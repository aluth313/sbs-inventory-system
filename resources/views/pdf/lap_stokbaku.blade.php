<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./public/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<title>Laporan Stok</title>
</head>
<body style="margin-left: -10px;margin-right: -10px;">
	<h4 style="margin-top: -30px;">{{ $profil->company_name }}</h4>
	<p style="margin-top: -20px">{{$profil->company_address}}<br>{{$profil->owner_phone}}</p>
	<div class="title"><center> 
		<h3>Laporan Stok Bahan Baku / Material</h3>
		<p style="font-size: 14px;margin-top: -10px" >Per {{date("d-m-Y H:i:s")}}</p></center>
	</div>

	<table border="1" width="100%" cellpadding="4" cellspacing="4" style="border-collapse: collapse; font-size: 12px;">
		<thead>
			<tr>
				<th width="1%">No</th>
				<th width="8%">ID</th>
				<th width="25%">Nama Material</th>
				<th>Kategori</th>
				<th>Satuan</th>
				
				<th>Stok</th>
				<th>Harga</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			
			<?php $no = 0; 
					$total = 0;
				foreach ($good as $key) { $no++; $total = $total + ($key->b_price * $key->stok) ?>
				<tr>
					<td>{{$no}}</td>
					<td>{{$key->id}}</td>
					<td>{{$key->material_name}}</td>
					<td>{{$key->category_name}}</td>
					<td>{{$key->unit}}</td>
					
					<td style="text-align: right;">{{number_format($key->stok)}}</td>
					<td style="text-align: right;">{{number_format($key->b_price)}}</td>
					<td style="text-align: right;">{{number_format($key->b_price * $key->stok)}}</td>
				</tr>
				
			<?php }?>
				<tr>
					<td colspan="7" style="text-align: right;"><strong>Total</strong></td>
					<td style="text-align: right;"><strong>{{ number_format($total) }}</strong></td>
				</tr>
			
		</tbody>
	</table>

	

</body>
</html>