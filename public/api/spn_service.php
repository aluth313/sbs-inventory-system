<?php
	
	if(isset($_POST['spn_job'])){

		require_once "connect.php";

		$query = "SELECT * FROM jobs ORDER BY id";
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result)>0){
			$response['data'] = array();
			$response['success'] = "1";
			while($data = mysqli_fetch_assoc($result)){
				$row['id'] = $data['id'];
				$row['job_name'] = $data['job_name'];
				$row['price'] = $data['price'];

				array_push($response['data'], $row);
			} 
		}
		else{

			$response['success'] = "0";
		}	

		echo json_encode($response);
		
	}

?>