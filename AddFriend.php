<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Mysql process</title>
</head>
<body>
<?php
include 'dbconnect.php'; 
session_start(); 
$sender = $_SESSION['usrname']; 
$recipient = $_GET["recipient"];
$_SESSION['rst_msg']="<div align='center' style='width=300; padding-top:10; padding-bottom:10; margin-top:10'><strong>The request has been sent to $recipient. </strong><br><br><a href=FriendGroup.php class=one>Back Home</a></div>"; 

$qsql = "SELECT * FROM rockinus.rocker_rel_info where recipient='$recipient' and sender='$sender'";
$qresult = mysql_query($qsql);
while($row = mysql_fetch_array($qresult)){
	$rstatus = $row['rstatus'];
	if($rstatus == 'P')	$_SESSION['rst_msg']="<div align='center' style='width=500; padding-top:10; padding-bottom:10; margin-top:10'><strong>The request has already been sent to $recipient.</strong><br><br><a href=FriendGroup.php  class=one>Back Home</a>"; 	
	if($rstatus == 'A')	$_SESSION['rst_msg']="<div align='center' style='width=300; padding-top:10; padding-bottom:10; margin-top:10'><strong>$recipient is already your friend. </strong><br><br><a href=FriendGroup.php  class=one>Back Home</a>"; 
}

$qsql2 = "SELECT * FROM rockinus.rocker_rel_info where recipient='$sender' and sender='$recipient'";
$qresult2 = mysql_query($qsql2);
while($row2 = mysql_fetch_array($qresult2)){
	$rstatus = $row2['rstatus'];
	if($rstatus == 'P')	$_SESSION['rst_msg']="<div align='center' style='width=300; padding-top:10; padding-bottom:10; margin-top:10'><strong>The request has already been sent to $recipient.</strong><br><br><a href=FriendGroup.php class=one>Back Home</a></div>";

	if($rstatus == 'A')	$_SESSION['rst_msg']="<div align='center' style='width=300; padding-top:10; padding-bottom:10; margin-top:10'><strong>$recipient is already your friend. </strong><br><br><a href=FriendGroup.php class=one>Back Home</a></div>"; 
}

$sql = "INSERT INTO rockinus.rocker_rel_info(recipient,rstatus,sender,pdate,ptime) VALUES('$recipient','P','$sender',CURDATE(), NOW())";
$result = mysql_query($sql);
if (!$result) die('Invalid query: ' . mysql_error());

header("location:AddFriendResult.php");
mysql_close($link);
?> 
</body>
</html>
