@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Service 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="javascript:void(0)">Service</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          
          <a href="{{ url('service/create') }}"><button id="tambah_tservice" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah Service</button></a>
          <div style="margin-bottom: 30px"></div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id="service-table" class="table table-striped table-hover">
              <thead>
                  <tr>
                      <th width="1%">ID</th>
                      <th width="10%">Tgl</th>
                      <th width="10%">TT</th>
                      <th width="10%">Invoice</th>
                      <th width="10%">Pelanggan</th>
                      <th width="10%">Item</th>
                      <th width="10%">Techn.</th>
                      <th width="*">Catatan</th>
                      <th width="10%">Total</th>
                      <th width="8%">Status</th>
                      <th width="17%">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                
              </tbody>
              <tfoot>
                  <tr>
                      <th width="1%">ID</th>
                      <th width="10%">Tgl</th>
                      <th width="10%">TT</th>
                      <th width="10%">Invoice</th>
                      <th width="10%">Pelanggan</th>
                      <th width="10%">Item</th>
                      <th width="10%">Techn.</th>
                      <th width="*">Catatan</th>
                      <th width="10%">Total</th>
                      <th width="8%">Status</th>
                      <th width="17%">Aksi</th>
                  </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- ================================================================================================= -->
  
                                <!-- JAVA-SCRPIT CODED BY INDRA RAHDIAN,  -->
                                           <!-- 18 JULI 2019 -->

  <!-- ================================================================================================= -->
  <script type="text/javascript">

          // created by indra rahdian

          // datatable  
          var table = $('#service-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.service') }}",
              order: [[ 0, "desc" ]],
              columns: [
                {data:'id',         name: 'id'},
                {data:'created_at', name: 'created_at'},
                {data:'ttno',       name: 'ttno'},
                {data:'invoice',       name: 'invoice'},
                {data:'customer_name',  name: 'customer_name'},
                {data:'item_name',  name:'item_name'},
                {data:'nama',  name:'nama'},
                {data:'note', name: 'nota', orderable:false},
                {data:'total',    name: 'total'},
                {data:'status',name: 'status'},
                {data:'action',     name: 'action', orderable:false, searchable:false}
              ]
          });

          
          
          $('#service-table').on('click', '#btn_hapus_service', function(){
                var popup = confirm('Anda Yakin Ingin Menghapus Data...?');
                
                var id = $(this).attr("data-id");
                var invoice = $(this).attr("data-inv");
                var ttno = $(this).attr("data-tt");

                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                if(popup == true){
                    $.ajax({
                        url  : "{{ url('hapus_service') }}" + '/'+id,
                        type : "POST",
                        dataType :"JSON",
                        data : {'_method':'DELETE', '_token':csrf_token, 'id':id, 'invoice':invoice, 'ttno':ttno},
                        success : function(data){
                                reloadTable();
                                alert('Data Berhasil Dihapus')
                              },
                        error: function(){
                          alert('Opps! Something error !');
                        }

                    });
                }
          });


          $('#service-table').on('click', '#btn_cetak_service', function(){
                var invoice = $(this).attr("data-inv");
                var tt = $(this).attr("data-tt");

                $('#loadingProgress').show();
                $.ajax({
                      url : "{{ url('cetak_invoice_service')}}"+"/"+invoice,
                      type : "GET",
                      success : function(data){
                          $('#loadingProgress').hide();
                          window.open("{{ url('cetak_invoice_service')}}"+"/"+invoice, "Faktur", "height=900, width=1000, scrollbars=yes");
                          reloadTable();
                      },
                      error: function(){
                          $('#loadingProgress').hide();
                          alert("OPPS Something Error");
                      }

                });
          });
          
          // refresh tabel
          function reloadTable() {
            $("#service-table").DataTable().ajax.reload(null,false);
          }
      
      
  </script>

  @endsection