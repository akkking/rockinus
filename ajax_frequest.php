<?php
include ("dbconnect.php");
include 'emailfuc.php';
require("class.phpmailer.php");

// CLIENT INFORMATION
$sender        = htmlspecialchars(trim($_POST['sender']));
$recipient     = htmlspecialchars(trim($_POST['recipient']));

$rel_exist = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$sender' AND recipient='$recipient' AND rstatus='P';");
if(!$rel_exist) die(mysql_error());
if( mysql_num_rows($rel_exist) > 0 ){
	echo("Already Requested");
}else if( strlen(trim($sender))>0 && strlen(trim($recipient))>0 ){
	$sqlstmt = "INSERT INTO rockinus.rocker_rel_history (sender, recipient, rstatus, descrip, pdate, ptime)VALUES('$sender', '$recipient', 'P', NULL, CURDATE(), NOW())";
	mysql_query($sqlstmt) or die(mysql_error());

	$q_sender = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$sender'");
	if(!$q_sender) die(mysql_error());
	$object_sender = mysql_fetch_object($q_sender);
	$fname = $object_sender->fname;
	$lname = $object_sender->lname;
	
	$q_email = mysql_query("SELECT a.email, b.fname FROM rockinus.user_check_info a JOIN rockinus.user_info b JOIN rockinus.user_email_setting c WHERE a.uname='$recipient' AND a.uname=b.uname AND a.uname=c.uname AND c.frequest='Y'");
	if(!$q_email) die(mysql_error());
	$no_row_email = mysql_num_rows($q_email);
	if($no_row_email>0){
		$object_recipient = mysql_fetch_object($q_email);
		$recipient_email = $object_recipient->email;
		$recipient_fname = $object_recipient->fname;
	
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
                      <td width='684' align='left'>Dear ".$recipient_fname.", <br />
                          <br />
                        This is an update that <strong><a href=http://www.rockinus.com/RockerDetail.php?uid=".$sender." class=one><font color=#336633>$sender</font></a> ($fname.$lname)</strong> has sent you a friend request.<br><a href=http://www.rockinus.com/FriendGroup.php?friendreq=1 class=one>Process the request now</a> <br />
                        <br />
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

		smtp_mail($recipient_email, $sender." wants to be your friend in Rockinus.com", $body, "admin@rockinus.com", $sender, "", ""); 
		echo("Request Sent!");
	}
}else
	echo("Error..");

?>