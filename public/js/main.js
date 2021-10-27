$(document).ready(function() {
    $('#reservation').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
    });

    $('#data-table').DataTable({
        'paging'      : false,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : true,
        'info'        : false,
        'autoWidth'   : false,
        "order": []
    });
});