<!DOCTYPE html>
<html>
<head>
	<title>GOOD RECEIPT</title>
</head>
<body>
  
	<div style="font-size: 14px;" class="title">
	<h3>{{ $profil->company_name }}</h3>
	<h2 style="margin-top:-16px;margin-bottom:-10px;">GOOD RECEIPT</h2>
	<hr>
	    <table width:"100%" >
	        <tr>
	            <td width:"20%">NO GR</td>
	           
	            <td width:"25%"><div style="margin-left:60px;">{{ $data->gr_no }}</div></td>
	            <td width:"20%"></td>
	            <td width:"25%"></td>
	        </tr>
	        <tr>
	            <td width:"25%">PO DATE</td>
	            <td width:"25%"><div style="margin-left:60px;">{{ date('d-m-Y', strtotime($data->created_at)) }}</div></td>
	            <td width:"25%"></td>
	            <td width:"25%"></td>
	        </tr>
	        <tr>
	            <td width:"25%">Supplier</td>
	            <td width:"25%"><div style="margin-left:60px;">{{ $data->supplier_name}}</div></td>
	            <td width:"25%"><div style="margin-left:30px;">Purchase Order</div></td>
	            <td width:"25%"><div style="margin-left:60px;">{{ $data->po_no }}</div></td>
	        </tr>
	       
	        <tr>
	            <td width:"25%">Contact</td>
	            <td width:"25%"><div style="margin-left:60px;">{{ $data->supplier_contact}}</div></td>
	            <td width:"25%"><div style="margin-left:30px;">Gudang Penerimaan</div></td>
	            <td width:"25%"><div style="margin-left:60px;"><?php if($data->gudang == 1) echo 'SBS'; elseif($data->gudang == 2) echo 'MDI'; ?></div></td>
	        </tr>
	        <tr>
	            <td width:"25%">Address</td>
	            <td width:"25%"><div style="margin-left:60px;">{{ $data->supplier_address}}</div></td>
	            <td width:"25%"><div style="margin-left:30px;">Phone</div></td>
	            <td width:"25%"><div style="margin-left:60px;">{{ $data->supplier_phone }}</div></td>
	        </tr>
	        <tr>
	            <td width:"25%">City</td>
	            <td width:"25%"><div style="margin-left:60px;">{{ $data->supplier_city}}</div></td>
	            <td width:"25%"><div style="margin-left:30px;">Fax</div></td>
	            <td width:"25%"><div style="margin-left:60px;">{{ $data->supplier_fax }}</div></td>
	        </tr>
	        <tr>
	            <td width:"25%">Country</td>
	            <td width:"25%"><div style="margin-left:60px;">Indonesia</div></td>
	            <td width:"25%"></td>
	            <td width:"25%"></td>
	        </tr>
	    </table>
	    
	</div>
	<div class="content" style="font-size: 13px; margin-top:12px;">
		<table width="100%" style="border-top:1 px solid black;border-collapse:collapse;" cellspacing="5" cellpadding="5" >
		    <thead>
	        <tr style="background-color:whitesmoke; color:black;">
	            <td>DESCRIPTION</td>
	            <td>QTY</td>
	            <td>UNIT</td>
	            <td>FGN PX</td>
	            <td>CCY</td>
	            <td>RATE</td>
	            <td>DISC</td>
	            <td>PX(Rp)</td>
	            <td>AMOUNT</td>
	        </tr>
	        </thead>
	        <tbody>
	           <?php
	           $totalquantity = 0;
	           $totalamount = 0;
	           
	           foreach($details as $d) { 
	           $totalquantity = $totalquantity + $d->quantity;
	           $totalamount = $totalamount + ($d->item_price * $d->quantity);
	           
	           ?>
	            <tr>
	                <td>{{ $d->material_name }}</td>
	                <td>{{ number_format($d->quantity) }}</td>
	                <td>{{ $d->item_unit }}</td>
	                <td style="text-align:right;">{{ number_format($d->item_price, 2) }}</td>
	                <td>IDR</td>
	                <td>1.00</td>
	                <td>0%</td>
	                <td style="text-align:right;">Rp. {{ number_format($d->item_price * $d->quantity, 2) }}</td>
	                <td style="text-align:right;">Rp. {{ number_format($d->item_price * $d->quantity, 2) }}</td>
	            </tr>
	            <?php  } ?>
	        </tbody>
	        <tfoot>
	            <tr>
	                <th style="border-top:1px solid black;">SUBTOTAL</th>
	                <th style="border-top:1px solid black;">{{ number_format($d->quantity, 2) }}</th>
	                <th style="border-top:1px solid black;"></th>
	                <th style="border-top:1px solid black;"></th>
	                <th style="border-top:1px solid black;"></th>
	                <th style="border-top:1px solid black;"></th>
	                <th style="border-top:1px solid black;"></th>
	                <th style="border-top:1px solid black;"></th>
	                <th style="text-align:right;border-top:1px solid black;">Rp. {{ number_format($totalamount, 2) }}</th>
	            </tr>
	            <tr>
	                <th style="text-align:right;" colspan="5"></th>
	                <th></th>
	                <th></th>
	                <th></th>
	                <th style="text-align:right;"></th>
	            </tr>
	            <tr>
	                <th style="text-align:right;" colspan="5">PPN</th>
	                <th></th>
	                <th></th>
	                <th></th>
	                <th style="text-align:right;">Rp. {{ number_format($totalamount * 0.1, 2) }}</th>
	            </tr>
	            <tr>
	                <th style="text-align:right;" colspan="5">GRAND TOTAL</th>
	                <th></th>
	                <th></th>
	                <th></th>
	                <th style="text-align:right;">Rp. {{ number_format($totalamount * 1.1, 2) }}</th>
	            </tr>
	            <tr>
	                <th style="text-align:right;" colspan="5"></th>
	                <th></th>
	                <th></th>
	                <th></th>
	                <th style="text-align:right;">Rp. {{ number_format(($totalamount * 1.1)/ $totalquantity,2) }}</th>
	            </tr>
	        </tfoot>
	    </table>
	</div>
	
	
	<div style="font-size: 13px;" class="footer">
		<p>RECEIVED BY :<span style="margin-left:180px;">APPROVED BY :</span></p>
		<p style="margin-top:60px;">...........................<span style="margin-left:190px;">.............................</span></p>
		<?php $sekarang = date('Y-m-d H:i:s'); ?>
		<small>Print Time : {{ date('d-m-Y', strtotime($sekarang)) }}  {{ date('H:i:s', strtotime($sekarang)) }}</small>
	</div>
</body>
</html>