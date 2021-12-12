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
                        <li class="breadcrumb-item">Invoice</li>
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
                                    @if ($title=='Lihat Detail Revisi')
                                    <select name="project" id="project"
                                        class="form-control select2  @error('project') is-invalid @enderror">
                                        <option value="">Pilih Project</option>
                                        @foreach ($project as $item)
                                        <option value="{{$item->id}}"
                                            {{old('project')==$item->id?'selected':(isset($invoice)?($invoice->invoice->project_id==$item->id?'selected':''):'')}}>
                                            {{$item->nama_project}} - {{ $item->customer->nama_customer }}</option>
                                        @endforeach
                                    </select>
                                    @error('project')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @else
                                    <select name="project" id="project"
                                        class="form-control select2  @error('project') is-invalid @enderror">
                                        <option value="">Pilih Project</option>
                                        @foreach ($project as $item)
                                        <option value="{{$item->id}}"
                                            {{old('project')==$item->id?'selected':(isset($invoice)?($invoice->project_id==$item->id?'selected':''):'')}}>
                                            {{$item->nama_project}} - {{ $item->customer->nama_customer }}</option>
                                        @endforeach
                                    </select>
                                    @error('project')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @endif

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class='form-control @error('
                                        tanggal') is-invalid @enderror'
                                        value="{{ old('tanggal')?old('tanggal'):($invoice->tanggal??'') }}">
                                    @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="perihal">Perihal</label>
                                    <textarea name="perihal" id="perihal" cols="30" rows="3"
                                        class="form-control @error('perihal') is-invalid @enderror"
                                        placeholder="Perihal">{{old('perihal')?old('perihal'):($invoice->perihal??'')}}</textarea>
                                    @error('perihal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Telp</label>
                                    <input type="text" class="form-control @error('telp') is-invalid @enderror"
                                        name="telp" id="telp"
                                        value="{{ old('telp')?old('telp'):($projectedit->customer->telp??'') }}"
                                        readonly placeholder="Telepon">
                                    @error('telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="provinsi">Provinsi</label>
                                    <input type="text" name="provinsi" id="provinsi" class='form-control @error('
                                        provinsi') is-invalid @enderror'
                                        value="{{ old('provinsi')?old('provinsi'):($projectedit->customer->kodepos->provinsi->nama??'') }}"
                                        readonly placeholder="Provinsi">
                                    @error('provinsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="kota">Kota</label>
                                    <input type="text" name="kota" id="kota" class='form-control @error(' kota')
                                        is-invalid @enderror'
                                        value="{{ old('kota')?old('kota'):($projectedit->customer->kodepos->kota->nama??'') }}"
                                        readonly placeholder="Kota">
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
                                    <input type="text" name="kecamatan" id="kecamatan" class='form-control @error('
                                        kecamatan') is-invalid @enderror'
                                        value="{{ old('kecamatan')?old('kecamatan'):($projectedit->customer->kodepos->kecamatan->nama??'') }}"
                                        readonly placeholder="Kecamatan">
                                    @error('kecamatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="kodepos">Kode Pos</label>
                                    <input type="text" name="kodepos" id="kodepos" class='form-control @error('
                                        kodepos') is-invalid @enderror'
                                        value="{{ old('kodepos')?old('kodepos'):($projectedit->customer->kodepos->kode??'') }}"
                                        readonly placeholder="Kode Pos">
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
                                        class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat"
                                        readonly="readonly">{{old('alamat')?old('alamat'):($projectedit->customer->alamat??'')}}</textarea>
                                    @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-4">
                            <div class="col-12">
                                <table class="table table-striped" id='table-deskripsi'>
                                    <thead>
                                        <tr>
                                            <th width='40%'>Deskripsi</th>
                                            <th width='40%'>Jumlah</th>
                                            <th width='20%'>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id='tbody-deskripsi'>
                                        @if (!isset(old('deskripsi')[0]) && !isset($invoice))
                                        <tr>
                                            <td><input type='text' class='form-control' name='deskripsi[]'
                                                    placeholder='Deskripsi' value=""></td>
                                            <td><input type='text' class='form-control ammount' value=''
                                                    placeholder='0'><input type='hidden' class='hid-ammount'
                                                    name='ammount[]' value=''></td>
                                            <td><button type='button' class='btn btn-danger btn-sm btn-del'><i
                                                        class='fa fa-trash'></i></button></td>
                                        </tr>
                                        @endif

                                        @if (isset(old('deskripsi')[0]))
                                        @foreach (old('deskripsi') as $key => $item)
                                        <tr>
                                            <td><input type='text' class='form-control' name='deskripsi[]'
                                                    placeholder='Deskripsi' value="{{ $item }}"></td>
                                            <td><input type='text' class='form-control ammount'
                                                    value='{{ number_format(old('ammount')[$key]) }}'
                                                    placeholder='0'><input type='hidden' class='hid-ammount'
                                                    name='ammount[]' value='{{ old('ammount')[$key] }}'></td>
                                            <td><button type='button' class='btn btn-danger btn-sm btn-del'><i
                                                        class='fa fa-trash'></i></button></td>
                                        </tr>
                                        @endforeach
                                        @endif

                                        @if (isset($invoice))
                                        @if ($title=='Lihat Detail Revisi')
                                        @foreach ($invoice->detailrevisi as $item)
                                        <tr>
                                            <td><input type='text' class='form-control' name='deskripsi[]'
                                                    placeholder='Deskripsi' value="{{$item->deskripsi ?? ''}}"></td>
                                            <td><input type='text' class='form-control ammount'
                                                    value='{{number_format($item->ammount)}}' placeholder='0'><input
                                                    type='hidden' class='hid-ammount' name='ammount[]'
                                                    value='{{$item->ammount??''}}'></td>
                                            <td><button type='button' class='btn btn-danger btn-sm btn-del'><i
                                                        class='fa fa-trash'></i></button></td>
                                        </tr>
                                        @endforeach
                                        @else
                                        @foreach ($invoice->deskripsi as $item)
                                        <tr>
                                            <td><input type='text' class='form-control' name='deskripsi[]'
                                                    placeholder='Deskripsi' value="{{$item->deskripsi ?? ''}}"></td>
                                            <td><input type='text' class='form-control ammount'
                                                    value='{{number_format($item->ammount)}}' placeholder='0'><input
                                                    type='hidden' class='hid-ammount' name='ammount[]'
                                                    value='{{$item->ammount??''}}'></td>
                                            <td><button type='button' class='btn btn-danger btn-sm btn-del'><i
                                                        class='fa fa-trash'></i></button></td>
                                        </tr>
                                        @endforeach
                                        @endif

                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class='float-right'><b>TOTAL</b></td>
                                            <td colspan="2">
                                                <input type="text" class="form-control" placeholder="Total" id='total'
                                                    readonly
                                                    value="{{old('total')?number_format(old('total')):(isset($invoice)?number_format($invoice->total):'0')}}">
                                                <input type="hidden" name="total" id='hid-total'
                                                    value='{{old('total')?old('total'):($invoice->total??'0')}}'>
                                                @error('total')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">
                                                <button type='button' class="btn btn-primary btn-sm" id='add-row'><i
                                                        class="fa fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <label for="metode_pembayaran">Metode Pembayaran</label>
                                <input type="text" class="form-control @error('metode_pembayaran') is-invalid @enderror"
                                    placeholder="Masukkan Metode Pembayaran" name="metode_pembayaran"
                                    value="{{ old('metode_pembayaran')?old('metode_pembayaran'):($invoice->metode_pembayaran??'') }}">
                                @error('metode_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <label for="bank">Bank</label>
                                <input type="text" class="form-control @error('bank') is-invalid @enderror"
                                    placeholder="Masukkan Bank" name="bank"
                                    value="{{ old('bank')?old('bank'):($invoice->bank??'') }}">
                                @error('bank')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <label for="no_rekening">Nomor Rekening</label>
                                <input type="text" class="form-control @error('no_rekening') is-invalid @enderror"
                                    placeholder="Masukkan Nomor Rekening" name="no_rekening"
                                    value="{{ old('no_rekening')?old('no_rekening'):($invoice->no_rekening??'') }}">
                                @error('no_rekening')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4">
                                <label for="cabang_bank">Cabang Bank</label>
                                <input type="text" class="form-control @error('cabang_bank') is-invalid @enderror"
                                    placeholder="Masukkan Cabang Bank" name="cabang_bank"
                                    value="{{ old('cabang_bank')?old('cabang_bank'):($invoice->cabang_bank??'') }}">
                                @error('cabang_bank')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <label for="penerima">Penerima</label>
                                <input type="text" class="form-control @error('penerima') is-invalid @enderror"
                                    placeholder="Masukkan Penerima" name="penerima"
                                    value="{{ old('penerima')?old('penerima'):($invoice->penerima??'') }}">
                                @error('penerima')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <label for="termin">Termin</label>
                                <select name="termin" id="termin"
                                    class="form-control select2  @error('termin') is-invalid @enderror">
                                    <option value="">Pilih Termin</option>
                                    <option value="Net 30" {{old('termin')=='Net 30'?'selected':(isset($invoice)?($invoice->termin=='Net 30'?'selected':''):'')}}>Net 30</option>
                                    <option value="Net 60" {{old('termin')=='Net 60'?'selected':(isset($invoice)?($invoice->termin=='Net 60'?'selected':''):'')}}>Net 60</option>
                                    <option value="Net 90" {{old('termin')=='Net 90'?'selected':(isset($invoice)?($invoice->termin=='Net 90'?'selected':''):'')}}>Net 90</option>
                                </select>
                                @error('termin')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="row float-right mt-3">
                            <div class="col-12">
                                @if ($title=='Lihat Detail Revisi')
                                <a href="{{ route('invoice')}}" class="btn btn-secondary float-left">Back</a>
                                @else
                                <a href="{{ route('invoice')}}" class="btn btn-secondary float-left">Cancel</a>
                                <button type="submit" id="submet" class="btn btn-primary float-left ml-2"
                                    style="width: 150px;">Save</button>
                                @endif

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
    function setTotal() {
        var total = 0
        $('.hid-ammount').each(function () {
            console.log($(this).val())
            if ($(this).val() != '') {
                total += parseInt($(this).val())
            }
        })
        $('#total').val(total)
        setHarga(total, $('#total'), $('#hid-total'))
    }

    $('#add-row').click(function () {
        let row = "<tr>" +
            "<td><input type='text' class='form-control' name='deskripsi[]' placeholder='Deskripsi'></td>" +
            "<td><input type='text' class='form-control ammount' min='0' placeholder='0'><input type='hidden' class='hid-ammount' name='ammount[]'></td>" +
            "<td><button type='button' class='btn btn-danger btn-sm btn-del'><i class='fa fa-trash'></i></button></td>" +
            "</tr>"
        $('#tbody-deskripsi').append(row)
    })

    $('body').on('click', '.btn-del', function () {
        $(this).closest('tr').remove()
        setTotal()
    })

    $('#project').on('select2:select', function (e) {
        console.log($(this).val())
        if ($(this).val() != '') {
            $.ajax({
                url: "{{ route('invoice.getdetailproject') }}",
                method: 'GET',
                data: {
                    project: $(this).val()
                },
                success: function (data) {
                    console.log(data)
                    if (data.status == 200) {
                        data = data.project[0]
                        $('#telp').val(data.telp)
                        $('#provinsi').val(data.provinsi)
                        $('#kota').val(data.kota)
                        $('#kecamatan').val(data.kecamatan)
                        $('#kodepos').val(data.kodepos)
                        $('#alamat').val(data.alamat)
                    }
                }
            })
        }
    })

    $('body').on('keyup', '.ammount', function () {
        setHarga($(this).val(), $(this), $(this).closest('tr').find('.hid-ammount'))
        setTotal()

    })

</script>
@endsection
