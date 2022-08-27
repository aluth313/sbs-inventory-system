<?php 

require_once 'connect.php';

$type = $_GET['item_type'];

if (isset($_GET['key'])) {
    $key = $_GET["key"];
    if ($type == 'users') {
        $query = "SELECT * FROM jobs WHERE job_name LIKE '%$key%'";
        $result = mysqli_query($conn, $query);
        $response = array();
        while( $row = mysqli_fetch_assoc($result) ){
            array_push($response, 
            array(
                'id'=>$row['id'], 
                'job_name'=>$row['job_name'], 
                'description'=>$row['description'],
                'price'=>'Rp. '.number_format($row['price'])) 
            );
        }
        echo json_encode($response);   
    }
} else {
    if ($type == 'users') {
        $query = "SELECT * FROM jobs";
        $result = mysqli_query($conn, $query);
        $response = array();
        while( $row = mysqli_fetch_assoc($result) ){
            array_push($response, 
            array(
                'id'=>$row['id'], 
                'job_name'=>$row['job_name'], 
                'description'=>$row['description'],
                'price'=>'Rp. '.number_format($row['price'])) 
            );
        }
        echo json_encode($response);   
    }
}

mysqli_close($conn);

?>