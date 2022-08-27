@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Quotation Process
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('quotation') }}">Quotation Process</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          
          <a href="{{ url('addQuote') }}"><button class="btn btn-success"><i class="fa fa-plus"></i> Tambah Quotation</button></a>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
          <table id="quot-table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th width="2%">ID</th>
                    <th width="10%">Tanggal</th>
                    <th width="10%">Quot No</th>
                    <th width="15%">Customer</th>
                    <th width="10%">Attn</th>
                    <th width="10%">Ref</th>
                    <th width="10%">Total</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
                <tr>
                    <th width="2%">ID</th>
                    <th width="10%">Tanggal</th>
                    <th width="10%">Quot No</th>
                    <th width="15%">Customer</th>
                    <th width="10%">Attn</th>
                    <th width="10%">Ref</th>
                    <th width="10%">Total</th>
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
          

          // #table list quotation
          var table = $('#quot-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.quote') }}",
              order: [[ 0, "desc" ]],
              columns: [
                {data:'id', name: 'id'},
                {data:'created_at', name: 'created_at'},
                {data:'quote_no', name: 'quote_no'},
                {data:'customer_name', name: 'customer_name'},
                {data:'attn', name: 'attn'},
                {data:'ref', name: 'ref'},
                {data:'total', name: 'total'},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });



          // #hapus quotation
          $('#quot-table').on('click', '#btn-hapus', function(){
              var indra = confirm("Apakah Anda Ingin Menghapus Quotation Ini....?");
              if(indra === true) {
                  var id = $(this).attr("data-id");
                  var invoice = $(this).attr("data-inv");
                  var _token = $('meta[name="csrf-token"]').attr('content');

                  $.ajax({
                      url : "{{ url('hapus_quotation') }}",
                      type : "POST",
                      data : {id:id, invoice:invoice, _token:_token},
                      success: function(data){
                          reloadTable();
                          alert("Sukses Hapus Quotation...");

                      },
                      error: function(){
                         alert("Something Error...");
                      }
                  }); 
              }
          });



          // #cetak quotation
          $('#quot-table').on('click', '#btn-cetak', function(){
                var invoice = $(this).attr("data-inv");
                var id = $(this).attr("data-id");

                $('#loadingProgress').show();
                $.ajax({
                      url : "{{ url('cetak_invoice_quotation')}}"+"/"+invoice,
                      type : "GET",
                      success : function(data){
                          $('#loadingProgress').hide();
                          window.open("{{ url('cetak_invoice_quotation')}}"+"/"+invoice, "Penawaran", "height=900, width=1000, scrollbars=yes");
                          reloadTable();
                      },
                      error: function(){
                          $('#loadingProgress').hide();
                          alert("OPPS Something Error");
                      }

                });
          });



          function reloadTable() {
            $("#quot-table").DataTable().ajax.reload(null,false);
          }
      
      
</script>

@endsection