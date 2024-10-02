<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ArchiveStudent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Exports\StudentsExport;
use Illuminate\Http\Response;

class StaffController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'firstName' => 'required|string|max:25',
            'middleInitial' => 'required|string|max:25',
            'lastName' => 'required|string|max:25',
            'birthdate' => 'required|string|max:25',
            'email' => 'required|email|max:50',
            'idNum' => 'required|integer',
            'courseYear' => 'required|string|max:25',
            'address' => 'required|string|max:25',
            'contactPerson' => 'required|string|max:25',
            'contactNumber' => 'required|string',
            'idPicture' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'signature' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'payment' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if (!preg_match('/@lorma\.edu$/', $request->email)) {
            return redirect()->back()->withErrors(['email' => 'The email must end with @lorma.edu.']);
        }

        $currentYear = date('Y'); // Get the current year

        // Check if the student with the same idNum exists in the current year
        $existingStudent = Student::where('idnumber', $request->idNum)
            ->whereYear('created_at', $currentYear)
            ->first();

        if ($existingStudent) {
            // If a match is found, return an error message
            return redirect()->back()->withErrors(['idNum' => 'ID number for this year is already added. Please contact the library if you still with to add.']);
        }

        // Store the ID Picture
        if ($request->file('idPicture')) {
            $idPictureFile = $request->file('idPicture');
            $idPictureFilename = $request->idNum . '-' . $currentYear . '-id' . '.' . $idPictureFile->getClientOriginalExtension(); // idNum-year.extension
            $idPictureFile->move(public_path('public/images/idPictures'), $idPictureFilename);
            $idPicturePath = 'public/images/idPictures/' . $idPictureFilename;
        }

        // Store the Signature
        if ($request->file('signature')) {
            $signatureFile = $request->file('signature');
            $signatureFilename = $request->idNum . '-' . $currentYear . '-sign' . '.' . $signatureFile->getClientOriginalExtension(); // idNum-year.extension
            $signatureFile->move(public_path('public/images/signatures'), $signatureFilename);
            $signaturePath = 'public/images/signatures/' . $signatureFilename;
        }

        // Store the Payment (optional)
        if ($request->hasFile('payment')) {
            $paymentFile = $request->file('payment');
            $paymentFilename = $request->idNum . '-' . $currentYear . '-payment' . '.' . $paymentFile->getClientOriginalExtension(); // idNum-year.extension
            $paymentFile->move(public_path('public/images/payments'), $paymentFilename);
            $paymentPath = 'public/images/payments/' . $paymentFilename;
        } else {
            $paymentPath = null;
        }

        // Store data in the database
        $student = Student::create([
            'firstname' => $request->firstName,
            'middleinitial' => $request->middleInitial,
            'lastname' => $request->lastName,
            'birthday' => $request->birthdate,
            'email' => $request->email,
            'idnumber' => $request->idNum,
            'courseyear' => $request->courseYear,
            'address' => $request->address,
            'contactperson' => $request->contactPerson,
            'contactnumber' => $request->contactNumber,
            'idpicture' => $idPicturePath,
            'signature' => $signaturePath,
            'payment' => $paymentPath,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Student information registered successfully! ID Number: ' . $student->idnumber);
    }




    public function studentsTable()
    {
        // Fetch all students and order by time of upload (created_at)
        $students = Student::orderBy('created_at', 'desc')->get();
        return view('staff.studentsTable', compact('students'));
    }


    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $students = DB::table('registered_college_students')
                ->where('lastname', 'LIKE', "%{$request->search}%")
                ->orWhere('firstname', 'LIKE', "%{$request->search}%")
                ->orWhere('idnumber', 'LIKE', "%{$request->search}%")
                ->orWhere('courseyear', 'LIKE', "%{$request->search}%")
                ->get();

            if ($students->isNotEmpty()) {
                foreach ($students as $student) {
                    $output .= '
            <tr>
                <td class="checkbox-column">
                    Helllooo
                </td>
                <td><img src="' . url($student->idpicture) . '" style="height: 96px; width: 96px; object-fit: scale-down"></td>
                <td>' . $student->lastname . '</td>
                <td>' . $student->firstname . '</td>
                <td>' . $student->middleinitial . '</td>
                <td>' . $student->idnumber . '</td>
                <td>' . $student->courseyear . '</td>
                <td>
                    <a href="' . route('students.view', $student->idnumber) . '" class="btn btn-info btn-sm">View</a>
                    <form action="' . route('students.archive', $student->idnumber) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to archive this student?\');">Archive</button>
                    </form>
                </td>
            </tr>';
                }
                return response($output);
            } else {
                return response('<tr><td colspan="8">No results found</td></tr>'); // Updated colspan to 8
            }
        }
    }







    // app/Http/Controllers/StudentController.php

    public function view($id)
    {
        $student = Student::findOrFail($id);
        return view('students.view', compact('student'));
    }

    // app/Http/Controllers/StudentController.php

    public function getImage()
    {
        $imageData = Student::all();
        return view('Image.view_image', compact('imageData'));
    }

    public function editStudent()
    {
        return view('staff.editstudent');
    }

    public function show($idNum)
    {
        // Fetch the student based on the idnumber
        $student = Student::where('idnumber', $idNum)->firstOrFail();
        return view('staff.editstudent', compact('student'));
    }

    public function update(Request $request, $idNum)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'firstName' => 'required|string|max:25',
            'middleInitial' => 'nullable|string|max:25',
            'lastName' => 'required|string|max:25',
            'birthday' => 'required|string|max:25',
            'email' => 'required|email|max:50|regex:/^[a-z0-9._%+-]+@lorma\.edu$/i',
            'courseYear' => 'required|string|max:50',
            'address' => 'required|string|max:50',
            'contactPerson' => 'required|string|max:50',
            'contactNumber' => 'required|string|max:50',
        ], [
            'email.email' => 'Please enter a valid email address.',
            'email.regex' => 'Email must end with @lorma.edu.',
        ]);

        try {
            // Fetch the student
            $student = Student::where('idnumber', $idNum)->firstOrFail();

            // Update basic student details
            $student->firstname = $request->firstName;
            $student->middleinitial = $request->middleInitial;
            $student->lastname = $request->lastName;
            $student->birthday = $request->birthday;
            $student->email = $request->email;
            $student->courseyear = $request->courseYear;
            $student->address = $request->address;
            $student->contactperson = $request->contactPerson;
            $student->contactnumber = $request->contactNumber;

            // Save changes
            $student->save();

            // Return success response
            return redirect()->back()->with('success', 'Student details updated successfully!');
        } catch (\Exception $e) {
            // Log the error for debugging purposes (optional)
            // \Log::error('Error updating student: ' . $e->getMessage());

            // Return back with an error message
            return redirect()->back()->with('error', 'An error occurred while updating the student. Please try again or contact support.');
        }
    }


    public function archive($idNum)
    {
        // Fetch the student to be archived using ID Number
        $student = Student::where('idnumber', $idNum)->firstOrFail();

        // Create a new ArchiveStudent entry with the student's current data
        ArchiveStudent::create([
            'firstname' => $student->firstname, // Correct field names
            'middleinitial' => $student->middleinitial,
            'lastname' => $student->lastname,
            'idnumber' => $student->idnumber,
            'email' => $student->email,
            'courseyear' => $student->courseyear,
            'birthday' => $student->birthday,
            'address' => $student->address,
            'contactperson' => $student->contactperson,
            'contactnumber' => $student->contactnumber,
            'idpicture' => $student->idpicture,
            'signature' => $student->signature,
            'payment' => $student->payment,
        ]);

        // Delete the student from the students table
        $student->delete();

        // Redirect back with a success message
        return redirect()->route('staff.students.tables')->with('success', 'Student archived successfully!');
    }



    public function archiveTable()
    {
        // Fetch all students and order by time of upload (created_at)
        $students = ArchiveStudent::orderBy('created_at', 'desc')->get();
        return view('staff.archive', compact('students'));
    }

    public function restore($idNum)
    {
        // Fetch the student to be archived using ID Number
        $student = ArchiveStudent::where('idnumber', $idNum)->firstOrFail();

        // Create a new ArchiveStudent entry with the student's current data
        Student::create([
            'firstname' => $student->firstname, // Correct field names
            'middleinitial' => $student->middleinitial,
            'lastname' => $student->lastname,
            'idnumber' => $student->idnumber,
            'email' => $student->email,
            'courseyear' => $student->courseyear,
            'birthday' => $student->birthday,
            'address' => $student->address,
            'contactperson' => $student->contactperson,
            'contactnumber' => $student->contactnumber,
            'idpicture' => $student->idpicture,
            'signature' => $student->signature,
            'payment' => $student->payment,
        ]);

        // Delete the student from the students table
        $student->delete();

        // Redirect back with a success message
        return redirect()->route('staff.archives.table')->with('success', 'Student restored successfully!');
    }


    public function delete($idnumber)
    {
        // Find the archived student by idnumber
        $archivedStudent = ArchiveStudent::where('idnumber', $idnumber)->firstOrFail();

        // Paths to delete (only if they exist)
        $idPicturePath = public_path($archivedStudent->idpicture);
        $signaturePath = public_path($archivedStudent->signature);
        $paymentPath = public_path($archivedStudent->payment);

        // Delete the ID picture if it exists
        if (File::exists($idPicturePath)) {
            File::delete($idPicturePath);
        }

        // Delete the signature if it exists
        if (File::exists($signaturePath)) {
            File::delete($signaturePath);
        }

        // Delete the payment file if it exists
        if ($archivedStudent->payment && File::exists($paymentPath)) {
            File::delete($paymentPath);
        }

        // Delete the archived student record from the database
        $archivedStudent->delete();

        // Redirect back with a success message
        return redirect()->route('staff.students.tables')->with('success', 'Archived student and associated files deleted successfully!');
    }

    // In your controller
    public function exportCsv()
    {
        $filename = 'students.csv';
        $handle = fopen('php://output', 'w');

        // Output CSV headers
        fputcsv($handle, ['ID', 'Picture', 'Last Name', 'First Name', 'Middle Initial', 'ID Number', 'Course and Year']);

        // Fetch and output data
        $students = Student::all();
        foreach ($students as $student) {
            fputcsv($handle, [
                $student->id,
                $student->picture,
                $student->last_name,
                $student->first_name,
                $student->middle_initial,
                $student->id_number,
                $student->course_and_year,
            ]);
        }

        fclose($handle);

        return response()->stream(
            function () use ($handle) {
                fclose($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
}
