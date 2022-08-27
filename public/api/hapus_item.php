<?php 

	if($_SERVER['REQUEST_METHOD']=='POST'){

		$id_service = $_POST['id_service'];
		$item = $_POST['item'];
		$jumlah = $_POST['jumlah'];

		require_once "connect.php";

		$query = "DELETE FROM transaction_item WHERE (id_service = '$id_service' AND item = '$item' AND jumlah = '$jumlah') ";
		$result = mysqli_query($conn, $query);

		$response = array();
		if($result){
			$response['success'] = "1";
			$response['message'] = "Sukses";

		}
		else{
			$response['success'] = "0";
			$response['message'] = "Error";
		}

		echo json_encode($response);
	}
?>