@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Proses Pembelian
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('purchase') }}">Proses Pembelian</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          
          <a href="{{ url('addPurchase') }}"><button id="tambah_purchase" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Pembelian</button></a>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
          <table id="purchase-table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th width="2%">ID</th>
                    <th width="10%">Tanggal</th>
                    <th width="10%">Invoice</th>
                    <th width="15%">Supplier</th>
                    <th width="6%">Tipe</th>
                    <th width="10%">DP</th>
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
                    <th width="10%">Invoice</th>
                    <th width="15%">Supplier</th>
                    <th width="6%">Tipe</th>
                    <th width="10%">DP</th>
                    <th width="*">Deskripsi</th>
                    <th width="15%">Total</th>
                    <th width="15%">Aksi</th>
                </tr>
            </tfoot>
          </table>
        </div>
        </div>
      
      </div>



      <div class="modal" id="modal-lihat" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
          <div class="modal-content">
          
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"> &times; </span>
                  </button>
                  <h3 class="modal-title">Lihat Data Teknisi</h3>
              </div>

              <div class="modal-body" id="isi-lihat">

                

              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>

              
          </div>
        </div>
      </div> <!--end modal-->



      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



<script type="text/javascript">
      
          var table = $('#purchase-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.purchase') }}",
              order: [[ 0, "desc" ]],
              columns: [
                {data:'id', name: 'id'},
                {data:'created_at', name: 'created_at'},
                {data:'invoice', name: 'invoice'},
                {data:'supplier_name', name: 'supplier_name'},
                {data:'tipe', name: 'tipe'},
                {data:'dp', name: 'dp'},
                {data:'description', name: 'description'},
                {data:'total', name: 'total'},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });


          function addForm(){
              save_method = "add";
              $('input[name=_method]').val('POST');
              $('#modal-expense').modal('show');
              $('#modal-expense form')[0].reset();
              $('.modal-title').text('Tambah Proses Pengeluaran');
          }


          function editForm(id){
              save_method = 'edit';
              $('input[name=_method]').val('PATCH');
              $('#modal-expense form')[0].reset();
              $.ajax({
                  url: "{{ url('expense') }}" + '/'+id+'/edit',
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){
                      $('#modal-expense').modal("show");
                      $('.modal-title').text("Edit Data Pengeluaran");

                      $('#id').val(data.id);
                      $('#cost_date').val(data.cost_date);
                      $('#cost_id').val(data.cost_id);
                      $('#description').val(data.description);
                      $('#cost_value').val(data.cost_value);                     
                },

                error: function(){
                  alert("Nothing Data....");
                }

              });
          }


          $(function(){
              $('#modal-expense form').validator().on('submit', function(e){
                  if(!e.isDefaultPrevented()){
                      var id = $('#id').val();
                      if(save_method =='add')  url = "{{ url('expense') }}";
                      else url = "{{ url('expense') .'/'}}"+ id;
                      $.ajax({
                          url : url,
                          type : "POST",
                          data : $('#modal-expense form').serialize(),
                          success : function(data){
                           
                            $('#modal-expense').modal('hide');
                            table.ajax.reload();
                            alert('Data Berhasil Disimpan');
                            
                          },
                          error: function(){
                            alert('Opps! Something error !');
                          }

                      });
                      return false;
                  }
              });

          });


          $('#purchase-table').on('click', '#btn-hapus', function(e){

              var popup = confirm('Anda Yakin Ingin Menghapus Data...?');
              var csrf_token = $('meta[name="csrf-token"]').attr('content');
              if(popup == true){
                  var invoice = $(this).attr("data-inv");
                  var id = $(this).attr("data-id");
              
                  $.ajax({
                      url  : "{{ url('hapus_pembelian') }}",
                      type : "POST",
                      data : {'_method':'DELETE', '_token':csrf_token, 'id':id, 'invoice':invoice},
                      success : function($data){
                              reloadTable();
                              alert('Data Berhasil Dihapus')
                            },
                      error: function(){
                        alert('Opps! Something error !');
                      }


                  });
              }
              
          });


          $('#purchase-table').on('click', '#btn-cetak', function(e){
              
              var id = $(this).attr("data-id");
              var invoice = $(this).attr("data-inv");

              $('#loadingProgress').show();
                  $.ajax({
                        url : "{{ url('cetak_pembelian')}}"+"/"+id+"/"+invoice,
                        type : "GET",
                        success : function(data){
                          $('#loadingProgress').hide();
                          window.open("{{ url('cetak_pembelian')}}"+"/"+id+"/"+invoice, "Nota Pembelian", "height=900, width=1000, scrollbars=yes");
                            reloadTable();
                        },
                        error: function(){
                          $('#loadingProgress').hide();
                           alert("OPPS Something Error");
                        }

                  });

          });



          function reloadTable() {
            $("#purchase-table").DataTable().ajax.reload(null,false);
          }
      
      
</script>

@endsection