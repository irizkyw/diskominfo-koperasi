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
                        <div class="col-sm-6 col-xl-6 mb-xl-10">
                            <!--begin::Card widget 2-->
                            <div class="card h-lg-100">
                                <!--begin::Body-->
                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                    <!--begin::Icon-->
                                    <div class="m-0">
                                        <i class="ki-outline ki-user fs-2hx text-gray-600"></i>
                                    </div>
                                    <!--end::Icon-->
                                    <!--begin::Section-->
                                    <div class="d-flex flex-column my-7">
                                        <!--begin::Number-->
                                        <span
                                            class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ $activeMembersCount }}</span>
                                        <!--end::Number-->
                                        <!--begin::Follower-->
                                        <div class="m-0">
                                            <span class="fw-semibold fs-6 text-gray-500">Anggota Aktif</span>
                                        </div>
                                        <!--end::Follower-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Card widget 2-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-sm-6 col-xl-6 mb-xl-10">
                            <!--begin::Card widget 2-->
                            <div class="card h-lg-100">
                                <!--begin::Body-->
                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                    <!--begin::Icon-->
                                    <div class="m-0">
                                        <i class="ki-outline ki-folder fs-2hx text-gray-600"></i>
                                    </div>
                                    <!--end::Icon-->
                                    <!--begin::Section-->
                                    <div class="d-flex flex-column my-7">
                                        <!--begin::Number-->
                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ $golonganData }}</span>
                                        <!--end::Number-->
                                        <!--begin::Follower-->
                                        <div class="m-0">
                                            <span class="fw-semibold fs-6 text-gray-500">Golongan</span>
                                        </div>
                                        <!--end::Follower-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Card widget 2-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        {{-- <div class="col-sm-6 col-xl-4 mb-xl-10">
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
                                            <span class="fw-semibold fs-6 text-gray-500">Total Simpanan
                                                {{ \Carbon\Carbon::now()->year }}</span>
                                        </div>
                                        <!--end::Follower-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Card widget 2-->
                        </div> --}}
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <div class="d-flex flex-lg-row-fluid">
                        <!--begin::Content-->
                        <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                            <!--begin::Image-->
                            <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                                src="{{ asset('assets/media/illustrations/dozzy-1/13.png') }}" alt="" />
                            <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                                src="{{ asset('assets/media/illustrations/dozzy-1/13-dark.png') }}" alt="" />
                            <!--end::Image-->
                            <!--begin::Title-->
                            <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">SELAMAT DATANG DI DASHBOARD KODIJA
                                <br> (Koperasi Diskominfo Jawa Barat)
                            </h1>
                            <!--end::Title-->
                            <!--begin::Text-->
                            <div class="text-gray-600 fs-base text-center fw-semibold">
                                Selamat datang di dashboard KODIJA, platform ini menyediakan berbagai fitur untuk memudahkan
                                Anda dalam mengelola layanan koperasi, termasuk Dashboard Utama, Kelola Anggota, Kelola
                                Posisi, Kelola Golongan, Data Simpanan, Tabel Simpanan, dan Broadcast Events, yang semuanya
                                bertujuan untuk meningkatkan efisiensi dan transparansi pengelolaan koperasi.
                            </div>

                            <!--end::Text-->
                        </div>
                        <!--end::Content-->
                    </div>

                    <!--begin::Row-->
                    {{-- <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                        <!--begin::Col-->
                        <div class="col-xl-12 mb-xl-10">
                            <!--begin::Chart widget 38-->
                            <div class="card card-flush">
                                <!--begin::Header-->
                                <div class="card-header py-5">
                                    <!--begin::Title-->
                                    <h3 class="card-title fw-bold text-gray-800">Simpanan Tahunan</h3>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body d-flex justify-content-between flex-column pb-0 px-0 pt-1">
                                    <div id="kt_charts_widget_20" class="min-h-auto ps-4 pe-6"
                                        data-kt-chart-info="Total Simpanan" style="height: 300px"></div>
                                    <!--end::Chart-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Chart widget 38-->
                        </div>
                        <!--end::Col-->
                    </div> --}}
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
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>

    <script>
        var KTChartsWidget20 = function() {
            var e = {
                    self: null,
                    rendered: !1
                },
                t = function(e) {
                    var t = document.getElementById("kt_charts_widget_20");
                    if (t) {
                        var a = parseInt(KTUtil.css(t, "height")),
                            l = KTUtil.getCssVariableValue("--bs-gray-500"),
                            r = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                            o = KTUtil.getCssVariableValue("--bs-danger"),
                            i = KTUtil.getCssVariableValue("--bs-danger"),
                            s = {
                                series: [{
                                    name: t.getAttribute("data-kt-chart-info"),
                                    data: [34.5, 34.5, 35, 35, 35.5, 35.5, 35, 35, 35.5, 35.5, 35, 35, 34.5,
                                        34.5, 35, 35, 35.4, 35.4, 35
                                    ]
                                }],
                                chart: {
                                    fontFamily: "inherit",
                                    type: "area",
                                    height: a,
                                    toolbar: {
                                        show: 1
                                    }
                                },
                                plotOptions: {},
                                legend: {
                                    show: !1
                                },
                                dataLabels: {
                                    enabled: !1
                                },
                                fill: {
                                    type: "gradient",
                                    gradient: {
                                        shadeIntensity: 1,
                                        opacityFrom: .4,
                                        opacityTo: 0,
                                        stops: [0, 80, 100]
                                    }
                                },
                                stroke: {
                                    curve: "smooth",
                                    show: !0,
                                    width: 3,
                                    colors: [o]
                                },
                                xaxis: {
                                    categories: ["", "Apr 02", "Apr 03", "Apr 04", "Apr 05", "Apr 06", "Apr 07",
                                        "Apr 08", "Apr 09", "Apr 10", "Apr 11", "Apr 12", "Apr 13", "Apr 14",
                                        "Apr 17", "Apr 18", "Apr 19", "Apr 21", ""
                                    ],
                                    axisBorder: {
                                        show: !1
                                    },
                                    axisTicks: {
                                        show: !1
                                    },
                                    tickAmount: 6,
                                    labels: {
                                        rotate: 0,
                                        rotateAlways: !0,
                                        style: {
                                            colors: l,
                                            fontSize: "12px"
                                        }
                                    },
                                    crosshairs: {
                                        position: "front",
                                        stroke: {
                                            color: o,
                                            width: 1,
                                            dashArray: 3
                                        }
                                    },
                                    tooltip: {
                                        enabled: !0,
                                        formatter: void 0,
                                        offsetY: 0,
                                        style: {
                                            fontSize: "12px"
                                        }
                                    }
                                },
                                yaxis: {
                                    max: 36.3,
                                    min: 33,
                                    tickAmount: 6,
                                    labels: {
                                        style: {
                                            colors: l,
                                            fontSize: "12px"
                                        },
                                        formatter: function(e) {
                                            return "$" + parseInt(10 * e)
                                        }
                                    }
                                },
                                states: {
                                    normal: {
                                        filter: {
                                            type: "none",
                                            value: 0
                                        }
                                    },
                                    hover: {
                                        filter: {
                                            type: "none",
                                            value: 0
                                        }
                                    },
                                    active: {
                                        allowMultipleDataPointsSelection: !1,
                                        filter: {
                                            type: "none",
                                            value: 0
                                        }
                                    }
                                },
                                tooltip: {
                                    style: {
                                        fontSize: "12px"
                                    },
                                    y: {
                                        formatter: function(e) {
                                            return "$" + parseInt(10 * e)
                                        }
                                    }
                                },
                                colors: [i],
                                grid: {
                                    borderColor: r,
                                    strokeDashArray: 4,
                                    yaxis: {
                                        lines: {
                                            show: !0
                                        }
                                    }
                                },
                                markers: {
                                    strokeColor: o,
                                    strokeWidth: 3
                                }
                            };
                        e.self = new ApexCharts(t, s), setTimeout((function() {
                            e.self.render(), e.rendered = !0
                        }), 200)
                    }
                };
            return {
                init: function() {
                    t(e), KTThemeMode.on("kt.thememode.change", (function() {
                        e.rendered && e.self.destroy(), t(e)
                    }))
                }
            }
        }();
    </script>
@stop
