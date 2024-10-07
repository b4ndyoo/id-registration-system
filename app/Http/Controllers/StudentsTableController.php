<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ArchiveStudent;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Exports\StudentsExport;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class StudentsTableController extends Controller
{
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
                ->orderBy('created_at', 'desc') // Sort by created_at in descending order
                ->get();

            if ($students->isNotEmpty()) {
                foreach ($students as $student) {
                    $output .= '
            <tr>
                 <td class="checkbox-column">
                        <input type="checkbox" name="student_ids[]" value="{{ $student->idnumber }}">
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


    public function view($id)
    {
        $student = Student::findOrFail($id);
        return view('students.view', compact('student'));
    }


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
            'firstname' => $student->firstname,
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


    public function groupArchive(Request $request)
    {
        $studentIds = $request->input('student_ids', []);

        if (empty($studentIds)) {
            return redirect()->back()->with('error', 'No students selected for archiving.');
        }

        // Fetch all students by the selected IDs
        $students = Student::whereIn('idnumber', $studentIds)->get();

        foreach ($students as $student) {
            ArchiveStudent::create([
                'firstname' => $student->firstname,
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

            // Delete the student from the original table
            $student->delete();
        }

        return redirect()->route('staff.students.tables')->with('success', 'Selected students archived successfully!');
    }

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

    public function downloadFiles(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'string|exists:registered_college_students,idnumber',
        ]);

        $zip = new ZipArchive();
        $date = now()->format('Y-m-d'); // Get current date
        $zipName = "{$date}-year.zip"; // Create zip file name
        $zipPath = public_path("downloads/{$zipName}"); // Set zip file path

        // Create a new zip file
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            return response()->json(['message' => 'Could not create zip file.'], 500);
        }

        foreach ($request->student_ids as $idnumber) {
            $student = DB::table('registered_college_students')->where('idnumber', $idnumber)->first();

            if ($student) {
                // Prepare file names
                $idPictureName = "{$student->idnumber}-year.{$student->idpicture_extension}"; // Get the file extension
                $signatureName = "{$student->idnumber}-sig.{$student->signature_extension}"; // Assuming you have this in your database

                // Add ID picture to zip
                $idPicturePath = public_path("images/idPictures/{$student->idpicture}");
                if (file_exists($idPicturePath)) {
                    $zip->addFile($idPicturePath, "idPictures/{$idPictureName}");
                }

                // Add signature to zip
                $signaturePath = public_path("images/signatures/{$student->signature}");
                if (file_exists($signaturePath)) {
                    $zip->addFile($signaturePath, "signatures/{$signatureName}");
                }
            }
        }

        $zip->close(); // Close zip file

        // Return the zip file as a download response
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
