<?php
include "linkmanagement/config.inc.php";

$db = new PDO("sqlite:linkmanagement/db/$dbname");

if(isset($_GET['link']))
{
$link = $_GET['link'];
if(preg_match('/[^0-9]/i', $link))
{
header("Location: linkerror.php?error=noid");
exit();
}
}

$result = $db->prepare("SELECT rowid, Counter, Links FROM Links WHERE rowid = '$link' LIMIT 1");

$result->execute();
$row = $result->fetch();

if(empty($row))
{
	header("Location: linkerror.php?error=noid");
	exit();
}

$db->exec("UPDATE Links SET Counter = Counter + 1 WHERE rowid = '$link'");

header("Location: " . $row['Links']);
$db = NULL;
exit();
?>