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

}
