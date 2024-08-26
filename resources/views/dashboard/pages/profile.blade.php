@extends('layouts.master')
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
                <div id="kt_app_content_container" class="app-container container-xxl" {!! Auth::user()->role->name !== 'Administrator' ? 'style="padding: 0px!important;"' : '' !!}>
                    @if ($event)
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">
                                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                    </symbol>
                                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                    </symbol>
                                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                    </symbol>
                                </svg>

                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                    aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                Pengumuman!
                            </h4>
                            <p>
                                <br>
                                Agenda: {{ $event->nama_event }} <br> <br>
                                Deskripsi Agenda: <br>
                                {{ $event->deskripsi_event }}
                            </p>
                            <hr>
                            <p class="mb-0">Dilaksanakan sebentar lagi pada tanggal:
                                {{ $event->tanggal_event->format('d-m-Y') }}</p>
                        </div>
                    @endif
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
                                    <div class="flex-grow-1">
                                        <!--begin::Title-->
                                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                            <!--begin::User-->
                                            <div class="d-flex flex-column">
                                                <!--begin::Name-->
                                                <div class="d-flex align-items-center mb-2">
                                                    @if (Auth::user()->isAdmin() || Auth::user()->id == $User->id)
                                                        <a href="#"
                                                            class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $User->name }}</a>
                                                    @else
                                                        <span
                                                            class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $User->name }}</span>
                                                    @endif
                                                    @if (Auth::user()->isAdmin())
                                                        <a href="#"><i
                                                                class="ki-outline ki-verify fs-1 text-primary"></i></a>
                                                    @endif
                                                </div>
                                                <!--end::Name-->
                                                <!--begin::Info-->
                                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                                    <div
                                                        class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                                        <i
                                                            class="ki-outline ki-profile-circle fs-4 me-1"></i>{{ $User->username }}
                                                    </div>

                                                    <div
                                                        class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                                        <i class="ki-outline ki-user-tick fs-4 me-1"></i>Nomor Anggota :
                                                        {{ str_pad($User->num_member, 3, '0', STR_PAD_LEFT) }}
                                                    </div>

                                                    <div
                                                        class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                                        <i class="ki-outline ki-medal-star fs-4 me-1"></i>
                                                        {{ $User->golongan->nama_golongan ?? 'Belum ada golongan' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex my-4">
                                                <!--begin::Menu-->
                                                <div class="me-0">
                                                    @if (!Auth::user()->isAdmin())
                                                        <a href="{{ route('logout') }}"
                                                            class="btn btn-icon btn-color-gray-500 btn-active-color-primary me-3">
                                                            <i class="ki-outline ki-exit-right fs-2"></i>
                                                        </a>
                                                    @endif
                                                    <button
                                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary"
                                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                        <i class="ki-solid ki-dots-horizontal fs-2x"></i>
                                                    </button>
                                                    <!--begin::Menu 3-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                                        data-kt-menu="true">
                                                        @if (Auth::user()->role->name !== 'Administrator')
                                                            <div class="menu-item px-3">
                                                                <div
                                                                    class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                                                    Mode Tampilan </div>
                                                            </div>
                                                            <div class="menu-item px-5"
                                                                data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                                                data-kt-menu-placement="left-start"
                                                                data-kt-menu-offset="-15px, 0">
                                                                <a href="#" class="menu-link p-2">
                                                                    <span class="menu-title position-relative">Mode
                                                                        <span
                                                                            class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                                                            <i
                                                                                class="ki-outline ki-night-day theme-light-show fs-2"></i>
                                                                            <i
                                                                                class="ki-outline ki-moon theme-dark-show fs-2"></i>
                                                                        </span></span>
                                                                </a>
                                                                <!--begin::Menu-->
                                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                                                                    data-kt-menu="true" data-kt-element="theme-mode-menu">
                                                                    <!--begin::Menu item-->
                                                                    <div class="menu-item px-3 my-0">
                                                                        <a href="#" class="menu-link px-3 py-2"
                                                                            data-kt-element="mode" data-kt-value="light">
                                                                            <span class="menu-icon" data-kt-element="icon">
                                                                                <i class="ki-outline ki-night-day fs-2"></i>
                                                                            </span>
                                                                            <span class="menu-title">Light</span>
                                                                        </a>
                                                                    </div>
                                                                    <!--end::Menu item-->
                                                                    <!--begin::Menu item-->
                                                                    <div class="menu-item px-3 my-0">
                                                                        <a href="#" class="menu-link px-3 py-2"
                                                                            data-kt-element="mode" data-kt-value="dark">
                                                                            <span class="menu-icon" data-kt-element="icon">
                                                                                <i class="ki-outline ki-moon fs-2"></i>
                                                                            </span>
                                                                            <span class="menu-title">Dark</span>
                                                                        </a>
                                                                    </div>
                                                                    <!--end::Menu item-->
                                                                    <!--begin::Menu item-->
                                                                    <div class="menu-item px-3 my-0">
                                                                        <a href="#" class="menu-link px-3 py-2"
                                                                            data-kt-element="mode" data-kt-value="system">
                                                                            <span class="menu-icon"
                                                                                data-kt-element="icon">
                                                                                <i class="ki-outline ki-screen fs-2"></i>
                                                                            </span>
                                                                            <span class="menu-title">System</span>
                                                                        </a>
                                                                    </div>
                                                                    <!--end::Menu item-->
                                                                </div>
                                                                <!--end::Menu-->
                                                            </div>
                                                        @endif

                                                        <!--end::Menu item-->
                                                        <!--begin::Heading-->
                                                        <div class="menu-item px-3">
                                                            <div
                                                                class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
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
                                        </div>
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
                                                        {{-- <i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i>
                                                    --}}
                                                        <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                                            data-kt-countup-value="{{ $SimpananAkhir }}"
                                                            data-kt-countup-prefix="Rp" data-kt-initialized="1">
                                                            Rp{{ number_format($SimpananAkhir, 0, ',', '.') }}</div>
                                                    </div>
                                                    <!--end::Number-->
                                                    <!--begin::Label-->
                                                    <div class="fw-semibold fs-6 text-gray-500">Jumlah Simpanan <br>
                                                    </div>
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
                            <!--begin::Toolbar-->
                            <div class="card-toolbar m-0">
                                <!--begin::Tab nav-->
                                <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 fw-bold" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a id="profile_activity_tab"
                                            class="nav-link justify-content-center text-active-gray-800 active"
                                            data-bs-toggle="tab" role="tab" href="#profile_activity"
                                            aria-selected="true">Log Transaksi</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a id="data_simpanan_tab"
                                            class="nav-link justify-content-center text-active-gray-800"
                                            data-bs-toggle="tab" role="tab" href="#data_simpanan"
                                            aria-selected="false" tabindex="-1">Tabel Simpanan</a>
                                    </li>
                                    @if (Auth::user()->id === $User->id || (Auth::user()->role->name !== 'Administrator' && $User->role->name !== 'Member'))
                                        <li class="nav-item" role="presentation">
                                            <a id="settings_tab"
                                                class="nav-link justify-content-center text-active-gray-800"
                                                data-bs-toggle="tab" role="tab" href="#settings"
                                                aria-selected="false" tabindex="-1">Pengaturan</a>
                                        </li>
                                    @endif
                                </ul>
                                <!--end::Tab nav-->
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Card head-->
                        <!--begin::Card body-->
                        <div class="card-body" style="max-height: 50em; overflow-y: scroll;">
                            <!--begin::Tab Content-->
                            <div class="tab-content">
                                <!--begin::Tab panel-->
                                <div id="profile_activity" class="card-body p-0 tab-pane fade active show"
                                    role="tabpanel" aria-labelledby="profile_activity_tab">
                                    <!--begin::Timeline-->
                                    <div class="timeline timeline-border-dashed">
                                        @if ($LogTransaksi->isEmpty())
                                            <div class="timeline-item">
                                                Tidak ada History Transaksi
                                            </div>
                                        @else
                                            @foreach ($LogTransaksi as $data)
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
                                                            <div class="fs-5 fw-semibold mb-2">Transaksi berhasil untuk
                                                                {{ $data->transaction_type }}</div>
                                                            <!--end::Title-->
                                                            <!--begin::Description-->
                                                            <div class="d-flex align-items-center mt-1 fs-6">
                                                                <!--begin::Info-->
                                                                <div class="text-muted me-2 fs-7">
                                                                    Ditambahkan pada
                                                                    {{ $data->created_at->format('d F Y') }}
                                                                </div>

                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Description-->
                                                        </div>
                                                        <!--end::Timeline heading-->
                                                        <!--begin::Timeline details-->
                                                        <div class="overflow-auto pb-5">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-0">
                                                                <div
                                                                    class="fs-5 text-hover-primary fw-semibold w-375px min-w-200px">
                                                                    {{ $data->description }}</div>
                                                                <div class="min-w-175px">
                                                                    <span
                                                                        class="badge badge-light text-muted">{{ $data->transaction_type }}</span>
                                                                </div>
                                                                <div class="min-w-175px">
                                                                    @if ($data->nominal < 0)
                                                                        <span class="badge badge-light-danger">
                                                                            {{ 'Rp' . number_format($data->nominal, 0, ',', '.') }}
                                                                        </span>
                                                                    @elseif ($data->nominal > 0)
                                                                        <span class="badge badge-light-success">
                                                                            {{ 'Rp' . number_format($data->nominal, 0, ',', '.') }}
                                                                        </span>
                                                                    @endif

                                                                </div>

                                                                <div class="d-flex justify-content-end min-w-125px">
                                                                    @if ($data->transaction_type != 'Pinjam' && $data->nominal > 0)
                                                                        <span class="badge badge-light-success">IN</span>
                                                                    @else
                                                                        <span class="badge badge-light-danger">OUT</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <!--end::Record-->
                                                        </div>
                                                        <!--end::Timeline details-->
                                                    </div>
                                                    <!--end::Timeline content-->
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <!--end::Timeline-->
                                </div>
                                <!--end::Tab panel-->
                                <!--begin::Tab panel-->
                                <div id="data_simpanan" class="card-body p-0 tab-pane fade" role="tabpanel"
                                    aria-labelledby="data_simpanan_tab">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Table-->
                                        <table class="table align-middle table-row-dashed fs-6 gy-5"
                                            id="datatable_simpanan">
                                            <thead>
                                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="min-w-75px">Tahun</th>
                                                    <th class="min-w-75px">S.Pokok</th>
                                                    <th class="min-w-75px">S.Sukarela</th>
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
                                                    <th class="min-w-125px">Total</th>
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
                                <!--end::Tab panel-->

                                <!--begin::Tab panel-->
                                <div id="settings" class="card-body p-0 tab-pane fade" role="tabpanel"
                                    aria-labelledby="settings_tab">
                                    <!--begin::Timeline-->
                                    <div class="timeline timeline-border-dashed">
                                        <form id="password-update-form" action="{{ route('profile.updatePassword') }}"
                                            method="POST">
                                            @csrf

                                            <!-- 1 row ada 2 text input -->
                                            <div class="mb-10">
                                                <div class="d-flex flex-wrap">
                                                    <div class="col-md-6">
                                                        <label for="nomor_anggota" class="required form-label">Nomor
                                                            Anggota</label>
                                                        <input type="text" class="form-control form-control-solid me-3"
                                                            name="nomor_anggota" placeholder="Nomor Anggota"
                                                            value="{{ Auth::user()->num_member }}" disabled />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="golongan" class="required form-label">Golongan</label>
                                                        <input type="text" class="form-control form-control-solid ms-3"
                                                            name="golongan" placeholder="Golongan"
                                                            value="{{ Auth::user()->golongan->nama_golongan }}"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="mb-10">
                                                <label for="username" class="required form-label">Username</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    name="username" placeholder="Username"
                                                    value="{{ Auth::user()->username }}" required />
                                            </div>

                                            <div class="mb-10">
                                                <label for="old_password" class="required form-label">Password
                                                    Lama</label>
                                                <input type="password" class="form-control form-control-solid"
                                                    name="old_password" placeholder="Password lama" required />
                                            </div>

                                            <div class="mb-10">
                                                <label for="password" class="required form-label">Password Baru</label>
                                                <input type="password" class="form-control form-control-solid"
                                                    name="password" placeholder="Password baru" required />
                                            </div>

                                            <div class="mb-10">
                                                <label for="password_confirmation" class="required form-label">Konfirmasi
                                                    Password Baru</label>
                                                <input type="password" class="form-control form-control-solid"
                                                    name="password_confirmation" placeholder="Konfirmasi password baru"
                                                    required />
                                            </div>

                                            <button type="button" class="btn btn-sm btn-primary password-update-button">
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
        <div id="kt_app_footer" class="app-footer" {!! Auth::user()->role->name !== 'Administrator' ? 'style="padding: 0 20px;"' : '' !!}>

            <!--begin::Footer container-->
            <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                <!--begin::Copyright-->
                <div class="text-gray-900 order-2 order-md-1">
                    <span class="text-muted fw-semibold me-1">2024©</span>
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
    <script src="{{ asset('assets/js/custom/pages/user-profile/general.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $("#datatable_simpanan").DataTable({
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,
                fixedColumns: {
                    left: 1
                },
                ajax: {
                    url: "{{ route('profile.datatable') }}?user_id={{ $User->id }}",
                    type: "GET",
                    dataSrc: function(json) {
                        return json.data;
                    }
                },
                columns: [{
                        name: 'year',
                        data: 'year'
                    },
                    {
                        name: 'simp_pokok',
                        data: 'simp_pokok'
                    },
                    {
                        name: 'simp_sukarela',
                        data: 'simp_sukarela'
                    },

                    {
                        name: 'january',
                        data: 'january'
                    },
                    {
                        name: 'february',
                        data: 'february'
                    },
                    {
                        name: 'march',
                        data: 'march'
                    },
                    {
                        name: 'april',
                        data: 'april'
                    },
                    {
                        name: 'may',
                        data: 'may'
                    },
                    {
                        name: 'june',
                        data: 'june'
                    },
                    {
                        name: 'july',
                        data: 'july'
                    },
                    {
                        name: 'august',
                        data: 'august'
                    },
                    {
                        name: 'september',
                        data: 'september'
                    },
                    {
                        name: 'october',
                        data: 'october'
                    },
                    {
                        name: 'november',
                        data: 'november'
                    },
                    {
                        name: 'december',
                        data: 'december'
                    },
                    {
                        name: 'total_tabungan',
                        data: 'total_tabungan'
                    }
                ]
            });
        });


        $(document).on("click", '.password-update-button', function(e) {
            e.preventDefault();

            Swal.fire({
                text: "Apakah Anda yakin ingin mengubah password?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Ya, Ubah!",
                cancelButtonText: "Tidak",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                    cancelButton: "btn fw-bold btn-active-light-primary",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#password-update-form').submit();
                }
            });
        });

        @if (session('success'))
            Swal.fire({
                text: "{{ session('success') }}",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                },
            });
        @endif

        @if (session('error'))
            Swal.fire({
                text: "{{ session('error') }}",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                },
            });
        @endif
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlFragment = window.location.hash;
            if (urlFragment) {
                const targetTab = document.querySelector(`a[href="${urlFragment}"]`);

                if (targetTab) {
                    const activeTab = document.querySelector('.nav-link.active');
                    if (activeTab) {
                        activeTab.classList.remove('active');
                    }

                    targetTab.classList.add('active');

                    const activeTabContent = document.querySelector('.tab-pane.active.show');
                    if (activeTabContent) {
                        activeTabContent.classList.remove('active', 'show');
                    }

                    const targetTabContent = document.querySelector(urlFragment);
                    if (targetTabContent) {
                        targetTabContent.classList.add('active', 'show');
                    }
                }
            }
        });
    </script>

    </script>
@stop
