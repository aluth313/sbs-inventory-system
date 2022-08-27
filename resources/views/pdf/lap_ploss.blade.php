<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./public/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<title>Laporan Laba Rugi</title>
</head>
<body>
	<h4 style="margin-top: -30px;">{{ $profil->company_name }}</h4>
	<p style="margin-top: -20px">{{$profil->company_address}}<br>{{$profil->owner_phone}}</p>
	<center><h2>LAPORAN LABA RUGI</h2></center>
	<h4>Periode : 
		@if($periode == '01')
			Januari {{date("Y")}}
		@elseif($periode=='02')
			Febuari {{date("Y")}}
		@elseif($periode=='03')
			Maret {{date("Y")}}
		@elseif($periode=='04')
			April {{date("Y")}}
		@elseif($periode=='05')
			Mei {{date("Y")}}
		@elseif($periode=='06')
			Juni {{date("Y")}}
		@elseif($periode=='07')
			Juli {{date("Y")}}
		@elseif($periode=='08')
			Agustus {{date("Y")}}
		@elseif($periode=='09')
			September {{date("Y")}}
		@elseif($periode=='10')
			Oktober {{date("Y")}}
		@elseif($periode=='11')
			November {{date("Y")}}
		@elseif($periode=='12')
			Desember {{date("Y")}}

		@endif	
	</h4>

	<table border="1" width="100%" cellpadding="4" cellspacing="4" style="border-collapse: collapse; font-size: 14px;">
		<thead>
			<tr>
				<th width="20%">PENDAPATAN SERVICE</th>
				<th width="20%"></th>
				<th width="*"></th>
				<th width="20%" style="text-align: right;">{{number_format($service->Service)}}</th>
			</tr>
			<tr>
				<th width="20%">PENJUALAN</th>
				<th width="20%"></th>
				<th width="*"></th>
				<th width="20%" style="text-align: right;">{{number_format($sales->Sales)}}</th>
			</tr>
			<tr>
				<th></th>
				<th>BIAYA - BIAYA</th>
				<td></td>
				<td></td>
			</tr>
			<?php
			$total_biaya = 0;
			foreach($cost as $key => $value ){
				$total_biaya = $total_biaya + $value->TOTAL;
			?>
			<tr>
				<td></td>
				<td>{{$value->cost_name}}</td>
				<td style="text-align: right;">{{number_format($value->TOTAL)}}</td>
				<td></td>
			</tr>
			<?php }?>
			<tr>
				<th>TOTAL BIAYA</th>
				<td></td>
				<td></td>
				<td style="text-align: right;">{{number_format($total_biaya * -1)}}</td>
			</tr>
			<tr>
				<th>LABA KOTOR</th>
				<td></td>
				<td></td>
				<th style="text-align: right;">{{number_format($service->Service + $sales->Sales - $total_biaya)}}</th>
			</tr>
			<tr>
				<th>HARGA POKOK PENJUALAN SERVICE</th>
				<td></td>
				<td></td>
				<td style="text-align: right;">{{number_format($hpp->Hpp * -1)}}</td>
			</tr>
			<tr>
				<th>HARGA POKOK PENJUALAN BARANG</th>
				<td></td>
				<td></td>
				<td style="text-align: right;">{{number_format($hpps->Hpp2 * -1)}}</td>
			</tr>
			<tr>
				<th>LABA BERSIH</th>
				<td></td>
				<td></td>
				<th style="text-align: right;font-size: 16px;">{{number_format($service->Service + $sales->Sales - $total_biaya - $hpp->Hpp - $hpps->Hpp2)}}</th>
			</tr>
		</thead>
	</table>
</body>
</html>