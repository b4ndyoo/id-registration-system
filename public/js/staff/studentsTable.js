jQuery(document).ready(function ($) {
    let checkboxesVisible = false; // Track the state of the checkboxes visibility

    // Toggle checkboxes visibility
    $(document).on("click", "#toggleCheckboxes", function () {
        $("#cancelSelection").show();
        $("#continueArchive").show(); // Show Continue to Archive button
        const checkboxes = $(".checkbox-column");
        checkboxes.toggle(); // Toggle visibility of checkboxes
        checkboxesVisible = checkboxes.is(":visible"); // Update the visibility state
        $("#toggleCheckboxes").hide();
    });

    // Cancel button functionality
    $(document).on("click", "#cancelSelection", function () {
        $(".checkbox-column").hide(); // Hide checkboxes
        $("#toggleCheckboxes").text("Select to Archive");
        $("#continueArchive").hide(); // Hide Continue to Archive button
        $('input[name="student_ids[]"]').prop("checked", false); // Uncheck all checkboxes
        checkboxesVisible = false; // Update the state
        $("#cancelSelection").hide();
        $("#toggleCheckboxes").show();
    });

    // Real-time search functionality
    $("#advanced-search-input").on("keyup", function () {
        let value = $(this).val();

        $.ajax({
            type: "GET",
            url: "{{ URL::to('search') }}",
            data: {
                search: value,
            },
            success: function (data) {
                $("#datatable").html(data); // Load the new table data

                // Reapply checkbox visibility after search results are loaded
                if (checkboxesVisible) {
                    $(".checkbox-column").show(); // Show checkboxes if they were visible before
                }
            },
            error: function (xhr) {
                console.error(
                    "An error occurred: " + xhr.status + " " + xhr.statusText
                );
            },
        });
    });

    // Select/Deselect All checkboxes
    $(document).on("click", "#select-all", function () {
        let checked = $(this).prop("checked");
        $('input[name="student_ids[]"]').prop("checked", checked);
    });
});
