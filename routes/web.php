<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ExportCollege;

Route::get('/', function () {
    return redirect('/login');
});

// Staff
Route::get('/register', [RegistrationController::class, 'showForm'])->name('registration.form');
Route::post('/register', [RegistrationController::class, 'register'])->name('registration.register');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->middleware('guest')
    ->name('login');


Route::get('/registerAccount', function () {
    return view('registration');
});

// Student
Route::get('/studentRegistrationForm', function () {
    return view('student/studentRegistration');
});

Route::post('/store-student', [StudentController::class, 'store'])->name('store.student');


// Protected route for Add Student --- Only for staff

Route::get('/dashboard', function () {
    return view('staff.dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/studentID_dashboard', function () {
    return view('staff/index');
})->middleware('auth');


// For Adding Student - Staff
Route::get('/add-student', function () {
    return view('staff.addstudent');
})->middleware('auth')->name('add-student');
Route::post('/staff-store-student', [StaffController::class, 'store'])->middleware('auth')->name('staff.store.student');

// For Table Student - Staff
Route::get('/students-table', [StaffController::class, 'studentsTable'])->middleware('auth')->name('staff.students.tables');
Route::get('/students/archive/{id}', [StaffController::class, 'archive'])->middleware('auth')->name('students.archive');
Route::get('/search', [StaffController::class, 'search'])->middleware('auth')->name('students.search');
Route::get('/export-students', [StaffController::class, 'exportCsv'])->name('students.export');

// For Edit Student - Staff
Route::get('/student/{id}/image', [StudentController::class, 'getImage'])->middleware('auth')->name('student.image');
Route::get('/students/view/{idNum}', [StaffController::class, 'show'])->middleware('auth')->name('students.view');
Route::put('/students/update/{idNum}', [StaffController::class, 'update'])->middleware('auth')->name('students.update');

Route::get('/archives-table', [StaffController::class, 'archiveTable'])->middleware('auth')->name('staff.archives.table');
Route::post('/students/archive/{id}', [StaffController::class, 'archive'])->middleware('auth')->name('students.archive');
Route::post('/students/restore/{id}', [StaffController::class, 'restore'])->middleware('auth')->name('students.restore');
Route::delete('/students/delete/{idnumber}', [StaffController::class, 'delete'])->middleware('auth')->name('students.delete');

// routes/web.php
Route::get('/export-college-csv', [ExportCollege::class, 'exportCsv'])->name('export.csv');
Route::post('/students/archive-group', [StaffController::class, 'groupArchive'])->name('students.archive.group');
Route::post('/students/download', [StudentController::class, 'downloadFiles'])->name('students.download');

