<?php
	
	if($_SERVER['REQUEST_METHOD']=='POST'){

		$id_service = $_POST['id'];

		require_once "connect.php";

		$query = "SELECT a.id, a.status, a.note, a.otw_time, a.start_time, a.finish_time, a.cancel_time, a.created_at, b.job_name, c.nama, d.customer_name, d.customer_address, (SELECT nota FROM transaction_posting WHERE id_service = a.id LIMIT 1)AS NOTA,
		(SELECT created_at FROM transaction_posting WHERE id_service = a.id LIMIT 1)AS BILL, 
			(SELECT SUM(total) FROM transaction_posting WHERE id_service = a.id)AS TOTAL 
			FROM services a LEFT JOIN jobs b ON a.job_id = b.id LEFT JOIN teknisi c ON a.tech_id = c.id LEFT JOIN customers d ON a.cust_id = d.id WHERE a.id = '$id_service' ORDER BY a.id DESC";

		$result = mysqli_query($conn, $query);
		$response['data'] = array();
		$response['success'] = "1";

		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_assoc($result)){
				array_push($response['data'], 
	            	array(
		                    'id'		=>$row['id'], 
		                    'status'	=>$row['status'],
		                    'note'		=>$row['note'],
		                    'otw'		=>$row['otw_time'],
		                    'start' 	=>$row['start_time'],
		                    'finish' 	=>$row['finish_time'],
		                    'bill' 		=>$row['BILL'],
		                    'cancel' 	=>$row['cancel_time'],
		                    'tanggal'	=>$row['created_at'],
		                    'pekerjaan' =>$row['job_name'],
		                    'teknisi' 	=>$row['nama'], 
		                    'pelanggan'	=>$row['customer_name'],
		                    'alamat'	=>$row['customer_address'],
		                    'nota'		=>$row['NOTA'],
		                    'total'		=>$row['TOTAL']
		            )
	            );
            }	
		}

		echo json_encode($response);
	}
?>