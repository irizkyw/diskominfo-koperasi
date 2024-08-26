var KTModalEventEdit = (function () {
    var t, e, o, n, r, i;
    return {
        init: function () {
            (i = new bootstrap.Modal(document.querySelector("#kt_modal_edit_event"))),
                (r = document.querySelector("#kt_modal_edit_event_form")),
                (t = r.querySelector("#kt_modal_edit_event_submit")),
                (e = r.querySelector("#kt_modal_edit_event_cancel")),
                (o = r.querySelector("#kt_modal_edit_event_close")),
                (n = FormValidation.formValidation(r, {
                    fields: {
                        nama_event: {
                            validators: {
                                notEmpty: {
                                    message: "Nama Event Diperlukan",
                                },
                            },
                        },
                        deskripsi_event: {
                            validators: {
                                notEmpty: {
                                    message: "Deskripsi Event Diperlukan",
                                },
                            },
                        },
                        tanggal_event: {
                            validators: {
                                notEmpty: {
                                    message: "Tanggal Event Diperlukan",
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
                t.addEventListener("click", function (e) {
                    e.preventDefault();
                    n && n.validate().then(function (e) {
                        console.log("validated!");
                        if ("Valid" == e) {
                            t.setAttribute("data-kt-indicator", "on");
                            t.disabled = !0;

                            var idField = $("#kt_modal_edit_event_form").find('[name="id"]');
                            idField.prop('disabled', false);

                            var id = idField.val();
                            var form = $("#kt_modal_edit_event_form");
                            var originalUrl = form.attr('data-original-action');
                            var url = originalUrl.replace(":id", id);
                            form.attr('action', url);
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
                                    }).then(function (e) {
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
                o.addEventListener("click", function (t) {
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
KTUtil.onDOMContentLoaded(function () {
    KTModalEventEdit.init();
});
