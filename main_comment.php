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

$q_news = mysql_query("SELECT * FROM rockinus.news_info;");
if(!$q_news) die(mysql_error());
$no_row_news = mysql_num_rows($q_news);

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
	$("#showLoginHomeDiv").hide();
	$("#showHomeDiv").hide();
	$("#loginDiv").hide();  
	$("#dailyUpdate").show();

	$("div .showLoginDiv").click(function () {
      //$("#joinUsDiv").hide("slide", { direction: "up" }, 1000);
	  $("#showLoginDiv").hide();
	  $("#IntroDiv").hide();
	  $("#showHomeDiv").hide("hide");
	  $("#dailyUpdateDiv").hide("hide");
	  $("#showLoginHomeDiv").show();
	  $("#loginDiv").show("slow");
	  //$("#joinUsDiv").show("slide", { direction: "up" }, 500);
	});
	
	$("div .showLoginHomeDiv").click(function () {
      //$("#joinUsDiv").hide("slide", { direction: "up" }, 1000);
	  $("#showLoginHomeDiv").hide();
	  $("#showLoginDiv").show();
	  $("#showJoinUsDiv").show();
	  $("#IntroDiv").show();
	  $("#loginDiv").hide("slow");
	  //$("#joinUsDiv").hide("slide", { direction: "up" }, 500);
	});

	$("div .showJoinUsDiv").click(function () {
      //$("#joinUsDiv").hide("slide", { direction: "up" }, 1000);
	  $("#showJoinUsDiv").hide();
	  $("#showLoginDiv").hide();
	  $("#showLoginHomeDiv").hide();
  	  $("#IntroDiv").hide();
	  $("#dailyUpdateDiv").hide();
	  $("#showHomeDiv").show();
	  $("#loginDiv").show("slow");
	  $("#joinUsDiv").show("slow");
	  //$("#joinUsDiv").show("slide", { direction: "up" }, 500);
	});
	
	$("div .showHomeDiv").click(function () {
      //$("#joinUsDiv").hide("slide", { direction: "up" }, 1000);
	  $("#showHomeDiv").hide();
	  $("#joinUsDiv").hide("slow");
	  $("#loginDiv").hide("slow");
	  $("#showLoginDiv").show();
	  $("#showJoinUsDiv").show();
	  $("#IntroDiv").show();
	  //$("#joinUsDiv").hide("slide", { direction: "up" }, 500);
	});
	
	$("div .showUpdateDiv").click(function () {
	  $("#dailyUpdateDiv").show();
	  $("#dailyUpdate").show();
	  $("#dailyHouseUpdate").hide();
	  $("#dailyArticleUpdate").hide();
	  $("#dailyCourseUpdate").hide();
	});
	
	$("div .showHouseUpdateDiv").click(function () {
	  $("#dailyUpdateDiv").show();
	  $("#dailyUpdate").hide();
	  $("#dailyArticleUpdate").hide();
	  $("#dailyCourseUpdate").hide();
	  $("#dailyHouseUpdate").show();
	});
	
	$("div .showArticleUpdateDiv").click(function () {
	  $("#dailyUpdateDiv").show();
	  $("#dailyUpdate").hide();
	  $("#dailyHouseUpdate").hide();
	  $("#dailyCourseUpdate").hide();
	  $("#dailyArticleUpdate").show();
	});

	$("div .showCourseUpdateDiv").click(function () {
	  $("#dailyUpdateDiv").show();
	  $("#dailyUpdate").hide();
	  $("#dailyHouseUpdate").hide();
	  $("#dailyArticleUpdate").hide();
	  $("#dailyCourseUpdate").show();
	});
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
		if(unameJoinUsValue == "" || unameJoinUsValue.length < 5){
			$("#username").after('&nbsp;&nbsp;&nbsp;&nbsp;<span class="error">User name is not long enough.</span>');
			return false;
		}
		
		var unameExp = /^[0-9a-zA-Z_]+$/;
		if(!unameJoinUsValue.match(unameExp)){
			$("#username").after('&nbsp;&nbsp;&nbsp;&nbsp;<span class="error">Name can only be number, letter or "_"</span>');
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
<?php include("main_header.php") ?>
  <div class="dailyUpdateDiv" id="dailyUpdateDiv" style="margin-top:10">
  <table width="1024" height="450" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="250" valign="top" align="left" style="border-right:0px dashed #CCCCCC">
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main.php" class="one">Home</a></td>
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
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif; font-weight:bold">&nbsp;&nbsp;Comment</td>
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
    <td width="706" align="right" valign="top" style="padding-top:10"><div style=" border:0px solid #DDDDDD; border-top:0">
      <table width="720" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:0px">
        <tr>
          <td width="720" height="86" colspan="0" align="center" style="border-left:0px #EEEEEE solid"><div style="background:#F5F5F5; border-bottom:1px #999999 solid; border-top:1px #CCCCCC solid; margin-bottom:5; margin-top:0px; padding-top:0px; padding-bottom:0px;font-size:11px;">
              <table width="730" height="30" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
                <tr>
                  <td width="275" style=" font-weight:bold; padding-left:15px; padding-right:10px; font-family: Arial, Helvetica, sans-serif; font-size:14px" align="left" bgcolor="" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.backgroundColor = '';"><a href="main_leaveComment.php" class="">+ Compose a Comment
                    <?php 
				  //Global Variable: 
$page_name = "NewFreeCommentUs.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
 
//**EDIT TO YOUR TABLE NAME, ETC.
$q = "SELECT count(*) as cnt FROM rockinus.open_comment_info WHERE 1=1 ORDER BY pdate,ptime DESC";
//echo("SELECT count(*) as cnt FROM rockinus.house_info WHERE $sel_cond ORDER BY pdate,ptime DESC");
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
//if ($total_items == 0 )echo("<strong>No post so far</strong>");

				  echo("") ?>
                  </strong></a></td>
                  <td width="445" align="right" style="padding-right:15"><?php			
 $limit= (isset($_GET["limit"])) ? $_GET["limit"] : 15;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;

if((!$limit) || (is_numeric($limit) == false)|| ($limit < 15) || ($limit > 50)) {
	$limit = 1; //default
}
 
if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items)) { 
	$page = 1; //default 
}
 
//calculate total pages
$total_pages = ceil($total_items / $limit);
$set_limit = ($page * $limit) - $limit;
//echo "Total Pages: $total_pages <br/>";
if ($total_items != 0 )echo "Page ";
//prev. page
$prev_page = $page - 1;
if($prev_page >= 1) { 
	echo("<a href=$page_name?limit=$limit&page=$prev_page class=one>Previous</a>");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo(" <strong>$a</strong>  "); //no link
}else{ 
	echo("<a href=$page_name?limit=$limit&page=$a class=one> <strong>$a</strong> </a>   ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo("  <a href=$page_name?limit=$limit&page=$next_page class=one>Next</a>");
}
//if ($total_items != 0 )echo " ...";
?>                  </td>
                </tr>
              </table>
          </div>
              <?php
 mysql_query("SET NAMES GBK");
$q1 = mysql_query("SELECT * FROM rockinus.open_comment_info WHERE 1=1 ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
//echo ("SELECT * FROM rockinus.forum_info WHERE 1=1 $sel_cond ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("<font size=5><div style='padding:20px; margin-bottom:0px; margin-top:10px; align='center'><br>No comments so far.</div><div align='center' style='background-color:#B92828; height:40px; display:inline; margin-top:0px; margin-bottom:0px; padding-left:15; border-bottom:1px #000000 solid; border-right:1px #000000 solid; padding-right:15; padding-top:8; padding-bottom:8; color:white'><a href='main_leaveComment.php' class='one'><font color=white>Write a Comment</font></a></div></font><br><br><br><br><br><br>");}
else if($no_row > 0){ 
	while($object = mysql_fetch_object($q1)){
		$comid = $object->comid;
		$sender = $object->sender;
		$descrip = $object->descrip;
		$descrip = str_replace("\\","",nl2br($descrip));
		$ptime = $object->ptime;
		$pdate = $object->pdate;  
?>
              <div style="padding-top:0px; padding-bottom:0px; border-right:0px #DDDDDD dashed">
                <table width="730" height="70" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD" onMouseOver="this.style.backgroundColor = '#F5F5F5';" onMouseOut="this.style.backgroundColor = 'white';">
                  <tr>
                    <td width="32" height="36" align="left" style=" color:#336633; padding-left:15; padding-top:15" valign="top">
					<img src="img/rightTriangleIcon.jpg" width="10"/></td>
                    <td width="538" align="left" valign="top" style=" padding-top:12; font-family: Arial, Helvetica, sans-serif, sans-serif; font-size:13px"><?php echo("<font color=##336633><strong>$sender</strong></font> <font color=#999999></font>") ?> </td>
                    <td width="110" align="right" style="color: #999999; font-size:12px; padding-right:10"><?php echo($pdate) ?> | <?php echo(substr($ptime,0,5)) ?></td>
                  </tr>
                  <tr>
                    <td height="43" align="left" style=" color:#336633; padding-bottom:20px">&nbsp;</td>
                    <td colspan="2" align="left" valign="top" style=" padding-right:5px; padding-bottom:20px; line-height:130%; padding-top:5; font-family: Arial, Helvetica, sans-serif, sans-serif; font-size:13px; border-bottom:0px #DDDDDD solid"><?php 
					echo(substr($descrip,0,300)."...") ?>
                    </td>
                  </tr>
                </table>
              </div>
            <?php }}?></td>
        </tr>
      </table>
    </div>	</td>
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
