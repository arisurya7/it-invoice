<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
    <style type="text/css">
        body {
            background-color: #eee;
        }

        .reset-title {
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
                    {{session('success')}}
                </div>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="card" style="width: 25rem; border-radius:5%;">
                <h1 class="text-center reset-title mt-4">Change Password</h1>
                <div class="card-body">
                    <form class="" method="post" action="{{ route('resetpassword',['token'=>$token]) }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }} " />
                        <input type="hidden" name="token" value="{{ $token }} " />
                        <input type="password"
                            class="form-control rounded-pill p-3 @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="New Password" autofocus required>
                        <small id='message_p' class="pl-2"></small>
                        @error('password')
                        <div class="invalid-feedback pl-2">{{ $message }}</div>
                        @enderror
                        <input type="password"
                            class="form-control rounded-pill p-3 @error('confirm_password') is-invalid @enderror"
                            id="confirm_password" name="confirm_password" placeholder="Confirm New Password" autofocus
                            required>
                        <small id='message_cp' class="pl-2"></small>
                        @error('confirm_password')
                        <div class="invalid-feedback pl-2">{{ $message }}</div>
                        @enderror

                        <div class="row justify-content-center mt-4 mb-3">
                            <button class="btn btn-primary rounded-pill pl-5 pr-5" type="submit">Change
                                Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('partials.script')
        @yield('script')
        <script>
            $('#password').on('keyup', function () {
                if ($('#password').val().trim().length < 5) {
                    $('#message_p').html('At Least 5 Character').css('color', 'red');
                } else {
                    $('#message_p').html('');
                }
            });
            $('#password, #confirm_password').on('keyup', function () {
                if ($('#password').val() != $('#confirm_password').val()) {
                    $('#message_cp').html('Not Matching').css('color', 'red');
                } else {
                    $('#message_cp').html('');
                }
            });

        </script>

</body>

</html>
