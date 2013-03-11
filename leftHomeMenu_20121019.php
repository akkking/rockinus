<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<LINK REL="SHORTCUT ICON" HREF="img/rockinTag.jpg">
<title><?php echo($uname) ?>, welcome home</title>
<style type="text/css">
<!--
body,td,th {
	font-size: 14px;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style></head>
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
<table width="250" cellspacing="0" cellpadding="0" style="border-right:0px dashed #999999; margin-bottom:50">
  <tr>
    <td height="106" valign="top" style="border-right:0px #EEEEEE solid">
	<a href="ThingsRock.php"><img src="img/rockinus_home.jpg" width="195" height="50" /></a>	</td>
  </tr>
  <tr>
    <td height="511" valign="top"><table width="250" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30" background="img/master.png" style="border-bottom:1px #CCCCCC solid; padding-left:5px">
		<strong></strong>		</td>
        <td height="30" background="img/master.png" bgcolor="" style="font-weight: ; border-bottom:1px #CCCCCC solid; padding-left:15px; color:">
		<?php 
		$today = $today = date("D M j G:i:s"); 
		echo($today);
		?></td>
      </tr>
	  </table>
	  <table border="0" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
      <tr>
        <td height="5" style="border-bottom:0px #DDDDDD solid; padding-left:5px">&nbsp;</td>
        <td height="5" style=" font-weight: bold; font-size:16px; border-bottom:0px #DDDDDD solid; padding-left:15px">&nbsp;</td>
      </tr>
      <tr>
        <td width="30" height="40" style="border-bottom:0px #DDDDDD solid; padding-left:5px">
		<img src="img/grayStar.jpg" width="20" /></td>
        <td style=" font-weight: bold; font-size:16px; border-bottom:0px #DDDDDD solid; padding-left:15px">
		<a href="newsList.php" class="one">Notice, Events</a> <font color=#999999 style='font-weight:normal; font-size:14px'><?php echo("($news_cnt)") ?></font></td>
      </tr>
      <tr>
        <td height="40" style="border-bottom:1px #DDDDDD solid; padding-left:5px">&nbsp;</td>
        <td valign="top" style=" padding-bottom:10px; padding-right:10px; line-height:150%; font-weight: ; border-bottom:1px #DDDDDD solid; padding-left:15px; font-size:12px; color:#999999">
		What's new around campus? Notices, Events, Activities, Part-time, Seminar,  etc. Refresh urself everyday, with Poly, and others :)		</td>
      </tr>
	  </table>
	  <table border="0" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
      <tr>
        <td width="30" height="50" style="border-bottom:0px #DDDDDD solid; padding-left:5px">
		<img src="img/blackBook.jpg" width="20" /></td>
        <td height="50" style="font-weight:bold; font-size:16px; border-bottom:0px #DDDDDD solid; padding-left:15px">
		<a href="SchoolCourse.php" class="one">Course Board</a> <font color=#999999 style='font-weight:normal; font-size:14px'><?php echo("($course_comment_cnt)") ?></font>
		</td>
      </tr>
      <tr>
        <td height="40" style="border-bottom:1px #DDDDDD solid; padding-left:5px">&nbsp;</td>
        <td valign="top" style=" padding-bottom:10px; padding-right:10px; line-height:150%; font-weight: ; border-bottom:1px #DDDDDD solid; padding-left:15px; font-size:12px; color:#999999">
		Course notes, materials, comments. Check what other students say about it. Comment it, or upload/download some files :)
		</td>
      </tr>
	  </table>
	  <table border="0" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
      <tr>
        <td width="30" height="50" style="border-bottom:0px #DDDDDD solid; padding-left:5px">
		<img src="img/blackHouseSale.jpg" width="20" /></td>
        <td height="50" style="font-size: 16px; font-weight:bold; border-bottom:0px #DDDDDD solid; padding-left:15px">
		<a href="HouseRental.php" class="one">House Rental</a> <font color=#999999 style='font-weight:normal; font-size:14px'><?php echo("($house_cnt)") ?></font>
		</td>
      </tr>
      <tr>
        <td height="40" style="border-bottom:1px #DDDDDD solid; padding-left:5px">&nbsp;</td>
        <td valign="top" style=" padding-bottom:10px; padding-right:10px; line-height:150%; font-weight: ; border-bottom:1px #DDDDDD solid; padding-left:15px; font-size:12px; color:#999999">
		Lease/Rent Apt., or finding a roommate. Others will be informed at first time. Most important, you will be connected soon :)
		</td>
      </tr>
	  </table>
	  <table border="0" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
      <tr>
        <td width="30" height="40" style="border-bottom:0px #DDDDDD solid; padding-left:5px">
		<img src="img/blackBuy.jpg" width="20" /></td>
        <td style="font-weight:bold; font-size:16px; border-bottom:0px #DDDDDD solid; padding-left:15px">
		<a href="FleaMarket.php" class="one">Sale, Sale, Sale</a> <font color=#999999 style='font-weight:normal; font-size:14px'><?php echo("($article_cnt)") ?></font></td>
      </tr>
      <tr>
        <td height="40" style="border-bottom:1px #DDDDDD solid; padding-left:5px">&nbsp;</td>
        <td valign="top" style=" padding-bottom:10px; padding-right:10px; line-height:150%; font-weight: ; border-bottom:1px #DDDDDD solid; padding-left:15px; font-size:12px; color:#999999">
		Sell your unwanted things, or buy something necessary to you. Don't waste resource. Let's simply share, and create a double-benefit place :)		</td>
      </tr>
	  </table>
	  <table border="0" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
      <tr>
        <td width="30" height="40" style="border-bottom:0px #DDDDDD solid; padding-left:5px">
		<img src="img/grayStar_66CCFF.jpg" width="20" /></td>
        <td style="font-weight:bold; font-size:16px; border-bottom:0px #DDDDDD solid; padding-left:15px">
		<a href="FriendGroup.php" class="one">People, Friend</a>	 <font color=#999999 style='font-weight:normal; font-size:14px'><?php echo("($people_cnt)") ?></font></td>
      </tr>
      <tr>
        <td height="40" style="border-bottom:0px #DDDDDD solid; padding-left:5px">&nbsp;</td>
        <td valign="top" style=" padding-bottom:10px; padding-right:10px; line-height:150%; font-weight: ; border-bottom:0px #DDDDDD solid; padding-left:15px; font-size:12px; color:#999999">
		Students in same major, take same courses, or from same hometown as you, etc. Too many unexpected pleasure, explore them out :)		</td>
      </tr>
	  </table>
    </td>
  </tr>
</table>
</body>
</html>
