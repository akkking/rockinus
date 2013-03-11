<?php 
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
	if(isset($_POST['fcountry'])) $fcountry = trim($_POST['fcountry']); else $fcountry = NULL;
	if(isset($_POST['fregion'])) $fregion = trim($_POST['fregion']); else $fregion = NULL;
	if($fcountry!="empty"&&$fregion!="empty") $_SESSION['rst_friend_flag'] = "success";
	
	if($mstatus!=NULL&&$gender!=NULL) $_SESSION['rst_emotionGender_flag'] = "success";
	
	if(checkdate(substr($birthdate,5,2),substr($birthdate,8,2),substr($birthdate,0,4))){
		$upd = mysql_query("UPDATE rockinus.user_info SET fname='$fname', lname='$lname', birthdate='$birthdate', gender='$gender', sstatus='$sstatus', mstatus='$mstatus', fcountry='$fcountry', fregion='$fregion' WHERE uname='$uname'");
		if(!$upd) die(mysql_error());
		$_SESSION['rst_msg'] = "<img src=img/addsuccessIcon.jpg width=15>&nbsp;&nbsp;&nbsp;<strong><font color=#336633 style=''>Successful</font></strong>";
		$_SESSION['rst_flag'] = "success";
		header("location:EditUserInfoView.php");
		mysql_close($link);
	}else{
		$_SESSION['err_rst_msg'] = "<img src=img/gantanhao.jpg width=25px>&nbsp;&nbsp;<strong><font color=red>Birth Date is invalid, please check.</font></strong>";
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

include 'mainHeader.php';
?>
<style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/ajax.jquery.min.js"></script>
<script>
function getXMLHTTP() { //fuction to return the xml http object
	var xmlhttp=false;	
	try{
		xmlhttp=new XMLHttpRequest();
	}
	catch(e)	{		
		try{			
			xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e1){
				xmlhttp=false;
			}
		}
	}
		 	
	return xmlhttp;
}
	
function getRegion(strURL)
{         
 var req = getXMLHTTP(); // fuction to get xmlhttp object 
 if (req)
 {
  	req.onreadystatechange = function()
 	{
  		if (req.readyState == 4) { //data is retrieved from server
   			if (req.status == 200) { // which reprents ok status                    
     			document.getElementById('regionDiv').innerHTML=req.responseText;
  			}
  			else
  			{ 
     			alert("There was a problem while using XMLHTTP:\n");
  			}
  		}            
  	}        
	req.open("GET", strURL, true); //open url using get method
	req.send(null);
 	}
}
</script>
<div align="center">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="padding-top:0; margin-top:0;">
    <tr>
      <td width="256" align="left" valign="top" style=" padding-left:15px; line-height:150%; font-size:14px">
	  <?php include "ProfileMenu.php" ?>
	  </td>
      <td width="768" align="right" valign="top">
	  <form action="EditUserInfo.php" method="post" name="profile">
        <table width="740" height="394" border="0" cellpadding="0" cellspacing="0" align="right">
          <tr>
            <td valign="top" align="right" style="padding-top:15px; padding-bottom:15px">
			<table width="740" height="500" border="0" cellpadding="0" cellspacing="0" style="border:0px solid #999999">
                <tr>
                  <td height="50" colspan="2" align="center" style="padding-right:10; padding-top:5px">&nbsp;</td>
                  <td height="50"><div align="right" style="padding-right:10"><font color="#336633"><?php echo($wid)?>%</font></div></td>
                  <td height="50"><div align="left" style="width:200; padding-top:0; padding-bottom:0; border:1 #336633 solid; background: #EEEEEE">
                    <table height="17" border="0" cellpadding="0" cellspacing="0" >
                      <tr>
                        <td height="17" width="<?php echo(2*$wid)?>" bgcolor="#336699" align="left">&nbsp;</td>
                      </tr>
                    </table>
                  </div></td>
                </tr>
                <tr>
                  <td width="146" height="30" align="right" style="padding-right:15px;  "><strong>User name </strong></td>
                  <td height="30">&nbsp;
                  <input name="uname" type="text" class="box" size="15" style=" background-color:#FFFFFF; border:0; font-weight:bold;" value="<?php echo($uname); ?>" disabled="disabled" /></td>
                  <td height="30" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td height="25" align="right" style="padding-right:15px;  "><strong>Full Name </strong></td>
                  <td height="25">&nbsp;
                      <input name="fname" type="text" class="box" size="12" value="<?php echo($fname); ?>" style="; " />
                    &nbsp;.&nbsp;
                  <input name="lname" type="text" class="box" size="12" value="<?php echo($lname); ?>" style="; " /></td>
                  <td height="25" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td height="15" align="right" style="padding-right:15px;  ">&nbsp;</td>
                  <td height="15" valign="top">&nbsp;
				  <font color="#999999" style="font-size:11px; font-weight:normal">(First Name . Last Name)</font></td>
                  <td height="15" colspan="2">&nbsp;</td>
                </tr>
				<tr>
                  <td height="30" align="right" style="padding-right:10px;  "><strong>Birthdate</strong></td>
                  <td height="30">&nbsp;
                      <select name="birthyear" style="; ">
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
					  <select name="birthmonth" style="; ">
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
					  <select name="birthday" style="; ">
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
                  <td height="30" colspan="2"><?php if(isset($_SESSION['err_rst_msg'])){
				  			echo($_SESSION['err_rst_msg']);
							unset($_SESSION['err_rst_msg']);
				  }?></td>
                </tr>
                <tr>
                  <td height="15" align="right" style="padding-right:15px;  ">&nbsp;</td>
                  <td height="15" valign="top">&nbsp;
				  <font color="#999999" style="font-size:11px">(Birth year will not be shown to others)</font></td>
                  <td height="15" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td height="30" align="right" style="padding-right:10px;  "><strong>Gender </strong></td>
                  <td height="30" colspan="3" style=" ">&nbsp;
                      <input type="radio" name="gender" value="Male" <?php echo $gender_options[0]; ?> />
                    Male&nbsp;&nbsp;
                    <input type="radio" name="gender" value="Female" <?php echo $gender_options[1]; ?> />
                  Female </td>
                </tr>
                <tr>
                  <td height="30" align="right" style="padding-right:10px;  ">
				  <strong>Currently</strong>
				  <div style="display:none">
				  </div> 
				  </td>
                  <td height="30" colspan="3" style=" ;">&nbsp;
                      <input type="radio" name="sstatus" value="Student" <?php echo $sstatus_options[0]; ?> />
                    Full-time Student&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="sstatus" value="Employee" <?php echo $sstatus_options[1]; ?> />
                  Full-time Employe(e/r) </td>
                </tr>
                <tr>
                  <td height="30" align="right" style="padding-right:10px;  "><strong>Maritial Status </strong></td>
                  <td height="30" colspan="3" style=" ">&nbsp;
                      <input type="radio" name="mstatus" value="Single" <?php echo $mstatus_options[0]; ?> />
                    Single&nbsp;&nbsp;
                    <input type="radio" name="mstatus" value="Married" <?php echo $mstatus_options[1]; ?> />
                    Married&nbsp;&nbsp;
                    <input type="radio" name="mstatus" value="In a relationship" <?php echo $mstatus_options[2]; ?> />
                  In a relationship </td>
                </tr>
                <tr>
                  <td height="30" align="right" style="padding-right:10px;  "><strong>  Proudly From </strong></td>
                  <td height="30" colspan="3" style=" ">&nbsp;
           	<select name="fcountry" id="fcountry" onChange="getRegion('findRegion.php?fcountry='+this.value)" style="; ">
			<option value="all" selected="selected">Select Country</option>
				  <?php 
				  	include 'dbconnect.php';
				  	$q = mysql_query("SELECT * FROM rockinus.region_info GROUP BY country_name ASC");
					if(!$q) die(mysql_error());
					while($obj = mysql_fetch_object($q)){
						$country_name = trim($obj->country_name);
						if($country_name == trim($fcountry))
							$selected = " selected"; 
						else 
                      		$selected = NULL;
						echo ("<option value=$country_name $selected>$country_name</option>");
					}				
					?>
                    </select>
					<div id="regionDiv" class="regionDiv" style="display: inline; ">
                    <select name="fregion" id="fregion" class="fregion" style="; ">
					<?php 
						if($fcountry!="empty"&&$fcountry!="all"){
						  	$q = mysql_query("SELECT region_name FROM rockinus.region_info WHERE country_name='$fcountry'");
							if(!$q) die(mysql_error());
							while($obj = mysql_fetch_object($q)){
								$region_name = trim($obj->region_name);
								if($region_name == trim($fregion))
									$selected = " selected"; 
								else 
                      				$selected = NULL;
							
								echo("<option value=$region_name $selected>$region_name</option>");
							}
						}else
						echo("<option value='all' style='; '>Select Region</option>");						
					?>
					  </select>
				  </div>				  </td>
                </tr>
                <tr>
                  <td height="20">&nbsp;</td>
                  <td width="303" height="20" valign="top" style=" padding-left:0">
				  &nbsp; <a href="reportIssue.php" class="one"><font color="#999999" style="font-size:11px">Let us know if your country is not in the list</font></a>				  </td>
                  <td width="66" height="20">&nbsp;</td>
                  <td width="223" height="20">&nbsp;</td>
                </tr>
                <tr>
                  <td height="47">&nbsp;</td>
                  <td align="left" style="padding-left:10">
				  <input name="infoSubmit" type="submit" style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:1px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; " value=" Save " />
				  </td>
                  <td align="right">&nbsp;
                    
				  </td>
                  <td></td>
                </tr>
                <tr>
                  <td height="20" colspan="4">&nbsp;</td>
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
