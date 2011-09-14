<?php
session_start();

include_once "../config/conn.php";

$id = $_POST['id'];

$conn = sqlConnection();
selectDB($conn);

$get_address = "SELECT name, neck, shoulder, bicep, arm_length, wrist, chest, waist, hips, shirt_length FROM account_measurement WHERE id = '$id'";
$data = createQuery($get_address, $conn);

if (!mysql_num_rows($data))
	$return['status'] = "NooOOOoooo";
else{

	$row = mysql_fetch_row($data);
		
	$return['name'] = $row[0];
	$return['neck'] = $row[1];
	$return['shoulder'] = $row[2];
	$return['bicep'] = $row[3];
	$return['armlength'] = $row[4];
	$return['wrist'] = $row[5];
	$return['chest'] = $row[6];
	$return['waist'] = $row[7];
	$return['hips'] = $row[8];
	$return['shirtlength'] = $row[9];
	
	$return['status'] = "OK";
}

echo json_encode($return);

?>