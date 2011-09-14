<?php
session_start();

require_once "../config/conn.php";
require_once "../class/shirt.php";
require_once "../class/promotion.php";
	
$conn = sqlConnection();
selectDB($conn);

$time = time(); //+ (60*60*15);
$time_now = date("Y-m-d H:i:s",$time);
$pid_format = date("yMd",$time);
$pid_format = strtoupper($pid_format);

$email = $_POST['email'];

if($_SESSION['login']){
	$account_id = $_SESSION['id'];
}else{
	//to check if the user has purchased with us before
	$verify = "SELECT id FROM account WHERE email = '$email' AND is_guest = 'Y' LIMIT 1";
	$num = createQuery($verify, $conn);
	
	if (!mysql_num_rows($num)){
		$add_account = "INSERT INTO account ( `email`, `is_guest`, `date_created`) values ('$email', 'Y', '$time_now')";
		createQuery($add_account, $conn);
		
		$account_id = mysql_insert_id();
		
		$to = $email;
		$subject = "Welcome to RONZARO";
		$message = '<div style="border:#AAA 1px solid; font-family:Helvetica, sans-serif; padding:10px; margin:5px; font-size:11px; width:500px">
					<div style="border-bottom:8px solid #AAA; margin:0px; padding-bottom:10px"><img src="http://images.ronzaro.netdna-cdn.com/logo.png" border="0" width="200" /></div>
					<p>
					Dear <strong>Customer</strong>,
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
		mail("support@ronzaro.com", "GUEST ACCOUNT (".$to."): ".$subject, $message, $headers);
		
	}
}

//add shipping address
$shipping_id = $_POST['id'];
$shiping_name = $_POST['name'];
$email = $_POST['email'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$country = $_POST['country'];
$number = $_POST['number'];

if($shipping_id==0){
	$add_shipping = "INSERT INTO shipping_address ( `account_id`, `name`, `address_line_1`, `address_line_2`, `city`, `state`, `zip`, `country`, `phone_number`, `date_created`, `date_modified`) values ('$account_id', '$shiping_name', '$address1', '$address2', '$city', '$state', '$zip', '$country', '$number', '$time_now', '$time_now')";
	createQuery($add_shipping, $conn);
	$shipping_id = mysql_insert_id();
}else{
	$update_shipping = "UPDATE shipping_address SET account_id='$account_id', name='$shiping_name', address_line_1='$address1', address_line_2='$address2', city='$city', state='$state', zip='$zip', country='$country', phone_number='$number', date_modified='$time_now' WHERE id = '$shipping_id'";
	createQuery($update_shipping, $conn);
}

//add promotion
if($_SESSION['promotion']){
	$promotion = new promotion();
	$promotion = unserialize($_SESSION['promotion']);
	$promotion_id = $promotion->id;
}

//add gift message
$gift_message = $_POST['gift_message'];

if($gift_message){
	$gift_from = $_POST['gift_from'];
	$add_gift = "INSERT INTO gift ( `from`, `message`, `date_created`) values ('$gift_from', '$gift_message', '$time_now')";
	createQuery($add_gift, $conn);
	
	$gift_id = mysql_insert_id();
}else
	$gift_id = 0;

//add payment
$add_payment = "INSERT INTO payment ( `account_id`, `promotion_code_id`, `shipping_address_id`, `gift_id`, `date_created`) values ('$account_id', '$promotion_id', '$shipping_id', '$gift_id', '$time_now')";
createQuery($add_payment, $conn);

$payment_id = mysql_insert_id();

//add every shirt
foreach($_SESSION['cart'] as $key=>$value){
	
	$shirt = new shirt();
	$shirt = unserialize($value);
	
	if($_SESSION['promotion'])
		$shirt->quantity = 1;
	
	//add monogram
	if(($shirt->monogram_text != 'undefined')&&($shirt->monogram_placement) != 'No monogram'){
		$add_monogram = "INSERT INTO shirt_monogram ( `colour`, `placement`, `text`, `date_created`) values ('$shirt->monogram_color','$shirt->monogram_placement', '$shirt->monogram_text', '$time_now')";
		createQuery($add_monogram, $conn);
		$monogram_id = mysql_insert_id();
	}else
		$monogram_id = 0;
	
	//get default body measurement
	if($shirt->size_id){
		$size_measurement_id = $shirt->size_id;
		
		$get_size = "SELECT shoulder, bicep, waist, hips, shirt_length FROM default_measurement WHERE id = '$size_measurement_id'";
		$data = createQuery($get_size, $conn);

		$row = mysql_fetch_row($data);
		
		$shirt->shoulder = $row[0];
		$shirt->bicep = $row[1];
		$shirt->waist = $row[2]; 
		$shirt->hips = $row[3];
		$shirt->shirtlength = $row[4];
		
		if($shirt->unit == "cm"){
			$shirt->shoulder = round($shirt->shoulder * 2.54);
			$shirt->bicep = round($shirt->bicep * 2.54);
			$shirt->waist = round($shirt->waist * 2.54);
			$shirt->hips = round($shirt->hips * 2.54);
			$shirt->shirtlength = round($shirt->shirtlength * 2.54);
		}
	}
	
	//add body measurement
	$add_measurement = "INSERT INTO account_measurement ( `name`, `neck`, `shoulder`, `arm_length`, `wrist`, `bicep`, `chest`, `waist`, `hips`, `shirt_length`, `unit`, `date_created`, `date_modified`) values ('$shirt->name', '$shirt->neck', '$shirt->shoulder', '$shirt->armlength', '$shirt->wrist', '$shirt->bicep', '$shirt->chest', '$shirt->waist', '$shirt->hips', '$shirt->shirtlength', '$shirt->unit', '$time_now', '$time_now')";
	createQuery($add_measurement, $conn);
	
	//standard size
	$new_measurement_id = mysql_insert_id();
	
	//add shirt
	$add_shirt = "INSERT INTO account_shirt ( `account_id`, `account_measurement_id`, `is_standard`, `collection_shirt_id`, `collar_id`, `cuff_id`, `pocket_id`, `back_id`, `bottom_id`, `fit_id`, `monogram_id`, `quantity`, `payment_id`, `date_created`, `date_modified`) values ('$account_id', '$new_measurement_id', '$shirt->is_standard', '$shirt->collection_shirt_id', '$shirt->collar_id', '$shirt->cuff_id', '$shirt->pocket_id', '$shirt->back_id','$shirt->bottom_id','$shirt->fit_id','$monogram_id','$shirt->quantity', '$payment_id', '$time_now', '$time_now')";
	createQuery($add_shirt, $conn);

}

//update promotion
if($_SESSION['promotion']){
	$update = "UPDATE promotion_code SET is_used = 'Y' WHERE id = '$promotion_id'";
	createQuery($update, $conn);
	
	$get_name = "SELECT firstname FROM account WHERE id = (SELECT account_id FROM payment WHERE id = '$payment_id')";
	$data = createQuery($get_name, $conn);
	
	$row = mysql_fetch_row($data);
	
	$name = $row[0];
	
	$to = $email;
	$subject = "Order receipt from RONZARO";
	
	$message = '<div style="border:#AAA 1px solid; font-family:Helvetica, sans-serif; padding:10px; margin:5px; font-size:11px; width:500px">
				<div style="border-bottom:8px solid #AAA; margin:0px; padding-bottom:10px"><img src="http://www.ronzaro.com/images/logo.png" border="0" width="200" /></div>
				<p>
				Dear <strong>Customer</strong>,
				<p>
				Thank you for your purchase. Your order will be processed immediatley.
				<p>
				Your order details:<br />
				Date <strong>'.$time_now.'</strong><br>
				Ronzaro Order Number <strong>R'.$pid_format.'PID'.$payment_id.'</strong><br>
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
	
}

$return['payment'] = $payment_id;
$return['status'] = "OK";

echo json_encode($return);

?>