<?php
session_start(); 

include_once "../config/conn.php";

$email = $_POST['email'];

$conn = sqlConnection();
selectDB($conn);

$time = time(); //+ (60*60*15);
$time_now = date("Y-m-d H:i:s",$time);

$update = "UPDATE account SET date_modified = '$time_now', email = '$email' WHERE id = ".$_SESSION['id'];
createQuery($update, $conn);

$return['status'] = "OK";

echo json_encode($return);

?>