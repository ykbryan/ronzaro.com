<?php
	session_start();
	
	unset($_SESSION['id']);
	unset($_SESSION['name']);
	unset($_SESSION['email']);
	unset($_SESSION['login']);
	
	echo '<script>location.href="./";</script>';
?>