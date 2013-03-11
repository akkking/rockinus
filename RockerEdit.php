<?php include("Header.php"); ?>
<div align="center">
  <table width="1018" height="394" border="0" cellpadding="0" cellspacing="0" style="padding-top:0; margin-top:0;">
    <tr>
      <td width="136" align="left" valign="top" style="border-right: 1px solid #CCCCCC; padding-right:0; padding-left:10;width:10">
	  <div style="margin-top: 0; margin-bottom: -20; margin-left:0; margin-right: -5; padding-left:10; border-left: 0px solid #CCCCCC; background-color: #; height:550px" align="left">
        <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:8"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0" /> <a href="HouseRental.php" class="one">House</a> </div>
        <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"><img src="img/RightArrow.jpg" width="12" height="12" style="border:0" /> <a href="FleaMarket.php" class="one">Market </a></div>
        <hr width="120"  size="1" color="#CCCCCC" style="margin-left:-5; border-bottom:dotted" />
        <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0" /> <a href="SchoolCourse.php" class="one">Schools</a> </div>
        <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0" /> <a href="SchoolCourse.php" class="one">Courses</a> </div>
        <hr width="120"  size="1" color="#CCCCCC" style="margin-left:-5; border-bottom:dotted" />
        <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"><img src="img/RightArrow.jpg" width="12" height="12" style="border:0" /> <a href="FriendGroup.php" class="one">Friends</a> </div>
        <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0" /> <a href="FriendGroup.php" class="one">Groups </a></div>
        <hr width="120"  size="1" color="#CCCCCC" style="margin-left:-5; border-bottom:dotted" />
        <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0" /> <a href="RockerDetail.php?uid=<?php echo($uname) ?>" class="one">Profile </a></div>
        <hr width="120"  size="1" color="#CCCCCC" style="margin-left:-5; border-bottom:dotted" />
        <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0" /> <a href="SendMessage.php" class="one">Send <span class="STYLE18">(Message)</span></a></div>
        <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0" /> <a href="MessageList.php" class="one">Read <span class="STYLE18">(Message)</span></a></div>
        <hr width="120"  size="1" color="#CCCCCC" style="margin-left:-5; border-bottom:dotted" />
        <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0" /> Wisdom </a></div>
        <br />
      </div></td>
      <td width="882" align="left" valign="top" style=" border:#CCCCCC solid 0; padding-left:3;">
	  <div align="center">
	  <form action="ChangeProfile.php" method="post" name="profile" onSubmit="return validateForm()" >
        <table width="888" height="394" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top"><div align="center">
                <table width="880" height="28" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="140" height="26" style="border: #CCCCCC solid 1; border-bottom:0;"><div align="center"><a href="RockerProfile.php" class="one">Profile</a></div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 1; border-bottom:1 #CCCCCC dotted;"><div align="center"><a href="PasswdEdit.php" class="one">Password </a></div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 1; border-bottom:1 #CCCCCC dotted;"><div align="center"><a href="ChangeHeadIcon.php" class="one">Head Icon </a></div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 1; border-bottom:1 #CCCCCC dotted;"><div align="center"><a href="RockerEdit.php" class="one">Memo </a></div></td>
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
//$ccity = $object->ccity;
//$cstate = $object->cstate;
//$fcity = $object->fcity;
//$fcountry = $object->fcountry;
//$email = $object->email;
//$cmajor = $object->cmajor;
//$cschool = $object->cschool;
//$cdegree = $object->cdegree;
//$phone = $object->phone;
//$address = $object->address;

$cdegree_options = array("", "", "", "",""); 
//if($cdegree == "U"){
//	$cdegree_options[0] = "checked='checked'";
//}else if($cdegree == "G"){
//	$cdegree_options[1] = "checked='checked'";
//}else if($cdegree == "P"){
//	$cdegree_options[2] = "checked='checked'";
//}else if($cdegree == "C"){
//	$cdegree_options[3] = "checked='checked'";
//}

$cschool_options = array("", "", "", "","", "", "", "", "", "", "", "", ""); 
//if($cschool == "empty"){
//	$cschool_options[0] = "selected='selected'";
//}else if($cschool == "NYNYU"){
//	$cschool_options[1] = "selected='selected'";
//}else if($cschool == "NYCOLUMBIA"){
//	$cschool_options[2] = "selected='selected'";
//}else if($cschool == "NYPOLY"){
//	$cschool_options[3] = "selected='selected'";
//}else if($cschool == "NYCUNY"){
//	$cschool_options[4] = "selected='selected'";
//}else if($cschool == "NYLIU"){
//	$cschool_options[5] = "selected='selected'";
//}else if($cschool == "NYNYIT"){
//	$cschool_options[6] = "selected='selected'";
//}

$cmajor_options = array("", "", "", "","", "", "", "", "", "", "", "", "", ""); 
//if($cmajor == "empty"){
//	$cmajor_options[0] = "selected='selected'";
//}else if($cmajor == "ECVE"){
//	$cmajor_options[1] = "selected='selected'";
//}else if($cmajor == "ECS"){
//	$cmajor_options[2] = "selected='selected'";
//}else if($cmajor == "EEE"){
//	$cmajor_options[3] = "selected='selected'";
//}else if($cmajor == "ECBE"){
//	$cmajor_options[4] = "selected='selected'";
//}else if($cmajor == "ECE"){
//	$cmajor_options[5] = "selected='selected'";
//}else if($cmajor == "EBS"){
//	$cmajor_options[6] = "selected='selected'";
//}else if($cmajor == "EBENT"){
//	$cmajor_options[7] = "selected='selected'";
//}else if($cmajor == "EC"){
//	$cmajor_options[8] = "selected='selected'";
//}else if($cmajor == "EBENG"){
//	$cmajor_options[9] = "selected='selected'";
//}else if($cmajor == "EBT"){
//	$cmajor_options[10] = "selected='selected'";
//}else if($cmajor == "EMC"){
//	$cmajor_options[11] = "selected='selected'";	
//}else if($cmajor == "EBI"){
//	$cmajor_options[12] = "selected='selected'";
//}else if($cmajor == "EBM"){
//	$cmajor_options[13] = "selected='selected'";	
//}
                      
$gender_options = array("", ""); 
if($gender == "M"){
	$gender_options[0] = "checked='checked'";
}else if($gender == "F"){
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

//if($cdegree=='G')$cdegree='Master Student';
//else if($cdegree=='P')$cdegree='P.H.D.';
//else if($cdegree=='U')$cdegree='Undergraduate';
//else $cdegree='Certificate Student';

if($mstatus=='S')$mstatus='Single';
else if($mstatus=='M')$mstatus='Married';
else if($mstatus=='I')$mstatus='In a relationship';

//$q1 = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
//if(!$q1) die(mysql_error());
//$obj1 = mysql_fetch_object($q1);
//$cschool = $obj1->school_name;
//$q2 = mysql_query("SELECT * FROM rockinus.major_info where mid='$cmajor'");
//if(!$q2) die(mysql_error());
//$obj2 = mysql_fetch_object($q2);
//$cmajor = $obj2->major_name;
//$q3 = mysql_query("SELECT * FROM rockinus.country_info where counid='$fcountry'");
//if(!$q3) die(mysql_error());
//$obj3 = mysql_fetch_object($q3);
//$fcountry_name = $obj3->country_name;

$cs_options = array("", "", "", ""); 
//if($cstate == "empty"){
//	$cs_options[0] = "selected='selected'";
//}elseif($cstate == "NY"){
//	$cs_options[1] = "selected='selected'";
//}

$fc_options = array("", "", "", "","", "", "", "", "", "", "", "", ""); 
//if($fcountry == "empty"){
//	$fc_options[0] = "selected='selected'";
//}elseif($fcountry == "IN"){
//	$fc_options[1] = "selected='selected'";
//}elseif($fcountry == "CN"){
//	$fc_options[2] = "selected='selected'";
//}elseif($fcountry == "TK"){
//	$fc_options[3] = "selected='selected'";
//}elseif($fcountry == "KO"){
//	$fc_options[4] = "selected='selected'";
//}elseif($fcountry == "MX"){
//	$fc_options[5] = "selected='selected'";
//}elseif($fcountry == "TW"){
//	$fc_options[6] = "selected='selected'";
//}elseif($fcountry == "JP"){
//	$fc_options[7] = "selected='selected'";
//}elseif($fcountry == "US"){
//	$fc_options[8] = "selected='selected'";
//}elseif($fcountry == "UK"){
//	$fc_options[9] = "selected='selected'";
//}elseif($fcountry == "SP"){
//	$fc_options[10] = "selected='selected'";
//}
?>
                    </div></td>
                  </tr>
                </table>
              <table width="880" height="546" border="0" cellpadding="0" cellspacing="0" style="border-left:#CCCCCC dotted 1">
                  <tr>
                    <td height="16" colspan="4">&nbsp;</td>
                    </tr>
                  <tr>
                    <td width="188" height="40"><div align="right" style="padding-right:5"><strong>Rock ID: </strong></div></td>
                    <td>&nbsp;
                        <input name="uname" type="text" class="box" value=<?php echo($uname); ?> disabled="disabled">
                        <span class="STYLE12">*</span></td>
                    <td width="237">&nbsp;</td>
                    <td width="228">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Your Name: </strong></div></td>
                    <td colspan="3">&nbsp;
                        <input name="fname" type="text" class="box" value=<?php echo($fname); ?>>&nbsp;.&nbsp;
                        <input name="lname" type="text" class="box" value=<?php echo($lname); ?>></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Birthdate:</strong></div></td>
                    <td colspan="3">&nbsp;
                        <input name="birthdate" type="text" class="box" id="birthdate"  value=<?php echo($birthdate); ?> size="10" maxlength="10">
                        <span class="STYLE12">*
                          <div id="calendar"></div>
                        </span></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>I am </strong></div></td>
                    <td colspan="3">&nbsp;
                      <input type="radio" name="gender" value="M" <?php echo $gender_options[0]; ?>>Male
					  <input type="radio" name="gender" value="F" <?php echo $gender_options[1]; ?>>Female 
					</td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>I am a </strong></div></td>
                    <td colspan="3">&nbsp;
                      <input type="radio" name="sstatus" value="S" <?php echo $sstatus_options[0]; ?>>Student
					  <input type="radio" name="sstatus" value="E" <?php echo $sstatus_options[1]; ?>>Employe(e/r) 
					</td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Where you stay? </strong></div></td>
                    <td colspan="3">&nbsp;
                      <select name="cstate" id="cstate" onChange="cityChange(this);">
                        <option value="empty" <?php echo $cs_options[0]; ?>>Select a State</option>
                        <option value="NY" <?php echo $cs_options[1]; ?>>New York</option>
                      </select>
                      <select name="ccity" id="ccity">
                        <option value="empty">Select a City</option>
                      </select>
                      <span class="STYLE12">* <span class="STYLE17">[ Current only New York is avaliable ]</span></span></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Current School: </strong></div></td>
                    <td colspan="3">&nbsp;
                      <select name="cschool" id="cschool">
                        <option value="empty" <?php echo $cschool_options[0]; ?>>Select a School</option>
                        <option value="NYNYU" <?php echo $cschool_options[1]; ?>>New York University</option>
                        <option value="NYCOLUMBIA" <?php echo $cschool_options[2]; ?>>Columbia University</option>
                        <option value="NYPOLY" <?php echo $cschool_options[3]; ?>>Polytechnic University of New York University</option>
                        <option value="NYCUNY" <?php echo $cschool_options[4]; ?>>City University of New York</option>
                        <option value="NYLIU" <?php echo $cschool_options[5]; ?>>Long Island University</option>
                        <option value="NYNYIT" <?php echo $cschool_options[6]; ?>>New York Institute of Technology</option>
                      </select>
                      <span class="STYLE12">*</span> <span class="STYLE17">[ If not a student, type the most recent school studied ] </span></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>I am a(n) </strong></div></td>
                    <td colspan="3">&nbsp;
                      <input type="radio" name="cdegree" value="U" <?php echo $cdegree_options[0]; ?>>Undergraduate
					  <input type="radio" name="cdegree" value="G" <?php echo $cdegree_options[1]; ?>>Graduate
					  <input type="radio" name="cdegree" value="P" <?php echo $cdegree_options[2]; ?>>PHD/Doctor
					  <input type="radio" name="cdegree" value="C" <?php echo $cdegree_options[3]; ?>>Certificate Program
					</td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Which Program Study? </strong></div></td>
                    <td colspan="3">&nbsp;
                      <select name="cmajor">
                        <option value="empty"<?php echo $cmajor_options[0]; ?>>Select a program</option>
                        <option value="ECVE" <?php echo $cmajor_options[1]; ?>>Civil Engineering</option>
                        <option value="ECS" <?php echo $cmajor_options[2]; ?>>Computer Science</option>
                        <option value="EEE" <?php echo $cmajor_options[3]; ?>>Electrical Engineering</option>
                        <option value="ECBE" <?php echo $cmajor_options[4]; ?>>Chemical and Biomolecular Engineering</option>
                        <option value="ECE" <?php echo $cmajor_options[5]; ?>>Chemical Engineering</option>
                        <option value="EBS" <?php echo $cmajor_options[6]; ?>>Biomolecular Science</option>
                        <option value="EBENT" <?php echo $cmajor_options[7]; ?>>Biotechnology and Entrepreneurship</option>
                        <option value="EC" <?php echo $cmajor_options[8]; ?>>Chemistry</option>
                        <option value="EBENG" <?php echo $cmajor_options[9]; ?>>Biomedical Engineering</option>
                        <option value="EBT" <?php echo $cmajor_options[10]; ?>>Biotechnology</option>
                        <option value="EMC" <?php echo $cmajor_options[11]; ?>>Materials Chemistry</option>
                        <option value="EBI" <?php echo $cmajor_options[12]; ?>>Bioinstrumentation</option>
                        <option value="EBM" <?php echo $cmajor_options[13]; ?>>Biomedical Materials</option>
                      </select>
                      <span class="STYLE12">*</span> <span class="STYLE17">[ The major you study(ied) at current or most recent school ] </span></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Where  From? </strong></div></td>
                    <td colspan="3">&nbsp;
                      <select name="fcountry" id="fcountry" onChange="gcityChange(this);">
                        <option value="empty" <?php echo $fc_options[0]; ?>>Select a country</option>
                        <option value="IN" <?php echo $fc_options[1]; ?>>India</option>
                        <option value="CN" <?php echo $fc_options[2]; ?>>P.R. China</option>
                        <option value="TK" <?php echo $fc_options[3]; ?>>Turkey</option>
                        <option value="KO" <?php echo $fc_options[4]; ?>>Korea</option>
                        <option value="MX" <?php echo $fc_options[5]; ?>>Mexico</option>
                        <option value="TW" <?php echo $fc_options[6]; ?>>Taiwan</option>
                        <option value="JP" <?php echo $fc_options[7]; ?>>Japan</option>
                        <option value="US" <?php echo $fc_options[8]; ?>>United States</option>
                        <option value="UK" <?php echo $fc_options[9]; ?>>United Kingdom</option>
                        <option value="SP" <?php echo $fc_options[10]; ?>>Spain</option>
                      </select>
                      <span class="STYLE12">
                      <select name="fcity" id="fcity">
                        <option value="empty">Select a city</option>
                      </select>
*</span> </td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>I am currently </strong></div></td>
                    <td colspan="3">&nbsp;
                      <input type="radio" name="mstatus" value="S" <?php echo $mstatus_options[0]; ?>>Single
					  <input type="radio" name="mstatus" value="M" <?php echo $mstatus_options[1]; ?>>Married
					  <input type="radio" name="mstatus" value="I" <?php echo $mstatus_options[2]; ?>>In a relationship
					</td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Email: </strong></div></td>
                    <td>&nbsp;
                        <input name="email" type="text" class="box"  value=<?php echo($email); ?> size=30>
                      <span class="STYLE12">*</span></td>
                    <td colspan="2"><input type="checkbox" name="emailcheck" value="checkbox" checked="checked">
Keep me informed </td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Phone: </strong></div></td>
                    <td colspan="3">&nbsp;
                        <input name="phone" type="text"  value=<?php echo($phone); ?> class="box"></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Address:</strong></div></td>
                    <td colspan="3">&nbsp; <?php echo '<input type="text" name=address size=80 class=box value="'.$address.'"></input>'; ?></td>
                  </tr>
                  <tr>
                    <td height="35">&nbsp;</td>
                    <td width="226">
                      <div align="right"><br>
                        <input name="Submit" type="submit" class="btn" value=" Submit "><p>
                      </div></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table><br>
            </div></td>
          </tr>
        </table>
		</form>
      </div>
	  </td>
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
