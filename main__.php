<?php 
session_start();
include 'dbconnect.php';
header("Content-Type: text/html; charset=gb2312");

$q_user = mysql_query("SELECT * FROM rockinus.user_info;");
if(!$q_user) die(mysql_error());
$no_row_user = mysql_num_rows($q_user);

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

		if(unameJoinUsValue == "" || unameJoinUsValue.length < 5){
			$("#uname_err").html('<span class="error" style="font-weight:bold; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">Too short</span>');
			hasError = true; 
		}
		
		if(fnameJoinUsValue.length < 3 || !isLetter(fnameJoinUsValue)){
			$("#fname_err").show();
			$("#fname_err").html('<span class="error" style="font-weight:bold; font-size:13px; font-family:Verdana, Arial, Helvetica, sans-serif">Invalid</span>');
			hasError = true; 
		}
		
		if(lnameJoinUsValue.length < 3 || !isLetter(lnameJoinUsValue)){
			$("#lname_err").show();
			$("#lname_err").html('<span class="error" style="font-weight:bold; font-size:13px; font-family:Verdana, Arial, Helvetica, sans-serif">Invalid</span>');
			hasError = true; 
		}
		
		if (passwordVal.length<6) {            
			$("#complexity").hide();
			$("#passwd_err").show();
			$("#passwd_err").html('<span class="error" style="font-weight:bold; font-size:13px; font-family:Verdana, Arial, Helvetica, sans-serif">Too short</span>');           
			hasError = true;        
		}
		
		if (genderValue.length <1) {            
			//$("#complexity").hide();
			$("#genderJoinUs").after('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="error" style="font-weight:bold; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">What\'s your gender?</span>');           
			hasError = true;        
		}  
		
		if (emailJoinUsValue.length<6 )
		{	
			email_err.html('<span class="error" style="font-weight:bold; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">Invalid</span>');
			email_err.fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400);
			emailJoinUs.focus();
			hasError = true;
		}
		else
		{
			if (!IsValidEmail(emailJoinUsValue))
			{
				email_err.html('<span class="error" style="font-weight:bold; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">Only .edu</span>');
				email_err.fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400);
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
<div style="width:100%; background:; height:150;" align="center">
  <table width="1024" height="70" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:0px">
    <tr>
      <td width="682" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size:28px; line-height:100%; color:#; padding-top:15;" align="left" valign="top">
	  <a href="main.php" class="one"><font color="#663399" style="font-weight:bold">NYU</font>-<font color="#336633" style="font-weight:bold">Poly</font>'s Social Network </a>
          <table height="47" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size:28px; line-height:110%; color:; padding-top:10;" valign="top">Simple, Local &amp; free.&nbsp;</td>
              <td style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size:24px; line-height:110%; color:; padding-top:10;" height="47" valign="top"></td>
            </tr>
          </table>
        <font style="color:#333333; font-size:14px; font-family: Geneva, Arial, Helvetica, sans-serif; font-weight:normal" > Campus notices. Course board. Apartment rental. Things On-sale. Friends in school, etc. </font> </td>
      <td width="342" colspan="2" align="left"><form action="login_process.php" method="post" style="margin-top:0px;">
        <table width="340" height="80" border="0" cellpadding="0" cellspacing="0" style="">
          <tr>
            <td height="15" colspan="2" align="left" style="padding-left:15px; color:#333333">&nbsp;</td>
          </tr>
          <tr>
            <td width="126" height="30" align="right" style="padding-right:15; color: ; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>Username</strong></td>
            <td width="204" height="30" align="left" style=" color:; font-size:12px"><input type="text" style="height:25px; padding:2px; font-size:14px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif;" name="usrname" size="25" onmouseover="this.className='over'" onmouseout="this.className='out'" class="box_login" value="<?php if(isset($_COOKIE["user"])) echo($_COOKIE["user"]); ?>" /></td>
          </tr>
          <tr>
            <td height="30" align="right" style="padding-right:15; color: ; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>Password</strong></td>
            <td height="30" align="left" style="padding-left:0; color:; font-size:12px"><input type="password" style="height:25px;font-size:14px; padding:2; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif;" name="passwd" onmouseover="this.className='over'" onmouseout="this.className='out'" class="box_login" size="25" /></td>
          </tr>
          <tr>
            <td height="35" align="left" style="padding-left:15px; font-size:12px; color:#F5F5F5"><div style="padding-left:0px">
              <?php 
		  	if(isset($_SESSION['logoff_tag_1'])){
		  		echo $_SESSION['logoff_tag_1'];
				unset($_SESSION['logoff_tag_1']);
			}
		  ?>
            </div></td>
            <td height="35" align="left" style="padding-left:; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif"><input type="submit" name="Submit" value=" Sign In " style="font-size:11px; background: url(img/black_cell_bg.jpg); color:#FFFFFF; height:23; padding:2 4 2 4; border:1px solid #999999; font-family:Verdana, Arial, Helvetica, sans-serif" />
              &nbsp;&nbsp;<a href="main_findPass.php" class="one" style="color: ">Forget Password?</a></td>
          </tr>
        </table>
      </form></td>
    </tr>
  </table>
</div>

<div id="dailyupdate" style="width:100%" align="center">
<table width="1024" height="415" border="0" cellpadding="0" cellspacing="0" style="background-repeat:no-repeat">
  <tr><td width="393" align="left" valign="top" style="padding-top:20; border:0px #DDDDDD solid"><table width="330" height="286" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="100" height="133" valign="top"><img src="img/anuja.jpg" width="100" height="133" style="border:0px solid #CCCCCC" /></td>
      <td width="120" valign="top"><img src="img/adel.jpg" width="100" style="border:0px solid #CCCCCC; margin-left:10" /></td>
      <td width="110" valign="top"><img src="img/liuhongze.jpg" width="100" height="133" /></td>
    </tr>
    <tr>
      <td height="153" valign="top" style="padding-top:10"><img src="img/AndyCui.jpg" width="100" style="border:0px solid #CCCCCC" /></td>
      <td valign="top" style="padding:10"><img src="img/khaaliah.jpg" width="100" style="border:0px solid #CCCCCC" /></td>
      <td valign="top" style="padding:10; padding-left:0"><img src="img/luv.jpg" width="100" height="133" /></td>
    </tr>
  </table>
      <div style=" margin-top:20; width:290; padding:15; padding-top:15; margin-bottom:20; border:1px solid #EEEEEE; color:#336633; line-height:150%; font-weight:normal; border-top:1px solid #EEEEE; background-color:; font-size:16px; font-family:Verdana, Arial, Helvetica, sans-serif; background:url(img/GrayGradbgDown.jpg); background-repeat: repeat-x"> <div style="margin-bottom:20; font-weight:bold; padding-bottom:0; border-bottom:0px solid #CCCCCC">Something About Rockinus</div>
          <div style=" height:25; line-height:150%; margin-top:5; border-bottom:1px solid #EEEEEE"> <font color='#000000' style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; line-height:150%"> <?php echo $no_row_user ?> Students Joined Us<font color="#999999"> (<?php echo $no_row_user ?> from Poly)</font></font> </div>
          <div style=" height:25; line-height:150%; margin-top:5; border-bottom:1px solid #EEEEEE"> <font color='#000000' style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; line-height:150%"> <?php echo $no_row_news ?> Notice &amp; Events<font color="#999999"> (We collect notices daily)</font></font></div>
          <div style=" height:25; line-height:150%; margin-top:5; border-bottom:1px solid #EEEEEE"> <font color='#000000' style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; line-height:150%"> <?php echo $no_row_course_memo ?> Course comments <font color="#999999">(from <?php echo $no_row_course ?> courses)</font></font></div>
          <div style=" height:25; line-height:150%; margin-top:5; border-bottom:1px solid #EEEEEE"> <font color='#000000' style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; line-height:150%"> <?php echo $no_row_room_mate ?> look for roommates, <?php echo $no_row_book ?> text book posts</font></div>
          <div style=" height:25; line-height:150%; margin-top:5; border-bottom:1px solid #EEEEEE"> <font color='#000000' style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; line-height:150%"> <?php echo $no_row_house ?> House Posts <font color="#999999"> (<?php echo $no_row_house_rent ?> for rent, <?php echo $no_row_house_lease ?> for lease)</font></font></div>
          <div style=" height:25; line-height:150%; margin-top:5; border-bottom:1px solid #EEEEEE"> <font color='#000000' style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; line-height:150%"> <?php echo $no_row_article ?> Sales Post <font color="#999999"> (<?php echo $no_row_article_buy ?> want buy, <?php echo $no_row_article_sale ?> for sales)</font></font></div>
          <div style=" height:25; line-height:150%; margin-top:5; border-bottom:1px solid #EEEEEE"> <font color='#000000' style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; line-height:150%">  <?php echo $no_row_friend ?> friend connections had been made</font></div>
      </div></td>
    <td width="631" align="left" valign="top"><div class="joinUsDiv" id="joinUsDiv" style=" margin-top:20" >
    <form action="joinUs_process.php" method="post" name="infoForm">
      <table width="630" border="0" cellpadding="0" cellspacing="0" bgcolor="" style="margin-top:0; margin-bottom:0; border:0px #EEEEEE solid">
        <tr>
          <td height="90" colspan="2" align="left" valign="middle" style=" font-weight:normal; font-family: Arial, Helvetica, sans-serif; padding-left:70; padding-bottom:10; color:#333333; font-size:36px; line-height:100%"> Join Us today, You Rock!</td>
        </tr>
        <tr>
          <td width="157" height="35" align="right" valign="middle" style="padding-right:7; color:; font-size:14px; font-family: Verdana, Arial, Helvetica, sans-serif">Login Name</td>
          <td width="473" height="35" valign="middle" style="padding-left:10"><input name="uname" type="text" id="username" class="unif_input" maxlength="30" size="25" style="font-size:14px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif; padding:2; height:25; background-color:#F5F5F5" value="<?php if(isset($_SESSION['join_uname'])){echo($_SESSION['join_uname']); unset($_SESSION['join_uname']);}?>">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id="tick" src="img/tick.png" width="16" height="16"/><img id="cross" src="img/cross.png" width="16" height="16" style="margin-right:5px"/><div id="uname_err" style="display:inline"></div></td>
        </tr>
        <tr>
          <td width="157" height="35" align="right" valign="middle" style="padding-right:7; font-size:14px; font-family: Verdana, Arial, Helvetica, sans-serif">First Name</td>
          <td width="473" height="35" valign="middle" style="padding-left:10"><input name="fname" type="text" id="fname" class="unif_input" maxlength="30" size="25" style="font-size:14px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif; padding:2; height:25" value="<?php if(isset($_SESSION['fname'])){echo($_SESSION['fname']); unset($_SESSION['fname']);}?>">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="fname_err" style="display:none; margin-right:10px"></span><span style="color:#999999; font-size:12px; font-family: Verdana, Arial, Helvetica, sans-serif">(At least 3 letters)</span> </td>
        </tr>
        <tr>
          <td width="157" height="35" align="right" valign="middle" style="padding-right:7; font-size:14px; font-family: Verdana, Arial, Helvetica, sans-serif">Last Name</td>
          <td width="473" height="35" valign="middle" style="padding-left:10"><input name="lname" type="text" id="lname" class="unif_input" maxlength="30" size="25" style="font-size:14px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif; padding:2; height:25" value="<?php if(isset($_SESSION['lname'])){echo($_SESSION['lname']); unset($_SESSION['lname']);}?>">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="lname_err" style="display:none; margin-right:10px"></span><span style="color:#999999; font-size:12px; font-family: Verdana, Arial, Helvetica, sans-serif">(At least 3 letters)</span></td>
        </tr>
        <tr >
          <td height="35" align="right" style="padding-right:7; font-size:14px; font-family: Verdana, Arial, Helvetica, sans-serif">School Email</td>
          <td height="35" style="padding-left:10"><input name="email" type="text" id="emailJoinUs" class="unif_input" size="25" style="font-size:14px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif; padding:2; height:25" value="<?php if(isset($_SESSION['email'])){echo($_SESSION['email']); unset($_SESSION['email']);}?>">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id="tick_email" src="img/tick.png" width="16" height="16" style="margin-right:10px"/><img id="cross_email" src="img/cross.png" width="16" height="16" style="margin-right:10px"/><span id="email_err" class="email_err" style="display:none; margin-right:10px"></span><span style="color:#999999; font-size:12px; font-family: Verdana, Arial, Helvetica, sans-serif">(Can be used for login)</span></td>
        </tr>
        <tr >
          <td height="35" align="right" style="padding-right:7; font-size:14px; font-family: Verdana, Arial, Helvetica, sans-serif">New Password</td>
          <td height="35"  style="padding-left:10"><input name="passwd2" type="password" class="unif_input" id="inputPassword" size="25" style="font-size:14px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif; padding:2; height:25">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="passwd_err" style="display:none; margin-right:10px"></span><span id="complexity" class="default"></span>        </tr>
        <tr >
          <td height="35" align="right" style="padding-right:7; font-size:14px; font-family: Verdana, Arial, Helvetica, sans-serif">I'm</td>
          <td height="35"  style="padding-left:10; "><select name="gender" id="genderJoinUs" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px">
              <option value="">Select gender</option>
              <option value="Female" <?php if(isset($_SESSION['gender'])&&$_SESSION['gender']=="Female"){echo("selected"); unset($_SESSION['gender']);}?>>Female</option>
              <option value="Male" <?php if(isset($_SESSION['gender'])&&$_SESSION['gender']=="Male"){echo("selected"); unset($_SESSION['gender']); }?>>Male</option>
          </select></td>
        </tr>
        <tr>
          <td height="50" align="right" style="padding-right:7; font-size:14px"><strong></strong></td>
          <td height="50"  style="padding-left:10"><font color="#333333" style="font-size:12px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif">Click sumbit means you have read and agree with the <br>
              <a href="main_agreement.php" class="one" target="_blank"><font color="#336633">User Agreement</font></a></font> </td>
        </tr>
        <tr bgcolor="">
          <td height="240" background="img/grass.jpg">&nbsp;</td>
          <td height="240" valign="top" background="img/grass.jpg" style="padding-left:10px; padding-top:20px"><input name="Submit2" type="submit" class="btn2" id="submitJoinUs" value=" Submit ">          </td>
        </tr>
      </table>
    </form>
  </div></td>
  </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
</div>
