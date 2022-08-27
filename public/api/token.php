<?php

	if($_SERVER['REQUEST_METHOD'] =='POST'){

		$token = $_POST['token'];
		$id_teknisi = $_POST['id_teknisi'];

		require_once "connect.php";

		$query = "UPDATE teknisi SET token = '$token' WHERE id = '$id_teknisi'";
		$result = mysqli_query($conn, $query);
		$response = array();
		if($result){
			$response['success']= "1";
			$response['message'] = 'Sukses';
		}
		else{
			$response['success']= "0";
			$response['message'] = 'Failed';	
		}
				
	}

?>