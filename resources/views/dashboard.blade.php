@extends('master')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>
<section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        
        {{-- <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <p>Penjualan Rp. </p>
              <h3>{{number_format($sales->Total)}}</h3>

              
            </div>
            <div class="icon">
              <i class="fa fa-dollar"></i>
            </div>
            <a href="#" class="small-box-footer">Penjualan Bulan Ini <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> --}}

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <p>Bahan Baku Rp. </p>
              <h3>{{number_format($stokbaku->Stokbaku)}}</h3>
            </div>
            <div class="icon">
              <i class="fa fa-wrench"></i>
            </div>
            <a href="#" class="small-box-footer">Stok Tersedia in Value <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              
              <p>Stok Rp. </p>
              <h3>{{number_format($stok->Stok)}}</h3>
            </div>
            <div class="icon">
              <i class="fa fa-cube"></i>
            </div>
            <a href="#" class="small-box-footer">Stok Tersedia in Value <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              
              <p>Produksi Rp. </p>
              <h3>{{number_format($production->Total)}}</h3>
            </div>
            <div class="icon">
              <i class="fa fa-file"></i>
            </div>
            <a href="#" class="small-box-footer">Produksi Bulan ini <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <!-- ./col -->
        {{-- <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <p>Pembelian Rp.</p>
              <h3>
              <h3>{{number_format($purchase->Total)}}</h3></h3>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">Pembelian Bulan Ini <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> --}}
        
        <!-- ./col -->
        
        <!-- ./col -->
      </div>

      <div class="row">
        
        {{-- <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <p>Biaya Rp. </p>
              <h3>{{number_format($biaya->Total)}}</h3>

              
            </div>
            <div class="icon">
              <i class="fa fa-calculator"></i>
            </div>
            <a href="#" class="small-box-footer">Biaya Bulan Ini <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> --}}

        {{-- <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <p>Hutang Ke Supplier Rp. </p>
              <h3>{{number_format($hutang->Sisa)}}</h3>
            </div>
            <div class="icon">
              <i class="fa fa-credit-card"></i>
            </div>
            <a href="#" class="small-box-footer">Hutang Bulan Ini <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> --}}
        <!-- ./col -->
        
        <!-- ./col -->
        {{-- <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <p>Piutang Penjualan Rp.</p>
              <h3>
              <h3>{{number_format($psales->Sisa)}}</h3></h3>
            </div>
            <div class="icon">
              <i class="fa fa-suitcase"></i>
            </div>
            <a href="#" class="small-box-footer">Piutang Bulan Ini <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> --}}
        
        <!-- ./col -->
        
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      
        <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Biaya <i class="fa fa-asterisk"></i> Penjualan <i class="fa fa-asterisk"></i> Pembelian</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="barChart" style="height:230px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
      
   
     
          <!-- /.box -->
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
  </div>

  <script>
  $(function () {
    
    var areaChartData = {
      labels  : ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
      datasets: [
        {
          label               : 'Biaya',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [{{ $jan }}, {{ $feb }}, {{ $mar }}, {{ $apr }}, {{ $mei }} , {{ $jun }}, {{ $jul }}, {{ $agt }}, {{ $sep }}, {{ $okt }}, {{ $nov }}, {{ $des }} ]
        },
        {
          label               : 'Service',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [{{ $ja + $jasal  }}, {{ $fe+$fesal }}, {{ $ma+$masal }}, {{ $ap+$apsal }}, {{ $me+$mesal }} , {{ $ju+$junsal }}, {{ $jl+$julsal }}, {{ $ag+$agusal }}, {{ $se+$sepsal }}, {{ $ok+$oksal }}, {{ $no+$novsal }}, {{ $de+$dessal }}]
        },
        {
          label               : 'Service',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [{{ $jax }}, {{ $fex }}, {{ $max }}, {{ $apx}}, {{ $mex }} , {{ $jux }}, {{ $jlx }}, {{ $agx }}, {{ $sex }}, {{ $okx }}, {{ $nox }}, {{ $dex }}]
        }
      ]
    }



    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

       


    
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    barChartData.datasets[1].fillColor   = '#00a65a'
    barChartData.datasets[1].strokeColor = '#00a65a'
    barChartData.datasets[1].pointColor  = '#00a65a'
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)
  })
</script>

@endsection
