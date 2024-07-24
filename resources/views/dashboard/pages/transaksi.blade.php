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
                                Simpanan
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
                                <li class="breadcrumb-item text-muted">Simpanan</li>
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
                            <div class="card-title">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                                    <input type="text" data-kt-customer-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-13" placeholder="Pencarian" />
                                </div>
                            </div>

                            <div class="card-toolbar">
                                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_export_simpanan">
                                        <i class="ki-outline ki-exit-up fs-2"></i>Export
                                    </button>
                                </div>

                                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_export_simpanan">
                                        <i class="bi bi-download fs-2"></i>Import
                                    </button>
                                </div>


                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_simpanan">
                                        Tambahkan Simpanan
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="table_simpanan">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-50px pe-2">
                                            No
                                        </th>
                                        <th class="min-w-100px">ID Transaksi</th>
                                        <th class="min-w-100px">Aggota</th>
                                        <th class="min-w-100px">Jenis Simpanan</th>
                                        <th class="min-w-125px">Deskripsi</th>
                                        <th class="min-w-125px">Tanggal Simpanan</th>
                                        <th class="min-w-75px">Nominal</th>
                                        <th class="text-end min-w-70px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end::Card-->


                    <!--begin::Modal - Adjust Balance-->
                    <div class="modal fade" id="kt_modal_export_simpanan" tabindex="-1" aria-hidden="true">
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
                                    <div id="kt_customers_export_close" class="btn btn-icon btn-sm btn-active-icon-primary"
                                        data-bs-dismiss="modal">
                                        <i class="ki-outline ki-cross fs-1"></i>
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--end::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                    <!--begin::Form-->
                                    <form id="kt_customers_export_form" class="form"
                                        action="{{ route('simpanan.export') }}" method="POST">
                                        @csrf

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <!--begin::Label-->
                                            <label class="fs-5 fw-semibold form-label mb-5">Pilih Format Ekspor:</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select data-control="select2" data-placeholder="Select a format"
                                                data-hide-search="true" name="format"
                                                class="form-select form-select-solid">
                                                <option value="xlsx">Excel</option>
                                                <option value="pdf">PDF</option>
                                                <option value="csv">CSV</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <!--begin::Label-->
                                            <label class="fs-5 fw-semibold form-label mb-5">Pilih Filter Anggota:</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select data-control="select2" data-placeholder="Select a filter"
                                                data-hide-search="true" name="filterAnggota"
                                                class="form-select form-select-solid">
                                                <option value="*">Semua</option>
                                                @foreach ($users as $data)
                                                    <option value={{ $data->id }}>{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <!--begin::Label-->
                                            <label class="fs-5 fw-semibold form-label mb-5">Pilih Filter Tipe
                                                Transaksi:</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select data-control="select2" data-placeholder="Select a filter"
                                                data-hide-search="true" name="filterTipeTransaksi"
                                                class="form-select form-select-solid">
                                                <option value="*">Semua</option>
                                                <option value="simp_wajib">Simpanan Wajib</option>
                                                <option value="simp_sukarela">Simpanan Sukarela</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <!--begin::Label-->
                                            <label class="fs-5 fw-semibold form-label mb-5">Pilih Filter Tahun:</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select data-control="select2" data-placeholder="Select a filter"
                                                data-hide-search="true" name="filterTahun"
                                                class="form-select form-select-solid">
                                                <option value="*">Semua</option>
                                                <option value="2024">2024</option>
                                                <option value="2023">2023</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Actions-->
                                        <div class="text-center">
                                            <button type="reset" id="kt_customers_export_cancel"
                                                class="btn btn-light me-3" data-bs-dismiss="modal">
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
                    <!--end::Modal - Adjust Balance-->


                    <!--begin::Modals Create-->
                    <div class="modal fade" id="kt_modal_add_simpanan" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-lg">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Form-->
                                <form class="form" action="{{ route('simpanan.create') }}"
                                    id="kt_modal_add_simpanan_form" data-kt-redirect="{{ route('simpanan.index') }}">
                                    @csrf
                                    <!--begin::Modal header-->
                                    <div class="modal-header" id="kt_modal_add_simpanan_header">
                                        <!--begin::Modal title-->
                                        <h2 class="fw-bold">Tambahkan Simpanan</h2>
                                        <!--end::Modal title-->
                                        <!--begin::Close-->
                                        <div id="kt_modal_add_simpanan_close"
                                            class="btn btn-icon btn-sm btn-active-icon-primary">
                                            <i class="ki-outline ki-cross fs-1"></i>
                                        </div>
                                        <!--end::Close-->
                                    </div>
                                    <!--end::Modal header-->
                                    <!--begin::Modal body-->
                                    <div class="modal-body py-10 px-lg-17">
                                        <!--begin::Scroll-->
                                        <div class="scroll-y me-n7 pe-7" id="kt_modal_add_simpanan_scroll"
                                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_add_simpanan_header"
                                            data-kt-scroll-wrappers="#kt_modal_add_simpanan_scroll"
                                            data-kt-scroll-offset="300px">

                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">Nama Anggota</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip" title="Pilih Anggota">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                    </span>
                                                </label>
                                                <select name="user_id" aria-label="Pilih Anggota" data-control="select2"
                                                    data-placeholder="Pilih Jenis Simpanan"
                                                    data-dropdown-parent="#kt_modal_add_simpanan"
                                                    class="form-select form-select-solid fw-bold">
                                                    <option value="">Pilih Anggota</option>
                                                    @foreach ($users as $data)
                                                        @foreach ($data->savings as $tabungan)
                                                            <option value="{{ $data->id }}">{{ $data->name }} (
                                                                {{ $tabungan->golongan->nama_golongan }} )
                                                            </option>
                                                        @endforeach
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">Jenis Simpanan</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Pilih jenis simpanan">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                    </span>
                                                </label>
                                                <select name="transaction_type" aria-label="Pilih Jenis Simpanan"
                                                    data-control="select2" data-placeholder="Pilih Jenis Simpanan"
                                                    data-dropdown-parent="#kt_modal_add_simpanan"
                                                    class="form-select form-select-solid fw-bold">
                                                    <option value="">Pilih Simpanan</option>
                                                    <option value="Simpanan Wajib">Simpanan Wajib</option>
                                                    <option value="Simpanan Sukarela">Simpanan Sukarela</option>
                                                </select>
                                            </div>
                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">Bayar untuk Bulan</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Pilih tanggal,bulan dan tahun untuk bayar simpanan bulan tersebut">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                    </span>
                                                </label>
                                                <input class="form-control form-control-solid" name="date_transaction"
                                                    placeholder="Bayar untuk bulan" id="datepicker_create" />
                                            </div>
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Nominal</label>
                                                <input type="number" class="form-control form-control-solid"
                                                    min="0" placeholder="Nominal (Rp)" name="nominal" />
                                            </div>
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Deskripsi</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Deskripsi" name="desc" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer flex-center">
                                        <!--begin::Button-->
                                        <button type="reset" id="kt_modal_add_simpanan_cancel"
                                            class="btn btn-light me-3">
                                            Buang
                                        </button>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <button type="submit" id="kt_modal_add_simpanan_submit" class="btn btn-primary">
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

                    <!--begin::Modals Edit-->
                    <div class="modal fade" id="kt_modal_edit_simpanan" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-lg">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Form-->
                                <form class="form" action="{{ route('simpanan.update', ':id') }}"
                                    data-original-action="{{ route('simpanan.update', ':id') }}"
                                    id="kt_modal_edit_simpanan_form" data-kt-redirect="{{ route('simpanan.index') }}">
                                    @csrf
                                    <div class="modal-header" id="kt_modal_edit_simpanan_header">
                                        <h2 class="fw-bold">Merubah Data Simpanan</h2>
                                        <div id="kt_modal_edit_simpanan_close"
                                            class="btn btn-icon btn-sm btn-active-icon-primary">
                                            <i class="ki-outline ki-cross fs-1"></i>
                                        </div>
                                    </div>
                                    <div class="modal-body py-10 px-lg-17">
                                        <div class="scroll-y me-n7 pe-7" id="kt_modal_edit_simpanan_scroll"
                                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_edit_simpanan_header"
                                            data-kt-scroll-wrappers="#kt_modal_edit_simpanan_scroll"
                                            data-kt-scroll-offset="300px">
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">ID Transaksi</label>

                                                <input type="text" class="form-control form-control-solid"
                                                    name="id" id="id" disabled />

                                                <input type="text" class="form-control form-control-solid"
                                                    name="user_id" id="user_id" hidden />
                                            </div>
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Anggota</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Nama Anggota" name="name" id="name" disabled />
                                            </div>
                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">Jenis Simpanan</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Pilih jenis simpanan">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                    </span>
                                                </label>
                                                <select name="transaction_type" aria-label="Pilih Jenis Simpanan"
                                                    data-control="select2" data-placeholder="Pilih Jenis Simpanan"
                                                    data-dropdown-parent="#kt_modal_edit_simpanan"
                                                    class="form-select form-select-solid fw-bold">
                                                    <option value="">Pilih Simpanan</option>
                                                    <option value="Simpanan Wajib">Simpanan Wajib</option>
                                                    <option value="Simpanan Sukarela">Simpanan Sukarela</option>
                                                </select>
                                            </div>
                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">Bayar untuk Bulan</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Pilih tanggal,bulan dan tahun untuk bayar simpanan bulan tersebut">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                    </span>
                                                </label>
                                                <input class="form-control form-control-solid" name="date_transaction"
                                                    placeholder="Bayar untuk bulan" id="datepicker_edit" />
                                            </div>
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Nominal</label>
                                                <input type="number" class="form-control form-control-solid"
                                                    min="0" placeholder="Nominal (Rp)" name="nominal" />
                                            </div>
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Deskripsi</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Deskripsi" name="desc" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer flex-center">
                                        <button type="reset" id="kt_modal_edit_simpanan_cancel"
                                            class="btn btn-light me-3">
                                            Buang
                                        </button>
                                        <button type="submit" id="kt_modal_edit_simpanan_submit"
                                            class="btn btn-primary">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="kt_app_footer" class="app-footer">
            <!--begin::Footer container-->
            <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                <!--begin::Copyright-->
                <div class="text-gray-900 order-2 order-md-1">
                    <span class="text-muted fw-semibold me-1">2024&copy;</span>
                    <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">IRWAPAW
                        🐾</a>
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
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/c_mAddSimpanan.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/c_mUpdateSimpanan.js') }}"></script>
    <script>
        $("#datepicker_create").flatpickr();
        $("#datepicker_edit").flatpickr();
    </script>
    <script>
        const datatable = $("#table_simpanan").DataTable({
            ajax: "{{ route('simpanan.datatable') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'simpanan_id',
                    name: 'simpanan_id'
                },
                {
                    data: 'user_id',
                    name: 'user_id'
                },
                {
                    data: 'transaction_type',
                    name: 'transaction_type'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'date_transaction',
                    name: 'date_transaction'
                },
                {
                    data: 'nominal',
                    name: 'nominal'
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

        $(document).on("click", '.transaksi-delete', function(e) {
            e.preventDefault();
            var n = $(this).data('id');
            Swal.fire({
                text: "Apakah yakin ingin menghapus Simpanan ID " + n +
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
                        url: "{{ route('simpanan.destroy', ['id' => ':id']) }}"
                            .replace(':id', n),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $(
                                'meta[name="csrf-token"]').attr(
                                'content')
                        },
                        success: function(response) {
                            Swal.fire({
                                text: "Berhasil menghapus Simpanan!",
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
                                text: "Gagal menghapus Simpanan " +
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
                        text: "Simpanan tidak dihapus.",
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

        $(document).on("click", '.transaksi-edit', function(e) {
            e.preventDefault();

            let id = $(this).data('id')

            $.ajax({
                type: "GET",
                url: "{{ route('simpanan.findById', ':id') }}".replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                success: function(response) {
                    $("#kt_modal_edit_simpanan").find("[name='id']").val(response.id)
                    $("#kt_modal_edit_simpanan").find("[name='user_id']").val(response.user_id)
                    $("#kt_modal_edit_simpanan").find("[name='name']").val(response.name)
                    $("#kt_modal_edit_simpanan").find("[name='desc']").val(response.description)
                    $("#kt_modal_edit_simpanan").find("[name='nominal']").val(response.nominal)
                    $("#kt_modal_edit_simpanan").find("[name='transaction_type']").val(response
                            .transaction_type)
                        .trigger('change');
                    $("#datepicker_edit").flatpickr().setDate(response.date_transaction);
                    $("#kt_modal_edit_simpanan").modal("show")
                }
            });
        })

        $(document).on("click", '.transaksi-export', function(e) {
            e.preventDefault();
            $('#kt_modal_export_simpanan').modal('show');
        });

        $(document).on("submit", '#kt_customers_export_form', function(e) {
            e.preventDefault();

            Swal.fire({
                text: "Apakah Anda yakin ingin mengekspor data?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Ya, Ekspor!",
                cancelButtonText: "Tidak",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                    cancelButton: "btn fw-bold btn-active-light-primary",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>
@stop
