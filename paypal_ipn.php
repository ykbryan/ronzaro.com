<?php

// Check to see there are posted variables coming into the script
//if ($_SERVER['REQUEST_METHOD'] != "POST") die ("No Post Variables");

// Initialize the $req variable and add CMD key value pair
$req = 'cmd=_notify-validate';
// Read the post from PayPal
foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
}
// Now Post all of that back to PayPal's server using curl, and validate everything with PayPal
// We will use CURL instead of PHP for this for a more universally operable script (fsockopen has issues on some environments)
//$url = "https://www.sandbox.paypal.com/cgi-bin/webscr";

$url = $paypal_url;
$curl_result=$curl_err='';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
curl_setopt($ch, CURLOPT_HEADER , 0);   
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$curl_result = @curl_exec($ch);
$curl_err = curl_error($ch);
curl_close($ch);

$req = str_replace("&", "\n", $req);  // Make it a nice list in case we want to email it to ourselves for reporting

// Check that the result verifies
/*
if (strpos($curl_result, "VERIFIED") !== false) {
    $req .= "\n\nPaypal Verified OK";
} else {
	$req .= "\n\nData NOT verified from Paypal!";
	mail("$notify_email", "IPN interaction not verified", "$req", "From: $notify_email" );
	exit();
}
*/

/* CHECK THESE 4 THINGS BEFORE PROCESSING THE TRANSACTION, HANDLE THEM AS YOU WISH
1. Make sure that business email returned is your business email
2. Make sure that the transaction’s payment status is “completed”
3. Make sure there are no duplicate txn_id
4. Make sure the payment amount matches what you charge for items. (Defeat Price-Jacking) */
//mail("$notify_email", "Receiver Email", $_POST['receiver_email'], "From: $notify_email" );

include_once "includes/paypal_variables.php";

$receiver_email = $_POST['receiver_email'];
if ($receiver_email != $paypal_email) {
	$message = "Investigate why and how receiver email is wrong. Email = " . $_POST['receiver_email'] . "\n\n\n$req";
    mail("$notify_email", "Receiver Email is incorrect", $message, "From: $paypal_email" );
    exit(); // exit script
}

if ($_POST['payment_status'] != "Completed") {
	// Handle how you think you should if a payment is not complete yet, a few scenarios can cause a transaction to be incomplete
	$message = "Payment status (".$_POST['payment_status'].") problem. Manually check the txn_id in the database and paypal \n\n\n$req";
    mail("$notify_email", "Payment status is not Completed", $message, "From: $paypal_email" );
    exit();
}


//mail("$notify_email", "test2: up to step 2, step 3 is next", "$req", "From: $paypal_email" );

require_once "config/conn.php";

$conn = sqlConnection();
selectDB($conn);
//mail("$notify_email", "test3: db connected", "$req", "From: $paypal_email" );

//check for duplicated txn_id
$checkTxn = "select id from payment WHERE paypal_txn_id = '". $_POST['txn_id'] ."'";
$txn = createQuery($checkTxn, $conn);
//mail("$notify_email", "test3: query made", "$req", "From: $paypal_email" );

$numRows = mysql_num_rows($txn);
if ($numRows > 0) {
    $message = "Duplicate transaction ID occured so we killed the IPN script. \n\n\n$req";
    mail("$notify_email", "Duplicate txn_id in the IPN system", "$message", "From: $paypal_email" );
    exit(); // exit script
} 

//mail("$notify_email", "test4: no duplicated paypal txn ID found", "$req", "From: $paypal_email" );

$payment_id = $_POST['custom'];
$findPayment = "select id from payment WHERE id = ". $payment_id;
$payment = createQuery($findPayment, $conn);

$numRows = mysql_num_rows($payment);
if ($numRows > 0) {
	//valid
	
	$getShirtsDB = "select c.price, s.quantity from collection_shirt c INNER JOIN account_shirt s ON c.id = s.collection_shirt_id WHERE payment_id = ". $payment_id;
	$getShirts = createQuery($getShirtsDB, $conn);
	
	$total = 0;
	while ($info = mysql_fetch_array($getShirts)) {
		$price = $info['price'];
		$quantity = $info['quantity'];
		
		$total += $price * $quantity;
	}
	//mail("$notify_email", "test5: quantity checked - ok", "$req", "From: $paypal_email" );
	
	if($_POST['mc_gross'] == $total){
		// update PRICE in PAYMENT table

		$time = time(); //+ (60*60*15);
		$time_now = date("Y-m-d H:i:s",$time);
		$pid_format = date("yMd",$time);
		$pid_format = strtoupper($pid_format);
		
		$update = "UPDATE payment SET date_paid = '$time_now', paypal_txn_id = '".$_POST['txn_id']."' WHERE id = '$payment_id'";
		createQuery($update, $conn);
		
		$get_name = "SELECT firstname, lastname, is_guest FROM account WHERE id = (SELECT account_id FROM payment WHERE id = '$payment_id')";
		$data = createQuery($get_name, $conn);
		
		$row = mysql_fetch_row($data);
		
		if($row[2] == "N"){
			if($row[0])
				$name = $row[0];
			if($row[1])
				$name .= ' '.$row[1];
		}else
			$name = 'Customer';
		
	}else{
		$message = "Possible price jacking. Contact paypal and user immediately. \n\n\n$req";
		mail("$notify_email", "Price not tally", $message, "From: $paypal_email" );
		exit(); // exit script
	}
	
}else{
	//invalid
	$message = "ID not found in database \n\n\n$req";
	mail("$notify_email", "Payment ID not found", $message, "From: $paypal_email" );
    exit(); // exit script
	
}


$datetime = explode(" ", $time_now);
$time = explode(":", $datetime[1]);
$date = explode("-", $datetime[0]);

$datetime = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
$time_now = date("M jS Y g:i A", $datetime);

$to = $_POST['payer_email'];
$subject = "Order receipt from RONZARO";

$message = '<div style="border:#AAA 1px solid; font-family:Helvetica, sans-serif; padding:10px; margin:5px; font-size:11px; width:500px">
			<div style="border-bottom:8px solid #AAA; margin:0px; padding-bottom:10px"><img src="http://images.ronzaro.netdna-cdn.com/logo.png" border="0" width="200" /></div>
			<p>
			Dear <strong>'.$name.'</strong>,
			<p>
			Thank you for your purchase. Your order will be processed immediatley upon PayPal approval.
			<p>
			Your order details:<br />
			Date <strong>'.$time_now.'</strong><br />
			Ronzaro Order Number <strong>R'.$pid_format.'PID'.$payment_id.'</strong><br />
			<p>
			Yours warmly,<br />
			Ronzaro
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
mail("support@ronzaro.com", "PAYMENT: ".$subject, $message, $headers);

// Mail yourself the details
//mail("$notify_email", "TRANSACTION ".$_POST['txn_id']." Completed Successfully", $req, "From: $paypal_email");

?>