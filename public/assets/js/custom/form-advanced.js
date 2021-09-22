!function (t) {
    "use strict";

    function e() {
    }

    e.prototype.init = function () {
        t("input[name='bobot']").TouchSpin({
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        })
    }, t.AdvancedForm = new e, t.AdvancedForm.Constructor = e
}(window.jQuery), function () {
    "use strict";
    window.jQuery.AdvancedForm.init()
}();
