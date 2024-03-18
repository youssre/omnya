<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Login </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- App favicon -->


    <!-- Bootstrap Css -->
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('admin/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" id="app-style"
        rel="stylesheet" type="text/css" />


    <style>
        .inputStyle {
            color: #494949 !important;
            background-color: hsla(0, 0%, 100%, .8) !important;
            border: 1px solid #d2d2d7 !important;
            border-radius: 12px !important;
            appearance: none !important;
        }

        .inputStyle:focus {
            box-shadow: 0 0 10px rgba(0, 125, 250, 0.6) !important;
        }

        .form-check-input:checked {
            background-color: #151f21 !important;
            border-color: #151f21 !important;
        }
    </style>
</head>

<body class="auth-body-bg" style="background-color: #fbfbfe; !important">
    <div>
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-12">
                    <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                        <div class="w-100">
                            <div class="row justify-content-center">
                                <div class="col-lg-4">
                                    <div>
                                        <div class="text-center">
                                            <div>
                                                <a href="/" class="">
                                                    <!-- <img src="{{ asset('admin/assets/logo/colorful-logo.png') }}" alt="" height="20" class="auth-logo colorful-logo mx-auto">
                                                        <img src="{{ asset('admin/assets/logo/colorful-logo.png') }}" alt="" height="20" class="auth-logo colorful-logo mx-auto">

                                                    <img src="{{ asset('admin/assets/logo/colorful-logo.png') }}"
                                                        alt="" height="200"
                                                        class="auth-logo colorful-logo mx-auto">-->
                                                    <video width="320" height="240" autoplay muted loop
                                                        class="mt-5">
                                                        <source src="/storage/app/public/logo/logo-video.mp4"
                                                            type="video/mp4">
                                                        Error Message
                                                    </video>


                                                </a>
                                            </div>

                                            <h4 class="font-size-18 mt-4">Welcome Back !</h4>
                                            <p class="text-muted">Sign in to continue to Admin Panel.</p>
                                        </div>

                                        <div class="p-2 mt-5">
                                            <form method="POST" action="{{ route('login') }}">
                                                @csrf

                                                <div class="mb-3 auth-form-group-custom mb-4">
                                                    <i class="ri-user-2-line auti-custom-input-icon"
                                                        style="color:#151f21 !important;"></i>
                                                    <label for="username">Email</label>
                                                    <input type="email"
                                                        class="form-control inputStyle @error('email') is-invalid @enderror"
                                                        id="username" name="email" value="{{ old('email') }}">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3 auth-form-group-custom mb-4">
                                                    <i class="ri-lock-2-line auti-custom-input-icon"
                                                        style="color:#151f21 !important;"></i>
                                                    <label for="userpassword">Password</label>
                                                    <input id="password" type="password"
                                                        class="form-control inputStyle @error('password') is-invalid @enderror"
                                                        name="password" required autocomplete="current-password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                {{-- <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="customControlInline">
                                                    <label class="form-check-label" for="customControlInline">Remember
                                                        me</label>
                                                </div> --}}

                                                <div class="mt-4 text-center">
                                                    <button
                                                        class="btn btn-primary btn-rounded w-md waves-effect waves-light"
                                                        type="submit" style="background-color:#151f21;">Log In</button>
                                                </div>


                                            </form>
                                        </div>

                                        <div class="mt-5 text-center">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <footer id="footer">

                    <div class="row" style="margin: 0px;">
                        <div class="col-sm-12 col-md-2 col-lg-2"
                            style="text-align: center;padding-top: 30px;float: left;">
                            <img src="{{ asset('admin/assets/logo/logo.png') }}" alt="logo-sm-light" height="50">
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3"
                            style="text-align: center;padding-top: 30px;float: left;">
                            <i style="font-size: 17px;color: #037EB2;" class="ri-phone-line"></i>
                            <i style="font-size: 17px;color: #00860D;" class="ri-whatsapp-fill"></i>
                            <span> +964-07504540021</span>
                        </div>
                        <div class="col-sm-12 col-md-2 col-lg-2"
                            style="text-align: center;padding-top: 30px;float: left;">
                            <i style="font-size: 17px;color: #00A8E5;" class="ri-telegram-fill"></i>
                            <span> livaid</span>
                        </div>
                        <div class="col-sm-12 col-md-2 col-lg-2"
                            style="text-align: center;float: left;padding-top: 30px;">
                            <i style="font-size: 17px;color: #39559A;" class="ri-facebook-circle-fill"></i>
                            <span> appleidliva</span>
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3" style="text-align: right;float: left;">
                            <span>بغداد - شارع الربيعي - بناية الزيتون </span>
                            <i style="font-size: 17px;color: #F0D830;" class="dripicons-location"></i>
                            <br>
                            <span>اربيل - كوتري سلام عمارة جهان </span>
                            <i style="font-size: 17px;color: #F0D830;" class="dripicons-location"></i>
                            <br>
                            <span>دهوك - تناهي </span>
                            <i style="font-size: 17px;color: #F0D830;" class="dripicons-location"></i>

                        </div>
                    </div>
                </footer> --}}

            </div>
        </div>
    </div>
    <style>
        #footer {
            background-color: #fff6f6 !important;
            padding: 15px !important;
        }
    </style>

</body>

</html>
