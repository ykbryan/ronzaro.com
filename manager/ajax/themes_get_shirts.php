<?php
session_start();
include_once "../../config/conn.php";

$conn = sqlConnection();
selectDB($conn);

$id = $_POST['id'];

$get_shirts_db = "SELECT id, name, description FROM `collection_shirt` WHERE collection_theme_id = $id";
$get_shirts = createQuery($get_shirts_db, $conn);
if (!mysql_num_rows($get_shirts))
	$return['html'] = "No shirts...";
else{
	$html .= '<table style="width:100%">';
	while ($info = mysql_fetch_array($get_shirts)) {
		$html .= '<tr><td style="border-bottom:1px solid #CCC"><br /><strong>'.$info['description'].' ('.$info['name'].')</strong>';
		
		$get_descriptions_db = 'SELECT id, name, description FROM `collecton_description` WHERE collection_shirt_id = '.$info['id'].'';
		$get_descriptions = createQuery($get_descriptions_db, $conn);
		$prev_name = '';
		while ($desc = mysql_fetch_array($get_descriptions)) {
			if($prev_name != $desc['name']){
				$prev_name = $desc['name'];
				$html .= '<br />'.$prev_name;
			}
			$html .= '<br />'.$desc['description'];	
		}
		
		$html .= '<br /></td></tr>';
	}
	$html .= '</table>';
	$return['html'] = $html;
}
echo json_encode($return);
?>