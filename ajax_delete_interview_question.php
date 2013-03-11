<?php
include 'dbconnect.php';
session_start();
 
if(isset($_POST['q_follow_id']))
{
 	$q_follow_id=$_POST['q_follow_id'];
 	$q_delete = mysql_query("DELETE FROM rockinus.interview_question_follow WHERE q_follow_id='$q_follow_id';");
	if(!$q_delete) $output = mysql_error();
 	else $output = "&nbsp;<img src=img/addsuccessIcon_F5.jpg width=10 />&nbsp;&nbsp; Your answer has been removed successfully :)";
}
?>
<table width="460" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style=" margin-top:5px; margin-bottom:5px; border:0px #DDDDDD solid">
  <tr>
   <td style="padding-left:5px; padding-top:5px; padding-bottom:5px; background-color:#F5F5F5; font-size:11px; font-weight:normal" valign="top">
<?php echo($output); ?>
</td>
</tr>
</table>
              