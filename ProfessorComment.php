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
$pid = $_POST['pid'];
$sid = $_POST['sid'];
$rating = $_POST['rating'];
$pagename = $_POST['pagename'];
$descrip = addslashes($_POST['description']);

$sql = "INSERT INTO rockinus.professor_memo_info(pid,sid,descrip,rating,sender,pdate,ptime, tbname) VALUES('$pid','$sid','$descrip','$rating','$sender',CURDATE(), NOW(), 'professor_memo_info')";
$result = mysql_query($sql);
if (!$result) {
   	die('Invalid query: ' . mysql_error());
}

$_SESSION['rst_msg']="<strong><font color=#336633>Posted!</font></strong>"; 
header("location:$pagename");
mysql_close($link);
?> <br>
</body>
</html>