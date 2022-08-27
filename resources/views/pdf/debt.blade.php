<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./public/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<title>Laporan Hutang Supplier</title>
</head>
<body style="margin-left: -10px;margin-right: -10px;">
	<h4 style="margin-top: -30px;">{{ $profil->company_name }}</h4>
	<p style="margin-top: -20px">{{$profil->company_address}}<br>{{$profil->owner_phone}}</p>
	<div class="title"><center> 
		<h3>Laporan Hutang Ke Supplier Per Supplier</h3>
		</center>
	</div>

	<table border="1" width="100%" cellpadding="4" cellspacing="4" style="border-collapse: collapse; font-size: 12px;">
		<thead>
			<tr>
				<th width="1%">No</th>
				<th width="8%">Tgl</th>
				<th width="20%">Supplier</th>
				<th width="10%">No.Beli</th>
				<th width="5%">Jumlah</th>
				<th width="8%">Dibayar</th>
				<th width="9%">DP</th>
				<th width="9%">Sisa</th>
				<th width="9%">JT</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 0;
			$jumlah = 0;
			$dibayar = 0;
			$dp = 0;
			$sisa =0;
			foreach($purchase as $key => $value )
			{
				$no++;
				$jumlah = $jumlah + $value->total;
				$dibayar = $dibayar + $value->pembayaran;
				$dp = $dp + $value->dp;
				$sisa = $sisa + $value->sisa;
			?>
			<tr>
				<td>{{$no}}</td>
				<td>{{date("d-m-Y", strtotime($value->created_at))}}</td>
				<td>{{$value->supplier_name}}</td>
				<td>{{$value->invoice}}</td>
				<td style="text-align: right;">{{number_format($value->total)}}</td>
				<td style="text-align: right;">{{number_format($value->pembayaran)}}</td>
				<td style="text-align: right;">{{number_format($value->dp)}}</td>
				<td style="text-align: right;">{{number_format($value->sisa)}}</td>
				<td>{{date("d-m-Y", strtotime('+'.$value->hari.' days', strtotime($value->created_at)))}}</td>
			</tr>
			<?php }?>
			<tr>
				<th colspan="4" style="text-align: right;"><strong>TOTAL</strong></th>
				<th style="text-align: right;">{{ number_format($jumlah) }}</th>
				<th style="text-align: right;">{{ number_format($dibayar) }}</th>
				<th style="text-align: right;">{{ number_format($dp) }}</th>
				<th style="text-align: right;">{{ number_format($sisa)}}</th>
				<td></td>
			</tr>
			
		</tbody>
	</table>

	

</body>
</html>