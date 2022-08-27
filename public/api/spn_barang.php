<?php
	
	if(isset($_POST['spn_barang'])){

		require_once "connect.php";

		$query = "SELECT * FROM goods ORDER BY id";
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result)>0){
			$response['data'] = array();
			$response['success'] = "1";
			while($data = mysqli_fetch_assoc($result)){
				$row['id'] = $data['id'];
				$row['good_name'] = $data['good_name'];
				$row['price'] = $data['s_price'];

				array_push($response['data'], $row);
			} 
		}
		else{

			$response['success'] = "0";
		}	

		echo json_encode($response);
		
	}

?>