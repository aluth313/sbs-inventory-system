<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SBS Inventory System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('') }}adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  
  <link href="{{ asset('') }}adminlte/dataTables/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('') }}adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('') }}adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('') }}adminlte/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('') }}adminlte/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('') }}adminlte/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('') }}adminlte/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('') }}adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('') }}adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('') }}adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="{{ asset('') }}css/custom.css">
  

  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />

  <!-- jQuery 3 -->
  <script src="{{ asset('') }}adminlte/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('') }}adminlte/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

  <!-- Bootstrap 3.3.7 -->
  <script src="{{ asset('') }}adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- Morris.js charts -->
  <script src="{{ asset('') }}adminlte/bower_components/raphael/raphael.min.js"></script>
  <!-- ChartJS -->
  <script src="{{ asset('') }}adminlte/bower_components/chart.js/Chart.js"></script>
  <!-- <script src="{{ asset('') }}adminlte/bower_components/morris.js/morris.min.js"></script> -->
  <!-- Sparkline -->
  <script src="{{ asset('') }}adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
  <!-- jvectormap -->
  <script src="{{ asset('') }}adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="{{ asset('') }}adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{ asset('') }}adminlte/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="{{ asset('') }}adminlte/bower_components/moment/min/moment.min.js"></script>
  <script src="{{ asset('') }}adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- datepicker -->
  <script src="{{ asset('') }}adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="{{ asset('') }}adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <!-- Slimscroll -->
  <script src="{{ asset('') }}adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="{{ asset('') }}adminlte/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('') }}adminlte/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- <script src="{{ asset('') }}adminlte/dist/js/pages/dashboard.js"></script> -->
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('') }}adminlte/dist/js/demo.js"></script>

  {{-- dataTables --}}
  <script src="{{ asset('') }}adminlte/dataTables/js/jquery.dataTables.min.js"></script>
  <script src="{{ asset('') }}adminlte/dataTables/js/dataTables.bootstrap.min.js"></script>

    {{-- Validator --}}
  <script src="{{ asset('') }}adminlte/validator/validator.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
    #loadingProgress { position: fixed; width: 100%; height: 100%; top: 200px; left: 50%; z-index: 9999; }
  </style>
</head>
<body class="sidebar-mini skin-blue fixed">
  <?php
    
    $master = '';
    $teknisi ='';
    $material = '';
    $pelanggan ='';
    $pekerjaan = '';
    $biaya = '';
    $barang = '';
    $unit = '';
    $kategori = '';
    $supplier = '';

    $transaksi ='';
    $service = '';
    $expense = '';

    $pengguna = '';
    $manajemen = '';
    
    if(!empty($halaman) && $halaman =='teknisi'){
      $teknisi = 'active';
      $master = 'active';
    }

    if(!empty($halaman) && $halaman =='supplier'){
      $supplier = 'active';
      $master = 'active';
    }

    if(!empty($halaman) && $halaman =='pelanggan'){
      $pelanggan = 'active';
      $master = 'active';
    }

    if(!empty($halaman) && $halaman =='pekerjaan'){
      $pekerjaan = 'active';
      $master = 'active';
    }
    
    if(!empty($halaman) && $halaman =='material'){
      $material = 'active';
      $master = 'active';
    }
    
    if(!empty($halaman) && $halaman =='biaya'){
      $biaya = 'active';
      $master = 'active';
    }
    if(!empty($halaman) && $halaman =='barang'){
      $barang = 'active';
      $master = 'active';
    }

    if(!empty($halaman) && $halaman =='kategori'){
      $kategori = 'active';
      $master = 'active';
    }

    if(!empty($halaman) && $halaman =='unit'){
      $unit = 'active';
      $master = 'active';
    }

    if(!empty($halaman) && $halaman =='service'){
      $service = 'active';
      $transaksi = 'active';
    }

    if(!empty($halaman) && $halaman =='expense'){
      $expense = 'active';
      $transaksi = 'active';
    }


    if(!empty($halaman) && $halaman =='pengguna'){
      $manajemen = 'active';
      $pengguna = 'active';
    }




  ?>


<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{ url('dashboard') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>BS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SBS - </b>Inventory System</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu pull-left" style="margin-left: 10px;">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          {{-- <li>
            <a href="{{url('purchase')}}">
              <i class="fa fa-shopping-cart"></i> Pembelian
              <!-- <span class="label label-warning">Pembelian</span> -->
            </a>
            
          </li> --}}

          <li style="margin-left: 10px;">
            <a href="{{url('production')}}">
              <i class="fa fa-database"></i> Produksi 
               <!--<span class="label label-warning">Tanda Terima</span> -->
            </a>
            
          </li>

          <!--<li style="margin-left: 10px;">-->
          <!--  <a href="{{url('service')}}">-->
          <!--    <i class="fa fa-wrench"></i> Service-->
              <!-- <span class="label label-warning">Proses Service</span> -->
          <!--  </a>-->
            
          <!--</li>-->

          {{-- <li style="margin-left: 10px;">
            <a href="{{url('sales')}}">
              <i class="fa fa-money"></i> Penjualan
              <!-- <span class="label label-warning">Proses Service</span> -->
            </a>
            
          </li> --}}

          <!-- Notifications: style can be found in dropdown.less -->
        </ul>
      </div>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('') }}/adminlte/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('') }}/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::user()->name }} - {{ Auth::user()->level }}
                  <small>{{ Auth::user()->email }}</small>
                </p>
              </li>
              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('') }}/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> {{ Auth::user()->level }}</a>
        </div>
      </div>
      <div style="margin-top: 40px"></div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active">
          <a href="{{ url('dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="pull-right"></i>
            </span>
          </a>
        </li>
       
        
        <li class="treeview {{ $master }}">
          <a href="#">
            <i class="fa fa-database"></i>
            <span>Master Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!--<li class="{{ $teknisi }}"><a href="{{ url('teknisi') }}"><i class="fa fa-circle-o"></i> Teknisi</a></li>-->
            <li class="{{ $supplier }}"><a href="{{ url('supplier') }}"><i class="fa fa-circle-o"></i> Supplier</a></li>
            <li class="{{ $pelanggan }}"><a href="{{ url('customer') }}"><i class="fa fa-circle-o"></i> Pelanggan</a></li>
            <!--<li class="{{ $pekerjaan }}"><a href="{{ url('job') }}"><i class="fa fa-circle-o"></i> Pekerjaan</a></li>-->
            <li class="{{ $kategori }}"><a href="{{ url('kategori') }}"><i class="fa fa-circle-o"></i> Kategori</a></li>
            <li class="{{ $unit }}"><a href="{{ url('unit') }}"><i class="fa fa-circle-o"></i> Satuan</a></li>
            <li class="{{ $material }}"><a href="{{ url('material') }}"><i class="fa fa-circle-o"></i> Material</a></li>
            <li class="{{ $barang }}"><a href="{{ url('good') }}"><i class="fa fa-circle-o"></i> Barang</a></li>
            <!--<li class="{{ $biaya }}"><a href="{{ url('cost') }}"><i class="fa fa-circle-o"></i> Pengeluaran</a></li>-->
          </ul>
        </li>
        <li class="treeview {{ $transaksi }}">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Transaksi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!--<li class=""><a href="{{ url('cash') }}"><i class="fa fa-circle-o"></i> Kas</a></li>-->
            {{-- <li class=""><a href="{{ url('purchase') }}"><i class="fa fa-circle-o"></i> Proses Pembelian</a></li> --}}
               <li class=""><a href="{{ url('gr') }}"><i class="fa fa-circle-o"></i> Penerimaan Barang</a></li>
            <!--<li class=""><a href="{{ url('tterima') }}"><i class="fa fa-circle-o"></i> Tanda Terima Service</a></li>-->
            <!--<li class="{{ $service }}"><a href="{{ url('service') }}"><i class="fa fa-circle-o"></i> Proses Service</a></li>-->
            <li class=""><a href="{{ url('production') }}"><i class="fa fa-circle-o"></i> Proses Produksi</a></li>
            {{-- <li class=""><a href="{{ url('sales') }}"><i class="fa fa-circle-o"></i> Proses Penjualan</a></li>
            <li class="{{ $expense }}"><a href="{{ url('expense') }}"><i class="fa fa-circle-o"></i>
            Proses Pengeluaran</a></li>
            <li class=""><a href="{{ url('debt') }}"><i class="fa fa-circle-o"></i> Pembayaran Supplier</a></li>
            <!--<li class=""><a href="{{ url('custpay') }}"><i class="fa fa-circle-o"></i> Pembayaran Service</a></li>-->
            <li class=""><a href="{{ url('salespay') }}"><i class="fa fa-circle-o"></i> Pembayaran Penjualan</a></li> --}}
            
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-file-o"></i> <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!--<li><a href="{{ url('cash_report') }}"><i class="fa fa-circle-o"></i> Laporan Bukti Kas</a></li>-->
            <!--<li><a href="{{ url('flow') }}"><i class="fa fa-circle-o"></i> Laporan Arus Kas</a></li>-->
            {{-- <li><a href="{{ url('lappur') }}"><i class="fa fa-circle-o"></i> Laporan Pembelian</a></li> --}}
            <li><a href="{{ url('lapstok') }}"><i class="fa fa-circle-o"></i> Laporan Stok Barang  </a></li>
            <li><a href="{{ url('lapstokbaku') }}"><i class="fa fa-circle-o"></i> Laporan Stok Bahan Baku </a></li>
            <!--<li><a href="{{ url('laphistok') }}"><i class="fa fa-circle-o"></i> Laporan History Stok </a></li>-->

            <!--<li><a href="{{ url('lapserv') }}"><i class="fa fa-circle-o"></i> Laporan Service</a></li>-->
            {{-- <li><a href="{{ url('lapsales') }}"><i class="fa fa-circle-o"></i> Laporan Penjualan</a></li> --}}
            {{-- <li><a href="{{ url('lapsalesproduk') }}"><i class="fa fa-circle-o"></i> Lap. Penjualan Produk</a></li> --}}
            <!--<li><a href="{{ url('lapexp') }}"><i class="fa fa-circle-o"></i> Laporan Pengeluaran</a></li>-->
            {{-- <li><a href="{{ url('report_debt') }}"><i class="fa fa-circle-o"></i> Lap Hutang Supplier</a></li> --}}
            {{-- <li><a href="{{ url('report_payment') }}"><i class="fa fa-circle-o"></i> Lap Pembayaran Supplier</a></li> --}}
            <!--<li><a href="{{ url('report_ar_service') }}"><i class="fa fa-circle-o"></i> Lap Piutang Service</a></li>-->
            <!--<li><a href="{{ url('report_payment_service') }}"><i class="fa fa-circle-o"></i> Lap Pembayaran Service</a></li>-->
            {{-- <li><a href="{{ url('report_ar_sales') }}"><i class="fa fa-circle-o"></i> Lap Piutang Penjualan</a></li> --}}
            {{-- <li><a href="{{ url('report_payment_sales') }}"><i class="fa fa-circle-o"></i> Lap Pembayaran Penjualan</a></li> --}}
            <!--<li><a href="{{ url('ploss') }}"><i class="fa fa-circle-o"></i> Laporan Laba/Rugi</a>-->
            <!-- <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Laporan Laba/Rugi</a></li> -->
          </ul>
        </li>

        <!--<li class="treeview">-->
        <!--  <a href="#">-->
        <!--    <i class="fa fa-clone"></i> <span>Quotation</span>-->
        <!--    <span class="pull-right-container">-->
        <!--      <i class="fa fa-angle-left pull-right"></i>-->
        <!--    </span>-->
        <!--  </a>-->
        <!--  <ul class="treeview-menu">-->
        <!--    <li class=""><a href="{{ url('quotation') }}"><i class="fa fa-circle-o"></i> Quotation Proses</a></li>-->
        <!--  </ul>-->
        <!--</li>-->


        <li class="treeview {{ $pengguna }}">
          <a href="#">
            <i class="fa fa-user"></i> <span>Pengguna</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ $manajemen }}"><a href="{{ url('user') }}"><i class="fa fa-circle-o"></i> Manajemen Pengguna</a></li>
            <li>
                <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fa fa-circle-o"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-wrench"></i> <span>Setting</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class=""><a href="{{ url('setting') }}"><i class="fa fa-circle-o"></i> General Setting</a></li>
          </ul>
        </li>
        
    </section>
    <!-- /.sidebar -->
  </aside>

  

    <!-- Main content -->
    @yield('content')
    <!-- /.content -->


  
  <footer class="main-footer">
    <div id="loadingProgress" style="display: none;">
        <img src="{{ url('') }}public/images/ajax-loader.gif" class="ajax-loader">
    </div>
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy;  2021 <a href="http://insoft-dev.com"> Insoft Developers</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<script type="text/javascript">

    $('.date').datepicker({  

       format: 'yyyy-mm-dd',
       autoclose:true

     });  

</script>

<script>  
  $.widget.bridge('uibutton', $.ui.button);
</script>

</body>
</html>
