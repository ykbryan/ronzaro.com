<?php
session_start();
include_once "../../config/conn.php";

$username = $_POST['username'];
$conn = sqlConnection();
selectDB($conn);

$update = "UPDATE admin SET username = '$username' WHERE id = '".$_SESSION['staff_id']."'";
createQuery($update, $conn);

$return['status'] = "OK";

echo json_encode($return);

?>