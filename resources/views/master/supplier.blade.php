@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Supplier
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('supplier') }}">Supplier</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          @if(in_array(Auth::user()->level, ['ADMIN']))
          <button onclick="addForm()" id="tambah_supplier" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Tambah Supplier</button>
          @endif
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
          <table id="supplier-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <tr>
                    <th width="2%">ID</th>
                    <th width="15%">Nama Supplier</th>
                    <th width="10%">Kontak</th>
                    <th width="*">Alamat</th>
                    <th width="10%">Kota</th>
                    <th width="10%">Telp</th>
                    <th width="10%">Email</th>
                    <th width="10%">Fax</th>
                    <th width="5%">Aksi</th>
                </tr>
                </tr>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
                <tr>
                    <th width="2%">ID</th>
                    <th width="15%">Nama Supplier</th>
                    <th width="10%">Kontak</th>
                    <th width="*">Alamat</th>
                    <th width="10%">Kota</th>
                    <th width="10%">Telp</th>
                    <th width="10%">Email</th>
                    <th width="10%">Fax</th>
                    <th width="5%">Aksi</th>
                </tr>
            </tfoot>
          </table>
        </div>
        </div>
      
      </div>


      <div class="modal fade" id="modal-supplier" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form id="form-supplier" method="post" class="form-horizontal" data-toggle="validator">
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
                          <label for="supplier_name" class="col-md-3 control-label">Nama Supplier  :</label>
                          <div class="col-md-8">
                              <input type="text" id="supplier_name" name="supplier_name" class="form-control" autofocus required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="supplier_contack" class="col-md-3 control-label">Kontak Person  :</label>
                          <div class="col-md-8">
                              <input type="text" id="supplier_contact" name="supplier_contact" class="form-control" autofocus>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="supplier_address" class="col-md-3 control-label">Alamat  :</label>
                          <div class="col-md-8">
                              <textarea style="height: 70px;" id="supplier_address" name="supplier_address" class="form-control" required></textarea>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="supplier_city" class="col-md-3 control-label">Kota  :</label>
                          <div class="col-md-8">
                              <input type="text" id="supplier_city" name="supplier_city" class="form-control" autofocus>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="supplier_phone" class="col-md-3 control-label">No Telepon  :</label>
                          <div class="col-md-8">
                              <input type="number" id="supplier_phone" name="supplier_phone" class="form-control" required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="supplier_email" class="col-md-3 control-label">Email  :</label>
                          <div class="col-md-8">
                              <input type="email" id="supplier_email" name="supplier_email" class="form-control" autofocus>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label for="supplier_fax" class="col-md-3 control-label">Fax  :</label>
                          <div class="col-md-8">
                              <input type="text" id="supplier_fax" name="supplier_fax" class="form-control" autofocus>
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
      
          var table = $('#supplier-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.supplier') }}",
              columns: [
                {data:'id', name: 'id'},
                {data:'supplier_name', name: 'supplier_name'},
                {data:'supplier_contact', name: 'supplier_contact'},
                {data:'supplier_address', name: 'supplier_address'},
                {data:'supplier_city', name: 'supplier_city'},
                {data:'supplier_phone', name: 'supplier_phone'},
                {data:'supplier_email', name: 'supplier_email'},
                {data:'supplier_fax', name: 'supplier_fax'},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });


          function addForm(){
              save_method = "add";
              $('input[name=_method]').val('POST');
              $('#modal-supplier').modal('show');
              $('#modal-supplier form')[0].reset();
              $('.modal-title').text('Tambah Data Supplier');
          }


          function editForm(id){
              save_method = 'edit';
              $('input[name=_method]').val('PATCH');
              $('#modal-supplier form')[0].reset();
              $.ajax({
                  url: "{{ url('supplier') }}" + '/'+id+'/edit',
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){
                      $('#modal-supplier').modal("show");
                      $('.modal-title').text("Edit Data Supplier");

                      $('#id').val(data.id);
                      $('#supplier_name').val(data.supplier_name);
                      $('#supplier_address').val(data.supplier_address);
                      $('#supplier_phone').val(data.supplier_phone);
                      $('#supplier_contact').val(data.supplier_contact);
                      $('#supplier_city').val(data.supplier_city);
                      $('#supplier_email').val(data.supplier_email);
                      $('#supplier_fax').val(data.supplier_fax);
                                         
                },

                error: function(){
                  alert("Nothing Data....");
                }

              });
          }




          $(function(){
              $('#modal-supplier form').validator().on('submit', function(e){
                  if(!e.isDefaultPrevented()){
                      var id = $('#id').val();
                      if(save_method =='add')  url = "{{ url('supplier') }}";
                      else url = "{{ url('supplier') .'/'}}"+ id;
                      $.ajax({
                          url : url,
                          type : "POST",
                          data : $('#modal-supplier form').serialize(),
                          success : function(data){
                           
                            $('#modal-supplier').modal('hide');
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


          function deleteData(id){
            var popup = confirm('Anda Yakin Ingin Menghapus Data...?');
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            if(popup == true){
                $.ajax({
                    url  : "{{ url('supplier') }}" + '/'+id,
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
  
</script>

@endsection