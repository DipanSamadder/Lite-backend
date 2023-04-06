@extends('backend.layouts.app')

{{-- Header section--}}
@section('header')

@endsection

{{-- Content section--}}
@section('content')

    <!-- Basic Validation -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
                <div class="header">
                    <h2><strong>Dashboard</strong> Setting</h2>
                </div>
                <div class="body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs p-0 mb-3 nav-tabs-success" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home_with_icon_title"> <i class="zmdi zmdi-home"></i> SITE INFO </a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile_with_icon_title"><i class="zmdi zmdi-settings"></i> SETTINGS </a></li>
                    </ul>
                    
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane in active" id="home_with_icon_title">
                            <form id="form_validation" action="{{ route('business.setting.update') }}" class="update_form" method="post"  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="hidden" name="types[]" id="types" value="dashboard_title">
                                            <input type="text" class="form-control" placeholder="Title" name="dashboard_title"  id="dashboard_title" value="{{ dsld_get_setting('dashboard_title') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Copyright</label>
                                            <input type="hidden" name="types[]" id="types" value="dashboard_copyright">
                                            <input type="text" class="form-control" placeholder="Copyright" name="dashboard_copyright"  id="dashboard_copyright" value="{{ dsld_get_setting('dashboard_copyright') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="form-label">Logo</label>
                                            <input type="hidden" name="types[]" id="types" value="dashboard_logo">
                                            <select class="form-control show-tick ms select2" name="dashboard_logo" id="dashboard_logo">
                                                <option value="">-- Please select --</option>
                                                @foreach(App\Models\Upload::where('user_id', Auth::user()->id)->where('type', 'image')->get() as $key => $value)
                                                    <option value="{{ $value->id }}" @if(dsld_get_setting('dashboard_logo') == $value->id) selected @endif>({{ $value->id }}) - {{ $value->file_title}} </option>
                                                @endforeach
                                            </select>
                                            @if(dsld_get_setting('dashboard_logo') > 0)
                                            <div class="image mt-2">
                                                <img src="{{ dsld_uploaded_asset(dsld_get_setting('dashboard_logo')) }}"  alt="{{ dsld_upload_file_title(dsld_get_setting('dashboard_logo')) }}" class="page_banner_icon">
                                            </div> 
                                            @endif                                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="form-label">Fav Icon</label>
                                            <input type="hidden" name="types[]" id="types" value="dashboard_fav_icon">
                                            <select class="form-control show-tick ms select2" name="dashboard_fav_icon" id="dashboard_fav_icon">
                                                <option value="">-- Please select --</option>
                                                @foreach(App\Models\Upload::where('user_id', Auth::user()->id)->where('type', 'image')->get() as $key => $value)
                                                    <option value="{{ $value->id }}" @if(dsld_get_setting('dashboard_fav_icon') == $value->id) selected @endif>({{ $value->id }}) - {{ $value->file_title}} </option>
                                                @endforeach
                                            </select>
                                            @if(dsld_get_setting('dashboard_fav_icon') > 0)
                                            <div class="image mt-2">
                                                <img src="{{ dsld_uploaded_asset(dsld_get_setting('dashboard_fav_icon')) }}"  alt="{{ dsld_upload_file_title(dsld_get_setting('dashboard_fav_icon')) }}" class="page_banner_icon">
                                            </div> 
                                            @endif                                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="form-label">Loader Icon</label>
                                            <input type="hidden" name="types[]" id="types" value="dashboard_loader_icon">
                                            <select class="form-control show-tick ms select2" name="dashboard_loader_icon" id="dashboard_loader_icon">
                                                <option value="">-- Please select --</option>
                                                @foreach(App\Models\Upload::where('user_id', Auth::user()->id)->where('type', 'image')->get() as $key => $value)
                                                    <option value="{{ $value->id }}" @if(dsld_get_setting('dashboard_loader_icon') == $value->id) selected @endif>({{ $value->id }}) - {{ $value->file_title}} </option>
                                                @endforeach
                                            </select>
                                            @if(dsld_get_setting('dashboard_loader_icon') > 0)
                                            <div class="image mt-2">
                                                <img src="{{ dsld_uploaded_asset(dsld_get_setting('dashboard_loader_icon')) }}"  alt="{{ dsld_upload_file_title(dsld_get_setting('dashboard_loader_icon')) }}" class="page_banner_icon">
                                            </div> 
                                            @endif                                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="form-label">Login Background</label>
                                            <input type="hidden" name="types[]" id="types" value="dashboard_login_background">
                                            <select class="form-control show-tick ms select2" name="dashboard_login_background" id="dashboard_login_background">
                                                <option value="">-- Please select --</option>
                                                @foreach(App\Models\Upload::where('user_id', Auth::user()->id)->where('type', 'image')->get() as $key => $value)
                                                    <option value="{{ $value->id }}" @if(dsld_get_setting('dashboard_login_background') == $value->id) selected @endif>({{ $value->id }}) - {{ $value->file_title}} </option>
                                                @endforeach
                                            </select>
                                            @if(dsld_get_setting('dashboard_login_background') > 0)
                                            <div class="image mt-2">
                                                <img src="{{ dsld_uploaded_asset(dsld_get_setting('dashboard_login_background')) }}"  alt="{{ dsld_upload_file_title(dsld_get_setting('dashboard_login_background')) }}" class="page_banner_icon">
                                            </div> 
                                            @endif                                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="form-label">Registration Background</label>
                                            <input type="hidden" name="types[]" id="types" value="dashboard_registration_background">
                                            <select class="form-control show-tick ms select2" name="dashboard_registration_background" id="dashboard_registration_background">
                                                <option value="">-- Please select --</option>
                                                @foreach(App\Models\Upload::where('user_id', Auth::user()->id)->where('type', 'image')->get() as $key => $value)
                                                    <option value="{{ $value->id }}" @if(dsld_get_setting('dashboard_registration_background') == $value->id) selected @endif>({{ $value->id }}) - {{ $value->file_title}} </option>
                                                @endforeach
                                            </select>
                                            @if(dsld_get_setting('dashboard_registration_background') > 0)
                                            <div class="image mt-2">
                                                <img src="{{ dsld_uploaded_asset(dsld_get_setting('dashboard_registration_background')) }}"  alt="{{ dsld_upload_file_title(dsld_get_setting('dashboard_registration_background')) }}" class="page_banner_icon">
                                            </div> 
                                            @endif                                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="form-label">Registration Background</label>
                                            <input type="hidden" name="types[]" id="types" value="dashboard_registration_background">
                                            <select class="form-control show-tick ms select2" name="dashboard_registration_background" id="dashboard_registration_background">
                                                <option value="">-- Please select --</option>
                                                @foreach(App\Models\Upload::where('user_id', Auth::user()->id)->where('type', 'image')->get() as $key => $value)
                                                    <option value="{{ $value->id }}" @if(dsld_get_setting('dashboard_registration_background') == $value->id) selected @endif>({{ $value->id }}) - {{ $value->file_title}} </option>
                                                @endforeach
                                            </select>
                                            @if(dsld_get_setting('dashboard_registration_background') > 0)
                                            <div class="image mt-2">
                                                <img src="{{ dsld_uploaded_asset(dsld_get_setting('dashboard_registration_background')) }}"  alt="{{ dsld_upload_file_title(dsld_get_setting('dashboard_registration_background')) }}" class="page_banner_icon">
                                            </div> 
                                            @endif                                                            
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="swal-button-container">
                                            <button class="btn btn-raised btn-success btn-round waves-effect dsld-btn-loader" type="submit">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile_with_icon_title">
                            <form id="form_validation" action="{{ route('business.setting.update') }}" class="update_form" method="post"  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="">
                                            <h6>THEME OPTION</h6>
                                            <div class="form-group">
                                                <input type="hidden" name="types[]" id="types" value="dashboard_theme_color">
                                                <div class="radio inlineblock m-r-20">
                                                    <input type="radio" name="dashboard_theme_color" id="light" class="with-gap" value="light" @if(dsld_get_setting('dashboard_theme_color') == 'light') checked="" @endif>
                                                    <label for="light">Light</label>
                                                </div>                                
                                                <div class="radio inlineblock">
                                                    <input type="radio" name="dashboard_theme_color" id="dark" class="with-gap" value="dark"  @if(dsld_get_setting('dashboard_theme_color') == 'dark') checked="" @endif>
                                                    <label for="dark">Dark</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="theme_color_skin">
                                            <h6>COLOR SKINS</h6>
                                            <div class="form-group">
                                                <input type="hidden" name="types[]" id="types" value="dashboard_base_color">
                                                <div class="radio inlineblock m-r-20">
                                                    <input type="radio" name="dashboard_base_color" id="purple" class="with-gap" value="purple" @if(dsld_get_setting('dashboard_base_color') == 'purple') checked="" @endif>
                                                    <label for="purple"><div class="purple"> Purple</div> </label>
                                                </div> 
                                                <div class="radio inlineblock m-r-20">
                                                    <input type="radio" name="dashboard_base_color" id="blue" class="with-gap" value="blue" @if(dsld_get_setting('dashboard_base_color') == 'blue') checked="" @endif>
                                                    <label for="blue"><div class="blue"> Blue</div> </label>
                                                </div>
                                                <div class="radio inlineblock m-r-20">
                                                    <input type="radio" name="dashboard_base_color" id="cyan" class="with-gap" value="cyan" @if(dsld_get_setting('dashboard_base_color') == 'cyan') checked="" @endif>
                                                    <label for="cyan"><div class="cyan"> Cyan</div> </label>
                                                </div>
                                                <div class="radio inlineblock m-r-20">
                                                    <input type="radio" name="dashboard_base_color" id="green" class="with-gap" value="green" @if(dsld_get_setting('dashboard_base_color') == 'green') checked="" @endif>
                                                    <label for="green"><div class="green"> Green</div> </label>
                                                </div>
                                                <div class="radio inlineblock m-r-20">
                                                    <input type="radio" name="dashboard_base_color" id="orange" class="with-gap" value="orange" @if(dsld_get_setting('dashboard_base_color') == 'orange') checked="" @endif>
                                                    <label for="orange"><div class="orange"> Orange</div> </label>
                                                </div>
                                                <div class="radio inlineblock m-r-20">
                                                    <input type="radio" name="dashboard_base_color" id="blush" class="with-gap" value="blush" @if(dsld_get_setting('dashboard_base_color') == 'blush') checked="" @endif>
                                                    <label for="blush"><div class="blush"> Blush</div> </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="">
                                            <h6>Support SETTINGS</h6>
                                            <div class="form-group">
                                                <input type="hidden" name="types[]" id="types" value="dashboard_rtl_version">
                                                <div class="checkbox">
                                                    <input id="dashboard_rtl" type="checkbox" value="rtl" @if(dsld_get_setting('dashboard_rtl_version') == 'rtl') checked="" @endif>
                                                    <label for="dashboard_rtl">RTL Version</label>
                                                    <input  name="dashboard_rtl_version" id="dashboard_rtl_version" type="hidden" @if(dsld_get_setting('dashboard_rtl_version') == 'rtl') value="rtl" @else value="null" @endif>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="swal-button-container">
                                            <button class="btn btn-raised btn-success btn-round waves-effect dsld-btn-loader" type="submit">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
          
@endsection

{{-- Footer section--}}
@section('footer')

<!-- Jquery Core Js --> 
<script src="{{ dsld_static_asset('backend/assets/plugins/jquery-validation/jquery.validate.js') }}"></script> 
<script src="{{ dsld_static_asset('backend/assets/plugins/jquery-steps/jquery.steps.js') }}"></script> 
<script src="{{ dsld_static_asset('backend/assets/js/pages/forms/form-validation.js') }}"></script>
<script>
// $(document).ready(function(){
//     $('.update_form').on('submit', function(event){
//     event.preventDefault();
//         alert($('.update_form').serialize());
//         $('#dsld-btn-loader').addClass('btnloading');
//        DSLDAjaxSubmit("{{ route('business.setting.update') }}", $('.update_form').serialize(), "POST", ".btnloading");
//     });
// });

   
</script>
<script>

$(document).ready(function(){
        $('.update_form').on('submit', function(event){
        event.preventDefault();
            $('.dsld-btn-loader').addClass('btnloading');
            var Loader = ".btnloading";
            DSLDButtonLoader(Loader, "start");
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                cache : false,
                data: $(this).serialize(),
                success: function(data) {
                    DSLDButtonLoader(Loader, "");
                    dsldFlashNotification(data['status'], data['message']);
                    if(data['status'] =='success'){
                        location.reload();
                    }
                    
                }
            });
        });
    });
   $('#dashboard_rtl').on('click', function(){
        if (!$(this).is(":checked")) {
            $('#dashboard_rtl_version').val('null');
        }else{
            $('#dashboard_rtl_version').val('rtl');
        }
   });

</script>
@endsection