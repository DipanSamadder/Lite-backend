<!doctype html>
<html class="no-js " lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @if(isset($page) && !empty($page['title']))
            <title>{{ $page['title'] }}</title>
        @else
            <title>{{ dsld_get_setting('site_title') }}</title>
        @endif
        <link rel="icon" type="image/png" href="{{ dsld_uploaded_asset(dsld_get_setting('dashboard_fav_icon')) }}" />

        <link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css') }}"/>
        <link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/charts-c3/plugin.css') }}"/>
        <link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/sweetalert/sweetalert.css') }}"/>
        <link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/dropify/css/dropify.min.css') }}">
        <link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/morrisjs/morris.min.css') }}" />
        <link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/summernote/dist/summernote.css') }}">
        <link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/bootstrap-select/css/bootstrap-select.css') }}">
        <link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/multi-select/css/multi-select.css') }}">
        <link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/select2/select2.css') }}">
        <!-- Custom Css -->
        <link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/css/style.min.css') }}">
        @yield('header')

        <style>
            .bootstrap-notify-container {
                z-index: 99999 !important;
            }
            .page_banner_icon{width:30px;}


            .purple{color: #6f42c1;}
            .blue{color: #46b6fe;}
            .cyan{color: #5CC5CD; }
            .green{color: #04BE5B;}
            .orange{color: #FF9948;}
            .blush {color: #e47297;}
            .disable_checkbox label::before, .disable_checkbox label::after{border: 1px solid #c30b0b;}
            .lds-ripple {
                display: inline-block;
                position: relative;
                width: 80px;
                height: 80px;
                }
                .lds-ripple div {
                position: absolute;
                border: 4px solid #fff;
                opacity: 1;
                border-radius: 50%;
                animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
                }
                .lds-ripple div:nth-child(2) {
                animation-delay: -0.5s;
                }
                @keyframes lds-ripple {
                0% {
                    top: 36px;
                    left: 36px;
                    width: 0;
                    height: 0;
                    opacity: 0;
                }
                4.9% {
                    top: 36px;
                    left: 36px;
                    width: 0;
                    height: 0;
                    opacity: 0;
                }
                5% {
                    top: 36px;
                    left: 36px;
                    width: 0;
                    height: 0;
                    opacity: 1;
                }
                100% {
                    top: 0px;
                    left: 0px;
                    width: 72px;
                    height: 72px;
                    opacity: 0;
                }
                }
                .full_page_loader{width: 100%;
                    height: 100%;
                    position: fixed;
                    top: 0;
                    background: #2b2b2b69;
                    z-index: 99999999;
                    display: flex;
                    justify-content: center;
                    align-items: center;}
        </style>
    </head>
     
    <body class="
        @if(dsld_get_setting('dashboard_base_color') != '') 
            theme-{{ dsld_get_setting('dashboard_base_color') }}
            @else  theme-blush  @endif 

        @if(dsld_get_setting('dashboard_theme_color') == 'dark') theme-dark  @endif 

        @if(dsld_get_setting('dashboard_rtl_version') == 'rtl') rtl @endif 
        ">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="m-t-30"><img class="zmdi-hc-spin" src="{{ dsld_uploaded_asset(dsld_get_setting('dashboard_loader_icon')) }}" width="48" height="48" alt="Aero"></div>
                <p>Please wait...</p>
            </div>
        </div>

        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>

        <!-- Main Search -->
        <div id="search">
            <button id="close" type="button" class="close btn btn-primary btn-icon btn-icon-mini btn-round">x</button>
            <form>
            <input type="search" value="" placeholder="Search..." />
            <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>


        @include('backend.inc.sidebar')
        <section class="content">
            <div class="body_scroll">
                <div class="block-header">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            
                            @if(isset($page) && !empty($page['title']))
                                <h2>{{ $page['title'] }}</h2>
                            @endif
                            <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">                
                            <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                                
                        </div>
                    </div>
                </div>
                <!-- Main Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>                    
            </div>
        </section> 

        @include('backend.modals.add_media')
        <div class="full_page_loader" style="display:none"><div class="lds-ripple"><div></div><div></div></div></div>
        <!-- Jquery Core Js --> 
        <script src="{{ dsld_static_asset('backend/assets/bundles/libscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) --> 
        <script src="{{ dsld_static_asset('backend/assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- slimscroll, waves Scripts Plugin Js -->
        <script src="{{ dsld_static_asset('backend/assets/bundles/jvectormap.bundle.js') }}"></script> <!-- JVectorMap Plugin Js -->
        <script src="{{ dsld_static_asset('backend/assets/bundles/sparkline.bundle.js') }}"></script> <!-- Sparkline Plugin Js -->
        <script src="{{ dsld_static_asset('backend/assets/bundles/c3.bundle.js') }}"></script>
        <script src="{{ dsld_static_asset('backend/assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
        <script src="{{ dsld_static_asset('backend/assets/plugins/dropify/js/dropify.min.js') }}"></script>
        <script src="{{ dsld_static_asset('backend/assets/js/pages/forms/dropify.js') }}"></script>
        <script src="{{ dsld_static_asset('backend/assets/bundles/mainscripts.bundle.js') }}"></script>
        <script src="{{ dsld_static_asset('backend/assets/plugins/bootstrap-notify/bootstrap-notify.js') }}"></script>
        <script src="{{ dsld_static_asset('backend/assets/plugins/select2/select2.min.js') }}"></script>
        <script src="{{ dsld_static_asset('backend/assets/plugins/dropzone/dropzone.js') }}"></script>
        <script src="{{ dsld_static_asset('backend/assets/plugins/summernote/dist/summernote.js') }}"></script>
        <script src="{{ dsld_static_asset('backend/assets/js/pages/index.js') }}"></script>
        <script src="{{ dsld_static_asset('backend/assets/js/pages/dsld_custom_js.js') }}"></script>
        @include('backend.inc.custom_js')
        @yield('footer')
     
    </body>
</html>