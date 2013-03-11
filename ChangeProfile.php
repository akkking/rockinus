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
$fname = $_POST['fname'];
$lname = $_POST['lname'];  
$cschool = $_POST['cschool'];  
$cdegree = $_POST['cdegree'];  
$cmajor = $_POST['cmajor'];  
$fcountry = $_POST['fcountry'];  
$fcity = $_POST['fcity'];  
$mstatus = $_POST['mstatus'];  
$sstatus = $_POST['sstatus'];  
$email = $_POST['email'];  
$phone = $_POST['phone'];  
$address = $_POST['address'];  
$ccity = $_POST['ccity'];  
$cstate = $_POST['cstate'];  
$gender = $_POST['gender'];  
$birthdate = $_POST['birthdate'];  
$_SESSION['rst_msg']="<div align='center' style='width=300; padding-top:10; padding-bottom:10; margin-top:10'><strong>Your profile has been updated successfully.</strong><p><a href=RockerProfile.php class=one>Back Home</a></div>"; 
$upd = mysql_query("UPDATE rockinus.user_info SET fname='$fname', lname='$lname', gender='$gender', cmajor='$cmajor', cdegree='$cdegree', cschool='$cschool', sstatus='$sstatus', mstatus='$mstatus', birthdate='$birthdate', fcity='$fcity', fcountry='$fcountry', ccity='$ccity', ccountry='ccountry', email='$email', phone='$phone', address='$address' WHERE uname='$uname'");
if(!$upd) die(mysql_error());
header("location:MessageProfileResult.php");
mysql_close($link);
?>
</body>
</html>