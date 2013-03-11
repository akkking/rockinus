<?php
include 'dbconnect.php'; 
include 'emailfuc.php';
require("class.phpmailer.php");

session_start();
$pagename = "JoinResult.php";
//$uname = $_POST['usrname'];
$uname = $_POST['usrname']; 
$randcode = $_SESSION['randcode'];
$uschool=NULL;
$mschool=NULL;
$pschool=NULL;
$level=NULL;
$icon=NULL;  
$passwd = $_POST['passwd']; 
$cpasswd = $_POST['cpasswd']; 
$sstatus = $_POST['sstatus']; 
$email = $_POST['email'];
$emailcheck = $_POST['emailcheck'];    
$rancode = $_POST['rancode'];	
$chkcode = trim(getRam(32));
$chkcodelink = "http://localhost/chkcode.php?rocker=".$uname."&&chkcode=".$chkcode; 

$stren = CheckPasswordStrength($passwd);
if( CheckPasswordStrength($passwd)<2 ){
	$_SESSION['passwd_rst_msg'] = "<div style='background-color:#EEEEEE; width:320; padding-bottom:5; padding-top:5; border:1 #333333 solid'><font color=red><strong>&nbsp;&nbsp;The Password is not secure enough</strong></font></div>";
	$pagename="joinUs.php";
} 

if( $passwd!= $cpasswd ) {
	$_SESSION['cpasswd_rst_msg'] = "<div style='background-color:#EEEEEE; width:320; padding-bottom:5; padding-top:5; border:1 #333333 solid'><font color=red><strong>&nbsp;&nbsp;Two passwords are not same</strong></font></div>";
	$pagename="joinUs.php";
}else 
	$passwd = md5($passwd);

if( $randcode!= $rancode ) {
	$_SESSION['rst_msg'] = "<div style='background-color:#EEEEEE; width:320; padding-bottom:5; padding-top:5; border:1 #333333 solid'><font color=red><strong>&nbsp;&nbsp;The Check Code is incorrect</strong></font></div>";
	$pagename="joinUs.php";
}

if( $email == "" ) {
	$_SESSION['erst_msg'] = "<div style='background-color:#EEEEEE; width:320; padding-bottom:5; padding-top:5; border:1 #333333 solid'><font color=red><strong>&nbsp;&nbsp;Email address is required</strong></font></div>";
	$pagename="joinUs.php";
}

if( is_email($email) == 0 ) {
	$_SESSION['erst_msg'] = "<div style='background-color:#EEEEEE; width:320; padding-bottom:5; padding-top:5; border:1 #333333 solid'><font color=red><strong>&nbsp;&nbsp;.edu email address is required</strong></font></div>";
	$pagename="joinUs.php";
}

$qsql = "SELECT * FROM rockinus.user_check_info";
$qresult = mysql_query($qsql);
while($row = mysql_fetch_array($qresult)){
	if ( $uname == $row['uname'] ){
		$_SESSION['rst_msg'] = "<div style='background-color:#EEEEEE; width:320; padding-bottom:5; padding-top:5; border:1 #333333 solid'><font color=red><strong>&nbsp;&nbsp;&nbsp;The Rocker name $uname is already exist</strong></font></div>";
		$pagename="joinUs.php";
		break;
	}

	if ( $email == $row['email'] ){
		$_SESSION['erst_msg'] = "<div style='background-color:#EEEEEE; width:320; padding-bottom:5; padding-top:5; border:1 #333333 solid'><font color=red><strong>&nbsp;&nbsp;&nbsp;$email is already registered</strong></font></div>";
		$pagename="joinUs.php";
		break;
	}	
}

if( $pagename=="JoinResult.php" ){
	$sql = "INSERT INTO rockinus.user_check_info (uname,email,passwd,status,chkcode,signup_date,signup_time, tbname) VALUES('$uname', '$email', '$passwd', 'P', '$chkcode', CURDATE(), NOW(), 'user_check_info')";
	$result = mysql_query($sql);
	if (!$result) {
   		die('Invalid query: ' . mysql_error());
	}

//$_SESSION['usrname']=$uname;
//setcookie("user", $uname, time()+3600);
	smtp_mail($email, "Welcome to Rockinus.com", NULL, "admin@rockinus.com", $uname, $chkcodelink);        
	$_SESSION['rst_msg'] = "<strong><font color=#FF6600 size=5>Well Done!</font></strong><br><br><br>An email has been sent to $email <br><br> Please check your email and activate the account within 24 hours.";
}else{
	$_SESSION['email'] = $email;
	$_SESSION['rid'] = $uname;
}

header("location:$pagename");
mysql_close($link);
?> 