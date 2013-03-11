<?php 
$uname = $_SESSION['usrname'];
$ua=getBrowser();
//header("Content-Type: text/html; charset=gb2312");
include 'dbconnect.php';

$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$_SESSION['hcolor'] = $object->hcolor;
$_SESSION['lan'] = $object->lan;
$hcolor = $_SESSION['hcolor'];
$lan = $_SESSION['lan'];

$q_uinfo = mysql_query("SELECT fname FROM rockinus.user_info where uname='$uname'");
if(!$q_uinfo) die(mysql_error());
$object_uinfo = mysql_fetch_object($q_uinfo);
$uname_fname = $object_uinfo->fname;
if($uname_fname==NULL || strlen(trim($uname_fname))==0) $uname_fname=$uname;

$t = mysql_query("
SELECT count(1) AS `cnt` 
FROM (SELECT sender FROM rockinus.message_info WHERE recipient='$uname'
      UNION ALL 
      SELECT sender FROM rockinus.message_history WHERE recipient='$uname') AS `t` 
");
if(!$t)	die("Error quering the Database: " . mysql_error());
$a = mysql_fetch_object($t);
$cnt_msg = $a->cnt;

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
	SELECT count(*) as total FROM rockinus.memo_follow_info WHERE recipient='$uname' AND rstatus = 'N' GROUP BY memoid
	UNION 
	SELECT count(*) as total FROM rockinus.headicon_like WHERE headicon_id IN (SELECT headicon_id FROM rockinus.headicon_history WHERE uname='$uname') AND rstatus = 'N'
) as cnt";

$t = mysql_query($reply_sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());

$a = mysql_fetch_object($t);
$replied_cnt = $a->cnt;

if(isset($_POST['lan'])){
	$lan = htmlspecialchars(trim($_POST['lan']));
	$_SESSION['lan'] = $lan;
	include("dbconnect.php");
	$setLan = "UPDATE rockinus.user_setting SET lan='$lan' WHERE uname='$uname'";
    mysql_query($setLan) or die(mysql_error());
	//header("location:ThingsRock.php");
}
?>
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
</style>
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
<div align="center" style="background-color:; margin-bottom:0">
  <table width="760" height="32" border="0" cellpadding="0" cellspacing="0" style="background:url(img/<?php echo(substr($_SESSION['hcolor'],1,6)."_MenuBar.jpg") ?>)">
    <tr>
      <td width="95" height="33" align="right" valign="middle" style="padding-right:0px; border-bottom:0px #EEEEEE solid; font-size:12px; font-weight:bold ">
<script type="text/javascript">
$(document).ready(function(){
  $('img.setting').hover(function () { 
      this.src = 'img/settingIconDarkGray.jpg'; 
    }, function () { 
        this.src = 'img/settingIconGray.jpg'; 
	}); 
	
	$('img.myhistory').hover(function () { 
      this.src = 'img/myhistoryIconDark.jpg'; 
    }, function () { 
        this.src = 'img/myhistoryIcon.jpg'; 
	}); 
	
	$('img.mycourse').hover(function () { 
      this.src = 'img/myCourseIconDark.jpg'; 
    }, function () { 
        this.src = 'img/myCourseIcon.jpg'; 
	}); 
}); 
</script>
	  <a href="UserSetting.php" class="one">
	  <span style="background:#F5F5F5; border:1px #EEEEEE solid; display:inline; padding:5px; padding-top:1px; padding-bottom:1px; height:20px; font-size:12px; font-weight:bold" align="center">My Settings</span></a>	  </td>
      <td width="210" align="left" valign="middle" style="padding-left:10px; border-bottom:0px #EEEEEE solid; font-size:12px; font-weight:bold ">
	  <div style="background:#F5F5F5; border:1px #EEEEEE solid; display:inline; padding:5px; padding-top:1px; padding-bottom:1px; height:20px; font-size:12px; font-weight:bold"> <a href="#" class="one" onClick="return overlib('&lt;div style=\'border:1px #666666 solid; padding:0px\'&gt;&lt;table style=border:1px #999999 solid; font-color:#999999&gt;&lt;tr&gt;&lt;td bgcolor=#387A36 width=\'25\' height=\'25\' style=padding:5px align=center&gt;&lt;a href=\'changeColor.php?hcolor=387A36\'&gt;^_^&lt;/a&gt;&lt;/td&gt;&lt;td bgcolor=#444444 width=\'25\' height=\'15\' style=padding:5px align=center&gt;&lt;a href=\'changeColor.php?hcolor=444444\'&gt;^_^&lt;/a&gt;&lt;/td&gt;&lt;td bgcolor=#2E4174 width=\'25\' height=\'25\' style=padding:5px align=center&gt;&lt;a href=\'changeColor.php?hcolor=2E4174\'&gt;^_^&lt;/a&gt;&lt;/td&gt;&lt;td bgcolor=#ED1C25 width=\'25\' height=\'25\' style=padding:5px align=center&gt;&lt;a href=\'changeColor.php?hcolor=ED1C25\'&gt;^_^&lt;/a&gt;&lt;/td&gt;&lt;td bgcolor=#7AC142 width=\'25\' height=\'25\' style=padding:5px align=center&gt;&lt;a href=\'changeColor.php?hcolor=7AC142\'&gt;^_^&lt;/a&gt;&lt;/td&gt;&lt;td bgcolor=#57068C width=\'25\' height=\'25\' style=padding:5px align=center&gt;&lt;a href=\'changeColor.php?hcolor=57068C\'&gt;^_^&lt;/a&gt;&lt;/td&gt;&lt;td bgcolor=#006699 width=\'25\' height=\'25\' style=padding:5px align=center&gt;&lt;a href=\'changeColor.php?hcolor=006699\'&gt;^_^&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;&lt;/div&gt;', OFFSETX, -45, OFFSETY, 15, CAPTION, '&lt;div style=\'border:0px #666666 solid; padding:4px; padding-left: 5px; font-size:12px; color:#000000 \'&gt;Select Color&lt;/div&gt;', CLOSEFONTCLASS, 'capfontClass', FGCOLOR, '#DDDDDD', BGCOLOR, '#DDDDDD', BORDER, 5, CAPTIONFONT, 'Garamond', TEXTFONT, 'Courier', TEXTSIZE, 2, WIDTH, 150, STICKY, CLOSECOLOR, '#999999', CLOSECLICK);" > <font color="#000000">More Skins</font></a> </div></td>
      <td width="361" align="right" valign="middle" bgcolor="" style="padding-right:0px; border-bottom:0px #EEEEEE solid; font-size:12px; font-weight:bold;">
	  <form action="searchme.php" id="searchmeform" name="searchmeform" method="post">
          <input type="hidden" name="pressed_button" id="pressed_button" value="false">
          <input type="text" name="searchfield" id="searchfield" style="background: #F5F5F5; font-size:13px; font-family:Arial, Helvetica, sans-serif;border:1px solid #CCCCCC; height: 1.5em;line-height: 1.5em; height:22" size="40">
        &nbsp;&nbsp;
          <input type="button" name="search" value="Search" onClick="var search_val=document.searchmeform.searchfield.value; if(search_val==''){alert('Please input something to search...'); return false;} ; document.getElementById('pressed_button').value='true';document.getElementById('searchmeform').submit();" style="background-image: url(img/black_cell_bg.jpg); border:1px #333333 solid; height:23; font-weight: bold; width:55; padding:1 5 2 5; color:#FFFFFF; font-size:11px; font-family:Arial, Helvetica, sans-serif; cursor:pointer ">
      </form></td>
      <td width="94" height="33" align="right" valign="top" style="padding-right:15px; padding-top:10px; font-size:12px"><a href="logoff.php" class=""><img src="img/lock.png" width="13"> &nbsp;Log Out</a> </td>
    </tr>
  </table>
</div>
</body>
</html>
