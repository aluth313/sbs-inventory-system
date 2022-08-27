@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Penjualan
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('sales') }}">Penjualan</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        
        <div style="background-color: beige" class="box-header with-border">
          <div style="margin-top: 10px;" class="row">
            <div class="col-md-12">
              <a href="{{url('addsales')}}"><button class="btn btn-success pull-left"><i class="fa fa-plus" id="tambah_penjualan" name="tambah_penjualan"></i> Tambah Penjualan</button></a>
            </div>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id="sales-table" class="table table-striped table-bordered table-hover">
              <thead>
                  <tr>
                      <th width="2%">ID</th>
                      <th width="8%">Tanggal</th>
                      <th width="15%">Invoice</th>
                      <th width="20%">Customer</th>
                      <th width="8%">Jumlah</th>
                      <th width="8%">DP</th>
                      <th width="*">Deskripsi</th>
                      <th width="12%">Aksi</th>
                  </tr>
              </thead>
              <tbody></tbody>
              <tfoot>
                  <tr>
                      <th width="2%">ID</th>
                      <th width="8%">Tanggal</th>
                      <th width="15%">Invoice</th>
                      <th width="20%">Customer</th>
                      <th width="8%">Jumlah</th>
                      <th width="8%">DP</th>
                      <th width="*">Deskripsi</th>
                      <th width="12%">Aksi</th>
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
      
          var table = $('#sales-table').DataTable({
              processing:true,
              serverSide:true,
              order: [[ 0, "desc" ]],
              ajax: "{{ route('api.sales') }}",
              columns: 
              [
                {data:'id', name: 'id'},
                {data:'created_at', name: 'created_at'},
                {data:'invoice', name: 'invoice'},
                {data:'customer_name', name: 'customer_name'},
                {data:'total', name: 'total'},
                {data:'dp', name: 'dp'},
                {data:'note', name: 'note', orderable:false, searchable:false},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });


        

          $('#sales-table').on('click', '#btn_hapus_sales', function(){
              var indra = confirm("Apakah Anda Ingin Menghapus Data Penjualan Ini....?");
              if(indra === true) {
                  var id = $(this).attr("data-id");
                  var invoice = $(this).attr("data-invoice");
                  var _token = $('meta[name="csrf-token"]').attr('content');

                  $.ajax({
                      url : "{{ url('hapus_penjualan') }}",
                      type : "POST",
                      data : {id:id, invoice:invoice, _token:_token},
                      success: function(data){
                          reloadTable();
                          alert("Sukses Hapus Penjualan...");

                      },
                      error: function(){
                         alert("Something Error...");
                      }
                  }); 
              }
          });

          


          $('#sales-table').on('click', '#btnPrintData', function(){
                var invoice = $(this).attr("data-invoice");
                var id = $(this).attr("data-id");

                $('#loadingProgress').show();
                $.ajax({
                      url : "{{ url('cetak_invoice_sales')}}"+"/"+invoice,
                      type : "GET",
                      success : function(data){
                          $('#loadingProgress').hide();
                          window.open("{{ url('cetak_invoice_sales')}}"+"/"+invoice, "Faktur", "height=900, width=1000, scrollbars=yes");
                          reloadTable();
                      },
                      error: function(){
                          $('#loadingProgress').hide();
                          alert("OPPS Something Error");
                      }

                });
          });




          // $('#sales-table').on('click', '#btnEditSales', function(){
          //       var invoice = $(this).attr("data-invoice");
          
          //       $('#loadingProgress').show();
          //       $.ajax({
          //             url : "{{ url('cetak_invoice_sales')}}"+"/"+invoice,
          //             type : "GET",
          //             success : function(data){
          //                 $('#loadingProgress').hide();
          //                 window.open("{{ url('cetak_invoice_sales')}}"+"/"+invoice, "Faktur", "height=900, width=1000, scrollbars=yes");
          //                 reloadTable();
          //             },
          //             error: function(){
          //                 $('#loadingProgress').hide();
          //                 alert("OPPS Something Error");
          //             }

          //       });
          // });






          function reloadTable() {
            $("#sales-table").DataTable().ajax.reload(null,false);
            // $("#list-table").DataTable().ajax.reload(null,false);
          }
      
</script>

@endsection