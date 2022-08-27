@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Teknisi
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('teknisi') }}">Teknisi</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          
          <button onclick="addForm()" id="tambah_teknisi" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Tambah Teknisi</button>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
          <table id="teknisi-table" class="table table-bordered table-striped">
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


      <div class="modal" id="modal-teknisi" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
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
                          <label for="nama" class="col-md-3 control-label">Nama Lengkap   :</label>
                          <div class="col-md-8">
                              <input type="text" id="nama" name="nama" class="form-control" autofocus required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="alamat" class="col-md-3 control-label">Alamat :</label>
                        <div class="col-md-8">
                            <textarea style="height: 80px;" id="alamat" name="alamat" class="form-control" required></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="jkelamin" class="col-md-3 control-label">Jenis Kelamin :</label>
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
                          <label for="tgl_lahir" class="col-md-3 control-label">Tanggal Lahir   :</label>
                          <div class="col-md-8">
                              <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control"required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="hp" class="col-md-3 control-label">No Handphone   :</label>
                          <div class="col-md-8">
                              <input type="number" id="hp" name="hp" class="form-control" required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="ktp" class="col-md-3 control-label">No KTP   :</label>
                          <div class="col-md-8">
                              <input type="number" id="no_ktp" name="no_ktp" class="form-control">
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="password" class="col-md-3 control-label">Password  :</label>
                          <div class="col-md-8">
                              <input type="password" id="password" name="password" class="form-control" required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="foto" class="col-md-3 control-label">Foto Diri   :</label>
                          <div class="col-md-8">
                              <input type="file" id="foto" name="foto" class="form-control">
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
      
          var table = $('#teknisi-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.teknisi') }}",
              columns: [
                {data:'id', name: 'id'},
                {data:'nama', name: 'nama'},
                {data:'alamat', name: 'alamat'},
                {data:'hp', name: 'hp'},
                {data:'foto', name: 'foto'},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });


          function addForm(){
              save_method = "add";
              $('input[name=_method]').val('POST');
              $('#modal-teknisi').modal('show');
              $('#modal-teknisi form')[0].reset();
              $('.modal-title').text('Tambah Data Teknisi');
          }


          function editForm(id){
              save_method = 'edit';
              $('input[name=_method]').val('PATCH');
              $('#modal-teknisi form')[0].reset();
              $.ajax({
                  url: "{{ url('teknisi') }}" + '/'+id+'/edit',
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){
                      $('#modal-teknisi').modal("show");
                      $('.modal-title').text("Edit Data Teknisi");

                      $('#id').val(data.id);
                      $('#nama').val(data.nama);
                      $('#alamat').val(data.alamat);
                      $('#jenis_kelamin').val(data.jenis_kelamin);
                      $('#tgl_lahir').val(data.tgl_lahir);
                      $('#hp').val(data.hp);
                      $('#no_ktp').val(data.no_ktp);
                      $('#password').val(data.password);
                      $('#foto').val(data.foto);
                      
                },

                error: function(){
                  alert("Nothing Data....");
                }

              });
          }

          $(function(){
              $('#modal-teknisi form').validator().on('submit', function(e){
                  if(!e.isDefaultPrevented()){
                      var id = $('#id').val();
                      if(save_method =='add')  url = "{{ url('teknisi') }}";
                      else url = "{{ url('teknisi') .'/'}}"+ id;
                      $.ajax({
                          url : url,
                          type : "POST",
                          // data : $('#modal-teknisi form').serialize(),
                          data : new FormData($('#modal-teknisi form')[0]),
                          contentType:false,
                          processData:false,
                          success : function(data){
                            if(data.success == true){
                              $('#modal-teknisi').modal('hide');
                              table.ajax.reload();
                              alert('Data Berhasil Disimpan');

                            }
                            
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
                    url  : "{{ url('teknisi') }}" + '/'+id,
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
                  url: "{{ url('teknisi') }}" + '/'+id,
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){

                      var HTML ='';
                      HTML  = '<div class="table-responsive"><table class="table table-bordered">';
                      HTML += '<tr><td width="150">ID</td><td width="10">:</td><td>'+ data.id +'</td></tr>';
                      HTML += '<tr><td width="150">Nama Lengkap</td><td width="10">:</td><td>'+ data.nama +'</td></tr>';
                      HTML += '<tr><td width="150">Alamat</td><td width="10">:</td><td>'+ data.alamat +'</td></tr>';
                      HTML += '<tr><td width="150">Jenis Kelamin</td><td width="10">:</td><td>'+ data.jenis_kelamin +'</td></tr>';
                      HTML += '<tr><td width="150">Tanggal Lahir</td><td width="10">:</td><td>'+ data.tgl_lahir +'</td></tr>';
                      HTML += '<tr><td width="150">No. Handphone</td><td width="10">:</td><td>'+ data.hp +'</td></tr>';
                      HTML += '<tr><td width="150">No KTP</td><td width="10">:</td><td>'+ data.no_ktp +'</td></tr>';
                      HTML += '<tr><td width="150">Password</td><td width="10">:</td><td>'+ data.password +'</td></tr>';
                      HTML += '<tr><td width="150">Foto</td><td width="10">:</td><td><img class="img-rounded" style="width:200px;height:220px" src="laravel/public/upload/teknisi/'+data.foto+'"></td></tr>';
                      HTML += '</table></div>';
                      $('.modal-title').text('Lihat Data Teknisi');
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