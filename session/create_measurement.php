<?php
session_start();

include_once "../config/conn.php";

$account_id = $_SESSION['id'];
$name = $_POST['name'];
$neck = $_POST['neck'];
$shoulder = $_POST['shoulder'];
$bicep = $_POST['bicep'];
$armlength = $_POST['armlength'];
$chest = $_POST['chest'];
$waist = $_POST['waist'];
$wrist = $_POST['wrist'];
$hips = $_POST['hips'];
$shirtlength = $_POST['shirtlength'];
$unit = $_POST['unit'];

$conn = sqlConnection();
selectDB($conn);

$time = time(); //+ (60*60*15);
$time_now = date("Y-m-d H:i:s",$time);

$add_measurement = "INSERT INTO account_measurement (`account_id`, `name`, `unit`, `neck`, `shoulder`, `bicep`, `arm_length`, `chest`, `waist`, `wrist`, `hips`, `shirt_length`, `date_created`, `date_modified`) values ('$account_id', '$name', '$unit', '$neck', '$shoulder', '$bicep', '$armlength', '$chest', '$waist', '$wrist', '$hips', '$shirtlength', '$time_now', '$time_now')";
createQuery($add_measurement, $conn);

$return['id'] = mysql_insert_id();	
$return['name'] = $name;		

$return['status'] = "OK";

echo json_encode($return);

?>