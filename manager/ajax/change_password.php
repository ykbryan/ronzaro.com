<?php
session_start();
include_once "../../config/conn.php";
include_once "../../includes/password.php";

$conn = sqlConnection();
selectDB($conn);

$password = hashThis("101",$_POST['password']);

$update = "UPDATE admin SET password = '$password' WHERE id = '".$_SESSION['staff_id']."'";
createQuery($update, $conn);

$return['status'] = "OK";

echo json_encode($return);

?>