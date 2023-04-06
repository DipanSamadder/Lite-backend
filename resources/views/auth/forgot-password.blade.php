@extends('backend.layouts.blank')

@section('content')

<div class="authentication">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <form class="card auth_form" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="header">
                        @if(dsld_get_setting('dashboard_logo') > 0)
                            <img src="{{ dsld_uploaded_asset(dsld_get_setting('dashboard_logo')) }}"  alt="{{ dsld_upload_file_title(dsld_get_setting('dashboard_logo')) }}" class="logo">
                        @else
                            <img class="logo" src="{{ dsld_static_asset('backend/assets/images/logo.svg') }}" alt="">
                        @endif
                        <h5>{{ dsld_translation('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</h5>
                    </div> 
                    <div class="body">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" name="email"  placeholder="{{ dsld_translation('email') }}" required autofocus>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">{{ dsld_translation('Submit') }}</button>                        
                        <!-- <div class="signin_with mt-3">
                            <p class="mb-0">or Sign Up using</p>
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round facebook"><i class="zmdi zmdi-facebook"></i></button>
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round twitter"><i class="zmdi zmdi-twitter"></i></button>
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round google"><i class="zmdi zmdi-google-plus"></i></button>
                        </div> -->
                        <div class="signin_with mt-3">
                            <a class="link" href="{{ route('login') }}">{{ dsld_translation('Sign In') }}?</a>
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
                    @if(dsld_get_setting('dashboard_login_background') > 0)
                        <img src="{{ dsld_uploaded_asset(dsld_get_setting('dashboard_login_background')) }}"  alt="{{ dsld_upload_file_title(dsld_get_setting('dashboard_login_background')) }}" class="page_banner_icon">
                    @else
                        <img src="{{ dsld_static_asset('backend/assets/images/signin.svg') }}" alt="Sign In"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

