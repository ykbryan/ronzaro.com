<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="noindex,nofollow">
<title>Ronzaro Management</title>
<link type="text/css" href="../css/base.css" rel="stylesheet" />
<link type="text/css" href="../jquery/jquery-ui-1.8.14.custom/css/dark-hive/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../jquery/jquery-ui-1.8.14.custom/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../jquery/jquery-ui-1.8.14.custom/js/jquery-ui-1.8.14.custom.min.js"></script>
<style>
td{vertical-align:text-top}
li.functionalities{padding-bottom:10px}
li.functionalities:hover{cursor:pointer; color:#CCC}
#loading_div{position:absolute; text-align:center; width:100%; height:100%}
#loading_img{color:#FFF; bottom:200px; margin-left:auto; margin-right:auto}
#loading{width:100%; height:100%; position:fixed; background:#FFF; opacity:0.3}
ul{ list-style-type:none }
li{ padding:5px }
</style>
</head>
<body>
<?php 
//CHECK THE ACCOUNT USERNAME AND PASSWORD
if(!$_SESSION['staff_id']){ 
?>
<div id="login" title="Staff Login">
	<table>
    	<tr>
        	<td width="50">username</td>
        	<td><input type="text" id="login-username" size="30" class="text ui-widget-content ui-corner-all" /></td>
        </tr>
    	<tr>
        	<td>Password</td>
        	<td><input type="password" id="login-password" size="30" class="text ui-widget-content ui-corner-all" /></td>
         </tr>
    </table>
</div>
<script>
	$("div#login").dialog({
		modal: true,
		buttons: {
			"Login": function() {
				$.ajax({
					type: 'POST',
					url: 'session/login.php',
					data: 'username='+$("input#login-username").val()+'&password='+$("input#login-password").val(),
					dataType: 'json',
					success: function(data){
						if(data.status != "OK")
							location.href = "http://www.ronzaro.com";
						else{
							location.reload();
						}
					},error: function(data){
						location.href = "http://www.ronzaro.com";
					}
				});	
			},
			Cancel: function() {
				alert("cancel");
				location.href = "http://www.ronzaro.com";
			}
		},
		close: function() {
			location.href = "http://www.ronzaro.com";
		}
	});
</script>';
<?php }
//FUNCTIONALITIES THAT A STAFF CAN DO
if($_SESSION['staff_id']){ ?>
<div id="loading_div">
    <div id="loading"></div>
    <div id="loading_img"><img src="../images/loading.gif" /><br />please wait...</div>
</div>
<img src="http://www.ronzaro.com/images/logo.png" style="padding:10px 0 10px" />
<div style="width:100%; margin:5px">
<!-- Accordion -->
<div id="functionalities" style="width:300px; float:left">
	<?php if($_SESSION['staff_id'] == "1"){ ?>
    <div>
        <h3><a href="#">Staff Account</a></h3>
        <div>
        	<li class="functionalities" id="staff_account_create">Create Account</li>
            <li class="functionalities" id="staff_account_all">View Account Status</li>
        </div>
    </div>
    <?php } ?>
    <div>
        <h3><a href="#">My Account</a></h3>
        <div>
        	<li class="functionalities" id="account_username">Change username</li>
        	<li class="functionalities" id="account_password">Change password</li>
        	<li class="functionalities" id="account_logout">Log out</li>
        </div>
    </div>
    <div>
    	<h3><a href="#">Themes</a></h3>
        <div>
        	<?php
			/*
				require_once "../config/conn.php";
				$get_themes_db = "select id, name from collection_theme ORDER BY id DESC";
				$get_themes = createQuery($get_themes_db, $conn);
				while ($info = mysql_fetch_array($get_themes)) {
					$id = $info['id'];
					$name = $info['name'];
					
					echo '<li class="functionalities themes" id="'.$id.'">';
					echo $name;
					echo '</li>';
					
				}
				*/
			?>
        </div>
    </div>
    <div>
        <h3><a href="#">Purchase</a></h3>
        <div>
        	<li class="functionalities" id="purchase_search">Search</li>
        	<li class="functionalities" id="purchase_pending">View Pending</li>
        	<li class="functionalities" id="purchase_completed">View Completed</li>
        	<li class="functionalities" id="purchase_faulty">View Faulty</li>
        </div>
    </div>
</div>

<div id="information" style="width:600px; float:left; padding-left:10px">
	<div>
    	<h3 id="information_id"><a href="#"></a></h3>
        <div id="information_div"></div>
    </div>
</div>
</div>

<?php if($_SESSION['staff_id'] == "1"){ ?>
<div id="staff_account_create_dialog" title="Create Staff Account" style="text-align:center">
	<br />
    <input type="text" placeholder="Type the username" id="staff_account_username" />
    <input type="text" placeholder="Type the password" id="staff_account_password" />
</div>
<?php } ?>

<div id="account_change_username" title="Change my username" style="text-align:center">
	<br />
    <input type="text" placeholder="Type the username" id="my_account_username" size="40" />
</div>
<div id="account_change_password" title="Change my password" style="text-align:center">
	<br />
    <input type="text" placeholder="Type the password" id="my_account_password" size="40" /><br />
    <div style="font-size:10px">the new password is visible intentionally</div>
</div>
<div id="purchase_search_dialog" title="Search" style="text-align:center">
	<br />
    <input type="text" placeholder="Enter purchase ID or customer name to begin" id="purchase_search_textbox" size="45" />
</div>


<script>
<!-- MAIN -->
$("#functionalities, #information").accordion({ header: "h3", autoHeight: false });
$("#information").hide();
$("button").button();
$(window).load(function(){
	$("div#loading_div").hide();
});
$("li").click(function(){
	$("#information").show();
	$("#information_id a").text($(this).text());
});

<!-- ACCOUNT -->
$("li#staff_account_all").click(function(){
	 $.ajax({
		type: 'POST',
		url: 'ajax/get_staff_account_all.php',
		dataType: 'json',
		success: function(data){
			$("div#information_div").fadeOut(function(){
				$(this).html(data.html).fadeIn();
			});
		}
	});
});

<?php if($_SESSION['staff_id'] == "1"){ ?>
$("div#staff_account_create_dialog").dialog({
	autoOpen: false,
	modal: true,
	width: 350,
	buttons: {
		"Create": function() { 
			var username = $("input#staff_account_username").val();
			var password = $("input#staff_account_password").val();
			 $.ajax({
				type: 'POST',
				url: 'ajax/get_staff_account_create.php',
				data: 'username='+username+'&password='+password,
				dataType: 'json',
				success: function(data){
					alert("Staff account is created");
					$("div#staff_account_create_dialog").dialog("close").dialog("refresh");; 
				}
			});
		}, 
		"Cancel": function() { 
			$(this).dialog("close"); 
		} 
	}
});
$("li#staff_account_create").click(function(){
	$("div#information_div").html("A popup will appear");
	$('div#staff_account_create_dialog').dialog('open');
	return false;

});
<?php } ?>
$("div#account_change_username").dialog({
	autoOpen: false,
	modal: true,
	width: 350,
	buttons: {
		"Change": function() { 
			var username = $("input#my_account_username").val();
			 $.ajax({
				type: 'POST',
				url: 'ajax/change_username.php',
				data: 'username='+username,
				dataType: 'json',
				success: function(data){
					alert("Log in with your new username next time");
					$("div#account_change_username").dialog("close").dialog("refresh");; 
				}
			});
		}, 
		"Cancel": function() { 
			$(this).dialog("close"); 
		} 
	}
});
$("li#account_username").click(function(e) {
    $("div#information_div").html("A popup will appear");
	$('div#account_change_username').dialog('open');
	return false;
});

$("div#account_change_password").dialog({
	autoOpen: false,
	modal: true,
	width: 350,
	buttons: {
		"Change": function() { 
			var password = $("input#my_account_password").val();
			 $.ajax({
				type: 'POST',
				url: 'ajax/change_password.php',
				data: 'password='+password,
				dataType: 'json',
				success: function(data){
					alert("Log in with your new password next time");
					$("div#account_change_password").dialog("close").dialog("refresh");; 
				}
			});
		}, 
		"Cancel": function() { 
			$(this).dialog("close"); 
		} 
	}
});
$("li#account_password").click(function(e) {
    $("div#information_div").html("A popup will appear");
	$('div#account_change_password').dialog('open');
	return false;
});
$("li#account_logout").click(function(e) {
	location.href = "logout.php";
});

<!-- THEMES -->
$("li.themes").click(function(){
	var theme_id = $(this).attr("id");
	$.ajax({
		type: 'POST',
		url: 'ajax/themes_get_shirts.php',
		data: 'id='+theme_id,
		dataType: 'json',
		success: function(data){
			$("div#information_div").html(data.html);
		}
	});
});

<!-- PURCHASE -->
$("li#purchase_faulty").click(function(){
	 $.ajax({
		type: 'POST',
		url: 'ajax/get_faulty_records.php',
		dataType: 'json',
		success: function(data){
			$("div#information_div").fadeOut(function(){
				$(this).html(data.html).fadeIn();
			});
		}
	});
});
$("li#purchase_search").click(function(e) {
    $("div#information_div").html("A popup will appear");
	$('div#purchase_search_dialog').dialog('open');
	return false;
});

$("div#purchase_search_dialog").dialog({
	autoOpen: false,
	modal: true,
	width: 350,
	buttons: {
		"Search": function() { 
			var search_query = $("input#purchase_search_textbox").val();
			 $.ajax({
				type: 'POST',
				url: 'ajax/purchase_search.php',
				data: 'search_query='+search_query,
				dataType: 'json',
				success: function(data){
					$("div#information_div").html(data.html);
					$("div#purchase_search_dialog").dialog("close").dialog("refresh");
				}
			});
		}, 
		"Cancel": function() { 
			$(this).dialog("close"); 
		} 
	}
});
$("li#purchase_search").click(function(e) {
    $("div#information_div").html("A popup will appear");
	$('div#purchase_search_dialog').dialog('open');
	return false;
});

</script>
<?php } ?>
</body>
</html>
