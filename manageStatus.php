<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];

if(isset($_GET['uid']) && strlen(trim($_GET['uid']))>0 ) $uid = $_GET['uid'];
else header("location:ThingsRock.php");

if($uid==$uname){
	$reply = mysql_query("SELECT count(*) as cnt FROM rockinus.memo_follow_info WHERE memoid in (SELECT memoid FROM rockinus.memo_info WHERE sender='$uname') AND rstatus = 'N'");
	if(!$reply)	die("Error quering the Database: " . mysql_error());
	$reply_obj = mysql_fetch_object($reply);
	$reply_cnt = $reply_obj->cnt;
}

$q = mysql_query("SELECT * FROM rockinus.user_info INNER JOIN rockinus.user_check_info INNER JOIN rockinus.user_edu_info INNER JOIN rockinus.user_contact_info ON user_info.uname='$uid' AND user_info.uname=user_check_info.uname AND user_info.uname=user_edu_info.uname AND user_info.uname=user_contact_info.uname");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;
$fname = $object->fname;
if($fname==NULL || strlen(trim($fname))==0) $fname=$uid;
$lname = $object->lname;
$birthdate = $object->birthdate;
if($birthdate!=NULL && strlen(trim($birthdate))==10 )$birthdate = substr($birthdate,5,5);
else $birthdate = "Unknown";
$sterm = $object->sterm;
$fregion = $object->fregion;
$fcountry = $object->fcountry;
if(trim($fcountry)=="empty")$fcountry="Unknown country";
if(trim($fregion)=="empty")$fregion="Unknown city";
$email = $object->email;
$cmajor = $object->cmajor;
if(trim($cmajor)=="empty") $cmajor=NULL;
$cschool = $object->cschool;
if(trim($cschool)=="empty") $cschool=NULL;
$cdegree = $object->cdegree;
if(trim($cdegree)=="empty") $cdegree="Unknown degree";
$cstate = $object->cstate;
$ccity = $object->ccity;

?>
<style type="text/css">
<!--
.STYLE2 {color: #336633}
-->
</style>
<style type="text/css">
#load{
position:absolute;
z-index:1;
border:4px solid #DDDDDD;
background: #F5F5F5;
color:#FFFFFF;
width:250px;
padding-top:15px;
padding-bottom:15px;
margin-top:-150px;
margin-left:-150px;
top:50%;
left:50%;
text-align:center;
line-height:500px;
font-family:"Trebuchet MS", verdana, arial,tahoma;
font-size:14pt;
}
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".showUploadDiv").click(function(){
		$(".downloadDiv").fadeOut("fast"); 
		$(".uploadDiv").fadeIn("fast"); 
	});
	
	$(".innerUploadDiv").click(function(){
		$(".downloadDiv").fadeOut("fast"); 
		$(".uploadDiv").fadeIn("fast"); 
	});
	
	$(".showDownloadDiv").click(function(){
		$(".uploadDiv").fadeOut("fast"); 
		$(".downloadDiv").fadeIn("fast"); 
	});

	$(".showSubscribeDiv").click(function(){
		$(".subscribeDiv").fadeIn("fast"); 
	});	
});
</script>
<script type="text/javascript">
var ray={
ajax:function(st){
	 this.show('load');
},

show:function(el){
	 this.getID(el).style.display='';
},

getID:function(el){
	 return document.getElementById(el);
}
}
</script>
<div align="center" style="margin-top:0px">
<table width="1024" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="300" valign="top" align="left" style="border-right:1px dashed #DDDDDD">
	<?php include("leftHomeMenu.php") ?>
	</td>
    <td align="right" valign="top" style="margin-top:0;" width="760">
	<?php include("HeaderEN.php"); ?>
	<?php 
if(isset($_SESSION['rst_msg'])) {
	echo($_SESSION['rst_msg']);
	unset($_SESSION['rst_msg']);
}
?>
	<table height="30" width="740" border="0" cellspacing="0" cellpadding="0" style=" margin-bottom:20">
      <tr>
        <td width="150" valign="middle" style="border:1px #CCCCCC solid; display:inline; background:#F5F5F5; border-bottom:0; font-weight:bold; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif" align="center"><a href="RockerDetail.php?uid=<?php echo($uid) ?>" class="one">Home</a></td>
        <td width="150" valign="middle" style="border:1px #333333 solid; display:inline; background:<?php echo($_SESSION['hcolor']) ?>; border-bottom:0; font-weight:bold; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif" align="center">
		<a href="manageStatus.php?uid=<?php echo($uid) ?>">Status<?php if($uid==$uname && $reply_cnt>0)echo(" ($reply_cnt)")?></a></td>
        <td width="150px" valign="middle" <?php if($uid==$uname)echo("style='border:1px #CCCCCC solid; display:inline; background:#F5F5F5; border-bottom:0; font-weight:bold; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;'")?> align="center">
	<?php if($uid==$uname)echo("<a href='userRelated.php?uid=$uid' class='one'>Private Info</a>") ?></td>
        <td>&nbsp;</td>
      </tr>
    </table>
	
	<table width="740" height="50" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:20; border-bottom:8px solid #EEEEEE; color:#999999">
	<tr>
	<td style="font-size:18px; font-weight:bold; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:5">
	<?php echo($fname) ?>'s Status Board
	</td>
	</tr>
	</table>
	<div class="writeMemo" id="writeMemo" style="display:">
 <?php if($uname==$uid){ ?>
            <div style="padding-left:0px" class="" id="">
                <table width="740" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style=" margin-top:15px; margin-bottom:15px; border:0px #DDDDDD solid">
                  <tr>
                    <td width="70px" style="padding-left:0px; padding-top:10px; padding-bottom:5px" valign="top"><?php 
			$memo_uname = $uname.'100.jpg';
			//date('Y-m-d, H:i');
			$target_memo_uname = "upload/".$uname;
			echo("<table><tr>");
			if(is_dir($target_memo_uname)){
				echo("<td align='center' style='border:0px solid #EEEEEE; padding:0px' width='50px'><a href='RockerDetail.php?uid=$uname' class=one title='$uname'><img src=upload/$uname/$memo_uname?".time()." width=70 style='margin-right:0px;'></a></td>");
			}else 
				echo("<td align='center' style='border:0px solid #EEEEEE; padding:0px' width='50px'><a href='RockerDetail.php?uid=$uname' class=one title='$uname'><img src='img/NoUserIcon_fixed.jpg' width=70 style='margin-right:0px;'></a></td>");
			echo("</tr></table>");
			 ?>
                    </td>
                    <td style="padding:20px; padding-bottom:10px; padding-top:0px; border:0 solid #DDDDDD" valign="top">
					<form action="postStatus.php" method="post" name="ownform" id="ownform" style="margin-top:10px">
                        <textarea name="contentforown" id="contentforown" style=" width:620; border:2 solid #DDDDDD; height:70px; font-size:14px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif; margin-bottom:10px"></textarea>
<script type="text/javascript" >
$(function() {
	$(".deleteComment_button<?php echo($memofid) ?>").click(function() {
		var memofid = <?php echo($memofid) ?>;
		var dataString = 'memofid='+memofid; 

		if(memofid=='')
		{
			alert("not getting memo id!");
		}
		else
		{
			$("#flashdeletememo<?php echo($memofid) ?>").show();
 			$("#flashdeletememo<?php echo($memofid) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle"> <span class="loading">Deleting comment...</span>');
 
			$.ajax({
 				type: "POST",
				url: "memo_delete_friend.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#deletefriendresult<?php echo($memofid) ?>").after(html);
					document.getElementById('contentforfriend').value='';
					document.getElementById('contentforfriend').focus();
					$("#flashdeletememo<?php echo($memofid) ?>").hide();
					$("#friendmemo<?php echo($memofid) ?>").hide();
				}
			});
		} return false;
 	});
 });
              </script>
                    <input name="ownformSubmit" type="submit" class="owncomment_button" value=" Submit " style=" height:23; border:1 solid #DDDDDD; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; background-color:#FFFFFF" />
                    </form></td>
                  </tr>
                </table>
            </div>
            <div id="writeOwnMemo" class="writeOwnMemo" style="background:#F5F5F5; padding-left:20px"> </div>
            <?php } ?>
 </div>
	
	<?php
	$q_memo = mysql_query("SELECT * FROM rockinus.memo_info WHERE sender='$uid' ORDER BY memoid DESC;");
	if(!$q_memo) die(mysql_error());
	$memo_no_row = mysql_num_rows($q_memo);
	if($memo_no_row==0)echo("<div style='color:#999999; font-size:24px; padding-top:30; padding-bottom:30; font-weight:bold' align='center'><img src=img/notfoundIcon.jpg width=25 />&nbsp;&nbsp;Nothing posted</div>");
	while($object = mysql_fetch_object($q_memo)){
	$memoid = $object->memoid;
	$descrip = $object->descrip;
	$descrip = str_replace("\\","",nl2br($descrip));
	$pdate = $object->pdate;
	$ptime = $object->ptime;
	
	$t = mysql_query("SELECT count(*) AS cnt FROM rockinus.memo_follow_info WHERE memoid='$memoid';");
	$a = mysql_fetch_object($t);
	$memo_follow_cnt = $a->cnt;
	?>
	<table width="740" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:20; border-bottom:1 solid #DDDDDD">
	<tr>
	<td height="34" align="left" valign="top" style=" font-weight:normal; font-size:14px; padding-left:5; line-height:180%">
	<?php if($descrip==NULL)echo("<font style='font-size:16px; font-family: Verdana, Arial, Helvetica, sans-serif; color:#999999; font-weight:bold'>Nothing posted ...</font>"); 
	else{ echo("$descrip "); echo("<font color=#666666>(".getDateName($pdate)." | ".substr($ptime,0,5).")</font>"); } ?>
	<br />
	<script type="text/javascript" >
$(function() {
 	$(".expandComment_button<?php echo($memoid) ?>").click(function() {
		var memoid = <?php echo($memoid) ?>;
		var memocnt = <?php echo($memo_follow_cnt) ?>;
		var dataString = 'memoid='+memoid; 

		if(memoid=='')
		{
			alert("not getting memo id!");
		}
		else if( memocnt>0 && !$("#display_expandComment<?php echo($memoid) ?>").is(':visible') )
		{
			$("#flash_expandComment<?php echo($memoid) ?>").show();
			$("#flash_expandComment<?php echo($memoid) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">&nbsp;<span class="loading">Loading Comments...</span>');
 
			$.ajax({
  				type: "POST",
  				url: "load_memo.php",
  				data: dataString,
  				cache: false,
  				success: function(html){
  					$("#display_expandComment<?php echo($memoid) ?>").after(html);
					$("#display_expandComment<?php echo($memoid) ?>").show(html);
  					$("#flash_expandComment<?php echo($memoid) ?>").hide();
					//alert($("#display_expandComment<?php echo($memoid) ?>").is(':visible'));
  				}
 			});
 		} return false;
 	});
 });
</script>
	  <span class="expandComment_button<?php echo($memoid) ?>" id="expandComment_button<?php echo($memoid) ?>" style="border-bottom:0 dashed #999999; font-color:#666666; font-weight:normal; font-size:12px" onMouseOver="this.style.cursor='hand';">Reply (<?php echo($memo_follow_cnt) ?>)</span><?php if($uname==$uid){ ?> <font color="#666666">| </font><a href="deleteStatusManage.php?memoid=<?php echo($memoid); ?>" class="one" style="border-bottom:0 dashed #999999;font-color:#666666; font-weight:normal; font-size:12px">Delete</a><?php } ?>		</td>
	</tr>
	<tr>
	  <td height="15" align="left" valign="top" style="padding-left:5; padding-bottom:10; line-height:150%; font-size:12px">
  	<div id="flash_expandComment<?php echo($memoid) ?>" class="flash_expandComment<?php echo($memoid) ?>" style="padding-left:0px" align="left"></div>
	<div id="display_expandComment<?php echo($memoid) ?>" class="display_expandComment<?php echo($memoid) ?>" style="padding-left:0px; display:none" align="left"></div>	  </td>
	  </tr>
	</table>
	<? } ?>
	
	<div>
 <?php if($uid!=$uname){ ?>
              <script type="text/javascript" >
 $(function() {
 $(".commentfriend_button").click(function() {
var test = $("#contentforfriend").val();
var memoid = <?php echo($memoid) ?>;
var pdate = '<?php echo(date('Y-m-d')) ?>';
var ptime = '<?php echo(date("H:i:s", time())) ?>';
var sender = '<?php echo($uname) ?>';
var recipient = '<?php echo($uid) ?>';
var dataString = 'content='+ test+'&memoid='+memoid+'&sender='+sender+'&recipient='+recipient+'&pdate='+pdate+'&ptime='+ptime; 

if(test=='')
{
 alert("Please Enter Something ok?");
}
else
{
 $("#flashfriendmemo").show();
 $("#flashfriendmemo").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle"> <span class="loading">Posting Comment...</span>');
 
 $.ajax({
  type: "POST",
  url: "memo_insert_friend.php",
  data: dataString,
  cache: false,
  success: function(html){
  $("#displayfriendmemo").after(html);
  document.getElementById('contentforfriend').value='';
  document.getElementById('contentforfriend').focus();
  $("#flashfriendmemo").hide();
  }
 });
 } return false;
 });
 });
              </script>
              <div id="flashfriendmemo" class="flashfriendmemo" style="padding-left:0px"></div>
            <div id="displayfriendmemo" style="padding-left:0px"></div>
            <div style="padding-left:0px">
                <table width="740" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style=" margin-top:15px; margin-bottom:15px; border:0px #DDDDDD solid">
                  <tr>
                    <td width="70px" style="padding-left:0px; padding-top:10px; padding-bottom:5px" valign="top"><?php 
			$memo_uname = $uname.'_fixed70.jpg';
			//date('Y-m-d, H:i');
			$target_memo_uname = "upload/".$uname;
			echo("<table><tr>");
			if(is_dir($target_memo_uname)){
				echo("<td align='center' style='border:0px solid #EEEEEE; padding:0px' width='50px'><a href='RockerDetail.php?uid=$uname' class=one title='$uname'><img src=upload/$uname/$memo_uname?".time()." style='margin-right:0px;'></a></td>");
			}else 
				echo("<td align='center' style='border:0px solid #EEEEEE; padding:0px' width='50px'><a href='RockerDetail.php?uid=$uname' class=one title='$uname'><img src='img/NoUserIcon_fixed.jpg' width=70 height=70 style='margin-right:0px;'></a></td>");
			echo("</tr></table>");
			 ?>
                    </td>
                    <td style="padding-left:20px; padding-bottom:10px; padding-top:0px"><form action="" method="post" name="form" id="form" style="margin-top:10px">
                        <textarea name="contentforfriend" id="contentforfriend" style=" width:600px; border:2 solid #DDDDDD; height:70px; font-size:14px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif; margin-bottom:10px"></textarea>
<script type="text/javascript" >
 $(function() {
 	$(".deleteComment_button<?php echo($memofid) ?>").click(function() {
		var memofid = <?php echo($memofid) ?>;
		var dataString = 'memofid='+memofid; 

if(memofid=='')
{
 alert("not getting memo id!");
}
else
{
 $("#flashdeletememo<?php echo($memofid) ?>").show();
 $("#flashdeletememo<?php echo($memofid) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle"> <span class="loading">Loading Comment...</span>');
 
 $.ajax({
  type: "POST",
  url: "memo_delete_friend.php",
  data: dataString,
  cache: false,
  success: function(html){
  $("#deletefriendresult<?php echo($memofid) ?>").after(html);
  document.getElementById('contentforfriend').value='';
  document.getElementById('contentforfriend').focus();
  $("#flashdeletememo<?php echo($memofid) ?>").hide();
  $("#friendmemo<?php echo($memofid) ?>").hide();
  }
 });
 } return false;
 });
 });
              </script>
                      <br />
                        <input name="submit2" type="submit" class="commentfriend_button" value=" Submit " style=" height:23; border:1 solid #DDDDDD; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; background-color:#FFFFFF" />
                    </form></td>
                  </tr>
                </table>
            </div>
            <div id="writeFriendMemo" class="writeFriendMemo" style="background:#F5F5F5; padding-left:20px"> </div>
            <?php } ?>
</div>

	</td>
  </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
