@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Pekerjaan
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('job') }}">Pekerjaan</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          
          <button onclick="addForm()" id="tambah_pekerjaan" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Tambah Pekerjaan</button>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
          <table id="pekerjaan-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="2%">ID</th>
                    <th width="20%">Pekerjaan</th>
                    <th width="*">Keterangan</th>
                    <th width="10%">Harga</th>
                    <th width="13%">Komisi</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
                <tr>
                    <th width="2%">ID</th>
                    <th width="20%">Pekerjaan</th>
                    <th width="*">Keterangan</th>
                    <th width="10%">Harga</th>
                    <th width="13%">Komisi</th>
                    <th width="15%">Aksi</th>
                </tr>
            </tfoot>
          </table>
        </div>
        </div>
      
      </div>


      <div class="modal" id="modal-pekerjaan" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form id="form-contact" method="post" class="form-horizontal" data-toggle="validator">
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
                          <label for="job_name" class="col-md-3 control-label">Nama Pekerjaan  :</label>
                          <div class="col-md-8">
                              <input type="text" id="job_name" name="job_name" class="form-control" autofocus required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="description" class="col-md-3 control-label">Deskripsi :</label>
                        <div class="col-md-8">
                            <textarea style="height: 80px;" id="description" name="description" class="form-control"></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                      </div>

                      
                      <div class="form-group">
                          <label for="price" class="col-md-3 control-label">Harga   :</label>
                          <div class="col-md-8">
                              <input type="number" id="price" name="price" class="form-control" required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="comm" class="col-md-3 control-label">Komisi Teknisi   :</label>
                          <div class="col-md-8">
                              <input type="decimal" id="comm" name="comm" class="form-control" placeholder="Dalam Persen" required>
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
      
          var table = $('#pekerjaan-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.job') }}",
              columns: [
                {data:'id', name: 'id'},
                {data:'job_name', name: 'job_name'},
                {data:'description', name: 'description'},
                {data:'price', name: 'price'},
                {data:'comm', name: 'comm'},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });


          function addForm(){
              save_method = "add";
              $('input[name=_method]').val('POST');
              $('#modal-pekerjaan').modal('show');
              $('#modal-pekerjaan form')[0].reset();
              $('.modal-title').text('Tambah Data Pekerjaan');
          }


          function editForm(id){
              save_method = 'edit';
              $('input[name=_method]').val('PATCH');
              $('#modal-pekerjaan form')[0].reset();
              $.ajax({
                  url: "{{ url('job') }}" + '/'+id+'/edit',
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){
                      $('#modal-pekerjaan').modal("show");
                      $('.modal-title').text("Edit Data Pekerjaan");

                      $('#id').val(data.id);
                      $('#job_name').val(data.job_name);
                      $('#description').val(data.description);
                      $('#price').val(data.price);
                      $('#comm').val(data.comm);
                                           
                },

                error: function(){
                  alert("Nothing Data....");
                }

              });
          }

          $(function(){
              $('#modal-pekerjaan form').validator().on('submit', function(e){
                  if(!e.isDefaultPrevented()){
                      var id = $('#id').val();
                      if(save_method =='add')  url = "{{ url('job') }}";
                      else url = "{{ url('job') .'/'}}"+ id;
                      $.ajax({
                          url : url,
                          type : "POST",
                          data : $('#modal-pekerjaan form').serialize(),
                          success : function(data){
                           
                            $('#modal-pekerjaan').modal('hide');
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
                    url  : "{{ url('job') }}" + '/'+id,
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
                      HTML += '<tr><td width="150">Foto</td><td width="10">:</td><td><img class="img-rounded" style="width:200px;height:220px" src="./upload/pelanggan/'+data.customer_foto+'"></td></tr>';
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