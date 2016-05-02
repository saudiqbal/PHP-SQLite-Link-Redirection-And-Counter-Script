<?php
include "config.inc.php";
  try
  {
    //open the database
    $db = new PDO("sqlite:db/$dbname");

    //create the database
    $db->exec("CREATE TABLE Links (
	rowid INTEGER PRIMARY KEY AUTOINCREMENT,
	Counter TEXT,
	Links TEXT)");
	
	echo "Database and Tables created sucessfully.<br>";
	
    // close the database connection
    $db = null;
  }
  catch(PDOException $e)
  {
    print 'Exception : '.$e->getMessage();
  }
$db = NULL;
?>