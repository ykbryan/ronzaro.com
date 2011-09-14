<?php

if(!$_GET['action'])
	echo "<script>location.href = './' </script>";

require_once "config/conn.php";

//get account info
$getAccountDB = "select title, firstname, lastname, country, birthdate, email, occupation from account WHERE id = " . $_SESSION['id'];
$getAccount = createQuery($getAccountDB, $conn);

$row = mysql_fetch_row($getAccount);

$title = $row[0];
$firstname = $row[1];
$lastname = $row[2];
$country = $row[3];
$birthdate = $row[4];
$email = $row[5];
$occupation = $row[6];
?>

<style type="text/css">
#wrap{
	width:100%;
	min-height:450px;
	overflow:hidden;
	background-image:url(images/bkg_wood.jpeg);
	float:left;
	margin:1px 0px 1px 0px;
	text-align:center;
	display:none
}
#panel{
	width:750px;
	margin-left:auto; margin-right:auto;
	overflow:hidden
}
#account_panel, #profile_panel, #address_panel, #measurement_panel, #purchase_panel{
	width:740px;
	min-height:320px;
	padding:5px 20px 20px 20px;
	text-align:left;
	position:absolute
}
.title{color:#AAA}
.content{
	width:100%;
	padding:10px 10px 10px 10px;
	background-image:url(images/bg_box.png);
	margin-top:5px;
	padding-bottom:20px;
	min-height: 320px;
	overflow: auto;
}
button.back{margin-top:5px}
span.back{text-decoration:underline}
.back:hover, .address_book:hover, .box:hover, .measurement_list:hover, #logout:hover{cursor:pointer;color:#FFF}
.view_image{
	position:absolute;
	margin-left:200px;
	margin-top:-70px;
	display:none;
}
.payment_description:hover{cursor:pointer;color:#AAA}
.box{font-size:11px; border:1px solid #666; margin:20px; padding:20px}
td{padding:5px}
</style>
</head>

<body>

<script>
<?php
	echo '$(window).load(function() {
			$("div#progress_bar").css("width", "200px");
			$("div#loading-bar").fadeOut(1000, function(){
				$("div.top, div.bottom, div#wrap").fadeIn();
			});
		});';
?>
</script>
<header>
    <!-- Loading Div --> 
    <div id="loading-bar"> 
        <div style="width:500px; color:#AAA; font-size:12px; margin-left:auto; margin-right:auto">
            
            <br /><br />
            <div id="progress-bar-border" style="height:10px; width:204px; border:#888 solid 1px; margin-left:auto; margin-right:auto">
                <div id="progress_bar" style="background-color:#FFF; height:6px; margin-top:2px; margin-left:2px; width:0px; float:left">
                
                </div>
            </div>
        </div>
    </div>
    
    <?php include_once "includes/top.php" ?>
</header>
<h1 style="display:none">RONZARO Account</h1>
<div id="wrap">
    	<div id="panel">
        
            <div id="account_panel">
           		
                <span class="title">My account</span>
                <div id="logout" style="float:right"><a href="logout.php">[ Log out ]</a></div>
                <div class="content">
                    <table cellpadding="10" cellspacing="10" style="width:100%">
                        <tr><td id="profile" class="box">
                            <span style="color:#FF9900">My profile</span><br />
                            <p style="font-size:11px">Manage your account profile, settings and information such as email and password</p>
                        </td></tr>
                        
                        <tr><td id="address" class="box">
                            <span style="color:#FF9900">My address book</span><br />
                            <p style="font-size:11px">Manage your addresses in the address book</p>
                        </td></tr>
                        
                        <tr><td id="measurement" class="box">
                            <span style="color:#FF9900">My measurement database</span><br />
                            <p style="font-size:11px">Manage yours and your loved ones' measurements and update them accordingly</p>
                        </td></tr>
                        
                        <tr><td id="purchase" class="box">
                            <span style="color:#FF9900">My purchases</span><br />
                            <p style="font-size:11px">Track your recent purchases and view your past puchases</p>
                        </td></tr>
                    </table>
                </div>
            </div>
            
            <div id="profile_panel">
                <span class="title"><span class="back" id="profile">My account</span> :: My profile <img src="images/loadingbar.gif" class="ajax-load" style="display:none"></span>
                <div class="content">
                    <table style="border-spacing:10px; width:100%">
                        <tr><td style="font-size:11px; border:1px solid #666; padding:10px">
                            
                                	<table><tr><td style="vertical-align:text-top">
                                        <table>
                                        	<tr><td colspan="2">
                                            	<span style="color:#FF9900">Account information</span>
                                                <p>Complete or update the fields below</p>
                                            </td></tr>
                                            <tr>
                                                <td>Title </td>
                                                <td>
                                                    <div id="radio" style="padding-left:10px">
                                                        <input type="radio" name="account_title" id="title_1" value="mr." <?php if($title == "mr.") echo "checked"; ?>>
                                                        <label for="title_1">Mr.</label>
                                                        <input type="radio" name="account_title" id="title_2" value="ms." <?php if($title == "ms.") echo "checked"; ?>>
                                                        <label for="title_2">Ms.</label>
                                                        <input type="radio" name="account_title" id="title_3" value="mrs." <?php if($title == "mrs.") echo "checked"; ?>>
                                                        <label for="title_3">Mrs.</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        
                                        <table>
                                            <tr>
                                                <td>First name <br /><input type="text" value="<?php echo $firstname ?>" id="profile_firstname"></td>
                                                <td>Last name <br /><input type="text" size="25" value="<?php echo $lastname ?>" id="profile_lastname"></td>
                                            </tr>
                                            <tr>
                                                <td>Email <br /><input type="text" value="<?php echo $email ?>" id="profile_email"></td>
                                                <td>Confirm email <br /><input type="text" size="25" value="<?php echo $email ?>" id="profile_re_email"></td>
                                            </tr>
                                            <tr>
                                                <td>Occupation<br /><input type="text" value="<?php echo $occupation ?>" id="profile_occupation"></td>
                                                <td>Country <br /><select name="country" id="profile_country"><?php include "includes/list_countries_account.php"; ?></select></td>
                                            </tr>
                                        </table>
                                       
                                    </td><td style="padding-left:10px">
                                            Birthdate<div id="datepicker"></div>
                                    </td></tr></table>
                                    
                                    <script>
									$("select#profile_country option").each(function(){
										if($(this).attr("value") == "<?php echo $country ?>")
											$(this).attr("selected", true);
									});
									
									</script>
                            <div style="position:absolute; margin-left:600px; margin-top:-25px">
                                <button id="profile-account">Submit</button>
                            </div>
                        </td></tr>
                        <tr><td style="font-size:11px; border:1px solid #666; padding:10px">
                            <span style="color:#FF9900">Change password</span>
                            <p>
                                <div style="float:left">
                                    New password
                                    <br />
                                    <input type="password" id="profile-new-password">
                                </div>
                                <div style="float:left; padding-left:10px">
                                    Confirm password
                                    <br />
                                    <input type="password" id="profile-re-password">
                                </div>
                            </p>
                            <div style="position:absolute; margin-left:600px; margin-top:10px">
                                <button id="profile-password">Submit</button>
                            </div>
                        </td></tr>
                    </table>
                </div>
                <button class="back" id="profile">Back</button>
            </div>
            
            <div id="address_panel">
                <span class="title"><span class="back" id="address">My account</span> :: My address book <img src="images/loadingbar.gif" class="ajax-load" style="display:none"></span>
                <div class="content">
                    <p>Add, store and manage addresses here for shipping.</p><br />
                    <button id="add_address">Add address</button>
                    
                    <div id="addresses" style="width:100%; border-top:1px solid #999; margin-top:30px; overflow:auto; height:270px">
                    	<table style="border-spacing:10px; width:100%">
                    	<?php
						//get addresses	
						$getAddressesDB = "select id, name, address_line_1, address_line_2, city, state, zip, country, phone_number from shipping_address WHERE account_id = " . $_SESSION['id'];
						$getAddresses = createQuery($getAddressesDB, $conn);
						
						$count_addresses = 0;
						while ($info = mysql_fetch_array($getAddresses)) {
							$address_id = $info['id'];
							$name = $info['name'];
							$address_line_1 = $info['address_line_1'];
							$address_line_2 = $info['address_line_2'];
							$city = $info['city'];
							$state = $info['state'];
							$zip = $info['zip'];
							$country = $info['country'];
							$phone_number = $info['phone_number'];
							
							echo "<tr><td id=\"address_$address_id\" class=\"address_book\" style=\"font-size:11px; border:1px solid #666; padding:10px\" title=\"$address_id\">
										<span style=\"color:#FF9900\">$name</span><br /><div>";
							
							if($address_line_1)
								echo "$address_line_1, ";
							if($address_line_2)
								echo "$address_line_2, ";
							if($city)
								echo "$city, ";
							if($state)
								echo "$state, ";
							if($country)
								echo "$country ";
							if($zip)
								echo "$zip";
							if($phone_number)
								echo "<br />tel: $phone_number";

							echo "</div></td></tr>";
							$count_addresses++;
						}
						echo "</table>";
						
						if(!$count_addresses) echo "<p>You currently have no saved addresses in your address book.</p><p>to add a new address, please click the add an address button above.</p>";
						?>
                    </div>
                </div>
                <button class="back" id="address">Back</button>
            </div>
            
        	<div id="measurement_panel">
                <span class="title"><span class="back" id="measurement">My account</span> :: My measurement database <img src="images/loadingbar.gif" class="ajax-load" style="display:none"></span>
                <div class="content">
                    <p>Add, store and manage the measurements here for shirt buying.</p><br />
                    <button id="add_measurement">add measurement</button>
                    
                    <div id="measurements" style="width:100%; border-top:1px solid #999; margin-top:30px; overflow:auto; height:270px">
                    	<table style="border-spacing:10px; width:100%">
                    	<?php
						//get addresses	
						$getMeasurementDB = "select id, name, unit, neck, shoulder, arm_length, wrist, bicep, chest, waist, hips, shirt_length from account_measurement WHERE account_id = " . $_SESSION['id'];
						$getMeasurements = createQuery($getMeasurementDB, $conn);
						
						$count_measurements = 0;
						while ($info = mysql_fetch_array($getMeasurements)) {
							$measurement_id = $info['id'];
							$name = $info['name'];
							$unit = $info['unit'];
							$neck = $info['neck'];
							$shoulder = $info['shoulder'];
							$arm_length = $info['arm_length'];
							$wrist = $info['wrist'];
							$bicep = $info['bicep'];
							$chest = $info['chest'];
							$waist = $info['waist'];
							$hips = $info['hips'];
							$shirt_length = $info['shirt_length'];
							
							echo "<tr><td id=\"measurement_$measurement_id\" class=\"measurement_list\" style=\"font-size:11px; border:1px solid #666; padding:10px\" title=\"$measurement_id\" ref=\"$unit\">
										<span style=\"color:#FF9900\">$name</span><br /><div>";
							if($unit == "inches")
								$unit = "\"";
							if($neck)
								echo "neck $neck$unit, ";
							if($shoulder)
								echo "shoulder $shoulder$unit, ";
							if($arm_length)
								echo "arm length $arm_length$unit, ";
							if($wrist)
								echo "wrist $wrist$unit, ";
							if($bicep)
								echo "bicep $bicep$unit<br />";
							if($chest)
								echo "chest $chest$unit, ";
							if($waist)
								echo "waist $waist$unit, ";
							if($hips)
								echo "hips $hips$unit, ";
							if($shirt_length)
								echo "shirt length $shirt_length$unit";

							echo "</div></td></tr>";
							$count_measurements++;
						}
						echo "</table>";
						
						if(!$count_measurements) echo "<p>You currently have no saved measurements in your measurement database.</p><p>to add a new measurement, please click the add an measurement button above.</p>";
						?>
                    </div>
                    
                </div>
                <button class="back" id="measurement">Back</button>
            </div>
        
        	<div id="purchase_panel">
                <span class="title"><span class="back" id="purchase">My account</span> :: My purchases <img src="images/loadingbar.gif" class="ajax-load" style="display:none"></span>
                <div class="content">
                    <p>Recent orders will not appear here immediately</p>
                    
                    <div id="purchases" style="width:100%; overflow:auto; height:270px">
                        <table style="width:100%; margin-top:30px">
                            <tr>
                                <td style="border-bottom:1px solid #999; padding:5px"><strong>Order number</strong></td>
                                <td style="border-bottom:1px solid #999; padding:5px"><strong>Order description</strong></td>
                                <td style="border-bottom:1px solid #999; padding:5px"><strong>Order date</strong></td>
                                <td style="border-bottom:1px solid #999; padding:5px"><strong>Ship-to address</strong></td>
                                <td style="border-bottom:1px solid #999; padding:5px"><strong>Status</strong></td>
                            </tr>
                            
                            <?php
                            
                            $getPaymentDB = "select id, date_created, date_tailored, date_shipped, shipping_address_id from payment WHERE paypal_txn_id <> \"\" AND account_id = " . $_SESSION['id'];
                            $getPayments = createQuery($getPaymentDB, $conn);
                            
                            while ($info = mysql_fetch_array($getPayments)) {
                                $payment_id = $info['id'];
                                $date_created = $info['date_created'];
                                $date_tailored = $info['date_tailored'];
                                $date_shipped = $info['date_shipped'];
                                $shipping_address_id = $info['shipping_address_id'];
                                
                                    $datetime = explode(" ", $date_created);
                                    $time = explode(":", $datetime[1]);
                                    $date = explode("-", $datetime[0]);
                                    
                                    $datetime = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
                                    $date_created = date("M jS Y g:i A", $datetime);
									
									$pid_format = date("yMd",$datetime);
									$pid_format = strtoupper($pid_format);
                                
								$getDescriptionDB = "select c.id, c.post_title, a.quantity FROM account_shirt a INNER JOIN wp_posts c ON a.collection_shirt_id = c.id WHERE a.payment_id = $payment_id";
								$getDescription = createQuery($getDescriptionDB, $conn);
								$payment_description = "";
								while ($desc_data = mysql_fetch_array($getDescription)) {
									$getShirtDB = 'SELECT meta_key, meta_value FROM wp_postmeta WHERE post_id = '.$desc_data['id'];
									$getShirt = createQuery($getShirtDB, $conn);
									
									while ($desc = mysql_fetch_array($getShirt)) {
										if($desc['meta_key'] == 'main_image')
											$image = str_replace(".jpg", "-199x300.jpg", $desc['meta_value']);
										else if($desc['meta_key'] == 'Product Code')
											$product_code = $desc['meta_value'];
									}
									$payment_description .= "<span class=\"payment_description\">".$desc_data['post_title'] . "(" . $product_code . ") x ". $desc_data['quantity'] ."<br />";
									$payment_description .= "<img src=\"".$image."\" class=\"view_image\" width=\"100\"></span>";
								}
								
                                echo "<tr>
                                        <td style=\"vertical-align:text-top; padding:5px\">R".$pid_format."PID$payment_id</td>
										<td style=\"vertical-align:text-top; padding:5px\">$payment_description</td>
                                        <td style=\"vertical-align:text-top; padding:5px\">$date_created</td>";
										
								//get shipping address
								$getAddressDB = "select name, address_line_1, address_line_2, city, state, zip, country, phone_number from shipping_address WHERE id=$shipping_address_id";
								$getAddress = createQuery($getAddressDB, $conn);
								
								$row = mysql_fetch_row($getAddress);
								$full_address = $row[1];
								if($row[2])
									$full_address .= ", ".$row[2];
								$full_address .=", ".$row[3];
								$full_address .=", ".$row[4];
								$full_address .=", ".$row[5];
								$full_address .=", ".$row[6];
								$full_address .=", (phone number. ".$row[7].")";
								
                                echo "<td style=\"vertical-align:text-top; padding:5px\"><strong>$row[0]</strong>.$full_address</td>";
								
								if($date_tailored != "0000-00-00 00:00:00")
									$status = "tailoring...";
								else if($date_shipped != "0000-00-00 00:00:00")
									$status = "delivered";
								else
									$status = "making order...";
								
								echo "<td style=\"vertical-align:text-top; padding:5px\">$status</td>";
                                
                                echo "</tr>";
                            }
                            
                            ?>
                            
                        </table>
                    </div>
                </div>
                <button class="back" id="purchase">Back</button>
            </div>
        
        </div>
</div>

<div id="dialog-message" title="Success" style="display:none">
    <strong></strong>
    <p></p>
</div>
<div id="address_new" title="Add address" style="display:none">
     <table>
        <tr>
            <td>Receiver's name</td>
            <td><input type="text" id="address_new_name" size="25"></td>
        </tr>
        <tr>
            <td>Address line 1</td>
            <td><input type="text" id="address_new_line1" size="25"></td>
        </tr>
        <tr>
            <td>Address line 2</td>
            <td><input type="text" id="address_new_line2" size="25"></td>
        </tr>
        <tr>
            <td>City</td>
            <td><input type="text" id="address_new_city" size="25"></td>
        </tr>
        <tr>
            <td>State</td>
            <td><input type="text" id="address_new_state" size="25"></td>
        </tr>
        <tr>
            <td>Country</td>
            <td><select id="address_new_country"><?php include "includes/list_countries_account.php"; ?></select></td>
        </tr>
        <tr>
            <td>ZIP / postal code</td>
            <td><input type="text" id="address_new_zip" size="25"></td>
        </tr>
        <tr>
            <td>Phone number</td>
            <td><input type="text" id="address_new_phonenumber" size="25"></td>
        </tr>
    </table>
</div>
<div id="address_old" title="Update/delete address" style="display:none">
     <table>
        <tr>
            <td>Receiver's name</td>
            <td><input type="text" id="address_old_name" size="25"></td>
        </tr>
        <tr>
            <td>Address line 1</td>
            <td><input type="text" id="address_old_line1" size="25"></td>
        </tr>
        <tr>
            <td>Address line 2</td>
            <td><input type="text" id="address_old_line2" size="25"></td>
        </tr>
        <tr>
            <td>City</td>
            <td><input type="text" id="address_old_city" size="25"></td>
        </tr>
        <tr>
            <td>State</td>
            <td><input type="text" id="address_old_state" size="25"></td>
        </tr>
        <tr>
            <td>Country</td>
            <td><select id="address_old_country"><?php include "includes/list_countries_account.php"; ?></select></td>
        </tr>
        <tr>
            <td>ZIP / Postal code</td>
            <td><input type="text" id="address_old_zip" size="25"></td>
        </tr>
        <tr>
            <td>Phone number</td>
            <td><input type="text" id="address_old_phonenumber" size="25"></td>
        </tr>
    </table>
</div>
<div id="measurement_new" title="Add measurement" style="display:none">
    <table style="width:100%">
        <tr><td><img src="images/measurement/neck.jpg" id="measurement-img" /></td>
            <td style="vertical-align:text-top">
                
                <table>
                    <tr><td colspan="3">
                    Measurements best taken while wearing a dress shirt.
                    <p>
                    <center>
                    <div id="radio">
                    	<input type="radio" name="type" id="type_inch" class="type" value="inches" checked><label for="type_inch" class="type" id="inches">inches</label>
                    	<input type="radio" name="type" id="type_cm" class="type" value="cm"><label for="type_cm" class="type" id="cm">cm</label>
                    </div>
                    </center>
                    </p>
                    </td></tr>
                    <tr><td>Neck</td><td>
                    <input type="text" id="measurement_new_neck" alt="place measuring tape under adam's apple and hold tape with at least 2 fingers' spacing" title="images/measurement/neck.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" />
                    </td><td class="type" width="40">inches</td></tr>
                    <tr><td>Shoulder</td><td><input type="text" id="measurement_new_shoulder" alt="measure across shoulder by placing measuring tape at the 2 interception points between the arm and the tip of the shoulder" title="images/measurement/shoulder.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Bicep</td><td><input type="text" id="measurement_new_bicep" alt="from 6 inch down from the shoulder, measure the circumference of the bicep with 1 finger's spacing." title="images/measurement/bicep.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Arm length</td><td><input type="text" id="measurement_new_armlength" alt="place measuring tape where the shoulders end (where shoulders start) and measure to half the back of the hand" title="images/measurement/armlength.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Wrist</td><td><input type="text" id="measurement_new_wrist" alt="measure loosely (at least 1 finger spacing) the circumference of the hand where the sleeves end. for the watch wearing wrist, measure the largest circumference of the wrist, including the watch" title="images/measurement/wrist.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Chest</td><td><input type="text" id="measurement_new_chest" alt="measure loosely (at least 1 finger spacing) rounding up to the nearest whole number the circumference of the chest. ensure that tape at the back is horizontal and not drooping downwards" title="images/measurement/chest.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Waist</td><td><input type="text" id="measurement_new_waist" alt="measure loosely (at least 1 finger spacing) rounding up to the nearest whole number the circumference of the waist. ensure that tape at the back is horizontal and not drooping downwards" title="images/measurement/waist.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Hips</td><td><input type="text" id="measurement_new_hips" alt="measure loosely (at least 1 finger spacing) rounding up to the nearest whole number the circumference of the hips" title="images/measurement/hips.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Shirt length</td><td><input type="text" id="measurement_new_shirtlength" alt="measure the top (just under the collar) to the end of the crotch" title="images/measurement/shirtlength.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td colspan="3"><p>This belongs to<br />
                    <input type="text" id="measurement_new_name" title="images/measurement/neck.jpg" class="measurement text ui-widget-content ui-corner-all" size="25" placeholder="(optional)" />
                    </td></tr>
                </table>
                
            </td>
        </tr>
    </table>
    <img src="images/loadingbar.gif" class="ajax-load" style="display:none" alt="loading" />
    <div style="text-align:center"><i id="custom_desc" style="font-size:10px; color:#666"></i></div>
</div>
<div id="measurement_old" title="Update/delete measurement" style="display:none">
    <table style="width:100%">
        <tr><td><img src="images/measurement/neck.jpg" id="measurement-img" /></td>
            <td style="vertical-align:text-top">
                
                <table>
                    <tr><td colspan="3">
                    Measurements best taken while wearing a dress shirt.
                    <p style="text-align:center">
                    </p>
                    </td></tr>
                    <tr><td>Neck</td><td>
                    <input type="text" id="measurement_old_neck" alt="place measuring tape under adam's apple and hold tape with at least 2 fingers' spacing" title="images/measurement/neck.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" />
                    </td><td class="type" width="40">inches</td></tr>
                    <tr><td>Shoulder</td><td><input type="text" id="measurement_old_shoulder" alt="measure across shoulder by placing measuring tape at the 2 interception points between the arm and the tip of the shoulder" title="images/measurement/shoulder.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Bicep</td><td><input type="text" id="measurement_old_bicep" alt="from 6 inch down from the shoulder, measure the circumference of the bicep with 1 finger's spacing." title="images/measurement/bicep.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Arm length</td><td><input type="text" id="measurement_old_armlength" alt="place measuring tape where the shoulders end (where shoulders start) and measure to half the back of the hand" title="images/measurement/armlength.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Wrist</td><td><input type="text" id="measurement_old_wrist" alt="measure loosely (at least 1 finger spacing) the circumference of the hand where the sleeves end. for the watch wearing wrist, measure the largest circumference of the wrist, including the watch" title="images/measurement/wrist.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Chest</td><td><input type="text" id="measurement_old_chest" alt="measure loosely (at least 1 finger spacing) rounding up to the nearest whole number the circumference of the chest. ensure that tape at the back is horizontal and not drooping downwards" title="images/measurement/chest.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Waist</td><td><input type="text" id="measurement_old_waist" alt="measure loosely (at least 1 finger spacing) rounding up to the nearest whole number the circumference of the waist. ensure that tape at the back is horizontal and not drooping downwards" title="images/measurement/waist.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Hips</td><td><input type="text" id="measurement_old_hips" alt="measure loosely (at least 1 finger spacing) rounding up to the nearest whole number the circumference of the hips" title="images/measurement/hips.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Shirt length</td><td><input type="text" id="measurement_old_shirtlength" alt="measure the top (just under the collar) to the end of the crotch" title="images/measurement/shirtlength.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td colspan="3"><p>This belongs to<br />
                    <input type="text" id="measurement_old_name" title="images/measurement/neck.jpg" class="measurement text ui-widget-content ui-corner-all" size="25" placeholder="(optional)" />
                    </td></tr>
                </table>
            </td>
        </tr>
    </table>
    <img src="images/loadingbar.gif" class="ajax-load" style="display:none" alt="none" />
    <div style="text-align:center"><i id="custom_desc" style="font-size:10px; color:#666"></i></div>
</div>

<script>
var settings = {
	showArrows: true,
	autoReinitialise: true
};
var pane = $("#addresses, #measurements, #purchases");
pane.jScrollPane(settings);
var contentPane = pane.data('jsp').getContentPane();

//$("#addresses, #measurements, #purchases").jScrollPane();

var width_counter = 1;
$("img").each(function(index, element) {
	var width = ($("div#progress-bar-border").css("width").substr(0,3)-4)/$("img").length;
	
	$(this).load(function() {
		var calc_width = (width*width_counter) + "px";
		$("div#progress_bar").css("width", calc_width);
		
		width_counter++;
    });
});

$(function(){
	$("#radio").buttonset();
	$("button").button();
	$("td.box, td.address_book, td.measurement_list").live("mouseover mouseout", function(e){
	if(e.type == 'mouseover')
		$(this).css("border-color", "#FFF");
	else
		$(this).css("border-color", "#666");
});
	$("input, select").addClass("text ui-widget-content ui-corner-all");
	$("#profile_panel, #address_panel, #measurement_panel, #purchase_panel").hide();
	$("td.box").click(function(){
		$("div#account_panel").hide("slide", { direction: "left" }, "1000");
		$("div#"+$(this).attr("id")+"_panel").show("slide", { direction: "right" }, "1000");
	});
	$(".back").click(function(){
		$("div#account_panel").show("slide", { direction: "left" }, "1000");
		$("div#"+$(this).attr("id")+"_panel").hide("slide", { direction: "right" }, "1000");
	});
	$("div#datepicker").datepicker({
		inline: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '-80y:c',
		dateFormat: 'yy-mm-dd'
	});
	$("div#datepicker").datepicker("setDate" , "<?php echo $birthdate ?>");
	$("img.ajax-load").ajaxStart(function() {
        $(this).show();
		$("button").button("option", "disabled", true);
    });
	$("img.ajax-load").ajaxStop(function() {
        $(this).hide();
		$("button").button("option", "disabled", false);
    });
	$("input.measurement").focus(function() {
		$("img#measurement-img").attr("src", $(this).attr("title"));
		$("i#custom_desc").text($(this).attr("alt"));
	});
});

$("button#profile-password").live("click", function() {
	if($("input#profile-new-password").attr("value") != $("input#profile-re-password").attr("value")){
		alert("warning: the passwords do not match");
		return false;
	}
    $.ajax({
		type: 'POST',
		url: 'session/save_password.php',
		data: 'newpassword='+$("input#profile-new-password").attr("value"),
		dataType: 'json',
		success: function(data){
			if(data.status != "OK"){
				alert("oops! please try again later...");
			}else{
				$("div#dialog-message strong").text("Password updated");
				$("div#dialog-message p").text("Your password has been successfully updated. Please use the new password for your next login");
				$("div#account_panel").show("slide", { direction: "left" }, "1000");
				$("div#profile_panel").hide("slide", { direction: "right" }, "1000");
				$("div#dialog-message").dialog({
					hide: "explode",
					height: 160,
					width: 310,
					modal: true,
					buttons: {
						"ok": function() {
							$(this).dialog("destroy");
						}
					}
				});
			}
		},
		error: function(){
			alert("oops! please try again later...");
		}
	});
});
$("button#profile-account").live("click", function(){
	if($("input#profile_email").attr("value") != $("input#profile_re_email").attr("value")){
		alert("warning: the emails do not match");
		return false;
	}
	if($("input#title_3").attr("checked"))
		title = $("input#title_3").attr("value");
	else if($("input#title_2").attr("checked"))
		title = $("input#title_2").attr("value");
	else
		title = $("input#title_1").attr("value");
	
	$.ajax({
		type: 'POST',
		url: 'session/save_personal_information.php',
		data: 'firstname='+$("input#profile_firstname").attr("value")+'&lastname='+$("input#profile_lastname").attr("value")+'&email='+$("input#profile_email").attr("value")+'&title='+title+'&occupation='+$("input#profile_occupation").attr("value")+'&birthdate='+$('#datepicker').datepicker({ dateFormat: 'dd-mm-yy' }).val()+'&country='+$("select#profile_country option:selected").attr("value"),
		dataType: 'json',
		success: function(data){
			if(data.status != "OK"){
				alert("oops! please try again later...");
			}else{
				$("div#dialog-message strong").text("Profile updated");
				$("div#dialog-message p").text("Your profile has been successfully updated");
				$("div#account_panel").show("slide", { direction: "left" }, "1000");
				$("div#profile_panel").hide("slide", { direction: "right" }, "1000");
				$("div#dialog-message").dialog({
					hide: "explode",
					height: 160,
					width: 310,
					modal: true,
					buttons: {
						"ok": function() {
							$(this).dialog("destroy").hide();
						}
					}
				});
			}
		},
		error: function(){
			alert("oops! please try again later...");
		}
	});
});
$("button#add_address").live("click", function(){
	$("input#address_new_name, input#address_new_line1, input#address_new_line2, input#address_new_city, input#address_new_state, input#address_new_zip, input#address_new_phonenumber").attr("value", "").css("border", "1px solid #555");
	$("div#address_new").dialog({
		hide: "explode",
		height: 350,
		width: 350,
		modal: true,
		buttons: {
			"add": function() {
				var name = $("input#address_new_name").attr("value");
				var address1 = $("input#address_new_line1").attr("value");
				var address2 = $("input#address_new_line2").attr("value");
				var city = $("input#address_new_city").attr("value");
				var state = $("input#address_new_state").attr("value");
				var zip = $("input#address_new_zip").attr("value");	
				var country = $("select#address_new_country option:selected").attr("value");
				var number = $("input#address_new_phonenumber").attr("value");
				
				if((!address1)||(!city)||(!state)||(!zip)||(!number)){
					alert("please enter the shipping information");
					
					if(!number) $("input#address_new_phonenumber").css("border", "1px solid #FFB73D").focus();
					else $("input#address_new_phonenumber").css("border", "1px solid #555");
					if(!zip) $("input#address_new_zip").css("border", "1px solid #FFB73D").focus();
					else $("input#address_new_zip").css("border", "1px solid #555");
					if(!state) $("input#address_new_state").css("border", "1px solid #FFB73D").focus();
					else $("input#address_new_state").css("border", "1px solid #555");
					if(!city) $("input#address_new_city").css("border", "1px solid #FFB73D").focus();
					else $("input#address_new_city").css("border", "1px solid #555");
					if(!address1) $("input#address_new_line1").css("border", "1px solid #FFB73D").focus();
					else $("input#address_new_line1").css("border", "1px solid #555");
					
					return false;
				}
				
				if(!name)
					name = "untitled";
				
				saved_dialog = $(this);
				
				$.ajax({
					type: 'POST',
					url: 'session/create_address.php',
					data: 'name='+name+'&address_line_1='+address1+'&address_line_2='+address2+'&city='+city+'&state='+state+'&zip='+zip+'&address_country='+country+'&address_phone_number='+number,
					dataType: 'json',
					success: function(data){
						if(data.status != "OK"){
							alert("oops! please try again later...");
						}else{
							new_td = "<tr><td id=\"address_"+data.id+"\" class=\"address_book\" style=\"font-size:11px; border:1px solid #666\" title=\""+data.id+"\">";
							new_td += "<span style=\"color:#FF9900\">"+name+"</span><br /><div>";
							if(address1)
								new_td += address1 + ", ";
							if(address2)
								new_td += address2 + ", ";
							if(city)
								new_td += city + ", ";
							if(city)
								new_td += state + ", ";
							if(city)
								new_td += country + ", ";
							if(city)
								new_td += zip + "<br />";
							if(city)
								new_td += "tel: " + number;
							new_td += "</div></td></tr>";
							
							$("div#dialog-message strong").text("New address added");
							$("div#dialog-message p").text("The new address has been successfully saved");
							$("div#dialog-message").dialog({
								hide: "explode",
								height: 160,
								width: 310,
								modal: true,
								buttons: {
									"ok": function() {
										$("div#addresses table").fadeOut(function(){
											$(this).prepend(new_td).fadeIn();
										});
										$("div#address_new").dialog("destroy");
										$(this).dialog("destroy");
									}
								}
							});
						}
					},
					error: function(){
						alert("oops! please try again later...");
					}
				});
			}
		}
	});
});
$("td.address_book").live("click", function(){
	
	address_id = $(this).attr("title");
	$.ajax({
		type: 'POST',
		url: 'session/get_address.php',
		data: 'id='+address_id,
		dataType: 'json',
		success: function(data){
			if(data.status != "OK"){
				alert("oops! please try again later...");
			}else{
				$("input#address_old_name").attr("value", data.name);
				$("input#address_old_line1").attr("value", data.address_line_1);
				$("input#address_old_line2").attr("value", data.address_line_2);
				$("input#address_old_city").attr("value", data.city);
				$("input#address_old_state").attr("value", data.state);
				$("input#address_old_zip").attr("value", data.zip);
				$("select#address_old_country option").each(function(){
					if($(this).attr("value") == data.country)
						$(this).attr("selected", true);
				});
				$("input#address_old_phonenumber").attr("value", data.phone_number);
			}
		},
		error: function(){
			alert("oops! please try again later...");
		}
	});
	
	$("div#address_old").dialog({
		hide: "explode",
		height: 350,
		width: 350,
		modal: true,
		buttons: {
			"update": function() {
				var name = $("input#address_old_name").attr("value");
				var address1 = $("input#address_old_line1").attr("value");
				var address2 = $("input#address_old_line2").attr("value");
				var city = $("input#address_old_city").attr("value");
				var state = $("input#address_old_state").attr("value");
				var zip = $("input#address_old_zip").attr("value");	
				var country = $("select#address_old_country option:selected").attr("value");
				var number = $("input#address_old_phonenumber").attr("value");
				
				if((!address1)||(!city)||(!state)||(!zip)||(!number)){
					alert("please enter the shipping information");
					
					if(!number) $("input#address_old_phonenumber").css("border", "1px solid #FFB73D").focus();
					if(!zip) $("input#address_old_state").css("border", "1px solid #FFB73D").focus();
					if(!state) $("input#address_old_state").css("border", "1px solid #FFB73D").focus();
					if(!city) $("input#address_old_city").css("border", "1px solid #FFB73D").focus();
					if(!address1) $("input#address_old_line1").css("border", "1px solid #FFB73D").focus();
					
					return false;
				}
				
				if(!name)
					name = "untitled";
				
				$.ajax({
					type: 'POST',
					url: 'session/edit_address.php',
					data: 'name='+name+'&address_line_1='+address1+'&address_line_2='+address2+'&city='+city+'&state='+state+'&zip='+zip+'&address_country='+country+'&address_phone_number='+number+'&id='+address_id,
					dataType: 'json',
					success: function(data){
						if(data.status != "OK"){
							alert("oops! please try again later...");
						}else{
							$("div#dialog-message strong").text("Address updated");
							$("div#dialog-message p").text("The address has been successfully updated");
							$("div#dialog-message").dialog({
								hide: "explode",
								height: 160,
								width: 310,
								modal: true,
								buttons: {
									"ok": function() {
										$("td#address_"+address_id).fadeOut("fast").fadeIn("fast");
										$("td#address_"+address_id+" span").text(name);
										address_string = "";
										if(address1)
											address_string += address1 + ", ";
										if(address2)
											address_string += address2 + ", ";
										if(city)
											address_string += city + ", ";
										if(city)
											address_string += state + ", ";
										if(city)
											address_string += country + ", ";
										if(city)
											address_string += zip + "<br />";
										if(city)
											address_string += "tel: " + number;
											
										$("td#address_"+address_id+" div").html(address_string);
											
										$("div#address_old").dialog("destroy");
										$(this).dialog("destroy");
									}
								}
							});
						}
					},
					error: function(){
						alert("oops! please try again later...");
					}
				});
			}, "delete": function(){
				result = confirm("I want to delete this address permanently");
				
				if(result){
					$.ajax({
						type: 'POST',
						url: 'session/delete_address.php',
						data: 'id='+address_id,
						dataType: 'json',
						success: function(data){
							if(data.status != "OK"){
								alert("oops! please try again later...");
							}else{
								$("div#dialog-message strong").text("Address deleted");
								$("div#dialog-message p").text("The address has been successfully deleted");
								$("div#dialog-message").dialog({
									hide: "explode",
									height: 160,
									width: 310,
									modal: true,
									buttons: {
										"ok": function() {
											$("div#address_old").dialog("destroy");
											$("td#address_"+address_id).fadeOut();
											$(this).dialog("destroy");
										}
									}
								});
							}
						},
						error: function(){
							alert("oops! please try again later...");
						}
					});
				}else
					$(this).dialog("destroy");
			}
		}
	});
});
$("button#add_measurement").live("click", function(){
		$("input#measurement_new_name, input#measurement_new_neck, input#measurement_new_shoulder, input#measurement_new_bicep, input#measurement_new_armlength, input#measurement_new_wrist, input#measurement_new_chest, input#measurement_new_waist, input#measurement_new_hips, input#measurement_new_shirtlength").attr("value", "").css("border", "1px solid #555");

	$("div#measurement_new").dialog({
		height: 550,
		width: 550,
		modal: true,
		buttons: {
			"add": function() {
				var name = $("input#measurement_new_name").attr("value");
				var neck = $("input#measurement_new_neck").attr("value");
				var shoulder = $("input#measurement_new_shoulder").attr("value");
				var bicep = $("input#measurement_new_bicep").attr("value");
				var armlength = $("input#measurement_new_armlength").attr("value");
				var wrist = $("input#measurement_new_wrist").attr("value");
				var chest = $("input#measurement_new_chest").attr("value");
				var waist = $("input#measurement_new_waist").attr("value");
				var hips = $("input#measurement_new_hips").attr("value");
				var shirtlength = $("input#measurement_new_shirtlength").attr("value");
				
				if((!neck)||(!shoulder)||(!bicep)||(!armlength)||(!wrist)||(!chest)||(!waist)||(!hips)||(!shirtlength)){
					alert("Please enter all the body measurements");
					
					if(!shirtlength) $("input#measurement_new_shirtlength").css("border", "1px solid #FFB73D").focus();
					else $("input#measurement_new_shirtlength").css("border", "1px solid #555");
					if(!hips) $("input#measurement_new_hips").css("border", "1px solid #FFB73D").focus();
					else $("input#measurement_new_hips").css("border", "1px solid #555");
					if(!waist) $("input#measurement_new_waist").css("border", "1px solid #FFB73D").focus();
					else $("input#measurement_new_waist").css("border", "1px solid #555");
					if(!chest) $("input#measurement_new_chest").css("border", "1px solid #FFB73D").focus();
					else $("input#measurement_new_chest").css("border", "1px solid #555");
					if(!wrist) $("input#measurement_new_wrist").css("border", "1px solid #FFB73D").focus();
					else $("input#measurement_new_wrist").css("border", "1px solid #555");
					if(!armlength) $("input#measurement_new_armlength").css("border", "1px solid #FFB73D").focus();
					else $("input#measurement_new_armlength").css("border", "1px solid #555");
					if(!bicep) $("input#measurement_new_bicep").css("border", "1px solid #FFB73D").focus();
					else $("input#measurement_new_bicep").css("border", "1px solid #555");
					if(!shoulder) $("input#measurement_new_shoulder").css("border", "1px solid #FFB73D").focus();
					else $("input#measurement_new_shoulder").css("border", "1px solid #555");
					if(!neck) $("input#measurement_new_neck").css("border", "1px solid #FFB73D").focus();
					else $("input#measurement_new_neck").css("border", "1px solid #555");
					
					return false;
				}
				
				if(!name)
					name = "untitled";
				
				$.ajax({
					type: 'POST',
					url: 'session/create_measurement.php',
					data: 'name='+name+'&neck='+neck+'&shoulder='+shoulder+'&bicep='+bicep+'&armlength='+armlength+'&wrist='+wrist+'&chest='+chest+'&waist='+waist+'&hips='+hips+'&shirtlength='+shirtlength+'&unit='+$("input.type:checked").val(),
					dataType: 'json',
					success: function(data){
						if(data.status != "OK"){
							alert("Oops! please try again later...");
						}else{
							new_td = "<tr><td id=\"measurement_"+data.id+"\" class=\"measurement_list\" style=\"font-size:11px; border:1px solid #666\" title=\""+data.id+"\">";
							new_td += "<span style=\"color:#FF9900\">"+name+"</span><br /><div>";
							
							if($("input.type:checked").val() == "inches")
								measurement_unit = "\"";
							else
								measurement_unit = $("input.type:checked").val();
								
							if(neck)
								new_td += "neck "+neck+""+measurement_unit+", ";
							if(shoulder)
								new_td += "shoulder "+shoulder+""+measurement_unit+", ";
							if(armlength)
								new_td += "arm length "+armlength+""+measurement_unit+", ";
							if(wrist)
								new_td += "wrist "+wrist+""+measurement_unit+", ";
							if(bicep)
								new_td += "bicep "+bicep+""+measurement_unit+"<br /> ";
							if(chest)
								new_td += "chest "+chest+""+measurement_unit+", ";
							if(waist)
								new_td += "waist "+waist+""+measurement_unit+", ";
							if(hips)
								new_td += "hips "+hips+""+measurement_unit+", ";
							if(shirtlength)
								new_td += "shirt length "+shirtlength+""+measurement_unit;
							
							$("div#dialog-message strong").text("New measurement added");
							$("div#dialog-message p").text("The new measurement has been successfully saved");
							$("div#dialog-message").dialog({
								hide: "explode",
								height: 160,
								width: 310,
								modal: true,
								buttons: {
									"ok": function() {
										$("div#measurements table").fadeOut(function(){
											$(this).prepend(new_td).fadeIn();
										});
										$("div#measurements p").text("");
										$("div#measurement_new").dialog("destroy");
										$(this).dialog("destroy");
									}
								}
							});
						}
					},
					error: function(){
						alert("oops! please try again later...");
					}
				});
			}
		}
	});
});
$("td.measurement_list").live("click", function(){
	
	measurement_id = $(this).attr("title");
	$("td.type").html($(this).attr("ref"));
	
	$.ajax({
		type: 'POST',
		url: 'session/get_measurement.php',
		data: 'id='+measurement_id,
		dataType: 'json',
		success: function(data){
			if(data.status != "OK"){
				alert("Oops! please try again later...");
			}else{
				$("input#measurement_old_name").attr("value", data.name);
				$("input#measurement_old_neck").attr("value", data.neck);
				$("input#measurement_old_shoulder").attr("value", data.shoulder);
				$("input#measurement_old_bicep").attr("value", data.bicep);
				$("input#measurement_old_armlength").attr("value", data.armlength);
				$("input#measurement_old_wrist").attr("value", data.wrist);
				$("input#measurement_old_chest").attr("value", data.chest);
				$("input#measurement_old_waist").attr("value", data.waist);
				$("input#measurement_old_hips").attr("value", data.hips);
				$("input#measurement_old_shirtlength").attr("value", data.shirtlength);
			}
		},
		error: function(){
			alert("Oops! please try again later...");
		}
	});
	
	$("div#measurement_old").dialog({
		hide: "explode",
		height: 550,
		width: 550,
		modal: true,
		buttons: {
			"update": function() {
				var name = $("input#measurement_old_name").attr("value");
				var neck = $("input#measurement_old_neck").attr("value");
				var shoulder = $("input#measurement_old_shoulder").attr("value");
				var bicep = $("input#measurement_old_bicep").attr("value");
				var armlength = $("input#measurement_old_armlength").attr("value");
				var wrist = $("input#measurement_old_wrist").attr("value");
				var chest = $("input#measurement_old_chest").attr("value");
				var waist = $("input#measurement_old_waist").attr("value");
				var hips = $("input#measurement_old_hips").attr("value");
				var shirtlength = $("input#measurement_old_shirtlength").attr("value");
				
				if((!neck)||(!shoulder)||(!bicep)||(!armlength)||(!wrist)||(!chest)||(!waist)||(!hips)||(!shirtlength)){
					alert("please enter all the body measurements");
					
					if(!shirtlength) $("input#measurement_old_shirtlength").css("border", "1px solid #FFB73D").focus();
					if(!hips) $("input#measurement_old_hips").css("border", "1px solid #FFB73D").focus();
					if(!waist) $("input#measurement_old_waist").css("border", "1px solid #FFB73D").focus();
					if(!chest) $("input#measurement_old_chest").css("border", "1px solid #FFB73D").focus();
					if(!wrist) $("input#measurement_old_wrist").css("border", "1px solid #FFB73D").focus();
					if(!armlength) $("input#measurement_old_armlength").css("border", "1px solid #FFB73D").focus();
					if(!bicep) $("input#measurement_old_bicep").css("border", "1px solid #FFB73D").focus();
					if(!shoulder) $("input#measurement_old_shoulder").css("border", "1px solid #FFB73D").focus();
					if(!neck) $("input#measurement_old_neck").css("border", "1px solid #FFB73D").focus();
					
					return false;
				}
				
				if(!name)
					name = "untitled";
				
				$.ajax({
					type: 'POST',
					url: 'session/edit_measurement.php',
					data: 'id='+measurement_id+'&name='+name+'&neck='+neck+'&shoulder='+shoulder+'&bicep='+bicep+'&armlength='+armlength+'&wrist='+wrist+'&chest='+chest+'&waist='+waist+'&hips='+hips+'&shirtlength='+shirtlength,
					dataType: 'json',
					success: function(data){
						if(data.status != "OK"){
							alert("Oops! please try again later...");
						}else{
							$("div#dialog-message strong").text("Measurement updated");
							$("div#dialog-message p").text("The measurement has been successfully updated");
							$("div#dialog-message").dialog({
								hide: "explode",
								height: 160,
								width: 310,
								modal: true,
								buttons: {
									"ok": function() {
										$("td#measurement_"+measurement_id).fadeOut("fast").fadeIn("fast");
										$("td#measurement_"+measurement_id+" span").text(name);
										measurement_string = "";
										if(neck)
											measurement_string += "neck "+neck+"\", ";
										if(shoulder)
											measurement_string += "shoulder "+shoulder+"\", ";
										if(armlength)
											measurement_string += "arm length "+armlength+"\", ";
										if(wrist)
											measurement_string += "wrist "+wrist+"\", ";
										if(bicep)
											measurement_string += "bicep "+bicep+"\"<br />";
										if(chest)
											measurement_string += "chest "+chest+"\", ";
										if(waist)
											measurement_string += "waist "+waist+"\", ";
										if(hips)
											measurement_string += "hips "+hips+"\", ";
										if(shirtlength)
											measurement_string += "shirt length "+shirtlength+"\"";
											
										$("td#measurement_"+measurement_id+" div").html(measurement_string);
											
										$("div#measurement_old").dialog("destroy");
										$(this).dialog("destroy");
									}
								}
							});
						}
					},
					error: function(){
						alert("Oops! please try again later...");
					}
				});
			}, "delete": function(){
				result = confirm("I want to delete this measurement permanently");
				
				if(result){
					$.ajax({
						type: 'POST',
						url: 'session/delete_measurement.php',
						data: 'id='+measurement_id,
						dataType: 'json',
						success: function(data){
							if(data.status != "OK"){
								alert("Oops! please try again later...");
							}else{
								$("div#dialog-message strong").text("Measurement deleted");
								$("div#dialog-message p").text("The measurement has been successfully deleted");
								$("div#dialog-message").dialog({
									hide: "explode",
									height: 160,
									width: 310,
									modal: true,
									buttons: {
										"ok": function() {
											$("div#measurement_old").dialog("destroy");
											$("td#measurement_"+measurement_id).fadeOut();
											$(this).dialog("destroy");
										}
									}
								});
							}
						},
						error: function(){
							alert("Oops! please try again later...");
						}
					});
				}else
					$(this).dialog("destroy");
			}
		}
	});
});

$( "div#radio, div#radio2" ).buttonset();
$("label.type, label.type2").click(function(){
	$("td.type").html($(this).attr("id"));
});

$("span.payment_description").hover(function(){
	$(this).find("img.view_image").show();
}, function(){
	$(this).find("img.view_image").hide();
});

$("title").html("RONZARO - My account");
</script>