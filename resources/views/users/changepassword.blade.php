@extends('base')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{$title}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Users</li>
                        <li class="breadcrumb-item active">{{$title}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <form method="post" id="form">
                        @csrf
                        @if ($errors->any())
                        <div class="row justify-content-center ">
                            <div class="col-12">
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible" style="margin-top: 30px;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> GAGAL!</h5>
                            {{session('error')}}
                        </div>
                        @endif

                        <div class="row justify-content-center">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="old_password">Masukan Password Lama</label>
                                    <input type="password"
                                        class="form-control @error('old_password') is-invalid @enderror"
                                        placeholder="Masukkan Password Lama" name="old_password" id="old_password">
                                    @error('old_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="new_password">Masukan Password Baru</label>
                                    <input type="password"
                                        class="form-control @error('new_password') is-invalid @enderror"
                                        placeholder="Masukkan new_password" name="new_password" id="new_password">
                                    <small id='message_p'></small>
                                    @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="confirm_new_password">Konfirmasi Password Baru</label>
                                    <input type="password"
                                        class="form-control @error('confirm_new_password') is-invalid @enderror"
                                        placeholder="Masukkan Konfirmasi Password" name="confirm_new_password"
                                        id="confirm_new_password">
                                    <small id='message_cp'></small>
                                    @error('confirm_new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row  mt-3 justify-content-center">
                            <div class="col-6 d-flex justify-content-center ">
                                <a href="{{ route('users.edit', ['id'=>$user->id])}}"
                                    class="btn btn-secondary float-left">Cancel</a>
                                <button type="submit" id="submet" class="btn btn-primary float-left ml-2"
                                    style="width: 150px;">Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- MODAL HERE --}}
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#new_password').on('keyup', function () {
        if ($('#new_password').val().trim().length < 5) {
            $('#message_p').html('At Least 5 Character').css('color', 'red');
        } else {
            $('#message_p').html('');
        }
    });
    $('#new_password, #confirm_new_password').on('keyup', function () {
        if ($('#new_password').val() != $('#confirm_new_password').val()) {
            $('#message_cp').html('Not Matching').css('color', 'red');
        } else {
            $('#message_cp').html('');
        }
    });

</script>
@endsection
