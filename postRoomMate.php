<?php 
include 'ValidCheck.php';
include 'emailfuc.php';
require("class.phpmailer.php");

if(isset($_POST['roomMate'])){
	$tag = 0;
	$has_room = $_POST['has_room'];
	$location = $_POST['location'];
	$mate_type = $_POST['mate_type'];
	$rate = trim($_POST['rate']);
	$descrip = addslashes($_POST['descrip']);
	$_SESSION['descrip'] = addslashes($_POST['descrip']);
	$extra_fee = addslashes($_POST['extra_fee']);
	
	if( ( $rate==NULL || trim($rate)=="" ) && $tag ==0 )
		$rate="0";
	
	if( ( !is_numeric($rate) ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "Please enter a legal rate number.";
	}
	
	if( ( $descrip==NULL || strlen($descrip)<20 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "Description is too short, it has to be more than 20 letters.";
	}
	
	if($tag==0){	
		include 'dbconnect.php'; 
		
		mysql_query('set character_set_connection=gbk, character_set_results=gbk, character_set_client=binary');
		$sql = "INSERT INTO rockinus.room_mate_info (has_room,mate_type,uname,rate,descrip,location,extra_fee, rstatus,pdate,ptime)VALUES('$has_room','$mate_type','$uname','$rate','$descrip','$location','$extra_fee','N',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$rst_msg = "Your post has been submitted successfully!";
		//mysql_close($link);
		
		$q_email = mysql_query("SELECT a.email, a.uname FROM rockinus.user_check_info a JOIN rockinus.user_email_setting b WHERE a.uname=b.uname AND b.roommate='Y'");
		if(!$q_email) die(mysql_error());
		while($object = mysql_fetch_object($q_email)){
			$email_list .= $object->email.";";
			$recipient_list .= $object->uname.";";
		}
		
		if(substr($email_list,strlen($email_list)-1,1)==";"){
			$email_list = substr($email_list,0,strlen($email_list)-1);
			$recipient_list = substr($recipient_list,0,strlen($recipient_list)-1);
		}	
		smtp_mail($email_list, "[Rockinus News] Someone is looking for room mate", nl2br($descrip), "admin@rockinus.com", $recipient_list, "", ""); 
		
		$_SESSION['rst_msg']="<div align='center' style='width=700; background:#F5F5F5; border:0 #DDDDDD solid; padding-top:10; padding-bottom:10; margin-top:0; margin-bottom:0'><strong><font size=3><img src=img/addsuccessIcon_F5.jpg width=15>&nbsp;&nbsp;&nbsp; $rst_msg</font></strong><br><br><font size=3><a href=roomMateList.php class=one>Go Back</a></font></div>"; 
		header("location:roomMateResult.php");
	}else
	$_SESSION['err_rst_msg']="<table width=760><tr><td align='right'><div align='left' style='width=740; background:#F5F5F5; border:0 #DDDDDD solid; padding-top:10; padding-bottom:10; margin-top:0; margin-bottom:10'><strong><font size=3 color=#B92828>&nbsp;&nbsp;<img src=img/stop.jpg width=15>&nbsp;&nbsp;&nbsp;$rst_msg</font></strong></div></td></tr></table>"; 
}

if(isset($_GET["recipient"])) $recipient = $_GET["recipient"];
else $recipient = "";

include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];

$z = mysql_query("SELECT * FROM rockinus.user_edu_info WHERE uname='$uname'");
if(!$z) die(mysql_error());
$objz = mysql_fetch_object($z);
$cmajor = $objz->cmajor;	

if($cmajor!=NULL && strlen($cmajor)>0){
	$m = mysql_query("SELECT major_name FROM rockinus.major_info");
	if(!$m) die(mysql_error());
	$objm = mysql_fetch_object($m);
	$major_name = $objm->major_name;		
}
?><style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
<div style="width:100%" align="center">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="300" align="left" valign="top" style="border-right:1 #DDDDDD dashed">
	  <?php include("leftHomeMenu.php"); ?>
	  </td>
      <td width="760" align="right" valign="top">
	  <?php include("HeaderEN.php"); ?>
	  <?php
	  	if(isset($_SESSION['err_rst_msg'])){
			echo($_SESSION['err_rst_msg']);
			unset($_SESSION['err_rst_msg']);
		}
	  ?>
	  <table border="0" cellspacing="0" cellpadding="0" width="760">
        <tr>
          <td align="right" valign="top" width="760">
		  <table width="740" height="94" border="0" cellpadding="0" cellspacing="0" style="border:1 #DDDDDD solid">
            <tr>
              <td height="34" colspan="2" align="left" background="img/master.png" style="padding-left:15; border-bottom:1 solid #CCCCCC; font-size:16px; font-weight:bold">&nbsp;</td>
              <td width="357" align="right" background="img/master.png" style="padding-right:15px; font-size:14px; font-weight:bold; border-bottom:1 solid #CCCCCC">
			  <a href="roomMateList.php" class="one" style=" color:<?php echo($_SESSION['hcolor']) ?>">Check whom else looking for roommates</a>			  </td>
            </tr>
            <tr>
              <td width="120" height="30" align="center" background="img/GrayGradbgDown.jpg">&nbsp;</td>
              <td width="263" height="50"  align="center" background="img/GrayGradbgDown.jpg">&nbsp;</td>
              <td height="50"  align="center" background="img/GrayGradbgDown.jpg">&nbsp;</td>
              </tr>
            <tr>
              <td height="30" colspan="3" align="center">
			  <form action="postRoomMate.php" method="post">
                <table width="740" height="400" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid; border-top:0px">
				  <tr>
                    <td width="254" height="40" align="right" style="padding-right:10px; font-size:14px;">
					Do you have Apt. or Room?					</td>
                    <td width="225" height="40" style="padding-left:10px">
					<select name="has_room">
                        <option value="Y" >Yes</option>
                        <option value="N" selected="selected">No</option>
                      </select>					  </td>
                    <td width="261" style="padding-left:10px; font-size:14px">
				  <tr>
				    <td height="40" style="padding-right:10px; font-size:14px;" align="right">
					Expected Apt. Location					</td>
				    <td height="40" style="padding-left:10px">
					<select name="location">
                        <option value="all" selected="selected">Anywhere in NYC</option>
						<option value="Brookyln">Brookyln</option>
						<option value="Queens">Queens</option>
						<option value="Manhattan">Manhattan</option>
						<option value="Bronx">Bronx</option>
                      	<option value="JersyCity">Jersy City</option>
                        <option value="LongIsland">Long Island</option>
                        </select>					</td>
				    <td style="padding-left:10px; font-size:14px">&nbsp;</td>
				    </tr>
                  <tr>
                    <td height="40" style="padding-right:10px; font-size:14px; font-weight:" align="right">Prefer the roommate from </strong></td>
                    <td height="40" colspan="2" style="padding-left:10px">
					<select name="mate_type">
					<option value="all">I don't care</option>
					<option value="India">India</option>
					<option value="China">China</option>
					<option value="Mexico">Mexico</option>
					<option value="UAE">Middle East</option>
					<option value="Turkey">Turkey</option>
					<option value="Korea">Korea</option>
					<option value="Taiwan">Taiwan</option>
					<option value="Japan">Japan</option>
					<option value="Russia">Russia</option>
					<option value="Bangladesh">Bangladesh</option>
					<option value="USA">USA</option>
					<option value="Italy">Italy</option>
					<option value="Others">Other nations</option>
					</select>					</td>
                  </tr>
                  <tr>
                    <td height="40" style="padding-right:10px; font-size:14px; font-weight:" align="right">Expected Monthly Rate </strong></td>
                    <td height="40" colspan="2" style="padding-left:10px">
                        $ <input type="text" name="rate" size="5" />
						<select name="extra_fee">
					<option value="P">(Includes partial additional fees)</option>
					<option value="A">(Includes all additional fees)</option>
					<option value="N">(Not includes any additional fees)</option>
					</select>						</td>
                  </tr>
                  <tr>
                    <td height="170" style="padding-right:10px; padding-top:10; font-size:14px;" valign="top" align="right">
					Short Description<br /><br />
					<font style="font-size:12px; color:#666666">(must be longer than 20 letters)</font>					</td>
                    <td colspan="2" valign="top" style="padding-left:10px; padding-top:10px">
                      <textarea name="descrip" rows="10" style="width:420; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><?php if(isset($_SESSION['descrip'])){echo($_SESSION['descrip']);unset($_SESSION['descrip']);}?></textarea>					  </td>
                  </tr>
                  <tr>
                    <td height="70" style="padding-right:10px" align="right">&nbsp;</td>
                    <td height="70" colspan="2" valign="top" style="padding-left:10px; padding-top:10px;">
					<input name="roomMate" type="submit" class="btn2" value=" Submit " />					</td>
                  </tr>
                </table>
              </form>
			  </td>
              </tr>
          </table>
		  </td>
        </tr>
      </table>
	  </td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
