@extends('master')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Stok Bahan Baku / Material
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="javascript:void(0);">Laporan Stok Bahan Baku / Material</a></li>
        
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
                  <label>Kategori</label>
                  <select id="kategori" class="form-control">
                    <option value=""> - Pilih Kategori - </option>
                    @foreach($kategori as $key)
                      <option value="{{$key->id}}">{{$key->category_name}}</option>
                    @endforeach
                  </select>
                  <p style="font-size: 12px;color: blue">* Kosongkan Untuk Memilih Semua Kategori</p>
                </div>
              </div>
              <div class="col-md-12">
                <button onclick="cetakLaporan()" class="btn btn-default" id="btn_cetak"><i class="fa fa-print"></i> Cetak Stok Bahan Baku</button>
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

          var kategori = $('#kategori').val();
        
         $('#btn_cetak').attr("disabled",true);
         $('#loadingProgress').show();
         $.ajax({
            url : "{{ url('stokcetakbaku')}}"+"/"+kategori,
            type : "GET",
            success : function(data){
              $('#btn_cetak').removeAttr("disabled");
              $('#loadingProgress').hide();
              window.open("{{ url('stokcetakbaku')}}"+"/"+kategori, "Laporan Stok Bahan Baku", "height=900, width=1000, scrollbars=yes");
            }

        });
        return false;
    }



  </script>
@endsection