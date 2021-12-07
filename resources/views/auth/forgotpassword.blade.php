<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
    <style type="text/css">
        body {
            background-color: #eee;
        }

        .forgot-title {
            color: #555;
            font-size: 1.8em;
            margin-bottom: 20px;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5 ml-5 mr-5">
            <div style="width: 25rem;">
                @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{session('success')}}
                </div>
                @endif
                @if (session()->has('failed'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{session('failed')}}
                </div>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="card" style="width: 25rem; border-radius:5%;">
                <h1 class="text-center forgot-title mt-4">Forgot Password</h1>
                <div class="card-body">
                    <form class="" method="post" action="{{ route('forgotpassword.validatepassword') }}">
                        @csrf
                        <label class="sr-only" for="email">Email</label>
                        <input type="email"
                            class="form-control rounded-pill mb-2 p-3 @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Email" autofocus required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="row justify-content-center mt-4">
                            <button class="btn btn-primary rounded-pill pl-5 pr-5" type="submit">Send Reset
                                Link</button>
                        </div>
                        <div class="row justify-content-center mt-2">
                            <a href="{{ route('login') }}">Back to Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('partials.script')
        @yield('script')
</body>

</html>
