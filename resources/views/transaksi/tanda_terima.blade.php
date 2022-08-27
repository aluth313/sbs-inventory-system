@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tanda Terima Service
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="javascript:void(0)">Tanda Terima Service</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          
          <button id="tambah_tterima" onclick="addForm()" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Buat Tanda Terima</button>
          <div style="margin-bottom: 30px"></div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id="tterima-table" class="table table-striped table-hover">
              <thead>
                  <tr>
                      <th width="1%">ID</th>
                      <th width="10%">Tgl</th>
                      <th width="10%">TTNo</th>
                      <th width="10%">Pelanggan</th>
                      <th width="10%">Item</th>
                      <th width="3%">Tipe</th>
                      <th width="8%">SN</th>
                      <th width="*">Keterangan</th>
                      <th width="10%">Keluhan</th>
                      <th width="10%">Status</th>
                      <th width="6%">Selesai</th>
                      <th width="25%">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                
              </tbody>
              <tfoot>
                  <tr>
                      <th width="2%">ID</th>
                      <th width="10%">Tgl</th>
                      <th width="10%">TTNo</th>
                      <th width="10%">Pelanggan</th>
                      <th width="10%">Item</th>
                      <th width="5%">Tipe</th>
                      <th width="10%">SN</th>
                      <th width="*">Keterangan</th>
                      <th width="15%">Keluhan</th>
                      <th width="10%">Kelengkapan</th>
                      <th width="8%">Selesai</th>
                      <th width="15%">Aksi</th>
                  </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>

      <div class="modal" id="modal-terima" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form id="form-terima" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
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
                          <label for="cust_id" class="col-md-3 control-label">Pelanggan :</label>
                          <div class="col-md-8">
                              <select id="cust_id" name="cust_id" class="form-control" required="">
                                  <option value=""> - Pilih Pelanggan - </option>
                                  @foreach($cust as $key)
                                      <option value="{{$key->id}}">{{$key->customer_name}}</option>
                                  @endforeach 
                              </select>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="item_name" class="col-md-3 control-label">Nama Item :</label>
                        <div class="col-md-8">
                            <textarea style="height: 80px;" id="item_name" name="item_name" class="form-control"></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                      </div>

                      <div class="form-group">
                          <label for="foto" class="col-md-3 control-label">Foto Item   :</label>
                          <div class="col-md-8">
                              <input type="file" id="foto" name="foto" class="form-control">
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="tipe/sn/estimasi" class="col-md-3 control-label">Tipe/SN/Estimasi :</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="tipe" name="tipe" placeholder="Tipe">
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="sn" name="sn" placeholder="SN">
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="col-md-2">
                            <input type="number" class="form-control" id="estimasi_selesai" name="estimasi_selesai" placeholder="Est./Hari" required="">
                            <span class="help-block with-errors"></span>
                        </div>
                      </div>

                      <div class="form-group">
                          <label for="dp" class="col-md-3 control-label">Down Payment :</label>
                          <div class="col-md-8">
                              <input type="number" id="dp" name="dp" class="form-control">
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="keterangan" class="col-md-3 control-label">Keterangan :</label>
                        <div class="col-md-8">
                            <textarea style="height: 80px;" id="keterangan" name="keterangan" class="form-control"></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="keluhan/kelengkapan" class="col-md-3 control-label">Keluhan/Kelangkapan :</label>
                        <div class="col-md-4">
                            <textarea style="height: 80px;" id="keluhan" name="keluhan" class="form-control" placeholder="keluhan" required></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="col-md-4">
                            <textarea style="height: 80px;" id="kelengkapan" name="kelengkapan" class="form-control" placeholder="Kelengkapan" required></textarea>
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


      <div class="modal" id="modal-foto" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"> &times; </span>
                  </button>
                  <h3 class="modal-title">Lihat Foto</h3>
              </div>
              <div class="modal-body" id="isi-foto"></div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>
        </div>
      </div> <!--end modal-->


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

          $('#cust_id').select2({
            theme: "bootstrap"
          });

          // datatable  
          var table = $('#tterima-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.terima') }}",
              order: [[ 0, "desc" ]],

              columns: [
                {data:'id',         name: 'id'},
                {data:'created_at', name: 'created_at'},
                {data:'ttno',       name: 'ttno'},
                {data:'customer_name',  name: 'customer_name'},
                {data:'item_name',  name:'item_name'},
                {data:'tipe',       name: 'tipe', orderable:false, searchable:false},
                {data:'sn',         name: 'sn', orderable:false},
                {data:'keterangan', name: 'keterangan', orderable:false},
                {data:'keluhan',    name: 'keluhan', orderable:false},
                {data:'status',name: 'status'},
                {data:'estimasi_selesai', name: 'estimasi_selesai'},
                {data:'action',     name: 'action', orderable:false, searchable:false}
              ]
          });

          // ===============================================================================
                                     // coded by Indra Rahdian
          // ===============================================================================

          // tambah tanda terima
          function addForm(){
              save_method = "add";
              $('input[name=_method]').val('POST');
              $('#modal-terima').modal('show');
              $('#modal-terima form')[0].reset();
              $('.modal-title').text('Buat Tanda Terima');
          }

          // ===============================================================================
                                     // coded by Indra Rahdian
          // ===============================================================================

          // simpan tanda terima
          $(function(){
              $('#modal-terima form').validator().on('submit', function(e){
                  if(!e.isDefaultPrevented()){
                      var id = $('#id').val();
                      if(save_method =='add')  url = "{{ url('tterima') }}";
                      else url = "{{ url('tterima') .'/'}}"+ id;

                      $.ajax({
                          url : url,
                          type : "POST",
                          data : new FormData($('#modal-terima form')[0]),
                          contentType :false,
                          processData : false,
                          success : function(data){
                              $('#modal-terima').modal('hide');
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

          // ===============================================================================
                                     // coded by Indra Rahdian
          // ===============================================================================

          // hapus tanda terima
          function deleteData(id){
              var popup = confirm('Anda Yakin Ingin Menghapus Data...?');
              var csrf_token = $('meta[name="csrf-token"]').attr('content');
              if(popup == true){
                  $.ajax({
                      url  : "{{ url('tterima') }}" + '/'+id,
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


          // ===============================================================================
                                     // coded by Indra Rahdian
          // ===============================================================================

          // edit tanda terima
          function editForm(id){
              save_method = 'edit';
              $('input[name=_method]').val('PATCH');
              $('#modal-terima form')[0].reset();
              $.ajax({
                  url: "{{ url('tterima') }}" + '/'+id+'/edit',
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){
                      $('#modal-terima').modal("show");
                      $('.modal-title').text("Edit Tanda Terima");

                      $('#id').val(data.id);
                      $('#cust_id').val(data.cust_id);
                      $('#item_name').val(data.item_name);
                      $('#tipe').val(data.tipe);
                      $('#sn').val(data.sn);
                      $('#keterangan').val(data.keterangan);
                      $('#keluhan').val(data.keluhan);
                      $('#kelengkapan').val(data.kelengkapan);
                      $('#estimasi_selesai').val(data.estimasi_selesai); 
                      $('#dp').val(data.dp);                    
                },
                error: function(){
                    alert("Nothing Data....");
                }
            });
          }


          // ===============================================================================
                                     // coded by Indra Rahdian
          // ===============================================================================

          // cetak tanda terima
          $('#tterima-table').on('click', '#btn-cetak', function(e){
              
              var id = $(this).attr("data-id");

              $('#loadingProgress').show();
              $.ajax({
                    url : "{{ url('cetak_tanda_terima')}}"+"/"+id,
                    type : "GET",
                    success : function(data){
                        $('#loadingProgress').hide();
                        window.open("{{ url('cetak_tanda_terima')}}"+"/"+id, "Tanda Terima", "height=900, width=1000, scrollbars=yes");
                        reloadTable();
                    },
                    error: function(){
                        $('#loadingProgress').hide();
                        alert("OPPS Something Error");
                    }

              });

          });



          function cancelForm(id){
              
              var popup = confirm('Apakah Anda Yakin Akan Membatalkan Tanda Terima Ini...?')
              if(popup == true){
                  var csrf_token = $('meta[name="csrf-token"]').attr('content');

                  $.ajax({

                      url : "{{url('cancel_tt')}}",
                      type : "post",
                      data :{id:id, _token:csrf_token},
                      success:function(data){
                          reloadTable();
                      },
                      error:function(){
                          alert("Something Error");
                       }
                  });  
              }  
          }


          function seePicture(id){

              $.ajax({
                 url : "{{ url('lihat_gambar_tt') }}"+"/"+id,
                 type : "GET",
                 dataType : "JSON",
                 success : function(data){
                    $('#isi-foto').html(data);
                    $('.modal-title').html('Lihat Foto Item');
                    $('#modal-foto').modal("show");
                    console.log(data);
                 },
                 error : function(){
                    alert("Something Error...");
                 }
              })

          }

          // ===============================================================================
                                     // coded by Indra Rahdian
          // ===============================================================================

          // refresh tabel
          function reloadTable() {
            $("#tterima-table").DataTable().ajax.reload(null,false);
          }
      
      
  </script>

  @endsection