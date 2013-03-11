<?php
session_start();
include 'dbconnect.php';
//header("Content-Type: text/html; charset=utf-8");
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
	background-color:#336633;
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

$q_news = mysql_query("SELECT * FROM rockinus.news_info;");
if(!$q_news) die(mysql_error());
$no_row_news = mysql_num_rows($q_news);

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
<script>
$(document).ready(function() {
	$("#dailyupdate").load("FreeDailyUpdate.php");
	$("#dailyUserupdate").load("FreeDailyUserUpdate.php");
	var refreshId = setInterval(function() {
		$("#dailyupdate").load('FreeDailyUpdate.php?randval='+ Math.random());
		$("#dailyUserupdate").load('FreeDailyUserUpdate.php?randval='+ Math.random());
	}, 2000);
   $.ajaxSetup({ cache: false });
});
</script>
</head>
<body bgcolor="#336633">
<?php 
	if(isset($_SESSION['uname']))$uname = $_SESSION['uname']; 
	if(isset($_SESSION['uname_tag'])) $uname_tag = $_SESSION['uname_tag']; else $uname_tag="";
	if(isset($_SESSION['rid'])) {$rid = $_SESSION['rid']; unset($_SESSION['rid']); }else $rid="";
?>
<div align="center" style="background-color:">
<?php include("main_header_.php") ?>
  <div class="dailyUpdateDiv" id="dailyUpdateDiv" style="margin-top:10; background-color:">
  <table width="1024" height="450" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="720" align="left" valign="top" style="border-right:0px dashed #CCCCCC"><div class="joinUsDiv" id="joinUsDiv" style="display: " >
      <form action="joinUs_process.php" method="post" name="infoForm">
        <table width="700" height="450" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="margin-top:10; margin-bottom:10; border:0px #EEEEEE solid">
          <tr>
            <td height="100" colspan="2" align="left" valign="middle" style=" font-weight:normal; font-family: Arial, Helvetica, sans-serif; padding-left:40; color:#333333; font-size:36px; line-height:100%"> Join Us today, You Rock!</td>
          </tr>
          <tr>
            <td width="170" height="35" align="right" valign="middle" style="padding-right:7; color:; font-size:14px; font-family: Verdana, Arial, Helvetica, sans-serif"><strong>Login Name</strong></td>
            <td width="528" height="35" valign="middle" style="padding-left:10"><input name="uname" type="text" id="username" class="unif_input" maxlength="30" size="25" style="font-size:14px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif; padding:2; height:25; background-color:#F5F5F5" value="<?php if(isset($_SESSION['join_uname'])){echo($_SESSION['join_uname']); unset($_SESSION['join_uname']);}?>">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img id="tick" src="img/tick.png" width="16" height="16"/><img id="cross" src="img/cross.png" width="16" height="16" style="margin-right:5px"/>
              <div id="uname_err" style="display:inline"></div></td>
          </tr>
          <tr>
            <td width="170" height="35" align="right" valign="middle" style="padding-right:7; font-size:14px; font-family: Verdana, Arial, Helvetica, sans-serif"><strong>First Name</strong></td>
            <td width="528" height="35" valign="middle" style="padding-left:10"><input name="fname" type="text" id="fname" class="unif_input" maxlength="30" size="25" style="font-size:14px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif; padding:2; height:25" value="<?php if(isset($_SESSION['fname'])){echo($_SESSION['fname']); unset($_SESSION['fname']);}?>">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="fname_err" style="display:none; margin-right:10px"></span><span style="color:#999999; font-size:12px; font-family: Verdana, Arial, Helvetica, sans-serif">(At least 3 letters)</span> </td>
          </tr>
          <tr>
            <td width="170" height="35" align="right" valign="middle" style="padding-right:7; font-size:14px; font-family: Verdana, Arial, Helvetica, sans-serif"><strong>Last Name</strong></td>
            <td width="528" height="35" valign="middle" style="padding-left:10"><input name="lname" type="text" id="lname" class="unif_input" maxlength="30" size="25" style="font-size:14px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif; padding:2; height:25" value="<?php if(isset($_SESSION['lname'])){echo($_SESSION['lname']); unset($_SESSION['lname']);}?>">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="lname_err" style="display:none; margin-right:10px"></span><span style="color:#999999; font-size:12px; font-family: Verdana, Arial, Helvetica, sans-serif">(At least 3 letters)</span></td>
          </tr>
          <tr >
            <td height="35" align="right" style="padding-right:7; font-size:14px; font-family: Verdana, Arial, Helvetica, sans-serif"><strong>School Email</strong></td>
            <td height="35" style="padding-left:10"><input name="email" type="text" id="emailJoinUs" class="unif_input" size="25" style="font-size:14px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif; padding:2; height:25" value="<?php if(isset($_SESSION['email'])){echo($_SESSION['email']); unset($_SESSION['email']);}?>">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id="tick_email" src="img/tick.png" width="16" height="16" style="margin-right:10px"/><img id="cross_email" src="img/cross.png" width="16" height="16" style="margin-right:10px"/><span id="email_err" class="email_err" style="display:none; margin-right:10px"></span><span style="color:#999999; font-size:12px; font-family: Verdana, Arial, Helvetica, sans-serif">(Can be used for login)</span></td>
          </tr>
          <tr >
            <td height="35" align="right" style="padding-right:7; font-size:14px; font-family: Verdana, Arial, Helvetica, sans-serif"><strong>Create Password</strong></td>
            <td height="35"  style="padding-left:10"><input name="passwd" type="password" class="unif_input" id="inputPassword" size="25" style="font-size:14px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif; padding:2; height:25">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="passwd_err" style="display:none; margin-right:10px"></span><span id="complexity" class="default"></span>          </tr>
          <tr >
            <td height="35" align="right" style="padding-right:7; font-size:14px; font-family: Verdana, Arial, Helvetica, sans-serif"><strong>I'm </strong></td>
            <td height="35"  style="padding-left:10; "><select name="gender" id="genderJoinUs" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px">
                <option value="">Select gender</option>
                <option value="Female" <?php if(isset($_SESSION['gender'])&&$_SESSION['gender']=="Female"){echo("selected"); unset($_SESSION['gender']);}?>>Female</option>
                <option value="Male" <?php if(isset($_SESSION['gender'])&&$_SESSION['gender']=="Male"){echo("selected"); unset($_SESSION['gender']); }?>>Male</option>
            </select></td>
          </tr>
          <tr>
            <td height="50" align="right" style="padding-right:7; font-size:14px"><strong></strong></td>
            <td height="50"  style="padding-left:10"><font color="#333333" style="font-size:12px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif">Click sumbit means you have read and agree with the <br>
                <a href="main_agreement.php" class="one" target="_blank"><font color="#336633">User Agreement</font></a></font> </td>
          </tr>
          <tr bgcolor="">
            <td height="90">&nbsp;</td>
            <td height="90" valign="top" style="padding-left:10px; padding-top:20px"><input name="Submit2" type="submit" class="btn2" id="submitJoinUs" value="Submit">
            </td>
          </tr>
        </table>
      </form>
    </div></td>
    <td width="304" align="right" valign="top" style="padding-top:10"><div class="dailyUserupdate" id="dailyUserupdate">
      <?php include("FreeDailyUserUpdate.php")?>
    </div></td>
  </tr>
</table>
  </div>
<?php include("bottomMenuEN_login_.php"); ?>
</div>
</body>
</html>
