<?php
	

	if(isset($_GET['teknisi_id'])){

        require_once "connect.php";

		$id = $_GET['teknisi_id'];

		$query = "SELECT a.id, a.created_at, a.status, b.nama, c.job_name, d.customer_name,
                    (SELECT SUM(total) FROM transaction_posting WHERE id_service = a.id)AS TOTAL,
                    (SELECT nota FROM transaction_posting WHERE id_service = a.id LIMIT 1)AS nota
					FROM services a LEFT JOIN teknisi b ON a.tech_id = b.id LEFT JOIN jobs c ON a.job_id=c.id LEFT JOIN customers d ON a.cust_id = d.id  WHERE a.tech_id ='$id' AND (a.status = 3 OR a.status = 6)  ORDER BY a.id DESC LIMIT 20 ";
		$result = mysqli_query($conn, $query);
		$response= array();
        
        while($row = mysqli_fetch_assoc($result)){
            array_push($response, 
            array(
                    'id'=>$row['id'], 
                    'tanggal'=>date('d F Y', strtotime($row['created_at'])),
                    'teknisi'=>$row['nama'],
                    'pekerjaan'=> $row['job_name'],  
                    'pelanggan'=>$row['customer_name'],
                    'nota' =>$row['nota'],
                    'total'=>'Rp. '.number_format($row['TOTAL']),
                    'status'=>$row['status']              
                ) 
            );
        }
        echo json_encode($response);

	}

?>