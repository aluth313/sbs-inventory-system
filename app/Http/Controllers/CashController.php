<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Cash;
use DB;
use PDF;
use App\Profil;

class CashController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transaksi.cash');
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
        $kode = $kd->autonumber('cashes','id','CH-');
        
        $input = $request->all();
        $input['cash_number'] = $kode;
        
        $cash = Cash::create($input);
        return $cash;

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
        $cash = Cash::findorfail($id);
        $cash['trans_date'] = date("Y-m-d", strtotime($cash['trans_date']));
        return $cash;   
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
        $cash = Cash::findorfail($id);

        $cash->update($input);

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
        $cash = Cash::destroy($id);
    }


    public function apiCash(){
        $cash = Cash::all();

        return Datatables::of($cash) 

            ->addColumn('cash_value', function($cash){
                return '<div style="text-align:right;">Rp. '.number_format($cash->cash_value).'</div>';
            })

            ->addColumn('category', function($cash){
                if($cash->category=='1'){
                    return '<div>Kas Masuk</div>';    
                }else{
                    return '<div>Kas Keluar</div>'; 
                }
            })

            ->addColumn('created_at', function($cash){
                return '<div>'.date("d-m-Y", strtotime($cash->created_at)).'</div>';
            })

            ->addColumn('trans_date', function($cash){
                return '<div>'.date("d-m-Y", strtotime($cash->trans_date)).'</div>';
            })

            ->addColumn('action', function($cash){
                
                return '<center><a onclick="printData('. $cash->id.')" style="margin-left:10px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
                    '<a onclick="editForm('. $cash->id.')" style="margin-left:10px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                    '<a onclick="deleteData('. $cash->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
            
            })->rawColumns(['trans_date', 'created_at','category','cash_value', 'action'])->make(true);
    }


    public function cetakCash($id)
    {    
        
        $profil =   DB::table('profils')->first();
        
        $cash =  DB::table('cashes')->
                    where('id', $id)->
                    get()->first();

        $pdf =      PDF::loadView('pdf.cash', compact('profil','cash'));
        $pdf->      setPaper('a4', 'potrait');

        return $pdf->stream();
    }


    public function cashReport()
    {
        return view('laporan.cash');
    }


    public function laporanCash($dari, $sampai)
    {
        
        $tgl = date('Y-m-d', strtotime('+1 days', strtotime($sampai)));
        $cash = DB::table('cashes')
                ->whereBetween('trans_date', [$dari, $tgl])
                ->get();

        $profil = Profil::all()->first();
        $pdf =      PDF::loadView('pdf.lap_cash', compact('profil','dari','sampai','cash'));
        $pdf->      setPaper('a4', 'potrait');

        return $pdf->stream();
    }
}
