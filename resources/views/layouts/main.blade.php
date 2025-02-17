<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $outlet->name }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/nice-select/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/owl-carousel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/owl-carousel/owl.carousel.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        @media print {
            @page {
                size: landscape; /* Jika ingin print dengan orientasi landscape */
                margin: 20mm; /* Menyesuaikan margin jika perlu */
            }
    
            body * {
                visibility: hidden; /* Menyembunyikan semua elemen pada halaman */
            }
    
            .invoice-body,
            .invoice-body * {
                visibility: visible; /* Menampilkan hanya elemen invoice */
            }
    
            /* Mengatur posisi invoice di paling atas */
            .invoice-page {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                width: 100%;
            }
    
            .invoice-total * {
                visibility: visible; /* Pastikan header dan total tampil di print */
            }
            .invoice-header * {
                visibility: visible; /* Pastikan header dan total tampil di print */
            }
    
            /* Menghilangkan tombol print setelah di-print */
            .button-postComment {
                display: none;
            }
    
            /* Menyembunyikan elemen lainnya yang tidak diperlukan */
            .navbar, .footer, .sidebar {
                display: none;
            }
        }
    </style>
    

    {{-- Trix Editor (Description) --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


</head>

<body>
    <!--================ Start Header Menu Area =================-->
    @include('layouts.inc.header')
    <!--================ End Header Menu Area =================-->

    <main class="site-main">
        @yield('container')
    </main>


    <!--================ Start footer Area  =================-->
    @include('layouts.inc.footer')
    <!--================ End footer Area  =================-->



    <script src="{{ asset('vendors/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('vendors/skrollr.min.js') }}"></script> --}}
    <script src="{{ asset('vendors/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendors/nice-select/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('vendors/mail-script.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/5d3ac04a7f.js" crossorigin="anonymous"></script>
    {{-- IndoRegion --}}
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $(function() {
                $("#provinsi").on("change", function() {
                    let namaProvinsi = $("#provinsi").val();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('getKabupaten') }}",
                        data: {
                            namaProvinsi: namaProvinsi,
                        },
                        cache: false,

                        success: function(msg) {
                            $("#kabupaten").html(msg);
                            $("#kecamatan").html("");
                        },
                        error: function(data) {
                            console.log("error : ", data);
                        },
                    });
                });
                $("#kabupaten").on("change", function() {
                    let namaKabupaten = $("#kabupaten").val();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('getKecamatan') }}",
                        data: {
                            namaKabupaten: namaKabupaten,
                        },
                        cache: false,

                        success: function(msg) {
                            $("#kecamatan").html(msg);
                        },
                        error: function(data) {
                            console.log("error : ", data);
                        },
                    });
                });
            });
        });
    </script>


</body>

</html>
