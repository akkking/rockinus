<?php
include 'dbconnect.php';
session_start();
 
if(isset($_POST['hi_follow_id']))
{
 	$hi_follow_id=$_POST['hi_follow_id'];
 	$q_delete = mysql_query("DELETE FROM rockinus.headicon_comment WHERE hi_follow_id='$hi_follow_id';");
	if(!$q_delete) $output = mysql_error();
 	else $output = "&nbsp;<img src=img/addsuccessIcon_F5.jpg width=10/>&nbsp;&nbsp; Comment has been removed successfully :)";
}
?>
<table width="450" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style=" margin-top:5; margin-bottom:5; border:0px #DDDDDD solid">
  <tr>
   <td style="padding-top:5px; padding-bottom:5px; background-color:#F5F5F5; font-size:11px; font-weight:normal" align="left" valign="top">
&nbsp; <?php echo($output); ?>
</td>
</tr>
</table>
              