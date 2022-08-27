<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./public/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<title>Laporan Penjualan</title>
</head>
<body>

	<h4 style="margin-top: -30px;">{{ $profil->company_name }}</h4>
	<p style="margin-top: -20px">{{$profil->company_address}}<br>{{$profil->owner_phone}}</p>
	<div class="title"><center> 
		<h3>Laporan Penjualan Per Customer</h3>
		<p style="font-size: 14px;margin-top: -10px" >Periode : {{ date("d-m-Y", strtotime($dari)) }} s.d {{ date("d-m-Y", strtotime($sampai)) }}</p></center>
	</div>

	<table border="1" width="100%" cellpadding="4" cellspacing="4" style="border-collapse: collapse; font-size: 12px;">
		<thead>
			<tr>
				<th>No</th>
				<th>Tgl</th>
				<th>Invoice</th>
				<th>Pelanggan</th>
				<th>Kasir</th>
				<th>Note</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			    $no = 0; 
			    $grandTotal = 0;
			    $subtotal = 0;
			    foreach ($sales as $x => $key) { 
			    $no++ ;
			    $grandTotal = $grandTotal + $key->total;
			    $subtotal = $subtotal + $key->total;
			?>
				<tr>
					<td>{{$no}}</td>
					<td>{{$key->created_at}}</td>
					<td>{{$key->invoice}}</td>
					<td>{{$key->customer_name}}</td>
					<td>{{$key->name}}</td>
					<td>{{$key->note}}</td>
					<td style="text-align:right;">{{number_format($key->total)}}</td>
				</tr>

				<?php
				if (@$sales[$x+1]->cust_id != $key->cust_id) {
	                
	                echo '<tr class="subtotal">
	                        <th colspan="6" style="text-align:right;">SubTotal '.$key->customer_name.'</th>
	                        <th style="text-align:right;" class="right">'.number_format($subtotal).'</th>
	                      </tr>';
	                $subtotal = 0;
            	}
		
			}?>
			<tr>
				<th style="text-align: right;" colspan="6">TOTAL PENJUALAN</th>
				<th style="text-align:right;">{{number_format($grandTotal)}}</th>
			</tr>
			
		</tbody>
	</table>

	

</body>
</html>