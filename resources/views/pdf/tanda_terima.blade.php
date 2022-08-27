
<!DOCTYPE html>
<html>
<head>
	<title>Surat Perintah Kerja</title>
</head>
<body style="margin-top: -30px;">
	<center><h2><u>SURAT PERINTAH KERJA</u></h2>
		<p style="margin-top: -20px;">No Spk : {{ substr($tt->ttno,5,4 )}}/SPK/{{$romawi}}/{{$tahun}}</p>
	</center>
	
	<div style="margin-top: 10px;font-size: 14px;" class="content">
		<table border="1" cellspacing="3" cellpadding="3" width="100%" style="border-collapse: collapse;">
			
			<tr>
				<td style="width:16%"><b>Customer :</b></td>
				<td>{{$tt->customer_name}}</td>
			</tr>
			<tr>
				<td><b>Pekerjaan :</b></td>
				<td>{{$tt->item_name}}</td>
			</tr>
			<tr>
				<td style="height: 500px"></td>
				<td></td>
			</tr>
			
		</table>
		<p>Estimasi Kerja :</p>
		<p>Mulai Kerja :</p>
		<p style="margin-top: 60px;">Tgl Selesai : 
			<br><br>
			<span style="margin-left: 200px;">Yang Membuat</span><span style="margin-left: 130px">Yang Mengerjakan</span>
			<div style="margin-top: 70px"></div>
			<span style="margin-left: 200px;">(...........................)</span><span style="margin-left: 110px">(................................)</span>
		</p>
		<p>NB :</p>

		
		
	</div>
	
</body>
</html>