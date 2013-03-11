<?php 
include 'ValidCheck.php';
include("Allfuc.php");
include 'dbconnect.php';
$uname = $_SESSION['usrname'];
	
if(isset($_POST['infoSubmit'])){
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
	if($fcountry!="empty"&&$fregion!="empty") $_SESSION['rst_friend_flag'] = "success";
	
	if($mstatus!=NULL&&$gender!=NULL) $_SESSION['rst_emotionGender_flag'] = "success";
	
	if(checkdate(substr($birthdate,5,2),substr($birthdate,8,2),substr($birthdate,0,4))){
		$upd = mysql_query("UPDATE rockinus.user_info SET fname='$fname', lname='$lname', birthdate='$birthdate', gender='$gender', sstatus='$sstatus', mstatus='$mstatus', fcountry='$fcountry', fregion='$fregion' WHERE uname='$uname'");
		if(!$upd) die(mysql_error());
		$_SESSION['rst_msg'] = "<img src=img/addsuccessIcon.jpg width=20px>&nbsp;&nbsp;&nbsp;<strong><font color=#336633 size=3>Successful</font></strong>";
		$_SESSION['rst_flag'] = "success";
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
body,td,th {
	font-size: 14px;
}
-->
</style>

<div align="center">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" style="padding-top:0; margin-top:0;" bgcolor="#FFFFFF">
    <tr>
      <td width="300" align="left" valign="top" style="border-right: 1px dashed #DDDDDD;">
	  <?php include("leftHomeMenu.php"); ?>
      </td>
      <td width="760" align="right" valign="top">
		<?php include("HeaderEN.php"); ?>
	  <form action="EditUserInfo.php" method="post" name="profile">
        <table width="760" height="394" border="0" cellpadding="0" cellspacing="0" align="right">
          <tr>
            <td valign="top" align="right">
                <table width="740" height="35" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="140" height="35" style="border: #CCCCCC solid 1; border-bottom:0 #CCCCCC dotted;"><div align="center"><strong>Profile</strong></div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 0; border-bottom:0 #CCCCCC dotted;"><div align="center"><a href="EditEduInfo.php" class="one">Education</a></div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 0; border-bottom:1 #CCCCCC dotted;"><div align="center"><a href="EditContactInfo.php" class="one">Contact</a></div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 0; border-bottom:0;"><div align="center"><a href="EditHobbyInfo.php" class="one">Interests</a></div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 0; border-bottom:1 #CCCCCC dotted;"><div align="center"><a href="EditHeadIcon.php" class="one">Head Icon</a> </div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 0; border-bottom:0 #CCCCCC dotted;"><div align="center"><a href="EditPassword.php" class="one">Password</a> </div></td>
                  </tr>
                </table>

              <table width="740" height="564" border="0" cellpadding="0" cellspacing="0" style="border-left:#CCCCCC dotted 0;border-right:#CCCCCC dotted 0;border-bottom:#CCCCCC dotted 0;">
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
                  <td width="146" height="50" align="right" style="padding-right:15px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>User name </strong></td>
                  <td height="50">&nbsp;
                      <input name="uname" type="text" class="box" size="15" style="border:0; font-weight:bold; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif" value="<?php echo($uname); ?>" disabled="disabled" /></td>
                  <td height="50" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td height="50" align="right" style="padding-right:15px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>Full Name </strong></td>
                  <td height="50">&nbsp;
                      <input name="fname" type="text" class="box" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif" size="15" value="<?php echo($fname); ?>" />
                    &nbsp;.&nbsp;
                      <input name="lname" type="text" class="box" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif" size="15" value="<?php echo($lname); ?>" /></td>
                  <td height="50" colspan="2">&nbsp;</td>
                  </tr>
                <tr>
                  <td height="50" align="right" style="padding-right:15px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>Birth date</strong></td>
                  <td height="50">&nbsp;
                      <select name="birthyear" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
					  <option value="0000" selected>Year</option>
					  <option value="1971" <?php if(substr($birthdate,0,4)=="1971")echo(" selected"); ?>>1971</option>
					  <option value="1972" <?php if(substr($birthdate,0,4)=="1972")echo(" selected"); ?>>1972</option>
					  <option value="1973" <?php if(substr($birthdate,0,4)=="1973")echo(" selected"); ?>>1973</option>
					  <option value="1974" <?php if(substr($birthdate,0,4)=="1974")echo(" selected"); ?>>1974</option>
					  <option value="1975" <?php if(substr($birthdate,0,4)=="1975")echo(" selected"); ?>>1975</option>
					  <option value="1976" <?php if(substr($birthdate,0,4)=="1976")echo(" selected"); ?>>1976</option>
					  <option value="1977" <?php if(substr($birthdate,0,4)=="1977")echo(" selected"); ?>>1977</option>
					  <option value="1978" <?php if(substr($birthdate,0,4)=="1978")echo(" selected"); ?>>1978</option>
					  <option value="1979" <?php if(substr($birthdate,0,4)=="1979")echo(" selected"); ?>>1979</option>
					  <option value="1980" <?php if(substr($birthdate,0,4)=="1980")echo(" selected"); ?>>1980</option>
					  <option value="1981" <?php if(substr($birthdate,0,4)=="1981")echo(" selected"); ?>>1981</option>
					  <option value="1982" <?php if(substr($birthdate,0,4)=="1982")echo(" selected"); ?>>1982</option>
					  <option value="1983" <?php if(substr($birthdate,0,4)=="1983")echo(" selected"); ?>>1983</option>
					  <option value="1984" <?php if(substr($birthdate,0,4)=="1984")echo(" selected"); ?>>1984</option>
					  <option value="1985" <?php if(substr($birthdate,0,4)=="1985")echo(" selected"); ?>>1985</option>
					  <option value="1986" <?php if(substr($birthdate,0,4)=="1986")echo(" selected"); ?>>1986</option>
					  <option value="1987" <?php if(substr($birthdate,0,4)=="1987")echo(" selected"); ?>>1987</option>
					  <option value="1988" <?php if(substr($birthdate,0,4)=="1988")echo(" selected"); ?>>1988</option>
					  <option value="1989" <?php if(substr($birthdate,0,4)=="1989")echo(" selected"); ?>>1989</option>
					  <option value="1990" <?php if(substr($birthdate,0,4)=="1990")echo(" selected"); ?>>1990</option>
					  <option value="1991" <?php if(substr($birthdate,0,4)=="1991")echo(" selected"); ?>>1991</option>
					  <option value="1992" <?php if(substr($birthdate,0,4)=="1992")echo(" selected"); ?>>1992</option>
					  <option value="1993" <?php if(substr($birthdate,0,4)=="1993")echo(" selected"); ?>>1993</option>
					  <option value="1994" <?php if(substr($birthdate,0,4)=="1994")echo(" selected"); ?>>1994</option>
					  <option value="1995" <?php if(substr($birthdate,0,4)=="1995")echo(" selected"); ?>>1995</option>
					  <option value="1996" <?php if(substr($birthdate,0,4)=="1996")echo(" selected"); ?>>1996</option>
					  <option value="1997" <?php if(substr($birthdate,0,4)=="1997")echo(" selected"); ?>>1997</option>
					  </select>
					  <select name="birthmonth" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
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
					  <select name="birthday" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
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
                  <td height="50" align="right" style="padding-right:15px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>I am </strong></td>
                  <td height="50" colspan="3" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px">&nbsp;
                      <input type="radio" name="gender" value="Male" <?php echo $gender_options[0]; ?> />
                    Male&nbsp;&nbsp;
                    <input type="radio" name="gender" value="Female" <?php echo $gender_options[1]; ?> />
                    Female </td>
                </tr>
                <tr>
                  <td height="50" align="right" style="padding-right:15px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>I am currently  </strong></td>
                  <td height="50" colspan="3" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px">&nbsp;
                      <input type="radio" name="sstatus" value="Student" <?php echo $sstatus_options[0]; ?> />
                    Student&nbsp;&nbsp;
                    <input type="radio" name="sstatus" value="Employee" <?php echo $sstatus_options[1]; ?> />
                    Employe(e/r) </td>
                </tr>
                <tr>
                  <td height="50" align="right" style="padding-right:15px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>I am </strong></td>
                  <td height="50" colspan="3" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px">&nbsp;
                      <input type="radio" name="mstatus" value="Single" <?php echo $mstatus_options[0]; ?> />
                    Single&nbsp;&nbsp;
                    <input type="radio" name="mstatus" value="Married" <?php echo $mstatus_options[1]; ?> />
                    Married&nbsp;&nbsp;
                    <input type="radio" name="mstatus" value="In a relationship" <?php echo $mstatus_options[2]; ?> />
                    In a relationship </td>
                </tr>
                <tr>
                  <td height="50" align="right" style="padding-right:15px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>  From </strong></td>
                  <td height="50" colspan="3" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px">&nbsp;
           	<select name="fcountry" id="fcountry" onchange="regionChange(this);" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
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
                    <select name="fregion" id="fregion" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
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
                  <td width="314" valign="bottom"><div align="right"><br />
                          <p> </p>
                  </div></td>
                  <td width="62">&nbsp;</td>
                  <td width="216">&nbsp;</td>
                </tr>
                <tr>
                  <td height="47">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">
                    <input name="infoSubmit" type="submit" class="profile_btn" value=" Save " />                  </td>
                  <td>
				  <?php 
				  	if(isset($_SESSION['rst_flag']) && $_SESSION['rst_flag']=="success"){
				  		echo("<div style='padding-left:10'><input type='button' class='profile_btn' value='Continue' ONCLICK=window.location.href='EditEduInfo.php' /></div>");
					  	unset($_SESSION['rst_flag']);
					  }
					?>				</td>
                </tr>
                <tr>
                  <td height="39" colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td height="40" colspan="4">
				  <div style=" margin-bottom:30px; margin-top:2px; width:740" align="center">
			<?php 
			if(isset($_SESSION['rst_friend_flag']) && $_SESSION['rst_friend_flag']=="success"){
				$q = mysql_query("SELECT * FROM rockinus.user_info WHERE fcountry = '$fcountry' AND fregion = '$fregion' AND uname<>'$uname';");
				if(!$q) die(mysql_error());
				$no_row = mysql_num_rows($q);
				if($no_row>0){
					echo "<div align='left' style='width:700; margin-bottom:15'><font style='font-size:16px; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight:normal'>&nbsp;<img src=img/grayStar.jpg width=15 />&nbsp;&nbsp;&nbsp;Following student(s) frome the same hometown as you :</div>";
					while($object = mysql_fetch_object($q)){					
						$loopname = $object->uname;
				?>
								  <script type="text/javascript">
$(function() {
	$(".addFriendHometownDiv<?php echo($loopname) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($loopname) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#addFriendHometownDiv<?php echo($loopname) ?>").hide();
		$("#flashAddFriendHometown<?php echo($loopname) ?>").show();
		$("#flashAddFriendHometown<?php echo($loopname) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_frequest.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashAddFriendHometown<?php echo($loopname) ?>").hide();
				$("#addFriendHometownResult<?php echo($loopname) ?>").html(html);
				$("#addFriendHometownResult<?php echo($loopname) ?>").show();
			}
 		});
 		return false;
 	});
 });
</script>
				<?php
						$rel_rstatus = "N";
						if($loopname==$uname)$rel_rstatus ="S";
						else{
							$q11 = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE (sender='$loopname' AND recipient='$uname') OR (recipient='$loopname' AND sender='$uname')");
							if(!$q11) die(mysql_error());
							$no_row_A = mysql_num_rows($q11);
							if($no_row_A>0)$rel_rstatus='A';
	
							$q21 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$loopname' AND recipient='$uname' AND rstatus='P'");
							if(!$q21) die(mysql_error());
							$no_row_P = mysql_num_rows($q21);
							if($no_row_P>0)$rel_rstatus='X';
	
							$q22 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uname' AND recipient='$loopname' AND rstatus='P'");
							if(!$q22) die(mysql_error());
							$no_row_X = mysql_num_rows($q22);
							if($no_row_X>0)$rel_rstatus='P';	
						}
				
						$loop_uname = $loopname.'_fixed70.jpg';
						//date('Y-m-d, H:i');
						$target_loop_uname = "upload/".$loopname;
						echo("<table width='700' style='margin-bottom:10px'><tr>");
				
						if(is_dir($target_loop_uname)){
							echo("<td align='left' style='border:1px solid #EEEEEE; padding:5px' width='50px'><a href='RockerDetail.php?uid=$loopname' class=one title='$loopname'><img src=upload/$loopname/$loop_uname?".time()." style='margin-right:0px;'></a></td>");
						}else 
							echo("<td align='left' style='border:1px solid #EEEEEE; padding:5px' width='50px'><a href='RockerDetail.php?uid=$loopname' class=one title='$loopname'><img src='img/NoUserIcon_fixed.jpg' width=70 height=70 style='margin-right:0px;'></a></td>");
						
						echo("<td style='padding-left:15px; padding-top:5; line-height:150%; font-family: Verdana, Arial, Helvetica, sans-serif;' valign='top'><a href='RockerDetail.php?uid=$loopname' class=one><strong>$loopname</strong></a><br><br>");
						if($rel_rstatus=="S")echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='EditUserInfo.php' class=one>+ Edit</a></div>&nbsp;");
						else if($rel_rstatus=="P")echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'>Requested</div>");
						else if($rel_rstatus=="A")echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='FriendConfirm.php?uid=$loopname&&pageName=EditUserInfo' class=one>Defriend</a></div>");
						else if($rel_rstatus=="X"){
							echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='AcceptFriend.php?sender=$loopname' class=one>Accept</a></div>&nbsp;&nbsp;");
							echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='DenyFriend.php?sender=$loopname&&pageName=EditUserInfo' class=one>Decline</a></div>");
							}else if($rel_rstatus=="N")echo("<div id='addFriendHometownDiv$loopname' class='addFriendHometownDiv$loopname' style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' onMouseOver=this.style.cursor='hand' align='center'>+ Friend</div>");
						?>
	<span id="flashAddFriendHometown<?php echo($loopname) ?>" class="flashAddFriendHometown<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span>
 	 <span id="addFriendHometownResult<?php echo($loopname) ?>" class="addFriendHometownResult<?php echo($loopname) ?>" style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:none' align='center'></span>&nbsp;
	 					<?php
	 					if($rel_rstatus!="S"){?><div style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:90; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333; padding-top:5; padding:3 5 3 5; display:inline" align="center"><a href="SendMessage.php?recipient=<?php echo($loopname) ?>" class='one'>Message</a>
	</div>
	<?php } 
	
						echo("</td></tr></table>");
					}
				}		
				unset($_SESSION['rst_friend_flag']);
		}
	?>	
	</div>
			
			<div style=" margin-bottom:50px; margin-top:0px; width:740" align="center">
			<?php 
			if(isset($_SESSION['rst_emotionGender_flag']) && $_SESSION['rst_emotionGender_flag']=="success"){
				if($gender=='F') $gender_here = 'Male'; else $gender_here = 'Female';
				
				$q = mysql_query("SELECT * FROM rockinus.user_info WHERE gender = '$gender_here' AND mstatus = '$mstatus' AND uname<>'$uname';");
				if(!$q) die(mysql_error());
				$no_row = mysql_num_rows($q);
				if($no_row>0){
					echo "<div align='left' style='width:700; margin-bottom:15'><font style='font-size:16px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif;'>&nbsp;<img src=img/grayStar.jpg width=15 />&nbsp;&nbsp;&nbsp;Following student(s) are also $mstatus :</div>";
					while($object = mysql_fetch_object($q)){					
						$loopname = $object->uname;
				?>
				<script type="text/javascript">
$(function() {
	$(".addFriendRelDiv<?php echo($loopname) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($loopname) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#addFriendRelDiv<?php echo($loopname) ?>").hide();
		$("#flashAddFriendRel<?php echo($loopname) ?>").show();
		$("#flashAddFriendRel<?php echo($loopname) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_frequest.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashAddFriendRel<?php echo($loopname) ?>").hide();
				$("#addFriendRelResult<?php echo($loopname) ?>").html(html);
				$("#addFriendRelResult<?php echo($loopname) ?>").show();
			}
 		});
 		return false;
 	});
 });
</script>
				<?php
						$rel_rstatus = "N";
						if($loopname==$uname)$rel_rstatus ="S";
						else{
							$q11 = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE (sender='$loopname' AND recipient='$uname') OR (recipient='$loopname' AND sender='$uname')");
							if(!$q11) die(mysql_error());
							$no_row_A = mysql_num_rows($q11);
							if($no_row_A>0)$rel_rstatus='A';
	
							$q21 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$loopname' AND recipient='$uname' AND rstatus='P'");
							if(!$q21) die(mysql_error());
							$no_row_P = mysql_num_rows($q21);
							if($no_row_P>0)$rel_rstatus='X';
	
							$q22 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uname' AND recipient='$loopname' AND rstatus='P'");
							if(!$q22) die(mysql_error());
							$no_row_X = mysql_num_rows($q22);
							if($no_row_X>0)$rel_rstatus='P';	
						}
						
						$loop_uname = $loopname.'_fixed70.jpg';
						//date('Y-m-d, H:i');
						$target_loop_uname = "upload/".$loopname;
						echo("<table width='700' style='margin-bottom:10px'><tr>");
				
						if(is_dir($target_loop_uname)){
							echo("<td align='left' style='border:1px solid #EEEEEE; padding:5px' width='50px'><a href='RockerDetail.php?uid=$loopname' class=one title='$loopname'><img src=upload/$loopname/$loop_uname?".time()." style='margin-right:0px;'></a></td>");
						}else 
							echo("<td align='left' style='border:1px solid #EEEEEE; padding:5px' width='50px'><a href='RockerDetail.php?uid=$loopname' class=one title='$loopname'><img src='img/NoUserIcon_fixed.jpg' width=70 height=70 style='margin-right:0px;'></a></td>");
						
						echo("<td style='padding-left:15px; padding-top:5; line-height:150%; font-family: Verdana, Arial, Helvetica, sans-serif;' valign='top'><a href='RockerDetail.php?uid=$loopname' class=one><strong>$loopname</strong></a><br><br>");
						if($rel_rstatus=="S")echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='EditUserInfo.php' class=one>+ Edit</a></div>&nbsp;"); 
						else if($rel_rstatus=="P")echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'>Requested</div>");
						else if($rel_rstatus=="A")echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='FriendConfirm.php?uid=$loopname&&pageName=EditUserInfo' class=one>Defriend</a></div>");
						else if($rel_rstatus=="X"){
							echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='AcceptFriend.php?sender=$loopname'>Accept</a></div>&nbsp;&nbsp;");
							echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='DenyFriend.php?sender=$loopname&&pageName=EditUserInfo'>Decline</a></div>");
							}else if($rel_rstatus=="N")echo("<div id='addFriendRelDiv$loopname' class='addFriendRelDiv$loopname' style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' onMouseOver=this.style.cursor='hand' align='center'>+ Friend</div>");
						?>
	<span id="flashAddFriendRel<?php echo($loopname) ?>" class="flashAddFriendHometown<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span>
 	 <span id="addFriendRelResult<?php echo($loopname) ?>" class="addFriendHometownResult<?php echo($loopname) ?>" style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:90; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:none' align='center'></span>&nbsp;
	 					<?php
	 					if($rel_rstatus!="S"){?><div style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:90; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333; padding-top:5; padding:3 5 3 5; display:inline" align="center"><a href="SendMessage.php?recipient=<?php echo($loopname) ?>" class='one'>Message</a>
					</div>
					<?php } 
						echo("</td></tr></table>");
					}
				}		
				unset($_SESSION['rst_emotionGender_flag']);
			}
			?>	
			</div>
				  </td>
                  </tr>
              </table>
			
			</td>
          </tr>
        </table>
		</form>

	  </td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
