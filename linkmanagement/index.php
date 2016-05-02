<?php
include "config.inc.php";
ob_start("ob_gzhandler");

if(isset($_POST['submit']))
{

$error = 0;

if (isset($_POST['username']))
{
	$username = $_POST['username'];
}
if (isset($_POST['password']))
{
	$password = $_POST['password'];
}
if(empty($username))
{
	$username = 1;
}
if(empty($password))
{
	$password = 1;
}

if($username == "admin" && $password == "adminpassword")
{
	$_SESSION['logedin'] = 'sqlitelinks';
	
	// Redirect to the page
	header("Location: $mainpage");
	exit();
}
else
{
	$error == 1;
	$errormessage = 'Invalid Username or Password';
}

}
?>
<!DOCTYPE html>
<html>
<head>
<title>Link Management</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<style type="text/css">
body {
	background: #f4f4f4;
}
.new_lifted {
	border-radius:2px;
	position:relative;
	padding:1em;
	background:#fcfcfc;
	box-shadow: 0px 0px 1px 1px rgba(0,0,0,0.2);
	-o-box-shadow: 0px 0px 1px 1px  rgba(0,0,0,0.2);
	-moz-box-shadow: 0px 0px 1px 1px  rgba(0,0,0,0.2);
}
.new_lifted:before, .new_lifted:after {
	content: "";
	position: absolute;
	z-index: -1;
	-ms-transform: skew(-3deg,-2deg);
	-webkit-transform: skew(-3deg,-2deg);
	-o-transform: skew(-3deg,-2deg);
	-moz-transform: skew(-3deg,-2deg);
	bottom: 14px;
	box-shadow: 0 15px 5px rgba(0, 0, 0, 0.3);
	height: 50px;
	left: 1px;
	max-width: 50%;
	width: 50%;
}
.new_lifted:after {
	-ms-transform: skew(3deg,2deg);
	-webkit-transform: skew(3deg,2deg);
	-o-transform: skew(3deg,2deg);
	-moz-transform: skew(3deg,2deg);
	left: auto;
	right: 1px;
}
.div{
	bottom: 0;
	height: 100px;
	left: 0;
	margin: auto;
	position: absolute;
	top: 0;
	right: 0;
	width: 550px;
}
</style>
</head>
<body>
<div class="div">
<div class="new_lifted" style="width:550px; height:100px;">
<form method="post" id="login" action="index.php">
<div style="text-align:center;border-bottom: 1px solid #E8E8E8;"></div>
<div style="text-align:center;padding-top:20px;">
Username: <input id="username" name="username" tabindex="1" type="text" />
Password: <input id="password" name="password" tabindex="2" type="password" />
<input type="submit" name="submit" id="submit" tabindex="4" value="Log in" />
</div>
</form>
</div>
</div>
<script type="text/javascript">
//<![CDATA[
<!--
document.getElementById("username").focus();
//-->
//]]>
</script>
</body>
</html>