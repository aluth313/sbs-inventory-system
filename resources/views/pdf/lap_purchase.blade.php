<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./public/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<title>Laporan Pembelian</title>
</head>
<body style="margin-left: -10px;margin-right: -10px;">
	<h4 style="margin-top: -30px;">{{ $profil->company_name }}</h4>
	<p style="margin-top: -20px">{{$profil->company_address}}<br>{{$profil->owner_phone}}</p>
	<div class="title"><center> 
		<h3>Laporan Pembelian Per Tanggal</h3>
		<p style="font-size: 14px;margin-top: -10px" >Periode : {{ date("d-m-Y", strtotime($dari)) }} s.d {{ date("d-m-Y", strtotime($sampai)) }}</p></center>
	</div>

	<table border="1" width="100%" cellpadding="4" cellspacing="4" style="border-collapse: collapse; font-size: 12px;">
		<thead>
			<tr>
				<th width="1%">No</th>
				<th width="8%">Tgl</th>
				<th>No.Pembelian</th>
				<th>Supplier</th>
				<th>Deskripsi</th>
				<th>Item</th>
				<th width="5%">Jumlah</th>
				<th width="8%">Satuan</th>
				<th width="8%">Harga</th>
				<th width="9%">Total</th>
				<th width="9%">Subtotal/Inv</th>
				
			</tr>
		</thead>
		<tbody>
			
			<?php $no = 0; 
				foreach ($purchase as $key) { $no++;?>
				<tr>
					<td>{{$no}}</td>
					<td>{{date("d-m-Y", strtotime($key->created_at))}}</td>
					<td>{{$key->invoice}}</td>
					<td>{{$key->supplier_name}}</td>
					<td>{{$key->description}}</td>
					<td>{{$key->material_name}}</td>
					<td style="text-align: right;">{{$key->quantity}}</td>
					<td style="text-align: right;">{{$key->item_unit}}</td>
					<td style="text-align: right;">{{number_format($key->item_price)}}</td>
					<td style="text-align: right;">{{number_format($key->item_total)}}</td>
					<td style="text-align: right;">{{number_format($key->total)}}</td>
				</tr>
				
			<?php }?>
				<tr>
					<td colspan="9" style="text-align: right;"><strong>Total</strong></td>
					<td style="text-align: right;"><strong>{{number_format($total->Total)}}</strong></td>
					<td></td>
				</tr>
			
		</tbody>
	</table>

	

</body>
</html>