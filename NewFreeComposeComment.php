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

include("Allfuc.php"); 	

if (isset($_SESSION['usrname']))
		header("location:ThingsRock.php");
		
	if (isset($_COOKIE["user"]) && isset($_COOKIE["Login_Tag"])){
		$_SESSION['usrname'] = $_COOKIE["user"];
		header("location:ThingsRock.php");
	}
	
if(isset($_POST['openComment'])){
	$tag = 0;
	$nickname = addslashes($_POST['nickname']);
	$descrip = addslashes($_POST['descrip']);
	
	if( strlen($nickname)==0 || $nickname==NULL ){
		$nickname = "Visitor";
	} 
	
	if( ( $descrip==NULL || strlen($descrip)==0 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "No content for the post, please check";
	}
	
	if($tag==0){	
		include 'dbconnect.php'; 
		$sql = "INSERT INTO rockinus.open_comment_info (sender,descrip,pdate,ptime)VALUES('$nickname','$descrip',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$rst_msg = "Your comment has been submitted successfully!";
		//mysql_close($link);
		$_SESSION['rst_msg']="<div align='center' style='width=680; border:1 solid #DDDDDD; padding-top:20; padding-bottom:20; margin-bottom:20; background:#F5F5F5; margin-top:10'><strong><font size=3 color=$_SESSION[hcolor]>$rst_msg ^^</font></strong><br><br><font size=3><a href=NewFreeNewFreeCommentUs.php class=one>Go Back</a></font></div>"; 
	}else
	$_SESSION['rst_msg']="<div align='center' style='width=680; border:1 solid #DDDDDD; padding-top:20; padding-bottom:20; margin-bottom:20; background:#F5F5F5; margin-top:10'><strong><font size=3 color=#B92828><img src=img/stop.jpg width=18 height=18 />&nbsp;&nbsp;&nbsp;$rst_msg</font></strong><br><br><font size=3><a href=NewFreeComposeComment.php class=one>Go Back</a></font></div>"; 
}
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
            <div align="left" style=" width:230; margin-bottom:40; font-size:14px; font-weight:normal; font-family:Arial, Helvetica, sans-serif; line-height:150%; padding:0px; color:;">Rockinus is an open, free, school-based social network for students who study, wish to study, or graduated in Polytechnic Institute of NYU. You can post house rentals, sales, course comments, upload course files, look for jobs, etc. Also, it is an exciting place to find new friends, exchange topics with other students as well. We hope you enjoy this network :)</div>            <div style="font-size:14px"> <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 0px; display:inline; margin-bottom:5px; background: #FFFFFF; border:2 solid #666666; height:25;"><a href="NewFreeCommentUs.php" class="one"><a href="NewFreeAboutUs.php" class="one"><strong>About Us</strong></a></span> &nbsp; <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 00px; display:inline; margin-bottom:5px; background: #FFFFFF; border:2 solid #666666; height:25;"><a href="NewFreeCommentUs.php" class="one"><strong>Comments</strong></a></span></div></td>
            <td width="680" align="right" style="padding-top:20" valign="top">
			<?php 
	  if(isset($_SESSION['rst_msg'])){
		  echo $_SESSION['rst_msg'];
		  unset($_SESSION['rst_msg']); 
	}
	  ?>
			<div style="border:0px #DDDDDD solid; background-color:#F5F5F5">
              <table width="680" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:25px">
                <tr>
                  <td width="680" height="86" colspan="0" align="left"><div style="background: url(img/master.png); border-bottom:1 #CCCCCC solid; margin-bottom:0px; font-size:11px; height:30px">
                      <table width="680" height="30" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="235" align="left" style="background-color:; padding-left:15px; padding-right:10px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;"><a href="NewFreeNewFreeCommentUs.php" class="one"><strong>Comment Board</font></a>
                              <?php 
				  //Global Variable: 
$page_name = "NewFreeCommentUs.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
 
//**EDIT TO YOUR TABLE NAME, ETC.
$q = "SELECT count(*) as cnt FROM rockinus.open_comment_info WHERE 1=1 ORDER BY pdate,ptime DESC";
//echo("SELECT count(*) as cnt FROM rockinus.house_info WHERE $sel_cond ORDER BY pdate,ptime DESC");
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
//if ($total_items == 0 )echo("<strong>No post so far</strong>");

				  echo("<font size=2> ($total_items)</font>") ?>
                          </td>
                          <td width="555" align="right"></td>
                        </tr>
                      </table>
                  </div>
                      <form action="NewFreeComposeComment.php" method="post">
                        <table width="680" height="282" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:0px #DDDDDD solid; border-top:0px">
                          <tr>
                            <td width="110" height="35" style="padding-left:10px" align="right">&nbsp;</td>
                            <td width="570" height="35" style="padding-left:10px">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="80" style="padding-right:10px" align="right"><strong>Nick Name </strong></td>
                            <td height="80" style="padding-left:10px"><input type="text" name="nickname" size="25" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"/>
                              &nbsp;&nbsp;&nbsp;<font color="#999999" style="font-size:12px">(Or leave it as blank for anonymous)</font></td>
                          </tr>
                          <tr>
                            <td height="170" style="padding-right:10px; padding-top:10px" align="right" valign="top"><strong> </strong></td>
                            <td style="padding-left:10px; padding-top:10px" valign="top"><textarea name="descrip" style="width:500; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif" rows="12"></textarea>
                            </td>
                          </tr>
                          <tr>
                            <td height="50" style="padding-right:10px" align="right">&nbsp;</td>
                            <td style="padding-left:10px; padding-top:30; padding-bottom:30" valign="top"><input name="openComment" type="submit" class="btn2" value=" Submit " />
                            </td>
                          </tr>
                        </table>
                      </form></td>
                </tr>
              </table>
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
