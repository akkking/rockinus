<?php
session_start();
include 'dbconnect.php';
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
<script>
$(document).ready(function(){
$('#username').keyup(username_check);
$('#fname').keyup(fname_check);
$('#lname').keyup(lname_check);
$('#inputPassword').keyup(passwd_check);
$('#emailJoinUs').keyup(emailJoinUs_check);
});

function fname_check(){	
$("#fname_err").hide();
}	

function lname_check(){	
$("#lname_err").hide();
}

function passwd_check(){
$("#passwd_err").hide();
$("#complexity").show();
}	

function username_check(){	
var username = $('#username').val();
$("#uname_err").html('');
if(username == "" || username.length < 4){
	$('#username').css('border', '2px #333333 solid');
	$('#tick').hide();
}else{
jQuery.ajax({
   type: "POST",
   url: "checkUnameExist.php",
   data: 'username='+ username,
   cache: false,
   success: function(response){
	if(response == 1){
		$('#username').css('border', '2px #333333 solid');	
		$('#tick').hide();
		$('#cross').fadeIn();
	}else{
		$('#username').css('border', '1px #999999 solid');
		$('#cross').hide();
		$('#tick').fadeIn();
	}
}
});
}

}

function emailJoinUs_check(){	
var emailJoinUs = $('#emailJoinUs').val();
$("#email_err").hide();
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
	var email_err = $('#email_err');

	$("#submitJoinUs").click(function(){      
		$(".error").hide();        
		var hasError = false;        
		var unameJoinUsValue = $("#username").val();
		var fnameJoinUsValue = $("#fname").val();
		var lnameJoinUsValue = $("#lname").val();
		var emailJoinUsValue = $("#emailJoinUs").val();  
		var passwordVal = $("#inputPassword").val(); 
		//var genderValue = $("#genderJoinUs").val();
		var genderValue = $('#genderJoinUs').val(); 

		if(unameJoinUsValue == "" || unameJoinUsValue.length < 4){
			$("#uname_err").html('<span class="error" style="font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif, sans-serif">Too short</span>');
			hasError = true; 
		}
		
		if(fnameJoinUsValue.length < 2 || !isLetter(fnameJoinUsValue)){
			$("#fname_err").show();
			$("#fname_err").html('<span class="error" style="font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif, sans-serif">Invalid</span>');
			hasError = true; 
		}
		
		if(lnameJoinUsValue.length < 2 || !isLetter(lnameJoinUsValue)){
			$("#lname_err").show();
			$("#lname_err").html('<span class="error" style="font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif, sans-serif">Invalid</span>');
			hasError = true; 
		}
		
		if (passwordVal.length<6) {            
			$("#complexity").hide();
			$("#passwd_err").show();
			$("#passwd_err").html('<span class="error" style="font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif, sans-serif">Too short</span>');           
			hasError = true;        
		}
		
		if (genderValue.length <1) {            
			//$("#complexity").hide();
			$("#genderJoinUs").after('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="error" style="font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif, sans-serif">What\'s your gender?</span>');           
			hasError = true;        
		}  
		
		if (emailJoinUsValue.length<6 )
		{	
			email_err.html('<span class="error" style="font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif, sans-serif">Invalid</span>');
			email_err.fadeIn(400);
			//email_err.fadeIn(400).fadeOut(400).fadeIn(400);
			emailJoinUs.focus();
			hasError = true;
		}
		else
		{
			if (!IsValidEmail(emailJoinUsValue))
			{
				email_err.html('<span class="error" style="font-weight:bold; font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif">Only .edu</span>');
				//email_err.fadeIn(400).fadeOut(400).fadeIn(400);
				email_err.fadeIn(400);
				emailJoinUs.focus();
				hasError = true;
			}
			else
			{
				email_err.html('');
				email_err.hide();
			}
		}
		
		if(hasError == true) {return false;}

	});
	
	function IsValidEmail(email)
	{
//		var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		var filter = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.+-]+\.edu$/; 
		return filter.test(email);
	}
	
	function isLetter(s) 
	{ 
  		return s.match("^[a-zA-Z\(\)]+$");     
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
<?php include("main_header.php") ?>
  <div class="dailyUpdateDiv" id="dailyUpdateDiv" style="margin-top:10">
  <table width="1024" height="450" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="250" valign="top" align="left" style="border-right:0px dashed #DDDDDD"><table width="200" height="45" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main.php" class="one">Home</a></td>
          <td width="40" style="font-size:12px; font-family:Arial, Helvetica, sans-serif, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main_join.php" class="one">Join Us</a></td>
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
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main_comment.php" class="one">Comment</a></td>
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
	  if(isset($_SESSION['joinus_rst_msg'])){
		  echo $_SESSION['joinus_rst_msg'];
		  unset($_SESSION['joinus_rst_msg']); 
	}
	  ?>
	<div class="joinUsDiv" id="joinUsDiv" style="display: " >
            <form action="joinUs_process.php" method="post" name="infoForm">
              <table width="720" height="450" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="margin-top:0; margin-bottom:10; border:1px #DDDDDD solid">
				  <tr>
                  <td height="100" colspan="2" align="left" valign="middle" background="img/GrayGradbgDown.jpg" style=" font-weight:normal; font-family: Arial, Helvetica, sans-serif; padding-left:70; color:#333333; font-size:36px; line-height:100%">		  
				  Join Us today, You Rock!</td>
                  </tr>
                <tr>
                  <td width="197" height="35" align="right" valign="middle" style="padding-right:7; color:; font-size:14px; font-family: Arial, Helvetica, sans-serif, sans-serif">Pickup a Name</td>
                    <td width="523" height="35" valign="middle" style="padding-left:10">
				  <input name="uname" type="text" id="username" class="unif_input" maxlength="30" size="25" style="font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif, sans-serif; padding:2; height:25; background-color:#F5F5F5" value="<?php if(isset($_SESSION['join_uname'])){echo($_SESSION['join_uname']); unset($_SESSION['join_uname']);}?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img id="tick" src="img/tick.png" width="16" height="16"/><img id="cross" src="img/cross.png" width="16" height="16" style="margin-right:5px"/><div id="uname_err" style="display:inline"></div></td>
                </tr>
                <tr>
                  <td width="197" height="35" align="right" valign="middle" style="padding-right:7; font-size:14px; font-family: Arial, Helvetica, sans-serif, sans-serif">First Name</td>
                  <td width="523" height="35" valign="middle" style="padding-left:10">
					<input name="fname" type="text" id="fname" class="unif_input" maxlength="30" size="25" style="font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif, sans-serif; padding:2; height:25" value="<?php if(isset($_SESSION['fname'])){echo($_SESSION['fname']); unset($_SESSION['fname']);}?>">
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999999; font-size:12px; font-family: Arial, Helvetica, sans-serif, sans-serif">(At least 2 letters)</span>			      </td>
                </tr>
                <tr>
                  <td width="197" height="35" align="right" valign="middle" style="padding-right:7; font-size:14px; font-family: Arial, Helvetica, sans-serif, sans-serif">Last Name</td>
                  <td width="523" height="35" valign="middle" style="padding-left:10">
					<input name="lname" type="text" id="lname" class="unif_input" maxlength="30" size="25" style="font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif, sans-serif; padding:2; height:25" value="<?php if(isset($_SESSION['lname'])){echo($_SESSION['lname']); unset($_SESSION['lname']);}?>">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999999; font-size:12px; font-family: Arial, Helvetica, sans-serif, sans-serif">(At least 2 letters)</span></td>
                </tr>
				<tr >
                  <td height="35" align="right" style="padding-right:7; font-size:14px; font-family: Arial, Helvetica, sans-serif, sans-serif">
				  School Email ID</td>
                    <td height="35" style="padding-left:10">
					<input name="email" type="text" id="emailJoinUs" class="unif_input" size="25" style="font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif, sans-serif; padding:2; height:25" value="<?php if(isset($_SESSION['email'])){echo($_SESSION['email']); unset($_SESSION['email']);}?>">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id="tick_email" src="img/tick.png" width="16" height="16" style="margin-right:10px"/><img id="cross_email" src="img/cross.png" width="16" height="16" style="margin-right:10px"/><span id="email_err" class="email_err" style="display:none; margin-right:10px"></span><span style="color:#999999; font-size:12px; font-family: Arial, Helvetica, sans-serif, sans-serif">(Can be used for login)</span></td>
                </tr>
                <tr >
                  <td height="35" align="right" style="padding-right:7; font-size:14px; font-family: Arial, Helvetica, sans-serif, sans-serif">
				  Set Password</td>
                    <td height="35" bgcolor="#FFFFFF"  style="padding-left:10">
					<input name="passwd" type="password" class="unif_input" id="inputPassword" size="25" style="font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif, sans-serif; padding:2; height:25">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <span id="passwd_err" style="display:none; margin-right:10px"></span><span id="complexity" class="default"></span></tr>
				<tr >
                  <td height="35" align="right" style="padding-right:7; font-size:14px; font-family: Arial, Helvetica, sans-serif, sans-serif">
				  I'm </td>
                    <td height="35"  style="padding-left:10; ">
					<select name="gender" id="genderJoinUs" style="font-family:Arial, Helvetica, sans-serif, sans-serif; font-size:14px">
                      <option value="">Select gender</option>
                      <option value="Female" <?php if(isset($_SESSION['gender'])&&$_SESSION['gender']=="Female"){echo("selected"); unset($_SESSION['gender']);}?>>Female</option>
                      <option value="Male" <?php if(isset($_SESSION['gender'])&&$_SESSION['gender']=="Male"){echo("selected"); unset($_SESSION['gender']); }?>>Male</option>
                    </select></td>
                </tr>
                <tr>
                  <td height="50" align="right" style="padding-right:7; font-size:14px"><strong></strong></td>
                    <td height="50"  style="padding-left:10">
					  <font color="#333333" style="font-size:12px; font-weight:normal; font-family: Arial, Helvetica, sans-serif, sans-serif">Click sumbit means you have read and agree with the <br>
				  <a href="main_agreement.php" class="one" target="_blank"><font color="#336633">User Agreement</font></a></font>				  </td>
                </tr>
                <tr bgcolor="">
                  <td height="90">&nbsp;</td>
                    <td height="90" valign="top" style="padding-left:10px; padding-top:20px">
					<input name="Submit2" type="submit" class="profile_btn" id="submitJoinUs" value="Submit">					</td>
                </tr>
              </table>
            </form>
          </div>
	</td>
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
