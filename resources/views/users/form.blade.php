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
                    <form method="post" id="form" enctype="multipart/form-data">
                        @csrf
                        @if ($errors->any())
                        <div class="row">
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
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                        placeholder="Masukkan First Name" name="firstname"
                                        value="{{ old('firstname')? old('firstname'):($user->firstname ?? '') }}">
                                    @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                        placeholder="Masukkan Last Name" name="lastname"
                                        value="{{ old('lastname')? old('lastname'):($user->lastname ?? '') }}">
                                    @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        placeholder="Masukkan Username" name="username"
                                        value="{{ old('username')? old('username'):($user->username ?? '') }}">
                                    @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Masukkan email" name="email"
                                        value="{{ old('email')? old('email'):($user->email ?? '') }}">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            @if ($title=='Tambah User')
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="password">Masukan Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Masukkan password" name="password" id="password"
                                        value="{{ old('password')? old('password'):($user->password ?? '') }}">
                                    <small id='message_p'></small>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select name="role" id="role"
                                        class="form-control select2  @error('role') is-invalid @enderror">
                                        <option value="">Pilih Role</option>
                                        <option value="Manager"
                                            {{old('role')=='Manager'?'selected':(isset($user)?($user->role=='Manager'?'selected':''):'')}}>
                                            Manager</option>
                                    </select>
                                    @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @endif

                            @if ($title=='Edit User')
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select name="role" id="role"
                                        class="form-control select2  @error('role') is-invalid @enderror">
                                        <option value="">Pilih Role</option>
                                        <option value="Manager"
                                            {{old('role')=='Manager'?'selected':(isset($user)?($user->role=='Manager'?'selected':''):'')}}>
                                            Manager</option>
                                        <option value="Admin"
                                            {{old('role')=='Admin'?'selected':(isset($user)?($user->role=='Admin'?'selected':''):'')}}>
                                            Admin</option>
                                    </select>
                                    @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="foto">Pilih Foto</label>
                                    <input class="form-control @error('foto') is-invalid @enderror pl-0" type="file"
                                        id="foto" name="foto">
                                    @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            @if ($title == 'Tambah User')
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password"
                                        class="form-control @error('confirm_password') is-invalid @enderror"
                                        placeholder="Masukkan Konfirmasi Password" name="confirm_password"
                                        id="confirm_password"
                                        value="{{ old('confirm_password')? old('confirm_password'):($user->confirm_password ?? '') }}">
                                    <small id='message_cp'></small>
                                    @error('confirm_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="foto">Pilih Foto</label>
                                    <input class="form-control @error('foto') is-invalid @enderror pl-0" type="file"
                                        id="foto" name="foto">
                                    @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @endif
                            @if ($title == 'Edit User')
                            <div class="col-6">
                                <div class="form-group">
                                    <a href="{{ route('users.changepassword', ['id'=>$user->id])}}"
                                        class="btn btn-primary"> Change Password</a>
                                </div>
                            </div>
                            @endif

                        </div>
                        <hr>
                        <div class="row float-right mt-3">
                            <div class="col-12">
                                <a href="{{ route('users')}}" class="btn btn-secondary float-left">Cancel</a>
                                <button type="submit" id="submet" class="btn btn-primary float-left ml-2"
                                    style="width: 150px;">Save</button>
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
@endsection
