<div class="top">
    <div style="width:981px; margin-left:auto; margin-right:auto">
        <a href="./" style="padding-left:0px; float:left; margin-top:8px" id="logo">
            RONZARO
        </a>
        <ul>
            <li><a href="./">home</a></li>
            <li><a href="http://www.ronzaro.com/news/">News</a></li>
            <li id="collection"><a href="./coverflow">collections <img src="../images/arrow_right.png" style="opacity:0.5; border:0px; width:6px" alt=">" /></a></li>
        </ul>
        <div id="collections" style="position:absolute; padding:10px; margin-top:17px; margin-left:400px; display:none; z-index:99; background: none">
            <a href="./coverflow">:: MONDAY BLUES</a>
        </div>
        
        <ul style="float:right; padding-right:0px">
            <li><a id="login">sign up / login</a></li>
            <li><a id="account" href="./account" style="display:none">welcome! <u><?php echo $_SESSION['name'] ?></u></a></li>
            <li><a href="./cart">my cart <span id="items_in_cart">
            
            <?php
                require_once "class/shirt.php";
    
                if($_SESSION['cart'] > 0){
                    $items = 0;
                    foreach($_SESSION['cart'] as $key=>$value){
                        $new_shirt = new shirt();
                        $new_shirt = unserialize($value);
                    
                        $items++;
                    }
                    
                    echo "( $items item";
                    if($items > 1)
                        echo "s";
                    echo " )";
                }
            ?>
            </span>
            </a>
            </li>
         </ul>
    </div>
</div>

<div id="account_message" title="" style="font-size:11px; display:none; text-align:center">
	<span></span>
</div>

<div id="login_panel" title="RONZARO Account" style="font-size:11px; display:none; text-align:center; vertical-align:middle">
    
    <table style="padding-top:10px; text-align:center; width:100%; height:90%;"><tr>
    	<td style="border-right:1px solid #666; vertical-align:middle; width:50%">
        	<p style="font-size:12px; color:#FFFFFF">Create an account</p>
        	<table style="padding-left:5px;font-size:11px">
                <tr><td>Name </td><td><input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" size="27" /></td></tr>
                <tr><td>Email </td><td><input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all" size="27" /></td></tr>
                <tr><td>Password </td><td><input type="password" name="newpassword" id="newpassword" value="" class="text ui-widget-content ui-corner-all" size="27" /></td></tr>
                <tr><td>Type it again</td><td><input type="password" name="repassword" id="repassword" value="" class="text ui-widget-content ui-corner-all" size="27" /></td></tr>
                <tr><td></td><td><button id="register" style="float:right">Register</button></td></tr>
            </table>
            <img id="login_loading" src="../images/loadingbar.gif" style="display:none" alt="loading..." />
        </td><td style="width:50%; vertical-align:middle;">
        	<p style="font-size:12px; color:#FFFFFF; padding-left:15px; margin-top:-40px">Account sign in</p>
            <table style="padding-left:20px; font-size:11px; text-align:center">
                <tr>
                    <td style="width:70px">Email </td><td><input id="login_email" type="text" class="text ui-widget-content ui-corner-all" size="30" style="float:right" /></td>
                </tr>
                <tr>
                    <td>Password </td><td><input id="password" type="password" class="text ui-widget-content ui-corner-all" size="30" style="float:right" /></td>
                </tr>
                <tr>
                	<td></td><td><button id="login" style="float:right">Login</button></td>
                </tr>
            </table>
        </td>
    </tr></table>
</div>

<script type="text/javascript">
$( "div#login_panel, div#create" ).dialog("destroy").hide();

<?php
	if($_SESSION['id']){
		echo "$(\"a#login\").hide();";
		echo "$(\"a#account\").show();";
	}

?>

$("a#login").click(function(){
	$("a#register").text("signup now.").show();
	$("img#login_loading").hide();
	$("input#login_email").attr("value", "");
	$("input#password").attr("value", "");
	
	$("div#login_panel").dialog({
		hide: "explode",
		height: 250,
		width: 650,
		modal: true
	});
});

$("button#login").click(function(){
	if(($("input#login_email").attr("value") == "") || ($("input#password").attr("value") == "")){
		alert("Please enter all fields");
		$("input#login_email").focus();
	}else{
		
		var email = $("input#login_email").attr("value");
		var password = $("input#password").attr("value");
		
		if((email.length)&&(password.length)){
			
			$("img#login_loading").show();
			$.ajax({
				type: 'POST',
				url: 'session/login.php',
				data: 'email='+email+'&password='+password,
				dataType: 'json',
				success: function(data){
					
					$("img#login_loading").hide();
					
					if(data.status == "OK"){
						$("input#shipping_email").attr("value", email);
						$("button#measurement_existing").button("option", "disabled", false);
						$("a#account").find("u").text(data.name);
						$("a#login").hide();
						$("a#account").show();
						
						$("div#account_message span").html("<br /><br />Welcome back, "+data.name+". <br /><br />[ <a href=\"./coverflow\">Click here to browse Latest Collection</a> ]");
						$("div#account_message").attr("title", "Login");
						
						$("div#account_message").dialog({
							hide: "explode",
							modal: true
						});
						$("div#login_panel").dialog("destroy");
					}else{
						$("input#password").attr("value", "");
						$("input#login_email").focus();
						alert("You have entered the incorrect email/password.");
					}
				},
				error: function(data){
					
					$("img#login_loading").hide();
					alert("Oops! please try again later...");
					$("div#login_panel").dialog("destroy");
				}
			});
		}else{
			alert("Please fill up your email and password");
		}
	
	}
});

$("button#register").click(function(){
	if(($("input#name").attr("value") == "") || ($("input#email").attr("value") == "") || ($("input#newpassword").attr("value") == "")){
		alert("please enter all fields");
		$("input#name").focus();
	}else{
		if($("input#newpassword").attr("value") == $("input#repassword").attr("value")){
			var name = $("input#name").attr("value");
			var email = $("input#email").attr("value");
			var password = $("input#newpassword").attr("value");
			
			
			$("img#login_loading").show();
			$.ajax({
				type: 'POST',
				url: 'session/create.php',
				data: 'name='+name+'&email='+email+'&password='+password,
				dataType: 'json',
				success: function(data){
					if(data.status == "OK"){
						$("input#shipping_email").attr("value", email);
						$("button#measurement_existing").button("option", "disabled", false);
						$("a#account").find("u").text(name).show();
						$("a#account").show();
						$("a#login").hide();
						$("div#login_panel").dialog("close");	
						
						$("div#account_message span").html("<br /><br />Welcome to the world of fashion. <br /><br />[ <a href=\"./coverflow\">Click here to browse Latest Collection</a> ]");
						$("div#account_message").attr("title", "Registration");
						
						$("div#account_message").dialog({
							hide: "explode",
							modal: true
						});
					}else{
						alert("The email has been used");
						$("input#email").focus();
					}
					
					$("img#login_loading").hide();
				},
				error: function(data){
					$("img#login_loading").hide();
					alert("Oops! please try again later...");
					$("div#login_panel").dialog("destroy");
				}
			});
		}else{
			alert("Please re-enter your password...");
			$("input#newpassword, input#repassword").attr("value", "");
			$("input#newpassword").focus();
		}	
	}
});

$("li").hover(function(){
	if($(this).attr("id") == "collection")
		$("div#collections").show();
	else
		$("div#collections").hide();
});
$("div#collections").mouseleave(function(){
	$("div#collections").hide();
});

</script>