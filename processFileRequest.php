<?php 
session_start(); 
$uname = $_SESSION['usrname'];
include 'dbconnect.php';

$seq_id = $_POST["seq_id"];
$pro_status = $_POST["pro_status"];

if($pro_status == "A"){
	$upd = mysql_query("UPDATE rockinus.user_request_file SET rstatus='$pro_status', adate=CURDATE(), atime=NOW() WHERE seq_id='$seq_id';");
	if(!$upd) die(mysql_error());
	
	// send email to owner
	$q_email = mysql_query("SELECT a.email, c.sender, b.file_name FROM rockinus.user_check_info a JOIN rockinus.user_file_info b JOIN rockinus.user_request_file c ON c.seq_id='$seq_id' AND a.uname=c.sender AND b.file_id=c.file_id;");
	if(!$q_email) die(mysql_error());
	$object = mysql_fetch_object($q_email);
	$email = $object->email;
	$sender = $object->sender;
	$file_name = $object->file_name;
	//$email = "barmuya@hotmail.com";    
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
                      <td width='684' align='left'><br />Dear ".$sender.", <br />
                          <br />
                        Just a reminder that <strong><a href=http://03531d0.netsolhost.com/FreeTourUser.php?uid=".$uname." class=one><font color=#336633>".$uname."</font></strong></a> has approved your request on file \"".$file_name."\", now you can download it.
                        <br />Enjoy, buddy :)<br />
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
	
	include 'emailfuc.php';
	require("class.phpmailer.php");
	smtp_mail($email, $uname." has accepted your file request in Rockinus.com", $body, "admin@rockinus.com", $uname, "", ""); 

	echo("<img src=img/addsuccessIcon_F5.jpg width=12 />&nbsp;&nbsp;Accepted");
}else if($pro_status == "R"){
	$upd = mysql_query("UPDATE rockinus.user_request_file SET rstatus='$rstatus' WHERE seq_id='$seq_id';");
	if(!$upd) die(mysql_error());
	echo("<img src=img/addsuccessIcon_F5.jpg width=12 />&nbsp;&nbsp;Rejected");
}

mysql_close($link);
?>