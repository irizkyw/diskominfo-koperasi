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
                                Transaksi
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
                                <li class="breadcrumb-item text-muted">Transaksi</li>
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
                                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari Anggota" />
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_transaksi">
                                        Tambahkan Transaksi
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="table_transaksi">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">
                                            No
                                        </th>
                                        <th class="min-w-125px">ID Aggota</th>
                                        <th class="min-w-125px">Jenis Transaksi</th>
                                        <th class="min-w-125px">Deskripsi</th>
                                        <th class="min-w-125px">Tanggal Transaksi</th>
                                        <th class="min-w-125px">Nominal</th>
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
                    <div class="modal fade" id="kt_modal_add_transaksi" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-lg">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Form-->
                                <form class="form" action="{{ route('transaksi.create') }}" method="post" id="kt_modal_add_transaksi_form"
                                    data-kt-redirect="{{ route('transaksi.index') }}">
                                    @csrf
                                    <!--begin::Modal header-->
                                    <div class="modal-header" id="kt_modal_add_transaksi_header">
                                        <!--begin::Modal title-->
                                        <h2 class="fw-bold">Tambahkan Role</h2>
                                        <!--end::Modal title-->
                                        <!--begin::Close-->
                                        <div id="kt_modal_add_transaksi_close"
                                            class="btn btn-icon btn-sm btn-active-icon-primary">
                                            <i class="ki-outline ki-cross fs-1"></i>
                                        </div>
                                        <!--end::Close-->
                                    </div>
                                    <!--end::Modal header-->
                                    <!--begin::Modal body-->
                                    <div class="modal-body py-10 px-lg-17">
                                        <!--begin::Scroll-->
                                        <div class="scroll-y me-n7 pe-7" id="kt_modal_add_transaksi_scroll"
                                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_add_transaksi_header"
                                            data-kt-scroll-wrappers="#kt_modal_add_transaksi_scroll"
                                            data-kt-scroll-offset="300px">
                                            

                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-7 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">Nama Anggota</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip" title="Akses akun">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                    </span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="user_id" aria-label="Pilih Nama Anggota" data-control="select2"
                                                    data-placeholder="Pilih Nama Anggota"
                                                    class="form-select form-select-solid fw-bold">
                                                    <option></option>
                                                    @foreach ($users as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                    @endforeach
                                                <!--end::Input-->
                                                </select>
                                            </div>

                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fs-6 fw-semibold mb-2">Jenis Transaksi</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="transaction_type" aria-label="Pilih Nama Anggota" data-control="select2"
                                                    data-placeholder="Pilih Nama Anggota"
                                                    class="form-select form-select-solid fw-bold">
                                                    <option></option>
                                                    <option value="Setoran">Setoran</option>
                                                    <option value="Penarikan">Penarikan</option>
                                                    <option value="SIMPANAN-BULANAN">SIMPANAN-BULANAN</option>
                                                    <option value="Erorr">Erorr</option>
                                                <!--end::Input-->
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fs-6 fw-semibold mb-2">Deskripsi (opsional)</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Deskripsi Transaksi" name="description" />
                                                <!--end::Input-->
                                            </div>
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fs-6 fw-semibold mb-2">Tanggal Transaksi</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Tahun-Bulan-Tanggal -> 2XXX-XX-XX" name="date_transaction" />
                                                <!--end::Input-->
                                            </div>
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fs-6 fw-semibold mb-2">Nominal</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Banyak Nominal (Rp)" name="nominal" />
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <!--end::Scroll-->
                                    </div>
                                    <!--end::Modal body-->
                                    <!--begin::Modal footer-->
                                    <div class="modal-footer flex-center">
                                        <!--begin::Button-->
                                        <button type="reset" id="kt_modal_add_transaksi_cancel" class="btn btn-light me-3">
                                            Buang
                                        </button>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <button type="submit" id="kt_modal_add_transaksi_submit" class="btn btn-primary">
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
                    <div class="modal fade" id="kt_modal_edit_transaksi" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-lg">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Form-->
                                
                                <form class="form" action="{{ route('transaksi.update', ':id') }}"
                                    id="kt_modal_edit_transaksi_form"  data-kt-redirect="{{ route('transaksi.index') }}">
                                    @csrf
                                    <div class="modal-header" id="kt_modal_edit_transaksi_header">
                                        <h2 class="fw-bold">Merubah Data Transaksi</h2>
                                        <div id="kt_modal_edit_transaksi_close"
                                            class="btn btn-icon btn-sm btn-active-icon-primary">
                                            <i class="ki-outline ki-cross fs-1"></i>
                                        </div>
                                    </div>
                                    <div class="modal-body py-10 px-lg-17">
                                        <div class="scroll-y me-n7 pe-7" id="kt_modal_edit_transaksi_scroll"
                                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_edit_transaksi_header"
                                            data-kt-scroll-wrappers="#kt_modal_edit_transaksi_scroll"
                                            data-kt-scroll-offset="300px">
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Nama Anggota</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="ID Role" name="user_id" id="user_id"  />
                                            </div>
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Jenis Transaksi</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Nama Role" name="transaction_type" id="transaction_type" />
                                            </div>
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Deskripsi (opsional)</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Deskripsi" name="description" id="description" />
                                            </div>
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Tanggal Transaksi</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Tanggal Transaksi" name="date_transaction" id="date_transaction" />
                                            </div>
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Nominal</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Nominal" name="nominal" id="nominal" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer flex-center">
                                        <button type="reset" id="kt_modal_edit_transaksi_cancel"
                                            class="btn btn-light me-3">
                                            Buang
                                        </button>
                                        <button type="submit" id="kt_modal_edit_transaksi_submit" class="btn btn-primary">
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
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/c_mAddTransaksi') }}"></script>
    <script src="{{ asset('assets/plugins/custom/c_mUpdatetransaksi.js') }}"></script>
    <script>
        const datatable = $("#table_transaksi").DataTable({
            ajax: "{{ route('transaksi.datatable') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
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
            n = $(this).data('id')
            name = $(this).data('name')
            Swal.fire({
                text: "Apakah yakin ingin menghapus Role " + name +
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
                        url: "{{ route('transaksi.destroy', ['id' => ':id']) }}"
                            .replace(':id', n),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $(
                                'meta[name="csrf-token"]').attr(
                                'content')
                        },
                        success: function(response) {
                            Swal.fire({
                                text: "Berhasil menghapus Role " +
                                    name + "!",
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
                                text: "Gagal menghapus Role " +
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
                        text: "Role " + name +
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

        $(document).on("click", '.transaksi-edit', function(e) {
            e.preventDefault();

            let id = $(this).data('id')

            $.ajax({
                type: "GET",
                url: "{{ route('transaksi.findById', ':id') }}".replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                success: function(response) {
                    // Mengisi nilai-nilai form di modal edit transaksi
                    $("#kt_modal_edit_transaksi").find("[name='id']").val(response.id)
                    $("#kt_modal_edit_transaksi").find("[name='user_id']").val(response.user_id)
                    $("#kt_modal_edit_transaksi").find("[name='transaction_type']").val(response.transaction_type)
                    $("#kt_modal_edit_transaksi").find("[name='description']").val(response.description)
                    $("#kt_modal_edit_transaksi").find("[name='date_transaction']").val(response.date_transaction)
                    $("#kt_modal_edit_transaksi").find("[name='nominal']").val(response.nominal)
                    
                    // Menampilkan modal edit transaksi
                    $("#kt_modal_edit_transaksi").modal("show")
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        text: "Gagal memuat data transaksi.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "OK mengerti!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    });
                }
            });
        });
    </script>
@stop
