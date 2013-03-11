<?php 
session_start(); 
$uname = $_SESSION['usrname'];
include 'dbconnect.php';
include 'emailfuc.php';
require("class.phpmailer.php");
$sender = $_GET["sender"];
$_SESSION['rst_msg']="<div align='center' style='width:730; padding-top:10; padding-bottom:10; margin-top:10'><img src='img/addsuccessIcon_F5.jpg' width=20>&nbsp;&nbsp;<font size=3 color=$_SESSION[hcolor]><strong>Congratulations! $sender is now your friend.</strong></font><br><br><a href=RockerDetail.php?uid=$sender class=one><font size=3>Go Back</font></a></div>"; 

if( strlen(trim($sender))>0 && strlen(trim($uname))>0 ){
	$upd = mysql_query("UPDATE rockinus.rocker_rel_history SET rstatus='A', pdate=CURDATE(), ptime=NOW() WHERE sender='$sender' AND recipient='$uname'");
	if(!$upd) die(mysql_error());

	$sql = mysql_query("INSERT INTO rockinus.rocker_rel_info (sender, recipient, pdate, ptime) VALUES ('$sender', '$uname', CURDATE(), NOW())");
	if(!$sql) die(mysql_error());
	
	$q_recipient = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$uname'");
	if(!$q_recipient) die(mysql_error());
	$object = mysql_fetch_object($q_recipient);
	$fname = $object->fname;
	$lname = $object->lname;
	
	$q_email = mysql_query("SELECT email FROM rockinus.user_check_info WHERE uname='$sender'");
	if(!$q_email) die(mysql_error());
	$object = mysql_fetch_object($q_email);
	$email = $object->email;

	$body = "<table width='700' height='262' border='0' cellpadding='0' cellspacing='0' style='margin-bottom:40; margin-top:50; border:0 #006699 solid; background-color:' alight='left'>
            <tr>
              <td width='519' height='42' bgcolor='#336633'>&nbsp;</td>
              <td width='181' bgcolor='#336633' align='center'><font size=5 color=white>Rockinus.com</font></td>
            </tr>
            <tr>
              <td height='180' colspan='2' bgcolor='#EEEEEE'>
                <div align='center'>
                  <table width='684' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='684' align='left'>Dear ".$sender.", <br />
                          <br />
                        Just a notification that <strong><a href=http://03531d0.netsolhost.com/RockerDetail.php?uid=".$uname." class=one><font color=#336633>$uname</font></a> ($fname.$lname)</strong> has accept your request. <br>Enjoy, buddy :)<br><br>
                        Most Sincerely,<br />
                        Rockinus Team <br />
                        New York City U.S.
				</td>
                    </tr>
                  </table>
			    </div>
			  </td>
            </tr>
</table>";

	smtp_mail($email, $fname." is now your friend in Rockinus.com", $body, "admin@rockinus.com", $sender, "", ""); 
}

header("location:FriendGroupResult.php");
mysql_close($link);
?>