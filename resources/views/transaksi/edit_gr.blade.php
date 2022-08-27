@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Penerimaan Barang
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('gr') }}">Proses Penerimaan Barang</a></li>
        <li><a href="{{ url('editgr') }}">Edit Penerimaan Barang</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
    <form id="frmgr" action="{{ url('savedatagr') }}" method="POST">
         {{ csrf_field() }} 
      <div class="box">
        <div class="box-header with-border" style="background-color: whitesmoke">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <lable>No GR:</lable>
                    <input type="text" class="form-control" id="grno" name="grno" value="{{ $grdata->gr_no }}" readonly>
                </div>
                <div class="form-group">
                    <lable>Deskripsi:</lable>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" required>{{ $grdata->description }}</textarea>
                </div>
                
                <div class="from-group">
                    <lable>Gudang:</lable>
                    <select id="gudang" name="gudang" class="form-control" required>
                        <option value=""> - Pilih Gudang - </option>
                        <option <?php if($grdata->gudang == 1) echo 'selected';?> value="1">GUDANG SBS</option>
                        <option <?php if($grdata->gudang == 2) echo 'selected';?> value="2">GUDANG MDI</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <button onclick="lihatpurchaseorder()" style="margin-top:20px;" class="btn btn-success btn-sm"><i class="fa fa-list"></i> List Purchase Order</button>
            </div>
        </div>
        </div>
    
        <div class="box-body">
          <div class="table-responsive">
            <div class="col-md-12">
                <input type="text" class="form-control" id="ponumber" name="ponumber" placeholder="No Purchase Order" value="{{ $grdata->po_no }}" readonly>
                <input type="hidden" id="supplierid" name="supplierid" value="{{ $grdata->supplier_id }}" >
                <table style="margin-top:10px;" id="item-gr-table" class="table table-bordered table-hover">
                  <thead>
                      <tr>
                          <th width="2%">ID</th>
                          <th width="5%">ItemCD</th>
                          <th width="*">ItemName</th>
                          <th width="10%">Sat.</th>
                          <th style="text-align:right;" width="15%">Harga</th>
                          <th style="text-align:right;" width="10%">Qty</th>
                          <th style="text-align:right;" width="15%">Total</th>
                          <th width="10%">Aksi</th>
                      </tr>
                  </thead>
                  <tbody id="isitablelistpo">
                    <?php
                    foreach($gritem as $key) {
                        
                        echo  '<tr id="tr_'.$key->ids.'">';
                        echo  '<td>'.$key->ids.'<input value="'.$key->ids.'" type ="hidden" id="id_'.$key->ids.'" name="id[]"></td>';
                        echo  '<td>'.$key->item_cd.'<input value="'.$key->item_cd.'" type ="hidden" id="itemcd_'.$key->ids.'" name="itemcd[]"></td>';
                        echo  '<td>'.$key->material_name.'<input value="'.$key->material_name.'" type="hidden" id="materialname_'.$key->ids.'" name="materialname[]"></td>';
                        echo  '<td>'.$key->item_unit.'<input value="'.$key->item_unit.'" type="hidden" id="itemunit_'.$key->ids.'" name="itemunit[]"></td>';
                        echo  '<td style="text-align:right;"><span id="pricetext_'.$key->ids.'">'.number_format($key->item_price,2).'</span><input value="'.$key->item_price.'" type="hidden" id="price_'.$key->ids.'" name="price[]"></td>';
                        echo  '<td style="text-align:right;"><span id="quantitytext_'.$key->ids.'">'.number_format($key->quantity, 2).'</span><input value="'.$key->quantity.'" type="hidden" id="quantity_'.$key->ids.'" name="quantity[]"><span style="display:none;" id="frame_'.$key->ids.'"><input value="'.$key->quantity.'" type="text" id="qtyinput_'.$key->ids.'"><a onclick="cek('.$key->ids.')" href="javascript:void(0);"><i class="fa fa-check-circle"></i></a></span></td>';
                        echo  '<td style="text-align:right;"><span id="itemtotaltext_'.$key->ids.'">'.number_format($key->item_total, 2).'</span><input value="'.$key->item_total.'" type="hidden" id="itemtotal_'.$key->ids.'" name="itemtotal[]"></td>';
                        echo  '<td><center><a title="Edit Item" style="width:30px;" onclick="edititem('.$key->ids.')" href="javascript:void(0);" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a><a title="Hapus Item" style="margin-left:10px;width:30px;" onclick="deleteitem('.$key->ids.')" href="javascript:void(0);" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></center></td>';
                        echo  '</tr>';  
                    
                    } ?>
                    
                  </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <div style="margin-top: 8px"></div>
                <button type="submit" class="btn btn-sm btn-primary "><i class="fa fa-save"></i> Simpan</button>
                <a href="{{ url('gr') }}"><button type="button" class="btn btn-sm btn-warning "><i class="fa fa-remove"></i> Batal</button></a>
            </div>
           </form>
        </div>
        </div>
      
      </div>
     
     <div class="modal" id="modal-purchase-order" tabindex="1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"> &times; </span>
                  </button>
                  <h3 class="modal-title">List Purchase Order</h3>
              </div>
              <div class="modal-body">
                  <table style="width:100%" id="table-list-po" class="table table-stripped table-bordered">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Tanggal</th>
                              <th>No PO</th>
                              <th>Supplier</th>
                              <th>Total Nilai</th>
                              <th>Aksi</th>
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
      
      

      <div class="modal fade" id="modal-purchase" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
          
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"> &times; </span>
                  </button>
                  <h3 class="modal-title"></h3>
              </div>

              <div class="modal-footer">
                  <button type="submit" id="btn_edit" class="btn btn-warning">Update</button>
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



<script>
    
    var table = $('#table-list-po').DataTable({
          processing:true,
          serverSide:true,
          ajax: "{{ route('api.listpo') }}",
          order: [[ 0, "desc" ]],
          columns: [
            {data:'DT_RowIndex', name: 'id'},
            {data:'created_at', name: 'created_at'},
            {data:'invoice', name: 'invoice'},
            {data:'supplier_name', name: 'supplier_name'},
            {data:'total', name: 'total'},
            {data:'action', name: 'action', orderable:false, searchable:false}
          ]
    });
          
          
    function lihatpurchaseorder(){
        reloadTable();
        $("#modal-purchase-order").modal("show");
    }
    
    
    table.on('click', '#pilihpurchaseorder', function(){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var invoice = $(this).attr('data-invoice');
        var idsupplier = $(this).attr('data-supplier');
        $.ajax({
            url : "{{ url('pilihpurchaseorder') }}",
            type : "POST",
          
            data : {invoice:invoice, '_token':csrf_token},
            success : function(data) {
                console.log('pilih', data);
                $("#isitablelistpo").html(data);
                $("#ponumber").val(invoice);
                $("#modal-purchase-order").modal("hide");
                $("#supplierid").val(idsupplier);
                
            }
        })
    })
    
    
    function deleteitem(id) {
        var hapus = confirm('Hapus Item....?');
        if(hapus === true) {
            $("#tr_"+id).remove();
        }
    }
    
    
    function edititem(id) {
        $("#frame_"+id).show();
        $("#quantitytext_"+id).hide();
    }
    
    
    function cek(id) {
        var quantity = $("#qtyinput_"+id).val();
        var price = $("#price_"+id).val();
        var totalharga = quantity * price;
        totalharga = totalharga.toString();
        $("#quantitytext_"+id).text(formatRupiah(quantity, ''));
        $("#quantity_"+id).val(quantity);
        $("#frame_"+id).hide();
        $("#quantitytext_"+id).show();
        $("#qtyinput_"+id).val(quantity);
        $("#itemtotal_"+id).val(totalharga);
        $("#itemtotaltext_"+id).text(formatRupiah(totalharga, ''));
    }
    
    $("#frmgr").submit(function(e){
        e.preventDefault();
        
        $.ajax({
            url : "{{ url('updategr') }}",
            type : "POST",
            dataType : "JSON",
            data : $("#frmgr").serialize(),
            success : function(data) {
                console.log('updategr', data);
                window.location = "{{ url('gr') }}";
            }
        })
    })
         

    function formatRupiah(angka, prefix){
         
          var number_string = angka.replace(/[^,\d]/g, '').toString(),
          split       = number_string.split(','),
          sisa        = split[0].length % 3,
          rupiah        = split[0].substr(0, sisa),
          ribuan        = split[0].substr(sisa).match(/\d{3}/gi);
     
          // tambahkan titik jika yang di input sudah menjadi angka ribuan
          if(ribuan){
            separator = sisa ? ',' : '';
            rupiah += separator + ribuan.join(',');
          }
     
          rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
          return prefix == undefined ? rupiah+'.00' : (rupiah ? '' + rupiah+'.00' : '');
    }
    
    
   
    
    function reloadTable() {
       $("#table-list-po").DataTable().ajax.reload(null,false);
    }

      
      
</script>

@endsection