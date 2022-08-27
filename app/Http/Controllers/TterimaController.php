<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Tterima;
use DB;
use App\Customer;
use App\Profil;
use PDF;

class TterimaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct(){
        $this->middleware('auth');
    }

    
    public function index()
    {
        
        $cust = Customer::all();
        return view('transaksi.tanda_terima', compact('cust'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $kd = new PurchaseController();

        $kode = $kd->autonumber('tanda_terima','id','RN-');

        $input = $request->all();
        $input['foto'] = null;

        if($request->hasFile('foto')){
            $input['foto'] = str_slug($input['item_name'], ' - ').'.'.$request->foto->getClientOriginalExtension();
            $request->foto->move(public_path('/upload/terima'), $input['foto']);
        }
        

        $tt = new Tterima;

        $tt->ttno = $kode;
        $tt->cust_id = $request->cust_id;
        $tt->item_name = $request->item_name;
        $tt->tipe = $request->tipe;
        $tt->sn = $request->sn;
        $tt->keterangan = $request->keterangan;
        $tt->keluhan = $request->keluhan;
        $tt->kelengkapan = $request->kelengkapan;
        $tt->estimasi_selesai = $request->estimasi_selesai;
        $tt->dp = $request->dp;
        $tt->foto = $input['foto'];
        $tt->save();

        return response()->json([
            'success'=>true
        ]);

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
    public function edit($id)
    {
        $tr = Tterima::findorfail($id);
        return $tr;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $input = $request->all();
        $terima = Tterima::findorfail($id);
        $input['foto'] = $terima->foto;

        if($request->hasFile('foto')){
            if($terima->foto != NULL){
                unlink(public_path('/upload/terima/'.$terima->foto));
            }
            $input['foto'] = str_slug($input['item_name'], ' - ').'.'.$request->foto->getClientOriginalExtension();
            $request->foto->move(public_path('/upload/terima'), $input['foto']);
        }

        $tr = Tterima::findorfail($id);
        $tr->cust_id = $request['cust_id'];
        $tr->item_name = $request['item_name'];
        $tr->tipe = $request['tipe'];
        $tr->sn = $request['sn'];
        $tr->keterangan = $request['keterangan'];
        $tr->keluhan = $request['keluhan'];
        $tr->kelengkapan = $request['kelengkapan'];
        $tr->estimasi_selesai =$request['estimasi_selesai'];
        $tr->dp = $request->dp;
        $tr->foto = $input['foto'];

        $tr->update();

        return response()->json([
            'success'=>true
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        

        $tr = Tterima::findorFail($id);
        if($tr->foto != NULL){
            unlink(public_path('/upload/terima/'.$tr->foto));
        }

        Tterima::destroy($id);
        
        return response()->json([
            'success'=>true

        ]);
    }



    public function apiTerima()
    {
        
        $terima = DB::table('tanda_terima')
            ->join('customers', 'customers.id', '=', 'tanda_terima.cust_id')
            ->select('tanda_terima.*', 'customers.customer_name')
            ->get();


        return Datatables::of($terima)
            ->addColumn('item_name', function($terima){
                return '<div>'.$terima->item_name.' |<br>DP:'.number_format($terima->dp).'</div>';
            })
            ->addColumn('status', function($terima){
                if($terima->status==0){
                    return '<div style="text-align:center"><i class="fa fa-exclamation text-red"></i> Outstanding</div>'; }
                elseif($terima->status==1){
                    return '<div style="text-align:center"><i class="fa fa-check text-green"></i> Process</div>'; }
                elseif($terima->status==2){
                    return '<div style="text-align:center"><i class="fa fa-caret-square-o-right text-blue"></i> Selesai</div>'; }
                elseif($terima->status==4){
                    return '<div style="text-align:center"><i class="fa fa-remove text-red"></i> Batal</div>'; }

                
            })
            ->addColumn('estimasi_selesai', function($terima){
                return date('Y-m-d', strtotime('+'.$terima->estimasi_selesai.' days', strtotime( $terima->created_at)));
            })
            ->addColumn('action', function($terima){
                if($terima->status == 0){
                    return '<center><a id="btn-cetak" data-id="'.$terima->id.'" data-inv ="'.$terima->ttno.'" href="javascript:void(0)" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a><br>'.
                    '<a onclick="seePicture('. $terima->id.')" style="margin-bottom:2px;margin-top:2px;" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-picture"></i></a><br>'.
                    '<a onclick="editForm('. $terima->id.')" style="margin-bottom:2px;margin-top:2px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a><br>'.
                    '<a onclick="cancelForm('. $terima->id.')" style="margin-bottom:2px;margin-top:2px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-floppy-remove"></i></a><br>'.
                    '<a onclick="deleteData('. $terima->id.')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }

                elseif($terima->status == 1){
                    return '<center><a id="btn-cetak" data-id="'.$terima->id.'" data-inv ="'.$terima->ttno.'" href="javascript:void(0)" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a><br>'.
                    '<a onclick="seePicture('. $terima->id.')" style="margin-bottom:2px;margin-top:2px;" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-picture"></i></a><br>'.
                    '<a onclick="editForm('. $terima->id.')" style="margin-bottom:2px;margin-top:2px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a><br>'.
                    '<a onclick="cancelForm('. $terima->id.')" style="margin-bottom:2px;margin-top:2px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-floppy-remove"></i></a><br>'.
                    '<a onclick="deleteData('. $terima->id.')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }

                else{
                    return '<center><a id="btn-cetak" data-id="'.$terima->id.'" data-inv ="'.$terima->ttno.'" href="javascript:void(0)" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a><br>'.
                    '<a onclick="seePicture('. $terima->id.')" style="margin-bottom:2px;margin-top:2px;" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-picture"></i></a><br>'.
                    '<a disabled="disabled" style="margin-bottom:2px;margin-top:2px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a><br>'.
                    '<a disabled style="margin-bottom:2px;margin-top:2px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-floppy-remove"></i></a><br>'.
                    '<a disabled="disabled" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }


                
            })->rawColumns(['item_name','status','action'])->make(true);
    }


    public function cetakTerima($id)
    {
        
        $tanggal = date("Y-m-d");
        $bulan = substr($tanggal, 5,2);
        $tahun = substr($tanggal, 0,4);
        // var_dump($bulan);
        // exit();

        if($bulan == '01'){
            $romawi = 'I';
        }
        elseif($bulan =='02'){
            $romawi = 'II';
        }
        elseif($bulan =='03'){
            $romawi = 'III';
        }
        elseif($bulan =='04'){
            $romawi = 'IV';
        }
        elseif($bulan =='05'){
            $romawi = 'V';
        }
        elseif($bulan =='06'){
            $romawi = 'VI';
        }
        elseif($bulan =='07'){
            $romawi = 'VII';
        }
        elseif($bulan =='08'){
            $romawi = 'VIII';
        }
        elseif($bulan =='09'){
            $romawi = 'IX';
        }
        elseif($bulan =='10'){
            $romawi = 'X';
        }
        elseif($bulan =='11'){
            $romawi = 'XI';
        }
        elseif($bulan =='12'){
            $romawi = 'XII';
        }

        $stat = DB::table('tanda_terima')
                ->where('id', $id)
                ->where('status', 0)
                ->update(['status'=>1]);

        $profil = DB::table('profils')->first();
        $tt     = DB::table('tanda_terima')
                ->join('customers', 'customers.id', '=', 'tanda_terima.cust_id')
                ->where('tanda_terima.id', $id)
                ->select('tanda_terima.*', 'customers.customer_name', 'customers.customer_address', 'customers.customer_phone')
                ->first();
        // return view('pdf.tanda_terima', compact('profil', 'tt'));
        
        $pdf    = PDF::loadView('pdf.tanda_terima', compact('profil', 'tt', 'romawi', 'tahun'));
        $pdf->setPaper('a4', 'potrait');

        return $pdf->stream();
    }


    public function cancelTT(Request $request){


        $id = $request->id;

        DB::beginTransaction();
         
        $cancel = DB::table('tanda_terima')
                ->where('id', $id)
                ->update([
                    'status'=>4
                ]);

        $ttno = DB::table('tanda_terima')->where('id', $id)->select('ttno')->first();
        
        $cash = DB::table('cash_flows')
                ->where('document', $ttno->ttno)
                ->update([
                    'incash'=>0
                ]);

        if(!$cancel || !$cash){
            DB::rollback();
        }
        else{
            DB::commit();
        }
        

    }


    public function lihatGambar($id) {

        $tr = Tterima::findorFail($id);
        $foto = $tr->foto;
        $HTML = '';

        if($foto =='' || $foto == null) {
            $HTML .= '<center><h2 style="color:red;">No Image Inserted....! <h2/></center>';    
        }
        else{
            $HTML .= '<img class="img-responsive"  src="'.url('laravel/public/upload/terima').'/'.$foto.'" />';    
        }
        
        // $foto = '<h2>APLIKASI SERVICE</h2>';
        echo json_encode($HTML);

    }

}
