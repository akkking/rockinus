<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];

if(isset($_GET['uid']) && strlen(trim($_GET['uid']))>0 ) $uid = $_GET['uid'];
else header("location:ThingsRock.php");

$wid = ProfileProgress($uid);

$total_profile=2;
if($wid<50) $total_profile=2;
else if($wid>=50&&$wid<85) $total_profile=5;
else if($wid>=85) $total_profile=10;

$t_headicon = mysql_query("SELECT count(*) as cnt FROM rockinus.headicon_history WHERE uname='$uid'");
$a_headicon = mysql_fetch_object($t_headicon);
$total_headicon = $a_headicon->cnt;

$t_message = mysql_query("SELECT count(*) as cnt FROM rockinus.message_info where sender='$uid'");
$a_message = mysql_fetch_object($t_message);
$total_message = $a_message->cnt;

$t_friend = mysql_query("SELECT count(*) AS cnt FROM rockinus.rocker_rel_info WHERE sender='$uid' OR recipient='$uid'");
$z_friend = mysql_fetch_object($t_friend);
$total_friend = $z_friend->cnt;

$t_course_subs = mysql_query("SELECT * FROM rockinus.user_course_info WHERE uname='$uid';");
if(!$t_course_subs) die(mysql_error());
$total_course_subs = mysql_num_rows($t_course_subs);

$q_course_file = mysql_query("SELECT a.*, b.course_id, b.pid, c.course_name FROM rockinus.user_file_info a JOIN rockinus.unique_course_info b JOIN rockinus.course_info c ON a.owner='$uid' AND a.course_uid=b.course_uid AND c.course_id=b.course_id GROUP BY a.course_uid");
if(!$q_course_file) die(mysql_error());
$total_course_file = mysql_num_rows($q_course_file);
		
$t_login = mysql_query("SELECT count(*) as cnt FROM rockinus.user_log_info where uname='$uid' AND flag=0");
$a_login = mysql_fetch_object($t_login);
$total_login_times = $a_login->cnt;

$t_course_memo = mysql_query("SELECT count(*) as cnt FROM rockinus.course_memo_info where sender='$uid'");
$a_course_memo = mysql_fetch_object($t_course_memo);
$total_course_memo = $a_course_memo->cnt;

$t_memo = mysql_query("SELECT count(*) as cnt FROM rockinus.memo_info where sender='$uid' AND descrip<>NULL AND descrip<>''");
$a_memo = mysql_fetch_object($t_memo);
$total_memo = $a_memo->cnt;

$t_news = mysql_query("SELECT count(*) as cnt FROM rockinus.news_info where creater='$uid'");
$a_news = mysql_fetch_object($t_news);
$total_news = $a_news->cnt;

$t_house = mysql_query("SELECT count(*) as cnt FROM rockinus.house_info where uname='$uid'");
$a_house = mysql_fetch_object($t_house);
$total_house = $a_house->cnt;

$t_article = mysql_query("SELECT count(*) as cnt FROM rockinus.article_info where uname='$uid'");
$a_article = mysql_fetch_object($t_article);
$total_article = $a_article->cnt;

$t_visit_user = mysql_query("SELECT * FROM rockinus.visit_info WHERE visitor='$uid' ORDER BY vdate DESC, vtime DESC;");
if(!$t_visit_user) die(mysql_error());
$total_visit_user = mysql_num_rows($t_visit_user);
				
$t_visit_times = mysql_query("SELECT * FROM rockinus.visit_history WHERE visitor='$uid' ORDER BY vdate DESC, vtime DESC;");
if(!$t_visit_times) die(mysql_error());
$total_visit_times = mysql_num_rows($t_visit_times);

$total_point = $total_profile + $total_headicon*15 + $total_visit_user*2 + $total_article*10 + $total_house*10 + $total_message*5 + $total_news*10 + $total_memo*5 + $total_course_file*15 + $total_course_memo*4 + $total_course_subs*5 + $total_login_times*2 + $total_friend*4 ;       

$token_full = 0;
$token_half = 0;
$token_empty = 0;

$token="star";
$cal_unit=100;

if($total_point>=500&&$total_point<2500){
	$cal_unit=500;
	$token = "diamond";
}else if($total_point>=2500){
	$cal_unit=1000;
	$token = "gold";
}

if(($token=="star"&&$total_point<100) || ($token=="diamond"&&$total_point<1000) || ($token=="gold"&&$total_point<2500)) $token_full=0;
else $token_full = floor($total_point/$cal_unit);
//echo("$token<br>$token_full<br>$total_point<br>");

if($total_point%$cal_unit>0) {
	$token_half=1;
	$token_empty=5-$token_half-$token_full;
}else{
	$token_half=0;
	$token_empty=5-$token_full;
}

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
<script>
$(document).ready(function() {  
	$("#recordRuleDiv").hide();
	
	$("div .checkRuleDiv").click(function () {
      //$("#recordRuleDiv").slideDown("slide", { direction: "up" }, 3000);
	  $("#recordRuleDiv").show();
	});

	$("div .igotitDiv").click(function () {
      //$("#joinUsDiv").hide("slide", { direction: "up" }, 1000);
	  $("#recordRuleDiv").hide();
	});
});
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
	<table width="740" height="40" border="0" cellpadding="0" cellspacing="0" style="margin-top:10">
      <tr>
        <td width="370" valign="top" align="left"><table width="370" height="60" border="0" cellpadding="0" cellspacing="0" background="img/GrayGradbgDown.jpg" style="margin-bottom:0; border-top:1px #DDDDDD solid">
          <tr>
            <td align="left" valign="top" style="padding-left:10; padding-top:15; font-weight:normal; font-size:16px; font-family:Verdana, Arial, Helvetica, sans-serif">Recent visitors
                <?php
			  $v = mysql_query("SELECT visitor, vtime, vdate, fname, lname FROM rockinus.visit_info a JOIN rockinus.user_info b ON a.host='$uid' AND b.uname=a.visitor ORDER BY a.vdate DESC, a.vtime DESC;");
				if(!$v) die(mysql_error());
				$no_row_v = mysql_num_rows($v);
				
			  $v_total = mysql_query("SELECT visitor, vtime, vdate FROM rockinus.visit_history WHERE host='$uid' ORDER BY vdate DESC, vtime DESC;");
				if(!$v_total) die(mysql_error());
				$no_row_v_total = mysql_num_rows($v_total);
				echo("<font color=#999999 size=2>($no_row_v)</font>");
			?></td>
            </tr>
        </table>
		<?php
		if($no_row_v == 0) echo("<div style='padding-top:10px; padding-left:5px; margin-bottom:10px; font-size: 14px' align='center'><strong><img src='img/join.jpg'>&nbsp;&nbsp; Nobody visited yet...</strong></div>");
		$i = 0;
		while($objv = mysql_fetch_object($v)){
			$i++;
			$visitor = $objv->visitor;
			$vfname = $objv->fname;
			$vlname = $objv->lname;
			$vdate = $objv->vdate;
			$vtime = substr($objv->vtime,0,5);
			//$visitpic100 = $visitor.'100.jpg';
			$visit_pic = $visitor.'100.jpg';
			//date('Y-m-d, H:i');
			$target_visitor = "upload/".$visitor;

			if(is_dir($target_visitor)){
			?>
				<div style="margin-bottom:15; margin-left:5" ><table width="360" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD"><tr><td align='center' background="<?php echo("upload/$visitor/$visit_pic?".time()); ?>" style='border:0px solid #EEEEEE; padding:5px' width=70 height="70"></td>
				  <td style='border:0px solid #EEEEEE; padding:5px; padding-left:15; line-height:100%; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif' valign="top" align="left" width=303>
				  <a href="RockerDetail.php?uid=<?php echo($visitor) ?>" class="one" style="font-weight:bold"><?php echo($vfname." ".$vlname) ?></a><br /><br />
				  <?php echo("Visited@".getDateName($vdate)." ".substr($vtime,0,5)) ?></td>
				</tr></table>
				</div>
		  <?php }else{ ?>
		  <div style="margin-bottom:15; margin-left:10" ><table width="360" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD"><tr><td align='center' style='border:0px solid #EEEEEE; padding-bottom:0' width='70px'><a href='RockerDetail.php?uid=$visitor' class=one title='$visitor | $vdate, $vtime'><img src='img/NoUserIcon_fixed.jpg' width=70 height=70 style='margin-right:0px;'></a></td>
				  <td style='border:0px solid #EEEEEE; padding:5px; padding-left:15; line-height:100%; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif' valign="top" align="left" width=303>
				  <a href="RockerDetail.php?uid=<?php echo($visitor) ?>" style="font-weight:bold" class="one"><?php echo($visitor) ?></a><br /><br />
				  <?php echo("Visited@$vdate $vtime") ?></td>
				</tr></table>
				</div>
		  <?php	}
			
			if($i==10)break;
		}
		?></td>
        <td width="370" valign="top" align="right">
		<div id="recordRuleDiv" class="recordRuleDiv"> 
		<table width="350" height="110" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #DDDDDD; margin-bottom:20">
          <tr>
            <td valign="top"><table width="350" height="35" border="0" cellpadding="0" cellspacing="0" background="img/black_cell_bg.jpg" style="margin-bottom:10; border-bottom:1px solid #CCCCCC">
              <tr>
                <td width="241" align="left" valign="middle" style="padding-left:15; font-weight:normal; color:#FFFFFF; font-size:16px; font-family:Verdana, Arial, Helvetica, sans-serif">Points for each item               </td>
                <td width="109" align="right" valign="middle" style="padding-right:15;">
				<div style="font-weight:bold; color:#FFFFFF; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif" id="igotitDiv" class="igotitDiv" onMouseOver="this.style.cursor='hand'"><u>I got it</u></div>
				</td>
              </tr>
            </table>
			  <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Profile(&lt;50%, &gt;50%, &gt;85%)</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right">+ 2, 5, 10 </td>
                </tr>
              </table>
			  <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">
				  Head Icon</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right">+ 15</td>
                </tr>
              </table>
			  <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15"> Head Icon Like</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right">+ 5</td>
                </tr>
              </table>
			  <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Friend</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right">+ 5 </td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Visited user</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right">+ 2 </td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Course comment</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right">+ 5 </td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Course file</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right">+ 20 </td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Subscribed course</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right">+ 5 </td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Notice post</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right">+ 15 </td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">House post</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right">+ 15</td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Sale post</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right">+ 15 </td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Status post</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right">+ 5 </td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Message sent</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right">+ 5 </td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Login</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right">+ 2 </td>
                </tr>
              </table>
			  <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-top:0">
                <tr>
                  <td style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding:15; line-height:150%; background-color:#EEEEEE">100 points for 1 star <br />
                    5 stars for 1 diamond<br />
					Higher level means : <br />
					Better&Extra service, more exciting things </td>
                  </tr>
              </table></td>
			  </tr>
			  </table>
			  </div>
			  
			  <table width="350" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #DDDDDD; margin-bottom:20">
			  <tr>
			  <td>
              <table width="350" height="85" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="margin-bottom:0; border-bottom:1px dashed #DDDDDD">
              <tr>
                <td width="215" align="left" valign="top" style="padding-left:15; padding-top:15; font-weight:normal; line-height:100%; font-size:16px; font-family:Verdana, Arial, Helvetica, sans-serif">Your current level <br />
                  <br />
                  <?php
				for($i=0; $i<$token_full; $i++)
					echo("<img src='img/ratingStar_full_F5.jpg' width=18>");
				for($j=0; $j<$token_half; $j++)
					echo("<img src='img/ratingStar_half_F5.jpg' width=18>");
				for($k=0; $k<$token_empty; $k++)
					echo("<img src='img/ratingStar_empty_F5.jpg' width=18>");
			?><br /></td>
                <td width="135" align="right" valign="top" style="padding-right:15; padding-top:15;">
				<div style="font-weight:bold; color:<?php echo($_SESSION['hcolor']) ?>; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; margin-bottom:15" id="checkRuleDiv" class="checkRuleDiv" onMouseOver="this.style.cursor='hand'"><u>Guide Me</u></div>
				<?php 
	if(getUserPoint($uname)<500)
	  echo "<font color=#DDDDDD><strong><a href=userRelated.php?uid=".$uname." class='one'>Junior User</a></strong></font>";
	else if(getUserPoint($uname)<2500)
	  echo "<font color=#DDDDDD><strong><a href=userRelated.php?uid=".$uname." class='one'>Senior User</a></strong></font>";  
	else
	  echo "<font color=#DDDDDD><strong><a href=userRelated.php?uid=".$uname." class='one'>Professional</a></strong></font>";  
	?>
				</td>
              </tr>
            </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Profile Completeness </td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right"><?php echo($wid) ?>%</td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Head Icon  </td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right"><?php echo($total_headicon) ?></td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Friend number</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right"><?php echo($total_friend) ?></td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Visited users </td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right"><?php echo($total_visit_user) ?></td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Visited times</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right"><?php echo($total_visit_times) ?></td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Course comments</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right"><?php echo($total_course_memo) ?></td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Course files</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right"><?php echo($total_course_file) ?></td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Subscribed courses</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right"><?php echo($total_course_subs) ?></td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Notice posts</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right"><?php echo($total_news) ?></td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">House posts</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right"><?php echo($total_house) ?></td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Sale posts</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right"><?php echo($total_article) ?></td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Status posts</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right"><?php echo($total_memo) ?></td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Message sent</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right"><?php echo($total_message) ?></td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Login times</td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right"><?php echo($total_login_times) ?></td>
                </tr>
              </table>
              <table width="350" height="35" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-left:15">Total points </td>
                  <td width="109" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-right:15" align="right"><?php echo($total_point) ?></td>
                </tr>
              </table></td>
          </tr>
        </table>
          </td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
