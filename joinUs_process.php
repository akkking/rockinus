<?php
session_start();
include 'dbconnect.php'; 
include 'emailfuc.php';
require("class.phpmailer.php");

$tag = 0;
$pagename = "JoinResult.php";
//$uname = $_POST['usrname'];
//$randcode = $_SESSION['randcode'];
$uschool=NULL;
$mschool=NULL;
$pschool=NULL;
$sstatus="Student";
$level=NULL;
$icon=NULL;  
//$cpasswd = $_POST['cpasswd']; 
//$sstatus = $_POST['sstatus']; 
$uname = trim($_POST['uname']);
$fname = ucfirst(strtolower($_POST['fname']));
$lname = ucfirst(strtolower($_POST['lname']));
$email = strtolower($_POST['email']);
$passwd = $_POST['passwd']; 
//$gender = strtolower($_POST['gender']);
$gender = $_POST['gender'];
//$emailcheck = $_POST['emailcheck'];    
//$rancode = $_POST['rancode'];    
//$hdf_rancode = $_POST['hdf_rancode'];
$chkcode = trim(getRam(32));
//$chkcodelink = "http://localhost/chkcode.php?rocker=".$uname."&&chkcode=".$chkcode; 
$chkcodelink = "http://www.rockinus.com/chkcode.php?rocker=".$uname."&&chkcode=".$chkcode; 
$chkcodelink_display = "http://www.rockinus.com/chkcode.php?rocker=".$uname."&&chkcode=".$chkcode;

if(strlen(trim($uname))<4){
	$_SESSION['joinus_rst_msg'] = "<div style='width:720; padding:5; background:#F5F5F5; height:25; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='left'>&nbsp;<img src=img/error_new.jpg width=18>&nbsp;&nbsp;<font color=#B92828><strong>User name is too short</strong></div>";
	$_SESSION['join_uname'] = $uname;
	$tag = 1;
	$pagename="main_join.php";
}

if($tag==0 && is_numeric(substr($uname,0,1))){
	$_SESSION['joinus_rst_msg'] = "<div style='width:720; padding:5; background:#F5F5F5; height:25; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='left'>&nbsp;<img src=img/error_new.jpg width=18>&nbsp;&nbsp;<font color=#B92828><strong>User name cannot be started with digit</strong></div>";
	$_SESSION['join_uname'] = $uname;
	$tag = 1;
	$pagename="main_join.php";
}

//if( $randcode!= $rancode ) {
//	$_SESSION['joinus_rst_msg'] = "<table height=30 style='background-color:#EEEEEE; width:660; margin-bottom:20px; border:2 #DDDDDD solid'><tr><td>&nbsp;&nbsp;<img src=img/error_new.jpg>&nbsp;&nbsp;</td><td><font color=#B92828><strong>Registration is unuccessful, because check code is incorrect, please try again.</strong></font></td></tr></table>";
//	$pagename="main.php";
//}

if( $tag==0 && (strlen(trim($fname))<2 || !ctype_alpha(trim($fname))) ) {
	$_SESSION['joinus_rst_msg'] = "<div style='width:720; padding:5; background:#F5F5F5; height:25; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='left'>&nbsp;<img src=img/error_new.jpg width=18>&nbsp;&nbsp;<font color=#B92828><strong>First name should be at least 2 letters</strong></div>";
	$tag=1;
	$pagename="main_join.php";
}else
	$_SESSION['fname'] = $fname;

if( $tag==0 && (strlen(trim($lname))<2 || !ctype_alpha(trim($lname))) ) {
	$_SESSION['joinus_rst_msg'] = "<div style='width:720; padding:5; background:#F5F5F5; height:25; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='left'>&nbsp;<img src=img/error_new.jpg width=18>&nbsp;&nbsp;<font color=#B92828><strong>Last name should be at least 2 letters</strong></div>";
	$tag=1;
	$pagename="main_join.php";
}else
	$_SESSION['lname'] = $lname;

if( $tag==0 && strlen(trim($email))==0 ) {
	$_SESSION['joinus_rst_msg'] = "<div style='width:720; padding:5; background:#F5F5F5; height:25; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='left'>&nbsp;<img src=img/error_new.jpg width=18>&nbsp;&nbsp;<font color=#B92828><strong>Please enter your school email</strong></div>";
	$tag = 1;
	$pagename="main_join.php";
}else 
	$_SESSION['email'] = $email;

if( $tag==0 && is_email($email) == 0 ) {
	$_SESSION['joinus_rst_msg'] = "<div style='width:720; padding:5; background:#F5F5F5; height:25; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='left'>&nbsp;<img src=img/error_new.jpg width=18>&nbsp;&nbsp;<font color=#B92828><strong>Please enter valid Email address</strong></div>";
	$tag = 1;
	$pagename="main_join.php";
}

if($tag==0 && strlen(trim($passwd))<6) {
	$_SESSION['joinus_rst_msg'] = "<div style='width:720; padding:5; background:#F5F5F5; height:25; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='left'>&nbsp;<img src=img/error_new.jpg width=18>&nbsp;&nbsp;<font color=#B92828><strong>Password is too short(longer than 6)</strong></div>";
	$tag = 1;
	$pagename="main_join.php";
}

//$stren = CheckPasswordStrength($passwd);
//if( $tag==0 && CheckPasswordStrength($passwd)<2 ){
//	$_SESSION['joinus_rst_msg'] = "<div style='width:720; padding:5; background:#F5F5F5; height:25; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='left'>&nbsp;<img src=img/error_new.jpg width=18>&nbsp;&nbsp;<font color=#B92828><strong>Password is not secure enough</strong></div>";
//	$tag = 1;
//	$pagename="main_join.php";
//} 

$passwd = md5($passwd);

//$_SESSION['joinus_rst_msg'] = $gender;
if( $tag==0 && strlen(trim($gender))==0 ) {
	$_SESSION['joinus_rst_msg'] = "<div style='width:720; padding:5; background:#F5F5F5; height:25; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='left'>&nbsp;<img src=img/error_new.jpg width=18>&nbsp;&nbsp;<font color=#B92828><strong>Please select your gender</strong></div>";
	$tag = 1;
	$pagename="main_join.php";
}else
	$_SESSION['gender'] = $gender;

if($tag==0){
	$qsql = "SELECT * FROM rockinus.user_check_info";
	$qresult = mysql_query($qsql);
	while($row = mysql_fetch_array($qresult)){
		if ( $uname == $row['uname'] ){
			$_SESSION['joinus_rst_msg'] = "<div style='width:720; padding:5; background:#F5F5F5; margin-bottom:10; height:25; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='left'>&nbsp;<img src=img/error_new.jpg width=18>&nbsp;&nbsp;<font color=#B92828><strong>This name has been used, please choose another one</strong></div>";
			$_SESSION['join_uname'] = $uname;
			$tag=1;
			$pagename="main_join.php";
			break;
		}

		if ( $email == $row['email'] ){
			$_SESSION['joinus_rst_msg'] = "<div style='width:720; padding:5; margin-bottom:10; background:#F5F5F5; height:25; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='left'>&nbsp;<img src=img/error_new.jpg width=18>&nbsp;&nbsp;<font color=#B92828><strong>Your Email has already been taken, please try another one</strong></div>";
			$_SESSION['email'] = $email;
			$tag=1;
			$pagename="main_join.php";
			break;
		}	
	}
}

if( $tag==0 ){
	smtp_mail($email, "Welcome to Rockinus.com", NULL, "admin@rockinus.com", $uname, $chkcodelink, "regist");
	
	$admin_body = "<strong>Name: </strong>".$fname.".".$lname."<br>";
	$admin_body .= "<strong>Email: </strong>".$email."<br>";
	$admin_body .= "<strong>Gender: </strong>".$gender."<br>";
	$admin_body .= "<strong>Date/Time: </strong>".date('m/d/Y h:i:s a', time())."<br><br>";
	
	smtp_mail("barmuya@hotmail.com", $uname." has joined", $admin_body, "admin@rockinus.com", $uname, "", "");
	
	$extra_string = "";
	if (strpos($email,'poly.edu') !== false) { 
//    echo 'true'; 
		$extra_string = "<br><br><br><a href='http://www.outlook.com'><div style='height:16; padding:3 8 3 8; background: url(img/master.png); width:150; border:1px solid #999999; border-top:1px solid #CCCCCC; border-left:1px solid #CCCCCC; font-size:12px; font-weight:normal; cursor:pointer; color:#000000' align='center'>Access Outlook Email</div></a>";
	} 
        
	$result = mysql_query("INSERT INTO rockinus.user_check_info (uname,email,passwd,status,chkcode,signup_date,signup_time, tbname) VALUES('$uname', '$email', '$passwd', 'P', '$chkcode', CURDATE(), NOW(), 'user_check_info')");
	if (!$result) die('Invalid query: ' . mysql_error());
	
	$result = mysql_query("INSERT INTO rockinus.user_info (uname, sstatus, fname, lname, fcountry, fregion, gender, tbname) VALUES('$uname', '$sstatus', '$fname', '$lname', 'empty', 'empty', '$gender', 'user_info')");
	if (!$result) die('Invalid query: ' . mysql_error());
	
	$result = mysql_query("INSERT INTO rockinus.user_points (uname, log_date, log_time, points) VALUES('$uname', CURDATE(), NOW(), 0)");
	if (!$result) die('Invalid query: ' . mysql_error());
	
	if(isset($_SESSION['join_uname']))unset($_SESSION['join_uname']);
	if(isset($_SESSION['fname']))unset($_SESSION['fname']);
	if(isset($_SESSION['lname']))unset($_SESSION['lname']);
	if(isset($_SESSION['email']))unset($_SESSION['email']);
	if(isset($_SESSION['gender']))unset($_SESSION['gender']);

	$_SESSION['rst_msg'] = "<img src='img/notification_done.png' width=25 />&nbsp;&nbsp;&nbsp; <strong><font color=#FF6600 style='font-size:28px'>$fname, everything almost set.</font></strong><br><br><font style='font-size:16px;'>Last step for you to go -> activation!<br>We have sent you confirmation email at <font color=#336699><strong>$email</strong></font><br> Please check your email and activate the account within 24 hours.$extra_string</font>";
	
}

header("location:$pagename");
mysql_close($link);
?> 