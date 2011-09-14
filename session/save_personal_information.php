<?php
session_start(); 

include_once "../config/conn.php";

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$occupation = $_POST['occupation'];
$title = $_POST['title'];
$birthdate = $_POST['birthdate'];
$country = $_POST['country'];
$email = $_POST['email'];

$conn = sqlConnection();
selectDB($conn);

$time = time(); //+ (60*60*15);
$time_now = date("Y-m-d H:i:s",$time);

$update = "UPDATE account SET date_modified = '$time_now', firstname = '$firstname', lastname = '$lastname', occupation = '$occupation', title = '$title', birthdate = '$birthdate', email = '$email', country = '$country' WHERE id = ".$_SESSION['id'];
createQuery($update, $conn);

$return['status'] = "OK";

echo json_encode($return);

?>