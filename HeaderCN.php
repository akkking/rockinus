<?php 
$uname = $_SESSION['usrname'];

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$_SESSION['hcolor'] = $object->hcolor;
$_SESSION['lan'] = $object->lan;
$hcolor = $_SESSION['hcolor'];
$lan = $_SESSION['lan'];

$t = mysql_query("SELECT count(*) as cnt FROM rockinus.message_info WHERE recipient='$uname' AND rstatus='N'");
if(!$t)	die("Error quering the Database: " . mysql_error());
$a = mysql_fetch_object($t);
$cnt_unread_msg = $a->cnt;

$u = mysql_query("SELECT count(*) as cnt FROM rockinus.rocker_rel_history WHERE recipient='$uname' AND rstatus='P'");
if(!$u)	die("Error quering the Database: " . mysql_error());
$b = mysql_fetch_object($u);
$cnt_friend_rqst = $b->cnt;

if(isset($_POST['lan'])){
	$lan = htmlspecialchars(trim($_POST['lan']));
	$_SESSION['lan'] = $lan;
	include("dbconnect.php");
	$setLan = "UPDATE rockinus.user_setting SET lan='$lan' WHERE uname='$uname'";
    mysql_query($setLan) or die(mysql_error());
	//header("location:ThingsRock.php");
}
?>
<html>
<head>
<title>Rock In U.S.</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<script type="text/javascript" src="dropdownTop.js"></script>
<script type="text/javascript" src="dropdown.js"></script>
<script type="text/javascript" src="CheckAll.js"></script>
<script type="text/javascript" src="birthday.js"></script>
<link href="calendar.css" rel="stylesheet">
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
<link rel="stylesheet" href="dropdownTop.css" type="text/css" />
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
p { font-size:100%; cursor:pointer; line-height: 300% }  
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body>
<div class="head_title" align="center" style="background:<?php echo($hcolor) ?>; padding-top:2px; padding-bottom:2px; border-bottom:#000000 solid 1; border-top:#000000 solid 1; margin-top: 0" >
    <table width="1024" border="0" cellpadding="0" cellspacing="0" height="16">
      <tr>
        <td width="359" align="left" valign="middle" style="padding-left:15px"><font color="#999999"><strong>
		<a href="ThingsRock.php">首页</a>&nbsp;&nbsp;| &nbsp;&nbsp;<a href="HouseRental.php">房屋</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="FleaMarket.php">二手</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="SchoolCourse.php">课程</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="FriendGroup.php">同学</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="foodCafe.php">美食</a>
		</strong>
		</font>		</td>
        <td width="85" valign="middle" align="left">
		<form action="Header.php" id="switch_lan" name="switch_lan" method="post">
          <select name="lan" class="box" onChange="document.switch_lan.submit()" style="background-color:#F5F5F5">
            <option value="EN">English</option>
            <option value="CN" selected="selected">中文简体</option>
          </select>
        </form>		</td>
        <td width="114" valign="middle" align="left"><form action="/" id="changecolor">
          <ul class="switchcolor">
            <strong><a href="#" class="one"> <font color="#CCCCCC" size="2">换个肤色</font></a></strong>
          </ul>
          <input type="hidden" name="uname" id="uname2" class="uname" value=<?php echo($uname) ?>>
          <input type="hidden" name="hcolor" id="hcolor" class="hcolor">
          <script type="text/javascript">
//On Click Event
$("ul.switchcolor a").click(function() {
	var colors = ["#336633","#333333","#663399","#B82929","#003366","#993366","#990033","#006699","#996633"];  
	var rand = Math.floor(Math.random()*colors.length);  
	$("div.head_title").css("background",colors[rand]);
	//$("td.topi").css("background",colors[rand]);
	$("div.head_title").show().fadeOut(200);
	$("div.head_title").fadeIn("normal");
	$("dt.dt").css("background",colors[rand]);
	$("ul.houserental").css("background",colors[rand]);
	$("#csk").css("color",colors[rand]);
	$("#tsk").css("color",colors[rand]);
	var color = colors[rand];
	$.post(
		'ajax.php',
		{
			uname:$("#uname").val(),
			hcolor:color
		}
	)
	//if(color!="#336633")$.post("changecolor.php",{color:color});
});
        </script>
        </form>		</td>
        <td width="65" valign="middle" align="left" style="padding-left:10px">
		<form action="/" id="changecolor">
          <div class="switchtopic"> <strong> <a href="#" class="one"><font size="2" color="#CCCCCC">选择主题</font></a></strong> </div>
		  <input type="hidden" name="uname2" id="uname" class="uname" value=<?php echo($uname) ?>>
          <script type="text/javascript">
$("div.switchtopic a").click(function() { 
$("#option-dialog").fadeIn("slow"); 
}); 
 
$(".opt").live("click", function() { 
//	var opt_val = $(this).attr("value"); 
//$("#option-dialog").toggle();
//	$.post(
//		'ajax_topic.php',
//		{
//			uname:$("#uname").val(),
//			topi:opt_val
//		}
//	)
}); 
        </script>
        </form>		</td>
        <td width="211" valign="middle" align="left" style="padding-left:20px">
		<input type="text" name="searchfield" style="background: #FFF; border:1px solid #CCCCCC height:22px;font-size:18px" size="14"> 
          <strong><font size="3">
          &nbsp;<input type="submit" name="Submit" value="Find" class="btn">
        </font></strong></td>
        <td align="right" valign="middle" style="padding-right:15px"><?php 
		$uname = $_SESSION['usrname']; 
 		if($_SESSION['usrname']=="")echo("Login");
		else echo "<font size=2 color=#CCCCCC><strong>你好, <a href=RockerDetail.php?uid=".$uname.">$uname</a></strong></font>";
	?>		</td>
      </tr>
  </table>
</div>
<div style="margin-bottom: 0px; margin-top: 0px; margin-left:0; background:url(<?php if(isset($_SESSION['topi']))echo("img/".$_SESSION['topi'].".jpg")?>);" align="center">
<table width="1024" height="54" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="272" rowspan="2" bgcolor="#FFFFFF" style="padding-bottom:15px; padding-left:5px" align="left"><a href="main.php"><img src="img/rockinus_logo.jpg" border="0"></a></td>
    <td width="100" height="30" align="right" bgcolor="#F5F5F5" style="padding-left:0px; padding-top:0px; border-bottom:1px #EEEEEE solid; ">
	<a href="FriendGroup.php?friendreq=1"><img src="img/addfriendIconCN.jpg" width="100" height="25"></a>	</td>
    <td width="35" align="left" bgcolor="#F5F5F5" style="padding-left:0px; border-bottom:1px #EEEEEE solid"><?php 
		if($cnt_friend_rqst>0)
		echo("<span style=background-color:#336633;><strong><a href=FriendGroup.php?friendreq=1>&nbsp;".$cnt_friend_rqst."&nbsp;</a></strong></span>");
		//else echo("(".$cnt_unread_msg.")");
		?>&nbsp;</td>
    <td width="100" align="right" bgcolor="#F5F5F5" style=" padding-left:20px; padding-right:0px; padding-top:0px; border-bottom:1px #EEEEEE solid;border-left:1px #DDDEEE solid;">
	<a href=MessageList.php><img src="img/messageTopIconCN.jpg" width="100" height="25"></a>	
	</td>
    <td width="35" align="left" bgcolor="#F5F5F5" style="padding-left:0px; border-bottom:1px #EEEEEE solid; border-right:1px #EEEEEE solid;"><?php 
		if($cnt_unread_msg>0)
		echo("<span style=background-color:#336633;><strong><a href=MessageList.php>&nbsp;".$cnt_unread_msg."&nbsp;</a></strong></span>");
		//else echo("(".$cnt_unread_msg.")");
		?>&nbsp;</td>
    <td height="30" colspan="2" align="right" bgcolor="#F5F5F5" style="padding-right:10px; padding-top:0px">
	<div id="option-dialog" style="display:none;"> <a href="<?php echo("Header.php") ?>?topi=<?php $loveTheme = array("l1","l2","l3","l4","l5","l6","l7","l8","l9"); $x = array_rand($loveTheme,1); echo("lovetopi".$loveTheme[$x]) ?>" class="two"><img src="img/lovebg.jpg" class="opt"/></a>&nbsp; <a href="<?php echo("Header.php") ?>?topi=<?php $fashionTheme = array("f1","f2","f3","f4","f5","f6","f7","f8","f9","f10"); $x = array_rand($fashionTheme,1); echo("fashiontopi".$fashionTheme[$x]) ?>" class="two"><img src="img/fashionbg.jpg" class="opt"/></a>&nbsp; <a href="<?php echo("Header.php") ?>?topi=<?php $sportTheme = array("Chelsea","Madrid","Barcelona","ACmilan","Intermilan","Manchester","Arsenal","Liverpool","Bayer","knicks"); $x = array_rand($sportTheme,1); echo("sportstopi".$sportTheme[$x]) ?>" class="two"><img src="img/sportsbg.jpg" class="opt"/></a>&nbsp; <a href="<?php echo("Header.php") ?>?topi=<?php $snowTheme = array("s1","s2","s3","s4","s5","s6","s7","s8","s9"); $x = array_rand($snowTheme,1); echo("snowflaketopi".$snowTheme[$x]) ?>" class="two"><img src="img/snowflakebg.jpg" class="opt"/></a>&nbsp; <a href="<?php echo("Header.php") ?>?topi=<?php $musicTheme = array("music1","music2","music3","music4","music5","music6","music7","music8","music9","music10"); $x = array_rand($musicTheme,1); echo("musictopi".$musicTheme[$x]) ?>" class="two"><img src="img/musicbg.jpg" class="opt"/></a>&nbsp; <a href="<?php echo("Header.php") ?>?topi=slashopi" class="two"><img src="img/slashbg.jpg" class="opt"/></a></div>		</td>
    <td width="90" align="center" bgcolor="#F5F5F5" style="border-bottom:1px #EEEEEE solid"><strong><a href="logoff.php" class="one">退 出</a></strong></td>
  </tr>
  <tr>
    <td height="50" colspan="5" align="right" valign="middle">&nbsp;</td>
    <td height="50" colspan="2" align="right" valign="middle" style="padding-right:10px;">&nbsp;</td>
  </tr>
</table>
</body>
</html>
