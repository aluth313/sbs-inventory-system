@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Penjualan
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="javascript:void(0);">Laporan Penjualan</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
          <div style="background-color: beige;" class="box-header with-border">
              <h4>Pilih Tanggal Laporan</h4>
          </div>
          <div class="box-body">

            <div class="row">
              <div class="col-md-4">              
                  <div class="form-group">
                    <label>Dari Tanggal:</label>

                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="dari" name="sampai">
                    </div>
                    <!-- /.input group -->
                  </div>
              </div>

              <div class="col-md-4">              
                  <div class="form-group">
                    <label>Sampai Tanggal:</label>

                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="sampai" name="sampai">
                    </div>
                    <!-- /.input group -->
                  </div>
              </div>

            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Pilih Pelanggan:</label>
                    <select id="pelanggan" class="form-control">
                        <option value=""> - Pilih Pelanggan - </option>
                        @foreach($customer as $value)
                            <option value="{{$value->id}}">{{$value->customer_name}}</option>
                        @endforeach
                    </select>
                    <p style="color:blue">* Kosongkan Untuk Pilih Semua Pelanggan</p>
                </div>
            </div>
            <div style="margin-top: 6px"></div>
            <div class="row">
              <div class="col-md-12">
                <button onclick="cetakLaporan()" class="btn btn-default" id="btn_cetak"><i class="fa fa-print"></i> Cetak Laporan</button>
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
    
    $('#pelanggan').select2({
          theme: "bootstrap"
    });
    
    function cetakLaporan(){

        var dari = $('#dari').val();
        var sampai = $('#sampai').val();
        var pelanggan = $('#pelanggan').val();
        

        if(dari=='' || sampai ==''){
           alert("Tanggal Tidak Boleh Ada Yang Kosong....");
        }

        $('#btn_cetak').attr("disabled",true);
        $('#loadingProgress').show();
        $.ajax({
            url : "{{ url('sales_report_cetak')}}"+"/"+dari+"/"+sampai+"/"+pelanggan,
            type : "GET",
            success : function(data){
                $('#btn_cetak').removeAttr("disabled");
                $('#loadingProgress').hide();
                window.open("{{ url('sales_report_cetak')}}"+"/"+dari+"/"+sampai+"/"+pelanggan, "Laporan Penjualan", "height=900, width=1000, scrollbars=yes");
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