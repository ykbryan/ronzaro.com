<?php
session_start();

include_once "../class/promotion.php";

include_once "../config/conn.php";

$conn = sqlConnection();
selectDB($conn);

$code = $_POST['id'];

$get_promo = "SELECT id, name, description, is_free_shirt, is_used FROM `promotion_code` WHERE `code` = '$code' LIMIT 1";
$data = createQuery($get_promo, $conn);

if (!mysql_num_rows($data))
	$return['status'] = "none";
else{
	
	$row = mysql_fetch_row($data);
	
	if($row[4] == 'Y')
		$return['status'] = "used!";
	else{
		$promotion = new promotion();
		$promotion->set_parameters($row[0], $code, $row[1], $row[2], $row[3]);
		
		$_SESSION['promotion'] = serialize($promotion);
		
		$return['status'] = "OK";
	}
}

echo json_encode($return);

?>