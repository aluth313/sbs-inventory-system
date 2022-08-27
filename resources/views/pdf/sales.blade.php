<!DOCTYPE html>
<html>
<head>
	<title>Faktur Tagihan</title>
	<style type="text/css">
		body{
			font-family: sans-serif;
		}

		.table-data{
		    
		    color: #232323;
		    border-collapse: collapse;
		}
 
		.table-data th {
		    border: 1px solid #999;
		    padding: 8px 20px;
		}
		.table-data td {

		    border-left: 1px solid #999;
		    border-right: 1px solid #999;
		    padding: 8px 20px;
		}
		.endRow td {

		    border-bottom: 2px solid #999;
		    padding: 8px 20px;
		}

		.footRow td {
		    padding: 8px 20px;
		}
		
	</style>
</head>
<body  style="margin-top: -30px; margin-left: -20px;margin-right: -20px;">
	<table width="100%"> 
		<tr>
			<td width="60%"><h2><i>{{$profil->company_name}}</i></h2></td>
			<td width="40%" colspan="4" style="text-align: left;"><h1><u>INVOICE</u></h1></td>
		</tr>
		<tr>
			<td width="30%"><p style="margin-top:-20px;font-size: 13px; ">{{$profil->company_address}}
					<br>
					Telp. {{$profil->owner_phone}} Fax. {{$profil->fax}}
					<br>
					E-mail : {{$profil->email}}
				</p><br><b>Kepada Yth:</b><br>
					Bpk/Ibu {{$sales->customer_name}}<br>
					Di {{$sales->customer_address}}
				</td>
			<td  style="font-size: 14px;" colspan="5" width="30%" rowspan="2">
				Invoice No &nbsp;&nbsp;: {{$sales->invoice}}
				<br>
				DO Kami &nbsp;&nbsp;&nbsp;&nbsp;: {{$sales->invoice}}
				<br>
				PO No.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      : {{$sales->invoice}}
				<br>
				Tujuan.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     : {{substr($sales->customer_address, 0, 30)}}
				<br>
				Tanggal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     : {{date("d-M-Y", strtotime($sales->created_at))}}
			</td>
			
		</tr>
	</table>

	<table class="table-data" cellpadding="2" cellspacing="2" width="100%">
		<tr>
			<th width="*">No</th>
			<th width="3%">Jml</th>
			<th width="3%">Sat</th>
			<th width="12%">Nama Barang</th>
			<th width="10%">Harga<br>(Rp.)</th>
			<th width="10%">Total<br> (Rp.)</th>
		</tr>
		<?php
			$no = 0;
			$gtotal = 0;
			foreach ($br as $key => $value) {
			$no++;	
			$gtotal = $gtotal + $value->total;
			
		 ?>
		<tr>
			<td style="text-align: right;">{{$no}}</td>
			<td style="text-align: right;">{{$value->quantity}}</td>
			<td>{{$value->uom}}</td>
			<td>{{$value->good_name}}</td>
			<td style="text-align: right;">{{number_format($value->price)}}</td>
			<td style="text-align: right;">{{number_format($value->total)}}</td>
		</tr>
	<?php }
			
		 for($x = $no+1; $x <= (26-($no*2)); $x++) {
		
	?>
		<tr>
			<td style="text-align: right;"><p style="display: none;">{{$x}}</p></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

	<?php }?>
		<tr class="endRow">
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<th rowspan="3" colspan="4"> * Terbilang:  {{\App\Helpers\Terbilang::kekata($gtotal - $sales->dp)}} Rupiah.</th>
			<th style="text-align: right;">Total Rp. </th>
			<th style="text-align: right;">{{ number_format($gtotal) }}</th>
		</tr>
		<!-- <tr>
			
			<th style="text-align: right;">PPn 10%  Rp.</th>
			<th style="text-align: right;">{{ number_format($gtotal * 0.1) }}</th>
		</tr> -->
		<!-- <tr>
			
			<th style="text-align: right;">TOTAL    Rp. </th>
			<th style="text-align: right;">{{ number_format($gtotal * 1.1) }}</th>
		</tr> -->
		<tr>
			
			<th style="text-align: right;">DP    Rp. </th>
			<th style="text-align: right;">({{ number_format($sales->dp) }})</th>
		</tr>
		<tr>
			<th style="text-align: right;">Belum Dbyr Rp. </th>
			<th style="text-align: right;">{{ number_format( $gtotal - $sales->pembayaran) }}</th>
		</tr>
	</table>
	<div style="margin-top: 40px;"></div>
	<table width="100%">
		<tr>
			<td width="70%">Mohon ditransfer ke Rekening kami:<br>
				Bank {{$profil->bank}}<br>
				KCP {{$profil->kcp}}<br>
				No. Rekening : {{$profil->norek}}<br>
				Atas Nama : {{$profil->company_name}}

			</td>
			<td width="30%">Hormat Kami,<br>
				{{$profil->company_name}}<br>
				<span style="color: #fff">Blank<br>
					Blank<br>
					Blank<br>
					Blank</span><br>
					<u>{{$profil->owner_name}}</u>
			</td>
		</tr>
	</table>
	
	
	
</body>
</html>