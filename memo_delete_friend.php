<?php
include 'dbconnect.php';
session_start();
 
if(isset($_POST['memofid']))
{
 	$memofid=$_POST['memofid'];
 	$q_delete = mysql_query("DELETE FROM rockinus.memo_follow_info WHERE memofid='$memofid';");
	if(!$q_delete) $output = mysql_error();
 	else $output = "&nbsp;<img src=img/addsuccessIcon_F5.jpg width=10 />&nbsp;&nbsp;Comment has been removed successfully :)";
}
?>
<table width="450" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style=" margin-top:5; margin-bottom:5; border:0px #DDDDDD solid">
  <tr>
   <td style="padding-left:5px; padding-top:5px; padding-bottom:5px; background-color:#F5F5F5; color:#666666; font-size:11px; font-weight:normal" valign="top">
<?php echo($output); ?>
</td>
</tr>
</table>
              