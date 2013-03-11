<?php 
session_start(); 
$uname = $_SESSION['usrname'];
include 'dbconnect.php';
$sender = $_GET["sender"];
$_SESSION['rst_msg']="<div align='center' style='width=700; padding-top:10; padding-bottom:10; margin-top:10'><font size=4 color=$_SESSION[hcolor]><strong>$sender is now your friend.</strong></font><br><br><a href=FriendGroup.php?friendreq=1 class=one><font size=3>Go Back</font></a></div>"; 

$upd = mysql_query("UPDATE rockinus.rocker_rel_history SET rstatus='R', pdate=CURDATE(), ptime=NOW() WHERE sender='$sender' AND recipient='$uname'");
if(!$upd) die(mysql_error());

header("location:FriendGroupResult.php");
mysql_close($link);
?>