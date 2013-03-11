<?php 
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
include 'dbconnect.php';

if(isset($_POST['SaveSubmit'])){
	include 'dbconnect.php';

	$hid = addslashes($_POST['hid']);
	$subject = addslashes($_POST['subject']);
	$type = $_POST['type'];
	$rentlease = $_POST['rentlease'];
	$state = $_POST['state'];
	$city = $_POST['city'];
	$duration = $_POST['duration'];
	$rate = $_POST['rate']; 
	$rstatus = $_POST['rstatus'];
	$email = $_POST['email'];
	$telephone = $_POST['telephone'];
	$description = addslashes($_POST['description']);
	$metroline = $_POST['metroline'];
	$metrostop = $_POST['metrostop'];
	$metromins = $_POST['metromins'];    
	$expireday = $_POST['expireday'];

	mysql_query('set character_set_connection=gbk, character_set_results=gbk, character_set_client=binary');
	$sql = "UPDATE rockinus.house_info SET subject='$subject',type='$type',city='$city',state='$state',email='$email',telephone='$telephone',rate='$rate', rstatus='$rstatus',descrip='$description',duration='$duration' WHERE hid='$hid'";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	header("location:HouseDetail.php?hid=$hid");
}

$q = mysql_query("SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_contact_info b ON a.uname='$uname' AND a.uname=b.uname;");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$fname = $object->fname;
if(trim($fname)==NULL)$fname="";
$email = $object->email;
if(trim($email)==NULL)$email="";
$phone = $object->phone;
if(trim($phone)==NULL)$phone="";
$ccity = $object->ccity;
$cstate = $object->cstate;

if(isset($_GET['hid'])){
	$hid = $_GET['hid'];
	mysql_query("SET NAMES GBK");
	$qh = mysql_query("SELECT * FROM rockinus.house_info WHERE hid='$hid';");
	if(!$qh) die(mysql_error());
	$no_row_h = mysql_num_rows($qh);
	if($no_row_h == 0) die("No matches met your criteria.");
	$object_h = mysql_fetch_object($qh);
	$subject = nl2br($object_h->subject);
	$subject = str_replace("\\","",$subject);
	$rate = $object_h->rate;
	$state = $object_h->state;
	$city = $object_h->city;
	$type = $object_h->type;
	$rentlease = $object_h->rentlease;
	$metroline = $object_h->metroline;
	$metrostop = $object_h->metrostop;
	$metromins = $object_h->metromins;
	$type = $object_h->type;
	$expireday = $object_h->expireday;
	$descrip = $object_h->descrip;
	$descrip = str_replace("\\","",$descrip);
	$rstatus = $object_h->rstatus;
}
?>
<style type="text/css">
<!--
.STYLE1 {color: #CCCCCC}
-->
</style>

<div align="center">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" style="margin-top:0px;" bgcolor="#FFFFFF">
    <tr>
      <td width="300" align="left" valign="top" style="border-right: 1px dashed #DDDDDD;">
	  <?php include("leftHomeHouseMenu.php"); ?>
	  </td>
      <td width="760" align="right" valign="top" style=" border:#CCCCCC solid 0" sty>
	  <?php include("HeaderEN.php"); ?>
	  <?php 
	  if(isset($_SESSION['rst_msg'])){
	  	echo $_SESSION['rst_msg'];
	  	unset($_SESSION['rst_msg']); }
	  ?>
	  <form action="EditHouse.php" enctype="multipart/form-data" method="post" onSubmit="return validateForm()" style="margin-top:0; margin-bottom:0;">
	  <table width="740" height="348" border="0" cellpadding="0" cellspacing="0" style="border:0 #CCCCCC solid; margin-bottom:8">
        <tr>
          <td width="740" height="342" valign="top" align="right">
		  <table width="740" height="678" border="0" cellpadding="0" cellspacing="0" style="border:1px #DDDDDD solid">  
            <tr>
              <td height="35" align="right" background="img/master.png" style="padding-right:10px">
			  <img src="img/PostPic.jpg" width="30" height="30" />			  </td>
              <td height="35" colspan="3" align="left" background="img/master.png">
			  <strong><font size="4" color="">House Information</font> </strong></td>
              </tr>
            <tr>
              <td height="16" colspan="4" style="border-top:1px solid #DDDDDD">&nbsp;</td>
              </tr>
            <tr>
              <td height="40" colspan="4" align="left" style=" font-family:Arial, Helvetica, sans-serif; padding-left:60; font-size:18px; color:<?php echo($_SESSION['hcolor']) ?>" bgcolor="#F5F5F5">
			  Is this house information still available?&nbsp;&nbsp;&nbsp;
			  <select name="rstatus" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
			  <option value="Y" <?php if(trim($rstatus)=="Y")echo("selected"); ?>>Yes, still avaiable</option>
			  <option value="N" <?php if(trim($rstatus)=="N")echo("selected"); ?>>No, mark as expired</option>
			  </select>
			  </td>
              </tr>
            <tr>
              <td height="10" colspan="4" align="left" style="padding-left:15" bgcolor="">&nbsp;</td>
            </tr>
            <tr>
              <td height="40" align="right" style="padding-right:10; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Subject </strong></td>
              <td colspan="3">
			  <input type="text" name="subject" size="70" class="box" value='<?php echo($subject) ?>' style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
			  <input type="hidden" name="hid" value='<?php echo($hid) ?>'>			  </td>
              </tr>
            <tr>
              <td width="129" height="40" align="right" style="padding-right:10; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Category</strong></td>
              <td width="156">
			      <select name="type" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
                  <option value="Single Room" <?php if($type=="Single Room")echo("selected") ?>>Single Room</option>
                  <option value="Shared Room" <?php if($type=="Shared Room")echo("selected") ?>>Shared Room</option>
                  <option value="Apartment" <?php if($type=="Apartment")echo("selected") ?>>Apartment</option>
				  <option value="Studio" <?php if($type=="Studio")echo("selected") ?>>Studio</option>
				  <option value="House" <?php if($type=="House")echo("selected") ?>>House</option>
				  <option value="Others" <?php if($type=="Others")echo("selected") ?>>Others</option>
                </select>				</td>
              <td align="right" style="padding-right:10; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Location </strong></td>
              <td><select name="state" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
                <option value="NY" <?php if($state=="NY")echo("selected") ?>>NewYork</option>
              </select>
                <select name="city" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
                  <option value="Brooklyn" <?php if($city=="Brooklyn")echo("selected") ?>>Brooklyn</option>
                  <option value="Manhattan" <?php if($city=="Manhattan")echo("selected") ?>>Manhatton</option>
                  <option value="Queens" <?php if($city=="Queens")echo("selected") ?>>Queens</option>
                  <option value="Bronx" <?php if($city=="Bronx")echo("selected") ?>>Bronx</option>
                  <option value="Long Island" <?php if($city=="Long Island")echo("selected") ?>>Long Island</option>
                </select></td>
            </tr>

            <tr>
              <td height="40" align="right" style="padding-right:10; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>I wanna </strong></td>
              <td height="45" style=" font-size:14px; font-family:Arial, Helvetica, sans-serif">
			  <input type="radio" name="rentlease" value="Lease" <?php if($rentlease=="Lease")echo("checked='checked'") ?>>Lease
			  <input type="radio" name="rentlease" value="Rent" <?php if($rentlease=="Rent")echo("checked='checked'") ?>>Rent 
			  </td>
              <td height="45" align="right" style="padding-right:10; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>$ Rate </strong></td>
              <td height="45" style=" font-size:14px; font-family:Arial, Helvetica, sans-serif">
			  <input type="text" name="rate" size="5" class="box" value=<?php echo($rate) ?> style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
/ Month</td>
            </tr>
            <tr>
              <td height="40" align="right" style="padding-right:10; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>How long? </strong></td>
              <td><select name="duration" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
                <option value="0" selected="selected">No Matter</option>
                <option value="7">1 Week</option>
                <option value="30">1 Month</option>
                <option value="91">3 Month</option>
                <option value="182">6 Month</option>
                <option value="365">1 Year</option>
              </select></td>
              <td width="105" align="right" style="padding-right:10; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Metro</strong></td>
              <td width="348">
			  <select name="metroline">
                <option value="<?php echo($metroline) ?>"><?php echo($metroline) ?></option>
              </select>
			  <select name="metrostop">
                <option value="<?php echo($metrostop) ?>"><?php echo($metrostop) ?></option>
              </select>
			  <select name="metromins">
                <option value="<?php echo($metromins) ?>"><?php echo($metromins) ?></option>
              </select>	Mins		  
			  </td>
            </tr>
            <tr>
              <td height="40" align="right" style="padding-right:10; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Phone </strong></td>
              <td height="47"><input type="text" name="telephone" size="15" class="box" value="<?php echo($telephone); ?>" style="font-size:14px; font-family:Arial, Helvetica, sans-serif" /></td>
              <td align="right" style="padding-right:10; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Email</strong></td>
              <td><input type="text" name="email" size="25" class="box" value="<?php echo($email); ?>" style="font-size:14px; font-family:Arial, Helvetica, sans-serif" /></td>
            </tr>
            <tr>
              <td height="30" align="right" style="padding-right:10; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Photos </strong></td>
              <td height="30" colspan="3" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
			  <input name="uploaded1" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #" /> 
                <font color="#CCCCCC">Make sure smaller than 500KB</font> </td>
              </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td height="30" colspan="3" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
			  <input name="uploaded2" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #" />
                <font color="#CCCCCC">Make sure smaller than 500KB</font></td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td height="30" colspan="3" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
			  <input name="uploaded3" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #" />
                <font color="#CCCCCC">Make sure smaller than 500KB</font></td>
            </tr>
            <tr>
              <td height="105" align="right" valign="top" style="padding:10; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Description</strong></td>
              <td height="105" colspan="3" valign="top" style="padding-top:10;">
			  <textarea name="description" id="styled" style="height:250; width:530; font-size:14px; font-family:Arial, Helvetica, sans-serif"><?php echo($descrip) ?></textarea>
			  </td>
            </tr>
            <tr>
              <td height="25">&nbsp;</td>
              <td height="25" colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td height="30" bgcolor="#F5F5F5" style="border-top:0 #CCCCCC solid">&nbsp;</td>
              <td height="30" colspan="3" bgcolor="#F5F5F5" style=" font-size:14px; font-family:Arial, Helvetica, sans-serif" align="left">
			  * Keep this post for 
                  <select name="expireday" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
                    <option value="3" <?php if($expireday=="3")echo("selected") ?>>3 Days</option>
                    <option value="7" <?php if($expireday=="7")echo("selected") ?>>7 Days</option>
                    <option value="15" <?php if($expireday=="15")echo("selected") ?>>15 Days</option>
                    <option value="30" <?php if($expireday=="30")echo("selected") ?>>30 Days</option>
                  </select>
               </td>
            </tr>
            <tr>
              <td height="80" colspan="4" align="center" valign="middle">
                <input type="submit" name="SaveSubmit" value=" Save " class="btn2" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">              </td>
              </tr>
          </table></td>
        </tr>
      </table>
	  </form>
	  </td>
    </tr>
  </table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
