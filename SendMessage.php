<?php 
include "mainHeader.php";
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
include("dbconnect.php"); 
include 'emailfuc.php';
require("class.phpmailer.php");
$pic210_Name = $uname.'210.jpg';
$ProPercent = 70;

if(isset($_POST['sendSubmit'])){	
	$tag = 0;
	$sender = $_SESSION['usrname']; 
	$subject = addslashes($_POST['subject']);
	$subject = str_replace("\\","",$subject);
	$subject = str_replace("'","\'",$subject);
	$recipient = $_POST['recipient'];
	$description = addslashes($_POST['description']);
	$description = str_replace("\\","",$description);
	$description = str_replace("'","\'",$description);
	
	if($recipient==NULL || strlen($recipient)==0){
		$tag = 1;
		$rst_msg = "Whom do you want to send?";
	}else
		$_SESSION['recipient'] = $recipient;
	
	if( ( $subject==NULL || strlen($subject)==0 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "Subject is not filled?";
	}else
		$_SESSION['subject'] = $subject;
	 
	if( ( $description==NULL || strlen($description)==0 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "No content filled, please check";
	}else{
		$_SESSION['descrip'] = $description;
//	 	echo $description;
	 }  
	$t = mysql_query("SELECT count(*) as cnt FROM rockinus.user_info WHERE uname='$recipient'");
	$a = mysql_fetch_object($t);
	$total_items = $a->cnt;
	
	if($total_items!=1 && $tag==0 ){
		$tag = 1;
		$rst_msg = "The user you want to send does not exist";
	}
	
	if($tag==0){	
		$sql = "INSERT INTO rockinus.message_info (subject,recipient,descrip,iostatus,rstatus,sender,pdate,ptime)VALUES('$subject','$recipient','$description','I','N','$sender',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		
		if(isset($_POST['mail_yesno'])){
			$q_email = mysql_query("SELECT email FROM rockinus.user_check_info WHERE uname='$recipient'");
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
              		<td height='230' colspan='2' bgcolor='#EEEEEE'>
                	<div align='center'>
                  	<table width='684' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='684' align='left'><br>Dear ".$recipient.", <br />
                          <br />
                        Just a reminder that <strong><a href=http://03531d0.netsolhost.com/FreeTourUser.php?uid=".$sender." class=one><font color=#336633>".$sender."</font></strong></a> has sent you a message in our local social network.<br>
                        <hr />
						\"".nl2br($description)."\"
                        <br /><br />
						<a href='http://www.rockinus.com'>Click here to the website</a> <br /><br />
						Most Sincerely,<br />
                        Rockinus Team <br />
                        New York City U.S.<br /><br />
						</td>
                    </tr>
                  </table>
			    </div>
			  </td>
            </tr>
			</table>";
				
			//$rst_msg = $email. $sender." has sent you a message in Rockinus.com". $body. "admin@rockinus.com". $sender. "". "";
			smtp_mail($email, $sender." has sent you a message in Rockinus.com", $body, "admin@rockinus.com", $sender, "", ""); 
		}
		
		$r_recipient = mysql_query("SELECT * FROM rockinus.user_info WHERE uname='$recipient'");
		if(!$r_recipient) die(mysql_error());
		$object_recipient = mysql_fetch_object($r_recipient);
		$r_fname = $object_recipient->fname;
		$r_lname = $object_recipient->lname;
		
		$rst_msg = "<img src=img/addsuccessIcon.jpg width=12 />&nbsp;&nbsp; Message has been sent to $r_fname $r_lname successfully!";
		if(isset($_SESSION['recipient']))unset($_SESSION['recipient']);
		if(isset($_SESSION['subject']))unset($_SESSION['subject']);
		if(isset($_SESSION['descrip']))unset($_SESSION['descrip']);
		//mysql_close($link);
		$_SESSION['rst_msg']="<div align='left' style='width:720px; height:20; margin-bottom:5; background-color:; font-size:12px; color:$_SESSION[hcolor]; font-weight:bold; padding:5 10 5 10;font-family:Arial, Helvetica, sans-serif'>$rst_msg</div>"; 
	}else
	$_SESSION['rst_msg']="<div align='left' style='width:720px; height:20; margin-bottom:5; background-color:; font-size:12px; color:#B92828; font-weight:bold; padding:5 10 5 10;font-family:Arial, Helvetica, sans-serif'>&nbsp;<img src=img/error_new.jpg width=15 />&nbsp;&nbsp;&nbsp;$rst_msg</div>"; 
	//header("location:MessageProfileResult.php");
}

if(isset($_GET["recipient"])) $recipient = $_GET["recipient"];
else $recipient = "";
//include("Header.php"); 
?><style type="text/css">
<!--
body,td,th {
	font-size:14px;
}
-->
</style>
<div align="center">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="padding-top:0; margin-top:0;">
    <tr>
      <td width="300" align="left" valign="top" style=" padding-left:15px; padding-top:15px">
	  <?php include "MessageMenu.php" ?>
	  </td>
      <td width="760" align="left" valign="top" style="padding-top:25px">
	  <?php 
	  if(isset($_SESSION['rst_msg'])){
	  	echo($_SESSION['rst_msg']);
		unset($_SESSION['rst_msg']);
	  }
	  ?>
	  <table width="720" height="347" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid; margin-bottom:15px;  -moz-border-radius: 5px; border-radius: 5px; ">
          <tr>
            <td height="345" align="center" valign="top" style="padding-top:25px">
			<form action="SendMessage.php" method="post">
              <table width="740" height="345" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="118" height="30" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">
				  <strong>Send to</strong></td>
                  <td width="622" align="left" style="padding-right:8px"height="30">
				  <?php 
				  if( ($recipient==NULL || strlen($recipient)==0) && !isset($_SESSION['recipient'])){
						include 'dbconnect.php';
				  		$q = mysql_query("SELECT sender AS frienduname FROM rockinus.rocker_rel_info WHERE recipient='$uname' 
										UNION 
										SELECT recipient AS frienduname FROM rockinus.rocker_rel_info WHERE sender='$uname'
										ORDER BY frienduname ASC");
						if(!$q) die(mysql_error());
						$friend_num = mysql_num_rows($q);
						if($friend_num == 0) echo("<input type=text name=recipient size=15 class=box style='font-size:14px; font-family:Arial, Helvetica, sans-serif; height:20'>");
						else{
							echo("<select name=recipient style='font-size:14px; height:22px; font-family:Arial, Helvetica, sans-serif'>"); 
							while($obj = mysql_fetch_object($q)){
								$frienduname = trim($obj->frienduname);
								$q_recipient = mysql_query("SELECT * FROM rockinus.user_info WHERE uname='$frienduname'");
								if(!$q_recipient) die(mysql_error());
								$object_recipient = mysql_fetch_object($q_recipient);
								$friend_fname = $object_recipient->fname;
								$friend_lname = $object_recipient->lname;
								echo ("<option value=$frienduname>$friend_fname $friend_lname</option>");
							}
							echo("</select>");
						} 
					}else{
						if(isset($_SESSION['recipient'])) $recipient = $_SESSION['recipient'];
						$q_recipient = mysql_query("SELECT * FROM rockinus.user_info WHERE uname='$recipient'");
						if(!$q_recipient) die(mysql_error());
						$object_recipient = mysql_fetch_object($q_recipient);
						$recipient_fname = $object_recipient->fname;
						$recipient_lname = $object_recipient->lname;

						if(isset($_SESSION['recipient'])){
							$recipient = $_SESSION['recipient'];
							unset($_SESSION['recipient']);
						}
						echo("<input type=text class=box value='$recipient_fname $recipient_lname' disabled=disabled style='font-size:14px; font-family:Arial, Helvetica, sans-serif; height:22px' size=80>");
						echo("<input type=hidden name=recipient size=15 class=box value='$recipient' style='font-size:14px; font-family:Arial, Helvetica, sans-serif'>");
					}
			?>                  </td>
                </tr>
                <tr>
                  <td height="30" align="right" style="padding-right:15; font-size:14px; font-family:Arial, Helvetica, sans-serif">
				  <strong>Subject</strong></td>
                  <td height="30">
				  <input type="text" value="<?php if(isset($_SESSION['subject'])){echo($_SESSION['subject']);unset($_SESSION['subject']);} ?>" name="subject" class="box" style="width:530px; font-size:14px; height:22; font-family:Arial, Helvetica, sans-serif"></td>
                </tr>
                <tr>
                  <td height="100" align="right" style="padding-right:15px; padding-top:10px" valign="top">
				  <strong>Content</strong></td>
                  <td height="100" style="padding-top:10" valign="top">
				  <textarea name="description" style="width:530; height:250; font-size:14px; padding:4px; line-height:130%; font-family:Arial, Helvetica, sans-serif; background:; border:1px solid #CCCCCC" id="styled" onBlur="setbg('white')"><?php if(isset($_SESSION['descrip'])){echo($_SESSION['descrip']);unset($_SESSION['descrip']);} ?></textarea>
				  </td>
                </tr>
                <tr>
                  <td height="35" align="right" style="padding-right:15px;" valign="middle">
				  <input type="checkbox" name="mail_yesno" checked="checked" />
				  </td>
                  <td height="35" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">Also drop a copy to user's email</td>
                </tr>
                <tr>
                  <td height="80" align="center" valign="top">&nbsp;</td>
                  <td height="80" align="left" valign="top" style=" padding-bottom:20px; padding-top:15px">
				  <input type="submit" name="sendSubmit" value=" Send " style="background-image:url(img/black_cell_bg.jpg); color:#FFFFFF; border:1px solid #000000; padding:2 8 2 8; font-size:12px; font-family:Arial, Helvetica, sans-serif; cursor:pointer"/>
				  </td>
                </tr>
              </table>
            </form>
			</td>
          </tr>
        </table>
      </td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
