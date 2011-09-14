<?php
session_start(); 

include_once "../config/conn.php";

$name = $_POST['name'];
$email = $_POST['email'];
$feedback = $_POST['feedback'];

$to = "customercare@ronzaro.com";
$subject = "feedback for Ronzaro.com";
$message = $feedback;
// To send HTML mail, the Content-type header must be set
//$headers  = 'MIME-Version: 1.0' . "\r\n";
//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: '.$name.' <'.$email.'>' . "\r\n";
//$headers .= 'Bcc: bryan@ronzaro.com' . "\r\n";

// Mail it
mail("$to", $subject, $message, $headers);

// Additional headers
$headers = 'From: Ronzaro <customercare@ronzaro.com>' . "\r\n";
mail("$email", $subject, "hello $name, \n\nthank you for your feedback. we will reply to you within 12 hours.\n\nSincerely,\nRonzaro", $headers);

$return['status'] = "OK";

echo json_encode($return);

?>