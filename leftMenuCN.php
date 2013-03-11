<style type="text/css">
<!--
.STYLE8 {color: #000000}
-->
</style>
<div style="margin-top:0px; padding-left:3px" align="left">
  <div style="width:100px; padding-bottom:5px; padding-left:0px; padding-top:0px; margin-bottom:5px; border:0 solid #DDDDDD;"><font size="4" color="black">我的菜单</font></div>
  <table width="100" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px">
    <tr>
      <td width="28" height="30"><img src="img/houselmIcon.jpg" width="15" height="15" style="border:0" /></td>
      <td width="82" height="30" align="left"><a href="HouseRental.php" class="one"><font size="3" color="#000000"><strong>房出租</strong></font></a></td>
    </tr>
    <tr>
      <td width="28" height="30">&nbsp;</td>
      <td height="30" valign="top"><img src="img/rightTriangleIcon.jpg" style="border:0px"/><a href="PostRental.php" class="one"> 发帖  </a></td>
    </tr>
  </table>
  <table width="100" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px">
    <tr>
      <td width="28" height="30"><img src="img/flealmIcon.jpg" width="15" height="15" style="border:0" /></td>
      <td width="82" height="30" align="left"><a href="FleaMarket.php" class="one"><font size="3" color="#000000"><strong>二手货</strong></font></a></td>
    </tr>
    <tr>
      <td width="28" height="30">&nbsp;</td>
      <td height="30" valign="top"><img src="img/rightTriangleIcon.jpg" style="border:0px"/><a href="PostFlea.php" class="one"> 发帖</a></td>
    </tr>
  </table>
  <table width="100" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px">
    <tr>
      <td width="28" height="30"><img src="img/courselmIcon.jpg" width="15" height="15" style="border:0" /></td>
      <td width="100" height="30" align="left"><a href="SchoolCourse.php" class="one"><font size="3" color="#000000"><strong>课 程</strong></font></a>
	  <?php
$q = "SELECT count(*) as cnt FROM rockinus.user_course_info WHERE uname='$uname'";
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
echo "<font color=#999999 size=1> (".$total_items.")</font>";
?>
	  </td>
    </tr>
  </table>
  <table width="100" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="28" height="30"><img src="img/friendlmIcon.jpg" width="15" height="15" style="border:0" /></td>
      <td width="85" height="30" align="left"><a href="FriendGroup.php?myfriends=1" class="one"><font size="3" color="#000000"><strong>同 学</strong></font></a>
          <?php
$q = "SELECT count(*) as cnt FROM rockinus.rocker_rel_info WHERE sender='$uname' OR recipient='$uname'";
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
echo "<font color=#999999 size=1> (".$total_items.")</font>";
?>	 </td>
    </tr>
  </table>
  <table width="100" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:0px">
    <tr>
      <td width="36" height="30">&nbsp;&nbsp;</td>
      <td width="74" height="30" align="left" valign="top"><?php
$q = "SELECT count(*) as cnt FROM rockinus.rocker_rel_history WHERE recipient='$uname' and rstatus='P'";
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
echo "<div  style='border-bottom: 0px dotted #999999; width:110; padding-bottom:4;padding-left:15px'><img src=img/rightTriangleIcon.jpg style=border:0px /><a href=RequestList.php class=one> 申请</a><font color=#999999 size=1> (".$total_items.")</font> </div>";
?></td>
    </tr>
  </table>
  <table width="100" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 10px">
    <tr>
      <td width="28" height="30"><img src="img/grouplmIcon.jpg" width="15" height="15" style="border:0" /></td>
      <td width="82" height="30" align="left"><a href="GroupList.php" class="one"><font size="3" color="#000000"><strong>群 组</strong></font></a>
      <?php
$q = "SELECT count(*) as cnt FROM rockinus.group_info where unamelist like '%$uname%'";
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
echo "<a href=GroupList.php class=one><font color=#999999 size=1> ($total_items)</font></a>";
?></td>
    </tr>
  </table>
  <table width="100" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px">
    <tr>
      <td width="28" height="30"><img src="img/eventlmIcon.jpg" width="15" height="15" style="border:0" /></td>
      <td width="82" height="30" align="left"><a href="eventList.php" class="one"><font size="3" color="#000000"><strong>活 动</strong></font></a></td>
    </tr>
    <tr>
      <td height="30">&nbsp;</td>
      <td height="30" align="left" valign="top"><img src="img/rightTriangleIcon.jpg" style="border:0px"/><a href="createEvent.php" class="one"> 发起 </a></td>
    </tr>
  </table>
  <table width="100" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px">
    <tr>
      <td width="28" height="30"><img src="img/profilelmIcon.jpg" width="15" height="15" style="border:0" /></td>
      <td width="82" height="30" align="left"><a href="RockerDetail.php?uid=<?php echo($uname) ?>" class="one"><font size="3" color="#000000"><strong>资 料</strong></font></a></td>
    </tr>
    <tr>
      <td height="30">&nbsp;</td>
      <td height="30" align="left" valign="top"><img src="img/rightTriangleIcon.jpg" style="border:0px"/><a href="EditUserInfo.php" class="one"> 修改</a></td>
    </tr>
  </table>
  <table width="100" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px">
    <tr>
      <td width="28" height="30"><img src="img/msglmIcon.jpg" width="15" height="15" style="border:0" /></td>
      <td width="82" height="30" align="left"><a href="MessageList.php" class="one"><font size="3" color="#000000"><strong>信 件</strong></font></a></td>
    </tr>
    <tr>
      <td height="30">&nbsp;</td>
      <td height="30" align="left" valign="top"><img src="img/rightTriangleIcon.jpg" style="border:0px"/><a href="SendMessage.php" class="one"> 写信 </a></td>
    </tr>
  </table>
  <table width="100" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
    <tr>
      <td width="28" height="30"><img src="img/settinglmIcon.jpg" width="15" height="15" style="border:0" /></td>
      <td width="82" height="30" align="left"><a href="UserSetting.php" class="one"><font size="3" color="#000000"><strong>设 置</strong></font></a></td>
    </tr>
  </table>
  <table width="100" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px; margin-top:15px">
    <tr>
      <td height="30" bgcolor="#EEEEEE" style="border:1px dashed #CCCCCC" align="center">
	  <a href="openForum.php" class="one"><font color=""><strong>进入论坛</strong></font></a></td>
    </tr>
  </table>
  <br>
  <div class="STYLE8" style="border-bottom: 0px dotted #999999; width:100px; padding-bottom:4; margin-top:10px">
  <a href="QuitUs.php"><font color="#999999">销户</font></a></div>
  <br />
</div>
