@extends('layouts.master')

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
                <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
                    <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                        <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                            <h1
                                class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                                Tabel Simpanan
                            </h1>
                            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                                <li class="breadcrumb-item text-muted">
                                    <a href="index.html" class="text-muted text-hover-primary">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                                </li>
                                <li class="breadcrumb-item text-muted">Tabel Simpanan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Toolbar-->
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
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
                                <div>
                                    <button type="button" class="btn btn-light-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_export_simpanan">
                                        <i class="ki-outline ki-exit-up fs-2"></i>Export
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body" style="max-height: 65em;">
                            <div class="d-flex flex-column mb-4">
                                <!-- Dropdown for year selection -->
                                <select id="yearDropdown" class="form-select form-select-solid">
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="data_simpanan" class="card-body p-0">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable_simpanan">
                                    <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-25px">ID</th>
                                            <th class="min-w-125px">Anggota</th>
                                            <th class="min-w-125px">S.Pokok</th>
                                            <th class="min-w-125px">S.Sukarela</th>
                                            <th class="min-w-75px">Tahun</th>
                                            <th class="min-w-125px">Januari</th>
                                            <th class="min-w-125px">Februari</th>
                                            <th class="min-w-125px">Maret</th>
                                            <th class="min-w-125px">April</th>
                                            <th class="min-w-125px">Mei</th>
                                            <th class="min-w-125px">Juni</th>
                                            <th class="min-w-125px">Juli</th>
                                            <th class="min-w-125px">Agustus</th>
                                            <th class="min-w-125px">September</th>
                                            <th class="min-w-125px">Oktober</th>
                                            <th class="min-w-125px">November</th>
                                            <th class="min-w-125px">Desember</th>
                                            <th class="min-w-125px">S.Wajib</th>
                                            <th class="min-w-125px">Jumlah Simpanan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <!-- Data will be populated via DataTables -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->

        <!--begin::Modal - Export Simpanan-->
        <div class="modal fade" id="kt_modal_export_simpanan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold">Export Data Simpanan</h2>
                        <div id="kt_customers_export_close" class="btn btn-icon btn-sm btn-active-icon-primary"
                            data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <form id="kt_customers_export_form" class="form" action="{{ route('simpanan.export') }}"
                            method="POST">
                            @csrf
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-semibold form-label mb-5">Pilih Format Ekspor:</label>
                                <select data-control="select2" data-placeholder="Select a format" data-hide-search="true"
                                    name="format" class="form-select form-select-solid">
                                    <option value="xlsx">Excel</option>
                                </select>
                            </div>

                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-semibold form-label mb-5">Pilih Filter Tahun:</label>
                                <select data-control="select2" data-placeholder="Select a filter" data-hide-search="true"
                                    name="filterTahun" class="form-select form-select-solid">
                                    @php
                                        $years = \App\Models\Transaksi::selectRaw('YEAR(date_transaction) as year')
                                            ->distinct()
                                            ->orderBy('year', 'desc')
                                            ->pluck('year');
                                    @endphp

                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-center">
                                <button type="reset" id="kt_customers_export_cancel" class="btn btn-light me-3"
                                    data-bs-dismiss="modal">
                                    Buang
                                </button>
                                <button type="submit" id="kt_customers_export_submit" class="btn btn-primary">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Modal - Export Simpanan-->
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#datatable_simpanan').DataTable({
                searching: true,
                paging: true,
                pageLength: 9,
                lengthChange: false,
                info: false,
                ordering: false,
                processing: true,
                serverSide: true,
                scrollX: true,
                scrollCollapse: true,
                fixedColumns: {
                    left: 4
                },
                ajax: {
                    url: "{{ route('simpanan.loadTabelSimpananan') }}",
                    type: "GET",
                    data: function(d) {
                        d.year = $('#yearDropdown').val(); // Use selected year from dropdown
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'anggota'
                    },
                    {
                        data: 'simpanan_pokok'
                    },
                    {
                        data: 'simpanan_sukarela'
                    },
                    {
                        data: 'tahun'
                    },
                    {
                        data: 'januari'
                    },
                    {
                        data: 'februari'
                    },
                    {
                        data: 'maret'
                    },
                    {
                        data: 'april'
                    },
                    {
                        data: 'mei'
                    },
                    {
                        data: 'juni'
                    },
                    {
                        data: 'juli'
                    },
                    {
                        data: 'agustus'
                    },
                    {
                        data: 'september'
                    },
                    {
                        data: 'oktober'
                    },
                    {
                        data: 'november'
                    },
                    {
                        data: 'desember'
                    },
                    {
                        data: 'total_simpanan_currentYear'
                    },
                    {
                        data: 'total_tabungan'
                    }
                ]
            });

            // Change event for year dropdown
            $('#yearDropdown').change(function() {
                table.ajax.reload(); // Reload table data based on selected year
            });
        });
    </script>
@endsection
