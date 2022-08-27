<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
    	
    	$response = array();

    	$username = $request->username;
    	$password = $request->password;

    	$query = DB::table('teknisi')
    		->where(array('hp'=>$username, 'password'=>$password))
    		->get();
    	
    	$response['login'] = array();

    	foreach ($query as $key) {
    		$row['id'] = $key->id;
    		$row['nama'] = $key->nama;
    		$row['alamat'] = $key->alamat;
    		$row['hp'] = $key->hp;	
    		$row['foto'] = 'http://192.168.43.107/serviceku/laravel/public/upload/teknisi/'.$key->foto;
    	}

    	if(!$query->isEmpty())
    	{
    		$response['success'] = "1";
    		$response['message'] = 'success';
    		array_push($response['login'], $row);
    	}else
    	{
    		$response['success'] = "0";
    		$response['message'] = 'error';
    	}

    	return $response;



    }
}
