@extends('base')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Project</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Project</li>
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
                                <a href="{{ route('project.add') }}" class="btn btn-success" title='Tambah Project'><i
                                        class="fa fa-plus"></i> Tambah Project</a>
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
                        <table id="tableproject" class="table table-bordered dt-responsive nowrap datatable"
                            style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Project</th>
                                    <th>Nama Customer</th>
                                    <th>Tanggal Masuk</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="actionz">
                                @foreach ($project as $key=>$item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->nama_project }}</td>
                                    <td>{{ $item->customer->nama_customer }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td class="text-center">
                                        @can('admin')
                                        <a href="{{ route('project.edit', ['id'=>$item->id]) }}" title='Edit Project'
                                            class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-info btn-sm btn-show"
                                            title='Show Project' data-id="{{ $item->id }}"><i
                                                class="fa fa-exclamation-circle"></i></a>
                                        <a type="button" class="btn btn-danger btn-sm btn-delete"
                                            onclick="idProject({{$item->id}})" title='Delete'><i
                                                class="far fa-trash-alt"></i></i></a>
                                        @endcan
                                        @can('manager')
                                        <a href="javascript:void(0)" class="btn btn-info btn-sm btn-show"
                                            title='Show Project' data-id="{{ $item->id }}"><i
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
                            <h5 class="modal-title" id="exampleModalLabel">Detail Project</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id='form-detail'>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="client">Nama Project</label>
                                            <input type="text" class="form-control" id='nama_project' readonly>
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
                                            <label for="perihal">Nama Customer</label>
                                            <input name="nama_custoner" id="nama_custoner" class="form-control"
                                                readonly>
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
                                            <label for="email">Email</label>
                                            <input name="email" id="email" class="form-control" readonly>
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
                            <p>Data Project akan dihapus. Anda yakin? </p>
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
                            <p>Data Invoice yang tehububung dengan project ini juga akan dihapus. Anda yakin? </p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('project.delete') }}" method="post">
                                @csrf
                                <input type="hidden" id="id_project" name="id_project">
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
            url: "{{ route('project.show') }}",
            type: 'GET',
            data: {
                id: id
            },
            success: function (data) {
                console.log(data)
                if (data.status == 200) {
                    data = data.data
                    $('#nama_project').val(data.nama_project)
                    $('#nama_custoner').val(data.nama_customer)
                    $('#telp').val(data.telp)
                    $('#tanggal').val(data.tanggal)
                    $('#email').val(data.email)
                    $('#modal-show').modal('show')
                }
            }
        })
    })

    function idProject(id) {
        console.log(id)
        $('#modal-delete').modal('show')
        $('#id_project').val(id)
    }

    $('body').on('click', '.btn-delete-ask', function () {
        $('#modal-delete-confirm').modal('show')
    })

</script>
@endsection
