$(document).ready(() => {
    const table = $("#stock-opnames-table").DataTable();

    // Initialize the date range picker
    $("#date_range").daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: "Clear",
        },
    });

    // Set selected dates to the input and trigger table redraw
    $("#date_range").on("apply.daterangepicker", function (ev, picker) {
        $(this).val(
            picker.startDate.format("YYYY-MM-DD") +
                " to " +
                picker.endDate.format("YYYY-MM-DD")
        );
        table.draw();
    });

    // Clear the input when the cancel button is clicked
    $("#date_range").on("cancel.daterangepicker", function (ev, picker) {
        $(this).val("");
        table.draw();
    });

    // Add change event to filter fields
    $("#product_filter").on("change", function () {
        table.draw();
    });
});
