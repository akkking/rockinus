<?php 
include ("dbconnect.php");
include 'emailfuc.php';
require("class.phpmailer.php");
session_start();
$sender = htmlspecialchars(trim($_POST['sender']));
$recipient = htmlspecialchars(trim($_POST['recipient']));

// Get Latest Headicon ID
$headicon_id = 0;
$q_m = mysql_query("SELECT headicon_id FROM rockinus.headicon_history WHERE uname='$recipient' ORDER BY headicon_id DESC");
if(!$q_m) die(mysql_error());
$no_row = mysql_num_rows($q_m);
if($no_row == 0){
//echo("Error, head icon not found");
}else{
	$object = mysql_fetch_object($q_m);
	$headicon_id = $object->headicon_id;
}
	
$q_like_headicon = mysql_query("SELECT * FROM rockinus.headicon_like WHERE uname='$sender' AND headicon_id='$headicon_id'");
if(!$q_like_headicon) die(mysql_error());
$no_row_headicon = mysql_num_rows($q_like_headicon);
if($no_row_headicon == 0){
	$sql = "INSERT INTO rockinus.headicon_like(headicon_id,uname,rstatus,pdate,ptime)VALUES('$headicon_id','$sender','N',CURDATE(),NOW())";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	echo("<div style='background-image:; background: ; margin-bottom:5px; display:inline; height:15px; color:$_SESSION[hcolor]; font-weight:bold; font-size:14px'><img src='img/headicon_like.png' width='12' />&nbsp; You like it.</div>"); 
	
	$q_sender = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$sender'");
	if(!$q_sender) die(mysql_error());
	$object_sender = mysql_fetch_object($q_sender);
	$sender_fname = $object_sender->fname;
	$sender_lname = $object_sender->lname;
	
	$q_recipient = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$recipient'");
	if(!$q_recipient) die(mysql_error());
	$object_recipient = mysql_fetch_object($q_recipient);
	$recipient_fname = $object_recipient->fname;
	$recipient_lname = $object_recipient->lname;
	
	$q_email = mysql_query("SELECT a.email, b.headicon_like FROM rockinus.user_check_info a JOIN rockinus.user_email_setting b ON a.uname=b.uname AND b.uname='$recipient';");
	if(!$q_email) die(mysql_error());
	$no_row_email = mysql_num_rows($q_email);
	if($no_row_email>0){
		$object_recipient = mysql_fetch_object($q_email);
		$recipient_email = $object_recipient->email;
		$recipient_headicon_like = $object_recipient->headicon_like;
		if($recipient_headicon_like=='Y'){
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
                        Just a notification that <strong><a href=http://www.rockinus.com/RockerDetail.php?uid=".$sender." class=one><font color=#336633>$sender_fname $sender_lname</font></a></strong> likes your new head icon :)<br><a href=http://www.rockinus.com/RockerDetail.php?uid=$recipient class=one>Go check it</a> <br />
                        <br />
						<font color=#999999>(If you don't need further notification on this, you could kindly cancel it in user setting section)</font> 
						<br />
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
			smtp_mail($recipient_email, $sender." likes your head icon in Rockinus.com", $body, "admin@rockinus.com", $sender, "", ""); 
		//echo("Request Sent!");
		}
	}
}
?>