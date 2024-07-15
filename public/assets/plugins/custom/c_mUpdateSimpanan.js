var KTModalSimpananEdit = (function () {
    var t, e, o, n, r, i;
    return {
        init: function () {
            (i = new bootstrap.Modal(document.querySelector("#kt_modal_edit_simpanan"))),
                (r = document.querySelector("#kt_modal_edit_simpanan_form")),
                (t = r.querySelector("#kt_modal_edit_simpanan_submit")),
                (e = r.querySelector("#kt_modal_edit_simpanan_cancel")),
                (o = r.querySelector("#kt_modal_edit_simpanan_close")),
                (n = FormValidation.formValidation(r, {
                        fields: {
                            user_id: {
                                validators: {
                                    notEmpty: {
                                        message: "Nama Anggota tidak boleh kosong",
                                    },
                                },
                            },
                            transaction_type: {
                                validators: {
                                    notEmpty: {
                                        message: "Tipe simpanan tidak boleh kosong",
                                    },
                                },
                            },
                            date_transaction: {
                                validators: {
                                    notEmpty: {
                                        message: "Bulan bayar tidak boleh kosong",
                                    },
                                },
                            },
                            nominal: {
                                validators: {
                                    notEmpty: {
                                        message: "Nominal tidak boleh kosong",
                                    },
                                },
                            },
                            desc: {
                                validators: {
                                    notEmpty: {
                                        message: "Deskripsi tidak boleh kosong",
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

                            var idField = $("#kt_modal_edit_simpanan_form").find('[name="id"]');
                            idField.prop('disabled', false);

                            var id = idField.val();
                            var form = $("#kt_modal_edit_simpanan_form");
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
    KTModalSimpananEdit.init();
});
