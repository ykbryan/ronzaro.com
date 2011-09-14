<?php

if(!$_GET['action'])
	echo "<script>location.href = './' </script>";

?>

<style type="text/css">
#wrap{
	width:100%;
	min-height:450px;
	overflow:hidden;
	background-image:url(images/bkg_wood.jpeg);
	float:left;
	display:none
}
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
<div id="wrap">
	<table style="margin:0px; border-spacing:0px; width:100%"><tr>
    	<td style="background:url(http://images.ronzaro.netdna-cdn.com/about_0.png) repeat-x; width:50%; padding:0px"></td>
        <td style="padding:0px">
            <div style="position:absolute; width:470px; z-index:10; margin-left:200px; color:#333; margin-top:100px; font-size:13px">
            
            	<h1>Coming soon - <strong>Summer Rage</strong></h1>
            	<br /><br />
                Express your energy with clean cuts and sharp colours!
                <br /><br /><br />
                May we update you on new releases and exclusive offers? 
                <br />
                Leave your name & email and we will let keep you posted.
                <br /><br />
                <table>
                    <tr><td>Name</td><td><input id="email_name" type="text" size="40"></td></tr>
                    <tr><td>Email</td><td><input id="email_address" type="text" size="40"></td></tr>
                </table>
                <br />
                <button id="subscribe">Subscribe</button>
            </div>
        	<div style="overflow:hidden; padding:0px"><img src="http://images.ronzaro.netdna-cdn.com/about_1.png" height="500"></div>
        </td>
        <td style="background:url(http://images.ronzaro.netdna-cdn.com/about_2.png) repeat-x; width:50%"></td>
    </tr></table>
</div>

<img src="http://images.ronzaro.netdna-cdn.com/about_0.png" style="display:none" alt="none">
<img src="http://images.ronzaro.netdna-cdn.com/about_1.png" style="display:none" alt="none">
<img src="http://images.ronzaro.netdna-cdn.com/about_2.png" style="display:none" alt="none">

<script>
$("button").button();
$("input").addClass("text ui-widget-content ui-corner-all");

var width_counter = 1;
$("img").each(function(index, element) {
	var width = ($("div#progress-bar-border").css("width").substr(0,3)-4)/$("img").length;

	$(this).load(function() {
		var calc_width = (width*width_counter) + "px";
		$("div#progress_bar").css("width", calc_width);
		width_counter++;
    });
});

$("button#subscribe").click(function(){
	if(!$("input#email_name").attr("value")){
		alert("please enter your name");
		return false;
	}else if(!$("input#email_address").attr("value")){
		alert("please enter your email");
		return false;
	}
	$.ajax({
		type: 'POST',
		url: 'session/add_to_mailing_list.php',
		data: 'name='+$("input#email_name").attr("value")+'&email='+$("input#email_address").attr("value"),
		dataType: 'json',
		success: function(data){
			if(data.status == "OK"){
				
				$("div#message span").html("<br /><br />Thank you for joining us");
				$("div#message").attr("title", "Mailing List");
				
				$("div#message").dialog({
					hide: "explode",
					modal: true
				});
			}else if(data.status == "update"){
				$("div#message span").html("<br /><br />Thank you for signing up with us. We note that you are already an existing subscriber and will keep you updated.");
				$("div#message").attr("title", "Mailing List");
				
				$("div#message").dialog({
					hide: "explode",
					modal: true
				});
			}else{
				alert("oops! please try again later...");
			}
			$("input#email_name, input#email_address").attr("value", "");
		},
		error: function(){
			alert("oops! please try again later...");
		}
	});
});

$("title").html("RONZARO - Summer Rage");
</script>