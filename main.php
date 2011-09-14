<style>
#wrap{
	width:100%;
	min-height:450px;
	overflow:hidden;
	background-color:#000000;
	float:left;
	display:none;
}
.img_button{
	border:1px solid #DEDCDF; 
	padding:5px; 
	float:left;
	opacity:0.7;
}
.img_button:hover{
	border-color:#FFF;
	cursor:pointer;
	opacity:1;
}
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
					$("div#loading-bar").delay(800).fadeOut(2000, function(){';
				
	if($_GET['action'] == "success")
		echo '$("div#purchase_success").dialog({
					hide: "explode",
					height: 200,
					width: 400,
					modal: true
				});';
					
echo '			$("div.top, #wrap").fadeIn(1000, function(){
					$("div.bottom").fadeIn(500);
					});
				});
			});';
		
	
?>
</script>
 
<header>
    <!-- Loading Div --> 
    <div id="loading-bar"> 
        <div style="width:650px; color:#AAA; font-size:14px; margin-left:auto; margin-right:auto">
            "Life shrinks or expands in proportion to one's courage" - Anais Nin
            <br /><br />
            <div id="progress-bar-border" style="height:10px; width:204px; border:#888 solid 1px; margin-left:auto; margin-right:auto">
                <div id="progress_bar" style="background-color:#FFF; height:6px; margin-top:2px; margin-left:2px; width:0px">
                
                </div>
            </div>
        </div>
    </div> 
    
    <?php include_once "includes/top.php" ?>
</header>

<h1 style="display:none">Welcome to RONZARO</h1>
<img src="images/landing_bg_left.jpg" style="display:none" alt="none">
<img src="images/landing_bg.png" style="display:none" alt="none">


<div id="wrap">
    <table style="margin:1px 0px 1px 0px; border-spacing:0px; width:100%">
    	<tr>
        	<td style="background:url(http://images.ronzaro.netdna-cdn.com/landing_bg_left.jpg) repeat-x; width:50%"></td>
            <td>
            	<div style="width:1024px; overflow:hidden; height:500px; float:right">
                    <img src="http://images.ronzaro.netdna-cdn.com/landing.jpg" alt="Welcome to RONZARO">
                </div>
                <!--
                <div style="position:absolute; margin-left:655px; margin-top:470px;">
                    <g:plusone></g:plusone>

					<script>
                      window.___gcfg = {
                        lang: 'en-US'
                      };
                
                      (function() {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/plusone.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                      })();
                    </script>
                </div>
                -->
                <div style="position:absolute; margin-left:495px; margin-top:300px; width:450px">
                    <a href="./coverflow">
                    <div class="img_button">
                        <img src="images/button1.jpg" style="border:0px; width:200px" alt="Latest collection">
                        <div style="position:absolute; bottom:5px; width:200px; height:15px; color:#C93; background-color:#000; opacity:0.8; text-align:center">
                            Latest collection
                        </div>
                    </div>
                    </a>
                    <a href="./coming">
                    <div style="margin-left:10px" class="img_button">
                        <img src="images/button2.jpg" style="border:0px; width:200px" alt="Coming soon">
                        <div style="position:absolute; bottom:5px; width:200px; height:15px; color:#C93; background-color:#000; opacity:0.8; text-align:center">
                            Coming soon
                        </div>
                    </div>
                    </a>
                </div>
            </td>
            <td style="background:url(http://images.ronzaro.netdna-cdn.com/landing_bg.png) repeat-x; width:50%"></td>
        </tr>
    </table>
</div>

<div id="purchase_success" title="Thank you for purchasing with us!" style="display:none">
    Thank you.
    <br /><br />
    We have sent an email that includes the your purchase ID (PID). We will update you the status of your purchase via email or your account (if you have registered an account with us).
    <br /><br />
    For enquries, please contact us at <a href="mailto:customercare@ronzaro.com"><i><u>customercare@ronzaro.com</u></i></a>
</div>