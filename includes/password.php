<?php
function hashThis($id, $password){
	$hash = md5($password);
	$hash = $id. $hash;
	$hash = md5($hash) . $id;
	return $hash;	
}
?>