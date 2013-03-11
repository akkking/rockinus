<?php 
include 'dbconnect.php';

session_start(); 
$uname = $_SESSION['usrname'];  
$result = mysql_query("INSERT INTO inventory.user_log_info (uname,LogDate,LogTime, tag) VALUES('$uname', CURDATE(), NOW(), '0')");
if (!$result) die('Invalid query: '.mysql_error());
mysql_close($link);

session_unset(); 
session_destroy(); 
setcookie("user", "", time()-3600);
setcookie("Login_Tag", "", time()-3600); 
header("location:index.php"); 
?> 