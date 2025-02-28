<?php
require "db.php";

$error_firstname = "";
$error_lastname = "";
$error_role = "";
$success = false;

if (isset($_POST["add_user_btn"])) {

    $firstname = ucwords($_POST["firstname"]);
    $lastname = ucwords($_POST["lastname"]);
    $status = $_POST["status"];
    $role = $_POST["role"];


    if (empty($firstname)) {
        $error_firstname = "Please, Enter your first name";
    }
    if (empty($lastname)) {
        $error_lastname = "Please, Enter your last name";
    }
    if (empty($role)) {
        $error_role = "Please, select your role";
    }

    if (empty($error_firstname) && empty($error_lastname) && empty($error_role)) {
        if($add_user = mysqli_query($db,"INSERT INTO users (firstname, lastname, status, role) VALUES ('$firstname', '$lastname', '$status', '$role')")){
            $success = true;
        }
    }
}

header('Content-Type: application/json');
echo json_encode([
    'success' => $success,
    'user_id' => $user_id = mysqli_insert_id($db), 
    'firstname' => $firstname,
    'lastname' => $lastname,
    'status' => $status,
    'role' => $role,
    'errors' => [
        'firstname' => $error_firstname,
        'lastname' => $error_lastname,
        'role' => $error_role,
    ]
]);
?>
