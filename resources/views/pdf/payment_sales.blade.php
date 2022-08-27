<!DOCTYPE html>
<html>
<head>
	<title>Nota Pembayaran</title>
	<style type="text/css">
		body{
			font-family: sans-serif;
		}
		.table-data{
			border: 1px solid #999;
		    padding: 8px 20px;
		}
	</style>
</head>
<body style="margin-top: -30px; width: 100%">
	<center>
		<h4>{{ $profil->company_name }}</h4>
		<p style="margin-top: -20px;">{{ $profil->company_address }} <br>Telp : {{ $profil->owner_phone }}<br></p>
		
		
	</center>
	<hr>
	<div style="margin-top: -20px;font-size: 16px;" class="profil">
		<h3>Nota Pembayaran Penjualan</h3>
		<p style="margin-top: -20px;font-size: 14px;">No. {{ $salespay->payment_no}} <br> Tanggal: {{date("d-m-Y", strtotime($salespay->created_at))}}</p>
	</div>
	

	<div style="margin-top: 20px;font-size: 14px;" class="contents">
		<table class="table-data" width="100%" cellspacing="3" cellpadding="3">
			<tr>
				<td colspan="3">Telah Diterima Pembayaran Dari :</td>
			</tr>
			<tr>
				<td  style="width: 30%;">Nama</td>
				<td style="width: 1%px">:</td>
				<td>{{$salespay->customer_name}}</td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td>{{$salespay->customer_address}}</td>
			</tr>
			<tr>
				<td>Phone</td>
				<td>:</td>
				<td>{{$salespay->customer_phone}}</td>
			</tr>
			<tr>
				<td>Jumlah Pembayaran</td>
				<td>:</td>
				<td><b>Rp. {{number_format($salespay->nilai_pembayaran)}} ,-</b></td>
			</tr>
			<tr>
				<td>Terbilang</td>
				<td>:</td>
				<td>( # {{\App\Helpers\Terbilang::kekata($salespay->nilai_pembayaran)}} Rupiah # )</td>
			</tr>
			<tr>
				<td>Untuk Pembayaran</td>
				<td>:</td>
				<td>No Invoice {{ $salespay->sales_id }}</td>
			</tr>
			<tr>
				<td>Keterangan</td>
				<td>:</td>
				<td>{{ $salespay->description }}</td>
			</tr>
		
		</table>
	</div>
	<div class="footer" style="font-size: 14px;">
		<p>Medan, {{ date("d-M-Y") }}</p>
		<p>Diserahkan Oleh : ...................................................  <span style="margin-left: 60px;">Diterima Oleh : ...................................................</span></p>
		<h4 style="margin-top: 70px;">NB : Nota Pembayaran Ini adalah Bukti Sah Telah diterimanya sejumlah uang dari yang tertera diatas setelah ditanda tangani oleh pihak yang menyerahkan dan yang menerima.</h4>
	</div>
</body>
</html>