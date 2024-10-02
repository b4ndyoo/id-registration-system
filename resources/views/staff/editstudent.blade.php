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

        h3 {
            text-align: center !important;
            font-size: 50px !important;
            font-weight: 900;
            margin-top: -50px !important;
        }
    </style>
    @section('contentEditStudent')
    <div class="container-edit">
        <div class="row h-100">
            <div class="col-xl-12">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px">
                    <div class="card-body p-4 p-md-5">
                        <br>
                        <span class="edit d-flex justify-content-end" style="padding-right: 50px">
                            <a href="" id="edit-btn"><i class="fa-solid fa-pen-to-square"></i> Edit Student Details</a>
                        </span>
                        <br>
                        <h3 class="">Student Details</h3>
                        <br>
                        <form action="{{ route('students.update', $student->idnumber) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row" style="padding: 50px">

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
                                <div class="col-md-4" style="text-align: center;">
                                    <div class="row d-flex justify-content-center">
                                        <!-- ID Picture Section -->
                                        <div class="col-md-12 mb-3">
                                            <p><strong>ID Picture:</strong></p>
                                            <img src="{{ asset('public/images/idPictures/' . basename($student->idpicture)) }}" style="height: 150px; width: 150px; border: 2px #d1d1d1 solid; object-fit: cover;">
                                            <div class="mt-2">
                                                <!-- Download Button -->
                                                <a href="{{ asset('public/images/idPictures/' . basename($student->idpicture)) }}" download class="btn btn-success">
                                                    <i class="fa-solid fa-download"></i> Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <br><br>

                                    <!-- Signature Section -->
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-12 mb-3">
                                            <p><strong>Signature:</strong></p>
                                            <img src="{{ asset('public/images/signatures/' . basename($student->signature)) }}" style="height: 150px; width: 150px; border: 2px #d1d1d1 solid">
                                            <div class="mt-2">
                                                <!-- Download Button -->
                                                <a href="{{ asset('public/images/signatures/' . basename($student->signature)) }}" download class="btn btn-success">
                                                    <i class="fa-solid fa-download"></i> Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-4 mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="firstName" class="form-control form-control-lg"
                                                    name="firstName" placeholder="Juan" required value="{{ $student->firstname }}" disabled />
                                                <label class="form-label" for="firstName">First Name</label>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="middleInitial"
                                                    class="form-control form-control-lg" name="middleInitial"
                                                    placeholder="M." required value="{{ $student->middleinitial }}" disabled />
                                                <label class="form-label" for="middleInitial">Middle Initial</label>
                                            </div>

                                        </div>

                                        <div class="col-md-4 mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="lastName" class="form-control form-control-lg"
                                                    name="lastName" placeholder="Dela Cruz" required value="{{ $student->lastname }}" disabled />
                                                <label class="form-label" for="lastName">Last Name</label>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-4 d-flex align-items-center">
                                            <div data-mdb-input-init class="form-outline datepicker w-100">
                                                <input type="text" class="form-control form-control-lg" id="birthdayDate"
                                                    name="birthday" placeholder="January 01, 2001"
                                                    required value="{{ $student->birthday}}" disabled />
                                                <label for="birthday" class="form-label">Birthday <span
                                                        style="color: #999999; font-size: 12px;">(Format: January 01,
                                                        2001)</span> </label>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-4 pb-2">
                                            <div data-mdb-input-init class="form-outline">
                                                <input type="email" id="email" class="form-control form-control-lg"
                                                    name="email" placeholder="juan.delacruz@lorma.edu" required value="{{ $student->email }}" disabled />
                                                <label class="form-label" for="email">Lorma Mail</label>
                                                <div id="emailError" class="text-danger" style="display:none;">Email must
                                                    end with @lorma.edu</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4 pb-2">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="number" id="idNumber" class="form-control form-control-lg"
                                                    name="idNum" placeholder="5100538" required value="{{ $student->idnumber }}" disabled />
                                                <label class="form-label" for="idNumber">ID Number <span style="font-size: 9px;">This section is not editable</span><span style="color: red;">*</span></label>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6 mb-4 pb-2">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="courseYear" class="form-control form-control-lg"
                                                    name="courseYear" placeholder="BSCS - IV" required value="{{ $student->courseyear }}" disabled />
                                                <label class="form-label" for="courseYeaar">Course and Year</label>
                                            </div>

                                        </div>
                                        <div class="col-md-6 mb-4 pb-2">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="address" class="form-control form-control-lg"
                                                    name="address"
                                                    placeholder="Brgy. Canaoay, City of San Fernando, La Union" required value="{{ $student->address }}" disabled />
                                                <label class="form-label" for="address">Home Address</label>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6 mb-4 pb-2">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="contactperson"
                                                    class="form-control form-control-lg" name="contactPerson"
                                                    placeholder="Juan M. Dela Cruz" required value="{{ $student->contactperson }}" disabled />
                                                <label class="form-label" for="emailAddress">Contact Person Full
                                                    Name</label>
                                            </div>

                                        </div>
                                        <div class="col-md-6 mb-4 pb-2">

                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="contactNumber"
                                                    class="form-control form-control-lg" name="contactNumber"
                                                    placeholder="09211060400" required value="{{ $student->contactnumber }}" disabled />
                                                <label class="form-label" for="contactNumber">Contact Person's Contact
                                                    Number</label>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckChecked" required disabled>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            I agree to update the following infomartion of this student.
                                        </label>
                                    </div>

                                    <div class="mt-4 pt-2">
                                        <input id="submit" data-mdb-ripple-init class="btn btn-primary btn-lg" type="submit"
                                            value="Submit" disabled />
                                    </div>


                                </div> <!--row col-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @endsection

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // When the edit button is clicked
        $('#edit-btn').click(function(e) {
            e.preventDefault(); // Prevent the default link behavior

            // Enable all inputs except the one with id="idNumber"
            $('input').prop('disabled', false); // Enable all inputs
            $('#idNumber').prop('disabled', true); // Keep idNumber disabled

            // Enable the submit button
            $('#submit').prop('disabled', false);
        });

        // Handle form submission using AJAX
        $('form').on('submit', function() {
            // Gather form data
            var formData = new FormData(this);

            // Make the AJAX request
            $.ajax({
                url: $(this).attr('action'), // Use the form's action attribute as the URL
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Handle success (you can display a success message or reload the page, etc.)
                    alert('Student details updated successfully!');
                    console.log(response);
                },
                error: function(xhr) {
                    // Handle error (you can display an error message here)
                    alert('Error updating student details');
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>






</html>