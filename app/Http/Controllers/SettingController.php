<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profil;
use DB;
use Session;

class SettingController extends Controller
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
        $profil = Profil::all()->first();
        return view('setting.general', compact('profil'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        DB::table('profils')
            ->update([  'company_name' => $request->nama_perusahaan,
                        'company_address' =>$request->alamat_perusahaan,
                        'company_title'=>$request->title_perusahaan,
                        'owner_name'=>$request->pemilik,
                        'owner_phone'=>$request->phone,
                        'fax'=>$request->fax,
                        'email'=>$request->email,
                        'bank'=>$request->bank,
                        'kcp'=>$request->kcp,
                        'norek'=>$request->norek
        ]);

        Session::flash('flash_message', 'Data Setting Berhasil Diupdate..');
        
        return redirect('setting');

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
