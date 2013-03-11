<?php include("Header.php"); ?>
<div align="center">
  <table width="1018" height="394" border="0" cellpadding="0" cellspacing="0" style="padding-top:0; margin-top:0;">
    <tr>
      <td width="136" align="left" valign="top" style="border-right: 1px solid #CCCCCC; padding-right:0; padding-left:0; width:10"><form action="login_process.php" method="post">
        <div style="margin-top: 0; margin-bottom: 0; margin-left:7; margin-right: 0" align="center">
          <table width="100" height="91" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="34"><span class="STYLE8">
                <div style="border-bottom: 1px dotted #999999; padding-right:0; width:55; padding-bottom:4"><a href="MessageList.php" class="one">Message</a></div>
              </span></td>
            </tr>
            <tr>
              <td height="29" style="padding-top:5"><a href="SendMessage.php?recipient=1" class="one">Draft</a></td>
            </tr>
            <tr>
              <td height="20" style="padding-top:0"><a href="MessageSentList.php" class="one">History</a> </td>
            </tr>
          </table>
        </div>
        <div style="margin-top: 25; margin-bottom: 0; margin-left:7; margin-right: 0" align="center">
          <table width="100" height="66" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="22"><span class="STYLE8">
                <div style="border-bottom: 1px dotted #999999; padding-right:0; width:40; padding-bottom:4"> <a href="RockerProfile.php" class="one">Profile</a> </div>
              </span></td>
            </tr>
            <tr>
              <td height="26" style="padding-top:5"><a href="RockerEdit.php" class="one">Edit</a></td>
            </tr>
          </table>
        </div>
      </form></td>
      <td width="882" align="left" valign="top" style=" border:#CCCCCC solid 0; padding-left:3;"><div align="center">
        <table width="888" height="394" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top"><div align="center">
              <table width="880" height="28" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="140" height="26" style="border: #CCCCCC solid 1; border-bottom:0;"><div align="center"><a href="RockerProfile.php" class="one">Profile</a></div></td>
                  <td width="140" background="img/master.png" style="border: #CCCCCC solid 1; border-bottom:1 #CCCCCC dotted;"><div align="center"><a href="PasswdEdit.php" class="one">Password </a></div></td>
                  <td width="140" background="img/master.png" style="border: #CCCCCC solid 1; border-bottom:1 #CCCCCC dotted;"><div align="center"><a href="ChangeHeadIcon.php" class="one">Head Icon </a></div></td>
                  <td width="140" background="img/master.png" style="border: #CCCCCC solid 1; border-bottom:0 #CCCCCC dotted;"><div align="center"><a href="RockerEdit.php" class="one">Memo</a></div></td>
                  <td width="151" style="border: #CCCCCC solid 0; border-bottom:1 #CCCCCC dotted;">&nbsp;</td>
                  <td width="101" style="border: #CCCCCC dotted 0; border-bottom: #CCCCCC dotted 1; border-right:0; border-top:0; padding-right:5"><div align="right">
                      <?php
//Global Variable: 
include 'dbconnect.php';
$uname = $_SESSION['usrname'];
$q = mysql_query("SELECT * FROM rockinus.user_info where uname='$uname'");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$fname = $object->fname;
$lname = $object->lname;
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;
$birthdate = $object->birthdate;
$ccity = $object->ccity;
$cstate = $object->cstate;
$fcity = $object->fcity;
$fcountry = $object->fcountry;
$email = $object->email;
$cmajor = $object->cmajor;
$cschool = $object->cschool;
$cdegree = $object->cdegree;
$phone = $object->phone;
$address = $object->address;

$gender_options = array("", ""); 
if($gender == "M"){
	$gender_options[0] = "checked='checked'";
}elseif($gender == "F"){
	$gender_options[1] = "checked='checked'";
}

$sstatus_options = array("", ""); 
if($sstatus == "S"){
	$sstatus_options[0] = "checked='checked'";
}elseif($sstatus == "E"){
	$sstatus_options[1] = "checked='checked'";
}

$mstatus_options = array("", "",""); 
if($mstatus == "S"){
	$mstatus_options[0] = "checked='checked'";
}elseif($mstatus == "M"){
	$mstatus_options[1] = "checked='checked'";
}elseif($mstatus == "I"){
	$mstatus_options[2] = "checked='checked'";
}

if($gender=='M')$gender='Male';
else if($gender=='F')$gender='Female';

if($sstatus=='S')$sstatus='Student';
else if($sstatus=='E')$sstatus='Empolyee(r)';

if($cdegree=='G')$cdegree='Master Student';
else if($cdegree=='P')$cdegree='P.H.D.';
else if($cdegree=='U')$cdegree='Undergraduate';
else $cdegree='Certificate Student';

if($mstatus=='S')$mstatus='Single';
else if($mstatus=='M')$mstatus='Married';
else if($mstatus=='I')$mstatus='In a relationship';

$q1 = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
if(!$q1) die(mysql_error());
$obj1 = mysql_fetch_object($q1);
$cschool = $obj1->school_name;
$q2 = mysql_query("SELECT * FROM rockinus.major_info where mid='$cmajor'");
if(!$q2) die(mysql_error());
$obj2 = mysql_fetch_object($q2);
$cmajor = $obj2->major_name;
$q3 = mysql_query("SELECT * FROM rockinus.country_info where counid='$fcountry'");
if(!$q3) die(mysql_error());
$obj3 = mysql_fetch_object($q3);
$fcountry_name = $obj3->country_name;

$cs_options = array("", "", "", ""); 
if($cstate == "empty"){
	$cs_options[0] = "selected='selected'";
}elseif($cstate == "NY"){
	$cs_options[1] = "selected='selected'";
}

$fc_options = array("", "", "", "","", "", "", "", "", "", "", "", ""); 
if($fcountry == "empty"){
	$fc_options[0] = "selected='selected'";
}elseif($fcountry == "IN"){
	$fc_options[1] = "selected='selected'";
}elseif($fcountry == "CN"){
	$fc_options[2] = "selected='selected'";
}elseif($fcountry == "TK"){
	$fc_options[3] = "selected='selected'";
}elseif($fcountry == "KO"){
	$fc_options[4] = "selected='selected'";
}elseif($fcountry == "MX"){
	$fc_options[5] = "selected='selected'";
}elseif($fcountry == "TW"){
	$fc_options[6] = "selected='selected'";
}elseif($fcountry == "JP"){
	$fc_options[7] = "selected='selected'";
}elseif($fcountry == "US"){
	$fc_options[8] = "selected='selected'";
}elseif($fcountry == "UK"){
	$fc_options[9] = "selected='selected'";
}elseif($fcountry == "SP"){
	$fc_options[10] = "selected='selected'";
}
?>
                  </div></td>
                </tr>
              </table>
              <table width="880" height="546" border="0" cellpadding="0" cellspacing="0" style="border:1; border-top:0">
                  <tr>
                    <td height="16" colspan="4">&nbsp;</td>
                    </tr>
                  <tr>
                    <td width="173" height="40"><div align="right" style="padding-right:5"><strong>Rock ID: </strong></div></td>
                    <td>&nbsp;
                        <input name="uname" type="text" class="box" value=<?php echo($uname); ?> disabled="disabled">
                        <span class="STYLE12">*</span></td>
                    <td width="237">&nbsp;</td>
                    <td width="228"><div align="center" style="padding-top:7; padding-bottom:7; background-color:#336633; width:100"><span class="STYLE16"><a href="RockerEdit.php">Change</a></span></div></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Your Name: </strong></div></td>
                    <td colspan="3">&nbsp;
                        <input name="fname" type="text" class="box" onFocus="value=''" value=<?php echo($fname); ?> disabled="disabled">&nbsp;.&nbsp;
                        <input name="lname" type="text" class="box" onFocus="value=''"  value=<?php echo($lname); ?> disabled="disabled"></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Birthdate:</strong></div></td>
                    <td colspan="3">&nbsp;
                        <input name="birthdate" type="text" class="box" id="birthdate"  value=<?php echo($birthdate); ?> disabled="disabled" size="10" maxlength="10">
                        <span class="STYLE12">*
                          <div id="calendar"></div>
                        </span></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>I am </strong></div></td>
                    <td colspan="3">&nbsp;
					<input name="uname2" type="text" class="box"  value=<?php echo($gender); ?> size="6" disabled="disabled"></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>I am a </strong></div></td>
                    <td colspan="3">&nbsp;
					<input name="uname3" type="text" class="box"  value=<?php echo($sstatus); ?> size="10" disabled="disabled"></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Where you stay? </strong></div></td>
                    <td colspan="3">&nbsp;
                      <input type="text" size=10 class="box"  value=<?php echo($cstate); ?> disabled="disabled">&nbsp;
                      <input type="text" size=10 class="box"  value=<?php echo($ccity); ?> disabled="disabled">
                      <span class="STYLE12">*</span></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Current School: </strong></div></td>
                    <td colspan="3">&nbsp;
					<?php echo '<input type="text" name="title" size=50 class=box value="'.$cschool.'" disabled="disabled"></input>'; ?>
                    <span class="STYLE12">*</span></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>I am a(n) </strong></div></td>
                    <td colspan="3">&nbsp; <?php echo '<input type="text" name="title" class=box value="'.$cdegree.'" disabled="disabled"></input>'; ?> <span class="STYLE12">*</span></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Which Program Study? </strong></div></td>
                    <td colspan="3">&nbsp;
                      <?php echo '<input type="text" name="title" class=box value="'.$cmajor.'" disabled="disabled"></input>'; ?>
                      <span class="STYLE12">*</span></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Where  From? </strong></div></td>
                    <td colspan="3">&nbsp;
                      <input name="uname42" type="text" class="box" size=10 value=<?php echo($fcountry_name); ?> disabled="disabled">
                      &nbsp;/&nbsp;
                      <input name="uname52" type="text" class="box" size=10 value=<?php echo($fcity); ?> disabled="disabled">
                      <span class="STYLE12">*</span></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>I am currently </strong></div></td>
                    <td colspan="3">&nbsp; <?php echo '<input type="text" name="title" class=box value="'.$mstatus.'" disabled="disabled"></input>'; ?></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Email: </strong></div></td>
                    <td>&nbsp;
                        <input name="email" type="text" class="box"  value=<?php echo($email); ?> disabled="disabled" size=30>
                      <span class="STYLE12">*</span></td>
                    <td colspan="2"><input type="checkbox" name="emailcheck" value="checkbox" checked="checked" disabled="disabled">
Keep me informed </td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Phone: </strong></div></td>
                    <td colspan="3">&nbsp;
                        <input name="phone" type="text"  value=<?php echo($phone); ?> class="box" disabled="disabled"></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Address:</strong></div></td>
                    <td colspan="3">&nbsp; <?php echo '<input type="text" name="title" size=80 class=box value="'.$address.'" disabled="disabled"></input>'; ?></td>
                  </tr>
                  <tr>
                    <td height="35">&nbsp;</td>
                    <td width="241">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
            </div></td>
          </tr>
        </table>
      </div></td>
    </tr>
  </table>
  <p style="border-bottom: 1px dotted #336633; margin-top:-10; margin-left:12; margin-bottom:10; width: 1010"></p>
  </font>
  <div style="font-size:12px">
  <a class="one" href="rockinus_intro.php">About us</a>&nbsp;|&nbsp; Jobs &nbsp;|&nbsp; Advertising&nbsp; |&nbsp; <span class="STYLE7">Give us a feedback.</span></div>
  <div style="margin-bottom:4; margin-top:4; font-size:12px">Copyright &copy; 2011 Rockinus Inc. </div>
</div><br>
</body>
</html>
