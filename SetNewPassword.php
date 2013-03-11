<?php
include 'dbconnect.php'; 
include 'emailfuc.php';

session_start();
$pagename = "JoinResult.php";
$uname = $_GET['rocker']; 
$chkcode = trim($_GET['chkcode']); 

//$_SESSION['rst_msg'] = "112222".$uname."33333".$chkcode;

$qsql = "SELECT * FROM rockinus.user_check_info WHERE uname='$uname' AND chkcode='$chkcode'";
$qresult = mysql_query($qsql);
while($row = mysql_fetch_array($qresult)){
	if ( $row['status'] == 'P' ){			
		$_SESSION['rocker'] = $uname;
		$_SESSION['rst_msg'] = "<strong><font color=#336633 size=5>Congratulations!</font></strong><br><br><br>Welcome to Rockinus. <br><br>A lot of surprises are waiting for you, enjoy it now.";
		break;
	}else if ( $row['status'] == 'E' ){
		$chkcodelink = "http://localhost/chkcode.php?rocker=".$uname."&&chkcode=".trim(getRam(32));
		smtp_mail($email, "Welcome to Rockinus.com", NULL, "admin@rockinus.com", $uname, $chkcodelink, "passwd");  
		$_SESSION['rst_msg'] = "<strong><font color=#336633 size=5>Sorry...</font></strong><br><br><br>Your registration has been expired over 24 hours, but don't worry. <br><br> A new email has been sent to .".$email.", please check it within 24 hours";
		break;
	}else 
		$pagename = "ThingsRock.php";
}

header("location:$pagename");
mysql_close($link);
?> 