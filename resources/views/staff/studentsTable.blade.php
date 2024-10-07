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
        <div class="export-btn btn-container">
            <div class="btn-group">
                <!-- Archive Buttons -->
                <a href="javascript:void(0);" class="btn" id="toggleArchive" style="background-color:#117554; color:white;">Select to Archive</a>
                <button type="submit" form="archive-form" id="continueArchive" class="btn" style="background-color:#117554; color:white; display:none; margin-left:10px;">Continue to Archive</button>
                <a href="javascript:void(0);" class="btn export" id="cancelArchive" style="background-color:#dc3545; color:white; display:none;"><i class="fa-solid fa-xmark"></i></a>

                <!-- Download Buttons -->
                <a href="javascript:void(0);" class="btn" id="toggleDownload" style="background-color:#117554; color:white;">Select to Download</a>
                <button type="button" id="continueDownload" class="btn" style="background-color:#117554; color:white; display:none;">Continue to Download</button>
                <a href="javascript:void(0);" class="btn" id="cancelDownload" style="background-color:#dc3545; color:white; display:none;">Cancel</a>

                <a href="{{ route('export.csv') }}" class="btn export" style="background-color:#117554; color:white; margin-left:10px;">Export to CSV <i class="fa-solid fa-file-export" style="margin-left: 3px;"></i></a>
            </div>
        </div>

        <!-- Archive Form -->
        <form id="archive-form" action="{{ route('students.archive.group') }}" method="POST" style="display: inline;">
            @csrf
            <!-- Table for both archiving and downloading -->
            <div style="overflow-y: auto; height: 75vh; overflow-x: auto;">
                <table class="table table-bordered" style="width: 100%; table-layout: auto;">
                    <thead style="position: sticky; top: 0; z-index: 1;">
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
                                <input type="checkbox" name="student_ids[]" value="{{ $student->idnumber }}" style="display: none;"> <!-- Initially hidden -->
                            </td>
                            <td>
                                <img src="{{ url($student->idpicture) }}" style="height: 96px; width: 96px; object-fit: scale-down;">
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
        </form>

        <!-- Download Form -->
        <form id="download-form" action="{{ route('students.download') }}" method="POST" style="display: inline;">
            @csrf
            <input type="hidden" name="student_ids" id="downloadStudentIds">
        </form>
    </div>




    @endsection





    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            let checkboxesVisible = false; // Track the state of the checkboxes visibility

            // Toggle checkboxes visibility
            $(document).on('click', '#toggleArchive', function() {
                $('#cancelArchive').show();
                $('#continueArchive').show(); // Show Continue to Archive button
                const checkboxes = $('.checkbox-column');
                checkboxes.toggle(); // Toggle visibility of checkboxes
                checkboxesVisible = checkboxes.is(':visible'); // Update the visibility state
                $('#toggleArchive').hide();
            });


            // Cancel button functionality
            $(document).on('click', '#cancelArchive', function() {
                $('.checkbox-column').hide(); // Hide checkboxes
                $('#toggleArchive').text('Select to Archive');
                $('#continueArchive').hide(); // Hide Continue to Archive button
                $('input[name="student_ids[]"]').prop('checked', false); // Uncheck all checkboxes
                checkboxesVisible = false; // Update the state
                $('#cancelArchive').hide();
                $('#toggleArchive').show();
            });

            $(document).on('click', '#toggleDownload', function() {
                $('#cancelDownload').show();
                $('#continueDownload').show(); // Show Continue to Archive button
                const checkboxes = $('.checkbox-column');
                checkboxes.toggle(); // Toggle visibility of checkboxes
                checkboxesVisible = checkboxes.is(':visible'); // Update the visibility state
                $('#toggleDownload').hide();
            });


            // Cancel button functionality
            $(document).on('click', '#cancelDownload', function() {
                $('.checkbox-column').hide(); // Hide checkboxes
                $('#toggleDownload').text('Select to Download');
                $('#continueDownload').hide(); // Hide Continue to Archive button
                $('input[name="student_ids[]"]').prop('checked', false); // Uncheck all checkboxes
                checkboxesVisible = false; // Update the state
                $('#cancelDownload').hide();
                $('#toggleDownload').show();
            });
            s

            // Real-time search functionality
            $('#advanced-search-input').on('keyup', function() {
                let value = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "{{ URL::to('search') }}",
                    data: {
                        search: value
                    },
                    success: function(data) {
                        $('#datatable').html(data); // Load the new table data

                        // Reapply checkbox visibility after search results are loaded
                        if (checkboxesVisible) {
                            $('.checkbox-column').show(); // Show checkboxes if they were visible before
                        }
                    },
                    error: function(xhr) {
                        console.error("An error occurred: " + xhr.status + " " + xhr.statusText);
                    }
                });
            });

            // Select/Deselect All checkboxes
            $(document).on('click', '#select-all', function() {
                const checked = $(this).prop('checked');
                $('#archive-form input[name="student_ids[]"]').prop('checked', checked); // Select/Deselect all checkboxes
            });

        });

        $(document).on('submit', '#archive-form', function(e) {
            let checkedBoxes = $('input[name="student_ids[]"]:checked').map(function() {
                return $(this).val();
            }).get();
            console.log('Checked boxes:', checkedBoxes);
        });


        $(document).ready(function() {
            let checkboxesVisible = false; // Track the visibility of checkboxes

            // Toggle Archive Checkboxes
            $(document).on('click', '#toggleArchive', function() {
                const checkboxes = $('#archive-form .checkbox-column input[type="checkbox"]');
                checkboxes.toggle(); // Toggle visibility of checkboxes
                checkboxesVisible = checkboxes.is(':visible'); // Update the visibility state
                $('#toggleArchive').hide();
                $('#cancelArchive').show();
                $('#continueArchive').show(); // Show Continue to Archive button
            });

            // Cancel button functionality for archive
            $(document).on('click', '#cancelArchive', function() {
                $('#archive-form .checkbox-column input[type="checkbox"]').hide(); // Hide checkboxes
                $('#toggleArchive').show(); // Show select to archive button
                $('#continueArchive').hide(); // Hide Continue to Archive button
                $('input[name="student_ids[]"]').prop('checked', false); // Uncheck all checkboxes
                checkboxesVisible = false; // Update the state
                $('#cancelArchive').hide(); // Hide cancel button
            });

            // Toggle Download Checkboxes
            $(document).on('click', '#toggleDownload', function() {
                $('#cancelDownload').show();
                $('#continueDownload').show(); // Show Continue to Download button
                const checkboxes = $('#archive-form .checkbox-column input[type="checkbox"]');
                checkboxes.toggle(); // Toggle visibility of checkboxes
                checkboxesVisible = checkboxes.is(':visible'); // Update the visibility state
                $('#toggleDownload').hide();
            });

            // Cancel button functionality for download
            $(document).on('click', '#cancelDownload', function() {
                $('#archive-form .checkbox-column input[type="checkbox"]').hide(); // Hide checkboxes
                $('#toggleDownload').text('Select to Download');
                $('#continueDownload').hide(); // Hide Continue to Download button
                $('input[name="student_ids[]"]').prop('checked', false); // Uncheck all checkboxes
                checkboxesVisible = false; // Update the state
                $('#cancelDownload').hide(); // Hide cancel button
                $('#toggleDownload').show(); // Show select to download button
            });

            // Continue to download functionality
            $(document).on('click', '#continueDownload', function() {
                // Collect selected student IDs for download
                const selectedIds = [];
                $('input[name="student_ids[]"]:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length === 0) {
                    alert("Please select at least one student to download.");
                    return;
                }

                // Set the IDs in the hidden input of the download form
                $('#downloadStudentIds').val(selectedIds.join(','));

                // Submit the download form
                $('#download-form').submit();
            });
        });
    </script>



</html>