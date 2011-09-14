<?php
session_start();
include_once "../../config/conn.php";

$conn = sqlConnection();
selectDB($conn);

$search_query = $_POST['search_query'];
$count = 1;
$html = '<strong>Search Results</strong><br><table style="width:100%">';

$account_search = "SELECT a.id, a.firstname, a.lastname, a.email, a.phonenumber, a.is_guest FROM account a";
$data = createQuery($account_search, $conn);

while ($info = mysql_fetch_array($data)) {
	$search = 0;
	if($search_query == $info[1]){
		$firstname = '<strong style="color:#FF0">'.$info[1].'</strong>';
		$search++;
	}else $firstname = $info[1];
	
	
	if($search_query == $info[2]){
		$lastname = '<strong style="color:#FF0">'.$info[2].'</strong>';
		$search++;
	}else $lastname = $info[2];
	
	
	if($search_query == $info['email']){
		$email = '<strong style="color:#FF0">'.$info[3].'</strong>';
		$search++;
	}else $email = $info[3];
	
	
	if($search_query == $info[4]){
		$phonenumber = '<strong style="color:#FF0">'.$info[4].'</strong>';
		$search++;
	}else $phonenumber = $info[4];
	
	if($info[5] == "Y")
		$type_of_account = '- Guest account (ID '.$info[0].')';
	else
		$type_of_account = '- Member account (ID '.$info[0].')';
	
	if(!$firstname && !$lastname)
		$firstname = 'N.A.';
	
	if($search > 0){
		$html .=  '<tr><td>'.$count.'</td><td>'.$firstname.' '.$lastname.' '.$type_of_account.'<br />Email: '.$email.'<br />Phone Number: '.$phonenumber.'</td></tr>';
		$count++;
	}
}

if(substr($search_query, 0, 3) == "PID"){

	$payment_id_search = "SELECT id, date_created, date_paid, date_tailored, date_shipped FROM payment WHERE id = ".substr($search_query, 3);
	$data = createQuery($payment_id_search, $conn);
	
	while ($info = mysql_fetch_array($data)) {
		if($info['date_created'] == '0000-00-00 00:00:00')
			$status = 'Error';
		else if($info['date_paid'] == '0000-00-00 00:00:00')
			$status = 'Not paid';
		else if($info['date_tailored'] == '0000-00-00 00:00:00')
			$status = 'Not yet tailored';
		else if($info['date_shipped'] == '0000-00-00 00:00:00')
			$status = 'Not yet shipped';
		
		$html .=  '<tr><td>'.$count.'</td><td><strong style="color:#FF0">PID '.$info['id'].'</strong><br />Status: '.$status.'</td></tr>';
			
		$count++;
	}
}

$html .= '</table>';

$return['html'] = $html;
echo json_encode($return);

?>