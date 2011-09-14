<?php
session_start();

include_once "../class/shirt.php";

include_once "../config/conn.php";

$conn = sqlConnection();
selectDB($conn);

$id = $_POST['id'];

$time = time(); //+ (60*60*15);
$time_now = date("Y-m-d H:i:s",$time);

$add_shirt = new shirt();
$add_shirt->set_parameters($_SESSION['shirt_id'], $_POST['collar_id'], $_POST['cuff_id'], $_POST['pocket_id'], $_POST['back_id'], $_POST['bottom_id'], $_POST['fit_id'], $_POST['monogram_color'], $_POST['monogram_placement'], $_POST['monogram_text']);

//get existing measurement
$get_measurement = "SELECT name, neck, shoulder, arm_length, wrist, bicep, chest, waist, hips, shirt_length FROM account_measurement WHERE id = '$id'";
$data = createQuery($get_measurement, $conn);

$row = mysql_fetch_row($data);

$name = $row[0];
$neck = $row[1];
$shoulder = $row[2];
$bicep = $row[3];
$armlength = $row[4];
$chest = $row[5];
$waist = $row[6];
$wrist = $row[7];
$hips = $row[8];
$shirtlength = $row[9];

$add_shirt->set_measurement($name, $neck, $shoulder, $bicep, $armlength, $chest, $waist, $wrist, $hips, $shirtlength);

if(count($_SESSION['cart'], 0) == 0){
	$_SESSION['cart'] = array(serialize($add_shirt));
}else{
	array_unshift($_SESSION['cart'],serialize($add_shirt));
}

$return['status'] = "OK";
$return['count'] = count($_SESSION['cart'], 0);

echo json_encode($return);

?>