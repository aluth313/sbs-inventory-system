@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Proses Produksi
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('production') }}">Proses Produksi</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          @if(in_array(Auth::user()->level, ['ADMIN','KEPALA PRODUKSI']))
          <a href="{{ url('addProduction') }}"><button id="tambah_purchase" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Produksi</button></a>
          @endif
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
          <table style="font-size:13px;" id="production-table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th width="2%">ID</th>
                    <th width="8%">Tanggal</th>
                    <th width="10%">No Produksi</th>
                    <th width="10%">Customer</th>
                    <th width="10%">Grade</th>
                    <th width="10%">Colour</th>
                    <th width="10%">Hardness</th>
                    <th width="10%">Batch</th>
                    <th width="*">Deskripsi</th>
                    <th width="10%">Total</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
               <tr>
                    <th width="2%">ID</th>
                    <th width="8%">Tanggal</th>
                    <th width="10%">No Produksi</th>
                    <th width="10%">Customer</th>
                    <th width="10%">Grade</th>
                    <th width="10%">Colour</th>
                    <th width="10%">Hardness</th>
                    <th width="10%">Batch</th>
                    <th width="*">Deskripsi</th>
                    <th width="10%">Total</th>
                    <th width="15%">Aksi</th>
                </tr>
            </tfoot>
          </table>
        </div>
        </div>
      
      </div>



      <div class="modal fade" id="modal-cetak" tabindex="1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
          
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"> &times; </span>
                  </button>
                  <h3 class="modal-title">Print Produksi Berdasarkan Antrian</h3>
              </div>

              <div class="modal-body" id="isi-cetak">
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>

              
          </div>
        </div>
      </div> <!--end modal-->
      
      
      <div class="modal fade" id="modal-adjust" tabindex="1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
             <form id="frmadjust" method="POST" action="{{ url('production') }}" >
                 {{ csrf_field() }}             
              <div class="modal-header">
                  <input type="hidden" id="idbatch" name="idbatch">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"> &times; </span>
                  </button>
                  <h3 class="modal-title">Material Adjustment</h3>
              </div>

              <div class="modal-body" id="isi-adjust">
              </div>

              <div class="modal-footer">
                   <button type="submit" class="btn btn-success">Adjust</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
              
            </form>
              
          </div>
        </div>
      </div> <!--end modal-->



      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



<script type="text/javascript">
                        // <th width="10%">Customer</th>
                        // <th width="10%">Grade</th>
                        // <th width="10%">Colour</th>
                        // <th width="10%">Hardness</th>
                        // <th width="10%">Batch</th>
      
          var table = $('#production-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.production') }}",
              order: [[ 0, "desc" ]],
              columns: [
                {data:'id', name: 'id'},
                {data:'created_at', name: 'created_at'},
                {data:'production_number', name: 'production_number'},
                {data:'customer_name', name: 'customer_name'},
                {data:'grade', name: 'grade'},
                {data:'colour', name: 'colour'},
                {data:'hardness', name: 'hardness'},
                {data:'batch', name: 'batch'},
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


          $('#production-table').on('click', '#btn-hapus', function(e){

              var popup = confirm('Anda Yakin Ingin Menghapus Data...?');
              var csrf_token = $('meta[name="csrf-token"]').attr('content');
              if(popup == true){
                  var invoice = $(this).attr("data-inv");
                  var id = $(this).attr("data-id");
              
                  $.ajax({
                      url  : "{{ url('hapus_produksi') }}",
                      type : "POST",
                      data : {'_method':'DELETE', '_token':csrf_token, 'id':id, 'invoice':invoice},
                      success : function($data){
                           reloadTable();
                           alert('Data Berhasil Dihapus')
                      }
                  });
              }
              
          });


          $('#production-table').on('click', '#btn-cetak', function(e){
              
              var id = $(this).attr("data-id");
              var production_number = $(this).attr("data-inv");

              $('#loadingProgress').show();
                  $.ajax({
                        url : "{{ url('listproduksiantrian')}}"+"/"+id+"/"+production_number,
                        type : "GET",
                        success : function(data){
                          $('#loadingProgress').hide();
                          console.log('prod batch', data);
                          $("#isi-cetak").html(data);
                          $("#modal-cetak").modal("show");
                          
                        }

                  });

          });
          
          
          function printbatch(id, inv) {
              $('#loadingProgress').show();
              $.ajax({
                    url : "{{ url('cetak_produksi')}}"+"/"+id,
                    type : "GET",
                    success : function(data){
                      $('#loadingProgress').hide();
                      window.open("{{ url('cetak_produksi')}}"+"/"+id, "Nota Produksi", "height=900, width=1000, scrollbars=yes");
                        reloadTable();
                    }

              });

          }
          
          
          function adjustmaterial(id, qt){
              var csrf_token = $('meta[name="csrf-token"]').attr('content');
              $.ajax({
                  url : "{{ url('adjust') }}",
                  type : "POST",
                  data: {'id':id, 'qt':qt, '_token':csrf_token},
                  success :function(data) {
                        console.log('adjust', data);
                        $("#isi-adjust").html(data);
                        $("#idbatch").val(id);
                        $("#modal-adjust").modal('show');        
                  }
              });
              
          }
          
          
          $("#frmadjust").submit(function(e){
              e.preventDefault();
              $.ajax({
                  url : "{{ 'updateadjust' }}",
                  type : "POST",
                  dataType : "JSON",
                  data : $("#frmadjust").serialize(),
                  success : function(data) {
                      $("#modal-adjust").modal("hide");
                  }
              })
          })
          
          
          function adjustpersen(id, qty, hitung) {
              var nilaipersen = $("#adper_"+id).val();
              var perkalian = ((nilaipersen * qty)/hitung) /100;
              $("#ad_"+id).val(perkalian);
              
          }
          
          
          function reloadTable() {
            $("#production-table").DataTable().ajax.reload(null,false);
          }
      
      
</script>

@endsection