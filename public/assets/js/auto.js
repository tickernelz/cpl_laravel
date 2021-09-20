$(document).ready(function () {
    $("#nim").autocomplete({

        source: function (request, response) {
            $.ajax({
                url: "/carimhs",
                data: {
                    term: request.term
                },
                dataType: "json",
                success: function (data) {
                    var resp = $.map(data, function (obj) {
                        return obj.nim;
                    });
                    response(resp);
                }
            });
        },
        minLength: 1
    });
});
