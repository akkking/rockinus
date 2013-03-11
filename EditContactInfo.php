<?php 
include 'dbconnect.php';
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
	
if(isset($_POST['contactSubmit'])){
	$cstate = $_POST['cstate'];
	$ccity = $_POST['ccity'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$address = trim($address1).trim($address2);
	if( trim($ccity)!="empty" )$_SESSION['rst_friend_flag']="success";
	
	//echo("UPDATE rockinus.user_contact_info SET email='$email', phone='$phone', address='$address', ccity='$ccity', cstate='$cstate', ccountry='US' WHERE uname='$uname'");
	$upd = mysql_query("UPDATE rockinus.user_contact_info SET email='$email', phone='$phone', address='$address', ccity='$ccity', cstate='$cstate', ccountry='US' WHERE uname='$uname'");
	if(!$upd) die(mysql_error());
	$_SESSION['rst_msg'] = "<img src=img/addsuccessIcon.jpg width=15>&nbsp;&nbsp;&nbsp;<strong><font color=#336633 style=''>Successful</font></strong>";
	$_SESSION['rst_flag'] = "success";
	header("location:EditContactInfoView.php");
	mysql_close($link);
}else{
	$q = mysql_query("SELECT * FROM rockinus.user_contact_info where uname='$uname'");
	if(!$q) die(mysql_error());
	$object = mysql_fetch_object($q);
	$ccity = $object->ccity;
	$cstate = $object->cstate;
	$email = $object->email;
	$phone = $object->phone;
	$address = $object->address;
	$address1 = NULL;
	$address2 = NULL;
	if ( strlen($address) > 0 && strlen($address) <40 ){
		$address1 = $address;
		$address2 = NULL;
	}else if( strlen($address) > 40 ){
		$address1 = substr( $address, 0, 40 );
		$address2 = substr( $address, 40, strlen($address)-40 );
	} 
}                      

$cs_options = array("", "", "", "", ""); 
if($cstate == "empty"){
	$cs_options[0] = "selected='selected'";
}else if($cstate == "NY"){
	$cs_options[1] = "selected='selected'";
}else if($cstate == "NJ"){
	$cs_options[2] = "selected='selected'";
}else if($cstate == "CA"){
	$cs_options[3] = "selected='selected'";
}else if($cstate == "ZZ"){
	$cs_options[4] = "selected='selected'";
}

$wid = ProfileProgress($uname);

include 'mainHeader.php';
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
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="padding-top:0; margin-top:0;">
    <tr>
      <td width="300" align="left" valign="top" style=" line-height:150%; font-size:14px; padding-left:15px">
	  <?php include "ProfileMenu.php" ?>
	  </td>
      <td width="760" align="left" valign="top"><form action="EditContactInfo.php" method="post" name="profile">
	    <table width="760" height="394" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="760" valign="top" align="right" style="padding-top:15px">
			<table width="740" height="400" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="50" colspan="2" align="center" style="padding-right:10; padding-top:5px">&nbsp;</td>
                      <td height="50" align="right" style="padding-right:10"><font color="#336633"><?php echo($wid)?>%</font></td>
                      <td height="50"><div align="left" style="width:200; padding-top:0; padding-bottom:0; border:1 #336633 solid; background: #EEEEEE">
                        <table height="17" border="0" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td height="17" width="<?php echo(2*$wid)?>" bgcolor="#336699" align="left">&nbsp;</td>
                          </tr>
                        </table>
                      </div></td>
                    </tr>
                    <tr>
                      <td width="180" height="25" align="right" style="padding-right:10px; ; "><strong>User name: </strong></td>
                      <td width="259" height="25">&nbsp;
                      <input name="uname" type="text" class="box" size="15" value="<?php echo($uname); ?>" style=" background-color:#FFFFFF; border:0; font-weight:bold; ; " disabled="disabled" /></td>
                      <td height="25" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="25" align="right" style="padding-right:10px; ; "><strong>Where you stay? </strong></td>
                      <td height="25">
					  <script>
$(document).ready(function() { 
	//$("#attendOrNot").hide();
	$('#cstate').change(function(){
    	var selected_item = $(this).val()
		//alert("111");
    	if(selected_item != "NY" && selected_item != "NJ"){
        	$('#cityDiv').hide();
    	}else{
       		$('#cityDiv').show();
    	}
	});
});
</script>
					  &nbsp;
                          <select name="cstate" id="cstate" onchange="cityChange(this);" style="; ">
                            <option value="empty" <?php echo $cs_options[0]; ?>>Select a State</option>
                            <option value="NY" <?php echo $cs_options[1]; ?>>New York</option>
							<option value="NJ" <?php echo $cs_options[2]; ?>>New Jersy</option>
							<option value="CA" <?php echo $cs_options[3]; ?>>California</option>
							<option value="MA" <?php echo $cs_options[3]; ?>>Massachusetts</option>
							<option value="ZZ" <?php echo $cs_options[4]; ?>>Other State</option>
                          </select>
						  <div id="cityDiv" class="cityDiv" style="display:inline">
                          <select name="ccity" id="ccity" style="; ">
                            <?php 
				  	include 'dbconnect.php';
					//$tag_in = 0;
					
					if($cstate=='NY'||$cstate=='NJ'||$cstate=='ZZ'){
					  	if($cstate=='NY')
						$q = mysql_query("SELECT * FROM rockinus.city_info WHERE state_name='New York' ORDER by city_name");
						else if($cstate=='NJ')
						$q = mysql_query("SELECT * FROM rockinus.city_info WHERE state_name='New Jersy' ORDER by city_name");
						else 
						$q = mysql_query("SELECT * FROM rockinus.city_info WHERE state_name='Other' ORDER by city_name");
						
						if(!$q) die(mysql_error());
						while($obj = mysql_fetch_object($q)){
							$loopcity = trim($obj->city_name);
							if($loopcity == trim($ccity)){
								$selected = " selected"; 
								$tag_in = 1;
							}
							else 
                      			$selected = NULL;
							echo ("<option value=$loopcity $selected>$loopcity</option>");
						}
					}else if($cstate!=NULL||trim($cstate)==""){
						if($cstate=='ZZ')
							echo ("<option value=$cstate selected>Other City</option>");
						else
							echo ("<option value=$cstate selected>$cstate</option>");
					}else
						echo ("<option value='ZZ' selected>Select a City</option>");
					?>
                      </select>
					  </div>
					  </td>
                      <td height="25" colspan="2"></td>
                    </tr>
                    <tr>
                      <td height="25" align="right" style="padding-right:10px; ; "><strong>Personal Email </strong></td>
                      <td height="25" colspan="3" style="; ">&nbsp;
                      <input name="email" type="text" class="box"  value="<?php echo($email); ?>" size="30" style="; ;" />&nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="checkbox" name="emailcheck" value="checkbox" checked="checked" />
                      Link to this Email once I graduate </td>
                    </tr>
                    <tr>
                      <td height="25" align="right" style="padding-right:10px; ; "><strong>Phone </strong></td>
                      <td height="25" colspan="3">&nbsp;
                      <input name="phone" type="text"  value="<?php echo($phone); ?>" class="box" size="30" style="; " /></td>
                    </tr>
                    <tr>
                      <td height="25" align="right" style="padding-right:10px; ; "><strong>Address</strong></td>
                      <td height="25" colspan="3">&nbsp; <?php echo("<input type='text' maxlength=40 name=address1 size=45 class=box value='$address1'>") ?></td>
                    </tr>
                    <tr>
                      <td height="25">&nbsp;</td>
                      <td height="25" colspan="3">&nbsp; <?php echo("<input type='text' name=address2 size=30 class=box value='$address2'>") ?></td>
                    </tr>
                    <tr>
                      <td height="47">&nbsp;</td>
                      <td style="padding-top:20; padding-left:10" valign="top">
					  <input name="contactSubmit" type="submit" style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:1px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; " value=" Save " />
					  </td>
                      <td width="71" style="padding-top:40;" align="right">&nbsp;
                          
                      </td>
                      <td width="228" style="padding-top:40;"></td>
                    </tr>
                    <tr>
                      <td height="10">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
              </table>
            </td>
          </tr>
        </table>
	  </form>
<table width="740" border="0" cellspacing="0" cellpadding="0" align="right">
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
</table>

	  </td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
