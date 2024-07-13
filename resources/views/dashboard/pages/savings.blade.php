@extends('layouts.dashboard.master') @section('styles')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    @endsection @section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar pt-10 mb-3">
                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
                    <!--begin::Toolbar wrapper-->
                    <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                            <!--begin::Title-->
                            <h1
                                class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                                Data Simpanan Anjay
                            </h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-muted">
                                    <a href="index.html" class="text-muted text-hover-primary">Dashboard</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                                </li>
                                <li class="breadcrumb-item text-muted">Data Simpanan</li>
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
                                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                                    <input type="text" data-kt-customer-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari Data" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                    <!--begin::Filter-->
                                    <div class="w-150px me-3">
                                        <!--begin::Select2-->
                                        <select class="form-select form-select-solid" data-control="select2"
                                            data-hide-search="true" data-placeholder="Simpanan"
                                            data-kt-ecommerce-order-filter="Simpanan">
                                            <option></option>
                                            <option value="all">Semua</option>
                                            <option value="active">Aktif</option>
                                            <option value="locked">Tidak Aktif</option>
                                        </select>
                                        <!--end::Select2-->
                                    </div>
                                    <!--end::Filter-->
                                    <!--begin::Export-->
                                    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                                        data-bs-target="#export_modal">
                                        <i class="ki-outline ki-exit-up fs-2"></i>Export
                                    </button>
                                    <!--end::Export-->
                                    <!--begin::Add customer-->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_customer">
                                        Tambahkan Data
                                    </button>
                                    <!--end::Add customer-->
                                </div>
                                <!--end::Toolbar-->
                                <!--begin::Group actions-->
                                <div class="d-flex justify-content-end align-items-center d-none"
                                    data-kt-customer-table-toolbar="selected">
                                    <div class="fw-bold me-5">
                                        <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected
                                    </div>
                                    <button type="button" class="btn btn-danger"
                                        data-kt-customer-table-select="delete_selected">
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
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="table_simpanan">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                    data-kt-check-target="#table_simpanan .form-check-input"
                                                    value="1" />
                                            </div>
                                        </th>
                                        <th class="min-w-125px">Nama Aggota</th>
                                        <th class="min-w-125px">Jenis Simpanan</th>
                                        <th class="min-w-125px">Nominal</th>
                                        <th class="min-w-125px">Deskripsi</th>
                                        <th class="min-w-125px">Tanggal Transaksi</th>
                                        <th class="text-end min-w-70px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1" />
                                            </div>
                                        </td>
                                        <td>
                                            <a href="apps/ecommerce/customers/details.html"
                                                class="text-gray-800 text-hover-primary mb-1">Emma Smith</a>
                                        </td>
                                        <td>
                                            <a href="#"
                                                class="text-gray-600 text-hover-primary mb-1">smith@kpmg.com</a>
                                        </td>
                                        <td>
                                            <!--begin::Badges-->
                                            <div class="badge badge-light-success">Active</div>
                                            <!--end::Badges-->
                                        </td>
                                        <td>25 Jul 2024, 5:20 pm</td>
                                        <td>25 Jul 2024, 5:20 pm</td>
                                        <td class="text-end">
                                            <a href="#"
                                                class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions <i
                                                    class="ki-outline ki-down fs-5 ms-1"></i></a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="apps/customers/view.html" class="menu-link px-3">Profile</a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3"
                                                        data-kt-customer-table-filter="edit_row">Edit</a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3"
                                                        data-kt-customer-table-filter="delete_row">Delete</a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->
                                        </td>
                                    </tr>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--begin::Modals-->
                    <!--begin::Modal - Customers - Add-->
                    <div class="modal fade" id="kt_modal_add_customer" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Form-->
                                <form class="form" action="#" id="kt_modal_add_customer_form"
                                    data-kt-redirect="apps/customers/list.html">
                                    <!--begin::Modal header-->
                                    <div class="modal-header" id="kt_modal_add_customer_header">
                                        <!--begin::Modal title-->
                                        <h2 class="fw-bold">Tambahkan Data</h2>
                                        <!--end::Modal title-->
                                        <!--begin::Close-->
                                        <div id="kt_modal_add_customer_close"
                                            class="btn btn-icon btn-sm btn-active-icon-primary">
                                            <i class="ki-outline ki-cross fs-1"></i>
                                        </div>
                                        <!--end::Close-->
                                    </div>
                                    <!--end::Modal header-->
                                    <!--begin::Modal body-->
                                    <div class="modal-body py-10 px-lg-17">
                                        <!--begin::Scroll-->
                                        <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll"
                                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_add_customer_header"
                                            data-kt-scroll-wrappers="#kt_modal_add_customer_scroll"
                                            data-kt-scroll-offset="300px">
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">Nomor simpanan</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Biaya yang harus dibayar setiap bulannya">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                    </span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="roles" aria-label="Select a Role" data-control="select2"
                                                    data-placeholder="Pilih simpanan"
                                                    data-dropdown-parent="#kt_modal_add_customer"
                                                    class="form-select form-select-solid fw-bold">
                                                    <option value="">Pilih Golongan</option>
                                                    <option value="1">Golongan I</option>
                                                    <option value="2">Golongan II</option>
                                                    <option value="3">Golongan III</option>
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!-- endL::input group -->

                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">Tipe Simpanan</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Biaya yang harus dibayar setiap bulannya">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                    </span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="roles" aria-label="Select a Role" data-control="select2"
                                                    data-placeholder="Pilih Tipe Simpanan"
                                                    data-dropdown-parent="#kt_modal_add_customer"
                                                    class="form-select form-select-solid fw-bold">
                                                    <option value="">Pilih Golongan</option>
                                                    <option value="1">Golongan I</option>
                                                    <option value="2">Golongan II</option>
                                                    <option value="3">Golongan III</option>
                                                </select>
                                            </div>

                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fs-6 fw-semibold mb-2">Nominal</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" class="form-control form-control-solid"
                                                    placeholder="Nominal Simpanan" name="name" />
                                                <!--end::Input-->
                                            </div>

                                            <div class="fv-row mb-7">
                                                <label class="fs-6 fw-semibold mb-2">Deskripsi</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Deskripsi (Opsional)" name="name" />
                                                <!--end::Input-->
                                            </div>


                                        </div>
                                        <!--end::Scroll-->
                                    </div>
                                    <!--end::Modal body-->
                                    <!--begin::Modal footer-->
                                    <div class="modal-footer flex-center">
                                        <!--begin::Button-->
                                        <button type="reset" id="kt_modal_add_customer_cancel"
                                            class="btn btn-light me-3">
                                            Buang
                                        </button>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                        <!--end::Button-->
                                    </div>
                                    <!--end::Modal footer-->
                                </form>
                                <!--end::Form-->
                            </div>
                        </div>
                    </div>
                    <!--end::Modal - Customers - Add-->
                    <!--begin::Modal - Adjust Balance-->
                    <div class="modal fade" id="export_modal" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bold">Export simpanan</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div id="kt_customers_export_close"
                                        class="btn btn-icon btn-sm btn-active-icon-primary">
                                        <i class="ki-outline ki-cross fs-1"></i>
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--end::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                    <!--begin::Form-->
                                    <form id="kt_customers_export_form" class="form" action="#">

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <!--begin::Label-->
                                            <label class="fs-5 fw-semibold form-label mb-5">Pilih Format Ekspor:</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select data-control="select2" data-placeholder="Select a format"
                                                data-hide-search="true" name="format"
                                                class="form-select form-select-solid">
                                                <option value="excell">Excel</option>
                                                <option value="pdf">PDF</option>
                                                <option value="cvs">CVS</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <!--begin::Label-->
                                            <label class="fs-5 fw-semibold form-label mb-5">Pilih Filter Ekspor:</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select data-control="select2" data-placeholder="Select a format"
                                                data-hide-search="true" name="format"
                                                class="form-select form-select-solid">
                                                <option value="all">Semua</option>
                                                <option value="active">Simpanan Wajib</option>
                                                <option value="locked">Simpanan Pokok</option>
                                                <option value="locked">Simpanan Sukarela</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="text-center">
                                            <button type="reset" id="kt_customers_export_cancel"
                                                class="btn btn-light me-3">
                                                Buang
                                            </button>
                                            <button type="submit" id="kt_customers_export_submit"
                                                class="btn btn-primary">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Modal body-->
                            </div>
                            <!--end::Modal content-->
                        </div>
                        <!--end::Modal dialog-->
                    </div>
                    <!--end::Modal - New Card-->
                    <!--end::Modals-->
                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->
        <!--begin::Footer-->
        <div id="kt_app_footer" class="app-footer">
            <!--begin::Footer container-->
            <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                <!--begin::Copyright-->
                <div class="text-gray-900 order-2 order-md-1">
                    <span class="text-muted fw-semibold me-1">2024&copy;</span>
                    <a href="https://keenthemes.com" target="_blank"
                        class="text-gray-800 text-hover-primary">Keenthemes</a>
                </div>
                <!--end::Copyright-->
                <!--begin::Menu-->
                <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                    <li class="menu-item">
                        <a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
                    </li>
                    <li class="menu-item">
                        <a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
                    </li>
                    <li class="menu-item">
                        <a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
                    </li>
                </ul>
                <!--end::Menu-->
            </div>
            <!--end::Footer container-->
        </div>
        <!--end::Footer-->
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/ecommerce/customers/listing/add.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/ecommerce/customers/listing/export.js') }}"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/create-campaign.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <script>
        var KTCustomersList = (function() {
            var t,
                e,
                o = () => {
                    e.querySelectorAll(
                        '[data-kt-customer-table-filter="delete_row"]'
                    ).forEach((e) => {
                        e.addEventListener("click", function(e) {
                            e.preventDefault();
                            const o = e.target.closest("tr"),
                                n = o.querySelectorAll("td")[1].innerText;
                            Swal.fire({
                                text: "Are you sure you want to delete " + n + "?",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: "Yes, delete!",
                                cancelButtonText: "No, cancel",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-danger",
                                    cancelButton: "btn fw-bold btn-active-light-primary",
                                },
                            }).then(function(e) {
                                e.value ?
                                    Swal.fire({
                                        text: "You have deleted " + n + "!.",
                                        icon: "success",
                                        buttonsStyling: !1,
                                        confirmButtonText: "OK mengerti!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        },
                                    }).then(function() {
                                        t.row($(o)).remove().draw();
                                    }) :
                                    "cancel" === e.dismiss &&
                                    Swal.fire({
                                        text: n + " was not deleted.",
                                        icon: "error",
                                        buttonsStyling: !1,
                                        confirmButtonText: "OK mengerti!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        },
                                    });
                            });
                        });
                    });
                },
                n = () => {
                    const o = e.querySelectorAll('[type="checkbox"]'),
                        n = document.querySelector(
                            '[data-kt-customer-table-select="delete_selected"]'
                        );
                    o.forEach((t) => {
                            t.addEventListener("click", function() {
                                setTimeout(function() {
                                    c();
                                }, 50);
                            });
                        }),
                        n.addEventListener("click", function() {
                            Swal.fire({
                                text: "Are you sure you want to delete selected customers?",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: "Yes, delete!",
                                cancelButtonText: "No, cancel",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-danger",
                                    cancelButton: "btn fw-bold btn-active-light-primary",
                                },
                            }).then(function(n) {
                                n.value ?
                                    Swal.fire({
                                        text: "You have deleted all selected customers!.",
                                        icon: "success",
                                        buttonsStyling: !1,
                                        confirmButtonText: "OK mengerti!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        },
                                    }).then(function() {
                                        o.forEach((e) => {
                                            e.checked &&
                                                t
                                                .row($(e.closest("tbody tr")))
                                                .remove()
                                                .draw();
                                        });
                                        e.querySelectorAll(
                                            '[type="checkbox"]'
                                        )[0].checked = !1;
                                    }) :
                                    "cancel" === n.dismiss &&
                                    Swal.fire({
                                        text: "Selected customers was not deleted.",
                                        icon: "error",
                                        buttonsStyling: !1,
                                        confirmButtonText: "OK mengerti!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        },
                                    });
                            });
                        });
                };
            const c = () => {
                const t = document.querySelector(
                        '[data-kt-customer-table-toolbar="base"]'
                    ),
                    o = document.querySelector(
                        '[data-kt-customer-table-toolbar="selected"]'
                    ),
                    n = document.querySelector(
                        '[data-kt-customer-table-select="selected_count"]'
                    ),
                    c = e.querySelectorAll('tbody [type="checkbox"]');
                let r = !1,
                    l = 0;
                c.forEach((t) => {
                        t.checked && ((r = !0), l++);
                    }),
                    r ?
                    ((n.innerHTML = l),
                        t.classList.add("d-none"),
                        o.classList.remove("d-none")) :
                    (t.classList.remove("d-none"), o.classList.add("d-none"));
            };
            return {
                init: function() {
                    (e = document.querySelector("#table_simpanan")) &&
                    (e.querySelectorAll("tbody tr").forEach((t) => {
                            const e = t.querySelectorAll("td"),
                                o = moment(e[5].innerHTML, "DD MMM YYYY, LT").format();
                            e[5].setAttribute("data-order", o);
                        }),
                        (t = $(e).DataTable({
                            info: !1,
                            order: [],
                            columnDefs: [{
                                    orderable: !1,
                                    targets: 0
                                },
                                {
                                    orderable: !1,
                                    targets: 4
                                },
                            ],
                        })).on("draw", function() {
                            n(), o(), c();
                        }),
                        n(),
                        document
                        .querySelector('[data-kt-customer-table-filter="search"]')
                        .addEventListener("keyup", function(e) {
                            t.search(e.target.value).draw();
                        }),
                        o(),
                        (() => {
                            const e = document.querySelector(
                                '[data-kt-ecommerce-order-filter="Simpanan"]'
                            );
                            $(e).on("change", (e) => {
                                let o = e.target.value;
                                "all" === o && (o = ""), t.column(3).search(o).draw();
                            });
                        })());
                },
            };
        })();
        KTUtil.onDOMContentLoaded(function() {
            KTCustomersList.init();
        });
    </script>
@stop
