@extends('base')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                                <a href="{{ route('users.add') }}" class="btn btn-success" title='Tambah Project'><i
                                        class="fa fa-plus"></i> Add User</a>
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
                                    <th>Nama User</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="actionz">
                                @foreach ($users as $key=>$item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->firstname.' '.$item->lastname}}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->role }}</td>
                                    <td class="text-center">
                                        @can('admin')
                                        <a href="{{ route('users.edit', ['id'=>$item->id]) }}" title='Edit Users'
                                            class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-info btn-sm btn-show"
                                            title='Show User' data-id="{{ $item->id }}"><i
                                                class="fa fa-exclamation-circle"></i></a>
                                        <a type="button" class="btn btn-danger btn-sm btn-delete"
                                            onclick="idUsers({{$item->id}})" title='Delete'><i
                                                class="far fa-trash-alt"></i></i></a>
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
                            <h5 class="modal-title" id="exampleModalLabel">Detail User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id='form-detail'>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="id_user">Nama User</label>
                                            <input type="text" class="form-control" id='nama_user' readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id='username' readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="firstname">First Name</label>
                                            <input name="firstname" id="firstname" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="lastname">Last Name</label>
                                            <input type="text" readonly="readonly" class="form-control" id="lastname">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" readonly="readonly" class="form-control" id="email">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <input type="text" readonly="readonly" class="form-control" id="role">
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
                            <p>Anda akan menghapus data user ini </p>
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
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Data User akan dihapus. Anda yakin? </p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('users.delete') }}" method="post">
                                @csrf
                                <input type="hidden" id="id_user" name="id_user">
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
            url: "{{ route('users.show') }}",
            type: 'GET',
            data: {
                id: id
            },
            success: function (data) {
                console.log(data)
                if (data.status == 200) {
                    data = data.data
                    $('#nama_user').val(data.firstname + ' ' + data.lastname)
                    $('#username').val(data.username)
                    $('#firstname').val(data.firstname)
                    $('#lastname').val(data.lastname)
                    $('#email').val(data.email)
                    $('#role').val(data.role)
                    $('#modal-show').modal('show')
                }
            }
        })
    })

    function idUsers(id) {
        console.log(id)
        $('#modal-delete').modal('show')
        $('#id_user').val(id)
    }

    $('body').on('click', '.btn-delete-ask', function () {
        $('#modal-delete-confirm').modal('show')
    })

</script>
@endsection
