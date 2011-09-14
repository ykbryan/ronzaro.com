<?php

if(!$_GET['action'])
	echo "<script>location.href = './' </script>";

?>

<style>
#wrap{ width:100%;min-height:450px;overflow:hidden;float:left;display:none}
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

<div id="wrap">
    <table style="margin:0px; border-spacing:0px; width:100%"><tr>
    	<td style="background:url(http://images.ronzaro.netdna-cdn.com/about_left.png) repeat-x; width:50%"></td>
        <td>
        <div style="position:absolute; width:400px; z-index:10; margin-left:10px; color:#333; margin-top:70px; font-size:13px"> 
           <h1>about Ronzaro</h1><br />
            <p style="font-size:14px;">Subtly Stylish Fashion</p><br />
            <p>RONZARO is a trendy luxury label reaching out to customers worldwide solely via the web.</p>
            <p style="padding-top:10px">We believe that bona fide luxury should be tailored to each individual. We pride ourselves in allowing you to personalize details without compromising the overall design of the article. Maintaining the hallmark of a luxury label, each collection is only available in limited quantities to maintain exclusivity.</p>
            <p style="padding-top:10px">Our collections follow themes that are inspired are drawn from everyday life. We utilize the most basic human instincts and add fine touches to create unorthodox designs.</p><br />
            <p style="padding-top:10px">It's time you open <a href="./coverflow" style="color:#333; font-weight:bold">pandora's box</a>.
            </p>
        </div>
        <img src="http://images.ronzaro.netdna-cdn.com/about_.jpg" height="500">
        </td>
        <td style="background:url(http://images.ronzaro.netdna-cdn.com/about_right.png) repeat-x; width:50%"></td>
    </tr></table>
</div>

<img src="images/about_left.png" style="display:none" alt="none">
<img src="images/about_right.png" style="display:none" alt="none">

<script>
$("title").html("RONZARO - About us");
</script>