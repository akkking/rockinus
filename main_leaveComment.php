<?php
session_start();
include 'dbconnect.php';
include("Allfuc.php"); 	
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

if(isset($_POST['openComment'])){
	$tag = 0;
	$nickname = addslashes($_POST['nickname']);
	$descrip = addslashes($_POST['descrip']);
	
	if( strlen($nickname)==0 || $nickname==NULL ){
		$nickname = "Visitor";
	} 
	
	if( ( $descrip==NULL || strlen($descrip)==0 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "No content for the post?";
	}
	
	if($tag==0){	
		include 'dbconnect.php'; 
		$sql = "INSERT INTO rockinus.open_comment_info (sender,descrip,pdate,ptime)VALUES('$nickname','$descrip',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$rst_msg = "Your comment has been submitted successfully!";
		//mysql_close($link);
		$_SESSION['rst_msg']="<div align='center' style='width:720; border:1 solid #DDDDDD; padding-top:20; padding-bottom:20; margin-bottom:20; background:#F5F5F5; margin-top:10'><strong><font size=3 color=$_SESSION[hcolor]>$rst_msg ^^</font></strong><br><br><font size=3><a href=main_comment.php class=one>Go Back</a></font></div>"; 
	}else
	$_SESSION['rst_msg']="<div align='left' style='width:720; border:0 solid #DDDDDD; padding-top:5; padding-bottom:5; margin-bottom:10; background:#F5F5F5; margin-top:10'><strong><font size=3 color=#B92828>&nbsp;<img src=img/stop.jpg width=18 height=18 />&nbsp;&nbsp;&nbsp;$rst_msg</font></strong></font></div>"; 
}
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
font-size:100%; cursor:pointer; line-height: 300% }

.capfontClass {
	font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;
   color:  #999999;
}  

.capfontClass A {color: #666666; font-size: 9px;}
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<div id="othercontent" style="margin-bottom: 0px; margin-top: 0px; margin-left:0;" align="center">
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
</head>
<body>
<?php 
	if(isset($_SESSION['uname']))$uname = $_SESSION['uname']; 
	if(isset($_SESSION['uname_tag'])) $uname_tag = $_SESSION['uname_tag']; else $uname_tag="";
	if(isset($_SESSION['rid'])) {$rid = $_SESSION['rid']; unset($_SESSION['rid']); }else $rid="";
?>
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
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main_leaveComment.php" class="one">Comment</a></td>
          <td width="40" style="font-size:12px; font-family:Arial, Helvetica, sans-serif, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
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
    <td width="706" align="right" valign="top" style="padding-top:10">
	<?php 
	  if(isset($_SESSION['rst_msg'])){
		  echo $_SESSION['rst_msg'];
		  unset($_SESSION['rst_msg']); 
	}
	  ?>
	<div style="border:0px #DDDDDD solid; background-color:; margin-top:-30px" align="right">
      <table width="680" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:25px">
        <tr>
          <td width="720" height="86" colspan="0" align="right">
		  <div style="">
              <table width="650" height="35" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
                <tr>
                  <td width="235" align="left" style=" font-weight:bold; background-color:; padding-left:15px; padding-right:10px; font-family: Arial, Helvetica, sans-serif; font-size:14px; color:#FFFFFF" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;">Comment Board
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
              <form action="main_leaveComment.php" method="post">
                <table width="650" height="300" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:1px #DDDDDD solid; border-top:0px; background-color:">
                  <tr>
                    <td height="25" align="right" style="padding-right:10px">&nbsp;</td>
                    <td height="25" style="padding-left:10px">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="138" height="30" align="right" style="padding-right:10px">Your  name</td>
                    <td width="510" height="30" style="padding-left:10px"><input type="text" name="nickname" size="25" style="font-size:14px; font-family: Arial, Helvetica, sans-serif"/>
                      &nbsp;&nbsp;&nbsp;<font color="#999999" style="font-size:11px">(Or leave blank for anonymous)</font></td>
                  </tr>
                  <tr>
                    <td height="170" style="padding-right:10px; padding-top:15px" align="right" valign="top">Say something</td>
                    <td style="padding-left:10px; padding-top:15" valign="top"><textarea name="descrip" style="width:400; font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif" rows="12"></textarea>                    </td>
                  </tr>
                  <tr>
                    <td height="50" style="padding-right:10px" align="right">&nbsp;</td>
                    <td style="padding-left:10px; padding-top:20; padding-bottom:40" valign="top">
					<input name="openComment" type="submit" style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:0px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif" value=" Submit " />                    </td>
                  </tr>
                </table>
              </form></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>

  </div>
  
  <div class="loginDiv" id="loginDiv"></div>
<br>
<br>
<?php include("bottomMenuEN_login.php"); ?>
</div>
</body>
</html>
