<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use DB;
use App\Debt;
use App\Purchase;
use PDF;
use App\Supplier;


class DebtController extends Controller
{
	
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
	{
		return view('transaksi.debt');
	}    

	public function apiDebt(){
        $debt = Debt::all();

        return Datatables::of($debt)
            ->addColumn('created_at', function($debt){
            	return '<div>'.date("d-m-Y", strtotime(($debt->created_at))).'</div>';
            })
            ->addColumn('nilai_pembayaran', function($debt){
            	return '<div style="text-align:right;">'.number_format($debt->nilai_pembayaran).'</div>';
            })
            ->addColumn('action', function($debt){
                if($debt->status==0)
                {
                	return '<center>
	                <a id="printData" data-id="'.$debt->id.'" data-invoice = "'.$debt->payment_no.'" style="margin-left:5px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
	                '<a onclick="editData('. $debt->id.')" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
	                '<a onclick="deleteData('. $debt->id.')" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }else
                {
                	return '<center>
                <a id="printData" data-id="'.$debt->id.'" data-invoice = "'.$debt->payment_no.'" style="margin-left:5px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
                '<a disabled="disabled" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                '<a disabled="disabled" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }
           
            })->rawColumns(['created_at','nilai_pembayaran', 'action'])->make(true);
    }

    public function apiList(){
        $purchase = DB::table('purchases')->
        			join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')->
        			where('sisa' , '>', 0)->
        			select('purchases.*', 'suppliers.supplier_name')->
        			get();

        return Datatables::of($purchase)
            
            ->addColumn('created_at', function($purchase){
            	return '<div>'.date("d-m-Y", strtotime($purchase->created_at)).'</div>';
            })
            ->addColumn('total', function($purchase){
            	return '<div style="text-align:right;">'.number_format($purchase->total).'</div>';
            })
            ->addColumn('pembayaran', function($purchase){
            	return '<div style="text-align:right;">'.number_format($purchase->pembayaran).'</div>';
            })
            ->addColumn('sisa', function($purchase){
            	return '<div style="text-align:right;">'.number_format($purchase->sisa).'</div>';
            })
            
            ->addColumn('action', function($purchase){
                return '<center><a onclick="chooseDebt('. $purchase->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-check"></i> Pilih</a>';
            })->rawColumns(['created_at', 'total', 'pembayaran', 'sisa', 'action'])->make(true);
    }

    public function pilihHutang($id)
    {
    	$purchase = DB::table('purchases')->
    				join('suppliers', 'suppliers.id','=', 'purchases.supplier_id')->
    				where('purchases.id', $id)->
    				select('purchases.*', 'suppliers.supplier_name')->
    				get();
    	return $purchase;
    }

    public function simpanPembayaran(Request $request)
    {
    	$table="debts";
        $primary="id";
        $prefix="DBT-";
        $pcs = new PurchaseController();
        $kode=$pcs->autonumber($table,$primary,$prefix);
        
        //// simpan header
        // nobeli:nobeli, idsupplier:idsupplier, namasupplier:namasupplier, pembayaran:pembayaran, sisa:sisa, ket:ket

        $data = new Debt;
        $data->payment_no = $kode;
        $data->id_purchase = $request->nobeli;
        $data->id_supplier = $request->idsupplier;
        $data->nama_supplier = $request->namasupplier;
        $data->nilai_pembayaran = $request->pembayaran;
        $data->description = $request->ket;
        $data->save();

        return $data;
    }


    public function updatePembayaran(Request $request)
    {
    	

        $kode = $request->id_bayar; 
        
        DB::table('debts')->
        	where('payment_no', $kode)->
        	delete();

        $data = new Debt;
        $data->payment_no = $kode;
        $data->id_purchase = $request->nobeli;
        $data->id_supplier = $request->idsupplier;
        $data->nama_supplier = $request->namasupplier;
        $data->nilai_pembayaran = $request->pembayaran;
        $data->description = $request->ket;
        $data->save();

        return $data;
    }




    public function hapusPembayaran(Request $request)
    {
    	$id = $request->id;
    	return Debt::destroy($id);
    }


    public function getPayment($id)
    {
    	$data = DB::table('debts')->
    			join('purchases', 'purchases.invoice', '=', 'debts.id_purchase')->
    			where('debts.id', $id)->
    			select('debts.*', 'purchases.sisa')->
    			get();

    	return $data;
    }

    
    public function cetakPembayaran($id, $invoice)
    {    
        DB::table('debts')->where('id', $id)->update(['status' => 1]);

        $profil = DB::table('profils')->first();
        
        $debt = DB::table('debts')->
    			join('suppliers', 'suppliers.id', '=', 'debts.id_supplier')->
        		where('debts.id', $id)->
        		select('debts.*', 'suppliers.supplier_address', 'suppliers.supplier_phone')->
        		get()->first();

        $pdf = PDF::loadView('pdf.payment', compact('profil','debt'));
        $pdf->setPaper('a4', 'potrait');

        return $pdf->stream();
    }


    public function cetakLaporanHutang()
    {
    	$supplier = Supplier::all();
    	return view('laporan.debt', compact('supplier'));
    }


    public function cetakLaporanPembayaran()
    {
    	$supplier = Supplier::all();
    	return view('laporan.payment', compact('supplier'));	
    }


    public function hutangCetakSekarang($periode = null)
    {
    	
        $profil = DB::table('profils')->first();

        if($periode =='' || $periode == null){
        	$purchase = DB::table('purchases')->
        				join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')->
        				where('sisa','>', 0)->
        				get();	
        }else{
        	$purchase = DB::table('purchases')->
        				join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')->
        				where('supplier_id', $periode)->
        				where('sisa','>', 0)->
        				get();
        }
        $pdf = PDF::loadView('pdf.debt', compact('profil', 'purchase'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream();
    }


    public function pembayaranCetakSekarang($supplier=null)
    {
    	$profil = DB::table('profils')->first();

        if($supplier =='' || $supplier == null){
        	$debt = Debt::all();	
        }else{
        	$debt = DB::table('debts')->
        				where('id_supplier', $supplier)->
        				get();
        }
        $pdf = PDF::loadView('pdf.pay', compact('profil', 'debt'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream();	
    }



}
