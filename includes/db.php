<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "crud_system";


$db = mysqli_connect($servername,$username,$password,$db_name); 

if ($db->connect_error) {
    exit(json_encode(["status" => false, "error" => ["code" => 500, "message" => "Database connection failed"]]));
}
?>