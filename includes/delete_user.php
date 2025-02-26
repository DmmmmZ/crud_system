<?php 
require "db.php";

if(isset($_POST["click_delete_btn"])) {
    $delete_id = $_POST['delete_id'];

    $delete_user = mysqli_query($db, "DELETE FROM users WHERE id = '$delete_id'");
}

?>