<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="{{asset('vendor/ad/img/apple-icon.png')}}">
        <link rel="icon" type="image/png" href="{{asset('vendor/ad/img/favicon.png')}}">
        <title>ГРИБ-FREE | Реклама</title>
        <!-- Fonts and icons -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="{{asset('vendor/ad/css/nucleo-icons.css')}}" rel="stylesheet" />
        <link href="{{asset('vendor/ad/css/nucleo-svg.css')}}" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="{{asset('vendor/ad/css/nucleo-svg.css')}}" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="{{asset('vendor/ad/css/soft-ui-dashboard.css')}}" rel="stylesheet" />
        <link href="{{asset('vendor/ad/css/toastr.min.css')}}" rel="stylesheet">
</head>

    <body class="g-sidenav-show bg-gray-100">
        @yield('sidebar')

        <div class="main-content position-relative bg-gray-100 min-vh-100 max-height-vh-100">
            @include('adsection.profile::layout.navbar')
            @yield('content')
            {{-- @include('adsection.profile::layout.footer') --}}
        </div>

        <!-- Core JS Files -->
        <script src="{{asset('vendor/ad/js/core/popper.min.js')}}"></script>
        <script src="{{asset('vendor/ad/js/core/bootstrap.min.js')}}"></script>
        <script src="{{asset('vendor/ad/js/plugins/perfect-scrollbar.min.js')}}"></script>
        <script src="{{asset('vendor/ad/js/plugins/smooth-scrollbar.min.js')}}"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{asset('vendor/ad/js/soft-ui-dashboard.min.js')}}?v=1.0.6"></script>

        <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>
        <script src="//code.jquery.com/jquery.min.js"></script>
        <script src="{{asset('vendor/ad/js/toastr.min.js')}}"></script>
        @include('adsection.profile::components.toasts')
    </body>
</html>
