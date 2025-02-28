<?php
require "db.php";

header("Content-Type: application/json");

if (isset($_POST['action_click_btn'])) {
    $user_id = $_POST['user_id'];
    $operation = $_POST['operation'];

    $idList = implode(',', $user_id);

    if ($operation === 'delete') {
        $action = "DELETE FROM users WHERE id IN ($idList)";
    } elseif ($operation === 'set_active') {
        $action = "UPDATE users SET status='active' WHERE id IN ($idList)";
    } elseif ($operation === 'set_not_active') {
        $action = "UPDATE users SET status='inactive' WHERE id IN ($idList)";
    }

    if (mysqli_query($db,$action)) {
        echo json_encode(["status" => true, "error" => null]);
    }
}
?>