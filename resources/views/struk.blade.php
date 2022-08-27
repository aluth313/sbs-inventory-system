<!DOCTYPE html>
<html>
<head>
	<title>Struk Service</title>
</head>
<body style="width: 200px;font-size: 13px;">
	<h3>My Service</h3>
	@foreach($nota as $row)

	<p style="margin-bottom:-10px;">Nota : {{ $row->nota }}</p>
	@endforeach
	<p style="margin-bottom:-10px;">Tanggal : {{ $tanggal }}</p>
	<p>Teknisi : {{ $servie->nama }}</p>

	==============================
	<table style="width: 100px;">
		<tr>
			<td>Deskripsi</td>
			<td>Harga/ Total</td>
		</tr>
		<tr>
			<td colspan="2">==============================</td>
		</tr>
		@foreach($data as $key)
		<tr>
			<td>{{ $key->item }} <br> {{ $key->jumlah }}  X  {{ number_format($key->harga) }}</td>
			<td style="text-align: right">{{ number_format($key->total) }}</td>	
		</tr>
		@endforeach
		<tr>
			<td colspan="2">==============================</td>
		</tr>
		<tr>
			<td><strong>TOTAL</strong></td>
			<td style="text-align: right"><b>{{ number_format($total_->Total) }}</b></td>
		</tr>

	</table>
	<p style="margin-bottom:-10px;">Pelanggan : {{ $servie->customer_name }} <br> Alamat : {{ $servie->customer_address}}</p>
	<center><p>***Terima Kasih***</p></center>
</body>
</html>