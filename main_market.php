<?php
session_start();
include 'dbconnect.php';
include 'Allfuc.php';
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
font-size:100%; line-height:180%; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; cursor:pointer; }

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
          <td width="135" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main.php" class="one">Home</a></td>
          <td width="40" style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main_join.php" class="one">Join Us</a></td>
          <td width="40" style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main_comment.php" class="one">Comment</a></td>
          <td width="40" style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main_aboutUs.php" class="one">About Us</a></td>
          <td width="40" style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="150" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px solid #DDDDDD">
        <tr>
          <td valign="bottom">&nbsp;</td>
        </tr>
      </table></td>
    <td width="68">&nbsp;</td>
    <td width="720" valign="top">
	 <?php
if(isset($_GET['aid']))
	$aid = $_GET['aid'];
else if(isset($_POST['aid']))
	$aid = $_POST['aid'];
	
mysql_query("SET NAMES GBK");
$q = mysql_query("SELECT * FROM rockinus.article_info where aid=$aid");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$aid = $object->aid;
$subject = $object->subject;
$subject = str_replace("\\","",$subject);
$type = $object->type;
$condition = $object->quality;
$delivery = $object->delivery;
if($delivery=='N')$delivery='No';else '$delivery=Yes';
$state = $object->state;
$city = $object->city;
$email = $object->email;
$rate = $object->rate;
$telephone = $object->telephone;
$num = $object->num;
$aname = $object->aname;
$postuname = $object->uname;
$rstatus = $object->rstatus;
$descrip = $object->descrip;
$descrip = str_replace("\\","",$descrip);
$pdate = $object->pdate;
$ptime = $object->ptime;

if($uname==$postuname){
	$t2 = mysql_query("SELECT * FROM rockinus.article_comment WHERE rstatus='N' AND aid=$aid");
	if(!$t2) die(mysql_error());
	$no_row_hist = mysql_num_rows($t2);
	
	if($no_row_hist>0){	
		$upd = mysql_query("UPDATE rockinus.article_comment SET rstatus='Y' WHERE aid='$aid' AND rstatus='N'");
		if(!$upd) die(mysql_error());
	}
}
?>  <table width="720" border="0" cellpadding="0" cellspacing="0" style="border:#EEEEEE solid 1px; margin-bottom:20px">
        <tr>
          <td height="50" background="img/GrayGradbgDown.jpg">&nbsp;</td>
          <td height="50" colspan="2" background="img/GrayGradbgDown.jpg">&nbsp;</td>
          <td height="50" background="img/GrayGradbgDown.jpg">&nbsp;</td>
          <td height="50" align="right" background="img/GrayGradbgDown.jpg" style="padding-right:10px; color:#999999">Posted : <?php echo(getDateName($pdate)) ?> | <?php echo(substr($ptime,0,5)) ?></td>
        </tr>
        <tr>
          <td height="70" colspan="5" align="center" style="border-bottom:0px #999999 solid; border-top:0px #CCCCCC solid">
		  <font size="5" style="font-weight:bold"><?php echo($subject) ?></font></td>
        </tr>
        <tr>
          <td height="33" align="right" style="padding-right:15px">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right" style="padding-right:10px">&nbsp;</td>
        </tr>
        <tr>
          <td width="143" height="33" align="right" style="padding-right:15px"><strong>Location</strong></td>
          <td><?php echo($city) ?>&nbsp;,&nbsp;<?php echo($state) ?></td>
          <td>&nbsp;</td>
          <td align="right" style="padding-right:15px"><strong>Available?</strong></td>
          <td align="left"><?php 
	if(trim($rstatus)=="Y") echo("<div align=center style='border-right:0 solid #000000; border-bottom:0 solid #000000; background-color: ; padding-bottom:3; padding-top:3; height:20px; color:#336633; font-size=16px; display:inline'><strong>Yes</strong></div>");
	else echo("<div align=center style='border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: ; padding-bottom:3; padding-top:3; padding-left:10px; padding-right:10px; height:20px; color: orange; font-size=16px; display:inline'><strong>No</strong></div>");
	 ?>
          </td>
        </tr>
        <tr>
          <td height="33" align="right" style="padding-right:15px"><strong>Name</strong></td>
          <td colspan="2"><?php echo($aname) ?>&nbsp;</td>
          <td width="107" align="right" style="padding-right:15px"><strong>Number</strong></td>
          <td width="260"><?php echo($num) ?>&nbsp;Piece(s)</td>
        </tr>
        <tr>
          <td height="34" align="right" style="padding-right:15px"><strong>Condition</strong></td>
          <td colspan="2"><?php echo($condition) ?>&nbsp;</td>
          <td align="right" style="padding-right:15px"><strong>Delivery</strong></td>
          <td><?php 
	if($delivery=='Y')
	echo("Yes"); else echo("No"); ?></td>
        </tr>
        <tr>
          <td height="37" align="right" style="padding-right:15px"><strong>Rate</strong></td>
          <td colspan="2"> $<?php echo($rate) ?>&nbsp;</td>
          <td align="right" style="padding-right:15px"><strong>Phone</strong></td>
          <td><?php echo($telephone) ?></td>
        </tr>
        <tr style="border-bottom:solid 1px #CCCCCC;">
          <td height="35" align="right" style="padding-right:15px;"><strong>Contact</strong></td>
          <td width="123"><?php echo($postuname) ?></td>
          <td width="85">
            <div style="background: #F5F5F5; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; display:inline; height:20px; padding:4 8 4 8; border:#DDDDDD solid 1" align="right">
              <?php 
				  echo("<a href=main_sendMsg.php?recipient=$postuname class=one>Message</a>")
				  ?>
            </div>
          </td>
          <td align="right" style="padding-right:15px"><strong>Email</strong></td>
          <td><?php echo($email) ?></td>
        </tr>
        <tr style="border-bottom:solid 1px #CCCCCC;">
          <td height="20" colspan="5" align="right" style="padding-right:15px;">&nbsp;</td>
        </tr>
        <tr>
          <td height="74" align="right" style="padding-right:15; border-top:#EEEEEE dotted 0; padding-top:10px" valign="top"></td>
          <td colspan="4" align="left" valign="top" style="border-bottom:0 #EEEEEE dotted; padding:10 0 10 0; line-height:150%; font-size:15px; width: 550; font-size:16px; margin-left:5px"><?php
	  echo nl2br($descrip)
	  ?>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" style="padding-right:10; border-top:#EEEEEE dotted 0; padding-top:30px" valign="top">&nbsp;</td>
          <td height="30"colspan="4" valign="top" style="border-top:#EEEEEE dotted 0; padding-top:10px"><?php 
					$target = "upload/a".$aid;
					if(is_dir($target)){
						if(file_exists($target."/1_600.jpg")) echo("<img src=upload/a$aid/1_600.jpg width=550 style=border:0><br><br>");
				  		if(file_exists($target."/2_600.jpg")) echo("<img src=upload/a$aid/2_600.jpg width=550 style=border:0><br><br>");
						if(file_exists($target."/3_600.jpg")) echo("<img src=upload/a$aid/3_600.jpg width=550 style=border:0>");
					}
	?>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" style="padding-right:10; border-top:#EEEEEE dotted 0; padding-top:30px" valign="top">&nbsp;</td>
          <td height="30"colspan="4" valign="top" style="border-top:#EEEEEE dotted 0; padding-top:10px"><table width="550" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px">
              <tr>
                <td width="710" height="41" colspan="3"><?php
$q1 = mysql_query("SELECT * FROM rockinus.article_comment WHERE aid='$aid' ORDER BY pdate DESC, ptime DESC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("");}
if($no_row > 0){ 
while($object = mysql_fetch_object($q1)){
	$cid = $object->cid;
	$aid = $object->aid;
	$sender = $object->sender;
	$recipient = $object->recipient;
	$descrip = $object->descrip;
	$ptime = $object->ptime;
	$pdate = $object->pdate; 
?>
                    <div style="padding-left:0; padding-right:0; line-height:180%; padding-top:0; padding-bottom:0; margin-bottom:10; width: 550; background-color: ; border:2 #EEEEEE solid">
                      <table width="550" height="63" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="246" height="25" align="left" bgcolor="#F5F5F5" style="padding-left:10px"><strong><?php echo($sender); 
				  if($sender!=$recipient)
				  	echo("@ $recipient");
				?></strong> </td>
                          <td height="25" align="right" bgcolor="#F5F5F5" style="padding-right:10"><?php echo($pdate) ?> | <?php echo($ptime) ?></td>
                        </tr>
                        <tr>
                          <td height="22" colspan="2" style="padding:10px"><font size="3">
                            <?php
									$len = strlen($descrip);
									$single_line_len = 95;
									$line_no = $len/$single_line_len; 
							
									for($i=0;$i<$line_no;$i++) {
										$str = substr($descrip,$i*$single_line_len, ($i+1)*$single_line_len)."<br>";
										echo $str;
									}?>
                          </font> </td>
                        </tr>
                      </table>
                    </div>
                  <?php }}?></td>
              </tr>
            </table>
              <div style="width:550; background-color:#F5F5F5; border:1px #DDDDDD dashed; padding-bottom:30; margin-top:30; margin-bottom:30; padding-top:30; font-size:16px; font-weight:bold" align="center"> To reply this post or for more info, please
                  <p style="margin-top:15">
                  <div style="border:1 #999999 solid; display:inline; padding-left:10; padding-right:10; padding-bottom:5; padding-top:5; height:10; background-image:url(img/master.png); font-weight:normal; font-size:14px"> <a href="main_join.php" class="one">+ Join Us Now</a> </div>
            </div></td>
        </tr>
      </table>
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
