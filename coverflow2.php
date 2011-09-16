<?php
if(!$_GET['action'])
	echo "<script>location.href = './' </script>";
	
require_once "config/conn.php";
?>

<style>
#wrap{
	float:left;
	width:100%;
	overflow:hidden;
	min-height:470px;
	background-image:url(images/bkg_wood.jpeg);
	display:none;
	margin:1px 0px 1px 0px;
}
#panel_wrapper{
	width:90000px;
	padding-top:10px;
	display:none
}
.ggpanel{
	display:inline;
	float:left;
	position:relative
}
.panel_inactive{opacity:0.3}
.prev, .next{
	cursor:pointer;
	opacity:0.5;
	display:none;
}
.next:hover, .prev:hover{opacity:1}
.panel_active_0, .panel_active_1, .panel_active_2, #arrow-right:hover, #arrow-left:hover{opacity:1;cursor:pointer}
img{z-index:0}
img.option{ width:300px; height:450px }
img.option:hover{cursor:pointer}
.description{
	width:360px;
	position:absolute;
	right:50px;
	top: 0px;
	float:right;
	color:#FFF;
	display:none
}
.description:hover{cursor:default}
.description_item{
	font-size:11px;
	float:left;
	width:100%;
	padding:10px 10px 10px 10px;
	border-bottom:#444 solid 1px;
	border-left:#444 solid 1px;
	border-right:#444 solid 1px;
	background-color:#000000
}
.description_item:first{border-top:#444 solid 1px}
.description img{padding-right:15px;float:left}
.description-img:hover{cursor:crosshair}
.option{padding-right:15px;float:right}
.panel_active_0:hover, .panel_active_1:hover, .panel_active_2:hover{cursor:pointer}
.close_panel, .edit_panel, .want_panel{display:none;opacity:0.5}
.close_panel:hover, .edit_panel:hover, .want_panel:hover{opacity:1}
.title{
	position:absolute; 
	top:390px; 
	left:85px;
	padding: 22px 0px 8px 0px;
	color:#FFF;
	text-align:center;
	overflow:hidden;
	height:27px;
	width:130px
}
.other_pictures{
	display:none;
	position:absolute;
	top: 85%;
	left:50px
}
.other_pictures img{padding-right:15px}
.other_picture:hover{cursor:default}
.x_close{color:#75683C}
.x_close:hover{cursor:default}
.x_close_font{color:#FFF;cursor:default}
.x_close:hover,.x_close_font:hover{color:#75683C;cursor:pointer}
</style>
</head>
<body>

<script>
<?php
echo '$(window).load(function() {
		$("div#progress_bar").css("width", "200px");
		$("div#loading-bar").delay(800).fadeOut(2000, function(){
			$("div#wrap, div.top, div.bottom").fadeIn(1000, function(){
				$("div#panel_wrapper").fadeIn(500);
				$("div.panel_active_0").css("width", "800px").animate({
					"width": "315px"
				}, 500, function(){
					$("img.option").css("float", "left");
					$("img#next").show();
				});
			});	
		});
	});';
?>
</script>
<!-- Loading Div --> 
<div id="loading-bar"> 
    <div style="width:650px; color:#AAA; font-size:14px; margin-left:auto; margin-right:auto">
        "Fashion is an art. You express who you are through what you're wearing." - Daniele Donato
        <br /><br />
        <div id="progress-bar-border" style="height:10px; width:204px; border:#888 solid 1px; margin-left:auto; margin-right:auto">
            <div id="progress_bar" style="background-color:#FFF; height:6px; margin-top:2px; margin-left:2px; width:0px; float:left">
            
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/top.php" ?>

<h1 style="display:none">RONZARO Designs</h1>
<div id="wrap">
	<img id="prev" class="prev" src="http://images.ronzaro.netdna-cdn.com/pagearrow_back.png" alt="back" style="position:absolute; top:110px; z-index:999" />
    <img id="next" class="next" src="http://images.ronzaro.netdna-cdn.com/pagearrow_forward.png" alt="next" style="position:absolute; top:110px; z-index:999" />
    
	<img id="arrow-right" width="20" height="25" src="http://images.ronzaro.netdna-cdn.com/arrow-right.png" alt="next" style="position:absolute; top:320px; z-index:0; display:none" />
	<img id="arrow-left" width="20" height="25" src="http://images.ronzaro.netdna-cdn.com/arrow-left.png" alt="back" style="position:absolute; top:320px; z-index:0; display:none" />
    
	<div id="panel_wrapper">
    	<?php
		
		$theme_id = 4;
		
		$getThemeName = 'SELECT name FROM wp_terms WHERE term_id = '.$theme_id;
		$themeName = createQuery($getThemeName, $conn);
		$row = mysql_fetch_row($themeName);
		$theme_name = $row[0];
		
		$getShirtsDB = 'SELECT object_id FROM wp_term_relationships WHERE term_taxonomy_id = '.$theme_id;
		$getShirts = createQuery($getShirtsDB, $conn);
		
		$count_checker = 0;
		while ($info = mysql_fetch_array($getShirts)) {
			
			$shirt_id = $info['object_id'];
			$getShirtDB = "SELECT post_title FROM wp_posts WHERE id = ".$shirt_id;
			$getShirt = createQuery($getShirtDB, $conn);
			$row = mysql_fetch_row($getShirt);
			
			$shirt_description = $row[0];
			
			$getShirtDB = 'SELECT meta_key, meta_value FROM wp_postmeta WHERE post_id = '.$shirt_id;
			$getShirt = createQuery($getShirtDB, $conn);
			
			$description_shirt = '<ul style="padding-left:20px">';
			$description_fabric = '<ul style="padding-left:20px">';
			$description_styling_options = '<ul style="padding-left:20px">';
			$main_image = '';
			$shirt_image = '';
			$sub_image = '';
			$price = '';
			
			while ($desc = mysql_fetch_array($getShirt)) {
				if($desc['meta_key'] == 'Shirt')
					$description_shirt .= '<li>'.$desc['meta_value'].'</li>';
				else if($desc['meta_key'] == 'Fabric')
					$description_fabric .= '<li>'.$desc['meta_value'].'</li>';
				else if($desc['meta_key'] == 'Styling options')
					$description_styling_options .= '<li>'.$desc['meta_value'].'</li>';
				else if($desc['meta_key'] == 'main_image')
					$main_image = str_replace(".jpg", "-300x451.jpg", $desc['meta_value']);
				else if($desc['meta_key'] == 'shirt_image')
					$shirt_image = $desc['meta_value'];
				else if($desc['meta_key'] == 'sub_image'){
					$image_rep = str_replace(".jpg", "-300x451.jpg", $desc['meta_value']);
					$image_thumb = str_replace(".jpg", "-150x150.jpg", $desc['meta_value']);
					$sub_image .= '<img class="other_picture" src="'.$image_thumb.'" alt="'.$image_rep.'" width="40" /><img src="'.$image_rep.'" style="display:none">';
				}else if($desc['meta_key'] == 'Price')
					$price = $desc['meta_value'];
			}
			$description_shirt .= '</ul>';
			$description_fabric .= '</ul>';
			$description_styling_options .= '</ul>';
			
			if($count_checker == 0){
				$count_checker++;
				echo "<div class=\"ggpanel panel_active_0\">";
			}else if($count_checker == 1){
				$count_checker++;
				echo "<div class=\"ggpanel panel_active_1\">";
			}else if($count_checker == 2){
				$count_checker++;
				echo "<div class=\"ggpanel panel_active_2\">";
			}else{
				echo "<div class=\"ggpanel panel_inactive\">";
			}
			
			
			echo "<div class=\"description\"><strong>$shirt_description</strong><span class=\"x_close\" title=\"close panel\" alt=\"close panel\" style=\"float:right; font-size:10px; margin-right:-20px\">[ <font class=\"x_close_font\">x</font> ]</span>";
			
				echo '<div class="description_item" style="border-top:1px solid #444; margin-top:2px"><div style="float:right; width:100%"><strong>Shirt</strong><br />'.$description_shirt.'</div></div>';
				echo '<div class="description_item"><div style="float:right; width:100% "><strong>Fabric</strong><br />'.$description_fabric.'</div></div>';
				echo '<div class="description_item"><div style="float:right; width:100% "><strong>Styling options</strong><br />'.$description_styling_options.'</div></div>';
				
			//}
			echo "<div style=\"float:right; padding-top:5px\">USD <strong>$price</strong>
					<button onclick=\"document.location.href='./design.$shirt_id' ; return false;\" style=\"margin-right:-20px\" class=\"goto\">Customize</button>
				</div>"; 
			echo "</div>";
			//end of description
			
			echo "<div class=\"title\"><img src=\"http://images.ronzaro.netdna-cdn.com/browse.png\"></div>";
			
			echo '<img class="option" src="'.$main_image.'" />';
			echo '<div class="other_pictures">'.$sub_image.'</div>';
			echo '</div>';
		}
		
		?>
    </div>
</div>

<script>
$("title").html("RONZARO - <?php echo $theme_name ?>");
$("button.goto").css("border-color", "#75683C");
var width_counter = 1;
$("img").each(function(index, element) {
	var width = ($("div#progress-bar-border").css("width").substr(0,3)-4)/$("img").length;

	$(this).load(function() {
		var calc_width = (width*width_counter) + "px";
		$("div#progress_bar").css("width", calc_width);
		width_counter++;
    });
});
</script>
<script type="text/javascript" src="jquery/coverflow.js"></script>