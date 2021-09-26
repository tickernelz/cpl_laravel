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
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        columnDefs: [
            {type: 'natural', targets: '_all'},
            {width: 100, targets: ['_all']}
        ],
        fixedColumns: true
    });
});
