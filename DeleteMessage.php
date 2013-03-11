<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Mysql process</title>
</head>
<body>
<?php 
session_start(); 
$uname = $_SESSION['usrname'];
include 'dbconnect.php';
$recipient = $_POST["recipient"];
$_SESSION['rst_msg']="<div align='center' style='width=300; padding-top:10; padding-bottom:10; margin-top:10'><strong>$recipient has been removed successfully.</strong><br><br><a href=FriendList.php class=one>Back Home</a></div>"; 

$t = mysql_query("SELECT count(*) as cnt FROM rockinus.rocker_rel_info WHERE sender='$uname' AND recipient='$recipient' AND rstatus='A'");
if(!$t){
	die("Error quering the Database: " . mysql_error());
} 
$a = mysql_fetch_object($t);
if ( $a->cnt > 0 )$dlt_stmt = "DELETE FROM rockinus.rocker_rel_info WHERE sender='$uname' and recipient='$recipient'";

$t = mysql_query("SELECT count(*) as cnt FROM rockinus.rocker_rel_info WHERE sender='$recipient' AND recipient='$uname' AND rstatus='A'");
if(!$t){
	die("Error quering the Database: " . mysql_error());
} 
$a = mysql_fetch_object($t); 
if ( $a->cnt > 0 )$dlt_stmt = "DELETE FROM rockinus.rocker_rel_info WHERE sender='$recipient' and recipient='$uname'";

$dlt = mysql_query($dlt_stmt);
if(!$dlt) die(mysql_error());
header("location:AddFriendResult.php");
mysql_close($link);
?>
</body>
</html>