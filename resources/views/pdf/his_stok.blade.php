<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./public/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<title>Laporan History Stok</title>
</head>
<body style="margin-left: -10px;margin-right: -10px;">
	<h4 style="margin-top: -30px;">{{ $profil->company_name }}</h4>
	<p style="margin-top: -20px">{{$profil->company_address}}<br>{{$profil->owner_phone}}</p>
	<div class="title"><center> 
		<h3>Laporan History Stok</h3>
		<p style="font-size: 14px;margin-top: -10px" >Per {{date("d-m-Y H:i:s")}}</p></center>
	</div>

	<table border="1" width="100%" cellpadding="4" cellspacing="4" style="border-collapse: collapse; font-size: 12px;">
		<thead>
			<tr>
				<th width="1%">No</th>
				<th width="10%">Tanggal</th>
				<th width="5%">ID</th>
				<th width="25%">Nama Barang</th>
				<th>Satuan</th>
				<th>Tipe</th>
				<th>Document</th>
				<th>In</th>
				<th>Out</th>
				<th>Sisa</th>
			</tr>
		</thead>
		<tbody>
			
			<?php $no = 0; 
				  $saldo = $stok_lama->Saldo;
				  $in = $stok_lama->Ing;
				  $out =$stok_lama->Outg;
				foreach ($stock as $key) { 
					$no++;
					$saldo = $saldo + $key->in - $key->out; 
					$in = $in + $key->in;
					$out = $out + $key->out;
				?>
				<tr>
					<td>{{$no}}</td>
					<td>{{date("d-m-Y", strtotime($key->created_at))}}</td>
					<td>{{$key->id_good}}</td>
					<td>{{$key->good_name}}</td>
					<td>{{$key->unit}}</td>
					<td>{{$key->type}}</td>
					<td>{{$key->document}}</td>
					<td style="text-align: right;">{{$key->in}}</td>
					<td style="text-align: right;">{{$key->out}}</td>
					<td style="text-align: right;"><strong>{{$saldo}}</strong></td>
					
					
				</tr>
				
			<?php }?>
				<tr>
					<td colspan="7" style="text-align: right;"><strong>Total</strong></td>
					<td style="text-align: right;"><strong>{{$in}}</strong></td>
					<td style="text-align: right;"><strong>{{$out}}</strong></td>
					<td style="text-align: right;"><strong>{{$in-$out}}</strong></td>
				</tr>
			
		</tbody>
	</table>

	

</body>
</html>