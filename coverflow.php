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
.x_close:hover, x_close_font:hover{color:#75683C;cursor:pointer}
</style>
</head>
<body>

<script>
<?php
	$theme_id = 2;
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
<header>
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
</header>
<h1 style="display:none">RONZARO Designs</h1>
<div id="wrap">
	<img id="prev" class="prev" src="images/pagearrow_back.png" alt="back" style="position:absolute; top:110px; z-index:999" />
    <img id="next" class="next" src="images/pagearrow_forward.png" alt="next" style="position:absolute; top:110px; z-index:999" />
    
	<img id="arrow-right" width="20" height="25" src="images/arrow-right.png" alt="next" style="position:absolute; top:320px; z-index:0; display:none" />
	<img id="arrow-left" width="20" height="25" src="images/arrow-left.png" alt="back" style="position:absolute; top:320px; z-index:0; display:none" />
    
	<div id="panel_wrapper">
    	<?php
		
		$getThemeName = "SELECT name FROM collection_theme WHERE id = $theme_id";
		$themeName = createQuery($getThemeName, $conn);
		$row = mysql_fetch_row($themeName);
		$theme_name = $row[0];
		
		$getShirtDB = "SELECT c.id, c.description, c.price, c.name FROM collection_shirt c WHERE c.collection_theme_id = $theme_id order by c.id asc";
		$getShirt = createQuery($getShirtDB, $conn);
		
		$count_checker = 0;
		while ($info = mysql_fetch_array($getShirt)) {
			$shirt_id = $info['id'];
			$name = $info['name'];
			$shirt_description = $info['description'];
			$price = $info['price'];
			
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
			
			//start of description
			$getDescriptionDB = "SELECT id, name, description, image FROM collecton_description WHERE collection_shirt_id = $shirt_id";
			$getDescription = createQuery($getDescriptionDB, $conn);
			echo "<div class=\"description\"><strong>$shirt_description</strong><span class=\"x_close\" title=\"close panel\" alt=\"close panel\" style=\"float:right; font-size:10px; margin-right:-20px\">[ <font class=\"x_close_font\">x</font> ]</span>";
			$count = 0;
			while ($description = mysql_fetch_array($getDescription)) {
				$description_id = $description['id'];
				$description_name = $description['name'];
				$description_text = $description['description'];
				$description_image = $description['image'];
				
				echo "<div class=\"description_item\"";
				
				if($count == 0)
					echo "style=\"border-top:#444 solid 1px\"";
				
				echo " >";
				if($description_image)
					echo "<img src=\"$description_image\" class=\"description-img\" width=\"70\" style=\"position:absolute\" />";
					
				echo "<div style=\"float:right; ";
				if(!$description_image)
					echo "width:100%";
				else
					echo "width:275px";
				
				echo "\"><strong>$description_name</strong><br />$description_text</div>
				</div>";
				$count++;
			}
			echo "<div style=\"float:right; padding-top:5px\">USD <strong>$price</strong>
					<button onclick=\"document.location.href='./design.$shirt_id' ; return false;\" style=\"margin-right:-20px\" class=\"goto\">Customize</button>
				</div>"; 
			echo "</div>";
			//end of description
			
			echo "<div class=\"title\"><img src=\"images/browse.png\"></div>";
			
			//start of gallery
			$getGalleryDB = "SELECT image, big_image FROM collection_gallery WHERE collection_shirt_id = $shirt_id ORDER BY main DESC LIMIT 5";
			$getGallery = createQuery($getGalleryDB, $conn);
			
			$count_gallery = 0;
			while ($gallery = mysql_fetch_array($getGallery)) {
				if($count_gallery == 0){
					echo "<img class=\"option\" src=\"$gallery[0]\" width=\"300\" height=\"450\" />";
				}else if($count_gallery == 1){
					echo "<div class=\"other_pictures\">";
				}
				if($count_gallery > 0)
					echo "<img class=\"other_picture\" src=\"$gallery[0]\" width=\"40\" height=\"55\" />";
				$count_gallery++;
			}
			if($count_gallery > 1)
				echo "</div>";
			//end of gallery
			
			echo "</div>";
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
$(document).ready(function() {
	$('.jqzoom').jqzoom({
		title: false,
		zoomType: 'innerzoom',
		lens:true,
		preloadImages: false,
		alwaysOn:false
	});
});
</script>
<script type="text/javascript" src="jquery/coverflow.js"></script>