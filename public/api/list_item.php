<?php
	

	if(isset($_GET['service_id'])){

        require_once "connect.php";

		$id = $_GET['service_id'];

		$query = "SELECT id, id_item, item, harga, jumlah, total FROM transaction_item WHERE id_service = '$id' ORDER BY id DESC";

		$result = mysqli_query($conn, $query);
		$response= array();
        
        while($row = mysqli_fetch_assoc($result)){
            array_push($response, 
            array(
                    'id'=>$row['id'], 
                    'id_item'=>$row['id_item'],
                    'item'=> $row['item'],  
                    'harga'=>'Rp.' .number_format($row['harga']),
                    'jumlah' =>$row['jumlah'],
                    'total'=>'Rp.' .number_format($row['total'])              
                ) 
            );
        }

        echo json_encode($response);

	}

?>