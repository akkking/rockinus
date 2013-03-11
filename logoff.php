<?php 
include 'dbconnect.php';

session_start(); 
$uname = $_SESSION['usrname'];  
$result = mysql_query("INSERT INTO rockinus.user_log_info (uname,log_date,log_time, flag) VALUES('$uname', CURDATE(), NOW(), '0')");
if (!$result) die('Invalid query: '.mysql_error());
mysql_close($link);

session_unset(); 
session_destroy(); 
setcookie("user", "", time()-3600);
setcookie("Login_Tag", "", time()-3600); 
session_start();
$_SESSION['logoff_tag'] = "<div style='border:0px #EEEEEE solid; background-color:; height:20px; padding-top:2; display:inline; padding-left:0px; padding-right: 10px; color: #006699' valign='middle'><font style='font-size:11px'><img src='img/addsuccessIcon.jpg' width=15> &nbsp; Sign Out Successful :)</font></div>";
header("location:main.php"); 
?> 