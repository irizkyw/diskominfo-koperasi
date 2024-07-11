@extends('layouts.dashboard.master') 
@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">

<link
  href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}"
  rel="stylesheet"
  type="text/css"
/>
@endsection 

@section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
  <!--begin::Content wrapper-->
  <div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-10 mb-3">
      <!--begin::Toolbar container-->
      <div
        id="kt_app_toolbar_container"
        class="app-container container-fluid d-flex align-items-stretch"
      >
        <!--begin::Toolbar wrapper-->
        <div
          class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100"
        >
          <!--begin::Page title-->
          <div
            class="page-title d-flex flex-column justify-content-center gap-1 me-3"
          >
            <!--begin::Title-->
            <h1
              class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0"
            >
              Anggota
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul
              class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0"
            >
              <!--begin::Item-->
              <li class="breadcrumb-item text-muted">
                <a href="index.html" class="text-muted text-hover-primary"
                  >Dashboard</a
                >
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
                <i
                  class="ki-outline ki-magnifier fs-3 position-absolute ms-5"
                ></i>
                <input
                  type="text"
                  data-kt-customer-table-filter="search"
                  class="form-control form-control-solid w-250px ps-13"
                  placeholder="Cari Anggota"
                />
              </div>
              <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
              <!--begin::Toolbar-->
              <div
                class="d-flex justify-content-end"
                data-kt-customer-table-toolbar="base"
              >
                <!--begin::Filter-->
                <div class="w-150px me-3">
                  <!--begin::Select2-->
                  <select
                    class="form-select form-select-solid"
                    data-control="select2"
                    data-hide-search="true"
                    data-placeholder="Status"
                    data-kt-ecommerce-order-filter="status"
                  >
                    <option></option>
                    <option value="all">Semua</option>
                    <option value="Anggota">Anggota</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                  </select>
                  <!--end::Select2-->
                </div>
                <!--end::Filter-->
                <!--begin::Export-->
                <button
                  type="button"
                  class="btn btn-light-primary me-3"
                  data-bs-toggle="modal"
                  data-bs-target="#kt_customers_export_modal"
                >
                  <i class="ki-outline ki-exit-up fs-2"></i>Export
                </button>
                <!--end::Export-->
                <!--begin::Add customer-->
                <button
                  type="button"
                  class="btn btn-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#kt_modal_add_users"
                >
                  Tambahkan Anggota
                </button>
                <!--end::Add customer-->
              </div>
              <!--end::Toolbar-->
              <!--begin::Group actions-->
              <div
                class="d-flex justify-content-end align-items-center d-none"
                data-kt-customer-table-toolbar="selected"
              >
                <div class="fw-bold me-5">
                  <span
                    class="me-2"
                    data-kt-customer-table-select="selected_count"
                  ></span
                  >Selected
                </div>
                <button
                  type="button"
                  class="btn btn-danger"
                  data-kt-customer-table-select="delete_selected"
                >
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
            <table
              class="table align-middle table-row-dashed fs-6 gy-5"
              id="table_anggota"
            >
              <thead>
                <tr
                  class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0"
                >
                  <th class="w-10px pe-2">
                    <div
                      class="form-check form-check-sm form-check-custom form-check-solid me-3"
                    >
                      <input
                        class="form-check-input"
                        type="checkbox"
                        data-kt-check="true"
                        data-kt-check-target="#table_anggota .form-check-input"
                        value="1"
                      />
                    </div>
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
                @foreach($users as $data)
                <tr>
                  <td>
                    <div
                      class="form-check form-check-sm form-check-custom form-check-solid"
                    >
                      <input
                        class="form-check-input"
                        type="checkbox"
                        value="1"
                      />
                    </div>
                  </td>
                  <td>
                    <a
                      href="apps/ecommerce/customers/details.html"
                      class="text-gray-800 text-hover-primary mb-1"
                      >{{ str_pad($data->num_member, 3, '0', STR_PAD_LEFT) }}</a
                    >
                  </td>
                  <td>
                    <a href="#" class="text-gray-600 text-hover-primary mb-1"
                      >{{$data->name}}</a
                    >
                  </td>
                  
                  <td>
                    @if($data->status_active)
                        <div class="badge badge-light-success">Anggota</div>
                    @else
                        <div class="badge badge-light-danger">Tidak Aktif</div>
                    @endif
                </td>
                
                  <td>
                    {{$data->role->name}}
                  </td>

                  <td>{{ $data->created_at->format('d M Y, h:i a') }}</td>
                  <td class="text-end">
                    <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-pen"></i>
                        </span>
                    </a>
                    <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-trash"></i>
                        </span>
                    </a>
                    <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-user"></i>
                        </span>
                    </a>
                </td>

                </tr>
                @endforeach
              </tbody>
              <!--end::Table body-->
            </table>
            <!--end::Table-->
          </div>
          <!--end::Card body-->
        </div>
        <!--end::Card-->


        <!--begin::Modals Create-->
        <div
          class="modal fade"
          id="kt_modal_add_users"
          tabindex="-1"
          aria-hidden="true"
        >
          <!--begin::Modal dialog-->
          <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
              <!--begin::Form-->
              <form
                class="form"
                action="{{route('users.create')}}"
                id="kt_modal_add_users_form"
                data-kt-redirect="{{route('users.index')}}"
              >
              @csrf
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_users_header">
                  <!--begin::Modal title-->
                  <h2 class="fw-bold">Tambahkan Anggota</h2>
                  <!--end::Modal title-->
                  <!--begin::Close-->
                  <div
                    id="kt_modal_add_users_close"
                    class="btn btn-icon btn-sm btn-active-icon-primary"
                  >
                    <i class="ki-outline ki-cross fs-1"></i>
                  </div>
                  <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                  <!--begin::Scroll-->
                  <div
                    class="scroll-y me-n7 pe-7"
                    id="kt_modal_add_users_scroll"
                    data-kt-scroll="true"
                    data-kt-scroll-activate="{default: false, lg: true}"
                    data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#kt_modal_add_users_header"
                    data-kt-scroll-wrappers="#kt_modal_add_users_scroll"
                    data-kt-scroll-offset="300px"
                  >
                  <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">Nomor anggota</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input
                          type="text"
                          class="form-control form-control-solid"
                          placeholder="Nomor Anggota"
                          name="num_member"
                          id="num_member"
                          disabled
                        />
                        <!--end::Input-->
                    </div>
                    <!-- endL::input group -->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class="required fs-6 fw-semibold mb-2">Nama Lengkap</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <input
                        type="text"
                        class="form-control form-control-solid"
                        placeholder="Nama Anggota"
                        name="name"
                      />
                      <!--end::Input-->
                    </div>
                      <!--begin::Input group-->
                      <div class="d-flex flex-column mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                          <span class="required">Golongan</span>
                          <span
                            class="ms-1"
                            data-bs-toggle="tooltip"
                            title="Biaya yang harus dibayar setiap bulannya"
                          >
                            <i
                              class="ki-outline ki-information-5 text-gray-500 fs-6"
                            ></i>
                          </span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select
                          name="group"
                          aria-label="Pilih Golongan"
                          data-control="select2"
                          data-placeholder="Pilih Golongan"
                          data-dropdown-parent="#kt_modal_add_users"
                          class="form-select form-select-solid fw-bold"
                        >
                          <option value="">Pilih Golongan</option>
                          @foreach($groups as $data)
                          <option value="{{$data->id}}">{{$data->name}}</option>
                          @endforeach
                        </select>
                        <!--end::Input-->
                      </div>
                      <!--end::Input group-->
                      <!--begin::Input group-->
                      <div class="fv-row mb-7">
                      <label class="fs-6 fw-semibold mb-2">Simpanan Wajib</label>
                      <input
                        type="number"
                        class="form-control form-control-solid"
                        placeholder="Simpanan Wajib Pertama kali daftar (Opsional)"
                        name="mandatory_savings"
                      />
                      <!--end::Input-->
                    </div>

                    <div class="fv-row mb-7">
                      <label class="fs-6 fw-semibold mb-2">Simpanan Sukarela</label>
                      <input
                        type="number"
                        class="form-control form-control-solid"
                        placeholder="Simpanan Sukarela (Opsional)"
                        name="voluntary_savings"
                      />
                      <!--end::Input-->
                    </div>
                      <!--begin::Input group-->
                      <!--begin::Input group-->
                      <div class="d-flex flex-column mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                          <span class="required">Posisi</span>
                          <span
                            class="ms-1"
                            data-bs-toggle="tooltip"
                            title="Akses akun"
                          >
                            <i
                              class="ki-outline ki-information-5 text-gray-500 fs-6"
                            ></i>
                          </span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select
                          name="roles"
                          aria-label="Select a Role"
                          data-control="select2"
                          data-placeholder="Pilih Posisi"
                          data-dropdown-parent="#kt_modal_add_users"
                          class="form-select form-select-solid fw-bold"
                        >
                          <option value="">Pilih Posisi</option>
                          @foreach($roles as $data)
                          <option value="{{$data->id}}">{{$data->name}}</option>
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
                  <button
                    type="reset"
                    id="kt_modal_add_users_cancel"
                    class="btn btn-light me-3"
                  >
                    Buang
                  </button>
                  <!--end::Button-->
                  <!--begin::Button-->
                  <button
                    type="submit"
                    id="kt_modal_add_users_submit"
                    class="btn btn-primary"
                  >
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress"
                      >Please wait...
                      <span
                        class="spinner-border spinner-border-sm align-middle ms-2"
                      ></span
                    ></span>
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
        <div
          class="modal fade"
          id="kt_customers_export_modal"
          tabindex="-1"
          aria-hidden="true"
        >
          <!--begin::Modal dialog-->
          <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
              <!--begin::Modal header-->
              <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Export Anggota</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div
                  id="kt_customers_export_close"
                  class="btn btn-icon btn-sm btn-active-icon-primary"
                >
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
                    <label class="fs-5 fw-semibold form-label mb-5"
                      >Pilih Format Ekspor:</label
                    >
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select
                      data-control="select2"
                      data-placeholder="Select a format"
                      data-hide-search="true"
                      name="format"
                      class="form-select form-select-solid"
                    >
                      <option value="excell">Excel</option>
                      <option value="pdf">PDF</option>
                      <option value="cvs">CVS</option>
                      <option value="zip">ZIP</option>
                    </select>
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="fs-5 fw-semibold form-label mb-5"
                      >Pilih Filter Ekspor:</label
                    >
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select
                      data-control="select2"
                      data-placeholder="Select a format"
                      data-hide-search="true"
                      name="format"
                      class="form-select form-select-solid"
                    >
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
                    <label class="fs-5 fw-semibold form-label mb-5"
                      >Daftar Informasi:</label
                    >
                    <!--end::Label-->
                    <!--begin::Radio group-->
                    <div class="d-flex flex-column">
                      <!--begin::Radio button-->
                      <label
                        class="form-check form-check-custom form-check-sm form-check-solid mb-3"
                      >
                        <input
                          class="form-check-input"
                          type="checkbox"
                          value="1"
                          checked="checked"
                          name="payment_type"
                        />
                        <span class="form-check-label text-gray-600 fw-semibold"
                          >Semua</span
                        >
                      </label>
                      <!--end::Radio button-->
                       <!--begin::Radio button-->
                      <label
                        class="form-check form-check-custom form-check-sm form-check-solid mb-3"
                      >
                        <input
                          class="form-check-input"
                          type="checkbox"
                          value="3"
                          name="payment_type"
                        />
                        <span class="form-check-label text-gray-600 fw-semibold"
                          >Nomor & Nama Anggota</span
                        >
                      </label>
                      <!--end::Radio button-->
                       <!--begin::Radio button-->
                      <label
                        class="form-check form-check-custom form-check-sm form-check-solid mb-3"
                      >
                        <input
                          class="form-check-input"
                          type="checkbox"
                          value="2"
                          name="payment_type"
                        />
                        <span class="form-check-label text-gray-600 fw-semibold"
                          >Username</span
                        >
                      </label>
                      <!--end::Radio button-->
                      <!--begin::Radio button-->
                      <label
                        class="form-check form-check-custom form-check-sm form-check-solid mb-3"
                      >
                        <input
                          class="form-check-input"
                          type="checkbox"
                          value="2"
                          name="payment_type"
                        />
                        <span class="form-check-label text-gray-600 fw-semibold"
                          >Status Aktif</span
                        >
                      </label>
                      <!--end::Radio button-->
                    </div>
                    <!--end::Input group-->
                  </div>
                  <!--end::Row-->
                  <!--begin::Actions-->
                  <div class="text-center">
                    <button
                      type="reset"
                      id="kt_customers_export_cancel"
                      class="btn btn-light me-3"
                    >
                      Buang
                    </button>
                    <button
                      type="submit"
                      id="kt_customers_export_submit"
                      class="btn btn-primary"
                    >
                      <span class="indicator-label">Submit</span>
                      <span class="indicator-progress"
                        >Please wait...
                        <span
                          class="spinner-border spinner-border-sm align-middle ms-2"
                        ></span
                      ></span>
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
        <div
          class="modal fade"
          id="kt_modal_edit_users"
          tabindex="-1"
          aria-hidden="true"
        >
          <!--begin::Modal dialog-->
          <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
              <!--begin::Form-->
              <form
                class="form"
                action="{{route('users.create')}}"
                id="kt_modal_edit_users_form"
                data-kt-redirect="{{route('users.index')}}"
              >
              @csrf
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_edit_users_header">
                  <!--begin::Modal title-->
                  <h2 class="fw-bold">Merubah Data Anggota</h2>
                  <!--end::Modal title-->
                  <!--begin::Close-->
                  <div
                    id="kt_modal_edit_users_close"
                    class="btn btn-icon btn-sm btn-active-icon-primary"
                  >
                    <i class="ki-outline ki-cross fs-1"></i>
                  </div>
                  <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                  <!--begin::Scroll-->
                  <div
                    class="scroll-y me-n7 pe-7"
                    id="kt_modal_edit_users_scroll"
                    data-kt-scroll="true"
                    data-kt-scroll-activate="{default: false, lg: true}"
                    data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#kt_modal_edit_users_header"
                    data-kt-scroll-wrappers="#kt_modal_edit_users_scroll"
                    data-kt-scroll-offset="300px"
                  >
                  <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">Nomor anggota</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input
                          type="text"
                          class="form-control form-control-solid"
                          placeholder="Nomor Anggota"
                          name="num_member"
                          id="num_member"
                          disabled
                        />
                        <!--end::Input-->
                    </div>
                    <!-- endL::input group -->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class="required fs-6 fw-semibold mb-2">Nama Lengkap</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <input
                        type="text"
                        class="form-control form-control-solid"
                        placeholder="Nama Anggota"
                        name="name"
                      />
                      <!--end::Input-->
                    </div>
                      <!--begin::Input group-->
                      <div class="d-flex flex-column mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                          <span class="required">Golongan</span>
                          <span
                            class="ms-1"
                            data-bs-toggle="tooltip"
                            title="Biaya yang harus dibayar setiap bulannya"
                          >
                            <i
                              class="ki-outline ki-information-5 text-gray-500 fs-6"
                            ></i>
                          </span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select
                          name="group"
                          aria-label="Pilih Golongan"
                          data-control="select2"
                          data-placeholder="Pilih Golongan"
                          data-dropdown-parent="#kt_modal_edit_users"
                          class="form-select form-select-solid fw-bold"
                        >
                          <option value="">Pilih Golongan</option>
                          @foreach($groups as $data)
                          <option value="{{$data->id}}">{{$data->name}}</option>
                          @endforeach
                        </select>
                        <!--end::Input-->
                      </div>
                      <!--end::Input group-->
                      <!--begin::Input group-->
                      <div class="fv-row mb-7">
                      <label class="fs-6 fw-semibold mb-2">Simpanan Wajib</label>
                      <input
                        type="number"
                        class="form-control form-control-solid"
                        placeholder="Simpanan Wajib Pertama kali daftar (Opsional)"
                        name="mandatory_savings"
                      />
                      <!--end::Input-->
                    </div>

                    <div class="fv-row mb-7">
                      <label class="fs-6 fw-semibold mb-2">Simpanan Sukarela</label>
                      <input
                        type="number"
                        class="form-control form-control-solid"
                        placeholder="Simpanan Sukarela (Opsional)"
                        name="voluntary_savings"
                      />
                      <!--end::Input-->
                    </div>
                      <!--begin::Input group-->
                      <!--begin::Input group-->
                      <div class="d-flex flex-column mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                          <span class="required">Posisi</span>
                          <span
                            class="ms-1"
                            data-bs-toggle="tooltip"
                            title="Akses akun"
                          >
                            <i
                              class="ki-outline ki-information-5 text-gray-500 fs-6"
                            ></i>
                          </span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select
                          name="roles"
                          aria-label="Select a Role"
                          data-control="select2"
                          data-placeholder="Pilih Posisi"
                          data-dropdown-parent="#kt_modal_edit_users"
                          class="form-select form-select-solid fw-bold"
                        >
                          <option value="">Pilih Posisi</option>
                          @foreach($roles as $data)
                          <option value="{{$data->id}}">{{$data->name}}</option>
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
                  <button
                    type="reset"
                    id="kt_modal_edit_users_cancel"
                    class="btn btn-light me-3"
                  >
                    Buang
                  </button>
                  <!--end::Button-->
                  <!--begin::Button-->
                  <button
                    type="submit"
                    id="kt_modal_edit_users_submit"
                    class="btn btn-primary"
                  >
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress"
                      >Please wait...
                      <span
                        class="spinner-border spinner-border-sm align-middle ms-2"
                      ></span
                    ></span>
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
        <div
          class="modal fade"
          id="kt_customers_export_modal"
          tabindex="-1"
          aria-hidden="true"
        >
          <!--begin::Modal dialog-->
          <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
              <!--begin::Modal header-->
              <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Export Anggota</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div
                  id="kt_customers_export_close"
                  class="btn btn-icon btn-sm btn-active-icon-primary"
                >
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
                    <label class="fs-5 fw-semibold form-label mb-5"
                      >Pilih Format Ekspor:</label
                    >
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select
                      data-control="select2"
                      data-placeholder="Select a format"
                      data-hide-search="true"
                      name="format"
                      class="form-select form-select-solid"
                    >
                      <option value="excell">Excel</option>
                      <option value="pdf">PDF</option>
                      <option value="cvs">CVS</option>
                      <option value="zip">ZIP</option>
                    </select>
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="fs-5 fw-semibold form-label mb-5"
                      >Pilih Filter Ekspor:</label
                    >
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select
                      data-control="select2"
                      data-placeholder="Select a format"
                      data-hide-search="true"
                      name="format"
                      class="form-select form-select-solid"
                    >
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
                    <label class="fs-5 fw-semibold form-label mb-5"
                      >Daftar Informasi:</label
                    >
                    <!--end::Label-->
                    <!--begin::Radio group-->
                    <div class="d-flex flex-column">
                      <!--begin::Radio button-->
                      <label
                        class="form-check form-check-custom form-check-sm form-check-solid mb-3"
                      >
                        <input
                          class="form-check-input"
                          type="checkbox"
                          value="1"
                          checked="checked"
                          name="payment_type"
                        />
                        <span class="form-check-label text-gray-600 fw-semibold"
                          >Semua</span
                        >
                      </label>
                      <!--end::Radio button-->
                       <!--begin::Radio button-->
                      <label
                        class="form-check form-check-custom form-check-sm form-check-solid mb-3"
                      >
                        <input
                          class="form-check-input"
                          type="checkbox"
                          value="3"
                          name="payment_type"
                        />
                        <span class="form-check-label text-gray-600 fw-semibold"
                          >Nama Anggota</span
                        >
                      </label>
                      <!--end::Radio button-->
                      <!--begin::Radio button-->
                      <label
                        class="form-check form-check-custom form-check-sm form-check-solid mb-3"
                      >
                        <input
                          class="form-check-input"
                          type="checkbox"
                          value="2"
                          name="payment_type"
                        />
                        <span class="form-check-label text-gray-600 fw-semibold"
                          >Username</span
                        >
                      </label>
                      <!--end::Radio button-->
                    </div>
                    <!--end::Input group-->
                  </div>
                  <!--end::Row-->
                  <!--begin::Actions-->
                  <div class="text-center">
                    <button
                      type="reset"
                      id="kt_customers_export_cancel"
                      class="btn btn-light me-3"
                    >
                      Buang
                    </button>
                    <button
                      type="submit"
                      id="kt_customers_export_submit"
                      class="btn btn-primary"
                    >
                      <span class="indicator-label">Submit</span>
                      <span class="indicator-progress"
                        >Please wait...
                        <span
                          class="spinner-border spinner-border-sm align-middle ms-2"
                        ></span
                      ></span>
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
    <div
      class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3"
    >
      <!--begin::Copyright-->
      <div class="text-gray-900 order-2 order-md-1">
        <span class="text-muted fw-semibold me-1">2024&copy;</span>
        <a
          href="https://keenthemes.com"
          target="_blank"
          class="text-gray-800 text-hover-primary"
          >Keenthemes</a
        >
      </div>
      <!--end::Copyright-->
      <!--begin::Menu-->
      <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
        <li class="menu-item">
          <a
            href="https://keenthemes.com"
            target="_blank"
            class="menu-link px-2"
            >About</a
          >
        </li>
        <li class="menu-item">
          <a
            href="https://devs.keenthemes.com"
            target="_blank"
            class="menu-link px-2"
            >Support</a
          >
        </li>
        <li class="menu-item">
          <a
            href="https://1.envato.market/EA4JP"
            target="_blank"
            class="menu-link px-2"
            >Purchase</a
          >
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
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/js/custom/apps/ecommerce/customers/listing/listing.js')}}"></script>
<!-- <script src="{{asset('assets/js/custom/apps/ecommerce/customers/listing/add.js')}}"></script> -->

<!-- ADD USER -->
<script>
  var KTModalCustomersAdd = (function () {
      var t, e, o, n, r, i;
      return {
          init: function () {
              (i = new bootstrap.Modal(document.querySelector("#kt_modal_add_users"))),
              (r = document.querySelector("#kt_modal_add_users_form")),
              (t = r.querySelector("#kt_modal_add_users_submit")),
              (e = r.querySelector("#kt_modal_add_users_cancel")),
              (o = r.querySelector("#kt_modal_add_users_close")),
              (n = FormValidation.formValidation(r, {
                  fields: {
                      name: {
                          validators: {
                              notEmpty: {
                                  message: "Nama Anggota is required",
                              },
                          },
                      },
                      num_member: {
                          validators: {
                              notEmpty: {
                                  message: "Nomor Anggota is required",
                              },
                          },
                      },
                      roles: {
                          validators: {
                              notEmpty: {
                                  message: "Posisi Anggota is required",
                              },
                          },
                      },
                  },
                  plugins: {
                      trigger: new FormValidation.plugins.Trigger(),
                      bootstrap: new FormValidation.plugins.Bootstrap5({
                          rowSelector: ".fv-row",
                          eleInvalidClass: "",
                          eleValidClass: "",
                      }),
                  },
              })),
              $(r.querySelector('[name="country"]')).on("change", function () {
                  n.revalidateField("country");
              }),
              t.addEventListener("click", function (e) {
                  e.preventDefault();
                  n && n.validate().then(function (e) {
                      console.log("validated!");
                      if ("Valid" == e) {
                          t.setAttribute("data-kt-indicator", "on");
                          t.disabled = !0;

                          // Enable num_member input
                          document.getElementById('num_member').disabled = false;

                          // Collect form data
                          var formData = new FormData(r);

                          fetch(r.action, {
                              method: 'POST',
                              headers: {
                                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                              },
                              body: formData
                          })
                          .then(response => response.json())
                          .then(data => {
                            console.log(data);
                              t.removeAttribute("data-kt-indicator");
                              Swal.fire({
                                  text: data.message,
                                  icon: "success",
                                  buttonsStyling: !1,
                                  confirmButtonText: "OK mengerti!",
                                  customClass: {
                                      confirmButton: "btn btn-primary",
                                  },
                              }).then(function (e) {
                                  if (e.isConfirmed) {
                                    r.reset();
                                    i.hide();
                                    t.disabled = !1;

                                    const tbody = document.querySelector('#table_anggota tbody');
                                    const newRow = document.createElement('tr');
                                    const numMemberFormatted = String(data.user.num_member).padStart(3, '0')
                                    const statusBadge = data.user.status_active ? 
                                        '<div class="badge badge-light-success">Aktif</div>' : 
                                        '<div class="badge badge-light-danger">Tidak Aktif</div>';

                                    const date = new Date(data.user.created_at);
                                    const options = { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true };
                                    const dateFormatted = new Intl.DateTimeFormat('en-US', options).format(date);
                                    newRow.innerHTML = `
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1">
                                            </div>
                                        </td>
                                        <td>
                                            <a href="apps/ecommerce/customers/details.html" class="text-gray-800 text-hover-primary mb-1">${numMemberFormatted}</a>
                                        </td>
                                        <td>${data.user.name}</td>
                                        <td>${statusBadge}</td>
                                        <td>${data.user.role.name}</td>
                                        <td>${dateFormatted}</td>
                                        <td class="text-end">
                                          <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                              <span class="svg-icon svg-icon-2">
                                                  <i class="fas fa-pen"></i>
                                              </span>
                                          </a>
                                          <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                              <span class="svg-icon svg-icon-2">
                                                  <i class="fas fa-trash"></i>
                                              </span>
                                          </a>
                                          <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                              <span class="svg-icon svg-icon-2">
                                                  <i class="fas fa-user"></i>
                                              </span>
                                          </a>
                                      </td>
                                    `;
                                    tbody.prepend(newRow);
                                }

                              });
                          })
                          .catch(error => {
                              Swal.fire({
                                  text: "Sorry, looks like there are some errors detected, please try again.",
                                  icon: "error",
                                  buttonsStyling: !1,
                                  confirmButtonText: "OK mengerti!",
                                  customClass: {
                                      confirmButton: "btn btn-primary",
                                  },
                              });
                              t.disabled = !1;
                          });
                      } else {
                          Swal.fire({
                              text: "Sorry, looks like there are some errors detected, please try again.",
                              icon: "error",
                              buttonsStyling: !1,
                              confirmButtonText: "OK mengerti!",
                              customClass: {
                                  confirmButton: "btn btn-primary",
                              },
                          });
                      }
                  });
              }),
              e.addEventListener("click", function (t) {
                  t.preventDefault(),
                  Swal.fire({
                      text: "Apakah Anda yakin ingin membatalkan?",
                      icon: "warning",
                      showCancelButton: !0,
                      buttonsStyling: !1,
                      confirmButtonText: "Ya, Batalkan!",
                      cancelButtonText: "Tidak",
                      customClass: {
                          confirmButton: "btn btn-primary",
                          cancelButton: "btn btn-active-light",
                      },
                  }).then(function (t) {
                      t.value
                          ? (r.reset(), i.hide())
                          : "cancel" === t.dismiss &&
                          Swal.fire({
                              text: "Your form has not been cancelled!.",
                              icon: "error",
                              buttonsStyling: !1,
                              confirmButtonText: "OK mengerti!",
                              customClass: {
                                  confirmButton: "btn btn-primary",
                              },
                          });
                  });
              }),
              o.addEventListener("click", function (t) {
                  t.preventDefault(),
                  Swal.fire({
                      text: "Apakah Anda yakin ingin membatalkan?",
                      icon: "warning",
                      showCancelButton: !0,
                      buttonsStyling: !1,
                      confirmButtonText: "Ya, Batalkan!",
                      cancelButtonText: "Tidak",
                      customClass: {
                          confirmButton: "btn btn-primary",
                          cancelButton: "btn btn-active-light",
                      },
                  }).then(function (t) {
                      t.value
                          ? (r.reset(), i.hide())
                          : "cancel" === t.dismiss &&
                          Swal.fire({
                              text: "Your form has not been cancelled!.",
                              icon: "error",
                              buttonsStyling: !1,
                              confirmButtonText: "OK mengerti!",
                              customClass: {
                                  confirmButton: "btn btn-primary",
                              },
                          });
                  });
              });
          },
      };
  })();
  KTUtil.onDOMContentLoaded(function () {
      KTModalCustomersAdd.init();
  });

</script>
<!-- END ADD USER -->

<!-- EDIT USER -->
<script>
  var KTModalCustomersEdit = (function () {
      var t, e, o, n, r, i;
      return {
          init: function () {
              (i = new bootstrap.Modal(document.querySelector("#kt_modal_edit_users"))),
              (r = document.querySelector("#kt_modal_edit_users_form")),
              (t = r.querySelector("#kt_modal_edit_users_submit")),
              (e = r.querySelector("#kt_modal_edit_users_cancel")),
              (o = r.querySelector("#kt_modal_edit_users_close")),
              (n = FormValidation.formValidation(r, {
                  fields: {
                      name: {
                          validators: {
                              notEmpty: {
                                  message: "Nama Anggota is required",
                              },
                          },
                      },
                      num_member: {
                          validators: {
                              notEmpty: {
                                  message: "Nomor Anggota is required",
                              },
                          },
                      },
                      roles: {
                          validators: {
                              notEmpty: {
                                  message: "Posisi Anggota is required",
                              },
                          },
                      },
                  },
                  plugins: {
                      trigger: new FormValidation.plugins.Trigger(),
                      bootstrap: new FormValidation.plugins.Bootstrap5({
                          rowSelector: ".fv-row",
                          eleInvalidClass: "",
                          eleValidClass: "",
                      }),
                  },
              })),
              $(r.querySelector('[name="country"]')).on("change", function () {
                  n.revalidateField("country");
              }),
              t.addEventListener("click", function (e) {
                  e.preventDefault();
                  n && n.validate().then(function (e) {
                      console.log("validated!");
                      if ("Valid" == e) {
                          t.setAttribute("data-kt-indicator", "on");
                          t.disabled = !0;

                          // Enable num_member input
                          document.getElementById('num_member').disabled = false;

                          // Collect form data
                          var formData = new FormData(r);

                          fetch(r.action, {
                              method: 'POST',
                              headers: {
                                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                              },
                              body: formData
                          })
                          .then(response => response.json())
                          .then(data => {
                              console.log(data);
                              t.removeAttribute("data-kt-indicator");
                              Swal.fire({
                                  text: data.message,
                                  icon: "success",
                                  buttonsStyling: !1,
                                  confirmButtonText: "OK mengerti!",
                                  customClass: {
                                      confirmButton: "btn btn-primary",
                                  },
                              }).then(function (e) {
                                  if (e.isConfirmed) {
                                      r.reset();
                                      i.hide();
                                      t.disabled = !1;

                                      const tbody = document.querySelector('#table_anggota tbody');
                                      const newRow = document.createElement('tr');
                                      const statusBadge = data.user.status_active ?  '<div class="badge badge-light-success">Anggota</div>' :  '<div class="badge badge-light-danger">Tidak Aktif</div>';
                                      newRow.innerHTML = `
                                          <td>
                                              <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                  <input class="form-check-input" type="checkbox" value="1">
                                              </div>
                                          </td>
                                          <td>
                                              <a href="apps/ecommerce/customers/details.html" class="text-gray-800 text-hover-primary mb-1">${data.user.num_member}</a>
                                          </td>
                                          <td>${data.user.name}</td>
                                          <td>${data.user.role ? data.user.role.name : '-'}</td>
                                           <td>${statusBadge}</td>
                                          <td>${new Date(data.user.created_at).toLocaleDateString()}</td>
                                          <td class="text-end">
                                              <!-- Actions buttons -->
                                              <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                  <!--begin::Svg Icon | path: icons/duotone/Communication/Write.svg-->
                                                  <span class="svg-icon svg-icon-2">
                                                      <i class="fas fa-pen"></i>
                                                  </span>
                                                  <!--end::Svg Icon-->
                                              </a>
                                              <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                  <!--begin::Svg Icon | path: icons/duotone/General/Trash.svg-->
                                                  <span class="svg-icon svg-icon-2">
                                                      <i class="fas fa-trash"></i>
                                                  </span>
                                                  <!--end::Svg Icon-->
                                              </a>
                                          </td>
                                      `;
                                      // Insert the new row at the beginning of the tbody
                                      tbody.insertBefore(newRow, tbody.firstChild);
                                  }
                              });
                          })
                          .catch(error => {
                              Swal.fire({
                                  text: "Sorry, looks like there are some errors detected, please try again.",
                                  icon: "error",
                                  buttonsStyling: !1,
                                  confirmButtonText: "OK mengerti!",
                                  customClass: {
                                      confirmButton: "btn btn-primary",
                                  },
                              });
                              t.disabled = !1;
                          });
                      } else {
                          Swal.fire({
                              text: "Sorry, looks like there are some errors detected, please try again.",
                              icon: "error",
                              buttonsStyling: !1,
                              confirmButtonText: "OK mengerti!",
                              customClass: {
                                  confirmButton: "btn btn-primary",
                              },
                          });
                      }
                  });
              }),
              e.addEventListener("click", function (t) {
                  t.preventDefault(),
                  Swal.fire({
                      text: "Apakah Anda yakin ingin membatalkan?",
                      icon: "warning",
                      showCancelButton: !0,
                      buttonsStyling: !1,
                      confirmButtonText: "Ya, Batalkan!",
                      cancelButtonText: "Tidak",
                      customClass: {
                          confirmButton: "btn btn-primary",
                          cancelButton: "btn btn-active-light",
                      },
                  }).then(function (t) {
                      t.value
                          ? (r.reset(), i.hide())
                          : "cancel" === t.dismiss &&
                          Swal.fire({
                              text: "Your form has not been cancelled!.",
                              icon: "error",
                              buttonsStyling: !1,
                              confirmButtonText: "OK mengerti!",
                              customClass: {
                                  confirmButton: "btn btn-primary",
                              },
                          });
                  });
              }),
              o.addEventListener("click", function (t) {
                  t.preventDefault(),
                  Swal.fire({
                      text: "Apakah Anda yakin ingin membatalkan?",
                      icon: "warning",
                      showCancelButton: !0,
                      buttonsStyling: !1,
                      confirmButtonText: "Ya, Batalkan!",
                      cancelButtonText: "Tidak",
                      customClass: {
                          confirmButton: "btn btn-primary",
                          cancelButton: "btn btn-active-light",
                      },
                  }).then(function (t) {
                      t.value
                          ? (r.reset(), i.hide())
                          : "cancel" === t.dismiss &&
                          Swal.fire({
                              text: "Your form has not been cancelled!.",
                              icon: "error",
                              buttonsStyling: !1,
                              confirmButtonText: "OK mengerti!",
                              customClass: {
                                  confirmButton: "btn btn-primary",
                              },
                          });
                  });
              });
          },
      };
  })();
  KTUtil.onDOMContentLoaded(function () {
      KTModalCustomersEdit.init();
  });

</script>
<!-- END EDIT USER -->
<script src="{{asset('assets/js/custom/apps/ecommerce/customers/listing/export.js')}}"></script>
<script src="{{asset('assets/js/widgets.bundle.js')}}"></script>
<script src="{{asset('assets/js/custom/widgets.js')}}"></script>
<script src="{{asset('assets/js/custom/apps/chat/chat.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/create-campaign.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('kt_modal_add_users');
        modal.addEventListener('show.bs.modal', function () {
            fetch("{{route('users.generate_number')}}")
                .then(response => response.json())
                .then(data => {
                    document.getElementById('num_member').value = data.newNumber;
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>
@stop
