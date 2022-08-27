@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah Service 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('service') }}">Service</a></li>
        <li><a href="javascript:void(0)">Tambah Service</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
          <div class="box-header with-border">
            <button id="cari_terima" onclick="addForm()" class="btn btn-sm btn-success pull-left"><i class="fa fa-search"></i> Lihat Tanda Terima</button>
            <div style="margin-bottom: 30px"></div>
          </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3>Tanda Terima</h3>    
                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                       <td width="30%">No. Tanda Terima</td>
                                       <td width="1%">:</td>
                                       <td width="*"><input type="text" id="tanda-terima" readonly class="form-control"></td>
                                    </tr>
                                    
                                    <tr>
                                       <td width="30%">Nama Pelanggan</td>
                                       <td width="1%">:</td>
                                       <td width="*"><input type="text" id="pelanggan" readonly class="form-control"></td>
                                    </tr>
                                    <input type="hidden" id="id-pelanggan">
                                    <tr>
                                       <td width="30%">Alamat Pelanggan</td>
                                       <td width="1%">:</td>
                                       <td width="*"><textarea style="height: 70px" readonly id="alamat-pelanggan" class="form-control"></textarea></td>
                                    </tr>
                                    <tr>
                                       <td width="30%">Nama Item</td>
                                       <td width="1%">:</td>
                                       <td width="*"><input type="text" id="nama-item" readonly class="form-control"></td>
                                    </tr>
                                    <tr>
                                       <td width="30%">Down Payment</td>
                                       <td width="1%">:</td>
                                       <td width="*"><input type="number" id="dp" readonly class="form-control"></td>
                                    </tr>
                                    <tr>
                                       <td width="30%">Tipe/SN</td>
                                       <td width="1%">:</td>
                                       <td width="*"><input type="text" id="tipe" readonly class="form-control"></td>
                                    </tr>
                                    <tr>
                                       <td width="30%">Keterangan</td>
                                       <td width="1%">:</td>
                                       <td width="*"><textarea style="height: 70px" readonly id="keterangan" class="form-control"></textarea></td>
                                    </tr>
                                    <tr>
                                       <td width="30%">Keluhan</td>
                                       <td width="1%">:</td>
                                       <td width="*"><textarea style="height: 70px" readonly id="keluhan" class="form-control"></textarea></td>
                                    </tr>
                                    <tr>
                                       <td width="30%">Kelengkapan</td>
                                       <td width="1%">:</td>
                                       <td width="*"><textarea style="height: 70px" readonly id="kelengkapan" class="form-control"></textarea></td>
                                    </tr>
                                    <tr>
                                       <td width="30%">Tgl Selesai</td>
                                       <td width="1%">:</td>
                                       <td width="*"><input type="text" id="tgl-selesai" readonly class="form-control"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>  
                </div>

                <div class="col-md-7">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3 id="total_transaksi">Rp. </h3>

                            
                        </div>
                        <div class="icon">
                            <i class="fa fa-cart-plus"></i>
                        </div>
                        <a href="javascript:void(0)" class="small-box-footer">
                            Total Biaya Service <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                    <button onclick="addJasa()" class="btn btn-sm btn-primary" id="tambah_jasa"><i class="fa fa-wrench"></i> Jasa</button>
                    <button onclick="addBarang()" class="btn btn-sm btn-warning" id="tambah_barang"><i class="fa fa-cube"></i> Barang</button>
                    <button onclick="saveService()" class="btn btn-sm btn-primary pull-right" id="simpan_service"><i class="fa fa-save"></i> Simpan</button>
                    <button style="margin-right: 5px;" onclick="batalService()" class="btn btn-sm btn-warning pull-right" id="batal_service"><i class="fa fa-remove"></i> Batal</button>
                    <div style="margin-top: 10px"></div>
                    



                    <div class="table-responsive">
                        <table id="tmp-service-table" class="table table-bordered table-hover">
                          <thead>
                              <tr>
                                  <th width="1%">ID</th>
                                  <th width="*">Nama</th>
                                  <th width="10%">Uom</th>
                                  <th width="10%">Jumlah</th>
                                  <th width="10%">Harga</th>
                                  <th width="10%">Total</th>
                                  <th width="15%">Aksi</th>
                              </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                          <tfoot>
                              <tr>
                                  <th width="1%">ID</th>
                                  <th width="*">Nama</th>
                                  <th width="10%">Uom</th>
                                  <th width="10%">Jumlah</th>
                                  <th width="10%">Harga</th>
                                  <th width="10%">Total</th>
                                  <th width="15%">Aksi</th>
                              </tr>
                          </tfoot>
                        </table>
                    </div>

                </div>
                <div class="col-md-12">
                <a href="{{ url('service') }}"><button class="btn btn-sm btn-info"><i class="fa fa-arrow-left"></i> Kembali</button></a>
            </div>
            </div>
            
        </div>
      </div>

      <div class="modal" id="modal-service" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
              
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true"> &times; </span>
                      </button>
                      <h3 class="modal-title"></h3>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="modal-body">
                              <table style="width: 100%" id="table-cari-tt" class="table table-bordered pull-right">
                                  <thead>
                                      <tr>
                                          <th>ID</th>
                                          <th>Tgl</th>
                                          <th>No. TT</th>
                                          <th>Pelanggan</th>
                                          <th>Item</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <!-- isi table disini   -->
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div> <!--end modal-->


      <div class="modal" id="modal-jasa" role="dialog" aria-hidden="true" data-backdrop="static">
          <div class="modal-dialog modal-sm">
              <div class="modal-content">
                  <form id="form-jasa" method="post" data-toggle="validator">
                      {{ csrf_field() }} {{ method_field('POST') }}
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true"> &times; </span>
                          </button>
                          <h3 class="modal-title-jasa"> Tambah Jasa Service</h3>
                      </div>
                      <div class="row">
                          <div class="col-md-12">
                              <div class="modal-body">
                                  <input type="hidden" name="id" id="id">
                                  <div class="form-group">
                                      <label>Nama Jasa</label>
                                      <select id="job_name" name="job_name" class="form-control" required>
                                          <option value=""> - Pilih Jasa - </option>
                                          @foreach($job as $key)
                                              <option value="{{$key->id}}">{{$key->job_name}}</option>
                                          @endforeach
                                      </select>
                                      <span class="help-block with-errors"></span>
                                  </div>
                                  <input type="hidden" id="job_desc" name="job_desc" class="form-control" required>
                                  <div class="form-group">
                                      <label>Jumlah</label>
                                      <input type="number" id="quantity" name="quantity" class="form-control" required>
                                      <span class="help-block with-errors"></span>
                                  </div>
                                  <div class="form-group">
                                      <label>Satuan</label>
                                      <input type="text" id="uom" name="uom" class="form-control" required readonly>
                                      <span class="help-block with-errors"></span>
                                  </div>
                                  <div class="form-group">
                                      <label>Harga</label>
                                      <input type="number" id="price" name="price" class="form-control" required readonly>
                                      <span class="help-block with-errors"></span>
                                  </div>
                                  <div class="form-group">
                                      <label>Total</label>
                                      <input type="number" id="total" name="total" class="form-control" required readonly>
                                      <span class="help-block with-errors"></span>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary btn-save">Submit</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div> <!--end modal-->


      <div class="modal" id="modal-barang" role="dialog" aria-hidden="true" data-backdrop="static">
          <div class="modal-dialog modal-sm">
              <div class="modal-content">
                  <form id="form-barang" method="post" data-toggle="validator">
                      {{ csrf_field() }} {{ method_field('POST') }}
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true"> &times; </span>
                          </button>
                          <h3 class="modal-title-barang"></h3>
                      </div>
                      <div class="row">
                          <div class="col-md-12">
                              <div class="modal-body">
                                  <input type="hidden" name="id_barang" id="id_barang">
                                  <div class="form-group">
                                      <label>Nama Barang</label>
                                      <select id="good_name" name="good_name" class="form-control" required>
                                          <option value=""> - Pilih Barang - </option>
                                          @foreach($good as $key)
                                              <option value="{{$key->id}}">{{$key->good_name}}</option>
                                          @endforeach
                                      </select>
                                      <span class="help-block with-errors"></span>
                                  </div>
                                  <input type="hidden" id="good_desc" name="good_desc" class="form-control" required>
                                  <div class="form-group">
                                      <label>Jumlah</label>
                                      <input type="number" id="quantity_barang" name="quantity_barang" class="form-control" required>
                                      <span class="help-block with-errors"></span>
                                  </div>
                                  <div class="form-group">
                                      <label>Satuan</label>
                                      <input type="text" id="uom_barang" name="uom_barang" class="form-control" required readonly>
                                      <span class="help-block with-errors"></span>
                                  </div>
                                  <div class="form-group">
                                      <label>Harga</label>
                                       <select class="form-control" id="price_barang" name="price_barang" required="">
                                      </select>
                                      <span class="help-block with-errors"></span>
                                  </div>
                                  <div class="form-group">
                                      <label>Total</label>
                                      <input type="number" id="total_barang" name="total_barang" class="form-control" required readonly>
                                      <span class="help-block with-errors"></span>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary btn-save">Submit</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div> <!--end modal-->


      <div class="modal" id="modal-teknisi" role="dialog" aria-hidden="true" data-backdrop="static">
          <div class="modal-dialog modal-sm">
              <div class="modal-content">
                  <form id="form-teknisi" method="post" data-toggle="validator">
                      {{ csrf_field() }} {{ method_field('POST') }}
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true"> &times; </span>
                          </button>
                          <h3 class="modal-title"></h3>
                      </div>
                      <div class="row">
                          <div class="col-md-12">
                              <div class="modal-body">
                                  <div class="form-group">
                                    <label>Tanggal Transaksi:</label>
                                    <input type="date" id="trans_date" class="form-control">
                                  </div>
                                  <div class="form-group">
                                      <label>Nama Teknisi</label>
                                      <select id="tech_name" name="tech_name" class="form-control" required>
                                          <option value=""> - Pilih Teknisi - </option>
                                          @foreach($tech as $key)
                                              <option value="{{$key->id}}">{{$key->nama}}</option>
                                          @endforeach
                                      </select>
                                      <span class="help-block with-errors"></span>
                                  </div>
                                  <div class="form-group">
                                    <label>No. Invoice</label>
                                    <input type="text" id="fak-no" class="form-control">
                                  </div>
                                  <div class="form-group">
                                    <label>No. DO</label>
                                    <input type="text" id="do-no" class="form-control">
                                  </div>
                                  <div class="form-group">
                                    <label>No. PO</label>
                                    <input type="text" id="po-no" class="form-control">
                                  </div>
                                  <div class="form-group">
                                      <label>Keterangan:</label>
                                      <textarea class="form-control" id="ket-teknisi" name="ket-teknisi" style="height: 90px"></textarea>
                                  </div>
                                  <input type="hidden" id="dp-hidden">
                                  
                              </div>
                              <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary btn-save">Submit</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                              </div>
                          </div>
                      </div>
                  </form>
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
          hitungTotal();

          $('#job_name').select2({
            theme: "bootstrap"
          });

          $('#good_name').select2({
            theme: "bootstrap"
          });

          $('#tech_name').select2({
            theme: "bootstrap"
          });



          // datatable  
          var table = $('#tmp-service-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.service-tmp') }}",
              columns: [
                {data:'id',         name: 'id'},
                {data:'item_name', name: 'item_name', orderable:false},
                {data:'uom',       name: 'uom', orderable:false, searchable:false},
                {data:'quantity',       name: 'quantity', orderable:false, searchable:false},
                {data:'price',  name: 'price', orderable:false, searchable:false},
                {data:'total',  name:'total', orderable:false, searchable:false},
                {data:'action',     name: 'action', orderable:false, searchable:false}
              ]
          });

          
          var table = $('#table-cari-tt').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.service-tt') }}",
              columns: [
                {data:'id',                 name: 'id'},
                {data:'created_at',         name: 'created_at'},
                {data:'ttno',               name: 'ttno'},
                {data:'customer_name',      name: 'customer_name'},
                {data:'item_name',          name: 'item_name'},
                {data:'status',             name: 'status'},
                {data:'action',             name: 'action', orderable:false, searchable:false}
              ]
          });

         
          function addForm(){
              $('.modal-title').text('Cari Tanda Terima');
              $('#modal-service').modal("show");
          }


          function addJasa(){
              var tanda_terima = $('#tanda-terima').val();
              if(tanda_terima == ''){
                  alert('Nomor Tanda Terima Belum Dipilih....');
              }

              else{
                  save_method = "add";
                  $('input[name=_method]').val('POST');
                  $('.modal-title-jasa').text('Tambah Jasa');
                  $('#modal-jasa form')[0].reset();
                  $('#modal-jasa').modal('show');  
              } 
              
          }



          function addBarang(){
              var tanda_terima = $('#tanda-terima').val();
              if(tanda_terima == ''){
                  alert('Nomor Tanda Terima Belum Dipilih....');
              }
              else{
                  save_method = "add";
                  $('input[name=_method]').val('POST');
                  $('.modal-title-barang').text('Tambah Barang');
                  $('#modal-barang form')[0].reset();
                  $('#modal-barang').modal('show');  
              }
              
          }



          function editJasa(id){
              save_method = 'edit';
              $('input[name=_method]').val('PATCH');
              $('#modal-jasa form')[0].reset();
              $.ajax({
                  url: "{{ url('service') }}" + '/'+id+'/edit',
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){
                      $('#modal-jasa').modal("show");
                      $('.modal-title-jasa').text("Edit Jasa");

                      $('#id').val(data.id);
                      $('#job_name').val(data.item_cd).trigger('change');
                      $('#job_desc').val(data.item_name);
                      $('#uom').val(data.uom);
                      $('#price').val(data.price);
                      $('#quantity').val(data.quantity);
                      $('#total').val(data.total);
                      
                                           
                },
                error: function(){
                    alert("Nothing Data....");
                }

              });
          }




          function editBarang(id){

              save_method = 'edit';
              $('input[name=_method]').val('PATCH');
              $('#modal-barang form')[0].reset();
              $.ajax({
                  url: "{{ url('service') }}" + '/'+id+'/edit',
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){
                      $('#modal-barang').modal("show");
                      $('.modal-title-barang').text("Edit Barang");

                      $('#id_barang').val(data.id);
                      $('#good_name').val(data.item_cd).trigger('change');
                      $('#good_desc').val(data.item_name);
                      $('#uom_barang').val(data.uom);

                      // $('#price_barang').val(data.price);
                      $('#quantity_barang').val(data.quantity);
                      $('#total_barang').val(data.total);
                                           
                  },
                  error: function(){
                      alert("Nothing Data....");
                  }

              });
          }



          function pilihTerima(id){

              $.ajax({
                  url : "{{ url('pilih_terima') }}"+"/"+id,
                  type: "GET", 
                  dataType : "json",
                  success:function(data){
                      $('#tanda-terima').val(data[0].ttno);
                      $('#id-pelanggan').val(data[0].customer_id);
                      $('#pelanggan').val(data[0].customer_name);
                      $('#alamat-pelanggan').val(data[0].customer_address);
                      $('#nama-item').val(data[0].item_name);
                      $('#dp').val(data[0].dp);
                      $('#tipe').val(data[0].tipe);
                      $('#keterangan').val(data[0].keterangan);
                      $('#keluhan').val(data[0].keluhan);
                      $('#kelengkapan').val(data[0].kelengkapan);
                      $('#tgl-selesai').val(data[0].estimasi_selesai+' Hari');


                      $('#modal-service').modal("hide");
                  },
                  error:function(){
                      alert("opps Something error...");
                  }
              });
          }



          $('#job_name').change(function(){
              var id = $(this).val();
              var job_desc = $(this).select2('data')[0].text;
              $.ajax({
                  url : "{{ url('tambah_jasa') }}"+"/"+id, 
                  type : "GET", 
                  dataType :"json",
                  success:function(data){
                      $('#job_desc').val(job_desc);
                      $('#uom').val(data.uom);
                      $('#price').val(data.price);
                      $('#total').val("");

                  },
                  error:function(){
                      alert('Something Error');
                  }
              });
          });



          $('#good_name').change(function(){
              var id = $(this).val();
              var good_desc = $(this).select2('data')[0].text;
              $.ajax({
                  url : "{{ url('tambah_barang') }}"+"/"+id, 
                  type : "GET", 
                  dataType :"json",
                  success:function(data){
                      $('#good_desc').val(good_desc);
                      $('#uom_barang').val(data.unit);
                      select_barang(id);
                      $('#total_barang').val("");     
                  },
                  error:function(){
                      alert('Something Error');
                  }
              });
          });



          $('#quantity').keyup(function(){
              var jumlah = $(this).val();
              var harga = $('#price').val();
              var total = jumlah * harga ;

              $('#total').val(total);
          });


          $('#quantity_barang').keyup(function(){
              var jumlah = $(this).val();
              var harga = $('#price_barang').val();
              var total = jumlah * harga ;

              $('#total_barang').val(total);
          });



          $('#quantity').change(function(){
              var jumlah = $(this).val();
              var harga = $('#price').val();
              var total = jumlah * harga ;

              $('#total').val(total);
          });


          $('#quantity_barang').change(function(){
              var jumlah = $(this).val();
              var harga = $('#price_barang').val();
              var total = jumlah * harga ;

              $('#total_barang').val(total);
          });

      

          $('#modal-jasa form').submit(function(e){
              e.preventDefault();
              var id = $('#id').val();
              if(save_method =='add')  url = "{{ url('service') }}";
              else url = "{{ url('service') .'/'}}"+ id;

              $.ajax({
                  url : url,
                  type : "POST",
                  data : $('#modal-jasa form').serialize(),
                  success:function(data){
                      if(data == 'exist')
                      {
                          alert("Item Ini Sudah Ada...");
                      }

                      else
                      {
                          
                          $('#modal-jasa').modal("hide");
                          reloadTable();  
                      } 
                  },
                  error:function(){
                      alert('Something Error');
                  }
              });
          
          });


          $('#modal-barang form').submit(function(e){
              e.preventDefault();
              var id = $('#id_barang').val();
              
              if(save_method =='add')  url = "{{ url('item') }}";
              else url = "{{ url('item') .'/'}}"+ id;

              $.ajax({
                  url : url,
                  type : "POST",
                  data : $('#modal-barang form').serialize(),
                  success:function(data){
                      if(data == 'exist')
                      {
                          alert("Item Ini Sudah Ada...");
                      }

                      else
                      {
                          
                          $('#modal-barang').modal("hide");
                          reloadTable();  
                      } 
                  },
                  error:function(){
                      alert('Something Error');
                  }
              });
          
          });


          $('#price_barang').change(function(){
              var jumlah = $('#quantity_barang').val();
              var harga = $('#price_barang').val();

              var total = jumlah * harga;
              $('#total_barang').val(total);
          });




          

          function deleteData(id){
              var popup = confirm('Anda Yakin Ingin Menghapus Data...?');
              var csrf_token = $('meta[name="csrf-token"]').attr('content');
              if(popup == true){
                  $.ajax({
                      url  : "{{ url('service') }}" + '/'+id,
                      type : "POST",
                      data : {'_method':'DELETE', '_token':csrf_token},
                      success : function($data){
                              reloadTable();
                              alert('Data Berhasil Dihapus')
                            },
                      error: function(){
                        alert('Opps! Something error !');
                      }

                  });
              }
          }



          function saveService(){
              var tanda_terima = $('#tanda-terima').val();
              if(tanda_terima == ''){
                  alert('Tanda Terima Belum Dipilih...');
              }
              else{

                  var popup = confirm('Anda Yakin Ingin Menyimpan Data...?');
                  if(popup==true){
                      var dp = $('#dp').val();
                      $('.modal-title').html('Nama Teknisi');
                      $('#modal-teknisi').modal('show');
                      $('#dp-hidden').val(dp);
                      console.log(dp);
                  }

              }
          }


          $('#modal-teknisi form').submit(function(e){
              e.preventDefault();

              var tgl_trans = $('#trans_date').val();
              var dp = $('#dp-hidden').val();
              var teknisi = $('#tech_name').val();
              var ttno = $('#tanda-terima').val();
              var cust = $('#id-pelanggan').val();
              var ket = $('#ket-teknisi').val();

              var fakno = $('#fak-no').val();
              var dono = $('#do-no').val();
              var pono = $('#po-no').val();

              var xtotal =$('#total_transaksi').text();
              var ytotal = xtotal.replace("Rp.", "");
              var ztotal = ytotal.replace(".", "");
              var total = ztotal.replace(".", "");
              var _token = $('input[name="_token"]').val();
          

              $.ajax({
                  url     : "{{ url('simpan_service') }}",
                  type    : "POST",
                  data    : {tgl_trans:tgl_trans,dp:dp, teknisi:teknisi, ttno:ttno, cust:cust, ket:ket, fakno:fakno, dono:dono, pono:pono, total:total,  _token:_token},
                  success : function(data){
                      alert("Service Ditambahkan....");
                      $('#modal-teknisi').modal("hide");
                      window.location = "{{ url('service') }}";
                  },
                  error   :function(){
                      alert('Something Error...');
                  }
              });

          });


          function batalService(){

              var popup = confirm('Apakah Anda Yakin Ingin Membatalkan Transaksi..?');
              if(popup == true){
                  $.ajax({

                      url : "{{ url('batal_service') }}",
                      type : "GET",
                      dataType : "JSON",
                      success:function(data){
                          window.location = "{{ url('service') }}";
                      },  
                      error:function(){
                          alert('Something Error');
                      }
                  });
              }
          }


          function reloadTable() {
              $("#tmp-service-table").DataTable().ajax.reload(null,false);
              hitungTotal();
          }


          function hitungTotal(){

              $.ajax({
                  url       : "{{ url('total_service') }}",
                  type      : "GET",
                  dataType  : "JSON",
                  success: function(data){
                      var ttl = 0;
                      if(data[0].Total == null) 
                      {
                        ttl = 0;
                      } 
                      else
                      {
                        ttl =  formatRupiah(data[0].Total, 'Rp. ');  
                      } 
                      $('#total_transaksi').html(ttl);
                  }, 
                  error: function(){
                      alert("Opps Something Error");
                  }

              });
          }


          function select_barang(id) {
              
              $.ajax({
                  url : "{{ url('select_barang') }}"+"/"+id,
                  type : "GET",
                  dataType : "JSON",
                  success:function(data){
                      console.log(data);
                      var sel = $('#price_barang');
                      sel.empty();
                      // sel.append('<option value="">- Pilih Harga Jual -</option>');
                      for (var i=0; i<data.length; i++) {
                          sel.append('<option value='+data[i]+'>'+data[i]+'</option>');
                      }
                  },
                  error:function(){
                    alert("Something Error");
                  }
              });

              
          }


          function formatRupiah(angka, prefix){
              var number_string = angka.replace(/[^,\d]/g, '').toString(),
              split       = number_string.split(','),
              sisa        = split[0].length % 3,
              rupiah        = split[0].substr(0, sisa),
              ribuan        = split[0].substr(sisa).match(/\d{3}/gi);
         
              // tambahkan titik jika yang di input sudah menjadi angka ribuan
              if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
              }
         
              rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
              return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
          }
      
      
  </script>

  @endsection