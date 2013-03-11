<?php
session_start();
header("Content-Type: text/html; charset=gb2312");
include 'dbconnect.php';
if(isset($_SESSION['usrname'])){
$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$_SESSION['hcolor'] = $object->hcolor;
$_SESSION['lan'] = $object->lan;
$hcolor = $_SESSION['hcolor'];
$lan = $_SESSION['lan'];
	header("location:ThingsRock.php");
}
$uname = "Login";

$_SESSION['lan'] = "#336633";
?>
<LINK REL="SHORTCUT ICON" HREF="img/rockinTag.jpg">
<title>NYU-Poly's Local Social Network - Rockinus</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<style type="text/css">
.bg1 { background-color: #6c0000; }
.bg2 { background-color: #5A2A00; }
.bg3 { background-color: #00345B; }
ul.switchcolor {
	margin: 0;
	padding: 0;
	height: 33px;
	line-height: 33px;
	border:0px #CCCCCC dotted
}

ul.switchcolor a {
	text-decoration: none;
	color: #B82929;
	display: block;
	padding: 0 20px;
	outline: none;
}
ul a:hover {
	background:;
}	

html ul.tabs li.active, html ul.tabs li.active a:hover  {
	background: #09F;
	border-bottom: 0px solid #fff;
}

p { 
font-size:100%; cursor:pointer; }

.capfontClass {
	font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;
   color:  #999999;
}  

.capfontClass A {color: #666666; font-size: 9px;}
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<div id="othercontent" style="margin-bottom: 0px; margin-top: 0px; margin-left:0;" align="center">
<?php 
$q_user = mysql_query("SELECT * FROM rockinus.user_info;");
if(!$q_user) die(mysql_error());
$no_row_user = mysql_num_rows($q_user);

$q_house = mysql_query("SELECT * FROM rockinus.house_info WHERE rentlease='lease';");
if(!$q_house) die(mysql_error());
$no_row_house = mysql_num_rows($q_house);

$q_article = mysql_query("SELECT * FROM rockinus.article_info;");
if(!$q_article) die(mysql_error());
$no_row_article = mysql_num_rows($q_article);

$q_job = mysql_query("SELECT * FROM rockinus.job_info;");
if(!$q_job) die(mysql_error());
$no_row_job = mysql_num_rows($q_job);

$q_file = mysql_query("SELECT * FROM rockinus.user_file_info;");
if(!$q_file) die(mysql_error());
$no_row_file = mysql_num_rows($q_file);

$q_course_memo = mysql_query("SELECT * FROM rockinus.course_memo_info;");
if(!$q_course_memo) die(mysql_error());
$no_row_course_memo = mysql_num_rows($q_course_memo);

$q_friend = mysql_query("SELECT * FROM rockinus.rocker_rel_info;");
if(!$q_friend) die(mysql_error());
$no_row_friend = mysql_num_rows($q_friend);

$q_course = mysql_query("SELECT * FROM rockinus.unique_course_info;");
if(!$q_course) die(mysql_error());
$no_row_course = mysql_num_rows($q_course);

$q_major = mysql_query("SELECT * FROM rockinus.major_info;");
if(!$q_major) die(mysql_error());
$no_row_major = mysql_num_rows($q_major);
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>NYU-Poly's Local Social Network</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
span.error{
	font-size:14px;
	display:inline;
	color: #B92828;
}
-->
</style>
<link type="text/css" href="style/PasswordStyle.css" rel="stylesheet" />
<script type="text/javascript" src="js/mocha.js"></script>
<script src="autoSubmit.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
</head>
<body>
<?php 
	if(isset($_SESSION['uname']))$uname = $_SESSION['uname']; 
	if(isset($_SESSION['uname_tag'])) $uname_tag = $_SESSION['uname_tag']; else $uname_tag="";
	if(isset($_SESSION['rid'])) {$rid = $_SESSION['rid']; unset($_SESSION['rid']); }else $rid="";
?>
<div align="center">
<div style="padding-top:15; padding-bottom:15; margin-bottom:15px; width:100%; background:#336633; height:60; border-bottom:0 solid #666666;" align="center">
  <table width="1000" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
    <tr>
      <td width="683" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size:24px; color:#FFFFFF; padding-bottom:5; padding-left:5">
	   <a href="main.php">Welcome to NYU-Poly's Local Social Network</a></td>
      <td width="183" rowspan="2" align="right" bgcolor="" style="padding-right:0">
	  <a href="main.php"><div style="padding:15; padding-top: 10; padding-bottom:10; background:#FFFFFF; display:inline; height:10; font-size:20px; color:#333333; border:#CCCCCC 1 solid" onMouseOver="this.style.cursor='hand'; this.style.backgroundColor='#EEEEEE';" 
onmouseout="this.style.backgroundColor='#FFFFFF';"> + Home</div></a>
	  </td>
	</tr>
    <tr>
      <td style="font-family: Georgia, 'Times New Roman', Times, serif; font-size:14px; color:#999999; padding-bottom:0; padding-left:5" valign="top">
	  Apartment rental/lease, Flea Market, Course Info, Events around, Friends in school	  </td>
    </tr>
  </table>
  </div>
  <div style=" background-color:; border-top:0px #333333 solid; border-bottom:0px #666666 dashed; width:100%" class="IntroDiv" id="IntroDiv">
    <table width="1000" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="320" align="left" valign="top" style="padding-left:5; padding-bottom:10; padding-top:10; font-size:24px; font-weight:bold; color:">
			<img src="img/rockinus_new.jpg">
			<div style="font-size:20px; margin-top:40; margin-bottom:30">Introduction >></div>
            <div align="left" style=" width:230; margin-bottom:40; font-size:14px; font-weight:normal; font-family:Arial, Helvetica, sans-serif; line-height:150%; padding:0px; color:;">Rockinus is an open, free, school-based social network for students who study, wish to study, or graduated in Polytechnic Institute of NYU. You can post house rentals, sales, course comments, upload course files, look for jobs, etc. Also, it is an exciting place to find new friends, exchange topics with other students as well. We hope you enjoy this network :)</div>            <div style="font-size:14px"> <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 0px; display:inline; margin-bottom:5px; background: #FFFFFF; border:2px solid #666666; height:25;"><a href="commentUs.php" class="one"><a href="NewFreeAboutUs.php" class="one"><strong>About Us</strong></a></span> &nbsp; <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 0px; display:inline; margin-bottom:5px; background: #FFFFFF; border:2px solid #666666; height:25;"><a href="NewFreeCommentUs.php" class="one"><strong>Comments</strong></a></span></div></td>
            <td width="680" align="left" valign="top">
			<div style="padding:25; margin-top:20; line-height:200%; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:13px; border:12px solid #DDDDDD;" >
			<p style="margin-bottom:30"><strong><font size="3">Who We Are,</font></strong></p>
                <p>The network is volunteered, built by NYU-Poly Computer Science students. Currently the team consists one formal member for overall development, implementation and in-time updates. The original idea of this network is based on builder's real life experience in NYU-Poly. Meanwhile, after observing and researching a lot among other Polyers, this work has eventually been invented. Great thanks for earlier effort by Ethan Wang, Tian Liang and others as well. Without your inspirations and hard working, this site would not go this far.
			<p style="margin-bottom:30; margin-top:30">
			<a href="NewFreeUser.php?uid=harvey"><img src="img/Aziz_AboutUs.jpg" width="150"></a>&nbsp;&nbsp;&nbsp;
			<a href="NewFreeUser.php?uid=yuchen"><img src="img/Ethan_AboutUs.jpg" width="150"></a>&nbsp;&nbsp;&nbsp;
			<a href="NewFreeUser.php?uid=liangtian"><img src="img/LiangTian_AboutUs.jpg" width="150"></a>
			<p style="margin-bottom:30"><strong><font size="3">Growing History,</font></strong></p>
                <table width="620" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="155" height="25" style="color:#000000; font-weight:normal; font-family:Verdana, Arial, Helvetica, sans-serif">Jun. 2011</td>
    <td width="465" height="25"> Rockinus idea was conceived, after a spring semester's end</td>
  </tr>
  <tr>
    <td height="25" style="color:#000000; font-weight:normal; font-family:Verdana, Arial, Helvetica, sans-serif">Nov. 2011</td>
    <td height="25">Conceptions and ideas were first drafted in tech paper</td>
  </tr>
  <tr>
    <td height="25" style="color:#000000; font-weight:normal; font-family:Verdana, Arial, Helvetica, sans-serif">Dec. 2011</td>
    <td height="25">Development work started, only 1 student was involved</td>
  </tr>
  <tr>
    <td height="25" style="color:#000000; font-weight:normal; font-family:Verdana, Arial, Helvetica, sans-serif">Mar. 2012</td>
    <td height="25">Ethan Wang was involved, developed codes and helped desigining</td>
  </tr>
  <tr>
    <td height="25" style="color:#000000; font-weight:normal; font-family:Verdana, Arial, Helvetica, sans-serif">May. 2012</td>
    <td height="25">Development was interrupted for a month due to final exams</td>
  </tr>
  <tr>
    <td height="25" style="color:#000000; font-weight:normal; font-family:Verdana, Arial, Helvetica, sans-serif">Jun. 2012</td>
    <td height="25"> Work resumed, only 1 student worked, in evening after internship</td>
  </tr>
  <tr>
    <td height="25" style="color:#000000; font-weight:normal; font-family:Verdana, Arial, Helvetica, sans-serif">Aug. 2012</td>
    <td height="25">Full time on Network development, by 1 student</td>
  </tr>
  <tr>
    <td height="25" style="color:#B92828; font-weight:normal; font-family:Verdana, Arial, Helvetica, sans-serif">31th Aug. 2012</td>
    <td height="25">Official publish date. Advertisement, marketing will follow up</td>
  </tr>
</table>
			<p style="margin-bottom:30">
				<p style="margin-bottom: 30">
				<strong><font size="3">A Letter to Young Homies,</font></strong>
                
                <p>Under the thunder and storm, there is a place like home that keeps us  warm and cool.
                Before coming to university study in United States, many of us, with a simple American dream  shaped in our minds.The unknown tomorrow,  full of doubtness, thorns, estranged environments with a whole lost, all putting together baffled our march again and again. We stay alert, know that we are  young, and we keep replenishing ourselves, do what we can. Those different desires in our studies, work, lives combined with all tricky situations had determined us a disparate one. We sometimes may have been deviated. Today, standing at the point, just keep rocking to summit, cause this time would be more enjoyable and expecting.
                Rockinus dedicates your study and social life in many aspects, boosting your life as much as it could. </p>
                <p>We look forward to see your days turning great,  being considered more carefully, and that is exactly why we are here. As said, you only live once, but if you do it right, once is enough. Do, rock in U.S. </p>
                <br>
                  <p style="margin-top:30px">
                  <div style="margin-left:300px; margin-bottom:30px; display:inline"><strong>Rockinus Team | In God's Country </strong></div>
				  <div style="margin-left:300px; margin-bottom:0px; display:inline">
				  <a href='http://akkking.blogbus.com' class="one">
				  <strong><font color="#336633" style="font-size:12px"> Check More @ Builder's Blog </font></strong>
				  </a></div>
				  </p>
			  </div>
			</td>
          </tr>
    </table>
  </div>
  
  <br>
<br>
<?php include("bottomMenuEN_login.php"); ?>
</div>
</body>
</html>
