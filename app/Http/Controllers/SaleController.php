<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Sale;
use App\Customer;
use App\Good;
use App\SaleTmp;
use DB;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Profil;
use App\SaleItem;

class SaleController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('transaksi.sales');
    }


    public function apiSales(){
        $sales = DB::table('sales')->
        		 join('customers', 'customers.id', '=', 'sales.cust_id')->
        		 select('sales.*', 'customers.customer_name')->
        		 get();

        return Datatables::of($sales)
            ->addColumn('created_at', function($sales){
            	return '<div>'.date("d-m-Y", strtotime($sales->created_at)).'</div>';
            })
            ->addColumn('total', function($sales){
            	return '<div style="text-align:right;">'.number_format($sales->total).'</div>';
            })
            ->addColumn('dp', function($sales){
            	return '<div style="text-align:right;">'.number_format($sales->dp).'</div>';
            })
            ->addColumn('action', function($sales){
                if($sales->status == 0){
                	return '<center>
	                <a id="btnPrintData" data-id="'.$sales->id.'" data-invoice = "'.$sales->invoice.'" style="margin-left:5px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
	                '<a href="'.url('edit_transaksi_sales').'/'.$sales->invoice.'" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
	                '<a id="btn_hapus_sales" data-id="'.$sales->id.'" data-invoice = "'.$sales->invoice.'" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';	
                }else{
                	return '<center>
	                <a id="btnPrintData" data-id="'.$sales->id.'" data-invoice = "'.$sales->invoice.'" style="margin-left:5px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
	                '<a disabled style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
	                '<a disabled style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }
            	
           
            })->rawColumns(['dp','created_at','total','action'])->make(true);
    }




    public function salesItem()
    {
        $tmp = DB::table('sales_tmp')->
        	   join('goods', 'goods.id', '=', 'sales_tmp.item_cd')->
        	   select('sales_tmp.*', 'goods.good_name')->
        	   get();

        return Datatables::of($tmp)
        	->addColumn('quantity', function($tmp){
        		return '<div style="text-align:right;">'.$tmp->quantity.'</div>';
        	})

        	->addColumn('price', function($tmp){
        		return '<div style="text-align:right;">'.number_format($tmp->price).'</div>';
        	})

        	->addColumn('total', function($tmp){
        		return '<div style="text-align:right;">'.number_format($tmp->total).'</div>';
        	})

            ->addColumn('action', function($tmp){
               
            	return '<center><a onclick="editData('. $tmp->id.')" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                '<a onclick="deleteData('. $tmp->id.')" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
           
            })->rawColumns(['quantity','price','total','action'])->make(true);
    }




    public function addSales()
    {
    	$customer = Customer::all();
    	$good = Good::all();
    	return view('transaksi.add_sales', compact('customer','good'));
    }




    public function simpanSalesItem(Request $request)
    {
    	$kd = $request->barang;

        $brg = DB::table('sales_tmp')->where('item_cd', $kd)->exists();

        if ($brg == true) 
        {
            $response = "exist";
            echo json_encode($response);
        }
        else
        {
            $tmp = new SaleTmp;
            $tmp->kategori = '2';
            $tmp->item_cd = $request->barang;
            $tmp->uom = $request->satuan;
            $tmp->quantity = $request->jumlah;
            $tmp->price = $request->harga;
            $tmp->total = $request->total;

            $tmp->save();

            return $tmp;
        }
    }



    public function editSalesItem($id)
    {

    	$item = SaleTmp::findorfail($id);
    	return $item;


    }





    public function hapusItem(Request $request)
    {
    	$id = $request->id;
    	$tmp = SaleTmp::destroy($id);
    }





    public function selectBarang($id)
    {
        $good = Good::findorfail($id);
        $satu = $good->s_price;
        $dua = $good->r_price;
        $tiga = $good->d_price;
        $harga = $satu.','.$dua.','.$tiga;
        $harga_baru = explode(",", $harga);
        
        return $harga_baru;
    }




    public function totalTransaksi()
    {
        $total_transaksi = DB::table('sales_tmp')
                        ->select(DB::raw('sum(total) as Total'))
                        ->get();
        return $total_transaksi;
    }


    public function updateSalesItem(Request $request)
    {
    	$id = $request['id_edit'];
    	$quantity = $request['quantity_edit'];
    	$price = $request['item_price_edit'];
    	$total = $request['item_total_edit'];

    	$update = DB::table('sales_tmp')->		
    			  where('id', $id)->
    			  update([
    			  	'quantity'=>$quantity,
    			  	'price'=>$price,
    			  	'total'=>$total
    			  ]);

    	return $update;
    
    }


    public function getHargaBarang($id)
    {
    	$good = Good::findorfail($id);
        $satu = $good->s_price;
        $dua = $good->r_price;
        $tiga = $good->d_price;
        $harga = $satu.','.$dua.','.$tiga;
        $harga_baru = explode(",", $harga);
        
        return $harga_baru;
    }


    public function simpanTransaksiSales(Request $req)
    {	
    	
    	$kd = new PurchaseController();
        $kode = $kd->autonumber('sales','id','SL-');

        $tgl_trans = $req->tgl_trans;
    	$customer = $req->customer;
    	$deskripsi = $req->deskripsi;
    	$dp = $req->dp;
    	$tipe = $req->tipe_pembayaran;
        $due = $req->jatuh_tempo;
    	$total = $req->total;

        if($tipe =='1'){
            $pembayaran = $total;
        }else{
            $pembayaran = $dp;
        }

    	DB::beginTransaction();

    	$sales = DB::table('sales')->
    	insert([
    		'invoice' 		=> $kode,
    		'cust_id' 		=> $customer,
    		'user_id' 		=> Auth::user()->id,
    		'tipe'			=> $tipe,
    		'note'    		=> $deskripsi,
    		'total'   		=> $total,
    		'dp'	  		=> $dp,
    		'pembayaran' 	=> $pembayaran,
    		'sisa'    		=> $total - $pembayaran,
    		'status'  		=> 0,
    		'due' 			=> $due,
    		'created_at'    => $tgl_trans,
    		'updated_at'    => $tgl_trans
    	]);


    	$tmp = SaleTmp::all();

    		foreach ($tmp as $key => $value) {
    			$kategori = $value->kategori;
    			$item = $value->item_cd;
    			$uom = $value->uom;
    			$quantity = $value->quantity;
    			$price = $value->price;
    			$total = $value->total;
    			$created_at = $tgl_trans;
    			$updated_at = $tgl_trans;

    			$item = DB::table('sales_item')->insert([
    				
    				'invoice' 	=>$kode,
    				'kategori' 	=>$kategori,
    				'item_cd' 	=>$item,
    				'uom'		=>$uom,
    				'quantity' 	=>$quantity,
    				'price'		=>$price,
    				'total'		=>$total,
    				'created_at'=>$created_at,
    				'updated_at'=>$updated_at

    			]);

    			$stok = DB::table('stocks')->insert([

    				'id_good' => $value->item_cd,
    				'type'    =>'Sales',
    				'document'=>$kode,
    				'in'      => 0,
    				'out'     =>$quantity,
    				'created_at'=>$tgl_trans

    			]);		
    		}



    	$deltmp = DB::table('sales_tmp')->delete();

		if(!$sales || !$tmp || !$deltmp || !$stok)
		{
        	DB::rollback();
        }
        else
        {
            DB::commit();
        } 

    }



    public function batalPenjualan()
    {
    	$sales = DB::table('sales_tmp')->delete();
    	return $sales;
    }


    public function hapusPenjualan(Request $req)
    {
    	$id = $req->id;
    	$invoice = $req->invoice;

    	DB::beginTransaction();

    	$header = DB::table('sales')->where('id', $id)->delete();

    	$item = DB::table('sales_item')->where('invoice', $invoice)->delete();

    	$stok = DB::table('stocks')->where('document', $invoice)->delete();

    	if(!$header || !$item || !$stok)
    	{
    		DB::rollback();
    	}
    	else
    	{
    		DB::commit();
    		return "true";
    	}

    }


    public function discountPenjualan(Request $req)
    {	
    	$diskon = $req->diskon;


    	$data = DB::table('sales_tmp')->insert([
    		'kategori' =>	3,
    		'item_cd'  =>	1001,
    		'uom'      => 	'Unit',
    		'quantity' => 	1,
    		'price'    => 	$diskon,
    		'total'    =>   $diskon * -1,
    		'created_at' => date("Y-m-d H:i:s"),
    		'updated_at' => date("Y-m-d H:i:s")
    	]);

    	return response()->json([
            'success'=>true
        ]);
    }



    public function cetakInvoiceSales($invoice)
    {
    	$status = DB::table('sales')->where('invoice', $invoice)->update(['status'=>1]);

        $profil = Profil::all()->first();
        $sales = DB::table('sales')
                ->join('customers', 'customers.id', '=', 'sales.cust_id')
                ->join('users', 'users.id', '=', 'sales.user_id')
                ->where('sales.invoice', $invoice)
                ->select('sales.*', 'customers.customer_name', 'customers.customer_address', 'customers.customer_phone','users.name')
                ->first();
        $br = DB::table('sales_item')->
        	  join('goods', 'goods.id', '=', 'sales_item.item_cd')->
        	  where('invoice', $invoice)->
        	  select('sales_item.*', 'goods.good_name')->
        	  get();     
        $pdf    = PDF::loadView('pdf.sales', compact('profil', 'sales','br'));
        $pdf->setPaper('legal', 'potrait');

        return $pdf->stream();
    }



    public function editTransaksiSales($invoice)
    {
    	$customer = Customer::all();
    	$good = Good::all();
    	$sales = DB::table('sales')->where('invoice', $invoice)->first();

    	DB::table('sales_tmp')->delete();

    	$item = DB::table('sales_item')->where('invoice', $invoice)->get();
    	foreach ($item as $key => $value) {
    		DB::table('sales_tmp')->insert([
    			'kategori' =>$value->kategori,
    			'item_cd' =>$value->item_cd,
    			'uom'=>$value->uom,
    			'quantity'=>$value->quantity,
    			'price'=>$value->price,
    			'total'=>$value->total,
    			'created_at'=>$value->created_at,
    			'updated_at'=>$value->updated_at
    		]);
    	}

    	return view('transaksi.edit_sales', compact('customer','good', 'invoice', 'sales'));
    }


    public function updateTransaksiSales(Request $req)
    {	
    	
    	
        $kode = $req->invoice;

        $tgl_trans = $req->tgl_trans;
    	$customer = $req->customer;
    	$deskripsi = $req->deskripsi;
    	$dp = $req->dp;
    	$tipe = $req->tipe_pembayaran;
    	$due = $req->jatuh_tempo;
    	$total = $req->total;

        if($tipe =='1'){
            $pembayaran = $total;
        }else{
            $pembayaran = $dp;
        }

    	DB::beginTransaction();

    	$delSales = DB::table('sales')->where('invoice', $kode)->delete();
    	$stkdel = DB::table('stocks')->where('document', $kode)->delete();

    	$sales = DB::table('sales')->
    	insert([
    		'invoice' 		=> $kode,
    		'cust_id' 		=> $customer,
    		'user_id' 		=> Auth::user()->id,
    		'tipe'			=> $tipe,
    		'note'    		=> $deskripsi,
    		'total'   		=> $total,
    		'dp'	  		=> $dp,
    		'pembayaran' 	=> $pembayaran,
    		'sisa'    		=> $total - $pembayaran,
    		'status'  		=> 0,
    		'due' 			=> $due,
    		'created_at'    => $tgl_trans,
    		'updated_at'    => $tgl_trans
    	]);


    	$delItem = DB::table('sales_item')->where('invoice', $kode)->delete();

    	$tmp = SaleTmp::all();

    		foreach ($tmp as $key => $value) {
    			$kategori = $value->kategori;
    			$item = $value->item_cd;
    			$uom = $value->uom;
    			$quantity = $value->quantity;
    			$price = $value->price;
    			$total = $value->total;
    			$created_at = $tgl_trans;
    			$updated_at = $tgl_trans;

    			$item = DB::table('sales_item')->insert([
    				
    				'invoice' 	=>$kode,
    				'kategori' 	=>$kategori,
    				'item_cd' 	=>$item,
    				'uom'		=>$uom,
    				'quantity' 	=>$quantity,
    				'price'		=>$price,
    				'total'		=>$total,
    				'created_at'=>$created_at,
    				'updated_at'=>$updated_at

    			]);		


    			$stok = DB::table('stocks')->insert([

    				'id_good' => $value->item_cd,
    				'type'    =>'Sales',
    				'document'=>$kode,
    				'in'      => 0,
    				'out'     =>$quantity,
    				'created_at'=>$tgl_trans

    			]);
    		}

    	$deltmp = DB::table('sales_tmp')->delete();


		if(!$sales || !$tmp || !$deltmp || !$stok || !$stkdel)
		{
        	DB::rollback();
        }
        else
        {
            DB::commit();
        } 

    }



}
