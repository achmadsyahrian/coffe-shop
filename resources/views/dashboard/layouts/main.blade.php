<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $outlet->name }}</title>
    <link rel="icon" href="{{asset('favicon.png')}}" type="image/png">
    <link rel="stylesheet" href="{{ asset('p_dashboard/css/styles.min.css') }}" />

    {{-- Trix Editor (Description) --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Body Wrapper -->
    <div class="page-wrapper d-flex flex-column flex-grow-1" id="main-wrapper" data-layout="vertical"
        data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('dashboard.layouts.inc.sidebar')
        <!-- Sidebar End -->

        <!-- Main wrapper -->
        <div class="body-wrapper d-flex flex-column flex-grow-1">
            <!-- Header Start -->
            @include('dashboard.layouts.inc.header')
            <!-- Header End -->

            <div class="container-fluid flex-grow-1">
                @yield('container')
            </div>

            <!-- Footer -->
            @include('dashboard.layouts.inc.footer')
        </div>
    </div>
</body>

<!-- Konten lainnya -->

</body>
<script src="{{ asset('p_dashboard/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('p_dashboard/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('p_dashboard/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('p_dashboard/js/app.min.js') }}"></script>
<script src="{{ asset('p_dashboard/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('p_dashboard/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('p_dashboard/js/dashboard.js') }}"></script>
{{-- Font Awesome --}}
<script src="https://kit.fontawesome.com/5d3ac04a7f.js" crossorigin="anonymous"></script>
{{-- Sweet Alerts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('p_dashboard/js/my.js') }}"></script>
</body>

</html>
