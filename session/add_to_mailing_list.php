<?php

include_once "../config/conn.php";

$name = $_POST['name'];
$email = $_POST['email'];

$conn = sqlConnection();
selectDB($conn);

$time = time(); //+ (60*60*15);
$time_now = date("Y-m-d H:i:s",$time);

$verify = "SELECT id FROM mailing WHERE email = '$email'";
$num = createQuery($verify, $conn);

if (!mysql_num_rows($num)){
	$add_mailing = "INSERT INTO mailing (`name`, `email`, `date_created`) values ('$name','$email', '$time_now')";
	createQuery($add_mailing, $conn);
	$return['status'] = "OK";
}else{
	$update_mailing = "UPDATE mailing SET name = '$name', date_created = '$time_now' WHERE email = '$email'";
	createQuery($update_mailing, $conn);
	$return['status'] = "update";
}
	
$to = $email;
$subject = "Welcome to RONZARO";
$message = '<div style="border:#AAA 1px solid; font-family:Helvetica, sans-serif; padding:10px; margin:5px; font-size:11px; width:500px">
			<div style="border-bottom:8px solid #AAA; margin:0px; padding-bottom:10px"><img src="http://www.ronzaro.com/images/logo.png" border="0" width="200" /></div>
			<p>
			Dear <strong>'.$name.'</strong>,
			<p>
			Thank you for subscribing to us. We will update you when the next series is released.
			<p>
			Do visit our current collection "Monday Blues" and we hope you will join RONZARO\'s club of esteemed customers soon.
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
mail("support@ronzaro.com", "MAILING (".$to."): $name has joined the mailing list", $message, $headers);


echo json_encode($return);

?>