<?php
session_start(); 

include_once "../config/conn.php";
include_once "../includes/password.php";

$newpassword = hashThis("101",$_POST['newpassword']);

$conn = sqlConnection();
selectDB($conn);

$verify = "SELECT id FROM account WHERE id = '".$_SESSION['id']."' AND is_guest = 'N'";
$num = createQuery($verify, $conn);

if (!mysql_num_rows($num))
	$return['status'] = "NooOOOoooo";
else{
	
	$time = time(); //+ (60*60*15);
	$time_now = date("Y-m-d H:i:s",$time);
	
	$update = "UPDATE account SET date_modified = '$time_now', password = '$newpassword' WHERE id = ".$_SESSION['id'];
	createQuery($update, $conn);
	
	$return['status'] = "OK";
}

echo json_encode($return);

?>