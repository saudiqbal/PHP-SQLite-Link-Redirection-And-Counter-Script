<?php
include "config.inc.php";
ob_start("ob_gzhandler");
if($_SESSION['logedin'] != 'sqlitelinks')
{
	header("Location: $indexpage"); 
	exit(); 
}

$db = new PDO("sqlite:db/$dbname");

if(isset($_GET['linkid']))
{
	$linkid = $_GET['linkid'];
	if(preg_match('/[^0-9]/i', $linkid))
		{
			header("Location: error.php?error=noid");
			exit();
		}
}
else
{
	$linkid=0;
}

$result = $db->prepare("SELECT rowid, Counter, Links FROM Links WHERE rowid = '$linkid' LIMIT 1");
$result->execute();
$row = $result->fetch();
$db = NULL;
if(empty($row))
{
	header("Location: error.php?error=noid");
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Update Link</title>
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
	height: 150px;
	left: 0;
	margin: auto;
	position: absolute;
	top: 0;
	right: 0;
	width: 800px;
}
</style>
</head>
<body>
<div class="div">
<div class="new_lifted" style="width:800px; height:150px;">
<form method="post" id="login" action="updatelink.php">
<input type="hidden" name="linkid" value="<?php echo $row['rowid']; ?>">
<div style="text-align:center;border-bottom: 1px solid #E8E8E8;">Update</div>
<div style="text-align:left;padding-top:20px;">
Link: <input id="link" name="link" type="text" value="<?php echo $row['Links']; ?>" size="100" /><br />
Counter: <input id="counter" name="counter" type="number" value="<?php echo $row['Counter']; ?>" size="25" /><br />
<input type="submit" name="submit" id="submit" value="Update" /> &nbsp;&nbsp;&nbsp;&nbsp;<a href="main.php">Back</a>
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