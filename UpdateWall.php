<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];
$uid = $uname;

//if(isset($_GET['uid']) && strlen(trim($_GET['uid']))>0 ) $uid = $_GET['uid'];
//else header("location:ThingsRock.php");

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

if($cschool!=NULL){
	$q = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
	if(!$q) die(mysql_error());
	$obj = mysql_fetch_object($q);
	$cschool = $obj->school_name;
}else $cschool = "Unknown which school";

if($cmajor!=NULL && trim($cmajor)!="empty"){
	$m = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid='$cmajor'");
	if(!$m) die(mysql_error());
	$objm = mysql_fetch_object($m);
	$major_name = $objm->major_name;	
}else $major_name = "Unknown which major";

if($ccity==NULL || $ccity=="empty" ) $ccity = "Unknown city";
if($cstate==NULL || $cstate=="em" ) $cstate = "Unknown State";
if($cdegree==NULL) $cdegree = "Unknown which degree";
if($mstatus==NULL) $mstatus = "Unknown status";
?><style type="text/css">
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
	<table width="740" height="116" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="250" valign="top" align="left">
		<?php 
			$pic100_Name = $uname.'250.jpg';
				  $target = "upload/".$uname;
				  if(is_dir($target))
				  echo("<a href='EditHeadIcon.php'><img src=upload/$uname/$pic100_Name?".time()." style=border:0></a>");
				  else {
				  	$headicon_id = -1;
					echo("<a href='EditHeadIcon.php'><img src=img/NoUserIcon250.jpg style=border:0 width=240></a>");
			}?>
		<div style="width:250; margin-top:15; margin-bottom:5; border-top:1px dashed #DDDDDD; border-bottom:0px solid #999999; background: ;">
			<table width="250" height="22" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="22" align="left" style="font-size:13px; padding-left:5; font-weight:bold; background:url('img/GrayGradbgDown.jpg')">
	<?php echo("Name:&nbsp; $fname $lname") ?>	</td>
    </tr>
</table>
</div>
			<div style="width:250; margin-top:0; border-bottom:1px solid #EEEEEE; background:#FFFFFF">
              <table width="250" height="25" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" style="font-size:12px; padding-left:5"><?php echo($cschool) ?> </td>
                </tr>
              </table>
		    </div>
			<div style="width:250; margin-top:0; border-bottom:1px solid #EEEEEE; background:#FFFFFF">
              <table width="250" height="25" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" style="font-size:13px; padding-left:5"><?php echo($major_name) ?> </td>
                </tr>
              </table>
		    </div>
			<div style="width:250; margin-top:0; border-bottom:1px solid #EEEEEE; background:#FFFFFF">
              <table width="250" height="25" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" style="font-size:13px; padding-left:5"><?php echo($cdegree.", $sterm") ?> </td>
                </tr>
              </table>
		    </div>
			<div style="width:250; margin-top:0; border-bottom:1px solid #EEEEEE; background:#FFFFFF">
              <table width="250" height="25" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" style="font-size:13px; padding-left:5">
				  <?php echo($mstatus." | Birth Date : ".$birthdate)?>
				  </td>
                </tr>
              </table>
		    </div>
			<div style="width:250; margin-top:0; border-bottom:1px solid #EEEEEE; background:#FFFFFF">
              <table width="250" height="25" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" style="font-size:13px; padding-left:5"><?php echo("From $fregion, ".$fcountry) ?> </td>
                </tr>
              </table>
		    </div>
			<div style="width:250; margin-top:0; border-bottom:1px solid #EEEEEE; background:#FFFFFF">
              <table width="250" height="25" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" style="font-size:13px; padding-left:5"><?php echo("Now live in $ccity, ".$cstate)?></td>
                </tr>
              </table>
		    </div>
			<div style="margin-top:15"> <a href="EditUserInfo.php">
              <div style=" height:16; padding:3 8 3 8; background: url(img/master.jpg); display:inline; margin-top:0; margin-bottom:10; width:250;  border:1px solid #999999; border-top:1px solid #CCCCCC;  border-left:1px solid #CCCCCC;  font-size:12px; cursor:pointer; color:#000000" align="center" onmouseover="this.style.background='url(img/GrayGradbgDown.jpg)'" onmouseout="this.style.background='url(img/master.jpg)'">+ Profile</div></a>&nbsp; <a href="EditHeadIcon.php">
  <span style=" height:16; padding:3 8 3 8; background: url(img/master.jpg); display:inline; margin-top:0; margin-bottom:;  border:1px solid #999999; border-top:1px solid #CCCCCC;  border-left:1px solid #CCCCCC; font-size:12px; cursor:pointer; color:#000000" align="center" onmouseover="this.style.background='url(img/GrayGradbgDown.jpg)'" onmouseout="this.style.background='url(img/master.jpg)'">+ Head Icon</span>
</a></div></td>
        <td width="490" valign="top" style="padding-left:20">
<script>
$(document).ready(function() { 
	$("#commentStatusDiv").hide();
	$("#displayStatusMemo").hide();
	$("#visitListDiv").hide();
	$("#recordBoardDiv").hide();
	$("#cancelVisitBtn").hide();
	$("#cancelRecordBtn").hide();
	$("#recordRuleDiv").hide();
	
	$("div .checkRuleBtn").click(function () {
      //$("#recordRuleDiv").slideDown("slide", { direction: "up" }, 3000);
	  $("#recordBoardDiv").hide();
	  $("#recordRuleDiv").show();
	});

	$("div .cancelRuleDiv").click(function () {
      //$("#joinUsDiv").hide("slide", { direction: "up" }, 1000);
	  $("#recordRuleDiv").hide();
	  $("#recordBoardDiv").show();
	});
	
	$("div .commentStatusBtn").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#commentStatusBtn").hide();
	  $("#commentStatusDiv").show();
	});
	
	$("div .commentCancelBtn").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#commentStatusDiv").hide();
	  $("#commentStatusBtn").show();
	});

	$("div .whoVisitBtn").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#whoVisitBtn").hide();
	  $("#recordBoardDiv").hide();
	  $("#cancelVisitBtn").show();
	  $("#visitListDiv").show();
	});
	
	$("div .cancelVisitBtn").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#visitListDiv").hide();
	  $("#cancelVisitBtn").hide();
	  $("#whoVisitBtn").show();
	});
	
	$("div .recordBoardBtn").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#recordBoardBtn").hide();
	  $("#visitListDiv").hide();
	  $("#cancelRecordBtn").show();
	  $("#recordBoardDiv").show();
	});
	
	$("div .cancelRecordBtn").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#recordBoardDiv").hide();
	  $("#recordRuleDiv").hide();
	  $("#cancelRecordBtn").hide();
	  $("#recordBoardBtn").show();
	});
});
</script>

<script type="text/javascript" >
$(function() {
	$(".commentSubmitBtn").click(function() {
		var test = $("#contentforown").val();
		var pdate = '<?php echo(date('Y-m-d')) ?>';
		var ptime = '<?php echo(date("H:i:s", time())) ?>';
		var sender = '<?php echo($uname) ?>';
		var dataString = 'content='+ test+'&sender='+sender+'&pdate='+pdate+'&ptime='+ptime; 

		if(test=='')
		{
			alert("Please Enter Something ok?");
		}
		else
		{
			$("#flashStatusMemo").show();
			$("#flashStatusMemo").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">');
 
 			$.ajax({
  				type: "POST",
  				url: "ajax_insert_status.php",
  				data: dataString,
  				cache: false,
  				success: function(html){
  					$("#displayStatusMemo").after(html);
  					document.getElementById('contentforown').value='';
  					document.getElementById('contentforown').focus();
  					$("#flashStatusMemo").hide();
					$("#commentStatusDiv").hide();
	  				$("#commentStatusBtn").show();
  				}
 			});
 		} return false;
 	});
});
</script>

<?php
$headicon_id = 0;
$q_m = mysql_query("SELECT headicon_id, pdate, ptime FROM rockinus.headicon_history WHERE uname='$uname' ORDER BY headicon_id DESC");
if(!$q_m) die(mysql_error());
$no_row = mysql_num_rows($q_m);
if($no_row == 0) $headicon_id=-1;
else{
	$object = mysql_fetch_object($q_m);
	$headicon_id = $object->headicon_id;
	$icon_create_date = $object->pdate;
	$icon_create_time = $object->ptime;
}

$like_uname_list=NULL;	
$q_like_headicon_list = mysql_query("SELECT * FROM rockinus.headicon_like WHERE headicon_id='$headicon_id' ORDER BY pdate DESC, ptime DESC");
if(!$q_like_headicon_list) die(mysql_error());
$no_row_headicon_list = mysql_num_rows($q_like_headicon_list);
if($no_row_headicon_list == 0 && $headicon_id!=-1){
	$like_uname_list = "<div style='margin-bottom:10; width:450; padding:10 10 10 0; background: #; border-top:0px solid #DDDDDD; border-bottom:0px solid #DDDDDD; '><font color='#000000' style='font-size:18px; font-weight:bold'><img src=img/smileyIcon.png width=18 />&nbsp;&nbsp;No friends liked your icon yet ...</font></div>";
}else if($no_row_headicon_list == 0 && $headicon_id==-1){
	$like_uname_list = "<div style='margin-bottom:20; width=450; font-size:13px; padding:10; background: #F5F5F5; border-top:1px solid #DDDDDD; border-bottom:1px solid #DDDDDD; '><font color='#000000' style='font-size:13px; font-weight:bold'>&nbsp;No friends like your icon, because you haven't uploaded one ...</font></div>";
}else{
	$like_uname_seq = 1;
	$like_uname_list = "<div style='margin-bottom:10; font-size:11px; padding-left:5; padding-top:4; height:18; background: url(img/master.png); border-bottom:1px solid #CCCCCC; font-weight:bold; color:#000000'>So far $no_row_headicon_list people like your icon</div>";
	while($object_headicon_list = mysql_fetch_object($q_like_headicon_list)){
		$like_uname = $object_headicon_list->uname;
		$like_rstatus = $object_headicon_list->rstatus;
		$like_pdate = $object_headicon_list->pdate;
		$like_ptime = $object_headicon_list->ptime;
		$q_like_uname = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$like_uname'");
		if(!$q_like_uname) die(mysql_error());
		$object_like_uname = mysql_fetch_object($q_like_uname);
		$like_fname = $object_like_uname->fname;
		$like_lname = $object_like_uname->lname;
		if($like_rstatus=='N')
		$like_uname_list .= "<div style='margin-bottom:5; padding-bottom:3; border-bottom:1px dashed #EEEEEE; font-size:13px'>
		<table width=470 border=0 cellspacing=0 cellpadding=0>
          <tr>
            <td width=330 align='left' style='font-size:12px; padding-left:5' height='10'>
			<img src='img/headicon_like_Dark.jpg' width=10 />&nbsp;&nbsp; <a href='UpdateWallOut.php?uid=$like_uname' class=one><font color=$_SESSION[hcolor]><strong>$like_fname $like_lname</strong></font></a></td>
            <td width=140 align=right style='padding-right:5; font-size:11px'> <font color=#000000>".getDateName($like_pdate).", ".substr($like_ptime,0,5)."</font></td>
          </tr>
        </table>
</div>";
		else
		$like_uname_list .= "<div style='margin-bottom:5; padding-bottom:3; border-bottom:1px dashed #EEEEEE; font-size:13px'>
		<table width=470 border=0 cellspacing=0 cellpadding=0>
          <tr>
            <td width=330 align=left style='font-size:12px; padding-left:5' height='10'>
			<img src='img/headicon_like.png' width=10 />&nbsp;&nbsp; <a href='UpdateWallOut.php?uid=$like_uname' class=one><font color=#000000>$like_fname $like_lname</font></a></td>
            <td width=140 align=right style='padding-right:5; font-size:11px'> <font color=#999999>".getDateName($like_pdate).", ".substr($like_ptime,0,5)."</font></td>
          </tr>
        </table>
</div>";

		$like_uname_seq++;
	}
}

$q_like_headicon = mysql_query("SELECT * FROM rockinus.headicon_like WHERE uname='$uname' AND headicon_id='$headicon_id'");
if(!$q_like_headicon) die(mysql_error());
$no_row_headicon = mysql_num_rows($q_like_headicon);
echo($like_uname_list);
?><br />
          <a href="RockerDetail.php?uid=<?php echo($uname) ?>">
		  <span class="historyBtn" id="historyBtn" style=" height:16; padding:3 8 3 8; background: url(img/master.jpg); border:1px solid #999999; border-top:1px solid #DDDDDD; border-left:1px #DDDDDD solid; font-size:12px; cursor:pointer; color:#000000; display:inline" align="center" onmouseover="this.style.background='url(img/GrayGradbgDown.jpg)'" onmouseout="this.style.background='url(img/master.jpg)'">My Paper</span></a>&nbsp; <a href="postingHistory_own.php">
		  <span class="historyBtn" id="historyBtn" style=" height:16; padding:3 8 3 8; background: url(img/master.jpg); border:1px solid #999999; border-top:1px solid #DDDDDD; border-left:1px solid #DDDDDD; font-size:12px; cursor:pointer; color:#000000; display:inline" align="center" onmouseover="this.style.background='url(img/GrayGradbgDown.jpg)'" onmouseout="this.style.background='url(img/master.jpg)'">My Recent</span></a>
		  
		  <br />
		  <br />
		  <br />
		  <br />
          <div class="commentStatusBtn" id="commentStatusBtn" style=" display:inline; height:16; padding:3 8 3 8; background: url(img/brownBtnBg.jpg); border:1px solid #333333; font-size:12px; cursor:pointer; color:#FFFFFF" align="center">+ Write New Status</div>&nbsp; <font style='font-size:12px; color:#999999'>(less than 1000 letters)</font>
<div class="commentStatusDiv" id="commentStatusDiv" style=" margin-top:15; margin-bottom:35">
<form action="postStatus.php" method="post" name="ownform" id="ownform" style="margin-top:5px">
<textarea name="contentforown" id="contentforown" style=" width:470; border:1px solid #DDDDDD; padding:4px; height:100px; font-size:13px; font-weight:normal; font-family: Arial, Helvetica, sans-serif; margin-bottom:10px"></textarea>
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
			  <div class="commentSubmitBtn" id="commentSubmitBtn" style=" height:18; padding:3 8 3 8; background: url(img/black_cell_bg.jpg); display:inline; margin-top:10; margin-bottom: width:60; border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:12px; cursor:pointer; color:#FFFFFF" align="center">Submit</div>&nbsp; <div class="commentCancelBtn" id="commentCancelBtn" style=" height:18; padding:3 8 3 8; background: url(img/master.png); display:inline; margin-top:10; width:70; border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:12px; cursor:pointer" align="center">Next time</div>
              </form>
</div>
<div id="flashStatusMemo" class="flashStatusMemo" style="padding-left:0px; margin-top:15; margin-bottom:15;"></div>
<div id="displayStatusMemo" class="displayStatusMemo" style="padding-left:0px; width:450; background:#F5F5F5; padding:10; margin-top:20; line-height:150%; font-size:13px; border:1px solid #DDDDDD"></div>

<div style="margin-top:5">
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
	if($descrip==NULL)
		echo("<div style='width:450; background:#F5F5F5; padding:10; margin-top:10; line-height:150%; font-size:13px; border:1px solid #EEEEEE'><font style='font-size:13px; color:#000000; font-weight:normal'>Hi, what's going on?</font></div>"); 
	else{ 
		echo("<div class='statusDiv$memoid' class='statusDiv$memoid' style='width:450; background:#F5F5F5; padding:10; margin-top:20; line-height:125%; font-size:13px; border:1px solid #DDDDDD'>".addHyperLink($descrip)." <font color=#666666 style='font-size:11px'>(".getDateName($pdate)." | ".substr($ptime,0,5).")</font></div>"); 
	}

	$t = mysql_query("SELECT count(*) AS cnt FROM rockinus.memo_follow_info WHERE memoid='$memoid';");
	$a = mysql_fetch_object($t);
	$memo_follow_cnt = $a->cnt;
	
	$t_u = mysql_query("SELECT count(*) AS cnt FROM rockinus.memo_follow_info WHERE memoid='$memoid' AND recipient='$uname' AND rstatus='N';");
	$a_u = mysql_fetch_object($t_u);
	$memo_follow_unread_cnt = $a_u->cnt;
?>

<script>
$(document).ready(function() { 
	$("#hideCommentBtn<?php echo($memoid) ?>").hide();
	$("#display_expandComment<?php echo($memoid) ?>").hide();
	$("#confirmDeleteDiv<?php echo($memoid) ?>").hide();

	$("#deleteStatusBtn<?php echo($memoid) ?>").click(function () {
	  $("#statusDiv<?php echo($memoid) ?>").hide();
	  $("#panelStatusDiv<?php echo($memoid) ?>").hide();
	  $("#confirmDeleteDiv<?php echo($memoid) ?>").show();
	});

	$("#cancelToDeleteStatusBtn<?php echo($memoid) ?>").click(function () {
	  $("#confirmDeleteDiv<?php echo($memoid) ?>").hide();
	  $("#statusDiv<?php echo($memoid) ?>").show();
	  $("#panelStatusDiv<?php echo($memoid) ?>").show();
	});
});
</script>
<div class="panelStatusDiv<?php echo($memoid) ?>" id="panelStatusDiv<?php echo($memoid) ?>">
<table width="470" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:20; border-bottom:0 solid #DDDDDD">
	<tr>
	<td width="315" height="34" align="left" valign="top" style=" font-weight:normal; font-size:14px; padding-left:10; padding-top:5; line-height:180%">
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
  				}
 			});
 		} return false;
 	});
 });
</script>
	  <span class="expandComment_button<?php echo($memoid) ?>" id="expandComment_button<?php echo($memoid) ?>" style="border-bottom:0 dashed #999999; font-color:#666666; font-weight:normal; font-size:12px; cursor:pointer">
	  <?php 
	  	if($memo_follow_unread_cnt>0)
			echo("<font color=$_SESSION[hcolor] style='font-weight:bold'>Reply($memo_follow_unread_cnt)</font>"); 
	  	else
			echo("Reply($memo_follow_cnt)");
	  ?>
	  </span>
	  <?php if($uname==$uid){ ?> <font color="#666666">| </font>
	  <span class="deleteStatusBtn<?php echo($memoid) ?>" id="deleteStatusBtn<?php echo($memoid) ?>" style="cursor:pointer; font-size:12px">Delete</span>
	  <?php } ?>		</td>
	<td width="155" align="right" valign="top" style="font-weight:normal; padding-right:20; padding-top:5">
	<div class="hideCommentBtn<?php echo($memoid) ?>" id="hideCommentBtn<?php echo($memoid) ?>" style=" height:16; padding:3 8 3 8; background: url(img/master.png); width:120; border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:12px; cursor:pointer; color:#000000" align="center">Hide Comment(s)</div>
	</td>
	</tr>
	<tr>
	  <td height="5" colspan="2" align="left" valign="top" style="padding-left:5; padding-bottom:10; line-height:100%; font-size:12px">
  	<div id="flash_expandComment<?php echo($memoid) ?>" class="flash_expandComment<?php echo($memoid) ?>" style="padding-left:0px" align="left"></div>
	<div id="display_expandComment<?php echo($memoid) ?>" class="display_expandComment<?php echo($memoid) ?>" align="left"></div>
	</td>
	  </tr>
	</table>
</div>

<div class="confirmDeleteDiv<?php echo($memoid) ?>" id="confirmDeleteDiv<?php echo($memoid) ?>" style=" width:470; background:#F5F5F5; border:1px solid #DDDDDD; font-size:13px; font-weight:bold; line-height:250%; padding-top:10; padding-bottom:15;  margin-top:10" align="center">
Are you sure to delete this status?<br />
<a href="deleteStatusManage.php?memoid=<?php echo($memoid); ?>">
<span class="confirmToDeleteStatusBtn<?php echo($memoid) ?>" id="confirmToDeleteStatusBtn<?php echo($memoid) ?>" style=" height:16; padding:3 8 3 8; background: url(img/master.jpg); line-height:120%; border:1px solid #999999; border-top:1px solid #CCCCCC; font-size:12px; cursor:pointer; color:#000000; display:inline; font-weight:normal" align="center">Yes, delete</span></a>&nbsp;&nbsp;<span class="cancelToDeleteStatusBtn<?php echo($memoid) ?>" id="cancelToDeleteStatusBtn<?php echo($memoid) ?>" style=" height:16; padding:3 8 3 8; background: url(img/master.jpg); border:1px solid #999999; line-height:120%; border-top:1px solid #CCCCCC; font-size:12px; cursor:pointer; color:#000000; display:inline; font-weight:normal" align="center">No, go back</span>
</div>
<?php
}		

// Update rstatus of headicon, set it already read
$upd_headicon_like = mysql_query("UPDATE rockinus.headicon_like SET rstatus='Y' WHERE rstatus='N' AND uname='$uname';");
if(!$upd_headicon_like) die(mysql_error());
?>
</div>
</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
