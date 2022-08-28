<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Good;
use App\Unit;
use App\Category;
use DB;
use App\Material;
use Auth;

class GoodController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
        // $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $halaman = 'barang';
        $data = Unit::all();
        $kat = Category::all();
        $mat = Material::all();

        return view('master.barang', compact('data', 'halaman', 'kat', 'mat'));
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
       
        $input = $request->all();
        $input['foto'] = null;

        if($request->hasFile('foto')){
            $input['foto'] = str_slug($input['good_name'], ' - ').'.'.$request->foto->getClientOriginalExtension();
            $request->foto->move(public_path('/upload/barang'), $input['foto']);
        }

        Good::create($input);

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
        $good = Good::findorfail($id);
        return $good;
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
        // $good = Good::findorfail($id);
        // $input = $request->all();
        // $good->update($input);
        // return $good;

        $input = $request->all();
        $good = Good::findorFail($id);
        
        $input['foto'] = $good->foto;

        if($request->hasFile('foto')){
            if($good->foto != NULL){
                unlink(public_path('/upload/barang/'.$good->foto));
            }

            $input['foto'] = str_slug($input['good_name'], ' - ').'.'.$request->foto->getClientOriginalExtension();
            $request->foto->move(public_path('/upload/barang'), $input['foto']);
        }

        $good->update($input);
        
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
        // $good = Good::destroy($id);

        $good=Good::findorFail($id);
        if($good->foto != NULL){
            unlink(public_path('/upload/barang/'.$good->foto));
        }

        Good::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }


    public function apiGood(){
        $good = DB::table('goods')
                ->join('categories', 'categories.id','=', 'goods.kategori')
                ->select('goods.*', 'categories.category_name')->get(); 

        return Datatables::of($good)
            ->addColumn('b_price', function($good){
                return '<div style="text-align:right;">'.number_format($good->b_price).'</div>';
            })

            ->addColumn('s_price', function($good){
                return '<div style="text-align:right;">'.number_format($good->s_price).'<br>'.number_format($good->r_price).'<br>'.number_format($good->d_price).'</div>';
            })

            ->addColumn('stok', function($good){
                return '<div style="text-align:right;">'.number_format($good->stok).'</div>';
            })
            
            ->addColumn('bahanbaku', function($good){
                $mat = DB::table('materialcombines')->join('materials', 'materials.id', '=', 'materialcombines.id_material')
                        ->where('id_product', $good->id)->select('materials.material_name', 'materialcombines.*')->get();
                
                $HTML = '';
                $HTML .= '<table style="font-size:12px;" class="table table-bordered table-striped">';
                if (in_array(Auth::user()->level, ['ADMIN','KEPALA PRODUKSI'])) {
                    $HTML .= '<tr><th>No</th><th>Material</th><th>Qty</th><th><center><button onclick="tambahBaku('.$good->id.')" class="btn btn-xs btn-success "><i class="glyphicon glyphicon-plus"></i></button></center></th></tr>';
                }else{
                    $HTML .= '<tr><th>No</th><th>Material</th><th>Qty</th><th><center></center></th></tr>';
                }
                $nom = 0;
                foreach($mat as $m)
                {
                    $nom++;
                    $HTML .= '<tr><td>'.$nom.'</td><td>'.$m->material_name.'</td><td>'.number_format($m->qty_material,2).'</td>
                    <td></tr>';
                }
                $HTML .= '</table>';
                return '<div style="text-align:right;">'.$HTML.'</div>';
            })

            ->addColumn('action', function($good){
                if (in_array(Auth::user()->level, ['ADMIN','KEPALA PRODUKSI'])) {
                    return '<center><a onclick="editForm('. $good->id.')" style="width:80px;margin-bottom:3px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                    '<br><a onclick="deleteData('. $good->id.')" style="width:80px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>'.
                    '<br><a style="width:80px;" href="/addProductionAutomationFill/'.$good->id.'" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-refresh"></i> Produksi</a></center>';
                }
            })->rawColumns(['b_price', 's_price', 'stok', 'bahanbaku', 'action'])->make(true);
    }


    public function getFoto($id) {

        $good = Good::findorFail($id);
        $foto = $good->foto;
        $HTML = '';

        if($foto =='' || $foto == null) {
            $HTML .= '<center><h2 style="color:red;">No Image Inserted....! <h2/></center>';    
        }
        else{
            $HTML .= '<img class="img-responsive"  src="'.url('laravel/public/upload/barang').'/'.$foto.'" />';    
        }
        
        // $foto = '<h2>APLIKASI SERVICE</h2>';
        echo json_encode($HTML);

    }
    
    
    public function tambahBahanBaku(Request $request)
    {
        $input = $request->all();
        
        $idproduk = $input['bakuproductid'];
        $idmat = $request->idmat;
        $qtymat = $request->qtymat;
        
        DB::table('materialcombines')
            ->where('id_product', $idproduk)
            ->delete();
        
        
        for($i=0; $i<count($idmat); $i++)
        {
            if($qtymat[$i] > 0 )
            {
                $datainsert = array([
                    "id_product" => $idproduk,
                    "id_material" => $idmat[$i],
                    "qty_material" => $qtymat[$i]
                ]) ;
                
                $query = DB::table('materialcombines')->insert($datainsert); 

                $updateStokMaterial = Material::find($idmat[$i]);
                $updateStokMaterial->stok = $updateStokMaterial->stok - ($qtymat[$i] * 100);
                $updateStokMaterial->save();
            }
               
        }
        
        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
    public function updateBahanBaku(Request $request)
    {
        $input = $request->all();
        $id = $input['bakucombineid'];
        
        $dataupdate = [
          "id_product" => $input['bakuproductid'],
          "id_material" => $input['bakumaterialname'],
          "qty_material" => $input['bakumaterialquantity']
        ];
        
        $query = DB::table('materialcombines')->where('id', $id)->update($dataupdate);
        return response()->json([
            'success'=>true
        ]);
    }
    
    
    public function editBahanBaku($id)
    {
        $query = DB::table('materialcombines')->where('id', $id)->get();
        return $query;
    }
    
    
    public function hapusBahanBaku(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        
        $query = DB::table('materialcombines')->where('id', $id)->delete();
        return $query;
    }
    
    
    public function materiallist(Request $request)
    {
        
        $idbarang = $request['id'];
        $query = DB::table('materials')->get();
        
        $html = '';
        $html .= '<table class="table table-bordered table-striped">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>No</th>';
        $html .= '<th>Nama Material</th>';
        $html .= '<th>Qty Input</th>';
        $html .= '<th>Qty Needed</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody id="table-quantity">';
        
        
        $nomor =0;
        foreach($query as $k)
        {
            
            $qtyisi = DB::table('materialcombines')
                ->where('id_product', $idbarang)
                ->where('id_material', $k->id)->get();
            
            if(count($qtyisi) > 0)
            {
                $qt = $qtyisi[0]->qty_material;    
            }
            else
            {
                $qt = 0;
            }
            
                     
            $nomor++;
            
            $tt = $qt * 100;    
            $html .= '<tr>';
            $html .= '<td>'.$nomor.'<input type="hidden" id="idmat_'.$k->id.'"  name = "idmat[]" value="'.$k->id.'"></td>';
            $html .= '<td>'.$k->material_name.'</td>';
            $html .= '<td><input value="'.$tt .'" onkeyup="ubahitem('.$k->id.')" style="text-align:right;" id="inp_'.$k->id.'" type="text" class="form-control"></td>';
            $html .= '<td><input value="'.$qt.'" style="text-align:right;" id="qty_'.$k->id.'" name="qtymat[]" type="text" class="form-control"></td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        
        $html .= '</table>';
        
        return $html;
        
        // return $query;
        
    }   

}
