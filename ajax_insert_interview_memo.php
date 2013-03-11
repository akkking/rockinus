<?php
include 'dbconnect.php';
include 'Allfuc.php';
include 'emailfuc.php';
require("class.phpmailer.php");
session_start();
 
if(isset($_POST['content']))
{
 $content=$_POST['content'];
 $q_id=$_POST['q_id'];
 $sender=$_POST['sender'];
 $pdate=$_POST['pdate'];
 $ptime=$_POST['ptime'];
 mysql_query("INSERT INTO rockinus.interview_question_follow(descrip,q_id,uname,pdate,ptime, rstatus) VALUES ('$content','$q_id','$sender','$pdate', '$ptime','N');");
 $sql_in= mysql_query("SELECT descrip, q_follow_id FROM rockinus.interview_question_follow WHERE q_id='$q_id' ORDER BY q_follow_id DESC");
 $object = mysql_fetch_object($sql_in);
 $descrip = $object->descrip; 
 }
 
 $q_interview_memo = mysql_query("SELECT creater FROM rockinus.interview_question WHERE q_id='$q_id'");
 if(!$q_interview_memo) die(mysql_error());
 $object_interview_memo = mysql_fetch_object($q_interview_memo);
 $sender = $object_interview_memo->creater;
 
 $q_sender = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$sender'");
 if(!$q_sender) die(mysql_error());
 $object_sender = mysql_fetch_object($q_sender);
 $sender_fname = $object_sender->fname;
 $sender_lname = $object_sender->lname;
 
 	$q_email = mysql_query("SELECT a.email, b.fname FROM rockinus.user_check_info a JOIN rockinus.user_info b JOIN rockinus.user_email_setting c WHERE a.uname='$recipient' AND a.uname=b.uname AND a.uname=c.uname AND c.srupdate='Y'");
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
                        This is an update that <strong><a href=http://03531d0.netsolhost.com/RockerDetail.php?uid=".$sender." class=one><font color=#336633>$sender</font></a> ($sender_fname.$sender_lname)</strong> has commented on your status.<br><a href=http://03531d0.netsolhost.com/ManageStatus.php?uid=$sender class=one>Go check it</a> <br />
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

		smtp_mail($recipient_email, $sender." commented your status in Rockinus.com", $body, "admin@rockinus.com", $sender, "", ""); 
		//echo("Request Sent!");
	}
?>
<table width="460" height="51" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-left:6px solid #EEEEEE; margin-top:5px">
  <tr>
    <td width="466" height="20" align="left" valign="top" bgcolor="#F5F5F5" style="padding:5 10 5 10; font-size:12px;">
	<?php echo("<strong> <a href=RockerDetail.php?uid=$sender class=one><FONT color=$_SESSION[hcolor]>$sender_fname $sender_lname</font></a></strong>") ?> </td>
    <td width="134" height="20" align="right" valign="top" bgcolor="#F5F5F5" style="font-size:11px; padding:5 5 5 10; color:#666666"><?php echo(getDateName($pdate)) ?> | <?php echo(substr($ptime,0,5)) ?> </td>
  </tr>
  <tr>
    <td height="23" colspan="2" valign="top" style="line-height:150%; font-size:11px; padding:0 10 5 10;"><?php
													if(strlen($descrip)>500)
														echo(substr(nl2br($descrip),0,500)." ...<br>");
													else
														echo(nl2br($descrip));
												?>    </td>
  </tr>
</table>
