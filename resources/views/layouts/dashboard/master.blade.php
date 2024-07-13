<!DOCTYPE html>
<html lang="en">

<head>
    <title>Metronic - The World's #1 Selling Tailwind CSS & Bootstrap Admin Template by KeenThemes</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @yield('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
</head>

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-header="true"
    data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
    class="app-default">
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            <div id="kt_app_header" class="app-header d-flex d-lg-none border-bottom">
                <!--begin::Header container-->
                <div class="app-container container-fluid d-flex flex-stack" id="kt_app_header_container">
                    <!--begin::Sidebar toggle-->
                    <button class="btn btn-icon btn-sm btn-active-color-primary ms-n2"
                        id="kt_app_sidebar_mobile_toggle">
                        <i class="ki-outline ki-abstract-14 fs-2"></i>
                    </button>
                    <!--end::Sidebar toggle-->
                    <!--begin::Logo-->
                    <a href="index.html">
                        <img alt="Logo" src="assets/media/logos/demo59.svg" class="h-30px theme-light-show" />
                        <img alt="Logo" src="assets/media/logos/demo59-dark.svg" class="h-30px theme-dark-show" />
                    </a>
                    <!--end::Logo-->
                    <!--begin::Sidebar panel toggle-->
                    <button class="btn btn-icon btn-sm btn-active-color-primary me-n2" id="kt_app_aside_mobile_toggle">
                        <i class="ki-outline ki-menu fs-2"></i>
                    </button>
                    <!--end::Sidebar panel toggle-->
                </div>
                <!--end::Header container-->
            </div>
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Sidebar-->
                @include('layouts.includes.dashboard._sidebar')
                <!--end::Sidebar-->

                <!--begin::Main-->
                @yield('content')
                <!--end:::Main-->

            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>

    @include('layouts.includes.dashboard._drawers')
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-outline ki-arrow-up"></i>
    </div>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    @yield('scripts')
</body>

</html>
