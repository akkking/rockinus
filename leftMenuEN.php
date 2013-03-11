<style type="text/css">
<!--
.STYLE8 {color: #000000}
-->
</style>
<div style="margin-top:0px; padding-left:10px" align="left">
  <div style="width:100px; padding-bottom:5px; padding-left:0px; padding-top:0px; margin-bottom:5px; border:0 solid #DDDDDD;"><font size="4" color="black">Menu List</font></div>
  <table width="100" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px">
    <tr>
      <td width="28" height="30"><img src="img/houselmIconNew.jpg" width="15" height="15" style="border:0" /></td>
      <td width="82" height="30" align="left" style="font-size:16px"><a href="HouseRental.php" class="one"><strong>House</strong></a></td>
    </tr>
    <tr>
      <td width="28" height="30">&nbsp;</td>
      <td height="30" valign="top"><img src="img/gray_plus.jpg" style="border:0px"/><a href="PostRental.php" class="one"> Post</a></td>
    </tr>
  </table>
  <table width="100" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px">
    <tr>
      <td width="28" height="30"><img src="img/flealmIcon.jpg" width="15" height="15" style="border:0" /></td>
      <td width="82" height="30" align="left" style="font-size:16px"><a href="FleaMarket.php" class="one"><strong>Market</strong></a></td>
    </tr>
    <tr>
      <td width="28" height="30">&nbsp;</td>
      <td height="30" valign="top"><img src="img/gray_plus.jpg" style="border:0px"/><a href="PostFlea.php" class="one"> Post</a></td>
    </tr>
  </table>
  <table width="100" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px">
    <tr>
      <td width="28" height="30"><img src="img/grouplmIcon.jpg" width="15" height="15" style="border:0" /></td>
      <td width="82" height="30" align="left" style="font-size:16px"><a href="openForum.php" class="one"><strong>Topic</strong></a>
	  <?php
$q = "SELECT count(*) as cnt FROM rockinus.forum_info";
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
echo "<font color=#999999 size=1> ($total_items)</font>";
?>
	  </td>
    </tr>
    <tr>
      <td width="28" height="30">&nbsp;</td>
      <td height="30" valign="top"><img src="img/gray_plus.jpg" style="border:0px"/><a href="postForum.php" class="one"> Post</a></td>
    </tr>
  </table>
  <table width="110" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px">
    <tr>
      <td width="28" height="30"><img src="img/friendlmIcon.jpg" width="15" height="15" style="border:0" /></td>
      <td width="82" height="30" align="left" style="font-size:16px"><a href="uploadCourseFile.php" class="one"><strong>Files</strong></a>
          <?php
$q = "SELECT count(*) as cnt FROM rockinus.user_file_info WHERE owner='$uname'";
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
  <table width="100" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px">
    <tr>
      <td width="28" height="30"><img src="img/eventlmIcon.jpg" width="15" height="15" style="border:0" /></td>
      <td width="72" height="30" align="left" style="font-size:16px"><a href="eventList.php" class="one"><strong>Event</strong></a>
	  <?php
$q = "SELECT count(*) as cnt FROM rockinus.event_info";
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
echo "<font color=#999999 size=1> ($total_items)</font>";
?></td>
    </tr>
    <tr>
      <td height="30">&nbsp;</td>
      <td width="72" height="30" align="left" valign="top"><img src="img/gray_plus.jpg" style="border:0px"/><a href="createEvent.php" class="one"> Post </a></td>
    </tr>
  </table>
  <table width="100" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px">
    <tr>
      <td width="28" height="30"><img src="img/profilelmIcon.jpg" width="15" height="15" style="border:0" /></td>
      <td width="72" height="30" align="left" style="font-size:16px"><a href="RockerDetail.php?uid=<?php echo($uname) ?>" class="one"><strong>Profile</strong></a></td>
    </tr>
    <tr>
      <td width="28" height="30">&nbsp;</td>
      <td height="30" align="left" valign="top"><img src="img/gray_plus.jpg" style="border:0px"/><a href="EditUserInfo.php" class="one"> Edit </a></td>
    </tr>
  </table>
  <table width="100" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
    <tr>
      <td width="28" height="30"><img src="img/settinglmIcon.jpg" width="15" height="15" style="border:0" /></td>
      <td width="72" height="30" align="left" style="font-size:16px"><a href="#" class="one"><font color="#999999"><strong>Setting</strong></font></a></td>
    </tr>
    <tr>
      <td height="30" style="color:#666666; font-size:11px" valign="top">&nbsp;</td>
      <td height="30" style="color:#666666; font-size:11px" valign="top">(Coming...)</td>
    </tr>
  </table>
  <br>
  <div class="STYLE8" style="border-bottom: 0px dotted #999999; width:100px; padding-bottom:4; margin-top:10px">
  <a href="QuitUs.php"><font color="#F5F5F5"><strong>Quit (Watch!)</strong></font></a></div>
  <br />
</div>
