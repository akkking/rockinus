<?php
include 'dbconnect.php';
include 'Allfuc.php';
session_start();
$uname = $_SESSION['usrname'];
 
if(isset($_POST['memoid'])&&isset($_SESSION['usrname']))
{
 	$memoid = $_POST['memoid'];
	
	$q_orig = mysql_query("SELECT sender FROM rockinus.memo_info WHERE memoid='$memoid'");
	if(!$q_orig) die(mysql_error());
	$object_orig = mysql_fetch_object($q_orig);
	$orig_sender = $object_orig->sender;
	
	$q_sel = mysql_query("SELECT * FROM rockinus.memo_follow_info WHERE memoid='$memoid' ORDER BY memofid DESC;");
	if(!$q_sel){
		$output = mysql_error();
		echo($output);
	}
	
	while($object = mysql_fetch_object($q_sel)){
		$memofid = $object->memofid;
		$sender = $object->sender;
		$recipient = $object->recipient;
		$descrip = $object->descrip;
		$descrip = str_replace("\\","",nl2br($descrip));
		$memo_follow_rstatus = $object->rstatus;
		$pdate = $object->pdate;
		$ptime = $object->ptime;
		
		$q_sender = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$sender'");
		if(!$q_sender) die(mysql_error());
		$object_sender = mysql_fetch_object($q_sender);
		$sender_fname = $object_sender->fname;
		$sender_lname = $object_sender->lname;
		
		$q_recipient = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$recipient'");
		if(!$q_recipient) die(mysql_error());
		$object_recipient = mysql_fetch_object($q_recipient);
		$recipient_fname = $object_recipient->fname;
		$recipient_lname = $object_recipient->lname;
	?>
	<script>
$(document).ready(function() { 
	$("#replyStatusDiv<?php echo($memofid) ?>").hide();
	$("#flashReply<?php echo($memofid) ?>").hide();
	$("#displayReplyResult<?php echo($memofid) ?>").hide();
	
	$("div .replyStatusBtn<?php echo($memofid) ?>").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#replyStatusBtn<?php echo($memofid) ?>").hide();
	  $("#replyStatusDiv<?php echo($memofid) ?>").show();
	  $("#commentStatusDiv_<?php echo($memoid) ?>").hide();
	});
	
	$("div .replyCancelBtn<?php echo($memofid) ?>").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#replyStatusDiv<?php echo($memofid) ?>").hide();
	  $("#replyStatusBtn<?php echo($memofid) ?>").show();
	});
});
</script>
<script type="text/javascript" >
$(function() {
	$(".replySubmitBtn<?php echo($memofid) ?>").click(function() {
		var test = $("#replyContent<?php echo($memofid) ?>").val();
		var pdate = '<?php echo(date('Y-m-d')) ?>';
		var ptime = '<?php echo(date("H:i:s", time())) ?>';
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($sender) ?>';
		var memoid = '<?php echo($memoid) ?>';
		var dataString = 'content='+ test+'&sender='+sender+'&recipient='+recipient+'&memoid='+memoid+'&pdate='+pdate+'&ptime='+ptime; 

		if(test=='')
		{
			alert("Please Enter Something ok?");
		}
		else
		{
			$("#replyStatusDiv<?php echo($memofid) ?>").hide();
			$("#flashReply<?php echo($memofid) ?>").show();
			$("#flashReply<?php echo($memofid) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">');
 
 			$.ajax({
  				type: "POST",
  				url: "ajax_reply_status.php",
  				data: dataString,
  				cache: false,
  				success: function(html){
  					$("#displayReplyResult<?php echo($memofid) ?>").after(html);
					document.getElementById('replyContent<?php echo($memofid) ?>').value='';
					//document.getElementById('replyContent<?php echo($memofid) ?>').focus();
  					$("#flashReply<?php echo($memofid) ?>").hide();
					$("#replyStatusBtn<?php echo($memofid) ?>").show();
  				}
 			});
 		} return false;
 	});
});
</script>

<script type="text/javascript" >
$(function() {
	$(".deleteReplyBtn<?php echo($memofid) ?>").click(function() {
		var memofid = <?php echo($memofid) ?>;
		var dataString = 'memofid='+memofid; 

		if(memofid=='')
		{
			alert("not getting memo id!");
		}
		else
		{
			$("#replyInfoDiv<?php echo($memofid) ?>").hide();
			$("#flashdeleteReply<?php echo($memofid) ?>").show();
 			$("#flashdeleteReply<?php echo($memofid) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle"> <span class="loading">Deleting comment...</span>');
 
			$.ajax({
 				type: "POST",
				url: "ajax_delete_reply.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#deleteReplyResult<?php echo($memofid) ?>").after(html);
					document.getElementById('replyContent<?php echo($memofid) ?>').value='';
					document.getElementById('replyContent<?php echo($memofid) ?>').focus();
					$("#flashdeleteReply<?php echo($memofid) ?>").hide();
					$("#deleteReplyResult<?php echo($memofid) ?>").fadeOut("slow");
				}
			});
		} return false;
 	});
 });
</script>
<div class="flashDeleteReply<?php echo($memofid) ?>" id="flashDeleteReply<?php echo($memofid) ?>"></div>
<div class="deleteReplyResult<?php echo($memofid) ?>" id="deleteReplyResult<?php echo($memofid) ?>"></div>

<div id="replyInfoDiv<?php echo($memofid) ?>" class="replyInfoDiv<?php echo($memofid) ?>" style=" padding-top:5; padding-bottom:0; width:450; border-bottom:1px dashed #DDDDDD;">
<table width="450" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="margin-bottom:0; border-bottom:0 dashed #DDDDDD">
	<tr>
	<td width="478" height="30" align="left" valign="top" style=" font-weight:normal; padding-left:5; font-size:12px; padding-top:8; padding-bottom:4; line-height:150%">
	<?php 
	if($memo_follow_rstatus=="N"&&$recipient==$uname){
		if($orig_sender==$recipient)
			echo("<strong>$descrip</strong>");
		else
			echo("<strong><font color=$_SESSION[hcolor]>@$recipient_fname $recipient_lname</font> $descrip</strong>");
	}else{
		if($orig_sender==$recipient)
			echo($descrip);
		else
			echo("<font color=$_SESSION[hcolor]>@$recipient_fname $recipient_lname</font> $descrip"); 
	}
	?>
	</td>
	</tr>
	<tr>
	  <td height="26" align="left" valign="top" style=" font-weight:normal; padding:3 5 5 5; font-size:11px; color:#999999; line-height:150%">
	  <a href="RockerDetail.php?uid=<?php echo($sender); ?>" class="one" style="border-bottom:0 dashed #999999"><?php if($uname==$sender)echo("<font color=#999999>You</font>"); else echo("<font color=$_SESSION[hcolor]>$sender_fname $sender_lname</font>"); ?></strong></font></a>&nbsp;<?php echo(getDateName($pdate).", ".substr($ptime,0,5)." | ") ?>
	  <font color="#999999">&nbsp;</font><?php if($uname==$sender){ ?>&nbsp;&nbsp;<span style=" height:6; padding:1 5 1 5; background: #F5F5F5; width:50; display:inline; border:1px solid #DDDDDD; font-size:10px; cursor:pointer; color:#999999" align="center" id="deleteReplyBtn<?php echo($memofid) ?>" class="deleteReplyBtn<?php echo($memofid) ?>">Delete</span>
	  <?php }else if($sender!=$recipient){ ?>
	  &nbsp;&nbsp;<div class="replyStatusBtn<?php echo($memofid) ?>" id="replyStatusBtn<?php echo($memofid) ?>" style=" height:6; padding:1 5 1 5; background: url(img/master.jpg); width:50; display:inline; border:1px solid #999999;  border-top:1px solid #CCCCCC; border-left:1px solid #CCCCCC; font-size:10px; cursor:pointer; color:#000000" align="center">Reply</div>
	  <?php } ?>
	  </td>
    </tr>
</table>
</div>
<div class="flashReply<?php echo($memofid) ?>" id="flashReply<?php echo($memofid) ?>" style=" margin-top:30"></div>
<div class="displayReplyResult<?php echo($memofid) ?>" id="displayReplyResult<?php echo($memofid) ?>" style="margin-top:30"></div>

<div class="replyStatusDiv<?php echo($memofid) ?>" id="replyStatusDiv<?php echo($memofid) ?>" style=" margin-top:5; margin-bottom:15; width:450">
<form action="postStatus.php" method="post" name="ownform" id="ownform" style="margin-top:10px">
<textarea name="replyContent" id="replyContent<?php echo($memofid) ?>" class="replyContent<?php echo($memofid) ?>" style=" width:450; border:1px solid #DDDDDD; height:100px; font-size:13px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif; margin-bottom:10px"></textarea><br />
			  <div class="replySubmitBtn<?php echo($memofid) ?>" id="replySubmitBtn<?php echo($memofid) ?>" style=" height:18; padding:3 8 3 8; background: url(img/black_cell_bg.jpg); display:inline; margin-top:10; margin-bottom: width:60; border:1px solid #333333; font-size:12px; cursor:pointer; color:#FFFFFF" align="center">Submit</div>&nbsp;
			<div class="replyCancelBtn<?php echo($memofid) ?>" id="replyCancelBtn<?php echo($memofid) ?>" style=" height:18; padding:3 8 3 8; background: url(img/master.png); display:inline; margin-top:10; width:70; border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; border-left:0px solid #DDDDDD; font-size:12px; cursor:pointer" align="center">Next time</div>
                    </form>
</div>
<div id="flashDeleteReply<?php echo($memofid) ?>" class="flashDeleteReply<?php echo($memofid) ?>" style="padding-left:0px; margin-top:15; margin-bottom:15; display:none"></div>
<div id="deleteReplyResult<?php echo($memofid) ?>" class="deleteReplyResult<?php echo($memofid) ?>" style="padding-left:0px; width:450; background:#F5F5F5; padding:10; margin-top:20; display:none"></div>
<? 
		// Update rstatus of follow comment, set it already read
		$upd_memo_follow = mysql_query("UPDATE rockinus.memo_follow_info SET rstatus='Y' WHERE rstatus='N' AND memofid='$memofid';");
		if(!$upd_memo_follow) die(mysql_error());
	} 
}
?>