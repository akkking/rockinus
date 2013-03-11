<?php 
include 'dbconnect.php';
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

$q_roommate = mysql_query("SELECT * FROM rockinus.room_mate_info;");
if(!$q_roommate) die(mysql_error());
$no_row_room_mate = mysql_num_rows($q_roommate);

$q_book = mysql_query("SELECT * FROM rockinus.book_info;");
if(!$q_book) die(mysql_error());
$no_row_book = mysql_num_rows($q_book);

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
		else
		{
			if (!IsValidEmail(emailJoinUsValue))
			{
				email_err.html('<span class="error" style="font-weight:bold; font-size:14px; font-family:Arial, Helvetica, sans-serif">Only .edu</span>');
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
<?php include("main_header.php") ?>
<div id="dailyupdate" style="width:100%;" align="center">
<table width="1024" height="415" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style=" border:0px solid #EEEEEE; background-repeat:no-repeat; margin-bottom:30">
  <tr>
    <td width="1024" align="center" valign="top" style="font-size:36px; color:#FFFFFF; padding-bottom:10">
	<div class="HomePageDiv" id="HomePageDiv">
	<table width="1035" height="149" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="539" valign="top"><div style=" margin-top:15; margin-left:0; width:400; padding:0 15 5 5; margin-bottom:20; border:0px dashed #EEEEEE; color:; line-height:150%; font-weight:normal; font-size:16px; font-family:Arial, Helvetica, sans-serif; background: ; background-repeat: repeat-x">
            <div style=" height:20; padding-top:8; padding-bottom:8; margin-bottom:40; background: #F5F5F5; border:0px solid #DDDDDD; width:380; border-top:1px solid #CCCCCC; border-bottom:1px solid #CCCCCC; vertical-align:middle; cursor:pointer" align="center" class="SignUpButton" id="SignUpButton"> 
              <table width="380" height="20" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="220" align="left" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#57068C; padding-left:10; font-weight:bold;">
				  + Sign Up with Rockinus</td>
                  <td width="160" align="right" style="padding-right:5"><img src="img/userIcon.jpg" width="18"/>&nbsp;</td>
                </tr>
              </table>
            </div>
            <div style="margin-bottom:15; font-weight:bold; padding-bottom:0; border-bottom:0px solid #CCCCCC; width:380">
			What's new?</div>
				<div style=" background:; width:380;  height:30; padding-top:2; line-height:150%; margin-top:5; border-bottom:1px solid #EEEEEE">
				  <table width="380" height="25" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="280" align="left" style="font-size:13px">People signed up</td>
                      <td width="100" align="right" style="font-size:13px; padding-right:10"><?php echo $no_row_user ?></td>
                    </tr>
                  </table>
				  </div>
				<div style=" background:; width:380;  height:30; padding-top:2; line-height:150%; margin-top:5; border-bottom:1px solid #EEEEEE">
                  <table width="380" height="25" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="280" align="left" style="font-size:13px">Campus notices, Events, etc. </td>
                      <td width="100" align="right" style="font-size:13px; padding-right:10"><?php echo $no_row_news ?></td>
                    </tr>
                  </table>
				  </div>
				<div style=" background:; width:380;  height:30; padding-top:2; line-height:150%; margin-top:5; border-bottom:1px solid #EEEEEE">
                  <table width="380" height="25" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="280" align="left" style="font-size:13px">Course comment based on <?php echo $no_row_course ?> courses</td>
                      <td width="100" align="right" style="font-size:13px; padding-right:10"><?php echo $no_row_course_memo ?></td>
                    </tr>
                  </table>
				  </div>
				<div style=" background:; width:380;  height:30; padding-top:2; line-height:150%; margin-top:5; border-bottom:1px solid #EEEEEE">
                  <table width="380" height="25" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="280" align="left" style="font-size:13px">Course notes, materials uploaded </td>
                      <td width="100" align="right" style="font-size:13px; padding-right:10">17</td>
                    </tr>
                  </table>
				  </div>
				<div style=" background:; width:380;  height:30; padding-top:2; line-height:150%; margin-top:5; border-bottom:1px solid #EEEEEE">
                  <table width="380" height="25" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="280" align="left" style="font-size:13px">Room mates seeking / text book posts </td>
                      <td width="100" align="right" style="font-size:13px; padding-right:10">
					  <?php echo $no_row_room_mate ?> / <?php echo $no_row_book ?></td>
                    </tr>
                  </table>
				  </div>
				<div style=" background:; width:380; height:30; padding-top:2; line-height:150%; margin-top:5; border-bottom:1px solid #EEEEEE">
                  <table width="380" height="25" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="280" align="left" style="font-size:13px">Apartment/Room for rental and Lease </td>
                      <td width="100" align="right" style="font-size:13px; padding-right:10"><?php echo $no_row_house ?></td>
                    </tr>
                  </table>
				  </div>
				<div style=" background:; width:380; height:30; padding-top:2; line-height:150%; margin-top:5; border-bottom:1px solid #EEEEEE">
                  <table width="380" height="25" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="280" align="left" style="font-size:13px">Items for sale or asked to purchase </td>
                      <td width="100" align="right" style="font-size:13px; padding-right:10"><?php echo $no_row_article ?></td>
                    </tr>
                  </table>
				  </div>
				<div style=" background:; width:380; height:30; padding-top:2; line-height:150%; margin-top:5; border-bottom:1px solid #EEEEEE">
                  <table width="380" height="25" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="280" align="left" style="font-size:13px">Friend connections had been made </td>
                      <td width="100" align="right" style="font-size:13px; padding-right:10"><?php echo $no_row_friend ?></td>
                    </tr>
                  </table>
				  </div>
        </div></td>
        <td width="496" valign="top" style="padding-top:10"><div id="" class="" style="width:470; background:">
	<form action="login_process.php" method="post" style="margin-top:0px;">
	<div style="border:18px solid #EEEEEE; width:450">
        <table width="450" height="160" border="0" cellpadding="0" cellspacing="0" style=" border:1px #CCCCCC solid">
          <tr>
            <td height="50" colspan="2" align="left" style="padding-left:15px; color:#333333">&nbsp;</td>
          </tr>
          <tr>
            <td width="165" height="35" align="right" style="padding-right:15; color: #000000; font-size:12px; font-family:Arial, Helvetica, sans-serif">Username or Email</td>
            <td width="271" height="35" align="left" style=" color:; font-size:12px"><input type="text" style="height:25px; padding:2px; font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif;" name="usrname" size="30" onmouseover="this.className='over'" onmouseout="this.className='out'" class="box_login" value="<?php if(isset($_COOKIE["user"])) echo($_COOKIE["user"]); ?>" /></td>
          </tr>
          <tr>
            <td height="35" align="right" style="padding-right:15; color: #000000; font-size:12px; font-family:Arial, Helvetica, sans-serif">Login Password</td>
            <td height="35" align="left" style="padding-left:0; color:; font-size:12px"><input type="password" style="height:25px;font-size:14px; padding:2; font-weight:normal; font-family: Arial, Helvetica, sans-serif;" name="passwd" onmouseover="this.className='over'" onmouseout="this.className='out'" class="box_login" size="30" /></td>
          </tr>
          <tr>
            <td height="110" align="left" style="padding-left:15px; font-size:12px; color:#F5F5F5"></td>
            <td height="110" align="left" style="padding-left:; font-size:12px; font-family:Arial, Helvetica, sans-serif; padding-top:20" valign="top"><input type="submit" name="Submit" value=" Sign In " style="font-size:12px; background: #7AC142; color:#FFFFFF; height:23; padding:2 4 2 4; border:1px solid #999999; font-family:Arial, Helvetica, sans-serif; cursor:pointer" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="main_findPass.php" class="one" style="color:#000000 ">Forget Password?</a></td>
          </tr>
        </table>
		</div>
      </form>
	    </div>
		<table width="470" height="70" border="0" cellpadding="0" cellspacing="0" style="margin-top:60;">
  <tr>
    <td width="101" style=" background-repeat:repeat-x">&nbsp;</td>
  </tr>
  <tr>
    <td width="101" height="23" style=" background-repeat:repeat-x; font-size:13px; padding-left:18; color:#000000"><img src="img/RightArrow.jpg" width="12" height="12" />&nbsp; Find &nbsp;</td>
    <td width="369" height="23"><div style="width:370; font-size:12px; color:#57068C; font-family:Arial, Helvetica, sans-serif; font-weight:" align="right"> Course, House, Sales, Notice, People</div></td>
    </tr>
  <tr>
    <td width="101" height="23" style=" background-repeat:repeat-x; font-size:13px; padding-left:18; color:#000000"><img src="img/RightArrow.jpg" width="12" height="12" />&nbsp; Create</td>
    <td height="23"><div style="width:370; font-size:12px; color:; font-family:Arial, Helvetica, sans-serif; font-weight:" align="right"> Your own paper@Rockinus.com</div></td>
  </tr>
  <tr>
    <td width="101" height="23" style=" background-repeat:repeat-x; font-size:13px; padding-left:18; color:#000000"><img src="img/RightArrow.jpg" width="12" height="12" />&nbsp; Stay</td>
    <td height="23"><div style="width:370; margin-top:5; font-size:12px; color:; font-family:Arial, Helvetica, sans-serif; font-weight:" align="right"> Real, Helpful, First-rate of you</div></td>
  </tr>
</table>

		  </td>
      </tr>
    </table>
	</div>
	
	<div class="SignUpDiv" id="SignUpDiv" style=" margin-top:0; border:24px solid #EEEEEE; width:700; display:none" align="center">
      <form action="joinUs_process.php" method="post" name="infoForm" id="infoForm">
        <table width="700" border="0" cellpadding="0" cellspacing="0" style="margin-top:0; margin-bottom:0; border:1px #CCCCCC solid" bgcolor="#FFFFFF">
          <tr>
            <td height="110" colspan="2" align="left" valign="middle" style="padding-right:7; color:; font-size:32px; font-family: Arial, Helvetica, sans-serif; padding-left:100">
			Join now, be the Great No.<?php $no_row_user = $no_row_user+1; echo($no_row_user) ?> user</td>
            </tr>
          <tr>
            <td width="217" height="35" align="right" valign="middle" style="padding-right:7; color:; font-size:13px; font-family: Arial, Helvetica, sans-serif">Pickup a name</td>
            <td width="449" height="35" valign="middle" style="padding-left:10"><input name="uname" type="text" id="username" class="unif_input" maxlength="30" size="28" style="font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif; padding:2; height:25; background-color:#F5F5F5; border:1px solid #CCCCCC" value="<?php if(isset($_SESSION['join_uname'])){echo($_SESSION['join_uname']); unset($_SESSION['join_uname']);}?>" />
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
            <td height="35" align="right" style="padding-right:7; font-size:13px; font-family: Arial, Helvetica, sans-serif">School Email ID</td>
            <td height="35" style="padding-left:10"><input name="email" type="text" id="emailJoinUs" class="unif_input" size="28" style="font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif; padding:2; height:25" value="<?php if(isset($_SESSION['email'])){echo($_SESSION['email']); unset($_SESSION['email']);}?>" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id="tick_email" src="img/tick.png" width="16" height="16" style="margin-right:10px"/><img id="cross_email" src="img/cross.png" width="16" height="16" style="margin-right:10px"/><span id="email_err" class="email_err" style="display:none; margin-right:10px"></span><span style="color:#999999; font-size:12px; font-family: Arial, Helvetica, sans-serif">(Can be used for login)</span></td>
          </tr>
          <tr >
            <td height="35" align="right" style="padding-right:7; font-size:13px; font-family: Arial, Helvetica, sans-serif">Set Password</td>
            <td height="35"  style="padding-left:10"><input name="passwd2" type="password" class="unif_input" id="inputPassword" size="28" style="font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif; padding:2; height:25" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="passwd_err" style="display:none; margin-right:10px"></span><span id="complexity" class="default"></span> </td>
          </tr>
          <tr >
            <td height="35" align="right" style="padding-right:7; font-size:13px; font-family: Arial, Helvetica, sans-serif">I'm</td>
            <td height="35"  style="padding-left:10; "><select name="gender" id="genderJoinUs" style="font-family:Arial, Helvetica, sans-serif; font-size:14px">
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
			<input name="Submit2" type="submit" class="btn2" id="submitJoinUs" value=" Submit " style=" background: #336699; border:0; padding-left:8; padding-right:8; color:#FFFFFF; height:30; font-size:14px; font-weight: normal" />
              &nbsp;&nbsp; 
			  <input type="button" class="btn2" id="CancelSignUpButton" value="Go Login" class="CancelSignUpButton" style=" background: #999999; border:0; padding-left:8; padding-right:8; color:#FFFFFF; height:30; font-size:14px; font-weight: normal; cursor:pointer" />
			  </td>
          </tr>
        </table>
      </form>
	  </div></td>
  </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
</div>
