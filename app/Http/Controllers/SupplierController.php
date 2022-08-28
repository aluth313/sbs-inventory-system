<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Supplier;
use Auth;

class SupplierController extends Controller
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
        $halaman = 'supplier';
        return view('master.supplier', compact('halaman'));
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
        $supplier = Supplier::create($input);
        return $supplier; 
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
        return $supplier = Supplier::findorfail($id);

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
        
        $supplier = Supplier::findorfail($id);
        $input = $request->all();
        $supplier->update($input);
        return $supplier;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::destroy($id);
    }


    public function apiSupplier(){
        $supplier = Supplier::all();

        return Datatables::of($supplier)
            
            ->addColumn('action', function($supplier){
                if(in_array(Auth::user()->level, ['ADMIN'])){
                    return '<center>
                    <a onclick="editForm('. $supplier->id.')" style="margin-bottom:5px;width:70px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                    '<br><a onclick="deleteData('. $supplier->id.')" style="width:70px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
                }
            })->rawColumns(['action'])->make(true);
    }
}
