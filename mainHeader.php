<?php
include 'ValidCheck.php';

$unameImg = "upload/$uname/$uname"."60.jpg";
$unameImg55 = "upload/$uname/$uname"."55.jpg";
if(file_exists($unameImg))
	$unameImg = "<div style='background:url($unameImg); background-repeat: no-repeat; width:55; height:60; border:0px solid #DDDDDD'></div>"; 
else
	$unameImg = "<div style='background:url(img/NoUserIcon100.jpg); background-repeat: no-repeat; width:70; height:115'></div>";
?>
<LINK REL="SHORTCUT ICON" HREF="img/rockinTag.png">
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
function off(elem){
	elem.className='overborder';
}
function on(elem){
	elem.className='outborder';
}
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

<style type="text/css">
td#subMenu{
  font-size:13px; 
  font-weight:bold; 
  font-family: Verdana, Arial, Helvetica, sans-serif;
  color: <?php echo($_SESSION['hcolor'])?>; 
  background:url(img/GrayGradbgDown120.jpg); 
  border-right:1px solid #EEEEEE; 
  border-bottom:3px solid #999999;
  cursor: pointer
}

td#littleMenu{
	color:#FFFFFF; 
	padding-right:10px; 
	font-size:13px;
	cursor:pointer;
}

td#littleMenu:hover{
	color:#EEEEEE; 
	padding-right:10px; 
	font-size:13px;
	cursor:pointer;
}

.outborder {
	border-bottom:4px solid #EEEEEE; padding-bottom:5px; display:inline
}
.overborder {
	border-bottom:4px solid #FF9966; padding-bottom:5px; display:inline; cursor:pointer
}
.outborder:hover {
    border: 1px solid blue; cursor:pointer
}

body{
	font-family: Geneva, Arial, Helvetica, sans-serif;
	background-attachment: fixed; background-position:fixed; 
}
</style>

<style type="text/css">
ul {
  font-family: Arial, Verdana;
  font-size: 14px;
  margin: 0;
  padding: 0;
  list-style: none;
}
ul li {
  display: block;
  position: relative;
  float: left;
}
li ul { display: none; }
ul li a {
  display: block;
  text-decoration: none;
  color: #ffffff;
  border-top: 1px solid #ffffff;
  padding: 5px 16px 5px 16px;
  background: <?php echo($_SESSION['hcolor']) ?>;
  margin-left: 1px;
  white-space: nowrap;
}

ul li .abc {
  display: block;
  text-decoration: none;
  color: #ffffff;
  border-top: 1px solid #ffffff;
  padding: 5px 15px 5px 15px;
  background: <?php echo($_SESSION['hcolor']) ?>;
  margin-left: 1px;
  white-space: nowrap;
}
ul li:hover { background: #95A9B1; }
ul li a:hover { background: #617F8A; }
li:hover ul {
  display: block;
  position: absolute;
}
li:hover li {
  float: none;
  font-size: 13px;
}
li:hover a { background: #617F8A; }
li:hover li a:hover { background: #95A9B1; }
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome Home - New York Community Network</title>
</head>

<?php
include("Allfuc.php");
include 'dbconnect.php';
//$uname="akkking";

$uid = $uname;

if(isset($_POST['colorSetting'])){
	if(isset($_POST['hcolor']))$hcolor=$_POST['hcolor'];
	
	$setColor  = "UPDATE rockinus.user_setting SET hcolor='$hcolor' WHERE uname='$uname'";
    mysql_query($setColor) or die(mysql_error());
}

$q_c = mysql_query("SELECT * FROM rockinus.user_setting WHERE uname='$uname';");
if(!$q_c) die(mysql_error());
$object_c = mysql_fetch_object($q_c);
$hcolor = $object_c->hcolor;

$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$_SESSION['hcolor'] = $object->hcolor;
$_SESSION['lan'] = $object->lan;
$hcolor = $_SESSION['hcolor'];
$lan = $_SESSION['lan'];

$q_uinfo = mysql_query("SELECT fname,lname FROM rockinus.user_info where uname='$uname'");
if(!$q_uinfo) die(mysql_error());
$object_uinfo = mysql_fetch_object($q_uinfo);
$uname_fname = $object_uinfo->fname;
$uname_lname = $object_uinfo->lname;
if($uname_fname==NULL || strlen(trim($uname_fname))==0) $uname_fname=$uname;

$q = "SELECT count(*) as cnt FROM rockinus.message_info where recipient='$uname'";
$t = mysql_query($q);
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

$friend = mysql_query("SELECT count(*) as cnt FROM rockinus.rocker_rel_info WHERE sender='$uname' OR recipient='$uname'");
if(!$friend)	die("Error quering the Database: " . mysql_error());
$friend_f = mysql_fetch_object($friend);
$friend_cnt = $friend_f->cnt;
$total_unfriend = $people_cnt-$friend_cnt;

$t = mysql_query("
SELECT count(1) AS `cnt` 
FROM (SELECT sender FROM rockinus.message_info WHERE recipient='$uname' AND rstatus='N'
      UNION ALL 
      SELECT sender FROM rockinus.message_history WHERE recipient='$uname' AND rstatus='N') AS `t` 
");
if(!$t)	die("Error quering the Database: " . mysql_error());
$a = mysql_fetch_object($t);
$cnt_unread_msg = $a->cnt;

$u = mysql_query("SELECT count(*) as cnt FROM rockinus.rocker_rel_history WHERE recipient='$uname' AND rstatus='P'");
if(!$u)	die("Error quering the Database: " . mysql_error());
$b = mysql_fetch_object($u);
$cnt_friend_rqst = $b->cnt;

$u = mysql_query("SELECT count(*) as cnt FROM rockinus.user_request_file WHERE file_id IN (SELECT file_id FROM rockinus.user_file_info WHERE owner='$uname' AND rstatus='P')");
if(!$u)	die("Error quering the Database: " . mysql_error());
$b = mysql_fetch_object($u);
$cnt_file_rqst = $b->cnt;

$cnt_total_rqst = $cnt_file_rqst + $cnt_friend_rqst;

$reply_sel_count = "
SELECT sum(total) as cnt FROM (
	SELECT count(*) as total FROM rockinus.house_comment WHERE hid in (SELECT hid FROM rockinus.house_info WHERE uname='$uname') AND rstatus = 'N' AND sender<>'$uname'
	UNION 
	SELECT count(*) as total FROM rockinus.article_comment WHERE aid IN (SELECT aid FROM rockinus.article_info WHERE uname='$uname') AND rstatus = 'N' AND sender<>'$uname' 
	UNION 
	SELECT count(*) as total FROM rockinus.interview_question_follow WHERE q_id IN (SELECT q_id FROM rockinus.interview_question WHERE creater='$uname') AND rstatus = 'N' AND uname<>'$uname' 
	UNION 
	SELECT count(*) as total FROM rockinus.memo_follow_info WHERE recipient='$uname' AND rstatus = 'N' AND memoid IN (SELECT memoid FROM rockinus.memo_info WHERE sender='$uname')
	UNION 
	SELECT count(*) as total FROM rockinus.headicon_like WHERE headicon_id IN (SELECT headicon_id FROM rockinus.headicon_history WHERE uname='$uname') AND rstatus = 'N'
) as cnt";

$t = mysql_query($reply_sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());

$a = mysql_fetch_object($t);
$replied_cnt = $a->cnt;

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

<body background="img/grayBg.jpg" topmargin="0" leftmargin="0" rightmargin="0">
<div style="width:100%; background:#FFFFFF; height:100px; padding-bottom:5px; padding-top:5px" align="center">
<div style="width:1024px; top:0; background:#FFFFFF" align="left">
<table cellpadding="0" cellspacing="0" border="0" width="1024" style="margin-top:5px; margin-bottom:0px">
<tr>
<td width="146" valign="top" style="padding-top:5px">
<a href="ThingsRock.php">
<img src="img/rockinus_home_<?php echo(substr($hcolor,1,6).".jpg") ?>" /></a></td>
<td style="padding-right:15px; padding-bottom:10px" align="right" valign="bottom" width="338">
<?php
if($uname=='kiran' || $uname=='akkking'){
?>
<a href="systemNoticeList.php">
<img src="img/manageSiteIcon.jpg" width="140"></a>
<?php
}
?></td>
<td width="540"><table width="540" height="90" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" style="font-size:18px; padding-bottom:20px; font-weight:bold; font-family:Georgia, 'Times New Roman', Times, serif" valign="bottom">
	<div style="padding-bottom:5px; font-size:16px; color:#CCCCCC">
	<img src="img/interviewIcon.jpg" width="20" />&nbsp;&nbsp;<?php echo($interview_cnt_) ?>	</div>
	<a href="interviewQuestions.php" class="two">
	<div class="outborder" onMouseOver="off(this)" onMouseOut="on(this)">Job.Interview</div>
	</a>	</td>
    <td align="center" style="font-size:18px; padding-bottom:20px; font-weight:bold; font-family:Georgia, 'Times New Roman', Times, serif" valign="bottom">
	<div style="padding-bottom:5px; font-size:16px; color:#CCCCCC">
	<img src="img/BlackBoard.png" width="20" />&nbsp;&nbsp;<?php echo($interview_cnt_) ?>	</div>
	<a href="SchoolCourse.php" class="two">
	<div onMouseOver="off(this)" onMouseOut="on(this)" class="outborder">Course.Test</div>
	</a>	</td>
    <td align="center" style="font-size:18px; padding-bottom:20px; font-weight:bold; font-family:Georgia, 'Times New Roman', Times, serif" valign="bottom">
	<div style="padding-bottom:5px; font-size:16px; color:#CCCCCC">
	<img src="img/saleRoundIcon.jpg" width="20" />&nbsp;&nbsp;	</div>
	<a href="HouseRental.php" class="two">
	<div onMouseOver="off(this)" onMouseOut="on(this)" class="outborder">Rent.Sales</div>
	</a>	</td>
    <td align="center" style="font-size:18px; padding-bottom:20px; font-weight:bold; font-family:Georgia, 'Times New Roman', Times, serif" valign="bottom">
	<div style="padding-bottom:5px; font-size:16px; color:#CCCCCC">
	<img src="img/littleChatIcon.jpg" width="20" />&nbsp;&nbsp;<?php echo($interview_cnt_) ?>	</div>
	<a href="FriendGroup.php" class="two">
	<div onMouseOver="off(this)" onMouseOut="on(this)" class="outborder">Alumnus</div>
	</a>	</td>
  </tr>
</table></td>
</tr>
</table>
</div>

<div style="width:100%; margin-top:5px; background: url(img/GrayGradbgDown.jpg); border-bottom:1px dashed #CCCCCC; border-top:1px dashed #CCCCCC; height:50px" align="center">
  <table width="1024" height="50" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="279" height="50" align="left" style="font-size:13px; color:#333333"> 
	  Hello, <a href="RockerDetail.php?uid=<?php echo($uname) ?>" class="one"><?php echo($uname_fname." ".$uname_lname) ?></a>&nbsp;&nbsp;&nbsp;[&nbsp;<a href="logoff.php" class="one" style="color:<?php echo($_SESSION['hcolor']);?>">Log Out</a>&nbsp;]</td>
      <td width="362" height="50" align="left" style="font-size:13px; color:#CCCCCC"><table width="300" height="50" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="95" align="center" id="" onMouseOver="this.style.background='url(img/blackBg.jpg)'" onMouseOut="this.style.background='url(img/GrayGradbgDown.jpg)'"><?php
		if($cnt_friend_rqst>0) 
			echo("<a href='FriendGroup.php?friendreq=1' class='two'><img src='img/friends_group.png' width='22' /> <span style='font-size:11px; font-weight:bold; background:#B92828;color:#FFFFFF; padding: 1px 3px 1px 3px'>$cnt_friend_rqst</span></a>");
		else
			echo("<a href='FriendGroup.php?myfriends=1' class='two'><img src='img/friends_group.png' width='22' /></a>"); 
		?>          </td>
          <td align="center" id="" onMouseOver="this.style.background='url(img/blackBg.jpg)'" onMouseOut="this.style.background='url(img/GrayGradbgDown.jpg)'" width="95"><a href="MessageList.php" class="two">
            <?php
		if($cnt_unread_msg>0) 
			echo "<img src='img/yellowMessage.png' width='22' /> <span style='font-size:11px; font-weight:bold; background:#B92828;color:#FFFFFF; padding: 1px 3px 1px 3px'>$cnt_unread_msg</span>";
		else
			echo "<img src='img/yellowMessage.png' width='22' />";
		php ?>
          </a> </td>
          <td width="95" align="center" id="" onMouseOver="this.style.background='url(img/blackBg.jpg)'" onMouseOut="this.style.background='url(img/GrayGradbgDown.jpg)'"><a href="EditUserInfo.php" class="two" style="font-size:12px; font-weight:bold"> <img src='img/recent.png' width='22' /> </a> </td>
          <td width="95" align="center" id="" onMouseOver="this.style.background='url(img/blackBg.jpg)'" onMouseOut="this.style.background='url(img/GrayGradbgDown.jpg)'"><a href="VisitorRock.php" class="two" style="font-size:12px; font-weight:bold"> <img src='img/profile.png' width='20' /> </a> </td>
        </tr>
      </table></td>
      <td width="383" height="50" align="right" id="littleMenu" style="vertical-align:middle">
	  <!--
	Search Div Starts
	-->
	<div>
	<form action="searchme.php" id="searchmeform" name="searchmeform" method="post">
          <input type="hidden" name="pressed_button" id="pressed_button" value="false">
          <input type="text" name="searchfield" id="searchfield" style="background: #FFFFFF; font-size:14px; font-family:Arial, Helvetica, sans-serif;border:1px solid #CCCCCC; padding:2px; height: 1.7em; line-height: 1.7em;" size="40">
        &nbsp;<input type="button" name="search" value="Search" onClick="var search_val=document.searchmeform.searchfield.value; if(search_val==''){alert('Please input something to search...'); return false;} ; document.getElementById('pressed_button').value='true';document.getElementById('searchmeform').submit();" style="background-image: url(img/<?php echo(substr($_SESSION['hcolor'],1,6)) ?>_MenuBar.jpg); border:1px #333333 solid; height:1.7em; line-height: 1.7em; font-weight: ; width:65px; padding:0 5 5 5; color:#DDDDDD; font-size:14px; font-family:Arial, Helvetica, sans-serif; cursor:pointer;  -moz-border-radius: 3px; border-radius: 3px;">
      </form>
	  </div>
  	  <!--
	Search Div Ends
	-->	  </td> </tr>
  </table>
</div>

