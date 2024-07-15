"use strict";
var KTModalNewAddress = (function () {
    var t, e, n, o, i, r;
    return {
        init: function () {
            (r = document.querySelector("#kt_modal_new_address")) &&
                ((i = new bootstrap.Modal(r)),
                (o = document.querySelector("#kt_modal_new_address_form")),
                (t = document.getElementById("kt_modal_new_address_submit")),
                (e = document.getElementById("kt_modal_new_address_cancel")),
                $(o.querySelector('[name="country"]'))
                    .select2()
                    .on("change", function () {
                        n.revalidateField("country");
                    }),
                (n = FormValidation.formValidation(o, {
                    fields: {
                        "first-name": {
                            validators: {
                                notEmpty: { message: "First name tidak boleh kosong" },
                            },
                        },
                        "last-name": {
                            validators: {
                                notEmpty: { message: "Last name tidak boleh kosong" },
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
                        address2: {
                            validators: {
                                notEmpty: { message: "Address 2 tidak boleh kosong" },
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
                t.addEventListener("click", function (e) {
                    e.preventDefault(),
                        n &&
                            n.validate().then(function (e) {
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
                                                  (t.disabled = !1),
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
                                                      t.isConfirmed && i.hide();
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
                                ? (o.reset(), i.hide())
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
                }));
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTModalNewAddress.init();
});
