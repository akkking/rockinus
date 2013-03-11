<?php
session_start();
header("Content-Type: text/html; charset=gb2312");
include 'dbconnect.php';

if(isset($_POST['sendmsgform'])){
	include 'dbconnect.php'; 
	$tag = 0;
	$subject = addslashes($_POST['subject']);
	$sender = $_POST['sender']; 
	$recipient = $_POST['recipient'];
	$description = addslashes($_POST['description']);
	
	if($sender==NULL || strlen(trim($sender))==0){
		$sender = "Anonymous";
	}
	
	if($recipient==NULL || strlen($recipient)==0){
		$tag = 1;
		$rst_msg = "Who you want to send the message?";
	}
	
	if( ( $subject==NULL || strlen(trim($subject))==0 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "What is your Message Subject?";
	}
	 
	if( ( $description==NULL || strlen(trim($description))==0 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "No content for the Message, please check";
	}
	   
	$t = mysql_query("SELECT count(*) as cnt FROM rockinus.user_info WHERE uname='$recipient'");
	$a = mysql_fetch_object($t);
	$total_items = $a->cnt;
	
	if($total_items!=1 && $tag==0 ){
		$tag = 1;
		$rst_msg = "The Student you want to send does not exist";
	}
	
	if($tag==0){	
		$sql = "INSERT INTO rockinus.message_info (subject,recipient,descrip,iostatus,rstatus,sender,pdate,ptime)VALUES('$subject','$recipient','$description','O','N','$sender',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$rst_msg = "Your Message has been sent to $recipient Successfully!";
		//mysql_close($link);
		$_SESSION['recipient'] = $recipient;
		$_SESSION['rst_msg']="<div align='center' style='width=680; padding-top:20; padding-bottom:20; margin-top:10; border:1px #DDDDDD solid; background:#F5F5F5; margin-top:15'><strong><font size=3><img src=img/addsuccessIcon_F5.jpg width=20>&nbsp;&nbsp; $rst_msg :)</font></strong><br><br><font size=3><a href=main.php class=one>Go Back</a></font></div>"; 
		//header("location:FreeTourMessageResult.php");
	}else
		$_SESSION['rst_msg']="<div align='center' style='width=680; padding-top:20; padding-bottom:20; margin-top:10; border:1px #DDDDDD solid; background:#F5F5F5; margin-top:15'><strong><font size=3 color=#B92828><img src=img/stop.jpg width=18 height=18 />&nbsp;&nbsp;&nbsp;$rst_msg</font></strong><br><br><font size=3><a href=NewFreeSendMsg.php?recipient=$recipient class=one>Go Back</a></font></div>"; 
}

if(!isset($_GET['recipient']) && !isset($_SESSION['rst_msg'])){
	header("location:main.php");
}

if(isset($_GET['recipient']))
	$recipient = $_GET['recipient'];
	
if(isset($_SESSION['recipient'])){
	$recipient = $_SESSION['recipient'];
	unset($_SESSION['recipient']);
}
?>

<?php
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
            <div align="left" style=" width:230; margin-bottom:40; font-size:14px; font-weight:normal; font-family:Arial, Helvetica, sans-serif; line-height:150%; padding:0px; color:;">Rockinus is an open, free, school-based social network for students who study, wish to study, or graduated in Polytechnic Institute of NYU. You can post house rentals, sales, course comments, upload course files, look for jobs, etc. Also, it is an exciting place to find new friends, exchange topics with other students as well. We hope you enjoy this network :)</div>            <div style="font-size:14px"> <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 0px; display:inline; margin-bottom:5px; background: #FFFFFF; border:2 solid #666666; height:25;"><a href="commentUs.php" class="one"><a href="NewFreeAboutUs.php" class="one"><strong>About Us</strong></a></span> &nbsp; <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 00px; display:inline; margin-bottom:5px; background: #FFFFFF; border:2 solid #666666; height:25;"><a href="NewFreeCommentUs.php" class="one"><strong>Comments</strong></a></span></div></td>
            <td width="680" align="right" style="padding-top:20" valign="top">
			
	  <?php 
	  if(isset($_SESSION['rst_msg'])){
		  echo $_SESSION['rst_msg'];
		  unset($_SESSION['rst_msg']); 
	}
	  ?> 	
			<form method="post" action="NewFreeSendMsg.php">
              <div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:10; padding-bottom:30; border-bottom:1px #EEEEEE solid">
                <table width="680" height="355" border="0" cellpadding="0" cellspacing="0" style="border:0px #CCCCCC dotted">
                  <tr>
                    <td height="20" colspan="3" align="left" style="padding-left:15px">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="103" rowspan="4" align="right" valign="top" style="padding-right:5; padding-top:10">
					<a href="NewFreeUser.php?uid=<?php echo($recipient)?>">
                      <?php
			$loopImg = "upload/$recipient/$recipient.jpg";
			if(file_exists($loopImg)) echo("<img src=$loopImg width=100px style='border:0px #666666 solid' />");
			 else echo("<img src=img/NoUserIcon.jpg width=100px />");
		?>
                    </a> </td>
                    <td width="138" height="50" align="right" style="padding-right:10px; font-size: 24px"><strong><font color="#CC3300">Hi, I'm </font></strong></td>
                    <td width="439" align="left" style="" height="50">
					<?php 
					//echo($recipient);
				  if($recipient==NULL || strlen($recipient)==0){
						echo("<input type=text name=recipient style='font-size:24px; font-weight: bold; border:0'>"); 
					}else{
						echo("<input type=text class=box value='$recipient' disabled=disabled style='font-size:24px; font-weight: bold; border:0'>");
						echo("<input type=hidden name=recipient size=15 class=box value='$recipient'>");
					}
			?></td>
                  </tr>
                  <tr>
                    <td width="138" align="right" style="padding-right:15px"><strong>Your Name</strong></td>
                    <td align="left" style="padding-right:8px"height="41"><input type="text" name="sender" size="20" class="box">
                      &nbsp;&nbsp;&nbsp;<font color="#999999">(Leave blank as anonymous)</font> </td>
                  </tr>
                  <tr>
                    <td width="138" height="40" align="right" style="padding-right:15"><strong>What is about?</strong></td>
                    <td height="40"><input type="text" name="subject" size="50" class="box" /></td>
                  </tr>
                  <tr>
                    <td width="138" height="100" align="right" valign="middle" style="padding-right:15px;">&nbsp;</td>
                    <td height="100" style="padding-top:10px" valign="top"><textarea name="description" rows="15" style="width:400; font-size:14px; font-weight:normal" id="styled" onFocus="this.value=''; setbg('#e5fff3');" onBlur="setbg('white')"></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td height="21" colspan="2" align="center" valign="top">&nbsp;</td>
                    <td height="21" align="left" valign="top" style=" padding-top:10px">
					<input type="submit" name="sendmsgform" value=" Send " class="btn2" style="font-size:14px" />
                    </td>
                  </tr>
                </table>
              </div>
            </form></td>
          </tr>
    </table>
  </div>
  
  <br>
<br>
<?php include("bottomMenuEN_login.php"); ?>
</div>
</body>
</html>
