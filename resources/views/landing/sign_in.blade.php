@extends('layouts.master')
@section('root')
@if($errors->has('error'))
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
        @endif
        <div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Page bg image-->
			<style>body { background-image: url('{{asset("assets/media/auth/bg10.jpeg")}}'); } [data-bs-theme="dark"] body { background-image: url('{{asset("assets/media/auth/bg10-dark.jpeg")}}'); }</style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Aside-->
				<div class="d-flex flex-lg-row-fluid">
					<!--begin::Content-->
                        <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                            <!--begin::Image-->
                            <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{asset('assets/media/auth/agency.png')}}" alt="" />
                            <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{asset('assets/media/auth/agency-dark.png')}}" alt="" />
                            <!--end::Image-->
                            <!--begin::Title-->
                            <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">KODIJA <br> (Koperasi Diskominfo Jawabarat)</h1>
                            <!--end::Title-->
                            <!--begin::Text-->
                            <div class="text-gray-600 fs-base text-center fw-semibold">Koperasi simpan pinjam menyediakan layanan keuangan seperti pinjaman dan simpanan kepada anggotanya, <br> dengan bertujuan untuk meningkatkan kesejahteraan ekonomi melalui prinsip kebersamaan.</div>
                            <!--end::Text-->
                        </div>
					<!--end::Content-->
				</div>
				<!--begin::Aside-->
				<!--begin::Body-->
				<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
					<!--begin::Wrapper-->
					<div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
						<!--begin::Content-->
						<div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
							<!--begin::Wrapper-->
							<div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
								<!--begin::Form-->
								<form class="form w-100" id="kt_sign_in_form" action="{{route('login.submit')}}" method="POST">
                                    @csrf
									<div class="text-center mb-11">
										<h1 class="text-gray-900 fw-bolder mb-3">Login</h1>
										<div class="text-gray-500 fw-semibold fs-6"></div>
									</div>
									<div class="fv-row mb-8">
										<input type="text" placeholder="Username anggota" name="username" autocomplete="off" class="form-control bg-transparent" />
									</div>
									<div class="fv-row mb-3">
										<input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
									</div>
									<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
										<div></div>
										<!-- <a href="https://web.whatsapp.com" class="link-primary">Lupa Password ?</a> -->
									</div>
									<div class="d-grid mb-10">
										<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
											<span class="indicator-label">Masuk</span>
											<span class="indicator-progress">Please wait...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
										</button>
									</div>
									<!-- <div class="text-gray-500 text-center fw-semibold fs-6">Ingin menjadi Anggota?
									<a href="https://web.whatsapp.com/" class="link-primary">Daftar</a></div> -->
								</form>
							</div>
                                <div class="d-flex justify-content-end">
                                </div>

							<!--end::Footer-->
						</div>
						<!--end::Content-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
@endsection

@section('scripts')
<script src="{{asset('assets/js/custom/authentication/sign-in/general.js')}}"></script>
@stop
