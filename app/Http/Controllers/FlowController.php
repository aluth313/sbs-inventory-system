<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use App\Profil;

class FlowController extends Controller
{
    	
	public function index()
	{
		return view('laporan.lap_flow');	
	}


	public function cetakFlow($dari, $sampai, $dokumen=null)
	{
		  $smp = date('Y-m-d', strtotime('+1 days', strtotime($sampai))); 
	      $dasar = '2010-01-01';
	      $awl = date('Y-m-d', strtotime('-1 days', strtotime($dari)));

	      $stok_lama = DB::table('cash_flows')
	              ->whereBetween('created_at', [$dasar, $awl])  
	              ->select(DB::raw('sum(cash_flows.incash - cash_flows.outcash) as Saldo'), DB::raw('sum(cash_flows.incash) as Ing'), DB::raw('sum(cash_flows.outcash) as Outg'))
	              ->first();

	      $profil = Profil::all()->first();
	      
	      $stock = DB::table('cash_flows')
	            ->whereBetween('created_at', [$dari, $smp])
	            ->orderBy('created_at', 'asc')
	            ->get();
	      

	      $pdf = PDF::loadView('pdf.flow', compact('profil', 'stock', 'stok_lama'));
	      $pdf->setPaper('letter', 'potrait');

	      return $pdf->stream();

	}
    
}
