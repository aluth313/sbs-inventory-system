<?php
	
	
	require_once "connect.php";



	if(isset($_POST['id'])){

		$id = $_POST['id'];
		$time = date("Y-m-d H:i:s");

		$query = "UPDATE services SET status = 2, start_time = '$time' WHERE id = '$id'";

		$result = mysqli_query($conn, $query);
		$response = array();

		if($result) {
			$response['success'] = 1;
			$response['message'] = 'Sukses';
		}

		else{
			$response['success'] = 0;
			$response['message'] = 'Error';	
		}

		echo json_encode($response);

	}

?>