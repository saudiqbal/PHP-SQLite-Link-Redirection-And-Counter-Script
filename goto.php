<?php
include "linkmanagement/config.inc.php";

$db = new PDO("sqlite:linkmanagement/db/$dbname");

if(isset($_GET['page']))
{
$page = $_GET['page'];
if(preg_match('/[^0-9]/i', $page))
{
header("Location: linkerror.php?error=noid");
exit();
}
}

$result = $db->prepare("SELECT rowid, Counter, Links FROM Links WHERE rowid = '$page' LIMIT 1");

$result->execute();
$row = $result->fetch();

if(empty($row))
{
	header("Location: linkerror.php?error=noid");
	exit();
}

$db->exec("UPDATE Links SET Counter = Counter + 1 WHERE rowid = '$page'");

header("Location: " . $row['Links']);
$db = NULL;
exit();
?>