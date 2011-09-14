<?php
session_start();
include_once "../../config/conn.php";

$conn = sqlConnection();
selectDB($conn);

$html = '<table style="width:100%"><tr style="text-decoration:underline"><td>Payment ID</td><td>Date of Purchase</td><td>Reason</td></tr>';
$payments = "SELECT id, account_id, promotion_code_id, paypal_txn_id, shipping_address_id, gift_id, date_created, date_paid, date_tailored, date_shipped FROM `payment` WHERE date_created != '0000-00-00 00:00:00' AND date_paid != '0000-00-00 00:00:00'";
$data = createQuery($payments, $conn);
if (!mysql_num_rows($data))
	$return['html'] = "Hurray! No record is bugged...";
else{
	while ($info = mysql_fetch_array($data)) {
		$reason = "";
		if(($info['date_created'] == '0000-00-00 00:00:00')&&($info['date_paid'] != '0000-00-00 00:00:00'))
			$reason .= 'Missing date (date and time created cannot be empty)';
		else if(($info['shipping_address_id'] ==0)&&($info['date_paid'] != '0000-00-00 00:00:00')){
			if($reason) $reason .= '<br />';
			$reason .= 'Failure to capture the shipping address';
		}else if((!$info['paypal_txn_id'])&&($info['date_paid']=='0000-00-00 00:00:00')){
			if($reason) $reason .= '<br />';
			$reason .= 'Failure to capture the paypal transaction date and time<br />Paypal Transaction ID '.$info['paypal_txn_id'].'<br />'.$info['date_paid'];
		}else if(!$info['paypal_txn_id']&&($info['date_paid']!='0000-00-00 00:00:00')){
			if($reason) $reason .= '<br />';
			$reason .= 'Failure to capture the paypal transaction id<br />Paypal Transaction ID '.$info['paypal_txn_id'].'<br />'.$info['date_paid'];
		}
		
		if($reason){
			$html .= '<tr><td>';
			$html .=  $info['id'].'</td><td>';
			
			$datetime = explode(" ",  $info['date_paid']);
			$time = explode(":", $datetime[1]);
			$date = explode("-", $datetime[0]);
			$datetime = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
		
			$html .= date("jS F  Y H:i:s", $datetime).'</td><td>';
			
			
			$html .= $reason;
			$html .= '</td></tr>';
		}
	}
}
$html .= '</table>';

$return['html'] = $html;
echo json_encode($return);

?>