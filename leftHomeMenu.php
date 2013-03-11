<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<LINK REL="SHORTCUT ICON" HREF="img/rockinTag.jpg">
<title><?php echo($uname) ?>, welcome home</title>
<style type="text/css">
<!--
body,td,th {
	font-size: 14px;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body>
<?php
$uid = $uname;
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

$t_interview_question = mysql_query("SELECT * FROM rockinus.interview_question WHERE creater='$uid';");
if(!$t_interview_question) die(mysql_error());
$total_interview_question = mysql_num_rows($t_interview_question);

$t_interview_question_follow = mysql_query("SELECT * FROM rockinus.interview_question_follow WHERE uname='$uid';");
if(!$t_interview_question_follow) die(mysql_error());
$total_interview_question_follow = mysql_num_rows($t_interview_question_follow);

$t_course_subs = mysql_query("SELECT * FROM rockinus.user_course_info WHERE uname='$uid';");
if(!$t_course_subs) die(mysql_error());
$total_course_subs = mysql_num_rows($t_course_subs);

//$q_course_question = mysql_query("SELECT a.*, b.course_id, b.pid, c.course_name FROM rockinus.user_file_info a JOIN rockinus.unique_course_info b JOIN rockinus.course_info c ON a.owner='$uid' AND a.course_uid=b.course_uid AND c.course_id=b.course_id GROUP BY a.course_uid");
$q_course_question = mysql_query("SELECT * FROM rockinus.course_question_info WHERE sender='$uname';");
if(!$q_course_question) die(mysql_error());
$total_course_question = mysql_num_rows($q_course_question);
		
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

$total_point = $total_profile + $total_headicon*15 + $total_visit_user*2 + $total_article*10 + $total_house*10 + $total_message*5 + $total_news*10 + $total_memo*5 + $total_course_question*15 + $total_course_memo*4 + $total_course_subs*5 + $total_login_times*2 + $total_friend*4 + $total_interview_question*25 + $total_interview_question_follow*25;       
?>


<?php 
$news = mysql_query("SELECT count(*) as cnt FROM rockinus.news_info");
if(!$news)	die("Error quering the Database: " . mysql_error());
$news_f = mysql_fetch_object($news);
$news_cnt = $news_f->cnt;

$course_comment = mysql_query("SELECT count(*) as cnt FROM rockinus.course_memo_info");
if(!$course_comment)	die("Error quering the Database: " . mysql_error());
$course_comment_f = mysql_fetch_object($course_comment);
$course_comment_cnt = $course_comment_f->cnt;

$interview = mysql_query("SELECT count(*) as cnt FROM rockinus.interview_question");
if(!$interview)	die("Error quering the Database: " . mysql_error());
$interview_f = mysql_fetch_object($interview);
$interview_cnt = $interview_f->cnt;

$house = mysql_query("SELECT count(*) as cnt FROM rockinus.house_info");
if(!$house)	die("Error quering the Database: " . mysql_error());
$house_f = mysql_fetch_object($house);
$house_cnt = $house_f->cnt;

$article = mysql_query("SELECT count(*) as cnt FROM rockinus.article_info");
if(!$article)	die("Error quering the Database: " . mysql_error());
$article_f = mysql_fetch_object($article);
$article_cnt = $article_f->cnt;

$people = mysql_query("SELECT count(*) as cnt FROM rockinus.user_check_info WHERE status='A'");
if(!$people)	die("Error quering the Database: " . mysql_error());
$people_f = mysql_fetch_object($people);
$people_cnt = $people_f->cnt;

$headicon_id = 0;
$q_m = mysql_query("SELECT headicon_id FROM rockinus.headicon_history WHERE uname='$uname' ORDER BY headicon_id DESC");
if(!$q_m) die(mysql_error());
$no_row = mysql_num_rows($q_m);
$object = mysql_fetch_object($q_m);
$headicon_id = $object->headicon_id;

$q_login = mysql_query("SELECT log_date, log_time FROM rockinus.user_log_info WHERE uname='$uname' ORDER BY id DESC LIMIT 1,1;");
if(!$q_login) die(mysql_error());
$no_row_login = mysql_num_rows($q_login);
$object_login = mysql_fetch_object($q_login);
$log_date = getDateName($object_login->log_date);
$log_time = $object_login->log_time;
if($log_date!="Today" && $log_date!="Yesterday")
$log_date = substr($log_date, 2,8);
//$log_time = substr($log_time, 0,5);

$no_row_headicon_list = 0;
$like_uname_list=NULL;	
if($headicon_id != 0){
	$q_like_headicon_list = mysql_query("SELECT * FROM rockinus.headicon_like WHERE headicon_id='$headicon_id'");
	if(!$q_like_headicon_list) die(mysql_error());
	$no_row_headicon_list = mysql_num_rows($q_like_headicon_list);
	if($no_row_headicon_list == 0){
		$like_uname_list = "<font color='#000000'>No friends clicked so far</font>";
	}else{
		$like_uname_seq = 1;
		$like_uname_list = "<div style='margin-bottom:10'>Totally $no_row_headicon_list people like this icon: </div>";
		while($object_headicon_list = mysql_fetch_object($q_like_headicon_list)){
			$like_uname = $object_headicon_list->uname;
			$q_like_uname = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$like_uname'");
			if(!$q_like_uname) die(mysql_error());
			$object_like_uname = mysql_fetch_object($q_like_uname);
			$like_fname = $object_like_uname->fname;
			$like_lname = $object_like_uname->lname;
		
			if($like_uname_seq==1) $like_uname_list .= "<a href='RockerDetail.php?uname=$like_uname' class=one><font color=$_SESSION[hcolor]><strong>$like_fname $like_lname</strong></font></a>";
			else $like_uname_list .= ", <a href='RockerDetail.php?uname=$like_uname' class=one><font color=$_SESSION[hcolor]><strong>$like_fname $like_lname</strong></font></a>";
		
			$like_uname_seq++;
		}
	}
}

 $q_uname = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$uname'");
 if(!$q_uname) die(mysql_error());
 $object_uname = mysql_fetch_object($q_uname);
 $fname = $object_uname->fname;
 $lname = $object_uname->lname;
?>
<table width="250" cellspacing="0" cellpadding="0" border="0" style="border:0px dashed #999999; margin-bottom:50">
  <tr>
    <td height="54" valign="top" style="border-right:0px #EEEEEE solid; padding-left:5px" align="left">
	<a href="ThingsRock.php"><img src="img/rockinus_home_<?php echo(substr($_SESSION['hcolor'],1,6).".jpg") ?>" width="150" /></a>	</td>
  </tr>
  <tr>
    <td height="487" valign="top"><table width="250" height="51" border="0" cellpadding="0" bgcolor="" cellspacing="0" style="border:0px solid #EEEEEE; border-top:0px solid #EEEEEE; border-bottom:0px solid #EEEEEE; margin-top:5;  margin-bottom:20">
      <tr>
        <td width="65" height="51" valign="top" align="left" style="padding-left:5px; font-size:11px"> 
		<?php 
				  $pic100_Name = $uname.'100.jpg';
				  $target = "upload/".$uname;
				  if(is_dir($target))
				  	echo("<a href='EditHeadIcon.php' class='one'><div style='border:2px solid #EEEEEE'><img src=upload/$uname/$pic100_Name?".time()." style='border:1px solid #999999' width=64></div></a>");
				  else {
				  	$headicon_id = -1;
					echo("<a href='EditHeadIcon.php' class='one'><img src=img/NoUserIcon100.jpg style='border:0; border-top:5px solid #FFFFFF' width=60></a>");
					}?>	
					<?php echo("<div style='margin-top:5px' align='center'><a href=EditUserInfo.php class=one><font color=#999999>+ Edit Profile</font></a></div>"); ?>						</td>
        <td width="185" height="51" valign="top" style="padding-bottom:5; padding-top:5; padding-left:0; line-height:160%; font-size:11px; font-family:Arial, Helvetica, sans-serif">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php if($headicon_id==-1)echo("<a href=EditHeadIcon.php class=one><font color=#999999>(+ Set  headicon)</font></a>"); else echo("<img src='img/redflagIcon.png' width=11 />&nbsp; <a href=UpdateWall.php class=one><font color=$_SESSION[hcolor] style='font-size:14px; font-weight:bold'>$uname</font></a>"); ?><br />
		<div style="margin-top:2">
		<?php if($headicon_id==-1)echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href='UpdateWall.php' class='one'><strong><font style='font-size:13px'>$fname $lname</font></strong></a>"); else echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href='UpdateWall.php' class='one'><img src='img/headicon_like.png' width='11' />&nbsp; by $no_row_headicon_list people</a>"); ?></div>
		<div style="margin-top:0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Current &nbsp;<?php
$total_point = getUserPoint($uname);

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

for($i=0; $i<$token_full; $i++)
	echo("<img src='img/ratingStar_full.jpg' width=11>");
for($j=0; $j<$token_half; $j++)
	echo("<img src='img/ratingStar_half.jpg' width=11>");
for($k=0; $k<$token_empty; $k++)
	echo("<img src='img/ratingStar_empty.jpg' width=11>");
?>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Last In:&nbsp; <?php echo("<font color=$_SESSION[hcolor]><em>$log_date</em></font>"); ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="RockerDetail.php?uid=<?php echo($uname) ?>">
<div style="height:18px; background: url(img/master.jpg); border:1px solid #DDDDDD; border-right:1px solid #999999; border-bottom:1px solid #999999; font-size:11px; font-weight:bold; margin-left:17; margin-top:5; font-family:Arial, Helvetica, sans-serif; width: 75; padding:0 3 0 3; color:#000000" align="center"onmouseover="this.style.background='url(img/GrayGradbgDown.jpg)'" onmouseout="this.style.background='url(img/master.jpg)'">My Paper</div>
</a>		
		</td>
      </tr>
	  </table>
	  <table border="0" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
      <tr>
        <td width="35" rowspan="2" style="border-top:0px #DDDDDD solid; padding-left:5px; padding-top:5px" valign="top" align="left">
		<img src="img/newsMenuIcon.jpg" width="20" /></td>
        <td height="25" style=" font-weight: normal; font-family:Arial, Helvetica, sans-serif; font-size:18px; border-top:0px #DDDDDD solid; padding-left:5px">
		<a href="newsList.php" class="one">Campus News</a> <font color=#999999 style='font-weight:normal; font-size:12px'><?php echo("($news_cnt)") ?></font></td>
      </tr>
      <tr>
        <td height="40" valign="top" style=" padding-bottom:5px; padding-right:50; line-height:130%; font-weight: ; border-bottom:0px #DDDDDD solid; padding-left:5px; font-size:11px; color:#999999">
		 School Event, Activity, Part-time, Seminar, Lost+Found, etc. </td>
      </tr>
	  </table>
	  <table border="0" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
      <tr>
        <td width="35" rowspan="2" style="border-bottom:0px #DDDDDD solid; padding-left:5px; padding-top:5px" valign="top" align="left">
		<img src="img/studyMenuIcon.jpg" width="20" /></td>
        <td height="25" style="font-weight:normal; font-family:Arial, Helvetica, sans-serif; font-size:18px; border-bottom:0px #DDDDDD solid; padding-left:5px">
		<a href="SchoolCourse.php" class="one">Course Board</a> <font color=#999999 style='font-weight:normal; font-size:12px'><?php echo("($course_comment_cnt)") ?></font>		</td>
      </tr>
      <tr>
        <td height="40" valign="top" style=" padding-bottom:5px; padding-right:50; line-height:130%; font-weight: ; border-bottom:0px #DDDDDD solid; padding-left:5px; font-size:11px; color:#999999">
		Course comments,  memoried questions. Subscribe courses </td>
      </tr>
	  </table>
	  <table border="0" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
        <tr>
          <td width="35" rowspan="2" style="border-bottom:0px #DDDDDD solid; padding-left:5px; padding-top:5px" valign="top" align="left">
		  <img src="img/interviewIcon.jpg" width="20" /></td>
          <td height="25" style="font-weight:normal; font-family:Arial, Helvetica, sans-serif; font-size:18px; border-bottom:0px #DDDDDD solid; padding-left:5px"><a href="interviewQuestions.php" class="one">Interview Book</a> <?php echo("<font color=#999999 style='font-size:12px; font-weight:normal'>($interview_cnt)</font>") ?></td>
        </tr>
        <tr>
          <td height="40" valign="top" style=" padding-bottom:5px; padding-right:50; line-height:130%; font-weight: ; border-bottom:0px #DDDDDD solid; padding-left:5px; font-size:11px; color:#999999"> Latest interview questions, discussion, and positions </td>
        </tr>
      </table>
	  <table border="0" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
      <tr>
        <td width="35" rowspan="2" style="border-bottom:0px #DDDDDD solid; padding-left:5px; padding-top:5px" valign="top" align="left">
		<img src="img/houseMenuIcon.jpg" width="20" /></td>
        <td height="25" style="font-size:18px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; border-bottom:0px #DDDDDD solid; padding-left:5px">
		<a href="HouseRental.php" class="one">House Rentals</a> <font color=#999999 style='font-weight:normal; font-size:12px'><?php echo("($house_cnt)") ?></font>		</td>
      </tr>
      <tr>
        <td height="40" valign="top" style=" padding-bottom:5px; padding-right:50; line-height:130%; font-weight: ; border-bottom:0px #DDDDDD solid; padding-left:5px; font-size:11px; color:#999999">
		Rent and lease house or aptartment,  find roommates</td>
      </tr>
	  </table>
	  <table border="0" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
      <tr>
        <td width="35" rowspan="2" style="border-bottom:0px #DDDDDD solid; padding-left:5px; padding-top:5px" valign="top" align="left">
		<img src="img/colorBuyIcon.jpg" width="20" /></td>
        <td height="25" style="font-weight:normal; font-family:Arial, Helvetica, sans-serif; font-size:18px; border-bottom:0px #DDDDDD solid; padding-left:5px">
		<a href="FleaMarket.php" class="one">Sales, Bargain </a> <font color=#999999 style='font-weight:normal; font-size:12px'><?php echo("($article_cnt)") ?></font></td>
      </tr>
      <tr>
        <td height="40" valign="top" style=" padding-bottom:5px; padding-right:50; padding-right:30; line-height:130%; font-weight: ; border-bottom:0px #DDDDDD solid; padding-left:5px; font-size:11px; color:#999999">
		Cheap, on sale. A  texbook?... Metro-card? Go check out</td>
      </tr>
	  </table>
	  <table border="0" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
      <tr>
        <td width="35" rowspan="2" style="border-bottom:0px #DDDDDD solid; padding-left:5px; padding-top:5px" valign="top" align="left">
		<img src="img/grayStar_66CCFF.jpg" width="20" /></td>
        <td height="25" style="font-weight: normal; font-size:18px; font-family:Arial, Helvetica, sans-serif; border-bottom:0px #DDDDDD solid; padding-left:5px">
		<a href="FriendGroup.php?myfriends=1" class="one">Friend</a>, <a href="FriendGroup.php" class="one">People</a> <?php echo("<font color=#999999 style='font-size:12px; font-weight:normal'>($people_cnt)</font>") ?></td>
      </tr>
      <tr>
        <td height="40" valign="top" style=" padding-bottom:5px; padding-right:50; line-height:130%; font-weight: ; border-bottom:0px #DDDDDD solid; padding-left:5px; font-size:11px; color:#999999">
		Same area, same hometown, same subject,  all to be found	</td>
      </tr>
	  </table>
	  
	  <script>
$(document).ready(function() { 
	$("#recordBoardDiv").hide();
	$("#recordRuleDiv").hide();
	$("#visitListDiv").hide();
	 
	$("div .whoVisitBtn").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#whoVisitBtn").hide();
	  $("#checkRuleBtn").hide();
	  $("#recordBoardBtn").hide();
	  $("#recordBoardDiv").hide();
	  $("#recordRuleDiv").hide();
	  $("#cancelVisitBtn").show();
	  $("#visitListDiv").show();
	});
	
	$("div .cancelVisitBtn").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#visitListDiv").hide();
	  $("#recordBoardDiv").hide();
	  $("#recordRuleDiv").hide();
	  $("#whoVisitBtn").show();
	  $("#checkRuleBtn").show();
	  $("#recordBoardBtn").show();
	});
	
	$("div .checkRuleBtn").click(function () {
      //$("#recordRuleDiv").slideDown("slide", { direction: "up" }, 3000);
	  $("#checkRuleBtn").hide();
	  $("#recordBoardDiv").hide();
	  $("#visitListDiv").hide();;
	  $("#whoVisitBtn").hide();
	  $("#recordBoardBtn").hide();
	  $("#recordRuleDiv").show();
	  $("#cancelRuleDiv").show();
	});

	$("div .cancelRuleDiv").click(function () {
      //$("#joinUsDiv").hide("slide", { direction: "up" }, 1000);
	  $("#recordRuleDiv").hide();
	  $("#visitListDiv").hide();
	  $("#recordBoardDiv").hide();
	  $("#whoVisitBtn").show();
	  $("#checkRuleBtn").show();
	  $("#recordBoardBtn").show();
	});
		
	$("div .recordBoardBtn").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#recordBoardBtn").hide();
	  $("#visitListDiv").hide();
	  $("#recordRuleDiv").hide();
	  $("#checkRuleBtn").hide();
	  $("#whoVisitBtn").hide();
	  $("#recordBoardDiv").show();
	});
	
	$("div .cancelRecordBtn").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#recordBoardDiv").hide();
	  $("#recordRuleDiv").hide();
	  $("#recordBoardBtn").show();
	  $("#checkRuleBtn").show();
	  $("#whoVisitBtn").show();
	});
});
</script>
	  
	 <br />

	   <div id="whoVisitBtn" class="whoVisitBtn" style="padding:5 0 0 5; background: url(img/GrayGradbgDown.jpg); border-bottom:0px solid #DDDDDD; border-top:1px solid #CCCCCC; font-size:12px; width:230px; font-family:Arial, Helvetica, sans-serif; cursor:pointer; margin-bottom:10" onmouseover="this.style.background='url(img/GrayGradbgDown120.jpg)'" onmouseout="this.style.background='url(img/GrayGradbgDown.jpg)'">
         <table width="230" border="0" cellpadding="0" cellspacing="0">
           <tr>
             <td valign="top" style="border-bottom:0px #DDDDDD solid; padding-top:5px; padding-bottom:10px; padding-left:15px; font-size:14px; color:#666666; font-weight:bold; font-family:Georgia, 'Times New Roman', Times, serif" align="left"><img src="img/guestIcon.png" width="13" />&nbsp;&nbsp;&nbsp;<em>Recent Visit</em></td>
           </tr>
         </table>
      </div>

	   <div id="recordBoardBtn" class="recordBoardBtn" style="padding:5 0 0 5; background: url(img/GrayGradbgDown.jpg); border-bottom:0px solid #DDDDDD; border-top:1px solid #CCCCCC; font-size:12px; width:230px; font-family:Arial, Helvetica, sans-serif; cursor:pointer; margin-bottom:10" onmouseover="this.style.background='url(img/GrayGradbgDown120.jpg)'" onmouseout="this.style.background='url(img/GrayGradbgDown.jpg)'">
	     <table width="230" border="0" cellpadding="0" cellspacing="0">
           <tr>
             <td valign="top" style="border-bottom:0px #DDDDDD solid; padding-top:5px; padding-bottom:10px; padding-left:15px; font-size:14px; color:#666666; font-weight:bold; font-family:Georgia, 'Times New Roman', Times, serif" align="left"><img src="img/diceIcon.png" width="13" />&nbsp;&nbsp;&nbsp;<em>How am I doing?</em></td>
           </tr>
         </table>
	   </div>
      <div id="checkRuleBtn" class="checkRuleBtn" style="height:; padding:5 0 0 5; background: url(img/GrayGradbgDown.jpg); border-bottom:0px solid #DDDDDD; border-top:1px solid #CCCCCC; font-size:12px; width:230px; font-family:Arial, Helvetica, sans-serif; cursor:pointer; margin-bottom:10; color:#FFFFFF" onmouseover="this.style.background='url(img/GrayGradbgDown120.jpg)'" onmouseout="this.style.background='url(img/GrayGradbgDown.jpg)'">
	  <table width="230" border="0" cellpadding="0" cellspacing="0">
           <tr>
             <td valign="top" style="border-bottom:0px #DDDDDD solid; padding-top:5px; padding-bottom:10px; padding-left:15px; font-size:14px; color:#666666; font-weight:bold; font-family:Georgia, 'Times New Roman', Times, serif" align="left"><img src="img/blackLineStar.png" width="13" />&nbsp;&nbsp;&nbsp;<em>I wanna Highlight</em></td>
           </tr>
         </table>
	  </div>
	  
      <div class="visitListDiv" id="visitListDiv" style="display:none; width:230px">
        <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" background="img/master.jpg" style="margin-bottom:10; border-bottom:1px solid #999999">
          <tr>
            <td width="191" align="left" valign="middle" style="padding-left:10; font-weight:normal; color:#000000; font-size:12px; ">
			Recent visitors
              <?php
			  $v = mysql_query("SELECT visitor, vtime, vdate, fname, lname FROM rockinus.visit_info a JOIN rockinus.user_info b ON a.host='$uname' AND b.uname=a.visitor ORDER BY a.vdate DESC, a.vtime DESC;");
				if(!$v) die(mysql_error());
				$no_row_v = mysql_num_rows($v);
				
			  $v_total = mysql_query("SELECT visitor, vtime, vdate FROM rockinus.visit_history WHERE host='$uname' ORDER BY vdate DESC, vtime DESC;");
				if(!$v_total) die(mysql_error());
				$no_row_v_total = mysql_num_rows($v_total);
				if($no_row_v < 10)
					echo("<font color=#666666>($no_row_v/$no_row_v)</font>");
				else
					echo("<font color=#666666>(10/$no_row_v)</font>");
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;<span id="cancelVisitBtn" class="cancelVisitBtn" style="cursor:pointer">
	  <img src="img/gray_arrow_up.png" width="14" /></span>
			</td>
            <td width="59" align="right" valign="middle" style="padding-right:5;"></td>
          </tr>
        </table>
        <?php
		if($no_row_v == 0) echo("<div style='padding-top:30px; padding-left:0px; margin-bottom:10px; font-size: 12px' align='center'><strong><img src='img/join.jpg'>&nbsp;&nbsp; Nobody visited yet...</strong></div>");
		$i = 0;
		while($objv = mysql_fetch_object($v)){
			$i++;
			$visitor = $objv->visitor;
			$vfname = $objv->fname;
			$vlname = $objv->lname;
			$vdate = $objv->vdate;
			$vtime = substr($objv->vtime,0,5);
			//$visitpic100 = $visitor.'100.jpg';
			$visit_pic = $visitor.'60.jpg';
			//date('Y-m-d, H:i');
			$target_visitor = "upload/".$visitor;

			if(is_dir($target_visitor)){
			?>
        <div style="margin-bottom:10; margin-left:5; width:230px">
          <table width="230" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
            <tr>
              <td align='center' style='border:0px solid #EEEEEE; padding:5px; background:url("<?php echo("upload/$visitor/$visit_pic?".time()); ?>"); background-repeat:no-repeat;' width="70" height="70"></td>
              <td style='border:0px solid #EEEEEE; padding:5px; padding-top:0; padding-left:5; line-height:170%; font-size:12px; ' valign="top" align="left" width="180"><a href="RockerDetail.php?uid=<?php echo($visitor) ?>" class="one" style="font-weight:bold; color:<?php echo($_SESSION['hcolor']) ?>"><?php echo($vfname." ".$vlname) ?></a><br />
                <?php 
				echo("<font style='font-size:11px'>Last visit: ".getDateName($vdate).", ".substr($vtime,0,5)."</font>");
				?>
				<a href="SendMessage.php?recipient=<?php echo($visitor) ?>">
				<div style="font-size:11px; font-weight:normal; width:70; height:20; border-right:1px #999999 solid; border-bottom:1px #999999 solid; background: url(img/master.png); color:#000000; padding:2 5 2 5; display:inline" align="center">Message</div>
				</a>
			  </td>
            </tr>
          </table>
        </div>
        <?php }else{ ?>
        <div style="margin-bottom:10; margin-left:10; width:230px" >
          <table width="230" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
            <tr>
              <td align='center' style='border:0px solid #EEEEEE; padding-bottom:0' width='70'><a href='RockerDetail.php?uid=$visitor' class="one" title='$visitor | $vdate, $vtime'><img src='img/NoUserIcon_fixed.jpg' width="60" style='margin-right:0px;' /></a></td>
              <td style='border:0px solid #EEEEEE; padding:5px; padding-top:0; padding-left:5; line-height:170%; font-size:12px; ' valign="top" align="left" width="180"><a href="RockerDetail.php?uid=<?php echo($visitor) ?>" class="one" style="font-weight:bold; color:<?php echo($_SESSION['hcolor']) ?>"><?php echo($vfname." ".$vlname) ?></a><br />
              <?php echo("Last visit: ".getDateName($vdate)."<br>".substr($vtime,0,5)) ?></td>
            </tr>
          </table>
        </div>
        <?php	}
			
			if($i==10)break;
		}
		?>
      </div>
      <div id="recordRuleDiv" class="recordRuleDiv" style="width:230px; display:">
        <table width="230" height="110" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #DDDDDD; margin-bottom:20">
          <tr>
            <td valign="top"><table width="230" height="25" border="0" cellpadding="0" cellspacing="0" background="img/master.jpg" style="margin-bottom:10; border-bottom:1px solid #999999">
                <tr>
                  <td align="left" valign="middle" style="padding-left:10; font-weight:normal; color:#000000; font-size:12px; ">
				  More points = Highlight!  
				  &nbsp;&nbsp;&nbsp;&nbsp;<span id="cancelRecordBtn" class="cancelRecordBtn" style="cursor:pointer">
	  <img src="img/gray_arrow_up.png" width="14" /></span></td>
                </tr>
              </table>
                <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Profile(&lt;50%, &gt;50%, &gt;85%)</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 2, 5, 10 </td>
                  </tr>
                </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10"> Have an head icon</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 15</td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10"> Head Icon Like</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 5</td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Friend</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 5 </td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Visited by others </td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 2 </td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:12px; ; padding-left:10">Interview Question </td>
                  <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 25 </td>
                </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:12px; ; padding-left:10">Interv. question solution </td>
                  <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 25 </td>
                </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Course comment</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 5 </td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Course Question</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 20 </td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Subscribed course</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 5 </td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Notice post</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 15 </td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">House post</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 15</td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Sale post</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 15 </td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Status post</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 5 </td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Message sent</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 5 </td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Login</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 2 </td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-top:10">
                  <tr>
                    <td style="font-size:11px; ; padding:10; line-height:140%; background-color:#EEEEEE">100 points for 1 star <br />
                      5 stars for 1 diamond<br />
                      Higher level means : <br />
                      Better&amp;Extra service, more exciting things </td>
                  </tr>
              </table></td>
          </tr>
        </table>
      </div>
      <div class="recordBoardDiv" id="recordBoardDiv" style="display:">
        <table width="230" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #DDDDDD; margin-bottom:20; margin-top:10">
          <tr>
            <td width="230"><table width="230" height="25" border="0" cellpadding="0" cellspacing="0" background="img/master.jpg" style="margin-bottom:10; border-bottom:1px solid #999999">
              <tr>
                <td width="191" align="left" valign="middle" style="padding-left:10; font-weight:normal; color:#000000; font-size:12px; ">Current score details&nbsp;&nbsp;&nbsp;&nbsp;<span id="cancelRuleDiv" class="cancelRuleDiv" style="cursor:pointer">
	  <img src="img/gray_arrow_up.png" width="14" /></span></td>
                <td width="59" align="right" valign="middle" style="padding-right:5;"></td>
              </tr>
            </table>
            <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10; font-family:Arial, Helvetica, sans-serif">Profile Completeness </td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($wid) ?>%</td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Head Icon </td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($total_headicon) ?></td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Friend number</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($total_friend) ?></td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Visited by others </td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($total_visit_user) ?></td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Visited times</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($total_visit_times) ?></td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:12px; ; padding-left:10">Interview questions</td>
                  <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($total_interview_question) ?></td>
                </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:12px; ; padding-left:10">Interv. question solutions </td>
                  <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($total_interview_question_follow) ?></td>
                </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Course comments</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($total_course_memo) ?></td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Course questions</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($total_course_question) ?></td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Subscribed courses</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($total_course_subs) ?></td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Notice posts</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($total_news) ?></td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">House posts</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($total_house) ?></td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Sale posts</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($total_article) ?></td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Status posts</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($total_memo) ?></td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Message sent</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($total_message) ?></td>
                  </tr>
              </table>
              <table width="230" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Login times</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo($total_login_times) ?></td>
                  </tr>
              </table>
              <table width="230" height="30" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="180" style="font-size:12px; ; padding-left:10">Current Total Points </td>
                    <td width="50" style="font-size:16px; ; font-weight:bold; color:<?php echo($_SESSION['hcolor']) ?>; padding-right:10; font-family:Arial, Helvetica, sans-serif; padding-top:5" align="right"><em><?php echo($total_point) ?></em></td>
                  </tr>
              </table></td>
          </tr>
        </table>
    </div></td>
  </tr>
</table>
</body>
</html>
