<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];

if(isset($_POST['housecomment'])){
	$replycontent = $_POST['replycontent'];
	$postsender = trim($_POST['sender']);
	$postrecipient = trim($_POST['recipient']);
	$hid = $_POST['hid'];
	$rstatus = "N";
	if($postrecipient==NULL || strlen($postrecipient)==0) {
		$postrecipient = $postsender;
		$rstatus = "Y";
	}
	$sql = "INSERT INTO rockinus.house_comment (hid,sender,recipient,descrip,rstatus,pdate,ptime) VALUES('$hid','$postsender','$postrecipient','$replycontent','$rstatus', CURDATE(), NOW())";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
}
?><style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
<div align='center' width='100%'>
  <table width="1024" height="836" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="300" height="836" align="left" valign="top" style="border-right: 0px solid #EEEEEE; padding-left:10px;">
	    <?php include("leftHomeMenu.php"); ?>      </td>
      <td width="760" align="left" valign="top" style='border-left:1px dashed #DDDDDD'><div align="right" style="border:0px solid #DDDDDD">
          <?php include("HeaderEN.php"); ?>
		  <table width="740
		  " border="0" cellspacing="0" cellpadding="0" style="padding-top:2">
  <tr>
    <td width="570" align="right"><div align="center">
      <?php
if(isset($_GET['hid']))
	$hid = $_GET['hid'];
else if(isset($_POST['hid']))
	$hid = $_POST['hid'];
else $hid = 1;

mysql_query("SET NAMES GBK");
$q = mysql_query("SELECT * FROM rockinus.house_info where hid='$hid'");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$subject = $object->subject;
$subject = str_replace("\\","",nl2br($subject));
$type = $object->type;
$city = $object->city;
$state = $object->state;
$email = $object->email;
$rate = $object->rate;
$telephone = $object->telephone;
$description = $object->descrip;
$description = str_replace("\\","",nl2br($description));
$duration = $object->duration; 
$expireday = $object->expireday; 
if($duration==30)$duration="1 Month";
else if($duration==7)$duration="1 Week";
else if($duration==91)$duration="3 Months";
else if($duration==182)$duration="6 Months";
else $duration="1 Year";
$metroline = $object->metroline;
$metrostop = $object->metrostop;
$metromins = $object->metromins;
$rstatus = $object->rstatus;
$extra_fee = $object->extra_fee;
$postuname = $object->uname;
$pdate = $object->pdate;
$ptime = $object->ptime;

if( strlen(trim($extra_fee))==0 || $extra_fee==NULL )
	$extra_fee = "None";
	
if($metrostop=="empty")$metrostop="";
if($metromins==0)$metromins="";
if($metroline=='X')$metroline="Unknown"; else $metroline.=" train, ".$metrostop.", within ".$metromins." minutes walking distance.";

if($uname==$postuname){
	$t2 = mysql_query("SELECT * FROM rockinus.house_comment WHERE rstatus='N' AND hid=$hid");
	if(!$t2) die(mysql_error());
	$no_row_hist = mysql_num_rows($t2);
	
	if($no_row_hist>0){	
		$upd = mysql_query("UPDATE rockinus.house_comment SET rstatus='Y' WHERE hid='$hid' AND rstatus='N'");
		if(!$upd) die(mysql_error());
	}
}

?>
    </div></td>
    <td width="130"><div align="right"></div></td>
  </tr>
</table>
<table width="740" height="35" border="0" cellpadding="0" cellspacing="0" background="img/master.png" style="border-top:0solid #DDDDDD;border-bottom:1px solid #DDDDDD">
  <tr>
    <td height="35" colspan="3" style="border-top:0 solid #999999; line-height:150%" align="center">
	<strong><font size="4"  color="<?php echo($_SESSION['hcolor']) ?>"><?php echo($subject) ?></font></strong>	</td>
    <td width="107" height="35" align="right" style="line-height:150%; padding-right:2">
	<div align="center" style="border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: #CC3300; padding-bottom:3; padding-top:3; margin:3; width:80; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><a href="PostRental.php"><strong>+ New </strong></a></div></td>
  </tr>
  </table>
  <table width="740" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border:1px #DDDDDD solid; margin-bottom:20px; font-size:16px">
  
  <tr>
    <td width="123" height="30">&nbsp;</td>
    <td width="169" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">&nbsp;</td>
    <td width="139">&nbsp;</td>
    <td colspan="2" align="right" style="padding-right:10px; color:#999999">Posted : <?php echo($pdate) ?> | <?php echo($ptime) ?></td>
  </tr>
  <tr>
    <td width="123" height="33" align="right" style="padding-right:15px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>Category</strong></td>
    <td style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"> <?php echo($type) ?></td>
    <td align="right" style="padding-right:15px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>Available?</strong></td>
    <td width="148" align="left">
	<strong>
	<?php 
	if(trim($rstatus)=='Y'){
		echo("<font color=#336633 size=3>Yes</font>");
	}else 
		echo("<font color=#B92828 size=3>No</font>") ?>
	</strong>	</td>
    <td width="159" align="right" style="padding-right:10px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><?php 
	if(trim($postuname)==trim($uname)) echo("<div align=center style='border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: $_SESSION[hcolor]; padding-bottom:3; padding-top:3; padding-left:10px; padding-right:10px; height:20px; display:inline'><a href=EditHouse.php?hid=$hid><strong>+ Edit</strong></a></div>"); ?></td>
  </tr>
  <tr>
    <td width="123" height="34" align="right" style="padding-right:15px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
	<strong>Cost</strong>	</td>
    <td style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">$<?php echo($rate) ?>/Month</td>
    <td align="right" style="padding-right:15px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>Contact</strong></td>
    <td style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
	<a href="RockerDetail.php?uid=<?php echo($postuname) ?>" class="one"><?php echo($postuname) ?></a>	</td>
    <td style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:10px" align="right">
	<div style="background: <?php echo($_SESSION['hcolor']) ?>; display:inline; height:20px; padding-left:8px; padding-right:8px; padding-bottom:4px; padding-top:4px; border-right:#000000 solid 1; border-bottom:#000000 solid 1; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold " align="center">
        <?php if($_SESSION['lan']=='CN')
				  echo("<a href=SendMessage.php?recipient=$postuname>Ð´ÐÅÁªÏµ</a>");
				  else if($_SESSION['lan']=='EN')
				  echo("<a href=SendMessage.php?recipient=$postuname>Message</a>")
				  ?>
      </div>    
	  </td>
  </tr>
  <tr>
    <td width="123" height="37" align="right" style="padding-right:15px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>Duration</strong></td>
    <td style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><?php echo($duration) ?></td>
    <td align="right" style="padding-right:15px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>Email</strong></td>
    <td colspan="2" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"> 
	<?php 
	if(strlen(trim($email))>0 && $email!=NULL)
		echo($email);
	else
		 echo("None");
	?>	</td>
  </tr>
  <tr>
    <td width="123" height="37" align="right" style="padding-right:15px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold">Include</td>
    <td style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif"> <?php echo($extra_fee) ?></td>
    <td align="right" style="padding-right:15px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>Phone</strong></td>
    <td colspan="2" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><?php echo($telephone) ?></td>
  </tr>
  <tr style="border-bottom:dotted 1 #CCCCCC; border:1">
    <td width="123" height="35" align="right" style="padding-right:15px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold">
	<strong>Location</strong>	</td>
    <td style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
	<?php echo($city) ?>&nbsp;,&nbsp;<?php echo($state) ?>    </td>
    <td align="right" style="padding-right:15px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">&nbsp;</td>
    <td colspan="2" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">&nbsp;</td>
  </tr>
  <tr style="border-bottom:dotted 1 #CCCCCC; border:1">
    <td height="35" align="right" style="padding-right:15px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold"><strong>Close to</strong></td>
    <td colspan="4" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><?php echo($metroline) ?></td>
    </tr>
  <tr>
    <td width="123" height="116" style=" font-weight:bold; padding-top:20px; padding-right:15; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif" valign="top" align="right">&nbsp;</td>
    <td colspan="4" valign="top" align="left" style="border-bottom:1 #EEEEEE dotted; padding-left:0; padding-right:10; padding-bottom:10; line-height:150%; font-size:15px; padding-top:20px; width: 615px; border: dotted #999999 0; margin-left:5px">
        <?php 
echo(nl2br($description)) ?>      </td>
    </tr>
  <tr>
    <td width="123" height="10" style="border-top:#EEEEEE dotted 1">&nbsp;</td>
    <td height="10"colspan="4" align="left" valign="top" style="border-top:#EEEEEE dotted 1; padding-top:15px">
      <?php 
					$target = "upload/h".$hid;
					if(is_dir($target)){
						if(file_exists($target."/1_600.jpg")) echo("<img src=upload/h$hid/1_600.jpg style=border:0><br><br>");
				  		if(file_exists($target."/2_600.jpg")) echo("<img src=upload/h$hid/2_600.jpg style=border:0><br><br>");
						if(file_exists($target."/3_600.jpg")) echo("<img src=upload/h$hid/3_600.jpg style=border:0>");
					}
	?>    </td>
  </tr>
  <tr>
    <td width="123" height="14" style="border-top:#EEEEEE dotted 0">&nbsp;</td>
    <td style="border-top:#EEEEEE dotted 0"colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="123" height="40" style="border-top:#CCCCCC dotted 0">&nbsp;</td>
    <td height="40" colspan="4" align="left" style="padding-left:10px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
      <font color="#999999">The availability of this post is for <?php echo($expireday) ?> days.</font>	  </td>
  </tr>
  <tr>
    <td width="123" height="52" style="border-top:#CCCCCC dotted 0">&nbsp;</td>
    <td colspan="4" align="left">
	<table border="0" cellpadding="0" cellspacing="0" style="margin-top:10px">
      <tr>
        <td width="600" height="41" colspan="3"><?php
$q1 = mysql_query("SELECT * FROM rockinus.house_comment WHERE hid='$hid' ORDER BY pdate DESC, ptime DESC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("");}
if($no_row > 0){ 
while($object = mysql_fetch_object($q1)){
	$cid = $object->cid;
	$hid = $object->hid;
	$sender = $object->sender;
	$recipient = $object->recipient;
	$descrip = $object->descrip;
	$ptime = $object->ptime;
	$pdate = $object->pdate; 
?>
            <div style="padding-left:0; padding-right:0; line-height:180%; padding-top:0; padding-bottom:0; margin-bottom:10; width: 600px; background-color: ; border-top:1 #EEEEEE solid">
              <table width="600" height="63" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="246" height="25" align="left" background="img/master.png" style=" color:<?php echo($_SESSION['hcolor'])?>; padding-left:5px">
<script language="javascript">
$(document).ready(function() { 
	$('.<?php echo($cid) ?>').click(function(){ 
  		var txt = $(this).text();
		var uid = "<?php echo($uname) ?>";
		txt = $.trim(txt);
		uid = $.trim(uid);
		if(uid!=txt){ 
			$("#show_recipient_name").text("@"+txt);
			$("#recipient").val(txt);
		} 
	}); 
}); 
</script>
				  <strong>
				  <a class="<?php echo($cid) ?>">
				  <font color="#000000">
				  <?php echo($sender) ?>				  </font>				  </a>
				  <?php
				  if($sender!=$recipient)
				  	echo("@ $recipient");
				?>
				  </strong>				  </td>
                  <td height="25" align="right" background="img/master.png" style="padding-right:5px"><?php echo($pdate) ?> | <?php echo($ptime) ?></td>
                  </tr>
                <tr>
                  <td height="22" colspan="2" style="padding-bottom:10; padding-top:10; padding-left:5px"><font size="3">
                    <?php
									$len = strlen($descrip);
									$single_line_len = 95;
									$line_no = $len/$single_line_len; 
							
									for($i=0;$i<$line_no;$i++) {
										$str = substr($descrip,$i*$single_line_len, ($i+1)*$single_line_len)."<br>";
										echo $str;
									}?>
                  </font> </td>
                </tr>
              </table>
            </div>
          <?php }}?></td>
      </tr>
    </table>
      <form action="HouseDetail.php" method="post" style="margin-top:10px; margin-bottom:20px">
        <table width="570" border="0" cellpadding="0" cellspacing="0" style="border:#DDDDDD solid 1">
          <tr>
            <td width="66" height="35" align="left" background="img/master.png" style="padding-left:10px"><strong>COMMENT</strong></td>
            <td width="214" height="35" background="img/master.png">
				<input type="hidden" name="hid" value="<?php echo($hid) ?>" />
                <input type="hidden" name="sender" value="<?php echo($uname) ?>" />
                <div id="show_recipient_name"></div>				</td>
            <td width="245" background="img/master.png">
			<input type="hidden" name="recipient" id="recipient" value=<?php echo($postuname) ?>>			</td>
            <td width="65" height="35" align="right" valign="middle" background="img/master.png" style="padding-right:5">
			<input type="submit" name="housecomment" value="Submit" class="btn2" />            </td>
          </tr>
          <tr>
            <td height="86" colspan="4" align="left" bgcolor="#EEEEEE" style="padding:10; border-top:1px solid #DDDDDD">
			<textarea name="replycontent" rows="4" style="width:570" id="styled"></textarea>            </td>
          </tr>
        </table>
      </form></td>
  </tr>
</table> 
      </div></td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
