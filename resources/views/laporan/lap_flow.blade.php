@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Arus Kas
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="javascript:void(0);">Laporan Arus Kas</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
          <div style="background-color: beige;" class="box-header with-border">
              <h4>Klik Tombol Untuk Mencetak Laporan</h4>
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
              <div style="display: none" class="col-md-4">
                  <label>No Document :</label>
                  <input type="text" class="form-control" id="document" placeholder="No Document">  
              </div>
              <!-- <div style="margin-top: 100px;"></div> -->
              <div class="col-md-12">
                <button onclick="cetakLaporan()" class="btn btn-default" id="btn_cetak"><i class="fa fa-print"></i> Cetak Laporan Arus Kas</button>
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

        var dokumen = $('#document').val();
        var dari = $('#dari').val();
        var sampai = $("#sampai").val();

        
        if(dari==''){
             alert("Tanggal Awal tidak boleh kosong...!");
        }else if(sampai==''){
             alert("Tanggal Akhir tidak boleh kosong...!");
        }else if(sampai < dari ){
             alert("Tanggal Awal Tidak Boleh Lebih Besari Dari Tanggal Akhir....");
        }else{

             $('#btn_cetak').attr("disabled",true);
             $('#loadingProgress').show();
             $.ajax({
                url : "{{ url('print_flow')}}"+"/"+dari+"/"+sampai+"/"+dokumen,
                type : "GET",
                success : function(data){
                  $('#btn_cetak').removeAttr("disabled");
                  $('#loadingProgress').hide();
                  window.open("{{ url('print_flow')}}"+"/"+dari+"/"+sampai+"/"+dokumen, "Laporan Arus Kas", "height=900, width=1000, scrollbars=yes");
                },
                error: function(){
                  $('#loadingProgress').hide();
                   alert("OPPS Something Error");
                }

            });
            return false; 
        }
        // console.log(id_barang);
  
         
    }

  </script>
@endsection