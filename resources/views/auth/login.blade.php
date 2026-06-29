@php
    $settings = \App\Models\Settings::first();
@endphp
<!DOCTYPE html>
<html data-navigation-type="default" data-navbar-horizontal-shape="default" lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>{{$settings->app_name}} | Login</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{asset('vendors/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{asset('vendors/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/js/config.js')}}"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link href="{{asset('vendors/simplebar/simplebar.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="{{asset('assets/css/theme-rtl.min.css')}}" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="{{asset('assets/css/theme.min.css')}}" type="text/css" rel="stylesheet" id="style-default">
    <link href=".{{asset('assets/css/user-rtl.min.css')}}" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="{{asset('assets/css/user.min.css')}}" type="text/css" rel="stylesheet" id="user-style-default">
    <script>
        var phoenixIsRTL = window.config.config.phoenixIsRTL;
        if (phoenixIsRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
</head>


<body>

<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">
    <div class="row vh-100 g-0">
        <div class="col-lg-6 position-relative d-none d-lg-block">
            <div class="bg-holder" style="background-image:url({{asset('img/bg/bg_image.jpg')}});">
            </div>
            <!--/.bg-holder-->

        </div>
        <div class="col-lg-6">
            <div class="row flex-center h-100 g-0 px-4 px-sm-0">
                <div class="col col-sm-6 col-lg-7 col-xl-6">
                    <form action="{{ route('auth.login.post') }}" method="POST" id="loginForm">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <a class="d-flex flex-center text-decoration-none mb-4" href="#">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img src="{{asset('img/app_logo.png')}}" alt="App Logo" width="58" />
                        </div>
                    </a>
                    <div class="text-center mb-7">
                        <h3 class="text-body-highlight">{{$settings->app_name}}</h3>
                        <p class="text-body-tertiary mt-2">V{{$settings->app_version}}</p>
                    </div>
                    <div class="position-relative">
                        <hr class="bg-body-secondary mt-5 mb-4" />
                        <div class="divider-content-center">Verify your identity</div>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label" for="email">Email address</label>
                        <div class="form-icon-container">
                            <input class="form-control form-icon-input" id="email" name="email" type="email" placeholder="Please enter your email" value="{!! old('email') !!}"/><span class="fas fa-envelope text-body fs-9 form-icon"></span>
                        </div>
                        <div class="invalid-feedback">Please choose a username.</div>
                        <span class="text-danger">{{ $errors->first('email', ':message') }}</span>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label" for="password">Password</label>
                        <div class="form-icon-container">
                            <input class="form-control form-icon-input" id="password" name="password" type="password" placeholder="please enter your password" /><span class="fas fa-key text-body fs-9 form-icon"></span>
                        </div>
                        <span class="text-danger">{{ $errors->first('password', ':message') }}</span>
                    </div>
                    <div class="row flex-between-center mb-7">
                        <div class="col-auto">
                            <div class="form-check mb-0">
                                <input class="form-check-input" id="remember-me" name="remember-me" type="checkbox" checked="checked" />
                                <label class="form-check-label mb-0" for="remember-me">Remember me</label>
                            </div>
                        </div>

                    </div>
                    <button class="btn btn-primary w-100 mb-3">Log In</button>

                        @if(env('DEMO_MODE'))
                        <p class="mt-3 text-danger text-center">Demo Mode</p>
                        <div class=" text-center">
                            <a class="btn btn-success" onclick="loginAsAdmin()">Login as admin</a>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
        var navbarTop = document.querySelector('.navbar-top');
        if (navbarTopStyle === 'darker') {
            navbarTop.setAttribute('data-navbar-appearance', 'darker');
        }

        var navbarVerticalStyle = window.config.config.phoenixNavbarVerticalStyle;
        var navbarVertical = document.querySelector('.navbar-vertical');
        if (navbarVertical && navbarVerticalStyle === 'darker') {
            navbarVertical.setAttribute('data-navbar-appearance', 'darker');
        }
    </script>
</main>
<!-- ===============================================-->
<!--    JavaScripts-->
<!-- ===============================================-->
<script src="{{asset('vendors/popper/popper.min.js')}}"></script>
<script src="{{asset('vendors/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/anchorjs/anchor.min.js')}}"></script>
<script src="{{asset('vendors/is/is.min.js')}}"></script>
<script src="{{asset('vendors/fontawesome/all.min.js')}}"></script>
<script src="{{asset('vendors/lodash/lodash.min.js')}}"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
<script src="{{asset('vendors/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('assets/js/phoenix.js')}}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@include('toaster')

<script>
    function loginAsAdmin() {
        $('#email').val('admin@demo.com');
        $('#password').val('123456');

        $('#loginForm').submit();
    }
</script>

</body>

</html>
