$(document).ready(function () {
    $('#datatable').DataTable({
        columnDefs: [
            {type: 'natural', targets: '_all'},
        ]
    });
    $('#datatable1').DataTable({
        columnDefs: [
            {type: 'natural', targets: '_all'},
        ]
    });
    $('#datatable2').DataTable({
        columnDefs: [
            {type: 'natural', targets: '_all'},
        ]
    });
    $('#datatableNilai').DataTable({
        scrollX: true,
        scrollCollapse: true,
        columnDefs: [
            {type: 'natural', targets: '_all'},
            {width: 100, targets: "teknik"},
            {width: 50, targets: 0},
            {width: 80, targets: [1, 2]},
        ]
    });
});
