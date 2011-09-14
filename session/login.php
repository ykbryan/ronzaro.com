<?php
session_start(); 

include_once "../config/conn.php";
include_once "../includes/password.php";

$email = $_POST['email'];
$password = hashThis("101",$_POST['password']);

$conn = sqlConnection();
selectDB($conn);

$time = time(); //+ (60*60*15);
$time_now = date("Y-m-d H:i:s",$time);

$verify = "SELECT id, firstname FROM account WHERE email = '$email' AND password = '$password' AND is_guest = 'N'";
$num = createQuery($verify, $conn);

if (!mysql_num_rows($num))
	$return['status'] = "NooOOOoooo";
else{
	
	$id = mysql_fetch_row($num);
	
	$update = "UPDATE account SET date_last_login = '$time_now' WHERE id = $id[0]";
	createQuery($update, $conn);
	
	$return['status'] = "OK";
	$return['name'] = $id[1];
	
	$_SESSION['id'] = $id[0];
	$_SESSION['name'] = $id[1];
	$_SESSION['email'] = $email;
	$_SESSION['login'] = 1;
}

echo json_encode($return);

?>