<?php
session_start();
include 'dbconnect.php';
header("Content-Type: text/html; charset=gb2312");
if(isset($_SESSION['usrname'])){
	$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
	if(!$q1) die(mysql_error());
	$object = mysql_fetch_object($q1);
	$_SESSION['hcolor'] = $object->hcolor;
	$_SESSION['lan'] = $object->lan;
	$hcolor = $_SESSION['hcolor'];
	$lan = $_SESSION['lan'];

	$pageName = "ThingsRock.php";
	$q_basic = mysql_query("SELECT * FROM rockinus.user_basic_setting where uname='$loopName'");
	if(!$q_basic) die(mysql_error());
	$object_basic = mysql_fetch_object($q_basic);
	$directPage = $object_basic->directPage;
	if($directPage=="H")$pageName= "ThingsRock.php";
	else if($directPage=="P")$pageName= "RockerDetail.php?uid=$loopName";
	header("location:$pageName");
}

$uname = "Login";

$_SESSION['lan'] = "#336633";
?>
<LINK REL="SHORTCUT ICON" HREF="img/rockinTag.png">
<title>New York Community Network</title>
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
font-size:100%; line-height: 300% }

.capfontClass {
	font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;
   color:  #999999;
}  

.capfontClass A {color: #666666; font-size: 9px;}
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
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
font-size:100%; line-height:180%; font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif; }

.capfontClass {
	font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;
   color:  #999999;
}  

.capfontClass A {color: #666666; font-size: 9px;}
</style>
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
<div align="center">
<?php include("main_header.php") ?>
  <div class="dailyUpdateDiv" id="dailyUpdateDiv" style="margin-top:10">
  <table width="1024" height="450" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="250" valign="top" align="left" style="border-right:0px dashed #CCCCCC">
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main.php" class="one">Home</a></td>
          <td width="40" style="font-size:12px; font-family:Arial, Helvetica, sans-serif, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main_workforus.php" class="one">Work for Us</a></td>
          <td width="40" style="font-size:12px; font-family:Arial, Helvetica, sans-serif, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main_leaveComment.php" class="one">Comment</a></td>
          <td width="40" style="font-size:12px; font-family:Arial, Helvetica, sans-serif, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main_aboutUs.php" class="one">About Us</a></td>
          <td width="40" style="font-size:12px; font-family:Arial, Helvetica, sans-serif, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="150" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px solid #DDDDDD">
        <tr>
          <td valign="bottom">&nbsp;</td>
        </tr>
      </table></td>
    <td width="68">&nbsp;</td>
    <td width="720" valign="top">
	<div style="border:16px solid #F5F5F5; margin-top:-50;">
	<div style="padding:25; line-height:150%; font-family:Arial, Helvetica, sans-serif, sans-serif; font-size:13px; border:1px solid #DDDDDD; background:#FFF">
      <p style="margin-bottom:30"><strong><font size="3">Who We Are,</font></strong></p>
      <p>This network is volunteered, built by NYU-Poly Computer Science students. Currently the team consists one formal member for overall development, implementation and in-time updates. The original idea of this network is based on builder's real life experience in NYU-Poly. Meanwhile, after observing and researching a lot among other Polyers, this work has eventually been invented. Great thanks for earlier effort by Ethan Wang, Tian Liang and others as well. Without your inspirations and hard working, the site would not go this far.
      <p style="margin-bottom:30; margin-top:30"> <img src="img/Aziz_AboutUs.jpg" width="150" alt="Aziz Igam">&nbsp;&nbsp;&nbsp; <img src="img/Ethan_AboutUs.jpg" width="150" alt="Yuchen Wang">&nbsp;&nbsp;&nbsp; <img src="img/LiangTian_AboutUs.jpg" width="150" alt="Tian Liang">
            <p style="margin-bottom:30"><strong><font size="3">Growing History,</font></strong></p>
      <table width="620" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="155" height="25" style="color:#000000; font-weight:normal; font-family:Arial, Helvetica, sans-serif, sans-serif">Jun. 2011</td>
                  <td width="465" height="25"> Rockinus idea was conceived, after a spring semester's end</td>
                </tr>
                <tr>
                  <td height="25" style="color:#000000; font-weight:normal; font-family:Arial, Helvetica, sans-serif, sans-serif">Nov. 2011</td>
                  <td height="25">Conceptions and ideas were first drafted in tech paper</td>
                </tr>
                <tr>
                  <td height="25" style="color:#000000; font-weight:normal; font-family:Arial, Helvetica, sans-serif, sans-serif">Dec. 2011</td>
                  <td height="25">Development work started, only 1 student was involved</td>
                </tr>
                <tr>
                  <td height="25" style="color:#000000; font-weight:normal; font-family:Arial, Helvetica, sans-serif, sans-serif">Mar. 2012</td>
                  <td height="25">Ethan Wang was involved, developed codes and helped desigining</td>
                </tr>
                <tr>
                  <td height="25" style="color:#000000; font-weight:normal; font-family:Arial, Helvetica, sans-serif, sans-serif">May. 2012</td>
                  <td height="25">Development was interrupted for a month due to final exams</td>
                </tr>
                <tr>
                  <td height="25" style="color:#000000; font-weight:normal; font-family:Arial, Helvetica, sans-serif, sans-serif">Jun. 2012</td>
                  <td height="25"> Work resumed, only 1 student worked, in evening after internship</td>
                </tr>
                <tr>
                  <td height="25" style="color:#000000; font-weight:normal; font-family:Arial, Helvetica, sans-serif, sans-serif">Aug. 2012</td>
                  <td height="25">Full time on Network development, by 1 student</td>
                </tr>
                <tr>
                  <td height="25" style="color:#B92828; font-weight:normal; font-family:Arial, Helvetica, sans-serif, sans-serif"><span class="STYLE6">31th Aug. 2012</span></td>
                  <td height="25">Planed release date. Advertisement, marketing will follow up</td>
                </tr>
                <tr>
                  <td height="25" style="color:#B92828; font-weight:normal; font-family:Arial, Helvetica, sans-serif, sans-serif">30th Sept. 2012</td>
                  <td height="25">Postpone to this date to release, due to unsuccessful testing result </td>
                </tr>
              </table>
      <p style="margin-bottom:30">
            <p style="margin-bottom: 30"> <strong><font size="3">Short writing to new  people,</font></strong>
            <p>Under the thunder and storm, there is a place like home that keeps us  warm and cool.
                Before coming to university study in United States, many of us, with a simple American dream  shaped in our minds.The unknown tomorrow,  full of doubtness, thorns, estranged environments with a whole lost, all putting together baffled our march again and again. We stay alert, know that we are  young, and we keep replenishing ourselves, do what we can. Those different desires in our studies, work, lives combined with all tricky situations had determined us a disparate one. We sometimes may have been deviated. Today, standing at the point, just keep rocking to summit, cause this time would be more enjoyable and expecting.
                Rockinus dedicates your study and social life in many aspects, boosting your life as much as it could. </p>
      <p>We look forward to see your days turning great,  being considered more carefully, and that is exactly why we are here. As said, you only live once, but if you do it right, once is enough. Do, rock in U.S. </p>
      <br>
              <p style="margin-top:30px">
              <div style="margin-left:300px; margin-bottom:30px; display:inline"><strong>Rockinus Team | In God's Country </strong></div>
              <div style="margin-left:300px; margin-bottom:0px; display:inline"> <a href='http://akkking.blogbus.com' class="one"> <strong><font color="#336633" style="font-size:12px"> Check More @ Builder's Blog </font></strong> </a></div>
              </p>
    </div>
	</div></td>
  </tr>
</table>

  </div>

<br>
<br>
<?php include("bottomMenuEN_login.php"); ?>
</div>
</body>
</html>
