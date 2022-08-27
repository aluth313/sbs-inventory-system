@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan History Stok
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="javascript:void(0);">Laporan History Stok</a></li>
        
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
              <div class="col-md-12">
                  <label>Nama Barang :</label>
                  <select id="id_barang" style="width: 30%" class="form-control">
                      <option value=""> - Pilih Nama Barang - </option>
                          @foreach($good as $key)
                              <option value="{{ $key->id }}">{{ $key->good_name }}</option>
                          @endforeach
                  </select>  
              </div>
              <div style="margin-top: 70px;"></div>
              <div class="col-md-12">
                <button onclick="cetakLaporan()" class="btn btn-default" id="btn_cetak"><i class="fa fa-print"></i> Cetak History Stok</button>
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

        var id_barang = $('#id_barang').val();
        var dari = $('#dari').val();
        var sampai = $("#sampai").val();

        if(id_barang == ''){
             alert("Nama Barang Belum Dipilih.....!");
        }else if(dari==''){
             alert("Tanggal Awal tidak boleh kosong...!");
        }else if(sampai==''){
             alert("Tanggal Akhir tidak boleh kosong...!");
        }else if(sampai < dari ){
             alert("Tanggal Awal Tidak Boleh Lebih Besari Dari Tanggal Akhir....");
        }else{

             $('#btn_cetak').attr("disabled",true);
             $('#loadingProgress').show();
             $.ajax({
                url : "{{ url('hiscetak')}}"+"/"+id_barang+"/"+dari+"/"+sampai,
                type : "GET",
                success : function(data){
                  $('#btn_cetak').removeAttr("disabled");
                  $('#loadingProgress').hide();
                  window.open("{{ url('hiscetak')}}"+"/"+id_barang+"/"+dari+"/"+sampai, "Laporan History Stok", "height=900, width=1000, scrollbars=yes");
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