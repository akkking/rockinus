<?php
$uname = "Login";
//$ua=getBrowser();
 
//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

//$_SESSION['hcolor'] = $object->hcolor;
//$_SESSION['lan'] = $object->lan;
//$hcolor = "#336633";
//$lan = $_SESSION['lan'];

$_SESSION['lan'] = "#336633";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<LINK REL="SHORTCUT ICON" HREF="img/rockinTag.jpg">
<title>Rock In U.S.</title>
<script language="JavaScript" src="js/curvycorners.src.js"></script>
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
</head>
<body>
<div align="center" style="background: url(img/green_bg_cell.jpg); margin-top:0px">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" height="35">
	<tr>
      <td width="297" align="left" valign="middle" style="padding-left:5px"><font color="#999999"><strong> <a href="main.php">Home</a>&nbsp;&nbsp;| &nbsp;&nbsp;<a href="FreeTourHouse.php">House</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="FreeTourMarket.php">Sale</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="FreeTourClass.php">Class</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="FreeTourForum.php">Forum</a>&nbsp;&nbsp;</strong></font></td>
      <td width="81" valign="middle" align="left"><form action="Header.php" id="switch_lan" name="switch_lan" method="post">
        <select name="lan" class="box" onChange="document.switch_lan.submit()" style="background-color:#F5F5F5; font-size:11px">
          <option value="EN" selected="selected">English</option>
        </select>
      </form></td>
      <td width="46" align="center" valign="middle" style="padding-left:0px">&nbsp;</td>
      <td width="600" align="right" valign="middle" style="padding-right:0px; color:#FFFFFF">
	  <form action="login_process.php" method="post" style="margin-bottom:0">
       <table width="600" height="30" border="0" cellpadding="0" cellspacing="0" style="border-left:0px #CCCCCC solid; border-bottom:0px #CCCCCC solid; border-top:0px #CCCCCC solid">
    <tr>
      <td width="120" height="30" align="right" style="padding-right:15px"><strong><font size="2" color="#FFFFFF">Username</font></strong></td>
            <td width="110" height="30"><input type="text" style="height:20px" name="usrname" size="15" onMouseOver="this.className='over'" onMouseOut="this.className='out'" class="box" value=<?php if(isset($_COOKIE["user"])) echo($_COOKIE["user"]); ?>></td>
            <td width="88" height="30" align="right" style="padding-right:15px"><strong><font size="2" color="#FFFFFF">&nbsp;&nbsp;&nbsp;Password</font></strong></td>
                    <td width="126" height="30"><input type="password" style="height:20px" name="passwd" onMouseOver="this.className='over'" onMouseOut="this.className='out'" class="box" size="15" ></td>
                    <td width="1" height="30" valign="middle" align="right">					</td>
					<td width="83">&nbsp;
			  <input type="submit" name="Submit" value="Sign In" style="background: #EEEEEE; border:1px #999999 solid; font-size:11px; height:22px">
			  </td>
			  <td width="72" align="right" style="padding-right:15px">
			  <span style="margin-bottom:15px; padding-top:-2px; color:#FFFFFF; font-size:12px; font-weight:bold"><a href="joinUs.php">Sign Up</a></span></td>
           </tr>
    </table>
        </form>	</td>
    </tr>
  </table>
</div>
<div id="othercontent" style="margin-bottom: 0px; margin-top: 0px; margin-left:0; background:url(<?php if(isset($_SESSION['topi']))echo("img/".$_SESSION['topi'].".jpg")?>);" align="center">
</body>
</html>
