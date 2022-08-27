@extends('master')

@section('content')

<?php $dataCustomer = isset($_POST['customer_id']) ? $_POST['customer_id'] : $q->customer;?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Quotation
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('quote') }}">Proses Quotation</a></li>
        <li><a href="javascript:void(0)">Edit Quotation</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border" style="background-color: whitesmoke">
        <div class="row">
          <div class="col-md-12">
              <h3 style="color:blue"><u>No Quotation : {{$invoice}}</u></h3>
              <input type="hidden" id="quote_nota" value="{{$invoice}}">  
          </div>
          
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <select id="customer_id" name="customer_id" class="form-control" required>
                  <option value=""> - Pilih Customer - </option>
                  @foreach($customer as $key)
                    <option value = "{{$key->id}}" <?php if ($key->id == $dataCustomer) echo 'selected';?>> {{ $key->customer_name }}</option>
                  @endforeach
              </select>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="attn" name="attn" placeholder="Attn" value="{{$q->attn}}" required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="dari" name="dari" placeholder="From" required value="{{$q->dari}}">
            </div>
          </div>
          <div class="col-md-3">
              <div class="form-group">
                  <input type="date" class="form-control" id="tanggal" name="tanggal" required value="{{date('Y-m-d', strtotime($q->created_at))}}">
              </div>
              <div class="form-group">
                  <input type="text" id="email" name="email" class="form-control" placeholder="Email" value="{{$q->email}}">
              </div>
              <div class="form-group">
                  <input type="text" id="fax" name="fax" class="form-control" placeholder="Fax" value="{{$q->fax}}">
              </div>
          </div>
          <div class="col-md-2">
              <div class="form-group">
                <input type="text" id="ref" name="ref" class="form-control" placeholder="Our Reff" value="{{$q->ref}}">
              </div>
              <div class="form-group">
                <input type="text" id="ref2" name="ref2" class="form-control" placeholder="Your Reff" value="{{$q->ref2}}">
              </div>
          </div>
          
     
          <div class="col-md-4">
            
           <div class="info-box bg-maroon">
            <span class="info-box-icon bg-whitesmoke"><i class="fa fa-dollar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Quotation</span>
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
        <div class="box-header with-border" style="background-color: orange">
          <div class="row">
          <div class="col-md-12">
            <button onclick="addItem()" id="tambah_item" class="btn btn-sm btn-default pull-left"><i class="fa fa-plus"></i> Item</button>
          </div>
          </div>
          <div style="margin-bottom: 10px"></div>
              <div class="row" id="ruang_tambah" style="display: none;">
                <div class="col-md-4">
                  <input type="text" class="form-control bulat" id="description" name="description" required placeholder="Deskripsi">        
                </div>
                <div class="col-md-1">
                  <input id="jumlah" type="number" class="form-control bulat" placeholder="Jumlah">
                </div>
                <div class="col-md-2">
                  <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga" required>
                </div>
                <div class="col-md-2">
                  <select id="satuan" name="satuan" class="form-control bulat" required>
                      <option value=""> - Pilih Satuan - </option>
                      @foreach($unit as $value)
                      <option value="{{$value->unit}}">{{$value->unit}}</option>
                      @endforeach
                  </select>
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
                          <th width="*">Description</th>
                          <th width="10%">Sat.</th>
                          <th width="10%">Qty</th>
                          <th width="15%">Harga</th>
                          <th width="15%">Total</th>
                          <th width="10%">Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                  <tfoot>
                      <tr>
                          <th width="2%">ID</th>
                          <th width="*">Description</th>
                          <th width="10%">Sat.</th>
                          <th width="10%">Qty</th>
                          <th width="15%">Harga</th>
                          <th width="15%">Total</th>
                          <th width="10%">Aksi</th>
                      </tr>
                  </tfoot>
                </table>
            </div>
            <div class="col-md-2">
                <div style="margin-top: 8px"></div>
                <button onclick="simpanPenawaran()" class="btn btn-sm btn-primary form-control"><i class="fa fa-save"></i> Simpan</button>
                <div style="margin-top: 3px"></div>
                <button onclick="batalPenawaran()" class="btn btn-sm btn-warning form-control"><i class="fa fa-remove"></i> Batal</button>
                
            </div>
            <div class="col-md-12">
                <a href="{{ url('quotation') }}"><button class="btn btn-sm btn-info"><i class="fa fa-arrow-left"></i> Kembali</button></a>
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
                          <label for="description" class="control-label">Description :</label>
                          <input type="text" id="description_edit" name="description_edit" class="form-control" required>
                          <span class="help-block with-errors"></span>
                      </div>

                      <div class="form-group">
                          <label for="quantity" class="control-label">Jumlah :</label>
                          <input type="number" id="quantity_edit" name="quantity_edit" class="form-control" required>
                          <span class="help-block with-errors"></span>
                          
                      </div>

                      <div class="form-group">
                          <label for="uom_edit" class="control-label">Satuan :</label>
                          <input type="text" id="uom_edit" name="uom_edit" class="form-control" required>
                          <span class="help-block with-errors"></span>
                          
                      </div>


                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label for="price_edit" class="control-label">Harga :</label>
                                <input type="number" id="price_edit" name="price_edit" class="form-control" required>
                                <span class="help-block with-errors"></span>
                              </div>  
                          </div>
                      </div>
                      

                      <div class="form-group">
                          <label for="total_edit" class="control-label">Total :</label>
                          <input type="number" id="total_edit" name="total_edit" class="form-control" readonly>
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


          $('#customer_id').select2({
            theme: "bootstrap"
          });

          $('#barang').select2({
            theme: "bootstrap"
          });

          $('#item_modal').select2({
            theme: "bootstrap"
          });

          

          // #hitung total 
          hitungTotal();
      
          // #tabel quotation
          var table = $('#item-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('quote.item') }}",
              order: [[ 0, "desc" ]],
              columns: 
              [
                {data:'id', name: 'id'},
                {data:'description', name: 'description', orderable:false, searchable:false},
                {data:'uom', name: 'uom', orderable:false, searchable:false},
                {data:'quantity', name: 'quantity', orderable:false, searchable:false},
                {data:'price', name: 'price', orderable:false, searchable:false},
                {data:'total', name: 'total', orderable:false, searchable:false},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });

          
          
          // #tambah item
          function addItem(){
            $('#ruang_tambah').show();
            $('#description').val("");
            $('#jumlah').val("");
            $('#harga').val("");
            $('#satuan').val("");
            $('#total').val("");
          }



          // #simpan tambah data
          $('#tambahData').click(function(){
            
              var description = $('#description').val();
              var jumlah = $('#jumlah').val();
              var satuan = $('#satuan').val();
              var harga = $('#harga').val();
              var total = $('#total').val();
              var csrf_token = $('meta[name="csrf-token"]').attr('content');

              if(description ==''){alert('Description Tidak Boleh Kosong...'); }
              else if(jumlah ==''){alert('Jumlah Barang Tidak Valid...');}
              else {

                $.ajax({
                    url: "{{ url('simpan_quote_item') }}",
                    type : "POST", 
                    dataType : "JSON", 
                    data : {description:description, quantity:jumlah, uom:satuan, price:harga, total:total, _token:csrf_token},
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




          // #kontrol form
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

          $('#harga').keyup(function(){
              var harga = $(this).val();
              var jumlah = $('#jumlah').val();

              total = jumlah * harga;
              $('#total').val(total);
          });



          // #kontrol form EDIT
          $('#quantity_edit').keyup(function(e){
              var jumlah = $(this).val();
              var harga = $('#price_edit').val();

              total = jumlah * harga;
              $('#total_edit').val(total);
          });


          $('#quantity_edit').change(function(e){
              var jumlah = $(this).val();
              var harga = $('#price_edit').val();

              total = jumlah * harga;
              $('#total_edit').val(total);
          });


          $('#price_edit').change(function(){
              var harga = $(this).val();
              var jumlah = $('#quantity_edit').val();

              total = jumlah * harga;
              $('#total_edit').val(total);
          });

          $('#price_edit').keyup(function(){
              var harga = $(this).val();
              var jumlah = $('#quantity_edit').val();

              total = jumlah * harga;
              $('#total_edit').val(total);
          });






          // #hapus item  
          function deleteData(id) {
              
              var popup = confirm('Anda Yakin Ingin Menghapus Data...?');
              var csrf_token = $('meta[name="csrf-token"]').attr('content');
              
              if(popup == true){
                  $.ajax({
                      url  : "{{ url('item_quote_hapus') }}",
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




          // #edit item
          function editData(id){

              $.ajax({
                  url : "{{url('edit_quote_item')}}"+"/"+id,
                  type : "GET",
                  dataType : "JSON",
                  success : function(data){
                      // console.log(data);
                      $('#id_edit').val(data.id);
                      $('#description_edit').val(data.description);
                      $('#quantity_edit').val(data.quantity);
                      $('#uom_edit').val(data.uom);
                      $('#price_edit').val(data.price);
                      $('#total_edit').val(data.total);

                      $('#modal-edit').modal("show");
                      $('.modal-edit-title').html("Edit Data Quotation Item");
                  },
                  error : function(){
                      alert("Something Error...");
                  }
              });
              
          }




          // #submit form edit
          $('#modal-edit form').submit(function(e){
              e.preventDefault();

              $.ajax({
                  url : "{{ url('update_quote_item') }}",
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




          // #simpan data quotation
          function simpanPenawaran(){

              var popup = confirm('Anda Yakin Ingin Menyimpan Data...?');
              
              if(popup==true){
                  var nota = $('#quote_nota').val();
                  var customer = $('#customer_id').val();
                  var attn = $('#attn').val();
                  var dari = $('#dari').val();
                  var tanggal = $('#tanggal').val();
                  var email = $('#email').val();
                  var fax = $('#fax').val();
                  var ref =$('#ref').val();
                  var ref2 =$('#ref2').val();
                  var csrf_token = $('meta[name="csrf-token"]').attr('content');
                  
                  var strTotal = $('#total_transaksi').text();
                  var xtotal = strTotal.replace('Rp.', '');
                  var ytotal = xtotal.replace('.', '');
                  var total = ytotal.replace('.', '');

                 
                  if(customer=='') alert('Customer Belum Dipilih...!');
                  else if(attn=='') alert('Attn Tidak Boleh Kosong...!');
                  else if(tanggal=='') alert('Tanggal Tidak Boleh Kosong...!');
                  else if(dari =='') alert('Kolom FROM Tidak Boleh Kosong...!');
                  else{
                      $.ajax({
                          url  : "{{ url('update_transaksi_quote') }}",
                          type : "POST",
                          data : {nota:nota, customer:customer, attn:attn, email:email, fax:fax, dari:dari, ref:ref, ref2:ref2, tanggal:tanggal, total:total, _token:csrf_token },
                          success:function(data){
                                alert('Quotation Disimpan...');
                                reloadTable();
                                window.location="{{ url('quotation') }}";
                          },
                          error:function(){
                                alert("Something Error....");
                          }   

                      });
                  }
              }
          }




          // #batal penawaran

          function batalPenawaran(){
              var popup = confirm('Anda Yakin Ingin Membatalkan Transaksi...?');
              if(popup==true){

                  var csrf_token = $('meta[name="csrf-token"]').attr('content');

                  $.ajax({
                      url : "{{ url('batal_quote') }}",
                      type :"POST",
                      data : {'_token':csrf_token},
                      success:function(data){
                          reloadTable();
                          clearForm();
                      },
                      error:function(){
                        alert("Opps Something Error...");
                      }

                  });
              }
          }



          // #bersihkan form
          function clearForm() {
              $('#customer_id').val(null).trigger('change');
              $('#attn').val("");
              $('#dari').val("");
              $('#tanggal').val("");
              $('#email').val("");
              $('#fax').val("");
              $('#ref').val("");
              $('#ref2').val("");
          }




          // #refresh table
          function reloadTable() {
            $("#item-table").DataTable().ajax.reload(null,false);
            hitungTotal();
          }




          // #hitung total
          function hitungTotal(){

            $.ajax({
                url : "{{ url('total_quote') }}",
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




          // # format rupiah
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