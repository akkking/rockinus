<?php
include 'dbconnect.php'; 
session_start(); 
$sender = $_SESSION['usrname']; 
$course_uid = $_POST['course_uid'];
$termType = $_POST['termType'];
$season = $_POST['season'];
$pagename = $_POST['pagename'];
$descrip = addslashes($_POST['description']);
if(isset($_POST['anony_yesno'])) $rstatus = "Y";
else $rstatus = "N";
//$qsql = "SELECT * FROM rockinus.course_memo_info";
//$qresult = mysql_query($qsql);

if(!isset($_POST['termType'])){
	$_SESSION['season']=$season;
	$_SESSION['descrip']=$descrip;
	$_SESSION['rst_msg']="<div style='width:740px; display: inline; padding: 3 8 3 8; height:25px; background: #FFFFFF; font-weight:bold; color:#B92828; font-size:12px' align=left><img src=img/stop.jpg width=11 />&nbsp;&nbsp;Please select a term that your question belongs to</div>";
}else if(!isset($_POST['season'])){
	$_SESSION['termType']=$termType;
	$_SESSION['descrip']=$descrip;
	$_SESSION['rst_msg']="<div style='width:740px; display: inline; padding: 3 8 3 8; height:25px; background: #FFFFFF; font-weight:bold; color:#B92828; font-size:12px' align=left><img src=img/stop.jpg width=11 />&nbsp;&nbsp;Please select a season that your question belongs to</div>";
}else if( strlen(trim($descrip))<20 ){
	$_SESSION['termType']=$termType;
	$_SESSION['season']=$season;
	$_SESSION['descrip']=$descrip;
	$_SESSION['rst_msg']="<div style='width:740px; display: inline; padding: 3 8 3 8; height:25px; background: #FFFFFF; font-weight:bold; color:#B92828; font-size:12px' align=left><img src=img/stop.jpg width=11 />&nbsp;&nbsp;Please make sure you have typed more than 20 letters</div>";
}else{
	$sql = "INSERT INTO rockinus.course_question_info (course_uid,descrip,termType,season,sender,rstatus,pdate,ptime) VALUES('$course_uid','$descrip','$termType','$season','$sender','$rstatus', CURDATE(), NOW())";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	$_SESSION['rst_msg']="<div style='width:740px; display: inline; padding: 3 8 3 8; height:25px; background: ; font-weight:bold; color:#000000; font-size:12px' align=left><img src=img/addsuccessIcon.jpg width=11 />&nbsp;&nbsp;Question posted successfully!</div>"; 
	if(isset($_SESSION['termType'])) unset($_SESSION['termType']);
	if(isset($_SESSION['season'])) unset($_SESSION['season']);
	if(isset($_SESSION['descrip'])) unset($_SESSION['descrip']);
}

header("location:$pagename");
mysql_close($link);
?> 