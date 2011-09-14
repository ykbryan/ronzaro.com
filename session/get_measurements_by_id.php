<?php
session_start();

include_once "../config/conn.php";

$conn = sqlConnection();
selectDB($conn);

$get_measurements = "SELECT id, name FROM account_measurement WHERE account_id =" . $_SESSION['id'];
$data = createQuery($get_measurements, $conn);

if (!mysql_num_rows($data))
	$return['status'] = "NooOOOoooo";
else{

	$text = "";
	while ($info = mysql_fetch_array($data)) {
		$m_id = $info[0];
		$m_name = $info[1];
		
		$text .= "<option id=\"$m_id\">$m_name</option>";
	}
	$return['text'] = $text;
	$return['status'] = "OK";
}

echo json_encode($return);

?>