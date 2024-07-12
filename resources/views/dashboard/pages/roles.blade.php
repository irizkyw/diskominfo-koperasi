@extends('layouts.dashboard.master') @section('styles')
<link
  href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}"
  rel="stylesheet"
  type="text/css"
/>
@endsection @section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
  <!--begin::Content wrapper-->
  <div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-10 mb-3">
      <!--begin::Toolbar container-->
      <div
        id="kt_app_toolbar_container"
        class="app-container container-fluid d-flex align-items-stretch"
      >
        <!--begin::Toolbar wrapper-->
        <div
          class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100"
        >
          <!--begin::Page title-->
          <div
            class="page-title d-flex flex-column justify-content-center gap-1 me-3"
          >
            <!--begin::Title-->
            <h1
              class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0"
            >
              Anggota
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul
              class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0"
            >
              <!--begin::Item-->
              <li class="breadcrumb-item text-muted">
                <a href="index.html" class="text-muted text-hover-primary"
                  >Dashboard</a
                >
              </li>
              <!--end::Item-->
              <!--begin::Item-->
              <li class="breadcrumb-item">
                <span class="bullet bg-gray-500 w-5px h-2px"></span>
              </li>
              <li class="breadcrumb-item text-muted">Anggota</li>
            </ul>
            <!--end::Breadcrumb-->
          </div>
          <!--end::Page title-->
        </div>
        <!--end::Toolbar wrapper-->
      </div>
      <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
      <!--begin::Content container-->
      <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card">
          <!--begin::Card header-->
          <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
              <!--begin::Search-->
              <div class="d-flex align-items-center position-relative my-1">
                <i
                  class="ki-outline ki-magnifier fs-3 position-absolute ms-5"
                ></i>
                <input
                  type="text"
                  data-kt-customer-table-filter="search"
                  class="form-control form-control-solid w-250px ps-13"
                  placeholder="Cari Role"
                />
              </div>
              <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
              <!--begin::Toolbar-->
              <div
                class="d-flex justify-content-end"
                data-kt-customer-table-toolbar="base"
              >
                <!--begin::Add customer-->
                <button
                  type="button"
                  class="btn btn-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#kt_modal_add_role"
                >
                  Tambahkan Role
                </button>
                <!--end::Add customer-->
              </div>
              <!--end::Toolbar-->
              <!--begin::Group actions-->
              <div
                class="d-flex justify-content-end align-items-center d-none"
                data-kt-customer-table-toolbar="selected"
              >
                <div class="fw-bold me-5">
                  <span
                    class="me-2"
                    data-kt-customer-table-select="selected_count"
                  ></span
                  >Selected
                </div>
                <button
                  type="button"
                  class="btn btn-danger"
                  data-kt-customer-table-select="delete_selected"
                >
                  Delete Selected
                </button>
              </div>
              <!--end::Group actions-->
            </div>
            <!--end::Card toolbar-->
          </div>
          <!--end::Card header-->
          <!--begin::Card body-->
          <div class="card-body pt-0">
            <!--begin::Table-->
            <table
              class="table align-middle table-row-dashed fs-6 gy-5"
              id="table_anggota"
            >
              <thead>
                <tr
                  class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0"
                >
                  <th class="min-w-125px">ID Role</th>
                  <th class="min-w-125px">Nama Role</th>
                  <th class="min-w-125px">DESKRIPSI</th>
                  <th class="text-end min-w-70px">Actions</th>
                </tr>
              </thead>
              <tbody class="fw-semibold text-gray-600">
                @foreach($roles as $data)
                <tr>
                  <td>
                      {{$data->id}}
                  </td>
                  <td>
                      {{$data->name}}
                  </td>
                  <td>
                      {{$data->desc}}
                  </td>
                  <td class="text-end">
                    <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_role">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-pen"></i>
                        </span>
                    </a>
                    <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-kt-customer-table-filter="delete_row">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-trash"></i>
                        </span>
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <!--end::Table body-->
            </table>
            <!--end::Table-->
          </div>
          <!--end::Card body-->
        </div>
        <!--end::Card-->
        <!--begin::Modals-->
        <!--begin::Modal - Add-->
        <div
          class="modal fade"
          id="kt_modal_add_role"
          tabindex="-1"
          aria-hidden="true"
        >
          <!--begin::Modal dialog-->
          <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
              <!--begin::Form-->
              <form
                class="form"
                action="{{route('roles.create')}}"
                id="kt_modal_add_role_form"
                data-kt-redirect="{{route('roles.index')}}"
              >
              @csrf
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_role_header">
                  <!--begin::Modal title-->
                  <h2 class="fw-bold">Tambahkan Role</h2>
                  <!--end::Modal title-->
                  <!--begin::Close-->
                  <div
                    id="kt_modal_add_role_close"
                    class="btn btn-icon btn-sm btn-active-icon-primary"
                  >
                    <i class="ki-outline ki-cross fs-1"></i>
                  </div>
                  <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                  <!--begin::Scroll-->
                  <div
                    class="scroll-y me-n7 pe-7"
                    id="kt_modal_add_role_scroll"
                    data-kt-scroll="true"
                    data-kt-scroll-activate="{default: false, lg: true}"
                    data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#kt_modal_add_role_header"
                    data-kt-scroll-wrappers="#kt_modal_add_role_scroll"
                    data-kt-scroll-offset="300px"
                  >
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class="required fs-6 fw-semibold mb-2">Nama Role</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <input
                        type="text"
                        class="form-control form-control-solid"
                        placeholder="Nama Role"
                        name="name"
                      />
                      <!--end::Input-->
                    </div>
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class="fs-6 fw-semibold mb-2">Deskripsi</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <input
                        type="text"
                        class="form-control form-control-solid"
                        placeholder="Deskripsi Role"
                        name="desc"
                      />
                      <!--end::Input-->
                    </div>
                  </div>
                  <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                  <!--begin::Button-->
                  <button
                    type="reset"
                    id="kt_modal_add_role_cancel"
                    class="btn btn-light me-3"
                  >
                    Buang
                  </button>
                  <!--end::Button-->
                  <!--begin::Button-->
                  <button
                    type="submit"
                    id="kt_modal_add_role_submit"
                    class="btn btn-primary"
                  >
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress"
                      >Please wait...
                      <span
                        class="spinner-border spinner-border-sm align-middle ms-2"
                      ></span
                    ></span>
                  </button>
                  <!--end::Button-->
                </div>
                <!--end::Modal footer-->
              </form>
              <!--end::Form-->
            </div>
          </div>
        </div>
        <!--end::Modal - Add-->

        <!--begin::Modal - edit-->
        <div
          class="modal fade"
          id="kt_modal_edit_role"
          tabindex="-1"
          aria-hidden="true"
        >
          <!--begin::Modal dialog-->
          <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
              <!--begin::Form-->
              <form
                class="form"
                action="{{route('roles.create')}}"
                id="kt_modal_edit_role_form"
                data-kt-redirect="{{route('roles.index')}}"
              >
              @csrf
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_edit_role_header">
                  <!--begin::Modal title-->
                  <h2 class="fw-bold">Merubah Role</h2>
                  <!--end::Modal title-->
                  <!--begin::Close-->
                  <div
                    id="kt_modal_edit_role_close"
                    class="btn btn-icon btn-sm btn-active-icon-primary"
                  >
                    <i class="ki-outline ki-cross fs-1"></i>
                  </div>
                  <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                  <!--begin::Scroll-->
                  <div
                    class="scroll-y me-n7 pe-7"
                    id="kt_modal_edit_role_scroll"
                    data-kt-scroll="true"
                    data-kt-scroll-activate="{default: false, lg: true}"
                    data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#kt_modal_edit_role_header"
                    data-kt-scroll-wrappers="#kt_modal_edit_role_scroll"
                    data-kt-scroll-offset="300px"
                  >
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class="required fs-6 fw-semibold mb-2">Nama Role</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <input
                        type="text"
                        class="form-control form-control-solid"
                        name="id"
                      />
                      <input
                        type="text"
                        class="form-control form-control-solid"
                        placeholder="Nama Role"
                        name="name"
                      />
                      <!--end::Input-->
                    </div>
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class="fs-6 fw-semibold mb-2">Deskripsi</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <input
                        type="text"
                        class="form-control form-control-solid"
                        placeholder="Deskripsi Role"
                        name="desc"
                      />
                      <!--end::Input-->
                    </div>
                  </div>
                  <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                  <!--begin::Button-->
                  <button
                    type="reset"
                    id="kt_modal_edit_role_cancel"
                    class="btn btn-light me-3"
                  >
                    Buang
                  </button>
                  <!--end::Button-->
                  <!--begin::Button-->
                  <button
                    type="submit"
                    id="kt_modal_edit_role_submit"
                    class="btn btn-primary"
                  >
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress"
                      >Please wait...
                      <span
                        class="spinner-border spinner-border-sm align-middle ms-2"
                      ></span
                    ></span>
                  </button>
                  <!--end::Button-->
                </div>
                <!--end::Modal footer-->
              </form>
              <!--end::Form-->
            </div>
          </div>
        </div>
        <!-- end::modal edit -->
      </div>
      <!--end::Content container-->
    </div>
    <!--end::Content-->
  </div>
  <!--end::Content wrapper-->
</div>
@endsection 

@section('scripts')
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script>
  var KTModalRolesAdd = (function () {
      var t, e, o, n, r, i;
      return {
          init: function () {
              (i = new bootstrap.Modal(
                  document.querySelector("#kt_modal_add_role")
              )),
                  (r = document.querySelector("#kt_modal_add_role_form")),
                  (t = r.querySelector("#kt_modal_add_role_submit")),
                  (e = r.querySelector("#kt_modal_add_role_cancel")),
                  (o = r.querySelector("#kt_modal_add_role_close")),
                  (n = FormValidation.formValidation(r, {
                      fields: {
                          name: {
                              validators: {
                                  notEmpty: {
                                      message: "Nama Role tidak boleh kosong",
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
                  $(r.querySelector('[name="country"]')).on(
                      "change",
                      function () {
                          n.revalidateField("country");
                      }
                  ),
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
                                            $.ajax({
                                                url: "{{route('roles.create')}}",
                                                type: "POST",
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                data: $(r).serialize(),
                                                success: function (response) {
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
                                                                (t.disabled = !1),
                                                                (window.location =
                                                                    r.getAttribute(
                                                                        "data-kt-redirect"
                                                                    )));
                                                        });
                                                },
                                                error: function (xhr) {
                                                    t.removeAttribute(
                                                        "data-kt-indicator"
                                                    ),
                                                        Swal.fire({
                                                            text: "Sorry, looks like there are some errors detected, please try again.",
                                                            icon: "error",
                                                            buttonsStyling: !1,
                                                            confirmButtonText:
                                                                "OK mengerti!",
                                                            customClass: {
                                                                confirmButton:
                                                                    "btn btn-primary",
                                                            },
                                                        });
                                                },
                                            }))
                                          : Swal.fire({
                                                text: "Sorry, looks like there are some errors detected, please try again.",
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
      KTModalRolesAdd.init();
  });
</script>

<script>
  var KTModalRolesEdit = (function () {
      var t, e, o, n, r, i;
      return {
          init: function () {
              (i = new bootstrap.Modal(
                  document.querySelector("#kt_modal_edit_role")
              )),
                  (r = document.querySelector("#kt_modal_edit_role_form")),
                  (t = r.querySelector("#kt_modal_edit_role_submit")),
                  (e = r.querySelector("#kt_modal_edit_role_cancel")),
                  (o = r.querySelector("#kt_modal_edit_role_close")),
                  (n = FormValidation.formValidation(r, {
                      fields: {
                          name: {
                              validators: {
                                  notEmpty: {
                                      message: "Nama Role tidak boleh kosong",
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
                  $(r.querySelector('[name="country"]')).on(
                      "change",
                      function () {
                          n.revalidateField("country");
                      }
                  ),
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
                                            $.ajax({
                                                url: "{{route('roles.create')}}",
                                                type: "POST",
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                data: $(r).serialize(),
                                                success: function (response) {
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
                                                                (t.disabled = !1),
                                                                (window.location =
                                                                    r.getAttribute(
                                                                        "data-kt-redirect"
                                                                    )));
                                                        });
                                                },
                                                error: function (xhr) {
                                                    t.removeAttribute(
                                                        "data-kt-indicator"
                                                    ),
                                                        Swal.fire({
                                                            text: "Sorry, looks like there are some errors detected, please try again.",
                                                            icon: "error",
                                                            buttonsStyling: !1,
                                                            confirmButtonText:
                                                                "OK mengerti!",
                                                            customClass: {
                                                                confirmButton:
                                                                    "btn btn-primary",
                                                            },
                                                        });
                                                },
                                            }))
                                          : Swal.fire({
                                                text: "Sorry, looks like there are some errors detected, please try again.",
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
      KTModalRolesEdit.init();
  });
</script>

<script src="{{asset('assets/js/widgets.bundle.js')}}"></script>
<script src="{{asset('assets/js/custom/widgets.js')}}"></script>
<script src="{{asset('assets/js/custom/apps/chat/chat.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/create-campaign.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}"></script>

<script>
    var KTRolesList = (function () {
        var dataTableInstance,
            tableElement;

        var setupDeleteRowHandler = () => {
            tableElement.querySelectorAll('[data-kt-customer-table-filter="delete_row"]').forEach((deleteButton) => {
                deleteButton.addEventListener("click", function (event) {
                    event.preventDefault();
                    const rowElement = event.target.closest("tr"),
                          roleName = rowElement.querySelectorAll("td")[1].innerText;
                    Swal.fire({
                        text: "Are you sure you want to delete " + roleName + "?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-primary",
                        },
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                text: "You have deleted " + roleName + "!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "OK, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                },
                            }).then(function () {
                                dataTableInstance.row($(rowElement)).remove().draw();
                            });
                        } else if (result.dismiss === "cancel") {
                            Swal.fire({
                                text: roleName + " was not deleted.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "OK, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                },
                            });
                        }
                    });
                });
            });
        };

        var setupDeleteSelectedRowsHandler = () => {
            const checkboxes = tableElement.querySelectorAll('[type="checkbox"]'),
                  deleteSelectedButton = document.querySelector('[data-kt-customer-table-select="delete_selected"]');

            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener("click", function () {
                    setTimeout(updateSelectedToolbar, 50);
                });
            });

            deleteSelectedButton.addEventListener("click", function () {
                Swal.fire({
                    text: "Are you sure you want to delete selected customers?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary",
                    },
                }).then(function (result) {
                    if (result.value) {
                        Swal.fire({
                            text: "You have deleted all selected customers!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "OK, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            },
                        }).then(function () {
                            checkboxes.forEach((checkbox) => {
                                if (checkbox.checked) {
                                    dataTableInstance.row($(checkbox.closest("tbody tr"))).remove().draw();
                                }
                            });
                            tableElement.querySelectorAll('[type="checkbox"]')[0].checked = false;
                        });
                    } else if (result.dismiss === "cancel") {
                        Swal.fire({
                            text: "Selected customers were not deleted.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            },
                        });
                    }
                });
            });
        };

        var updateSelectedToolbar = () => {
            const baseToolbar = document.querySelector('[data-kt-customer-table-toolbar="base"]'),
                  selectedToolbar = document.querySelector('[data-kt-customer-table-toolbar="selected"]'),
                  selectedCount = document.querySelector('[data-kt-customer-table-select="selected_count"]'),
                  checkboxes = tableElement.querySelectorAll('tbody [type="checkbox"]');
            
            let anySelected = false, selectedCountValue = 0;
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    anySelected = true;
                    selectedCountValue++;
                }
            });

            if (anySelected) {
                selectedCount.innerHTML = selectedCountValue;
                baseToolbar.classList.add("d-none");
                selectedToolbar.classList.remove("d-none");
            } else {
                baseToolbar.classList.remove("d-none");
                selectedToolbar.classList.add("d-none");
            }
        };

        return {
            init: function () {
                tableElement = document.querySelector("#table_anggota");
                if (tableElement) {
                    dataTableInstance = $(tableElement).DataTable({
                        info: false,
                        order: [],
                        columnDefs: [
                            { orderable: false, targets: 0 },
                            { orderable: false, targets: 3 },
                        ],
                    }).on("draw", function () {
                        setupDeleteSelectedRowsHandler();
                        setupDeleteRowHandler();
                        updateSelectedToolbar();
                    });

                    setupDeleteSelectedRowsHandler();
                    document.querySelector('[data-kt-customer-table-filter="search"]').addEventListener("keyup", function (event) {
                        dataTableInstance.search(event.target.value).draw();
                    });
                    setupDeleteRowHandler();

                    // Status Filter
                    const statusFilter = document.querySelector('[data-kt-ecommerce-order-filter="status"]');
                    $(statusFilter).on("change", (event) => {
                        let statusValue = event.target.value;
                        if (statusValue === "all") {
                            statusValue = "";
                        }
                        dataTableInstance.column(3).search(statusValue).draw();
                    });
                }
            },
        };
    })();

    KTUtil.onDOMContentLoaded(function () {
        KTRolesList.init();
    });
</script>

@stop
