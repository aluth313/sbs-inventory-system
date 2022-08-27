@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Pengeluaran
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="javascript:void(0);">Laporan Pengeluaran</a></li>
        
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
                    <label>Sampat Tanggal:</label>

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

        var dari = $('#dari').val();
        var sampai = $('#sampai').val();

        if(dari=='' || sampai ==''){
           alert("Tanggal Tidak Boleh Ada Yang Kosong....");
        }
        else
        {
           $('#btn_cetak').attr("disabled",true);
           $('#loadingProgress').show();
           $.ajax({
              url : "{{ url('expcetak')}}"+"/"+dari+"/"+sampai,
              type : "GET",
              success : function(data){
                $('#btn_cetak').removeAttr("disabled");
                $('#loadingProgress').hide();
                window.open("{{ url('expcetak')}}"+"/"+dari+"/"+sampai, "Laporan Pengeluaran", "height=900, width=1000, scrollbars=yes");
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