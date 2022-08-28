<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use DB;
use PDF;
use App\Material;
use App\Good;
use App\TmpProduction;
use App\Production;
use App\Customer;
use App\Profil;
use Illuminate\Support\Facades\Auth;

class ProductionController extends Controller
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
        return view('transaksi.production');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cekCart()
    {
        return count(TmpProduction::all());
    }


    public function addProduction()
    {
        $material = Material::all();
        $barang = Good::all();
        $customer = Customer::all();
        TmpProduction::truncate();
        DB::table('materialconsume')->delete();
        $batch = DB::table('antrian')->get();
        return view('transaksi.add_production', compact('barang', 'material', 'batch', 'customer'));
    }
    
    public function addProductionAutomationFill($id)
    {
        $material = Material::all();
        $barang = Good::all();
        $customer = Customer::all();
        TmpProduction::truncate();
        DB::table('materialconsume')->delete();
        $batch = DB::table('antrian')->get();
        $good = Good::find($id);
        return view('transaksi.add_production_automationfill', compact('barang', 'good', 'material', 'batch', 'customer'));
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
        $hapus = TmpProduction::findorfail($id);
        $itemcode = $hapus->item_cd;
        $hapus->delete();
        
        DB::table('materialconsume')->where('id_product', $itemcode)->delete();
        return $hapus;

    }
    
    
    public function listproduksiantrian($id, $inv)
    {
        
        $query = DB::table('production_batch')
            ->join('goods', 'goods.id','=', 'production_batch.item_cd', 'left' )
            ->select('production_batch.*', 'goods.good_name')
            ->where('production_number', $inv)
            ->get();
        
        $html = '';
        $html .= '<table id="table-produksi-batch" class="table table-bordered table-striped">';
        $html .= '<thead>';
        $html .= '<th>No</th>';
        $html .= '<th>Prod Number</th>';
        $html .= '<th>Tanggal</th>';
        $html .= '<th>Batch</th>';
        $html .= '<th>Nama Item</th>';
        $html .= '<th>Qty</th>';
        $html .= '<th>Antrian</th>';
        $html .= '<th colspan="2">Aksi</th>';
        $html .= '</thead>';
        
        $html .= '<tbody>';
        $nomor = 0;
        foreach($query as $i =>$k)
        {
            if(@$query[$i+1]->production_number != $k->production_number)
            {
                $nomor++;
                $html .= '<tr>';
                $html .='<td>'.$nomor.'</td>';
                $html .='<td>'.$k->production_number.'</td>';
                $html .='<td>'.date('d-m-Y', strtotime($k->created_at)).'</td>';
                $html .='<td> Batch 0'.$k->batch.'</td>';
                $html .='<td>'.$k->good_name.'</td>';
                $html .='<td style="text-align:right;">'.$k->quantity.'</td>';
                $html .='<td style="text-align:right;">'.$k->antrian.'</td>';
                $html .='<td><center><a onclick="adjustmaterial('.$k->id.', '.$k->quantity.')" href="javascript:void(0);">Adjust</a></center></td>';
                $html .='<td><center><a onclick="printbatch('.$k->id.')" href="javascript:void(0);">Print</a></center></td>';
                $html .='</tr>'; 
            }
            
        }
        $html .= '</tbody>'; 
        $html .= '</table>';
        
        return $html;
    }


    public function adjust(Request $request)
    {
        $input = $request->all();
        $quan = $input['qt'];
        $query = DB::table('production_batch')
                    ->where('id', $input['id']) 
                    ->first();
                    
        $prodnumber = $query->production_number;
        
        $count = DB::table('production_batch')->where('production_number', $prodnumber)->get()->count();
        
        $material = DB::table('materialused')
                    ->select('materialused.*', 'materials.id as idmaterial', 'materials.material_name')
                    ->join('materials', 'materials.id', '=', 'materialused.id_material')
                    ->where('materialused.production_number', $prodnumber)->get();
            
        $html ='';
        $html .= '<table id="table-adjust" class="table table-bordered table-striped">';
        $html .= '<thead>';
        $html .= '<th>No</th>';
        $html .= '<th>Prod Number</th>';
        $html .= '<th>Nama Material</th>';
        $html .= '<th>Qty</th>';
        $html .= '<th>Adjust Qty</th>';
        $html .= '<th>Adjust (%)</th>';
        $html .= '</thead>';
        
        $html .= '<tbody>';
        $nomor = 0;
        
        foreach($material as $m)
        {
            
            $qtt = $m->qty_material/$count;
            $adm = $m->adjustment;
            $persen = ($adm * 100)/$qtt;
            
            
            
            $nomor++;
            $html .= '<tr>';
            $html .='<td>'.$nomor.'<input type="hidden" name="id[]" value="'.$m->id.'"></td>';
            $html .='<td>'.$prodnumber.'</td>';
            $html .='<td>'.$m->material_name.'<input type="hidden" name="idmaterial[]" value="'.$m->idmaterial.'"></td>';
            $html .='<td style="text-align:right;">'.number_format(($m->qty_material/$count), 4).'</td>';
            
            $html .='<td><center><input type="text" value="'.$m->adjustment.'" id="ad_'.$m->id.'" name="ad[]"></td>';
             $html .='<td><center><input value="'.$persen.'" onkeyup="adjustpersen('.$m->id.', '.$m->qty_material.', '.$count.')" type="text" value="0" id="adper_'.$m->id.'" name="adper[]"></td>';
            $html .='</tr>'; 
        }
        
        $html .= '</tbody>'; 
        $html .= '</table>';
                    
        return $html;            
    }
    
    public function updateadjust(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $value = $input['ad'];
        $batch = $input['idbatch'];
        $idmaterial = $input['idmaterial'];
        $persen = $input['adper'];
        
        $hapusadjust = DB::table('material_adjustment')
            ->where('idbatch', $batch)
            ->delete();
        
            $pb = DB::table('production_batch')->where('id', $batch)->first();
            $pn = $pb->production_number;
            
            
            for($i=0; $i< count($id); $i++)
            {
                    
                if($value[$i] > 0)
                {
                    DB::table('material_adjustment')->insert([
                        "prod_number" => $pn,
                        "id_material" => $idmaterial[$i],
                        "qty_adjust" => $value[$i],
                        "idbatch" => $batch,
                        "persen" => $persen[$i]
                    ]);
                    
                }
            }
        
        
        
        
        return response()->json(true);
        
    }



    public function cari($barang){
        $brg = Good::findorfail($barang);
        return $brg;
    }



    public function simpanItemProduksi(Request $request){

        $kd = $request->barang;

        $brg = DB::table('production_tmp')->where('item_cd', $kd)->exists();

        if ($brg == true) {
            $response = "exist";
            echo json_encode($response);
        }
        else{

            $tmp = new TmpProduction;
            $tmp->item_cd = $request->barang;
            $tmp->quantity = $request->jumlah;
            $tmp->item_price = $request->harga;
            $tmp->item_unit = $request->satuan;
            $tmp->item_total = $request->total;


            $tmp->save();
            $hit = DB::table('materialcombines')
            ->join('materials', 'materials.id', '=', 'materialcombines.id_material')
            ->where('materialcombines.id_product', $kd)
            ->where('materials.kategori', '!=', 76)
            ->select('materialcombines.*', 'materials.material_name','materials.stok','materials.kategori','materials.id as idmaterial')
            ->get();
            $bat=floor($request->jumlah /100);
            $tot = 0;
			foreach($hit as $i => $m) {
			    $nilai = $m->qty_material * 100;
			    $tot = $tot + $nilai;
            }
            // $bahanbaku = DB::table('materialcombines')->where('id_product', $kd)->get();
            $bahanbaku = DB::table('materialcombines')
            ->join('materials', 'materials.id', '=', 'materialcombines.id_material')
            ->where('materialcombines.id_product', $kd)
            ->select('materialcombines.*', 'materials.material_name','materials.stok','materials.kategori','materials.id as idmaterial')
            ->get();

            foreach($bahanbaku as $bb) 
            {
                
                if($bb->kategori == "76"){
                    $qtyneeded = (number_format($bb->qty_material * $tot,4)/1000)*$bat;
                    $idmaterial = $bb->id_material;
                    DB::table('materialconsume')->insert([
                        "id_product" => $kd,
                        "id_material" => $idmaterial,
                        "qty_material" => number_format($qtyneeded,4)
                     ]);
                }else{
                    $idmaterial = $bb->id_material;
                    $qty = $bb->qty_material * $request->jumlah;
                    
                    DB::table('materialconsume')->insert([
                       "id_product" => $kd,
                       "id_material" => $idmaterial,
                       "qty_material" => $qty
                    ]);
                }
            }

            return $tmp;
        }
        
    }
    



    public function simpanProduksi(Request $request){

        $table="productions";
        $primary="id";
        $prefix="PRD-";
        $kode=$this->autonumber($table,$primary,$prefix);
        
        //// simpan header

        $pcs = new Production;
        $pcs->production_number = $kode;
        $pcs->description = $request['deskripsi'];
        $pcs->user_id = Auth::user()->id;
        $pcs->total = DB::table('production_tmp')->sum('item_total');
        $pcs->batch = $request['batch'];
        $pcs->id_customer = $request['customer'];
        $pcs->grade = $request['grade'];
        $pcs->colour = $request['colour'];
        $pcs->hardness = $request['hardness'];

        $pcs->save();

        $query = DB::table('production_tmp')
                ->select('*')
                ->get();
       
        
        //simpan item
        foreach ($query as $key) {
            $barang = $key->item_cd;
            $satuan = $key->item_unit;
            $harga = $key->item_price;
            $jumlah = $key->quantity;
            $total = $key->item_total;

            DB::table('production_details')->insert([
                    'production_number' => $kode ,
                    'item_cd' => $barang,
                    'quantity'=> $jumlah,
                    'item_unit' =>$satuan,
                    'item_price'=>$harga,
                    'item_total'=>$total, 
                    'created_at'=> date("Y-m-d H:i:s")
                    
            ]);

            // revisi 

            DB::table('stocks')->insert([
                'id_good'=>$barang,
                'type'=>'production',
                'document'=>$kode,
                'in'=>$jumlah,
                'out'=>0,
                'created_at'=> date("Y-m-d H:i:s")
            ]);
            
            
            if($jumlah > 100)
            {
                $div = floor($jumlah/100);
                $sisa = $jumlah % 100;
                
                for($i=0; $i<$div; $i++)
                {
                    $d = DB::table('production_batch')->where('batch', $request['batch'])->max('antrian');

                    if($d == null )
                    {
                        $urutanantrian = 1;    
                    }
                    else
                    {
                        $urutanantrian = $d + 1;
                    }
                    
                    
                    DB::table('production_batch')->insert([
                       "production_number" =>  $kode,
                       "item_cd" => $barang,
                       "quantity" => 100,
                       "item_unit" => $satuan,
                       "item_price" => $harga,
                       "item_total" => $harga * 100,
                       "batch" => $request['batch'],
                       "antrian" => $urutanantrian
                    ]);
                
                }
                
                if($sisa > 0)
                {
                    $d = DB::table('production_batch')->where('batch', $request['batch'])->max('antrian');
    
                    if($d == null )
                    {
                        $urutanantrian = 1;    
                    }
                    else
                    {
                        $urutanantrian = $d + 1;
                    }
                    
                    
                    DB::table('production_batch')->insert([
                       "production_number" =>  $kode,
                       "item_cd" => $barang,
                       "quantity" => $sisa,
                       "item_unit" => $satuan,
                       "item_price" => $harga,
                       "item_total" => $harga * $sisa,
                       "batch" => $request['batch'],
                       "antrian" => $urutanantrian
                    ]);
                }
                
                
                
            }
            else
            {
                $d = DB::table('production_batch')->where('batch', $request['batch'])->max('antrian');

                if($d == null )
                {
                    $urutanantrian = 1;    
                }
                else
                {
                    $urutanantrian = $d + 1;
                }
                
                
                DB::table('production_batch')->insert([
                   "production_number" =>  $kode,
                   "item_cd" => $barang,
                   "quantity" => $jumlah,
                   "item_unit" => $satuan,
                   "item_price" => $harga,
                   "item_total" => $harga * $jumlah,
                   "batch" => $request['batch'],
                   "antrian" => $urutanantrian
                ]);
            }
           
        }
        
        

        DB::table('production_tmp')->delete();
        
        $consume = DB::table('materialconsume')->get();
        
        foreach($consume as $cs )
        {
           
            // $cari = DB::table('materialused')
            //     ->where('production_number', $kode)
            //     ->where('id_product', $cs->id_product)
            //     ->where('id_material', $cs->id_material)
            //     ->get();

            // if(count($cari) > 0 ) 
            // {
            //     DB::table('materialused')
            //     ->where('production_number', $kode)
            //     ->where('id_product', $cs->id_product)
            //     ->where('id_material', $cs->id_material)
            //     ->update([
            //        "qty_material" => $cari[0]->qty_material + $cs->qty_material
            //     ]);
            // }
            // else
            // {
                DB::table('materialused')
                ->insert([
                   "production_number" => $kode,
                   "id_product" => $cs->id_product,
                   "id_material" => $cs->id_material,
                   "qty_material" => $cs->qty_material
                ]);
            // }    


        }
        
        DB::table('materialconsume')->delete();
        
        return $query;
    
    }




    public function updateProduksi(Request $request){

        $productionnumber = $request['production_number'];
        
        DB::table('productions')->where('production_number', $productionnumber)->delete();
        DB::table('production_details')->where('production_number', $productionnumber)->delete();
        DB::table('materialused')->where('production_number', $productionnumber)->delete();
        DB::table('stocks')->where('document', $productionnumber)->delete();


        $pcs = new Production;
        $pcs->production_number = $productionnumber;
        $pcs->description = $request['deskripsi'];
        $pcs->id_customer = $request['customer'];
        $pcs->grade = $request['grade'];
        $pcs->colour = $request['colour'];
        $pcs->hardness = $request['hardness'];
        $pcs->batch = $request['batch'];
        $pcs->user_id = Auth::user()->id;
        $pcs->total = DB::table('production_tmp')->sum('item_total');

        $pcs->save();


        $query = DB::table('production_tmp')
                ->select('*')
                ->get();

        foreach ($query as $key) {
            $barang = $key->item_cd;
            $satuan = $key->item_unit;
            $harga = $key->item_price;
            $jumlah = $key->quantity;
            $total = $key->item_total;

            DB::table('production_details')->insert([
                    'production_number' => $productionnumber ,
                    'item_cd' => $barang,
                    'quantity'=> $jumlah,
                    'item_unit' =>$satuan,
                    'item_price'=>$harga,
                    'item_total'=>$total, 
                    'created_at'=> date("Y-m-d H:i:s")
                    
            ]);

            // revisi 

            DB::table('stocks')->insert([
                'id_good'=>$barang,
                'type'=>'production',
                'document'=>$productionnumber,
                'in'=>$jumlah,
                'out'=>0,
                'created_at'=> date("Y-m-d H:i:s")
            ]);
            
            DB::table('production_batch')->where('production_number', $productionnumber)->delete();
            
            DB::table('material_adjustment')->where('prod_number', $productionnumber)->delete();
            
            if($jumlah > 100)
            {
                $div = floor($jumlah/100);
                $sisa = $jumlah % 100;
                
                for($i=0; $i<$div; $i++)
                {
                    $d = DB::table('production_batch')->where('batch', $request['batch'])->max('antrian');

                    if($d == null )
                    {
                        $urutanantrian = 1;    
                    }
                    else
                    {
                        $urutanantrian = $d + 1;
                    }
                    
                    
                    DB::table('production_batch')->insert([
                       "production_number" =>  $productionnumber,
                       "item_cd" => $barang,
                       "quantity" => 100,
                       "item_unit" => $satuan,
                       "item_price" => $harga,
                       "item_total" => $harga * 100,
                       "batch" => $request['batch'],
                       "antrian" => $urutanantrian
                    ]);
                
                }
                
                if($sisa > 0)
                {
                    $d = DB::table('production_batch')->where('batch', $request['batch'])->max('antrian');
    
                    if($d == null )
                    {
                        $urutanantrian = 1;    
                    }
                    else
                    {
                        $urutanantrian = $d + 1;
                    }
                    
                    
                    DB::table('production_batch')->insert([
                       "production_number" =>  $productionnumber,
                       "item_cd" => $barang,
                       "quantity" => $sisa,
                       "item_unit" => $satuan,
                       "item_price" => $harga,
                       "item_total" => $harga * $sisa,
                       "batch" => $request['batch'],
                       "antrian" => $urutanantrian
                    ]);
                }
                
                
                
            }
            else
            {
                $d = DB::table('production_batch')->where('batch', $request['batch'])->max('antrian');

                if($d == null )
                {
                    $urutanantrian = 1;    
                }
                else
                {
                    $urutanantrian = $d + 1;
                }
                
                
                DB::table('production_batch')->insert([
                   "production_number" =>  $productionnumber,
                   "item_cd" => $barang,
                   "quantity" => $jumlah,
                   "item_unit" => $satuan,
                   "item_price" => $harga,
                   "item_total" => $harga * $jumlah,
                   "batch" => $request['batch'],
                   "antrian" => $urutanantrian
                ]);
            }

        }

        DB::table('production_tmp')->delete();
        
        $consume = DB::table('materialconsume')->get();
        
        foreach($consume as $cs )
        {
            // $cari = DB::table('materialused')
            //     ->where('production_number', $productionnumber)
            //     ->where('id_product', $cs->id_product)
            //     ->where('id_material', $cs->id_material)
            //     ->get();

            // if(count($cari) > 0 ) 
            // {
            //     DB::table('materialused')
            //     ->where('production_number', $productionnumber)
            //     ->where('id_product', $cs->id_product)
            //     ->where('id_material', $cs->id_material)
            //     ->update([
            //        "qty_material" => $cari->qty_material + $cs->qty_material
            //     ]);
            // }
            // else
            // {
                DB::table('materialused')
                ->insert([
                   "production_number" => $productionnumber,
                   "id_product" => $cs->id_product,
                   "id_material" => $cs->id_material,
                   "qty_material" => $cs->qty_material
                ]);
            // }    



            
        }
        
        DB::table('materialconsume')->delete();
        
        return $query;
    
    }
    
    
    
    

    public function hapusProduksi(Request $request){

        $id = $request->id;        
        $purchase = Production::destroy($id);

        $inv = $request->invoice;

        $stock = DB::table('stocks')
                ->where('document', $inv)
                ->delete();
        
        
        
        $details = DB::table('production_details')
                     ->where('production_number', $inv)
                     ->delete();
        
        if($details)
        {
            DB::table('materialused')->where('production_number', $inv)->delete(); 
            DB::table('production_batch')->where('production_number', $inv)->delete();    
        }
        
        return $details;

    }


    public function batalProduksi(){

        DB::table('production_tmp')->delete();
        DB::table('materialconsume')->delete();

    }


    

    public function cetakProduksi($id){

        $profil = DB::table('profils')->first();
        $item = DB::table('production_batch')
                ->where('id', $id)
                ->first();
        
        $prod = DB::table('productions')->where('production_number', $item->production_number)->first();
        $cust = DB::table('customers')->where('id', $prod->id_customer)->first();
        
        $mat = DB::table('materialcombines')
            ->join('materials', 'materials.id', '=', 'materialcombines.id_material', 'left')
            ->select('materialcombines.*', 'materials.id as idmaterial', 'materials.material_name')
            ->where('materialcombines.id_product', $item->item_cd)
            ->where('materials.kategori', '!=', 76)
            ->get();
            
        
        
        $det = DB::table('production_details')->where('production_number', $item->production_number)->first();    
            
        $col = DB::table('materialcombines')
        ->join('materials', 'materials.id', '=', 'materialcombines.id_material', 'left')
        ->select('materialcombines.*', 'materials.id as idmaterial', 'materials.material_name')
        ->where('materialcombines.id_product', $item->item_cd)
        ->where('materials.kategori', 76)
        ->get();
        
        $good = DB::table('goods')->where('id', $item->item_cd)->first();    
        
        $pdf = PDF::loadView('pdf.batchpro', compact('profil', 'item', 'prod', 'cust', 'mat', 'good', 'col', 'det', 'id'));
        $pdf->setPaper('a4', 'potrait');

        return $pdf->stream();
    }
    
    


    public function editProduksi($invoice){

        $d = DB::table('productions')
            ->where('production_number', $invoice)
            ->first();

        if($d->status == 1){
            return redirect(url('production'));
            exit();
        }
        else{
            
            DB::table('production_tmp')->delete();
            
            $dt = DB::table('production_details')
                    ->where('production_number', $invoice)
                    ->get();
            
            foreach ($dt as $key) {
                DB::table('production_tmp')->insert([
                                'item_cd' => $key->item_cd,
                                'quantity'=> $key->quantity,
                                'item_unit' =>$key->item_unit,
                                'item_price'=>$key->item_price,
                                'item_total'=>$key->item_total, 
                                'created_at'=> date("Y-m-d H:i:s")
                                
                ]);
            }
            
            
            $mat = DB::table('materialused')->where('production_number', $invoice)
                    ->get();
                    
            DB::table('materialconsume')->delete();
            foreach($mat as $m)
            {
                DB::table('materialconsume')->insert([
                   "id_product" => $m->id_product,
                   "id_material" => $m->id_material,
                   "qty_material" => $m->qty_material
                ]);
            }
            

            $purchase = DB::table('productions')
                        ->where('production_number', $invoice)
                        ->first();

            $barang = Good::all();
            $customer = Customer::all();
            $batch = DB::table('antrian')->get();

            return view('transaksi.edit_produksi', compact('purchase', 'barang', 'customer', 'batch'));    
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
    
    
    public function getBahan(Request $request)
    {
        $input = $request->all();
        $id_barang = $input['barang'];
        $jumlah_order = $input['jumlah'];
        $satuan = $input['satuan'];
        
        $produkjadi = DB::table('goods')->where('id', $id_barang)->first();
        
        
        $query = DB::table('materialcombines')
        ->join('materials', 'materials.id', '=', 'materialcombines.id_material')
        ->join('goods', 'goods.id', '=', 'materialcombines.id_product')
        ->where('materialcombines.id_product', $id_barang)
        ->where('materials.kategori', '!=', 76)
        ->select('materialcombines.*','materials.kategori', 'materials.material_name','materials.stok','materials.id as idmaterial', 'goods.good_name')
        ->get();
        
        $HTML = '';
        $HTML.= '<table class="table table-bordered table-striped"><tr>';
        $HTML.= '<th>No<th>';
        $HTML.= '<th>Material<th>';
        $HTML.= '<th>Qty Needed<th>';
        $HTML.= '<th>Qty Allocated<th>';
        $HTML.= '<th>Stok<th>';
        
        $HTML.= '</tr>';
        
        $nomor=0;
        $kurangstok=0;
        foreach($query as $key)
        {
            
            $qtyneeded = $jumlah_order * $key->qty_material;
            $stoktmp = DB::table('materialconsume')->where('id_material', $key->idmaterial)->sum('qty_material');
            
            if($key->stok < ($qtyneeded + $stoktmp)) 
            {
                $kurangstok++;
                $color = 'color:red;';
            }
            else{
                $color = '';
            }
            
            
            
            $nomor++;
            $HTML.= '<tr><td>'.$nomor.'<td>';
            $HTML.= '<td>'.$key->material_name.'<td>';
            $HTML.= '<td style="text-align:right;">'.$qtyneeded.'<td>';
            $HTML.= '<td style="text-align:right;">'.$stoktmp.'<td>';
            $HTML.= '<td style="text-align:right;'.$color.'">'.$key->stok.'<td>';
            $HTML.= '</tr>';
        }
        
        $HTML.= '</table>';
        
        $resp = array(
            "html" => $HTML,
            "barang" => $produkjadi->good_name,
            "qty_order" => $jumlah_order,
            "satuan" => $satuan,
            "kurangstok" => $kurangstok
            
        );
        
        return $resp;
    }


    public function cekItemProduksi(Request $req)
    {
        return count(DB::table('production_tmp')->get());
    }
    
    
    
    
    
     public function apiProduction(){
        $production = DB::table('productions')
                   ->select('productions.*', 'customers.customer_name')
                   ->join('customers', 'productions.id_customer', '=', 'customers.id')
                   ->orderBy('productions.id','desc')
                   ->get();

       

        return Datatables::of($production) 
           
            ->addColumn('total', function($production){
                return '<div style="text-align:right;">'.number_format($production->total).'</div>';
            })
            
            ->addColumn('batch', function($production){
                return '<div style="text-align:right;"> BATCH 0'.$production->batch.'</div>';
            
            })
            ->addColumn('action', function($production){
                if($production->status == 0){
                        return '<center><a id="btn-cetak" data-id = "'.$production->id.'" data-inv = "'.$production->production_number.'" style="margin-left:5px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
                            '<a href="'.url('edit_produksi').'/'.$production->production_number.'" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                            '<a id="btn-hapus" data-id = "'.$production->id.'" data-inv = "'.$production->production_number.'" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                }else{
                    return  '<center><a id="btn-cetak" data-id = "'.$production->id.'" data-inv = "'.$production->production_number.'" style="margin-left:5px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
                            '<a disabled="disabled" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                            '<a disabled="disabled" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                            
                }
                
            })->rawColumns(['batch','total','action'])->make(true);
    }
    
    
    public function apiItem(){
        $tmp = DB::table('production_tmp')
                ->join('goods', 'goods.id', '=', 'production_tmp.item_cd')
                ->select('production_tmp.*', 'goods.good_name')
                ->orderBy('production_tmp.id', 'desc')
                ->get();

        return Datatables::of($tmp)
            ->addColumn('item_price', function($tmp){
                return '<div style="text-align:right;">'.number_format($tmp->item_price).'</div>';
            })
            ->addColumn('quantity', function($tmp){
                return '<div style="text-align:right;">'.number_format($tmp->quantity).'</div>';
            })
            ->addColumn('item_total', function($tmp){
                return '<div style="text-align:right;">'.number_format($tmp->item_total).'</div>';
            })
            ->addColumn('action', function($tmp){
                return '<center><a onclick="deleteitem('. $tmp->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
            })->rawColumns(['quantity','item_price','item_total','action'])->make(true);
    }



}
