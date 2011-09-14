<?php
session_start(); 

include_once "../config/conn.php";

$id = $_POST['id'];
$name = $_POST['name'];
$address_line_1 = $_POST['address_line_1'];
$address_line_2 = $_POST['address_line_2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$address_country = $_POST['address_country'];
$address_phone_number = $_POST['address_phone_number'];

$conn = sqlConnection();
selectDB($conn);

$time = time(); //+ (60*60*15);
$time_now = date("Y-m-d H:i:s",$time);

$update = "UPDATE shipping_address SET date_modified = '$time_now', name = '$name', address_line_1 = '$address_line_1', address_line_2 = '$address_line_2', city = '$city', state = '$state', zip = '$zip', country = '$address_country', phone_number = '$address_phone_number' WHERE id = '$id'";
createQuery($update, $conn);

$return['id'] = $id;
$return['name'] = $name;
$return['status'] = "OK";

echo json_encode($return);

?>