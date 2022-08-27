<?php

	if($_SERVER['REQUEST_METHOD']=='POST'){

		require_once "connect.php";
		$id = $_POST['id'];
		$job = $_POST['job'];
		$jumlah = $_POST['jumlah'];
		$harga = $_POST['harga'];
		$id_service = $_POST['id_service'];
		$total = $jumlah * $harga;
		$kategori = 1;


		$query = "INSERT INTO transaction_item (id_service, kategori, id_item, item, harga, jumlah, total, status)VALUES('$id_service', '$kategori', '$id', '$job', '$harga', '$jumlah', '$total', 0)";

		
		$result = mysqli_query($conn, $query);
		$response = array();
		if($result){
			
			$response['success'] = "1";
			$response['message'] = "Sukses";

		}
		else{
			$response['success'] = "0";
			$response['message'] = "Gagal";
		}

		echo json_encode($response);


	}




?>