<?php
	
	require_once "connect.php";

	if(isset($_POST['id'])){

		$id = $_POST['id'];

		$query = "SELECT a.id, a.status, a.note, a.created_at, b.nama, c.job_name, d.customer_name, d.customer_address, d.jenis_kelamin, d.customer_phone, d.customer_foto
					FROM services a LEFT JOIN teknisi b ON a.tech_id = b.id LEFT JOIN jobs c ON a.job_id=c.id LEFT JOIN customers d ON a.cust_id = d.id WHERE a.id ='$id' ORDER BY a.id DESC ";
		$result = mysqli_query($conn, $query);
		$response['data'] = array();
        $response['success'] = "1";
        while( $row = mysqli_fetch_assoc($result)){
            array_push($response['data'], 
            array(
                    'id'=>$row['id'], 
                    'status'=>$row['status'],
                    'note'=>$row['note'],
                    'tanggal'=> date('d F Y', strtotime($row['created_at'])), 
                    'teknisi'=>$row['nama'],
                    'pekerjaan' =>$row['job_name'],
                    'pelanggan'=>$row['customer_name'],
                    'alamat'=>$row['customer_address'],
                    'jk'=>$row['jenis_kelamin'],
                    'hp'=>$row['customer_phone'],
                    'foto'=>'http://192.168.43.107/serviceku/laravel/public/upload/pelanggan/'.$row['customer_foto']
                ) 
            );
        }
        echo json_encode($response);

	}

?>