@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pembayaran Ke Supplier
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('debt') }}">Pembayaran Supplier</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          
          <button onclick="findPurchase()" id="cari_purchase" class="btn btn-info"><i class="fa fa-search"></i> Cari Pembelian</button>
          <div class="box-tools pull-right">
              <h3 id="string_no_pembayaran"></h3>
              <input type="hidden" id="no_pembayaran">
          </div>
        </div>
        <div style="background-color: beige" class="box-header with-border">
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label>No Pembelian :</label>
                <input id="no_beli" name="no_beli" type="text" class="form-control" readonly >
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Supplier :</label>
                <input type="hidden" id="id_supplier" name="id_supplier">
                <input id="nama_supplier" name="nama_supplier" type="text" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Sisa :</label>
                <input id="sisa" name="sisa" type="number" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Jumlah Pembayaran :</label>
                <input id="pembayaran" name="pembayaran" type="number" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">  
                <label>Keterangan :</label>
                <textarea class="form-control pull-right" id="ket"  name="ket"></textarea>
              </div>
            </div>
          </div>

          <div style="margin-top: 10px;" class="row">
            <div class="col-md-12">
              <button onclick="batalPembayaran()" style="margin-left: 5px;" class="btn btn-warning pull-right"><i class="fa fa-remove"></i> Batal</button>
              <button onclick="simpanPembayaran()" class="btn btn-success pull-right"><i class="fa fa-save" id="save_pembayaran" name="simpan_pembayaran"></i> Simpan Pembayaran</button>
            </div>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id="payment-table" class="table table-striped table-bordered table-hover">
              <thead>
                  <tr>
                      <th width="2%">ID</th>
                      <th width="8%">Tanggal</th>
                      <th width="15%">No Bayar</th>
                      <th width="15%">no Beli</th>
                      <th width="20%">Supplier</th>
                      <th width="8%">Jumlah</th>
                      <th width="*">Deskripsi</th>
                      <th width="12%">Aksi</th>
                  </tr>
              </thead>
              <tbody></tbody>
              <tfoot>
                  <tr>
                      <th width="2%">ID</th>
                      <th width="8%">Tanggal</th>
                      <th width="15%">No Bayar</th>
                      <th width="15%">no Beli</th>
                      <th width="20%">Supplier</th>
                      <th width="8%">Jumlah</th>
                      <th width="*">Deskripsi</th>
                      <th width="12%">Aksi</th>
                  </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>

      <div class="modal" id="modal-debt" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"> &times; </span>
                  </button>
                  <h3 class="modal-title">Pembelian Belum Dibayar</h3>
              </div>
              <div class="modal-body">
                <table style="width: 100%" id="list-table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th width="2%">No</th>
                      <th width="10%">Tanggal</th>
                      <th width="15%">No Beli</th>
                      <th width="*">Supplier</th>
                      <th width="10%">Jumlah</th>
                      <th width="10%">Dibayar</th>
                      <th width="10%">Sisa</th>
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody></tbody>
              </table>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
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
      
          var table = $('#payment-table').DataTable({
              processing:true,
              serverSide:true,
              order: [[ 0, "desc" ]],
              ajax: "{{ route('api.debt') }}",
              columns: [
                {data:'id', name: 'id'},
                {data:'created_at', name: 'created_at'},
                {data:'payment_no', name: 'payment_no'},
                {data:'id_purchase', name: 'id_purchase'},
                {data:'nama_supplier', name: 'nama_supplier'},
                {data:'nilai_pembayaran', name: 'nilai_pembayaran'},
                {data:'description', name: 'description', orderable:false, searchable:false},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });


          var list = $('#list-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.list_purchase') }}",
              columns: [
                {data:'id', name: 'id'},
                {data:'created_at', name: 'created_at'},
                {data:'invoice', name: 'invoice'},
                {data:'supplier_name', name: 'supplier_name'},
                {data:'total', name: 'total'},
                {data:'pembayaran', name: 'pembayaran'},
                {data:'sisa', name: 'sisa'},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });


          function findPurchase(){
              $('#modal-debt').modal("show");
          }

          function clearForm(){
              $('#cari_purchase').removeAttr("disabled");
              $('#no_pembayaran').val("");
              $('#string_no_pembayaran').html("");
              $('#no_beli').val("");
              $('#id_supplier').val("");
              $('#nama_supplier').val("");
              $('#pembayaran').val("");
              $('#sisa').val("");
              $('#ket').val("");
          }

          function chooseDebt(id){
              $.ajax({
                  url : "{{ url('pilih_hutang') }}"+"/"+id,
                  type : "GET",
                  dataType : "JSON",
                  success : function(data){
                    // console.log(data);
                    $('#no_beli').val(data[0].invoice);
                    $('#id_supplier').val(data[0].supplier_id);
                    $('#nama_supplier').val(data[0].supplier_name);
                    $('#sisa').val(data[0].sisa);
                    
                    $('#simpan_pembayaran').show();
                    $('#update_pembayaran').hide();
                    $('#modal-debt').modal("hide");

                  },
                  error : function(){
                    alert("Something Error");
                  }
              });
          }


          function simpanPembayaran(){
             var id = $('#no_pembayaran').val();
             if(id==''){
                savePembayaran();
             }else{
                updatePembayaran();
             }
          }


          function savePembayaran(){

              var pembayaran = $('#pembayaran').val();
              var nobeli = $('#no_beli').val();
              var sisa = $('#sisa').val();
              var idsupplier = $('#id_supplier').val();
              var namasupplier = $('#nama_supplier').val();
              var ket = $('#ket').val();
              var _token = $('meta[name="csrf-token"]').attr('content');

              if(pembayaran == ''){
                  alert("Jumlah Pembayaran Belum Diisi....");
              }
              else if(pembayaran <= 0 ){
                  alert("Pembayaran Tidak Boleh Lebih Kecil Atau Sama Dengan Nol..");
              }
              
              else if(nobeli ==''){
                  alert("Belum Ada Data Hutang Dipilih...!");
              }
              else{
                  $.ajax({
                      url : "{{ url('simpan_pembayaran') }}",
                      type : "POST",
                      data : {nobeli:nobeli, idsupplier:idsupplier, namasupplier:namasupplier, pembayaran:pembayaran, sisa:sisa, ket:ket, _token:_token},
                      success : function(data){
                          reloadTable();
                          clearForm();
                          alert("Simpan Pembayaran Sukses..");
                      },  
                      error : function(){
                          alert("Something Error...");
                      }
                  });
              }
          }


          function updatePembayaran(){

              var nopembayaran = $('#no_pembayaran').val();
              var pembayaran = $('#pembayaran').val();
              var nobeli = $('#no_beli').val();
              var sisa = $('#sisa').val();
              var idsupplier = $('#id_supplier').val();
              var namasupplier = $('#nama_supplier').val();
              var ket = $('#ket').val();
              var _token = $('meta[name="csrf-token"]').attr('content');

              if(pembayaran == ''){
                  alert("Jumlah Pembayaran Belum Diisi....");
              }
              else if(pembayaran <= 0 ){
                  alert("Pembayaran Tidak Boleh Lebih Kecil Atau Sama Dengan Nol..");
              }
              
              else if(nobeli ==''){
                  alert("Belum Ada Data Hutang Dipilih...!");
              }
              else{
                  $.ajax({
                      url : "{{ url('update_pembayaran') }}",
                      type : "POST",
                      data : {id_bayar:nopembayaran, nobeli:nobeli, idsupplier:idsupplier, namasupplier:namasupplier, pembayaran:pembayaran, sisa:sisa, ket:ket, _token:_token},
                      success : function(data){
                          reloadTable();
                          clearForm();
                          alert("Update Pembayaran Sukses..");
                      },  
                      error : function(){
                          alert("Something Error...");
                      }
                  });
              }
          }


          function batalPembayaran(){
             clearForm();
          }


          function editData(id){
              $.ajax({
                  url : "{{url('get_data_payment')}}"+"/"+id,
                  type :"GET",
                  dataType : "JSON",
                  success :function(data){
                      $('#no_beli').val(data[0].id_purchase);
                      $('#id_supplier').val(data[0].id_supplier);
                      $('#nama_supplier').val(data[0].nama_supplier);
                      $('#pembayaran').val(data[0].nilai_pembayaran);
                      var sisa  = parseInt(data[0].sisa);
                      var pembayaran = parseInt(data[0].nilai_pembayaran);
                      var sisa_sekarang = sisa + pembayaran;
                      $('#sisa').val(sisa_sekarang);
                      $('#ket').val(data[0].description);
                      $('#string_no_pembayaran').html(data[0].payment_no);
                      $('#no_pembayaran').val(data[0].payment_no);
                      $('#cari_purchase').attr("disabled", "disabled");
                  },
                  error : function(){
                      alert("Something Error...");
                  }
              });
          }

          function deleteData(id){
             var indra = confirm("Apakah Anda Ingin Menghapus Data Pembayaran Ini....?");
             if(indra ==true) {
                confirmDeleteData(id);
             }
          }

          function confirmDeleteData(id){
              var _token = $('meta[name="csrf-token"]').attr('content');
              $.ajax({
                  url : "{{ url('hapus_pembayaran') }}",
                  type : "POST",
                  data : {id:id, _token:_token},
                  success: function(data){
                      reloadTable();
                      clearForm();
                      alert("Sukses Hapus Pembayaran...");
                  },
                  error: function(){
                     alert("Something Error...");
                  }
              })
          }



          $('#payment-table').on('click', '#printData', function(){
              
              var id = $(this).attr("data-id");
              var invoice = $(this).attr("data-invoice");

              $('#loadingProgress').show();
              $.ajax({
                  url     : "{{ url('cetak_pembayaran')}}"+"/"+id+"/"+invoice,
                  type    : "GET",
                  success : function(data){
                    $('#loadingProgress').hide();
                    window.open("{{ url('cetak_pembayaran')}}"+"/"+id+"/"+invoice, "Nota Pembayaran ", "height=900, width=1000, scrollbars=yes");
                      reloadTable();
                  },
                  error: function(){
                    $('#loadingProgress').hide();
                     alert("OPPS Something Error");
                  }
              });
          });



          function reloadTable() {
            $("#payment-table").DataTable().ajax.reload(null,false);
            $("#list-table").DataTable().ajax.reload(null,false);
          }

$(document).ready(function(){



});
      
      
</script>

@endsection