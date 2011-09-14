<?php
include_once "../../config/conn.php";
include_once "../../includes/password.php";

$conn = sqlConnection();
selectDB($conn);

$username = $_POST['username'];
$password = hashThis("101",$_POST['password']);
$time = time(); //+ (60*60*15);
$time_now = date("Y-m-d H:i:s",$time);

$admins = "INSERT INTO admin ( `username`, `password`, `date_created`) VALUES ( '$username', '$password', '$time_now' )";
createQuery($admins, $conn);

$return['html'] = "oK";
echo json_encode($return);

?>