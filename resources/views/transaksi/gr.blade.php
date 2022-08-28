@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Proses Penerimaan Barang (Good Receipt)
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('gr') }}">Proses Penerimaan Barang</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          @if(in_array(Auth::user()->level, ['ADMIN','KEPALA PRODUKSI']))
          <a href="{{ url('addGR') }}"><button id="tambah_purchase" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Penerimaan Barang</button></a>
          @endif
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
          <table id="gr-table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th width="2%">ID</th>
                    <th width="10%">Tanggal</th>
                    <th width="10%">GR NO</th>
                    <th width="10%">PO NO</th>
                    <th width="15%">Supplier</th>
                    <th width="*">Deskripsi</th>
                    <th width="15%">Total</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
                  <tr>
                    <th width="2%">ID</th>
                    <th width="10%">Tanggal</th>
                    <th width="10%">GR NO</th>
                    <th width="10%">PO NO</th>
                    <th width="15%">Supplier</th>
                    <th width="*">Deskripsi</th>
                    <th width="15%">Total</th>
                    <th width="15%">Aksi</th>
                </tr>
            </tfoot>
          </table>
        </div>
        </div>
      
      </div>

      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



<script type="text/javascript">
      
          var table = $('#gr-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.gr') }}",
              order: [[ 0, "desc" ]],
              columns: [
                {data:'id', name: 'id'},
                {data:'created_at', name: 'created_at'},
                {data:'gr_no', name: 'gr_no'},
                {data:'po_no', name: 'po_no'},
                {data:'supplier_name', name: 'supplier_name'},
                {data:'description', name: 'description'},
                {data:'total', name: 'total'},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });
          
          
          
          $('#gr-table').on('click', '#btn-hapus', function(e){

              var popup = confirm('Anda Yakin Ingin Menghapus Data...?');
              var csrf_token = $('meta[name="csrf-token"]').attr('content');
              if(popup == true){
                  var invoice = $(this).attr("data-inv");
                  var id = $(this).attr("data-id");
              
                  $.ajax({
                      url  : "{{ url('deletegr') }}",
                      type : "POST",
                      data : {'_method':'DELETE', '_token':csrf_token, id:id, invoice:invoice},
                      success : function($data){
                           reloadTable();
                           alert('Data Berhasil Dihapus')
                      }
                  });
              }
              
          });


          $('#gr-table').on('click', '#btn-cetak', function(e){
              
              var id = $(this).attr("data-id");
              var invoice = $(this).attr("data-inv");

              $('#loadingProgress').show();
                  $.ajax({
                        url : "{{ url('printgr')}}"+"/"+id+"/"+invoice,
                        type : "GET",
                        success : function(data){
                          $('#loadingProgress').hide();
                          window.open("{{ url('printgr')}}"+"/"+id+"/"+invoice, "Bukti Penerimaan Barang", "height=900, width=1000, scrollbars=yes");
                          reloadTable();
                        }
                  });

          });



          function reloadTable() {
            $("#gr-table").DataTable().ajax.reload(null,false);
          }
      
      
</script>

@endsection