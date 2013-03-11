<?php
include 'dbconnect.php'; 
include 'emailfuc.php';
require("class.phpmailer.php");

session_start();
$pagename = "JoinResult.php";
//$uname = $_POST['usrname'];
$uname = $_POST['uname']; 
$randcode = $_SESSION['randcode'];
$email = strtolower($_POST['email']);;    
$rancode = $_POST['rancode'];	
$chkcode = trim(getRam(32));
$chkcodelink = "http://03531d0.netsolhost.com/NewPassword.php?rocker=".$uname."&&chkcode=".$chkcode; 

if( $uname == "" || $uname==NULL ) {
	$_SESSION['uname_rst_msg'] = "<div style='background-color:#FFFFFF; width:200; padding-bottom:5; padding-top:5; border:0 #DDDDDD solid; font-size:11px'><font color=#B92828><strong>&nbsp;&nbsp;User name is not entered</strong></font></div>";
	$pagename="main_findPass.php";
}

if( $email == "" || $email==NULL  ) {
	$_SESSION['email_rst_msg'] = "<div style='background-color:#FFFFFF; width:200; padding-bottom:5; padding-top:5; border:0 #DDDDDD solid; font-size:11px'><font color=#B92828><strong>&nbsp;&nbsp;Email address is required</strong></font></div>";
	$pagename="main_findPass.php";
}else if( is_email($email) == 0 ) {
	$_SESSION['email_rst_msg'] = "<div style='background-color:#FFFFFF; width:200; padding-bottom:5; padding-top:5; border:0 #DDDDDD solid; font-size:11px'><font color=#B92828><strong>&nbsp;&nbsp;.edu email is required</strong></font></div>";
	$pagename="main_findPass.php";
}

if( $randcode!= $rancode ) {
	$_SESSION['chk_rst_msg'] = "<div style='background-color:#FFFFFF; width:200; padding-bottom:5; padding-top:5; border:0 #DDDDDD solid; font-size:11px'><font color=#B92828><strong>&nbsp;&nbsp; Check Code is incorrect</strong></font></div>";
	$pagename="main_findPass.php";
}

if( $pagename=="JoinResult.php" ){
	$qresult = mysql_query("SELECT * FROM rockinus.user_check_info WHERE uname='$uname';");
	$no_row = mysql_num_rows($qresult);
	if($no_row == 0){
	$_SESSION['uname_rst_msg'] = "<div style='background-color:#FFFFFF; width:200; padding-bottom:5; padding-top:5; border:0 #DDDDDD solid; font-size:11px'><font color=#B92828><strong>&nbsp;&nbsp;&nbsp;User name $uname does not exist</strong></font></div>";
		$pagename="main_findPass.php";
	}else{
		$row = mysql_fetch_array($qresult);
 		if( $email != $row['email'] ){
			$_SESSION['email_rst_msg'] = "<div style='background-color:#FFFFFF; padding-bottom:5; padding-top:5; border:0 #DDDDDD solid; font-size:11px'><font color=#B92828><strong>&nbsp;&nbsp;&nbsp;$email does not match $uname</strong></font></div>";
			$pagename="main_findPass.php";
		}
	}
}

if( $pagename=="JoinResult.php" ){
//$_SESSION['usrname']=$uname;
//setcookie("user", $uname, time()+3600);
	$result = mysql_query("UPDATE rockinus.user_check_info SET chkcode='$chkcode' WHERE uname='$uname'");
	if (!$result) die('Invalid query: ' . mysql_error());
		
	smtp_mail($email, "Password Reset Request", NULL, "admin@rockinus.com", $uname, $chkcodelink, "passwd");        
	$_SESSION['rst_msg'] = "<strong><font color=#FF6600 size=5>Submitted!</font></strong><br><br><font size=3>An email has been sent to $email <br><br> Please check your email and renew the password within 24 hours.</font>";
}

header("location:$pagename");
mysql_close($link);
?> 