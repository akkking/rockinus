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

if(isset($_GET["uid"]))
	$uid = $_GET["uid"]; 
else
	echo "Error Page";
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
          <td width="135" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold">&nbsp;&nbsp;Comment</td>
          <td width="40" style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold">&nbsp;&nbsp;About Us</td>
          <td width="40" style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="150" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px solid #DDDDDD">
        <tr>
          <td valign="bottom">&nbsp;</td>
        </tr>
      </table></td>
    <td width="68">&nbsp;</td>
    <td width="706" align="right" valign="top"><table width="680" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #EEEEEE; border-bottom:1px solid #999999; padding:0px">
      <tr>
        <td><table width="720" border="0" align="right" cellpadding="0" cellspacing="0" style="border-right:1px solid #DDDDDD">
            <tr>
              <td width="320" align="left" valign="top" style="padding:10"><?php
			$loopImg = "upload/$uid/$uid.jpg";
			if(file_exists($loopImg)) echo("<img src=$loopImg?".time()." width=300px style='border:0px #666666 solid' />");
			 else echo("<br><img src=img/NoUserIcon.jpg width=275 />");
		?>              </td>
              <td width="400" align="right" valign="top" style="padding-bottom:20"><table width="380" height="310" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="33" height="30" valign="top" align="center" style="padding-top:15"><img src="img/grayStar.jpg" width="22"/></td>
                    <td height="30" valign="top" style="padding:5; padding-bottom:0; padding-top:10; font-size:18px; color:#660099"><?php
			$sel_count = "
SELECT sum(total) as cnt FROM (
	SELECT count(*) as total FROM rockinus.house_info WHERE uname='$uid'
	UNION 
	SELECT count(*) as total FROM rockinus.article_info WHERE uname='$uid'
	UNION 
	SELECT count(*) as total FROM rockinus.course_memo_info WHERE sender='$uid' 
	UNION 
	SELECT count(*) as total FROM rockinus.event_info WHERE creater='$uid'
	UNION 
	SELECT count(*) as total FROM rockinus.cafe_info WHERE creater='$uid' 
	UNION 
	SELECT count(*) as total FROM rockinus.cafefood_memo_info WHERE sender='$uid' 
) as cnt";

$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
 
$a = mysql_fetch_object($t);
$t_cnt = $a->cnt;
echo("<font color=#660099 style='font-size:24px; font-family: Verdana, Arial, Helvetica, sans-serif'><strong>$uid </strong></font> <font color=#999999>($t_cnt posted)</font>");

$q = mysql_query("SELECT *, b.email as eemail FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON a.uname='$uid' AND b.uname='$uid' AND c.uname='$uid' AND d.uname='$uid'");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("This user info no longer exist in system.");
$object = mysql_fetch_object($q);
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;
$birthdate = $object->birthdate;
$sterm = $object->sterm;
$fregion = $object->fregion;
$fcountry = $object->fcountry;
$ccity = $object->ccity;
$cstate = $object->cstate;
if($fcountry=="empty")$fcountry = NULL;
$email = $object->email;
$eemail = $object->eemail;
$cmajor = $object->cmajor;
$cschool = $object->cschool;
$cdegree = $object->cdegree;

if($gender=='M')$gender='Gentle Man';
else if($gender=='F')$gender='Female';

if($sstatus=='S')$sstatus='Student';
else if($sstatus=='E')$sstatus='Empolyee(r)';

if($cdegree=='G')$cdegree='Master Student';
else if($cdegree=='P')$cdegree='P.H.D.';
else if($cdegree=='U')$cdegree='Undergraduate';
else if($cdegree=='C')$cdegree='Certificate Student';

if($mstatus=='S')$mstatus='Single';
else if($mstatus=='M')$mstatus='Married';
else if($mstatus=='I')$mstatus='In a relationship';

if($cschool!=NULL&&$cschool!="empty"){
	$q1 = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
	if(!$q1) die(mysql_error());
	$obj1 = mysql_fetch_object($q1);
	$school_name = $obj1->school_name;
}else $school_name="<font color=#CCCCCC>Unknown school name</font>";

if($cmajor!=NULL){
	$q2 = mysql_query("SELECT * FROM rockinus.major_info where mid='$cmajor'");
	if(!$q2) die(mysql_error());
	$obj2 = mysql_fetch_object($q2);
	$cmajor = $obj2->major_name;
}

if($fcountry!=NULL){
	$q1 = mysql_query("SELECT * FROM rockinus.country_info where counid='$fcountry'");
//	echo("SELECT * FROM rockinus.country_info where counid='$fcountry'");
//	if(!$q1) die(mysql_error());
//	$obj1 = mysql_fetch_object($q1);
//	$fcountry = $obj1->country_name;
}

$q3 = mysql_query("SELECT * FROM rockinus.memo_info where sender='$uid' order by memoid DESC");
if(!$q3) die(mysql_error());
$obj3 = mysql_fetch_object($q3);
$uiddescrip = $obj3->descrip;
$memoid = $obj3->memoid;
if($uiddescrip==NULL) $uiddescrip="<font color=#CCCCCC>Nothing posted ...</font>";

$rstatus = NULL;
if($uid==$uname)$rstatus ="S";
else{
	$q11 = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE (sender='$uid' AND recipient='$uname') OR (recipient='$uid' AND sender='$uname')");
	if(!$q11) die(mysql_error());
	$no_row_A = mysql_num_rows($q11);
	if($no_row_A>0)$rstatus='A';
	
	$q21 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uid' AND recipient='$uname' AND rstatus='P'");
	if(!$q21) die(mysql_error());
	$no_row_P = mysql_num_rows($q21);
	if($no_row_P>0)$rstatus='X';
	
	$q22 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uname' AND recipient='$uid' AND rstatus='P'");
	if(!$q22) die(mysql_error());
	$no_row_X = mysql_num_rows($q22);
	if($no_row_X>0)$rstatus='P';	
}
			  ?>
                      &nbsp;</td>
                    </tr>
                  <tr>
                    <td width="33" height="30" align="right" valign="top" style="padding-top:5px; padding-right:5px">&nbsp;</td>
                    <td height="30" style="border:0px #DDDDDD solid; line-height:150%; display:inline; padding:5px; padding-top:10; padding-right:10; font-size:14px; height:15"><?php
				if(strlen($uiddescrip)) echo($uiddescrip);		 
			?>                    </td>
                  </tr>
                  <tr>
                    <td width="33" height="30" valign="middle" align="center"><img src="img/studentIcon.jpg" width="20" /> </td>
                    <td height="30" style="padding-top:3px; padding-bottom:5px; padding-left:5px; font-size:18px"><?php 
						  if($cdegree!=NULL)echo("<strong>$cdegree</strong>"); 
						  if($sstatus!=NULL)echo("<strong> | $sstatus</strong>");
						   ?>                    </td>
                  </tr>
                  <tr>
                    <td width="33" height="30" align="right" valign="top" style="padding-top:5px; padding-right:5px">&nbsp;</td>
                    <td height="30" style="padding-top:3px; padding-bottom:5px; padding-left:5px; font-size:14px"><span style="margin-top:10px">
                      <?php
					if(($sstatus!=NULL)&&($cschool!=NULL))echo("$school_name"); 
					else{
							$pieces = explode('@', $eemail);
							if(stristr($pieces[1],'poly')==true) echo("From NYU-Poly ");
							else echo("From ".$pieces[1]);
					}
				?>
                    </span></td>
                  </tr>
                  <tr>
                    <td width="33" height="30" style="padding-right:5px" align="right"></td>
                    <td height="30" style="padding-left:5px; padding-top:0; font-size: 14px" valign="top"><?php 
						  if(($cdegree!=NULL)&&($cmajor!=NULL))echo("$cmajor ($sterm)"); 
						  else echo("<font color=#CCCCCC> Unknown major</font>");
						  ?>                    </td>
                  </tr>
                  <tr>
                    <td width="33" height="30" align="center"><img src="img/hometownIcon.jpg" width="20"/></td>
                    <td height="30" style="padding-left:5px; font-size:18px"><?php 
							echo("<strong>Live in: </strong>  ");
						   if($ccity!=NULL)echo($ccity); else echo("<font color=#CCCCCC>Unkown City</font>"); 
						   		if(($cstate!=NULL)&&($cstate!=NULL)){
						   			if($ccity!=NULL)echo(", $cstate");
								}else 	
						   			echo("<font color=#CCCCCC>, Unknown State</font>"); 
						   ?>                    </td>
                  </tr>
                  <tr>
                    <td width="33" height="30" style="padding-left:0px; padding-right:5px">&nbsp;</td>
                    <td height="30" style="padding-left:0px; padding-left:5px; font-size:14px"><?php 
						   echo("<strong>From: &nbsp;</strong>");
						   if($fregion!=NULL&&$fregion!="empty")echo($fregion); else echo("<font color=#CCCCCC>Unknown City</font>");
						   if(($fregion!=NULL)&&($fcountry!=NULL))echo(", ".$fcountry); else echo("<font color=#CCCCCC>, Unknown Country</font>");
						   ?>                    </td>
                  </tr>
                  <tr>
                    <td width="33" height="30"  align="center">&nbsp;</td>
                    <td height="30" style="padding-left:0px; padding-left:5px; font-size:14px"><?php 
				if($gender=="Male")echo("He is ");
					else if($gender=="Female")echo("She is ");
						if($mstatus!=NULL)echo($mstatus); else echo("<font color=#CCCCCC>Unknown</font>");  ?></td>
                  </tr>
                  <tr>
                    <td width="33" height="30" style="" align="center"><img src="img/emailIcon.jpg" width="20" /></td>
                    <td height="30" style="padding-left:5px; font-size:14px">
					<a href="main_sendMsg.php?recipient=<?php echo($uid); ?>" class="one"> Leave me a Message </a> </td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="35" colspan="2" align="right" valign="middle" background="img/master.png" bgcolor="#EEEEEE" style="padding-right:5; border-top:1 solid #EEEEEE"><a href="main_sendMsg.php?recipient=<?php echo($uid); ?>">
                <div style="display:inline; padding-left:10; padding-right:10; padding-top:3px; padding-bottom:5px; border:1 solid #333333; height:20; background:#336633;" onMouseOver="this.style.cursor='hand';"> Message </div>
              </a> </td>
            </tr>
        </table></td>
      </tr>
    </table></td>
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
