<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
    <style type="text/css">
        body {
            background-color: #eee;
        }

        .login-title {
            color: #555;
            font-size: 1.8em;
            margin-bottom: 20px;
        }

    </style>
    <link href="{{ asset('/assets/dist/css/main.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/assets/dist/css/util.css') }}" rel="stylesheet" type="text/css"/>
</head>

<body>
    <div class="limiter container-login100">
        <div class="row justify-content-center mt-5 ml-5 mr-5">
            <div style="width: 25rem;">
                @if (session()->has('loginError'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{session('loginError')}}
                </div>
                @endif
                @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{session('success')}}
                </div>
                @endif
            </div>
        </div>
        <div class="wrap-login100">
            <div class="login100-pic js-tilt" data-tilt>
                <img src="{{URL::asset('/assets/dist/img/login-image.png')}}" alt="IMG">
            </div>

            <div class="login100-form row justify-content-center">
                <div class="">
                    <h1 class="text-center login-title mt-4">Login</h1>
                    <div class="">
                        <form class="" method="post" action="{{ route('login.authenticate') }}">
                            @csrf
                            <input type="text" class="form-control rounded-pill mb-2 p-3" id="username" name="username"
                                placeholder="Username" autofocus required>
                            <input type="password" class="form-control rounded-pill mb-2 p-3 mt-1" id="password"
                                name="password" placeholder="Password" required>
                            <div class="row justify-content-center mt-4">
                                <button class="btn btn-primary rounded-pill pl-5 pr-5" type="submit">Login</button>
                            </div>
                            <div class="row justify-content-center mt-2 mb-2">
                                <a href="{{ route('forgotpassword') }}">Forgot Password?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- jQuery -->
        @include('partials.script')
        @yield('script')
</body>

</html>
