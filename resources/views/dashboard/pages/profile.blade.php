@extends('layouts.dashboard.master')
@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <!--begin::Navbar-->
                    <div class="card mb-6">
                        <div class="card-body pt-9 pb-0">
                            <!--begin::Details-->
                            <div class="d-flex flex-wrap flex-sm-nowrap">
                                <!--begin: Pic-->
                                <div class="me-7 mb-4">
                                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                        <img src="https://www.gravatar.com/avatar/?d=mp" alt="image">
                                        <div
                                            class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                                        </div>
                                    </div>
                                </div>
                                <!--end::Pic-->
                                <!--begin::Info-->
                                <div class="flex-grow-1">
                                    <!--begin::Title-->
                                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                        <!--begin::User-->
                                        <div class="d-flex flex-column">
                                            <!--begin::Name-->
                                            <div class="d-flex align-items-center mb-2">
                                                <a href="#"
                                                    class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ Auth::user()->name }}</a>
                                                <a href="#">
                                                    <i class="ki-outline ki-verify fs-1 text-primary"></i>
                                                </a>
                                            </div>
                                            <!--end::Name-->
                                            <!--begin::Info-->
                                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                                <div
                                                    class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                                    <i
                                                        class="ki-outline ki-profile-circle fs-4 me-1"></i>{{ Auth::user()->username }}
                                                </div>

                                                <div
                                                    class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                                    <i class="ki-outline ki-sms fs-4 me-1"></i>Nomor Anggota :
                                                    {{ str_pad(Auth::user()->num_member, 3, '0', STR_PAD_LEFT) }}
                                                </div>

                                                <div
                                                    class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                                    <i class="ki-outline ki-geolocation fs-4 me-1"></i> GOLONGAN X
                                                </div>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::User-->
                                        <!--begin::Actions-->
                                        <div class="d-flex my-4">
                                            <!--begin::Menu-->
                                            <div class="me-0">
                                                <a href="{{ route('logout') }}"
                                                    class="btn btn-icon btn-color-gray-500 btn-active-color-primary me-3">
                                                    <i class="ki-outline ki-exit-right fs-2"></i>
                                                </a>
                                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary"
                                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    <i class="ki-solid ki-dots-horizontal fs-2x"></i>
                                                </button>
                                                <!--begin::Menu 3-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                                    data-kt-menu="true">
                                                    <!--begin::Heading-->
                                                    <div class="menu-item px-3">
                                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                                            Downloads
                                                        </div>
                                                    </div>
                                                    <!--end::Heading-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3 my-1">
                                                        <a href="#" class="menu-link px-3">Laporan Simpanan</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu 3-->
                                            </div>
                                            <!--end::Menu-->
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Title-->
                                    <!--begin::Stats-->
                                    <div class="d-flex flex-wrap flex-stack">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-column flex-grow-1 pe-8">
                                            <!--begin::Stats-->
                                            <div class="d-flex flex-wrap">
                                                <!--begin::Stat-->
                                                <div
                                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                    <!--begin::Number-->
                                                    <div class="d-flex align-items-center">
                                                        {{-- <i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i> --}}
                                                        <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                                            data-kt-countup-value="4500" data-kt-countup-prefix="$"
                                                            data-kt-initialized="1">$4,500</div>
                                                    </div>
                                                    <!--end::Number-->
                                                    <!--begin::Label-->
                                                    <div class="fw-semibold fs-6 text-gray-500">Simpanan</div>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Stat-->
                                                <!--begin::Stat-->
                                                <div
                                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                    <!--begin::Number-->
                                                    <div class="d-flex align-items-center">
                                                        {{-- <i class="ki-outline ki-arrow-down fs-3 text-danger me-2"></i> --}}
                                                        <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                                            data-kt-countup-value="80" data-kt-initialized="1">80</div>
                                                    </div>
                                                    <!--end::Number-->
                                                    <!--begin::Label-->
                                                    <div class="fw-semibold fs-6 text-gray-500">Hutang</div>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Stat-->
                                                <!--begin::Stat-->
                                                <div
                                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                    <!--begin::Number-->
                                                    <div class="d-flex align-items-center">
                                                        {{-- <i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i> --}}
                                                        <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                                            data-kt-countup-value="60" data-kt-countup-prefix="%"
                                                            data-kt-initialized="1">%60</div>
                                                    </div>
                                                    <!--end::Number-->
                                                    <!--begin::Label-->
                                                    <div class="fw-semibold fs-6 text-gray-500">Success Rate</div>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Stat-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Details-->
                        </div>
                    </div>
                    <!--end::Navbar-->
                    <!--begin::Timeline-->
                    <div class="card">
                        <!--begin::Card head-->
                        <div class="card-header card-header-stretch">
                            <!--begin::Title-->
                            <div class="card-title d-flex align-items-center">
                                {{-- <i class="ki-outline ki-calendar-8 fs-1 text-primary me-3 lh-0"></i> --}}
                                <h5 class="fw-bold m-0 text-gray-800">Halo {{ Auth::user()->name }}👋, Selamat datang di
                                    aplikasi Koperasi Diskominfo Jawabarat (Kodija)</h5>
                            </div>
                            <!--end::Title-->
                            <!--begin::Toolbar-->
                            <div class="card-toolbar m-0">
                                <!--begin::Tab nav-->
                                <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 fw-bold" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a id="kt_activity_today_tab"
                                            class="nav-link justify-content-center text-active-gray-800 active"
                                            data-bs-toggle="tab" role="tab" href="#kt_activity_today"
                                            aria-selected="true">Log Transaksi</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a id="kt_activity_week_tab"
                                            class="nav-link justify-content-center text-active-gray-800"
                                            data-bs-toggle="tab" role="tab" href="#kt_activity_week"
                                            aria-selected="false" tabindex="-1">Tabel Simpanan</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a id="kt_activity_month_tab"
                                            class="nav-link justify-content-center text-active-gray-800"
                                            data-bs-toggle="tab" role="tab" href="#kt_activity_month"
                                            aria-selected="false" tabindex="-1">Pengaturan</a>
                                    </li>
                                </ul>
                                <!--end::Tab nav-->
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Card head-->
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Tab Content-->
                            <div class="tab-content">
                                <!--begin::Tab panel-->
                                <div id="kt_activity_today" class="card-body p-0 tab-pane fade active show"
                                    role="tabpanel" aria-labelledby="kt_activity_today_tab">
                                    <!--begin::Timeline-->
                                    <div class="timeline timeline-border-dashed">
                                        <!--begin::Timeline item-->
                                        <div class="timeline-item">
                                            <!--begin::Timeline line-->
                                            <div class="timeline-line"></div>
                                            <!--end::Timeline line-->
                                            <!--begin::Timeline icon-->
                                            <div class="timeline-icon me-4">
                                                <i class="ki-outline ki-flag fs-2 text-gray-500"></i>
                                            </div>
                                            <!--end::Timeline icon-->
                                            <!--begin::Timeline content-->
                                            <div class="timeline-content mb-10 mt-n1">
                                                <!--begin::Timeline heading-->
                                                <div class="pe-3 mb-5">
                                                    <!--begin::Title-->
                                                    <div class="fs-5 fw-semibold mb-2">Transaksi ...</div>
                                                    <!--end::Title-->
                                                    <!--begin::Description-->
                                                    <div class="d-flex align-items-center mt-1 fs-6">
                                                        <!--begin::Info-->
                                                        <div class="text-muted me-2 fs-7">Added at 4:23 PM by ...</div>
                                                        <!--end::Info-->
                                                    </div>
                                                    <!--end::Description-->
                                                </div>
                                                <!--end::Timeline heading-->
                                                <!--begin::Timeline details-->
                                                <div class="overflow-auto pb-5">
                                                    <div
                                                        class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-0">
                                                        <div
                                                            class="fs-5 text-gray-900 text-hover-primary fw-semibold w-375px min-w-200px">
                                                            ....</div>
                                                        <div class="min-w-175px">
                                                            <span class="badge badge-light text-muted">Tipe
                                                                Transaksi</span>
                                                        </div>
                                                        <div
                                                            class="symbol-group symbol-hover flex-nowrap flex-grow-1 min-w-100px">
                                                            <p>Rp ....</p>
                                                        </div>
                                                        <div class="min-w-125px">
                                                            <span class="badge badge-light-success">Completed</span>
                                                        </div>
                                                    </div>
                                                    <!--end::Record-->
                                                </div>
                                                <!--end::Timeline details-->
                                            </div>
                                            <!--end::Timeline content-->
                                        </div>
                                        <!--end::Timeline item-->
                                        <!--begin::Timeline item-->
                                        <div class="timeline-item">
                                            <!--begin::Timeline line-->
                                            <div class="timeline-line"></div>
                                            <!--end::Timeline line-->
                                            <!--begin::Timeline icon-->
                                            <div class="timeline-icon me-4">
                                                <i class="ki-outline ki-flag fs-2 text-gray-500"></i>
                                            </div>
                                            <!--end::Timeline icon-->
                                            <!--begin::Timeline content-->
                                            <div class="timeline-content mb-10 mt-n2">
                                                <!--begin::Timeline heading-->
                                                <div class="overflow-auto pe-3">
                                                    <!--begin::Title-->
                                                    <div class="fs-5 fw-semibold mb-2">Invitation for crafting engaging
                                                        designs that speak human workshop</div>
                                                    <!--end::Title-->
                                                    <!--begin::Description-->
                                                    <div class="d-flex align-items-center mt-1 fs-6">
                                                        <!--begin::Info-->
                                                        <div class="text-muted me-2 fs-7">Sent at 4:23 PM by</div>
                                                        <!--end::Info-->
                                                        <!--begin::User-->
                                                        <div class="symbol symbol-circle symbol-25px"
                                                            data-bs-toggle="tooltip" data-bs-boundary="window"
                                                            data-bs-placement="top" aria-label="Alan Nilson"
                                                            data-bs-original-title="Alan Nilson" data-kt-initialized="1">
                                                            <img src="assets/media/avatars/300-1.jpg" alt="img">
                                                        </div>
                                                        <!--end::User-->
                                                    </div>
                                                    <!--end::Description-->
                                                </div>
                                                <!--end::Timeline heading-->
                                            </div>
                                            <!--end::Timeline content-->
                                        </div>
                                        <!--end::Timeline item-->
                                    </div>
                                    <!--end::Timeline-->
                                </div>
                                <!--end::Tab panel-->
                                <!--begin::Tab panel-->
                                <div id="kt_activity_week" class="card-body p-0 tab-pane fade" role="tabpanel"
                                    aria-labelledby="kt_activity_week_tab">
                                    <div class="card-body pt-0">
                                        <!--begin::Table-->
                                        <div class="table-responsive">
                                            <table id="datatable_simpanan"
                                                class="table table-striped table-row-bordered gy-5 gs-7">
                                                <thead>
                                                    <tr class="fw-semibold fs-6 text-gray-800">
                                                        <th class="min-w-85px">Tahun</th>
                                                        <th class="min-w-150px">Januari</th>
                                                        <th class="min-w-150px">Februari</th>
                                                        <th class="min-w-150px">Maret</th>
                                                        <th class="min-w-150px">April</th>
                                                        <th class="min-w-150px">Mei</th>
                                                        <th class="min-w-150px">Juni</th>
                                                        <th class="min-w-150px">Juli</th>
                                                        <th class="min-w-150px">Agustus</th>
                                                        <th class="min-w-150px">September</th>
                                                        <th class="min-w-150px">Oktober</th>
                                                        <th class="min-w-150px">November</th>
                                                        <th class="min-w-150px">Desember</th>
                                                        <th class="min-w-150px">Total saat ini</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>2024</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 5.000.000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2023</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 100.000</td>
                                                        <td>Rp 5.000.000</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--end::Table-->
                                    </div>
                                </div>
                                <!--end::Tab panel-->
                                <!--begin::Tab panel-->
                                <div id="kt_activity_month" class="card-body p-0 tab-pane fade" role="tabpanel"
                                    aria-labelledby="kt_activity_month_tab">
                                    <!--begin::Timeline-->
                                    <div class="timeline  timeline-border-dashed">
                                        <form action="">
                                            <div class="mb-10">
                                                <label for="password" class="required form-label">Password</label>
                                                <input type="password" class="form-control form-control-solid"
                                                    placeholder="Password lama" />
                                            </div>

                                            <div class="mb-10">
                                                <label for="newPassword" class="required form-label">Password
                                                    baru</label>
                                                <input type="password" class="form-control form-control-solid"
                                                    placeholder="Password baru" />
                                            </div>
                                            <div class="mb-10">
                                                <label for="confirm_newPassword" class="required form-label">Konfirmasi
                                                    Password baru</label>
                                                <input type="password" class="form-control form-control-solid"
                                                    placeholder="Konfirmasi password baru" />
                                            </div>

                                            <button type="button" class="btn btn-sm btn-primary">
                                                Simpan
                                            </button>
                                        </form>
                                    </div>
                                    <!--end::Timeline-->
                                </div>
                                <!--end::Tab panel-->
                            </div>
                            <!--end::Tab Content-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Timeline-->
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
                    <span class="text-muted fw-semibold me-1">2024©</span>
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
    <script src="{{ asset('assets/js/custom/pages/user-profile/general.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <script>
        $("#datatable_simpanan").DataTable({
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
                left: 1
            }
        });
    </script>
@stop
