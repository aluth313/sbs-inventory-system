<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./public/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<title>Laporan Bukti Kas</title>
</head>
<body>
	<h4 style="margin-top: -30px;">{{ $profil->company_name }}</h4>
	<p style="margin-top: -20px">{{ $profil->company_address }}<br>{{ $profil->owner_phone }}</p>

	<h2>Laporan Bukti Kas By Date</h2>
	<p>Periode : {{ date("d-m-Y", strtotime($dari)) }} s.d {{ date("d-m-Y", strtotime($sampai)) }}</p>

	<table border="1" width="100%" cellpadding="4" cellspacing="4" style="border-collapse: collapse; font-size: 12px;">
		<thead>
			<tr>
				<th>No</th>
				<th>Tgl Transaksi</th>
				<th>Kategori</th>
				<th>Deskripsi</th>
				<th>Kas Masuk</th>
				<th>Kas Keluar</th>
				<th>Tgl Dibuat</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$no = 0;
				$kas_masuk = 0;
				$kas_keluar = 0;
				foreach($cash as $key =>$value){
					$no++;
					if($value->category ==1){
						$km = $value->cash_value;
						$kk = 0;
					}else{
						$km = 0;
						$kk = $value->cash_value;
					}

					$kas_masuk = $kas_masuk + $km;
					$kas_keluar = $kas_keluar + $kk;
				?>
				<tr>
					<td>{{$no}}</td>
					<td style="text-align: center;">{{date("d-m-Y", strtotime($value->trans_date))}}</td>
					<td><?php if($value->category ==1){echo 'Kas Masuk';}else{echo 'Kas Keluar';} ?></td>
					<td>{{$value->description}}</td>
					<td style="text-align: right;">
						<?php if($value->category == 1){
								echo number_format($value->cash_value);		
							} else{
								echo 0;
							}
						?>
						</td>
					<td style="text-align: right;">
						<?php if($value->category == 2){
								echo number_format($value->cash_value);		
							} else{
								echo 0;
							}
						?>
						</td>
					<td style="text-align: center;">{{date("d-m-Y", strtotime($value->created_at))}}</td>
				</tr>
			<?php }?>
			
		</tbody>
		<tfoot>
			<tr>
				<th colspan="4"><b> TOTAL KAS</b></th>
				<th style="text-align: right;"><b>{{number_format($kas_masuk)}}</b></th>
				<th style="text-align: right;"><b>{{number_format($kas_keluar)}}</b></th>
				<th></th>
			</tr>
		</tfoot>
	</table>

	

</body>
</html>