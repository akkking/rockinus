<?php
$q1 = mysql_query("SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_edu_info b ON a.uname='$uname' AND a.uname=b.uname");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$fregion = $object->fregion;
$fcountry = $object->fcountry;
$cmajor = $object->cmajor;
$cschool = $object->cschool;

$t = mysql_query("SELECT count(*) as cnt FROM rockinus.rocker_rel_history WHERE recipient='$uname' AND rstatus='P'");
$y = mysql_fetch_object($t);
$req_items = $y->cnt;

$t = mysql_query("SELECT count(*) as cnt FROM rockinus.rocker_rel_info WHERE sender='$uname' OR recipient='$uname'");
$z = mysql_fetch_object($t);
$rel_items = $z->cnt;

$t = mysql_query("SELECT count(DISTINCT a.uname) as cnt FROM rockinus.user_course_info a INNER JOIN rockinus.user_course_info b ON a.coid=b.coid AND a.uname!='$uname' AND a.uname<>b.uname GROUP BY a.uname;");
if(!$t) die("Error quering the Database: " . mysql_error());
$a = mysql_fetch_object($t);
$course_items = $a->cnt;

$t = mysql_query("SELECT count(*) as cnt FROM rockinus.user_info WHERE fregion='$fregion' AND fcountry='$fcountry';");
$b = mysql_fetch_object($t);
$home_items = $b->cnt;

$t = mysql_query("SELECT count(*) as cnt FROM rockinus.user_edu_info WHERE cmajor='$cmajor';");
$c = mysql_fetch_object($t);
$major_items = $c->cnt;

$t = mysql_query("SELECT count(*) as cnt FROM rockinus.user_edu_info WHERE cschool='$cschool';");
$d = mysql_fetch_object($t);
$school_items = $d->cnt;
?>
<table width="115" height="164" border="0" cellpadding="0" cellspacing="0" style="margin-top:0">
  <tr>
    <td height="24" style="padding-bottom:5px"> <a href="FriendGroup.php" class="one"><strong><font size="3">Students</font></strong></a></td>
  </tr>
  <tr>
    <td height="20" style="padding-top:5px; padding-left:0px">
	<img src="img/RightArrow.jpg" width="12" height="12"> 
	<?php echo("<a href=FriendGroup.php?friendreq=1 class=one>好友请求</a> <font color=#CCCCCC size=1>($req_items)</font>") ?>
	</td>
  </tr>
  <tr>
    <td height="20" style="padding-top:5px; padding-left:0px">
	<img src="img/RightArrow.jpg" width="12" height="12"> 
	<?php echo("<a href=FriendGroup.php?myfriends=1 class=one>我的好友</a> <font color=#CCCCCC size=1>($rel_items)</font>") ?>
	</td>
  </tr>
  <tr>
    <td height="20" style="padding-top:5px; padding-left:0px">
	<img src="img/RightArrow.jpg" width="12" height="12" /> 
	<?php echo("<a href=FriendGroup.php?fcountry=$fcountry&fregion=$fregion class=one>Hometown</a> <font color=#CCCCCC size=1>($home_items)</font>") ?></td>
  </tr>
  <tr>
    <td height="20" style="padding-top:5px; padding-left:0px"><img src="img/RightArrow.jpg" width="12" height="12" /> <?php echo("<a href=FriendGroup.php?course=1 class=one>Courses</a> <font color=#CCCCCC size=1>($course_items)</font>") ?></td>
  </tr>
  <tr>
    <td height="20" style="padding-top:5px; padding-left:0px"><img src="img/RightArrow.jpg" width="12" height="12" /> <?php echo("<a href=FriendGroup.php?major=$cmajor class=one>Major</a> <font color=#CCCCCC size=1>($major_items)</font>") ?></td>
  </tr>
  <tr>
    <td height="20" style="padding-top:5px; padding-left:0px"><img src="img/RightArrow.jpg" width="12" height="12" /> <?php echo("<a href=FriendGroup.php?school=$cschool class=one>School</a> <font color=#CCCCCC size=1>($school_items)</font>") ?></td>
  </tr>
  <tr>
    <td height="20" style="padding-top:5px; padding-left:0px; padding-bottom:5px"><img src="img/RightArrow.jpg" width="12" height="12" /> <?php echo("<a href=FriendGroup.php?specials= class=one>Matched</a>") ?></td>
  </tr>
</table>
<br>
<table width="115" height="186" border="0" cellpadding="0" cellspacing="0" style="margin-top:5">
  <tr>
    <td height="26"><a href="GroupList.php" class="one"><strong><font size="3">Groups</font></strong></a></td>
  </tr>
  <tr>
    <td height="25" style="padding-top:5; padding-left:0px;">
	<img src="img/RightArrow.jpg" width="12" height="12" /> <a href="GroupCreate.php" class="one">Create +</a> </td>
  </tr>
  <tr>
    <td height="25" style="padding-top:5; padding-left:0px"><img src="img/RightArrow.jpg" width="12" height="12" /> <a class='one' href="Grouplist.php?type=hometown">Hometown</a></td>
  </tr>
  <tr>
    <td height="25" style="padding-top:5; padding-left:0px"><img src="img/RightArrow.jpg" width="12" height="12" /> <a class='one' href="Grouplist.php?type=interests">Interests </a></td>
  </tr>
  <tr>
    <td height="25" style="padding-top:5; padding-left:0px"><img src="img/RightArrow.jpg" width="12" height="12" /> <a class='one' href="Grouplist.php?type=expertise">Department </a></td>
  </tr>
  <tr>
    <td height="25" style="padding-top:5; padding-left:0px"><img src="img/RightArrow.jpg" width="12" height="12" /> <a class='one' href="Grouplist.php?type=school">Schools</a> </td>
  </tr>
  <tr>
    <td height="25" style="padding-top:5; padding-left:0px"><img src="img/RightArrow.jpg" width="12" height="12" /> <a class='one' href="Grouplist.php?type=career">Career</a> </td>
  </tr>
  <tr>
    <td height="25" style="padding-top:5; padding-left:0px; padding-bottom:5px"><img src="img/RightArrow.jpg" width="12" height="12" /> <a class='one' href="Grouplist.php?type=specials">Specials</a></td>
  </tr>
  
  <tr>
    <td height="25" style="padding-top:5; padding-left:5px; padding-bottom:5px">&nbsp;</td>
  </tr>
</table>
<br />
<br />
