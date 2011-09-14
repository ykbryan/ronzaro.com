<?php
session_start(); 

include_once "../config/conn.php";

$id = $_POST['id'];
$name = $_POST['name'];
$neck = $_POST['neck'];
$shoulder = $_POST['shoulder'];
$bicep = $_POST['bicep'];
$armlength = $_POST['armlength'];
$wrist = $_POST['wrist'];
$chest = $_POST['chest'];
$waist = $_POST['waist'];
$hips = $_POST['hips'];
$shirtlength = $_POST['shirtlength'];

$conn = sqlConnection();
selectDB($conn);

$time = time(); //+ (60*60*15);
$time_now = date("Y-m-d H:i:s",$time);

$update = "UPDATE account_measurement SET date_modified = '$time_now', name = '$name', neck = '$neck', shoulder = '$shoulder', bicep = '$bicep', arm_length = '$armlength', wrist = '$wrist', chest = '$chest', waist = '$waist', hips = '$hips', shirt_length = '$shirtlength' WHERE id = '$id'";
createQuery($update, $conn);

$return['id'] = $id;
$return['status'] = "OK";

echo json_encode($return);

?>