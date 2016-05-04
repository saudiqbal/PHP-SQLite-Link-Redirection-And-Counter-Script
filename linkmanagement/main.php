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
    display: block;
    display: inline-block;
    margin: 0px 5px;
    position: relative;
}

/* ===[ For demonstration ]=== */

.dropdown { margin-top: 0px }

/* ===[ End demonstration ]=== */

.dropdown .dropdown_button {
    cursor: pointer;
    width: auto;
    display: inline-block;
    padding: 4px 5px;
    border: 1px solid #AAA;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
    font-weight: bold;
    color: #717780;
    line-height: 16px;
    text-decoration: none !important;
    background: white;
}

.dropdown input[type="checkbox"]:checked +  .dropdown_button {
    border: 1px solid #3B5998;
    color: white;
    background: #6D84B4;
    -moz-border-radius-topleft: 2px;
    -moz-border-radius-topright: 2px;
    -moz-border-radius-bottomright: 0px;
    -moz-border-radius-bottomleft: 0px;
    -webkit-border-radius: 2px 2px 0px 0px;
    border-radius: 2px 2px 0px 0px;
    border-bottom-color: #6D84B4;
}

.dropdown input[type="checkbox"] + .dropdown_button .arrow {
    display: inline-block;
    width: 0px;
    height: 0px;
    border-top: 5px solid #6B7FA7;
    border-right: 5px solid transparent;
    border-left: 5px solid transparent;
}

.dropdown input[type="checkbox"]:checked + .dropdown_button .arrow { border-color: white transparent transparent transparent }

.dropdown .dropdown_content {
    position: absolute;
    border: 1px solid #777;
    padding: 0px;
    background: white;
    margin: 0;
    display: none;
	z-index: 2;
}

.dropdown .dropdown_content li {
    list-style: none;
    margin-left: 0px;
    line-height: 16px;
    border-top: 1px solid #FFF;
    border-bottom: 1px solid #FFF;
    margin-top: 2px;
    margin-bottom: 2px;
}

.dropdown .dropdown_content li:hover {
    border-top-color: #3B5998;
    border-bottom-color: #3B5998;
    background: #6D84B4;
}

.dropdown .dropdown_content li a {
    display: block;
    padding: 2px 7px;
    padding-right: 15px;
    color: black;
    text-decoration: none !important;
    white-space: nowrap;
}

.dropdown .dropdown_content li:hover a {
    color: white;
    text-decoration: none !important;
}

.dropdown input[type="checkbox"]:checked ~ .dropdown_content { display: block }

.dropdown input[type="checkbox"] { display: none }
</style>
</head>
<body>
<h1>Links Manager</h1>
<h4><a href="form.php">Add a link</a> / <a href="logoff.php">Log out</a></h4>
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
	echo "<tr $rowColor>" . "<td width='70'>" . stripslashes($row['rowid']) . "</td>" . "<td width='100'>" . stripslashes($row['Counter']) . "</td>" . "<td><div class=\"dropdown\" id=\"dropdown\">
<input type=\"checkbox\" id=\"drop" . $row['rowid'] . "\" />
<label for=\"drop" . $row['rowid'] . "\" class=\"dropdown_button\"><span class=\"arrow\"></span></label>
<ul class=\"dropdown_content\">
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