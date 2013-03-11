<?php 
include ("dbconnect.php");
include 'emailfuc.php';
require("class.phpmailer.php");
session_start();
$sender = htmlspecialchars(trim($_POST['sender']));
$news_id = htmlspecialchars(trim($_POST['news_id']));

$q_uid = mysql_query("SELECT * FROM rockinus.event_attendance WHERE uname='$sender' AND news_id='$news_id' AND rstatus='Y'");
if(!$q_uid) die(mysql_error());
$no_row_uid = mysql_num_rows($q_uid);
if($no_row_uid > 0){
	$sql = "UPDATE rockinus.event_attendance SET rstatus='N' WHERE news_id='$news_id' AND uname='$sender'";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	echo("Canceled "); 
}
?>