<?php
include 'dbconnect.php';
include 'Allfuc.php';
session_start();
$uname = $_SESSION['usrname'];
 
if(isset($_POST['content'])){
	$headicon_id=$_POST['headicon_id'];
	$descrip=addslashes($_POST['content']);
	$sender=$_POST['sender'];
	$recipient=$_POST['recipient'];
	$pdate=$_POST['pdate'];
	$ptime=$_POST['ptime'];

	$q_orig = mysql_query("SELECT uname FROM rockinus.headicon_history WHERE headicon_id='$headicon_id'");
	if(!$q_orig) die(mysql_error());
	$object_orig = mysql_fetch_object($q_orig);
	$orig_sender = $object_orig->uname;

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
	
	$del = mysql_query("INSERT INTO rockinus.headicon_comment(descrip,sender,recipient,pdate,ptime,headicon_id,rstatus) VALUES ('$descrip','$sender','$recipient',CURDATE(), NOW(),'$headicon_id','N');"); 
	
	$descrip = nl2br($descrip);
	$descrip = str_replace("\\","",$descrip);

	echo("
	<table width=450 border=0 cellpadding=0 cellspacing=0 style='margin-bottom:5; border-top:1px solid #EEEEEE; margin-top:5; background:#F5F5F5'>
	<tr>
	<td width=450 height=20 align=left valign=top style='font-weight:normal; font-size:13px; padding:5; padding-left:7; padding-bottom:4; line-height:120%'>");
	if($memo_follow_rstatus=="N"){
		if($orig_sender==$recipient)
			echo("<strong>".addHyperLink($descrip)."</strong>");
		else
			echo("<strong><font color=$_SESSION[hcolor]>@$recipient_fname $recipient_lname</font> ".addHyperLink($descrip)."</strong>");
	}else{
		if($orig_sender==$recipient)
			echo(addHyperLink($descrip));
		else
			echo("<font color=$_SESSION[hcolor]>@$recipient_fname $recipient_lname</font> ".addHyperLink($descrip));
	}
	echo("</td></tr>
	<tr>
	  <td height=10 align=left valign=top style='font-weight:normal; padding-left:7; font-size:11px; padding-bottom:5; color:#999999; line-height:120%'>"); 
	  if($uname==$sender){ 
//	  	echo("&nbsp;&nbsp;<span style='background:#F5F5F5; padding-left:5; padding-right:5; height:20; border-bottom:0 dashed #999999; font-color:#666666; font-weight:normal; font-size:12px; cursor:pointer' id='deleteReplyBtn$memofid' class='deleteReplyBtn$memofid'>Delete</span>");
		echo("<font color=$_SESSION[hcolor]>You</font> | ".getDateName($pdate).", ".substr($ptime,0,5)."&nbsp;");
	  }else{ 
	  	echo("<a href=RockerDetail.php?uid=$sender class=one style='border-bottom:0 dashed #999999'><font color=$_SESSION[hcolor]>$sender_fname $sender_lname</font></a> | ".getDateName($pdate).", ".substr($ptime,0,5)."&nbsp;");
	  	echo("&nbsp;&nbsp;<div class='replyStatusBtn$memofid' id='replyStatusBtn$memofid' style='height:16; padding:2 6 2 6; background: url(img/master.png); width:50; display:inline; border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:12px; cursor:pointer; color:#000000' align=center>Reply</div>");
	   } 
	   echo("</td></tr></table>");	
}?>