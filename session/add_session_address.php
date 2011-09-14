<?php
session_start();

include_once "../class/address.php";
	
$name = $_POST['name'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$country = $_POST['country'];
$number = $_POST['number'];

$address = new address();
$address->set_parameters($name, $address1, $address2, $city, $state, $zip, $country, $number);

$_SESSION['address'] = serialize($address);

$return['status'] = "OK";
$return['name'] = $name;

echo json_encode($return);

?>