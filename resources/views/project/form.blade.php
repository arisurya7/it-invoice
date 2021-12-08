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
                        <li class="breadcrumb-item">Project</li>
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
                                    <label>Nama Project</label>
                                    <input type="text" class="form-control @error('nama_project') is-invalid @enderror"
                                        placeholder="Masukkan Nama Project" name="nama_project"
                                        value="{{ old('nama_project')? old('nama_project'):($project->nama_project ?? '') }}">
                                    @error('nama_project')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class='form-control @error('
                                        tanggal') is-invalid @enderror'
                                        value="{{ old('tanggal')? old('tanggal'):($project->tanggal ?? '') }}">
                                    @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="nama_customer">Nama Customer/Perusahaan</label>
                                    <select name="customer" id="customer"
                                        class="form-control select2  @error('customer') is-invalid @enderror">
                                        <option value="">Pilih Customer</option>
                                        @foreach ($customer as $item)
                                        <option value="{{$item->id}}"
                                            {{old('customer')==$item->id?'selected':(isset($project)?($project->customer_id==$item->id?'selected':''):'')}}>
                                            {{$item->nama_customer}}</option>
                                        @endforeach
                                    </select>
                                    @error('customer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row float-right mt-3">
                            <div class="col-12">
                                <a href="{{ route('project')}}" class="btn btn-secondary float-left">Cancel</a>
                                <button type="submit" id="submet" class="btn btn-primary float-left ml-2"
                                    style="width: 150px;">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

</script>
@endsection
