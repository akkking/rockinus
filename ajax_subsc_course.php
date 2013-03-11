<?php 
include ("dbconnect.php");
include 'emailfuc.php';
require("class.phpmailer.php");
session_start();
$sender = htmlspecialchars(trim($_POST['sender']));
$course_uid = htmlspecialchars(trim($_POST['course_uid']));

$q_uid = mysql_query("SELECT * FROM rockinus.user_course_info WHERE uname='$sender' AND course_uid='$course_uid'");
if(!$q_uid) die(mysql_error());
$no_row_uid = mysql_num_rows($q_uid);
if($no_row_uid == 0){
	$sql = "INSERT INTO rockinus.user_course_info(uname,course_uid,pdate,ptime)VALUES('$sender','$course_uid',CURDATE(), NOW())";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	echo("<span style='height:14; padding:2 6 2 6; background: $_SESSION[hcolor]; border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:11px; color:#FFFFFF; line-height:120%; display:inline' align='center'>Subscribed</span>"); 
}
?>