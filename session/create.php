<?php
session_start();

include_once "../config/conn.php";
include_once "../includes/password.php";

$name = $_POST['name'];
$email = $_POST['email'];
$password = hashThis("101",$_POST['password']);

$conn = sqlConnection();
selectDB($conn);

$time = time(); //+ (60*60*15);
$time_now = date("Y-m-d H:i:s",$time);

$verify = "SELECT id, firstname FROM account WHERE email = '$email' AND is_guest = 'N'";
$num = createQuery($verify, $conn);

if (mysql_num_rows($num))
	$return['status'] = "NooOOOoooo";
else{
		
	$add_account = "INSERT INTO account (`firstname`, `email`, `password`, `date_created`, `date_modified`, `date_last_login`) values ('$name','$email', '$password', '$time_now', '$time_now', '$time_now')";
	createQuery($add_account, $conn);
	
	$_SESSION['id'] = mysql_insert_id();
	$_SESSION['name'] = $name;
	$_SESSION['email'] = $email;
	$_SESSION['login'] = 1;
	
	$to = $email;
	$subject = "Welcome to RONZARO";
	$message = '<div style="border:#AAA 1px solid; font-family:Helvetica, sans-serif; padding:10px; margin:5px; font-size:11px; width:500px">
				<div style="border-bottom:8px solid #AAA; margin:0px; padding-bottom:10px"><img src="http://images.ronzaro.netdna-cdn.com/logo.png" border="0" width="200" /></div>
				<p>
				Dear <strong>'.$name.'</strong>,
				<p>
				We are charmed to have you with us. Soon, you will join RONZARO\'s club of discerning customers who seek avant-garde designs in exclusive numbers.
				<p>
				We understand that individual personalities are unique and we allow our customers to personalize details without compromising the overall design of the article.
				<p>
				Our careful selection of premium materials combined with impeccable workmanship results in products of the highest qualitity.
				<p>
				At RONZARO, we value our relationship with you. Please let us know if you have any feedback, queries or suggestions and we will respond within 24 hours.
				<p>
				The current theme is "Monday Blues" and we hope you will enjoy RONZARO.
				<p>
				Yours warmly,<br />
				<strong>Ronzaro</strong>
				</div>';
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	//$headers .= 'To: '.$name.' <'.$email.'>' . "\r\n";
	$headers .= 'From: Ronzaro <customercare@ronzaro.com>' . "\r\n";
	//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
	//$headers .= 'Bcc: bryan@ronzaro.com' . "\r\n";
	
	// Mail it
	mail($to, $subject, $message, $headers);
	mail("support@ronzaro.com", "ACCOUNT: (".$to."): ".$subject, $message, $headers);
	
	$return['status'] = "OK";
	
}

echo json_encode($return);

?>