@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Laba Rugi
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="javascript:void(0);">Laporan Laba Rugi</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
          <div style="background-color: beige;" class="box-header with-border">
              <h4>Pilih Periode Laporan</h4>
          </div>
          <div class="box-body">

            <div class="row">
              <div class="col-md-4">              
                  <div class="form-group">
                    <label>Untuk Transaksi Dalam Bulan :</label>

                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <select class="form-control" id="periode" name="periode">
                        <option value=""> - Pilih Periode - </option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                      </select>
                    </div>
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

        var periode = $('#periode').val();
        if(periode==''){
           alert("Periode Tidak Boleh Kosong....");
        }
        else
        {
            $('#btn_cetak').attr("disabled",true);
            $('#loadingProgress').show();
            $.ajax({
                url : "{{ url('ploss_cetak')}}"+"/"+periode,
                type : "GET",
                success : function(data){
                    $('#btn_cetak').removeAttr("disabled");
                    $('#loadingProgress').hide();
                    window.open("{{ url('ploss_cetak')}}"+"/"+periode, "Laporan Laba Rugi", "height=900, width=1000, scrollbars=yes");
                },
                error: function(){
                    $('#loadingProgress').hide();
                    alert("OPPS Something Error");
                }
            });
            return false; 
        }
    }



  </script>
@endsection