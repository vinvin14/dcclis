<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Styles -->
    <link href="{{asset('includes/sbadmin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&display=swap" rel="stylesheet">

    {{-- <link href="{{asset('includes/sbadmin/css/sb-admin-2.min.css')}}" rel="stylesheet"> --}}
    <link href="{{asset('themes/sbadminb5/css/styles.css')}}" rel="stylesheet">
    <style>
        * {
            font-size: 15px;
        }
        .cursor {
            cursor: pointer;
            opacity: .8;
        }
        .cursor:hover {
            opacity: 1;
        }
        body {
            background-color: #F0F1F3;
            font-family: 'Poppins', sans-serif;
            font-size: 15px !important;
        }
    </style>
    @yield('styles')
</head>
<body id="page-top" class="sb-nav-fixed @yield('body_class')">
<div id="app">
        @yield('content')
</div>
<script src="{{ asset('includes/js/jquery.3.6.js') }}"></script>
<script src="{{ asset('themes/sbadminb5/js/boostrap5.1.3.js') }}"></script>
<script src="{{ asset('themes/sbadminb5/js/scripts.js') }}"></script>
<script src="{{ asset('themes/sbadminb5/js/chart.min.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> --}}
<script src="{{ asset('themes/sbadminb5/assets/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('themes/sbadminb5/assets/demo/chart-bar-demo.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script> --}}
<script src="{{ asset('themes/sbadminb5/js/simple-datatables-latest.js') }}"></script>
<script src="{{ asset('themes/sbadminb5/js/datatables-simple-demo.js') }}"></script>
@yield('scripts')

</body>
</html>
