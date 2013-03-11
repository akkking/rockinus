<?php
include 'dbconnect.php'; 
session_start(); 
$sender = $_SESSION['usrname']; 
$course_uid = $_POST['course_uid'];
$rating = $_POST['rating'];
if(isset($_POST['anony_yesno'])) $rstatus = "Y";
else $rstatus = "N";
$pagename = $_POST['pagename'];
$descrip = addslashes($_POST['description']);
//$qsql = "SELECT * FROM rockinus.course_memo_info";
//$qresult = mysql_query($qsql);

if(strlen($rating)==0||$rating==NULL) $rating=0;

if( strlen(trim($sender))>0 && strlen(trim($descrip))>20 ){
	$sql = "INSERT INTO rockinus.course_memo_info (course_uid,descrip,rating,sender,rstatus,pdate,ptime,tbname) VALUES('$course_uid','$descrip','$rating','$sender','$rstatus',CURDATE(), NOW(),'course_memo_info')";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	$_SESSION['rst_msg']="<div style='width:740px; display: inline; padding: 3 8 3 8; height:25px; background: #F5F5F5; font-weight:bold; color:#000000; font-size:14px' align=left><img src=img/addsuccessIcon_F5.jpg width=15 />&nbsp;&nbsp;Posted successfully!</div>"; 
}else{
	$_SESSION['rst_msg']="<div style='width:740px; display: inline; padding: 3 8 3 8; height:25px; background: #F5F5F5; font-weight:bold; color:#B92828; font-size:14px' align=left><img src=img/stop.jpg width=15 />&nbsp;&nbsp;Please make sure you have typed more than 20 letters</div>";
}

header("location:$pagename");
mysql_close($link);
?> 