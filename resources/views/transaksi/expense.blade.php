@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Proses Pengeluaran
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('expense') }}">Proses Pengeluaran</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          
          <button onclick="addForm()" id="tambah_service" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Tambah Service</button>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
          <table id="expense-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th width="2%">ID</th>
                    <th width="10%">Tanggal</th>
                    <th width="10%">TglExp</th>
                    <th width="15%">Kategori</th>
                    <th width="*">Deskripsi</th>
                    <th width="15%">Nilai</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
                <tr>
                    <th width="2%">ID</th>
                    <th width="10%">Tanggal</th>
                    <th width="10%">TglExp</th>
                    <th width="15%">Kategori</th>
                    <th width="*">Deskripsi</th>
                    <th width="15%">Nilai</th>
                    <th width="15%">Aksi</th>
                </tr>
            </tfoot>
          </table>
        </div>
        </div>
      
      </div>


      <div class="modal" id="modal-expense" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form id="form-expense" method="post" class="form-horizontal" data-toggle="validator">
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
                          <label for="cost_date" class="col-md-3 control-label">Tanggal Pengeluaran :</label>
                          <div class="col-md-8">
                              <input type="date" id="cost_date" name="cost_date" class="form-control" required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="cost_id" class="col-md-3 control-label">Kategori :</label>
                          <div class="col-md-8">
                              <select id="cost_id" name="cost_id" class="form-control" required>
                                  <option value=""> -- Pilih Kategori -- </option>
                                  @foreach($data as $row)
                                      <option value="{{ $row->id }}">{{ $row->cost_name }}</option>
                                  @endforeach
                              </select>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="description" class="col-md-3 control-label">Deskripsi :</label>
                        <div class="col-md-8">
                            <textarea style="height: 80px;" id="description" name="description" class="form-control" required></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="cost_value" class="col-md-3 control-label">Jumlah Pengeluaran (Rp.) :</label>
                        <div class="col-md-8">
                            <input type="number" id="cost_value" name="cost_value" class="form-control" required>
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
      
          var table = $('#expense-table').DataTable({
              processing:true,
              serverSide:true,
              ajax: "{{ route('api.expense') }}",
              columns: [
                {data:'id', name: 'id'},
                {data:'created_at', name: 'created_at'},
                {data:'cost_date', name: 'cost_date'},
                {data:'cost_id', name: 'cost_id'},
                {data:'description', name: 'description'},
                {data:'cost_value', name: 'cost_value'},
                {data:'action', name: 'action', orderable:false, searchable:false}
              ]
          });


          function addForm(){
              save_method = "add";
              $('input[name=_method]').val('POST');
              $('#modal-expense').modal('show');
              $('#modal-expense form')[0].reset();
              $('.modal-title').text('Tambah Proses Pengeluaran');
          }


          function editForm(id){
              save_method = 'edit';
              $('input[name=_method]').val('PATCH');
              $('#modal-expense form')[0].reset();
              $.ajax({
                  url: "{{ url('expense') }}" + '/'+id+'/edit',
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){
                      $('#modal-expense').modal("show");
                      $('.modal-title').text("Edit Data Pengeluaran");

                      $('#id').val(data.id);
                      $('#cost_date').val(data.cost_date);
                      $('#cost_id').val(data.cost_id);
                      $('#description').val(data.description);
                      $('#cost_value').val(data.cost_value);                     
                },

                error: function(){
                  alert("Nothing Data....");
                }

              });
          }


          $(function(){
              $('#modal-expense form').validator().on('submit', function(e){
                  if(!e.isDefaultPrevented()){
                      var id = $('#id').val();
                      if(save_method =='add')  url = "{{ url('expense') }}";
                      else url = "{{ url('expense') .'/'}}"+ id;
                      $.ajax({
                          url : url,
                          type : "POST",
                          data : $('#modal-expense form').serialize(),
                          success : function(data){
                           
                            $('#modal-expense').modal('hide');
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
                    url  : "{{ url('expense') }}" + '/'+id,
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