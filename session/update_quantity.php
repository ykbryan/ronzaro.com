<?php

session_start();

require_once "../class/shirt.php";

$id = $_POST['id'];
$quantity = $_POST['quantity'];

$count = 0;
foreach($_SESSION['cart'] as $key=>$value){
	$shirt = new shirt();
	$shirt = unserialize($value);
	
	if($key == $id){
		$shirt->quantity = $quantity;
	}
	
	if(count($_SESSION['new_cart'], 0) == 0){
		$_SESSION['new_cart'] = array(serialize($shirt));
	}else{
		array_unshift($_SESSION['new_cart'],serialize($shirt));
	}
}

$_SESSION['cart'] = $_SESSION['new_cart'];
unset($_SESSION['new_cart']);

$return['status'] = "OK";

echo json_encode($return);

?>