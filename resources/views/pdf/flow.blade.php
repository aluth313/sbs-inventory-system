<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./public/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<title>Laporan Arus Kas</title>
</head>
<body style="margin-left: -10px;margin-right: -10px;">
	<h4 style="margin-top: -30px;">{{ $profil->company_name }}</h4>
	<p style="margin-top: -20px">{{$profil->company_address}}<br>{{$profil->owner_phone}}</p>
	<div class="title"><center> 
		<h3>Laporan Arus Kas</h3>
		<p style="font-size: 14px;margin-top: -10px" >Per {{date("d-m-Y H:i:s")}}</p></center>
	</div>

	<table border="1" width="100%" cellpadding="4" cellspacing="4" style="border-collapse: collapse; font-size: 12px;">
		<thead>
			<tr>
				<th width="1%">No</th>
				<th width="10%">Tanggal</th>
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
					$saldo = $saldo + $key->incash - $key->outcash; 
					$in = $in + $key->incash;
					$out = $out + $key->outcash;
				?>
				<tr>
					<td>{{$no}}</td>
					<td>{{date("d-m-Y", strtotime($key->created_at))}}</td>
					<td>{{$key->type}}</td>
					<td>{{$key->document}}</td>
					<td style="text-align: right;">{{number_format($key->incash)}}</td>
					<td style="text-align: right;">{{number_format($key->outcash)}}</td>
					<td style="text-align: right;"><strong>{{number_format($saldo)}}</strong></td>
					
					
				</tr>
				
			<?php }?>
				<tr>
					<td colspan="4" style="text-align: right;"><strong>Total</strong></td>
					<td style="text-align: right;"><strong>{{number_format($in)}}</strong></td>
					<td style="text-align: right;"><strong>{{number_format($out)}}</strong></td>
					<td style="text-align: right;"><strong>{{number_format($in-$out)}}</strong></td>
				</tr>
			
		</tbody>
	</table>

	

</body>
</html>