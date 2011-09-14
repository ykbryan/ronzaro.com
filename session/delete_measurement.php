<?php
session_start(); 

include_once "../config/conn.php";

$id = $_POST['id'];

$conn = sqlConnection();
selectDB($conn);

$update = "DELETE FROM account_measurement WHERE id = '$id'";
createQuery($update, $conn);

$return['id'] = $id;
$return['status'] = "OK";

echo json_encode($return);

?>