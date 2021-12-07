<script src="{{ asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.min.js')}}"></script>
{{-- Select2 --}}
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
    $(".select2").select2();
</script>
{{-- datatables --}}
<!-- DataTables -->
<script src="{{url('assets/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{url('assets/plugins/datatables-buttons/js/dataTables.buttons.js') }}"></script>
<script src="{{url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/js/formatNumber.js') }}"></script>
<script> 
    $('.datatable').DataTable({})

    function setHarga(val, parent, child){
        console.log(parent)
        console.log(child)
        if (val != ''){
            //val = Math.trunc($(parent).val())
            val = parseInt($(parent).val().replace(/\D/g,''))
        }else{
            val = 0
        }
        console.log(val)
        $(parent).closest('tr').find(child).val(val)
        let locale4 = val.toLocaleString()
        $(parent).val(locale4)
    }
</script>
