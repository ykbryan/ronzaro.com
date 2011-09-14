<?php

if(!$_GET['action'])
	echo "<script>location.href = './' </script>";
	
require_once "class/shirt.php";
require_once "class/promotion.php";
require_once "config/conn.php";

?>

<style>
#wrap{
	width:100%;
	min-height:400px;
	overflow:hidden;
	background-image:url(images/bkg_wood.jpeg);
	float:left;
	text-align:center;
	margin:1px 0px 1px 0px
}
.floating{position:absolute;margin-left:0px}
.cart_summary{width:250px;color:#FFF;padding:0px 20px 20px 20px}
.cart_summary div{
	width:100%;
	padding:10px 10px 10px 10px;
	background-image:url(images/bg_box.png);
	margin-top:5px;
}
.cart, .personal{
	width:600px;
	float:left;
	color:#FFF;
	padding:0px 20px 20px 20px;
}
.cart .content, .personal div{
	float:left;
	width:100%;
	padding:10px 10px 10px 10px;
	margin-top:5px;
	background-image:url(images/bg_box.png);
}
.title_box{font-size:11px;color:#BBB}
a#gift{color:#999;font-size:10px;padding-left:20px}
a#gift:hover{color:#FFF;cursor:pointer}
img.design{padding-left:20px}
span#empty_this{
	color:#666;
	float:right;
	font-size:10px;
}
span#empty_this:hover{color:#FFF;cursor:pointer}
.ui-button{width:125px;height:20px}
.ui-button-text-only .ui-button-text{padding:0px 0px;font-size:11px}
.ui-selectmenu-status, li{font-size:10px;padding:0px 10px}
.ui-selectmenu{width:10px;height:15px}
.ui-selectmenu-menu-popup{width:250px}
.proceed2:hover, .proceed1:hover{cursor:pointer;color:#fff}
td.proceed2{
	background:url(images/process2.png) no-repeat left center; 
	width:90px; 
	height:40px; 
	padding-left:50px;
}
td.proceed2:hover{
	background:url(images/process2-selected.png) no-repeat left center;
	cursor:pointer;
	color:#fff;
}
td.proceed1{
	background:url(images/process1.png) no-repeat left center; 
	width:90px; 
	height:40px; 
	padding-left:50px;
}
td.proceed1:hover{
	background:url(images/process1-selected.png) no-repeat left center;
	cursor:pointer;
	color:#fff;
}
.remove:hover{cursor: pointer}
ul{margin-left:35px;margin-bottom:10px}
</style>
</head>
<body>
<script>
<?php
	echo '$(window).load(function() {
				$("div#progress_bar").css("width", "200px");
				$("div.bottom, div.top").show();
				$("div#loading-bar").delay(800).fadeOut(2000, function(){
					$("div#sub-bg").fadeOut();
				});
				var padding_top = parseInt($("div.top").css("padding-top"));
				var float_top = parseInt("115");
				var input_top = padding_top + float_top;
				$("div.floating").css("top", input_top+"px");
				var menuYloc = parseInt($("div.floating").css("top").substring(0,$("div.floating").css("top").indexOf("px")));
				
				$(window).scroll(function(){
					var checkYloc = parseInt($(document).scrollTop());
					var offset = checkYloc+0+"px";
					if(checkYloc<menuYloc)
						offset = menuYloc+"px";
					
					if(checkYloc<(parseInt($("div#wrap").css("height")) - parseInt($("div.floating").css("height"))+115)){
						$("div.floating").animate({top:offset},{duration:500,queue:false});
					}
				});
		});';
?>
</script>

<header>
    <!-- Loading Div --> 
    <div id="sub-bg" style="background-color:#000; position:fixed; width:100%; height:100%; z-index:999"></div>
    <div id="loading-bar"> 
        <div style="width:600px; color:#AAA; font-size:14px; margin-left:auto; margin-right:auto">
            "He who trims himself to suit everyone will soon whittle himself away."  - Raymond Hull
            <br /><br />
            <div id="progress-bar-border" style="height:10px; width:204px; border:#888 solid 1px; margin-left:auto; margin-right:auto">
                <div id="progress_bar" style="background-color:#FFF; height:6px; margin-top:2px; margin-left:2px; width:0px; float:left">
                
                </div>
            </div>
        </div>
    </div>
    
    <?php include_once "includes/top.php" ?>
</header>

<h1 style="display:none">RONZARO Shopping cart</h1>
<div id="wrap">
	<div style="width:950px; overflow:hidden; text-align:left; margin-left:auto; margin-right:auto">
    <table style="margin-top:10px; margin-left:20px; width:60^"><tr>
    	<td class="proceed1">Design</td>
        <td class="proceed2">Size</td>
        <td class="proceed3" style="background:url(images/process3-selected.png) no-repeat left center; width:90px; height:40px; padding-left:50px; color:#FFF">Checkout</td>
        <td></td>
    </tr></table>
    <table style="width:100%">
    	<tr>
        	<td style="width:642px">
            
             <div class="cart" style="padding-top:10px">
                <span class="title_box">Items in your cart</span>
                <div class="content" style="float:left; ">
                    <div style="width:100%; margin:10px 0px 10px 0px" id="cart_content">
                        <?php
                        
                        //count number of items
                        $count = 0;
                        if($_SESSION['cart']){
                        
							foreach($_SESSION['cart'] as $key=>$value){
								
								$shirt = new shirt();
								$shirt = unserialize($value);
								
								$getShirtDB = "SELECT post_title FROM wp_posts WHERE id = ".$shirt->collection_shirt_id;
								$getShirt = createQuery($getShirtDB, $conn);
								$row = mysql_fetch_row($getShirt);
								$description = $row[0];
								
								$getShirtDB = "select meta_key, meta_value from wp_postmeta WHERE post_id = ".$shirt->collection_shirt_id;
								$getShirt = createQuery($getShirtDB, $conn);
								while ($desc = mysql_fetch_array($getShirt)) {
									if($desc['meta_key'] == 'main_image')
										$main_image = $desc['meta_value'];
									else if($desc['meta_key'] == 'Price')
										$price = $desc['meta_value'];
									else if($desc['meta_key'] == 'Product Code')
										$product_code = $desc['meta_value'];
								}
								
								
								echo "<div class=\"shirt_$key shirt_div\" style=\"width:600px; border-top:#333 1px solid; height:250px\">";
								echo "<div style=\"float:left; width:120px;\" align=\"center\">
										<img src=\"$main_image\" width=\"100\" style=\"padding-top:10px; \">
										<span style=\"font-size:10px; color:#666\"><br />x <a class=\"remove\" id=\"$key\">Remove this shirt</a></span>
									</div>";
								
								echo "<div style=\"float:right; width:470px;\">
										<div style=\"padding:10px 10px 10px 10px; margin-left:10px; border-bottom:#333 1px solid\">
											<strong>$description ($product_code)</strong>
											<span style=\"float:right\">USD $price per piece</span>
										</div>";
											
								
								echo "<table style=\"width:100%; float:left; padding-top:10px\">
											<tr><td>
											<strong style=\"font-size:10px; padding-left:20px;\">Design style summary</strong><p>";
								
								$collarDB = "select image, name from shirt_collar WHERE id = " . $shirt->collar_id;
								$collar = createQuery($collarDB, $conn);
								$collar_image = mysql_fetch_row($collar);
								
								echo "<img src=\"$collar_image[0]\" class=\"design\" title=\"$collar_image[1]\" height=\"45\">";
								
								if($shirt->cuff_id != 0){
									$cuffDB = "select image, name from shirt_cuff WHERE id = " . $shirt->cuff_id;
									$cuff = createQuery($cuffDB, $conn);
									$cuff_image = mysql_fetch_row($cuff);
									
									echo "<img src=\"$cuff_image[0]\" class=\"design\" title=\"$cuff_image[1]\" height=\"45\" style=\"padding-left:10px\">";
								}
								
								$pocketDB = "select image, name from shirt_pocket WHERE id = " . $shirt->pocket_id;
								$pocket = createQuery($pocketDB, $conn);
								$pocket_image = mysql_fetch_row($pocket);
								
								echo "<img src=\"$pocket_image[0]\" class=\"design\" title=\"$pocket_image[1]\" height=\"45\" style=\"padding-left:10px\">";
								
								$backDB = "select image, name from shirt_back WHERE id = " . $shirt->back_id;
								$back = createQuery($backDB, $conn);
								$back_image = mysql_fetch_row($back);
								
								echo "<img src=\"$back_image[0]\" class=\"design\" title=\"$back_image[1]\" height=\"45\" style=\"padding-left:10px\">";
								
								$bottomDB = "select image, name from shirt_bottom WHERE id = " . $shirt->bottom_id;
								$bottom = createQuery($bottomDB, $conn);
								$bottom_image = mysql_fetch_row($bottom);
								
								echo "<img src=\"$bottom_image[0]\" class=\"design\" title=\"$bottom_image[1]\" height=\"45\" style=\"padding-left:10px\">";
								
								$fitDB = "select image, name from shirt_fit WHERE id = " . $shirt->fit_id;
								$fit = createQuery($fitDB, $conn);
								$fit_image = mysql_fetch_row($fit);
								echo "<img src=\"$fit_image[0]\" class=\"design\" title=\"$fit_image[1]\" height=\"45\">";
								
								echo "<ul style=\"list-style: square; font-size:10px; width:250px \">
										<li>Monogram: ";
								if(($shirt->monogram_text == "undefined")||($shirt->monogram_placement == "none"))
									echo "none";
								else
									echo "$shirt->monogram_color, $shirt->monogram_placement, \"$shirt->monogram_text\"";	
										
								echo "</li>
									</ul>";
								
								echo "</td></tr><tr><td>";
								
								if($shirt->is_standard == "Y"){
									//get allowance
									$fit_allowance_db = "SELECT cuff, chest FROM shirt_fit_allowance WHERE shirt_fit_id = '$shirt->fit_id'";
									$fit_allowance = createQuery($fit_allowance_db, $conn);
									$row = mysql_fetch_row($fit_allowance);
									$allowance_cuff = $row[0];
									$allowance_chest = $row[1];
									
									$shirt_wrist = $shirt->wrist + $allowance_cuff;
									$shirt_chest = $shirt->chest + $allowance_chest;
									//standard measurement
									echo "<div style=\"width:100%; float:left\">
											<div style=\"padding:0px 0px 5px 20px \"><strong style=\"font-size:10px\">Standard size selected: $shirt->size_name</strong></div>
												<ul style=\"list-style: square; font-size:10px; float:left; width:250px \">
													<li> Collar $shirt->neck $shirt->unit</li>
													<li> Sleeve length $shirt->armlength $shirt->unit</li>
													<li> Cuff $shirt_wrist $shirt->unit</li>
													<li> Chest $shirt_chest $shirt->unit</li>";
											echo "</ul>
										</div>"; 
								}else{
								
									//body measurement
									echo "
											<strong style=\"font-size:10px; padding-left:20px\">Customized measurement";
									if($shirt->name)
									echo " for <u>$shirt->name</u>";
									
									echo "</strong>
											<table><tr><td valign=\"top\">
												<ul style=\"list-style: square; font-size:10px; float:left; width:120px \">
													<li>Neck: $shirt->neck $shirt->unit</li>
													<li>Shoulder: $shirt->shoulder $shirt->unit</li>
													<li>Bicep: $shirt->bicep $shirt->unit</li>
													<li>Arm length: $shirt->armlength $shirt->unit</li>
													<li>Wrist: $shirt->wrist $shirt->unit</li>
													
												</ul>
												</td><td valign=\"top\">
												<ul style=\"list-style: square; font-size:10px; float:left; width:120px \">
													<li>Chest: $shirt->chest $shirt->unit</li>
													<li>Waist: $shirt->waist $shirt->unit</li>
													<li>Hips: $shirt->hips $shirt->unit</li>
													<li>Shirt length: $shirt->shirtlength $shirt->unit</li>
												</ul>
											</td></tr></table>";
								}
								
								echo "</td></tr></table>";
								
								
								$limit = 5;
								echo "<div style=\"position:absolute; margin-left:350px; margin-top:10px;\">quantity 
										<select class=\"quantity\" id=\"quantity_$key\" title=\"$key\" name=\"$price\">";
								$max = 1;
								while($limit >= $max){
									echo "<option id=\"$max\" value=\"$max\">$max</option>";
									$max++;
								}
											
								echo "</select><br /><img id=\"loading\" class=\"loading_$key\" src=\"images/loadingbar.gif\" style=\"float:right\" border=0>";
								
								$selected_quantity = $shirt->quantity;
								
								echo "<script type=\"application/javascript\">$(\"select#quantity_$key\").find(\"option#$selected_quantity\").attr(\"selected\", true);</script>";
								
								
								echo"</div>";
								//end of quantity check
								
								echo "</div>";
								
								echo "</div>";
								
								$count++;
							}
						
						}
                        
                        if($count == 0)
                            echo "<p align=\"center\">There is no item in your cart yet</p>";
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="personal" style="font-size:10px">
                <span class="title_box">Add gift message</span>
                <div style="float:left; margin-top:5px;">
                    <a id="gift">Yes, this is a gift and i want to add a message</a>
                    <table id="gift" style="display:none; font-size:10px; float:left">
                        <tr><td width="105">Your name</td><td><input type="text" id="gift-from-name" class="gift-box text ui-widget-content ui-corner-all" /></td></tr>
                        <tr id="message"><td>Your message</td><td><input type="text" id="gift-message" class="gift-box text ui-widget-content ui-corner-all" size="42" /></td></tr>
                    </table>
                	<a id="no-gift" style="float:right; display:none">No, this is not a gift</a>
                </div>
            </div>
            
            <div class="personal">
                <span class="title_box">Shipping address</span>
                <div style="float:left">
                    <?php
                    
                    include_once "class/address.php";
                    
                    if($_SESSION['address']){
                        $address = new address();
                        $address = unserialize($_SESSION['address']);
                    }
                    ?>
                    <table id="shipping_address" style="font-size:10px; float:left">
                    
                    <?php
					if($_SESSION['login']){
					?>
                        <tr><td>
                        Profile
                        </td><td>
                        <select id="shipping_address">
                            <option value="0" selected="selected">New address</option>
                            <?php
                            
                            if(!empty($_SESSION['id'])){
                                $addressesDB = "select id, name, address_line_1, address_line_2, city, state, zip, country, phone_number, date_modified from shipping_address WHERE account_id = " . $_SESSION['id'];
                                $addresses = createQuery($addressesDB, $conn);
                                
                                while ($info = mysql_fetch_array($addresses)) {
									$address_id = $info['id'];
									$address_name = $info['name'];
									$address_line_1 = $info['address_line_1'];
									$address_line_2 = $info['address_line_2'];
									$city = $info['city'];
									$state = $info['state'];
									$zip = $info['zip'];
									$country = $info['country'];
									$phone_number = $info['phone_number'];
									$date_modified = $info['date_modified'];
									$posted_date = stripslashes($date_modified);
									$datetime = explode(" ", $posted_date);
									$time = explode(":", $datetime[1]);
									$date = explode("-", $datetime[0]);
									
									$datetime = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
									$date_modified = date("M jS Y g:i A", $datetime);
									 
                                    echo "<option value=\"$address_id\"> $address_name - $address_line_1 $address_line_2 | $city $state, $country $zip (last updated on $date_modified)</option>";
                                }
                            }
                            
                            ?>
                        </select>
                        </td></tr>
                        <?php
						}
						if(!$_SESSION['login']){
							echo "<tr><td>your email <span style=\"font-size:10px; color:#666\">*</span></td><td>
									<input type=\"text\" id=\"shipping_email\" name=\"shipping_email\"";
							if($_SESSION['address']) echo 'value="'.$address->email.'"';
							
							echo " size=\"40\" class=\"text ui-widget-content ui-corner-all\" /></td></tr>";
						}
						?>
                        <tr><td>Receiver's name <span style="font-size:10px; color:#666">*</span></td><td>
                        <input type="text" id="address_name" name="first_name" <?php if($_SESSION['address']) echo 'value="'.$address->name.'"';?> 
                        class="text ui-widget-content ui-corner-all" size="40" placeholder="preferred name" /></td></tr>
                        <tr><td>Address line 1 <span style="font-size:10px; color:#666">*</span></td><td>
                        <input id="address1" name="address1" type="text" size="45" placeholder="street address, P.O. box, company name" class="text ui-widget-content ui-corner-all" />
                        </td></tr>
                        <tr><td>Address line 2</td><td>
                        <input id="address2" name="address2" type="text" size="45" placeholder="apartment, suite, unit, building, floor" class="text ui-widget-content ui-corner-all" />
                        </td></tr>
                        <tr><td>State <span style="font-size:10px; color:#666">*</span></td><td>
                        <input id="state" name="state" type="text" size="30" placeholder="state / province / region" class="text ui-widget-content ui-corner-all" />
                        </td></tr>
                        <tr><td>City <span style="font-size:10px; color:#666">*</span></td><td>
                        <input id="city" name="city" type="text" size="20" class="text ui-widget-content ui-corner-all" />
                        </td></tr>
                        <tr><td>ZIP <span style="font-size:10px; color:#666">*</span></td><td>
                        <input id="zip" name="zip" type="text" size="10" class="text ui-widget-content ui-corner-all" />
                        </td></tr>
                        <tr><td>Country <span style="font-size:10px; color:#666">*</span></td><td><?php include_once "includes/list_countries.php"; ?></td></tr>
                        <tr><td>Phone number <span style="font-size:10px; color:#666">*</span></td><td>
                        <input id="number" name="night_ phone_b" type="text" class="text ui-widget-content ui-corner-all" placeholder="+ (country code) - (area code) - (number)" size="45" /><br />
                         <span style="font-size:9px; color:#999"></span>
                        </td></tr>
                    </table>
                    <span style="float:right; font-size:9px; color:#666">* required fields</span>
                </div>
            </div>
            </td>
            <td>
            	<div class="floating">
                	<table><tr><td>
                    <div class="cart_summary">
                        <span class="title_box">Cart summary</span>
                        
                        <?php include_once "includes/paypal_variables.php"; ?>
                        
                        <form id="paypal" action="<?php echo $paypal_url; ?>" method="post">
                        
                        <input type="hidden" name="no_shipping" value="1" />
                        <input type="hidden" name="cmd" value="_cart">
                        <input type="hidden" name="upload" value="1">
                        <input type="hidden" name="business" value="<?php echo $paypal_email; ?>">
                        <input type="hidden" id="payment" name="custom" value="">
                        
                        <div style="float:left">
                            <strong>USD <span id="amount"></span></strong>
                            <span id="empty_this">empty</span>
                            <ul style="border-top:1px #999 dashed; list-style: square; font-size:10px; padding-top:10px; margin-left:0px; color:#999; width:100%" id="shirt_summary">
                                <?php
                                
                                $count = 0;
								if($_SESSION['promotion']){
									$promotion = new promotion();
									$promotion = unserialize($_SESSION['promotion']);
										
								}
								
                                if($_SESSION['cart']){
                                    foreach($_SESSION['cart'] as $key=>$value){
                                        
                                        $shirt = new shirt();
                                        $shirt = unserialize($value);
										$count++; 
										
										$getShirtDB = 'select meta_key, meta_value from wp_postmeta WHERE post_id ='.$shirt->collection_shirt_id;
										$getShirt = createQuery($getShirtDB, $conn);
										while ($desc = mysql_fetch_array($getShirt)) {
											if($desc['meta_key'] == 'Price')
												$price = $desc['meta_value'];
											else if($desc['meta_key'] == 'Product Code')
												$product_code = $desc['meta_value'];
										}
										
										echo "<li id=\"$key\" ";
										
										if($_SESSION['promotion']){
											if($promotion->is_free_shirt == 'Y')
												echo "title=\"0\"";
										}else
											echo "title=\"$price\"";
										
										echo " class=\"item\" style=\"margin-left:15px\"><span id=\"highlight_$key\" class=\"highlight\" style=\"position:absolute; width:150px; height:12px; background-color:#AAA; opacity:0.5; \"></span><strong>$product_code</strong> <span id=\"quantity_$key\" style=\"color:#FFF\">";
										if($shirt->quantity >1)
											echo "x $shirt->quantity";
										echo "</span></li>";
										
										$x = 1 + $key;
										
										echo "<input type=\"hidden\" name=\"item_name_$x\" id=\"item_name_$x\" value=\"$product_code\">
												<input type=\"hidden\" name=\"item_number_$x\" id=\"item_number_$x\" value=\"$shirt->collection_shirt_id\">
												<input type=\"hidden\" name=\"amount_$x\" id=\"amount_$x\" value=\"$price\">
												<input type=\"hidden\" name=\"quantity_$x\" id=\"quantity_$x\" value=\"$shirt->quantity\">";
										
                                    }
                                }
                                
                                if($_SESSION['promotion']){
									
                                    $key++;
                                    
                                    echo "<li id=\"promotion_code\" title=\"0\" class=\"item\" style=\"margin-left:15px\"><span id=\"highlight_promo\" class=\"highlight\" style=\"position:absolute; width:150px; height:12px; background-color:#AAA; opacity:0.5; \"></span><strong>".$promotion->name."</strong></li>";
                                    
                                    if($key == 1)
										$x = 1;
									else
										$x = 1 + $key;
                                    
                                    echo "<input type=\"hidden\" name=\"item_name_$x\" id=\"item_name_$x\" value=\"PROMOTION - ".$promotion->name."\">
                                            <input type=\"hidden\" name=\"item_number_$x\" id=\"item_number_$x\" value=\"".$promotion->id."\">
                                            <input type=\"hidden\" name=\"amount_$x\" id=\"amount_$x\" value=\"0\">
                                            <input type=\"hidden\" name=\"quantity_$x\" id=\"quantity_$x\" value=\"1\">";
                                }
                                ?>
                            </ul>
                            <p style="border-bottom:1px #999 dashed;">
                                <span id="no_item" style="font-size:10px; color:#666">No item in the cart</span>
                            </p>
                            <p style="font-size:10px"><br />
                                Ships: 7-10 business days
                            </p>
                            <p style="font-size:10px;">
                                Free shipping
                            </p>
                            <p>
                            	<input type="hidden" name="return" value="<?php echo $success_url ?>">
                            	<input type="hidden" name="notify_url" value="<?php echo $notify_url ?>">
                                <input type="hidden" name="rm" value="2">
                                <input type="hidden" name="cbt" value="<?php echo $cbt ?>">
                                <input type="hidden" name="cancel_return" value="<?php echo $cancel_url ?>">
                                <input type="hidden" name="lc" value="<?php echo $language ?>">
                                <input type="hidden" name="currency_code" value="<?php echo $currency ?>" />
                                <center>
                                <input type="image" src="https://www.paypalobjects.com/en_GB/SG/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online." style="padding-top:10px">
                                <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
                                </center>
                            
                                </form>
                                
                                <?php
								if($_SESSION['promotion']){
									if($promotion->is_free_shirt == 'Y'){
										if(count($_SESSION['cart'], 0) != 1){
											echo '<center><br /><i style="color:#F00; font-size:9px">Warning: please ensure only 1 shirt <br />in your cart to use this promotion</i><br /><br />
													<button id="get_free_shirt" disabled>Get shirt</button></center>';
										}else
											echo '<br /><center><button id="get_free_shirt" onClick="return false">Get shirt</button></center>';
										
									}
									
									echo "<script>
											$(\"select.quantity option#1\").attr(\"selected\", \"true\");
											$(\"select.quantity\").attr(\"disabled\", \"disabled\");
										  </script>";
								}
								?>
                                <center><img id="paypal_loading" src="images/paypal_loading.gif" border=0></center>
                            </p>
                        </div>
                    </div>
                    </td></tr><tr><td>
                    <div class="cart_summary" style="font-size:11px; float:right; padding-top:5px; margin-top:5px;">
                        <span class="title_box">Promotional code</span>
                        <div style="float:left" align="center">
                            Code <input type="text" id="promotion-code" class="text ui-widget-content ui-corner-all" size="30" /><br /><br />
                            <button id="promotion-button">Get promotion</button>
                            <img id="promotion-loading" src="images/loadingbar.gif" border=0 style="display:none">
                            <p id="promotion-description" style="text-align:left">
                            	<strong></strong>
                                <br />
                                <span></span>
                            </p>
                        </div>
                    </div>
                    </td></tr></table>
				</div>
            </td>
        </tr>
    </table>
    </div>
</center>
</div>

<script>
$("button").button();
$("input.gift_message, img#loading, img#paypal_loading").hide();

$("td.proceed2").click(function(){
	var check_id = "<?php echo $_SESSION['shirt_id'] ?>";
	if(!check_id){
		var r = confirm("Oops, you have not select any shirt. go to the coverflow now.");
		if(r)
			window.location.href = "./coverflow";
	}else
		window.location.href = "./design";
});

$("input:text").each(function() {
    if($(this).attr("value") == $(this).attr("alt"))
		$(this).css("color", "#AAA");
});

$("a#gift").click(function(){
	$("table#gift").show();
	$("a#no-gift").show();
	$(this).hide();
	
});
$("a#no-gift").click(function(){
	$("table#gift").hide();
	$("a#gift").show();
	$(this).hide();
	$("input.gift-box").attr("value", "");
});

$("a.remove").click(function(){
	$("div.shirt_"+$(this).attr("id")).fadeOut();
	var id = $(this).attr("id");
	
	$.ajax({
		type: 'POST',
		url: 'session/remove_shirt.php',
		data: 'id='+id,
		dataType: 'json',
		success: function(data){
			
			location.reload();
			
			$("li#"+id).css("display", "none");
			check_summary();
			
			if(data.items == 0){
				$("span#items_in_cart").text("");
				$("div#cart_content").append("<p align=\"center\">There is no item in your cart yet</p>");
			}else if(data.items == 1)
				$("span#items_in_cart").text("("+data.items+" item)");
			else
				$("span#items_in_cart").text("("+data.items+" items)");
		},
		error: function(data){
			alert("Oops! Please try again later...");
		}
	});
});
$("span#empty_this").click(function(){
	$("div.shirt_div").fadeOut();
	
	$.ajax({
		type: 'POST',
		url: 'session/remove_all_shirts.php',
		dataType: 'json',
		success: function(data){
			location.reload();
		},
		error: function(data){
			alert("Oops! Please try again later...");
		}
	});
});

$("td.proceed1").click(function(){
	window.location.href = "./coverflow";
});
function check_summary(){
	var amount = 0;
	
	$('li.item').each(function() {
		if($(this).css("display") != "none"){
			var quantity = parseFloat($(this).find("span").text().substring(1));
			if(!quantity)
				quantity = 1;
			amount += (parseFloat($(this).attr("title")) * quantity);
		}
	});
	amount = parseInt(amount * 100);
	amount = amount / 100;
	$("span#amount").text(amount);
	if(amount == 0){
		$("span#no_item").show();
		$("input:image").hide();
	}else
		$("span#no_item").hide();
}
check_summary();

$("span.highlight").hide();

$("select.quantity").change(function(e) {
	
	var id = $(this).attr("title");
	var quantity = $(this).find("option:selected").attr("value");
	var this_item = $(this);
	
	$("img.loading_"+id).show();
	
	$.ajax({
		type: 'POST',
		url: 'session/update_quantity.php',
		data: 'id='+id+'&quantity='+quantity,
		dataType: 'json',
		success: function(data){
			if(data.status != "OK")
				alert("Oops! Please try again later...");
			else{
				
				if(this_item.find("option:selected").attr("value") > 1)
					$("span#quantity_"+this_item.attr("title")).text("x "+this_item.find("option:selected").attr("value"));
				else
					$("span#quantity_"+this_item.attr("title")).text("");
				
				var quantity_id = parseFloat(id) +1;
				$("input#quantity_"+quantity_id).attr("value", this_item.find("option:selected").attr("value"));
				
				$("span#highlight_"+this_item.attr("title")).css("display", "").fadeIn(1500, function(){
					$(this).fadeOut(1500);
				});
				
				check_summary();
			}
			$("img#loading").hide();
		},
		error: function(data){
			$("img#loading").hide();
			alert("Oops! Please try again later...");
		}
	});
});

$("select#shipping_address").change(function(){
	var address_id = $(this).find("option:selected").attr("value");
	if(address_id != 0){
		$.ajax({
			type: 'POST',
			url: 'session/get_address.php',
			data: 'id='+address_id,
			dataType: 'json',
			success: function(data){
				if(data.status != "OK")
					alert("Oops! Please try again later...");
				else{
					$("input").css("color", "#FFF");
					$("input#address_name").attr("value", data.name);
					$("input#address1").attr("value", data.address_line_1);
					$("input#address2").attr("value", data.address_line_2);
					$("input#city").attr("value", data.city);
					$("input#state").attr("value", data.state);
					$("input#zip").attr("value", data.zip);
					$("select#country option").each(function() {
						if($(this).attr("value") == data.country){
							$(this).attr("selected", "selected");
						}
					});
					$("input#number").attr("value", data.phone_number);
				}
			},
			error: function(data){
				alert("Oops! Please try again later...");
			}
		});
	}
});

$("input:text").focusin(function(){
	if($(this).attr("value") == $(this).attr("alt")){
		$(this).attr("value", "");
		$(this).css("color", "#FFF");
	}
});
$("input:text").focusout(function(){
	if($(this).attr("value") == ""){
		$(this).attr("value", $(this).attr("alt"));
		$(this).css("color", "#AAA");
	}
});
$("input:text").keydown(function(){
	$("select#shipping_address option:first").attr("selected", true);
});

$("input:image").click(function() {
	$("img#paypal_loading").show();
	var id = $("select#shipping_address").attr("value");
	if(!id)
		id = "0";
		
	<?php
		if(!$_SESSION['id']) echo 'var email = $("input#shipping_email").attr("value");';
		else echo 'var email = "'.$_SESSION['email'].'";';
	?>
	var name = $("input#address_name").attr("value");
	var address1 = $("input#address1").attr("value");
	var address2 = $("input#address2").attr("value");
	var city = $("input#city").attr("value");
	var state = $("input#state").attr("value");
	
	var zip = $("input#zip").attr("value");	
	var country = $("select#country option:selected").text();
	var number = $("input#number").attr("value");
	
	if(address1 == $("input#address1").attr("alt")) address1 = "";
	if(address2 == $("input#address2").attr("alt")) address2 = "";
	if(state == $("input#state").attr("alt")) state = "";
	
	if((!email)||(!name)||(!address1)||(!city)||(!state)||(!zip)||(!number)){
		
		$("img#paypal_loading").hide();
		
		alert("Please enter the shipping information");
		
		if(!number) $("input#number").css("border", "1px solid #FFB73D").focus();
		if(!zip) $("input#zip").css("border", "1px solid #FFB73D").focus();
		if(!state) $("input#state").css("border", "1px solid #FFB73D").focus();
		if(!city) $("input#city").css("border", "1px solid #FFB73D").focus();
		if(!address1) $("input#address1").css("border", "1px solid #FFB73D").focus();
		if(!name) $("input#address_name").css("border", "1px solid #FFB73D").focus();
		if(!email) $("input#shipping_email").css("border", "1px solid #FFB73D").focus();
		
		return false;
	}
	var gift_from, gift_message;
	gift_message = $("input#gift-message").attr("value");
	if(gift_message)
		gift_from = $("input#gift-from-name").attr("value");
		
	$.ajax({
		type: 'POST',
		url: 'session/before_payment.php',
		data: 'id='+id+'&name='+name+'&email='+email+'&address1='+address1+'&address2='+address2+'&city='+city+'&state='+state+'&zip='+zip+'&country='+country+'&number='+number+'&gift_message='+gift_message+'&gift_from='+gift_from,
		dataType: 'json',
		success: function(data){
			if(data.status != "OK"){
				$("img#paypal_loading").hide();
				alert("Oops! Please try again later...");
			}else{
				$("input#payment").attr("value", data.payment);
				$("form#paypal").submit();
			}
		},
		error: function(data){
			$("img#paypal_loading").hide();
			alert("Oops! something wrong has occurred...");
			return false;
		}
	});
	return false;
	
});

//a custom format option callback
var addressFormatting = function(text){
	var newText = text;
	//array of find replaces
	var findreps = [
		{find:/^([^\-]+) \- /g, rep: '<span class="ui-selectmenu-item-header">$1</span>'},
		{find:/([^\|><]+) \| /g, rep: '<span class="ui-selectmenu-item-content">$1</span>'},
		{find:/([^\|><\(\)]+) (\()/g, rep: '<span class="ui-selectmenu-item-content">$1</span>$2'},
		{find:/([^\|><\(\)]+)$/g, rep: '<span class="ui-selectmenu-item-content">$1</span>'},
		{find:/(\([^\|><]+\))$/g, rep: '<span class="ui-selectmenu-item-footer">$1</span>'}
	];
	
	for(var i in findreps){
		newText = newText.replace(findreps[i].find, findreps[i].rep);
	}
	return newText;
}		

$("select#shipping_address").selectmenu({
	style:'popup', 
	width: '200px',
	format: addressFormatting
});

$("select#country, select.quantity").addClass("text ui-widget-content ui-corner-all");

$("button#promotion-button").click(function(e) {
	$(this).button( "option", "disabled", true );
	$(this).next("img#promotion-loading").show();
	
	var obj_this = $(this);
	
    //get promotion info using ajax
	$.ajax({
		type: 'POST',
		url: 'session/get_promotion.php',
		data: 'id='+$("input#promotion-code").attr("value"),
		dataType: 'json',
		success: function(data){
			if(data.status != "OK"){
				alert("sorry, this promotion is currently unavailable");
				obj_this.button( "option", "disabled", false );
				obj_this.next("img#promotion-loading").hide();
			}else
				location.reload();
		},
		error: function(data){
			alert("Oops! Please try again later...");
			obj_this.button( "option", "disabled", false );
			obj_this.next("img#promotion-loading").hide();
		}
	});
});
<?php

if($_SESSION['promotion']){
	$promotion = new promotion();
	$promotion = unserialize($_SESSION['promotion']);
	echo '$("button#promotion-button").button( "option", "disabled", true );';
	echo '$("input#promotion-code").attr( "disabled", "disabled" );';
	echo '$("input#promotion-code").attr( "value", "'.$promotion->code.'" );';
	echo '$("p#promotion-description").attr( "title", "'.$promotion->id.'" );';
	echo '$("p#promotion-description strong").text( "'.$promotion->name.'" );';
	echo '$("p#promotion-description span").text( "'.$promotion->description.'" );';
	echo '$("p#promotion-description").show();';	
}

?>

var width_counter = 1;
$("img").each(function(index, element) {
	var width = ($("div#progress-bar-border").css("width").substr(0,3)-4)/$("img").length;
	
	$(this).load(function() {
		var calc_width = (width*width_counter) + "px";
		$("div#progress_bar").css("width", calc_width);
		
		width_counter++;
    });
});

$(".design").tipsy({gravity: 's'});// nw | n | ne | w | e | sw | s | se

$("button#get_free_shirt").click(function(){
	$("img#paypal_loading").show();
	var id = $("select#shipping_address").attr("value");
	<?php 
	
	if($_SESSION['email']) echo 'var email = "'.$_SESSION['email'].'";';
	else echo 'var email = $("input#shipping_email").attr("value");';
	
	?>
	
	var name = $("input#address_name").attr("value");
	var address1 = $("input#address1").attr("value");
	var address2 = $("input#address2").attr("value");
	var city = $("input#city").attr("value");
	var state = $("input#state").attr("value");
	
	var zip = $("input#zip").attr("value");	
	var country = $("select#country option:selected").text();
	var number = $("input#number").attr("value");
	
	if(address1 == $("input#address1").attr("alt")) address1 = "";
	if(address2 == $("input#address2").attr("alt")) address2 = "";
	if(state == $("input#state").attr("alt")) state = "";
	
	if((!email)||(!name)||(!address1)||(!city)||(!state)||(!zip)||(!number)){
		
		$("img#paypal_loading").hide();
		
		alert("Please enter the shipping information");
		
		if(!number) $("input#number").css("border", "1px solid #FFB73D").focus();
		if(!zip) $("input#zip").css("border", "1px solid #FFB73D").focus();
		if(!state) $("input#state").css("border", "1px solid #FFB73D").focus();
		if(!city) $("input#city").css("border", "1px solid #FFB73D").focus();
		if(!address1) $("input#address1").css("border", "1px solid #FFB73D").focus();
		if(!name) $("input#address_name").css("border", "1px solid #FFB73D").focus();
		if(!email) $("input#shipping_email").css("border", "1px solid #FFB73D").focus();
		
		return false;
	}
	
	var gift_from, gift_message;
	gift_message = $("input#gift-message").attr("value");
	if(gift_message)
		gift_from = $("input#gift-from-name").attr("value");
	
	$.ajax({
		type: 'POST',
		url: 'session/before_payment.php',
		data: 'id='+id+'&name='+name+'&email='+email+'&address1='+address1+'&address2='+address2+'&city='+city+'&state='+state+'&zip='+zip+'&country='+country+'&number='+number+'&gift_message='+gift_message+'&gift_from='+gift_from,
		dataType: 'json',
		success: function(data){
			if(data.status != "OK"){
				$("img#paypal_loading").hide();
				alert("Oops! Please try again later...");
			}else{
				window.location.href = './success';
			}
		},
		error: function(data){
			$("img#paypal_loading").hide();
			alert("Oops! something wrong has occurred...");
			return false;
		}
	});
	return false;
});


$("input#do-not-show").click(function(){
	if($(this).attr("checked")){
		setCookie("intro", "none", "7");
	}else{
		setCookie("intro", "", "-7");
	}
});

$("title").html("RONZARO - Shopping Cart");
</script>