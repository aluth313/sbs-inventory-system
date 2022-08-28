@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Barang
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('good') }}">Barang</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          @if(in_array(Auth::user()->level, ['ADMIN','KEPALA PRODUKSI']))
          <button onclick="addForm()" id="tambah_barang" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Tambah Barang</button>
          @endif
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
          <table id="barang-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="2%">ID</th>
                    <th width="18%">Nama Barang</th>
                    <th width="10%">Kategori</th>
                    <th width="7%">Satuan</th>
                    <th width="9%">Co Number</th>
                    <th width="9%">H.Beli</th>
                    <th width="9%">H.Jual</th>
                    <th width="8%">Stok</th>
                    <th width="*">B.Baku</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
                <tr>
                    <th width="2%">ID</th>
                    <th width="18%">Nama Barang</th>
                    <th width="10%">Kategori</th>
                    <th width="7%">Satuan</th>
                    <th width="9%">Co Number</th>
                    <th width="9%">H.Beli</th>
                    <th width="9%">H.Jual</th>
                    <th width="8%">Stok</th>
                    <th width="*">B.Baku</th>
                    <th width="10%">Aksi</th>
                </tr>
            </tfoot>
          </table>
        </div>
        </div>
      
      </div>


      <div class="modal fade" id="modal-barang" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form id="form-contact" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data" >
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
                          <label for="good_name" class="col-md-3 control-label">Nama Barang  :</label>
                          <div class="col-md-8">
                              <input type="text" id="good_name" name="good_name" class="form-control" autofocus required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="co_number" class="col-md-3 control-label">Co Number  :</label>
                        <div class="col-md-8">
                            <input type="text" id="co_number" name="co_number" class="form-control" autofocus required>
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
                        <label for="grade" class="col-md-3 control-label">Grade :</label>
                        <div class="col-md-8">
                            <input type="text" id="grade" name="grade" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                      <div class="form-group">
                        <label for="colour" class="col-md-3 control-label">Colour :</label>
                        <div class="col-md-8">
                            <input type="text" id="colour" name="colour" class="form-control" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                      <div class="form-group">
                        <label for="hardness" class="col-md-3 control-label">Hardness :</label>
                        <div class="col-md-8">
                            <input type="text" id="hardness" name="hardness" class="form-control" autofocus required>
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

                      <input type="hidden" name="b_price" value="0">
                      <input type="hidden" name="s_price" value="0">
                      <input type="hidden" name="r_price" value="0">
                      <input type="hidden" name="d_price" value="0">
                      <input type="hidden" name="stok" value="0">
                      {{-- <div class="form-group">
                          <label for="b_price" class="col-md-3 control-label">Harga Beli :</label>
                          <div class="col-md-8">
                              <input type="number" id="b_price" name="b_price" class="form-control" required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                       <div class="form-group">
                          <label for="s_price" class="col-md-3 control-label">Harga Jual :</label>
                          <div class="col-md-2">
                              <input type="number" id="s_price" name="s_price" class="form-control" required placeholder="Harga Jual Normal">
                              <span class="help-block with-errors"></span>
                          </div>
                          <div class="col-md-2">
                              <input type="number" id="r_price" name="r_price" class="form-control" placeholder="Harga Jual Retail">
                              <span class="help-block with-errors"></span>
                          </div>
                          <div class="col-md-2">
                              <input type="number" id="d_price" name="d_price" class="form-control" placeholder="Harga Jual Distributor">
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="stok" class="col-md-3 control-label">Stok :</label>
                          <div class="col-md-8">
                              <input type="number" id="stok" name="stok" class="form-control" required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div> --}}

                      <div class="form-group" style="display:none;">
                          <label for="foto" class="col-md-3 control-label">Foto Barang   :</label>
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

      <div class="modal fade" id="modal-baku" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"> &times; </span>
                  </button>
                  <h3 class="modal-title modalbahanbaku"></h3>
                  <input type="text" style="width: 30%; float: right;" name="search" id="search" class="form-control" placeholder="Search...">
              </div>
              <div class="modal-body">
                <form id="form-baku" method="post" data-toggle="validator">
                  {{ csrf_field() }} {{ method_field('POST') }}
                  <div class="form-group">
                    <input type="hidden" id="metodesimpan" name="metodesimpan">
                    <input type="hidden" id="bakucombineid" name="bakucombineid">
                    <input type="hidden" id="bakuproductid" name="bakuproductid">
                    <div id="table-material-komposisi"></div>
                    <!--<label>Material Name</label><br>-->
                    <!--<select style="width:100%" id="bakumaterialname" class="form-control" name="bakumaterialname" required>-->
                    <!--    <option value=""> - Choose Material - </option>-->
                    <!--    @foreach($mat as $row)-->
                    <!--        <option value="{{ $row->id }}">{{ $row->material_name }}</option>-->
                    <!--    @endforeach-->
                    <!--</select>-->
                  </div>
                  
                  <!--<div class="form-group">-->
                  <!--  <label>Material Quantity Needed</label>-->
                  <!--  <input type="text" id="bakumaterialquantity" name="bakumaterialquantity" class="form-control" required>-->
                  <!--</div>-->
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary btn-sm">Save</button>
                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
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

          $("#bakumaterialname").select2({
              theme: "bootstrap"
          });

          var table = $('#barang-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.good') }}",
              columns: [
                {data:'id', name: 'id'},
                {data:'good_name', name: 'good_name'},
                {data:'category_name', name: 'kategori'},
                {data:'unit', name: 'unit'},
                {data:'co_number', name: 'co_number'},
                {data:'b_price', name: 'b_price'},
                {data:'s_price', name: 's_price'},
                {data:'stok', name: 'stok'},
                {data:'bahanbaku', name: 'bahanbaku', orderable:false, searchable:false},
               
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });
          
          
          function hapusBaku(id) {
              var hapus = confirm("Hapus Bahan Baku...?");
              var csrf_token = $('meta[name="csrf-token"]').attr('content');
              if(hapus==true) {
                  $.ajax({
                     url : "{{ url('hapusBaku') }}",
                     type : "POST",
                     dataType : "JSON",
                     data: {id:id, '_token': csrf_token},
                     success: function(data) {
                          table.ajax.reload(null, false);
                     }
                      
                  });
              } 
              
          }
          
          
          function editBaku(id) {
              $("#metodesimpan").val("edit")
              $("#modal-baku").modal("show");
              $(".modalbahanbaku").text('Edit Bahan Baku');
              $.ajax({
                  url : "{{ url('editBaku') }}"+"/"+id,
                  type : "GET",
                  dataTYpe : "JSON", 
                  success: function(data) {
                      console.log('data edit baku', data);
                      $("#bakucombineid").val(data[0].id);
                      $("#bakuproductid").val(data[0].id_product);
                      $("#bakumaterialname").val(data[0].id_material).trigger('change');
                      $("#bakumaterialquantity").val(data[0].qty_material);
                  }
                  
                  
              });
          }
          
          
          function tambahBaku(id) {
              $("#metodesimpan").val("add")
              $("#bakumaterialname").val("");
              $("#bakumaterialquantity").val("");
              var csrf_token = $('meta[name="csrf-token"]').attr('content');
              
              $.ajax({
                  url :"{{ url('materiallist') }}",
                  type : "POST",
                  data : {'id':id, '_token':csrf_token },
                 
                  success : function(data) {
                        console.log('materiallist', data);
                        $("#modal-baku").modal("show");
                        $(".modalbahanbaku").text('Tambah Bahan Baku');
                        $("#bakuproductid").val(id);
                        $("#table-material-komposisi").html(data);
                        
                  }
              })
          }


          function addForm(){
              save_method = "add";
              $('input[name=_method]').val('POST');
              $('#modal-barang').modal('show');
              $('#modal-barang form')[0].reset();
              $('#stok').removeAttr("disabled");
              $('.modal-title').text('Tambah Data Barang');
          }


          function editForm(id){
              save_method = 'edit';
              $('input[name=_method]').val('PATCH');
              $('#modal-barang form')[0].reset();
              $.ajax({
                  url: "{{ url('good') }}" + '/'+id+'/edit',
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){
                      $('#modal-barang').modal("show");
                      $('.modal-title').text("Edit Data Barang");

                      $('#id').val(data.id);
                      $('#good_name').val(data.good_name);
                      $('#co_number').val(data.co_number);
                      $('#grade').val(data.grade);
                      $('#colour').val(data.colour);
                      $('#hardness').val(data.hardness);
                      $('#kategori').val(data.kategori);
                      $('#unit').val(data.unit);
                      $('#description').val(data.description);
                      $('#b_price').val(data.b_price);
                      $('#s_price').val(data.s_price);
                      $('#r_price').val(data.r_price);
                      $('#d_price').val(data.d_price);
                      $('#stok').val(data.stok);
                      $('#stok').attr("disabled",true);
                      $('#foto').val(data.foto);
                                           
                },

                error: function(){
                  alert("Nothing Data....");
                }

              });
          }


          
          $('#modal-barang form').validator().on('submit', function(e){
              if(!e.isDefaultPrevented()){
                  var id = $('#id').val();
                  if(save_method =='add')  url = "{{ url('good') }}";
                  else url = "{{ url('good') .'/'}}"+ id;
                  $.ajax({
                      url : url,
                      type : "POST",
                      data : new FormData($('#modal-barang form')[0]),
                      contentType:false,
                      processData:false,
                      success : function(data){
                        console.log(data);
                        if(data.success == true){
                          $('#modal-barang').modal('hide');
                          table.ajax.reload(null, false);
                          alert('Data Berhasil Disimpan');
                        }
                      }

                  });
                  return false;
              }
          });
          
          
          $('#modal-baku form').validator().on('submit', function(e){
             e.preventDefault();
             var metodesimpan = $("#metodesimpan").val();
             if(metodesimpan =='add')  url = "{{ url('setbaku') }}";
             else url = "{{ url('updatebaku') }}";
             
             $.ajax({
                  url : url,
                  type : "POST",
                  data : $("#form-baku").serialize(),
                  dataType : "JSON",
                  success : function(data){
                    if(data.success == true){
                      $("#modal-baku").modal("hide");
                      console.log('tambah bahan baku', data);
                      table.ajax.reload(null, false);
                     
                    }
                  }

              });
             
          });

          


          function deleteData(id){
            var popup = confirm('Anda Yakin Ingin Menghapus Data...?');
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            if(popup == true){
                $.ajax({
                    url  : "{{ url('good') }}" + '/'+id,
                    type : "POST",
                    data : {'_method':'DELETE', '_token':csrf_token},
                    success : function($data){
                            table.ajax.reload(null, false);
                            alert('Data Berhasil Dihapus')
                          },
                    error: function(){
                      alert('Opps! Something error !');
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
          
          
          function ubahitem(id) {
            var nilai = $("#inp_"+id).val();
            $.ajax({
                url      :  "{{ url('material/') }}"+'/'+id+'/'+nilai,
                type     :  "GET",
                dataType :  "JSON",
                success  :   function(data){
                  if (data == false) {
                    alert('Stok tidak cukup');
                    $("#inp_"+id).val(0);
                    $("#qty_"+id).val(0);
                  }else{
                    $("#qty_"+id).val(nilai/100);
                  }
                },
            });
          }

          $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $('#table-quantity tr').filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
          

        
</script>

@endsection