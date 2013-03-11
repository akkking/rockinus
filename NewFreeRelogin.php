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
font-size:100%; cursor:pointer; line-height: 300% }

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
            <div align="left" style=" width:230; margin-bottom:40; font-size:14px; font-weight:normal; font-family:Arial, Helvetica, sans-serif; line-height:150%; padding:0px; color:;">Rockinus is an open, free, school-based social network for students who study, wish to study, or graduated in Polytechnic Institute of NYU. You can post house rentals, sales, course comments, upload course files, look for jobs, etc. Also, it is an exciting place to find new friends, exchange topics with other students as well. We hope you enjoy this network :)</div>            <div style="font-size:14px"> <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 0px; display:inline; margin-bottom:5px; background: #FFFFFF; border:2 solid #666666; height:25;"><a href="commentUs.php" class="one"><a href="NewFreeAboutUs.php" class="one"><strong>About Us</strong></a></span> &nbsp; <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 00px; display:inline; margin-bottom:5px; background: #FFFFFF; border:2 solid #666666; height:25;"><a href="commentUs.php" class="one"><strong>Comments</strong></a></span></div></td>
            <td width="680" align="right" style="padding-top:20" valign="top"><table width="680" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="margin-bottom:15px">
              <tr>
                <td align="center" bgcolor="#F5F5F5" style="border-top:1px #999999 dashed">
				<?php 
	if(isset($_SESSION['rst_msg'])){
		echo($_SESSION['rst_msg']);
		unset($_SESSION['rst_msg']);
	}
?>
                    <form action="login_process.php" method="post">
                      <div style="margin-top: 10">
                        <div align="center" style="background-color: #FFFFFF; opacity:0.9; filter:alpha(opacity=85); padding-top: 50px; padding-bottom: 20px; margin-top:70px; margin-bottom:70px; padding-left: 10px; padding-right:10px; border:12px #DDDDDD solid; width:450;">
                          <table width="400" height="270" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="145" height="30" align="right" style="padding-right:15px"><strong><font size="3">Username</font></strong></td>
                              <td width="255" height="30"><input type="text" style="height:22px" name="usrname" class="box" size="22"></td>
                            </tr>
                            <tr>
                              <td width="145" height="30" align="right" style="padding-right:15px"><strong><font size="3">Password</font></strong></td>
                              <td width="255" height="30"><input type="password" style="height:22px"  name="passwd" size="22" class="box">
                              </td>
                            </tr>
                            <tr>
                              <td width="145" height="35" align="right" style="padding-right:15px"><input type="checkbox" name="checkbox" value="checkbox">
                              </td>
                              <td width="255" height="35">Keep me logged in </td>
                            </tr>
                            <tr>
                              <td width="145" height="35">&nbsp;</td>
                              <td width="255" height="35"><input type="submit" name="Submit" value=" Sign In " class="btn">
                              </td>
                            </tr>
                            <tr>
                              <td width="145" height="80">&nbsp;</td>
                              <td width="255" height="80" valign="top" style="padding-top:10px"><a href="findPassword.php" class="one">Forget Password? </a>
                                  <p style="margin-bottom:25px">
                                  <div align="center" style="padding-top:5px; padding-bottom:5px; padding-left:8px; padding-right:8px; margin-top: 10px; display:inline; margin-bottom:0px; background-color: #B92828; border-bottom:1 solid #000000; border-right:1 solid #000000"><a href="joinUs.php"><strong>&nbsp;Sign Up&nbsp;</strong></a></div>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </form></td>
              </tr>
            </table></td>
          </tr>
    </table>
  </div>
<br>
<?php include("bottomMenuEN_login.php"); ?>
</div>
</body>
</html>
