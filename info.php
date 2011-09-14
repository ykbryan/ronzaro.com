<?php

if(!$_GET['action'])
	echo "<script>location.href = './' </script>";

require_once "config/conn.php";

//get info
$getInfoDB = "select id, name, description from information_type WHERE short_name = '".$_GET['action']."'";
$getInfo = createQuery($getInfoDB, $conn);

$row = mysql_fetch_row($getInfo);
$info_id = $row[0];
$info_name = $row[1];
$info_description = $row[2];

?>
<style>
#wrap{
	width:100%;
	overflow:hidden;
	float:left;
	text-align:center;
	display:none
}
li.link{
	list-style:square;
	font-size:11px;
	text-indent:-10px;
	padding-right:10px;
	color:#999
}
li.link:hover{cursor:pointer;color:#FFF}
#answers li{list-style:square}
#answers li:hover{cursor:default}
td{vertical-align:text-top}
</style>
</head>
<body>
<script>
var width_counter = 1;
$("img").each(function(index, element) {
	var width = ($("div#progress-bar-border").css("width").substr(0,3)-4)/$("img").length;
	
	$(this).load(function() {
		var calc_width = (width*width_counter) + "px";
		$("div#progress_bar").css("width", calc_width);
		
		width_counter++;
    });
});

<?php
	echo '$(window).load(function() {
			$("div#wrap").hide();
			$("div#progress_bar").css("width", "200px");
			$("div#loading-bar").fadeOut(1000, function(){
				$("div.top, div.bottom, div#wrap").fadeIn();
				var pane = $("#answers");
					pane.jScrollPane({
						showArrows: false,
						animateScroll: true
					});
				var api = pane.data("jsp");
				
				$("li.link").click(function(){
					var id = $(this).attr("id");
					$("div.link_question").css("color", "#666");
					$("div#question_"+id).stop().animate({ color: "#FFF" }, 1000);
				});
				$(".link").bind("click", function(){
						api.scrollToY($(this).attr("rel"));
						return false;
					}
				);
				$("li.link").each(function(){
					var id = $(this).attr("id");
					var count = 0;
					var height = 0;
					while(count!=id){
						height += parseInt($("div#question_"+count).css("height"));
						count++;
					}
					$(this).attr("rel", height);
				});
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
<div id="wrap">
        <div class="content" style="width:1000px; overflow:auto; background-image:url(images/bg_box.png); text-align:left; margin:10px; padding:10px; margin-left:auto; margin-right:auto">
        
        	
            <div style="padding-bottom:10px; border-bottom:1px solid #999;">
            	<h1><?php echo $info_name ?></h1>
                <span style="font-style:italic; font-size:9px">last updated on 20 july 2011</span>
                <table style="margin-left:10px"><tr><td width="245" valign="top">
                <?php 
					//get info
					$getDataDB = "select id, group_name, question, custom from information WHERE information_type_id = $info_id";
					$getData = createQuery($getDataDB, $conn);
                	
					$table_counter = 0;
					$question_id = 0;
					$last_group_name = "";
					$num_of_groups = 0;
					
					while ($info = mysql_fetch_array($getData)) {
						
						//$question_id = $info['id'];
						$group_name = $info['group_name'];
						$question = $info['question'];
						$position = $info['custom'];
						
						if($group_name != $last_group_name){
							if(($table_counter!=0)&&($num_of_groups!=3)/*&&($table_counter>3)*/){
								if($num_of_groups == 0)
									$width_space = 260;
								else
									$width_space = 235;
								echo "</td><td width=\"$width_space\" valign=\"top\">";
								$table_counter = 0;
								$num_of_groups++;
							}
							$last_group_name = $group_name;
							
							echo "<div style=\" margin-left:-12px; color:#CCC; ";
							if($table_counter != 0)
								echo "padding-top:10px;";
							echo "\">$group_name</div>";
						}
					
						if(($table_counter!=0)&&!$last_group_name&&($table_counter%4==0))
							echo "</td><td width=\"245\" valign=\"top\">";
							
						echo "<li id=\"$question_id\" class=\"link\">".$question."</li>";
						
						$table_counter++;
						$question_id++;
						
					}
				?>
                </td></tr></table>
                <p><?php echo $info_description ?></p>
            </div>
            
            <div id="answers" style="width:100%; overflow:auto; height:375px; padding-bottom:100px">
            	
                <?php
				$getDataDB = "select id, group_name, question, answer from information WHERE information_type_id = $info_id";
				$getData = createQuery($getDataDB, $conn);
				
				$last_group_name = "";
				$question_id = 0;
				while ($info = mysql_fetch_array($getData)) {
					//$question_id = $info['id'];
					$group_name = $info['group_name'];
					$question = $info['question'];
					$answer = $info['answer'];
					
					echo '<div class="link_question" id="question_'.$question_id.'" ';
					if($group_name && ($group_name != $last_group_name)){
						echo 'class="link_first">';
						echo "<span style=\"color:#AAA; font-size:12px\">$group_name</span>";
						$last_group_name = $group_name;
					}else
						echo ">";
					
					echo "<p><strong style=\"color:#999\">Q: $question</strong><br />A: $answer<br /><br /></p></div>";
					
					$question_id++;
				}
				
				?>
            </div>
        </div>
    </center>
</div>

<script>
$("title").html("RONZARO - <?php echo $info_name ?>");
</script>