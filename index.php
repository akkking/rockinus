<?php 
include 'dbconnect.php';
include 'emailfuc.php';
header("Content-Type: text/html; charset=gb2312");
session_start();
if(isset($_SESSION['usrname'])){
	$loopName = $_SESSION['usrname'];
	$pageName = "ThingsRock.php";
	$q_basic = mysql_query("SELECT * FROM rockinus.user_basic_setting where uname='$loopName'");
	if(!$q_basic) die(mysql_error());
	$object_basic = mysql_fetch_object($q_basic);
	$directPage = $object_basic->directPage;
	if($directPage=="H")$pageName= "ThingsRock.php";
	else if($directPage=="P")$pageName= "RockerDetail.php?uid=$loopName";	
	header("location:$pageName");
}

$q_user = mysql_query("SELECT * FROM rockinus.user_check_info WHERE status='A';");
if(!$q_user) die(mysql_error());
$no_row_user = mysql_num_rows($q_user);

$q_user_poly = mysql_query("SELECT * FROM rockinus.user_check_info WHERE status='A' AND email LIKE '%poly.edu%';");
if(!$q_user_poly) die(mysql_error());
$no_row_user_poly = mysql_num_rows($q_user_poly);

$q_house_lease = mysql_query("SELECT * FROM rockinus.house_info WHERE rentlease='lease';");
if(!$q_house_lease) die(mysql_error());
$no_row_house_lease = mysql_num_rows($q_house_lease);

$q_house_rent = mysql_query("SELECT * FROM rockinus.house_info WHERE rentlease='rent';");
if(!$q_house_rent) die(mysql_error());
$no_row_house_rent = mysql_num_rows($q_house_rent);
$no_row_house = $no_row_house_rent + $no_row_house_lease;

$q_article_buy = mysql_query("SELECT * FROM rockinus.article_info WHERE buysale='buy';");
if(!$q_article_buy) die(mysql_error());
$no_row_article_buy = mysql_num_rows($q_article_buy);

$q_article_sale = mysql_query("SELECT * FROM rockinus.article_info WHERE buysale='sale';");
if(!$q_article_sale) die(mysql_error());
$no_row_article_sale = mysql_num_rows($q_article_sale);
$no_row_article = $no_row_article_buy + $no_row_article_sale;

$q_news = mysql_query("SELECT * FROM rockinus.news_info;");
if(!$q_news) die(mysql_error());
$no_row_news = mysql_num_rows($q_news);

$interview = mysql_query("SELECT count(*) as cnt FROM rockinus.interview_question");
if(!$interview)	die("Error quering the Database: " . mysql_error());
$interview_f = mysql_fetch_object($interview);
$interview_cnt = $interview_f->cnt;

//$q_roommate = mysql_query("SELECT * FROM rockinus.room_mate_info;");
//if(!$q_roommate) die(mysql_error());
//$no_row_room_mate = mysql_num_rows($q_roommate);

//$q_book = mysql_query("SELECT * FROM rockinus.book_info;");
//if(!$q_book) die(mysql_error());
//$no_row_book = mysql_num_rows($q_book);

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
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
<!--
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
	$("#commentStatusDiv<?php echo($memoid) ?>").hide();
	$("#displayCommentStatus<?php echo($memoid) ?>").hide();
	
	$("div .SignUpButton").click(function () {
	  //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#SignUpButton").hide();
	  $("#HomePageDiv").hide();
	  $("#SignUpDiv").show();
	});
	
	$("#CancelSignUpButton<?php echo($memoid) ?>").click(function () {
	  $("#SignUpDiv").hide();
	  $("#HomePageDiv").show();
	  $("#SignUpButton").show();
	});
	
	$("div .jobJoinUsBtn").click(function () {
	  //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#SignUpButton").hide();
	  $("#HomePageDiv").hide();
	  $("#jobDiv").hide();
	  $("#courseDiv").hide();
	  $("#saleDiv").hide();
	  $("#alumniDiv").hide();
	  $("#SignUpDiv").show();
	});
	
	$("div .courseJoinUsBtn").click(function () {
	  //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#SignUpButton").hide();
	  $("#HomePageDiv").hide();
	  $("#jobDiv").hide();
	  $("#courseDiv").hide();
	  $("#saleDiv").hide();
	  $("#alumniDiv").hide();
	  $("#SignUpDiv").show();
	});
	
	$("div .saleJoinUsBtn").click(function () {
	  //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#SignUpButton").hide();
	  $("#HomePageDiv").hide();
	  $("#jobDiv").hide();
	  $("#courseDiv").hide();
	  $("#saleDiv").hide();
	  $("#alumniDiv").hide();
	  $("#SignUpDiv").show();
	});
	
	$("div .alumniJoinUsBtn").click(function () {
	  //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#SignUpButton").hide();
	  $("#HomePageDiv").hide();
	  $("#jobDiv").hide();
	  $("#courseDiv").hide();
	  $("#saleDiv").hide();
	  $("#alumniDiv").hide();
	  $("#SignUpDiv").show();
	});
});
</script>
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
			$("#uname_err").html('<span class="error" style="font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif">Too short</span>');
			hasError = true; 
		}else if(unameJoinUsValue.length > 20){
			$("#uname_err").html('<span class="error" style="font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif">Too long</span>');
			hasError = true; 
		}
		
		if(fnameJoinUsValue.length < 2 || !isLetter(fnameJoinUsValue)){
			$("#fname_err").show();
			$("#fname_err").html('<span class="error" style="font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif">Invalid</span>');
			hasError = true; 
		}
		
		if(lnameJoinUsValue.length < 2 || !isLetter(lnameJoinUsValue)){
			$("#lname_err").show();
			$("#lname_err").html('<span class="error" style="font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif">Invalid</span>');
			hasError = true; 
		}
		
		if (passwordVal.length<6) {            
			$("#complexity").hide();
			$("#passwd_err").show();
			$("#passwd_err").html('<span class="error" style="font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif">Too short</span>');           
			hasError = true;        
		}
		
		if (genderValue.length <1) {            
			//$("#complexity").hide();
			$("#genderJoinUs").after('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="error" style="font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif">What\'s your gender?</span>');           
			hasError = true;        
		}  
		
		if (emailJoinUsValue.length<6 )
		{	
			email_err.html('<span class="error" style="font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif">Invalid</span>');
			email_err.fadeIn(400);
			//email_err.fadeIn(400).fadeOut(400).fadeIn(400);
			emailJoinUs.focus();
			hasError = true;
		}
		else if(hasError != true)
		{
			//if (!IsValidEmail(emailJoinUsValue))
			if (!is_email(emailJoinUsValue))
			{
				email_err.html('<span class="error" style="font-weight:bold; font-size:14px; font-family:Arial, Helvetica, sans-serif">Invalid email address</span>');
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
		var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
//		var filter = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.+-]+\.edu$/; 
		return filter.test(email);
	}
	
	function isLetter(s) 
	{ 
  		return s.match("^[a-zA-Z\(\)]+$");     
	} 
});
</script>
<?php include("main_header.php") ?>
<style type="text/css">
<!--
body {
	
}
-->
</style><div id="dailyupdate" style="width:100%;" align="center">
<div style="background-image: url(img/home_cover.jpg); background-repeat: no-repeat; width:1024px" >
<table width="1024" height="592" border="0" cellpadding="0" cellspacing="0" bgcolor="" style=" border:0px solid #EEEEEE; background-repeat:no-repeat; margin-bottom:0">
  <tr>
    <td width="1024" height="570" align="center" valign="top" style="font-size:36px; color:; padding-top:20px">
	<div class="HomePageDiv" id="HomePageDiv">
	<table width="1035" height="149" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="539" valign="top">&nbsp;</td>
        <td width="496" valign="top" style="padding-top:0"><div id="" class="" style="width:480; background:" align="right">
	<form action="login_process.php" method="post" style="margin-top:0px;">
	<div style="border:18px solid #F5F5F5; width:410px; margin-top:-80px; -moz-border-radius: 10px; border-radius: 10px; ">
        <table width="410" height="164" border="0" cellpadding="0" cellspacing="0" style=" border:1px #DDDDDD solid; background:#FFF">
          <tr>
            <td height="25" colspan="2" align="left" style="padding-left:15px; color:#333333">&nbsp;</td>
          </tr>
          <tr>
            <td width="146" height="32" align="right" style="padding-right:15; color: #000000; font-size:12px; font-family:Arial, Helvetica, sans-serif">Username or Email</td>
            <td width="226" height="32" align="left" style=" color:; font-size:12px"><input type="text" style="height:25px; padding:2px; font-size:13px; font-weight:normal; font-family: Arial, Helvetica, sans-serif;" name="usrname" size="25" onmouseover="this.className='over'" onmouseout="this.className='out'" class="box_login" value="<?php if(isset($_COOKIE["user"])) echo($_COOKIE["user"]); ?>" /></td>
          </tr>
          <tr>
            <td height="32" align="right" style="padding-right:15; color: #000000; font-size:12px; font-family:Arial, Helvetica, sans-serif">Login Password</td>
            <td height="32" align="left" style="padding-left:0; color:; font-size:12px"><input type="password" style="height:25px;font-size:13px; padding:2; font-weight:normal; font-family: Arial, Helvetica, sans-serif;" name="passwd" onmouseover="this.className='over'" onmouseout="this.className='out'" class="box_login" size="25" /></td>
          </tr>
          <tr>
            <td height="64" align="right" valign="top" style="padding-right:15px; padding-top:10px; font-size:12px; color:#F5F5F5"></td>
            <td height="64" align="left" style="padding-left:; font-size:12px; font-family:Arial, Helvetica, sans-serif; padding-top:10" valign="top"><input type="submit" name="Submit" value=" Sign In " style="font-size:12px; background: url(img/master.jpg); color:#333333; height:24; padding:2 4 2 4; border:1px solid #CCCCCC; font-family:Arial, Helvetica, sans-serif; cursor:pointer" onmouseover="this.style.background='url(img/GrayGradbgDown.jpg)'" onmouseout="this.style.background='url(img/master.jpg)'"/>
              &nbsp;&nbsp;&nbsp;&nbsp; <a href="main_findPass.php" class="one" style="color:#000000 ">Forgot Password?</a></td>
          </tr>
        </table>
		</div>
      </form>
	    <div style=" margin-top:25; margin-left:0; width:410; padding:40 15 5 0; margin-bottom:10px; border-right:0px dashed #CCCCCC; color:; line-height:150%; font-weight:normal; font-size:16px; font-family:Arial, Helvetica, sans-serif; background: ; background-repeat: repeat-x" align="left">
          <div style="line-height:120%; margin-bottom:15px" align="left">
            <h1 style="font-family:'ADMUI3', Georgia, serif">We boost you!!! </h1>
          </div>
	      <table width="480" height="160" border="0" cellpadding="0" cellspacing="0" style="margin-top:0;">
            <tr>
              <td height="20" align="left" valign="top" style=" background-repeat:repeat-x; padding-top:0; line-height:130%">&nbsp;&nbsp;&nbsp;&nbsp;
                  <div style=" font-size:14px; color:; font-family:Arial, Helvetica, sans-serif; font-weight:" align="left"> Find your alumni</div>
                  <div style=" font-size:14px; color:#000000; font-family:Arial, Helvetica, sans-serif; font-weight:" align="left">Campus notices, events</div>
                <div style=" font-size:14px; color:#000000; font-family:Arial, Helvetica, sans-serif; font-weight:" align="left">Latest interviews &amp; solutions</div>
                <div style=" font-size:14px; color:#000000; font-family:Arial, Helvetica, sans-serif; font-weight:" align="left">Course comment &amp; exam questions </div>
                <div style=" font-size:14px; color:#000000; font-family:Arial, Helvetica, sans-serif; font-weight:" align="left">Aptartment, sales, roommate, textbook </div>
                <div style=" font-size:14px; color:; font-family:Arial, Helvetica, sans-serif; font-weight:" align="left"> Subscribe interested channels </div>
                <div style=" margin-top:0; font-size:14px; color:; font-family:Arial, Helvetica, sans-serif; font-weight:" align="left">This is your home, forever! </div></td>
            </tr>
          </table>
	      <div style=" height:35; padding-top:20; padding-bottom:3; margin-bottom:35; background:; border:0px solid #DDDDDD; width:175; border-top:0px solid #CCCCCC; border-bottom:0px solid #CCCCCC; vertical-align:middle; cursor:pointer" align="left" class="SignUpButton" id="SignUpButton">
            <table width="170" height="30" border="0" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor='#F5F5F5';" onmouseout=" this.style.backgroundColor='#EEEEEE';">
              <tr>
                <td width="200" align="left" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; color:; padding-left:10px; padding-top:1; font-weight:normal; border-bottom:1px solid #000000; border-right:1px solid #000000; background: url(img/black_cell_bg.jpg)"><font color="#FFFFFF">+ Sign Up Now <font color="#CCCCCC" style="font-weight:normal; font-size:12px">(Very fast)</font></font></td>
              </tr>
            </table>
	        </div>
	      </div>
        <table width="410" height="80" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="307" align="right" style="padding-right:5px"><img src="img/google_plus.png" width="30" height="30" /></td>
            <td width="34"><img src="img/facebookIcon.png" width="30" height="30" /></td>
            <td width="30"><img src="img/twitter.png" width="30" height="30" /></td>
            <td width="39" style="padding-left:5"><img src="img/linkedin.png" width="30" height="30" /></td>
          </tr>
        </table>
        </div>
          <div style="margin-left:-200px; margin-top:40px"></div>
		  </td>
      </tr>
    </table>
	</div>
	
	<div class="SignUpDiv" id="SignUpDiv" style="-moz-border-radius: 15px; border-radius: 15px; margin-top:-50px; margin-left:300px; border:24px solid #F5F5F5; width:680; display:none" align="center">
      <form action="joinUs_process.php" method="post" name="infoForm" id="infoForm">
        <table width="680" border="0" cellpadding="0" cellspacing="0" style="margin-top:0; margin-bottom:0; background:#FFF; border:1px #CCCCCC solid" bgcolor="">
          <tr>
            <td height="110" colspan="2" align="left" valign="middle" style="padding-right:7; color:; font-family: Arial, Helvetica, sans-serif; padding-left:100">
			<h1>We'd love you to be No.<?php $no_row_user = $no_row_user+1; echo($no_row_user) ?> user</h1></td>
            </tr>
          <tr>
            <td width="217" height="35" align="right" valign="middle" style="padding-right:7; color:; font-size:13px; font-family: Arial, Helvetica, sans-serif">Pickup a username</td>
            <td width="449" height="35" valign="middle" style="padding-left:10"><input name="uname" type="text" id="username" class="unif_input" maxlength="20" size="28" style="font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif; padding:2; height:25; background-color:#F5F5F5; border:1px solid #CCCCCC" value="<?php if(isset($_SESSION['join_uname'])){echo($_SESSION['join_uname']); unset($_SESSION['join_uname']);}?>" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id="tick" src="img/tick.png" width="16" height="16"/><img id="cross" src="img/cross.png" width="16" height="16" style="margin-right:5px"/>
              <div id="uname_err" style="display:inline"></div></td>
          </tr>
          <tr>
            <td width="217" height="35" align="right" valign="middle" style="padding-right:7; font-size:13px; font-family: Arial, Helvetica, sans-serif">First Name</td>
            <td width="449" height="35" valign="middle" style="padding-left:10"><input name="fname" type="text" id="fname" class="unif_input" maxlength="30" size="28" style="font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif; padding:2; height:25" value="<?php if(isset($_SESSION['fname'])){echo($_SESSION['fname']); unset($_SESSION['fname']);}?>" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999999; font-size:12px; font-family: Arial, Helvetica, sans-serif">(At least 2 letters)</span> </td>
          </tr>
          <tr>
            <td width="217" height="35" align="right" valign="middle" style="padding-right:7; font-size:13px; font-family: Arial, Helvetica, sans-serif">Last Name</td>
            <td width="449" height="35" valign="middle" style="padding-left:10">
			<input name="lname" type="text" id="lname" class="unif_input" maxlength="30" size="28" style="font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif; padding:2; height:25" value="<?php if(isset($_SESSION['lname'])){echo($_SESSION['lname']); unset($_SESSION['lname']);}?>" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999999; font-size:12px; font-family: Arial, Helvetica, sans-serif">(At least 2 letters)</span></td>
          </tr>
          <tr >
            <td height="35" align="right" style="padding-right:7; font-size:13px; font-family: Arial, Helvetica, sans-serif">Your Email address</td>
            <td height="35" style="padding-left:10"><input name="email" type="text" id="emailJoinUs" class="unif_input" size="28" style="font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif; padding:2; height:25" value="<?php if(isset($_SESSION['email'])){echo($_SESSION['email']); unset($_SESSION['email']);}?>" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id="tick_email" src="img/tick.png" width="16" height="16" style="margin-right:10px"/><img id="cross_email" src="img/cross.png" width="16" height="16" style="margin-right:10px"/><span id="email_err" class="email_err" style="display:none; margin-right:10px"></span><span style="color:#999999; font-size:12px; font-family: Arial, Helvetica, sans-serif">(Can be used for login)</span></td>
          </tr>
          <tr >
            <td height="35" align="right" style="padding-right:7; font-size:13px; font-family: Arial, Helvetica, sans-serif">Set Password</td>
            <td height="35"  style="padding-left:10"><input name="passwd" type="password" class="unif_input" id="inputPassword" size="28" style="font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif; padding:2; height:25" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="passwd_err" style="display:none; margin-right:10px"></span><span id="complexity" class="default"></span> </td>
          </tr>
          <tr >
            <td height="35" align="right" style="padding-right:7; font-size:13px; font-family: Arial, Helvetica, sans-serif">I'm</td>
            <td height="35"  style="padding-left:10; "><select name="gender" id="genderJoinUs" style="font-family:Arial, Helvetica, sans-serif; font-size:13px">
                <option value="">Select gender</option>
                <option value="Female" <?php if(isset($_SESSION['gender'])&&$_SESSION['gender']=="Female"){echo("selected"); unset($_SESSION['gender']);}?>>Female</option>
                <option value="Male" <?php if(isset($_SESSION['gender'])&&$_SESSION['gender']=="Male"){echo("selected"); unset($_SESSION['gender']); }?>>Male</option>
            </select></td>
          </tr>
          <tr>
            <td height="50" align="right" style="padding-right:7; font-size:14px"></td>
            <td height="50"  style="padding-left:10"><font color="#333333" style="font-size:12px; font-weight:normal; font-family: Arial, Helvetica, sans-serif">Click sumbit means you have read <br />and agree with the <a href="main_agreement.php" class="one" target="_blank"><font color="#660099">User Agreement</font></a></font> </td>
          </tr>
          <tr bgcolor="">
            <td height="120" background="">&nbsp;</td>
            <td height="120" valign="top" background="" style="padding-left:10px; padding-top:20px">
			<input name="Submit2" type="submit" class="btn2" id="submitJoinUs" value=" Submit " style=" background: #666; border:0; padding-left:8; padding-right:8; color:#FFF; height:25; padding-bottom:3; font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight: normal; cursor:pointer" />
              &nbsp;&nbsp; 
			  			  <input type="button" class="btn2" id="CancelSignUpButton" value="Go Login" class="CancelSignUpButton" style=" background: #999999; border:0; padding-left:8; padding-right:8; color:#FFF; height:25; padding-bottom:3; font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight: normal; cursor:pointer" />
			  </td>
          </tr>
        </table>
      </form>
	  </div>
	  
	  
	  <div class="jobDiv" id="jobDiv" style=" -moz-border-radius: 15px; border-radius: 15px; margin-bottom:30px; margin-top:-50px; margin-left:300px; border:24px solid #F5F5F5; width:680; display:none" align="center">
	          <table width="680" border="0" cellpadding="0" cellspacing="0" style="margin-top:0; margin-bottom:0; background:#FFF; border:1px #CCCCCC solid" bgcolor="">
          <tr>
            <td height="110" colspan="2" align="left" valign="middle" style="padding-right:7; color:; font-family: Georgia, 'Times New Roman', Times, serif; padding:25; font-size:18px;">
	  <div style="color:#FF9966"><h2><img src="img/yellowChatIcon.png" width="25" />&nbsp;&nbsp;Looking for Job.Employment?</h2></div>
	  <div style="margin-top:20">Rockinus can favor you by:</div>
	  <div style="margin-top:15"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Latest interview questions, discussion & solutions</div>
	  <div style="margin-top:5"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Connecting with alumni for internal referrals, getting chances</div>
	  <div style="margin-top:5"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Following our public job information posts</div>
	  <div style="margin-top:15">Currently 78 posts are available & more's coming...</div>
	  <div style="margin-top:5"><span style='border-bottom:1px dashed #CCCCCC; color:#666666'>(Part-time, on-campus jobs are also included)</span></div>
	  <div style="margin-top:20; -moz-border-radius: 5px; border-radius: 5px; width:150px; height:25px; padding:5 0 5 0; background:#FF9966; border:1px solid #666666; color:#FFFFFF; cursor:pointer" id="jobJoinUsBtn" class="jobJoinUsBtn" align="center">
	  + Join Rockinus</div>
	  </td>
	  </tr>
	  </table>
	  </div>

	  <div class="courseDiv" id="courseDiv" style=" -moz-border-radius: 15px; border-radius: 15px; margin-bottom:30px; margin-top:-50px; margin-left:300px; border:24px solid #F5F5F5; width:680; display:none" align="center">
	          <table width="680" border="0" cellpadding="0" cellspacing="0" style="margin-top:0; margin-bottom:0; background:#FFF; border:1px #CCCCCC solid" bgcolor="">
          <tr>
            <td height="110" colspan="2" align="left" valign="middle" style="padding-right:7; color:; font-family: Georgia, 'Times New Roman', Times, serif; padding:25; font-size:18px;">
	  <div style="color: #3399CC"><h2><img src="img/clipboard.png" width="25" />&nbsp;&nbsp;Quality study = Smart learning approach</h2></div>
	  <div style="margin-top:20">Rockinus can favor you by:</div>
	  <div style="margin-top:15"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Course comments, rating, questions&answers</div>
	  <div style="margin-top:5"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Previous test questions, workaround discussions</div>
	  <div style="margin-top:5"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Sharing open resources like syllubus, notes, etc.</div>
	  <div style="margin-top:5"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Computer science, electrical engineering, civil engineering, financial, etc.</div>
	  <div style="margin-top:15">Currently 108 posts are available & more's coming...</div>
	  <div style="margin-top:5"><span style='border-bottom:1px dashed #CCCCCC; color:#666666'>(Feel free to comment courses you took)</span></div>
	  <div style="margin-top:20; -moz-border-radius: 5px; border-radius: 5px; width:150px; height:25px; padding:5 0 5 0; background:#3399CC; border:1px solid #666666; color:#FFFFFF; cursor:pointer" id="courseJoinUsBtn" class="courseJoinUsBtn" align="center">
	  + Join Rockinus</div>
	  </td>
	  </tr>
	  </table>
	  </div>



	  <div class="saleDiv" id="saleDiv" style=" -moz-border-radius: 15px; border-radius: 15px; margin-bottom:30px; margin-top:-50px; margin-left:300px; border:24px solid #F5F5F5; width:680; display:none" align="center">
	          <table width="680" border="0" cellpadding="0" cellspacing="0" style="margin-top:0; margin-bottom:0; background:#FFF; border:1px #CCCCCC solid" bgcolor="">
          <tr>
            <td height="110" colspan="2" align="left" valign="middle" style="padding-right:7; color:; font-family: Georgia, 'Times New Roman', Times, serif; padding:25; font-size:18px;">
	  <div style="color: #4CC552"><h2><img src="img/Shopping_cart_2.png" width="25" />&nbsp;&nbsp;Do you need a metro card on sale? <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Or you may need a room to rent? </h2></div>
	  <div style="margin-top:20">Rockinus can favor you by:</div>
	  <div style="margin-top:15"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Posting/Finding things for sale, cheap or free</div>
	  <div style="margin-top:5"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Posting/Finding apartments for rent or lease</div>
	  <div style="margin-top:5"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Finding roommates</div>
	  <div style="margin-top:5"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Things unexpected may cost free, textbook? You never know</div>
	  <div style="margin-top:15">Currently 23 posts are available & more's coming...</div>
	  <div style="margin-top:5"><span style='border-bottom:1px dashed #CCCCCC; color:#666666'>(Feel free to share your item)</span></div>
	  <div style="margin-top:20; -moz-border-radius: 5px; border-radius: 5px; width:150px; height:25px; padding:5 0 5 0; background:#4CC552; border:1px solid #666666; color:#FFFFFF; cursor:pointer" id="saleJoinUsBtn" class="saleJoinUsBtn" align="center">
	  + Join Rockinus</div>
	  </td>
	  </tr>
	  </table>
	  </div>


	  <div class="alumniDiv" id="alumniDiv" style=" -moz-border-radius: 15px; border-radius: 15px; margin-bottom:30px; margin-top:-50px; margin-left:300px; border:24px solid #F5F5F5; width:680; display:none" align="center">
	          <table width="680" border="0" cellpadding="0" cellspacing="0" style="margin-top:0; margin-bottom:0; background:#FFF; border:1px #CCCCCC solid" bgcolor="">
          <tr>
            <td height="110" colspan="2" align="left" valign="middle" style="padding-right:7; color:; font-family: Georgia, 'Times New Roman', Times, serif; padding:25; font-size:18px;">
	  <div style="color: #6C2DC7"><h2><img src="img/people-y.png" width="25" />&nbsp;&nbsp;Never lose contact with alumni, please!</h2></div>
	  <div style="margin-top:20">Rockinus can favor you by:</div>
	  <div style="margin-top:15"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Finding/Maintaining people went to your school</div>
	  <div style="margin-top:5"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Finding/Maintaining people went to your major</div>
	  <div style="margin-top:5"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Finding/Maintaining people from your hometown</div>
	  <div style="margin-top:5"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Finding/Maintaining people who maybe important to you</div>
	  <div style="margin-top:5"><img src="img/blackArrow.png" width="12" />&nbsp;&nbsp;Boosting you with more important connections</div>
	  <div style="margin-top:15">Currently 111 alumni joined us & Who's next?</div>
	  <div style="margin-top:5"><span style='border-bottom:1px dashed #CCCCCC; color:#666666'>(Feel free to invite your friends in)</span></div>
	  <div style="margin-top:20; -moz-border-radius: 5px; border-radius: 5px; width:150px; height:25px; padding:5 0 5 0; background:#6C2DC7; border:1px solid #666666; color:#FFFFFF; cursor:pointer" id="alumniJoinUsBtn" class="alumniJoinUsBtn" align="center">
	  + Join Rockinus</div>
	  </td>
	  </tr>
	  </table>
	  </div>

	  </td>
  </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
</div>
</div>
