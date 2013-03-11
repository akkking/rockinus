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

$interview = mysql_query("SELECT count(*) as cnt FROM rockinus.interview_question");
if(!$interview)	die("Error quering the Database: " . mysql_error());
$interview_f = mysql_fetch_object($interview);
$interview_cnt = $interview_f->cnt;

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
<table width="250" cellspacing="0" cellpadding="0" style="border-right:0px dashed #999999">
  <tr>
    <td height="511" valign="top">
	<a href="FleaMarket.php" class="two"><div style="margin-bottom:25; -moz-border-radius: 5px; border-radius: 5px; width:200px; height:35px; padding:5 0 5 0; background:#FF9966; font-size:24px; line-height:150%; border:1px solid #666666; color:#FFFFFF; cursor:pointer" align="center">
	  <img src="img/colorBuyIcon.jpg" width="20" /> Sales Buy</div></a>
	<table border="0" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor='#FFFFFF';" onmouseout=" this.style.backgroundColor='#FFFFFF';" style="margin-top:10">
        <tr>
          <td width="40" rowspan="2" style="border-bottom:0px #DDDDDD solid; padding-left:5px; padding-top:5px" valign="top">
		  <img src="img/houseMenuIcon.jpg" width="25" /></td>
          <td width="210" height="32" style="font-size: 24px; font-weight:normal; border-bottom:0px #DDDDDD solid; padding-left:5px"><a href="HouseRental.php" class="one">House Rent</a>	<font color="#999999" style='font-weight:normal; font-size:18px'><?php echo("($house_cnt)") ?></font></td>
        </tr>
        <tr>
          <td height="40" valign="top" style=" padding-bottom:5; padding-right:10px; line-height:150%; font-weight: ; border-bottom:0px #DDDDDD solid; padding-left:5px; font-size:12px; color:"><table width="130" height="150" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:5">
              <tr>
                <td height="24" align="left" style="width:100px; padding-bottom:4; padding-top:4; font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold">Search by Category</td>
              </tr>
              <tr>
                <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?type=<?php echo("All") ?>" class="one">All Types </a></td>
              </tr>
              <tr>
                <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="roomMateList.php" class="one">Room mate</a></td>
              </tr>
              <tr>
                <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?type=<?php echo("Single Room") ?>" class="one">Single Room</a></td>
              </tr>
              <tr>
                <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?type=<?php echo("Apartment") ?>" class="one">Apartment</a></td>
              </tr>
            <tr>
                <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?type=<?php echo("Studio") ?>" class="one">Studio</a> </td>
              </tr>
              <tr>
                <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?type=<?php echo("House") ?>" class="one">House</a></td>
              </tr>
              <tr>
                <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?type=<?php echo("Others") ?>" class="one">Others</a></td>
              </tr>
            </table>
              <table width="130" height="150" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="24" align="left" style="width:100px; padding-bottom:4; padding-top:4; font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold">Search by Location</td>
                </tr>
                <tr>
                  <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?city=<?php echo("All") ?>" class="one">All Areas</a></td>
                </tr>
                <tr>
                  <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?city=<?php echo("Brooklyn") ?>" class="one">Brooklyn</a></td>
                </tr>
                <tr>
                  <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?city=<?php echo("Manhattan") ?>" class="one">Manhattan</a></td>
                </tr>
                <tr>
                  <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?city=<?php echo("Queens") ?>" class="one">Queens</a></td>
                </tr>
                <tr>
                  <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?city=<?php echo("Bronx") ?>" class="one">Bronx</a> </td>
                </tr>
                <tr>
                  <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?city=<?php echo("Long Island") ?>" class="one">Long Island</a></td>
                </tr>
                <tr>
                  <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?city=<?php echo("Others") ?>" class="one">Others</a></td>
                </tr>
            </table>
            <table width="130" height="150" border="0" cellpadding="0" cellspacing="0" style="margin-top:5; margin-left:0px; margin-bottom:5px">
                <tr>
                  <td height="24" align="left" style="width:100px; padding-bottom:4; padding-top:4; font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold">Search by Rates</td>
                </tr>
                <tr>
                  <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?rate=<?php echo("All") ?>" class="one">All Ranges </a></td>
                </tr>
                <tr>
                  <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?rate=300" class="one">$0 ~ 300 </a></td>
                </tr>
                <tr>
                  <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?rate=400" class="one">$300~400</a></td>
                </tr>
                <tr>
                  <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?rate=500" class="one">$400~500</a></td>
                </tr>
                <tr>
                  <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?rate=600" class="one">$500~600</a></td>
                </tr>
                <tr>
                  <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?rate=1000" class="one">$600~$1000</a></td>
                </tr>
                <tr>
                  <td height="10" style="padding-top:0; font-size:14px"><strong>&middot;</strong>&nbsp;&nbsp;&nbsp;<a href="HouseRental.php?rate=10000" class="one">&gt; $1000</a></td>
                </tr>
            </table></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
