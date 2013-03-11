<?php 
include 'mainHeader.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];
?>
<style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
<div align='center' width='100%'>
  <table width="1024" height="836" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td height="836" align="left" valign="top" style="padding:15px;"><div align="left" style="border:0px solid #DDDDDD">
		  <table width="1000
		  " border="0" cellspacing="0" cellpadding="0" style="padding-top:2">
  <tr>
    <td width="570" align="right"><div align="center">
      <?php
if(isset($_GET['hid']))
	$hid = $_GET['hid'];
else if(isset($_POST['hid']))
	$hid = $_POST['hid'];
else $hid = 1;

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
	
if($metroline=='X'){
	$metroline="Not mentioned close to which train stop";
	$metrostop="";
	$metromins="";
}else{
	$metroline.= " train";
	if($metrostop=="empty"){
		$metrostop="";
		$metromins="";
	}else{
		$metrostop=", ".$metrostop;
		if($metromins==0)$metromins="";else $metromins=", within ".$metromins." minutes walking distance.";
	}
}
$metroline.=$metrostop.$metromins;

if($uname==$postuname){
	$t2 = mysql_query("SELECT * FROM rockinus.house_comment WHERE rstatus='N' AND hid=$hid");
	if(!$t2) die(mysql_error());
	$no_row_hist = mysql_num_rows($t2);
	
	if($no_row_hist>0){	
		$upd = mysql_query("UPDATE rockinus.house_comment SET rstatus='Y' WHERE hid='$hid' AND rstatus='N'");
		if(!$upd) die(mysql_error());
	}
}

$unameImg = "upload/$uname/$uname"."60.jpg";
if(file_exists($unameImg))
	$unameImg = "<div style='height:50;overflow-x:hidden;overflow-y:hidden;' align='left'><img src='$unameImg' width='40' style='border:0px solid #DDDDDD'></div>"; 
	else
	$unameImg = "<img src='img/NoUserIcon100.jpg' width=50 style='border:0px solid #DDDDDD'>";
?>
    </div></td>
    <td width="130">	</td>
  </tr>
</table>
<table width="1000" height="50" border="0" cellpadding="0" cellspacing="0" style="border-top:0px solid #DDDDDD;border-bottom:0px solid #999999; background:#F5F5F5">
  <tr>
    <td height="30" 
	style="font-weight:bold; font-size:18px; font-family:Arial, Helvetica, sans-serif; line-height:120%; color: <?php echo($_SESSION['hcolor']) ?>" align="center">
	<?php echo($subject) ?>	</td>
    </tr>
  </table>
  <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="" style="border:0px #DDDDDD solid; margin-bottom:20px;">
  
  <tr>
    <td height="50" style="padding-right:15px; font-size:11px; color:#CCCCCC" align="right"> Timestamp: </td>
    <td height="50" style="padding-left:0px; font-size:11px; color:#CCCCCC"><?php echo(getDateName($pdate)) ?> | <?php echo(substr($ptime,0,5)) ?></td>
    <td height="50" style="padding-left:50px; font-size:12px; color:#CCCCCC"></td>
    <td height="50" colspan="2" align="right" style="line-height:150%; padding-right:20px; font-size:14px; font-weight:bold; font-family:Arial, Helvetica, sans-serif"><a href="PostRental.php" class="one">+ Publish </a></td>
  </tr>
  <tr>
    <td width="123" height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Category</td>
    <td width="200" height="25" style="font-size:14px; font-family:Arial, Helvetica, sans-serif"> <?php echo($type) ?></td>
    <td width="108" height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Available?</td>
    <td width="148" height="25" align="left" style=" font-size:14px; font-family:Arial, Helvetica, sans-serif">
	
	<?php 
	if(trim($rstatus)=='Y'){
		echo("<font color=#336633>Yes</font>");
	}else 
		echo("<font color=#B92828>No</font>") ?>		</td>
    <td width="159" height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><?php 
	if(trim($postuname)==trim($uname)) echo("<a href=EditHouse.php?hid=$hid><div align=center style='height:15; padding:2 5 2 5; background: url(img/master.jpg); display:; margin-top:5; margin-bottom:0; width:50; color:#000000; border:1px solid #999999; font-size:11px; cursor:pointer'>+ Edit</div></a>"); ?></td>
  </tr>
  <tr>
    <td width="123" height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">
	Cost	</td>
    <td height="25" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">$<?php echo($rate) ?>/Month</td>
    <td height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Contact</td>
    <td height="25" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
	<a href="RockerDetail.php?uid=<?php echo($postuname) ?>" class="one"><?php echo($postuname) ?></a>	</td>
    <td height="25" align="right" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; padding-right:15">
        <?php   echo("<a href=SendMessage.php?recipient=$postuname><div style='height:15; padding:2 5 2 5; background: url(img/master.jpg); display:; margin-top:5; margin-bottom:0; width:50; color:#000000; border:1px solid #999999;  font-size:11px; cursor:pointer' align='center'>Message</div></a>");
				  ?>	  </td>
  </tr>
  <tr>
    <td width="123" height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Duration</td>
    <td height="25" style="font-size:14px; font-family:Arial, Helvetica, sans-serif"><?php echo($duration) ?></td>
    <td height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Email</td>
    <td height="25" colspan="2" style="font-size:14px; font-family:Arial, Helvetica, sans-serif"> 
	<?php 
	if(strlen(trim($email))>0 && $email!=NULL)
		echo($email);
	else
		 echo("None");
	?>	</td>
  </tr>
  <tr>
    <td width="123" height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:">Include</td>
    <td height="25" style="font-size:12px; font-family:Arial, Helvetica, sans-serif"> <?php echo($extra_fee) ?></td>
    <td height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Phone</td>
    <td height="25" colspan="2" style="font-size:14px; font-family:Arial, Helvetica, sans-serif"><?php echo($telephone) ?></td>
  </tr>
  <tr style="border-bottom:dotted 1 #CCCCCC; border:1">
    <td width="123" height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:">
	Location	</td>
    <td height="25" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
	<?php echo($city) ?>&nbsp;,&nbsp;<?php echo($state) ?>    </td>
    <td height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">&nbsp;</td>
    <td height="25" colspan="2" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">&nbsp;</td>
  </tr>
  <tr style="border-bottom:dotted 1 #CCCCCC; border:1">
    <td height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:">Close to</td>
    <td height="25" colspan="4" style="font-size:14px; font-family:Arial, Helvetica, sans-serif"><?php echo($metroline) ?></td>
    </tr>
  <tr>
    <td width="123" height="48" style=" font-weight:bold; padding-top:20px; padding-right:15; font-size:14px; font-family:Arial, Helvetica, sans-serif" valign="top" align="right">&nbsp;</td>
    <td colspan="4" valign="top" align="left" style="border-bottom:0 #EEEEEE dotted; padding: 20 40 10 0; line-height:150%; font-size:14px; font-family:Arial, Helvetica, sans-serif;  margin-left:5px">
        <?php 
echo($description) ?>      </td>
    </tr>
  <tr>
    <td width="123" height="10" style="border-top:#EEEEEE dotted 0">&nbsp;</td>
    <td height="10"colspan="4" align="left" valign="top" style="border-top:#EEEEEE dotted 0; padding-top:10">
      <?php 
					$target = "upload/h".$hid;
					if(is_dir($target)){
						echo("<div style='margin-top:20; margin-bottom:20'>");
						if(file_exists($target."/1_600.jpg")) echo("<img src=upload/h$hid/1_600.jpg style=border:0 width=450><br><br>");
				  		if(file_exists($target."/2_600.jpg")) echo("<img src=upload/h$hid/2_600.jpg style=border:0 width=450><br><br>");
						if(file_exists($target."/3_600.jpg")) echo("<img src=upload/h$hid/3_600.jpg style=border:0 width=450>");
						echo("</div>");
					}
	?>    </td>
  </tr>
  <tr>
    <td width="123" height="14" style="border-top:#EEEEEE dotted 0">&nbsp;</td>
    <td style="border-top:#EEEEEE dotted 0"colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="123" height="20" style="border-top:#CCCCCC dotted 0">&nbsp;</td>
    <td height="20" colspan="4" align="left" style="padding-left:0; font-size:14px; font-family:Arial, Helvetica, sans-serif">
      <font color="#999999">The availability of this post is for <?php echo($expireday) ?> days.</font>	  </td>
  </tr>
  <tr>
    <td width="123" height="52" style="border-top:#CCCCCC dotted 0">&nbsp;</td>
    <td colspan="4" align="left">
	<table width="500" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px">
      <tr>
        <td width="580" height="41" colspan="3"><?php
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
            <div id="flashDeleteMemo<?php echo($cid) ?>" class="flashDeleteMemo<?php echo($cid) ?>" style="padding-left:0px"></div>
			<div id="deleteMemoResult<?php echo($cid) ?>" class="deleteMemoResult<?php echo($cid) ?>" style="padding-left:0px"></div>
			<div style="line-height:180%; margin-bottom:10; width: 550; border:0 #EEEEEE solid" id="houseMemo<?php echo($cid) ?>" class="houseMemo<?php echo($cid) ?>">
              <table width="580" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style=" margin-top:0px; margin-bottom:0px; border:0 #EEEEEE solid">
                <tr>
                  <td width="70" style="padding:5;" valign="top">
				  	<script type="text/javascript" >
$(function() {
	$(".deleteComment_button<?php echo($cid) ?>").click(function() {
		var cid = <?php echo($cid) ?>;
		var dataString = 'cid='+cid; 

		if(cid=='')
		{
			alert("not getting memo id!");
		}
		else
		{
			$("#flashDeleteMemo<?php echo($cid) ?>").show();
 			$("#flashDeleteMemo<?php echo($cid) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle"> <span class="loading">Removing comment...</span>');
 
			$.ajax({
 				type: "POST",
				url: "memo_delete_house.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#flashDeleteMemo<?php echo($cid) ?>").hide();
					$("#houseMemo<?php echo($cid) ?>").hide();
					$("#deleteMemoResult<?php echo($cid) ?>").after(html);
					$("#deleteMemoResult<?php echo($cid) ?>").fadeIn("slow");
					document.getElementById('replycontent').value='';
					document.getElementById('replycontent').focus();
				}
			});
		} return false;
 	});
 });
</script>	                      </td>
                  <td width="480" height="36" colspan="0" valign="top" style="padding-top:5px; line-height:150%; border-top:0px #EEEEEE solid; padding-left:5px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><?php
			echo(nl2br($descrip));
			echo("<br><font color=#CCCCCC style='font-size:11px'>".getDateName($pdate)." | ".$ptime." | </font>");
			if($sender==$uname)echo("<font color=#CCCCCC style='font-size:11px'>From </font><a href='RockerDetail.php?uid=$sender' class=one><font color=#999999 style='font-size:11px'>$sender</font></a> &nbsp;<span id='deleteComment_button$cid' class='deleteComment_button$cid' style='height:13;display:inline; padding:0 7 0 7; background-color:#F5F5F5; border:1px #EEEEEE solid; font-size:11px; cursor:pointer'><font color=$_SESSION[hcolor]>Delete </font></span>");else
			echo("<font color=#CCCCCC style='font-size:11px'>Click <a href='RockerDetail.php?uid=$sender' class=one><font color=#CCCCCC style='font-size:11px'>$sender</font></a> to reply</font>");
	?>                  </td>
                </tr>
              </table>
            </div>
          <?php }}?></td>
      </tr>
    </table>
	<div id="flashHouseMemo" class="flashHouseMemo" style="padding-left:0px"></div>
    <div id="displayHouseMemo" style="padding-left:0px"></div>
        <table width="700" border="0" cellpadding="0" cellspacing="0" style="border-top:#EEEEEE solid 1px; margin-bottom:20">
          <tr>
            <td width="46" height="86" align="left" valign="top" bgcolor="#F5F5F5" style="padding:10px; border-top:0px solid #999999"><?php echo($unameImg) ?></td>
            <td width="460" height="86" colspan="2" align="left" bgcolor="#F5F5F5" style="padding:10 10 10 0; border-top:0px solid #999999"><textarea name="replycontent" class="replycontent" id="replycontent" rows="6" style="width:600; font-size:14px; font-family:Arial, Helvetica, sans-serif; border:1px #DDDDDD solid"></textarea></td>
          </tr>
          <tr>
            <td height="38" align="left" bgcolor="#F5F5F5" style="padding:10px; border-top:0px solid #999999">&nbsp;</td>
            <td height="38" colspan="2" align="left" bgcolor="#F5F5F5" style="padding:0 10 10 0; border-top:0px solid #999999"><input type="hidden" name="recipient" id="recipient" value="<?php echo($postuname) ?>" />
                <input name="submit2" type="submit" class="commentArticle_button" value=" Submit " style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:0px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif" />
                <input type="hidden" name="aid" value="<?php echo($aid) ?>" />
                <input type="hidden" name="sender" value="<?php echo($uname) ?>" />
                <div id="show_recipient_name"></div></td>
          </tr>
        </table>
        <script type="text/javascript" src="js/jquery.min.js"></script>
	  <script type="text/javascript">
 $(function() {
 $(".commentHouse_button").click(function() {
var test = $("#replycontent").val();
var hid = <?php echo($hid) ?>;
var pdate = '<?php echo(date('Y-m-d')) ?>';
var ptime = '<?php echo(date("H:i:s", time())) ?>';
var sender = '<?php echo($uname) ?>';
var recipient = $("#recipient").val();
var dataString = 'content='+ test+'&hid='+hid+'&sender='+sender+'&recipient='+recipient+'&pdate='+pdate+'&ptime='+ptime; 
//alert(dataString);

if(test=='')
{
 alert("Please Enter Something ok?");
}
else
{
 $("#flashHouseMemo").show();
 $("#flashHouseMemo").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle"> <span class="loading">Posting Comment...</span>');
 
 $.ajax({
  type: "POST",
  url: "memo_house.php",
  data: dataString,
  cache: false,
  success: function(html){
  $("#displayHouseMemo").after(html);
  document.getElementById('replycontent').value='';
  document.getElementById('replycontent').focus();
  $("#flashHouseMemo").hide();
  }
 });
 } 
return false;
 });
 });
</script></td>
  </tr>
</table> 
      </div></td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
