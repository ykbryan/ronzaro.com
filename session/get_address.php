<?php
session_start();

include_once "../config/conn.php";

$id = $_POST['id'];

$conn = sqlConnection();
selectDB($conn);

$get_address = "SELECT name, address_line_1, address_line_2, city, state, zip, country, phone_number FROM shipping_address WHERE id = '$id'";
$data = createQuery($get_address, $conn);

if (!mysql_num_rows($data))
	$return['status'] = "NooOOOoooo";
else{

	$row = mysql_fetch_row($data);
		
	$return['name'] = $row[0];
	$return['address_line_1'] = $row[1];
	$return['address_line_2'] = $row[2];
	$return['city'] = $row[3];
	$return['state'] = $row[4];
	$return['zip'] = $row[5];
	$return['country'] = $row[6];
	$return['phone_number'] = $row[7];
	
	$return['status'] = "OK";
}

echo json_encode($return);

?>