"use strict";
var KTModalOfferADealFinance = (function () {
    var e, t, a, n, i;
    return {
        init: function () {
            (n = KTModalOfferADeal.getForm()),
                (i = KTModalOfferADeal.getStepperObj()),
                (e = KTModalOfferADeal.getStepper().querySelector(
                    '[data-kt-element="finance-next"]'
                )),
                (t = KTModalOfferADeal.getStepper().querySelector(
                    '[data-kt-element="finance-previous"]'
                )),
                (a = FormValidation.formValidation(n, {
                    fields: {
                        finance_setup: {
                            validators: {
                                notEmpty: { message: "Amount tidak boleh kosong" },
                                callback: {
                                    message:
                                        "The amount must be greater than $100",
                                    callback: function (e) {
                                        var t = e.value;
                                        if (
                                            ((t = t.replace(/[$,]+/g, "")),
                                            parseFloat(t) < 100)
                                        )
                                            return !1;
                                    },
                                },
                            },
                        },
                        finance_usage: {
                            validators: {
                                notEmpty: { message: "Usage type tidak boleh kosong" },
                            },
                        },
                        finance_allow: {
                            validators: {
                                notEmpty: {
                                    message: "Allowing budget tidak boleh kosong",
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
                })),
                KTDialer.getInstance(
                    n.querySelector("#kt_modal_finance_setup")
                ).on("kt.dialer.changed", function () {
                    a.revalidateField("finance_setup");
                }),
                e.addEventListener("click", function (t) {
                    t.preventDefault(),
                        (e.disabled = !0),
                        a &&
                            a.validate().then(function (t) {
                                console.log("validated!"),
                                    "Valid" == t
                                        ? (e.setAttribute(
                                              "data-kt-indicator",
                                              "on"
                                          ),
                                          setTimeout(function () {
                                              e.removeAttribute(
                                                  "data-kt-indicator"
                                              ),
                                                  (e.disabled = !1),
                                                  i.goNext();
                                          }, 1500))
                                        : ((e.disabled = !1),
                                          Swal.fire({
                                              text: "Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi.",
                                              icon: "error",
                                              buttonsStyling: !1,
                                              confirmButtonText: "OK mengerti!",
                                              customClass: {
                                                  confirmButton:
                                                      "btn btn-primary",
                                              },
                                          }));
                            });
                }),
                t.addEventListener("click", function () {
                    i.goPrevious();
                });
        },
    };
})();
"undefined" != typeof module &&
    void 0 !== module.exports &&
    (window.KTModalOfferADealFinance = module.exports =
        KTModalOfferADealFinance);
