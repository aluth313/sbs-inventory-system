@extends('master')

@section('content')

<?php $dataSupplier = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : $purchase->supplier_id;?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Pembelian
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('purchase') }}">Proses Pembelian</a></li>
        <li><a href="{{ url('editPurchase') }}">Edit Pembelian</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border" style="background-color: whitesmoke">
        <div class="row">
          <div class="col-md-12">
              <h3 class="pull-left"><u> No Invoice :{{ $purchase->invoice }} </u></h3>
              <input type="hidden" id="invoice" value="{{$purchase->invoice}}">
          </div>
          <div style="margin-top: 90px;"></div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Supplier</label>
              <select id="supplier_id" name="supplier_id" class="form-control" required>
                <option value=""> - Pilih Supplier - </option>
                @foreach($supplier as $key)
                    <option value = "{{$key->id}}" <?php if ($key->id == $dataSupplier) echo 'selected';?>> {{ $key->supplier_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Tipe</label>
              <select id="tipe_pembayaran" class="form-control">
                <option value=""> - Pilih Tipe Pembayaran - </option>
                <option value = "1" <?php if ($purchase->tipe == "1") echo 'selected';?>>Cash</option>
                <option value = "2" <?php if ($purchase->tipe == "2") echo 'selected';?>>Credit</option>
                <!-- <option value="1">Cash</option>
                <option value="2">Credit</option> -->
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>DP</label>
              <input type="number" class="form-control" id="dp" value="{{$purchase->dp}}">
            </div>
            <?php 
              if($purchase->tipe ==1){
                  $style = "style=display:none";
              }
              else{
                  $style = '';
              } 
              ?>
            <div id="container_jatuh_tempo" {{$style}} class="form-group">
              <label>Jatuh Tempo:</label>
              <select id="jatuh_tempo" class="form-control">
                 <option value=""> - Pilih Tempo - </option>
                 <option value = "1" <?php if ($purchase->hari == "1") echo 'selected';?>>1 HARI</option>
                 <option value = "7" <?php if ($purchase->hari == "7") echo 'selected';?>>7 HARI</option>
                 <option value = "14" <?php if ($purchase->hari == "14") echo 'selected';?>>14 HARI</option>
                 <option value = "28" <?php if ($purchase->hari == "28") echo 'selected';?>>28 HARI</option>
                 <option value = "30" <?php if ($purchase->hari == "30") echo 'selected';?>>30 HARI</option>
                 <option value = "45" <?php if ($purchase->hari == "45") echo 'selected';?>>45 HARI</option>
                 <option value = "60" <?php if ($purchase->hari == "60") echo 'selected';?>>60 HARI</option>
                 <option value = "75" <?php if ($purchase->hari == "75") echo 'selected';?>>75 HARI</option>
                 <option value = "90" <?php if ($purchase->hari == "90") echo 'selected';?>>90 HARI</option>
              </select>
            </div>
            <div class="form-group">
              <label>Deskripsi</label>
              <textarea id="description" name="description" class="form-control"  required style="height: 60px;border-radius: 3px;">{{ $purchase->description }}</textarea>
            </div>
          </div>
          <div class="col-md-4">
            
           <div class="info-box">
            <span class="info-box-icon bg-whitesmoke"><i class="fa fa-dollar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Pembelian</span>
              <span class="info-box-number pull-right" style="font-size: 30px;" id="total_transaksi"></span>
            </div>
            <!-- /.info-box-content -->
          </div> 
          </div>
          <div class="row">
            <div class="col-md-12">
              
            </div>
          </div>
        </div>
         
        </div>
        <div class="box-header with-border" style="background-color: #FFEBCD">
          <div class="row">
          <div class="col-md-12">
            <button onclick="addItem()" id="tambah_item" class="btn btn-sm btn-default pull-left"><i class="fa fa-plus"></i> Item</button>
          </div>
          </div>
          <div style="margin-bottom: 10px"></div>
              <div class="row" id="ruang_tambah" style="display: none;">
                <div class="col-md-3">

                  <select class="form-control" id="barang" name="barang">
                    <option value=""> -Pilih Barang- </option>
                    @foreach($barang as $row)
                        <option value="{{$row->id}}">{{$row->material_name}}</option>
                    @endforeach
                  </select>
                  
                </div>
                <div class="col-md-2">
                  <input id="jumlah" type="text" class="form-control bulat" placeholder="Jumlah">
                </div>
                <div class="col-md-2">
                  <input id="harga" type="number" class="form-control bulat" placeholder="Harga">
                </div>
                <div class="col-md-2">
                  <input id="satuan" type="text" class="form-control bulat" placeholder="Satuan" readonly="readonly">
                </div>
                <div class="col-md-2">
                  <input id="total" type="number" class="form-control bulat" placeholder="Total" readonly="readonly">
                </div>
                <div class="col-md-1">
                  <button id="tambahData" class="btn btn-info"><i class="fa fa-plus"></i></button>
                </div>
              </div>
          

        </div>


        <div class="box-body">
          <div class="table-responsive">
            <div class="col-md-10">
                <table id="item-table" class="table table-bordered table-hover">
                  <thead>
                      <tr>
                          <th width="2%">ID</th>
                          <th width="5%">ItemCD</th>
                          <th width="*">ItemName</th>
                          <th width="10%">Sat.</th>
                          <th width="15%">Harga</th>
                          <th width="10%">Qty</th>
                          <th width="15%">Total</th>
                          <th width="10%">Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                  <tfoot>
                      <tr>
                          <th width="2%">ID</th>
                          <th width="5%">ItemCD</th>
                          <th width="*">ItemName</th>
                          <th width="10%">Sat.</th>
                          <th width="15%">Harga</th>
                          <th width="10%">Qty</th>
                          <th width="15%">Total</th>
                          <th width="10%">Aksi</th>
                      </tr>
                  </tfoot>
                </table>
            </div>
            <div class="col-md-2">
                <div style="margin-top: 8px"></div>
                <button onclick="updatePembelian()" class="btn btn-sm btn-primary form-control"><i class="fa fa-save"></i> Update</button>
                <div style="margin-top: 3px"></div>
                <button onclick="batalPembelian()" class="btn btn-sm btn-warning form-control"><i class="fa fa-remove"></i> Batal</button>
            </div>
            
          
        </div>
        </div>
      
      </div>



      <div class="modal" id="modal-purchase" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
          
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"> &times; </span>
                  </button>
                  <h3 class="modal-title"></h3>
              </div>

              

                  <form id="form-purchase" data-toggle="validator">
                  {{ csrf_field() }} {{ method_field('POST') }}
                  <div class="modal-body">
                      <input type="hidden" id="id" name="id">
                      
                      <div class="form-group">
                          <label for="quantity" class="control-label">Barang :</label>
                          <select id="item" name="item" class="form-control">
                              @foreach($barang as $brg)
                                  <option value="{{$brg->id}}">{{$brg->material_name}}</option>
                              @endforeach
                          </select>
                          <span class="help-block with-errors"></span>
                          
                      </div>

                      <div class="form-group">
                          <label for="quantity" class="control-label">Jumlah :</label>
                          <input type="text" id="quantity_modal" name="quantity" class="form-control" required>
                          <span class="help-block with-errors"></span>
                          
                      </div>

                      <div class="form-group">
                          <label for="item_price" class="control-label">Harga :</label>
                          <input type="number" id="item_price_modal" name="item_price" class="form-control" required>
                          <span class="help-block with-errors"></span>
                          
                      </div>

                      <div class="form-group">
                          <label for="item_total" class="control-label">Total :</label>
                          <input type="number" id="item_total_modal" name="item_total" class="form-control" readonly>
                          <span class="help-block with-errors"></span>
                          
                      </div>

                  </div>

                  <div class="modal-footer">
                      <button type="submit" id="btn_edit" class="btn btn-warning">Update</button>
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

          $('#supplier_id').select2({
            theme: "bootstrap"
          });

          $('#barang').select2({
            theme: "bootstrap"
          });

          hitungTotal();
      
          

          var table = $('#item-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.item') }}",
              columns: [
                {data:'id', name: 'id'},
                {data:'item_cd', name: 'item_cd', orderable:false, searchable:false},
                {data:'material_name', name: 'material_name',orderable:false, searchable:false},
                {data:'item_unit', name: 'item_unit', orderable:false, searchable:false},
                {data:'item_price', name: 'item_price', orderable:false, searchable:false},
                {data:'quantity', name: 'quantity', orderable:false, searchable:false},
                {data:'item_total', name: 'item_total', orderable:false, searchable:false},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });

          


          function addItem(){
            $('#ruang_tambah').show();
            $('#barang').val("");
            $('#jumlah').val("");
            $('#harga').val("");
            $('#satuan').val("");
            $('#total').val("");
          }

          


          $('#tambahData').click(function() {
            
              var barang = $('#barang').val();
              var jumlah = $('#jumlah').val();
              var satuan = $('#satuan').val();
              var harga = $('#harga').val();
              var total = $('#total').val();
              var csrf_token = $('meta[name="csrf-token"]').attr('content');

              if(barang ==''){alert('Barang Belum Dipilih...'); }
              else if(jumlah < 0 || jumlah ==''){alert('Jumlah Barang Tidak Valid...');}
              else {

                $.ajax({
                    url: "{{ url('simpan_item') }}",
                    type : "POST", 
                    dataType : "JSON", 
                    data : {barang:barang, jumlah:jumlah, satuan:satuan, harga:harga, total:total, _token:csrf_token},
                    success:function(data){
                        if(data=='exist'){
                          alert("Item Ini Sudah Ada...");
                        }
                        else{
                          $('#ruang_tambah').hide();
                          reloadTable();
                        }
                        
                    }
                });
            }
        });


          $('#barang').change(function(){
            var barang = $('#barang').val();

            $.ajax({
                url : "{{ url('caribrg') }}"+'/'+barang,
                type : "GET",
                dataType : "JSON",
                success:function(data){
                    $('#satuan').val(data.unit);
                    $('#harga').val(data.s_price);
                    var jumlah = $('#jumlah').val();
                    var harga = data.s_price;
                    var total = jumlah * harga;
                    $('#total').val(total);
                },
                error: function(){
                  alert("Nothing Data....");
                }
            });

          });




          $('#jumlah').keyup(function(e){
              var jumlah = $(this).val();
              var harga = $('#harga').val();

              total = jumlah * harga;
              $('#total').val(total);
          });


          $('#jumlah').change(function(e){
              var jumlah = $(this).val();
              var harga = $('#harga').val();

              total = jumlah * harga;
              $('#total').val(total);
          });




          $('#harga').keyup(function(e){
              var harga = $(this).val();
              var jumlah = $('#jumlah').val();

              total = jumlah * harga;
              $('#total').val(total);
          });




          function editForm(id){

              $('input[name=_method]').val('POST');
              $('#modal-purchase form')[0].reset();
              $.ajax({
                  url: "{{ url('editItem') }}" + '/'+id,
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){
                      $('#modal-purchase').modal("show");
                      $('.modal-title').text("Edit Item");

                      $('#id').val(data.id);
                      $('#item').val(data.item_cd);
                      $('#quantity_modal').val(data.quantity);
                      $('#item_price_modal').val(data.item_price);
                      $('#item_total_modal').val(data.item_total);                     
                },

                error: function(){
                  alert("Nothing Data....");
                }

              });
          }


          $('#quantity_modal').keyup(function(){
              var jumlah = $(this).val();
              var harga = $('#item_price_modal').val();
              var total = jumlah * harga;
              $('#item_total_modal').val(total);

          });


          $('#quantity_modal').change(function(){
              var jumlah = $(this).val();
              var harga = $('#item_price_modal').val();
              var total = jumlah * harga;
              $('#item_total_modal').val(total);

          });

          $('#item_price_modal').keyup(function(){
              var harga = $(this).val();
              var jumlah = $('#quantity_modal').val();
              var total = jumlah * harga;
              $('#item_total_modal').val(total);

          });


          $('#item_price_modal').change(function(){
              var harga = $(this).val();
              var jumlah = $('#quantity_modal').val();
              var total = jumlah * harga;
              $('#item_total_modal').val(total);

          });

          $('#tipe_pembayaran').change(function(){
             var id = $(this).val();
             if(id=="2"){
                $('#container_jatuh_tempo').show();
             }else{
                $('#jatuh_tempo').val("");
                $('#container_jatuh_tempo').hide();
             }
          })



          $('#form-purchase').submit(function(e){
            e.preventDefault();

              var id = $('#id').val();
              var harga = $('#item_price_modal').val();
              var total = $('#item_total_modal').val();
              var jumlah = $('#quantity_modal').val();
              var _token = $('input[name="_token"]').val();

              $.ajax({
                  url : "{{ url('item_update') }}",
                  type : "POST",
                  data : {id:id, harga:harga, total:total, jumlah:jumlah, _token:_token },
                  success : function(data){
                      $('#modal-purchase').modal('hide');
                      reloadTable();
                  },
                  error:function(){
                    alert("Opps Something Error");
                  }

              });

          });




          function deleteData(id){
            var popup = confirm('Anda Yakin Ingin Menghapus Data...?');
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            if(popup == true){
                $.ajax({
                    url  : "{{ url('item_hapus') }}" + '/'+id,
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


          function updatePembelian(){
            var popup = confirm('Anda Yakin Ingin Mengupdate Data...?');
            if(popup==true){
                var invoice = $('#invoice').val();
                var supplier = $('#supplier_id').val();
                var deskripsi = $('#description').val();
                var dp = $('#dp').val();
                var tipe_pembayaran = $('#tipe_pembayaran').val();
                var jatuh_tempo =$('#jatuh_tempo').val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                var strTotal = $('#total_transaksi').text();
                var xtotal = strTotal.replace('Rp.', '');
                var ytotal = xtotal.replace('.', '');
                var total = ytotal.replace('.', '');

                console.log(total);
               
                if(supplier=='') alert('Supplier Tidak Boleh Kosong...!');
                if(deskripsi=='') alert('Deskripsi Tidak Boleh Kosong...!');
                if(tipe_pembayaran=='') alert('Tipe Pembayaran Tidak Boleh Kosong...!');

                $.ajax({
                    url : "{{ url('update_purchase') }}",
                    type : "POST",
                    data : {'invoice':invoice, 'supplier':supplier, 'deskripsi':deskripsi, 'dp':dp, 'tipe_pembayaran':tipe_pembayaran, 'jatuh_tempo':jatuh_tempo, 'total':total, '_token':csrf_token },
                    success:function(data){
                          alert('Pembelian Diupdate...');
                          reloadTable();
                          $('#supplier_id').val(null).trigger('change');
                          $('#description').val("");
                          window.location="{{ url('purchase') }}";
                    }
                });

            }
          }


          function batalPembelian(){
              var popup = confirm('Anda Yakin Ingin Membatalkan Transaksi...?');
              if(popup==true){

                  var csrf_token = $('meta[name="csrf-token"]').attr('content');

                  $.ajax({
                      url : "{{ url('batal_pembelian') }}",
                      type :"POST",
                      data : {'_token':csrf_token},
                      success:function(data){
                          reloadTable();
                          $('#supplier_id').val(null).trigger('change');
                          $('#description').val("");
                          window.location="{{ url('purchase') }}";
                      }

                  });
              }


          }



          function reloadTable() {
            $("#item-table").DataTable().ajax.reload(null,false);
            hitungTotal();
          }


          function hitungTotal(){

            $.ajax({
                url : "{{ url('total_purchase') }}",
                type : "GET",
                cache : false,
                dataType : "JSON",
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