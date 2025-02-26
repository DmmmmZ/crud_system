<?php 
require "db.php";

if (isset($_POST['click_edit_btn'])) {
    $user_id = $_POST['user_id'];


    $edit_user = mysqli_query($db, "SELECT * FROM users WHERE id ='$user_id'");
    $result_array = [];
    if (mysqli_num_rows($edit) > 0) {
        foreach ($edit as $row) {
            array_push($result_array, $row);
        }
        header('Content-type: application/json');
        echo json_encode($result_array);
    }
}


?>