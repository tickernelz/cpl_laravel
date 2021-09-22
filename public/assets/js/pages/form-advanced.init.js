!function (t) {
    "use strict";

    function e() {
    }

    e.prototype.init = function () {
        t(".select2").select2(), t(".select2-limiting").select2({maximumSelectionLength: 2}), t("#colorpicker-default").spectrum(), t("#colorpicker-showalpha").spectrum({showAlpha: !0}), t("#colorpicker-showpaletteonly").spectrum({
            showPaletteOnly: !0,
            showPalette: !0,
            color: "#34c38f",
            palette: [["#556ee6", "white", "#34c38f", "rgb(255, 128, 0);", "#50a5f1"], ["red", "yellow", "green", "blue", "violet"]]
        }), t("#colorpicker-togglepaletteonly").spectrum({
            showPaletteOnly: !0,
            togglePaletteOnly: !0,
            togglePaletteMoreText: "more",
            togglePaletteLessText: "less",
            color: "#556ee6",
            palette: [["#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff"], ["#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f"], ["#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#cfe2f3", "#d9d2e9", "#ead1dc"], ["#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#9fc5e8", "#b4a7d6", "#d5a6bd"], ["#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6fa8dc", "#8e7cc3", "#c27ba0"], ["#c00", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3d85c6", "#674ea7", "#a64d79"], ["#900", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#0b5394", "#351c75", "#741b47"], ["#600", "#783f04", "#7f6000", "#274e13", "#0c343d", "#073763", "#20124d", "#4c1130"]]
        }), t("#colorpicker-showintial").spectrum({showInitial: !0}), t("#colorpicker-showinput-intial").spectrum({
            showInitial: !0,
            showInput: !0
        }), t("#datepicker").datepicker(), t("#datepicker-inline").datepicker(), t("#datepicker-multiple").datepicker({
            numberOfMonths: 3,
            showButtonPanel: !0
        }), t("#datepicker").datepicker(), t("#datepicker-autoclose").datepicker({
            autoclose: !0,
            todayHighlight: !0
        }), t("#datepicker-multiple-date").datepicker({
            format: "mm/dd/yyyy",
            clearBtn: !0,
            multidate: !0,
            multidateSeparator: ","
        }), t("#date-range").datepicker({toggleActive: !0});
        t(".vertical-spin").TouchSpin({
            verticalbuttons: !0,
            verticalupclass: "ion-plus-round",
            verticaldownclass: "ion-minus-round",
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        }), t("input[name='demo1']").TouchSpin({
            min: 0,
            max: 100,
            step: .1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: "%",
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        }), t("input[name='demo2']").TouchSpin({
            min: -1e9,
            max: 1e9,
            stepinterval: 50,
            maxboostedstep: 1e7,
            prefix: "$",
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        }), t("input[name='demo3']").TouchSpin({
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        }), t("input[name='demo3_21']").TouchSpin({
            initval: 40,
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        }), t("input[name='demo3_22']").TouchSpin({
            initval: 40,
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        }), t("input[name='demo5']").TouchSpin({
            prefix: "pre",
            postfix: "post",
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        }), t("input[name='demo0']").TouchSpin({
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        }), t("input#defaultconfig").maxlength({
            warningClass: "badge bg-info",
            limitReachedClass: "badge bg-warning"
        }), t("input#thresholdconfig").maxlength({
            threshold: 20,
            warningClass: "badge bg-info",
            limitReachedClass: "badge bg-warning"
        }), t("input#moreoptions").maxlength({
            alwaysShow: !0,
            warningClass: "badge bg-success",
            limitReachedClass: "badge bg-danger"
        }), t("input#alloptions").maxlength({
            alwaysShow: !0,
            warningClass: "badge bg-success",
            limitReachedClass: "badge bg-danger",
            separator: " out of ",
            preText: "You typed ",
            postText: " chars available.",
            validate: !0
        }), t("textarea#textarea").maxlength({
            alwaysShow: !0,
            warningClass: "badge bg-info",
            limitReachedClass: "badge bg-warning"
        }), t("input#placement").maxlength({
            alwaysShow: !0,
            placement: "top-left",
            warningClass: "badge bg-info",
            limitReachedClass: "badge bg-warning"
        })
    }, t.AdvancedForm = new e, t.AdvancedForm.Constructor = e
}(window.jQuery), function () {
    "use strict";
    window.jQuery.AdvancedForm.init()
}();
