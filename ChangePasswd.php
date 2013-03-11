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

$oldpasswd = md5($_POST['oldpasswd']);
$passwd = md5($_POST['passwd']);  
$cpasswd = md5($_POST['cpasswd']);  
$_SESSION['rst_msg']="<div align='center' style='width:250px; padding-top:10; padding-bottom:5; margin-top:5;font-size:13px'><img src=img/addsuccessIcon.jpg width=18>&nbsp;&nbsp; <strong><font color=#336633>Successfully</font></strong><p></div>"; 
$q = mysql_query("SELECT * FROM rockinus.user_check_info where uname='$uname'");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("User Data cannot be found.");
$object = mysql_fetch_object($q);
if(trim($passwd) != trim($cpasswd)){
	$_SESSION['rst_msg']="<div align='center' style='width:250px; padding-top:10; padding-bottom:10; margin-top:10;font-size:13px'><strong><font color='#B92828'>Confirmed password is not correct</font></strong></div>";
}else if(trim($oldpasswd) == trim($object->passwd)){
	$upd = mysql_query("UPDATE rockinus.user_check_info SET passwd='$passwd' WHERE uname='$uname'");
	if(!$upd) die(mysql_error());
}else{
	$_SESSION['rst_msg']="<div align='center' style='width:250px; padding-top:5; padding-bottom:5; margin-top:5; font-size:13px'><strong><font color='#B92828'>Original password is not correct</font></strong></div>";
}

header("location:EditPassword.php");
mysql_close($link);
?>
</body>
</html>