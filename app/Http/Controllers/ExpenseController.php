<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\Auth;
use App\Expense;
use App\Cost;
use DB;

class ExpenseController extends Controller
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
        $halaman = 'expense';
        $data = Cost::all();
        return view('transaksi.expense', compact('data', 'halaman'));
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
        return Expense::create($input);
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
        $expense = Expense::findorfail($id);
        return $expense;
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
        $expense = Expense::findorfail($id);
        $input = $request->all();
        $expense->update($input);
        return $expense;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::destroy($id);
    }




    public function apiExpense(){
        $expense = DB::table('expenses')
                   ->join('costs', 'costs.id', '=', 'expenses.cost_id')
                   ->select('expenses.*', 'costs.cost_name')
                   ->orderBy('costs.id','desc')
                   ->get();

        return Datatables::of($expense) 

            ->addColumn('cost_id', function($expense){
                return '<div>'.$expense->cost_name.'</div>';
            })

            ->addColumn('cost_value', function($expense){
                return '<div style="text-align:right;">Rp. '.number_format($expense->cost_value).'</div>';
            })

            ->addColumn('action', function($expense){
                if(Auth::user()->level=='ADMIN'){
                    return '<center><a onclick="editForm('. $expense->id.')" style="margin-left:10px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                    '<a onclick="deleteData('. $expense->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
                }
            })->rawColumns(['cost_id', 'cost_value', 'action'])->make(true);
    }
}
