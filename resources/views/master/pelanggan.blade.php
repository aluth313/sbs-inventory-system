@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Pelanggan
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('customer') }}">Pelanggan</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          
          <button onclick="addForm()" id="tambah_pelanggan" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Tambah Pelanggan</button>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
          <table id="pelanggan-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="2%">ID</th>
                    <th width="20%">Nama</th>
                    <th width="*">Alamat</th>
                    <th width="10%">Telp</th>
                    <th width="13%">Foto</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
                <tr>
                    <th width="30">No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Telp</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
          </table>
        </div>
        </div>
      
      </div>


      <div class="modal" id="modal-pelanggan" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form id="form-contact" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
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
                          <label for="customer_name" class="col-md-3 control-label">Nama Pelanggan  :</label>
                          <div class="col-md-8">
                              <input type="text" id="customer_name" name="customer_name" class="form-control" autofocus required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="customer_address" class="col-md-3 control-label">Alamat Pelanggan :</label>
                        <div class="col-md-8">
                            <textarea style="height: 80px;" id="customer_address" name="customer_address" class="form-control" required></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="jenis_kelamin" class="col-md-3 control-label">Jenis Kelamin :</label>
                        <div class="col-md-8">
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                              <option value=""> -- Pilih -- </option>
                              <option value="Laki-Laki">Laki-Laki</option>
                              <option value="Perempuan">Perempuan</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                      </div>

                    
                      <div class="form-group">
                          <label for="customer_phone" class="col-md-3 control-label">No Handphone   :</label>
                          <div class="col-md-8">
                              <input type="number" id="customer_phone" name="customer_phone" class="form-control" required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>


                      <div class="form-group">
                          <label for="customer_foto" class="col-md-3 control-label">Foto Pelanggan   :</label>
                          <div class="col-md-8">
                              <input type="file" id="customer_foto" name="customer_foto" class="form-control">
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
      
          var table = $('#pelanggan-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.pelanggan') }}",
              columns: [
                {data:'id', name: 'id'},
                {data:'customer_name', name: 'customer_name'},
                {data:'customer_address', name: 'customer_address'},
                {data:'customer_phone', name: 'customer_phone'},
                {data:'customer_foto', name: 'customer_foto'},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });


          function addForm(){
              save_method = "add";
              $('input[name=_method]').val('POST');
              $('#modal-pelanggan').modal('show');
              $('#modal-pelanggan form')[0].reset();
              $('.modal-title').text('Tambah Data Pelanggan');
          }


          function editForm(id){
              save_method = 'edit';
              $('input[name=_method]').val('PATCH');
              $('#modal-pelanggan form')[0].reset();
              $.ajax({
                  url: "{{ url('customer') }}" + '/'+id+'/edit',
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){
                      $('#modal-pelanggan').modal("show");
                      $('.modal-title').text("Edit Data Pelanggan");

                      $('#id').val(data.id);
                      $('#customer_name').val(data.customer_name);
                      $('#customer_address').val(data.customer_address);
                      $('#customer_phone').val(data.customer_phone);
                      $('#jenis_kelamin').val(data.jenis_kelamin);
                      $('#customer_foto').val(data.customer_foto);
                                           
                },

                error: function(){
                  alert("Nothing Data....");
                }

              });
          }

          $(function(){
              $('#modal-pelanggan form').validator().on('submit', function(e){
                  if(!e.isDefaultPrevented()){
                      var id = $('#id').val();
                      if(save_method =='add')  url = "{{ url('customer') }}";
                      else url = "{{ url('customer') .'/'}}"+ id;
                      $.ajax({
                          url : url,
                          type : "POST",
                          // data : $('#modal-teknisi form').serialize(),
                          data : new FormData($('#modal-pelanggan form')[0]),
                          contentType:false,
                          processData:false,
                          success : function(data){
                           
                            $('#modal-pelanggan').modal('hide');
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
                    url  : "{{ url('customer') }}" + '/'+id,
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

          function showForm(id){

              $.ajax({
                  url: "{{ url('customer') }}" + '/'+id,
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){

                      var HTML ='';
                      HTML  = '<div class="table-responsive"><table class="table table-bordered">';
                      HTML += '<tr><td width="150">ID</td><td width="10">:</td><td>'+ data.id +'</td></tr>';
                      HTML += '<tr><td width="150">Nama Pelanggan</td><td width="10">:</td><td>'+ data.customer_name +'</td></tr>';
                      HTML += '<tr><td width="150">Alamat</td><td width="10">:</td><td>'+ data.customer_address +'</td></tr>';
                      HTML += '<tr><td width="150">Jenis Kelamin</td><td width="10">:</td><td>'+ data.jenis_kelamin +'</td></tr>';
                      HTML += '<tr><td width="150">No. Handphone</td><td width="10">:</td><td>'+ data.customer_phone +'</td></tr>';

                      if(data.customer_foto !=null){
                        HTML += '<tr><td width="150">Foto</td><td width="10">:</td><td><img class="img-rounded" style="width:200px;height:220px" src="./laravel/public/upload/pelanggan/'+data.customer_foto+'"></td></tr>';  
                      }
                      else{
                        HTML += '<tr><td width="150">Foto</td><td width="10">:</td><td><img class="img-rounded" style="width:200px;height:220px" src="./laravel/public/images/cust.png"></td></tr>';  
                      }
                      
                      HTML += '</table></div>';
                      $('.modal-title').text('Lihat Data Pelanggan');
                      $('#modal-lihat').modal("show");
                      $('#isi-lihat').html(HTML);
                      
                },

                error: function(){
                  alert("Nothing Data....");
                }

              });
          }

        


    


      
</script>

@endsection