@extends('base')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Customer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Customer</li>
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
                            <div class="float-left">
                                <a href="{{ route('customer.add') }}" class="btn btn-success" title='Tambah Customer'><i
                                        class="fa fa-plus"></i> Tambah Customer</a>
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

                    <div class="table-responsive">
                        <table id="tablecustomer" class="table table-bordered dt-responsive nowrap datatable"
                            style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Customer</th>
                                    <th>Provinsi</th>
                                    <th>Kota</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="actionz">
                                @foreach ($customer as $key=>$item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->nama_customer }}</td>
                                    <td>{{ $item->provinsi->nama }}</td>
                                    <td>{{ $item->kota->nama }}</td>
                                    <td class="text-center">
                                        @can('admin')
                                        <a href="{{ route('customer.edit', ['id'=>$item->id]) }}" title='Edit Customer'
                                            class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-info btn-sm btn-show"
                                            title='Show Customer' data-id="{{ $item->id }}"><i
                                                class="fa fa-exclamation-circle"></i></a>
                                        <a type="button" class="btn btn-danger btn-sm btn-delete"
                                            onclick="idCustomer({{$item->id}})" title='Delete'><i
                                                class="far fa-trash-alt"></i></i></a>
                                        @endcan
                                        @can('manager')
                                        <a href="javascript:void(0)" class="btn btn-info btn-sm btn-show"
                                            title='Show Customer' data-id="{{ $item->id }}"><i
                                                class="fa fa-exclamation-circle"></i></a>
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
            <div class="modal fade" id="modal-show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detail Customer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id='form-detail'>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="client">Nama Customer</label>
                                            <input type="text" class="form-control" id='nama_customer' readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="telp">Telp</label>
                                            <input type="text" id="telp" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="tanggal">Email</label>
                                            <input type="text" readonly="readonly" class="form-control" id="email">
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
                                            <textarea name="alamat" id="alamat" cols="30" rows="3" readonly="readonly"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Peringatan! </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Data Customer akan dihapus. Anda yakin? </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                            <button type="buttpn" class="btn btn-warning btn-delete-ask" data-dismiss="modal">
                                Continue</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-delete-confirm" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Peringatan! </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Data Project dan Invoice yang tehububung dengan project ini juga akan dihapus. Anda
                                yakin? </p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('customer.delete') }}" method="post">
                                @csrf
                                <input type="hidden" id="id_customer" name="id_customer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger btn-confirm-delete"> Delete</button>
                            </form>
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
    $('body').on('click', '.btn-show', function () {
        console.log($(this).data('id'))
        let id = $(this).data('id')
        $.ajax({
            url: "{{ route('customer.show') }}",
            type: 'GET',
            data: {
                id: id
            },
            success: function (data) {
                console.log(data)
                if (data.status == 200) {
                    data = data.data
                    $('#nama_customer').val(data.nama_customer)
                    $('#telp').val(data.telp)
                    $('#email').val(data.email)
                    $('#provinsi').val(data.provinsi.nama)
                    $('#kota').val(data.kota.nama)
                    $('#kecamatan').val(data.kecamatan.nama)
                    $('#kodepos').val(data.kodepos)
                    $('#alamat').val(data.alamat)
                    $('#modal-show').modal('show')
                }
            }
        })
    })

    function idCustomer(id) {
        console.log(id)
        $('#modal-delete').modal('show')
        $('#id_customer').val(id)
    }

    $('body').on('click', '.btn-delete-ask', function () {
        $('#modal-delete-confirm').modal('show')
    })

</script>
@endsection
