<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./public/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<title>Laporan Komisi</title>
</head>
<body>

	<h2>Laporan Komisi By Date</h2>
	<p>Periode : {{ $dari }} s.d {{ $sampai }}</p>

	<table border="1" width="100%" cellpadding="4" cellspacing="4" style="border-collapse: collapse; font-size: 12px;">
		<thead>
			<tr>
				<th>No</th>
				<th>Tgl Pekerjaan</th>
				<th>Pekerjaan</th>
				<th>Pelanggan</th>
				<th>Teknisi</th>
				<th>Nilai</th>
			</tr>
		</thead>
		<tbody>
			
			<?php $no = 0; 
				foreach ($expense as $key) { $no++;?>
				<tr>
					<td>{{ $no  }}</td>
					<td>{{ date('d-m-Y', strtotime($key->cost_date)) }}</td>
					<td>{{ $key->cost_name}}</td>
					<td>{{ $key->description}}</td>
					<td style="text-align: right;">{{ number_format($key->cost_value) }}</td>
					<td>{{ date('d-m-Y', strtotime($key->created_at)) }}</td>
				</tr>
			<?php }?>
			
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4"><b> TOTAL PENGELUARAN</b></td>
				<td style="text-align: right;"><b>{{ number_format($total_expense->Total) }}</b></td>
				<td></td>
			</tr>
		</tfoot>
	</table>

	

</body>
</html>