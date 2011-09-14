<?php
include_once "../../config/conn.php";

$conn = sqlConnection();
selectDB($conn);

$html = '<table style="width:100%"><tr style="text-decoration:underline"><td>Staff ID</td><td>Username</td><td>Date Created</td><td>Last Login</td></tr>';
$admins = "SELECT id, username, date_created, date_login FROM `admin`";
$data = createQuery($admins, $conn);
while ($info = mysql_fetch_array($data)) {
	$html .= '<tr>';
	$html .=  '<td>'.$info['id'].'</td>';
	$html .=  '<td>'.$info['username'].'</td>';
	
	$datetime = explode(" ",  $info['date_created']);
	$time = explode(":", $datetime[1]);
	$date = explode("-", $datetime[0]);
	$datetime = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);

	$html .= '<td>'.date("jS F  Y H:i:s", $datetime).'</td>';
	
	if( $info['date_login'] == '0000-00-00 00:00:00'){
		$html .= "<td>Never log in</td>";
	}else{
		$datetime = explode(" ",  $info['date_login']);
		$time = explode(":", $datetime[1]);
		$date = explode("-", $datetime[0]);
		$datetime = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
		$html .= '<td>'.date("jS F  Y H:i:s", $datetime).'</td>';
	}
	$html .= '</tr>';
}
$html .= '</table>';

$return['html'] = $html;
echo json_encode($return);

?>