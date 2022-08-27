@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Material
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('material') }}">Material</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          
          <button onclick="addForm()" id="tambah_barang" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Tambah Material</button>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
          <table id="material-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="2%">ID</th>
                    <th width="24%">Nama Material</th>
                    <th width="15%">Kategori</th>
                    <th width="8%">Satuan</th>
                    <th width="10%">H.Beli</th>
                    <th width="12%">Stok</th>
                    <th width="12%">Stok MDI</th>
                    <th width="*">Keterangan</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
                <tr>
                    <th width="2%">ID</th>
                    <th width="24%">Nama Material</th>
                    <th width="10%">Kategori</th>
                    <th width="8%">Satuan</th>
                    <th width="10%">H.Beli</th>
                    <th width="12%">Stok</th>
                    <th width="12%">Stok MDI</th>
                    <th width="*">Keterangan</th>
                    <th width="25%">Aksi</th>
                </tr>
            </tfoot>
          </table>
        </div>
        </div>
      
      </div>


      <div class="modal fade" id="modal-barang" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form id="form-material" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data" >
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
                          <label for="good_name" class="col-md-3 control-label">Nama Material  :</label>
                          <div class="col-md-8">
                              <input type="text" id="material_name" name="material_name" class="form-control" autofocus required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="kategori" class="col-md-3 control-label">Kategori :</label>
                        <div class="col-md-8">
                            <select id="kategori" name="kategori" class="form-control" required>
                              <option value=""> -- Pilih Kategori -- </option>
                              @foreach($kat as $row)
                                <option value="{{ $row->id }}">{{ $row->category_name }}</option>
                              @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="unit" class="col-md-3 control-label">Unit :</label>
                        <div class="col-md-8">
                            <select id="unit" name="unit" class="form-control" required>
                              <option value=""> -- Pilih Satuan -- </option>
                              @foreach($data as $row)
                                <option value="{{ $row->unit }}">{{ $row->unit }}</option>
                              @endforeach
                            </select>
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
                          <label for="b_price" class="col-md-3 control-label">Harga Beli :</label>
                          <div class="col-md-8">
                              <input type="number" id="b_price" name="b_price" class="form-control" required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      

                      <div class="form-group">
                          <label for="stok" class="col-md-3 control-label">Stok :</label>
                          <div class="col-md-8">
                              <input type="text" id="stok" name="stok" class="form-control" required>
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
      
          var table = $('#material-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.material') }}",
              columns: [
                {data:'id', name: 'id'},
                {data:'material_name', name: 'material_name'},
                {data:'category_name', name: 'kategori'},
                {data:'unit', name: 'unit'},
                {data:'b_price', name: 'b_price'},
                {data:'stok', name: 'stok'},
                {data:'stok_2', name: 'stok_2'},
                {data:'description', name: 'description'},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });


          function addForm(){
              save_method = "add";
              $('input[name=_method]').val('POST');
              $('#modal-barang').modal('show');
              $('#modal-barang form')[0].reset();
              $('#stok').removeAttr("disabled");
              $('.modal-title').text('Tambah Data Material');
          }


          function editForm(id){
              save_method = 'edit';
              $('input[name=_method]').val('PATCH');
              $('#modal-barang form')[0].reset();
              $.ajax({
                  url: "{{ url('material') }}" + '/'+id+'/edit',
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){
                      

                      $('#id').val(data.id);
                      $('#material_name').val(data.material_name);
                      $('#kategori').val(data.kategori);
                      $('#unit').val(data.unit);
                      $('#description').val(data.description);
                      $('#b_price').val(data.b_price);
                      $('#stok').val(data.stok);
                      $('#stok').attr("disabled",true);
                      $('#modal-barang').modal("show");
                      $('.modal-title').text("Edit Data Material");
                     
                                           
                }

              });
          }


          $(function(){
              $('#modal-barang form').validator().on('submit', function(e){
                  if(!e.isDefaultPrevented()){
                      var id = $('#id').val();
                      if(save_method =='add')  url = "{{ url('material') }}";
                      else url = "{{ url('material') .'/'}}"+ id;
                      $.ajax({
                          url : url,
                          type : "POST",
                          data : new FormData($('#modal-barang form')[0]),
                          contentType:false,
                          processData:false,
                          success : function(data){
                            if(data.success == true){
                              $('#modal-barang').modal('hide');
                              table.ajax.reload();
                              alert('Data Berhasil Disimpan');
                            }
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
                    url  : "{{ url('material') }}" + '/'+id,
                    type : "POST",
                    data : {'_method':'DELETE', '_token':csrf_token},
                    success : function(data){
                            table.ajax.reload();
                            alert('Data Berhasil Dihapus')
                    }
                });
            }
          }


          function lihatFoto(id) {
            $.ajax({
                url      :  "{{ url('foto') }}"+'/'+id,
                type     :  "GET",
                dataType :  "JSON",
                success  :   function(data){
                    
                    $('#isi-foto').html(data);
                    $('.modal-title').html('Lihat Foto Barang');
                    $('#modal-foto').modal("show");
                },
                error    :   function(){
                    alert("Something Error Happens...");
                }
            });

          }

        
</script>

@endsection