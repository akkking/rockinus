<?php
include 'dbconnect.php';
include 'Allfuc.php';
session_start();
$uname = $_SESSION['usrname'];
 
if(isset($_POST['content']))
{
 $content=addslashes($_POST['content']);
 $memoid=$_POST['memoid'];
 $sender=$_POST['sender'];
 $recipient=$_POST['recipient'];
 $pdate=$_POST['pdate'];
 $ptime=$_POST['ptime'];
 mysql_query("INSERT INTO rockinus.memo_follow_info(descrip,memoid,sender,recipient,pdate,ptime, rstatus) VALUES ('$content','$memoid','$sender','$recipient','$pdate', '$ptime','N');");
 $sql_in= mysql_query("SELECT descrip,memofid FROM rockinus.memo_follow_info ORDER BY memofid DESC");
 $object = mysql_fetch_object($sql_in);
 $memofid = $object->memofid; 
 $descrip = $object->descrip; 
 $descrip = str_replace("\\","",nl2br($descrip));
 }
?>

<table width="740" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style=" margin-top:0px; margin-bottom:5px; border-bottom:0 #DDDDDD dashed">
                      <tr>
                        <td width="75" style="padding:5; padding-left:0" valign="top">
						<?php 
			$memo_uname = $sender.'_fixed70.jpg';
			//date('Y-m-d, H:i');
			$target_memo_uname = "upload/".$sender;
			echo("<table><tr>");
			if(is_dir($target_memo_uname)){
				echo("<td align='center' style='border:0px solid #EEEEEE; padding:0px' width='50px'><a href='RockerDetail.php?uid=$sender' class=one title='$sender'><img src=upload/$sender/$memo_uname?".time()." style='margin-right:0px;'></a></td>");
			}else 
				echo("<td align='center' style='border:0px solid #EEEEEE; padding:0px' width='50px'><a href='RockerDetail.php?uid=$sender' class=one title='$sender'><img src='img/NoUserIcon_fixed.jpg' width=70 height=70 style='margin-right:0px;'></a></td>");
			echo("</tr></table>");
			 ?>			 </td>
             <td height="36" colspan="0" valign="top" style="padding-top:5px; line-height:150%; border-top:0px #EEEEEE solid; padding-left:15px; font-size:14px">
	<?php
			echo(nl2br($descrip));
			echo("<br><br><font color=#999999 style='font-size:12px'>".getDateName($pdate)." | ".$ptime." | </font>");
			if($sender==$uname)echo("<font color=#999999>From </font><a href='RockerDetail.php?uid=$sender' class=one><font color=#999999><strong>$sender</strong></font></a>");
			else
			echo("<font color=#999999>From </font><a href='RockerDetail.php?uid=$sender' class=one><font color=#999999><strong>$sender</strong></font></a>");
	?>    </td>
      </tr>
</table>
              