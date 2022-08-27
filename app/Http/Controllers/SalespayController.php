<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\SalesPay;
use App\Customer;
use DB;
use PDF;


class SalespayController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }

    
    public function index()
    {
    	return view('transaksi.salespay');
    }


    public function apiSalespay(){
        $salespay = SalesPay::all();

        return Datatables::of($salespay)
            ->addColumn('created_at', function($salespay){
            	return '<div>'.date("d-m-Y", strtotime(($salespay->created_at))).'</div>';
            })
            ->addColumn('nilai_pembayaran', function($salespay){
            	return '<div style="text-align:right;">'.number_format($salespay->nilai_pembayaran).'</div>';
            })
            ->addColumn('action', function($salespay){
                if($salespay->status==0)
                {
                	return '<center>
	                <a id="printData" data-id="'.$salespay->id.'" data-invoice = "'.$salespay->payment_no.'" style="margin-left:5px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
	                '<a onclick="editData('. $salespay->id.')" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
	                '<a onclick="deleteData('. $salespay->id.')" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }else
                {
                	return '<center>
                <a id="printData" data-id="'.$salespay->id.'" data-invoice = "'.$salespay->payment_no.'" style="margin-left:5px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
                '<a disabled="disabled" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                '<a disabled="disabled" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }
           
            })->rawColumns(['created_at','nilai_pembayaran', 'action'])->make(true);
    }


    public function apiList(){
        $sales = DB::table('sales')->
        			join('customers', 'customers.id', '=', 'sales.cust_id')->
        			where('sisa' , '>', 0)->
        			select('sales.*', 'customers.customer_name')->
        			get();

        return Datatables::of($sales)
            ->addColumn('customer_name', function($sales){
            	return '<div>'.$sales->customer_name.'</div>';
            })

            ->addColumn('created_at', function($sales){
            	return '<div>'.date("d-m-Y", strtotime($sales->created_at)).'</div>';
            })
            ->addColumn('total', function($sales){
            	return '<div style="text-align:right;">'.number_format($sales->total).'</div>';
            })
            ->addColumn('pembayaran', function($sales){
            	return '<div style="text-align:right;">'.number_format($sales->pembayaran).'</div>';
            })
            ->addColumn('sisa', function($sales){
            	return '<div style="text-align:right;">'.number_format($sales->sisa).'</div>';
            })
            
            ->addColumn('action', function($sales){
                return '<center><a onclick="chooseService('. $sales->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-check"></i> Pilih</a>';
            })->rawColumns(['customer_name','created_at', 'total', 'pembayaran', 'sisa', 'action'])->make(true);
    }



    public function pilihSales($id)
    {
    	$sales = DB::table('sales')->
    				join('customers', 'customers.id','=', 'sales.cust_id')->
    				where('sales.id', $id)->
    				select('sales.*', 'customers.customer_name')->
    				get();
    	return $sales;
    }



    public function simpanPembayaran(Request $request)
    {
    	$table="salespay";
        $primary="id";
        $prefix="SPA-";
        $pcs = new PurchaseController();
        $kode=$pcs->autonumber($table,$primary,$prefix);
        
        //// simpan header
        // nobeli:nobeli, idsupplier:idsupplier, namasupplier:namasupplier, pembayaran:pembayaran, sisa:sisa, ket:ket

        $data = new SalesPay;
        $data->payment_no = $kode;
        $data->sales_id = $request->nopenjualan;
        $data->customer_id = $request->idcustomer;
        $data->customer_name = $request->namacustomer;
        $data->nilai_pembayaran = $request->pembayaran;
        $data->description = $request->ket;
        $data->save();

        return $data;
    }




    public function getPayment($id)
    {
    	$data = DB::table('salespay')->
    			join('sales', 'sales.invoice', '=', 'salespay.sales_id')->
    			where('salespay.id', $id)->
    			select('salespay.*', 'sales.sisa')->
    			get();

    	return $data;
    }




    public function updatePembayaran(Request $request)
    {
    	

        $kode = $request->id_bayar; 
        
        DB::table('salespay')->
        	where('payment_no', $kode)->
        	delete();

        $data = new SalesPay;
        $data->payment_no = $kode;
        $data->sales_id = $request->nopenjualan;
        $data->customer_id = $request->idcustomer;
        $data->customer_name = $request->namacustomer;
        $data->nilai_pembayaran = $request->pembayaran;
        $data->description = $request->ket;


        $data->save();

        return $data;
    }




    public function hapusPembayaran(Request $request)
    {
    	$id = $request->id;
    	return SalesPay::destroy($id);
    }



    public function cetakPembayaran($id, $invoice)
    {    
        DB::table('salespay')->where('id', $id)->update(['status' => 1]);

        $profil =   DB::table('profils')->first();
        
        $salespay =  DB::table('salespay')->
                    join('customers', 'customers.id', '=', 'salespay.customer_id')->
                    where('salespay.id', $id)->
                    select('salespay.*', 'customers.customer_address', 'customers.customer_phone')->
                    get()->first();

        $pdf =      PDF::loadView('pdf.payment_sales', compact('profil','salespay'));
        $pdf->      setPaper('a4', 'potrait');

        return $pdf->stream();
    }


    
    public function cetakLaporanPiutang()
    {
        $customer = Customer::all();
        return view('laporan.ar_sales', compact('customer'));
    }



    public function arSalesCetakSekarang($customer = null)
    {
        
        $profil = DB::table('profils')->first();

        if($customer =='' || $customer == null)
        {
            $sales = DB::table('sales')->
                        join('customers', 'customers.id', '=', 'sales.cust_id')->
                        where('sisa','>', 0)->
                        get();  
        }
        
        else
        
        {
            $sales = DB::table('sales')->
                        join('customers', 'customers.id', '=', 'sales.cust_id')->
                        where('cust_id', $customer)->
                        where('sisa','>', 0)->
                        get();
        }
        
        $pdf = PDF::loadView('pdf.ar_sales', compact('profil', 'sales'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream();
    }




    public function cetakLaporanPembayaranSales()
    {
        $customer = Customer::all();
        return view('laporan.sales_payment', compact('customer'));
    }



    public function pembayaranSales($customer=null)
    {
        $profil = DB::table('profils')->first();

        if($customer =='' || $customer == null){
            $salespay = SalesPay::all();    
        }else{
            $salespay = DB::table('salespay')->
                        where('customer_id', $customer)->
                        get();
        }
        $pdf = PDF::loadView('pdf.pay_sales', compact('profil', 'salespay'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream();  
    }




}
