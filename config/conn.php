<?php
function sqlConnection(){
	$host = "localhost"; 
	$user ="root";
	$password = "Bryan1986";
	
	$connection = mysql_connect($host, $user, $password) or die(mysql_error());
	return $connection;
}
function selectDB($connection){
	$database = "mondb_wp";
	mysql_select_db($database,$connection)  or die(mysql_error());
}
function createQuery($query, $connection){
	$res = mysql_query($query,$connection) or die(mysql_error());
	return $res;
}

$conn = sqlConnection();
selectDB($conn);
?>
