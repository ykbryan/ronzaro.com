<?php
session_start();

include_once "../class/shirt.php";

include_once "../config/conn.php";

$conn = sqlConnection();
selectDB($conn);

$id = $_POST['id'];
$size_collar = $_POST['size_collar'];
$size_sleeve = $_POST['size_sleeve'];
$size_cuff = $_POST['size_cuff'];
$size_chest = $_POST['size_chest'];
$size_name = $_POST['size_name'];

$unit = $_POST['unit'];

$time = time(); //+ (60*60*15);
$time_now = date("Y-m-d H:i:s",$time);

$fit_id = $_POST['fit_id'];
//get allowance
$fit_allowance_db = "SELECT cuff, chest FROM shirt_fit_allowance WHERE shirt_fit_id = '$fit_id'";
$fit_allowance = createQuery($fit_allowance_db, $conn);
$row = mysql_fetch_row($fit_allowance);
$allowance_cuff = $row[0];
$allowance_chest = $row[1];
//set shirt
$add_shirt = new shirt();
$add_shirt->set_parameters($_SESSION['shirt_id'], $_POST['collar_id'], $_POST['cuff_id'], $_POST['pocket_id'], $_POST['back_id'], $_POST['bottom_id'], $_POST['fit_id'], $_POST['monogram_color'], $_POST['monogram_placement'], $_POST['monogram_text']);
//get default size
$get_default_db = "SELECT neck, arm_length, wrist, chest FROM default_measurement WHERE id = '$id'";
$get_default = createQuery($get_default_db, $conn);
$row = mysql_fetch_row($get_default);
//compare
if($unit == "inches"){
	if($size_collar == $row[0]) $default_neck = $row[0];
	else $default_neck = $size_collar;
	
	if($size_sleeve == $row[1]) $default_arm_length = $row[1];
	else $default_arm_length = $size_sleeve;
	
	if(($size_cuff-$allowance_cuff) == $row[2]) $default_wrist = $row[2];
	else $default_wrist = $size_cuff-$allowance_cuff;
	
	if(($size_chest-$allowance_chest) == $row[3]) $default_chest = $row[3];
	else $default_chest = $size_chest-$allowance_chest;
}else{
	$standard_collar = round($row[0]*2.54);
	if($size_collar == $standard_collar) $default_neck = $standard_collar;
	else $default_neck = $size_collar;
	
	$standard_sleeve = round($row[1]*2.54);
	if($size_sleeve == $standard_sleeve) $default_arm_length = $standard_sleeve;
	else $default_arm_length = $size_sleeve;
	
	$standard_cuff = round($row[2]*2.54);
	if(($size_cuff-$allowance_cuff) == $standard_cuff) $default_wrist = $standard_cuff;
	else $default_wrist = $size_cuff-$allowance_cuff;
	
	$standard_chest = round($row[3]*2.54);
	if(($size_chest-$allowance_chest) == $standard_chest) $default_chest = $standard_chest;
	else $default_chest = $size_chest-$allowance_chest;
}

$add_shirt->set_standard($default_neck, $default_arm_length, $default_wrist, $default_chest, $id, $size_name);
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