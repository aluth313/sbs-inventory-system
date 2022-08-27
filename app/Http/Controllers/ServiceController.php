<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use DB;
use App\ServiceTmp;
use App\Tterima;
use App\Job;
use App\Good;
use App\Teknisi;
use App\Service;
use PDF;
use App\Profil;

class ServiceController extends Controller
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
        
        return view('transaksi.service');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $job = Job::all();
        $good = Good::all();
        $tech = Teknisi::all();
        return view('transaksi.add_service', compact('job', 'good', 'tech'));
    }   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
        $kode_service = $request['job_name'];

        $tmp = DB::table('service_tmp')
                ->where('item_cd', $kode_service)
                ->where('kategori', 1)
                ->exists();

            
        if ($tmp == true)
        {
            $response = "exist";
            return $response;
        }
        else
        {
            
            $data = [
                'kategori'  => 1,
                'item_cd'   => $request['job_name'],
                'item_name' => $request['job_desc'],
                'uom'       => $request['uom'],
                'quantity'  => $request['quantity'],
                'price'     => $request['price'],
                'total'     =>$request['total']
            ];

            return ServiceTmp::create($data);

        }

       
    }



    public function storeBarang(Request $request)
    {

        $kode_barang = $request['good_name'];

        $tmp = DB::table('service_tmp')
                ->where('item_cd', $kode_barang)
                ->where('kategori', 2)
                ->exists();


        if ($tmp == true)
        {
            $response = "exist";
            return $response;
        }
        else
        {
            
            $data = [
                'kategori'  => 2,
                'item_cd'   => $request['good_name'],
                'item_name' => $request['good_desc'],
                'uom'       => $request['uom_barang'],
                'quantity'  => $request['quantity_barang'],
                'price'     => $request['price_barang'],
                'total'     =>$request['total_barang']
            ];

            return ServiceTmp::create($data);
        }  
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
        $service = ServiceTmp::findorfail($id);
        return $service;
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
        $tmp = ServiceTmp::findorfail($id);
        $input = $request->all();
        $tmp->update($input);
        return $tmp;
    }



    public function updateBarang($id, Request $request)
    {
        
        $tmp = DB::table('service_tmp')
            ->where('id', $request->id_barang)
            ->update([  'quantity' => $request->quantity_barang,
                        'total'=>$request->total_barang
                    ]);
        return $tmp;

    }
    

    public function destroy($id)
    {
        $service = ServiceTmp::destroy($id);

    }


    public function apiService()
    {
        $service = DB::table('services')
                    ->join('customers', 'customers.id', '=', 'services.cust_id')
                    ->join('teknisi', 'teknisi.id', '=', 'services.tech_id')
                    ->join('tanda_terima', 'tanda_terima.ttno', '=', 'services.ttno')
                    ->select('services.*', 'customers.customer_name', 'teknisi.nama', 'tanda_terima.item_name')
                    ->get();


        return Datatables::of($service)

            ->addColumn('status', function($service){
                if($service->status==0){
                    return '<div style="text-align:center"><i class="fa fa-exclamation text-red"></i></div>'; }
                elseif($service->status==1){
                    return '<div style="text-align:center"><i class="fa fa-check text-green"></i></div>'; }
            })    
            ->addColumn('total', function($service){
                return '<div style="text-align:right;">'.number_format($service->total).'</div>';
            })

            ->addColumn('action', function($service){
                if($service->status ==0){
                    return '<center>
                    <a id="btn_cetak_service" data-inv ="'.$service->invoice.'" data-tt = "'.$service->ttno.'"  style="margin-left:10px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
                    '<a href="'.url('edit_service').'/'.$service->invoice.'/'.$service->ttno.'" style="margin-left:10px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                    '<a id="btn_hapus_service" data-id = "'.$service->id.'" data-inv = "'.$service->invoice.'" data-tt = "'.$service->ttno.'" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';    
                }else{
                    return '<center>
                    <a id="btn_cetak_service" data-inv ="'.$service->invoice.'" data-tt = "'.$service->ttno.'"  style="margin-left:10px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
                    '<a disabled="disabled" style="margin-left:10px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                    '<a disabled="disabled" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }
                
            })->rawColumns(['status','total','action'])->make(true);
    }



    public function apiServiceTmp()
    {
        $tmp = DB::table('service_tmp')
                ->get();

        return Datatables::of($tmp)
            ->addColumn('quantity', function($tmp){
                return '<div style="text-align:right">'.$tmp->quantity.'</div>';
            })
            ->addColumn('price', function($tmp){
                return '<div style="text-align:right">'.number_format($tmp->price).'</div>';
            })
            ->addColumn('total', function($tmp){
                return '<div style="text-align:right">'.number_format($tmp->total).'</div>';
            })
            ->addColumn('action', function($tmp){
                if($tmp->kategori == 1){
                    return '<center><a onclick="editJasa('.$tmp->id.')" style="margin-left:10px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                    '<a onclick="deleteData('. $tmp->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }else{
                    return '<center><a onclick="editBarang('.$tmp->id.')" style="margin-left:10px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                    '<a onclick="deleteData('. $tmp->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }
                
            })->rawColumns(['quantity','price','total','action'])->make(true);
    }


    public function apiServiceTerima()
    {
        $tt = DB::table('tanda_terima')
                ->join('customers', 'customers.id', '=', 'tanda_terima.cust_id')
                ->where('tanda_terima.status', '<', 2 )
                ->select('tanda_terima.*', 'customers.customer_name')
                ->get();

        return Datatables::of($tt)
            ->addColumn('action', function($tt){
                return '<center><a onclick="pilihTerima('. $tt->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-check"></i> Pilih</a>';
            })->rawColumns(['total','action'])->make(true);
    }


    public function pilihTerima($id)
    {
        
        $tt = DB::table('tanda_terima')
            ->where('tanda_terima.id', $id)
            ->join('customers', 'customers.id', '=', 'tanda_terima.cust_id')
            ->select('tanda_terima.*', 'customers.id as customer_id', 'customers.customer_name', 'customers.customer_address')
            ->get();

        return $tt;
    }



    public function tambahJasa($id)
    {
        $job = Job::findorfail($id);
        return $job;
    }



    public function tambahBarang($id)
    {
        $good = Good::findorfail($id);
        return $good;
    }



    public function totalService()
    {

        $total_transaksi = DB::table('service_tmp')
                        ->select(DB::raw('sum(total) as Total'))
                        ->get();
        return $total_transaksi;
    }


    public function simpanService(Request $request)
    {
       
        DB::beginTransaction();

                $kd = new PurchaseController();

                $kode = $kd->autonumber('services','id','SV-');

                $sv = new Service;

                

                $sv->invoice = $kode;
                $sv->created_at = $request->tgl_trans;
                $sv->ttno = $request->ttno;
                $sv->cust_id = $request->cust;
                $sv->tech_id = $request->teknisi;
                $sv->note = $request->ket;
                $sv->fak_no = $request->fakno;
                $sv->do_no = $request->dono;
                $sv->po_no = $request->pono;
                $sv->total = $request->total;
                $sv->dp = $request->dp;
                $sv->pembayaran = $request->dp;
                $sv->sisa = $request->total - $request->dp;
                $sv->save();

                $js = DB::table('service_tmp')->where('kategori', 1)->get();
                foreach ($js as $key) {
                    $its = DB::table('service_item_job')->insert([
                        'invoice'       =>  $kode,
                        'kategori'      =>  $key->kategori,
                        'item_cd'       =>  $key->item_cd,
                        'item_name'     =>  $key->item_name,
                        'uom'           =>  $key->uom,
                        'quantity'      =>  $key->quantity,
                        'price'         =>  $key->price,
                        'total'         =>  $key->total, 
                        'created_at'    =>  $request->tgl_trans
                                    
                    ]);
                }

                $br = DB::table('service_tmp')->where('kategori', 2)->get();
                foreach ($br as $key) {
                    $itg = DB::table('service_item_good')->insert([
                        'invoice'       =>  $kode,
                        'kategori'      =>  $key->kategori,
                        'item_cd'       =>  $key->item_cd,
                        'item_name'     =>  $key->item_name,
                        'uom'           =>  $key->uom,
                        'quantity'      =>  $key->quantity,
                        'price'         =>  $key->price,
                        'total'         =>  $key->total, 
                        'created_at'    =>  $request->tgl_trans
                                    
                    ]);

                    DB::table('stocks')->insert([
                        'id_good'=>$key->item_cd,
                        'type'=>'sales',
                        'document'=>$kode,
                        'in'=>0,
                        'out'=>$key->quantity,
                        'created_at'=> $request->tgl_trans
                    ]);

                }

                $dt = DB::table('service_tmp')->delete();

                $st = DB::table('tanda_terima')
                        ->where('ttno', $request->ttno)
                        ->update(['status'=>2]);
        
        if(!$sv || !$dt || !$st){
            DB::rollback();
        }
        else{
            DB::commit();
        }        
    }


    public function batalService()
    {

        return $dt = DB::table('service_tmp')->delete();        

    }


    public function hapusService(Request $request)
    {
        $id = $request['id'];
        $invoice = $request['invoice'];
        $ttno = $request['ttno'];

        DB::beginTransaction();
            $a = DB::table('services')->where('id', $id)->delete();
            $b = DB::table('service_item_good')->where('invoice', $invoice)->delete();
            $stk = DB::table('stocks')->where('document', $invoice)->delete();
            $c = DB::table('service_item_job')->where('invoice', $invoice)->delete();
            $st = DB::table('tanda_terima')
                        ->where('ttno', $ttno)
                        ->update(['status'=>1]);

        if(!$a || !$st || !$stk)
        {
            DB::rollback();    
        }
        else
        {
            DB::commit();  
            return "true";

        }           

    }


    public function editService($invoice, $ttno)
    {
        
        $tt = DB::table('tanda_terima')
            ->join('customers', 'customers.id', '=', 'tanda_terima.cust_id')
            ->where('ttno', $ttno)
            ->select('tanda_terima.*','customers.id as customer_id' ,'customers.customer_name','customers.customer_address')
            ->first();

        $tmp = DB::table('service_tmp')->delete();    

        $sv = DB::table('service_item_job')->where('invoice', $invoice)->get();
        foreach ($sv as $key) {
            DB::table('service_tmp')->insert([
                'kategori' => $key->kategori,
                'item_cd'=>$key->item_cd,
                'item_name'=>$key->item_name,
                'uom'=>$key->uom,
                'quantity'=>$key->quantity,
                'price'=>$key->price,
                'total'=>$key->total
            ]);
        }


        $br = DB::table('service_item_good')->where('invoice', $invoice)->get();
        foreach ($br as $key) {
            DB::table('service_tmp')->insert([
                'kategori' => $key->kategori,
                'item_cd'=>$key->item_cd,
                'item_name'=>$key->item_name,
                'uom'=>$key->uom,
                'quantity'=>$key->quantity,
                'price'=>$key->price,
                'total'=>$key->total
            ]);
        }

        $service = DB::table('services')
            ->join('teknisi', 'teknisi.id', '=', 'services.tech_id')
            ->where('invoice', $invoice)
            ->select('teknisi.nama','services.tech_id','services.invoice', 'services.fak_no', 'services.do_no', 'services.po_no', 'services.note','services.created_at')
            ->first();

        $job = Job::all();
        $good = Good::all();
        $tech = Teknisi::all();
        return view('transaksi.edit_service', compact('job', 'good', 'tech', 'tt', 'service'));
    }



    public function updateService(Request $request)
    {
       
    
        // DB::beginTransaction();

            
                $kode = $request->invoice;

                $sv = DB::table('services')
                        ->where('invoice', $kode)
                        ->update([
                                    'tech_id'   =>$request->teknisi,
                                    'fak_no'    =>$request->fakno,
                                    'do_no'     =>$request->dono,
                                    'po_no'     =>$request->pono,
                                    'note'      =>$request->ket,
                                    'total'     =>$request->total,
                                    'created_at'=>$request->tgl_trans
                                ]);




                $jsd = DB::table('service_item_job')->where('invoice', $kode)->delete();

                $js = DB::table('service_tmp')->where('kategori', 1)->get();
                foreach ($js as $key) {
                    $its = DB::table('service_item_job')->insert([
                        'invoice'       =>  $kode,
                        'kategori'      =>  $key->kategori,
                        'item_cd'       =>  $key->item_cd,
                        'item_name'     =>  $key->item_name,
                        'uom'           =>  $key->uom,
                        'quantity'      =>  $key->quantity,
                        'price'         =>  $key->price,
                        'total'         =>  $key->total, 
                        'created_at'    =>  $request->tgl_trans
                                    
                    ]);
                }

                $brd = DB::table('service_item_good')->where('invoice', $kode)->delete();
                $sdel = DB::table('stocks')->where('document', $kode)->delete();

                $br = DB::table('service_tmp')->where('kategori', 2)->get();
                foreach ($br as $key) {
                    $itg = DB::table('service_item_good')->insert([
                        'invoice'       =>  $kode,
                        'kategori'      =>  $key->kategori,
                        'item_cd'       =>  $key->item_cd,
                        'item_name'     =>  $key->item_name,
                        'uom'           =>  $key->uom,
                        'quantity'      =>  $key->quantity,
                        'price'         =>  $key->price,
                        'total'         =>  $key->total, 
                        'created_at'    =>  $request->tgl_trans
                                    
                    ]);

                    DB::table('stocks')->insert([
                        'id_good'=>$key->item_cd,
                        'type'=>'sales',
                        'document'=>$kode,
                        'in'=>0,
                        'out'=>$key->quantity,
                        'created_at'=> $request->tgl_trans
                    ]);

                }

                $dt = DB::table('service_tmp')->delete();

                
        
        // if(!$sv || !$dt || !$sdel){
        //     DB::rollback();
        // }
        // else{
        //     DB::commit();
        // }        
    }



    public function cetakService($invoice)
    {
        
        $status = DB::table('services')->where('invoice', $invoice)->update(['status'=>1]);

        $profil = Profil::all()->first();
        $tt = DB::table('services')
                ->join('customers', 'customers.id', '=', 'services.cust_id')
                ->join('tanda_terima', 'tanda_terima.ttno', '=', 'services.ttno')
                ->join('teknisi', 'teknisi.id', '=', 'services.tech_id')
                ->where('services.invoice', $invoice)
                ->select('services.*', 'customers.customer_name', 'customers.customer_address', 'customers.customer_phone', 'tanda_terima.item_name', 'tanda_terima.tipe', 'tanda_terima.sn', 'tanda_terima.keterangan', 'teknisi.nama')
                ->first();
        $sv = DB::table('service_item_job')->where('invoice', $invoice)->get();
        $br = DB::table('service_item_good')->where('invoice', $invoice)->get();     
        $pdf    = PDF::loadView('pdf.service', compact('profil', 'tt', 'sv', 'br'));
        $customPaper = array(0,0,950,950);
        $pdf->setPaper('legal', 'potrait');

        return $pdf->stream();
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

   
}
