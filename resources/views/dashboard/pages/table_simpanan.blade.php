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
                            <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
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
                    <div class="card">
                        <div class="card-header card-header-stretch">
                            <div class="card-toolbar m-0">
                                <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 fw-bold" role="tablist">
                                    @foreach ($years as $year)
                                        <li class="nav-item" role="presentation">
                                            <a id="tab_{{ $year }}" class="nav-link justify-content-center text-active-gray-800"
                                               data-bs-toggle="tab" role="tab" href="javascript:void(0);"
                                               data-year="{{ $year }}">{{ $year }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="card-body" style="max-height: 50em; overflow-y: scroll;">
                            <div class="tab-content">
                                <div id="data_simpanan" class="card-body p-0 tab-pane fade active show" role="tabpanel">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable_simpanan">
                                        <thead>
                                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                <th class="min-w-50px">ID</th>
                                                <th class="min-w-125px">Anggota</th>
                                                <th class="min-w-125px">S.Pokok</th>
                                                <th class="min-w-125px">S.Sukarela</th>
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
                                                <th class="min-w-75px">Tahun</th>
                                                <th class="min-w-125px">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="kt_app_footer" class="app-footer">
            <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                <div class="text-gray-900 order-2 order-md-1">
                    <span class="text-muted fw-semibold me-1">2024&copy;</span>
                    <a href="https://github.com/IRWAPAW-Group" target="_blank" class="text-gray-800 text-hover-primary">IRWAPAW 🐾</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#datatable_simpanan').DataTable({
                searching: false,
                paging: false,
                info: false,
                ordering: false
            });

            function loadTable(year) {
                $.ajax({
                    url: "{{ route('simpanan.loadTabelSimpananan') }}", // Update to the correct route
                    type: "GET",
                    data: {
                        year: year,
                    },
                    success: function(response) {
                        table.clear().draw();
                        response.data.forEach(function(row) {
                            table.row.add([
                                row.id,
                                row.anggota,
                                row.simpanan_pokok,
                                row.simpanan_sukarela,
                                row.januari,
                                row.februari,
                                row.maret,
                                row.april,
                                row.mei,
                                row.juni,
                                row.juli,
                                row.agustus,
                                row.september,
                                row.oktober,
                                row.november,
                                row.desember,
                                row.tahun,
                                row.total
                            ]).draw(false);
                        });
                    },
                    error: function(xhr) {
                        console.error("Error loading data: ", xhr.responseText);
                    }
                });
            }

            // Load data for the default active tab
            var activeYear = $('.nav-link.active').data('year');
            if (activeYear) {
                loadTable(activeYear);
            }

            $('.nav-link').on('click', function() {
                var year = $(this).data('year');
                if (year) {
                    loadTable(year);
                }
            });
        });
    </script>
@stop
