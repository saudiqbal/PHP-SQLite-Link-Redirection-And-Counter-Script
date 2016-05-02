<?php
include "config.inc.php";
if($_SESSION['logedin'] != 'sqlitelinks')
{
	header("Location: $indexpage"); 
	exit(); 
}

$link = $_POST['link'];

if(empty($link))
{
	header("Location: error.php?error=nolink");
	exit();
}
  
    //open the database
    $db = new PDO("sqlite:db/$dbname");

	$db->exec("INSERT INTO Links (Counter, Links) VALUES ('0', '$link')");
	
    // close the database connection
    $db = NULL;

header("Location: $mainpage");
?>