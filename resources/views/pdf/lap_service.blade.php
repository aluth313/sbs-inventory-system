<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./public/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<title>Laporan Service</title>
</head>
<body>

	<h4 style="margin-top: -30px;">{{ $profil->company_name }}</h4>
	<p style="margin-top: -20px">{{$profil->company_address}}<br>{{$profil->owner_phone}}</p>
	<div class="title"><center> 
		<h3>Laporan Service Per Tanggal</h3>
		<p style="font-size: 14px;margin-top: -10px" >Periode : {{ date("d-m-Y", strtotime($dari)) }} s.d {{ date("d-m-Y", strtotime($sampai)) }}</p></center>
	</div>

	<table border="1" width="100%" cellpadding="4" cellspacing="4" style="border-collapse: collapse; font-size: 12px;">
		<thead>
			<tr>
				<th>No</th>
				<th>Tgl</th>
				<th>Invoice</th>
				<th>TT</th>
				<th>Pelanggan</th>
				<th>Teknisi</th>
				<th>Item</th>
				<th>Note</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			
			<?php $no = 0; foreach ($service as $key) { $no++ ?>
				<tr>
					<td>{{$no}}</td>
					<td>{{$key->created_at}}</td>
					<td>{{$key->invoice}}</td>
					<td>{{$key->ttno}}</td>
					<td>{{$key->customer_name}}</td>
					<td>{{$key->nama}}</td>
					<td>{{$key->ITEM}}</td>
					<td>{{$key->note}}</td>
					<td style="text-align:right;">{{number_format($key->total)}}</td>
				</tr>
			<?php }?>
			<tr>
				<td colspan="8"></td>
				<td style="text-align:right;">{{number_format($total->Total)}}</td>
			</tr>
			
		</tbody>
	</table>

	

</body>
</html>