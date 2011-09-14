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
	text-align:center
}
li{
	list-style:square;
	font-size:11px
}
td{
	vertical-align:text-top
}
</style>

</head>

<body>

<script>
<?php
	echo '$(window).load(function() {
				$("div.top, div.bottom").show();
				$("div#loading-bar").css("width", "200px").hide();
				$("input").addClass("text ui-widget-content ui-corner-all");
				$("textarea").addClass("text ui-corner-all").css("background", "#000");
				$("button").button();
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
    <div class="content" style="width:900px; background-image:url(images/bg_box.png); text-align:left; margin:10px; padding:10px; margin-left:auto; margin-right:auto">
    <table style="width:100%; border-spacing:10px"><tr>
        <td style="border-right:1px solid #333; padding:10px 0px 10px 30px; width:50%">
            <h1>Feedback form</h1><br />
            <table>
                <tr><td>Name</td><td><input type="text" id="sender_name" size="40"></td></tr>
                <tr><td>Email</td><td><input type="text" id="sender_email" size="40"></td></tr>
                <tr><td colspan="2"><textarea cols="54" rows="20" id="sender_feedback"></textarea></td></tr>
                <tr><td style="text-align:right" colspan="2">
                    <img src="images/loadingbar.gif" class="ajax-load" style="display:none">
                    <button id="send">Submit</button>
                </td></tr>
            </table>
            
        </td>
        <td style="padding:10px 0px 10px 20px; vertical-align:text-top">
        <h1>Contact us</h1>
        <p><br />
        If you need help in:
            <li>Placing an order</li>
            <li>Tracking your purchase</li>
            <li>Arranging your return or exchange</li>
            <li>Choosing the right size and fit</li>
            <li>Managing your Ronzaro account</li>
        </p><br />
        You can also ask a question by dropping us a message now and<br />we will reply you within the next 12 hours.
            
        </td>
    
    </tr></table>
    </div>
</div>

<script type="text/javascript">
$("img.ajax-load").ajaxStart(function() {
	$(this).show();
	$("button").button("option", "disabled", true);
});
$("img.ajax-load").ajaxStop(function() {
	$(this).hide();
	$("button").button("option", "disabled", false);
});
$("button#send").click(function(){
	
	if(($("input#sender_email").attr("value") == "")||($("input#sender_name").attr("value") == "") || ($("textarea#sender_feedback").attr("value") == "")){
		alert("please fill up the form");
		return false;
	}
	
	$.ajax({
		type: 'POST',
		url: 'session/send_feedback.php',
		data: 'email='+$("input#sender_email").attr("value")+'&name='+$("input#sender_name").attr("value")+'&feedback='+$("textarea#sender_feedback").attr("value"),
		dataType: 'json',
		success: function(data){
			if(data.status != "OK")
				alert("oops! please try again later...");
			else{
				alert("thank you for your feedback. we will contact you shortly");
				window.location.href = "./coverflow";
			}
		},
		error: function(){
			alert("oops! please try again later...");
		}
	});
});

$("title").html("RONZARO - Contact us");
</script>