<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Material;
use App\Unit;
use App\Category;
use DB;
class MaterialController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $halaman = 'material';
        $data = Unit::all();
        $kat = Category::all();

        return view('master.material', compact('data', 'halaman', 'kat'));
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
    
        Material::create($input);

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
       
        $material = Material::findorfail($id);
        return $material;
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
        $material = Material::findorfail($id);
        $input = $request->all();
        $material->update($input);
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
        
        Material::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }


    public function apiMaterial(){
        $material = DB::table('materials')
                ->join('categories', 'categories.id','=', 'materials.kategori')
                ->select('materials.*', 'categories.category_name')->get(); 

        return Datatables::of($material)
            ->addColumn('b_price', function($material){
                return '<div style="text-align:right;">'.number_format($material->b_price).'</div>';
            })


            ->addColumn('stok', function($material){
                return '<div style="text-align:right;">'.$material->stok.'</div>';
            })
            
            ->addColumn('stok_2', function($material){
                return '<div style="text-align:right;">'.number_format($material->stok_2, 4).'</div>';
            })

            ->addColumn('action', function($material){
                return '<center><a onclick="editForm('. $material->id.')" style="margin-left:2px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<a onclick="deleteData('. $material->id.')" style="margin-left:2px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
            })->rawColumns(['b_price', 'stok','stok_2', 'action'])->make(true);
    }


  

}
