@extends('layouts.layout')

@section('title', 'Dashboard')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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
    </style>

    @section('contentArchivesTable')
    <div class="container-table">
        <div class="input-group mb-4">
            <input type="text" class="form-control" id="advanced-search-input" placeholder="phrase in:column1,column2" style="border: 1px #999999 solid;" />
            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary" id="advanced-search-button" type="button">
                <i class="fa fa-search"></i>
            </button>
        </div>

        <table class="table table-bordered" style="width: 100%;">
            <thead>
                <tr>
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
                    <td>
                        <img src="{{ url($student->idpicture) }}" style="height: 96px; width: 96px;">

                    </td>
                    <td>{{ $student->lastname }}</td>
                    <td>{{ $student->firstname }}</td>
                    <td>{{ $student->middleinitial }}</td>
                    <td>{{ $student->idnumber }}</td>
                    <td>{{ $student->courseyear }}</td>
                    <td>
                        <form action="{{ route('students.restore', $student->idnumber) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-info btn-sm" onclick="return confirm('Are you sure you want to restore this student?');">Restore</button>
                        </form>
                        <form action="{{ route('students.delete', $student->idnumber) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to delete this student?');">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection

</body>
<!-- Add this script to the bottom of your Blade view -->
<script>
    document.getElementById('advanced-search-button').addEventListener('click', function() {
        var input = document.getElementById('advanced-search-input').value.toLowerCase();
        var rows = document.querySelectorAll('#datatable tr');

        rows.forEach(function(row) {
            var columns = row.getElementsByTagName('td');
            var match = false;

            for (var i = 0; i < columns.length; i++) {
                if (columns[i].innerText.toLowerCase().includes(input)) {
                    match = true;
                    break;
                }
            }

            row.style.display = match ? '' : 'none';
        });
    });
</script>

</html>