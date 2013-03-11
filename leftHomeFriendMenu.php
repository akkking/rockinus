<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo($uname) ?>, welcome home</title>
<style type="text/css">
<!--
body,td,th {
	font-size: 14px;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>
<?php
$q1 = mysql_query("SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_edu_info b INNER JOIN rockinus.user_contact_info c ON a.uname='$uname' AND a.uname=b.uname AND a.uname=c.uname;");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
//$student_cnt = $object->cnt;
$fregion = $object->fregion;
$fcountry = $object->fcountry;
$cstate = $object->cstate;
$ccity = $object->ccity;
$cmajor = $object->cmajor;
$cschool = $object->cschool;

$t = mysql_query("SELECT count(*) AS cnt FROM rockinus.user_check_info WHERE status='A'");
$x = mysql_fetch_object($t);
$student_cnt = $x->cnt;

$t = mysql_query("SELECT count(*) AS cnt FROM rockinus.rocker_rel_history WHERE recipient='$uname' AND rstatus='P'");
$y = mysql_fetch_object($t);
$req_items = $y->cnt;

$t = mysql_query("SELECT count(*) AS cnt FROM rockinus.rocker_rel_info WHERE sender='$uname' OR recipient='$uname'");
$z = mysql_fetch_object($t);
$rel_items = $z->cnt;

$t = mysql_query("SELECT count(b.uname) AS cnt FROM rockinus.user_course_info a JOIN rockinus.user_course_info b ON a.uname='$uname' AND a.uname<>b.uname AND a.course_uid=b.course_uid;");
if(!$t) die("Error quering the Database: " . mysql_error());
$a = mysql_fetch_object($t);
$course_items = $a->cnt;

//$t = mysql_query("SELECT count(*) AS cnt FROM rockinus.user_info WHERE fcountry='$fcountry';");
$t = mysql_query("SELECT count(*) as cnt FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname AND a.fcountry='$fcountry'");
$x = mysql_fetch_object($t);
$country_items = $x->cnt;

$t = mysql_query("SELECT count(*) AS cnt FROM rockinus.user_info WHERE fregion='$fregion' AND fcountry='$fcountry';");
$b = mysql_fetch_object($t);
$home_items = $b->cnt;

$t = mysql_query("SELECT count(*) AS cnt FROM rockinus.user_contact_info WHERE ccity='$ccity' AND cstate='$cstate';");
$e = mysql_fetch_object($t);
$location_items = $e->cnt;

$t = mysql_query("SELECT count(*) AS cnt FROM rockinus.user_edu_info WHERE cmajor='$cmajor';");
$c = mysql_fetch_object($t);
$major_items = $c->cnt;

$t = mysql_query("SELECT count(*) AS cnt FROM rockinus.user_edu_info WHERE cschool='$cschool';");
$d = mysql_fetch_object($t);
$school_items = $d->cnt;
?>
</head>
<body>
<?php
$news = mysql_query("SELECT count(*) as cnt FROM rockinus.news_info");
if(!$news)	die("Error quering the Database: " . mysql_error());
$news_f = mysql_fetch_object($news);
$news_cnt = $news_f->cnt;

$course_comment = mysql_query("SELECT count(*) as cnt FROM rockinus.course_memo_info");
if(!$course_comment)	die("Error quering the Database: " . mysql_error());
$course_comment_f = mysql_fetch_object($course_comment);
$course_comment_cnt = $course_comment_f->cnt;

$house = mysql_query("SELECT count(*) as cnt FROM rockinus.house_info");
if(!$house)	die("Error quering the Database: " . mysql_error());
$house_f = mysql_fetch_object($house);
$house_cnt = $house_f->cnt;

$article = mysql_query("SELECT count(*) as cnt FROM rockinus.article_info");
if(!$article)	die("Error quering the Database: " . mysql_error());
$article_f = mysql_fetch_object($article);
$article_cnt = $article_f->cnt;

$people = mysql_query("SELECT count(*) as cnt FROM rockinus.user_check_info WHERE status='A'");
if(!$people)	die("Error quering the Database: " . mysql_error());
$people_f = mysql_fetch_object($people);
$people_cnt = $people_f->cnt;
?>
<table width="250" cellspacing="0" cellpadding="0" style="border-right:0px dashed #999999; margin-bottom:25px">
  <tr>
    <td height="511" valign="top"><table width="250" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="36" rowspan="2" valign="top" style="border-bottom:0px #DDDDDD solid; padding-left:5px; padding-top:5px">
		  <img src="img/friends_group.png" width="25" /></td>
	    </tr>
        <tr>
          <td width="214" height="40" valign="top" style=" padding-bottom:10; padding-right:10px; line-height:150%; font-weight: ; font-size:14px; color:#999999"><table width="200" height="164" border="0" cellpadding="0" cellspacing="0" style="margin-top:0">
              <tr>
                <td height="30" style="padding-top:3px; padding-left:5px;  font-size:14px; font-family:Arial, Helvetica, sans-serif;" align="left">
				<strong>&middot;</strong>&nbsp;&nbsp;<?php echo("<a href=FriendGroup.php?friendreq=1 class=one>Friend Requests</a> <font color=#999999 style='font-size:14px'>($req_items)</font>") ?> </td>
              </tr>
              <tr>
                <td height="30" style="padding-top:3px; padding-left:5px;  font-size:14px; font-family:Arial, Helvetica, sans-serif" align="left">
				<strong>&middot;</strong>&nbsp;&nbsp;<?php echo("<a href=FriendGroup.php?myfriends=1 class=one>My friends</a> <font color=#999999 style='font-size:14px'>($rel_items)</font>") ?> </td>
              </tr>
              <tr>
                <td height="30" style="padding-top:3px; padding-left:5px;  font-size:14px">
				<strong>&middot;</strong>&nbsp;&nbsp;<?php echo("<a href=FriendGroup.php?fcountry=$fcountry class=one>Same Country</a> <font color=#999999 style='font-size:14px'>($country_items)</font>") ?></td>
              </tr>
              <tr>
                <td height="30" style="padding-top:3px; padding-left:5px;  font-size:14px">
				<strong>&middot;</strong>&nbsp;&nbsp;<?php echo("<a href=FriendGroup.php?fcountry=$fcountry&fregion=$fregion class=one>Same Hometown</a> <font color=#999999 style='font-size:14px'>($home_items)</font>") ?></td>
              </tr>
              <tr>
                <td height="30" style="padding-top:3px; padding-left:5px;  font-size:14px">
				<strong>&middot;</strong>&nbsp;&nbsp;<?php echo("<a href=FriendGroup.php?ccity=$ccity&cstate=$cstate class=one>Same Location</a> <font color=#999999 style='font-size:14px'>($location_items)</font>") ?></td>
              </tr>
              <tr>
                <td height="30" style="padding-top:3px; padding-left:5px; font-size:14px" align="left">
				<strong>&middot;</strong>&nbsp;&nbsp;<?php 
	// echo("Courses");
	echo("<a href=FriendGroup.php?course=1 class=one>Same Courses</a> <font color=#999999 style='font-size:14px'>($course_items)</font>") 
	?>                </td>
              </tr>
              <tr>
                <td height="30" style="padding-top:3px; padding-left:5px; font-size:14px" align="left">
				<strong>&middot;</strong>&nbsp;&nbsp;<?php echo("<a href=FriendGroup.php?major=$cmajor class=one>Same Major</a> <font color=#999999 style='font-size:14px'>($major_items)</font>") ?></td>
              </tr>
              <tr>
                <td height="30" style="padding-top:3px; padding-left:5px;  font-size:14px" align="left">
				<strong>&middot;</strong>&nbsp;&nbsp;<?php echo("<a href=FriendGroup.php?school=$cschool class=one>Same School</a> <font color=#999999 style='font-size:14px'>($school_items)</font>") ?></td>
              </tr>
              <tr>
                <td height="30" style="padding-top:3px; padding-left:5px;  font-size:14px" align="left">
				<strong>&middot;</strong>&nbsp;&nbsp;<?php 
	echo("Recommended<font style='font-size:14px; color:#999999'> (Coming)</font>");
	// echo("<a href=FriendGroup.php?specials= class=one>May Interested</a>") 
	?>                </td>
              </tr>
          </table></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
