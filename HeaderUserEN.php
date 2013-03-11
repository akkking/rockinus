<?php 
$uname = $_SESSION['usrname'];
$ua=getBrowser();

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$_SESSION['hcolor'] = $object->hcolor;
$_SESSION['lan'] = $object->lan;
$hcolor = $_SESSION['hcolor'];
$lan = $_SESSION['lan'];

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

if(isset($_POST['lan'])){
	$lan = htmlspecialchars(trim($_POST['lan']));
	$_SESSION['lan'] = $lan;
	include("dbconnect.php");
	$setLan = "UPDATE rockinus.user_setting SET lan='$lan' WHERE uname='$uname'";
    mysql_query($setLan) or die(mysql_error());
	//header("location:ThingsRock.php");
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<LINK REL="SHORTCUT ICON" HREF="img/rockinTag.jpg">
<title><?php echo($uname) ?>, welcome home</title>
<script type="text/javascript" src="js/ScrollTableHeader103.min.js"></script>
<script type="text/javascript" src="dropdownTop.js"></script>
<script type="text/javascript" src="dropdown.js"></script>
<script type="text/javascript" src="CheckAll.js"></script>
<script type="text/javascript" src="birthday.js"></script>
<script language="JavaScript" src="js/curvycorners.src.js"></script>
<link href="calendar.css" rel="stylesheet">
<link rel="stylesheet" href="style/HeaderRequest.css" />
<script src="calendar.js"></script>
<script language="javascript" type="text/javascript">
function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}

function clearContents(element) { 
  element.value = ''; 
} 

function select_all()
{
var text_val=eval("document.MemoPost.limitedtextarea");
text_val.focus();
text_val.select();
}
</script>
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
<style type="text/css">
#search {
    color: #fff;
	height:23px;
    text-align: center;
	background-color:#F5F5F5;
	padding-right:3px;
	padding-left:3px;
	width: <?php if(contains("Internet",$ua['name']))echo("275"); else echo("240"); ?>;
	font-size:15px;
}

#stickyheader{
	background-color:<?php echo($_SESSION['hcolor']) ?>;
	border-bottom:1px #000000 solid;
	width: 100%;                        
	height: 35px;
}                
#stickyalias {
	display: none;
	height: 10px;
}
#unstickyheader {
	margin-bottom: 15px;
}

#othercontent {
	margin-top: 20px;
}  
</style>
<script type="text/JavaScript">
  curvyCorners.addEvent(window, 'load', initCorners);
  function initCorners() {
    var settings = {
      tl: { radius: 5 },
      tr: { radius: 5 },
      bl: { radius: 5 },
      br: { radius: 5 },
      antiAlias: true
    }
	curvyCorners(settings, "#search");
}
</script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="JavaScript" src="js/overlib.js"></script>
<script type="text/javascript">
$(document).ready(function () {
	$('#nav li').hover(
		function () {
			//show its submenu
			$('ul', this).slideDown(100);

		}, 
		function () {
			//hide its submenu
			$('ul', this).slideUp(100);			
		}
	);
	
});
</script>
</head>
<body>
<div align="center" style="background-color:">
<div style="width:100%; background-color:<?php echo($_SESSION['hcolor']) ?>">
  <table width="1024" height="35" border="0" cellpadding="0" cellspacing="0" bgcolor=<?PHP echo($_SESSION['hcolor']) ?>>
	<tr>
      <td width="85" valign="top" align="left" style="padding-top:5px; padding-left:15px">
	  <div style="background:#F5F5F5; border:1px #EEEEEE solid; display:inline; padding:5px; padding-top:1px; padding-bottom:1px; height:20px; font-size:12px; font-weight:bold">
          <a href="#" class="one" onClick="return overlib('<div style=\'border:1px #666666 solid; padding:0px\'><table style=border:1px #999999 solid; font-color:#999999><tr><td bgcolor=#336633 width=\'25\' height=\'25\' style=padding:5px align=center><a href=\'changeColor.php?hcolor=336633\'>^_^</a></td><td bgcolor=#444444 width=\'25\' height=\'15\' style=padding:5px align=center><a href=\'changeColor.php?hcolor=444444\'>^_^</a></td><td bgcolor=#172B5E width=\'25\' height=\'25\' style=padding:5px align=center><a href=\'changeColor.php?hcolor=172B5E\'>^_^</a></td><td bgcolor=#993300 width=\'25\' height=\'25\' style=padding:5px align=center><a href=\'changeColor.php?hcolor=993300\'>^_^</a></td><td bgcolor=#006633 width=\'25\' height=\'25\' style=padding:5px align=center><a href=\'changeColor.php?hcolor=006633\'>^_^</a></td><td bgcolor=#663366 width=\'25\' height=\'25\' style=padding:5px align=center><a href=\'changeColor.php?hcolor=663366\'>^_^</a></td><td bgcolor=#006699 width=\'25\' height=\'25\' style=padding:5px align=center><a href=\'changeColor.php?hcolor=006699\'>^_^</a></td></tr></table></div>', OFFSETX, -45, OFFSETY, 15, CAPTION, '<div style=\'border:0px #666666 solid; padding:4px; padding-left: 5px; font-size:12px; color:#000000 \'>Select Color</div>', CLOSEFONTCLASS, 'capfontClass', FGCOLOR, '#DDDDDD', BGCOLOR, '#DDDDDD', BORDER, 5, CAPTIONFONT, 'Garamond', TEXTFONT, 'Courier', TEXTSIZE, 2, WIDTH, 150, STICKY, CLOSECOLOR, '#999999', CLOSECLICK);" > <font color="#000000">Skin Color</font></a>	    </div>	  </td>
      <td width="281" valign="top" align="left" style="padding-top:5px; padding-left:0">
	  <div style="background:#F5F5F5; border:1px #EEEEEE solid; display:inline; padding:5px; padding-top:1px; padding-bottom:1px; height:20px; font-size:12px; font-weight:bold">
          <a href="EditUserInfo.php" class="one">+ Edit Profile</a></div>
	  </td>
      <td width="432" align="right" valign="top" style="padding-left:10px; padding-top:3px">
	  <ul id="nav">
	<li><a href="" class="one">Request (<?php echo($cnt_total_rqst) ?>)</a>
		<ul style="margin-left:-1px">
			<li style="padding-left:5px"><a href="FriendGroup.php?friendreq=1">Friend (<?php echo($cnt_friend_rqst) ?>)</a></li>
			<li style="padding-left:5px"><a href="fileRequestList.php">Files (<?php echo($cnt_file_rqst) ?>)</a></li>
		</ul>
		<div class="clear"></div>
	</li>
	<li><a href="MessageList.php" class="one">Message (<?php echo($cnt_unread_msg) ?>)</a></li>
	<li><a href="RockerDetail.php" class="one">Answers (<?php $sel_count = "
	SELECT sum(total) as cnt FROM (
		SELECT count(*) as total FROM rockinus.house_comment WHERE hid in (SELECT hid FROM rockinus.house_info WHERE uname='$uname') AND rstatus = 'N' AND sender<>'$uname'
		UNION 
		SELECT count(*) as total FROM rockinus.article_comment WHERE aid in (SELECT aid FROM rockinus.article_info WHERE uname='$uname') AND rstatus = 'N' AND sender<>'$uname' 
		UNION 
		SELECT count(*) as total FROM rockinus.forum_history WHERE foid in (SELECT foid FROM rockinus.forum_info WHERE creater='$uname') AND rstatus = 'N'
	) as cnt";

	$t = mysql_query($sel_count);
	if(!$t) die("Error quering the Database: " . mysql_error());

	$a = mysql_fetch_object($t);
	$replied_cnt = $a->cnt;
	echo($replied_cnt) ?>)</a>		
		<div class="clear"></div>
	</li>
</ul>
<div class="clear"></div>	  </td>
      <td width="226" align="right" valign="top" style="padding-right:15px; font-size:14px; padding-top:10px">
	  <?php 
		$uname = $_SESSION['usrname']; 
 		if($_SESSION['usrname']=="")echo("Login");
		else echo "<font color=#DDDDDD><strong>I'm <a href=RockerDetail.php?uid=".$uname." class=>$uname</a></strong></font>";
	?>	</td>
    </tr>
  </table>
  </div>
  <table width="1024" height="73" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
	<td width="242" valign="top" style="padding-top:10">
	<a href="ThingsRock.php"><img src="img/rockinus.jpg"></a>
	</td>
      <td width="557" height="54" align="right" valign="middle" bgcolor="#FFFFFF" style="padding-right:0px; padding-bottom:3px; border-bottom:0px #EEEEEE solid; font-size:12px; font-weight:bold "><form action="searchme.php" id="searchmeform" method="post">
          <input type="hidden" name="pressed_button" id="pressed_button" value="false">
          <input type="text" name="searchfield" style="background: #F5F5F5; border:1px solid #CCCCCC; height: 1.5em;line-height: 1.5em;" size="30">
        &nbsp;&nbsp;&nbsp;&nbsp;
          <input type="button" name="search" value="Search" onClick="document.getElementById('pressed_button').value='true';document.getElementById('searchmeform').submit();" style="background-image: url(img/black_cell_bg.jpg); border:1px #000000 solid; height:21px; font-weight: normal; margin-top:1; padding-top: 1px; padding-bottom:1px; color:#FFFFFF; font-size:12px">
      </form></td>
      <td width="225" height="54" align="right" valign="top" style="padding-right:15px; padding-top:10px; font-size:12px"><a href="logoff.php" class="one"><img src="img/LogOffIcon.jpg"> Log Out</a> </td>
    </tr>
    <tr>
      <td height="18" colspan="2" align="right" valign="middle">&nbsp;</td>
    </tr>
  </table>
</div>
<div id="stickyalias"></div>
<div id="othercontent" style="margin-bottom: 0px; margin-top: 0px; margin-left:0; background:url(<?php if(isset($_SESSION['topi']))echo("img/".$_SESSION['topi'].".jpg")?>);" align="center">
</body>
</html>
