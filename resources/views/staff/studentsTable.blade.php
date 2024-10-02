@extends('layouts.layout')

@section('title', 'Dashboard')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{asset('css\student\studentregistration.css')}}">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

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

        #canselSelection {
            display: none
        }
    </style>

    @section('contentStudentsTable')



    <div class="container-table">
        <div class="export-btn btn-container">
            <div class="btn-group">
                <a href="javascript:void(0);" class="btn" id="toggleCheckboxes" style="background-color:#117554; color:white;">Select to Archive</a>
                <a href="javascript:void(0);" class="btn export" id="canselSelection" style="background-color:#dc3545; color:white;"><i class="fa-solid fa-xmark"></i></a>
            </div>
            <a href="{{ route('export.csv') }}" class="btn export" style="background-color:#117554; color:white">Export to CSV <i class="fa-solid fa-file-export" style="margin-left: 3px;"> </i></a>
        </div>

        <div class="input-group mb-4">
            <input type="text" class="form-control" id="advanced-search-input" placeholder="phrase in:column1,column2" style="border: 1px #999999 solid;" />
            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary" id="advanced-search-button" type="button">
                <i class="fa fa-search"></i>
            </button>
        </div>

        <table class="table table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th class="checkbox-column">Select All <input type="checkbox" id="select-all" style="margin-left: 4px;"></th>
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
                @foreach($students as $student)
                <tr>
                    <td class="checkbox-column">
                        <input type="checkbox" name="student_ids[]" value="{{ $student->idnumber }}">
                    </td>
                    <td>
                        <img src="{{ url($student->idpicture) }}" style="height: 96px; width: 96px; object-fit: scale-down">
                    </td>
                    <td>{{ $student->lastname }}</td>
                    <td>{{ $student->firstname }}</td>
                    <td>{{ $student->middleinitial }}</td>
                    <td>{{ $student->idnumber }}</td>
                    <td>{{ $student->courseyear }}</td>
                    <td>
                        <a href="{{ route('students.view', $student->idnumber) }}" class="btn btn-info btn-sm">View</a>
                        <form action="{{ route('students.archive', $student->idnumber) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to archive this student?');">Archive</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection



</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#toggleCheckboxes').click(function() {

            const checkboxes = $('.checkbox-column');
            checkboxes.toggle();
            $(this).text(function(i, text) {
                return text === "Continue Archive" ? "Select to Archive" : "Continue Archive";
            });
        });


        // Cancel button functionality
        $('#cancelSelection').click(function() {
            $('.checkbox-column').hide();
            $('#toggleCheckboxes').text('Select to Archive');
            $('input[name="student_ids[]"]').prop('checked', false);
        });


        $('#advanced-search-input').on('keyup', function() {
            let value = $(this).val();
            console.log(value); // For debugging, you can remove this later

            $.ajax({
                type: 'GET',
                url: "{{ URL::to('search') }}",
                data: {
                    search: value
                },
                success: function(data) {
                    $('#datatable').html(data);
                },
                error: function(xhr) {
                    console.error("An error occurred: " + xhr.status + " " + xhr.statusText);
                }
            });
        });

        $('#select-all').click(function() {
            $('#cancelSelection').css('display', 'block');
            let checked = $(this).prop('checked');
            $('input[name="student_ids[]"]').prop('checked', checked);
        });
    });

    document.getElementById('toggleCheckboxes').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.checkbox-column');
        checkboxes.forEach(checkbox => {
            checkbox.style.display = checkbox.style.display === 'none' ? '' : 'none';
        });
    });
</script>



</html>