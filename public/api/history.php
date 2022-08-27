<?php
	
	if(isset($_GET['id_teknisi'])){

		require_once "connect.php";

		$id = $_GET['id_teknisi'];

		$query = "SELECT a.id, a.created_at, a.status, b.job_name, c.customer_name, d.nama,
					(SELECT nota FROM transaction_posting WHERE id_service = a.id LIMIT 1)AS NOTA,
					(SELECT SUM(total) FROM transaction_posting WHERE id_service = a.id)AS TOTAL 
					FROM services a LEFT JOIN jobs b ON a.job_id = b.id LEFT JOIN customers c ON a.cust_id = c.id LEFT JOIN teknisi d ON a.tech_id = d.id WHERE d.id = '$id' ORDER BY a.id DESC";

		$result = mysqli_query($conn, $query);
		$response = array();
		while($row = mysqli_fetch_assoc($result)){
			array_push($response, 
            array(
                'id'=>$row['id'], 
                'tanggal'=>$row['created_at'],
                'pekerjaan'=>$row['job_name'],
                'pelanggan'=>$row['customer_name'], 
                'teknisi'=>$row['nama'],
                'nota' =>$row['NOTA'],
                'total'=>'Rp. '.number_format($row['TOTAL']),
            	'status'=>$row['status']) 
            );
		}
		
		echo json_encode($response);
	}

?>