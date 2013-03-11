<?php 
session_start(); 
$uname = $_SESSION['usrname'];
include 'dbconnect.php';

if(isset($_GET["sender"]) && isset($_GET['pageName'])){
	$sender = $_GET["sender"];
	$pageName = $_GET['pageName'];
	if(trim($pageName)=="RockerDetail")$pageName="RockerDetail.php?uid=$uid";
	else $pageName .= ".php";
}else header("location:ThingsRock.php");

if(trim($pageName)=="RockerDetail"){
	$_SESSION['rst_msg']="<div align='left' style='width:740; padding-top:5; margin-bottom:10; height:35'>&nbsp;&nbsp;<img src='img/addsuccessIcon.jpg' width=20>&nbsp;&nbsp;<font color='#000000'><strong>$sender's request has been ignored.</strong></font></div>"; 
}else{
	$_SESSION['rst_msg']="<div align='center' style='width:740; padding:15; margin-bottom:10; display:inline'>&nbsp;&nbsp;<img src='img/addsuccessIcon.jpg' width=20>&nbsp;&nbsp;<font color='#000000'><strong>$sender's request has been declined.</strong></font><br><br><a href=FriendGroup.php class=one><font size=4>Go Back</font></a></div>"; 
}

$upd = mysql_query("UPDATE rockinus.rocker_rel_history SET rstatus='D', pdate=CURDATE(), ptime=NOW() WHERE sender='$sender' AND recipient='$uname'");
if(!$upd) die(mysql_error());
header("location:$pageName");
mysql_close($link);
?>