<?php 
require "db.php";

$error_firstname = "";
$error_lastname = "";
$success = false;


if (isset($_POST["update_user_btn"])) {
    $user_id = $_POST['user_id'];
    $firstname = ucwords($_POST["firstname"]);
    $lastname = ucwords($_POST["lastname"]);
    $status = $_POST["status"];
    $role = $_POST["role"];

    if (empty($firstname)) {
        $error_firstname = "Please, Edit your first name";
    }
    if (empty($lastname)) {
        $error_lastname = "Please, Edit your last name";
    }

    if (empty($error_firstname) && empty($error_lastname)) {
        if($update_user = mysqli_query($db,"UPDATE users SET firstname = '$firstname', lastname = '$lastname', status = '$status', role = '$role' WHERE id = '$user_id'")){
            $success = true;
        }
    }
}

header('Content-Type: application/json');
echo json_encode([
    'success' => $success,
    'user_id' => $user_id,
    'firstname' => $firstname,
    'lastname' => $lastname,
    'status' => $status,
    'role' => $role,
    'errors' => [
        'firstname' => $error_firstname,
        'lastname' => $error_lastname,
    ]
]);

?>