"use strict";
var KTModalAddAddress = (function () {
    var t, e, n, o, r, i;
    return {
        init: function () {
            (i = new bootstrap.Modal(
                document.querySelector("#kt_modal_add_address")
            )),
                (r = document.querySelector("#kt_modal_add_address_form")),
                (t = r.querySelector("#kt_modal_add_address_submit")),
                (e = r.querySelector("#kt_modal_add_address_cancel")),
                (n = r.querySelector("#kt_modal_add_address_close")),
                (o = FormValidation.formValidation(r, {
                    fields: {
                        name: {
                            validators: {
                                notEmpty: {
                                    message: "Address name tidak boleh kosong",
                                },
                            },
                        },
                        country: {
                            validators: {
                                notEmpty: { message: "Country tidak boleh kosong" },
                            },
                        },
                        address1: {
                            validators: {
                                notEmpty: { message: "Address 1 tidak boleh kosong" },
                            },
                        },
                        city: {
                            validators: {
                                notEmpty: { message: "City tidak boleh kosong" },
                            },
                        },
                        state: {
                            validators: {
                                notEmpty: { message: "State tidak boleh kosong" },
                            },
                        },
                        postcode: {
                            validators: {
                                notEmpty: { message: "Postcode tidak boleh kosong" },
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
                })),
                $(r.querySelector('[name="country"]')).on(
                    "change",
                    function () {
                        o.revalidateField("country");
                    }
                ),
                t.addEventListener("click", function (e) {
                    e.preventDefault(),
                        o &&
                            o.validate().then(function (e) {
                                console.log("validated!"),
                                    "Valid" == e
                                        ? (t.setAttribute(
                                              "data-kt-indicator",
                                              "on"
                                          ),
                                          (t.disabled = !0),
                                          setTimeout(function () {
                                              t.removeAttribute(
                                                  "data-kt-indicator"
                                              ),
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
                                                  }).then(function (e) {
                                                      e.isConfirmed &&
                                                          (i.hide(),
                                                          (t.disabled = !1));
                                                  });
                                          }, 2e3))
                                        : Swal.fire({
                                              text: "Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi.",
                                              icon: "error",
                                              buttonsStyling: !1,
                                              confirmButtonText: "OK mengerti!",
                                              customClass: {
                                                  confirmButton:
                                                      "btn btn-primary",
                                              },
                                          });
                            });
                }),
                e.addEventListener("click", function (t) {
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
                                ? (r.reset(), i.hide())
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
                n.addEventListener("click", function (t) {
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
                                ? (r.reset(), i.hide())
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
                });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTModalAddAddress.init();
});
