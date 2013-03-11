<?php
include 'dbconnect.php';
include 'Allfuc.php';
session_start();
$uname = $_SESSION['usrname'];
 
if(isset($_POST['content'])){
	$memoid=$_POST['memoid'];
	$descrip=addslashes(trim($_POST['content']));
	//$descrip=addslashes($_POST['content']);
	$sender=trim($_POST['sender']);
	$recipient = trim($_POST['recipient']);
	$pdate=$_POST['pdate'];
	$ptime=$_POST['ptime'];
	$rstatus='N';
	if($sender==$recipient) $rstatus='Y';
	
	if($descrip[0]=="@"){
		$arr_descrip = array();
		$arr_descrip = explode(":", substr($descrip,1,strlen($descrip)-1));
		$descrip = $arr_descrip[1];
	}
	
	$q_orig = mysql_query("SELECT sender FROM rockinus.memo_info WHERE memoid='$memoid'");
	if(!$q_orig) die(mysql_error());
	$object_orig = mysql_fetch_object($q_orig);
	$orig_sender = $object_orig->sender;

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
	
	$loopSenderImg = "upload/$sender/$sender"."60.jpg";
	if(file_exists($loopSenderImg))
		$loopSenderImg = "<div style='height:40;overflow-x:hidden;overflow-y:hidden;' align='left'><img src='$loopSenderImg' width='40' style='border:0px solid #DDDDDD'></div>"; 
	else
		$loopSenderImg = "<img src='img/NoUserIcon100.jpg' width=40 style='border:0px solid #DDDDDD'>";
	
	$del = mysql_query("INSERT INTO rockinus.memo_follow_info(descrip,sender,recipient,pdate,ptime,memoid,rstatus) VALUES ('$descrip','$sender','$recipient',CURDATE(), NOW(),'$memoid','$rstatus');"); 
	
	$descrip = nl2br($descrip);
	$descrip = str_replace("\\","",$descrip);

	echo("
	<table width=550 border=0 cellpadding=0 cellspacing=0 style='margin-bottom:5; border-bottom:0 dashed #DDDDDD; margin-top:5px'>
	<tr>
	<td width=50 height=40 align=left valign=top style='padding-left:5'>
	$loopSenderImg 
	</td>
	<td align=left valign=top style='font-weight:normal; padding-left:0; font-size:13px; padding-bottom:5; line-height:150%'>");
	if($memo_follow_rstatus=="N"){
		if($orig_sender==$recipient)
			echo("<a href=RockerDetail.php?uid=$sender class=one><font color=$_SESSION[hcolor]>$sender_fname</font></a>: <strong>$descrip</strong>");
		else
			echo("<a href=RockerDetail.php?uid=$sender class=one><font color=$_SESSION[hcolor]>$sender_fname</font></a>: <strong><font color=#000000>$recipient_fname</font> $descrip</strong>");
	}else{
		if($orig_sender==$recipient)
			echo("<a href=RockerDetail.php?uid=$sender class=one><font color=$_SESSION[hcolor]>$sender_fname</font></a>: $descrip");
		else
			echo("<a href=RockerDetail.php?uid=$sender class=one><font color=$_SESSION[hcolor]>$sender_fname</font></a>: <font color=#000000>$recipient_fname</font> $descrip");
	}
	
	echo("<br><font color='#CCCCCC' style='font-size:12px'>".getDateName($pdate).", ".substr($ptime,0,5)."</font>"); 
	if($uname==$sender){ 
//	  	echo("&nbsp;&nbsp;<span style='background:#F5F5F5; padding-left:5; padding-right:5; height:20; border-bottom:0 dashed #999999; font-color:#666666; font-weight:normal; font-size:12px; cursor:pointer' id='deleteReplyBtn$memofid' class='deleteReplyBtn$memofid'>Delete</span>")
;
	  }else{ 
	  	echo("&nbsp;&nbsp;<div class='replyStatusBtn$memofid' id='replyStatusBtn$memofid' style='height:16; padding:2 6 2 6; background: url(img/master.png); width:50; display:inline; border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:12px; cursor:pointer; color:#000000' align=center>Reply</div>");
	   } 
	   echo("</td></tr></table>");	
}?>