@extends('base')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="float-right mb-3">
                <button id="btn-filter" class="btn btn-primary">Filter <i class="fas fa-filter"></i></button>
              </div>
            </div>   
          </div>

          <div class="row">
            <div class="col-sm-4">
                <div class="small-box bg-light card-success card-outline">
                  <div class="inner">
                    <p>Final Invoice</p>
                    <h3>{{ $countStatusFinal }}</h3>
                  </div>
                  <div class="icon text-success">
                    <i class="fas fa-stamp"></i>
                  </div>
                  <a href="javascript:void(0)" data-status="Final" class="small-box-footer btn-status">more info <i class="fas fa-info-circle text-info"></i></i></a>
                </div>
            </div>

            <div class="col-sm-4">
              <div class="small-box bg-light card-warning card-outline">
                <div class="inner">
                  <p>Draft Invoice</p>
                  <h3>{{ $countStatusDraft }}</h3>
                </div>
                <div class="icon text-warning">
                  <i class="fas fa-pencil-ruler"></i>
                </div>
                <a href="javascript:void(0)" data-status="Draft" class="small-box-footer btn-status">more info <i class="fas fa-info-circle text-info"></i></i></a>
              </div>
            </div>

          <div class="col-sm-4">
            <div class="small-box bg-light card-danger card-outline">
              <div class="inner">
                <p>Cancel Invoice</p>
                <h3>{{ $countStatusCancel }}</h3>
              </div>
              <div class="icon text-danger">
                <i class="fas fa-window-close"></i>
              </div>
              <a href="javascript:void(0)" data-status="Cancel" class="small-box-footer btn-status">more info <i class="fas fa-info-circle text-info"></i></i></a>
            </div>
          </div>

        </div> 

        <div class="card card-primary card-outline">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="float-left">
                  <h4>Invoice Status</h4>
                </div>
               
                <div class="float-right">
                  <select name="filter_status" id="filter_status" class="form-control select2">
                    <option value="">All Status</option>
                    <option value="Final">Final</option>
                    <option value="Draft">Draft</option>
                    <option value="Cancel">Cancel</option>
                  </select>
                </div>
               
              </div>

            </div>
            
            <table class="table">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>No. Invoice</th>
                  <th>Tanggal</th>
                  <th>Perihal</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody id="tbody-invoice">
                @if (count($invoice)>0)
                  @foreach ($invoice as $key=>$item)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $item->nomor_invoice }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->perihal }}</td>
                    <td>{{ $item->status }}</td>
                  </tr> 
                  @endforeach
                @else
                    <tr class="text-center">
                      <td colspan="5">Data Tidak Ditemukan</td>
                    </tr>
                @endif
               
              </tbody>
            </table>
        
          </div>
        </div>
       
     
        
        {{-- MODAL --}}
        <div class="modal fade" id="modal-more-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">More Status</h5>
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
                                  <th>Tanggal Invoice</th>
                                  <th>Status</th>
                                  <th>Perihal</th>
                              </tr>
                          </thead>
                          <tbody id='tbody-status'></tbody>
                      </table>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </div>
          </div>
        </div> 
         
        <div class="modal fade" id="modal-status-not-found" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Informasi </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <p>Status Invoice ini masih kosong </p>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>                               
                  </div>
              </div>
          </div>
        </div>

        <div class="modal fade" id="modal-filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <form action="{{ route('dashboard') }}" method="POST" id="form-filter">
                        @csrf
                        <label for="filter_month">Bulan</label>
                        <select name="filter_month" id="filter_month" class="form-control select2">
                          <option value="">All Month</option>
                          @for ($i = 0; $i < 12; $i++)
                          <option value="{{ date('n',strtotime(sprintf('%d months',$i))) }}" {{ request('filter_month')== date('n',strtotime(sprintf('%d months',$i))) ?'selected':'' }}>{{ date('F',strtotime(sprintf('%d months',$i))) }}</option>
                          @endfor
                          <option value=""></option>
                        </select>
                        <label for="filter_year">Tahun</label>
                        <select name="filter_year" id="filter_year" class="form-control select2">
                          <option value="">All Year</option>
                          @for ($i = date('Y'); $i >= 2000; $i--) 
                          <option value="{{ $i }}" {{request('filter_year')==$i ? 'selected':'' }} >{{ $i }}</option> 
                          @endfor
                        </select>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>                               
                      <button type="button" class="btn btn-success" id="btn-filter-confirm">Filter</button>                               
                  </div>
              </div>
          </div>
        </div>

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
@endsection

@section('script')
<script>
    $('body').on('click', '.btn-status', function(){
        console.log($(this).data('status'))
        let status = $(this).data('status')
        var month = $('#filter_month').val()
        var year = $('#filter_year').val()
       
        $.ajax({
            url:"{{ route('showstatus') }}",
            type:'GET',
            data:{
                status:status,
                month:month,
                year:year
            },
            success:function(data){
                console.log(data)
                if(data.status == '404') $('#modal-status-not-found').modal('show')
                
                if (data.status=='200'){
                    $('#tbody-status').empty()
                    $.each(data.data, function(i, v){
                        let row = "<tr>"+
                                "<td>"+(i+1)+"</td>"+
                                "<td>"+v.nomor_invoice+"</td>"+
                                "<td>"+v.tanggal+"</td>"+
                                "<td>"+v.status+"</td>"+
                                "<td>"+v.perihal+"</td>"+                                
                            "</tr>"
                        $('#tbody-status').append(row)
                    })
                    $('#modal-more-status').modal('show')
                }
            }
        })
    })

    $('#filter_status').on('change', function(){
      var status = $(this).val()
      var month = $('#filter_month').val()
      var year = $('#filter_year').val()
      $.ajax({
            url:"{{ route('showstatus') }}",
            type:'GET',
            data:{
                status:status,
                month:month,
                year:year
            },
            success:function(data){
                console.log(data)
                if(data.status == '404'){
                  $('#tbody-invoice').empty()
                  let row = "<tr class='text-center'><td colspan='5'>Data Tidak Ditemukan</td></tr>"
                  $('#tbody-invoice').append(row)
                }
                
                if (data.status=='200'){
                    $('#tbody-invoice').empty()
                    $.each(data.data, function(i, v){
          
                        let row = "<tr>"+
                                "<td>"+(i+1)+"</td>"+
                                "<td>"+v.nomor_invoice+"</td>"+
                                "<td>"+v.tanggal+"</td>"+
                                "<td>"+v.perihal+"</td>"+
                                "<td>"+v.status+"</td>"+                               
                            "</tr>"
                        $('#tbody-invoice').append(row)
                    })
                }
            }
        })
    })

    $('body').on('click', '#btn-filter', function(){
        $('#modal-filter').modal('show')
    })

    $('#btn-filter-confirm').click(function(){
      $('#form-filter').submit()
    })

</script>  
@endsection

