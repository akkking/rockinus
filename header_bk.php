<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>&#26080;&#26631;&#39064;&#25991;&#26723;</title>
</head>

<body>
<table width="760" height="35" border="0" cellpadding="0" cellspacing="0" bgcolor="<?php echo($_SESSION['hcolor']) ?>" style="box-shadow: 2px 2px 2px #EEEEEE">
  <tr>
    <td width="85" valign="top" align="left" style="padding-top:5px; padding-left:15px"><div style="background:#F5F5F5; border:1px #EEEEEE solid; display:inline; padding:5px; padding-top:1px; padding-bottom:1px; height:20px; font-size:12px; font-weight:bold"> <a href="#" class="one" onclick="return overlib('&lt;div style=\'border:1px #666666 solid; padding:0px\'&gt;&lt;table style=border:1px #999999 solid; font-color:#999999&gt;&lt;tr&gt;&lt;td bgcolor=#387A36 width=\'25\' height=\'25\' style=padding:5px align=center&gt;&lt;a href=\'changeColor.php?hcolor=387A36\'&gt;^_^&lt;/a&gt;&lt;/td&gt;&lt;td bgcolor=#444444 width=\'25\' height=\'15\' style=padding:5px align=center&gt;&lt;a href=\'changeColor.php?hcolor=444444\'&gt;^_^&lt;/a&gt;&lt;/td&gt;&lt;td bgcolor=#2E4174 width=\'25\' height=\'25\' style=padding:5px align=center&gt;&lt;a href=\'changeColor.php?hcolor=2E4174\'&gt;^_^&lt;/a&gt;&lt;/td&gt;&lt;td bgcolor=#ED1C25 width=\'25\' height=\'25\' style=padding:5px align=center&gt;&lt;a href=\'changeColor.php?hcolor=ED1C25\'&gt;^_^&lt;/a&gt;&lt;/td&gt;&lt;td bgcolor=#7AC142 width=\'25\' height=\'25\' style=padding:5px align=center&gt;&lt;a href=\'changeColor.php?hcolor=7AC142\'&gt;^_^&lt;/a&gt;&lt;/td&gt;&lt;td bgcolor=#57068C width=\'25\' height=\'25\' style=padding:5px align=center&gt;&lt;a href=\'changeColor.php?hcolor=57068C\'&gt;^_^&lt;/a&gt;&lt;/td&gt;&lt;td bgcolor=#006699 width=\'25\' height=\'25\' style=padding:5px align=center&gt;&lt;a href=\'changeColor.php?hcolor=006699\'&gt;^_^&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;&lt;/div&gt;', OFFSETX, -45, OFFSETY, 15, CAPTION, '&lt;div style=\'border:0px #666666 solid; padding:4px; padding-left: 5px; font-size:12px; color:#000000 \'&gt;Select Color&lt;/div&gt;', CLOSEFONTCLASS, 'capfontClass', FGCOLOR, '#DDDDDD', BGCOLOR, '#DDDDDD', BORDER, 5, CAPTIONFONT, 'Garamond', TEXTFONT, 'Courier', TEXTSIZE, 2, WIDTH, 150, STICKY, CLOSECOLOR, '#999999', CLOSECLICK);" > <font color="#000000">More Skins</font></a> </div></td>
    <td width="186" valign="top" align="left" style="padding-top:5px; padding-left:0"><div style="background:#F5F5F5; border:1px #EEEEEE solid; display:inline; padding:5px; padding-top:1px; padding-bottom:1px; height:20px; font-size:12px; font-weight:bold"> <a href="EditUserInfo.php" class="one">+ Edit Profile</a></div></td>
    <td width="328" align="right" valign="top" style="padding-left:10px; padding-top:3px"><ul id="nav">
      <li style="background:<?php if($cnt_total_rqst>0)echo("yellow");else echo("#F5F5F5"); ?>"><a href="#" class="one">Request (<?php echo($cnt_total_rqst) ?>)</a>
            <ul style="margin-left:-1px">
              <li style="padding-left:5px;background:<?php if($cnt_friend_rqst>0)echo("yellow");else echo("#F5F5F5");?>"><a href="FriendGroup.php?friendreq=1">Friend (<?php echo($cnt_friend_rqst) ?>)</a></li>
              <li style="padding-left:5px;background:<?php if($cnt_file_rqst>0)echo("yellow");else echo("#F5F5F5");?>"><a href="fileRequestList.php">Other (<?php echo($cnt_file_rqst) ?>)</a></li>
            </ul>
        <div class="clear"></div>
      </li>
      <li style="background:<?php if($cnt_unread_msg>0)echo("#FFCC00");else echo("#F5F5F5"); ?>"><a href="MessageList.php" class="one">Message (<?php echo($cnt_unread_msg) ?>)</a></li>
      <li style="background:<?php if($replied_cnt>0)echo("#FFCC00");else echo("#F5F5F5"); ?>"><a href="recentUpdates.php" class="one">Recent (
              <?php 
	echo($replied_cnt) ?>
        )</a>
            <div class="clear"></div>
      </li>
    </ul>
        <div class="clear"></div></td>
    <td width="161" align="right" valign="top" style="padding-right:15px; font-size:12px; padding-top:10px; font-family:Arial, Helvetica, sans-serif"><?php 
	if(getUserPoint($uname)<500)
	  echo "<font color=#DDDDDD><strong><a href=UpdateWall.php>I'm Rookie</a></strong></font>";
	else if(getUserPoint($uname)<2500)
	  echo "<font color=#DDDDDD><strong><a href=UpdateWall.php>I'm Senior</a></strong></font>";  
	else
	  echo "<font color=#DDDDDD><strong><a href=UpdateWall.php>I'm Professional</a></strong></font>";  
	?>
    </td>
  </tr>
</table>
</body>
</html>
