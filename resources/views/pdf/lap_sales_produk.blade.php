<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./public/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<title>Laporan Penjualan Per Produk</title>
</head>
<body>

	<h4 style="margin-top: -30px;">{{ $profil->company_name }}</h4>
	<p style="margin-top: -20px">{{$profil->company_address}}<br>{{$profil->owner_phone}}</p>
	<div class="title"><center> 
		<h3>Laporan Penjualan Per Produk</h3>
		<p style="font-size: 14px;margin-top: -10px" >Periode : {{ date("d-m-Y", strtotime($dari)) }} s.d {{ date("d-m-Y", strtotime($sampai)) }}</p></center>
	</div>

	<table border="1" width="100%" cellpadding="4" cellspacing="4" style="border-collapse: collapse; font-size: 12px;">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Barang</th>
				<th>Kategori</th>
				<th>Satuan</th>
				<th>Jumlah</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			    $no = 0;
			    $grand_total = 0; 
			    $item_total = 0;
			    foreach ($sales as $x => $key) { 
			    $no++ ;
			    $item_total = $item_total + $key->ITEM_JUAL + $key->ITEM_JUAL_SERVICE;
			    $grand_total = $grand_total + $key->TOTAL_JUAL + $key->TOTAL_JUAL_SERVICE;
			    
			?>
				<tr>
					<td>{{$no}}</td>
					<td>[ {{$key->id}} ] {{$key->good_name}}</td>
					<td>{{$key->category_name}}</td>
					<td>{{$key->unit}}</td>
					<td style="text-align: right;">{{number_format($key->ITEM_JUAL + $key->ITEM_JUAL_SERVICE)}}</td>
					<td style="text-align:right;">{{number_format($key->TOTAL_JUAL + $key->TOTAL_JUAL_SERVICE)}}</td>
				</tr>

				<?php
				// if (@$sales[$x+1]->cust_id != $key->cust_id) {
	                
	   //              echo '<tr class="subtotal">
	   //                      <th colspan="6" style="text-align:right;">SubTotal '.$key->customer_name.'</th>
	   //                      <th style="text-align:right;" class="right">'.number_format($subtotal).'</th>
	   //                    </tr>';
	   //              $subtotal = 0;
    //         	}
		
			}?>
			<tr>
				<th style="text-align: right;" colspan="4">TOTAL PENJUALAN</th>
				<th style="text-align:right;">{{$item_total}}</th>
				<th style="text-align:right;">{{number_format($grand_total)}}</th>
			</tr>
			
		</tbody>
	</table>

	

</body>
</html>