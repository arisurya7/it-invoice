@extends('base')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Report</li>
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
                            <div class="float-right">
                                <form action="{{ route('report.printpdf') }}" method="POST" target="_blank">
                                    @csrf
                                    <input type="hidden" name="filter_project" value="{{ $filter['project'] }}">
                                    <input type="hidden" name="filter_status" value="{{ $filter['status'] }}">
                                    <input type="hidden" name="filter_begin_date" value="{{ $filter['begin_date'] }}">
                                    <input type="hidden" name="filter_last_date" value="{{ $filter['last_date'] }}">
                                    <button class="btn btn-success"
                                        {{ !$invoice?'disabled':(count($invoice)>0?'':'disabled') }}> <i
                                            class="fas fa-download"></i> Print Report</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <h4>Filter</h4>
                    <form action="{{ route('report') }}" , method="POST">
                        @csrf
                        <div class="row mb-3 align-items-end">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="filter_project" class="text-sm"> Project</label>
                                    <select name="filter_project" id="filter_project"
                                        class="form-control select2 filter">
                                        <option value="">All Project</option>
                                        @foreach ($project as $item)
                                        <option value="{{$item->id}}"
                                            {{ request('filter_project')==$item->id?'selected':'' }}>
                                            {{$item->nama_project}} - {{$item->customer->nama_customer}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="filter_status" class="text-sm"> Status</label>
                                    <select name="filter_status" id="filter_status" class="form-control select2 filter">
                                        <option value="">All Status</option>
                                        <option value="Draft" {{ request('filter_status')=='Draft'?'selected':'' }}>
                                            Draft</option>
                                        <option value="Final" {{ request('filter_status')=='Final'?'selected':'' }}>
                                            Final</option>
                                        <option value="Cancel" {{ request('filter_status')=='Cancel'?'selected':'' }}>
                                            Cancel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="filter_begin_date" class="text-sm"> Awal Tanggal</label>
                                    <input type="date" name="filter_begin_date" id="filter_begin_date"
                                        class="form-control filter" value="{{ request('filter_begin_date')}}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="filter_last_date" class="text-sm"> Akhir Tanggal</label>
                                    <input type="date" name="filter_last_date" id="filter_last_date"
                                        class="form-control filter" value="{{ request('filter_last_date') }}">
                                </div>
                            </div>
                            <div class="col-1">
                                <button type="submit" class="btn btn-outline-primary mb-3">Check</button>
                            </div>

                        </div>
                    </form>

                    @if ($invoice != null && count($invoice)>0)
                    <div class="table-responsive">
                        <table id="tableinvoice" class="table table-bordered dt-responsive nowrap" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Invoice</th>
                                    <th>Project</th>
                                    <th>Customer</th>
                                    <th>Tanggal</th>
                                    <th>Perihal</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="actionz">
                                @foreach ($invoice as $key=>$item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{$item->nomor_invoice}}</td>
                                    <td>{{$item->project->nama_project}}</td>
                                    <td>{{$item->project->nama_perusahaan}}</td>
                                    <td>{{date('d-m-Y',strtotime($item->tanggal))}}</td>
                                    <td>{{$item->perihal}}</td>
                                    <td>{{$item->status}}</td>
                                    <td>{{$item->total}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-center">Tidak ditemukan, silahkan filter ulang invoice</p>
                    @endif

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
