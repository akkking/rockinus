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
$uname = $_SESSION['rid'];
$uschool=NULL;
$mschool=NULL;
$pschool=NULL;
$level=NULL;
$icon=NULL;  
$passwd = $_POST['passwd']; 
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$birthdate = $_POST['birthdate']; 
$gender = $_POST['gender'];
$ccountry = NULL;
$cstate = $_POST['cstate']; 
$ccity = $_POST['ccity']; 
$cschool = $_POST['cschool']; 
$cmajor = $_POST['cmajor']; 
$cdegree = $_POST['cdegree'];
$fcountry = $_POST['fcountry']; 
$fstate = NULL; 
$fcity = $_POST['fcity']; 
$mstatus = $_POST['mstatus']; 
$sstatus = $_POST['sstatus']; 
$email = $_POST['email'];
$phone = $_POST['phone']; 
$address = $_POST['address']; 
$emailcheck = $_POST['emailcheck'];    

if($cdegree=='U')$uschool=$cschool;
else if($cdegree=='M')$mschool=$cschool;
else if($cdegree=='P')$pschool=$cschool;

$qsql = "SELECT uname, uid FROM rockinus.user_info ORDER BY uid DESC";
$qresult = mysql_query($qsql);
while($row = mysql_fetch_array($qresult)){
	if ( $uname == $row['uname'] ){
		echo "<br />Sorry! The Rocker name '$uname' already exist..<br /><br />";
		echo "<a href='rockinus_reg.php'>Back</a>";
		die();
	}else{
		$c_uid = $row['uid'];
		if($uid < $c_uid)$uid = $c_uid;
	}
	$uid += 1;
}
$sql = "INSERT INTO rockinus.user_info (uname,passwd,fname,lname,birthdate,gender,uschool,mschool,pschool,cmajor,sstatus,ccountry,cstate,ccity,cschool,cdegree,fcountry,fstate,fcity,mstatus,level, icon, email,phone,address,signup_date,signup_time) VALUES('$uname', '$passwd', '$fname', '$lname', '$birthdate', '$gender', '$uschool','$mschool','$pschool','$cmajor','$sstatus', '$ccountry', '$cstate', '$ccity', '$cschool', '$cdegree', '$fcountry', '$fstate', '$fcity', '$mstatus', '$level','$icon','$email', '$phone', '$address', CURDATE(), NOW())";
$result = mysql_query($sql);
if (!$result) {
   	die('Invalid query: ' . mysql_error());
}

$_SESSION['usrname']=$uname;
setcookie("user", $uname, time()+3600);
header("location:headicon_upload.php");
mysql_close($link);
?> <br>
</body>
</html>
