var KTModalTransaksiEdit = (function() {
    var modal, form, submitBtn, cancelBtn, closeBtn;

    return {
        init: function() {
            modal = new bootstrap.Modal(document.querySelector("#kt_modal_edit_transaksi"));
            form = document.querySelector("#kt_modal_edit_transaksi_form");
            submitBtn = form.querySelector("#kt_modal_edit_transaksi_submit");
            cancelBtn = form.querySelector("#kt_modal_edit_transaksi_cancel");
            closeBtn = form.querySelector("#kt_modal_edit_transaksi_close");

            var validator = FormValidation.formValidation(form, {
                fields: {
                    user_id: {
                        validators: {
                            notEmpty: {
                                message: "User ID is required",
                            },
                        },
                    },
                    transaction_type: {
                        validators: {
                            notEmpty: {
                                message: "Transaction Type is required",
                            },
                        },
                    },
                    description: {
                        validators: {
                            notEmpty: {
                                message: "Description is required",
                            },
                        },
                    },
                    date_transaction: {
                        validators: {
                            notEmpty: {
                                message: "Transaction Date is required",
                            },
                        },
                    },
                    nominal: {
                        validators: {
                            notEmpty: {
                                message: "Nominal is required",
                            },
                            numeric: {
                                message: "Nominal must be a number",
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

            submitBtn.addEventListener("click", function(event) {
                event.preventDefault();
                validator.validate().then(function(status) {
                    if (status === "Valid") {
                        submitBtn.setAttribute("data-kt-indicator", "on");
                        submitBtn.disabled = true;

                        var id = form.querySelector('[name="id"]').value;
                    var url = form.getAttribute('action').replace(":id", id);

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    })

                        .then(response => response.json())
                        .then(data => {
                            submitBtn.removeAttribute("data-kt-indicator");
                            Swal.fire({
                                text: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "OK mengerti!",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                },
                            }).then(function(result) {
                                if (result.isConfirmed) {
                                    form.reset();
                                    modal.hide();
                                    submitBtn.disabled = false;
                                    // Assuming you have a function to reload data
                                    // e.g., datatable.ajax.reload();
                                }
                            });
                        })
                        .catch(error => {
                            Swal.fire({
                                text: "Maaf, terjadi kesalahan. Silakan coba lagi.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "OK mengerti!",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                },
                            });
                            submitBtn.disabled = false;
                        });
                    } else {
                        Swal.fire({
                            text: "Maaf, ada kesalahan dalam formulir. Silakan periksa kembali.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK mengerti!",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });
                    }
                });
            });

            cancelBtn.addEventListener("click", function(event) {
                event.preventDefault();
                Swal.fire({
                    text: "Apakah Anda yakin ingin membatalkan?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Ya, Batalkan!",
                    cancelButtonText: "Tidak",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light",
                    },
                }).then(function(result) {
                    if (result.isConfirmed) {
                        form.reset();
                        modal.hide();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            text: "Formulir tidak dibatalkan.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK mengerti!",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });
                    }
                });
            });

            closeBtn.addEventListener("click", function(event) {
                event.preventDefault();
                Swal.fire({
                    text: "Apakah Anda yakin ingin membatalkan?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Ya, Batalkan!",
                    cancelButtonText: "Tidak",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light",
                    },
                }).then(function(result) {
                    if (result.isConfirmed) {
                        form.reset();
                        modal.hide();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            text: "Formulir tidak dibatalkan.",
                            icon: "error",
                            buttonsStyling: false,
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

KTUtil.onDOMContentLoaded(function() {
    KTModalTransaksiEdit.init();
});
