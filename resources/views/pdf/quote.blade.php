<!DOCTYPE html>
<html>
<head>
	<title>Quotation</title>
	<style type="text/css">
		body{
			font-family: sans-serif;
		}

		footer{
			position: absolute;
			bottom: 0;
		}

		.table-data, .table-content{
		    color: #232323;
		    border-collapse: collapse;
		}
 
		.table-data th, .table-content th{
		    border: 1px solid #999;
		    padding: 4px 10px;
		}



		.table-data td, .table-content td {

		    border-left: 1px solid #999;
		    border-right: 1px solid #999;
		    padding: 4px 10px;
		}

		.atas{
			border-top: 1px solid #999;
		}

		.bawah{
			border-bottom: 1px solid #999;
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
			<td></td>
		</tr>
		<tr>
			<td width="30%"><p style="margin-top:-20px;font-size: 13px; ">{{$profil->company_title}}</p>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: center;"><h2>QUOTATION</h2></td>
		</tr>
	</table>

	<table class="table-data" width="100%"> 
		<tr>
			<td class="atas" width="20%">TO</td>
			<td class="atas" width="1%">:</td>
			<td class="atas" width="29%">{{$q->customer_name}}</td>
			<td class="atas" width="20%">DATE</td>
			<td class="atas" width="1%">:</td>
			<td class="atas" width="29%">{{date("d-m-Y", strtotime($q->created_at))}} </td>
		</tr>
		<tr>
			<td>ATTN</td>
			<td>:</td>
			<td>{{$q->attn}}</td>
			<td>OUR REF</td>
			<td>:</td>
			<td>{{$q->ref}} </td>
		</tr>
		<tr>
			<td>EMAIL/FAX</td>
			<td>:</td>
			<td>{{$q->email}}/{{$q->fax}}</td>
			<td>PAGES</td>
			<td>:</td>
			<td></td>
		</tr>
		<tr>
			<td class="bawah">FROM</td>
			<td class="bawah">:</td>
			<td class="bawah">{{$q->dari}}</td>
			<td class="bawah">YOUR REF</td>
			<td class="bawah">:</td>
			<td class="bawah">{{$q->ref2}}</td>
		</tr>
		
	</table>
	<p>
		Dear Sir, <br>
		We are pleased to quote you as follows :
	</p>

	<table class="table-content" width="100%">
		<thead>
			<tr>
				<th>No.</th>
				<th>Description</th>
				<th>Qty</th>
				<th>Unit Price</th>
				<th>Total Price</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$no = 0;
				$total = 0;
				foreach($item as $key => $value){
				$no++;
				$total = $total + $value->total;
			?>
			<tr>
				<td style="text-align: center;">{{$no}}</td>
				<td>{{$value->description}}</td>
				<td style="text-align: right;">{{$value->quantity}} {{$value->uom}}</td>
				<td style="text-align: right;">{{number_format($value->price)}}</td>
				<td style="text-align: right;">{{number_format($value->total)}}</td>
			</tr>
			<?php }?>
		</tbody>
		<tfoot>
			<tr>
				<th></th>
				<th colspan="3" style="text-align: right;">Total</th>
				<th style="text-align: right;">{{number_format($total)}}</th>
			</tr>
			<tr>
				<th></th>
				<th colspan="3" style="text-align: right;">PPN 10%</th>
				<th style="text-align: right;">{{number_format($total * 0.1)}}</th>
			</tr>
			<tr>
				<th></th>
				<th colspan="3" style="text-align: right;">Grand Total</th>
				<th style="text-align: right;">{{number_format($total * 1.1)}}</th>
			</tr>
		</tfoot>
	</table>
	<p>
		If you have any question concerning this quotation Contact Name, Phone Number , Email.
	</p>
	<p>Thank You</p>
	<p style="margin-top: 60px">{{$q->dari}}</p>

<center><footer>
	<h2 style="color: green">{{$profil->company_title}}</h2>
	<p style="font-size: 12px;margin-top: -20px;">{{$profil->company_address}}
		<br>Telp : {{$profil->owner_phone}} Fax : {{$profil->fax}}
		<br>Email : {{$profil->email}}
	</p>
</footer></center>
	
	
</body>
</html>