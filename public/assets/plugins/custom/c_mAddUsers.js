        var KTModalMemberAdd = (function() {
            var t, e, o, n, r, i;
            return {
                init: function() {
                    (i = new bootstrap.Modal(document.querySelector("#kt_modal_add_users"))),
                    (r = document.querySelector("#kt_modal_add_users_form")),
                    (t = r.querySelector("#kt_modal_add_users_submit")),
                    (e = r.querySelector("#kt_modal_add_users_cancel")),
                    (o = r.querySelector("#kt_modal_add_users_close")),
                    (n = FormValidation.formValidation(r, {
                        fields: {
                            name: {
                                validators: {
                                    notEmpty: {
                                        message: "Nama Anggota is required",
                                    },
                                },
                            },
                            num_member: {
                                validators: {
                                    notEmpty: {
                                        message: "Nomor Anggota is required",
                                    },
                                },
                            },
                            roles: {
                                validators: {
                                    notEmpty: {
                                        message: "Posisi Anggota is required",
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
                    $(r.querySelector('[name="country"]')).on("change", function() {
                            n.revalidateField("country");
                        }),
                        t.addEventListener("click", function(e) {
                            e.preventDefault();
                            n && n.validate().then(function(e) {
                                console.log("validated!");
                                if ("Valid" == e) {
                                    t.setAttribute("data-kt-indicator", "on");
                                    t.disabled = !0;

                                    // Enable num_member input
                                    document.getElementById('num_member').disabled = false;

                                    // Collect form data
                                    var formData = new FormData(r);

                                    fetch(r.action, {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector(
                                                    'meta[name="csrf-token"]').getAttribute(
                                                    'content')
                                            },
                                            body: formData
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            console.log(data);
                                            t.removeAttribute("data-kt-indicator");
                                            Swal.fire({
                                                text: data.message,
                                                icon: "success",
                                                buttonsStyling: !1,
                                                confirmButtonText: "OK mengerti!",
                                                customClass: {
                                                    confirmButton: "btn btn-primary",
                                                },
                                            }).then(function(e) {
                                                if (e.isConfirmed) {
                                                    r.reset();
                                                    i.hide();
                                                    t.disabled = !1;
                                                    datatable.ajax.reload()
                                                }

                                            });
                                        })
                                        .catch(error => {
                                            Swal.fire({
                                                text: "Sorry, looks like there are some errors detected, please try again.",
                                                icon: "error",
                                                buttonsStyling: !1,
                                                confirmButtonText: "OK mengerti!",
                                                customClass: {
                                                    confirmButton: "btn btn-primary",
                                                },
                                            });
                                            t.disabled = !1;
                                        });
                                } else {
                                    Swal.fire({
                                        text: "Sorry, looks like there are some errors detected, please try again.",
                                        icon: "error",
                                        buttonsStyling: !1,
                                        confirmButtonText: "OK mengerti!",
                                        customClass: {
                                            confirmButton: "btn btn-primary",
                                        },
                                    });
                                }
                            });
                        }),
                        e.addEventListener("click", function(t) {
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
                                }).then(function(t) {
                                    t.value ?
                                        (r.reset(), i.hide()) :
                                        "cancel" === t.dismiss &&
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
                        o.addEventListener("click", function(t) {
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
                                }).then(function(t) {
                                    t.value ?
                                        (r.reset(), i.hide()) :
                                        "cancel" === t.dismiss &&
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
        KTUtil.onDOMContentLoaded(function() {
            KTModalMemberAdd.init();
        });
