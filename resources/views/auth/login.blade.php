<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Admin Pawon Lijo</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="../assets/img/icon.ico" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/atlantis/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {"families":["Lato:300,400,700,900"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('assets/atlantis/css/fonts.min.css') }}']},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/atlantis/css/bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/atlantis/css/atlantis.min.css') }} ">
    @yield('css')
</head>
<body>
    <div class="container">
        <div class="row" style="position: relative; top: 120px;">
            <div class="col-md-4 mx-auto">
                <div class="card border">
                    <div class="card-body">
                        <div class="image text-center">
                            <img src="{{ asset('assets/img/usr.png') }}" class="img-fluid" alt="" width="20%">
                            <h3 class="mt-2"><b>LOGIN ADMIN</b></h3>
                        </div>
                        <div class="separator-solid"></div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <div class="input-icon {{$errors->has('username_booth') ? 'has-error' : null}}">
                                    <span class="input-icon-addon {{$errors->has('username_booth') ? 'text-danger' : null}}">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}" required autofocus>                                       
                                </div>
                                @if ($errors->has('username'))
                                    <span class="help-block text-danger mt-1">
                                        {{$errors->first('username')}}
                                    </span>
                                @endif
                            </div>

                           
                            <div class="form-group">
                                <div class="input-icon {{$errors->has('password') ? 'has-error' : null}}">
                                    <span class="input-icon-addon {{$errors->has('password') ? 'text-danger' : null}}">
                                        <i class="fa fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="help-block text-danger">
                                        {{$errors->first('password')}}
                                    </span>
                                @endif
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary btn-rounded pl-5 pr-5">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="button text-center mt-5 mb-0">
                                <small class="text-muted">2019, made by mno</small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/atlantis/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('assets/atlantis/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/atlantis/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('assets/atlantis/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/atlantis/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/atlantis/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Atlantis JS -->
    <script src="{{ asset('assets/atlantis/js/atlantis.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @include('sweet::alert')
</body>
</html>