@extends('base')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Invoice</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Invoice</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            @can('admin')
                                <div class="float-right">
                                    <a href="{{ route('invoice.add') }}" class="btn btn-success" title='Tambah invoice'><i class="fa fa-plus"></i></a>
                                </div>    
                            @endcan
                        </div>
                    </div>
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> BERHASIL!</h5>
                        {{session('success')}}
                    </div>
                    @elseif(session('warning'))
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> GAGAL!</h5>
                        {{session('warning')}}
                    </div>
                    @elseif(session('error'))
                    <div class="alert alert-danger alert-dismissible" style="margin-top: 30px;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> GAGAL!</h5>
                        {{session('error')}}
                    </div>
                    @endif
                    
                    <h4>Filter</h4>
                    <form action="{{ route('invoice') }}", method="POST">
                        @csrf
                        <div class="row mb-3 align-items-end">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="filter_project" class="text-sm"> Project</label>
                                    <select name="filter_project" id="filter_project" class="form-control select2 filter">
                                        <option value="">All Project</option>
                                        @foreach ($project as $item)
                                        <option value="{{$item->id}}"   {{ request('filter_project')==$item->id?'selected':'' }} >{{$item->nama_project}} - {{$item->nama_perusahaan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="filter_status" class="text-sm"> Status</label>
                                    <select name="filter_status" id="filter_status" class="form-control select2 filter">
                                        <option value="">All Status</option>
                                        <option value="Draft" {{ request('filter_status')=='Draft'?'selected':'' }} >Draft</option>
                                        <option value="Final" {{ request('filter_status')=='Final'?'selected':'' }}>Final</option>
                                        <option value="Cancel" {{ request('filter_status')=='Cancel'?'selected':'' }}>Cancel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="filter_begin_date" class="text-sm"> Awal Tanggal</label>
                                    <input type="date" name="filter_begin_date" id="filter_begin_date" class="form-control filter" value="{{ request('filter_begin_date')}}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="filter_last_date" class="text-sm"> Akhir Tanggal</label>
                                    <input type="date" name="filter_last_date" id="filter_last_date" class="form-control filter" value="{{ request('filter_last_date') }}">
                                </div>
                            </div>  
                            <div class="col-1">
                                <button type="submit" class="btn btn-outline-primary mb-3">Check</button>
                            </div>
                            
                        </div>
                    </form>
                   

                    <div class="table-responsive">
                        <table id="tableinvoice" class="table table-bordered dt-responsive nowrap datatable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Perihal</th>
                                    <th>Status</th>
                                    <th>Revisi</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="actionz">
                                @foreach ($invoice as $key=>$item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{$item->project->nama_project}}</td>
                                    <td>{{$item->nomor_invoice}}</td>
                                    <td>{{date('d-m-Y',strtotime($item->tanggal))}}</td>
                                    <td>{{$item->perihal}}</td>
                                    <td>{{$item->status}}</td>
                                    <td>{{$item->revisiCount($item->id)}}</td>
                                    <td>
                                        @can('admin')
                                            <a href="{{ route('invoice.edit', ['id'=>$item->id]) }}" title='Revisi invoice' class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>                                     
                                            <a href="javascript:void(0)" class="btn btn-info btn-sm btn-status" data-id="{{$item->id}}" title='Ganti status'><i class="fa fa-exclamation-circle"></i></a>
                                            <button class="btn btn-primary btn-sm btn-revisi" title='History revisi' data-id="{{$item->id}}" data-invoice="{{$item->nomor_invoice}}"><i class="fa fa-history"></i></button>
                                            <a href="{{ route('invoice.exportpdf', ['id'=>$item->id]) }}" class="btn btn-success btn-sm btn-pdf" target="_blank"title='Export PDF'><i class="fas fa-download"></i></a>
                                            <a type="button" class="btn btn-danger btn-sm btn-delete" onclick="idInvoice({{$item->id}})" title='Delete'><i class="far fa-trash-alt"></i></i></a>
                                        @endcan
                                        @can('manager')
                                            <a href="javascript:void(0)" class="btn btn-info btn-sm btn-status" data-id="{{$item->id}}" title='Lihat Invoice'><i class='fa fa-eye'></i></a>
                                            <button class="btn btn-primary btn-sm btn-revisi" title='History revisi' data-id="{{$item->id}}" data-invoice="{{$item->nomor_invoice}}"><i class="fa fa-history"></i></button>
                                            <a href="{{ route('invoice.exportpdf', ['id'=>$item->id]) }}" class="btn btn-success btn-sm btn-pdf" target="_blank"title='Export PDF'><i class="fas fa-download"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- MODAL HERE --}}
            <div class="modal fade" id="modal-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            @can('admin')
                                <h5 class="modal-title" id="exampleModalLabel">Ganti Status</h5>
                            @endcan
                            @can('manager')
                                <h5 class="modal-title" id="exampleModalLabel">Lihat Invoice</h5>
                            @endcan
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('invoice.status') }}" id='form-status' method="GET">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nama_project">Nama Project</label>
                                            <input type="text" class="form-control" id='nama_project' readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="telp">Telp</label>
                                            <input type="text" id="telp" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="perihal">Perihal</label>
                                            <textarea name="perihal" id="perihal" cols="30" rows="3" class="form-control" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="text" readonly="readonly" class="form-control" id="tanggal">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="provinsi">Provinsi</label>
                                            <input type="text" readonly="readonly" class="form-control" id="provinsi">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kota">Kota</label>
                                            <input type="text" readonly="readonly" class="form-control" id="kota">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kecamatan">Kecamatan</label>
                                            <input type="text" readonly="readonly" class="form-control" id="kecamatan">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kodepos">Kode Pos</label>
                                            <input type="text" readonly="readonly" class="form-control" id="kodepos">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea name="alamat" id="alamat" cols="30" rows="3" readonly="readonly" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Deskripsi</th>
                                                    <th>Ammount</th>
                                                </tr>
                                            </thead>
                                            <tbody id='tbody-deskripsi'></tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="metode_pembayaran">Metode Pembayaran</label>
                                            <input type="text" readonly="readonly" class="form-control" id="metode_pembayaran">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="bank">Bank</label>
                                            <input type="text" readonly="readonly" class="form-control" id="bank">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="no_rekening">No Rekening</label>
                                            <input type="text" readonly="readonly" class="form-control" id="no_rekening">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="cabang_bank">Cabang Bank</label>
                                            <input type="text" readonly="readonly" class="form-control" id="cabang_bank">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="penerima">Penerima</label>
                                            <input type="text" readonly="readonly" class="form-control" id="penerima">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group"> 
                                            <label for="termin">Termin</label>
                                            <input type="text" readonly="readonly" class="form-control" id="termin">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <input type="hidden" name="id" id="id-status">
                            <input type="hidden" name="status" id="status">
                            <div class="modal-footer">
                                @can('admin')
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger" id='btn-cancel'>Cancel</button>
                                    <button type="button" class="btn btn-warning" id='btn-draft'>Draft</button>
                                    <button type="button" class="btn btn-success" id='btn-final'>Final</button>
                                @endcan
                                @can('manager')
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-revisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">History Revisi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>No. Invoice</th>
                                        <th>Tanggal Revisi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id='tbody-revisi'></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Peringatan! </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Data Invoice dan History Invoice akan dihapus. Anda yakin? </p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('invoice.delete') }}" method="post">
                                @csrf
                                <input type="hidden" id="id_invoice" name="id_invoice">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger btn-confirm-delete" > Delete</button>
                            </form>                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-revisi-not-found" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Informasi </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Tidak ditemukan revisi </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>                               
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('body').on('click', '.btn-status', function(){
        console.log($(this).data('id'))
        let id = $(this).data('id')
        $.ajax({
            url:"{{ route('invoice.show') }}",
            type:'GET',
            data:{
                id:id
            },
            success:function(data){
                 console.log(data)
                if (data.status == '200'){
                    deskripsi = data.deskripsi
                    invoice = data.invoice
                    project = data.project
                    $('#nama_project').val(project.nama_project)
                    $('#telp').val(project.telp) 
                    $('#perihal').val(invoice.perihal)
                    $('#alamat').val(project.alamat)
                    $('#provinsi').val(project.provinsi)
                    $('#kota').val(project.kota)
                    $('#kecamatan').val(project.kecamatan)
                    $('#kodepos').val(project.kodepos)
                    $('#tanggal').val(invoice.tanggal)
                    $('#metode_pembayaran').val(invoice.metode_pembayaran)
                    $('#bank').val(invoice.bank)
                    $('#no_rekening').val(invoice.no_rekening)
                    $('#cabang_bank').val(invoice.cabang_bank)
                    $('#penerima').val(invoice.penerima)
                    $('#termin').val(invoice.termin)
                    
                    $('#tbody-deskripsi').empty()
                    let row=''
                    $.each(deskripsi, function(i, v){
                        row = "<tr>"+
                                "<td>"+v.deskripsi+"</td>"+
                                "<td>"+v.ammount+"</td>"+
                            "<tr>"
                        console.log(row)
                        $('#tbody-deskripsi').append(row)
                    })
                    
                    row = "<tr>"+
                                "<td class='float-right'> Total </td>"+
                                "<td>"+invoice.total+"</td>"+
                            "<tr>"
                        console.log(row)
                    $('#tbody-deskripsi').append(row)

                    $('#id-status').val(id)
                    $('#modal-status').modal('show')
                }
            }
        })
    })

    $('#btn-cancel').click(function(){
        console.log('cancel')
        $('#status').val('Cancel')
        $('#form-status').submit()
    })

    $('#btn-draft').click(function(){
        console.log('draft')
        $('#status').val('Draft')
        $('#form-status').submit()
    })

    $('#btn-final').click(function(){
        console.log('final')
        $('#status').val('Final')
        $('#form-status').submit()
    })

    $('body').on('click', '.btn-revisi', function(){
        console.log($(this).data('id'))
        let id = $(this).data('id')
        let no_invoice = $(this).data('invoice')
        console.log(no_invoice)
        $.ajax({
            url:"{{ route('invoice.showrevisi') }}",
            method:'GET',
            data:{
                id:id
            },
            success:function(data){
                console.log(data) 

                if(data.status == '404') $('#modal-revisi-not-found').modal('show')
                
                if (data.status=='200'){
                    $('#tbody-revisi').empty()
                    $.each(data.data, function(i, v){
                        let date = $.format.date(v.created_at, 'dd-MM-yyyy HH:mm:ss')
                        console.log(date)
                        let row = "<tr>"+
                                "<td>"+(i+1)+"</td>"+
                                "<td>"+no_invoice+"</td>"+
                                "<td>"+date+"</td>"+
                                "<td>"+
                                    "<button class='btn btn-primary btn-xs btn-show-revisi' data-id='"+v.id+"'><i class='fa fa-eye'></i></button>"+
                                "</td>"+
                            "</tr>"
                        $('#tbody-revisi').append(row)
                    })
                    $('#modal-revisi').modal('show')
                }
            }
        })
    })

    $('body').on('click', '.btn-show-revisi', function(){
        console.log($(this).data('id'))
        let url = "{{ route('invoice.revisi', ':id') }}"
        url = url.replace(':id', $(this).data('id'))
        window.location.href = url
    })

    // catch id invoice for delete invoice and revisis
    function idInvoice(id){
        console.log(id)
        $('#modal-delete').modal('show')  
        $('#id_invoice').val(id)
    }

</script>
@endsection