<?php
include "config.inc.php";

if($_SESSION['logedin'] != 'sqlitelinks')
{
	header("Location: $indexpage"); 
	exit(); 
}

$rowdelete = $_GET['id']; 
if(empty($rowdelete))
{
	header("Location: $mainpage");
	exit();
}

$db = new PDO("sqlite:db/$dbname");

$db->exec("DELETE FROM Links WHERE rowid = '$rowdelete'");
$db = NULL;

header("Location: $mainpage");
exit();
?>