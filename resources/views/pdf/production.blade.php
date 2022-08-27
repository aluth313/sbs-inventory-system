<!DOCTYPE html>
<html>
<head>
	<title>Nota Pembelian</title>
</head>
<body>
	<div style="text-align: center;font-size: 14px;" class="title">
	<h3>{{ $profil->company_name }}</h3>
	<p style="margin-top: -20px;">{{ $profil->company_address }}<br>
		NOTA PRODUKSI <br>
		No. {{ $purchase->production_number }}
	</p>
	<hr>
	</div>
	<div class="content" style="font-size: 13px;">
		<table>
			<tr>
				<td>Tanggal</td>
				<td>:</td>
				<td>{{ date("d-m-Y H:i:s", strtotime($purchase->created_at)) }}</td>
			</tr>
			<tr>
				<td>Keterangan</td>
				<td>:</td>
				<td>{{ $purchase->description }}</td>
			</tr>	

		</table>
		<hr style="border-style:dotted;">
		<table style="width: 100%">
			<tr>
				<td>ID Brg</td>
				<td>Nama Barang</td>
				<td>Satuan</td>
				<td style="text-align: right;">Jumlah</td>
				<td style="text-align: right;">Harga</td>
				<td style="text-align: right;">Total</td>
			</tr>

			<tr>
				<td colspan="6"><hr style="border-style:dotted;"></td>
			</tr>
			@foreach($details as $key)
			<tr>
				<td>{{ $key->item_cd }}</td>
				<td>{{ $key->good_name }}</td>
				<td>{{ $key->item_unit }}</td>
				<td style="text-align: right;">{{ number_format($key->quantity) }}</td>
				<td style="text-align: right;">{{ number_format($key->item_price) }}</td>
				<td style="text-align: right;">{{ number_format($key->item_total) }}</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="6"><hr style="border-style:dotted;"></td>
			</tr>
			<tr>
				<td colspan="5" style="text-align: right;">Total Produksi</td>
				<td style="text-align: right;"><b>{{ number_format($purchase->total) }}</b></td>
			</tr>
			<tr>
				<td colspan="6"><hr style="border-style:dotted;"></td>
			</tr>
		</table>
		
		
		<table>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>LIST MATERIAL KELUAR</td>
				<td></td>
				<td></td>
			</tr>	

		</table>
		<hr style="border-style:dotted;">
		<table style="width: 100%">
			<tr>
				<td>ID Material</td>
				<td>Nama Material</td>
				<td>Satuan</td>
				<td style="text-align: right;">Jumlah</td>
				<td style="text-align: right;"></td>
				<td style="text-align: right;"></td>
			</tr>

			<tr>
				<td colspan="6"><hr style="border-style:dotted;"></td>
			</tr>
			<?php
			$totalmaterial = 0;
			foreach($material as $i => $k) {
			$totalmaterial = $totalmaterial + $k->qty_material;
			?>
			<tr>
				<td>{{ $k->idmaterial }}</td>
				<td>{{ $k->material_name }} - [ {{ $k->good_name }} ]</td>
				<td>{{ $k->unit }}</td>
				<td style="text-align: right;">{{ number_format($k->qty_material,2) }}</td>
				
			</tr>
		    <?php
		    if(@$material[$i+1]->idmaterial != $k->idmaterial)
		    {
		        echo '<tr><th></th><th></th><th>Total '.$k->material_name.'</th><th style="text-align:right";>'.number_format($totalmaterial,2).'</th></tr>';
		        $totalmaterial = 0;
		        
		    }
		    
		    }?>
			<tr>
				<td colspan="6"><hr style="border-style:dotted;"></td>
			</tr>
			
			<tr>
				<td colspan="6"><hr style="border-style:dotted;"></td>
			</tr>
		</table>
		
		
	</div>
	<div style="font-size: 13px;" class="footer">
		<p>Dibuat Oleh : ...................................................................... <span style="margin-left:40px;">Diketahui Oleh : ......................................................................</span></p>
		<p>Print Time : {{ date("Y-m-d H:i:s") }}</p>
	</div>
</body>
</html>