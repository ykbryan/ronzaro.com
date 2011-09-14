<?php
session_start(); 

include_once "../../config/conn.php";
include_once "../../includes/password.php";

$username = $_POST['username'];
$password = hashThis("101",$_POST['password']);

$conn = sqlConnection();
selectDB($conn);
  
$time = time(); //+ (60*60*15);
$time_now = date("Y-m-d H:i:s",$time);

$verify = "SELECT id, username FROM admin WHERE username = '$username' AND password = '$password'";
$num = createQuery($verify, $conn);

if (!mysql_num_rows($num))
	$return['status'] = "NooOOOoooo";
else{
	
	$id = mysql_fetch_row($num);
	
	$update = "UPDATE admin SET date_login = '$time_now' WHERE id = $id[0]";
	createQuery($update, $conn);
	
	$return['status'] = "OK";
	$return['name'] = $id[1];
	
	$_SESSION['staff_id'] = $id[0];
}

echo json_encode($return);

?>