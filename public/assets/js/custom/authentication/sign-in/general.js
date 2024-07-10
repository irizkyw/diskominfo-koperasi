"use strict";

var KTSigninGeneral = (function () {
    var t, e, r;
    return {
        init: function () {
            (t = document.querySelector("#kt_sign_in_form")),
                (e = document.querySelector("#kt_sign_in_submit")),
                (r = FormValidation.formValidation(t, {
                    fields: {
                        username: {
                            validators: {
                                notEmpty: {
                                    message: "Username is required",
                                },
                            },
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: "Password is required",
                                },
                            },
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: "",
                        }),
                    },
                }));

            e.addEventListener("click", function (i) {
                i.preventDefault();
                r.validate().then(function (r) {
                    if (r === "Valid") {
                        e.setAttribute("data-kt-indicator", "on");
                        e.disabled = !0;

                        axios
                            .post(t.getAttribute("action"), new FormData(t))
                            .then(function (response) {
                                e.removeAttribute("data-kt-indicator");
                                e.disabled = !1;

                                Swal.fire({
                                    text: response.data.message,
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "OK mengerti!",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                }).then(function (result) {
                                    if (result.isConfirmed) {
                                        window.location.href =
                                            response.data.redirect;
                                    }
                                });
                            })
                            .catch(function (error) {
                                e.removeAttribute("data-kt-indicator");
                                e.disabled = !1;

                                Swal.fire({
                                    text:
                                        error.response.data.error ||
                                        "An error occurred, please try again.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "OK mengerti!",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                });
                            });
                    } else {
                        Swal.fire({
                            text: "Maaf, sepertinya ada beberapa kesalahan yang anda inputkan, silakan coba lagi.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "OK mengerti!",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });
                    }
                });
            });
        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTSigninGeneral.init();
});
