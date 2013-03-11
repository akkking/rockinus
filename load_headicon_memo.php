<script type="text/javascript" src="js/jquery.min.js"></script>
<?php
include 'dbconnect.php';
include 'Allfuc.php';
session_start();
$uname = $_SESSION['usrname'];
 
if(isset($_POST['headicon_id'])&&isset($_SESSION['usrname']))
{
 	$headicon_id = $_POST['headicon_id'];
	$start_line_no = $_POST['start_line_no'];
	
	$q_orig = mysql_query("SELECT uname FROM rockinus.headicon_history WHERE headicon_id='$headicon_id'");
	if(!$q_orig) die(mysql_error());
	$object_orig = mysql_fetch_object($q_orig);
	$orig_sender = $object_orig->uname;
	
	$q_sel = mysql_query("SELECT * FROM rockinus.headicon_comment WHERE headicon_id='$headicon_id' ORDER BY hi_follow_id ASC LIMIT 0, $start_line_no;");
	if(!$q_sel){
		$output = mysql_error();
		echo($output);
	}
	
	while($object = mysql_fetch_object($q_sel)){
		$hi_follow_id = $object->hi_follow_id;
		$sender = $object->sender;
		$recipient = $object->recipient;
		$descrip = $object->descrip;
		$descrip = str_replace("\\","",nl2br($descrip));
		$headicon_follow_rstatus = $object->rstatus;
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
	$("#replyHeadIconStatusDiv<?php echo($hi_follow_id) ?>").hide();
	$("#flashHeadIconReply<?php echo($hi_follow_id) ?>").hide();
	$("#displayHeadIconReplyResult<?php echo($hi_follow_id) ?>").hide();
	
	$("div .replyHeadIconStatusBtn<?php echo($hi_follow_id) ?>").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#replyHeadIconStatusBtn<?php echo($hi_follow_id) ?>").hide();
	  $("#replyHeadIconStatusDiv<?php echo($hi_follow_id) ?>").show();
	  $("#commentHeadIconStatusDiv_<?php echo($hi_follow_id) ?>").hide();
	});
	
	$("div .replyHeadIconCancelBtn<?php echo($hi_follow_id) ?>").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#replyHeadIconStatusDiv<?php echo($hi_follow_id) ?>").hide();
	  $("#replyHeadIconStatusBtn<?php echo($hi_follow_id) ?>").show();
	});
});
</script>
<script type="text/javascript" >
$(function() {
	$(".replyHeadIconSubmitBtn<?php echo($hi_follow_id) ?>").click(function() {
		var test = $("#replyHeadIconContent<?php echo($hi_follow_id) ?>").val();
		var pdate = '<?php echo(date('Y-m-d')) ?>';
		var ptime = '<?php echo(date("H:i:s", time())) ?>';
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($sender) ?>';
		var hi_follow_id = '<?php echo($hi_follow_id) ?>';
		var dataString = 'content='+ test+'&sender='+sender+'&recipient='+recipient+'&hi_follow_id='+hi_follow_id+'&pdate='+pdate+'&ptime='+ptime; 

		if(test=='')
		{
			alert("Please Enter Something ok?");
		}
		else
		{
			$("#replyHeadIconStatusDiv<?php echo($hi_follow_id) ?>").hide();
			$("#flashHeadIconReply<?php echo($hi_follow_id) ?>").show();
			$("#flashHeadIconReply<?php echo($hi_follow_id) ?>").fadeIn(400).html('');
 
 			$.ajax({
  				type: "POST",
  				url: "ajax_headicon_reply_status.php",
  				data: dataString,
  				cache: false,
  				success: function(html){
  					$("#displayHeadIconReplyResult<?php echo($hi_follow_id) ?>").after(html);
					document.getElementById('replyContent<?php echo($hi_follow_id) ?>').value='';
					//document.getElementById('replyContent<?php echo($hi_follow_id) ?>').focus();
  					$("#flashHeadIconReply<?php echo($hi_follow_id) ?>").hide();
					$("#replyHeadIconStatusBtn<?php echo($hi_follow_id) ?>").show();
  				}
 			});
 		} return false;
 	});
});
</script>

<script type="text/javascript" >
$(function() {
	$(".deleteHeadIconReplyBtn<?php echo($hi_follow_id) ?>").click(function() {
		var hi_follow_id = <?php echo($hi_follow_id) ?>;
		var dataString = 'hi_follow_id='+hi_follow_id; 

		if(hi_follow_id=='')
		{
			alert("not getting memo id!");
		}
		else
		{
			$("#replyHeadIconInfoDiv<?php echo($hi_follow_id) ?>").hide();
			$("#flashHeadIconDeleteReply<?php echo($hi_follow_id) ?>").show();
 			$("#flashHeadIconDeleteReply<?php echo($hi_follow_id) ?>").fadeIn(400).html('');
 
			$.ajax({
 				type: "POST",
				url: "ajax_delete_headicon_reply.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#deleteHeadIconReplyResult<?php echo($hi_follow_id) ?>").after(html);
					document.getElementById('replyHeadIconContent<?php echo($hi_follow_id) ?>').value='';
					document.getElementById('replyHeadIconContent<?php echo($hi_follow_id) ?>').focus();
					$("#flashHeadIconDeleteReply<?php echo($hi_follow_id) ?>").hide();
					$("#deleteHeadIconReplyResult<?php echo($hi_follow_id) ?>").fadeOut("slow");
				}
			});
		} return false;
 	});
 });
</script>
<div class="flashHeadIconDeleteReply<?php echo($hi_follow_id) ?>" id="flashHeadIconDeleteReply<?php echo($hi_follow_id) ?>" style="width:450px"></div>
<div class="deleteHeadIconReplyResult<?php echo($hi_follow_id) ?>" id="deleteHeadIconReplyResult<?php echo($hi_follow_id) ?>"></div>

<div id="replyHeadIconInfoDiv<?php echo($hi_follow_id) ?>" class="replyHeadIconInfoDiv<?php echo($hi_follow_id) ?>" style=" padding-top:0; padding-bottom:0; width:450px; border-top:1px solid #EEEEEE">
<table width="450" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="margin-bottom:0; border-bottom:0 dashed #DDDDDD">
	<tr>
	<td width="450" height="25" align="left" valign="top" style=" font-weight:normal; padding-left:7; font-size:12px; padding-top:5; padding-bottom:0; padding-right:7; line-height:120%">
	<?php 
	if($uname==$sender)
			echo("<strong><font color=$_SESSION[hcolor]>You</font></strong> : $descrip");
		else
			echo("<font color=$_SESSION[hcolor]>@$sender_fname $recipient_lname</font> $descrip");
	?>	</td>
	</tr>
	<tr>
	  <td height="20" align="left" valign="top" style=" font-weight:normal; font-size:10px; padding:1 5 2 7; color:#999999; line-height:150%">
	  <?php echo(getDateName($pdate).", ".substr($ptime,0,5)." | ") ?>
	  <?php if($uname==$sender){ ?>&nbsp;<span style=" height:6; padding:1px; background: #F5F5F5; width:45; display:inline; border:0px solid #DDDDDD; font-size:10px; cursor:pointer; color:<?php echo($_SESSION['hcolor']) ?>" align="center" id="deleteHeadIconReplyBtn<?php echo($hi_follow_id) ?>" class="deleteHeadIconReplyBtn<?php echo($hi_follow_id) ?>">Delete</span>
	  <?php }else if($sender!=$recipient){ ?>
	  &nbsp;&nbsp;
	  <div class="replyHeadIconStatusBtn<?php echo($hi_follow_id) ?>" id="replyHeadIconStatusBtn<?php echo($hi_follow_id) ?>" style=" height:6; padding:1 5 1 5; background: url(img/master.jpg); width:50; display:inline; border:1px solid #999999;  border-top:1px solid #CCCCCC; border-left:1px solid #CCCCCC; font-size:10px; cursor:pointer; color:#000000" align="center">Reply</div>
	  <?php } ?>	  </td>
    </tr>
</table>
</div>
<div class="flashHeadIconReply<?php echo($hi_follow_id) ?>" id="flashHeadIconReply<?php echo($hi_follow_id) ?>" style="margin-top:5"></div>
<div class="displayReplyResult<?php echo($hi_follow_id) ?>" id="displayReplyResult<?php echo($hi_follow_id) ?>" style="margin-top:5"></div>
<div class="replyHeadIconStatusDiv<?php echo($hi_follow_id) ?>" id="replyHeadIconStatusDiv<?php echo($hi_follow_id) ?>" style=" margin-top:0; margin-bottom:5; width:450px; display:none">
<textarea id="replyHeadIconContent<?php echo($hi_follow_id) ?>" class="replyHeadIconContent<?php echo($hi_follow_id) ?>" style=" width:450px; border:1px solid #DDDDDD; height:60px; font-size:13px; padding:4; font-weight:normal; font-family: Arial, Helvetica, sans-serif; margin-bottom:10px"></textarea><br />
			  <div class="replySubmitBtn<?php echo($hi_follow_id) ?>" id="replySubmitBtn<?php echo($hi_follow_id) ?>" style=" height:15; padding:2 4 2 4; background: url(img/black_cell_bg.jpg); display:inline; margin-top:10; margin-bottom: width:60; border:1px solid #333333; font-size:11px; cursor:pointer; font-weight:bold; color:#FFFFFF" align="center">Submit</div>&nbsp;
			<div class="replyCancelBtn<?php echo($hi_follow_id) ?>" id="replyCancelBtn<?php echo($hi_follow_id) ?>" style=" height:15; padding:2 4 2 4; background: url(img/master.png); display:inline; margin-top:10; width:70; border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; font-size:11px; font-weight:bold; cursor:pointer" align="center">Next time</div>
</div>
<div id="flashHeadIconDeleteReply<?php echo($hi_follow_id) ?>" class="flashHeadIconDeleteReply<?php echo($hi_follow_id) ?>" style="padding-left:0px; margin-top:15; margin-bottom:15; display:none"></div>
<div id="deleteHeadIconReplyResult<?php echo($hi_follow_id) ?>" class="deleteHeadIconReplyResult<?php echo($hi_follow_id) ?>" style="padding-left:0px; width:450; background:#F5F5F5; padding:10; margin-top:20; display:none"></div>
<? 
	} 
}
?>