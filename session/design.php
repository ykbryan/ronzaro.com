<?php
session_start();

require_once "../class/shirt.php";

$add_shirt = new shirt();
$add_shirt->setParameters($_SESSION['shirt_id'], $_POST['collar_id'], $_POST['cuff_id'], $_POST['pocket_id'], $_POST['back_id'], $_POST['bottom_id'], $_POST['fit_id'], $_POST['monogram_color'], $_POST['monogram_placement'], $_POST['monogram_text']);

if(count($_SESSION['cart'], 0) == 0){
	$_SESSION['cart'] = array(serialize($add_shirt));
}else{
	array_unshift($_SESSION['cart'],serialize($add_shirt));
}

$return['status'] = "OK";
	
echo json_encode($return);

?>