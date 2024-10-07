@extends('layouts.layout')

@section('title', 'Dashboard')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="_token" content="{{ csrf_token() }}">
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
        thead,
        tbody,
        th,
        td {
            text-align: center !important;
            vertical-align: middle !important;
        }

        thead {
            background-color: #117554;
            color: white;
        }

        #filter-course {
            width: 300px;
        }

        .export-btn {
            display: flex;
            justify-content: end;
            margin-bottom: 20px;
        }

        .checkbox-column {
            display: none;
            /* Initially hide checkboxes */
        }

        .btn-container {
            display: flex;
            gap: 10px;
        }

        #cancelArchive {
            display: none
        }

        .table th,
        .table td {
            white-space: nowrap;
            /* Prevent text wrapping */
        }

        @media (max-width: 768px) {

            .table th,
            .table td {
                white-space: normal;
                /* Allow wrapping on smaller screens */
                font-size: 12px;
                /* Adjust font size */
            }

            .table img {
                height: 48px;
                /* Reduce image size on smaller screens */
                width: 48px;
            }
        }
    </style>

    @section('contentStudentsTable')
        <div class="container-table" style="position: relative; height: auto; overflow: hidden;">
            <!-- Set a fixed height -->
            <form id="archive-form" action="{{ route('students.archive.group') }}" method="POST">
                <div class="export-btn btn-container">
                    <div class="btn-group">
                        <a href="javascript:void(0);" class="btn" id="toggleCheckboxes"
                            style="background-color:#117554; color:white;">Select to Archive</a>

                        <!-- Form for archiving students -->
                        @csrf
                        <button type="submit" id="continueArchive" class="btn"
                            style="background-color:#117554; color:white; display:none;">Continue to Archive</button>
                        <a href="javascript:void(0);" class="btn export" id="cancelSelection"
                            style="background-color:#dc3545; color:white; display:none;"><i
                                class="fa-solid fa-xmark"></i></a>

                        <a href="{{ route('export.csv') }}" class="btn export"
                            style="background-color:#117554; color:white; margin-left:20px;">Export to CSV <i
                                class="fa-solid fa-file-export" style="margin-left: 3px;"></i></a>
                    </div>
                </div>

                <div class="input-group mb-4">
                    <input type="text" class="form-control" id="advanced-search-input"
                        placeholder="phrase in:column1,column2" style="border: 1px #999999 solid;" />
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary" id="advanced-search-button"
                        type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>

                <!-- Table with checkboxes inside the form -->
                <div style="overflow-y: auto; height: 70vh;"> <!-- Make the table scrollable -->
                    <table class="table table-bordered" style="width: 100%;">
                        <thead style="position: sticky; top:0;">
                            <tr>
                                <th class="checkbox-column">Select All <input type="checkbox" id="select-all"
                                        style="margin-left: 4px;"></th>
                                <th>Id Picture</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Initial</th>
                                <th>ID Number</th>
                                <th>Course and Year</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="datatable">
                            @foreach ($students as $student)
                                <tr>
                                    <td class="checkbox-column">
                                        <input type="checkbox" name="student_ids[]" value="{{ $student->idnumber }}">
                                    </td>
                                    <td>
                                        <img src="{{ url($student->idpicture) }}"
                                            style="height: 96px; width: 96px; object-fit: scale-down">
                                    </td>
                                    <td>{{ $student->lastname }}</td>
                                    <td>{{ $student->firstname }}</td>
                                    <td>{{ $student->middleinitial }}</td>
                                    <td>{{ $student->idnumber }}</td>
                                    <td>{{ $student->courseyear }}</td>
                                    <td>
                                        <a href="{{ route('students.view', $student->idnumber) }}"
                                            class="btn btn-info btn-sm">View</a>
                                        <form action="{{ route('students.archive', $student->idnumber) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to archive this student?');">Archive</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

    @endsection





    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script>
        const searchUrl = "{{ route('students.search') }}";
    </script>

    <script type="text/javascript" src="{{ asset('js/staff/studentsTable.js') }}"></script>



</html>
