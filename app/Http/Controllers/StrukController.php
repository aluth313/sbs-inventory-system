<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StrukController extends Controller
{
    

    public function __construct(){
        $this->middleware('auth');
    }
    

    public function index($id){

    	$tanggal = date("Y-m-d H:i:s");
    	$data = DB::table('services')
    			->join('transaction_posting', 'transaction_posting.id_service', '=', 'services.id')
    			->select('services.*', 'transaction_posting.nota', 'transaction_posting.item', 'transaction_posting.harga', 'transaction_posting.jumlah', 'transaction_posting.total')
    			->where('transaction_posting.id_service', $id)
    			->get();

    	$total_ = DB::table('transaction_posting')
                        ->select(DB::raw('sum(total) as Total'))
                        ->where('id_service', $id)
                        ->first();
        $nota = DB::table('transaction_posting')
        		->select('nota')
        		->where('id_service', $id)
        		->limit(1)
        		->get();

        $servie = DB::table('services')
        		->join('teknisi', 'teknisi.id', '=', 'services.tech_id')
        		->join('customers', 'customers.id', '=', 'services.cust_id')
        		->where('services.id', $id)
        		->select('teknisi.nama', 'customers.customer_name', 'customers.customer_address')
        		->first();


    	return view('struk', compact('data', 'total_', 'nota', 'servie', 'tanggal'));

    }
}
