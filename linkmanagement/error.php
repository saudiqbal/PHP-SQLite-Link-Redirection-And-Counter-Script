<?php
ob_start("ob_gzhandler");
	
if (isset($_GET['error']))
$PAGES = $_GET['error'];

// Default
else $PAGES = 'blank';

switch ($PAGES)
{
// Blank 
	case 'blank': 
		$error = 'No Error Detected'; 
	break;

// No Title
	case 'noid': 
		$error = 'Invalid link ID'; 
	break;

// No Notes
	case 'nolink': 
		$error = 'Link cannot be empty'; 
	break;

// Default
	default: 
		$error = 'No Error Detected'; 
	break;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Error</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="robots" content="noindex, nofollow" />
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
	height: 25px;
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
<div class="new_lifted" style="width:550px; height:25px;">
<div style="text-align: center;font-size:24px;"><?php echo("$error"); ?></div>
</div>
</div>
</body>
</html>