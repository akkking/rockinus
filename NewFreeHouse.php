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
<script>
 $(document).ready(function() {
 	 $("#dailyUpdate").load("HomeDailyUpdate.php");
   var refreshId = setInterval(function() {
      $("#dailyUpdate").load('HomeDailyUpdate.php?randval='+ Math.random());
   }, 2000);
   $.ajaxSetup({ cache: false });
});
</script>
<script>
$(document).ready(function() { 
    $('div .polyfont_cover_bg').mouseover(function(){ 
        $('div#polyfont_cover_bg img').fadeIn('slow'); 
    }); 
    $('img').mouseout(function(){ 
        $('div#polyfont_cover_bg img').fadeOut('slow'); 
    }); 
}); 
</script>

<script>
$(document).ready(function(){
$('#username').keyup(username_check);
$('#emailJoinUs').mouseout(emailJoinUs_check);
});
	
function username_check(){	
var username = $('#username').val();
if(username == "" || username.length < 4){
	$('#username').css('border', '3px #B92828 solid');
	$('#tick').hide();
}else{
jQuery.ajax({
   type: "POST",
   url: "checkUnameExist.php",
   data: 'username='+ username,
   cache: false,
   success: function(response){
	if(response == 1){
		$('#username').css('border', '3px #000000 solid');	
		$('#tick').hide();
		$('#cross').fadeIn();
	}else{
		$('#username').css('border', '1px #336633 solid');
		$('#cross').hide();
		$('#tick').fadeIn();
	}
}
});
}

}

function emailJoinUs_check(){	
var emailJoinUs = $('#emailJoinUs').val();

jQuery.ajax({
   type: "POST",
   url: "checkEmailExist.php",
   data: 'email='+ emailJoinUs,
   cache: false,
   success: function(response){
	if(response == 1){
		$('#emailJoinUs').css('border', '3px #000000 solid');	
		$('#tick_email').hide();
		$('#cross_email').fadeIn();
	}else{
		$('#emailJoinUs').css('border', '1px #336633 solid');
		$('#cross_email').hide();
		$('#tick_email').fadeIn();
	}
}
});
}
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script>
jQuery(function(){    
	var emailJoinUs = $('#emailJoinUs');
	var messageDiv = $('#MessageDiv');

	$("#submitJoinUs").click(function(){      
		$(".error").hide();        
		var hasError = false;        
		var passwordVal = $("#inputPassword").val();    
		var checkVal = $("#inputPassword_check").val();   
		var emailJoinUsValue = $("#emailJoinUs").val();
	
		var unameJoinUsValue = $("#username").val();
		if(unameJoinUsValue == "" || unameJoinUsValue.length < 4){
			$("#username").after('&nbsp;&nbsp;&nbsp;&nbsp;<span class="error">User name is not long enough.</span>');
			return false;
		}
		
		if (passwordVal == '') {            
			$("#complexity").hide();
			$("#inputPassword").after('&nbsp;&nbsp;&nbsp;&nbsp;<span class="error">Please enter a password.</span>');           
			hasError = true;        
		} else if (checkVal == '') {            
			$("#inputPassword_check").after('&nbsp;&nbsp;&nbsp;&nbsp;<span class="error">Please re-enter your password.</span>');            
			hasError = true;        
		} else if (passwordVal != checkVal ) {            
			$("#inputPassword_check").after('&nbsp;&nbsp;&nbsp;&nbsp;<span class="error">Passwords do not match.</span>');           
			hasError = true;        
		}        
	
		if(hasError == true) {return false;}
		
		if (emailJoinUsValue == '')
		{	
			messageDiv.html('Email address required');
			messageDiv.fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400);
			emailJoinUs.focus();
		}
		else
		{
			if (!IsValidEmail(emailJoinUsValue))
			{
				messageDiv.html('Please enter a valid .edu email address');
				messageDiv.fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400);
				emailJoinUs.focus();
				return false;
			}
			else
			{
				messageDiv.html('');
				messageDiv.hide();
			}
		}
	});
	
	function IsValidEmail(email)
	{
//		var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		var filter = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.+-]+\.edu$/; 
		return filter.test(email);
	}
});
</script>
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
            <div align="left" style=" width:230; margin-bottom:40; font-size:14px; font-weight:normal; font-family:Arial, Helvetica, sans-serif; line-height:150%; padding:0px; color:;">Rockinus is an open, free, school-based social network for students who study, wish to study, or graduated in Polytechnic Institute of NYU. You can post house rentals, sales, course comments, upload course files, look for jobs, etc. Also, it is an exciting place to find new friends, exchange topics with other students as well. We hope you enjoy this network :)</div>            <div style="font-size:14px"> <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 0px; display:inline; margin-bottom:5px; background: #FFFFFF; border:2px solid #666666; height:25;"><a href="commentUs.php" class="one"><a href="NewFreeAboutUs.php" class="one"><strong>About Us</strong></a></span> &nbsp; <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 00px; display:inline; margin-bottom:5px; background: #FFFFFF; border:2px solid #666666; height:25;"><a href="NewFreeCommentUs.php" class="one"><strong>Comments</strong></a></span></div></td>
            <td width="680" align="right" style="padding-top:20" valign="top"><table width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td width="680" align="left" valign="top" style=" border-right:#DDDDDD solid 0;border-left:#DDDDDD solid 0;"><?php
	  if(isset($_GET['hid']))
	$hid = $_GET['hid'];
else if(isset($_POST['hid']))
	$hid = $_POST['hid'];
else $hid = 1;

mysql_query("SET NAMES GBK");
$q = mysql_query("SELECT * FROM rockinus.house_info where hid='$hid'");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$subject = $object->subject;
$type = $object->type;
$city = $object->city;
$state = $object->state;
$email = $object->email;
$rate = $object->rate;
$telephone = $object->telephone;
$rstatus = $object->rstatus;
$description = $object->descrip;
$duration = $object->duration; 
$expireday = $object->expireday; 
if($duration==30)$duration="1 Month";
else if($duration==7)$duration="1 Week";
else if($duration==91)$duration="3 Months";
else if($duration==182)$duration="6 Months";
else $duration="1 Year";
$metroline = $object->metroline;
$metrostop = $object->metrostop;
$metromins = $object->metromins;
$postuname = $object->uname;
$pdate = $object->pdate;
$ptime = $object->ptime;

if($metrostop=="empty")$metrostop="";
if($metromins==0)$metromins="";
if($metroline=='X')$metroline="Unknown"; else $metroline.=" train, ".$metrostop.", within ".$metromins." minutes walking distance.";

if($uname==$postuname){
	$t2 = mysql_query("SELECT * FROM rockinus.house_comment WHERE rstatus='N' AND hid=$hid");
	if(!$t2) die(mysql_error());
	$no_row_hist = mysql_num_rows($t2);
	
	if($no_row_hist>0){	
		$upd = mysql_query("UPDATE rockinus.house_comment SET rstatus='Y' WHERE hid='$hid' AND rstatus='N'");
		if(!$upd) die(mysql_error());
	}
}
	  ?>
                  <table width="670" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid; border-top: 0px; margin-bottom:20px">
                    <tr>
                      <td height="30" colspan="5" background="img/master.png" style="padding-right:10; color:#666666; border-bottom:1 solid #CCCCCC" align="right">Posted : <?php echo($pdate) ?> | <?php echo($ptime) ?></td>
                    </tr>
                    <tr>
                      <td height="60" colspan="5" align="center" style="border-bottom:0px #999999 solid; border-top:0px #999999 solid"><font size="4" style="font-weight:bold"><?php echo($subject) ?></font> </td>
                    </tr>
                    <tr>
                      <td width="96" height="15" align="right" style="padding-right:15px">&nbsp;</td>
                      <td height="15">&nbsp;</td>
                      <td height="15">&nbsp;</td>
                      <td width="105" height="15" align="right" style="padding-right:15px">&nbsp;</td>
                      <td height="15" align="right" style="padding-right:15px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="96" height="33" align="right" style="padding-right:15px"><strong>Location</strong></td>
                      <td><?php echo($city) ?>&nbsp;,&nbsp;<?php echo($state) ?></td>
                      <td>&nbsp;</td>
                      <td align="right" style="padding-right:15px"><strong>Available?</strong></td>
                      <td align="left"><?php 
	if(trim($rstatus)=="Y") echo("<div align=center style='border-right:0 solid #000000; border-bottom:0 solid #000000; background-color: ; padding-bottom:3; padding-top:3; height:20px; color:#336633; font-size=16px; display:inline'><strong>Yes</strong></div>");
	else echo("<div align=center style='border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: ; padding-bottom:3; padding-top:3; padding-left:10px; padding-right:10px; height:20px; color: orange; font-size=16px; display:inline'><strong>No</strong></div>");
	 ?>                      </td>
                    </tr>
                    <tr>
                      <td width="96" height="34" align="right" style="padding-right:15px"><strong>Category</strong></td>
                      <td colspan="2"><?php echo($type) ?>&nbsp;</td>
                      <td align="right" style="padding-right:15px"><strong>Duration</strong></td>
                      <td width="255"><?php echo($duration) ?></td>
                    </tr>
                    <tr>
                      <td width="96" height="37" align="right" style="padding-right:15px"><strong>Rate</strong></td>
                      <td colspan="2"> $<?php echo($rate) ?>&nbsp;</td>
                      <td align="right" style="padding-right:15px"><strong>Email</strong></td>
                      <td><?php echo($email) ?></td>
                    </tr>
                    <tr>
                      <td width="96" height="37" align="right" style="padding-right:15px"><strong>Metro</strong></td>
                      <td colspan="4"><?php echo($metroline) ?></td>
                    </tr>
                    <tr style="border-bottom:dotted 1 #CCCCCC; border:1">
                      <td width="96" height="35" align="right" style="padding-right:15px;"><strong>Contact</strong></td>
                      <td width="151"><a href="NewFreeUser.php?uid=<?php echo($postuname) ?>" class="one"><?php echo($postuname) ?></td>
                      <td width="104"><font color="#006699" size="2">
                        <div style="background: #336633; display:inline; height:20px; padding-left:8px; padding-right:8px; padding-bottom:4px; padding-top:4px; border:#CCCCCC solid 1;" align="center">
                          <?php 
				  echo("<a href=NewFreeSendMsg.php?recipient=$postuname>Message</a>")
				  ?>
                        </div>
                      </font></td>
                      <td align="right" style="padding-right:15px"><strong>Phone</strong></td>
                      <td><?php echo($telephone) ?></td>
                    </tr>
                    <tr>
                      <td width="96" height="116" style="border-top:#EEEEEE dotted 0; padding-top:15; padding-right:15" valign="top" align="right"><strong>Description</strong></td>
                      <td colspan="4" valign="top" align="left" style="border-bottom:1 #EEEEEE dotted; padding-left:0; padding-right:10; padding-bottom:10; line-height:150%; font-size:15px; padding-top:15px; width: 615px; border: dotted #999999 0; margin-left:5px"><?php 
echo(nl2br($description)) ?>                      </td>
                    </tr>
                    <tr>
                      <td width="96" height="10" style="border-top:#EEEEEE dotted 1">&nbsp;</td>
                      <td height="10"colspan="4" align="left" valign="top" style="border-top:#EEEEEE dotted 1; padding-top:15px"><?php 
					$target = "upload/h".$hid;
					if(is_dir($target)){
						if(file_exists($target."/1_600.jpg")) echo("<img src=upload/h$hid/1_600.jpg style=border:0><br><br>");
				  		if(file_exists($target."/2_600.jpg")) echo("<img src=upload/h$hid/2_600.jpg style=border:0><br><br>");
						if(file_exists($target."/3_600.jpg")) echo("<img src=upload/h$hid/3_600.jpg style=border:0>");
					}
	?>                      </td>
                    </tr>
                    <tr>
                      <td width="96" height="14" style="border-top:#EEEEEE dotted 0">&nbsp;</td>
                      <td style="border-top:#EEEEEE dotted 0"colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="96" height="40" style="border-top:#CCCCCC dotted 0">&nbsp;</td>
                      <td height="40" colspan="4" align="left" style="padding-left:10px; border-top:#CCCCCC dotted 0"><font color="#999999">The availability of this post is for <?php echo($expireday) ?> days.</font> </td>
                    </tr>
                    <tr>
                      <td width="96" height="52" style="border-top:#CCCCCC dotted 0">&nbsp;</td>
                      <td colspan="4" align="left" style="padding-left:0; border-top:#CCCCCC dotted 0"><table width="600" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px">
                          <tr>
                            <td width="500" height="41" colspan="3"><?php
$q1 = mysql_query("SELECT * FROM rockinus.house_comment WHERE hid='$hid' ORDER BY pdate DESC, ptime DESC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("");}
if($no_row > 0){ 
while($object = mysql_fetch_object($q1)){
	$cid = $object->cid;
	$hid = $object->hid;
	$sender = $object->sender;
	$recipient = $object->recipient;
	$descrip = $object->descrip;
	$ptime = $object->ptime;
	$pdate = $object->pdate; 
?>
                                <div style="padding-left:0; padding-right:0; line-height:180%; padding-top:0; padding-bottom:0; margin-bottom:10; width: 600; background-color: ; border:2 #EEEEEE solid">
                                  <table width="600" height="63" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="329" height="25" align="left" bgcolor="#F5F5F5" style="padding-left:10"><strong><?php echo($sender); 
				  if($sender!=$recipient)
				  	echo("@ $recipient");
				?></strong> </td>
                                      <td width="364" height="25" align="right" bgcolor="#F5F5F5" style="padding-right:10"><?php echo($pdate) ?> | <?php echo($ptime) ?></td>
                                    </tr>
                                    <tr>
                                      <td height="22" colspan="2" style="padding:10"><font size="3">
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
                          <div style="width:600; border:8px #DDDDDD solid; padding-bottom:30; margin-top:30; margin-bottom:30; padding-top:30; font-size:16px; font-weight:bold" align="center"> To reply to this post or to view more info, please:
                            <p style="margin-top:30"/>                      
                            </p>
                              <div style="border:1 #999999 solid; display:inline; padding-left:10; padding-right:10; padding-bottom:5; padding-top:5; height:10; background:#336633; font-weight:normal; font-size:14px; color:#FFFFFF"><a href="main.php">Login Or Sign-up</a> </div>
                        </div></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          </tr>
    </table>
  </div>
  
  <br>
<br>
<?php include("bottomMenuEN_login.php"); ?>
</div>
</body>
</html>
