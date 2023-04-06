@extends('backend.layouts.blank')

@section('content')
<div class="authentication">    
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <form class="card auth_form" method="POST" action="{{ route('register') }}">
                @csrf
                    <div class="header">
                        @if(dsld_get_setting('dashboard_logo') > 0)
                            <img src="{{ dsld_uploaded_asset(dsld_get_setting('dashboard_logo')) }}"  alt="{{ dsld_upload_file_title(dsld_get_setting('dashboard_logo')) }}" class="logo">
                        @else
                            <img class="logo" src="{{ dsld_static_asset('backend/assets/images/logo.svg') }}" alt="">
                        @endif
                        <h5>{{ dsld_translation('Sign Up') }}</h5>
                        <span>{{ dsld_translation('Register a new membership') }}</span>
                    </div>
                    <div class="body">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="name" placeholder="{{ dsld_translation('Username') }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" name="email" placeholder="{{ dsld_translation('Enter Email') }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                            </div>
                        </div>                        
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password" placeholder="{{ dsld_translation('Password') }}" required>
                            <div class="input-group-append">                                
                                <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                            </div>                            
                        </div>                       
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="{{ dsld_translation('Confirm Password') }}" required>
                            <div class="input-group-append">                                
                                <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                            </div>                            
                        </div>
                        <!-- <div class="checkbox">
                            <input id="remember_me" name="" type="checkbox">
                            <label for="remember_me">{{ dsld_translation('I read and agree to the') }} <a href="javascript:void(0);">terms of usage</a></label>
                        </div> -->
                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">{{ dsld_translation('SIGN UP') }}</button>
                        <div class="signin_with mt-3">
                            <a class="link" href="{{ route('login') }}">{{ dsld_translation('You already have a membership') }}?</a>
                        </div>
                    </div>
                </form>
                <div class="copyright text-center">
                    @php $str = dsld_get_setting('dashboard_copyright'); @endphp
                    <?php echo htmlspecialchars_decode($str); ?>
                    <!-- &copy;
                    <script>document.write(new Date().getFullYear())</script>,
                    <span>{{ dsld_translation('Designed by') }} <a href="{{ route('home') }}" target="_blank">{{ dsld_get_setting('website_title') }}</a></span>
                  -->
                  </div>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    @if(dsld_get_setting('dashboard_registration_background') > 0)
                        <img src="{{ dsld_uploaded_asset(dsld_get_setting('dashboard_registration_background')) }}"  alt="{{ dsld_upload_file_title(dsld_get_setting('dashboard_registration_background')) }}" class="page_banner_icon">
                    @else
                        <img src="{{ dsld_static_asset('backend/assets/images/signup.svg') }}" alt="Sign Up" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection