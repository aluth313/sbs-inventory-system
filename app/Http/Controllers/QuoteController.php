<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use DB;
use App\Customer;
use App\Good;
use App\Unit;
use App\QuoteTmp;
use App\QuoteItem;
use App\Profil;
use PDF;


class QuoteController extends Controller
{
    public function index()
    {
    	return view('transaksi.quot');
    }


    public function apiQuote(){
        $quote = DB::table('quotes')
                   ->join('customers', 'customers.id', '=', 'quotes.customer')
                   ->select('quotes.*', 'customers.customer_name')
                   ->orderBy('quotes.id','desc')
                   ->get();

       

        return Datatables::of($quote) 
            ->addColumn('created_at', function($quote){
                return '<div>'.date("d-m-Y", strtotime($quote->created_at)).'</div>';
            })
            ->addColumn('total', function($quote){
                return '<div style="text-align:right;">'.number_format($quote->total).'</div>';
            })
            
            ->addColumn('action', function($quote){
                    return '<center><a id="btn-cetak" data-id = "'.$quote->id.'" data-inv = "'.$quote->quote_no.'" style="margin-left:5px;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-print"></i></a>'.
                        '<a href="'.url('edit_quotation').'/'.$quote->quote_no.'" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                        '<a id="btn-hapus" data-id = "'.$quote->id.'" data-inv = "'.$quote->quote_no.'" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
                
            })->rawColumns(['created_at','total','action'])->make(true);
    }



    public function addQuote()
    {
    	$customer = Customer::all();
    	$good = Good::all();
    	$unit = Unit::all();
    	return view('transaksi.add_quote', compact('customer', 'good', 'unit'));
    }


    public function quoteItem()
    {
        $tmp = DB::table('quote_tmp')->get();

        return Datatables::of($tmp)
        	->addColumn('quantity', function($tmp){
        		return '<div style="text-align:right;">'.$tmp->quantity.'</div>';
        	})

        	->addColumn('price', function($tmp){
        		return '<div style="text-align:right;">'.number_format($tmp->price).'</div>';
        	})

        	->addColumn('total', function($tmp){
        		return '<div style="text-align:right;">'.number_format($tmp->total).'</div>';
        	})

            ->addColumn('action', function($tmp){
               
            	return '<center><a onclick="editData('. $tmp->id.')" style="margin-left:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                '<a onclick="deleteData('. $tmp->id.')" style="margin-left:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
           
            })->rawColumns(['quantity','price','total','action'])->make(true);
    }



    public function simpanQuoteItem(Request $request)
    {
        $desc = $request->description;

        $data = DB::table('quote_tmp')->where('description', $desc)->exists();

        if ($data == true) 
        {
            $response = "exist";
            echo json_encode($response);
        }
        else
        {
           
            $tmp = $request->all();

            return QuoteTmp::create($tmp);
        }
    }


    public function totalTransaksi()
    {
        $total_transaksi = DB::table('quote_tmp')
                        ->select(DB::raw('sum(total) as Total'))
                        ->get();
        return $total_transaksi;
    }



    public function hapusItem(Request $request)
    {
        $id = $request->id;
        $tmp = QuoteTmp::destroy($id);
    }



    public function editQuoteItem($id)
    {
        $item = QuoteTmp::findorfail($id);
        return $item;
    }



    public function updateQuoteItem(Request $request)
    {
        $id = $request['id_edit'];
        $description = $request['description_edit'];
        $quantity = $request['quantity_edit'];
        $uom = $request['uom_edit'];
        $price = $request['price_edit'];
        $total = $request['total_edit'];

        $update = DB::table('quote_tmp')->      
                  where('id', $id)->
                  update([
                    'description'=>$description,
                    'quantity'=>$quantity,
                    'uom'=>$uom,
                    'price'=>$price,
                    'total'=>$total
                  ]);

        return $update;
    
    }



    public function simpanTransaksiQuote(Request $req)
    {   
        
        $kd = new PurchaseController();
        $kode = $kd->autonumber('quotes','id','QN-');

        
        $customer = $req->customer;
        $attn = $req->attn;
        $email = $req->email;
        $fax = $req->fax;
        $dari = $req->dari;
        $ref= $req->ref;
        $ref2 = $req->ref2;
        $tanggal = $req->tanggal;
        $total = $req->total;

        DB::beginTransaction();

        $q = DB::table('quotes')->
        insert([
            'quote_no'      => $kode,
            'customer'       => $customer,
            'attn'          => $attn,
            'email'         => $email,
            'fax'           => $fax,
            'dari'          => $dari,
            'ref'           => $ref,
            'ref2'          => $ref2,
            'total'         => $total,
            'created_at'    => $tanggal,
            'updated_at'    => $tanggal
        ]);


        $tmp = QuoteTmp::all();

            foreach ($tmp as $key => $value) {
                $description = $value->description;
                $quantity = $value->quantity;
                $uom = $value->uom;
                $price = $value->price;
                $total = $value->total;
                $created_at = date("Y-m-d H:i:s");
                $updated_at = date("Y-m-d H:i:s");

                $item = DB::table('quote_item')->insert([    
                    'quote_no'      =>$kode,
                    'description'   =>$description,
                    'quantity'      =>$quantity,
                    'uom'           =>$uom,
                    'price'         =>$price,
                    'total'         =>$total,
                    'created_at'    =>date("Y-m-d H:i:s"),
                    'updated_at'    =>date("Y-m-d H:i:s")
                ]);
  
            }

        $deltmp = DB::table('quote_tmp')->delete();

        if(!$q || !$tmp || !$deltmp)
        {
            DB::rollback();
        }
        else
        {
            DB::commit();
        } 

    }


    public function batalQuote()
    {
        $q = DB::table('quote_tmp')->delete();
        return $q;
    }

    // ==================================================================================================

    //                                        FORM EDIT QUOTATION 
    //                                          By Indra Rahdian

    // ==================================================================================================



    public function editQuotation($invoice)
    {
        $customer = Customer::all();
        $unit = Unit::all();

        $q = DB::table('quotes')->where('quote_no', $invoice)->first();

        DB::table('quote_tmp')->delete();

        $item = DB::table('quote_item')->where('quote_no', $invoice)->get();
        foreach ($item as $key => $value) 
        {
            DB::table('quote_tmp')->insert([
                'description' =>$value->description,
                'quantity' =>$value->quantity,
                'uom'=>$value->uom,
                'price'=>$value->price,
                'total'=>$value->total
            ]);
        }

        return view('transaksi.edit_quote', compact('customer', 'unit', 'invoice', 'q'));
    }



    public function updateTransaksiQuote(Request $req)
    {   
        
        
        $kode = $req->nota;

       
        $customer = $req->customer;
        $attn = $req->attn;
        $email = $req->email;
        $fax = $req->fax;
        $dari = $req->dari;
        $ref= $req->ref;
        $ref2 = $req->ref2;
        $tanggal = $req->tanggal;
        $total = $req->total;


        DB::beginTransaction();

        $delQuote = DB::table('quotes')->where('quote_no', $kode)->delete();

        $q = DB::table('quotes')->
        insert([
            'quote_no'      => $kode,
            'customer'      => $customer,
            'attn'          => $attn,
            'email'         => $email,
            'fax'           => $fax,
            'dari'          => $dari,
            'ref'           => $ref,
            'ref2'          => $ref2,
            'total'         => $total,
            'created_at'    => $tanggal,
            'updated_at'    => $tanggal
        ]);


        $delItem = DB::table('quote_item')->where('quote_no', $kode)->delete();

        $tmp = QuoteTmp::all();

            foreach ($tmp as $key => $value) {
                $description = $value->description;
                $quantity = $value->quantity;
                $uom = $value->uom;
                $price = $value->price;
                $total = $value->total;
                $created_at = date("Y-m-d H:i:s");
                $updated_at = date("Y-m-d H:i:s");

                $item = DB::table('quote_item')->insert([    
                    'quote_no'      =>$kode,
                    'description'   =>$description,
                    'quantity'      =>$quantity,
                    'uom'           =>$uom,
                    'price'         =>$price,
                    'total'         =>$total,
                    'created_at'    =>date("Y-m-d H:i:s"),
                    'updated_at'    =>date("Y-m-d H:i:s")
                ]);
  
            }

        $deltmp = DB::table('quote_tmp')->delete();


        if(!$q || !$tmp || !$deltmp)
        {
            DB::rollback();
        }
        else
        {
            DB::commit();
        } 
    }


    public function hapusQuotation(Request $req)
    {
        $id = $req->id;
        $invoice = $req->invoice;

        DB::beginTransaction();

        $header = DB::table('quotes')->where('id', $id)->delete();

        $item = DB::table('quote_item')->where('quote_no', $invoice)->delete();

        if(!$header || !$item )
        {
            DB::rollback();
        }
        else
        {
            DB::commit();
            return "true";
        }

    }



    public function cetakInvoiceQuotation($invoice)
    {
        
        $profil = Profil::all()->first();
        $q = DB::table('quotes')
            ->join('customers', 'customers.id', '=', 'quotes.customer')
            ->where('quotes.quote_no', $invoice)
            ->select('quotes.*', 'customers.customer_name')
            ->first();

        $item = QuoteItem::all()->where('quote_no', $invoice);

        // var_dump($item);
        // exit();
        
        $pdf    = PDF::loadView('pdf.quote', compact('profil', 'q', 'item'));
        $pdf->setPaper('letter', 'potrait');

        return $pdf->stream();


    }




}
