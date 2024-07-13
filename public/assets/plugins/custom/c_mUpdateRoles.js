        var KTModalRolesEdit = (function() {
            var t, e, o, n, r, i;
            return {
                init: function() {
                    (i = new bootstrap.Modal(document.querySelector("#kt_modal_edit_roles"))),
                    (r = document.querySelector("#kt_modal_edit_roles_form")),
                    (t = r.querySelector("#kt_modal_edit_roles_submit")),
                    (e = r.querySelector("#kt_modal_edit_roles_cancel")),
                    (o = r.querySelector("#kt_modal_edit_roles_close")),
                    (n = FormValidation.formValidation(r, {
                        fields: {
                            name: {
                                validators: {
                                    notEmpty: {
                                        message: "Nama Anggota is required",
                                    },
                                },
                            },
                            desc: {
                                validators: {
                                    notEmpty: {
                                        message: "Deskripsi is required",
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
                        t.addEventListener("click", function(e) {
                            e.preventDefault();
                            n && n.validate().then(function(e) {
                                console.log("validated!");
                                if ("Valid" == e) {
                                    t.setAttribute("data-kt-indicator", "on");
                                    t.disabled = !0;

                                    id = $("#kt_modal_edit_roles_form").find('[name="id"]')
                                        .val()
                                    url = $("#kt_modal_edit_roles_form").attr('action')
                                    $("#kt_modal_edit_roles_form").attr('action', url.replace(":id",
                                        id))

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
                                                text: "Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi.",
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
                                        text: "Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi.",
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
            KTModalRolesEdit.init();
        });
