@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        General Settings
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="javascript:void(0)">General Setting</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
        <div class="box">
          <div style="margin-top: 50px"></div>
            <div class="box-body">
              

              @include('_partial.flash_message')
              <div class="col-md-8">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">General Information</h3>
                  </div>
                  <div class="box-body">

                    <form id="form-profil" method="post" action="{{url('setting')}}" data-toggle="validator">
                    {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="form-group">
                          <label>Nama Perusahaan:</label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-building"></i>
                            </div>
                            <input type="text" class="form-control pull-right" name="nama_perusahaan" value="{{$profil->company_name}}">
                            <span class="help-block with-errors"></span>
                          </div>
                          <!-- /.input group -->
                        </div>
                        <!-- /.form group -->

                        <!-- Date range -->
                        <div class="form-group">
                          <label>Title Perusahaan:</label>

                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-credit-card"></i>
                            </div>
                            <input type="text" class="form-control pull-right" name="title_perusahaan" value="{{$profil->company_title}}">
                            <span class="help-block with-errors"></span>
                          </div>
                          <!-- /.input group -->
                        </div>
                        <!-- /.form group -->

                        <!-- Date and time range -->
                        <div class="form-group">
                          <label>Alamat Perusahaan:</label>

                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-map"></i>
                            </div>
                            <input type="text" class="form-control pull-right" name="alamat_perusahaan" value="{{$profil->company_address}}">
                            <span class="help-block with-errors"></span>
                          </div>
                          <!-- /.input group -->
                        </div>
                        <!-- /.form group -->

                        <!-- Date and time range -->
                        <div class="form-group">
                          <label>Nama Penanggung Jawab Perusahaan:</label>

                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                            </div>
                            <input type="text" class="form-control pull-right" name="pemilik" value="{{$profil->owner_name}}">
                            <span class="help-block with-errors"></span>
                          </div>
                          <!-- /.input group -->
                        </div>

                        <!-- Date and time range -->
                        <div class="form-group">
                          <label>No. Telp Perusahaan:</label>

                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-phone"></i>
                            </div>
                            <input type="text" class="form-control pull-right" name="phone" value="{{$profil->owner_phone}}">
                            <span class="help-block with-errors"></span>
                          </div>
                          <!-- /.input group -->
                        </div>

                        <!-- Date and time range -->
                        <div class="form-group">
                          <label>Fax Perusahaan:</label>

                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-fax"></i>
                            </div>
                            <input  type="text" class="form-control pull-right" name="fax" value="{{$profil->fax}}">
                          </div>
                          <!-- /.input group -->
                        </div>


                        <!-- Date and time range -->
                        <div class="form-group">
                          <label>Email Perusahaan:</label>

                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-envelope"></i>
                            </div>
                            <input type="text" class="form-control pull-right" name="email" value="{{$profil->email}}">
                          </div>
                          <!-- /.input group -->
                        </div>


                        <div class="form-group">
                          <label>Bank:</label>

                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-bank"></i>
                            </div>
                            <input type="text" class="form-control pull-right" name="bank" value="{{$profil->bank}}">
                          </div>
                          <!-- /.input group -->
                        </div>



                        <div class="form-group">
                          <label>KCP Bank:</label>

                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-database"></i>
                            </div>
                            <input type="text" class="form-control pull-right" name="kcp" value="{{$profil->kcp}}">
                          </div>
                          <!-- /.input group -->
                        </div>


                        <div class="form-group">
                          <label>No. Rekening:</label>

                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-money"></i>
                            </div>
                            <input type="text" class="form-control pull-right" name="norek" value="{{$profil->norek}}">
                          </div>
                          <!-- /.input group -->
                        </div>

                        <button type="submit" class="btn btn-warning">Update</button>
                    </form>
                  </div>
                  <!-- /.box-body -->
                </div>
          <!-- /.box -->

            </div>
      
        </div>
    <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



<script type="text/javascript">
      
          var table = $('#biaya-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.cost') }}",
              columns: [
                {data:'id', name: 'id'},
                {data:'cost_name', name: 'cost_name'},
                {data:'description', name: 'description'},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });


          function addForm(){
              save_method = "add";
              $('input[name=_method]').val('POST');
              $('#modal-biaya').modal('show');
              $('#modal-biaya form')[0].reset();
              $('.modal-title').text('Tambah Data Biaya');
          }


          function editForm(id){
              save_method = 'edit';
              $('input[name=_method]').val('PATCH');
              $('#modal-biaya form')[0].reset();
              $.ajax({
                  url: "{{ url('cost') }}" + '/'+id+'/edit',
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){
                      $('#modal-biaya').modal("show");
                      $('.modal-title').text("Edit Data Biaya");

                      $('#id').val(data.id);
                      $('#cost_name').val(data.cost_name);
                      $('#description').val(data.description);
                                           
                },

                error: function(){
                  alert("Nothing Data....");
                }

              });
          }

          $(function(){
              $('#modal-biaya form').validator().on('submit', function(e){
                  if(!e.isDefaultPrevented()){
                      var id = $('#id').val();
                      if(save_method =='add')  url = "{{ url('cost') }}";
                      else url = "{{ url('cost') .'/'}}"+ id;
                      $.ajax({
                          url : url,
                          type : "POST",
                          data : $('#modal-biaya form').serialize(),
                          success : function(data){
                           
                            $('#modal-biaya').modal('hide');
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
                    url  : "{{ url('cost') }}" + '/'+id,
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