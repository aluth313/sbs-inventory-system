<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Customer;
use Auth;

class AdminController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }



    public function index(){
        $tgl = date("Y-m-d");
        $bulan = substr($tgl, 5,2);
        // $bulan = "06";
       

        $biaya = DB::table('expenses')
                ->whereMonth('cost_date', $bulan)
                ->select(DB::raw('SUM(cost_value) as Total'))
                ->first();

        $stokbaku = DB::table('materials')
                ->select(DB::raw('SUM(stok * b_price ) as Stokbaku'))
                ->first();

        $stok = DB::table('goods')
                ->select(DB::raw('SUM(stok * b_price ) as Stok'))
                ->first();

        $purchase = DB::table('purchases')
                ->whereMonth('created_at', $bulan)
                ->where('status', 1)
                ->select(DB::raw('SUM(total) as Total'))
                ->first();
                
                
        $production = DB::table('productions')
                ->whereMonth('created_at', $bulan)
                ->where('status', 1)
                ->select(DB::raw('SUM(total) as Total'))
                ->first();

        $sales = DB::table('sales')
                ->whereMonth('created_at', $bulan)
                
                ->select(DB::raw('SUM(total) as Total'))
                ->first(); 

        $hutang = DB::table('purchases')
                ->where('sisa', '>', 0)
                ->select(DB::raw('SUM(sisa) as Sisa'))
                ->first();

        $pservice = DB::table('services')
                ->where('sisa', '>', 0)
                ->select(DB::raw('SUM(sisa) as Sisa'))
                ->first(); 

        $psales = DB::table('sales')
                ->where('sisa', '>', 0)
                ->select(DB::raw('SUM(sisa) as Sisa'))
                ->first();      


        $jan = DB::table('expenses')
                ->whereMonth('cost_date','01')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $feb = DB::table('expenses')
               
                ->whereMonth('cost_date','02')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $mar = DB::table('expenses')
               
                ->whereMonth('cost_date','03')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $apr = DB::table('expenses')
               
                ->whereMonth('cost_date','04')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $mei = DB::table('expenses')
               
                ->whereMonth('cost_date','05')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $jun = DB::table('expenses')
               
                ->whereMonth('cost_date','06')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $jul = DB::table('expenses')
               
                ->whereMonth('cost_date','07')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $agt = DB::table('expenses')
               
                ->whereMonth('cost_date','08')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $sep = DB::table('expenses')
               
                ->whereMonth('cost_date','09')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $okt = DB::table('expenses')
               
                ->whereMonth('cost_date','10')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $nov = DB::table('expenses')
               
                ->whereMonth('cost_date','11')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $des = DB::table('expenses')
               
                ->whereMonth('cost_date','12')
                ->select('cost_value')
                ->get()->sum('cost_value');



        // total service

        $ja = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','01')
                ->select('total')
                ->get()->sum('total');

        $jasal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','01')
                ->select('total')
                ->get()->sum('total');

        $fe = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','02')
                ->select('total')
                ->get()->sum('total');

        $ma = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','03')
                ->select('total')
                ->get()->sum('total');

        $ap = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','04')
                ->select('total')
                ->get()->sum('total');

        $me = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','05')
                ->select('total')
                ->get()->sum('total');

        $ju = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','06')
                ->select('total')
                ->get()->sum('total');

        $jl = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','07')
                ->select('total')
                ->get()->sum('total');

        $ag = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','08')
                ->select('total')
                ->get()->sum('total');

        $se = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','09')
                ->select('total')
                ->get()->sum('total');

        $ok = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','10')
                ->select('total')
                ->get()->sum('total');

        $no = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','11')
                ->select('total')
                ->get()->sum('total');

        $de = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','12')
                ->select('total')
                ->get()->sum('total');


        // total pembelian
        // total service

        $jax = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','01')
                ->select('total')
                ->get()->sum('total');

        $fex = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','02')
                ->select('total')
                ->get()->sum('total');

        $max = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','03')
                ->select('total')
                ->get()->sum('total');

        $apx = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','04')
                ->select('total')
                ->get()->sum('total');

        $mex = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','05')
                ->select('total')
                ->get()->sum('total');

        $jux = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','06')
                ->select('total')
                ->get()->sum('total');

        $jlx = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','07')
                ->select('total')
                ->get()->sum('total');

        $agx = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','08')
                ->select('total')
                ->get()->sum('total');

        $sex = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','09')
                ->select('total')
                ->get()->sum('total');

        $okx = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','10')
                ->select('total')
                ->get()->sum('total');

        $nox = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','11')
                ->select('total')
                ->get()->sum('total');

        $dex = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','12')
                ->select('total')
                ->get()->sum('total');


        $jasal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','01')
                ->select('total')
                ->get()->sum('total');

        $fesal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','02')
                ->select('total')
                ->get()->sum('total');

        $masal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','03')
                ->select('total')
                ->get()->sum('total');

        $apsal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','04')
                ->select('total')
                ->get()->sum('total');

        $mesal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','05')
                ->select('total')
                ->get()->sum('total');


        $junsal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','06')
                ->select('total')
                ->get()->sum('total');

        $julsal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','07')
                ->select('total')
                ->get()->sum('total');

        $agusal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','08')
                ->select('total')
                ->get()->sum('total');

        $sepsal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','09')
                ->select('total')
                ->get()->sum('total');

        $oksal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','10')
                ->select('total')
                ->get()->sum('total');

        $novsal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','11')
                ->select('total')
                ->get()->sum('total');

        $dessal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','12')
                ->select('total')
                ->get()->sum('total');




       
        $tr = DB::table('tanda_terima')
                ->join('customers', 'customers.id', 'tanda_terima.cust_id')
                ->where('status','<', 2)
                ->select('tanda_terima.*', 'customers.customer_name', 'customers.customer_address', 'customers.customer_phone', 'customers.customer_foto')
                ->orderBy('tanda_terima.created_at', 'desc')
                ->get();

                // return Auth::user();


        return view('dashboard', compact('tr', 'production', 'biaya',  'stok', 'stokbaku', 'purchase', 'sales', 'hutang', 'pservice', 'psales', 'jan','feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'okt', 'nov', 'des', 'ja','fe', 'ma', 'ap', 'me', 'ju', 'jl', 'ag', 'se', 'ok', 'no', 'de', 'jax','fex', 'max', 'apx', 'mex', 'jux', 'jlx', 'agx', 'sex', 'okx', 'nox', 'dex', 'jasal', 'fesal', 'masal', 'apsal', 'mesal', 'junsal', 'julsal', 'agusal', 'sepsal', 'oksal', 'novsal', 'dessal' ));
    }

    public function dashboard(){

        $tgl = date("Y-m-d");
        $bulan = substr($tgl, 5,2);
        // $bulan = "06";
       

        $biaya = DB::table('expenses')
                ->whereMonth('cost_date', $bulan)
                ->select(DB::raw('SUM(cost_value) as Total'))
                ->first();

        $service = DB::table('services')
                ->whereMonth('created_at', $bulan)
                
                ->select(DB::raw('SUM(total) as Total'))
                ->first();

        $stok = DB::table('goods')
                ->select(DB::raw('SUM(stok * b_price ) as Stok'))
                ->first();
                
        $stokbaku = DB::table('materials')
                ->select(DB::raw('SUM(stok * b_price ) as Stokbaku'))
                ->first();

        $purchase = DB::table('purchases')
                ->whereMonth('created_at', $bulan)
                ->where('status', 1)
                ->select(DB::raw('SUM(total) as Total'))
                ->first();

        $sales = DB::table('sales')
                ->whereMonth('created_at', $bulan)
                
                ->select(DB::raw('SUM(total) as Total'))
                ->first(); 

        $hutang = DB::table('purchases')
                ->where('sisa', '>', 0)
                ->select(DB::raw('SUM(sisa) as Sisa'))
                ->first();
                
        $production = DB::table('productions')
                ->whereMonth('created_at', $bulan)
                ->where('status', 1)
                ->select(DB::raw('SUM(total) as Total'))
                ->first();

        $pservice = DB::table('services')
                ->where('sisa', '>', 0)
                ->select(DB::raw('SUM(sisa) as Sisa'))
                ->first(); 

        $psales = DB::table('sales')
                ->where('sisa', '>', 0)
                ->select(DB::raw('SUM(sisa) as Sisa'))
                ->first();      


        $jan = DB::table('expenses')
                ->whereMonth('cost_date','01')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $feb = DB::table('expenses')
               
                ->whereMonth('cost_date','02')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $mar = DB::table('expenses')
               
                ->whereMonth('cost_date','03')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $apr = DB::table('expenses')
               
                ->whereMonth('cost_date','04')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $mei = DB::table('expenses')
               
                ->whereMonth('cost_date','05')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $jun = DB::table('expenses')
               
                ->whereMonth('cost_date','06')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $jul = DB::table('expenses')
               
                ->whereMonth('cost_date','07')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $agt = DB::table('expenses')
               
                ->whereMonth('cost_date','08')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $sep = DB::table('expenses')
               
                ->whereMonth('cost_date','09')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $okt = DB::table('expenses')
               
                ->whereMonth('cost_date','10')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $nov = DB::table('expenses')
               
                ->whereMonth('cost_date','11')
                ->select('cost_value')
                ->get()->sum('cost_value');

        $des = DB::table('expenses')
               
                ->whereMonth('cost_date','12')
                ->select('cost_value')
                ->get()->sum('cost_value');



        // total service

        $ja = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','01')
                ->select('total')
                ->get()->sum('total');

        $jasal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','01')
                ->select('total')
                ->get()->sum('total');

        $fe = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','02')
                ->select('total')
                ->get()->sum('total');

        $ma = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','03')
                ->select('total')
                ->get()->sum('total');

        $ap = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','04')
                ->select('total')
                ->get()->sum('total');

        $me = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','05')
                ->select('total')
                ->get()->sum('total');

        $ju = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','06')
                ->select('total')
                ->get()->sum('total');

        $jl = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','07')
                ->select('total')
                ->get()->sum('total');

        $ag = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','08')
                ->select('total')
                ->get()->sum('total');

        $se = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','09')
                ->select('total')
                ->get()->sum('total');

        $ok = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','10')
                ->select('total')
                ->get()->sum('total');

        $no = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','11')
                ->select('total')
                ->get()->sum('total');

        $de = DB::table('services')
                ->where('status', 1)
                ->whereMonth('created_at','12')
                ->select('total')
                ->get()->sum('total');


        // total pembelian
        // total service

        $jax = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','01')
                ->select('total')
                ->get()->sum('total');

        $fex = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','02')
                ->select('total')
                ->get()->sum('total');

        $max = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','03')
                ->select('total')
                ->get()->sum('total');

        $apx = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','04')
                ->select('total')
                ->get()->sum('total');

        $mex = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','05')
                ->select('total')
                ->get()->sum('total');

        $jux = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','06')
                ->select('total')
                ->get()->sum('total');

        $jlx = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','07')
                ->select('total')
                ->get()->sum('total');

        $agx = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','08')
                ->select('total')
                ->get()->sum('total');

        $sex = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','09')
                ->select('total')
                ->get()->sum('total');

        $okx = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','10')
                ->select('total')
                ->get()->sum('total');

        $nox = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','11')
                ->select('total')
                ->get()->sum('total');

        $dex = DB::table('purchases')
                ->where('status', 1)
                ->whereMonth('created_at','12')
                ->select('total')
                ->get()->sum('total');


        $jasal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','01')
                ->select('total')
                ->get()->sum('total');

        $fesal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','02')
                ->select('total')
                ->get()->sum('total');

        $masal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','03')
                ->select('total')
                ->get()->sum('total');

        $apsal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','04')
                ->select('total')
                ->get()->sum('total');

        $mesal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','05')
                ->select('total')
                ->get()->sum('total');


        $junsal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','06')
                ->select('total')
                ->get()->sum('total');

        $julsal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','07')
                ->select('total')
                ->get()->sum('total');

        $agusal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','08')
                ->select('total')
                ->get()->sum('total');

        $sepsal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','09')
                ->select('total')
                ->get()->sum('total');

        $oksal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','10')
                ->select('total')
                ->get()->sum('total');

        $novsal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','11')
                ->select('total')
                ->get()->sum('total');

        $dessal = DB::table('sales')
                ->where('status', 1)
                ->whereMonth('created_at','12')
                ->select('total')
                ->get()->sum('total');


        $tr = DB::table('tanda_terima')
                ->join('customers', 'customers.id', 'tanda_terima.cust_id')
                ->where('status','<', 2)
                ->select('tanda_terima.*', 'customers.customer_name', 'customers.customer_address', 'customers.customer_phone', 'customers.customer_foto')
                ->orderBy('tanda_terima.created_at', 'desc')
                ->get();

        return view('dashboard', compact('tr', 'production' ,'biaya', 'service', 'stok','stokbaku', 'purchase', 'sales', 'hutang', 'pservice', 'psales', 'jan','feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'okt', 'nov', 'des', 'ja','fe', 'ma', 'ap', 'me', 'ju', 'jl', 'ag', 'se', 'ok', 'no', 'de', 'jax','fex', 'max', 'apx', 'mex', 'jux', 'jlx', 'agx', 'sex', 'okx', 'nox', 'dex', 'jasal', 'fesal', 'masal', 'apsal', 'mesal', 'junsal', 'julsal', 'agusal', 'sepsal', 'oksal', 'novsal', 'dessal' ));
    }

    public function teknisi(){
        return view('teknisi');
    }
}
