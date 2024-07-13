@extends('layouts.dashboard.master')
@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
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
                                Anggota
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
                                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                                    <input type="text" data-kt-customer-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari Anggota" />
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
                                            data-hide-search="true" data-placeholder="Status"
                                            data-kt-ecommerce-order-filter="status">
                                            <option></option>
                                            <option value="all">Semua</option>
                                            <option value="Anggota">Anggota</option>
                                            <option value="Tidak Aktif">Tidak Aktif</option>
                                        </select>
                                        <!--end::Select2-->
                                    </div>
                                    <!--end::Filter-->
                                    <!--begin::Export-->
                                    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                                        data-bs-target="#kt_customers_export_modal">
                                        <i class="ki-outline ki-exit-up fs-2"></i>Export
                                    </button>
                                    <!--end::Export-->
                                    <!--begin::Add customer-->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_users">
                                        Tambahkan Anggota
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
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="table_anggota">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">
                                            No
                                        </th>
                                        <th class="min-w-125px">Nomor anggota</th>
                                        <th class="min-w-125px">Nama Lengkap</th>
                                        <th class="min-w-125px">Status</th>
                                        <th class="min-w-125px">Role</th>
                                        <th class="min-w-125px">Daftar Sejak</th>
                                        <th class="text-end min-w-70px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->


                    <!--begin::Modals Create-->
                    <div class="modal fade" id="kt_modal_add_users" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-lg">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Form-->
                                <form class="form" action="{{ route('users.create') }}" id="kt_modal_add_users_form"
                                    data-kt-redirect="{{ route('users.index') }}">
                                    @csrf
                                    <!--begin::Modal header-->
                                    <div class="modal-header" id="kt_modal_add_users_header">
                                        <!--begin::Modal title-->
                                        <h2 class="fw-bold">Tambahkan Anggota</h2>
                                        <!--end::Modal title-->
                                        <!--begin::Close-->
                                        <div id="kt_modal_add_users_close"
                                            class="btn btn-icon btn-sm btn-active-icon-primary">
                                            <i class="ki-outline ki-cross fs-1"></i>
                                        </div>
                                        <!--end::Close-->
                                    </div>
                                    <!--end::Modal header-->
                                    <!--begin::Modal body-->
                                    <div class="modal-body py-10 px-lg-17">
                                        <!--begin::Scroll-->
                                        <div class="scroll-y me-n7 pe-7" id="kt_modal_add_users_scroll"
                                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_add_users_header"
                                            data-kt-scroll-wrappers="#kt_modal_add_users_scroll"
                                            data-kt-scroll-offset="300px">
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fs-6 fw-semibold mb-2">Nomor anggota</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Nomor Anggota" name="num_member" id="num_member"
                                                    disabled />
                                                <!--end::Input-->
                                            </div>
                                            <!-- endL::input group -->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fs-6 fw-semibold mb-2">Nama Lengkap</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Nama Anggota" name="name" />
                                                <!--end::Input-->
                                            </div>
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">Golongan</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Biaya yang harus dibayar setiap bulannya">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                    </span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="group" aria-label="Pilih Golongan" data-control="select2"
                                                    data-placeholder="Pilih Golongan"
                                                    data-dropdown-parent="#kt_modal_add_users"
                                                    class="form-select form-select-solid fw-bold">
                                                    <option value="">Pilih Golongan</option>
                                                    @foreach ($golongan as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                    @endforeach
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <label class="fs-6 fw-semibold mb-2">Simpanan Wajib</label>
                                                <input type="number" class="form-control form-control-solid"
                                                    placeholder="Simpanan Wajib Pertama kali daftar (Opsional)"
                                                    name="mandatory_savings" min="0" />
                                                <!--end::Input-->
                                            </div>

                                            <div class="fv-row mb-7">
                                                <label class="fs-6 fw-semibold mb-2">Simpanan Sukarela</label>
                                                <input type="number" class="form-control form-control-solid"
                                                    placeholder="Simpanan Sukarela (Opsional)" name="voluntary_savings"
                                                    min="0" />
                                                <!--end::Input-->
                                            </div>
                                            <!--begin::Input group-->
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">Posisi</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip" title="Akses akun">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                    </span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="roles" aria-label="Select a Role" data-control="select2"
                                                    data-placeholder="Pilih Posisi"
                                                    data-dropdown-parent="#kt_modal_add_users"
                                                    class="form-select form-select-solid fw-bold">
                                                    <option value="">Pilih Posisi</option>
                                                    @foreach ($roles as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                    @endforeach
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Scroll-->
                                    </div>
                                    <!--end::Modal body-->
                                    <!--begin::Modal footer-->
                                    <div class="modal-footer flex-center">
                                        <!--begin::Button-->
                                        <button type="reset" id="kt_modal_add_users_cancel" class="btn btn-light me-3">
                                            Buang
                                        </button>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <button type="submit" id="kt_modal_add_users_submit" class="btn btn-primary">
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
                    <div class="modal fade" id="kt_customers_export_modal" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-lg">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bold">Export Anggota</h2>
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
                                                <option value="true">Aktif</option>
                                                <option value="false">Anggota Non Aktif</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Row-->
                                        <div class="row fv-row mb-15">
                                            <!--begin::Label-->
                                            <label class="fs-5 fw-semibold form-label mb-5">Daftar Informasi:</label>
                                            <!--end::Label-->
                                            <!--begin::Radio group-->
                                            <div class="d-flex flex-column">
                                                <!--begin::Radio button-->
                                                <label
                                                    class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        checked="checked" name="payment_type" />
                                                    <span class="form-check-label text-gray-600 fw-semibold">Semua</span>
                                                </label>
                                                <!--end::Radio button-->
                                                <!--begin::Radio button-->
                                                <label
                                                    class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                                    <input class="form-check-input" type="checkbox" value="3"
                                                        name="payment_type" />
                                                    <span class="form-check-label text-gray-600 fw-semibold">Nomor & Nama
                                                        Anggota</span>
                                                </label>
                                                <!--end::Radio button-->
                                                <!--begin::Radio button-->
                                                <label
                                                    class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                                    <input class="form-check-input" type="checkbox" value="2"
                                                        name="payment_type" />
                                                    <span
                                                        class="form-check-label text-gray-600 fw-semibold">Username</span>
                                                </label>
                                                <!--end::Radio button-->
                                                <!--begin::Radio button-->
                                                <label
                                                    class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                                    <input class="form-check-input" type="checkbox" value="2"
                                                        name="payment_type" />
                                                    <span class="form-check-label text-gray-600 fw-semibold">Status
                                                        Aktif</span>
                                                </label>
                                                <!--end::Radio button-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Row-->
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
                    <!--end::Modals Create-->

                    <!--begin::Modals Edit-->
                    <div class="modal fade" id="kt_modal_edit_users" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-lg">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Form-->
                                <form class="form" action="{{ route('users.update', ':id') }}"
                                    id="kt_modal_edit_users_form" data-kt-redirect="{{ route('users.index') }}">
                                    @csrf
                                    <!--begin::Modal header-->
                                    <div class="modal-header" id="kt_modal_edit_users_header">
                                        <!--begin::Modal title-->
                                        <h2 class="fw-bold">Merubah Data Anggota</h2>
                                        <!--end::Modal title-->
                                        <!--begin::Close-->
                                        <div id="kt_modal_edit_users_close"
                                            class="btn btn-icon btn-sm btn-active-icon-primary">
                                            <i class="ki-outline ki-cross fs-1"></i>
                                        </div>
                                        <!--end::Close-->
                                    </div>
                                    <!--end::Modal header-->
                                    <!--begin::Modal body-->
                                    <div class="modal-body py-10 px-lg-17">
                                        <!--begin::Scroll-->
                                        <div class="scroll-y me-n7 pe-7" id="kt_modal_edit_users_scroll"
                                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_edit_users_header"
                                            data-kt-scroll-wrappers="#kt_modal_edit_users_scroll"
                                            data-kt-scroll-offset="300px">
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fs-6 fw-semibold mb-2">Nomor anggota</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Nomor Anggota" name="num_member" id="num_member"
                                                    disabled />
                                                <!--end::Input-->
                                            </div>
                                            <!-- endL::input group -->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fs-6 fw-semibold mb-2">Nama Lengkap</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Nama Anggota" name="name" id="name" />
                                                <!--end::Input-->
                                            </div>
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fs-6 fw-semibold mb-2">Username</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Username Anggota" name="username" id="username" />
                                            </div>
                                            <!--end::Input-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">Password baru</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Password baru (Opsional)" name="password"
                                                    id="password" />
                                            </div>
                                            <!--end::Input-->
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">Golongan</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Biaya yang harus dibayar setiap bulannya">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                    </span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="group" aria-label="Pilih Golongan" data-control="select2"
                                                    data-placeholder="Pilih Golongan"
                                                    data-dropdown-parent="#kt_modal_edit_users"
                                                    class="form-select form-select-solid fw-bold" id="group">
                                                    <option value="">Pilih Golongan</option>
                                                    @foreach ($golongan as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                    @endforeach
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <label class="fs-6 fw-semibold mb-2">Simpanan Wajib</label>
                                                <input type="number" class="form-control form-control-solid"
                                                    placeholder="Simpanan Wajib Pertama kali daftar (Opsional)"
                                                    name="mandatory_savings" id="mandatory_savings" />
                                                <!--end::Input-->
                                            </div>

                                            <div class="fv-row mb-7">
                                                <label class="fs-6 fw-semibold mb-2">Simpanan Sukarela</label>
                                                <input type="number" class="form-control form-control-solid"
                                                    placeholder="Simpanan Sukarela (Opsional)" name="voluntary_savings"
                                                    id="voluntary_savings" />
                                                <!--end::Input-->
                                            </div>
                                            <!--begin::Input group-->
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">Posisi</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip" title="Akses akun">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                    </span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="roles" aria-label="Select a Role" data-control="select2"
                                                    data-placeholder="Pilih Posisi"
                                                    data-dropdown-parent="#kt_modal_edit_users"
                                                    class="form-select form-select-solid fw-bold" id="roles">
                                                    <option value="">Pilih Posisi</option>
                                                    @foreach ($roles as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                    @endforeach
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">Status</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip" title="Akses akun">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                    </span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="status" aria-label="Select a Role" data-control="select2"
                                                    data-placeholder="Pilih Posisi"
                                                    data-dropdown-parent="#kt_modal_edit_users"
                                                    class="form-select form-select-solid fw-bold" id="status">
                                                    <option value="">Pilih Status</option>
                                                    <option value="0">Tidak Aktif</option>
                                                    <option value="1">Aktif</option>
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Scroll-->
                                    </div>
                                    <!--end::Modal body-->
                                    <!--begin::Modal footer-->
                                    <div class="modal-footer flex-center">
                                        <!--begin::Button-->
                                        <button type="reset" id="kt_modal_edit_users_cancel"
                                            class="btn btn-light me-3">
                                            Buang
                                        </button>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <button type="submit" id="kt_modal_edit_users_submit" class="btn btn-primary">
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
                    <div class="modal fade" id="kt_customers_export_modal" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-lg">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bold">Export Anggota</h2>
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
                                                <option value="Aktif">Anggota Aktif</option>
                                                <option value="Tidak Aktif">Anggota Non Aktif</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Row-->
                                        <div class="row fv-row mb-15">
                                            <!--begin::Label-->
                                            <label class="fs-5 fw-semibold form-label mb-5">Daftar Informasi:</label>
                                            <!--end::Label-->
                                            <!--begin::Radio group-->
                                            <div class="d-flex flex-column">
                                                <!--begin::Radio button-->
                                                <label
                                                    class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        checked="checked" name="payment_type" />
                                                    <span class="form-check-label text-gray-600 fw-semibold">Semua</span>
                                                </label>
                                                <!--end::Radio button-->
                                                <!--begin::Radio button-->
                                                <label
                                                    class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                                    <input class="form-check-input" type="checkbox" value="3"
                                                        name="payment_type" />
                                                    <span class="form-check-label text-gray-600 fw-semibold">Nama
                                                        Anggota</span>
                                                </label>
                                                <!--end::Radio button-->
                                                <!--begin::Radio button-->
                                                <label
                                                    class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                                    <input class="form-check-input" type="checkbox" value="2"
                                                        name="payment_type" />
                                                    <span
                                                        class="form-check-label text-gray-600 fw-semibold">Username</span>
                                                </label>
                                                <!--end::Radio button-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Row-->
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
                    <!--end::Modals Create-->
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
    <script src="{{ asset('assets/plugins/custom/c_mAddUsers.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/c_mUpdateUsers.js') }}"></script>
    <script>
        const datatable = $("#table_anggota").DataTable({
            ajax: "{{ route('users.datatable') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'num_member',
                    name: 'num_member'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions'
                },
            ]
        })

        document.querySelector('[data-kt-customer-table-filter="search"]')
            .addEventListener("keyup", function(e) {
                datatable.search(e.target.value).draw();
            })

        $('[data-kt-ecommerce-order-filter="status"]').on("change", (e) => {
            let o = e.target.value;
            "all" === o && (o = ""), datatable.column(3).search(o).draw();
        });

        $(document).on("click", '.user-delete', function(e) {
            e.preventDefault();
            n = $(this).data('id')
            Swal.fire({
                text: "Apakah yakin ingin menghapus Nomor Anggota " + n +
                    "?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Tidak",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary",
                },
            }).then(function(e) {
                if (e.value) {
                    $.ajax({
                        url: "{{ route('users.destroy', ['id' => ':id']) }}"
                            .replace(':id', n),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $(
                                'meta[name="csrf-token"]').attr(
                                'content')
                        },
                        success: function(response) {
                            Swal.fire({
                                text: "Berhasil menghapus Nomor Anggota " +
                                    n + "!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "OK mengerti!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                },
                            }).then(function() {
                                datatable.ajax.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                text: "Gagal menghapus Nomor Anggota " +
                                    n +
                                    ". Silakan coba lagi.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "OK mengerti!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                },
                            });
                        }
                    });
                } else if (e.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        text: "Nomor Anggota " + n +
                            " tidak dihapus.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK mengerti!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        },
                    });
                }
            });

        });

        $(document).on("click", '.user-edit', function(e) {
            e.preventDefault();

            let id = $(this).data('id')

            $.ajax({
                type: "GET",
                url: "{{ route('users.detail', ':id') }}".replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                success: function(response) {
                    $("#kt_modal_edit_users").find("[name='num_member']").val(response.num_member)
                    $("#kt_modal_edit_users").find("[name='name']").val(response.name)
                    $("#kt_modal_edit_users").find("[name='username']").val(response.username)
                    $("#kt_modal_edit_users").find("[name='roles']").val(response.role_id).trigger(
                        'change')
                    $("#kt_modal_edit_users").find("[name='status']").val(response.status_active)
                        .trigger('change')

                    $("#kt_modal_edit_users").modal("show")
                }
            });
        })
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal_add = document.getElementById('kt_modal_add_users');
            modal_add.addEventListener('show.bs.modal', function() {
                fetch("{{ route('users.generate_number') }}")
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('num_member').value = data.newNumber;
                    })
                    .catch(error => console.error('Error:', error));
            });

        });
    </script>
@stop
