@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah Penjualan
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('sales') }}">Proses Penjualan</a></li>
        <li><a href="{{ url('addSales') }}">Tambah Penjualan</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border" style="background-color: whitesmoke">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Tanggal Transaksi:</label>
              <input type="date" class="form-control bulat" id="trans_date">
            </div>
            <div class="form-group">
              <label>Customer</label>
              <select id="customer_id" name="customer_id" class="form-control" required>
                  <option value=""> - Pilih Customer - </option>
                  @foreach($customer as $value)
                      <option value="{{$value->id}}">{{$value->customer_name}}</option>
                  @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Tipe</label>
              <select id="tipe_pembayaran" class="form-control bulat">
                <option value=""> - Pilih Tipe Pembayaran - </option>
                <option value="1">Cash</option>
                <option value="2">Credit</option>
              </select>
            </div>

          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>DP</label>
              <input type="number" class="form-control bulat" id="dp">
            </div>
            <div id="container_jatuh_tempo" style="display: none;" class="form-group bulat">
              <label>Jatuh Tempo:</label>
              <select id="jatuh_tempo" class="form-control">
                 <option value=""> - Pilih Tempo - </option>
                 <option value="1">1 HARI </option>
                 <option value="7">7 HARI </option>
                 <option value="14">14 HARI </option>
                 <option value="28">28 HARI </option>
                 <option value="30">30 HARI </option>
                 <option value="45">45 HARI </option>
                 <option value="60">60 HARI </option>
                 <option value="75">75 HARI </option>
                 <option value="90">90 HARI </option>
              </select>
            </div>
            
            <div class="form-group">
              <label>Deskripsi</label>
              <textarea id="description" name="description" class="form-control" required style="height: 60px;border-radius: 3px;"></textarea>
            </div>
          </div>
          <div class="col-md-4">
            
           <div class="info-box bg-aqua">
            <span class="info-box-icon bg-whitesmoke"><i class="fa fa-dollar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Penjualan</span>
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
        <div class="box-header with-border" style="background-color: skyblue">
          <div class="row">
          <div class="col-md-12">
            <button onclick="addItem()" id="tambah_item" class="btn btn-sm btn-default pull-left"><i class="fa fa-plus"></i> Item</button>
          </div>
          </div>
          <div style="margin-bottom: 10px"></div>
              <div class="row" id="ruang_tambah" style="display: none;">
                <div class="col-md-3">
                  <select class="form-control" id="barang" name="barang">
                      <option value=""> - Pilih Barang - </option>
                      @foreach($good as $key)
                          <option value="{{$key->id}}">{{$key->good_name}}</option>
                      @endforeach
                  </select>
                  
                </div>
                <div class="col-md-2">
                  <input id="jumlah" type="number" class="form-control bulat" placeholder="Jumlah">
                </div>
                <div class="col-md-2">
                  <select id="harga" name="harga" class="form-control" required>
                    <option value="">Harga</option>
                  </select>
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
                <button onclick="simpanPenjualan()" class="btn btn-sm btn-primary form-control"><i class="fa fa-save"></i> Simpan</button>
                <div style="margin-top: 3px"></div>
                <button onclick="batalPenjualan()" class="btn btn-sm btn-warning form-control"><i class="fa fa-remove"></i> Batal</button>
                <button style="margin-top: 3px" onclick="discountSales()" class="btn btn-sm btn-danger form-control"><i class="fa fa-money"></i> Discount</button>
            </div>
            <div class="col-md-12">
                <a href="{{ url('sales') }}"><button class="btn btn-sm btn-info"><i class="fa fa-arrow-left"></i> Kembali</button></a>
            </div>
          
        </div>
        </div>
      
      </div>

      <!-- MODAL AREA=============================================================== -->

      <div class="modal" id="modal-edit" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
          
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"> &times; </span>
                  </button>
                  <h3 class="modal-edit-title"></h3>
              </div>

                  <form id="form-edit" data-toggle="validator">
                  {{ csrf_field() }}
                  <div class="modal-body">
                      <input type="hidden" id="id_edit" name="id_edit">
                      
                      <div class="form-group">
                          <label for="quantity" class="control-label">Barang :</label>
                          <select disabled id="item_edit" name="item_edit" class="form-control">
                              <option value=""> - Pilih Barang - </option>
                              @foreach($good as $key)
                                  <option value="{{$key->id}}">{{$key->good_name}}</option>
                              @endforeach   
                          </select>
                          <span class="help-block with-errors"></span>
                      </div>

                      <div class="form-group">
                          <label for="quantity" class="control-label">Jumlah :</label>
                          <input type="number" id="quantity_edit" name="quantity_edit" class="form-control" required>
                          <span class="help-block with-errors"></span>
                          
                      </div>
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label for="item_price" class="control-label">Harga :</label>
                                <input type="number" id="item_price_edit" name="item_price_edit" class="form-control" required readonly>
                                <a href="javascript:void(0)"><span onclick="ubahHarga()" class="pull-right">Ubah Harga...</span></a>
                                <span class="help-block with-errors"></span>
                              </div>  
                          </div>
                      </div>
                      

                      <div class="form-group">
                          <label for="item_total" class="control-label">Total :</label>
                          <input type="number" id="item_total_edit" name="item_total_edit" class="form-control" readonly>
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


      <div class="modal" id="modal-price" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
          
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"> &times; </span>
                  </button>
                  <h4 class="modal-price-title"></h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id_harga">
                  <select class="form-control" id="combo_harga" class="form-control">
                  </select>
                  
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div> 
          </div>
        </div>
      </div> <!--end modal-->



      <div class="modal" id="modal-discount" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
          
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"> &times; </span>
                  </button>
                  <h4 class="modal-discount-title"></h4>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                    <input type="number" class="form-control" id="txtDiscount" placeholder="Masukkan Jumlah Diskon (Rp.)">
                  </div>      
                
             </div>
             <div class="modal-footer">
                <button id="btn_discount" onclick="disCount()" class="btn btn-danger">Discount</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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

          $('#customer_id').select2({
            theme: "bootstrap"
          });

          $('#barang').select2({
            theme: "bootstrap"
          });

          $('#item_modal').select2({
            theme: "bootstrap"
          });

          hitungTotal();
      
          

          var table = $('#item-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('sales.item') }}",
              order: [[ 0, "desc" ]],
              columns: [
                {data:'id', name: 'id'},
                {data:'item_cd', name: 'item_cd', orderable:false, searchable:false},
                {data:'good_name', name: 'good_name',orderable:false, searchable:false},
                {data:'uom', name: 'uom', orderable:false, searchable:false},
                {data:'price', name: 'price', orderable:false, searchable:false},
                {data:'quantity', name: 'quantity', orderable:false, searchable:false},
                {data:'total', name: 'total', orderable:false, searchable:false},
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
                    url: "{{ url('simpan_sales_item') }}",
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
                    },
                    error:function(){
                        alert('Opps Something Error');
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
                    $('#jumlah').val('');
                    $('#total').val('');
                    select_barang(barang);
                },
                error: function(){
                  alert("Nothing Data....");
                }
            });

          });



          function select_barang(id) {
              
              $.ajax({
                  url : "{{ url('select_sales_item') }}"+"/"+id,
                  type : "GET",
                  dataType : "JSON",
                  success:function(data){
                      console.log(data);
                      var sel = $('#harga');
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


          $('#harga').change(function(){
              var harga = $(this).val();
              var jumlah = $('#jumlah').val();

              total = jumlah * harga;
              $('#total').val(total);
          });



          function editData(id){

              $.ajax({
                  url : "{{url('edit_sales_item')}}"+"/"+id,
                  type : "GET",
                  dataType : "JSON",
                  success : function(data){
                      // console.log(data);
                      $('#id_edit').val(data.id);
                      $('#item_edit').val(data.item_cd);
                      $('#quantity_edit').val(data.quantity);
                      $('#item_price_edit').val(data.price);
                      $('#item_total_edit').val(data.total);

                      $('#modal-edit').modal("show");
                      $('.modal-edit-title').html("Edit Data Barang");
                  },
                  error : function(){
                      alert("Something Error...");
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



          function ubahHarga(){
              var id = $('#item_edit').val();
              $('#id_harga').val(id);
              $.ajax({
                  url : "{{ url('list_harga_barang') }}"+"/"+id,
                  type : "GET",
                  dataType : "JSON",
                  success : function(data){
                      var sel = $('#combo_harga');
                      sel.empty();
                      // sel.append('<option value="">- Pilih Harga Jual -</option>');
                      for (var i=0; i<data.length; i++) {
                          sel.append('<option value='+data[i]+'>'+data[i]+'</option>');
                      }
                  },  
                  error : function(){
                      alert("Something Error....");
                  }
              });

              $('#modal-price').modal("show");
              $('.modal-price-title').html("Harga item")
          }



          $('#combo_harga').change(function(){
              var harga = $(this).val();
              var jumlah = $('#quantity_edit').val();
              var total = harga * jumlah;
              $('#item_price_edit').val(harga);
              $('#item_total_edit').val(total);
              $('#modal-price').modal("hide");

          })




          $('#tipe_pembayaran').change(function(){
             var id = $(this).val();
             if(id=="2"){
                $('#container_jatuh_tempo').show();
             }else{
                $('#jatuh_tempo').val("");
                $('#container_jatuh_tempo').hide();
             }
          })



          function deleteData(id) {
              
              var popup = confirm('Anda Yakin Ingin Menghapus Data...?');
              var csrf_token = $('meta[name="csrf-token"]').attr('content');
              
              if(popup == true){
                  $.ajax({
                      url  : "{{ url('item_sales_hapus') }}",
                      type : "POST",
                      data : {id:id , _token:csrf_token},
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



          
          $('#modal-edit form').submit(function(e){
              e.preventDefault();

              $.ajax({
                  url : "{{ url('update_sales_item') }}",
                  type : "POST",
                  data : $('#modal-edit form').serialize(),
                  success : function(data){
                      reloadTable();
                      $('#modal-edit').modal("hide");
                  },
                  error : function(){
                      alert("Something Error...");
                  }
              });

          });



          $('#quantity_edit').keyup(function(){

              var jumlah = $('#quantity_edit').val();
              var harga = $('#item_price_edit').val();
              var total = jumlah * harga;
              $('#item_total_edit').val(total);
          });




          function simpanPenjualan(){

            var popup = confirm('Anda Yakin Ingin Menyimpan Data...?');
            
            if(popup==true){

                var tgl_trans = $('#trans_date').val();
                var customer = $('#customer_id').val();
                var deskripsi = $('#description').val();
                var dp = $('#dp').val();
                var tipe_pembayaran = $('#tipe_pembayaran').val();
                var jatuh_tempo =$('#jatuh_tempo').val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                var strTotal = $('#total_transaksi').text();
                var xtotal = strTotal.replace('Rp.', '');
                var ytotal = xtotal.replace('.', '');
                var total = ytotal.replace('.', '');

                // console.log(total);
               
                if(tgl_trans =='') alert("Tanggal Transaksi Tidak Boleh Kosong...!");
                if(customer=='') alert('Customer Belum Dipilih...!');
                if(deskripsi=='') alert('Deskripsi Tidak Boleh Kosong...!');
                if(tipe_pembayaran=='') alert('Tipe Pembayaran Tidak Boleh Kosong...!');

                $.ajax({
                    url  : "{{ url('simpan_transaksi_sales') }}",
                    type : "POST",
                    data : {tgl_trans:tgl_trans, customer:customer, deskripsi:deskripsi, dp:dp, tipe_pembayaran:tipe_pembayaran, jatuh_tempo:jatuh_tempo, total:total, _token:csrf_token },
                    success:function(data){
                          alert('Penjualan Disimpan...');
                          reloadTable();
                          clearForm()
                          window.location="{{ url('sales') }}";
                    },
                    error:function(){
                          alert("Something Error....");
                    }   

                });

            }
          }


          function clearForm() {
              $('#customer_id').val(null).trigger('change');
              $('#description').val("");
              $('#dp').val("");
              $('#tipe_pembayaran').val("");
              $('#jatuh_tempo').val("");
          }


          function batalPenjualan(){
              var popup = confirm('Anda Yakin Ingin Membatalkan Transaksi...?');
              if(popup==true){

                  var csrf_token = $('meta[name="csrf-token"]').attr('content');

                  $.ajax({
                      url : "{{ url('batal_penjualan') }}",
                      type :"POST",
                      data : {'_token':csrf_token},
                      success:function(data){
                          reloadTable();
                          clearForm();
                          $('#container_jatuh_tempo').hide();
                      },
                      error:function(){
                        alert("Opps Something Error...");
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
                url : "{{ url('total_sales') }}",
                type : "GET",
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
                }, 
                error: function(){
                    alert("Opps Something Error");
                }

            });
          }


          function discountSales(){
              $('#modal-discount').modal("show");
              $('.modal-discount-title').html("Discount Total");
              $('#txtDiscount').val("");
          }


          function disCount(){
            
              var diskon = $('#txtDiscount').val();
              var csrf_token = $('meta[name="csrf-token"]').attr('content');
              $.ajax({
                  url : "{{ url('discount') }}",
                  type : "POST",
                  data : { diskon: diskon, _token:csrf_token},
                  success : function(data){

                      $('#modal-discount').modal("hide");
                      alert("Diskon Ditambahkan...");
                      reloadTable();

                  },
                  error : function(){
                      alert("Something Error...");
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