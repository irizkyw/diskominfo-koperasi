"use strict";
var KTUsersUpdatePassword = (function () {
    const t = document.getElementById("kt_modal_update_password"),
        e = t.querySelector("#kt_modal_update_password_form"),
        n = new bootstrap.Modal(t);
    return {
        init: function () {
            (() => {
                var o = FormValidation.formValidation(e, {
                    fields: {
                        current_password: {
                            validators: {
                                notEmpty: {
                                    message: "Current password tidak boleh kosong",
                                },
                            },
                        },
                        new_password: {
                            validators: {
                                notEmpty: {
                                    message: "The password tidak boleh kosong",
                                },
                                callback: {
                                    message: "Please enter valid password",
                                    callback: function (t) {
                                        if (t.value.length > 0)
                                            return validatePassword();
                                    },
                                },
                            },
                        },
                        confirm_password: {
                            validators: {
                                notEmpty: {
                                    message:
                                        "The password confirmation tidak boleh kosong",
                                },
                                identical: {
                                    compare: function () {
                                        return e.querySelector(
                                            '[name="new_password"]'
                                        ).value;
                                    },
                                    message:
                                        "The password and its confirm are not the same",
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
                });
                t
                    .querySelector('[data-kt-users-modal-action="close"]')
                    .addEventListener("click", (t) => {
                        t.preventDefault(),
                            Swal.fire({
                                text: "Apakah Anda yakin ingin membatalkan?",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: "Ya, Batalkan!",
                                cancelButtonText: "Tidak",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                    cancelButton: "btn btn-active-light",
                                },
                            }).then(function (t) {
                                t.value
                                    ? (e.reset(), n.hide())
                                    : "cancel" === t.dismiss &&
                                      Swal.fire({
                                          text: "Your form has not been cancelled!.",
                                          icon: "error",
                                          buttonsStyling: !1,
                                          confirmButtonText: "OK mengerti!",
                                          customClass: {
                                              confirmButton: "btn btn-primary",
                                          },
                                      });
                            });
                    }),
                    t
                        .querySelector('[data-kt-users-modal-action="cancel"]')
                        .addEventListener("click", (t) => {
                            t.preventDefault(),
                                Swal.fire({
                                    text: "Apakah Anda yakin ingin membatalkan?",
                                    icon: "warning",
                                    showCancelButton: !0,
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ya, Batalkan!",
                                    cancelButtonText: "Tidak",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                        cancelButton: "btn btn-active-light",
                                    },
                                }).then(function (t) {
                                    t.value
                                        ? (e.reset(), n.hide())
                                        : "cancel" === t.dismiss &&
                                          Swal.fire({
                                              text: "Your form has not been cancelled!.",
                                              icon: "error",
                                              buttonsStyling: !1,
                                              confirmButtonText: "OK mengerti!",
                                              customClass: {
                                                  confirmButton:
                                                      "btn btn-primary",
                                              },
                                          });
                                });
                        });
                const a = t.querySelector(
                    '[data-kt-users-modal-action="submit"]'
                );
                a.addEventListener("click", function (t) {
                    t.preventDefault(),
                        o &&
                            o.validate().then(function (t) {
                                console.log("validated!"),
                                    "Valid" == t &&
                                        (a.setAttribute(
                                            "data-kt-indicator",
                                            "on"
                                        ),
                                        (a.disabled = !0),
                                        setTimeout(function () {
                                            a.removeAttribute(
                                                "data-kt-indicator"
                                            ),
                                                (a.disabled = !1),
                                                Swal.fire({
                                                    text: "Form has been successfully submitted!",
                                                    icon: "success",
                                                    buttonsStyling: !1,
                                                    confirmButtonText:
                                                        "OK mengerti!",
                                                    customClass: {
                                                        confirmButton:
                                                            "btn btn-primary",
                                                    },
                                                }).then(function (t) {
                                                    t.isConfirmed && n.hide();
                                                });
                                        }, 2e3));
                            });
                });
            })();
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdatePassword.init();
});
