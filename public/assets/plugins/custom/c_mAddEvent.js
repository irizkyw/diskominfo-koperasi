var KTModalEventAdd = (function() {
    var t, e, o, n, r, i;
    return {
        init: function() {
            i = new bootstrap.Modal(document.querySelector("#kt_modal_add_event"));
            r = document.querySelector("#kt_modal_add_event_form");
            t = r.querySelector("#kt_modal_add_event_submit");
            e = r.querySelector("#kt_modal_add_event_cancel");
            o = r.querySelector("#kt_modal_add_event_close");

            e.addEventListener("click", function(event) {
                event.preventDefault();
                console.log('Cancel button clicked');
                r.reset();
                i.hide();
            });

            o.addEventListener("click", function(event) {
                event.preventDefault();
                console.log('Close button clicked');
                r.reset();
                i.hide();
            });
        }
    };
})();

document.addEventListener("DOMContentLoaded", function() {
    KTModalEventAdd.init();
});
