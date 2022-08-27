<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./public/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<title>Laporan Pembayaran Service</title>
</head>
<body style="margin-left: -10px;margin-right: -10px;">
	<h4 style="margin-top: -30px;">{{ $profil->company_name }}</h4>
	<p style="margin-top: -20px">{{$profil->company_address}}<br>{{$profil->owner_phone}}</p>
	<div class="title"><center> 
		<h3>Laporan Pembayaran Service Per Customer</h3>
		</center>
	</div>

	<table border="1" width="100%" cellpadding="4" cellspacing="4" style="border-collapse: collapse; font-size: 12px;">
		<thead>
			<tr>
				<th width="1%">No</th>
				<th width="8%">Tgl</th>
				<th width="10%">No.Bayar</th>
				<th width="10%">No.Service</th>
				<th width="20%">Customer</th>
				<th width="5%">Jumlah</th>
				<th width="*">Keterangan</th>
			</tr>
		</thead>
		<tbody>
			
			<?php
				$no = 0;
				$total = 0;
				foreach ($custpay as $key => $value) {
				$no++;
				$total = $total + $value->nilai_pembayaran;
			?>
			<tr>
				<td>{{$no}}</td>
				<td>{{$value->created_at}}</td>
				<td>{{$value->payment_no}}</td>
				<td>{{$value->service_id}}</td>
				<td>{{$value->customer_name}}</td>
				<td style="text-align: right;">{{number_format($value->nilai_pembayaran)}}</td>
				<td>{{$value->description}}</td>
			</tr>
			<?php } ?>
			<tr>
				<th colspan="5" style="text-align: right;"><strong>TOTAL</strong></th>
				<th style="text-align: right;">{{ number_format($total)}}</th>
				<th></th>
			</tr>
			
		</tbody>
	</table>
</body>
</html>