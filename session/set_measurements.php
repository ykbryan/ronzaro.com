<?php
session_start();

include_once "../class/shirt.php";

include_once "../config/conn.php";

$conn = sqlConnection();
selectDB($conn);

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

$time = time(); //+ (60*60*15);
$time_now = date("Y-m-d H:i:s",$time);

$add_shirt = new shirt();
$add_shirt->set_parameters($_SESSION['shirt_id'], $_POST['collar_id'], $_POST['cuff_id'], $_POST['pocket_id'], $_POST['back_id'], $_POST['bottom_id'], $_POST['fit_id'], $_POST['monogram_color'], $_POST['monogram_placement'], $_POST['monogram_text']);

$add_shirt->set_measurement($name, $neck, $shoulder, $bicep, $armlength, $chest, $waist, $wrist, $hips, $shirtlength);

$add_shirt->unit = $unit;

if(count($_SESSION['cart'], 0) == 0){
	$_SESSION['cart'] = array(serialize($add_shirt));
}else{
	array_unshift($_SESSION['cart'],serialize($add_shirt));
}

$return['status'] = "OK";
$return['count'] = count($_SESSION['cart'], 0);

echo json_encode($return);

?>