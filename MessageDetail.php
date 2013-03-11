<?php 
include("mainHeader.php");
include("Allfuc.php");
include 'dbconnect.php';
$uname = $_SESSION['usrname'];
  
$unameImg = "upload/$uname/$uname"."60.jpg";
if(file_exists($unameImg))
	$unameImg = "<div style='height:50;overflow-x:hidden;overflow-y:hidden;' align='left'><img src='$unameImg' width='40' style='border:0px solid #DDDDDD'></div>"; 
	else
	$unameImg = "<img src='img/NoUserIcon100.jpg' width=50 style='border:0px solid #DDDDDD'>";
  
$pic210_Name = $uname.'210.jpg';
$ProPercent = 70;

include 'emailfuc.php';
require("class.phpmailer.php");

$pagename = "MessageDetail.php";

if(isset($_POST['replySubmit'])){
	$msgid = $_POST['msgid'];
	$replycontent = $_POST['replycontent'];
	$t = mysql_query("SELECT * FROM rockinus.message_info WHERE msgid=$msgid");
	if(!$t) die(mysql_error());
	$obj = mysql_fetch_object($t);
	$sender = $obj->sender;
	$recipient = $obj->recipient;
	$rstatus = $obj->rstatus;
	$subject = $obj->subject;
	
	$from_who = $sender;
	$receiver = $recipient;
	if($uname==$recipient) {
		$from_who = $recipient;
		$receiver=$sender;
	}
	
	$replycontent = str_replace("\\","", $replycontent);
	$replycontent = str_replace("'","\'", $replycontent);
	$postsender = $_POST['sender'];
	$postrecipient = $_POST['recipient'];
	
	if(strlen(trim($replycontent))>0){
		$sql = "INSERT INTO rockinus.message_history (msgid,sender,recipient,descrip,rstatus,pdate,ptime) VALUES('$msgid','$postsender','$postrecipient','$replycontent','N', CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());

		if(isset($_POST['mail_yesno'])){
			$q_email = mysql_query("SELECT email FROM rockinus.user_check_info WHERE uname='$receiver'");
			if(!$q_email) die(mysql_error());
			$object = mysql_fetch_object($q_email);
			$email = $object->email;
			//$email = "barmuya@hotmail.com";    
			$body = "<table width='700' height='262' border='0' cellpadding='0' cellspacing='0' style='margin-bottom:40; margin-top:50; border:0 #006699 solid; background-color:' alight='left'>
            	<tr>
           		<td width='519' height='42' bgcolor='#336633'>&nbsp;</td>
           	  	<td width='181' bgcolor='#336633' align='center'><font size=5 color=white>Rockinus.com</font></td>
           	</tr>
           	<tr>
              		<td height='218' colspan='2' bgcolor='#EEEEEE'>
                	<div align='center'>
                  	<table width='684' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='684' align='left'>Dear ".$receiver.", <br />
                          <br />
                        Just a reminder that <strong><a href=http://03531d0.netsolhost.com/RockerDetail.php?uid=".$from_who." class=one><font color=#336633>".$from_who."</font></strong></a> has sent you message in our local social network.<br>
                        <hr />
						".nl2br($replycontent)."
                        <br /><br />
						<a href='http://www.rockinus.com'>Click here to the website</a> <br /><br />
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

			smtp_mail($email, $sender." has sent you a message in Rockinus.com", $body, "admin@rockinus.com", $sender, "", ""); 
		}

	//if( $recipient==$uname){
	//	$subject = addslashes("RE_".$subject);
	//	$upd = mysql_query("UPDATE rockinus.message_info SET subject='$subject', sender='$postsender', recipient='$postrecipient' WHERE msgid='$msgid'");
	//	if(!$upd) die(mysql_error());
	//}

		$rst_msg = "<img src=img/addsuccessIcon_F5.jpg width=12 />&nbsp;&nbsp;&nbsp;<font style='color:#000000; font-weight:;'> Message has been sent successfully!</font>";
	//mysql_close($link);
	}else{
		
		$rst_msg = "<img src=img/error_new.jpg width=12 />&nbsp;&nbsp;&nbsp;<font style='color:#B92828; font-weight: normal;'>You haven't written anything, please check ...</font>";
	}
		
	$_SESSION['rst_msg']="<table style='margin-bottom:5px'><tr><td align='left' style='width:730; border:0px solid #DDDDDD; padding-top:5 10 5 10; height:20; background-color:; font-size:12px'>$rst_msg<br></td></tr></table>"; 
	$_SESSION['msg_id'] = $msgid;
}

if(isset($_GET["msgid"])){
	$msgid = $_GET["msgid"];
	
	$x = mysql_query("SELECT * FROM rockinus.message_info WHERE msgid='$msgid'");
	if(!$x) die(mysql_error());
	$obj = mysql_fetch_object($x);
	$sender = $obj->sender;
	$recipient = $obj->recipient;
	$rstatus = $obj->rstatus;

//echo($sender.",".$uname);
	$t1 = mysql_query("SELECT * FROM rockinus.message_info WHERE msgid=$msgid");
	if(!$t1) die(mysql_error());
	$no_row_info = mysql_num_rows($t1);

	$t2 = mysql_query("SELECT * FROM rockinus.message_history WHERE recipient='$uname' AND msgid=$msgid");
	if(!$t2) die(mysql_error());
	$no_row_hist = mysql_num_rows($t2);

	if($no_row_info>0){
		$t = mysql_query("UPDATE rockinus.message_info SET rstatus='Y' WHERE msgid='$msgid' AND rstatus='N'");
		if(!$t) die(mysql_error());
	}
	
	if($no_row_hist>0){	
		$upd = mysql_query("UPDATE rockinus.message_history SET rstatus='Y' WHERE msgid='$msgid' AND recipient='$uname' AND rstatus='N'");
		if(!$upd) die(mysql_error());
	}	
}else if(isset($_SESSION['msg_id'])) $msgid = $_SESSION['msg_id'];
else die("URL Error!");

$q = mysql_query("SELECT * FROM rockinus.message_info WHERE msgid=$msgid");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$sender = $object->sender;
$orig_sender = $sender;
$recipient = $object->recipient;
$orig_recipient = $recipient;
$iostatus = $object->iostatus;
$subject = $object->subject;
$descrip = $object->descrip;
$descrip = str_replace("\\","",nl2br($descrip));
$pdate = $object->pdate;
$ptime = $object->ptime;

$q_sender = mysql_query("SELECT * FROM rockinus.user_info WHERE uname='$sender'");
if(!$q_sender) die(mysql_error());
$object_sender = mysql_fetch_object($q_sender);
$sender_fname = $object_sender->fname;
$sender_lname = $object_sender->lname;

$q_recipient = mysql_query("SELECT * FROM rockinus.user_info WHERE uname='$recipient'");
if(!$q_recipient) die(mysql_error());
$object_recipient = mysql_fetch_object($q_recipient);
$recipient_fname = $object_recipient->fname;
$recipient_lname = $object_recipient->lname;
?>
<div align="center">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="257" align="left" valign="top" style=" padding:15px">
	  <?PHP
	  include "MessageMenu.php";
	  ?>
	  </td>
      <td width="767" align="left" valign="top" style="padding-top:20">
	  <?php 
	  if(isset($_SESSION['rst_msg'])){
	  	echo($_SESSION['rst_msg']);
		unset($_SESSION['rst_msg']);
	  }
	  ?>
	  <table width="740" height="394" border="0" cellpadding="0" cellspacing="0" style="border:#DDDDDD 0 solid">
          <tr>
            <td width="740" align="left" valign="top"><table width="740" height="500" border="0" cellpadding="0" cellspacing="0" style="border:0px solid #DDDDDD; margin-bottom:15px; background:#FFFFFF">
                  <tr>
                    <td width="90" height="35" align="right" style="border-bottom:#EEEEEE solid 0;padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">From</td>
                    <td width="475" height="35" style="border-bottom:#F5F5F5 solid 1px; padding-left:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif">
					<?php 
					if($iostatus=="I" && trim($sender)!="admin")
						echo("<a href=RockerDetail.php?uid=$sender class=one><font color=$_SESSION[hcolor]>$sender_fname $sender_lname</font></a>"); 
					else{
						if(trim($sender)=="admin")
							echo("<font color=$_SESSION[hcolor]>$sender</font><font style='font-size:14px' color='#999999'>&nbsp;&nbsp;(You cannot reply to admin)</font>");
						else
							echo("<font color=$_SESSION[hcolor]>$sender</font><font style='font-size:14px' color='#999999'>&nbsp;&nbsp;(You cannot reply this message, this is an outside visitor)</font>");							
					}
					?>					</td>
                    <td width="175" height="35" align="right" style="border-bottom:#EEEEEE dotted 1px; font-size:11px; font-family:Arial, Helvetica, sans-serif; padding-right:15px">
					<? echo("<font color=#999999>Timestamp: ".getDateName($pdate)." | $ptime</font>") ?>					</td>
                  </tr>
                  <tr>
                    <td height="35" align="right" style="border-bottom:#EEEEEE solid 0px;padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">To</td>
                    <td height="35" colspan="2" style="border-bottom:#F5F5F5 solid 1px; padding-left:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif">
					<?php echo("<a href=RockerDetail.php?uid=$recipient class=one><font color=$_SESSION[hcolor]>$recipient_fname $recipient_lname</font></a>") ?>					</td>
                  </tr>
                  <tr>
                    <td width="90" height="35" align="right" style="padding-right:15px; font-size:14px; border-bottom:0px solid #EEEEEE; font-family:Arial, Helvetica, sans-serif">Title</td>
                    <td height="35" colspan="2" style="border-bottom:#F5F5F5 solid 1px; padding-left:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif; color:<?php echo($_SESSION['hcolor'])?>; font-weight:bold">
					<?php echo($subject) ?></td>
                  </tr>
                  <tr>
                    <td height="39" align="left" valign="top" style="padding-left:25px; padding-top:20px">&nbsp;</td>
                    <td height="39" colspan="2" align="left" valign="top" style="padding:10px 10px 25px 10px; line-height:130%; font-size:14px; font-family:Arial, Helvetica, sans-serif; background-color:#F5F5F5">
					<?php echo($descrip) ?>					</td>
                  </tr>
                  <tr>
                    <td height="100" align="left" valign="top" style="padding-left:25px; padding-top:20px">&nbsp;</td>
                    <td height="100" colspan="2" align="left" valign="top" style="padding-left:0; padding-top:0">
					  <table width="600" border="0" cellpadding="0" cellspacing="0" style="margin-top:0px">
                        <tr>
                          <td width="600" height="112" colspan="3">
						  <?php
$q1 = mysql_query("SELECT * FROM rockinus.message_history WHERE msgid='$msgid' ORDER BY pdate ASC, ptime ASC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("");}
if($no_row > 0){ 
while($object = mysql_fetch_object($q1)){
	$msgid = $object->msgid;
	$sender = $object->sender;
	$recipient = $object->recipient;
	$descrip = $object->descrip;
	$ptime = $object->ptime;
	$pdate = $object->pdate; 
?>
                              <div style="padding-left:0; padding-right:0; line-height:180%; padding-top:5; padding-bottom:2; margin-bottom:0;  width: 650px; border-top:1px #EEEEEE solid">
                                <table width="650" height="56" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="30" height="20" align="left" valign="top" style=" color:<?php echo($_SESSION['hcolor']) ?>; padding-top:5px; padding-right:; font-size:14px; font-family:Arial, Helvetica, sans-serif">
									<img src="img/courseAjaxIcon.jpg" width="15" />									</td>
                                    <td width="284" height="20" align="left" valign="top" style=" color:<?php echo($_SESSION['hcolor']) ?>; padding-top:5px; font-size:14px; font-family:Arial, Helvetica, sans-serif">
									<?php if($sender==$uname)echo("You");else echo($sender); ?>									</td>
                                    <td width="165" height="20" align="center" >&nbsp;</td>
                                    <td width="171" height="20" align="right" style="color: #999999; font-size:11px; padding-right:10px;">
									<?php echo(getDateName($pdate)) ?> | <?php echo(substr($ptime,0,5)) ?></td>
                                  </tr>
                                  <tr>
                                    <td height="33" colspan="4" style="padding:5 15 10 30; line-height:130%; font-size:14px; font-family: Arial, Helvetica, sans-serif">
									<?php
										echo(nl2br($descrip));
									?>								    </td>
                                  </tr>
                                </table>
                              </div>
                          <?php }}?></td>
                        </tr>
                      </table>
					  <?php
	if( $iostatus=="I" && trim($sender)!="admin"){
	?>
					  <form action="MessageDetail.php" method="post" style="margin-top:10px; margin-bottom:20px">
                      <table width="650" border="0" cellpadding="0" cellspacing="0" style="border:#DDDDDD solid 0px">
                        <tr>
                          <td width="65" rowspan="2" align="left" valign="top" bgcolor="#F5F5F5" style="padding:10; border-top:0px solid #999999">
						  <?php echo($unameImg) ?>						  </td>
                          <td width="585" height="86" align="left" bgcolor="#F5F5F5" style="padding:10 10 10 0; border-top:0px solid #999999">
						  <textarea name="replycontent" rows="12" style="width:555; height:150; line-height:130%; padding:4px; font-size:14px; font-family:Arial, Helvetica, sans-serif" id="styled"></textarea>
						  </td>
                        </tr>
                        <tr>
                          <td height="33" align="left" bgcolor="#F5F5F5" style=" font-size:12px; font-family: Arial, Helvetica, sans-serif; padding-left:0 0 10 0">
						  <input type="submit" name="replySubmit" value="Submit" style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:0px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif" />&nbsp;&nbsp; 
						  <input type="checkbox" name="mail_yesno" />&nbsp;&nbsp;Also send a copy to user's email
						  <input type="hidden" name="msgid" value=<?php echo($msgid) ?> />
						  <input type="hidden" name="sender" value=<?php echo($uname) ?> />
                          <input type="hidden" name="recipient" value=<?php if($uname==$orig_sender)echo($orig_recipient); else echo($orig_sender); ?> />&nbsp;						  </td>
                        </tr>
                      </table>
                    </form>	
	 <?php } ?>					</td>
                  </tr>
              </table>
		    </td>
          </tr>
        </table>
      </td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
