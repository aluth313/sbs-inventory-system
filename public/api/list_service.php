<?php
	
	require_once "connect.php";

	if(isset($_GET['teknisi_id'])){

		$id = $_GET['teknisi_id'];

		$query = "SELECT a.id, a.status, a.note, a.created_at, b.nama, c.job_name, d.customer_name, d.customer_phone
					FROM services a LEFT JOIN teknisi b ON a.tech_id = b.id LEFT JOIN jobs c ON a.job_id=c.id LEFT JOIN customers d ON a.cust_id = d.id WHERE a.tech_id ='$id' AND a.status <3 ORDER BY a.id DESC ";
		$result = mysqli_query($conn, $query);
		$response = array();
        while( $row = mysqli_fetch_assoc($result)){
            array_push($response, 
            array(
                'id'=>$row['id'], 
                'status'=>$row['status'],
                'note'=>$row['note'],
                'tanggal'=>$row['created_at'], 
                'teknisi'=>$row['nama'],
                'pekerjaan' =>$row['job_name'],
                'pelanggan'=>$row['customer_name'],
            	'phone'=>$row['customer_phone']) 
            );
        }
        echo json_encode($response);

	}


?>