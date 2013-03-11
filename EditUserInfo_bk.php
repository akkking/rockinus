<?php 
include("Header.php"); 

//Global Variable: 
include 'dbconnect.php';
$uname = $_SESSION['usrname'];
	
if(isset($_POST['gender'])||isset($_POST['mstatus'])||isset($_POST['sstatus'])||isset($_POST['fname'])||isset($_POST['lname'])||isset($_POST['birthmonth'])||isset($_POST['fcountry'])||isset($_POST['fregion'])){
	if(isset($_POST['fname'])) $fname = $_POST['fname']; else $fname = NULL;
	if(isset($_POST['lname'])) $lname = $_POST['lname']; else $lname = NULL;
	if(isset($_POST['birthyear'])) 
		$birthdate  = $_POST['birthyear']."-".$_POST['birthmonth']."-".$_POST['birthday']; 
	else 
		$birthdate = NULL;
	if(isset($_POST['gender'])) $gender = $_POST['gender']; else $gender = NULL;
	if(isset($_POST['sstatus'])) $sstatus = $_POST['sstatus']; else $sstatus = NULL;
	if(isset($_POST['mstatus'])) $mstatus = $_POST['mstatus']; else $mstatus = NULL;
	if(isset($_POST['fcountry'])) $fcountry = $_POST['fcountry']; else $fcountry = NULL;
	if(isset($_POST['fregion'])) $fregion = $_POST['fregion']; else $fregion = NULL;

	if(checkdate(substr($birthdate,5,2),substr($birthdate,8,2),substr($birthdate,0,4))){
		$upd = mysql_query("UPDATE rockinus.user_info SET fname='$fname', lname='$lname', birthdate='$birthdate', gender='$gender', 			sstatus='$sstatus', mstatus='$mstatus', fcountry='$fcountry', fregion='$fregion' WHERE uname='$uname'");
		if(!$upd) die(mysql_error());
		$_SESSION['rst_msg'] = "<img src=img/addsuccessIcon.jpg width=25px>&nbsp;&nbsp;<strong><font color=#336633 size=3>Successful</font></strong>";
		$_SESSION['rst_flag'] = "sucess";
		mysql_close($link);
	}else{
		$_SESSION['rst_msg'] = "<img src=img/gantanhao.jpg width=25px>&nbsp;&nbsp;<strong><font color=red>Birth Date is invalid, please check.</font></strong>";
		mysql_close($link);
	}
}else{
	$q = mysql_query("SELECT * FROM rockinus.user_info where uname='$uname'");
	if(!$q) die(mysql_error());
	$object = mysql_fetch_object($q);
	$fname = $object->fname;
	$lname = $object->lname;
	$sstatus = $object->sstatus;
	$gender = $object->gender;
	$mstatus = $object->mstatus;
	$birthdate = $object->birthdate;
	if($birthdate=="0000-00-00")$birthdate=NULL;
	$fcountry = $object->fcountry;
	//if($fcountry =="empty")$fcountry="Select a country";
	$fregion = $object->fregion;
	if($fregion =="empty")$fregion="Select Hometown";
}                      

$gender_options = array("", ""); 
if($gender == "Male"){
	$gender_options[0] = " checked='checked'";
}else if($gender == "Female"){
	$gender_options[1] = " checked='checked'";
}

$sstatus_options = array("", ""); 
if($sstatus == "Student"){
	$sstatus_options[0] = " checked='checked'";
}else if($sstatus == "Employee"){
	$sstatus_options[1] = " checked='checked'";
}

$mstatus_options = array("", "", ""); 
if($mstatus == "Single" ){
	$mstatus_options[0] = "checked='checked'";
}else if($mstatus == "Married"){
	$mstatus_options[1] = "checked='checked'";
}else if($mstatus == "In a relationship"){
	$mstatus_options[2] = "checked='checked'";
}

$wid = ProfileProgress($uname);
?>
<style type="text/css">
<!--
.STYLE7 {color: #CC3300}
-->
</style>

<div align="center">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" style="padding-top:0; margin-top:0;" bgcolor="#FFFFFF">
    <tr>
      <td width="136" align="left" valign="top" style="border-right: 0px solid #CCCCCC; padding-left:15px;">
	  <?php include("leftMenu".$_SESSION['lan'].".php"); ?>
      </td>
      <td width="875" align="left" valign="top" style=" border:#CCCCCC solid 0; padding-left:3;">
	  <div align="center">
	  <form action="EditUserInfo.php" method="post" name="profile">
        <table width="875" height="394" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top" style="padding-right:3px">
                <table width="878" height="35" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="140" height="35" style="border: #CCCCCC solid 1; border-bottom:0 #CCCCCC dotted;"><div align="center"><strong>Profile</strong></div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 0; border-bottom:0 #CCCCCC dotted;"><div align="center"><a href="EditEduInfo.php" class="one">Education</a></div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 0; border-bottom:1 #CCCCCC dotted;"><div align="center"><a href="EditContactInfo.php" class="one">Contact</a></div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 0; border-bottom:0;"><div align="center"><a href="EditHobbyInfo.php" class="one">Interests</a></div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 0; border-bottom:1 #CCCCCC dotted;"><div align="center"><a href="EditHeadIcon.php" class="one">Head Icon</a> </div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 0; border-bottom:0 #CCCCCC dotted;"><div align="center"><a href="EditPassword.php" class="one">Password</a> </div></td>
                  </tr>
                </table>
            <div align="left">
              <table width="878" height="454" border="0" cellpadding="0" cellspacing="0" style="border-left:#CCCCCC dotted 1;border-right:#CCCCCC dotted 1;border-bottom:#CCCCCC dotted 1;">
                <tr>
                  <td height="60" colspan="2" align="center" style="padding-right:10; padding-top:5px">&nbsp;</td>
                  <td height="40"><div align="right" style="padding-right:10"><font color="#336633"><?php echo($wid)?>%</font></div></td>
                  <td height="40"><div align="left" style="width:200; padding-top:0; padding-bottom:0; border:1 #336633 solid; background: #EEEEEE">
                    <table height="17" border="0" cellpadding="0" cellspacing="0" >
                      <tr>
                        <td height="17" width="<?php echo(2*$wid)?>" bgcolor="#336699" align="left">&nbsp;</td>
                      </tr>
                    </table>
                  </div></td>
                </tr>
                <tr>
                  <td width="161" height="50" align="right" style="padding-right:15px"><strong>User ID </strong></td>
                  <td height="50">&nbsp;
                      <input name="uname" type="text" class="box" size="15" value="<?php echo($uname); ?>" disabled="disabled" /></td>
                  <td height="50" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td height="50" align="right" style="padding-right:15px"><strong>Full Name </strong></td>
                  <td height="50">&nbsp;
                      <input name="fname" type="text" class="box" size="15" value="<?php echo($fname); ?>" />
                    &nbsp;.&nbsp;
                      <input name="lname" type="text" class="box" size="15" value="<?php echo($lname); ?>" /></td>
                  <td height="50" colspan="2">&nbsp;</td>
                  </tr>
                <tr>
                  <td height="50" align="right" style="padding-right:15px"><strong>Birthdate</strong></td>
                  <td height="50">&nbsp;
                      <input name="birthyear" type="text" value="<?php echo(substr($birthdate,0,4)); ?>" size="4" maxlength="4" />
					  <select name="birthmonth">
					  <option value="00">Month</option>
					  <option value="01" <?php if(substr($birthdate,5,2)=="01")echo(" selected"); ?>>January</option>
					  <option value="02" <?php if(substr($birthdate,5,2)=="02")echo(" selected"); ?>>February</option>
					  <option value="03" <?php if(substr($birthdate,5,2)=="03")echo(" selected"); ?>>March</option>
					  <option value="04" <?php if(substr($birthdate,5,2)=="04")echo(" selected"); ?>>April</option>
					  <option value="05" <?php if(substr($birthdate,5,2)=="05")echo(" selected"); ?>>May</option>
					  <option value="06" <?php if(substr($birthdate,5,2)=="06")echo(" selected"); ?>>June</option>
					  <option value="07" <?php if(substr($birthdate,5,2)=="07")echo(" selected"); ?>>July</option>
					  <option value="08" <?php if(substr($birthdate,5,2)=="08")echo(" selected"); ?>>August</option>
					  <option value="09" <?php if(substr($birthdate,5,2)=="09")echo(" selected"); ?>>September</option>
					  <option value="10" <?php if(substr($birthdate,5,2)=="10")echo(" selected"); ?>>October</option>
					  <option value="11" <?php if(substr($birthdate,5,2)=="11")echo(" selected"); ?>>November</option>
					  <option value="12" <?php if(substr($birthdate,5,2)=="12")echo(" selected"); ?>>December</option>
					  </select>
					  <select name="birthday">
					  <option value="00">Day</option>
					  <option value="01" <?php if(substr($birthdate,8,2)=="01")echo(" selected"); ?>>01</option>
					  <option value="02" <?php if(substr($birthdate,8,2)=="02")echo(" selected"); ?>>02</option>
					  <option value="03" <?php if(substr($birthdate,8,2)=="03")echo(" selected"); ?>>03</option>
					  <option value="04" <?php if(substr($birthdate,8,2)=="04")echo(" selected"); ?>>04</option>
					  <option value="05" <?php if(substr($birthdate,8,2)=="05")echo(" selected"); ?>>05</option>
					  <option value="06" <?php if(substr($birthdate,8,2)=="06")echo(" selected"); ?>>06</option>
					  <option value="07" <?php if(substr($birthdate,8,2)=="07")echo(" selected"); ?>>07</option>
					  <option value="08" <?php if(substr($birthdate,8,2)=="08")echo(" selected"); ?>>08</option>
					  <option value="09" <?php if(substr($birthdate,8,2)=="09")echo(" selected"); ?>>09</option>
					  <option value="10" <?php if(substr($birthdate,8,2)=="10")echo(" selected"); ?>>10</option>
					  <option value="11" <?php if(substr($birthdate,8,2)=="11")echo(" selected"); ?>>11</option>
					  <option value="12" <?php if(substr($birthdate,8,2)=="12")echo(" selected"); ?>>12</option>
					  <option value="13" <?php if(substr($birthdate,8,2)=="13")echo(" selected"); ?>>13</option>
					  <option value="14" <?php if(substr($birthdate,8,2)=="14")echo(" selected"); ?>>14</option>
					  <option value="15" <?php if(substr($birthdate,8,2)=="15")echo(" selected"); ?>>15</option>
					  <option value="16" <?php if(substr($birthdate,8,2)=="16")echo(" selected"); ?>>16</option>
					  <option value="17" <?php if(substr($birthdate,8,2)=="17")echo(" selected"); ?>>17</option>
					  <option value="18" <?php if(substr($birthdate,8,2)=="18")echo(" selected"); ?>>18</option>
					  <option value="19" <?php if(substr($birthdate,8,2)=="19")echo(" selected"); ?>>19</option>
					  <option value="20" <?php if(substr($birthdate,8,2)=="20")echo(" selected"); ?>>20</option>
					  <option value="21" <?php if(substr($birthdate,8,2)=="21")echo(" selected"); ?>>21</option>
					  <option value="22" <?php if(substr($birthdate,8,2)=="22")echo(" selected"); ?>>22</option>
					  <option value="23" <?php if(substr($birthdate,8,2)=="23")echo(" selected"); ?>>23</option>
					  <option value="24" <?php if(substr($birthdate,8,2)=="24")echo(" selected"); ?>>24</option>
					  <option value="25" <?php if(substr($birthdate,8,2)=="25")echo(" selected"); ?>>25</option>
					  <option value="26" <?php if(substr($birthdate,8,2)=="26")echo(" selected"); ?>>26</option>
					  <option value="27" <?php if(substr($birthdate,8,2)=="27")echo(" selected"); ?>>27</option>
					  <option value="28" <?php if(substr($birthdate,8,2)=="28")echo(" selected"); ?>>28</option>
					  <option value="29" <?php if(substr($birthdate,8,2)=="29")echo(" selected"); ?>>29</option>
					  <option value="30" <?php if(substr($birthdate,8,2)=="30")echo(" selected"); ?>>30</option>
					  <option value="31" <?php if(substr($birthdate,8,2)=="31")echo(" selected"); ?>>31</option>
					  </select>				   </td>
                  <td height="50" colspan="2"><?php if(isset($_SESSION['rst_msg'])){
				  			echo($_SESSION['rst_msg']);
							unset($_SESSION['rst_msg']);
				  }?></td>
                  </tr>
                <tr>
                  <td height="50" align="right" style="padding-right:15px"><strong>I am </strong></td>
                  <td height="50" colspan="3">&nbsp;
                      <input type="radio" name="gender" value="Male" <?php echo $gender_options[0]; ?> />
                    Male&nbsp;&nbsp;
                    <input type="radio" name="gender" value="Female" <?php echo $gender_options[1]; ?> />
                    Female </td>
                </tr>
                <tr>
                  <td height="50" align="right" style="padding-right:15px"><strong>I am  </strong></td>
                  <td height="50" colspan="3">&nbsp;
                      <input type="radio" name="sstatus" value="Student" <?php echo $sstatus_options[0]; ?> />
                    Student&nbsp;&nbsp;
                    <input type="radio" name="sstatus" value="Employee" <?php echo $sstatus_options[1]; ?> />
                    Employe(e/r) </td>
                </tr>
                <tr>
                  <td height="50" align="right" style="padding-right:15px"><strong>I am </strong></td>
                  <td height="50" colspan="3">&nbsp;
                      <input type="radio" name="mstatus" value="Single" <?php echo $mstatus_options[0]; ?> />
                    Single&nbsp;&nbsp;
                    <input type="radio" name="mstatus" value="Married" <?php echo $mstatus_options[1]; ?> />
                    Married&nbsp;&nbsp;
                    <input type="radio" name="mstatus" value="In a relationship" <?php echo $mstatus_options[2]; ?> />
                    In a relationship </td>
                </tr>
                <tr>
                  <td height="50" align="right" style="padding-right:15px"><strong>  From </strong></td>
                  <td height="50" colspan="3">&nbsp;
           	<select name="fcountry" id="fcountry" onchange="regionChange(this);">
				  <?php 
				  	include 'dbconnect.php';
				  	$q = mysql_query("SELECT * FROM rockinus.country_info");
					if(!$q) die(mysql_error());
					while($obj = mysql_fetch_object($q)){
						$counid = trim($obj->counid);
						$country_name = trim($obj->country_name);
						if($counid == trim($fcountry))
							$selected = " selected"; 
						else 
                      		$selected = NULL;
						echo ("<option value=$counid $selected>$country_name</option>");
					}				
					?>
                    </select>
                    <select name="fregion" id="fregion">
					<?php 
				  	include 'dbconnect.php';
				  	$q = mysql_query("SELECT * FROM rockinus.user_info WHERE uname='$uname'");
					if(!$q) die(mysql_error());
					while($obj = mysql_fetch_object($q)){
						$loopregion = trim($obj->fregion);
						//if($loopregion == "empty") echo("<option value='empty'>Select hometown</option>");
						if($loopregion == trim($fregion))
							$selected = " selected"; 
						else 
                      		$selected = NULL;
						echo ("<option value=$loopregion $selected>$fregion</option>");
					}				
					?>
                    </select>                    </td>
                </tr>
                <tr>
                  <td height="27">&nbsp;</td>
                  <td width="415" valign="bottom"><div align="right"><br />
                          <p> </p>
                  </div></td>
                  <td width="79">&nbsp;</td>
                  <td width="221">&nbsp;</td>
                </tr>
                <tr>
                  <td height="47">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">
                    <input name="Submit" type="submit" class="btn" value=" SAVE " />
                  </td>
                  <td>
				  <?php if(isset($_SESSION['rst_flag']) && $_SESSION['rst_flag']=="success")
				  			echo("<div style=padding-left:10>
                      <input type=button class=btn value= NEXT  ONCLICK='window.location.href=EditEduInfo.php />
                      </div>
					?>	  
				</td>
                </tr>
                <tr>
                  <td height="40">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </div></td>
          </tr>
        </table>
		</form>
      </div>
	  </td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
