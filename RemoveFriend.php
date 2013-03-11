<?php 
session_start(); 
$uname = $_SESSION['usrname'];
include 'dbconnect.php';
$recipient = $_GET["recipient"];
$_SESSION['rst_msg']="<div align='center' style='width:700; padding-top:10; padding-bottom:10; margin-top:10'><img src='img/addsuccessIcon.jpg'>&nbsp;&nbsp;&nbsp;<font size=4 color=$_SESSION[hcolor]><strong>$recipient has been removed successfully.</strong></font><br><br><br><a href=FriendGroup.php?friendreq=1 class=one>Back Home</a></div>"; 

$t = mysql_query("SELECT count(*) as cnt FROM rockinus.rocker_rel_info WHERE sender='$uname' AND recipient='$recipient'");
if(!$t)	die("Error quering the Database: " . mysql_error());
$a = mysql_fetch_object($t);
if ( $a->cnt > 0 ){
	$dlt_stmt = "DELETE FROM rockinus.rocker_rel_info WHERE sender='$uname' and recipient='$recipient'";
	$dlt_stmt_hist = "DELETE FROM rockinus.rocker_rel_history WHERE sender='$uname' and recipient='$recipient'";
}
$t = mysql_query("SELECT count(*) as cnt FROM rockinus.rocker_rel_info WHERE sender='$recipient' AND recipient='$uname'");
if(!$t)	die("Error quering the Database: " . mysql_error());
$b = mysql_fetch_object($t); 
if ( $b->cnt > 0 ){
	$dlt_stmt = "DELETE FROM rockinus.rocker_rel_info WHERE sender='$recipient' and recipient='$uname'";
	$dlt_stmt_hist = "DELETE FROM rockinus.rocker_rel_history WHERE sender='$recipient' and recipient='$uname'";
}

$dlt = mysql_query($dlt_stmt);
if(!$dlt) die(mysql_error());

$dlt_hist = mysql_query($dlt_stmt_hist);
if(!$dlt_hist) die(mysql_error());

header("location:FriendGroupResult.php");
mysql_close($link);
?>