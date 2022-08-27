<?php
	
	if($_SERVER['REQUEST_METHOD']=='POST'){

		$id = $_POST['id_service'];

		

		require_once "connect.php";

		$tgl = date("Y-m-d");
		$dibuat = date("Y-m-d H:i:s");


		$query = "SELECT * FROM transaction_item WHERE id_service = '$id'";

		$result = mysqli_query($conn, $query);
		
		if(mysqli_num_rows($result)>0){

			while($data = mysqli_fetch_assoc($result)){

				$id_service = $data['id_service'];
				$nota = $tgl.'-000'.$id;
				$kategori = $data['kategori'];
				$id_item = $data['id_item'];
				$item = $data['item'];
				$harga = $data['harga'];
				$jumlah = $data['jumlah'];
				$total = $data['total'];
				$status = 1;

			
				$postingSQL = "INSERT INTO transaction_posting SET id_service = $id_service, nota = '$nota', kategori = '$kategori', id_item = '$id_item', item = '$item', harga = $harga, jumlah = $jumlah, total = $total, status = $status, created_at = '$dibuat'";

				$res = mysqli_query($conn, $postingSQL);

			}

			$hapusSQL = "DELETE FROM transaction_item WHERE id_service = '$id'";
			$resHapus = mysqli_query($conn, $hapusSQL);

			$statusSQL = "UPDATE services SET status = 6 WHERE id = '$id'";
			$resStatus = mysqli_query($conn, $statusSQL);
			

			if($res && $resHapus){
				$response['success'] ="1";
				$response['message'] ="Sukses";
			}else{
				$response['success'] ="0";
				$response['message'] ="Gagal";
			}
		
		}

		echo json_encode($response);
	}

?>