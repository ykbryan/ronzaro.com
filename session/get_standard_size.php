<?php

include_once "../config/conn.php";

$fit_id = $_POST['id'];

$conn = sqlConnection();
selectDB($conn);

$get_default_db = "SELECT id, name, neck, arm_length, wrist, chest FROM default_measurement";
$get_default = createQuery($get_default_db, $conn);

if (!mysql_num_rows($get_default))
	$return['status'] = "NooOOOoooo";
else{
	$text = "";
	
	$fit_allowance_db = "SELECT cuff, chest FROM shirt_fit_allowance WHERE shirt_fit_id = '$fit_id'";
	$fit_allowance = createQuery($fit_allowance_db, $conn);
	$row = mysql_fetch_row($fit_allowance);
	$allowance_cuff = $row[0];
	$allowance_chest = $row[1];
	
	$checked = " checked";
	while ($info = mysql_fetch_array($get_default)) {
		$id = $info[0];
		$name = $info[1];
		$neck = $info[2];
		$arm_length = $info[3];
		$wrist = $info[4]+$allowance_cuff;
		$chest = $info[5]+$allowance_chest;
		
		$shirtlength = $info[10];
		
		$text .= '<tr bgcolor="#666" class="choosing_std" height="27" id="size_'.$id.'">
					<td valign="top"><input class="size_id" type="radio" name="size" value="'.$id.'"'.$checked.'/></td><td class="size_name">'.$name.'</td>
					<td valign="top" class="size_collar" alt="'.$neck.'"><div class="size_value" style="float:left">'.$neck.'</div><button class="edit_size" style="float:right"></button></td>
					<td valign="top" class="size_sleeve" alt="'.$arm_length.'"><div class="size_value" style="float:left">'.$arm_length.'</div><button class="edit_size" style="float:right"></button></td>
					<td valign="top" class="size_cuff" alt="'.$wrist.'"><div class="size_value" style="float:left">'.$wrist.'</div><button class="edit_size" style="float:right"></button></td>
					<td valign="top" class="size_chest" alt="'.$chest.'"><div class="size_value" style="float:left">'.$chest.'</div><button class="edit_size" style="float:right"></button></td>
				</tr>';
		$checked = "";
	}
	$return['text'] = $text;
	$return['status'] = "OK";
}

echo json_encode($return);

?>