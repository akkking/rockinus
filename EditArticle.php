<?php 
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
include 'dbconnect.php';

if(isset($_POST['SaveSubmit'])){
	include 'dbconnect.php';

	$aid = addslashes($_POST['aid']);
	$subject = addslashes($_POST['subject']);
	$type = $_POST['type'];
	$aname = $_POST['aname'];
	$rentlease = $_POST['buysale'];
	$state = $_POST['state'];
	$city = $_POST['city'];
	$duration = $_POST['duration'];
	$rate = $_POST['rate']; 
	$delivery = $_POST['delivery'];
	$rstatus = $_POST['rstatus'];
	$email = $_POST['email'];
	$telephone = $_POST['telephone'];
	$description = addslashes($_POST['description']);
	$uname = $_POST['contact'];

	mysql_query('set character_set_connection=gbk, character_set_results=gbk, character_set_client=binary');
	$sql = "UPDATE rockinus.article_info SET subject='$subject',type='$type',aname='$aname',delivery='$delivery',city='$city',state='$state',email='$email',telephone='$telephone',rate='$rate', rstatus='$rstatus', descrip='$description' WHERE aid='$aid'";
	echo($sql);
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	header("location:ArticleDetail.php?aid=$aid");
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

if(isset($_GET['aid'])){
	$aid = $_GET['aid'];
	mysql_query("SET NAMES GBK");
	$qa = mysql_query("SELECT * FROM rockinus.article_info WHERE aid='$aid';");
	if(!$qa) die(mysql_error());
	$no_row_a = mysql_num_rows($qa);
	if($no_row_a == 0) die("No matches met your criteria.");
	$object_a = mysql_fetch_object($qa);
	$subject = nl2br($object_a->subject);
	$subject = str_replace("\\","",$subject);
	$rate = $object_a->rate;	
	$state = $object_a->state;
	$city = $object_a->city;
	$type = $object_a->type;
	$aname = $object_a->aname;
	$contact = $object_a->uname;
	$buysale = $object_a->buysale;
	$quality = $object_a->quality;
	$telephone = $object_a->telephone;
	//$expireday = $object_a->expireday;
	$descrip = $object_a->descrip;
	$descrip = str_replace("\\","",$descrip);
	$delivery = $object_a->delivery;
	$telephone = $object_a->telephone;
	$email = $object_a->email;
	$rstatus = $object_a->rstatus;
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
	  <?php include("leftHomeMarketMenu.php"); ?>
	  </td>
      <td width="760" align="right" valign="top" style=" border:#CCCCCC solid 0" sty>
	  <?php include("HeaderEN.php"); ?>
	  <?php 
	  if(isset($_SESSION['rst_msg'])){
	  	echo $_SESSION['rst_msg'];
	  	unset($_SESSION['rst_msg']); }
	  ?>
	  <form action="EditArticle.php" enctype="multipart/form-data" method="post" onSubmit="return validateForm()" style="margin-top:0; margin-bottom:0;">
	  <table width="613" height="348" border="0" cellpadding="0" cellspacing="0" style="border:0 #CCCCCC solid; margin-bottom:8">
        <tr>
          <td width="613" height="342" valign="top" align="right"><table width="740" height="658" border="0" cellpadding="0" cellspacing="0" style="border:1px #DDDDDD solid">
            <tr>
              <td height="40" bgcolor="#EEEEEE" style="border-top:#DDDDDD solid 1; border-bottom:#DDDDDD solid 1; padding-right:10" align="right"><img src="img/PostPic.jpg" width="30" height="30" /></td>
              <td height="40" colspan="3" bgcolor="#EEEEEE" style="border-top:#DDDDDD solid 1; border-bottom:#DDDDDD solid 1;" align="left"><font size="4" color=""><strong> Flea Market </strong></font>
			  <input type="hidden" value='<?php echo($aid) ?>' name="aid" />			  </td>
            </tr>
            <tr>
              <td height="22">&nbsp;</td>
              <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td height="40" colspan="4" style="padding-left:60; font-size:18px; color:<?php echo($_SESSION['hcolor']) ?>" bgcolor="#F5F5F5">
			  Is this house information still available?&nbsp;&nbsp;&nbsp;
			  <select name="rstatus">
			  <option value="Y" <?php if(trim($rstatus)=="Y")echo("selected"); ?>>Yes, still avaiable</option>
			  <option value="N" <?php if(trim($rstatus)=="N")echo("selected"); ?>>No, it is not available</option>
			  </select>			  </td>
              </tr>
            <tr>
              <td height="22">&nbsp;</td>
              <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td height="35" align="right" style="padding-right:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Subject </strong></td>
              <td colspan="3"><input type="text" name="subject" size="80" value='<?php echo($subject) ?>' class="box" /></td>
            </tr>
            <tr>
              <td width="141" height="30" align="right" style="padding-right:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Category </strong></td>
              <td width="256"><select name="type" id="type" onchange="articleChange(this);">
                  <option value="empty">Select a Type</option>
                  <option value="Electronics" <?php if($type=="Electronics")echo("selected") ?>>Electronics</option>
                  <option value="Books" <?php if($type=="Books")echo("selected") ?>>Books</option>
                  <option value="Furniture" <?php if($type=="Furniture")echo("selected") ?>>Furniture</option>
                  <option value="Costume" <?php if($type=="Costume")echo("selected") ?>>Costume</option>
                  <option value="Transports" <?php if($type=="Transports")echo("selected") ?>>Transports</option>
                  <option value="Cosmetics" <?php if($type=="Cosmetics")echo("selected") ?>>Cosmetics</option>
                  <option value="Instruments" <?php if($type=="Instruments")echo("selected") ?>>Instruments</option>
                  <option value="CardTickets" <?php if($type=="CardTickets")echo("selected") ?>>CardTickets</option>
                </select>
                  <select name="aname" id="aname">
                    <option value="empty">Select Name</option>
                </select></td>
              <td width="101" align="right" style="padding-right:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Condition</strong></td>
              <td width="302" align="left">
                  <select name="quality">
                    <option value="Like New" <?php if($quality=="Like New")echo("selected") ?>>Like New</option>
                    <option value="Very Good" <?php if($quality=="Very Good")echo("selected") ?>>Very Good</option>
                    <option value="Good" <?php if($quality=="Good")echo("selected") ?>>Good</option>
                    <option value="Acceptable" <?php if($quality=="Acceptable")echo("selected") ?>>Acceptable</option>
					<option value="Broken" <?php if($quality=="Broken")echo("selected") ?>>Broken</option>
                  </select>
              </td>
            </tr>
            <tr>
              <td height="30" align="right" style="padding-right:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Location </strong></td>
              <td><select name="state">
                <option value="NY" <?php if($state=="NY")echo("selected") ?>>NewYork</option>
              </select>
                <select name="city">
                  <option value="Brooklyn" <?php if($city=="Brooklyn")echo("selected") ?>>Brooklyn</option>
                  <option value="Manhattan" <?php if($city=="Manhattan")echo("selected") ?>>Manhatton</option>
                  <option value="Queens" <?php if($city=="Queens")echo("selected") ?>>Queens</option>
                  <option value="Bronx" <?php if($city=="Bronx")echo("selected") ?>>Bronx</option>
                  <option value="Long Island" <?php if($city=="Long Island")echo("selected") ?>>Long Island</option>
                </select></td>
              <td align="right" style="padding-right:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>I wanna </strong></td>
              <td>
			  <input type="radio" name="buysale" value="Sale" <?php if($buysale=="Sale")echo("checked='checked'") ?> />
                Sale
                <input type="radio" name="buysale" value="Buy" <?php if($buysale=="Buy")echo("checked='checked'") ?> />
                Buy </td>
            </tr>
            <tr>
              <td height="30" align="right" style="padding-right:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>$ Rate </strong></td>
              <td height="38"><input type="text" name="rate" size="7" class="box" value="<?php echo($rate) ?>" />
                / Piece </td>
              <td height="38" align="right" style="padding-right:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Number </strong></td>
              <td height="38"><input type="text" name="num" size="3" value='1' />
                (Pieces)</td>
            </tr>
            <tr>
              <td height="30" align="right" style="padding-right:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Delivery?</strong></td>
              <td width="256" height="35"><input type="radio" name="delivery" value="Y" <?php if($delivery=="Y")echo("checked='checked'") ?>>
                Yes
                <input type="radio" name="delivery" value="N" <?php if($delivery=="N")echo("checked='checked'") ?> />
                No </td>
              <td align="right" style="padding-right:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Phone</strong></td>
              <td><input type="text" name="telephone" size="15" class="box" value="<?php echo($telephone); ?>"></td>
            </tr>
            <tr>
              <td height="30" align="right" style="padding-right:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Email </strong></td>
              <td height="34"><input type="text" name="email" size="30" class="box" value="<?php echo($email); ?>"></td>
              <td align="right" style="padding-right:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Contact</strong></td>
              <td><input type="text" name="contact" size="15" class="box" value="<?php echo($contact); ?>"></td>
            </tr>
            <tr>
              <td height="30" align="right" style="padding-right:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Photos </strong></td>
              <td height="30" colspan="3"><input name="uploaded1" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #" />
                  <font color="#CCCCCC">Make sure smaller than 500KB</font></td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td height="30" colspan="3"><input name="uploaded2" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #" />
                  <font color="#CCCCCC">Make sure smaller than 500KB</font></td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td height="30" colspan="3"><input name="uploaded3" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #" />
                  <font color="#CCCCCC">Make sure smaller than 500KB</font></td>
            </tr>
            <tr>
              <td height="146" align="right" valign="top" style="padding:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Description</strong></td>
              <td height="146" colspan="3" style=" padding-bottom:15px">
			  <textarea name="description" id="styled" style="width:530; height:200; font-size:14px; font-family:Arial, Helvetica, sans-serif"><?php echo($descrip) ?></textarea></td>
            </tr>
            <tr>
              <td height="30" bgcolor="#F5F5F5" style="border-top:0 #CCCCCC solid">&nbsp;</td>
              <td height="30" colspan="3" bgcolor="#F5F5F5" style=" font-size:14px; font-family:Arial, Helvetica, sans-serif" align="left">
			  We will keep the post for
                <select name="duration">
                    <option value="3">3 Days</option>
                    <option value="7" selected="selected">7 Days</option>
                    <option value="15">15 Days</option>
                    <option value="30">30 Days</option>
                  </select>              </td>
            </tr>
            <tr>
              <td height="80" style="padding-top:15px; padding-bottom:15px" align="center">&nbsp;</td>
              <td height="80" style="padding-top:15px; padding-bottom:15px" align="left">
			  	<input type="submit" name="SaveSubmit" value=" Save " class="btn2" style="font-size:14px; font-family:Arial, Helvetica, sans-serif" />
				</td>
              <td height="80" style="padding-top:15px; padding-bottom:15px" align="center">&nbsp;</td>
              <td height="80" style="padding-top:15px; padding-bottom:15px" align="center">&nbsp;</td>
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
