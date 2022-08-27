<?php
	

	if($_SERVER['REQUEST_METHOD']=='POST')
    {

        require_once "connect.php";

		$id = $_POST['service_id'];

		$query = "SELECT SUM(total)AS TOTAL FROM transaction_item WHERE id_service = '$id'";

		$result = mysqli_query($conn, $query);
		$response['data'] = array();
        $response['success'] = "1";
        
        while($row = mysqli_fetch_assoc($result)){
            array_push($response['data'], 
            array(
                    'TOTAL'=>'Rp. '.number_format($row['TOTAL'])              
                ) 
            );
        }

        echo json_encode($response);
	}

?>