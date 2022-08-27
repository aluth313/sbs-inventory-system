<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ApiController extends Controller
{
    
	public function barang($type, $key){
		

		if($type =='users')
		{
			$users = DB::table('goods')
            ->where('good_name', 'like', '%'.$key.'%')
            ->get();

            $response = array();
            foreach ($users as $row) {
            	array_push($response, 
	            array(
	                'id'=>$row->id, 
	                'good_name'=>$row->good_name, 
	                'unit'=>$row->unit,
	                's_price'=>'Rp. '.number_format($row->s_price)) 
	            );

            }

        	return $response;
		}
			
			
		
		// $type = $_GET['item_type'];

		// if (isset($_GET['key'])) {
		//     $key = $_GET["key"];
		//     if ($type == 'users') {
		//         $query = "SELECT * FROM goods WHERE good_name LIKE '%$key%'";
		//         $result = mysqli_query($conn, $query);
		//         $response = array();
		//         while( $row = mysqli_fetch_assoc($result) ){
		//             array_push($response, 
		//             array(
		//                 'id'=>$row['id'], 
		//                 'good_name'=>$row['good_name'], 
		//                 'unit'=>$row['unit'],
		//                 's_price'=>'Rp. '.number_format($row['s_price'])) 
		//             );
		//         }
		//         echo json_encode($response);   
		//     }
		// } else {
		//     if ($type == 'users') {
		//         $query = "SELECT * FROM goods";
		//         $result = mysqli_query($conn, $query);
		//         $response = array();
		//         while( $row = mysqli_fetch_assoc($result) ){
		//             array_push($response, 
		//             array(
		//                 'id'=>$row['id'], 
		//                 'good_name'=>$row['good_name'], 
		//                 'unit'=>$row['unit'],
		//                 's_price'=>'Rp. '.number_format($row['s_price']))
		//             );
		//         }
		//         echo json_encode($response);   
		//     }
		// }

		
	}

}
