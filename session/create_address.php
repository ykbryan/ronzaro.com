<?php
session_start();

include_once "../config/conn.php";

$account_id = $_SESSION['id'];
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

$add_address = "INSERT INTO shipping_address (`account_id`, `name`, `address_line_1`, `address_line_2`, `city`, `state`, `zip`, `country`, `phone_number`, `date_created`, `date_modified`) values ('$account_id','$name','$address_line_1', '$address_line_2', '$city', '$state', '$zip', '$address_country', '$address_phone_number', '$time_now', '$time_now')";
createQuery($add_address, $conn);

$return['id'] = mysql_insert_id();	
$return['name'] = $name;		

$return['status'] = "OK";

echo json_encode($return);

?>