@extends('backend.layouts.app')

{{-- Header section--}}
@section('header')
<link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/sweetalert/sweetalert.css') }}"/>
@endsection

{{-- Content section--}}
@section('content')

    <!-- Basic Validation -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Footer</strong> Setting</h2>
                    <!-- <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else</a></li>
                            </ul>
                        </li>
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul> -->
                </div>
                <div class="body">
                    <form action="javascript:void(0)" id="form_validation" class="update_form" method="POST"  enctype="multipart/form-data">
                        <div class="form-group form-float">
                            <label>Dashboard Title</label>
                            <input type="hidden" name="types[]" value="dashboard_title">
                            <input s="text" class="form-control" placeholder="Dashboard Title" name="dashboard_title" value="{{ dsld_get_setting('dashboard_title') }}" required>
                        </div>
                      
                        <div class="swal-button-container">
                            <button class="btn btn-raised btn-primary waves-effect dsld-btn-loader" type="submit" onclick="update_form()">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
          
@endsection

{{-- Footer section--}}
@section('footer')

<!-- Jquery Core Js --> 
<script src="{{ dsld_static_asset('backend/assets/plugins/jquery-validation/jquery.validate.js') }}"></script> 
<script src="{{ dsld_static_asset('backend/assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ dsld_static_asset('backend/assets/plugins/jquery-steps/jquery.steps.js') }}"></script> 
<script src="{{ dsld_static_asset('backend/assets/js/pages/forms/form-validation.js') }}"></script>
<script src="{{ dsld_static_asset('backend/assets/js/pages/dsld_custom_js.js') }}"></script>

@include('backend.inc.custom_js')

<script>

    function update_form(){

        $(this).addClass('btnloading');
        var parameters =  "_token={{ csrf_token() }}&"+$('.update_form').serialize();
        DSLDAjaxSubmit("{{ route('business.setting.update') }}", parameters, "POST", ".btnloading");

    }
   
</script>
@endsection