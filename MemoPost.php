<?php
include 'dbconnect.php'; 
session_start(); 
$sender = $_SESSION['usrname']; 
$pagename = $_POST['pagename'];
$description =  addslashes($_POST['limitedtextarea']);    
$level = "A";

$sql = "INSERT INTO rockinus.memo_info (descrip,level,sender,pdate,ptime) VALUES('$description','$level','$sender',CURDATE(), NOW())";
$result = mysql_query($sql);
if(!$result) die('Invalid query: ' . mysql_error());

$_SESSION['rst_msg']="<strong><font color=red>Shared!</font></strong>"; 
header("location:ThingsRock.php");
mysql_close($link);
?> 