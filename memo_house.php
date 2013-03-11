<?php
include 'dbconnect.php';
include 'Allfuc.php';
session_start();
$uname = $_SESSION['usrname'];
 
if(isset($_POST['content']))
{
 $content=addslashes($_POST['content']);
 $hid=$_POST['hid'];
 $sender=$_POST['sender'];
 $recipient=$_POST['recipient'];
 $pdate=$_POST['pdate'];
 $ptime=$_POST['ptime'];
 mysql_query("INSERT INTO rockinus.house_comment(descrip,hid,sender,recipient,pdate,ptime, rstatus) VALUES ('$content','$hid','$sender','$recipient','$pdate', '$ptime','N');");
 $sql_in= mysql_query("SELECT cid FROM rockinus.house_comment ORDER BY cid DESC");
 $object = mysql_fetch_object($sql_in);
 $cid = $object->cid; 
 $descrip = $content;
 //$descrip = str_replace("\\","",nl2br($content));
 }
?>
<div id="flashDeleteMemo<?php echo($cid) ?>" class="flashDeleteMemo<?php echo($cid) ?>" style="padding-left:0px"></div>
<div id="deleteMemoResult<?php echo($cid) ?>" class="deleteMemoResult<?php echo($cid) ?>" style="padding-left:0px"></div>
<script type="text/javascript" >
$(function() {
	$(".deleteComment_button<?php echo($cid) ?>").click(function() {
		var cid = <?php echo($cid) ?>;
		var dataString = 'cid='+cid; 

		if(cid=='')
		{
			alert("not getting memo id!");
		}
		else
		{
			$("#flashDeleteMemo<?php echo($cid) ?>").show();
 			$("#flashDeleteMemo<?php echo($cid) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle"> <span class="loading">Posting New Status...</span>');
 
			$.ajax({
 				type: "POST",
				url: "memo_delete_house.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#deleteMemoResult<?php echo($cid) ?>").after(html);
					document.getElementById('replycontent').value='';
					document.getElementById('replycontent').focus();
					$("#flashDeleteMemo<?php echo($cid) ?>").hide();
					$("#houseMemo<?php echo($cid) ?>").hide();
					$("#deleteMemoResult<?php echo($cid) ?>").show();
				}
			});
		} return false;
 	});
 });
</script>
<div style="line-height:180%; margin-bottom:10; width: 550; border:0 #EEEEEE solid" id="houseMemo<?php echo($cid) ?>" class="houseMemo<?php echo($cid) ?>">
<table width="580" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style=" margin-top:0px; margin-bottom:10; border:1 #EEEEEE solid">
  <tr>
    <td width="75" style="padding:5;" valign="top"><?php 
			$memo_uname = $sender.'_fixed70.jpg';
			//date('Y-m-d, H:i');
			$target_memo_uname = "upload/".$sender;
			echo("<table><tr>");
			if(is_dir($target_memo_uname)){
				echo("<td align='center' style='border:0px solid #EEEEEE; padding:0px' width='50px'><a href='RockerDetail.php?uid=$sender' class=one title='$sender'><img src=upload/$sender/$memo_uname?".time()." style='margin-right:0px;'></a></td>");
			}else 
				echo("<td align='center' style='border:0px solid #EEEEEE; padding:0px' width='50px'><a href='RockerDetail.php?uid=$sender' class=one title='$sender'><img src='img/NoUserIcon_fixed.jpg' width=70 height=70 style='margin-right:0px;'></a></td>");
			echo("</tr></table>");
			 ?>
    </td>
    <td height="36" colspan="0" valign="top" style="padding-top:5px; line-height:150%; border-top:0px #EEEEEE solid; padding-left:15px; font-size:14px"><?php
			echo(nl2br($descrip));
			echo("<br><br><font color=#999999 style='font-size:12px'>".getDateName($pdate)." | ".$ptime." | </font>");
			if($sender==$uname)echo("<font color=#999999 style='font-size:12px'>From </font><a href='RockerDetail.php?uid=$sender' class=one><font color=#999999 style='font-size:12px'><strong>$sender</strong></font></a> &nbsp;<span id='deleteComment_button$cid' class='deleteComment_button$cid' style='height:13;display:inline; padding:0 7 0 7; background-color:#F5F5F5; border:1px #EEEEEE solid; font-size:12px' onMouseOver=this.style.cursor='hand';><font color=$_SESSION[hcolor]>Delete </font></span>");else
			echo("<font color=#999999 style='font-size:12px'>Click </font><a href='RockerDetail.php?uid=$sender' class=one><font color=#999999 style='font-size:12px'><strong>$sender</strong></font></a><font color=#999999 style='font-size:12px'> to reply</font>");
	?>
    </td>
  </tr>
</table>
</div>
