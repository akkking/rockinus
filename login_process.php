<?php
include 'dbconnect.php';  
include 'Allfuc.php';
include 'emailfuc.php';
require("class.phpmailer.php");
session_start(); 
$_SESSION['rst_msg']= NULL;
$uname = $_POST['usrname']; 
$passwd = trim(md5($_POST['passwd'])); 
$Login_Tag = $_POST['Login_Tag']; 
$result = mysql_query("SELECT * from rockinus.user_check_info WHERE (uname='$uname' OR email='$uname') AND status='A'");
if (!$result) die('Invalid query: ' . mysql_error());
$count = mysql_num_rows($result);
if($count==1){
	$obj = mysql_fetch_object($result);
	if($passwd == trim($obj->passwd)){
		$loopName = $obj->uname;
		$loopEmail = $obj->email;
		if($uname==$loopEmail) $uname=$loopName;
 		$_SESSION['usrname']=$loopName;
		setcookie("user", $uname, time()+3600);
		setcookie("Login_Tag", $Login_Tag, time()+3600);
		
		$points = getUserPoint($uname);
		$points -= 2;
		$sql = "INSERT INTO rockinus.user_log_info (uname,log_date,log_time, flag) VALUES('$loopName', CURDATE(), NOW(), '1')";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		
		$sql = "INSERT INTO rockinus.user_points (uname,log_date,log_time, points) VALUES('$loopName', CURDATE(), NOW(), '$points')";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		
		$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$loopName'");
		if(!$q1) die(mysql_error());
		$object = mysql_fetch_object($q1);
		$_SESSION['hcolor'] = $object->hcolor;
		$_SESSION['lan'] = $object->lan;
		$_SESSION['topi'] = $object->topi;
		
		$pageName = "ThingsRock.php";
		$q_basic = mysql_query("SELECT * FROM rockinus.user_basic_setting where uname='$loopName'");
		if(!$q_basic) die(mysql_error());
		$object_basic = mysql_fetch_object($q_basic);
		$directPage = $object_basic->directPage;
		
		if(ProfileProgress($uname)<60)
			$pageName= "homeProfileUpdater.php";
		else{
			if($directPage=="H")$pageName= "ThingsRock.php";
			else if($directPage=="P")$pageName= "RockerDetail.php?uid=$loopName";
		}
		
		if($uname!="akkking"&&$uname!="harvey"&&$uname!="barmuya@hotmail.com"&&$uname!="ayigai01@students.poly.edu")
		smtp_mail("barmuya@hotmail.com", $uname." has login", "Blank", "admin@rockinus.com", $uname, "", "");
		
		header("location:$pageName");
	}else{
		$_SESSION['login_uname'] = $uname;
		$_SESSION['rst_msg']="<div align='center' style='width:400; padding-top:10; padding-bottom:-20; margin-top:10; margin-bottom:-30'><font color=#B92828 style='font-size:16px; font-family:Arial, Helvetica, sans-serif, sans-serif; font-weight:bold'><img src='img/error_new.jpg' width='15'>&nbsp;&nbsp;&nbsp;User Password is incorrect, try another</font><br></div>"; 
		header("location:main_reLogin.php");
	}
}else{
	$_SESSION['rst_msg']="<div align='center' style='width:400; padding-top:10; padding-bottom:-20; margin-top:10; margin-bottom:-30'><font color=#B92828 style='font-size:16px; font-family:Arial, Helvetica, sans-serif, sans-serif;font-weight:bold'><img src='img/error_new.jpg' width='15'>&nbsp;&nbsp;&nbsp;User name does not exist, try another</font><br></div>"; 
	header("location:main_reLogin.php");
}
mysql_close($link);
?>