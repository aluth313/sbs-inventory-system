<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use DB;
use PDF;
use App\Supplier;
use App\Material;
use App\TmpPurchase;
use App\Purchase;
use App\Profil;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transaksi.purchase');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function addPurchase()
    {
        $supplier = Supplier::all();
        $barang = Material::all();
        return view('transaksi.add_purchase', compact('supplier', 'barang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editItem($id)
    {
        $item = TmpPurchase::findorfail($id);
        return $item;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateItem(Request $request)
    {
        
        $id = $request->id;

        $item = TmpPurchase::findorFail($id);
        $item->quantity = $request['jumlah'];
        $item->item_price = $request['harga'];
        $item->item_total = $request['total'];
        $item->update();
        
        return $item;

         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = TmpPurchase::findorfail($id);
        $hapus->delete();
        return $hapus;

    }


    public function apiPurchase(){
        $purchase = DB::table('purchases')
                   ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
                   ->select('purchases.*', 'suppliers.supplier_name')
                   ->orderBy('purchases.id','desc')
                   ->get();

       

        return Datatables::of($purchase) 
            ->addColumn('tipe', function($purchase){
                if($purchase->tipe==2){return 'Credit';}else{return 'Cash';};
            })
            ->addColumn('dp', function($purchase){
                return '<div style="text-align:right;">'.number_format($purchase->dp).'</div>';
            })
            ->addColumn('total', function($purchase){
                return '<div style="text-align:right;">'.number_format($purchase->total).'</div>';
            })
            
            ->addColumn('action', function($purchase){
                if($purchase->status == 0){
                        return '<center>
                             <a id="btn-cetak" data-id = "'.$purchase->id.'" data-inv = "'.$purchase->invoice.'" style="margin-left:5px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
                            '<a href="'.url('edit_pembelian').'/'.$purchase->invoice.'" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                            '<a id="btn-hapus" data-id = "'.$purchase->id.'" data-inv = "'.$purchase->invoice.'" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }else{
                    return '<center>
                            <a id="btn-cetak" data-id = "'.$purchase->id.'" data-inv = "'.$purchase->invoice.'" style="margin-left:5px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
                            '<a disabled="disabled" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                            '<a disabled="disabled" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                            
                }
                
            })->rawColumns(['tipe','dp','total','action'])->make(true);
    }



    public function cari($barang){
        $brg = Material::findorfail($barang);
        return $brg;
    }



    public function apiItem(){
        $tmp = DB::table('purchase_tmp')
                ->join('materials', 'materials.id', '=', 'purchase_tmp.item_cd')
                ->select('purchase_tmp.*', 'materials.material_name')
                ->orderBy('purchase_tmp.id', 'desc')
                ->get();

        return Datatables::of($tmp)
            ->addColumn('item_price', function($tmp){
                return '<div style="text-align:right;">'.number_format($tmp->item_price).'</div>';
            })
            ->addColumn('quantity', function($tmp){
                return '<div style="text-align:right;">'.number_format($tmp->quantity, 2).'</div>';
            })
            ->addColumn('item_total', function($tmp){
                return '<div style="text-align:right;">'.number_format($tmp->item_total).'</div>';
            })
            ->addColumn('action', function($tmp){
                return '<center>
                <a onclick="editForm('. $tmp->id.')" style="margin-left:10px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                '<a onclick="deleteData('. $tmp->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
            })->rawColumns(['quantity','item_price','item_total','action'])->make(true);
    }



    public function simpan_item(Request $request){

        $kd = $request->barang;

        $brg = DB::table('purchase_tmp')->where('item_cd', $kd)->exists();

        if ($brg == true) {
            $response = "exist";
            echo json_encode($response);
        }
        else{

            $tmp = new TmpPurchase;
            $tmp->item_cd = $request->barang;
            $tmp->quantity = $request->jumlah;
            $tmp->item_price = $request->harga;
            $tmp->item_unit = $request->satuan;
            $tmp->item_total = $request->total;

            $tmp->save();

            return $tmp;
        }
        
    }



    public function simpanPurchase(Request $request){

        $table="purchases";
        $primary="id";
        $prefix="PCH-";
        $kode=$this->autonumber($table,$primary,$prefix);
        
        //// simpan header

        $tipe = $request['tipe_pembayaran'];

        if($tipe == 1){
            $pembayaran = $request['total'];
        }else{
            $pembayaran = $request['dp'];
        }

        $pcs = new Purchase;
        $pcs->invoice = $kode;
        $pcs->supplier_id = $request['supplier'];
        $pcs->description = $request['deskripsi'];
        $pcs->tipe = $request['tipe_pembayaran'];


        $pcs->dp = $request['dp'];
        $pcs->hari = $request['jatuh_tempo'];
        $pcs->pembayaran = $pembayaran;
        $pcs->sisa = $request['total'] - $pembayaran;
        $pcs->user_id = Auth::user()->id;
        $pcs->total = $request['total'];

        $pcs->save();

        // simpan openssl_pkey_get_details(key)

        $query = DB::table('purchase_tmp')
                ->select('*')
                ->get();

                foreach ($query as $key) {
                    $barang = $key->item_cd;
                    $satuan = $key->item_unit;
                    $harga = $key->item_price;
                    $jumlah = $key->quantity;
                    $total = $key->item_total;

                    DB::table('purchase_details')->insert([
                            'invoice' => $kode ,
                            'item_cd' => $barang,
                            'quantity'=> $jumlah,
                            'item_unit' =>$satuan,
                            'item_price'=>$harga,
                            'item_total'=>$total, 
                            'created_at'=> date("Y-m-d H:i:s")
                            
                    ]);

                    // revisi 

                    // DB::table('stocks')->insert([
                    //     'id_good'=>$barang,
                    //     'type'=>'purchase',
                    //     'document'=>$kode,
                    //     'in'=>$jumlah,
                    //     'out'=>0,
                    //     'created_at'=> date("Y-m-d H:i:s")
                    // ]);

                }

        DB::table('purchase_tmp')->delete();

        return $query;
    
    }




    public function updatePembelian(Request $request){

        $invoice = $request['invoice'];

        DB::table('purchases')->where('invoice', $invoice)->delete();
        DB::table('purchase_details')->where('invoice', $invoice)->delete();
        DB::table('stocks')->where('document', $invoice)->delete();

        $tipe = $request['tipe_pembayaran'];

        if($tipe == 1){
            $pembayaran = $request['total'];
        }else{
            $pembayaran = $request['dp'];
        }

        $pcs = new Purchase;
        $pcs->invoice = $invoice;
        $pcs->supplier_id = $request['supplier'];
        $pcs->description = $request['deskripsi'];
        $pcs->tipe = $request['tipe_pembayaran'];
        $pcs->dp = $request['dp'];
        $pcs->hari = $request['jatuh_tempo'];
        $pcs->pembayaran = $pembayaran;
        $pcs->sisa = $request['total'] - $pembayaran;
        $pcs->user_id = Auth::user()->id;
        $pcs->total = $request['total'];

        $pcs->save();

        // simpan openssl_pkey_get_details(key)

        $query = DB::table('purchase_tmp')
                ->select('*')
                ->get();

                foreach ($query as $key) {
                    $invoice = $request['invoice'];
                    $barang = $key->item_cd;
                    $satuan = $key->item_unit;
                    $harga = $key->item_price;
                    $jumlah = $key->quantity;
                    $total = $key->item_total;

                    DB::table('purchase_details')->insert([
                            'invoice' => $invoice ,
                            'item_cd' => $barang,
                            'quantity'=> $jumlah,
                            'item_unit' =>$satuan,
                            'item_price'=>$harga,
                            'item_total'=>$total, 
                            'created_at'=> date("Y-m-d H:i:s")
                            
                    ]);

                    DB::table('stocks')->insert([
                        'id_good'=>$barang,
                        'type'=>'purchase',
                        'document'=>$invoice,
                        'in'=>$jumlah,
                        'out'=>0,
                        'created_at'=> date("Y-m-d H:i:s")
                    ]);


                }

        DB::table('purchase_tmp')->delete();

        return $query;
    
    }






    public function hapusPembelian(Request $request){

        $id = $request->id;        
        $purchase = Purchase::destroy($id);

        $inv = $request->invoice;

        $stock = DB::table('stocks')
                ->where('document', $inv)
                ->delete();

        $details = DB::table('purchase_details')
                     ->where('invoice', $inv)
                     ->delete();
            
        return $details;

    }


    public function batalPembelian(){

        $purchase = DB::table('purchase_tmp')->delete();

    }


    public function lihatPembelian($id, $invoice){

            $purchase = DB::table('purchases')
                        ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
                        ->where('purchases.id', $id)
                        ->select('purchases.*', 'suppliers.supplier_name', 'suppliers.supplier_address', 'suppliers.supplier_phone')

                        ->first();

            $details = DB::table('purchase_details')
                        ->join('materials', 'materials.id','=','purchase_details.item_cd')
                        ->select('purchase_details.*', 'materials.material_name')
                        ->where('purchase_details.invoice', $invoice)
                        ->get();

            return view('transaksi.show_purchase', compact('purchase', 'details'));


    }


    public function cetakPembelian($id, $invoice){
        
        $status = DB::table('purchases')
                    ->where('id', $id)
                    ->update([ 'status'=>1 ]);

        $profil = DB::table('profils')->first();

        $purchase = DB::table('purchases')
                    ->join('suppliers', 'suppliers.id','=','purchases.supplier_id')
                    ->where('purchases.id', $id)
                    ->select('purchases.*', 'suppliers.*')
                    ->first();

        $details = DB::table('purchase_details')
                    ->join('materials', 'materials.id', '=', 'purchase_details.item_cd')
                    ->where('purchase_details.invoice', $invoice)
                    ->select('purchase_details.*', 'materials.material_name')
                    ->get();

        $pdf = PDF::loadView('pdf.purchase', compact('profil', 'purchase', 'details'));
        $pdf->setPaper('a4', 'potrait');

        return $pdf->stream();
    }


    public function editPembelian($invoice){

        $d = DB::table('purchases')
            ->where('invoice', $invoice)
            ->first();

        if($d->status == 1){

            return redirect(url('purchase'));
            exit();
        }
        else{
            $dt = DB::table('purchase_details')
                    ->where('invoice', $invoice)
                    ->get();

            foreach ($dt as $key) {
                DB::table('purchase_tmp')->insert([
                                'item_cd' => $key->item_cd,
                                'quantity'=> $key->quantity,
                                'item_unit' =>$key->item_unit,
                                'item_price'=>$key->item_price,
                                'item_total'=>$key->item_total, 
                                'created_at'=> date("Y-m-d H:i:s")
                                
                ]);
            }

            $purchase = DB::table('purchases')
                        ->where('invoice', $invoice)
                        ->first();

            $supplier = Supplier::all();
            $barang = Material::all();


            return view('transaksi.edit_purchase', compact('supplier', 'purchase', 'barang'));    
        }
    }




    public function totalTransaksi(){

        $total_transaksi = DB::table('purchase_tmp')
                        ->select(DB::raw('sum(item_total) as Total'))
                        ->get();
        return $total_transaksi;
    }



    public static function autonumber($table,$primary,$prefix){
        $q=DB::table($table)->select(DB::raw('MAX('.$primary.') as kd_max'));
        $prx=$prefix;
        if($q->count()>0)
        {
            foreach($q->get() as $k)
            {
                $tmp = ((int)$k->kd_max)+1;
                $kd = $prx.sprintf("%06s", $tmp);
            }
        }
        else
        {
            $kd = $prx."000001";
        }

        return $kd;
    }


}
