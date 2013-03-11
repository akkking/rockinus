<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

$q=$_GET["q"];
$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}


mysql_select_db("ajax_demo", $link);

$sql="SELECT * FROM metro_info WHERE LineNo = '$q';";

$result = mysql_query($sql);

while($row = mysql_fetch_array($result))
 {
	 echo  $row['stopName'] . "|";
 }


mysql_close($link);
?>