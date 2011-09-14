<?php

include_once "../config/conn.php";

$id = $_POST['id'];

$conn = sqlConnection();
selectDB($conn);

$get_sizes = "SELECT id, name, collar, shoulder,back_length,sleeve_length,sleeve_width,cuff_depth,cuff_width,chest,waist,shirt_length FROM size_measurement WHERE size_company_id = $id";
$data = createQuery($get_sizes, $conn);

if (!mysql_num_rows($data))
	$return['status'] = "NooOOOoooo";
else{
	$text = "";
	while ($info = mysql_fetch_array($data)) {
		$size_id = $info[0];
		$size_name = $info[1];
		$size_collar = $info[2];
		$size_shoulder = $info[3];
		$size_back_length = $info[4];
		$size_sleeve_length = $info[5];
		$size_sleeve_width = $info[6];
		$size_cuff_depth = $info[7];
		$size_cuff_width = $info[8];
		$size_chest = $info[9];
		$size_waist = $info[10];
		$size_shirt_length = $info[11];
		
		$text .= '<tr bgcolor="#666" class="choosing_std"><td><input type="radio" name="std_size" value="'.$size_id.'" /></td><td>'.$size_name.'</td><td class="size_collar">'.$size_collar.'</td><td class="size_shoulder">'.$size_shoulder.'</td><td class="size_back_length">'.$size_back_length.'</td><td class="size_sleeve_length">'.$size_sleeve_length.'</td><td class="size_sleeve_width">'.$size_sleeve_width.'</td><td class="size_cuff_depth">'.$size_cuff_depth.'</td><td class="size_cuff_width">'.$size_cuff_width.'</td><td class="size_chest">'.$size_chest.'</td><td class="size_waist">'.$size_waist.'</td><td class="size_shirt_length">'.$size_shirt_length.'</td></tr>';
	}
	$return['text'] = $text;
	$return['status'] = "OK";
}

echo json_encode($return);

?>