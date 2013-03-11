<?php
include 'dbconnect.php';
session_start(); 
$sender = $_SESSION['usrname']; 
$memofid = 1;
$uid = $_POST['uid'];    
$descrip = addslashes($_POST['textarea']);    
echo("SELECT * FROM rockinus.memo_info where sender='$uid' ORDER BY memoid DESC");
$qsql = mysql_query("SELECT * FROM rockinus.memo_info where sender='$uid' ORDER BY memoid DESC");
if(!$qsql) die(mysql_error());
$obj = mysql_fetch_object($qsql);
$memoid = $obj->memoid;

$sql = "INSERT INTO rockinus.memo_follow_info(memoid,sender,recipient,descrip,pdate,ptime,rstatus) VALUES('$memoid','$sender','$uid','$descrip',CURDATE(), NOW(),'N')";
$result = mysql_query($sql);
if (!$result) {
   	die('Invalid query: ' . mysql_error());
}

$_SESSION['rst_msg']="<strong><font color=#336633>Posted!</font></strong>"; 
header("location:ThingsRock.php");
mysql_close($link);
?>