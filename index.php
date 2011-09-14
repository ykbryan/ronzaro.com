<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Join RONZARO's club of discerning customers who seek avant-garde designs in exclusive numbers" />
<meta name="keywords" content="RONZARO, Business Shirt, Business Shirts, Custom Shirt, Custom Shirts, Design Shirt, Design Shirts, Designer Shirt, Designer Shirts, Exclusive Shirt, Exclusive Shirts, Party Shirt, Party Shirts, Stylish Shirt, Stylish Shirts, Formal Shirt, Formal Shirts, Premium Shirt, Premium Shirts, Men Shirt, Men Shirts" /> 
<title>RONZARO - Avant Garde Design, Limited Edition, Personalization, Premium Shirts</title>
<link rel="canonical" href="http://www.ronzaro.com">
<link rel="shortcut icon" href="favicon.ico">
<?php 
if(strlen($REQUEST_URI)>100){
	header("HTTP/1.1 404 Not Found"); exit;
}

# The Last-Modified time is the newer of this script's modification time
# and the sermon contents file modification time
$this_mtime = filemtime($_SERVER['SCRIPT_FILENAME']);
$serm_mtime = filemtime("sermons/$file.sermon");
$mtime = ($this_mtime > $serm_mtime) ? $this_mtime : $serm_mtime;
$gmt_mtime = gmdate('D, d M Y H:i:s', $mtime) . ' GMT';
header("Last-Modified: " . $gmt_mtime);

# Expires time is 1s to next midnight (local time)
$etime = mktime(23-$tz,59,59,$t['mon'],$t['mday'],$t['year']);
header('Expires: '.date('D, d M Y H:i:s', $etime).' GMT');

//require_once "config/password_lock.php";
session_start(); 

include_once "includes/header.php";

if($_GET['action'] == "coverflow")
	include "coverflow2.php";
else if($_GET['action'] == "design")
	include "design2.php";
else if($_GET['action'] == "cart")
	include "shopping_cart2.php";
else if($_GET['action'] == "account"){
	if($_SESSION['id'])
		include "account.php";
	else
		include "coverflow.php";
}else if($_GET['action'] == "about")
	include "about.php";
else if($_GET['action'] == "coming")
	include "coming_soon.php";
else if(($_GET['action'] == "faq")||($_GET['action'] == "privacy")||($_GET['action'] == "terms"))
	include "info.php";
else if($_GET['action'] == "contact")
	include "contact.php";
else if($_GET['action'] == "success"){
		unset($_SESSION['cart']);
		unset($_SESSION['promotion']);
		include "main.php";
}else if($_GET['action'] == "cancel"){
	echo "<script>alert(\"Sorry, we are unable to process your payment via paypal.\");</script>";
	include "coverflow.php";
}
else
	include "main.php";

include_once "includes/bottom.php" 

?>

<script>
$("button").button();
$(".ui-button").css("height", "20px").css("padding", "0px 10px 0px 10px");
$(".ui-button-text-only .ui-button-text").css("font-size", "11px");


var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-24580239-2']);
_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();


$(function(){
	var ronzaro_height = parseInt($("div.top").css("height")) + parseInt($("div#wrap").css("height")) + parseInt($("div.bottom").css("height"));
	var document_height = parseInt($(document).height());
	if(document_height > ronzaro_height){
		var padding_top = (document_height - ronzaro_height) / 2;
		var existing_padding_top = parseInt($("div.top").css("padding-top"));
		$("div.top").css("padding-top", padding_top+"px");
	}
});
</script>
</body>
</html>