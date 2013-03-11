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
if($no_row_uid == 0){
	$sql = "INSERT INTO rockinus.event_attendance(news_id,uname,rstatus,pdate,ptime)VALUES('$news_id','$sender','Y',CURDATE(), NOW())";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	echo("<span style='background: #F5F5F5; border:1px solid #DDDDDD; height:14; padding:2 8 2 8; font-size:11px; display:inline'><img src='img/addsuccessIcon_F5.jpg' width=10 />&nbsp;&nbsp;I'm going</span>"); 
}else{
	$q_uid_upd = mysql_query("SELECT * FROM rockinus.event_attendance WHERE uname='$sender' AND news_id='$news_id' AND rstatus='N'");
	if(!$q_uid_upd) die(mysql_error());
	$no_row_uid_upd = mysql_num_rows($q_uid_upd);
	
	if($no_row_uid_upd == 0){
		$sql = "UPDATE rockinus.event_attendance SET rstatus='Y' WHERE news_id='$news_id' AND uname='$sender'";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		echo("<span style='background: #F5F5F5; border:1px solid #DDDDDD; height:14; padding:2 8 2 8; font-size:11px; display:inline'><img src='img/addsuccessIcon_F5.jpg' width=10 />&nbsp;&nbsp;I'm going</span>"); 
	}
}
?>