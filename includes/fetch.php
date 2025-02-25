<?php 
require "db.php";


$fetch_user = mysqli_query($db, "SELECT * FROM users");   



if(mysqli_num_rows($fetch_user)){
    foreach($fetch_user as $row){
            $result_array[] = [
                "id" => $row['id'],
                "firstname" => $row['firstname'],
                "lastname" => $row['lastname'],
                "status" => $row['status'],
                "role" => $row['role']
            ];
    }

    $response = [
        "status" => true,
        "error" => null,
        "users" => $result_array
    ];

    header('content-type: application/json');
    echo json_encode($response);
}
?>