@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tambah Produksi
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ url('production') }}">Proses Produksi</a></li>
      <li><a href="{{ url('addProduction') }}">Tambah Produksi</a></li>

    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border" style="background-color: whitesmoke">
        <div class="row">

          <div class="col-md-12">
            <div class="form-group">
              <label>Customer</label>
              <select style="width:100%" id="customer" name="customer" class="form-control" required>
                <option value=""> - Pilih Customer - </option>
                @foreach($customer as $key)
                <option value="{{ $key->id }}">{{ $key->customer_name }}</option>
                @endforeach;
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Grade</label>
              <input type="text" class="form-control" id="grade" name="grade" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Colour</label>
              <input type="text" class="form-control" id="colour" name="colour" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Hardness</label>
              <input type="text" class="form-control" id="hardness" name="hardness" required>
            </div>
          </div>
          
          <div class="col-md-12">
            <div class="form-group">
              <label>Deskripsi</label>
              <textarea id="description" name="description" class="form-control" required style="height: 60px;border-radius: 3px;"></textarea>
            </div>
          </div>

        </div>
        <div class="row" style="display:none;">
          <div class="col-md-12">
            <div class="form-group">
              <label>Batch:</label>
              <select id="batch" name="batch" class="form-control">
                @foreach($batch as $key)
                <option value="{{ $key->id }}">{{ $key->batch }}</option>
                @endforeach
              </select>
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
              <option value="{{ $row->id }}">{{ $row->good_name }}</option>
              @endforeach
            </select>

          </div>
          <div class="col-md-2">
            <input id="jumlah" type="number" class="form-control bulat" placeholder="Jumlah">
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
            <button onclick="simpanProduksi()" class="btn btn-sm btn-primary form-control"><i class="fa fa-save"></i> Simpan</button>
            <div style="margin-top: 3px"></div>
            <button onclick="batalProduksi()" class="btn btn-sm btn-warning form-control"><i class="fa fa-remove"></i> Batal</button>
          </div>
          <div class="col-md-12">
            <a href="{{ url('production') }}"><button class="btn btn-sm btn-info"><i class="fa fa-arrow-left"></i> Kembali</button></a>
          </div>
          
        </div>
      </div>
      
    </div>



    <div class="modal fade" id="modal-purchase" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
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
                  @foreach($barang as $row)
                  <option value="{{ $row->id }}" >{{ $row->material_name }}</option>
                  @endforeach
                </select>
                <span class="help-block with-errors"></span>

              </div>

              <div class="form-group">
                <label for="quantity" class="control-label">Jumlah :</label>
                <input type="number" id="quantity_modal" name="quantity" class="form-control" required>
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

    <div class="modal fade" id="modal-stok" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"> &times; </span>
            </button>
            <h3 class="modal-title modal-stok"></h3>
          </div>

          <form id="form-stok" data-toggle="validator">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="modal-body">
              <div id="isimodalstok"></div>
            </div>
            <div class="modal-footer">
              <button type="submit" id="btn_edit" class="btn btn-warning">Tambah</button>
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



  var kurangstok = 0;

  $('#supplier_id').select2({
    theme: "bootstrap"
  });

  $('#customer').select2({
    theme: "bootstrap"
  });

  $('#barang').select2({
    theme: "bootstrap"
  });

  hitungTotal();


  $("#form-stok").submit(function(e){
    e.preventDefault();
    var barang = $("#barang").val();
    var jumlah = $("#jumlah").val();
    var satuan = $("#satuan").val();
    var harga = $('#harga').val();
    var total = $('#total').val();
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    if(kurangstok > 0 ) {
      alert('Stok Bahan Baku Tidak Cukup...!');
    } else {
     $.ajax({
      url: "{{ url('simpan_item_produksi') }}",
      type : "POST", 
      dataType : "JSON", 
      data : {barang:barang, jumlah:jumlah, satuan:satuan, harga:harga, total:total, _token:csrf_token},
      success:function(data){
        if(data=='exist'){
          alert("Item Ini Sudah Ada...");
        }
        else{
          $('#ruang_tambah').hide();
          $("#modal-stok").modal('hide');
          reloadTable();
        }

      }
    });

   }
 });



  var table = $('#item-table').DataTable({
    processing:true,
    serverSide:true,
    ajax: "{{ route('api.productionitem') }}",
    order: [[ 0, "desc" ]],
    columns: [
    {data:'id', name: 'id'},
    {data:'item_cd', name: 'item_cd', orderable:false, searchable:false},
    {data:'good_name', name: 'good_name',orderable:false, searchable:false},
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
   cekitem()
   
 });



  function cekitem() {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
     url : "{{ url('cekitemproduksi') }}",
     type : "POST",
     dataType : "JSON",
     data : {'_token': csrf_token},
     success: function(data) {
      console.log('cekitem', data);
      if(data == 0) {
        var barang = $("#barang").val();
        var jumlah = $("#jumlah").val();
        var satuan = $("#satuan").val();
        var harga = $('#harga').val();
        var total = $('#total').val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');

        if(barang ==''){alert('Barang Belum Dipilih...'); }
        else if(jumlah < 0 || jumlah ==''){alert('Jumlah Barang Tidak Valid...');}
        else {
          $("#modal-stok").modal("show");

          $.ajax({
           url : "{{ url('getbahanbaku') }}",
           type : "POST",
           cache :false,
           data : {barang:barang, jumlah:jumlah, satuan:satuan, '_token': csrf_token},
           success : function(data) {
            $("#isimodalstok").html(data.html);
            var title = data.barang+' ('+data.qty_order+' '+data.satuan+')';
            $(".modal-stok").html(title);
            kurangstok = data.kurangstok;
            console.log('data_bahan_baku', data);     
          }
        });
        }
      } else {
        alert('Item Produk Jadi Tidak Boleh Lebih Dari Satu Dalam Satu SPK...!');
      }
    }
  });
  }  



  $('#barang').change(function(){
    var barang = $('#barang').val();

    $.ajax({
      url : "{{ url('caribrgproduksi') }}"+'/'+barang,
      type : "GET",
      cache: false,
      dataType : "JSON",
      success:function(data){
        $('#satuan').val(data.unit);
        $('#harga').val(data.b_price);
        var jumlah = $('#jumlah').val();
        var harga = data.b_price;
        var total = jumlah * harga;
        $('#total').val(total);
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




  function deleteitem(id){
    var popup = confirm('Anda Yakin Ingin Menghapus Data...?');
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    if(popup == true){
      $.ajax({
        url  : "{{ url('item_hapus_produksi') }}" + '/'+id,
        type : "POST",
        data : {'_method':'DELETE', '_token':csrf_token},
        success : function($data){
          reloadTable();
          alert('Data Berhasil Dihapus')
        }
      });
    }
  }


  function cekcart() {
     $.ajax({
        url : "{{ url('cekcart') }}",
        type : "GET",
        dataType : "JSON",
        success : function(data) {
          console.log('cart', data);
          if(data > 0) {
            simpanProduksiConfirm();

          } else {
            alert("Data Item Belum Ditambahkan...!");
          }
        }

     })
  } 

  function simpanProduksi() {
    cekcart();
  }

  function simpanProduksiConfirm(){
    var popup = confirm('Anda Yakin Ingin Menyimpan Data...?');
    if(popup==true){
      var deskripsi = $('#description').val();
      var batch = $("#batch").val();
      var customer = $("#customer").val();
      var grade = $("#grade").val();
      var colour = $("#colour").val();
      var hardness = $("#hardness").val();

      var csrf_token = $('meta[name="csrf-token"]').attr('content');
      if(deskripsi=='') alert('Deskripsi Tidak Boleh Kosong...!');


      $.ajax({
        url : "{{ url('simpan_produksi') }}",
        type : "POST",
        data : {'deskripsi':deskripsi, 'batch':batch,'customer':customer, 'grade':grade, 'colour':colour, 'hardness':hardness, '_token':csrf_token },
        success:function(data){
          alert('Production Disimpan...');
          reloadTable();
          $('#description').val("");
          // window.location="{{ url('production') }}";
        }
      });

    }
  }


  function batalProduksi(){
    var popup = confirm('Anda Yakin Ingin Membatalkan Transaksi...?');
    if(popup==true){
      var csrf_token = $('meta[name="csrf-token"]').attr('content');

      $.ajax({
        url : "{{ url('batal_produksi') }}",
        type :"POST",
        data : {'_token':csrf_token},
        success:function(data){
          reloadTable();

          $('#description').val("");
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
      cache: false,
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


        $('#total_transaksi').text(ttl);
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