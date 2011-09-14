<?php
session_start();

if(!$_SESSION['pass']){
echo '<script type="text/javascript">
var login = 0;
var today = new Date();
while(login==0){
	var pw=prompt("Enter the access password",today);
	
		
	var pass;
	pass = "blues";
	
	if(pw==pass){
		login=1;
	}else
		location.href="http://www.google.com/";
}
</script>';
}

$_SESSION['pass'] = "ok";

?>