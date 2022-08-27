<!DOCTYPE html>
<html>
<head>
	<title>Bukti Kas</title>
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
	<div style="margin-top: -20px;font-size: 16px;text-align: right;" class="profil">
		@if($cash->category == 1)
			<h3>Bukti Kas Masuk</h3>
		@else
			<h3>Bukti Kas Keluar</h3>
		@endif
		<p style="margin-top: -20px;font-size: 14px;">No. {{$cash->cash_number}} <br> Tanggal: {{date("d-m-Y", strtotime($cash->created_at))}}</p>
	</div>
	

	<div style="margin-top: 20px;font-size: 14px;" class="contents">
		<table class="table-data" width="100%" cellspacing="3" cellpadding="3">
			<tr>
				<td colspan="3">
					@if($cash->category == 1)
						TELAH DITERIMA SEJUMLAH UANG :
					@else
						TELAH DIKELUARKAN SEJUMLAH UANG :
					@endif
				</td>
			</tr>
				
			<tr>
				<td>Sebanyak</td>
				<td>:</td>
				<td><b>Rp. {{number_format($cash->cash_value)}}</b></td>
			</tr>
			<tr>
				<td>Terbilang</td>
				<td>:</td>
				<td># {{\App\Helpers\Terbilang::kekata($cash->cash_value)}} Rupiah # </td>
			</tr>
			<tr>
				<td>Untuk</td>
				<td>:</td>
				<td>{{$cash->description}}</td>
			</tr>
		
		</table>
	</div>
	<div class="footer" style="font-size: 14px;">
		<p>Medan, {{ date("d-M-Y") }}</p>
		<p>Diserahkan Oleh : ...................................................  <span style="margin-left: 60px;">Diterima Oleh : ...................................................</span></p>
		<h4 style="margin-top: 70px;">NB : Bukti Kas Ini adalah Bukti Sah Serah Terima Sejumlah Uang Bagi Pihak-pihak yang bertanda tangan diatas.</h4>
	</div>
</body>
</html>