<!doctype html>
<html class="no-js " lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Multipurpose backend laravel9') }}</title>
        <!-- Favicon-->
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <!-- Custom Css -->
        <link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/bootstrap/css/bootstrap.min.css') }} ">
        <link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/css/style.min.css') }}">
        @yield('header')
    </head>

    <body class="theme-blush">

        @yield('content')

        <!-- Jquery Core Js -->
        <script src="{{ dsld_static_asset('backend/assets/bundles/libscripts.bundle.js') }}"></script>
        <script src="{{ dsld_static_asset('backend/assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js --> 
        @yield('footer')
    </body>
</html>