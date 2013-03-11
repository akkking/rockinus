<?php 
include 'mainHeader.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];

if(isset($_POST['emailSetting'])){
	if(isset($_POST['features']) && $_POST['features'] == 'Y')$features="Y";
	else $features="N";
	
	if(isset($_POST['frequest']) && $_POST['frequest'] == 'Y')$frequest="Y";
	else $frequest="N";
	
	if(isset($_POST['message']) && $_POST['message'] == 'Y')$message="Y";
	else $message="N";
	
	if(isset($_POST['ccomment']) && $_POST['ccomment'] == 'Y')$ccomment ="Y";
	else $ccomment="N";
	
	if(isset($_POST['fcourse']) && $_POST['fcourse'] == 'Y')$fcourse="Y";
	else $fcourse="N";
	
	if(isset($_POST['fsupdate']) && $_POST['fsupdate'] == 'Y')$fsupdate="Y";
	else $fsupdate="N";
		
	if(isset($_POST['srupdate']) && $_POST['srupdate'] == 'Y')$srupdate="Y";
	else $srupdate="N";
	
	if(isset($_POST['eventnews']) && $_POST['eventnews'] == 'Y')$eventnews="Y";
	else $eventnews="N";
	
	if(isset($_POST['house']) && $_POST['house'] == 'Y')$house="Y";
	else $house="N";
	
	if(isset($_POST['article']) && $_POST['article'] == 'Y')$article="Y";
	else $article="N";
	
	if(isset($_POST['roommate']) && $_POST['roommate'] == 'Y')$roommate="Y";
	else $roommate="N";
	
	if(isset($_POST['headicon_like']) && $_POST['headicon_like'] == 'Y')$headicon_like="Y";
	else $headicon_like="N";
	
	if(isset($_POST['interviewQuestion']) && $_POST['interviewQuestion'] == 'Y')$interviewQuestion="Y";
	else $interviewQuestion="N";
	
	$upd = mysql_query("UPDATE rockinus.user_email_setting SET features='$features', frequest='$frequest', message='$message', ccomment='$ccomment', fcourse='$fcourse', fsupdate='$fsupdate', eventnews='$eventnews', house='$house', article='$article', roommate='$roommate', headicon_like='$headicon_like', interviewQuestion='$interviewQuestion' WHERE uname='$uname';");
	if(!$upd) die(mysql_error());
	$_SESSION['email_rst_msg'] = "<div style='width:740; height:30; font-weight:bold; background:; font-size:12px; padding-top:5; margin-bottom:0' align='left'>&nbsp;&nbsp;<img src=img/addsuccessIcon_F5.jpg width=10 />&nbsp;&nbsp;Your email setting has been updated successfully</div>";
}

if(isset($_POST['basicSetting'])){
	if(isset($_POST['whoVisit']) && $_POST['whoVisit'] == 'F')$whoVisit="F";
	else $whoVisit="A";
	
	if(isset($_POST['directPage']) && $_POST['directPage'] == 'H')$directPage="H";
	else $directPage="P";
	
	$upd = mysql_query("UPDATE rockinus.user_basic_setting SET whoVisit='$whoVisit', directPage='$directPage' WHERE uname='$uname';");
	if(!$upd) die(mysql_error());
	$_SESSION['basic_rst_msg'] = "<div style='width:740; height:30; font-weight:bold; background:; font-size:12px; padding-top:5; margin-bottom:0' align='left'>&nbsp;&nbsp;<img src=img/addsuccessIcon_F5.jpg width=10 />&nbsp;&nbsp;Your basic setting has been updated successfully</div>";
}

$q1 = mysql_query("SELECT * FROM rockinus.user_setting WHERE uname='$uname';");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$hcolor = $object->hcolor;

$q = mysql_query("SELECT * FROM rockinus.user_email_setting WHERE uname='$uname';");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object_email = mysql_fetch_object($q);
$features = $object_email->features;
$frequest = $object_email->frequest;
$message = $object_email->message;
$ccomment = $object_email->ccomment;
$fcourse = $object_email->fcourse;
$srupdate = $object_email->srupdate;
$fsupdate = $object_email->fsupdate;
$eventnews = $object_email->eventnews;
$house_tag = trim($object_email->house);
$article_tag = trim($object_email->article);
$roommate = $object_email->roommate;
$headicon_like = $object_email->headicon_like;
$interviewQuestion = $object_email->interviewQuestion;

$q_b = mysql_query("SELECT * FROM rockinus.user_basic_setting WHERE uname='$uname';");
if(!$q_b) die(mysql_error());
$no_row_basic = mysql_num_rows($q_b);
if($no_row_basic == 0) die("No matches met your criteria.");
$object_basic = mysql_fetch_object($q_b);
$whoVisit = $object_basic->whoVisit;
$directPage = $object_basic->directPage;
//echo("SELECT * FROM rockinus.user_basic_setting WHERE uname='$uname';");
//echo($whoVisit."----");
?>
<div align="center" style="width:100%">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="center">
    <tr>
      <td align="left" valign="top" style="padding:20px">
	   <?php
		  	if(isset($_SESSION['email_rst_msg'])){
				echo($_SESSION['email_rst_msg']);
				unset($_SESSION['email_rst_msg']);
			}
		  ?>
	       
		     <?php
		  	if(isset($_SESSION['basic_rst_msg'])){
				echo($_SESSION['basic_rst_msg']);
				unset($_SESSION['basic_rst_msg']);
			}
		  ?>
		  
		  <?php
		  	if(isset($_SESSION['color_rst_msg'])){
				echo($_SESSION['color_rst_msg']);
				unset($_SESSION['color_rst_msg']);
			}
		  ?>
	  <table width="990" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	    <tr>
	      <td width="485" align="left" valign="top">
	        <form method="post" action="UserSetting.php">
	          <table width="450" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:0px #999999 solid; border:; font-size:14px; margin-bottom:15">
	            <tr>
	              <td height="40" bgcolor="#F5F5F5" style="border-bottom:1px solid #DDDDDD; padding-left:15; font-weight:bold; font-size:18px; ; color:<?php echo($_SESSION['hcolor']) ?>">
	                Email Settings			  </td>
              </tr>
	            <tr>
	              <td height="10" style="padding-left:10">&nbsp;</td>
              </tr>
	            <tr>
	              <td height="25" style='padding-left:5px' align='left'>
	                <input type="checkbox" <?php if($features=="Y")echo("checked='checked'") ?> name="features" value="Y" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;Notification about new functions, features, site updates</td>
              </tr>
	            <tr>
	              <td height="25" style='padding-left:5px' align='left'>
	                <input type="checkbox" <?php if($frequest=="Y")echo("checked='checked'") ?> name="frequest" value="Y" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;New friend request</td>
              </tr>
	            <tr>
	              <td height="25" style='padding-left:5px' align='left'>
	                <input type="checkbox" <?php if($message=="Y")echo("checked='checked'") ?> name="message" value="Y" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;New messages from others</td>
              </tr>
	            <tr>
	              <td height="25" style='padding-left:5px' align='left'>
	                <input type="checkbox" <?php if($ccomment=="Y")echo("checked='checked'") ?> name="ccomment" value="Y" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;New comments on subscribed courses</td>
              </tr>
	            <tr>
	              <td height="25" style='padding-left:5px' align='left'>
	                <input type="checkbox" <?php if($fcourse=="Y")echo("checked='checked'") ?> name="fcourse" value="Y" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;New file uploaded on subscribed courses</td>
              </tr>
	            <tr>
	              <td height="25" style='padding-left:5px' align='left'>
	                <input type="checkbox"<?php if($fsupdate=="Y")echo("checked='checked'") ?> name="fsupdate" value="Y" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;New status update from friends</td>
              </tr>
	            <tr>
	              <td height="25" style='padding-left:5px' align='left'>
	                <input type="checkbox"<?php if($srupdate=="Y")echo("checked='checked'") ?> name="srupdate" value="Y" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;Comments to my status</td>
              </tr>
	            <tr>
	              <td height="25" style='padding-left:5px' align='left'>
	                <input type="checkbox" <?php if($eventnews=="Y")echo("checked='checked'") ?> name="eventnews" value="Y" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;New notices or events post</td>
              </tr>
	            <tr>
	              <td height="25" style='padding-left:5px' align='left'>
	                <input type="checkbox" <?php if($house_tag=="Y")echo("checked='checked'") ?> name="house" value="Y" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;New house rental post</td>
              </tr>
	            <tr>
	              <td height="25" style='padding-left:5px' align='left'>
	                <input type="checkbox" <?php if($roommate=="Y")echo("checked='checked'") ?> name="roommate" value="Y" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;New room mate post</td>
              </tr>
	            <tr>
	              <td height="25" style='padding-left:5px' align='left'>
	                <input type="checkbox" <?php if($article_tag=="Y")echo("checked='checked'") ?> name="article" value="Y" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;New sales post</td>
              </tr>
	            <tr>
	              <td height="25" style='padding-left:5px' align='left'>
	                <input type="checkbox" <?php if($headicon_like=="Y")echo("checked='checked'") ?> name="headicon_like" value="Y" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;Others like my head icon, notify me</td>
              </tr>
	            <tr>
	              <td height="25" style='padding-left:5px' align='left'>
	                <input type="checkbox" <?php if($interviewQuestion=="Y")echo("checked='checked'") ?> name="interviewQuestion" value="Y" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;Interview Question Post</td>
              </tr>
	            <tr>
	              <td height="60" style="padding-left:5px; padding-top:15" valign="top">
	                <input type="submit" name="emailSetting" value="Submit" style="height:22; padding:2 7 2 7; background: url(img/master.jpg); cursor:pointer; border:1px solid #333333; font-size:12px; color:#000000; line-height:120%; display:inline;  -moz-border-radius: 3px; border-radius: 3px;" />			  </td>
              </tr>
	            </table>
		    </form>
		    
  		    </td>
          <td width="539" align="right" valign="top">
		    <form method="post" action="UserSetting.php">
	          <table width="500" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="margin-bottom:15; border:px solid #999999">
	            <tr>
	              <td height="40" style="border-bottom:1px solid #DDDDDD; padding-left:15; font-weight:bold; font-size:18px; ; color:<?php echo($_SESSION['hcolor']) ?>" bgcolor="#F5F5F5">
	                Basic Settings	</td>
    </tr>
	            <tr>
	              <td height="10">&nbsp;</td>
    </tr>
	            <tr>
	              <td height="25" style=" padding-left:10px; ; font-weight:bold" align="left">
	                Once login, bring me to? </td>
    </tr>
	            <tr>
	              <td height="25" style='padding-left:10px' align='left'>
	                <input type="radio" <?php if($directPage=="H")echo("checked='checked'") ?> name="directPage" value="H" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;Default home page</td>
    </tr>
	            <tr>
	              <td height="25" style='padding-left:10px' align='left'>
	                <input type="radio" <?php if($directPage=="P")echo("checked='checked'") ?> name="directPage" value="P" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;My personal page</td>
    </tr>
	            <tr>
	              <td height="20">&nbsp;			 </td>
    </tr>
	            <tr>
	              <td height="25" style=" padding-left:10px; ; font-weight:bold" align="left">
	                Who can visit my page?</td>
    </tr>
	            <tr>
	              <td height="25" style='padding-left:10px' align='left'>
	                <input type="radio" <?php if($whoVisit=="F")echo("checked='checked'") ?> name="whoVisit" value="F" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;My friends</td>
    </tr>
	            <tr>
	              <td height="25" style='padding-left:10px' align='left'>
	                <input type="radio" <?php if($whoVisit=="A")echo("checked='checked'") ?> name="whoVisit" value="A" style="font-size:14px; " />&nbsp;&nbsp;&nbsp;Everyone</td>
    </tr>
	            <tr>
	              <td height="60" style="padding-left:10px; padding-top:15" valign="top">
	                <input type="submit" name="basicSetting" value="Submit" style="height:22; padding:2 7 2 7; background: url(img/master.jpg); cursor:pointer; border:1px solid #333333; font-size:12px; color:#000000; line-height:120%; display:inline;  -moz-border-radius: 3px; border-radius: 3px;" />	                </td>
              </tr>
  </table>
  </form>
  
  
  
  <form method="post" action="UserSetting.php">
	          <table width="500" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="margin-bottom:15; border:0px solid #999999">
	            <tr>
	              <td colspan="15" height="40" style="border-bottom:1px solid #DDDDDD; padding-left:15; font-weight:bold; font-size:18px; ; color:<?php echo($_SESSION['hcolor']) ?>" bgcolor="#F5F5F5">
	                Color Settings	</td>
    </tr>
	            <tr>
	              <td height="10" colspan="15">&nbsp;</td>
    </tr>
	            <tr>
	              <td width="40" height="60" bgcolor="#387A36" style="padding-left:15;  ; font-weight:bold">&nbsp;</td>
                  <td width="15" style="padding-left:15;  ; font-weight:bold">&nbsp;</td>
                  <td width="40" bgcolor="#444444" style="padding-left:15;  ; font-weight:bold">&nbsp;</td>
                  <td width="20" style="padding-left:15;  ; font-weight:bold">&nbsp;</td>
                  <td width="40" bgcolor="#7AC142" style="padding-left:15;  ; font-weight:bold">&nbsp;</td>
                  <td width="20" style="padding-left:15;  ; font-weight:bold">&nbsp;</td>
                  <td width="40" bgcolor="#57068C" style="padding-left:15;  ; font-weight:bold">&nbsp;</td>
                  <td width="20" style="padding-left:15;  ; font-weight:bold">&nbsp;</td>
                  <td width="40" bgcolor="#006699" style="padding-left:15;  ; font-weight:bold">&nbsp;</td>
                  <td width="20" style="padding-left:15;  ; font-weight:bold">&nbsp;</td>
                  <td width="40" bgcolor="#2E4174" style="padding-left:15;  ; font-weight:bold">&nbsp;</td>
	              <td width="20" style="padding-left:15;  ; font-weight:bold">&nbsp;</td>
	              <td width="40" bgcolor="#ED1C25" style="padding-left:15;  ; font-weight:bold">&nbsp;</td>
	              <td width="10" style="padding-left:15;  ; font-weight:bold">&nbsp;</td>
	            </tr>
	            <tr>
	              <td width="40" height="25" style="  " align="center">
				  <input type="radio" <?php if($hcolor=="#387A36")echo("checked='checked'") ?> name="hcolor" value="#387A36" style="font-size:14px; " /></td>
                  <td width="15" height="25" style="  ">&nbsp;</td>
                  <td width="40" height="25" align="center" style="  ">
				  <input type="radio" <?php if($hcolor=="#444444")echo("checked='checked'") ?> name="hcolor" value="#444444" style="font-size:14px; " />				  </td>
                  <td width="20" height="25" style="  ">&nbsp;</td>
                  <td width="40" height="25" style="  " align="center">
				  <input type="radio" <?php if($hcolor=="#7AC142")echo("checked='checked'") ?> name="hcolor" value="#7AC142" style="font-size:14px; " />				  </td>
                  <td width="20" height="25" style="  ">&nbsp;</td>
                  <td width="40" height="25" style="  " align="center">
				  <input type="radio" <?php if($hcolor=="#57068C")echo("checked='checked'") ?> name="hcolor" value="#57068C" style="font-size:14px; " />				  </td>
                  <td width="20" height="25" style="  ">&nbsp;</td>
                  <td width="40" height="25" style="  " align="center">
				  <input type="radio" <?php if($hcolor=="#006699")echo("checked='checked'") ?> name="hcolor" value="#006699" style="font-size:14px; " />				  </td>
                  <td width="20" height="25" style="  ">&nbsp;</td>
                  <td width="40" height="25" align="center" style="  ">
				  <input type="radio" <?php if($hcolor=="#2E4174")echo("checked='checked'") ?> name="hcolor" value="#2E4174" style="font-size:14px; " />				  </td>
	              <td width="20" height="25" align="center" style="  ">&nbsp;</td>
	              <td width="40" height="25" align="center" style="  ">
				  <input type="radio" <?php if($hcolor=="#ED1C25")echo("checked='checked'") ?> name="hcolor" value="#ED1C25" style="font-size:14px; " />				  </td>
	              <td width="10" height="25" align="center" style="  ">&nbsp;</td>
	            </tr>
	            <tr>
	              <td height="60" colspan="15" valign="top" style="padding-left:0; padding-top:15">
	                <input type="submit" name="colorSetting" value="Submit" style="height:22; padding:2 7 2 7; background: url(img/master.jpg); cursor:pointer; border:1px solid #333333; font-size:12px; color:#000000; line-height:120%; display:inline;  -moz-border-radius: 3px; border-radius: 3px;" />	                </td>
              </tr>
  </table>
  </form>
		  </td>
	    </tr>
      </table></td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
