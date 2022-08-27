@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Hutang ke Supplier
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="javascript:void(0);">Laporan Hutang Supplier</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
          <div style="background-color: beige;" class="box-header with-border">
              <h4>Pilih Supplier</h4>
          </div>
          <div class="box-body">

            <div class="row">
              <div class="col-md-4">              
                  <div class="form-group">
                    <label>Supplier :</label>

                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-truck"></i>
                      </div>
                      <select id="cmb-periode" class="form-control">
                          <option value=""> - Pilih Supplier - </option>
                          @foreach($supplier as $key)
                          <option value="{{$key->id}}">{{$key->supplier_name}}</option>
                          @endforeach
                      </select>
                    </div>
                    <p style="color:red">* Kosongkan Pilihan Untuk Memilih Semua Supplier *</p>
                    <!-- /.input group -->
                  </div>
              </div>

            </div>
            <div class="row">
              
              <div class="col-md-12">
                <button onclick="cetakLaporan()" class="btn btn-default" id="btn_cetak"><i class="fa fa-print"></i> Cetak</button>
              </div>
            </div>
          </div>

      </div>
      
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    
    function cetakLaporan(){

       var periode = $('#cmb-periode').val(); 
       $('#btn_cetak').attr("disabled",true);
       $('#loadingProgress').show();
       $.ajax({
            url : "{{ url('hutang_cetak_sekarang')}}"+"/"+periode,
            type : "GET",
            success : function(data){
              $('#btn_cetak').removeAttr("disabled");
              $('#loadingProgress').hide();
              window.open("{{ url('hutang_cetak_sekarang')}}"+"/"+periode, "Laporan Hutang Supplier", "height=900, width=1000, scrollbars=yes");
            },
            error: function(){
              $('#loadingProgress').hide();
               alert("OPPS Something Error");
            }
      });
      return false; 
    }

  </script>
@endsection