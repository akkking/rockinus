<?php 
include "mainHeader.php";
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];

$pic210_Name = $uname.'210.jpg';
$ProPercent = 70;
		
$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$_SESSION['hcolor'] = $object->hcolor;
$_SESSION['lan'] = $object->lan;
$hcolor = $_SESSION['hcolor'];
$lan = $_SESSION['lan'];

$t = mysql_query("
SELECT count(1) AS `cnt` 
FROM (SELECT sender FROM rockinus.message_info WHERE recipient='$uname' AND rstatus='N'
      UNION ALL 
      SELECT sender FROM rockinus.message_history WHERE recipient='$uname' AND rstatus='N') AS `t` 
");
if(!$t)	die("Error quering the Database: " . mysql_error());
$a = mysql_fetch_object($t);
$cnt_unread_msg = $a->cnt;

$u = mysql_query("SELECT count(*) as cnt FROM rockinus.rocker_rel_history WHERE recipient='$uname' AND rstatus='P'");
if(!$u)	die("Error quering the Database: " . mysql_error());
$b = mysql_fetch_object($u);
$cnt_friend_rqst = $b->cnt;

$u = mysql_query("SELECT count(*) as cnt FROM rockinus.user_request_file WHERE file_id IN (SELECT file_id FROM rockinus.user_file_info WHERE owner='$uname' AND rstatus='P')");
if(!$u)	die("Error quering the Database: " . mysql_error());
$b = mysql_fetch_object($u);
$cnt_file_rqst = $b->cnt;

$cnt_total_rqst = $cnt_file_rqst + $cnt_friend_rqst;

if(isset($_POST['lan'])){
	$lan = htmlspecialchars(trim($_POST['lan']));
	$_SESSION['lan'] = $lan;
	include("dbconnect.php");
	$setLan = "UPDATE rockinus.user_setting SET lan='$lan' WHERE uname='$uname'";
    mysql_query($setLan) or die(mysql_error());
	//header("location:ThingsRock.php");
}
?>

<script type="text/javascript" src="js/ScrollTableHeader103.min.js"></script>
<script type="text/javascript" src="dropdownTop.js"></script>
<script type="text/javascript" src="dropdown.js"></script>
<script type="text/javascript" src="CheckAll.js"></script>
<script type="text/javascript" src="birthday.js"></script>
<script language="JavaScript" src="js/curvycorners.src.js"></script>
<link href="calendar.css" rel="stylesheet">
<link rel="stylesheet" href="style/HeaderRequest.css" />
<script src="calendar.js"></script>

<script>
// scroll body to 0px on click
$('#goTopDiv a').click(function () {
	$('body,html').animate({
			scrollTop: 0
		}, 900);
	return false;
});
</script>
<script>
$(function () {
    /* set variables locally for increased performance */
    var scroll_timer;
    var displayed = false;
    var $message = $('#goTopDiv a');
    var $window = $(window);
    var top = $(document.body).children(0).position().top;

    /* react to scroll event on window */
    $window.scroll(function () {
        window.clearTimeout(scroll_timer);
        scroll_timer = window.setTimeout(function () {
            if($window.scrollTop() <= top)
            {
                displayed = false;
                $message.fadeOut(500);
            }
            else if(displayed == false)
            {
                displayed = true;
                $message.stop(true, true).show().click(function () { $message.fadeOut(500); });
            }
        }, 100);
    });
});
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

<style>
#goTopDiv a
{
	width:60px;
    /* display: block before hiding */
    display: block;
    display: none;

    /* link is above all other elements */
    z-index: 999; 

    /* link doesn't hide text behind it */
    opacity: 0.5;
	filter:alpha(opacity=70);
    /* link stays at same place on page */
    position: fixed;
 	_position:absolute;
	_top:expression(eval(document.body.scrollTop+400));
    _bottom:auto;
	/* link goes at the bottom of the page */
    /* top: 100%; */
    /* margin-top: -80px; */ 
	/* = height + preferred bottom margin */
	bottom:10%;
    /* link is centered */
    right: 2%;
    /* margin-left: -160px; */
	/* = half of width */

    /* round the corners (to your preference) */
    -moz-border-radius: 12px;
    -webkit-border-radius: 12px;

    /* make it big and easy to see (size, style to preferences) */
    line-height: 48px;
    padding: 5 10 5 10;
    background-color: #333333;
    font-size: 24px;
    text-align: center;
    color: #fff;
	cursor:pointer
}
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
<style type="text/css">
#search {
    color: #fff;
	height:23px;
    text-align: center;
	background-color:#F5F5F5;
	padding-right:3px;
	padding-left:3px;
	width: <?php if(contains("Internet",$ua['name']))echo("275"); else echo("240"); ?>;
	font-size:15px;
}

#stickyheader{
	background-color:<?php echo($_SESSION['hcolor']) ?>;
	border-bottom:1px #000000 solid;
	width: 100%;                        
	height: 35px;
}                
#stickyalias {
	display: none;
	height: 10px;
}
#unstickyheader {
	margin-bottom: 15px;
}

#othercontent {
	margin-top: 20px;
}  
</style>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="JavaScript" src="js/overlib.js"></script>
<script type="text/javascript">
	function scrollToBottom() {
		$('html, body').animate({scrollTop:$(document).height()}, 'slow');
	}
	function scrollToTop() {
		$('html, body').animate({scrollTop:0}, 'slow');
	}
</script>
<script type="text/javascript">
$(document).ready(function () {
	$('#nav li').hover(
		function () {
			//show its submenu
			$('ul', this).slideDown(100);

		}, 
		function () {
			//hide its submenu
			$('ul', this).slideUp(100);			
		}
	);
	
});
</script>
</head>
<body>
<?php 
//include("Header.php");
$self_join_stmt = NULL;

if(isset($_POST['FindName'])&&trim($_POST['FindName'])!="Enter username, first or last name"){
	$FindName = $_POST['FindName'];
	$sel_count = "SELECT count(*) as cnt FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON (a.uname LIKE '%$FindName%' OR a.fname LIKE '%$FindName%' OR a.lname LIKE '%$FindName%') AND a.uname=b.uname AND b.uname=c.uname AND a.uname=d.uname;";
	$sel_stmt = "SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON (a.uname LIKE '%$FindName%' OR a.fname LIKE '%$FindName%' OR a.lname LIKE '%$FindName%') AND a.uname=b.uname AND b.uname=c.uname AND a.uname=d.uname ORDER BY b.signup_date DESC";
}else if(isset($_GET['fcountry'])&&$_GET['fcountry']!=NULL&&$_GET['fcountry']!="empty"){
	$sel_count = "SELECT count(*) as cnt FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname AND a.fcountry='$_GET[fcountry]'";
	$sel_stmt = "SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname AND a.fcountry='$_GET[fcountry]'";
	if(isset($_GET['fregion'])&&$_GET['fregion']!=NULL&&$_GET['fregion']!="empty"){
		$sel_count .= " AND a.fregion='$_GET[fregion]'";
		$sel_stmt .= " AND a.fregion='$_GET[fregion]'";
	}
	$sel_stmt .= " ORDER BY b.signup_date DESC";
}else if(isset($_GET['cstate'])&&$_GET['cstate']!=NULL&&$_GET['cstate']!="empty"){
	$sel_count = "SELECT count(*) as cnt FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname AND d.cstate='$_GET[cstate]'";
	$sel_stmt = "SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname AND d.cstate='$_GET[cstate]'";
	if(isset($_GET['ccity'])&&$_GET['ccity']!=NULL&&$_GET['ccity']!="empty"){
		$sel_count .= " AND d.ccity='$_GET[ccity]'";
		$sel_stmt .= " AND d.ccity='$_GET[ccity]'";
	}
	$sel_stmt .= " ORDER BY b.signup_date DESC";
}else if(isset($_GET['major'])&&$_GET['major']!=NULL&&$_GET['major']!="empty"){	
	$sel_count = "SELECT count(*) as cnt FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname AND cmajor='$_GET[major]';";
	$sel_stmt = "SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname AND cmajor='$_GET[major]' ORDER BY b.signup_date DESC";
}else if(isset($_GET['school'])&&$_GET['school']!=NULL&&$_GET['school']!="empty"){
	$sel_count = "SELECT count(*) as cnt FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname AND c.cschool='$_GET[school]';";
	$sel_stmt = "SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname AND c.cschool='$_GET[school]' ORDER BY b.signup_date DESC";	
}else if(isset($_GET['course'])&&$_GET['course']!=NULL){
	$sel_count = "SELECT count(*) AS cnt FROM rockinus.user_course_info a INNER JOIN rockinus.user_course_info b INNER JOIN rockinus.user_info c INNER JOIN rockinus.user_edu_info d INNER JOIN rockinus.user_info e ON a.uname='$uname' AND a.uname<>b.uname AND a.course_uid=b.course_uid AND b.uname=c.uname AND b.uname=d.uname AND b.uname=e.uname;";
	//$sel_count = "SELECT count(DISTINCT a.uname) as cnt FROM rockinus.user_course_info a INNER JOIN rockinus.user_course_info b INNER JOIN rockinus.user_info c INNER JOIN rockinus.user_edu_info d ON a.coid=b.coid AND a.uname!='$uname' AND a.uname<>b.uname AND a.uname<>c.uname AND a.uname<>d.uname GROUP BY a.uname;";
	$sel_stmt = "SELECT DISTINCT(b.uname), c.gender, e.fname, e.lname, d.cschool, d.cmajor, d.cdegree, d.sterm FROM rockinus.user_course_info a INNER JOIN rockinus.user_course_info b INNER JOIN rockinus.user_info c INNER JOIN rockinus.user_edu_info d INNER JOIN rockinus.user_info e ON a.uname='$uname' AND a.uname<>b.uname AND a.course_uid=b.course_uid AND b.uname=c.uname AND b.uname=d.uname AND b.uname=e.uname GROUP BY b.uname ";
//	$sel_stmt = "SELECT DISTINCT(a.uname), e.fname, d.cschool, d.cmajor, d.cdegree, d.sterm FROM rockinus.user_course_info a INNER JOIN rockinus.user_course_info b INNER JOIN rockinus.user_info c INNER JOIN rockinus.user_edu_info d INNER JOIN rockinus.user_info e ON a.coid=b.coid AND a.uname!='$uname' AND a.uname<>b.uname AND a.uname<>c.uname AND a.uname<>d.uname GROUP BY a.uname;";
}else if(isset($_GET['mstatus'])&&$_GET['mstatus']!=NULL){
	$sel_count = "SELECT count(*) AS cnt FROM rockinus.user_info WHERE uname<>'$uname' AND mstatus='$_GET[mstatus]'";
	$sel_stmt = "SELECT DISTINCT(a.uname), a.fname, b.cschool, b.cmajor, b.cdegree, b.sterm FROM rockinus.user_info a INNER JOIN rockinus.user_edu_info b ON a.uname!='$uname' AND a.uname<>b.uname AND a.mstatus='$_GET[mstatus]' GROUP BY a.uname ";
}else if(isset($_GET['hobby'])&&$_GET['hobby']!=NULL){
	$sel_count = "SELECT count(*) AS cnt FROM rockinus.user_hobby_info WHERE uname<>'$uname' AND hobby LIKE '%$_GET[hobby]%';";
	$sel_stmt = "SELECT DISTINCT(a.uname), a.fname, b.cschool, b.cmajor, b.cdegree, b.sterm FROM rockinus.user_info a INNER JOIN rockinus.user_edu_info b INNER JOIN rockinus.user_hobby_info c ON a.uname!='$uname' AND a.uname=b.uname AND a.uname=c.uname AND c.hobby LIKE '%$_GET[hobby]%' GROUP BY a.uname ";
}else if(isset($_GET['friendreq'])&&$_GET['friendreq']!=NULL){
	$sel_count = "SELECT count(*) as cnt FROM rockinus.rocker_rel_history WHERE recipient='$uname' AND rstatus='P'";
	$sel_stmt = "SELECT * FROM rockinus.rocker_rel_history WHERE recipient='$uname' AND rstatus='P'";
	//$sel_stmt = "SELECT * FROM rockinus.rocker_rel_history a INNER JOIN rockinus.user_info b INNER JOIN rockinus.user_edu_info c ON a.rstatus='P' AND a.recipient='$uname' AND a.recipient=b.uname AND a.recipient=c.uname ORDER BY a.pdate DESC, a.ptime DESC";
}else if(isset($_GET['myfriends'])&&$_GET['myfriends']!=NULL){
	$sel_count = "SELECT count(*) as cnt FROM rockinus.rocker_rel_info WHERE sender='$uname' OR recipient='$uname'";
//	$sel_stmt = "SELECT * FROM rockinus.rocker_rel_info a INNER JOIN rockinus.user_info b INNER JOIN rockinus.user_edu_info c ON (a.sender='$uname' OR a.recipient='$uname') AND (a.sender=b.uname OR a.recipient=b.uname) AND (b.uname<>'$uname' AND c.uname<>'$uname') ORDER BY a.pdate DESC, a.ptime DESC";
	$sel_stmt = "SELECT * FROM rockinus.rocker_rel_info WHERE sender='$uname' OR recipient='$uname'";
}else{
	$sel_count = "SELECT count(*) as cnt FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname;";
	$sel_stmt = "SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname ORDER BY b.signup_date DESC";	
}
?>
<div style=" width:100%" align="center">
<div id="goTopDiv">
  <a href="#">Top</a>
</div>
    <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td width="265" align="left" valign="top" style=" padding:20px">
        <?php include("leftHomeFriendMenu.php"); ?>	  </td>
      <td width="759" align="left" valign="top" style="padding-top:25" bgcolor="">
	  <table width="700" height="426" border="0" cellpadding="0" cellspacing="0" style="border:0px solid #999999; margin-bottom:10;" bgcolor="#FFFFFF">
          <tr>
            <td height="30" colspan="2" align="right" valign="top">	
			  <table width="710" height="50" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="margin-bottom:0px; border-top: 0px #CCCCCC dotted; border-bottom:1px #DDDDDD solid;">
                <tr>
                  <td width="410" height="30" align="left" style="padding-left:10px; font-weight:normal; font-size:14px; color:#FFFFFF">
				  <form action="FriendGroup.php" method="post" style="margin:0; padding:0">
				  <input type="text" name="FindName" size='40' class="box" style=" height:22; font-size:13px; font-family:Arial, Helvetica, sans-serif" maxlength="25" onClick="this.value='';" onFocus="this.select()" onBlur="this.value=!this.value?' Enter username, first or last name':this.value;" value=" Enter username, first or last name">
				  <input type="hidden" name="pagename" value="FindGroup.php">				  
                  &nbsp;<input name="submit" type="submit" style=" font-size:13px;  background: url(img/master.png); height:23; padding:2 8 2 8; color:#000000; border:1px solid #000000; cursor:pointer; -moz-border-radius: 3px; border-radius: 3px;" value="Search">                  </form>
				  </td>
                  <td width="330" height="30" align="right" style="padding-right:15px; font-size:14px;  color:#000000">
                    <?php
//Global Variable: 
$page_name = "FriendGroup.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

//echo($sel_count);
$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items == 0 );

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
if ($total_items != 0 )echo "<font color=>Page</font> ";
//prev. page
$prev_page = $page - 1;
if($prev_page >= 1) { 
	echo("<a href=$page_name?limit=$limit&page=$prev_page class=one><<</a>");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo(" <strong><font><u>$a</u></font></strong>  "); //no link
}else{ 
	echo("<a href=$page_name?limit=$limit&page=$a class=one> $a </a>   ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo(" <a href=$page_name?limit=$limit&page=$next_page class=one>>></a>");
}
echo " ";
?>                 </td>
                </tr>
              </table>              
		        <table width="710" height="30" border="0" cellpadding="0" cellspacing="0" align="right">
                <tr>
                  <td width="700" height="50" align="left" valign="bottom" style=" padding-left:15; padding-bottom:0; font-size:24px; border-top:#EEEEEE solid 0px; border-bottom:#DDDDDD dashed 0px; color:#000000">
				  <?php
				  	if(isset($_GET['myfriends']) && $_GET['myfriends']=="1"){
						echo("<div style='display:inline; padding:5; padding-right:15; background:; border:0 solid #CCCCCC; height:20; font-weight:normal'><img src=img/addsuccessIcon.jpg width=20 />&nbsp;&nbsp;You currently have $total_items friends</div>");
					}else if(isset($_GET['fcountry'])){
						if(isset($_GET['fregion']))
							echo("<div style='display:inline; padding:5; padding-right:15; background:; border:0 solid #CCCCCC; height:20; font-weight:normal'><img src=img/addsuccessIcon.jpg width=20 />&nbsp;&nbsp;$total_items people from $fregion, $fcountry (include you)</div>");
						else
							echo("<div style='display:inline; padding:5; padding-right:15; background:; border:0 solid #CCCCCC; height:20; font-weight:normal'><img src=img/addsuccessIcon.jpg width=20 />&nbsp;&nbsp;$total_items people from $fcountry (include you)</div>");
					}else if(isset($_GET['cstate'])){
						if(isset($_GET['ccity']))
							echo("<div style='display:inline; padding:5; padding-right:15; background:; border:0 solid #CCCCCC; height:20; font-weight:normal'><img src=img/addsuccessIcon.jpg width=20 />&nbsp;&nbsp;$total_items people from $ccity, $cstate (include you)</div>");
						else
							echo("<div style='display:inline; padding:5; padding-right:15; background:; border:0 solid #CCCCCC; height:20; font-weight:normal'><img src=img/addsuccessIcon.jpg width=20 />&nbsp;&nbsp;$total_items people from $cstate (include you)</div>");
					}else if(isset($_GET['friendreq']) && $_GET['friendreq']=="1"){
						echo("<div style='display:inline; padding:5; padding-right:15; background:; border:0 solid #CCCCCC; height:20; font-weight:normal'><img src=img/addsuccessIcon.jpg width=20 />&nbsp;&nbsp;You currently have $total_items friend request(s)</div>");
					}else if(isset($_GET['major'])){
						echo("<div style='display:inline; padding:5; padding-right:15; background:; border:0 solid #CCCCCC; height:20; font-weight:normal'><img src=img/addsuccessIcon_F5.jpg width=20 />&nbsp;&nbsp;$total_items people are of same major as you</div>");
					}else if(isset($_GET['school'])){
						echo("<div style='display:inline; padding:5; padding-right:15; background:; border:0 solid #CCCCCC; height:20; font-weight:normal'><img src=img/addsuccessIcon_F5.jpg width=20 />&nbsp;&nbsp;$total_items people went to your school</div>");
					}else if(isset($_GET['course'])){
						echo("<div style='display:inline; padding:5; padding-right:15; background:; border:0 solid #CCCCCC; height:20; font-weight:normal'><img src=img/addsuccessIcon_F5.jpg width=20 />&nbsp;&nbsp;$total_items people have subscribed same course as you</div>");
					}else if(isset($_GET['hobby'])){
						echo("<div style='display:inline; padding:5; padding-right:15; background:; border:0 solid #CCCCCC; height:20; font-weight:normal'><img src=img/addsuccessIcon_F5.jpg width=20 />&nbsp;&nbsp;We find $total_items people also like $_GET[hobby]</div>");
					}else{
						echo("<div style='display:inline; padding:5; padding-right:15; background:; border:0 solid #CCCCCC; height:20; font-weight:normal'><img src=img/addsuccessIcon.jpg width=20 />&nbsp;&nbsp; $total_items people found</div>");
					}
				  ?>				  </td>
                  </tr>
            </table></td>
          </tr>
          <tr>
            <td width="746" align="center" valign="top" style="padding-top:5">
			<?php
			//echo($sel_stmt." LIMIT $set_limit, $limit");
$q = mysql_query($sel_stmt." LIMIT $set_limit, $limit");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0){
	if(isset($_POST['FindName'])) 
		echo("<div style='padding-right:50; margin-left:15; padding-top:50' align=center><img src='img/error_new.jpg' width=20>&nbsp;&nbsp;&nbsp;&nbsp;<font color=$_SESSION[hcolor] size=4><strong>Sorry, people named with <u>'$FindName'</u> not found.</strong></font></div>");
	else if(isset($_GET['friendreq']))
		echo("<div style='padding:25 0 25 0; margin-left:15px; border:16px solid #DDDDDD; width:500px; background:#F5F5F5; margin-top:50px; -moz-border-radius: 5px; border-radius: 5px;' align=center>&nbsp;<font color=$_SESSION[hcolor] style='font-size:24px'><strong><img src=img/people.png width=20>&nbsp;&nbsp;$uname_fname, <a href='FriendGroup.php' class='one' style='color:#B92828'>let's find some friends!</a></strong></font></div>");
	else echo("<div style='padding-right:50; margin-left:20px' align=center><br><br><br><font color=$_SESSION[hcolor] size=4><strong>Sorry, no records found.</strong></font></div>");
}
$i = 1;
while($object = mysql_fetch_object($q)){
	if(isset($_GET['myfriends'])&&$_GET['myfriends']!=NULL){
		$loopsender = $object->sender;
		$looprecipient = $object->recipient;
		if($loopsender==$uname)
			$sel_stmt_friend = "SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_edu_info b INNER JOIN rockinus.user_contact_info c ON
			a.uname='$looprecipient' AND a.uname=b.uname AND a.uname=c.uname";		
		else if($looprecipient==$uname)
			$sel_stmt_friend = "SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_edu_info b INNER JOIN rockinus.user_contact_info c ON 
			a.uname='$loopsender' AND a.uname=b.uname AND a.uname=c.uname";		

		$qfriend = mysql_query($sel_stmt_friend);
		if(!$qfriend) die(mysql_error());
		$ob = mysql_fetch_object($qfriend);
		$loopname = $ob->uname;
		$pic100_Name = $loopname.'100.jpg';
		$fname = $ob->fname;
		$lname = $ob->lname;
		$gender = $ob->gender;
		$rstatus = NULL;
		$cschool = $ob->cschool;
		if($cschool=="empty") $cschool=NULL;
		$cmajor = $ob->cmajor;
		if($cmajor=="empty") $cmajor=NULL;
		$cdegree = $ob->cdegree;
		$sterm = $ob->sterm;
		$cstate = $ob->cstate;
		$ccity = $ob->ccity;
		$ccity_cstate = "";		
		if((strlen(trim($cstate))==0 && strlen(trim($ccity))==0)||$cstate=='em')
	 		$ccity_cstate = "Somewhere not sure";
		else if(strlen(trim($ccity))==0 || $ccity==NULL){	
			$q_in = mysql_query("SELECT * FROM rockinus.state_info WHERE state_id='$cstate'");
			if(!$q_in) die(mysql_error());
			$obj_in = mysql_fetch_object($q_in);
			$cstate_name = trim($obj_in->state_name);
			$ccity_cstate = $cstate_name;
		}else{
			$q_in = mysql_query("SELECT * FROM rockinus.state_info WHERE state_id='$cstate'");
			if(!$q_in) die(mysql_error());
			$obj_in = mysql_fetch_object($q_in);
			$cstate_name = trim($obj_in->state_name);
			$ccity_cstate = $ccity.", ".$cstate_name;
		}
	}else if(isset($_GET['friendreq'])&&$_GET['friendreq']!=NULL){
		$loopsender = $object->sender;
		$sel_stmt_friend = "SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_edu_info b INNER JOIN rockinus.user_contact_info c ON a.uname='$loopsender' AND a.uname=b.uname AND a.uname=c.uname";
		$qfriend = mysql_query($sel_stmt_friend);
		if(!$qfriend) die(mysql_error());
		$ob = mysql_fetch_object($qfriend);
		$loopname = $ob->uname;
		$pic100_Name = $loopname.'100.jpg';
		$fname = $ob->fname;
		$lname = $ob->lname;
		$gender = $ob->gender;
		$rstatus = NULL;
		$cschool = $ob->cschool;
		if($cschool=="empty") $cschool=NULL;
		$cmajor = $ob->cmajor;
		if($cmajor=="empty") $cmajor=NULL;
		$cdegree = $ob->cdegree;
		$sterm = $ob->sterm;
		$cstate = $ob->cstate;
		$ccity = $ob->ccity;
		$ccity_cstate = "";		
		if((strlen(trim($cstate))==0 && strlen(trim($ccity))==0)||$cstate=='em')
	 		$ccity_cstate = "Somewhere not sure";
		else if(strlen(trim($ccity))==0 || $ccity==NULL){	
			$q_in = mysql_query("SELECT * FROM rockinus.state_info WHERE state_id='$cstate'");
			if(!$q_in) die(mysql_error());
			$obj_in = mysql_fetch_object($q_in);
			$cstate_name = trim($obj_in->state_name);
			$ccity_cstate = $cstate_name;
		}else{
			$q_in = mysql_query("SELECT * FROM rockinus.state_info WHERE state_id='$cstate'");
			if(!$q_in) die(mysql_error());
			$obj_in = mysql_fetch_object($q_in);
			$cstate_name = trim($obj_in->state_name);
			$ccity_cstate = $ccity.", ".$cstate_name;
		}
	}else{
		$loopname = $object->uname;
		$pic100_Name = $loopname.'100.jpg';
		$fname = $object->fname;
		$lname = $object->lname;
		$gender = $object->gender;
		$rstatus = NULL;
		$cschool = $object->cschool;
		if($cschool=="empty") $cschool=NULL;
		$cmajor = $object->cmajor;
		if($cmajor=="empty") $cmajor=NULL;
		$cdegree = $object->cdegree;
		$sterm = $object->sterm;
		$cstate = $object->cstate;
		$ccity = $object->ccity;
		$ccity_cstate = "";		
		if((strlen(trim($cstate))==0 && strlen(trim($ccity))==0)||$cstate=='em')
	 		$ccity_cstate = "Somewhere not sure";
		else if(strlen(trim($ccity))==0 || $ccity==NULL){	
			$q_in = mysql_query("SELECT * FROM rockinus.state_info WHERE state_id='$cstate'");
			if(!$q_in) die(mysql_error());
			$obj_in = mysql_fetch_object($q_in);
			$cstate_name = trim($obj_in->state_name);
			$ccity_cstate = $cstate_name;
		}else{
			$q_in = mysql_query("SELECT * FROM rockinus.state_info WHERE state_id='$cstate'");
			if(!$q_in) die(mysql_error());
			$obj_in = mysql_fetch_object($q_in);
			$cstate_name = trim($obj_in->state_name);
			$ccity_cstate = $ccity.", ".$cstate_name;
		}
	}
	
	if($loopname==$uname)$rstatus ="S";
	else{
		$q11 = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE (sender='$loopname' AND recipient='$uname') OR (recipient='$loopname' AND sender='$uname')");
		if(!$q11) die(mysql_error());
		$no_row_A = mysql_num_rows($q11);
		if($no_row_A>0)$rstatus='A';
	
		$q21 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$loopname' AND recipient='$uname' AND rstatus='P'");
		if(!$q21) die(mysql_error());
		$no_row_P = mysql_num_rows($q21);
		if($no_row_P>0)$rstatus='X';
	
		$q22 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uname' AND recipient='$loopname' AND rstatus='P'");
		if(!$q22) die(mysql_error());
		$no_row_X = mysql_num_rows($q22);
		if($no_row_X>0)$rstatus='P';	
	}
	
	$school_name = "";
	if($cschool!=NULL){
		$q1 = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
	//echo("SELECT * FROM rockinus.school_info where sid='$cschool'");
		if(!$q1) die(mysql_error());
		$obj1 = mysql_fetch_object($q1);
		$school_name = $obj1->school_name;
	}
	
	$major_name = "";
	if($cmajor!=NULL && $cmajor!="empty"){
		$q2 = mysql_query("SELECT * FROM rockinus.major_info where mid='$cmajor'");
	//echo("SELECT * FROM rockinus.major_info where mid='$cmajor'");
		if(!$q2) die(mysql_error());
		$obj2 = mysql_fetch_object($q2);
		$major_name = $obj2->major_name;
	}
	
	$q3 = mysql_query("SELECT * FROM rockinus.memo_info where sender='$loopname' order by memoid DESC");
	if(!$q3) die(mysql_error());
	$obj3 = mysql_fetch_object($q3);
	$descrip = $obj3->descrip;
	if($descrip==NULL){
		$descrip="Nothing Posted...";
		$fontcolor = "#CCCCCC";
	}else $fontcolor = "#336633";
	
	if($gender=="Male")$gender_name = "He";
	else if($gender=="Female")$gender_name = "She";
	else $gender_name = $fname;
	
	$rel_rstatus = "N";
	if($loopname==$uname)$rel_rstatus ="S";
	else{
		$q11 = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE (sender='$loopname' AND recipient='$uname') OR (recipient='$loopname' AND sender='$uname')");
		if(!$q11) die(mysql_error());
		$no_row_A = mysql_num_rows($q11);
		if($no_row_A>0)$rel_rstatus='A';
	
		$q21 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$loopname' AND recipient='$uname' AND rstatus='P'");
		if(!$q21) die(mysql_error());
		$no_row_P = mysql_num_rows($q21);
		if($no_row_P>0)$rel_rstatus='X';
	
		$q22 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uname' AND recipient='$loopname' AND rstatus='P'");
		if(!$q22) die(mysql_error());
		$no_row_X = mysql_num_rows($q22);
		if($no_row_X>0)$rel_rstatus='P';	
	}
	?>
	
      <script type="text/javascript">
$(function() {
	$(".addFriendMajorDiv<?php echo($loopname) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($loopname) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#addFriendMajorDiv<?php echo($loopname) ?>").hide();
		$("#flashAddFriendMajor<?php echo($loopname) ?>").show();
		$("#flashAddFriendMajor<?php echo($loopname) ?>").fadeIn(400).html('<img src="img/loading42.gif" width="80" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_frequest.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashAddFriendMajor<?php echo($loopname) ?>").hide();
				$("#addFriendMajorResult<?php echo($loopname) ?>").html(html);
				$("#addFriendMajorResult<?php echo($loopname) ?>").show();
			}
 		});
 		return false;
 	});
 });
    </script>
				<table width="710" height="100" border="0" cellpadding="0" cellspacing="0" style="border:0px solid #EEEEEE; border-bottom:1px #DDDDDD solid; margin-bottom:px; margin-top:px; padding-top:5px; padding-bottom:5px;">
                <tr>
                  <td width="105" align="left" valign="top" style="padding:10; padding-right:15">
                      <?php 
					$target = "upload/".$loopname;
					if(is_dir($target))
				  echo("<a href='RockerDetail.php?uid=$loopname' class='one'><img src=upload/$loopname/$pic100_Name?".time()." style=border:0></a>");
				  else 
				  	echo("<a href='RockerDetail.php?uid=$loopname' class='one'><img src=img/NoUserIcon100.jpg style=border:0></a>");
					?>                  </td>
                  <td width="585" colspan="2" valign="top" style=" line-height:140%; padding-left:5; padding-top:10; font-size:14">
				  <div style="margin-bottom:0">
				  <?php 
					  echo("<strong><a href='RockerDetail.php?uid=$loopname' class='one' style='color:$_SESSION[hcolor]; font-size:14px'>$fname $lname</a></strong>&nbsp; ");
					  if($cdegree!=NULL)echo("<font color=#333333 style='font-size:12px'>(".$gender_name."'s ".$cdegree.")</font>&nbsp; "); 
					  $total_point = getUserPoint($loopname);

$token_full = 0;
$token_half = 0;
$token_empty = 0;

$token="star";
$cal_unit=100;

if($total_point>=500&&$total_point<2500){
	$cal_unit=500;
	$token = "diamond";
}else if($total_point>=2500){
	$cal_unit=1000;
	$token = "gold";
}

if(($token=="star"&&$total_point<100) || ($token=="diamond"&&$total_point<1000) || ($token=="gold"&&$total_point<2500)) $token_full=0;
else $token_full = floor($total_point/$cal_unit);
//echo("$token<br>$token_full<br>$total_point<br>");

if($total_point%$cal_unit>0) {
	$token_half=1;
	$token_empty=5-$token_half-$token_full;
}else{
	$token_half=0;
	$token_empty=5-$token_full;
}
				
for($i=0; $i<$token_full; $i++)
	echo("<img src='img/ratingStar_full.jpg' width=12>");
for($j=0; $j<$token_half; $j++)
	echo("<img src='img/ratingStar_half.jpg' width=12>");
for($k=0; $k<$token_empty; $k++)
	echo("<img src='img/ratingStar_empty.jpg' width=12>");
?>
					</div>
				  <div style="font-size:12px; margin-bottom:0; margin-top:0; width:570; font-weight:normal; color:#000000">
							<?php 
							if($cmajor!=NULL){
								if($sterm=="empty")
									echo(trim($major_name));
								else
									echo(trim($major_name)."(".$sterm.")");
							}else{
								echo("<font color=#999999>Not sure what $gender_name studies</font>");
							}
							
							if($cschool!=NULL){
								echo("<font color=#000000>");
								if($cdegree!=NULL)echo(", "); 
								echo($school_name);
								echo("</font>");
							}
						?> 
					</div>
				 <div style="font-size:12px; line-height:130%; margin-top:0">            
			      <?php
				  echo("<strong>Current:</strong> &nbsp;$ccity_cstate &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
?>				  
					</div>
					<div style="display:; margin-top:5">
							      <?php
	 					if($rel_rstatus!="S"){?>
						<a href="SendMessage.php?recipient=<?php echo($loopname) ?>">
      <div style="font-size:11px; font-weight:normal; width:70; height:20; border-right:1px #999999 solid; border-bottom:1px #999999 solid; background: url(img/master.jpg); color:#000000; padding:2 5 2 5; display:inline" align="center">Message</div></a>
      <?php } ?>&nbsp;<?php
							if($rel_rstatus=="S")echo("<a href='EditEduInfo.php'><div style='font-size:11px; font-weight:normal; width:70; height:20; border:1px #CCCCCC solid; background: url(img/GrayGradbgDown.jpg); color:#333333;  padding:2 5 2 5; display:inline; cursor:pointer' align='center'>+ Edit</div></a>&nbsp;");
						else if($rel_rstatus=="P")echo("<div style='font-size:11px; font-weight:normal; width:70; height:20; border-right:1px #CCCCCC solid; border-bottom:1px #CCCCCC solid; background: url(img/GrayGradbgDown.jpg); color:$_SESSION[hcolor];  padding:2 5 2 5; display:inline' align='center'>Requested</div>");
						else if($rel_rstatus=="A")echo("<a href='FriendConfirm.php?uid=$loopname&&pageName=FriendGroup'><div style='font-size:11px; font-weight:normal; width:70; height:20; border-right:1px #CCCCCC solid; border-bottom:1px #CCCCCC solid; background: url(img/GrayGradbgDown.jpg); color:#333333;  padding:2 5 2 5; display:inline; cursor:pointer' align='center'>Defriend</div></a>");
						else if($rel_rstatus=="X"){
							echo("<div style='font-size:11px; font-weight:normal; width:130px; height:20; border-right:1px #CCCCCC solid; border-bottom:1px #CCCCCC solid; background: $_SESSION[hcolor]; color:#FFFFFF;  padding:2 8 2 8; display:inline' align='center'><a href='AcceptFriend.php?sender=$loopname' class=>Accept Request</a></div>&nbsp;&nbsp;");
							echo("<div style='font-size:11px;  font-weight:normal; width:85px; width:70; height:20; border-right:1px #CCCCCC solid; border-bottom:1px #CCCCCC solid; background: url(img/black_cell_bg.jpg); color:#FFFFFF;  padding:2 5 2 5; display:inline; cursor:pointer' align='center'><a href='DenyFriend.php?sender=$loopname&&pageName=FriendGroupResult' class=>Ignore</a></div>");
							}else if($rel_rstatus=="N")echo("<div id='addFriendMajorDiv$loopname' class='addFriendMajorDiv$loopname' style='font-size:11px; font-weight:normal; width:80; height:20; border:1px #DDDDDD solid; border-right:1px #999999 solid; border-bottom:1px #999999 solid; background: url(img/".substr($_SESSION['hcolor'],1,6)."_ajax_button.jpg); color:#000000;  padding:2 5 2 5; display:inline; cursor:pointer' align='center'>+ Friend</div>");
						?>
      <span id="flashAddFriendMajor<?php echo($loopname) ?>" class="flashAddFriendMajor<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span> <span id="addFriendMajorResult<?php echo($loopname) ?>" class="addFriendMajorResult<?php echo($loopname) ?>" style='font-size:11px; width:122; height:20; border-right:1px #DDDDDD solid; border-bottom:1px #DDDDDD solid; background: url(img/GrayGradbgDown.jpg); color:#333333;  padding:2 5 2 5; display:none' align='center'></span>&nbsp;
							
					</div>
				  </td>
                </tr>
              </table>
            <?php 
			//}
	//		$i++;
			} ?>
			
<?php
$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items != 0 ){
?>
            <table width="700" height="40" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px; margin-bottom:10">
              <tr>
                <td height="35" align="left" style="padding-left:10px; font-weight:bold; font-size:14px; font-family:Arial, Helvetica, sans-serif ">&nbsp;</td>
                <td width="363" height="35" align="right" style="padding-right:25; font-size:13px; padding-top:10" valign="top">
<?php
//Global Variable: 
$page_name = "FriendGroup.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

//echo($sel_count);
$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items == 0 );

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
if ($total_items != 0 )echo "<font color=>Page</font> ";
//prev. page
$prev_page = $page - 1;
if($prev_page >= 1) { 
	echo("<a href=$page_name?limit=$limit&page=$prev_page class=one><<</a>");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo(" <strong><font style='font-size:14px' color=$_SESSION[hcolor]><u>$a</u></font></strong>  "); //no link
}else{ 
	echo("<a href=$page_name?limit=$limit&page=$a class=one> $a </a>   ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo(" <a href=$page_name?limit=$limit&page=$next_page class=one>>></a>");
}
echo " ";
?>                </td>
              </tr>
            </table>
			<?php } ?>
			
			
			
			
			</td>
        </tr>
        </table>
      </td>
    </tr>
</table>
<font size="2"><?php include("bottomMenu".$_SESSION['lan'].".php"); ?></font>
</body></html>
