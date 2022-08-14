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
                        <li class="breadcrumb-item">Customer</li>
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
                            <div class="col">
                                <div class="form-group">
                                    <label>Nama Customer / Company</label>
                                    <input type="text" class="form-control @error('nama_customer') is-invalid @enderror"
                                        placeholder="Masukkan Nama Customer" name="nama_customer"
                                        value="{{ old('nama_customer')? old('nama_customer'):($customer->nama_customer ?? '') }}">
                                    @error('nama_customer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Telp</label>
                                    <input type="text" class="form-control @error('telp') is-invalid @enderror"
                                        placeholder="Masukkan No Telp" name="telp"
                                        value="{{ old('telp')? old('telp'):($customer->telp ?? '') }}">
                                    @error('telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Masukkan Email" name="email"
                                        value="{{ old('email')? old('email'):($customer->email ?? '') }}">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="provinsi">Provinsi</label>
                                    <select name="provinsi" id="provinsi"
                                        class="form-control select2  @error('provinsi') is-invalid @enderror">
                                        <option value="">Pilih Provinsi</option>
                                        @foreach ($provinsi as $item)
                                        <option value="{{$item->id}}"
                                            {{old('provinsi')==$item->id?'selected':(isset($customer)?($customer->id_provinsi==$item->id?'selected':''):'')}}>
                                            {{$item->nama}}</option>
                                        @endforeach
                                    </select>
                                    @error('provinsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="kota">Kota</label>
                                    <select name="kota" id="kota"
                                        class="form-control select2  @error('kota') is-invalid @enderror">
                                        <option value="">Pilih Kota</option>
                                        @if (isset($kota) && isset($customer))
                                        @foreach ($kota as $item)
                                        <option value="{{$item->id}}"
                                            {{old('kota')==$item->id?'selected':($customer->id_kota==$item->id?'selected':'')}}>
                                            {{$item->nama}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('kota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan</label>
                                    <select name="kecamatan" id="kecamatan"
                                        class="form-control select2  @error('kecamatan') is-invalid @enderror">
                                        <option value="">Pilih Kecamatan</option>
                                        @if (isset($kecamatan) && isset($customer))
                                        @foreach ($kecamatan as $item)
                                        <option value="{{$item->id}}"
                                            {{old('kecamatan')==$item->id?'selected':($customer->id_kecamatan==$item->id?'selected':'')}}>
                                            {{$item->nama}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('kecamatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Kode Pos</label>
                                    <input type="text" class="form-control @error('kodepos') is-invalid @enderror"
                                        placeholder="Masukkan Kode Post" name="kodepos" id="kodepos"
                                        value="{{ old('kodepos')? old('kodepos'):($customer->kodepos ?? '') }}">
                                    @error('kodepos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" id="alamat" cols="30" rows="3"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        placeholder="Alamat">{{ old('alamat')? old('alamat'):($customer->alamat ?? '') }}</textarea>
                                    @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row float-right mt-3">
                            <div class="col-12">
                                <a href="{{ route('customer')}}" class="btn btn-secondary float-left">Cancel</a>
                                <button type="submit" class="btn btn-primary float-left ml-2"
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
    $('#provinsi').on('select2:select', function (e) {
        console.log($(this).val())
        if ($(this).val() != '') {
            $.ajax({
                url: "{{ route('customer.getkota') }}",
                method: 'GET',
                data: {
                    provinsi: $(this).val()
                },
                success: function (data) {
                    if (data.status==200) {
                        $('#kota').empty()
                        let opt = new Option('Pilih Kota', '', false, false)
                        $('#kota').append(opt).trigger('change')
                        $.each(data.kota, function (key, item) {
                            opt = new Option(item.nama, item.id, false, false)
                            $('#kota').append(opt)
                        })
                    }
                }
            })
        }
    })

    $('#kota').on('select2:select', function (e) {
        console.log($(this).val())
        if ($(this).val() != '') {
            $.ajax({
                url: "{{ route('customer.getkecamatan') }}",
                method: 'GET',
                data: {
                    kota: $(this).val()
                },
                success: function (data) {
                    console.log(data)
                    if (data.status == 200) {
                        $('#kecamatan').empty()
                        let opt = new Option('Pilih Kecamatan', '', false, false)
                        $('#kecamatan').append(opt).trigger('change')
                        $.each(data.kecamatan, function (key, item) {
                            opt = new Option(item.nama, item.id, false, false)
                            $('#kecamatan').append(opt)
                        })
                    }
                }
            })
        }
    })

</script>
@endsection
