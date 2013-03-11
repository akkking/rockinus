<?php
include 'dbconnect.php';
session_start();
 
if(isset($_POST['cid']))
{
 	$cid=$_POST['cid'];
 	$q_delete = mysql_query("DELETE FROM rockinus.article_comment WHERE cid='$cid';");
	if(!$q_delete) $output = mysql_error();
 	else $output = "&nbsp;<img src=img/addsuccessIcon_F5.jpg width=15/>&nbsp;&nbsp;Your comment has been removed successfully :)";
}
?>
<table width="400" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style=" margin-top:5; margin-bottom:15; border:0px #DDDDDD solid">
  <tr>
   <td style="padding-left:5px; padding-top:5px; padding-bottom:5px; background-color:#F5F5F5; font-size:12px; font-weight:bold" valign="top">
<?php echo($output); ?>
</td>
</tr>
</table>
              