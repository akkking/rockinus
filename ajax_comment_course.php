<?php 
include ("dbconnect.php");
include 'emailfuc.php';
require("Allfuc.php");
require("class.phpmailer.php");
//session_start();
$sender = htmlspecialchars(trim($_POST['sender']));
$course_uid = htmlspecialchars(trim($_POST['course_uid']));
$rating = $_POST['rating'];
$rstatus = $_POST['anony_yesno'];
$descrip = htmlspecialchars(trim($_POST['descrip']));
if(strlen($rating)==0 || $rating==NULL) $rating="0";

if( strlen(trim($sender))>0 && strlen(trim($descrip))>20 ){
	$sql = "INSERT INTO rockinus.course_memo_info (course_uid,descrip,rating,sender,rstatus,pdate,ptime,tbname) VALUES('$course_uid','$descrip','$rating','$sender','$rstatus',CURDATE(), NOW(),'course_memo_info')";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	
	$rating_img = NULL;
	for($i=0; $i<$rating; $i++) $rating_img .= "<img src='img/yellowstar.jpg' width='13' />";
	
	echo("<div style='border-top:1px solid #DDDDDD; padding-top:15; font-size:13px; margin-bottom:10'>".nl2br($descrip)." <br><font color='#999999'>( $rating_img " .getDateName(date("Y-m-d H:i:s"))." )</font></div>");
}
?>