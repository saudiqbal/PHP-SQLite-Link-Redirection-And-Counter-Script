<?php
include "config.inc.php";
ob_start("ob_gzhandler");
if($_SESSION['logedin'] != 'sqlitelinks')
{
	header("Location: $indexpage"); 
	exit(); 
}
$db = new PDO("sqlite:db/$dbname");
?>
<html>
<head>
<title>Links Manager</title>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<style type="text/css">
#customers
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:100%;
border-collapse:collapse;
}
#customers td, #customers th 
{
font-size:1em;
border:1px solid #98bf21;
padding:3px 7px 2px 7px;
}
#customers th 
{
font-size:1.1em;
text-align:left;
padding-top:5px;
padding-bottom:4px;
background-color:#A7C942;
color:#ffffff;
}
#customers tr.alt td 
{
color:#000000;
background-color:#EAF2D3;
}
.pages a {
  color: #1C5C9A;
  text-decoration: none;
  font-weight: bold;
  font-family:arial, helvetica, arial, sans-serif;
}
.pages a:hover {
  color: #6398CD;
  text-decoration: none;
  font-weight: bold;
  font-family:arial, helvetica, arial, sans-serif;
}
.pages {
    padding: 20px 0 10px 0;
    margin: 20px 0 10px 0;
    clear: left;
    font-size: 11px;
    text-align: center;
	font-family:arial, helvetica, arial, sans-serif;
}
.pages a, .pages span {
    padding: 0.2em 0.5em;
    margin-right: 0.1em;
    border: 1px solid #fff;
    background: #fff;
}
.pages span.current {
    border: 1px solid #2E6AB1;
    font-weight: bold;
    background: #30659E;
    color: #fff;
	font-family:arial, helvetica, arial, sans-serif;
}
.pages a {
    border: 1px solid #9AAFE5;
    text-decoration: none;
}
.pages a:hover {
    color: #1c5c9a;
    border-color: #6398CD;
    background: #ecf2f8;
}
.pages a.nextprev {
    font-weight: bold;
	font-family:arial, helvetica, arial, sans-serif;
}
.pages span.nextprev {
    border: 1px solid #ddd;
    color: #666;
	font-weight: bold;
	font-family:arial, helvetica, arial, sans-serif;
}

.dropdown {
				   
						  
					
    position: relative;
 

								 

							 

								 

							
					
				
    display: inline-block;
					 
						   
							   
							
					   
					  
				   
					  
									 
					  
}

.dropdown .dropdown-menu {
							  
				 
						
									
									 
										
									   
										   
								   
								 
 

															
						  
			   
				
								  
										
									   
 

																															  

							 
    position: absolute;
    top: 100%;
    display: none;
					  
    margin: 0;
    list-style: none; /** Remove list bullets */
     /** Set the width to 100% of it's parent */
    padding: 0;
	z-index: 2;
}

.dropdown:hover .dropdown-menu {
    display: block;
					 
					  
							   
								  
					
					   
}

/** Button Styles **/
.dropdown button {
    background-color: Transparent;
    color: #FFFFFF;
    border: none;
    margin: 0;
    padding: 0em 0.2em;
    font-size: 1em;
	z-index: -1;
}

/** List Item Styles **/
.dropdown a {
    display: block;
    padding: 0.2em 0.8em;
    text-decoration: none;
    background: #CCCCCC;
    color: #333333;
	width: 150%;
}

/** List Item Hover Styles **/
.dropdown a:hover {
    background: #BBBBBB;
	width: 150%;
	z-index: 2;
}
#dropdownicon { 
background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQAgMAAABinRfyAAAAA3NCSVQICAjb4U/gAAAACXBIWXMAAADeAAAA3gHd6oNqAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAAAlQTFRF////AAAAAAAAflGpXQAAAAJ0Uk5TAICbK04YAAAALklEQVQIHW3BMQEAIAwDsPAgYmqmBzWI4KEqMUDCx0quSo6ZbCNp1kUdzI3Rfh7ocQqhSrAE5gAAAABJRU5ErkJggg==);
height: 16px;
width: 16px;
background-repeat: no-repeat;
}

.divider {
display: inline-block;
height: 50px;
}
#alignleft {
float: left;
}
#alignright {
float: right;
}
</style>
</head>
<body>
<div class="divider">
<div id="alignleft"><span style="font-size:xx-large;">Links Manager</span></div>
<div id="alignright">
<span class="dropdown">
<button><div id="dropdownicon" title="Dropdownicon" style="margin-top: 10px; margin-left: 20px;"></div></button>
<ul class="dropdown-menu">
<li><a href="form.php">Add a link</a></li>
<li><a href="logoff.php">Log out</a></li>
</ul>
</span>
</div>
</div>


<table id="customers">
<thead><tr>
<th align='left'>Link ID</th>
<th align='left'>Counter</th>
<th align='left'>Link</th>
</tr></thead>
<?php
$result = $db->query("SELECT rowid FROM Links");
$rows = $result->fetchAll();
$total_pages = count($rows);
$limit = 50;
$adjacents = 3;
if(isset($_GET['page']))
{
$page = $_GET['page'];
if(preg_match('/[^0-9]/i', $page))
{
echo "SQL Injection detected!";
exit();
}
}
if(isset($page))
$start = ($page - 1) * $limit;
else
$start = 0;

$result = $db->query("SELECT rowid, Counter, Links FROM Links ORDER BY rowid DESC LIMIT '$start', '$limit'");

$i = 1;
foreach($result as $row)
{
	if ($i % 2 != 0) # An odd row 
    $rowColor = "";
	else # An even row 
    $rowColor = "class='alt'";
	echo "<tr $rowColor>" . "<td width='70'>" . stripslashes($row['rowid']) . "</td>" . "<td width='100'>" . stripslashes($row['Counter']) . "</td>" . "<td><div class=\"dropdown\">
<button><div id=\"dropdownicon\" title=\"Dropdownicon\" style=\"margin-right: 5px;\">&nbsp;&nbsp;&nbsp;</div></button>
																										
<ul class=\"dropdown-menu\">
<li><a href='" . $linkdir . "updateform.php?linkid=" . $row['rowid'] . "'>Edit</a></li>
<li><a href='" . $linkdir . "delete.php?id=" . $row['rowid'] . "' onclick=\"javascript:return confirm('Delete permanently?')\">Delete</a></li>
</ul>
</div><a href='" . $goto . "goto.php?link=" . $row['rowid'] . "' style='text-decoration: none; color:#000000;' target=\"_blank\">" . $row['Links'] . "</a></td>" . "</tr>\n";
	$i++;
}
$db = NULL;
/*
	Plugin Name: *Digg Style Paginator
	Plugin URI: http://www.mis-algoritmos.com/2006/11/23/paginacion-al-estilo-digg-y-sabrosus/
	Description: Adds a <strong>digg style pagination</strong>.
	Version: 0.1 Beta
*/
function pagination($total_pages,$limit,$page,$file,$adjacents){
		#$total_pages; //total number of rows in data table
		#$limit; //how many items to show per page
		#$page = isset($_GET['page'])?$_GET['page']:1;

		#$file = "paginator.php";
		#$file = array("digg-[...].html","[...]");
		#$adjacents = 3;

		/* Setup vars for query. */
		if($page)
				$start = ($page - 1) * $limit; 			//first item to display on this page
			else
				$start = 0;								//if no page var is given, set start to 0

		/* Setup page vars for display. */
		if ($page == 0) $page = 1;					//if no page var is given, default to 1.
		$prev = $page - 1;							//anterior page is page - 1
		$siguiente = $page + 1;							//siguiente page is page + 1
		$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
		$lpm1 = $lastpage - 1;						//last page minus 1

		/*
			Now we apply our rules and draw the pagination object.
			We're actually saving the code to a variable in case we want to draw it more than once.
		*/

		$url_friendly = false;
		if(is_array($file))
			$url_friendly=true;

		$p = false;
		if(strpos($file,"?")>0)
			$p = true;

		ob_start();
		if($lastpage > 1){
				echo "<div class=\"pages\">";
				//anterior button
				if($page > 1)
						if($url_friendly)
								echo "<a href=\"".str_replace($file[1],$prev,$file[0])."\"><< Previous</a>";
							else
								if($p)
									echo "<a href=\"$file$prev\"><< Previous</a>";
									else
									echo "<a href=\"$file$prev\"><< Previous</a>";
					else
						echo "<span class=\"nextprev\"><< Previous</span>";
				//pages
				if ($lastpage < 7 + ($adjacents * 2)){//not enough pages to bother breaking it up
						for ($counter = 1; $counter <= $lastpage; $counter++){
								if ($counter == $page)
										echo "<span class=\"current\">$counter</span>";
									else
										if($url_friendly)
												echo "<a href=\"".str_replace($file[1],$counter,$file[0])."\">$counter</a>";
											else
												if($p)
												echo "<a href=\"$file$counter\">$counter</a>";
												else
												echo "<a href=\"$file?page=$counter\">$counter</a>";
							}
					}
				elseif($lastpage > 5 + ($adjacents * 2)){//enough pages to hide some
						//close to beginning; only hide later pages
						if($page < 1 + ($adjacents * 2)){
								for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
										if ($counter == $page)
												echo "<span class=\"current\">$counter</span>";
											else
												if($url_friendly)
														echo "<a href=\"".str_replace($file[1],$counter,$file[0])."\">$counter</a>";
													else
														if($p)
														echo "<a href=\"$file$counter\">$counter</a>";
														else
														echo "<a href=\"$file?page=$counter\">$counter</a>";
									}
								echo "<b>...</b>";
								if($url_friendly){
										echo "<a href=\"".str_replace($file[1],$lpm1,$file[0])."\">$lpm1</a>";
										echo "<a href=\"".str_replace($file[1],$lastpage,$file[0])."\">$lastpage</a>";
									}else{
										if($p){
										echo "<a href=\"$file$lpm1\">$lpm1</a>";
										echo "<a href=\"$file$lastpage\">$lastpage</a>";
										}else{
										echo "<a href=\"$file?page=$lpm1\">$lpm1</a>";
										echo "<a href=\"$file?page=$lastpage\">$lastpage</a>";
										}

									}
							}
						//in middle; hide some front and some back
						elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
								if($url_friendly){
										echo "<a href=\"".str_replace($file[1],1,$file[0])."\">1</a>";
										echo "<a href=\"".str_replace($file[1],2,$file[0])."\">2</a>";
									}else{
										if($p){
										echo "<a href=\"{$file}1\">1</a>";
										echo "<a href=\"{$file}2\">2</a>";
										}else{
										echo "<a href=\"$file?page=1\">1</a>";
										echo "<a href=\"$file?page=2\">2</a>";
										}
									}
								echo "<b>...</b>";
								for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
									if ($counter == $page)
											echo "<span class=\"current\">$counter</span>";
										else
											if($url_friendly)
													echo "<a href=\"".str_replace($file[1],$counter,$file[0])."\">$counter</a>";
												else
													if($p)
													echo "<a href=\"$file$counter\">$counter</a>";
													else
													echo "<a href=\"$file?page=$counter\">$counter</a>";
								echo "<b>...</b>";
								if($url_friendly){
										echo "<a href=\"".str_replace($file[1],$lpm1,$file[0])."\">$lpm1</a>";
										echo "<a href=\"".str_replace($file[1],$lastpage,$file[0])."\">$lastpage</a>";
									}else{
										if($p){
										echo "<a href=\"$file$lpm1\">$lpm1</a>";
										echo "<a href=\"$file$lastpage\">$lastpage</a>";
										}else{
										echo "<a href=\"$file?page=$lpm1\">$lpm1</a>";
										echo "<a href=\"$file?page=$lastpage\">$lastpage</a>";
										}
									}
							}
						//close to end; only hide early pages
						else{
								if($url_friendly){
										echo "<a href=\"".str_replace($file[1],1,$file[0])."\">1</a>";
										echo "<a href=\"".str_replace($file[1],2,$file[0])."\">2</a>";
									}else{
										if($p){
										echo "<a href=\"{$file}1\">1</a>";
										echo "<a href=\"{$file}2\">2</a>";
										}else{
										echo "<a href=\"$file?page=1\">1</a>";
										echo "<a href=\"$file?page=2\">2</a>";
										}
									}
								echo "<b>...</b>";
								for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
									if ($counter == $page)
											echo "<span class=\"current\">$counter</span>";
										else
											if($url_friendly)
													echo "<a href=\"".str_replace($file[1],$counter,$file[0])."\">$counter</a>";
												else
													if($p)
													echo "<a href=\"$file$counter\">$counter</a>";
													else
													echo "<a href=\"$file?page=$counter\">$counter</a>";
							}
					}
				//siguiente button
				if ($page < $counter - 1)
						if($url_friendly)
								echo "<a href=\"".str_replace($file[1],$siguiente,$file[0])."\">Siguiente >></a>";
							else
								if($p)
								echo "<a href=\"$file$siguiente\">Next >></a>";
								else
								echo "<a href=\"$file?page=$siguiente\">Next >></a>";
					else
						echo "<span class=\"nextprev\">Next >></span>";
				echo "</div>\n";
			}
		return utf8_decode(ob_get_clean());
	}
?>
</table>
<form action="updateform.php" method="get">
<label>Go to link ID <input type="number" name="linkid" /></label>
<input type="submit" value="Go" />
</form>
<br /><br />
<?php
if(!isset($page))
$page=1;
echo pagination($total_pages,$limit,$page,"main.php?page=",$adjacents);
?>
</body>