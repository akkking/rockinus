<?php
include 'dbconnect.php'; 
include 'emailfuc.php';
require("class.phpmailer.php");
session_start();
$pagename = "JoinResult.php";
$uname = $_GET['rocker']; 
$chkcode = trim($_GET['chkcode']); 

//$_SESSION['rst_msg'] = "112222".$uname."33333".$chkcode;

$qsql = "SELECT * FROM rockinus.user_check_info WHERE uname='$uname' AND chkcode='$chkcode'";
$qresult = mysql_query($qsql);
while($row = mysql_fetch_array($qresult)){
	if ( $row['status'] == 'P' ){
		$result = mysql_query("INSERT INTO rockinus.memo_info (sender,descrip,level,ptime,pdate) VALUES('$uname', NULL, 'A', NOW(), CURDATE())");
		if (!$result) die('Invalid query: ' . mysql_error());	

		$result = mysql_query("INSERT INTO rockinus.user_edu_info (uname, tbname) VALUES('$uname','user_edu_info')");
		if (!$result) die('Invalid query: ' . mysql_error());
	
		$result = mysql_query("INSERT INTO rockinus.user_contact_info (uname, tbname) VALUES('$uname','user_contact_info')");
		if (!$result) die('Invalid query: ' . mysql_error());
		
		$result = mysql_query("INSERT INTO rockinus.user_hobby_info (uname,ptime,pdate) VALUES('$uname',NOW(), CURDATE())");
		if (!$result) die('Invalid query: ' . mysql_error());
		
		$result = mysql_query("INSERT INTO rockinus.user_setting (uname, hcolor, lan, topi, priority) VALUES('$uname','#387A36', 'EN', 'slashopi', 'D')");
		if (!$result) die('Invalid query: ' . mysql_error());
		
		$result = mysql_query("INSERT INTO rockinus.user_custom_setting (uname, features, ccomment, eventnews, house, article, examQuestion, jobReferral, interviewQuestion) VALUES('$uname','N', 'N', 'N', 'N', 'N', 'N', 'N', 'N')");
		if (!$result) die('Invalid query: ' . mysql_error());
		
		$body ="With Rockinus, you can follow up with New York students\' openning jobs, internal referrals, interview questions, campus news and so on. You can also find apartments, roommates, useful things on sale very close to you. Reviewing what others say about courses you may be interested in. Commenting on courses to help others taking decison before registering the courses. Connecting with alumnus is rather practical. Do not lose people from your hometown, school and same city. What are you waiting for? Find them out in Rockinus.com. 
                         There is more for you to explore, hope you enjoy the experience. We make it simple, local and free.
                        <br />
						Please click on the following link to activate your account.<br />
                        We look forward to your visit and feedback. Enjoy :)
                        <br />
						Looking forward to your show-up.<br />
                        Warmly Regards,<br />
                        Rockinus Team <br />
                        New York City, USA";	
		$result = mysql_query("INSERT INTO rockinus.message_info (recipient, sender, subject, descrip, rstatus, ptime, pdate) VALUES('$uname','admin', 'Welcome to New York Community Network', '$body', 'N', NOW(), CURDATE())");
		if (!$result) die('Invalid query: ' . mysql_error());
		
		$result = mysql_query("INSERT INTO rockinus.user_email_setting (uname,features,frequest,message,ccomment,fcourse,fsupdate,srupdate,eventnews,house,article,roommate,headicon_like,interviewQuestion) VALUES('$uname','Y','Y','N','Y','N','Y','N','N','N','N','N','Y','N')");
		if (!$result) die('Invalid query: ' . mysql_error());
		
		$result = mysql_query("INSERT INTO rockinus.user_basic_setting (uname,whoVisit,directPage) VALUES('$uname','A','H')");
		if (!$result) die('Invalid query: ' . mysql_error());
		
		$sql = "INSERT INTO rockinus.user_log_info (uname,log_date,log_time, flag) VALUES('$uname', CURDATE(), NOW(), '1')";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		
		$result = mysql_query("UPDATE rockinus.user_check_info SET status='A' WHERE uname='$uname' AND chkcode='$chkcode'");
		if (!$result) die('Invalid query: ' . mysql_error());
		
		$result = mysql_query("INSERT INTO rockinus.user_points (uname, log_date, log_time, points) VALUES('$uname', CURDATE(), NOW(), 2)");
		if (!$result) die('Invalid query: ' . mysql_error());
				
		smtp_mail("barmuya@hotmail.com", $uname." has joined", "Formally joined", "admin@rockinus.com", $uname, "", "");
	
		$_SESSION['usrname'] = $uname;
		//$_SESSION['rst_msg'] = "<strong><font color=#336633 size=5>Congratulations!</font></strong><br><br><br><font size=3>You have successfully joined Rockinus.com <br><br>We have a lot of things collected for you, go enjoy now.</font>";
		$pagename = "homeProfileUpdater.php";
		$_SESSION['Delay'] = "OK";
		break;
	}else if ( $row['status'] == 'E' ){
		$chkcodelink = "http://www.rockinus.com/chkcode.php?rocker=".$uname."&&chkcode=".trim(getRam(32));
		smtp_mail($email, "Welcome to Rockinus.com", NULL, "admin@rockinus.com", $uname, $chkcodelink,"");  
		$_SESSION['rst_msg'] = "<strong><font color=#336633 size=5>Sorry...</font></strong><br><br><br>Your registration has been expired over 24 hours, but don't worry. <br><br> A new email has been sent to .".$email.", please check it within 24 hours";
		break;
	}else 
		$pagename = "homeProfileUpdater.php";
}

header("location:$pagename");
mysql_close($link);
?> 