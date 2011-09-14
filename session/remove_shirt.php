<?php

session_start();

require_once "../class/shirt.php";

$id = $_POST['id'];

foreach($_SESSION['cart'] as $key=>$value){
	$shirt = new shirt();
	$shirt = unserialize($value);
	
	if($key != $id){
			
		if(count($_SESSION['new_cart'], 0) == 0){
			$_SESSION['new_cart'] = array(serialize($shirt));
		}else{
			array_unshift($_SESSION['new_cart'],serialize($shirt));
		}
	}
}

$_SESSION['cart'] = $_SESSION['new_cart'];
unset($_SESSION['new_cart']);

$return['items'] = $count;
$return['status'] = "OK";

echo json_encode($return);

?>