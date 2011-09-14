<?php
session_start();

include_once "../config/conn.php";
	
$conn = sqlConnection();
selectDB($conn);

require_once "../class/shirt.php";

$time = time(); //+ (60*60*15);
$time_now = date("Y-m-d H:i:s",$time);

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
		
	}else{
		$id = mysql_fetch_row($num);
		
		$account_id = $id[0];
		
	}
}

//add shipping address
	
$promotion_id = $_POST['promotion_id'];
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

/*
include_once "../class/address.php";

$address = new address();
$address->set_parameters($shipping_id, $shiping_name, $email, $address1, $address2, $city, $state, $zip, $country, $number);

$_SESSION['address'] = serialize($address);
*/

if(($shipping_id == 0)||($shipping_id == "")){
	$add_shipping = "INSERT INTO shipping_address ( `account_id`, `name`, `address_line_1`, `address_line_2`, `city`, `state`, `zip`, `country`, `phone_number`, `date_created`, `date_modified`) values ('$account_id', '$shiping_name', '$address1', '$address2', '$city', '$state', '$zip', '$country', '$number', '$time_now', '$time_now')";
	createQuery($add_shipping, $conn);
	
	$shipping_id = mysql_insert_id();
}

//add payment
$add_payment = "INSERT INTO payment ( `account_id`, `shipping_address_id`, `promotion_code_id`, `date_created`) values ('$account_id', '$shipping_id', '$promotion_id', '$time_now')";
createQuery($add_payment, $conn);

$payment_id = mysql_insert_id();
$_SESSION['payment_id'] = $payment_id;

$total_price;

foreach($_SESSION['cart'] as $key=>$value){
	
	$shirt = new shirt();
	$shirt = unserialize($value);
	
	if(!empty($shirt->monogram_text)){
		$add_monogram = "INSERT INTO shirt_monogram ( `colour`, `placement`, `text`, `date_created`) values ('$shirt->monogram_color','$shirt->monogram_placement', '$shirt->monogram_text', '$time_now')";
		createQuery($add_monogram, $conn);
		$monogram_id = mysql_insert_id();
	}else
		$monogram_id = 0;
	
	if($shirt->is_existing == "Y"){
		$measurement_id = $shirt->existing_id;
		
		$add_shirt = "INSERT INTO account_shirt ( `account_id`, `account_measurement_id`, `collection_shirt_id`, `collar_id`, `cuff_id`, `pocket_id`, `back_id`, `bottom_id`, `fit_id`, `monogram_id`, `quantity`, `payment_id`, `date_created`, `date_modified`) values ('$account_id','$measurement_id','$shirt->collection_shirt_id', '$shirt->collar_id', '$shirt->cuff_id', '$shirt->pocket_id', '$shirt->back_id','$shirt->bottom_id','$shirt->fit_id','$monogram_id','$shirt->quantity', '$payment_id', '$time_now', '$time_now')";
		
	}else if($shirt->is_standard == "Y"){
		$size_measurement_id = $shirt->size_id;
		
		$add_shirt = "INSERT INTO account_shirt ( `account_id`, `is_custom`, `size_measurement_id`, `collection_shirt_id`, `collar_id`, `cuff_id`, `pocket_id`, `back_id`, `bottom_id`, `fit_id`, `monogram_id`, `quantity`, `payment_id`, `date_created`, `date_modified`) values ('$account_id', 'N', '$size_measurement_id','$shirt->collection_shirt_id', '$shirt->collar_id', '$shirt->cuff_id', '$shirt->pocket_id', '$shirt->back_id','$shirt->bottom_id','$shirt->fit_id','$monogram_id','$shirt->quantity', '$payment_id', '$time_now', '$time_now')";
		
	}else{
		$add_measurement = "INSERT INTO account_measurement ( `account_id`, `name`, `neck`, `shoulder`, `arm_length`, `wrist`, `arm_hole`, `bicep`, `chest`, `waist`, `hips`, `waist_point`, `shirt_length`, `date_created`, `date_modified`) values ('$account_id','$shirt->name', '$shirt->neck', '$shirt->shoulder', '$shirt->armlength', '$shirt->wrist', '$shirt->armhole', '$shirt->bicep', '$shirt->chest', '$shirt->waist', '$shirt->hips', '$shirt->waistpoint', '$shirt->shirtlength', '$time_now', '$time_now')";
		createQuery($add_measurement, $conn);
		
		$new_measurement_id = mysql_insert_id();
		
		$add_shirt = "INSERT INTO account_shirt ( `account_id`, `account_measurement_id`, `collection_shirt_id`, `collar_id`, `cuff_id`, `pocket_id`, `back_id`, `bottom_id`, `fit_id`, `monogram_id`, `quantity`, `payment_id`, `date_created`, `date_modified`) values ('$account_id','$new_measurement_id','$shirt->collection_shirt_id', '$shirt->collar_id', '$shirt->cuff_id', '$shirt->pocket_id', '$shirt->back_id','$shirt->bottom_id','$shirt->fit_id','$monogram_id','$shirt->quantity', '$payment_id', '$time_now', '$time_now')";
		
		
	}
	createQuery($add_shirt, $conn);

}

$return['payment'] = $payment_id;
$return['status'] = "OK";

echo json_encode($return);

?>