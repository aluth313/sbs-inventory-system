<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use App\Purchase;
use App\Profil;
use App\Good;
use App\Customer;
use App\Teknisi;
use App\CashFlow;
use App\Category;

class LaporanServiceController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

    	return view('laporan.service');

    }

    public function servPDF($dari, $sampai)
    {
    	
    	$tgl = date('Y-m-d', strtotime('+1 days', strtotime($sampai)));
    	
    	$service = DB::table('services')
                   ->join('customers', 'customers.id', '=', 'services.cust_id')
                   ->join('teknisi', 'teknisi.id', '=', 'services.tech_id')
                   ->whereBetween('services.created_at', [$dari, $tgl])
                   ->select('services.*', 'customers.customer_name', 'teknisi.nama', 
               		   DB::raw("(SELECT item_name FROM tanda_terima WHERE ttno = services.ttno LIMIT 1)as ITEM"))
                   ->orderBy('services.id','asc')
                   ->get();

      $profil = Profil::all()->first();
      $total = DB::table('services')
              ->whereBetween('created_at', [$dari, $tgl])
              ->select(DB::raw('sum(total) as Total'))
              ->get()->first();

    	$pdf = PDF::loadView('pdf.lap_service', compact('service', 'dari', 'sampai', 'profil', 'total'));
    	$pdf->setPaper('letter', 'landscape');

    	return $pdf->stream();

    	// return view('pdf.lap_service');
    }

    public function expense(){

      return view('laporan.expense');

    }

    public function expPDF($dari, $sampai){
      
      $tgl = date('Y-m-d', strtotime('+1 days', strtotime($sampai)));
      
      $expense = DB::table('expenses')
                   ->join('costs', 'costs.id', '=', 'expenses.cost_id')
                   ->whereBetween('expenses.cost_date', [$dari, $tgl])
                   ->select('expenses.*', 'costs.cost_name')
                   ->orderBy('expenses.cost_date','desc')
                   ->get();

      $total_expense = DB::table('expenses')
                        ->select(DB::raw('sum(cost_value) as Total'))
                        ->whereBetween('cost_date', [$dari, $tgl])
                        ->first();

      $pdf = PDF::loadView('pdf.lap_expense', compact('expense', 'dari', 'sampai', 'total_expense'));
      $pdf->setPaper('a4', 'potrait');

      return $pdf->stream();

      // return view('pdf.lap_service');
    }

    public function purchase(){

      return view('laporan.purchase');

    }

    public function purPDF($dari, $sampai){
      
      $tgl = date('Y-m-d', strtotime('+1 days', strtotime($sampai)));
      $purchase = DB::table('purchases')
                ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
                ->join('purchase_details', 'purchase_details.invoice', '=', 'purchases.invoice')
                ->join('materials', 'materials.id', '=','purchase_details.item_cd')
                ->whereBetween('purchases.created_at', [$dari, $tgl])
                ->select('purchases.*', 'suppliers.supplier_name', 'purchase_details.quantity', 'purchase_details.item_unit','purchase_details.item_price','purchase_details.item_total', 'materials.material_name')
                ->orderBy('purchases.invoice')
                ->get();
      $total = DB::table('purchases')
              ->whereBetween('created_at', [$dari, $tgl])
              ->select(DB::raw('sum(total) as Total'))
              ->get()->first();
      $profil = Profil::all()->first();
      

      $pdf = PDF::loadView('pdf.lap_purchase', compact('dari', 'sampai', 'purchase', 'profil', 'total'));
      $pdf->setPaper('letter', 'landscape');

      return $pdf->stream();

      // return view('pdf.lap_service');
    }


    public function stok(){
      $kategori = Category::all();
      return view('laporan.stok', compact('kategori'));
    }
    
    public function stokbaku(){
      $kategori = Category::all();
      return view('laporan.stokbaku', compact('kategori'));
    }



    public function stokPDF($kategori=null){
      
      $profil = Profil::all()->first();

      if($kategori !=null){

          $good = DB::table('goods')
            ->join('categories', 'categories.id', '=', 'goods.kategori')
            ->where('goods.kategori', $kategori)
            ->select('goods.*', 'categories.category_name')
            ->get();

      }else{

          $good = DB::table('goods')
            ->join('categories', 'categories.id', '=', 'goods.kategori')
            ->select('goods.*', 'categories.category_name')
            ->get();
      
      }

      $pdf = PDF::loadView('pdf.lap_stok', compact('profil', 'good'));
      $pdf->setPaper('letter', 'potrait');

      return $pdf->stream();

      // return view('pdf.lap_service');
    }
    
    
    
    
    public function stokbakuPDF($kategori=null){
      
      $profil = Profil::all()->first();

      if($kategori !=null){

          $good = DB::table('materials')
            ->join('categories', 'categories.id', '=', 'materials.kategori')
            ->where('materials.kategori', $kategori)
            ->select('materials.*', 'categories.category_name')
            ->get();

      }else{

          $good = DB::table('materials')
            ->join('categories', 'categories.id', '=', 'materials.kategori')
            ->select('materials.*', 'categories.category_name')
            ->get();
      
      }

      $pdf = PDF::loadView('pdf.lap_stokbaku', compact('profil', 'good'));
      $pdf->setPaper('letter', 'potrait');

      return $pdf->stream();

      // return view('pdf.lap_service');
    }
    
    


    public function laphistok(){
      $good = Good::all();
      return view('laporan.histok', compact('good'));
    }


    public function hisPDF($id, $dari, $sampai){

      $smp = date('Y-m-d', strtotime('+1 days', strtotime($sampai))); 
      $dasar = '2010-01-01';
      $awl = date('Y-m-d', strtotime('-1 days', strtotime($dari)));

      $stok_lama = DB::table('stocks')
              ->whereBetween('created_at', [$dasar, $awl])  
              ->select(DB::raw('sum(stocks.in - stocks.out) as Saldo'), DB::raw('sum(stocks.in) as Ing'), DB::raw('sum(stocks.out) as Outg'))
              ->first();

     
      $total = DB::table('goods')
              ->select(DB::raw('sum(b_price * stok) as Total'))
              ->get()->first();

      $profil = Profil::all()->first();
      $stock = DB::table('stocks')
            ->join('goods', 'goods.id', '=', 'stocks.id_good')
            ->where('id_good', $id)
            ->whereBetween('stocks.created_at', [$dari, $smp])
            ->select('stocks.*', 'goods.good_name', 'goods.unit')
            ->orderBy('stocks.created_at', 'asc')
            ->get();
      

      $pdf = PDF::loadView('pdf.his_stok', compact('profil', 'stock', 'stok_lama'));
      $pdf->setPaper('letter', 'potrait');

      return $pdf->stream();

      // return view('pdf.lap_service');
    }



    public function salesReport()
    {
        
        $customer = Customer::all();
        return view('laporan.sales', compact('customer'));
    }


    public function salesReportCetak($dari, $sampai, $pelanggan = null)
    {
        $tgl = date('Y-m-d', strtotime('+1 days', strtotime($sampai)));
      
        if($pelanggan != null || $pelanggan !='')
        {
            $sales = DB::table('sales')
                     ->join('customers', 'customers.id', '=', 'sales.cust_id')
                     ->join('users', 'users.id', '=', 'sales.user_id')
                     ->whereBetween('sales.created_at', [$dari, $tgl])
                     ->where('sales.cust_id', $pelanggan)
                     ->select('sales.*', 'customers.customer_name', 'users.name')
                     ->orderBy('sales.id','asc')
                     ->get();
        }
        else
        {
            $sales = DB::table('sales')
                     ->join('customers', 'customers.id', '=', 'sales.cust_id')
                     ->join('users', 'users.id', '=', 'sales.user_id')
                     ->whereBetween('sales.created_at', [$dari, $tgl])
                     ->select('sales.*', 'customers.customer_name', 'users.name')
                     ->orderBy('sales.id','asc')
                     ->get(); 
        }

        $profil = Profil::all()->first();
        

        $pdf = PDF::loadView('pdf.lap_sales', compact('sales', 'dari', 'sampai', 'profil'));
        $pdf->setPaper('letter', 'landscape');

        return $pdf->stream();
    }



    public function ploss(){

      return view('laporan.ploss');
    
    }


    public function plossPDF($periode){

      $sekarang = date("Y-m-d");
      $tahun = substr($sekarang,0,4);

      $awal = $tahun.'-'.$periode.'-01';
      $akhir = $tahun.'-'.$periode.'-31';

      // var_dump($akhir);
      // exit();

      $profil = Profil::all()->first();
      $service = DB::table('service_item_good')
                      ->select(DB::raw('sum(total) as Service'))
                      ->whereMonth('created_at', $periode)
                      ->get()->first();

      $sales = DB::table('sales_item')
                      ->select(DB::raw('sum(total) as Sales'))
                      ->whereMonth('created_at', $periode)
                      ->get()->first();

      $cost = DB::table('costs')
                ->select('*',
                  DB::raw("(SELECT SUM(cost_value) FROM expenses WHERE cost_id = costs.id AND (cost_date BETWEEN '$awal' AND '$akhir')) as TOTAL"))
                ->get();

      $hpp = DB::table('service_item_good')
                ->join('goods', 'goods.id', '=', 'service_item_good.item_cd')
                ->select(DB::raw('sum(goods.b_price * service_item_good.quantity) as Hpp'))
                ->whereMonth('service_item_good.created_at', $periode)
                ->where('service_item_good.kategori', 2)
                ->get()->first();

      $hpps = DB::table('sales_item')
                ->join('goods', 'goods.id', '=', 'sales_item.item_cd')
                ->select(DB::raw('sum(goods.b_price * sales_item.quantity) as Hpp2'))
                ->whereMonth('sales_item.created_at', $periode)
                ->where('sales_item.kategori', 2)
                ->get()->first();

      $pdf = PDF::loadView('pdf.lap_ploss', compact('periode', 'profil', 'service', 'cost', 'hpp', 'sales', 'hpps'));
      $pdf->setPaper('a4', 'potrait');

      return $pdf->stream();
    }


    public function salesProduk()
    {
        $good = Good::all();
        return view('laporan.sales_produk', compact('good'));   
    }



    public function cetakSalesProduk($dari, $sampai, $barang = null)
    {
        $tgl = date('Y-m-d', strtotime('+1 days', strtotime($sampai)));
        $profil = Profil::all()->first();

        if($barang == null || $barang == '')
        {
            $sales = DB::table('goods')
                 ->join('categories', 'categories.id', '=', 'goods.kategori')
                 ->select('goods.*', 'categories.category_name',
                  DB::raw("(SELECT SUM(quantity) FROM sales_item WHERE item_cd = goods.id AND created_at BETWEEN '$dari' AND '$tgl')AS ITEM_JUAL"),
                  DB::raw("(SELECT SUM(total) FROM sales_item WHERE item_cd = goods.id AND created_at BETWEEN '$dari' AND '$tgl')AS TOTAL_JUAL"),
                  DB::raw("(SELECT SUM(quantity) FROM service_item_good WHERE item_cd = goods.id AND created_at BETWEEN '$dari' AND '$tgl')AS ITEM_JUAL_SERVICE"),
                  DB::raw("(SELECT SUM(total) FROM service_item_good WHERE item_cd = goods.id AND created_at BETWEEN '$dari' AND '$tgl')AS TOTAL_JUAL_SERVICE"))
                 ->orderBy('kategori')
                 ->get();
        }
        else
        {
            $sales = DB::table('goods')
                 ->join('categories', 'categories.id', '=', 'goods.kategori')
                 ->where('goods.id', $barang)
                 ->select('goods.*', 'categories.category_name',
                  DB::raw("(SELECT SUM(quantity) FROM sales_item WHERE item_cd = goods.id AND created_at BETWEEN '$dari' AND '$tgl')AS ITEM_JUAL"),
                  DB::raw("(SELECT SUM(total) FROM sales_item WHERE item_cd = goods.id AND created_at BETWEEN '$dari' AND '$tgl')AS TOTAL_JUAL"),
                  DB::raw("(SELECT SUM(quantity) FROM service_item_good WHERE item_cd = goods.id AND created_at BETWEEN '$dari' AND '$tgl')AS ITEM_JUAL_SERVICE"),
                  DB::raw("(SELECT SUM(total) FROM service_item_good WHERE item_cd = goods.id AND created_at BETWEEN '$dari' AND '$tgl')AS TOTAL_JUAL_SERVICE"))
                 ->orderBy('kategori')
                 ->get();
        }
        
        
        

        $pdf = PDF::loadView('pdf.lap_sales_produk', compact('sales', 'dari', 'sampai', 'profil'));
        $pdf->setPaper('letter', 'landscape');

        return $pdf->stream();   
    }


}
