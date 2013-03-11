<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];

if(isset($_POST['roomMate'])){
	$tag = 0;
	$rmate_id = $_POST['rmate_id'];
	$rstatus = $_POST['rstatus'];
	$has_room = $_POST['has_room'];
	$location = $_POST['location'];
	$mate_type = $_POST['mate_type'];
	$rate = trim($_POST['rate']);
	$descrip = addslashes($_POST['descrip']);
	$_SESSION['descrip'] = addslashes($_POST['descrip']);
	$extra_fee = addslashes($_POST['extra_fee']);
	
	if( ( $rate==NULL || $rate=="" ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "You haven't entered any description info";
	}
	
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
		$sql = "UPDATE rockinus.room_mate_info SET has_room='$has_room',mate_type='$mate_type',uname='$uname',rate='$rate',descrip='$descrip',location='$location',extra_fee='$extra_fee', rstatus='$rstatus',pdate=CURDATE(),ptime=NOW() WHERE rmate_id='$rmate_id';";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$rst_msg = "Your info has been updated successfully!";
		mysql_close($link);
		$_SESSION['rst_msg']="<div align='center' style='width=700; background:#F5F5F5; border:0 #DDDDDD solid; padding-top:10; padding-bottom:10; margin-top:0; margin-bottom:0'><strong><font size=3><img src=img/addsuccessIcon_F5.jpg width=15>&nbsp;&nbsp;&nbsp; $rst_msg</font></strong><br><br><font size=3><a href=roomMateList.php class=one>Go Back</a></font></div>"; 
		header("location:roomMateResult.php");
	}else
	$_SESSION['err_rst_msg']="<table width=760><tr><td align='right'><div align='left' style='width=740; background:#F5F5F5; border:0 #DDDDDD solid; padding-top:10; padding-bottom:10; margin-top:0; margin-bottom:10'><strong><font size=3 color=#B92828>&nbsp;&nbsp;<img src=img/stop.jpg width=15>&nbsp;&nbsp;&nbsp;$rst_msg</font></strong></div></td></tr></table>"; 
}else if(isset($_GET["rmate_id"])){
	$rmate_id = $_GET['rmate_id'];
	mysql_query("SET NAMES GBK");
	$q_roommmate = mysql_query("SELECT * FROM rockinus.room_mate_info WHERE rmate_id='$rmate_id';");
	if(!$q_roommmate) die(mysql_error());
	$no_row_roommmate = mysql_num_rows($q_roommmate);
	if($no_row_roommmate == 0) die("No matches met your criteria.");
	$object_roommate = mysql_fetch_object($q_roommmate);
	$has_room = $object_roommate->has_room;	
	$mate_type = $object_roommate->mate_type;
	$location = $object_roommate->location;
	$rate = $object_roommate->rate;
	$expireday = $object_roommate->expireday;
	$extra_fee  = $object_roommate->extra_fee;
	$rstatus = $object_roommate->rstatus;
	$descrip = $object_roommate->descrip;
	$descrip = str_replace("\\","",$descrip);
}

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
		  <table width="740" height="64" border="0" cellpadding="0" cellspacing="0" style="border:1 #DDDDDD solid">
            <tr>
              <td width="330" height="60" align="left" background="img/GrayGradbgDown.jpg" style="padding-left:15; border-bottom:0 solid #CCCCCC; font-size:16px; font-weight:bold">&nbsp;</td>
              <td width="410" height="60" align="right" background="img/GrayGradbgDown.jpg" style="padding-right:20; font-size:16px; font-weight:normal; border-bottom:0 solid #CCCCCC">
			  <a href="roomMateList.php" class="one" style=" color:<?php echo($_SESSION['hcolor']) ?>">Check whom else looking for roommates</a>			  </td>
            </tr>
            <tr>
              <td height="30" colspan="2" align="center">
			  <form action="EditRoomMate.php" method="post">
                <table width="740" height="462" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid; border-top:0px">
                  <tr>
                    <td width="254" height="22" style="padding-left:10px" align="right">&nbsp;</td>
                    <td height="22" colspan="2" style="padding-left:10px">&nbsp;</td>
                  </tr>
				  <tr>
				    <td height="40" style="padding-right:10px; font-size:14px;" align="right">Still looking for roommate?</td>
				    <td height="40" style="padding-left:10px">
					<select name="rstatus">
                        <option <?php if($rstatus=="Y")echo("selected=selected") ?> value="Y" >Yes</option>
                        <option <?php if($rstatus=="N")echo("selected=selected") ?> value="N">No</option>
                      </select>					  </td>
				    <td style="padding-left:10px; font-size:14px">                  
				    <tr>
                    <td height="40" style="padding-right:10px; font-size:14px;" align="right">
					Do you have Apt. or Room?					</td>
                    <td width="225" height="40" style="padding-left:10px">
					<select name="has_room">
                        <option <?php if($has_room=="Y")echo("selected=selected") ?> value="Y" >Yes</option>
                        <option <?php if($has_room=="N")echo("selected=selected") ?> value="N">No</option>
                      </select>					  </td>
                    <td width="261" style="padding-left:10px; font-size:14px">
				  <tr>
				    <td height="40" style="padding-right:10px; font-size:14px;" align="right">
					Expected Apt. Location					</td>
				    <td height="40" style="padding-left:10px">
					<select name="location">
                        <option <?php if($location=="all")echo("selected=selected") ?> value="all" selected="selected">Anywhere in NYC</option>
						<option <?php if($location=="Brookyln")echo("selected=selected") ?> value="Brookyln">Brookyln</option>
						<option <?php if($location=="Queens")echo("selected=selected") ?> value="Queens">Queens</option>
						<option <?php if($location=="Manhattan")echo("selected=selected") ?> value="Manhattan">Manhattan</option>
						<option <?php if($location=="Bronx")echo("selected=selected") ?> value="Bronx">Bronx</option>
                      	<option <?php if($location=="JersyCity")echo("selected=selected") ?> value="JersyCity">Jersy City</option>
                        <option <?php if($location=="LongIsland")echo("selected=selected") ?> value="LongIsland">Long Island</option>
                        </select>					</td>
				    <td style="padding-left:10px; font-size:14px">&nbsp;</td>
				    </tr>
                  <tr>
                    <td height="40" style="padding-right:10px; font-size:14px; font-weight:" align="right">Prefer the roommate from </strong></td>
                    <td height="40" colspan="2" style="padding-left:10px">
					<select name="mate_type">
					<option value="all" <?php if($mate_type=="all")echo("selected=selected") ?>>I don't care</option>
					<option value="India" <?php if($mate_type=="India")echo("selected=selected") ?>>India</option>
					<option value="China" <?php if($mate_type=="China")echo("selected=selected") ?>>China</option>
					<option value="Mexico" <?php if($mate_type=="Mexico")echo("selected=selected") ?>>Mexico</option>
					<option value="UAE" <?php if($mate_type=="UAE")echo("selected=selected") ?>>Middle East</option>
					<option value="Turkey" <?php if($mate_type=="Turkey")echo("selected=selected") ?>>Turkey</option>
					<option value="Korea" <?php if($mate_type=="Korea")echo("selected=selected") ?>>Korea</option>
					<option value="Taiwan" <?php if($mate_type=="Taiwan")echo("selected=selected") ?>>Taiwan</option>
					<option value="Japan" <?php if($mate_type=="Japan")echo("selected=selected") ?>>Japan</option>
					<option value="Russia" <?php if($mate_type=="Russia")echo("selected=selected") ?>>Russia</option>
					<option value="Bangladesh" <?php if($mate_type=="Bangladesh")echo("selected=selected") ?>>Bangladesh</option>
					<option value="USA" <?php if($mate_type=="USA")echo("selected=selected") ?>>USA</option>
					<option value="Italy" <?php if($mate_type=="Italy")echo("selected=selected") ?>>Italy</option>
					<option value="Others" <?php if($mate_type=="all")echo("selected=selected") ?>>Other nations</option>
					</select>					</td>
                  </tr>
                  <tr>
                    <td height="40" style="padding-right:10px; font-size:14px; font-weight:" align="right">Expected Monthly Rate </strong></td>
                    <td height="40" colspan="2" style="padding-left:10px">
                        $ <input type="text" name="rate" value="<?php echo($rate) ?>" size="5" />
						<select name="extra_fee">
					<option value="I" <?php if($extra_fee=="P")echo("selected=selected") ?>>(Includes partial additional fees)</option>
					<option value="A" <?php if($extra_fee=="A")echo("selected=selected") ?>>(Includes all additional fees)</option>
					<option value="N" <?php if($extra_fee=="N")echo("selected=selected") ?>>(Not includes any additional fees)</option>
					</select>						</td>
                  </tr>
                  <tr>
                    <td height="170" style="padding-right:10px; padding-top:10; font-size:14px;" valign="top" align="right">
					Short Description<br /><br />
					<font style="font-size:12px; color:#666666">(Longer than 20 letters)</font>					</td>
                    <td colspan="2" valign="top" style="padding-left:10px; padding-top:10px">
                      <textarea name="descrip" rows="10" style="width:420; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><?php if(isset($_SESSION['descrip'])){echo($_SESSION['descrip']);unset($_SESSION['descrip']);}else echo($descrip); ?></textarea>					  </td>
                  </tr>
                  <tr>
                    <td height="70" style="padding-right:10px" align="right">&nbsp;</td>
                    <td height="80" colspan="2" valign="top" style="padding-left:10px; padding-top:10px;">
					<input name="rmate_id" value="<?php echo($rmate_id) ?>" type="hidden" />
					<input name="roomMate" type="submit" class="profile_btn" value=" Save " style="font-size:14px;"/>					</td>
                  </tr>
                </table>
              </form>			  </td>
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
