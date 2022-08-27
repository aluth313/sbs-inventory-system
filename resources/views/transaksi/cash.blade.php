@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kas
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="javascript:void(0)">Kas</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          
          <button onclick="addForm()" id="tambah_service" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Proses Kas</button>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
          <table id="cash-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th width="2%">ID</th>
                    <th width="8%">No Cash</th>
                    <th width="10%">Tanggal</th>
                    <th width="10%">Tgl Trans</th>
                    <th width="15%">Kategori</th>
                    <th width="*">Deskripsi</th>
                    <th width="15%">Nilai</th>
                    <th width="12%">Aksi</th>
                </tr>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
                <tr>
                    <th width="2%">ID</th>
                    <th width="8%">No Cash</th>
                    <th width="10%">Tanggal</th>
                    <th width="10%">Tgl Trans</th>
                    <th width="15%">Kategori</th>
                    <th width="*">Deskripsi</th>
                    <th width="15%">Nilai</th>
                    <th width="12%">Aksi</th>
                </tr>
            </tfoot>
          </table>
        </div>
        </div>
      
      </div>


      <div class="modal" id="modal-cash" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form id="form-cash" method="post" class="form-horizontal" data-toggle="validator">
                  {{ csrf_field() }} {{ method_field('POST') }}
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true"> &times; </span>
                      </button>
                      <h3 class="modal-title"></h3>
                  </div>

                  <div class="modal-body">
                      <input type="hidden" id="id" name="id">
                      <div class="form-group">
                          <label for="trans_date" class="col-md-3 control-label">Tanggal Transaksi :</label>
                          <div class="col-md-8">
                              <input type="date" id="trans_date" name="trans_date" class="form-control" required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="category" class="col-md-3 control-label">Kategori :</label>
                          <div class="col-md-8">
                              <select id="category" name="category" class="form-control" required>
                                  <option value=""> - Pilih Kategori - </option>
                                  <option value="1">Kas Masuk</option>
                                  <option value="2">kas Keluar</option>
                              </select>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="description" class="col-md-3 control-label">Deskripsi :</label>
                        <div class="col-md-8">
                            <textarea style="height: 80px;" id="description" name="description" class="form-control" required></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="cash_value" class="col-md-3 control-label">Jumlah Kas (Rp.) :</label>
                        <div class="col-md-8">
                            <input type="number" id="cash_value" name="cash_value" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                      </div>

                  </div>

                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary btn-save">Submit</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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
      
          var table = $('#cash-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.cash') }}",
              columns: [
                {data:'id', name: 'id'},
                {data:'cash_number', name: 'cash_number'},
                {data:'created_at', name: 'created_at'},
                {data:'trans_date', name: 'trans_date'},
                {data:'category', name: 'category'},
                {data:'description', name: 'description'},
                {data:'cash_value', name: 'cash_value'},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });



          function addForm(){
              save_method = "add";
              $('input[name=_method]').val('POST');
              $('#modal-cash').modal('show');
              $('#modal-cash form')[0].reset();
              $('.modal-title').text('Tambah Proses Kas');
          }


          function editForm(id){
              save_method = 'edit';
              $('input[name=_method]').val('PATCH');
              $('#modal-cash form')[0].reset();
              $.ajax({
                  url: "{{ url('cash') }}" + '/'+id+'/edit',
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){
                      $('#modal-cash').modal("show");
                      $('.modal-title').text("Edit Proses Kas");

                      $('#id').val(data.id);
                      $('#trans_date').val(data.trans_date);
                      $('#category').val(data.category);
                      $('#description').val(data.description);
                      $('#cash_value').val(data.cash_value);                     
                },

                error: function(){
                  alert("Nothing Data....");
                }

              });
          }


          $(function(){
              $('#modal-cash form').validator().on('submit', function(e){
                  if(!e.isDefaultPrevented()){
                      var id = $('#id').val();
                      if(save_method =='add')  url = "{{ url('cash') }}";
                      else url = "{{ url('cash') .'/'}}"+ id;
                      $.ajax({
                          url : url,
                          type : "POST",
                          data : $('#modal-cash form').serialize(),
                          success : function(data){
                           
                            $('#modal-cash').modal('hide');
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




          function deleteData(id){
            var popup = confirm('Anda Yakin Ingin Menghapus Data...?');
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            if(popup == true){
                $.ajax({
                    url  : "{{ url('cash') }}" + '/'+id,
                    type : "POST",
                    data : {'_method':'DELETE', '_token':csrf_token},
                    success : function($data){
                            table.ajax.reload();
                            alert('Data Berhasil Dihapus')
                          },
                    error: function(){
                      alert('Opps! Something error !');
                    }


                });
            }
          }


          function printData(id){
              $('#loadingProgress').show();
              $.ajax({
                  url     : "{{ url('cetak_cash')}}"+"/"+id,
                  type    : "GET",
                  success : function(data){
                    $('#loadingProgress').hide();
                    window.open("{{ url('cetak_cash')}}"+"/"+id, "Bukti Kas ", "height=900, width=1000, scrollbars=yes");
                      reloadTable();
                  },
                  error: function(){
                    $('#loadingProgress').hide();
                     alert("OPPS Something Error");
                  }
              });
          }

      
      
</script>

@endsection