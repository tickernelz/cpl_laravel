$(document).ready(function () {
    $('#datatable').DataTable({
        "columnDefs": [
            {type: 'natural', targets: '_all'}
        ]
    });
    $('#datatable1').DataTable({
        "columnDefs": [
            {type: 'natural', targets: '_all'}
        ]
    });
    $('#datatable2').DataTable({
        "columnDefs": [
            {type: 'natural', targets: '_all'}
        ]
    });
});
