@extends('layouts.master') @section('styles')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.css') }}" rel="stylesheet" type="text/css" />

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
                                Dashboard KODIJA
                                <!--begin::Description-->
                                <span class="page-desc text-muted fs-7 fw-semibold"></span>
                                <!--end::Description-->
                            </h1>
                            <!--end::Title-->
                            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                                <li class="breadcrumb-item text-muted">
                                    <a href="index.html" class="text-muted text-hover-primary">Dashboard</a>
                                </li>
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
                    <!--begin::Row-->
                    <div class="row gy-5 gx-xl-10">
                        <!--begin::Col-->
                        <div class="col-sm-6 col-xl-4 mb-xl-10">
                            <!--begin::Card widget 2-->
                            <div class="card h-lg-100">
                                <!--begin::Body-->
                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                    <!--begin::Icon-->
                                    <div class="m-0">
                                        <i class="ki-outline ki-compass fs-2hx text-gray-600"></i>
                                    </div>
                                    <!--end::Icon-->
                                    <!--begin::Section-->
                                    <div class="d-flex flex-column my-7">
                                        <!--begin::Number-->
                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">327</span>
                                        <!--end::Number-->
                                        <!--begin::Follower-->
                                        <div class="m-0">
                                            <span class="fw-semibold fs-6 text-gray-500">Anggota Aktif</span>
                                        </div>
                                        <!--end::Follower-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Badge-->
                                    <span class="badge badge-light-success fs-base">
                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.1%</span>
                                    <!--end::Badge-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Card widget 2-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-sm-6 col-xl-4 mb-xl-10">
                            <!--begin::Card widget 2-->
                            <div class="card h-lg-100">
                                <!--begin::Body-->
                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                    <!--begin::Icon-->
                                    <div class="m-0">
                                        <i class="ki-outline ki-chart-simple fs-2hx text-gray-600"></i>
                                    </div>
                                    <!--end::Icon-->
                                    <!--begin::Section-->
                                    <div class="d-flex flex-column my-7">
                                        <!--begin::Number-->
                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">27,5M</span>
                                        <!--end::Number-->
                                        <!--begin::Follower-->
                                        <div class="m-0">
                                            <span class="fw-semibold fs-6 text-gray-500">Golongan</span>
                                        </div>
                                        <!--end::Follower-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Badge-->
                                    <span class="badge badge-light-success fs-base">
                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.1%</span>
                                    <!--end::Badge-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Card widget 2-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-sm-6 col-xl-4 mb-xl-10">
                            <!--begin::Card widget 2-->
                            <div class="card h-lg-100">
                                <!--begin::Body-->
                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                    <!--begin::Icon-->
                                    <div class="m-0">
                                        <i class="ki-outline ki-chart-simple fs-2hx text-gray-600"></i>
                                    </div>
                                    <!--end::Icon-->
                                    <!--begin::Section-->
                                    <div class="d-flex flex-column my-7">
                                        <!--begin::Number-->
                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">27,5M</span>
                                        <!--end::Number-->
                                        <!--begin::Follower-->
                                        <div class="m-0">
                                            <span class="fw-semibold fs-6 text-gray-500">Total Simpanan</span>
                                        </div>
                                        <!--end::Follower-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Badge-->
                                    <span class="badge badge-light-success fs-base">
                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.1%</span>
                                    <!--end::Badge-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Card widget 2-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                    <!--begin::Row-->
                    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                        <!--begin::Col-->
                        <div class="col-xl-12 mb-xl-10">
                            <!--begin::Chart widget 38-->
                            <div class="card card-flush">
                                <!--begin::Header-->
                                <div class="card-header py-5">
                                    <!--begin::Title-->
                                    <h3 class="card-title fw-bold text-gray-800">Monthly Targets</h3>
                                    <!--end::Title-->
                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                                        <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left"
                                            class="btn btn-sm btn-light d-flex align-items-center px-4">
                                            <!--begin::Display range-->
                                            <div class="text-gray-600 fw-bold">Loading date range...</div>
                                            <!--end::Display range-->
                                            <i class="ki-outline ki-calendar-8 text-gray-500 lh-0 fs-2 ms-2 me-0"></i>
                                        </div>
                                        <!--end::Daterangepicker-->
                                    </div>
                                    <!--end::Toolbar-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body d-flex justify-content-between flex-column pb-0 px-0 pt-1">
                                    <!--begin::Items-->
                                    <div class="d-flex flex-wrap d-grid gap-5 px-9 mb-5">
                                        <!--begin::Item-->
                                        <div class="me-md-2">
                                            <!--begin::Statistics-->
                                            <div class="d-flex mb-2">
                                                <span class="fs-4 fw-semibold text-gray-500 me-1">$</span>
                                                <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">12,706</span>
                                            </div>
                                            <!--end::Statistics-->
                                            <!--begin::Description-->
                                            <span class="fs-6 fw-semibold text-gray-500">Targets for April</span>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div
                                            class="border-start-dashed border-end-dashed border-start border-end border-gray-300 px-5 ps-md-10 pe-md-7 me-md-5">
                                            <!--begin::Statistics-->
                                            <div class="d-flex mb-2">
                                                <span class="fs-4 fw-semibold text-gray-500 me-1">$</span>
                                                <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">8,035</span>
                                            </div>
                                            <!--end::Statistics-->
                                            <!--begin::Description-->
                                            <span class="fs-6 fw-semibold text-gray-500">Actual for April</span>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="m-0">
                                            <!--begin::Statistics-->
                                            <div class="d-flex align-items-center mb-2">
                                                <!--begin::Currency-->
                                                <span class="fs-4 fw-semibold text-gray-500 align-self-start me-1">$</span>
                                                <!--end::Currency-->
                                                <!--begin::Value-->
                                                <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">4,684</span>
                                                <!--end::Value-->
                                                <!--begin::Label-->
                                                <span class="badge badge-light-success fs-base">
                                                    <i
                                                        class="ki-outline ki-black-up fs-7 text-success ms-n1"></i>4.5%</span>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Statistics-->
                                            <!--begin::Description-->
                                            <span class="fs-6 fw-semibold text-gray-500">GAP</span>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Item-->
                                    </div>
                                    <!--end::Items-->
                                    <!--begin::Chart-->
                                    <div id="kt_charts_widget_20" class="min-h-auto ps-4 pe-6"
                                        data-kt-chart-info="Revenue" style="height: 300px"></div>
                                    <!--end::Chart-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Chart widget 38-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
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
                    <a href="https://github.com/IRWAPAW-Group" target="_blank"
                        class="text-gray-800 text-hover-primary">IRWAPAW
                        🐾</a>
                </div>
                <!--end::Copyright-->
                <!--begin::Menu-->

                <!--end::Menu-->
            </div>
            <!--end::Footer container-->
        </div>
        <!--end::Footer-->
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/create-campaign.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/new-address.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@stop
