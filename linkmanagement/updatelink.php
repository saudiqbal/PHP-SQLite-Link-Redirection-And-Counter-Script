<?php
include "config.inc.php";
if($_SESSION['logedin'] != 'sqlitelinks')
{
	header("Location: $indexpage"); 
	exit(); 
}

$db = new PDO("sqlite:db/$dbname");

if(isset($_POST['linkid']))
{
	$linkid = $_POST['linkid'];
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
if(isset($_POST['counter']))
{
	$Counter = $_POST['counter'];
}
if(isset($_POST['link']))
{
	$links = $_POST['link'];
}

$db->exec("UPDATE Links SET Counter = '$Counter', Links = '$links' WHERE rowid = '$linkid'");

header("Location: $mainpage");
$db = NULL;
exit();
?>