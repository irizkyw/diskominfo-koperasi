var KTModalCustomersEdit = (function () {
    var t, e, o, n, r, i;
    return {
      init: function () {
        (i = new bootstrap.Modal(document.querySelector("#kt_modal_edit_users"))),
          (r = document.querySelector("#kt_modal_edit_users_form")),
          (t = r.querySelector("#kt_modal_edit_users_submit")),
          (e = r.querySelector("#kt_modal_edit_users_cancel")),
          (o = r.querySelector("#kt_modal_edit_users_close")),
          (n = FormValidation.formValidation(r, {
            fields: {
              name: {
                validators: {
                  notEmpty: {
                    message: "Nama Anggota tidak boleh kosong",
                  },
                },
              },
              num_member: {
                validators: {
                  notEmpty: {
                    message: "Nomor Anggota tidak boleh kosong",
                  },
                },
              },
              username: {
                validators: {
                  notEmpty: {
                    message: "Username tidak boleh kosong",
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
          $(r.querySelector('[name="country"]')).on("change", function () {
            n.revalidateField("country");
          }),
          t.addEventListener("click", function (e) {
            e.preventDefault();
            n &&
              n.validate().then(function (e) {
                console.log("validated!");
                if ("Valid" == e) {
                  t.setAttribute("data-kt-indicator", "on");
                  t.disabled = !0;
  
                  id = $("#kt_modal_edit_users_form")
                    .find('[name="num_member"]')
                    .val();
                  url = $("#kt_modal_edit_users_form").attr("action");
                  $("#kt_modal_edit_users_form").attr("data-action", url);
                  $("#kt_modal_edit_users_form").attr(
                    "action",
                    url.replace(":id", id),
                  );
  
                  // Collect form data
                  var formData = new FormData(r);
  
                  fetch(r.action, {
                    method: "POST",
                    headers: {
                      "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    },
                    body: formData,
                  })
                    .then((response) => response.json())
                    .then((data) => {
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
                          $("#kt_modal_edit_users_form").attr(
                            "action",
                            $("#kt_modal_edit_users_form").data("action"),
                          );
                          datatable.ajax.reload();
                        }
                      });
                    })
                    .catch((error) => {
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
    KTModalCustomersEdit.init();
  });