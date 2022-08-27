<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Custpay;
use DB;
use PDF;
use App\Customer;

class CustpayController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }
    

    public function index()
    {
    	return view('transaksi.custpay');
    }

    
    public function apiCustpay(){
        $custpay = Custpay::all();

        return Datatables::of($custpay)
            ->addColumn('created_at', function($custpay){
            	return '<div>'.date("d-m-Y", strtotime(($custpay->created_at))).'</div>';
            })
            ->addColumn('nilai_pembayaran', function($custpay){
            	return '<div style="text-align:right;">'.number_format($custpay->nilai_pembayaran).'</div>';
            })
            ->addColumn('action', function($custpay){
                if($custpay->status==0)
                {
                	return '<center>
	                <a id="printData" data-id="'.$custpay->id.'" data-invoice = "'.$custpay->payment_no.'" style="margin-left:5px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
	                '<a onclick="editData('. $custpay->id.')" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
	                '<a onclick="deleteData('. $custpay->id.')" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }else
                {
                	return '<center>
                <a id="printData" data-id="'.$custpay->id.'" data-invoice = "'.$custpay->payment_no.'" style="margin-left:5px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
                '<a disabled="disabled" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                '<a disabled="disabled" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }
           
            })->rawColumns(['created_at','nilai_pembayaran', 'action'])->make(true);
    }


    public function apiList(){
        $service = DB::table('services')->
        			join('customers', 'customers.id', '=', 'services.cust_id')->
        			join('tanda_terima', 'tanda_terima.ttno', '=', 'services.ttno')->
        			where('sisa' , '>', 0)->
        			select('services.*', 'customers.customer_name', 'tanda_terima.item_name')->
        			get();

        return Datatables::of($service)
            ->addColumn('customer_name', function($service){
            	return '<div>'.$service->customer_name.'<br>['.$service->item_name.']</div>';
            })

            ->addColumn('created_at', function($service){
            	return '<div>'.date("d-m-Y", strtotime($service->created_at)).'</div>';
            })
            ->addColumn('total', function($service){
            	return '<div style="text-align:right;">'.number_format($service->total).'</div>';
            })
            ->addColumn('pembayaran', function($service){
            	return '<div style="text-align:right;">'.number_format($service->pembayaran).'</div>';
            })
            ->addColumn('sisa', function($service){
            	return '<div style="text-align:right;">'.number_format($service->sisa).'</div>';
            })
            
            ->addColumn('action', function($service){
                return '<center><a onclick="chooseService('. $service->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-check"></i> Pilih</a>';
            })->rawColumns(['customer_name','created_at', 'total', 'pembayaran', 'sisa', 'action'])->make(true);
    }


    public function pilihService($id)
    {
    	$service = DB::table('services')->
    				join('customers', 'customers.id','=', 'services.cust_id')->
    				where('services.id', $id)->
    				select('services.*', 'customers.customer_name')->
    				get();
    	return $service;
    }



    public function simpanPembayaran(Request $request)
    {
    	$table="custpays";
        $primary="id";
        $prefix="CPA-";
        $pcs = new PurchaseController();
        $kode=$pcs->autonumber($table,$primary,$prefix);
        
        //// simpan header
        // nobeli:nobeli, idsupplier:idsupplier, namasupplier:namasupplier, pembayaran:pembayaran, sisa:sisa, ket:ket

        $data = new Custpay;
        $data->payment_no = $kode;
        $data->service_id = $request->noservice;
        $data->customer_id = $request->idcustomer;
        $data->customer_name = $request->namacustomer;
        $data->nilai_pembayaran = $request->pembayaran;
        $data->description = $request->ket;
        $data->save();

        return $data;
    }



    
    public function updatePembayaran(Request $request)
    {
    	

        $kode = $request->id_bayar; 
        
        DB::table('custpays')->
        	where('payment_no', $kode)->
        	delete();

        $data = new Custpay;
        $data->payment_no = $kode;
        $data->service_id = $request->noservice;
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
    	return Custpay::destroy($id);
    }



    public function getPayment($id)
    {
    	$data = DB::table('custpays')->
    			join('services', 'services.invoice', '=', 'custpays.service_id')->
    			where('custpays.id', $id)->
    			select('custpays.*', 'services.sisa')->
    			get();

    	return $data;
    }



    public function cetakPembayaran($id, $invoice)
    {    
        DB::table('custpays')->where('id', $id)->update(['status' => 1]);

        $profil =   DB::table('profils')->first();
        
        $custpay =  DB::table('custpays')->
                    join('customers', 'customers.id', '=', 'custpays.customer_id')->
                    where('custpays.id', $id)->
                    select('custpays.*', 'customers.customer_address', 'customers.customer_phone')->
                    get()->first();

        $pdf =      PDF::loadView('pdf.payment_service', compact('profil','custpay'));
        $pdf->      setPaper('a4', 'potrait');

        return $pdf->stream();
    }



    public function cetakLaporanPiutang()
    {
        $customer = Customer::all();
        return view('laporan.ar_service', compact('customer'));
    }



    public function arServiceCetakSekarang($customer = null)
    {
        
        $profil = DB::table('profils')->first();

        if($customer =='' || $customer == null)
        {
            $service = DB::table('services')->
                        join('customers', 'customers.id', '=', 'services.cust_id')->
                        where('sisa','>', 0)->
                        get();  
        }
        
        else
        
        {
            $service = DB::table('services')->
                        join('customers', 'customers.id', '=', 'services.cust_id')->
                        where('cust_id', $customer)->
                        where('sisa','>', 0)->
                        get();
        }
        
        $pdf = PDF::loadView('pdf.ar_service', compact('profil', 'service'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream();
    }


    public function cetakLaporanPembayaranService()
    {
        $customer = Customer::all();
        return view('laporan.service_payment', compact('customer'));
    }



    public function pembayaranService($customer=null)
    {
        $profil = DB::table('profils')->first();

        if($customer =='' || $customer == null){
            $custpay = Custpay::all();    
        }else{
            $custpay = DB::table('custpays')->
                        where('customer_id', $customer)->
                        get();
        }
        $pdf = PDF::loadView('pdf.pay_service', compact('profil', 'custpay'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream();  
    }


}
