<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Customer;

class CustomerController extends Controller
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
        $halaman = 'pelanggan';
        return view('master.pelanggan', compact('halaman'));
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
        $input['customer_foto'] = null;

        if($request->hasFile('customer_foto')){
            $input['customer_foto'] = str_slug($input['customer_name'], ' - ').'.'.$request->customer_foto->getClientOriginalExtension();
            $request->customer_foto->move(public_path('/upload/pelanggan'), $input['customer_foto']);
        }

        Customer::create($input);

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
        $customer = Customer::findorFail($id);
        return $customer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findorFail($id);
        return $customer;
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
        $pelanggan = Customer::findorFail($id);
        
        $input['customer_foto'] = $pelanggan->customer_foto;

        if($request->hasFile('customer_foto')){
            if($pelanggan->customer_foto != NULL){
                unlink(public_path('/upload/pelanggan/'.$pelanggan->customer_foto));
            }

            $input['customer_foto'] = str_slug($input['customer_name'], ' - ').'.'.$request->customer_foto->getClientOriginalExtension();
            $request->customer_foto->move(public_path('/upload/pelanggan'), $input['customer_foto']);
        }

        $pelanggan->update($input);
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
        $pelanggan=Customer::findorFail($id);
        if($pelanggan->customer_foto != NULL){
            unlink(public_path('/upload/pelanggan/'.$pelanggan->customer_foto));
        }

        Customer::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }


    public function apiPelanggan(){
        $pelanggan = Customer::all();

        return Datatables::of($pelanggan)
            ->addColumn('customer_foto', function($pelanggan){
                if($pelanggan->customer_foto == null){
                    return 'No Image';
                }
                return '<center><img class="img-rounded" width="50" height="60" src="'.url('laravel/public/upload/pelanggan/'.$pelanggan->customer_foto).'" alt=""></center>';
            })

            ->addColumn('action', function($pelanggan){
                return '<center><a onclick="showForm('. $pelanggan->id.')" href="javascript:void(0)" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a>'.
                '<a onclick="editForm('. $pelanggan->id.')" style="margin-left:10px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<a onclick="deleteData('. $pelanggan->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
            })->rawColumns(['customer_foto', 'action'])->make(true);
    }
}
