<?php 
include 'dbconnect.php';
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];

$cdegree_options = array("", "", "", "",""); 
if(isset($_POST['eduSubmit'])){
	if(isset($_POST['cdegree'])) $cdegree = $_POST['cdegree']; else $cdegree = NULL;
	if(isset($_POST['cmajor'])) $cmajor = $_POST['cmajor']; else $cmajor = "empty";
	if(isset($_POST['cschool'])) $sid = $_POST['cschool']; else $sid = "empty";
	if(isset($_POST['sterm'])) $sterm = $_POST['sterm']; else $sterm = "empty";
	if(isset($_POST['eterm'])) $eterm = $_POST['eterm']; else $eterm = "empty";

	$q_global = mysql_query("SELECT * FROM rockinus.global_info");
	if(!$q_global) die(mysql_error());
//	$no_row = mysql_num_rows($q_global);
	$object_global = mysql_fetch_object($q_global);
	$cur_term = $object_global->cur_term;
	$cur_term_year=substr($cur_term,0,4);
	
	$term_expire = 0;
	$term_num=4;
	
	if($cur_term_year<substr($sterm,0,4)){
		$term_expire = 1;	
//	}else if($strlen(cur_term)==10&&strlen($sterm)==8){
//		$term_expire = true;
	}
	
	if($sterm!="empty"&&$eterm!="empty"){
		if(strlen($sterm)==8 && strlen($eterm)==10)
			$term_num = (substr($eterm,0,4)-substr($sterm,0,4))*2 - 1;
		else if(strlen($sterm)==10 && strlen($eterm)==8)
			$term_num = (substr($eterm,0,4)-substr($sterm,0,4))*2 + 1;
		else
			$term_num = (substr($eterm,0,4)-substr($sterm,0,4))*2;
	}
	
	if($term_num<2||$term_num>4||$term_expire==1){
		$_SESSION['err_rst_msg'] = "<img src=img/error_new.jpg width=15>&nbsp;&nbsp;<strong><font color=#B92828>Check enrolled, graduated term</font></strong>";
		mysql_close($link);
	}else{
		if( $cmajor!=NULL && strlen($cmajor)>0 )$_SESSION['rst_friend_flag']="success";

		$upd = mysql_query("UPDATE rockinus.user_edu_info SET cdegree='$cdegree', cmajor='$cmajor', cschool='$sid', sterm='$sterm', eterm='$eterm' WHERE uname='$uname'");
		if(!$upd) die(mysql_error());
		$_SESSION['rst_msg'] = "<img src=img/addsuccessIcon.jpg width=15>&nbsp;&nbsp;&nbsp;<strong><font color=#336633 style=''>Successful</font></strong>";
		$_SESSION['rst_flag'] = "success";
		header("location:EditEduInfoView.php");
		mysql_close($link);
	}
}else{
	$q = mysql_query("SELECT * FROM rockinus.user_edu_info where uname='$uname'");
	if(!$q) die(mysql_error());
	$no_row = mysql_num_rows($q);
	if($no_row == 0) die("No matches met your criteria.");
	$object = mysql_fetch_object($q);
	$sid = $object->cschool;
	$cdegree = $object->cdegree;
	$cmajor = $object->cmajor;
	$sterm = $object->sterm;
	$eterm = $object->eterm;
}
                      
if($cdegree == "Undegraduate"){
	$cdegree_options[0] = "checked='checked'";
}else if($cdegree == "Graduate" ){
	$cdegree_options[1] = "checked='checked'";
}else if($cdegree == "PHD"){
	$cdegree_options[2] = "checked='checked'";
}else if($cdegree == "Certificate"){
	$cdegree_options[3] = "checked='checked'";
}

$wid = ProfileProgress($uname);

include 'mainHeader.php';
?><style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
<div align="center">
  <table width="1018" height="479" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="300" height="479" align="left" valign="top" style=" padding-left:15px; line-height:150%; font-size:14px">
	  <?php include "ProfileMenu.php" ?>
	  </td>
      <td width="760" align="right" valign="top">
	  <form action="EditEduInfo.php" method="post" name="profile">
        <table width="740" height="394" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top" align="right" style="padding-top:15px; padding-bottom:15px">
			<table width="740" height="450" border="0" cellpadding="0" cellspacing="0" style="border:0px solid #999999">
                <tr>
                  <td height="50" colspan="2" align="right" style="padding-right:10"><font color="#336633"><?php echo($wid)?>%</font></td>
                  <td height="50" colspan="2"><div align="left" style="width:200; padding-top:0; padding-bottom:0; border:1 #336633 solid; background: #EEEEEE">
                    <table height="17" border="0" cellpadding="0" cellspacing="0" >
                      <tr>
                        <td height="17" width="<?php echo(2*$wid)?>" bgcolor="#336699" align="left">&nbsp;</td>
                      </tr>
                    </table>
                  </div><div align="center"></div></td>
                </tr>
                <tr>
                  <td width="192" height="25" align="right" style="padding-right:10px;  "><strong>User name: </strong></td>
                  <td width="298" height="25" style="padding-left:10">
				  <input name="uname" type="text" class="box" style=" background-color:#FFFFFF; border:0; font-weight:bold;  " value="<?php echo($uname); ?>" size="15" disabled="disabled" /></td>
                  <td height="25" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td height="25" align="right" style="padding-right:10px;  "><strong>I am a(n) </strong></td>
                  <td height="25" style=" ">&nbsp;
                      <input type="radio" name="cdegree" value="Undergraduate" <?php echo $cdegree_options[0]; ?>>&nbsp;Undergraduate&nbsp;&nbsp;&nbsp;
			      <input type="radio" name="cdegree" value="Graduate" <?php echo $cdegree_options[1]; ?>>&nbsp;Graduate&nbsp;&nbsp;&nbsp;</td>
                  <td height="25" colspan="2" style=" ">
				  <?php if(isset($_SESSION['err_rst_msg'])){
				  			echo($_SESSION['err_rst_msg']);
							unset($_SESSION['err_rst_msg']);
				  }?>				  </td>
                </tr>
                <tr>
                  <td height="25">&nbsp;</td>
                  <td height="25" style=" ">&nbsp;
<input type="radio" name="cdegree" value="P.h.D" <?php echo $cdegree_options[2]; ?> />&nbsp;PHD/Doctor&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="cdegree" value="Transfer" <?php echo $cdegree_options[3]; ?> />
                  &nbsp;Exchange/Scholar(J1) </td>
                  <td height="25" colspan="2"></td>
                </tr>
                <tr>
                  <td height="25" align="right" style="padding-right:10px;  "><strong>Most recent  school: </strong></td>
                  <td height="25" colspan="3">&nbsp;
                      <select name="cschool" id="cschool" style=" ">
                        <?php 
				  	include 'dbconnect.php';
					$tag_in = 0;
				  	$q = mysql_query("SELECT * FROM rockinus.school_info ORDER BY school_name ASC");
					if(!$q) die(mysql_error());
					while($obj = mysql_fetch_object($q)){
						$loopsid = $obj->sid;
						$school_name = trim($obj->school_name);
						if($loopsid == $sid){
							$selected = " selected"; 
							$tag_in = 1;
						}else 
                      		$selected = NULL;
						echo ("<option value=$loopsid $selected>$school_name</option>");
					}		
					if( $tag_in == 0 ) echo("<option value='empty' selected>Select a School</option>");
					?>
                  </select></td>
                </tr>
                <tr>
                  <td height="25" align="right" style="padding-right:10px;  "><strong>Which program? </strong></td>
                  <td height="25" colspan="3">&nbsp;
                      <select name="cmajor" style=" ">
					  <?php 
				  	include 'dbconnect.php';
					$tag_in = 0;
				  	$q = mysql_query("SELECT * FROM rockinus.major_info ORDER BY major_name");
					if(!$q) die(mysql_error());
					while($obj = mysql_fetch_object($q)){
						$loopmid = trim($obj->mid);
						$loopmajor_name = trim($obj->major_name);
						if($loopmid == trim($cmajor)){
							$selected = " selected"; 
							$tag_in = 1;
						}
						else 
                      		$selected = NULL;
						echo ("<option value=$loopmid $selected>$loopmajor_name</option>");
					}	
					if( $tag_in == 0 )	echo ("<option value='empty' selected>Select a Major</option>");
					?>
                  </select>					</td>
                </tr>
                <tr>
                  <td height="25" align="right" style="padding-right:10px;  "><strong>When enrolled? </strong></td>
                  <td height="25" colspan="3">&nbsp;
                      <select name="sterm" style=" ">
                      	<?php 
				  	include 'dbconnect.php';
					$tag_in = 0;
				  	$q = mysql_query("SELECT * FROM rockinus.school_term_info WHERE sid='NYPOLY' AND tyear<'2014' ORDER BY tyear DESC");
					if(!$q) die(mysql_error());
					while($obj = mysql_fetch_object($q)){
						$loopterm = trim($obj->tyear).trim($obj->tterm);
						$displayterm = trim($obj->tyear)." ".trim($obj->tterm);
						if($loopterm == trim($sterm)){
							$selected = " selected"; 
							$tag_in = 1;
						}
						else 
                      		$selected = NULL;
						echo ("<option value=$loopterm $selected>$displayterm</option>");
					}
					if( $tag_in == 0 ) echo ("<option value=empty selected>Select a Term</option>");
					?>
				  </select>                  </td>
                </tr>
                <tr>
                  <td height="25" align="right" style="padding-right:10px;  "><strong>When graduate(d)? </strong></td>
                  <td height="25" colspan="3">&nbsp;
                      <select name="eterm" style=" ">
                      	<?php 
				  	include 'dbconnect.php';
					$tag_in = 0;
				  	$q = mysql_query("SELECT * FROM rockinus.school_term_info WHERE sid='NYPOLY' ORDER BY tyear DESC");
					if(!$q) die(mysql_error());
					while($obj = mysql_fetch_object($q)){
						$loopterm = trim($obj->tyear).trim($obj->tterm);
						$displayterm = trim($obj->tyear)." ".trim($obj->tterm);
						if($loopterm == trim($eterm)){
							$selected = " selected"; 
							$tag_in = 1;
						}
						else 
                      		$selected = NULL;
						echo ("<option value=$loopterm $selected>$displayterm</option>");
					}
					if( $tag_in == 0 ) echo ("<option value=empty selected>Select a Term</option>");
					?>
				  </select>					</td>
                </tr>
                <tr>
                  <td height="75" align="center">&nbsp;</td>
                  <td height="75" align="left" style="padding-left:10; padding-top:25;" valign="top">
				  <input name="eduSubmit" type="submit" style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:1px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; " value=" Save " />				  </td>
                  <td width="76" height="75" align="right" valign="middle">&nbsp;                  </td>
                  <td width="172" height="75" valign="middle">				  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
		</form>
	  </td>
    </tr>
</table>
<?php 
//if(isset($_SESSION['rst_flag'])) unset($_SESSION['rst_flag']);
include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
