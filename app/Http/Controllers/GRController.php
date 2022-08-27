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

class GRController extends Controller
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
        return view('transaksi.gr');
    }


    public function addgr()
    {
        return view('transaksi.add_gr');
    }
    
    
    public function editgr($grno)
    {
        $grdata = DB::table('goodreceipt')->where('gr_no', $grno)->get()->first();
        $gritem = DB::table('goodreceipt_details')
                    ->select('goodreceipt_details.*', 'materials.material_name')
                    ->join('materials', 'materials.id', '=', 'goodreceipt_details.item_cd', 'left')
                    ->where('goodreceipt_details.gr_no', $grno)->get();
        
        
        return view('transaksi.edit_gr', compact('grdata', 'gritem'));
    }
    
    public function pilihPurchaseOrder(Request $request)
    {   
        $input = $request->all();
        $invoice = $input['invoice'];
        
        $po = DB::table('purchase_details')
        ->select('purchase_details.*', 'materials.material_name')
        ->join('materials', 'materials.id', '=', 'purchase_details.item_cd', 'left')        
        ->where('purchase_details.invoice', $invoice)->get();
        
        $html = '';
        foreach($po as $key) {
            $sisa = $key->quantity - $key->qty_received;
            
            $tot = $sisa * $key->item_price;
            if($sisa > 0 ) 
            {
                $html .= '<tr id="tr_'.$key->id.'">';
                $html .= '<td>'.$key->id.'<input value="'.$key->id.'" type ="hidden" id="id_'.$key->id.'" name="id[]"></td>';
                $html .= '<td>'.$key->item_cd.'<input value="'.$key->item_cd.'" type ="hidden" id="itemcd_'.$key->id.'" name="itemcd[]"></td>';
                $html .= '<td>'.$key->material_name.'<input value="'.$key->material_name.'" type="hidden" id="materialname_'.$key->id.'" name="materialname[]"></td>';
                $html .= '<td>'.$key->item_unit.'<input value="'.$key->item_unit.'" type="hidden" id="itemunit_'.$key->id.'" name="itemunit[]"></td>';
                $html .= '<td style="text-align:right;"><span id="pricetext_'.$key->id.'">'.number_format($key->item_price,2).'</span><input value="'.$key->item_price.'" type="hidden" id="price_'.$key->id.'" name="price[]"></td>';
                $html .= '<td style="text-align:right;"><span id="quantitytext_'.$key->id.'">'.number_format($sisa, 2).'</span><input value="'.$sisa.'" type="hidden" id="quantity_'.$key->id.'" name="quantity[]"><span style="display:none;" id="frame_'.$key->id.'"><input value="'.$sisa.'" type="text" id="qtyinput_'.$key->id.'"><a onclick="cek('.$key->id.')" href="javascript:void(0);"><i class="fa fa-check-circle"></i></a></span></td>';
                $html .= '<td style="text-align:right;"><span id="itemtotaltext_'.$key->id.'">'.number_format($tot, 2).'</span><input value="'.$tot.'" type="hidden" id="itemtotal_'.$key->id.'" name="itemtotal[]"></td>';
                $html .= '<td><center><a title="Edit Item" style="width:30px;" onclick="edititem('.$key->id.')" href="javascript:void(0);" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a><a title="Hapus Item" style="margin-left:10px;width:30px;" onclick="deleteitem('.$key->id.')" href="javascript:void(0);" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></center></td>';
                $html .= '</tr>';    
            }
            
        }
        
        return $html;
    }
    
    
    public function savedata(Request $request)
    {
        $input = $request->all();
        
        $deskripsi = $input['deskripsi'];
        $gudang = $input['gudang'];
        $ponumber = $input['ponumber'];
        $grno = $this->autonumber('goodreceipt', 'id', 'GR');
        
        $id = $input['id'];
        $itemcd = $input['itemcd'];
        $materialname = $input['materialname'];
        $itemunit = $input['itemunit'];
        $price = $input['price'];
        $quantity = $input['quantity'];
        $idsupp = $input['supplierid'];
        
        $itemtotal = $input['itemtotal'];
        
        $stotal = 0;
        foreach($itemtotal as $it)
        {
            $stotal = $stotal + $it;
        }
        
        $insert = [
            "gr_no" => $grno,
            "po_no" => $ponumber,
            "description" => $deskripsi,
            "supplier_id" => $idsupp,
            "user_id" => Auth::user()->id,
            "total" => $stotal,
            "gudang" => $gudang,
            "status" => 0,
        ];
        
        $response = DB::table('goodreceipt')->insert($insert);
        if($response)
        {
            for($i=0; $i<count($id); $i++)
            {
                $item = [
                    "ids" => $id[$i],
                    "gr_no" => $grno,
                    "po_no" => $ponumber,
                    "gudang" => $gudang,
                    "item_cd" => $itemcd[$i],
                    "quantity" => $quantity[$i],
                    "item_unit" => $itemunit[$i],
                    "item_price" => $price[$i],
                    "item_total" => $itemtotal[$i],
                    
                ];
                
                DB::table('goodreceipt_details')->insert($item);
            }
        }
        
        return response()->json($response);
    }
    
    
    
    public function updatedata(Request $request)
    {
        $input = $request->all();
        
        $deskripsi = $input['deskripsi'];
        $gudang = $input['gudang'];
        $ponumber = $input['ponumber'];
        $grno = $input['grno'];
        
        $id = $input['id'];
        $itemcd = $input['itemcd'];
        $materialname = $input['materialname'];
        $itemunit = $input['itemunit'];
        $price = $input['price'];
        $quantity = $input['quantity'];
        $idsupp = $input['supplierid'];
        
        $itemtotal = $input['itemtotal'];
        
        $stotal = 0;
        foreach($itemtotal as $it)
        {
            $stotal = $stotal + $it;
        }
        
        
        $insert = [
            "po_no" => $ponumber,
            "description" => $deskripsi,
            "supplier_id" => $idsupp,
            "user_id" => Auth::user()->id,
            "total" => $stotal,
            "gudang" => $gudang,
            "status" => 0,
        ];
        
        $response = DB::table('goodreceipt')->where('gr_no', $grno)
        ->update($insert);
        if($response)
        {
            $del = DB::table('goodreceipt_details')->where('gr_no', $grno)
                ->delete();
            
            if($del)
            {
                for($i=0; $i<count($id); $i++)
                {
                    $item = [
                        "ids" => $id[$i],
                        "gr_no" => $grno,
                        "po_no" => $ponumber,
                        "gudang" => $gudang,
                        "item_cd" => $itemcd[$i],
                        "quantity" => $quantity[$i],
                        "item_unit" => $itemunit[$i],
                        "item_price" => $price[$i],
                        "item_total" => $itemtotal[$i],
                        
                    ];
                    
                    DB::table('goodreceipt_details')->insert($item);
                }
            }
            
        }
        
        return response()->json($response);
    }
    
    
    public function deletedata(Request $request)
    {
        $input = $request->all();
        $invoice = $input['invoice'];
        $id = $input['id'];
        
        $response = DB::table('goodreceipt')->where('gr_no', $invoice)->delete();
        if($response)
        {
            DB::table('goodreceipt_details')->where('gr_no', $invoice)->delete();
        }
        
        return response()->json($response);
    }
    
    
    
    public function printdata($id, $invoice){
        
        $status = DB::table('goodreceipt')
                    ->where('id', $id)
                    ->update([ 'status'=>1 ]);

        $profil = DB::table('profils')->first();

        $data = DB::table('goodreceipt')
                    ->join('suppliers', 'suppliers.id','=','goodreceipt.supplier_id')
                    ->where('goodreceipt.id', $id)
                    ->select('goodreceipt.*', 'suppliers.*')
                    ->first();

        $details = DB::table('goodreceipt_details')
                    ->join('materials', 'materials.id', '=', 'goodreceipt_details.item_cd')
                    ->where('goodreceipt_details.gr_no', $invoice)
                    ->select('goodreceipt_details.*', 'materials.material_name')
                    ->get();

        $pdf = PDF::loadView('pdf.gr', compact('profil', 'data', 'details'));
        $pdf->setPaper('a4', 'potrait');

        return $pdf->stream();
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
    
    
    
    
    
    
    
    //  DATATABLES
     public function apiGR(){
        $gr = DB::table('goodreceipt')
                   ->join('suppliers', 'suppliers.id', '=', 'goodreceipt.supplier_id')
                   ->select('goodreceipt.*', 'suppliers.supplier_name')
                   ->orderBy('goodreceipt.id','desc')
                   ->get();

       

        return Datatables::of($gr) 
            ->addColumn('total', function($gr){
                return '<div style="text-align:right;">'.number_format($gr->total, 2).'</div>';
            })
         
            ->addColumn('action', function($gr){
                if($gr->status == 0){
                        return '<center>
                            <a id="btn-cetak" data-id = "'.$gr->id.'" data-inv = "'.$gr->gr_no.'" style="margin-left:5px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
                            '<a href="'.url('editgr').'/'.$gr->gr_no.'" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                            '<a id="btn-hapus" data-id = "'.$gr->id.'" data-inv = "'.$gr->gr_no.'" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }else{
                    return '<center><a id="btn-cetak" data-id = "'.$gr->id.'" data-inv = "'.$gr->gr_no.'" style="margin-left:5px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
                            '<a disabled="disabled" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                            '<a disabled="disabled" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                            
                }
                
            })->rawColumns(['total','action'])->make(true);
    }
    
    
    
    //  DATATABLES
     public function apiListPO(){
        $list = DB::table('purchases')
                   ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
                   ->select('purchases.*', 'suppliers.id as idsupplier', 'suppliers.supplier_name')
                   ->orderBy('purchases.id','desc')
                   ->get();
        
        
        return Datatables::of($list) 
            
            ->addIndexColumn()
            ->addColumn('created_at', function($list){
                return '<center>'.date('d-m-Y', strtotime($list->created_at)).'</center>';
            })
            ->addColumn('action', function($list){
                return '<center>
                            <a id="pilihpurchaseorder" data-supplier="'.$list->idsupplier.'" data-invoice="'.$list->invoice.'" style="text-align:center;" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-check"></i> Pilih</a></center>';
            })
            ->addColumn('total', function ($list){
                return '<div style="text-align:right;">'.number_format($list->total) .'</div>';    
            })
            ->rawColumns(['created_at', 'total', 'action'])->make(true);
    }


}
