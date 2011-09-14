<?php
session_start();

if(!empty($_SESSION['id'])){
	
	include_once "../config/conn.php";
	
	$conn = sqlConnection();
	selectDB($conn);

	$get_measurements = "SELECT id, name FROM account_measurement WHERE account_id = '" . $_SESSION['id'] ."'";
	$data = createQuery($get_measurements, $conn);
	
	if (!mysql_num_rows($data))
		$return['status'] = "none";
	else{
	
		$text = "";
		$count = 0;
		while ($info = mysql_fetch_array($data)) {
			$count ++;
			$m_id = $info[0];
			$m_name = $info[1];
			
			$text .= "<option id=\"$m_id\">$m_name</option>";
		}
		
		if($count > 0)
			$return['available'] = "OK";
		else
			$return['available'] = "no";
		$return['option'] = $text;
		
		$return['status'] = "OK";
	}
}else
	$return['status'] = "NooOOOoooo";
	
echo json_encode($return);

?>