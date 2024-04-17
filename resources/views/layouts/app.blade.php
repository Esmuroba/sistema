<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-menu-fixed" dir="ltr"
    data-theme="theme-default" data-assets-path="../assets/" data-framework="Laravel"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-brand1.jpg') }}" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <title>Esmuroba | @yield('title')</title>
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('vendor/fonts/boxicons.css') }}" />
    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- Ajax --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/62d333b9ff.js" crossorigin="anonymous"></script>
    {{-- ChartJS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- ApexCharts --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('vendor/css/card-analytics.css') }}">
    <link rel="stylesheet" href="{{ asset('css/demo.css') }}" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/libs/apex-charts/apex-charts.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/libs/tagify/select2.css') }}" /> --}}
    <!-- Page CSS -->
    <!-- Stepper -->
    <link rel="stylesheet" href="{{ asset('vendor/libs/bs-stepper/bs-stepper.css') }}">

    <!-- Helpers -->
    <script src="{{ asset('vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('js/config.js') }}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('layouts.sections.sidebar') {{-- Menú lateral --}}
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('layouts.sections.navbar') {{-- Navbar (Sección y Apartado de perfil) --}}
                
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content') {{-- Contenido de las vistas --}}
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('layouts.sections.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->

            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    {{-- Main --}}
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('vendor/js/menu.js') }}"></script>
    <script src="{{ asset('vendor/js/forms-selects.js') }}"></script>
    <!-- endbuild -->
    <!-- Vendors JS -->
    {{-- <script src="{{ asset('vendor/libs/apex-charts/apexcharts.js') }}"></script> --}}
    <!-- Main JS -->
    <script src="{{ asset('js/main.js') }}"></script>
    {{-- <script src="{{ asset('js/forms-selects.js') }}"></script> --}}
    <script src="{{ asset('js/forms-tagify.js') }}"></script>
    {{-- <script src="{{ asset('js/forms-typeahead.js') }}"></script> --}}
    <!-- Page JS -->
    {{-- <script src="{{ asset('js/dashboards-analytics.js') }}"></script> --}}
    <!-- Place this tag in your head or just before your close body tag. -->
    <script ript async defer src="https://buttons.github.io/buttons.js"></script>
    {{-- Wizard --}}
    {{-- <script src="{{ asset('js/form-wizard-numbered.js') }}"></script>
    <script src="{{ asset('js/form-wizard-validation.js') }}"></script> --}}
    {{-- Stepper --}}
    <script src="{{ asset('vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
</body>

</html>
