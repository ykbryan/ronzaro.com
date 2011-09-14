<script>
$(document).ready(function() {
	$('.jqzoom').jqzoom({
		zoomType: 'innerzoom',
		preloadImages: false,
		alwaysOn:false
	});
});
</script>
<?php

if(!$_GET['action']||(!$_SESSION['shirt_id']&&!$_GET['id']))
	echo "<script>location.href = './' </script>";

require_once "config/conn.php";

if($_GET['id'])
	$_SESSION['shirt_id'] = $_GET['id'];
	
$getShirtDB = "SELECT post_title FROM wp_posts WHERE id = ".$_SESSION['shirt_id'];
$getShirt = createQuery($getShirtDB, $conn);
$row = mysql_fetch_row($getShirt);
$description = $row[0];

$getShirtDB = "select meta_key, meta_value from wp_postmeta WHERE post_id = ".$_SESSION['shirt_id'];
$getShirt = createQuery($getShirtDB, $conn);

$sub_image = '';

while ($desc = mysql_fetch_array($getShirt)) {
	if($desc['meta_key'] == 'Shirt Collar ID')
		$shirt_collar_id = $desc['meta_value'];
	else if($desc['meta_key'] == 'Shirt Cuff ID')
		$shirt_cuff_id = $desc['meta_value'];
	else if($desc['meta_key'] == 'Shirt Fit ID')
		$shirt_fit_id = $desc['meta_value'];
	else if($desc['meta_key'] == 'Shirt Placket ID')
		$shirt_placket_id = $desc['meta_value'];
	else if($desc['meta_key'] == 'Shirt Pocket ID')
		$shirt_pocket_id = $desc['meta_value'];
	else if($desc['meta_key'] == 'Shirt Yoke ID')
		$shirt_yoke_id = $desc['meta_value'];
	else if($desc['meta_key'] == 'Shirt Back ID')
		$shirt_back_id = $desc['meta_value'];
	else if($desc['meta_key'] == 'Shirt Bottom ID')
		$shirt_bottom_id = $desc['meta_value'];
	else if($desc['meta_key'] == 'Shirt Button ID')
		$shirt_button_id = $desc['meta_value'];
	else if($desc['meta_key'] == 'Short Sleeve')
		$is_short_sleeve = $desc['meta_value'];
	else if($desc['meta_key'] == 'Price')
		$price = $desc['meta_value'];
	else if($desc['meta_key'] == 'shirt_image'){
		$big_image = $desc['meta_value'];
		$small_image = str_replace(".jpg", "-680x1024.jpg", $desc['meta_value']);
		$shirt_image = '<a href="'.$small_image.'" class="jqzoom" rel="gal1" title="'.$description.'"><img src="'.$small_image.'" style="width:250px" class="another"></a>';
		$shirt_image .= '<span id="small_images" style="width:250px; height:56px; float:left; overflow:hidden"><p style="margin-top:0px">';
		$shirt_image .= '<a class="zoomThumbActive" href="javascript:void(0);" rel="{gallery: \'gal1\', smallimage: \''.$small_image.'\',largeimage: \''.$small_image.'\'}">';
		$shirt_image .= '<img src=\''.$small_image.'\' class="small" width="40" style="padding:5px 5px 5px 5px; float:left"></a>';
	}else if($desc['meta_key'] == 'main_image'){
		$big_image = $desc['meta_value'];
		$small_image = str_replace(".jpg", "-680x1024.jpg", $desc['meta_value']);
		$main_image = '<a href="javascript:void(0);" rel="{gallery: \'gal1\', smallimage: \''.$small_image.'\',largeimage: \''.$small_image.'\'}">';
		$main_image .= '<img src=\''.$small_image.'\' class="small" width="40" style="padding:5px 5px 5px 5px; float:left"></a>';
	}else if($desc['meta_key'] == 'sub_image'){
		$big_image = $desc['meta_value'];
		$small_image = str_replace(".jpg", "-680x1024.jpg", $desc['meta_value']);
		$sub_image .= '<a href="javascript:void(0);" rel="{gallery: \'gal1\', smallimage: \''.$small_image.'\',largeimage: \''.$small_image.'\'}">';
		$sub_image .= '<img src=\''.$small_image.'\' class="small" width="40" style="padding:5px 5px 5px 5px; float:left"></a>';
	}	
}
if(empty($shirt_collar_id))
	$shirt_collar_id = 1;
if(empty($shirt_cuff_id))
	$shirt_cuff_id = 1;
if(empty($shirt_fit_id))
	$shirt_fit_id = 1;
if(empty($shirt_placket_id))
	$shirt_placket_id = 1;
if(empty($shirt_pocket_id))
	$shirt_pocket_id = 1;
if(empty($shirt_yoke_id))
	$shirt_yoke_id = 1;
if(empty($shirt_back_id))
	$shirt_back_id = 1;
if(empty($shirt_bottom_id))
	$shirt_bottom_id = 1;
if(empty($shirt_button_id))
	$shirt_button_id = 1;
if(empty($is_short_sleeve))
	$is_short_sleeve = 'N';
?>

<style>
#wrap{
	width:100%;
	overflow:hidden;
	background-image:url(images/bkg_wood.jpeg);
	min-height:630px;
	float:left;
	margin:1px 0px 1px 0px
}
#details option{float:left}
#details .option{margin:5px 0px 5px 5px;padding:0px 0px 0px 0px;border:#000 3px solid}
.option_title:hover{cursor:pointer;opacity:0.5}
.shirt_option{font-size:11px;padding-left:5px}
.option:hover{cursor:pointer}
div.proceed2{
	background-image:url(images/proceed2.png);
	background-position:center right;
	background-repeat:no-repeat;
	padding-bottom:10px
}
div.proceed2:hover{
	background-image:url(images/proceed2-selected.png);
	cursor:pointer;
	color:#FFF
}
div.back1{
	background-image:url(images/back.png);
	background-position:center right;
	background-repeat:no-repeat;
	padding-left:30px
}
div.back1:hover{
	background-image:url(images/back-selected.png);
	cursor:pointer;
	color:#FFF
}
.shirt_option{color:#AAA}
.magnifyarea{ /* CSS to add shadow to magnified image. Optional */
	box-shadow: 5px 5px 7px #818181;
	-webkit-box-shadow: 5px 5px 7px #818181;
	-moz-box-shadow: 5px 5px 7px #818181;
	filter: progid:DXImageTransform.Microsoft.dropShadow(color=#818181, offX=5, offY=5, positive=true);
	background: white
}
td.proceed2{
	background:url(images/process2.png) no-repeat left center; 
	width:90px; 
	height:40px; 
	padding-left:40px
}
td.proceed2:hover{
	background:url(images/process2-selected.png) no-repeat left center;
	cursor:pointer;
	color:#FFF
}
td.proceed3{
	background:url(images/process3.png) no-repeat left center; 
	width:90px; 
	height:40px; 
	padding-left:40px
}
td.proceed3:hover{
	background:url(images/process3-selected.png) no-repeat left center;
	cursor:pointer;
	color:#fff
}
.outline{
	position:absolute; 
	width:250px;
	margin-top:30px;
	border:0px solid #000
}
.description_content{width:220px; padding:10px 10px 10px 10px; text-align:left}
.description_content p{font-style:italic}
.note{
	color: #FFF;
	position:absolute; 
	z-index:0; 
	overflow:hidden; 
	padding: 5px 15px 4px 10px;
	margin-top:-22px;
}
#show_monogram:hover, #question_monogram:hover{cursor: pointer;color:#FFF}
button.edit_size{float:right;display:none}
td.type{font-size:9px;color:#666;padding:5px}
table#std_size_table td{padding:3px}
</style>
</head>
<body>
<script>
<?php
echo '$(window).load(function() {
		$("div#progress_bar").css("width", "200px");
		$("div.top, div.bottom, div#wrap").show();
		$("div#loading-bar").delay(800).fadeOut(2000, function(){
			$("div#sub-bg").fadeOut(1000);
		});
	});';
?>
</script>

<!-- Loading Div -->
<div id="sub-bg" style="background-color:#000; position:fixed; width:100%; height:100%; z-index:999"></div>
<div id="loading-bar"> 
    <div style="width:500px; color:#AAA; font-size:14px; margin-left:auto; margin-right:auto">
        There is just one life for each of us: our own. - Euripides
        <br /><br />
        <div id="progress-bar-border" style="height:10px; width:204px; border:#888 solid 1px; margin-left:auto; margin-right:auto">
            <div id="progress_bar" style="background-color:#FFF; height:6px; margin-top:2px; margin-left:2px; width:0px; float:left">
            
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/top.php" ?>

<h1 style="display:none">RONZARO's Customization</h1>

<div id="wrap">
<div style="width:950px; overflow:hidden; text-align:left; margin-left:auto; margin-right:auto">
    <div id="shirt" style="position: absolute; margin-top: 125px; width: 250px; color:#FFF; margin-left:auto; margin-right:auto">
        <div id="small">
        	
			<?php
				echo $shirt_image;
				echo $main_image;
				echo $sub_image;
				echo "</p></span>";
				
            ?>
            
        </div>
        
        <div style="position:absolute; height:140px; overflow:hidden; width:230px; margin-top:340px; opacity:0.9; background-color:#000; padding:10px; display:none; z-index:999" id="shirt_description"></div>
    </div>
    
    <div id="outline_front" style="position: absolute; margin-top: 125px; width: 250px; height:375px; color:#FFF; background-color:#000; z-index:99; display:none; opacity:0.9">
    	<img src="images/outline_front/bottom-loose-round.png" class="outline fit_3 btm_2 outline_btm">
    	<img src="images/outline_front/bottom-loose-square.png" class="outline fit_3 btm_1 outline_btm">
    	<img src="images/outline_front/bottom-regular-round.png" class="outline fit_2 btm_2 outline_btm">
    	<img src="images/outline_front/bottom-regular-square.png" class="outline fit_2 btm_1 outline_btm">
    	<img src="images/outline_front/bottom-slim-round.png" class="outline fit_1 btm_2 outline_btm">
    	<img src="images/outline_front/bottom-slim-square.png" class="outline fit_1 btm_1 outline_btm">
        
    	<img src="images/outline_front/cut-loose.png" class="outline fit_3 cut_3 outline_fit">
    	<img src="images/outline_front/cut-regular.png" class="outline fit_2 cut_2 outline_fit">
    	<img src="images/outline_front/cut-slim.png" class="outline fit_1 cut_1 outline_fit">
        
    	<img src="images/outline_front/collar-medium-button.png" class="outline collar_4 outline_collar">
    	<img src="images/outline_front/collar-medium.png" class="outline collar_3 outline_collar">
    	<img src="images/outline_front/collar-narrow.png" class="outline collar_2 outline_collar">
    	<img src="images/outline_front/collar-wide.png" class="outline collar_5 outline_collar">
    	<img src="images/outline_front/collar-round.png" class="outline collar_1 outline_collar">
        
        <?php
		$getPlacketDB = "select outline_image from shirt_placket WHERE id = $shirt_placket_id";
		$getPlacket = createQuery($getPlacketDB, $conn);
		
		$row = mysql_fetch_row($getPlacket);
		echo "<img src=\"$row[0]\" class=\"outline optional\">";
		?>
    	
    	<img src="images/pocket/transparent.png" class="outline pocket_1">
    	<img src="images/outline_front/pocket-angular.png" class="outline pocket_2 outline_pocket">
    	<img src="images/outline_front/pocket-curve.png" class="outline pocket_3 outline_pocket">
    	<img src="images/outline_front/pocket-corner-cut.png" class="outline pocket_4 outline_pocket">
        
        <img src="images/pocket/transparent.png" class="monogram_none outline outline_monogram">
        <img src="images/monogram_placing/cuff-left<?php if($is_short_sleeve != 'N') echo "-short"; ?>.png" class="monogram_leftcuff outline outline_monogram">
        <img src="images/monogram_placing/cuff-right<?php if($is_short_sleeve != 'N') echo "-short"; ?>.png" class="monogram_rightcuff outline outline_monogram">
        <img src="images/monogram_placing/chest-left.png" class="monogram_leftchest outline outline_monogram">
        <img src="images/monogram_placing/chest-right.png" class="monogram_rightchest outline outline_monogram">
        
        <?php 
			if($is_short_sleeve == 'N') echo '<img src="images/outline_front/cuff.png" class="outline optional">
											  <img src="images/outline_front/sleeves-long.png" class="outline optional">';
			else echo '<img src="images/outline_front/sleeves-short.png" class="outline optional">';
		?>
    </div>
    
    <div id="outline_back" style="position: absolute; float:left; margin-top: 125px; width: 250px; height:375px; color:#FFF; background-color:#000; z-index:99; display:none; opacity:0.9">
    <img src="images/outline_back/bottom-loose-round.png" class="outline btm_2 fit_3 outline_btm">
    <img src="images/outline_back/bottom-loose-square.png" class="outline btm_1 fit_3 outline_btm">
    <img src="images/outline_back/bottom-regular-round.png"class="outline btm_2 fit_2 outline_btm">
    <img src="images/outline_back/bottom-regular-square.png" class="outline btm_1 fit_2 outline_btm">
    <img src="images/outline_back/bottom-slim-round.png" class="outline btm_2 fit_1 outline_btm">
    <img src="images/outline_back/bottom-slim-square.png" class="outline btm_1 fit_1 outline_btm">
    
    <img src="images/outline_back/collar.png" class="outline optional">
    
    <img src="images/outline_back/cut-loose.png" class="outline fit_3 cut_3 outline_fit">
    <img src="images/outline_back/cut-regular.png" class="outline fit_2 cut_2 outline_fit">
    <img src="images/outline_back/cut-slim.png" class="outline fit_1 cut_1 outline_fit">
    
    <img src="images/outline_back/pleat-box.png" class="outline back_3 outline_back">
    <img src="images/outline_back/pleat-plain.png" class="outline back_1 outline_back">
    <img src="images/outline_back/pleat-single-side.png" class="outline back_2 outline_back">
    
    <?php 
			if($is_short_sleeve == 'N') echo '<img src="images/outline_back/cuff-double-angled.png" class="outline cuff_4 outline_cuff">
												<img src="images/outline_back/cuff-double-curved.png" class="outline cuff_5 outline_cuff">
												<img src="images/outline_back/cuff-doubled-square.png" class="outline cuff_6 outline_cuff">
												<img src="images/outline_back/cuff-single-angled.png" class="outline cuff_1 outline_cuff">
												<img src="images/outline_back/cuff-single-curved.png" class="outline cuff_2 outline_cuff">
												<img src="images/outline_back/cuff-single-square.png" class="outline cuff_3 outline_cuff">
												<img src="images/outline_back/sleeves-long.png" class="outline placket_1 outline_placket">
												<img src="images/outline_back/sleeves-long.png" class="outline outline optional">';
			else echo '<img src="images/outline_back/sleeves-short.png" class="outline outline optional">';
	?>
    
    </div>
    
    <table style="margin-bottom:5px; margin-top:5px; width:60%"><tr>
    	<td class="proceed1" style="background:url(images/process1-selected.png) no-repeat left center; width:90px; height:40px; padding-left:40px; color:#FFF">Design</td>
        <td class="proceed2">Size</td>
        <td class="proceed3">Checkout</td>
        <td></td>
    </tr></table>

    <div id="message" style="margin-bottom:20px; padding:10px 15px 10px 15px; background-image:url(images/bg_box.png); width:630px; text-align:left; height:25px">
        <span style="float:left; color:#777"><b style="color:#AAA"><?php echo $description; ?></b><br />Default shirt features selected below. Customize or proceed to sizing.</span>
        <button style="float:right" class="proceed2">Proceed to sizing</button>
    </div>
    <div id="details" style="padding-left:250px; width:700px; padding-top:5px">
    	
    	<div id="note_image" class="note" style="margin-left:-255px">[+] Mouseover  to zoom</div>
    	<div id="note_front" class="note" style="margin-left:0px;">i. Customize front</div>
       	<div id="note_back" class="note" style="margin-left:430px;">i. Customize back</div>
        
        <table style="margin-top:-5px; border-spacing:5px" id="customize_shirt">
            <tr>
                <td style="background-image:url(images/bg_box.png); vertical-align:text-top; padding:5px" width="400" id="mouseover_front" colspan="1" rowspan="2">
                <div id="collar" class="panel">
                    <span class="shirt_option">Collar</span>
                    <br />
                    <?php
                
                    $collars = "SELECT * FROM shirt_collar"; 
                    $all_collars = createQuery($collars, $conn);
                    
                    while ($info = mysql_fetch_array($all_collars)) {
                        $id = $info['id'];
                        $name = $info['name'];
                        $description = $info['description'];
                        $image = $info['image'];
                        
                        echo "<img class=\"option collar collar_$id front\" id=\"$id\" src=\"$image\" alt=\"$name\" rel=\"$description\" width=\"55\" height=\"55\" style=\"margin-right:10px\" />";
                        
                    }
                    
                    ?>
                </div>
                <div id="pocket" class="panel">
                <span class="shirt_option">Pockets</span>
                <br />
                <?php
            
                $pockets = "SELECT * FROM shirt_pocket"; 
                $all_pockets = createQuery($pockets, $conn);
                
                while ($info = mysql_fetch_array($all_pockets)) {
                    $id = $info['id'];
                    $name = $info['name'];
                    $description = $info['description'];
                    $image = $info['image'];
                    
                    echo "<img class=\"option pocket pocket_$id front\" id=\"$id\" src=\"$image\" alt=\"$name\" rel=\"$description\" width=\"55\" height=\"55\" style=\"margin-right:10px\" />";
                    
                }
                
                ?>
                </div>
                <div id="fit" class="panel">
                <span class="shirt_option">Fit</span>
                <br />
                <div style="height:100px; padding-left:10px">
                    <img src="images/fit/none.png" style="position:absolute" width="100">
                    <?php
                
                    $fits = "SELECT * FROM shirt_fit"; 
                    $all_fits = createQuery($fits, $conn);
                    $x = 0;
                    while ($info = mysql_fetch_array($all_fits)) {
                        $id = $info['id'];
                        $name = $info['name'];
                        $description = $info['description'];
                        $image = $info['image'];
                        echo '<img class="fit fit_'.$id.'" id="'.$id.'" src="'.$image.'" style="position:absolute; opacity:0.1; margin-top:'.$x.'px" width="100">';
                        $x -= 25;
                        echo "<div style=\"margin-left:120px; padding-left:10px; width:60px\" src=\"$image\" class=\"option front fit fit_$id\" id=\"$id\"  alt=\"$name\" rel=\"$description\" height=\"88\" />$name</div>";
                    }
                    ?>
                </div>
                </div>
                
                <div id="btm" class="panel">
                    <span class="shirt_option">Bottom</span>
                    <br />
                    <?php
                
                    $bottoms = "SELECT * FROM shirt_bottom"; 
                    $all_bottoms = createQuery($bottoms, $conn);
                    
                    while ($info = mysql_fetch_array($all_bottoms)) {
                        $id = $info['id'];
                        $name = $info['name'];
                        $description = $info['description'];
                        $image = $info['image'];
                        
                        echo "<img class=\"option btm btm_$id front\" id=\"$id\" src=\"$image\" alt=\"$name\" rel=\"$name. $description\" height=\"88\" />";
                        
                    }
                    
                    ?>
                    </div>
                </td>
                <td style="background-image:url(images/bg_box.png); padding:5px; vertical-align:text-top; width:240px; height:250px" id="mouseover_back">
                <?php 
                    if($is_short_sleeve == 'N'){
                    
                         echo '<div id="cuff" class="panel">
                            <span class="shirt_option">Cuffs</span>
                            <br />';
                    
                
                        $cuffs = "SELECT * FROM shirt_cuff"; 
                        $all_cuffs = createQuery($cuffs, $conn);
                        
                        while ($info = mysql_fetch_array($all_cuffs)) {
                            $id = $info['id'];
                            $name = $info['name'];
                            $description = $info['description'];
                            $image = $info['image'];
                            
                            echo "<img class=\"option cuff cuff_$id\" id=\"$id\" src=\"$image\" alt=\"$name\" rel=\"$description\" width=\"60\" />";
                            
                        }
                        
                        echo '</div>';
                    }
                ?>
                <div id="back" class="panel">
                <span class="shirt_option">Back</span>
                <br />
                <?php
            
                $backs = "SELECT * FROM shirt_back"; 
                $all_backs = createQuery($backs, $conn);
                
                while ($info = mysql_fetch_array($all_backs)) {
                    $id = $info['id'];
                    $name = $info['name'];
                    $description = $info['description'];
                    $image = $info['image'];
                    
                    echo "<img class=\"option back back_$id\" id=\"$id\" src=\"$image\" alt=\"$name\" rel=\"$description\" width=\"55\" height=\"55\" />";
                    
                }
                
                ?>
                </div>
                </td>
            </tr>
            <tr>
                
                
                <td style="background-image:url(images/bg_box.png)" id="mouseover_monogram" title="shirt monogram is a small embroidery of two or three letters on the shirt">
                <span class="shirt_option">Monogram lettering <img src="images/question_mark.png" width="15" id="question_monogram" title="What is a monogram"></span>
                    <br />
                    <table style="padding:0px 10px 0px 2px; font-size:11px">
                        <tr style="height:30px"><td colspan="2">i. Choose placement<br />

						<?php if($is_short_sleeve == "Y") $is_sleeve = "sleeve"; else $is_sleeve = "cuff"; ?>
<img class="option monogram_placement placement_none" id="monogram_none" src="images/pocket/none.png" title="No monogram" width="40" />
<img class="option monogram_placement placement_leftcuff" id="monogram_leftcuff" src="images/monogram_placing/closeup-right-cuff.png" title="Right <?php echo $is_sleeve ?>" width="40" />
<img class="option monogram_placement placement_rightcuff" id="monogram_rightcuff" src="images/monogram_placing/closeup-cuff.png" title="Left <?php echo $is_sleeve ?>" width="40" />
<img class="option monogram_placement placement_rightchest" id="monogram_rightchest" src="images/monogram_placing/closeup-pocket.png" title="Left chest/pocket" width="40" />

<img src="images/monogram/leftcuff.png" style="display:none" />
<img src="images/monogram/rightcuff.png" style="display:none" />
<img src="images/monogram/rightpocket.png" style="display:none" />
                        </td></tr>
                        <tr height="30">
                            <td valign="top" style="vertical-align:text-top">ii. Type your initials</td>
                            <td><input class="monogram_text text ui-widget-content ui-corner-all" type="text" placeholder="e.g R.O.N" maxlength="20" /></td>
                        </tr>
                        <tr><td width="90" style="vertical-align:text-top">iii. Color of your initials</td><td>
                        	<img class="option colour colour_black" src="images/monogram/black.png" alt="black" title="black" width="20" />
                            <img class="option colour colour_babyblue" src="images/monogram/babyblue.png" alt="baby blue" title="baby blue" width="20" />
                            <img class="option colour colour_darkblue" src="images/monogram/darkblue.png" alt="dark blue" title="dark blue" width="20" />
                            <img class="option colour colour_maroon" src="images/monogram/maroon.png" alt="maroon" title="maroon" width="20" />
                            <img class="option colour colour_white" src="images/monogram/white.png" alt="white" title="white" width="20" />
                        	<img class="option colour colour_gold" src="images/monogram/gold.png" alt="gold" title="gold" width="20" />
                        </td></tr>
                    </table>
                </td>
            </tr>
        </table>
        
    </div>
    <table style="float:right; padding-left:15px; width:710px; border-spacing:0px">
        <tr>
            <td><div class="back1" style="width:160px; height:30px; float:left"></div></td>
            <td><div class="proceed2" style="width:200px; height:30px; float:right"></div></td>
        </tr>
    </table>
</div>
</div>
<div id="question" title="2. Sizing options" align="center" style="font-size:11px; display:none">
    <br /><p><button id="measurement_existing">Log in to use my previous measurements</button></p>
	<br /><p><button id="measurement_customize">Enter my body measurements</button></p>
	<br /><p><button id="measurement_standardize">Choose from a standard size chart</button></p>
    <center><img class="size_loading" src="images/loadingbar.gif" border="0" style="display:none;" /></center>
</div>
<div id="customize" title="2. Body measurements" align="center" style="font-size:11px; display:none">
	<table style="width:100%">
    	<tr>
        	<td style="vertical-align:text-top">
            	<img src="images/measurement/neck.jpg" id="measurement-img" />
            </td>
            <td style="vertical-align:top">
            	
                <table>
                    <tr><td colspan="3" style="color:#AAA; text-align:left; ">
                    measurements best taken while wearing a dress shirt.<p>
                    round off measurement to the nearest 0.5 unit.
                    <p><br /><br />
                    <center>
                    <div id="radio">
                    	<label for="type_inch" class="type" id="inches">
                        	<input type="radio" name="type" id="type_inch" class="type" value="inches" checked>
                            <span style="padding-left:10px">inches</span>
                         </label>
                    	<label for="type_cm" class="type" id="cm">
                            <input type="radio" name="type" id="type_cm" class="type" value="cm">
                            <span style="padding-left:10px">cm</span>
                        </label>
                    </div>
                    </center>
                    </p><br />
                    </td></tr>
                    <tr><td>Neck</td><td>
                    <input type="text" name="neck" id="neck" alt="place measuring tape under adam's apple and hold tape with at least 2 fingers' spacing" title="images/measurement/neck.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" />
                    </td><td class="type" width="40">inches</td></tr>
                    <tr><td>Shoulder</td><td><input type="text" name="shoulder" id="shoulder" alt="measure across shoulder by placing measuring tape at the 2 interception points between the arm and the tip of the shoulder" title="images/measurement/shoulder.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Bicep</td><td><input type="text" name="bicep" id="bicep" alt="from 6 inch down from the shoulder, measure the circumference of the bicep with 1 finger's spacing." title="images/measurement/bicep.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Arm length</td><td><input type="text" name="armlength" id="armlength" alt="place measuring tape where the shoulders end (where shoulders start) and measure to half the back of the hand" title="images/measurement/armlength.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Wrist</td><td><input type="text" name="wrist" id="wrist" alt="measure loosely (at least 1 finger spacing) the circumference of the hand where the sleeves end. for the watch wearing wrist, measure the largest circumference of the wrist, including the watch" title="images/measurement/wrist.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Chest</td><td><input type="text" name="chest" id="chest" alt="measure loosely (at least 1 finger spacing) rounding up to the nearest whole number the circumference of the chest. ensure that tape at the back is horizontal and not drooping downwards" title="images/measurement/chest.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Waist</td><td><input type="text" name="waist" id="waist" alt="measure loosely (at least 1 finger spacing) rounding up to the nearest whole number the circumference of the waist. ensure that tape at the back is horizontal and not drooping downwards" title="images/measurement/waist.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Hips</td><td><input type="text" name="hips" id="hips" alt="measure loosely (at least 1 finger spacing) rounding up to the nearest whole number the circumference of the hips" title="images/measurement/hips.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td>Shirt length</td><td><input type="text" name="shirtlength" id="shirtlength" alt="measure the top (just under the collar) to the end of the crotch" title="images/measurement/shirtlength.jpg" value="" class="measurement text ui-widget-content ui-corner-all" size="5" /></td><td class="type">inches</td></tr>
                    <tr><td colspan="3"><br /><p>This belongs to<br />
                    <input type="text" name="m_name" id="m_name" title="images/measurement/neck.jpg" class="measurement text ui-widget-content ui-corner-all" size="25" placeholder="(optional)" />
                    </td></tr>
                </table>
            </td>
        </tr>
    </table>
    
    <!-- preload -->
    <img src="images/measurement/shoulder.jpg" style="display:none">
    <img src="images/measurement/bicep.jpg" style="display:none">
    <img src="images/measurement/armlength.jpg" style="display:none">
    <img src="images/measurement/wrist.jpg" style="display:none">
    <img src="images/measurement/chest.jpg" style="display:none">
    <img src="images/measurement/waist.jpg" style="display:none">
    <img src="images/measurement/hips.jpg" style="display:none">
    <img src="images/measurement/shirtlength.jpg" style="display:none">
    <img src="images/back-selected.png" style="display:none">
    <img src="images/proceed2-selected.png" style="display:none">
    
    <div id="custom_desc" style="color:#CCC; text-align:left"></i>
    </div>
    <br />
    
	<img id="loading" src="images/loadingbar.gif" border="0" style="float:right" />
</div>
<div id="standard" title="2. Standard sizing" align="center" style="font-size:11px; display:none">
    <br />
    Measurements can be edited accordingly for a better fit. <br />
    <p>
    <div id="radio2">
    	<br />
        <label for="view_inch" class="view_type" id="inches">
        	<input type="radio" name="view_type" id="view_inch" class="view_type" value="inches" style="padding-right:10px" checked>
            <span style="padding-left:10px">inches</span>
        </label>
        <label for="view_cm" class="view_type" id="cm">
        	<input type="radio" name="view_type" id="view_cm" class="view_type" value="cm" style="padding-right:10px">
            <span style="padding-left:10px">cm</span>
        </label>
        <br />
    </div><img class="size_loading" src="images/loadingbar.gif" border="0" style="float:right; display:none;" />
	</p>
    <table style="width:90%; color:#FFF" id="std_size_table">
        <tr bgcolor="#444">
            <td style="width:15px"></td>
            <td><strong>Size</strong></td>
            <td class="size_collar" width="100"><strong>Collar</strong></td>
            <td class="size_back_length" width="100"><strong>Sleeve length</strong></td>
            <td class="size_sleeve_length" width="100"><strong>Cuff</strong></td>
            <td class="size_cuff_depth" width="100"><strong>Chest</strong></td>
        </tr>
    </table>
</div>

<script>
$(document).ready(function() {
	$('.jqzoom').jqzoom({
		zoomType: 'innerzoom',
		preloadImages: false,
		alwaysOn:false
	});
});

$("tr.choosing_std").live("click", function(){
	$("button.use_this_standard").button("option", "disabled", false);
	$("tr.choosing_std").css("background-color", "#666")
	$(this).find("input:radio").attr("checked", "checked");
	$(this).attr("alt", $(this).css("background-color"));
	$(this).css("background-color", "#888");
});
</script>

<div id="exist" title="Select measurement" align="center" style="font-size:11px; display:none">
	<p><br />
    <select id="m_existing" class="ui-widget ui-state-default ui-corner-all">
    
    </select>
    <button id="select_existing_measurement" class="use_this_existing">Next</button>
    <button id="re-selection">Back to previous</button>
    
    </p><br />
    <img class="size_loading" src="images/loadingbar.gif" border="0" style="float:right; display:none" />
</div>
<div id="action" title="Continue shopping" align="center" style="display:none"><br />
	<p>Would you like to add more shirts to cart?</p><br />
    <button id="select_shopping" class="action">Yes, continue shopping</button>
    <button id="select_checkout" class="action">No, that's all i want</button>
</div>
<div id="monogram_answer" title="What is a monogram" align="center" style="display:none"> 
	<img src="http://images.ronzaro.netdna-cdn.com/monogram_placing/monogram_instruction.jpg" width="420" >
    <br />
	A monogram is a small embroidery of two or three letters usually corresponding to your initials. Having a monogram can add an identity to your shirt. 
</div> 

<script type="text/javascript">
$( "div#question, div#customize, div#exist, div#standard, div#action, div#view_gallery, div#monogram_answer" ).dialog("destroy").hide();
$("img#loading, .outline").hide();
$(".optional").show();

$("button").button();

//floating div
var menuYloc = parseInt($("#shirt").css("top").substring(0,$("#shirt").css("top").indexOf("px")));

$(window).scroll(function(){
	var checkYloc = parseInt($(document).scrollTop());
	var offset = checkYloc+5+"px";
	if(checkYloc<menuYloc)
		offset = menuYloc+"px";
	
	if(checkYloc<(parseInt($("div#wrap").css("height")) - parseInt($("img.main_picture").css("height"))+10)){
		$("#shirt").animate({top:offset},{duration:500,queue:false});
	}
});

$(".option").hover(function(){
	if($(this).hasClass("fit")&&!$(this).hasClass("img_selected")){
		fit_id = $(this).attr("id");
		$("div.fit_"+fit_id).css("color", "#FFF");
		$("img.fit_"+fit_id).css("opacity", "1");
		
		$("img.btm").each(function () {
			if($(this).hasClass("img_selected"))
				btm_id = $(this).attr("id");
		});
		$(".outline_btm, .outline_fit").hide();
		$(".outline_btm").each(function(){
			if($(this).hasClass("fit_"+fit_id)){
				if($(this).hasClass("btm_"+btm_id))
					$(this).show();
				$(".cut_"+fit_id).show();
			}
		});
	}else if(!$(this).hasClass("img_selected")){
		$(this).css("border", "#FFF 3px solid");
		if($(this).hasClass("collar")){
			$(".outline_collar").hide();
			$(".collar_"+$(this).attr("id")).show();
		}else if($(this).hasClass("pocket")){
			$(".outline_pocket").hide();
			$(".pocket_"+$(this).attr("id")).show();
		}else if($(this).hasClass("btm")){
			btm_id = $(this).attr("id");
			$("div.fit").each(function () {
				if($(this).hasClass("img_selected"))
					fit_id = $(this).attr("id");
			});
			$(".outline_btm").hide();
			$(".outline_btm").each(function(){
				if($(this).hasClass("fit_"+fit_id)){
					if($(this).hasClass("btm_"+btm_id))
						$(this).show();
					
				}
			});
		}else if($(this).hasClass("cuff")){
			$(".outline_cuff").hide();
			$(".cuff_"+$(this).attr("id")).show();
		}else if($(this).hasClass("back")){
			$(".outline_back").hide();
			$(".back_"+$(this).attr("id")).show();
		}
	}
	if(!$(this).hasClass("colour")&&!$(this).hasClass("monogram_placement")){
		var text = "<img src=\""+$(this).attr("src")+"\" width=\"90\" style=\"float:left; padding-right:10px; padding-bottom:20px\"><strong>" + $(this).attr("alt") + "</strong><br />" + $(this).attr("rel");
		$("div#shirt_description").html(text);
	}	
},function(){
	if($(this).hasClass("fit")&&!$(this).hasClass("img_selected")){
		$("div.fit_"+$(this).attr("id")).css("color", "#AAA");
		$("img.fit_"+$(this).attr("id")).css("opacity", "0.1");
	}else if(!$(this).hasClass("img_selected"))
		$(this).css("border", "#000 3px solid");
		
	if(!$(this).hasClass("colour")&&!$(this).hasClass("monogram_placement")){
		check_front_outline();
		$("div#shirt_description").html("");
	}
});

$(".option").click(function(){
	if($(this).hasClass("collar"))
		$("img.collar").removeClass("img_selected").css("border", "#000 3px solid");
	else if($(this).hasClass("cuff"))
		$("img.cuff").removeClass("img_selected").css("border", "#000 3px solid");
	else if($(this).hasClass("pocket"))
		$("img.pocket").removeClass("img_selected").css("border", "#000 3px solid");
	else if($(this).hasClass("back"))
		$("img.back").removeClass("img_selected").css("border", "#000 3px solid");
	else if($(this).hasClass("btm"))
		$("img.btm").removeClass("img_selected").css("border", "#000 3px solid");
	else if($(this).hasClass("monogram_placement"))
		$("img.monogram_placement").removeClass("img_selected").css("border", "#000 3px solid");
	else if($(this).hasClass("fit")){
		$(".fit").removeClass("img_selected").css("color", "#AAA");
		$("img.fit").css("opacity", "0.2");
	}else if($(this).hasClass("colour"))
		$("img.colour").removeClass("img_selected").css("border", "#000000 3px solid");
		
	if($(this).hasClass("fit")){
		$(this).addClass("img_selected").css("color", "#75683C");
		$(".fit_"+$(this).attr("id")).css("opacity", "1");
	}else
            $(this).addClass("img_selected").css("border", "#75683C 3px solid");
	check_front_outline();
});

$("input.monogram_text").keyup(function(){
	var monogram_text = $(this).attr("value");
	if(!monogram_text)
		monogram_text = "R.O.N";
	if($(".placement_leftcuff").hasClass("img_selected"))
		$("div#shirt_description").html("monogram illustration below:<br /><img src=\"images/monogram/leftcuff.png\" style=\"padding:5px\" width=\"220\"><div style=\"position:absolute; right:35px; top:90px; font-family:cursive; font-size:13px\">"+monogram_text+"</div>");
	else if($(".placement_rightcuff").hasClass("img_selected"))
		$("div#shirt_description").html("monogram illustration below:<br /><img src=\"images/monogram/rightcuff.png\" style=\"padding:5px\" width=\"220\"><div style=\"position:absolute; left:35px; top:90px; font-family:cursive; font-size:13px\">"+monogram_text+"</div>");
	else if($(".placement_rightchest").hasClass("img_selected"))
		$("div#shirt_description").html("monogram illustration below:<br /><img src=\"images/monogram/rightpocket.png\" style=\"padding:5px\" width=\"220\"><div style=\"position:absolute; left:50px; top:65px; font-family:cursive; font-size:13px\">"+monogram_text+"</div>");
	else 
		$("div#shirt_description").html("<center>No placement is selected</center>");
});
$("span#show_monogram, img.monogram_placement").click(function(){
	$("input.monogram_text").keyup();
});

<?php 
if(empty($_SESSION['id']))
	echo "$(\"button#measurement_existing\").button(\"option\", \"disabled\", true);";
?>

$("img.option").each(function() {
    if($(this).hasClass("collar_<?php echo $shirt_collar_id?>")) $(this).addClass("img_selected").css("border", "#75683C 3px solid");
    if($(this).hasClass("cuff_<?php echo $shirt_cuff_id?>")) $(this).addClass("img_selected").css("border", "#75683C 3px solid");
    if($(this).hasClass("pocket_<?php echo $shirt_pocket_id?>")) $(this).addClass("img_selected").css("border", "#75683C 3px solid");
    if($(this).hasClass("back_<?php echo $shirt_back_id?>")) $(this).addClass("img_selected").css("border", "#75683C 3px solid");
    if($(this).hasClass("btm_<?php echo $shirt_bottom_id?>")) $(this).addClass("img_selected").css("border", "#75683C 3px solid");
    if($(this).hasClass("placket_<?php echo $shirt_placket_id?>")) $(this).addClass("img_selected").css("border", "#75683C 3px solid");
    if($(this).hasClass("placement_none")) $(this).addClass("img_selected").css("border", "#75683C 3px solid");
    if($(this).hasClass("colour_black")) $(this).addClass("img_selected").css("border", "#75683C 3px solid");
});

$("div.fit_<?php echo $shirt_fit_id?>").css("color", "#75683C").addClass("img_selected");
$("img.fit_<?php echo $shirt_fit_id?>").css("opacity", "1");

function check_front_outline(){
	$(".outline").hide();
	$(".optional").show();
	
	$("img.collar").each(function () {
		if($(this).hasClass("img_selected"))
			$(".collar_"+$(this).attr("id")).show();
	});
	$("img.pocket").each(function () {
		if($(this).hasClass("img_selected"))
			$(".pocket_"+$(this).attr("id")).show();
	});
	$("img.placket").each(function () {
		if($(this).hasClass("img_selected"))
			$(".placket_"+$(this).attr("id")).show();
	});
	$("img.cuff").each(function () {
		if($(this).hasClass("img_selected"))
			$(".cuff_"+$(this).attr("id")).show();
	});
	$("img.monogram_placement").each(function () {
		if($(this).hasClass("img_selected"))
			$("."+$(this).attr("id")).show();
	});
	$("img.back").each(function () {
		if($(this).hasClass("img_selected"))
			$(".back_"+$(this).attr("id")).show();
	});
	$("img.btm").each(function () {
		if($(this).hasClass("img_selected"))
			btm_id = $(this).attr("id");
	});
	$("div.fit").each(function () {
		if($(this).hasClass("img_selected"))
			fit_id = $(this).attr("id");
	});
	
	$(".outline_btm").each(function(){
		if($(this).is(".fit_"+fit_id))
			if($(this).is(".btm_"+btm_id))
				$(this).show();
	});
	
	$(".outline_fit").each(function(){
		if($(this).is(".fit_"+fit_id))
			if($(this).is(".btm_"+btm_id))
				$(this).show();
		$(".cut_"+fit_id).show();
	});
};
check_front_outline();

$("div.panel").hover(function(){
	$(".outline").css("opacity", "0.65");
	$("img.outline_"+$(this).attr("id")).css("opacity", "1");
}, function(){
	$(".outline").css("opacity", "1");
});

$(".proceed2").click(function(){
	$("td.proceed2").css("background-image", "url(images/process2-selected.png)").css("color", "#FFF");
	$("td.proceed1").css("background-image", "url(images/process1.png)").css("color", "#666");
	
	$("div#question").dialog({
		hide: "explode",
		height: 190,
		width: 350,
		modal: true
	});
});


$('div').bind('dialogclose', function(event) {
	$("td.proceed2").css("background-image", "url(images/process2.png)").css("color", "#666");
	$("td.proceed1").css("background-image", "url(images/process1-selected.png)").css("color", "#FFF");
 });

$("td.proceed3").click(function(){
	var r=confirm("warning: you have not added the current shirt to cart yet. do you want to proceed?");
	if(r)
		window.location.href = "./cart";
		
});

var edit_button = 0;

var std_size_html = $("table#std_size_table").html();
$("button#measurement_standardize").click(function(){
	
	$("img.size_loading").show();
	
	$("div.fit").each(function () {
		if($(this).hasClass("img_selected"))
			fit_id = $(this).attr("id");
	});
	$.ajax({
		type: 'POST',
		url: './session/get_standard_size.php',
		data: 'id='+fit_id,
		dataType: 'json',
		success: function(data){
			$("img.size_loading").hide();
			$("table#std_size_table").html(std_size_html);
			
			if(data.status == "OK"){
				$("");
				$("table#std_size_table").append(data.text);
				$("button.edit_size" ).button({
					icons: {
						primary: "ui-icon-pencil"
					},
					text: false
				});
				//get first size id
				var size_id = $("input[@name=size]:checked").attr("value");
				$("table#std_size_table tr").hover(function(){
					$(this).find("button.edit_size").show();
				}, function(){
					$(this).find("button.edit_size").hide();
				});
				$("button.edit_size").click(function() {
					if(edit_button == 0){
						edit_button++;
						
						$(this).removeClass("edit_size");
						var this_button = $(this);
											var content_span = $(this).prev("div");
						var content = content_span.text();
						var boxup = '<input type="text" size="4" value="'+content+'" id="edit_text" class="text ui-widget-content ui-corner-all"><button id="edit_ok" style="float:right"></button>';
						content_span.html(boxup);
						$(this).hide();
						$("button#edit_ok" ).button({
							icons: {
								primary: "ui-icon-check"
							},
							text: false
						});
						$("input#edit_text").keypress(function(e) {
							if(!(((e.keyCode >= 48)&&(e.keyCode <= 57))||(e.keyCode == 46)))
								return false;
						});
						$("button#edit_ok").click(function(){
							var content_value = Math.round($("input#edit_text").attr("value"));
							content_span.text(content_value);
							this_button.addClass("edit_size");
							edit_button = 0;
						});
					}else
						alert("please confirm the measurement input");
                });

				
				$("div#question").dialog("destroy");
				$("div#standard").dialog({
					hide: "explode",
					height: 450,
					width: 500,
					modal: true,
					buttons: {
						"next": function() {
							$(this).button("option", "disabled", true);
							
							var size_id = $("input.size_id:checked").attr("value");
							var size_name = $("tr#size_"+size_id+" td.size_name").text();
							var size_collar = $("tr#size_"+size_id+" td.size_collar").text();
							var size_sleeve = $("tr#size_"+size_id+" td.size_sleeve").text();
							var size_cuff = $("tr#size_"+size_id+" td.size_cuff").text();
							var size_chest = $("tr#size_"+size_id+" td.size_chest").text();
							
							if(!size_id || !size_collar || !size_sleeve || !size_cuff || !size_chest){
								alert("please confirm the measurement input");
								return false;
							}
							
							var collar_id, cuff_id, pocket_id, back_id, bottom_id, fit_id, monogram_color, monogram_placement, monogram_text;
							
							$("img.collar").each(function () {
								if($(this).hasClass("img_selected"))
									collar_id = $(this).attr("id");
							});
							$("img.cuff").each(function () {
								if($(this).hasClass("img_selected"))
									cuff_id = $(this).attr("id");
							});
							$("img.pocket").each(function () {
								if($(this).hasClass("img_selected")){
									pocket_id = $(this).attr("id");
								}
							});
							$("img.back").each(function () {
								if($(this).hasClass("img_selected"))
									back_id = $(this).attr("id");
							});
							$("img.btm").each(function () {
								if($(this).hasClass("img_selected"))
									bottom_id = $(this).attr("id");
							});
							$("div.fit").each(function () {
								if($(this).hasClass("img_selected"))
									fit_id = $(this).attr("id");
							});
							$("img.colour").each(function () {
								if($(this).hasClass("img_selected"))
									monogram_color = $(this).attr("title");
							});
							$("img.monogram_placement").each(function () {
								if($(this).hasClass("img_selected"))
									monogram_placement = $(this).attr("original-title");
							});
							
							if(monogram_placement&&$("input.monogram_text").attr("value"))
								monogram_text = $("input.monogram_text").attr("value");
								
							$.ajax({
								type: 'POST',
								url: 'session/set_measurement_standard.php',
								data: 'collar_id='+collar_id+'&cuff_id='+cuff_id+'&pocket_id='+pocket_id+'&back_id='+back_id+'&bottom_id='+bottom_id+'&fit_id='+fit_id+'&monogram_color='+monogram_color+'&monogram_placement='+monogram_placement+'&monogram_text='+monogram_text+'&size_name='+size_name+'&id='+size_id+'&size_collar='+size_collar+'&size_sleeve='+size_sleeve+'&size_cuff='+size_cuff+'&size_chest='+size_chest+'&unit='+$("input.view_type:checked").val(),
								dataType: 'json',
								success: function(data){
									$(this).button("option", "disabled", false);
									
									if(data.status == "OK"){
										$("div#standard").dialog("destroy");
										aftermath_action();
									}else
										alert("Oops! please try again later...");
								},error: function(data){
									alert("Oops! please try again later...");
								}
							});
						}
					}
				});
				
			}
			
		},error: function(data){
			alert("Oops! an error has occurred. please try again later...");
		}
	});

});

$("button#measurement_customize").click(function(){
	$("input#m_name").css("color", "#999");	
	$("div#question").dialog("destroy");
	$("div#customize").dialog({
		hide: "explode",
		height: 550,
		width: 525,
		modal: true,
		buttons: {
			"next": function(){
				if(!$("input#neck").attr("value")||!$("input#shoulder").attr("value")||!$("input#bicep").attr("value")||!$("input#armlength").attr("value")||!$("input#wrist").attr("value")||!$("input#chest").attr("value")||!$("input#waist").attr("value")||!$("input#hips").attr("value")||!$("input#shirtlength").attr("value")){
					if(!$("input#shirtlength").attr("value"))
						$("input#shirtlength").css("border-color", "#FFB73D").focus();
					if(!$("input#hips").attr("value"))
						$("input#hips").css("border-color", "#FFB73D").focus();
					if(!$("input#waist").attr("value"))
						$("input#waist").css("border-color", "#FFB73D").focus();
					if(!$("input#chest").attr("value"))
						$("input#chest").css("border-color", "#FFB73D").focus();
					if(!$("input#wrist").attr("value"))
						$("input#wrist").css("border-color", "#FFB73D").focus();
					if(!$("input#armlength").attr("value"))
						$("input#armlength").css("border-color", "#FFB73D").focus();
					if(!$("input#bicep").attr("value"))
						$("input#bicep").css("border-color", "#FFB73D").focus();
					if(!$("input#shoulder").attr("value"))
						$("input#shoulder").css("border-color", "#FFB73D").focus();
					if(!$("input#neck").attr("value"))
						$("input#neck").css("border-color", "#FFB73D").focus();
					
					alert("please enter the missing measurement fields");
					return false;
				}
					
				$("img#loading").show();
				$(this).button("option", "disabled", true);
				
				//shirt
				var collar_id, cuff_id, pocket_id, back_id, bottom_id, fit_id, monogram_color, monogram_placement, monogram_text;
			
				$("img.collar").each(function () {
					if($(this).hasClass("img_selected"))
						collar_id = $(this).attr("id");
				});
				$("img.cuff").each(function () {
					if($(this).hasClass("img_selected"))
						cuff_id = $(this).attr("id");
				});
				$("img.pocket").each(function () {
					if($(this).hasClass("img_selected"))
						pocket_id = $(this).attr("id");
				});
				$("img.back").each(function () {
					if($(this).hasClass("img_selected"))
						back_id = $(this).attr("id");
				});
				$("img.btm").each(function () {
					if($(this).hasClass("img_selected"))
						bottom_id = $(this).attr("id");
				});
				$("div.fit").each(function () {
					if($(this).hasClass("img_selected"))
						fit_id = $(this).attr("id");
				});
				$("img.colour").each(function () {
					if($(this).hasClass("img_selected"))
						monogram_color = $(this).attr("title");
				});
				$("img.monogram_placement").each(function () {
					if($(this).hasClass("img_selected"))
						monogram_placement = $(this).attr("original-title");
				});
				
				if(monogram_placement&&$("input.monogram_text").attr("value"))
					monogram_text = $("input.monogram_text").attr("value");
					
				//measurement
				var name = $("input#m_name").attr("value");
				var neck = $("input#neck").attr("value");
				var shoulder = $("input#shoulder").attr("value");
				var bicep = $("input#bicep").attr("value");
				var armlength = $("input#armlength").attr("value");
				var wrist = $("input#wrist").attr("value");
				var chest = $("input#chest").attr("value");
				var waist = $("input#waist").attr("value");
				var hips = $("input#hips").attr("value");
				var shirtlength = $("input#shirtlength").attr("value");
				
				$.ajax({
					type: 'POST',
					url: 'session/set_measurements.php',
					data: 'collar_id='+collar_id+'&cuff_id='+cuff_id+'&pocket_id='+pocket_id+'&back_id='+back_id+'&bottom_id='+bottom_id+'&fit_id='+fit_id+'&monogram_color='+monogram_color+'&monogram_placement='+monogram_placement+'&monogram_text='+monogram_text+'&name='+name+'&neck='+neck+'&shoulder='+shoulder+'&bicep='+bicep+'&armlength='+armlength+'&wrist='+wrist+'&chest='+chest+'&waist='+waist+'&hips='+hips+'&shirtlength='+shirtlength+'&unit='+$("input.type:checked").val(),
					dataType: 'json',
					success: function(data){
						//alert(data.status);
						$("img#loading").hide();
						$(this).button("option", "disabled", false);
						
						if(data.status == "OK"){
							$("div#customize").dialog("destroy");
							aftermath_action();
						}else
							alert("Oops! please try again later...");
					},error: function(data){
						alert("Oops! please try again later...");
					}
				});	
			}
		}
	});
});

function aftermath_action(){
	$("div#action").dialog({
		hide: "explode",
		height: 120,
		width: 375,
		modal: true
	});
}

$("button#select_existing_measurement").live("click", function(){
	
	$(this).button("option", "disabled", true);
	$("img.size_loading").show();
	var collar_id, cuff_id, pocket_id, back_id, bottom_id, fit_id, monogram_color, monogram_placement, monogram_text;
	
	$("img.collar").each(function () {
		if($(this).hasClass("img_selected"))
			collar_id = $(this).attr("id");
	});
	$("img.cuff").each(function () {
		if($(this).hasClass("img_selected"))
			cuff_id = $(this).attr("id");
	});
	$("img.pocket").each(function () {
		if($(this).hasClass("img_selected")){
			pocket_id = $(this).attr("id");
		}
	});
	$("img.back").each(function () {
		if($(this).hasClass("img_selected"))
			back_id = $(this).attr("id");
	});
	$("img.btm").each(function () {
		if($(this).hasClass("img_selected"))
			bottom_id = $(this).attr("id");
	});
	$("div.fit").each(function () {
		if($(this).hasClass("img_selected"))
			fit_id = $(this).attr("id");
	});
	$("img.colour").each(function () {
		if($(this).hasClass("img_selected"))
			monogram_color = $(this).attr("title");
	});
	$("img.monogram_placement").each(function () {
		if($(this).hasClass("img_selected"))
			monogram_placement = $(this).attr("original-title");
	});
	
	if(monogram_placement&&$("input.monogram_text").attr("value"))
		monogram_text = $("input.monogram_text").attr("value");
	
	var existing_id = $("select#m_existing option:selected").attr("id");
	
	$.ajax({
		type: 'POST',
		url: 'session/set_measurement_exist.php',
		data: 'collar_id='+collar_id+'&cuff_id='+cuff_id+'&pocket_id='+pocket_id+'&back_id='+back_id+'&bottom_id='+bottom_id+'&fit_id='+fit_id+'&monogram_color='+monogram_color+'&monogram_placement='+monogram_placement+'&monogram_text='+monogram_text+'&id='+existing_id,
		dataType: 'json',
		success: function(data){
			$("img.size_loading").hide();
			
			if(data.status == "OK"){
				$("div#exist").dialog("destroy");
				aftermath_action();
			}else
				alert("Oops! please try again later...");
		},error: function(data){
			alert("Oops! please try again later...");
		}
	});

	
});

$("button#measurement_existing").click(function(){
	$.ajax({
		type: 'POST',
		url: 'session/get_existing_measurements.php',
		dataType: 'json',
		success: function(data){
			if(data.status == "OK"){
				$("select#m_existing").html("");
				$("select#m_existing").append(data.option);
				if(data.available != "OK")
					$("button#select_existing_measurement").hide();
				else
					$("button#re-selection").hide();
				
				$("div#question").dialog("destroy");
				$("div#exist").dialog({
					hide: "explode",
					height: 150,
					width: 300,
					modal: true
				});
			}else
				alert("There is no measurement recorded in your account.");
		},error: function(data){
			alert("Oops! please try again later...");
		}
	});
	
});

$("button.action").click(function(){
	$( "div#question, div#customize, div#exist, div#standard, div#action" ).dialog("destroy");
	if($(this).attr("id")=="select_checkout"){
		window.location.href = "./cart";
	}else
		window.location.href = "./coverflow";
});

$("input.measurement").focus(function() {
    $("img#measurement-img").attr("src", $(this).attr("title"));
	$("div#custom_desc").text($(this).attr("alt"));
});

$("input#m_name").focus(function(){
	if($(this).attr("value") == $(this).attr("alt"))
		$(this).attr("value", "");
});

$("button#re-selection").live("click", function(){
	$( "div#question, div#customize, div#exist, div#standard, div#action" ).dialog("destroy").hide();
	$("div#question").dialog({
		hide: "explode",
		height: 190,
		width: 350,
		modal: true
	});
});

$("div.back1").click(function(){
	window.location.href = "./coverflow";
});

var width_counter = 2;
$("img").each(function(index, element) {
	var width = ($("div#progress-bar-border").css("width").substr(0,3)-4)/$("img").length;
	
	$(this).load(function() {
		var calc_width = (width*width_counter) + "px";
		$("div#progress_bar").css("width", calc_width);
		
		width_counter++;
    });
});

$("td#mouseover_monogram").hover(function() {
	$("div#outline_front, div#shirt_description").show();
	$("input.monogram_text").keyup();
}, function(){
	$("div#outline_front, div#shirt_description").hide();
	$("div#shirt_description").html("");
});

$("td#mouseover_front").hover(function() {
	$("div#note_front").css("opacity", "0.2");
	$("div#outline_front, div#shirt_description").show();
}, function(){
	$("div.note").css("opacity", "1");
	$("div#outline_front, div#shirt_description").hide();
});

$("td#mouseover_back").hover(function() {
	$("div#note_back").css("opacity", "0.2");
	$("div#outline_back, div#shirt_description").show();
}, function(){
	$("div.note").css("opacity", "1");
	$("div#outline_back, div#shirt_description").hide();
});

$("div#shirt").hover(function() {
	$("div#note_image").css("opacity", "0.2");
}, function(){
	$("div.note").css("opacity", "1");
	$("div#outline_back, div#shirt_description").hide();
});

$("input#do-not-show").click(function(){
	if($(this).attr("checked")){
		setCookie("intro", "none", "7");
	}else{
		setCookie("intro", "", "-7");
	}
});

$("div#small").hover(function(){
	$("div#note_back, div#note_front").css("opacity", "1");
}, function(){
	$("div.note").css("opacity", "0.2");
});

$("img.size_loading").ajaxStart(function() {
    $(this).show();
});
$("img.size_loading").ajaxStop(function() {
    $(this).hide();
});

$("img.monogram_placement").tipsy({gravity: 's'});
//$( "div#radio, div#radio2" ).buttonset();


$("label.type").click(function(){
	$("td.type").html($(this).attr("id"));
});

$("label.view_type").click(function(){
	if(edit_button > 0){
		alert("please confirm your measurement first");
		return false;
	}
	var label = $(this)
	$("td.size_collar, td.size_sleeve, td.size_cuff, td.size_chest").each(function() {
		var size_value = $(this).attr("alt");
		if(label.attr("id") == "cm"){
			var calc_value = Math.round(size_value*2.54);
			$(this).find("div.size_value").text(calc_value);
		}else
			$(this).find("div.size_value").text(size_value);
	});
});

$("img#question_monogram").click(function(){
	$("div#monogram_answer").dialog({
		hide: "explode",
		height: 370,
		width: 460,
		modal: true
	});
});

$("input").addClass("text ui-widget-content ui-corner-all");
$("title").html("RONZARO - Design Personalisation");
</script>