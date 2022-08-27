<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Teknisi;
class TeknisiController extends Controller
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
        $halaman = 'teknisi';
        return view('master.teknisi', compact('halaman'));
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
            $input['foto'] = str_slug($input['nama'], ' - ').'.'.$request->foto->getClientOriginalExtension();
            $request->foto->move(public_path('/upload/teknisi'), $input['foto']);
        }

        Teknisi::create($input);

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
        $teknisi = Teknisi::findorFail($id);
        return $teknisi;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teknisi = Teknisi::findorFail($id);
        return $teknisi;
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
        $teknisi = Teknisi::findorFail($id);
        
        $input['foto'] = $teknisi->foto;

        if($request->hasFile('foto')){
            if($teknisi->foto != NULL){
                unlink(public_path('/upload/teknisi/'.$teknisi->foto));
            }

            $input['foto'] = str_slug($input['nama'], ' - ').'.'.$request->foto->getClientOriginalExtension();
            $request->foto->move(public_path('/upload/teknisi'), $input['foto']);
        }

        $teknisi->update($input);
        
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
        $teknisi=Teknisi::findorFail($id);
        if($teknisi->foto != NULL){
            unlink(public_path('/upload/teknisi/'.$teknisi->foto));
        }

        Teknisi::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }

    public function apiTeknisi(){
        $teknisi = Teknisi::all();

        return Datatables::of($teknisi)
            ->addColumn('foto', function($teknisi){
                if($teknisi->foto == null){
                    return 'No Image';
                }
                return '<center><img class="img-rounded" width="50" height="60" src="'.url('laravel/public/upload/teknisi/'.$teknisi->foto).'" alt=""></center>';
            })

            ->addColumn('action', function($teknisi){
                return '<center><a onclick="showForm('. $teknisi->id.')" href="javascript:void(0)" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a>'.
                '<a onclick="editForm('. $teknisi->id.')" style="margin-left:10px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<a onclick="deleteData('. $teknisi->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
            })->rawColumns(['foto', 'action'])->make(true);
    }
}
