<!DOCTYPE html>
<html>
<head>
	<title>JOB ORDER </title>
</head>
<body style>
	<div style="font-size: 14px;margin-top:-40px;" class="title">
	<h3>{{ $profil->company_name }}</h3>
	<p style="margin-top: -10px;">
		<strong><span style="font-size:20px;">JOB ORDER</span></strong> <br>
		No.{{ $item->production_number }} 
	</p>
	<hr>
	</div>
	<div class="content" style="font-size: 13px;">
		<table style="width:100%;">
			<tr>
				
				<td>PRODUCT:</td>
				<td style="width:20%"><strong>{{ $good->good_name }}</strong></td>
				<td></td>
				<td>DATE</td>
				<td>{{ date('d-m-Y') }}</td>
				
				<td></td>
			</tr>
			<tr>
				<td>CUSTOMER</td>
				<td>{{ $cust->customer_name }}</td>
				<td></td>
				<td>ORDER DATE</td>
				<td>{{ date('d-m-Y', strtotime($prod->created_at)) }}</td>
				<td>LINE:...</td>
			</tr>
			<tr>
				<td>CO NUMBER</td>
				<td>{{ $cust->id }}</td>
				<td></td>
				<td>QTY ORDER</td>
				<td>{{ $det->quantity }} {{ $det->item_unit }}</td>
				<td></td>
			</tr>
			<tr>
				<td>GRADE</td>
				<td>{{ $prod->grade }}</td>
				<td></td>
				<td>BATCH</td>
				<td>{{ floor($det->quantity /100) }} ({{ $item->quantity }} {{ $item->item_unit }})</td>
				<td></td>
			</tr>
			<tr>
				<td>COLOUR</td>
				<td>{{ $prod->colour }}</td>
				<td></td>
				<td>LOT NUMBER</td>
				<td>..................................</td>
				<td></td>
			</tr>
			<tr>
				<td>HARDNESS</td>
				<td>{{ $prod->hardness }}</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>Hp....................</td>
				<td>MFI...................</td>
				<td>Hp Disetel ...........</td>
				<td></td>
			</tr>
			
		</table>
		<table cellspacing="1" cellpadding="3" border="1 solid black" style="width:100%;border-collapse:collapse;">
			<tr>
				<th>No</th>
				<th>RAW MATERIAL</th>
				<th>Qty/Kg</th>
				<th>ADJUST 1</th>
				<th>KG</th>
				<th>GRAM</th>
				<th>ADJUST</th>
				<th>TOTAL HASIL PRODUKSI</th>
			</tr>
			<?php 
			$qty = 0;
			$tot = 0;
			$totalqa = 0;
			foreach($mat as $i => $m) {
			    $nilai = $m->qty_material * 100;
			    $qty = $qty + $m->qty_material;
			    $tot = $tot + $nilai;
			    
			    $qa = DB::table('material_adjustment')
			        ->select('qty_adjust')
			        ->where('id_material', $m->idmaterial)
			        ->where('idbatch', $id)
			        ->first();
			   
			   if(! empty($qa))
			   {
			        $add = $qa->qty_adjust;
			   }
			   else
			   {
			        $add = 0;   
			   }
			   
			   $totalqa = $totalqa + $add;  
			          
			    
			    
			
			?>
			<tr>
				<td>{{ $i + 1 }}</td>
				<td>{{ $m->material_name }}</td>
				<td style="text-align:right;">{{ number_format($nilai, 2) }} </td>
				<td style="text-align:right;"></td>
				<td style="text-align:right;"></td>
				
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<?php } ?>
			
			<?php
				$used = DB::table('materialused')
				->join('materials', 'materials.id', '=', 'materialused.id_material')
				->where('materialused.production_number', $item->production_number)
				->where('materials.kategori', '=', 76)
				->get();

				foreach ($used as $key) {
					$out = $key->qty_material * $tot /100000;
					$stok = DB::table('materials')
						->select('stok')
						->where('id', $key->id_material)
						->first();
					$stokawal = $stok->stok;

					DB::table('materials')->where('id', $key->id_material)
						->update(['stok'=> $stokawal - $out]);



				}

			?>

			<tr>
				<td></td>
				<td><strong>TOTAL</strong></td>
				<td style="text-align:right;"><strong>{{ number_format($tot,2) }}</strong></td>
				<td style="text-align:right;"><strong></strong></td>
				<td style="text-align:right;"><strong></strong></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<th style="height:3%" colspan="8">TEST PROPERTIES: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TS : ...................EL : ...................AB : ...................BJ : ...................</th>
				
			</tr>
			
			<tr>
				<th>No</th>
				<th>COLOURING</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<td></td>
				<th>TOTAL</th>
			</tr>
			<?php 
			$qty = 0.0000;
			$totc = 0.0000;
			$totalqa = 0.0000;
			$adtot = 0.0000;
			$totalkali = 0;
			$totalhasil = 0;
			foreach($col as $i => $m) {
			    $nilai = $m->qty_material;
			    $qty = $qty + $m->qty_material;
			    $totc = $totc + $nilai;
			    
			    $qa = DB::table('material_adjustment')
			        ->select('*')
			        ->where('id_material', $m->idmaterial)
			        ->where('idbatch', $id)
			        ->first();
			        
			    if(! empty($qa))
			    {
			        
			        $persen = number_format($qa->persen, 2).'%';
			        $add = $nilai * $qa->persen / 100;
			    }
			    else
			    {
			        
			        $persen = '';
			        $add = 0; 
			    }
			    
			    
			   
			    $totalqa = $totalqa + $add;
			    $addnil = $nilai + $add;
			    
			    $adtot = $adtot + $addnil;
			    $ps = $adtot * 1000;
			    
			    $kali = $nilai * $tot;
			    $totalkali = $totalkali + $kali;
			    
			    
			    $hasil = $add * $tot;
			    
			    $totalhasil = $totalhasil + $hasil;
			    
			    
			   
			        
			    
			
			?>
			<tr>
				<td>{{ $i + 1 }}</td>
				<td>{{ $m->material_name }}</td>
				<td style="text-align:right;">{{ number_format($nilai, 4) }} </td>
				<td style="text-align:right;">{{ number_format($kali,4) }}</td>
				<td style="text-align:right;">{{ $persen }}</td>
				
				<td style="text-align:right;">{{ number_format($add, 4) }}</td>
				
				<td style="text-align:right;">{{ number_format($hasil, 4) }}</td>
				<td></td>
				
			</tr>
			<?php } ?>
			
			<tr>
				<td></td>
				<td><strong>TOTAL</strong></td>
				<td style="text-align:right;"><strong>{{ number_format($totc, 4) }}</strong></td>
				<td style="text-align:right;"><strong>{{ number_format($totalkali,4) }}</strong></td>
				<td></td>
				<td style="text-align:right;"><strong>{{ number_format($totalqa, 4) }}</strong></td>
			    <td style="text-align:right;"><strong>{{ number_format($totalhasil, 4) }}</strong></td>
				<td></td>
				
			</tr>
			<tr>
				<?php $gtotal = $totalkali / 1000; ?>
				<td></td>
				<td><strong>GRAND TOTAL</strong></td>
				<td style="text-align:right;"><strong>{{ number_format(($tot + $gtotal), 4) }}</strong></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				
			</tr>
			<tr>
				<th style="height:3%" colspan="8">HASIL PRODUKSI: ............................... UNTUK DI INJECT: ................................</th>
				
			</tr>
		</table>	
		
		
		
		
	</div>
	<div style="font-size: 13px;" class="footer">
		<p>Approved By :  <span style="margin-left:260px;">Received By :</span></p> <p style="margin-top:70px;">......................................................................  <span style = "margin-left:100px;">......................................................................</span></p>
		<small>Print Time : {{ date("d-M-Y H:i:s") }}</small>
	</div>
</body>
</html>