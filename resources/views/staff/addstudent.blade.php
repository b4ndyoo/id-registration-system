@extends('layouts.layout')

@section('title', 'Dashboard')

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css\student\studentregistration.css') }}">
        <!-- fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

        <title>Document</title>
    </head>

    <body>
        <style>
            input {
                border: 1px #999999 solid !important;
            }
        </style>
        @section('contentAddStudent')
            <div class="container">
                <div class="row h-100">
                    <div class="col-xl-12">
                        <div class="card shadow-2-strong card-registration" style="border-radius: 15px">
                            <div class="card-body p-4 p-md-5">
                                <br><br>
                                <h3 class="">Student ID Registration Form</h3>
                                <p id="note"><span style="color: red; font-size: 15px;">*</span>Note: Please fill in
                                    the blanks with the correct information. Errors on the student's part are not the
                                    Library's responsibility. <span style="color: red; font-size: 15px;">*</span></p>
                                <br>
                                <form action="{{ route('staff.store.student') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-md-4 mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="firstName" class="form-control form-control-lg"
                                                    name="firstName" placeholder="Juan" required />
                                                <label class="form-label" for="firstName">First Name</label>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="middleInitial"
                                                    class="form-control form-control-lg" name="middleInitial"
                                                    placeholder="M." required />
                                                <label class="form-label" for="middleInitial">Middle Initial</label>
                                            </div>

                                        </div>

                                        <div class="col-md-4 mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="lastName" class="form-control form-control-lg"
                                                    name="lastName" placeholder="Dela Cruz" required />
                                                <label class="form-label" for="lastName">Last Name</label>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-4 d-flex align-items-center">
                                            <div data-mdb-input-init class="form-outline datepicker w-100">
                                                <input type="text" class="form-control form-control-lg" id="birthdayDate"
                                                    name="birthdate" placeholder="January 01, 2001" name="birthdate"
                                                    required />
                                                <label for="birthdayDate" class="form-label">Birthday <span
                                                        style="color: #999999; font-size: 12px;">(Format: January 01,
                                                        2001)</span> </label>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-4 pb-2">
                                            <div data-mdb-input-init class="form-outline">
                                                <input type="email" id="emailAddress" class="form-control form-control-lg"
                                                    name="email" placeholder="juan.delacruz@lorma.edu" required />
                                                <label class="form-label" for="emailAddress">Lorma Mail</label>
                                                <div id="emailError" class="text-danger" style="display:none;">Email must
                                                    end with @lorma.edu</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4 pb-2">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="number" id="idNumber" class="form-control form-control-lg"
                                                    name="idNum" placeholder="5100538" required />
                                                <label class="form-label" for="idNumber">ID Number</label>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6 mb-4 pb-2">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="courseYear" class="form-control form-control-lg"
                                                    name="courseYear" placeholder="BSCS - IV" required />
                                                <label class="form-label" for="courseYeaar">Course and Year</label>
                                            </div>

                                        </div>
                                        <div class="col-md-6 mb-4 pb-2">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="address" class="form-control form-control-lg"
                                                    name="address"
                                                    placeholder="Brgy. Canaoay, City of San Fernando, La Union" required />
                                                <label class="form-label" for="address">Home Address</label>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6 mb-4 pb-2">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="contactperson"
                                                    class="form-control form-control-lg" name="contactPerson"
                                                    placeholder="Juan M. Dela Cruz" required />
                                                <label class="form-label" for="emailAddress">Contact Person Full
                                                    Name</label>
                                            </div>

                                        </div>
                                        <div class="col-md-6 mb-4 pb-2">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="contactNumber"
                                                    class="form-control form-control-lg" name="contactNumber"
                                                    placeholder="09211060400" required />
                                                <label class="form-label" for="contactNumber">Contact Person's Contact
                                                    Number</label>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-4 pb-2">
                                            <div data-mdb-input-init class="form-outline">
                                                <label for="formFileLg" class="form-label">ID Picture</label>
                                                <input class="form-control form-control-md" id="idPicture" type="file"
                                                    name="idPicture" required />
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-4 pb-2">
                                            <div data-mdb-input-init class="form-outline">
                                                <label for="formFileLg" class="form-label">Digital Signature</label>
                                                <input class="form-control form-control-md" id="signature" type="file"
                                                    name="signature" required />
                                            </div>

                                        </div>

                                        <div class="col-md-4 mb-4 pb-2">
                                            <div data-mdb-input-init class="form-outline">
                                                <label for="formFileLg" class="form-label">Enrollment Receipt</label>
                                                <input class="form-control form-control-md" id="payment" type="file"
                                                    name="payment" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckChecked" required>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            I agree to share the following information to Lorma Colleges for academic
                                            puposes.
                                        </label>
                                    </div>

                                    <div class="mt-4 pt-2">
                                        <input data-mdb-ripple-init class="btn btn-primary btn-lg" type="submit"
                                            value="Submit" />
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection

    </body>

</html>
