<?php 
include 'dbconnect.php';
include 'Allfuc.php';
session_start();
$uname = $_SESSION['usrname'];

if(!isset($_SESSION['hcolor']) || !isset($_SESSION['lan']) || !isset($_SESSION['topi'])){
	include 'dbconnect.php';

	$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
	if(!$q1) die(mysql_error());
	$object = mysql_fetch_object($q1);
	$_SESSION['hcolor'] = $object->hcolor;
	$_SESSION['lan'] = $object->lan;
	$_SESSION['topi'] = $object->topi;
}

$hcolor = $_SESSION['hcolor'];
$lan = $_SESSION['lan'];
$topi = $_SESSION['topi'];

if(isset($_POST['lan'])){
	$lan = htmlspecialchars(trim($_POST['lan']));
	$_SESSION['lan'] = $lan;
	include("dbconnect.php");
	$setLan = "UPDATE rockinus.user_setting SET lan='$lan' WHERE uname='$uname'";
    mysql_query($setLan) or die(mysql_error());
	header("location:ThingsRock.php");
}

if(isset($_GET["topi"])){
echo("111");
	include 'dbconnect.php';
	if(isset($_SESSION['topi']))unset($_SESSION['topi']);
	$_SESSION['topi'] = $_GET['topi'];
	$topi = htmlspecialchars(trim( $_GET['topi']));

    $setTopic  = "UPDATE rockinus.user_setting SET topi='$topi' WHERE uname='$uname'";
    mysql_query($setTopic) or die(mysql_error());
	header("location:ThingsRock.php");
}

$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$_SESSION['hcolor'] = $object->hcolor;
$_SESSION['lan'] = $object->lan;
$hcolor = $_SESSION['hcolor'];
$lan = $_SESSION['lan'];
?>
<link rel="stylesheet" type="text/css" href="style.css" />
<table width="599" height="115" border="0" cellpadding="0" cellspacing="0" style="margin-top:5px; margin-bottom:5px;">
                <tr>
                  <td height="85" colspan="2" valign="top" style="border-right:0 dotted #666666; border-left:0 dotted #666666"><table width="740" height="85" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="663" height="85" valign="top" >
						<?php
			include 'dbconnect.php';
			
			$sel_count = "
SELECT sum(total) as cnt FROM (
	SELECT count(*) as total FROM rockinus.user_check_info  
	UNION 
	SELECT count(*) as total FROM rockinus.house_info 
	UNION 
	SELECT count(*) as total FROM rockinus.article_info 
	UNION 
	SELECT count(*) as total FROM rockinus.course_memo_info 
	UNION 
	SELECT count(*) as total FROM rockinus.news_info
	UNION
	SELECT count(*) as total FROM rockinus.memo_info 
	UNION 
	SELECT count(*) as total FROM rockinus.rocker_rel_info 
) as cnt";

$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

	$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 40;
	$page= (isset($_GET["page"]))? $_GET["page"] : 1;
	if((!$limit) || (is_numeric($limit) == false)|| ($limit < 40) || ($limit > 50)) 
		$limit = 1; //default
	
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
		$page = 1; //default 

	$next_page = $page + 1;
	$div_id = "myDiv".$page;
	$total_pages = ceil($total_items / $limit);
	$set_limit = ($page * $limit) - $limit;
						
	//				echo("set_limit=".$set_limit);
	//				echo("limit=".$limit);
	//				echo("page=".$page);
		$sql_stmt = "SELECT email,uname, NULL as col_1,status, signup_date,signup_time,tbname, NULL as col_2, NULL as col_3, NULL as col_4, NULL as col_5, NULL as col_6, NULL as col_7 
					FROM rockinus.user_check_info a WHERE a.status='A'
					UNION 
					SELECT hid,uname,subject,rentlease,pdate,ptime,tbname, type, city, rate, NULL, NULL, descrip 
					FROM rockinus.house_info c 
					UNION 
					SELECT aid,uname,subject,buysale,pdate,ptime,tbname,aname,city,rate,delivery,type, descrip 
					FROM rockinus.article_info d  
					UNION 
					SELECT course_uid, sender, descrip, rating, pdate, ptime, tbname, NULL, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.course_memo_info e 
					UNION 
					SELECT news_id, creater, subject, descrip, pdate, ptime, 'news_info', category, NULL,NULL, NULL, NULL, NULL 
					FROM rockinus.news_info f 
					UNION 
					SELECT memoid, sender, level, descrip, pdate, ptime, 'memo_info', NULL, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.memo_info i WHERE descrip <> ''
					UNION 
					SELECT NULL, sender, recipient, NULL, pdate, ptime, 'rocker_rel_info', NULL, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.rocker_rel_info g 
					ORDER BY signup_date DESC, signup_time DESC LIMIT $set_limit, $limit";
					//echo($sql_stmt);
		
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($no_row == 0) echo("");
		while($object = mysql_fetch_object($q)){
			$loopname = $object->uname;		
			$tbname = $object->tbname;			
			$pdate = $object->signup_date;
			$ptime = $object->signup_time;
			$id = $object->email;
			$subject = $object->col_1;
			$subject = str_replace("\\","",$subject);
			$aname = $object->col_2;
			$city = $object->col_3;
			$rate = $object->col_4;
			$delivery = $object->col_5;
			$type = $object->col_6;
			$descrip = $object->col_7;
			$descrip = str_replace("\\","",$descrip);
			$action = $object->status;
			$action = str_replace("\\","",$action);
			if(strlen($subject)>50) $subject = substr(trim($subject), 0, 50)."...";
			if($tbname=="user_check_info"){
			?>
						<div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:10px; padding-bottom: 10px; border-bottom:1px #DDDDDD solid">
                          <table width="740" height="65" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="77" rowspan="4" valign="top" bgcolor="#FFFFFF" style="padding-top:5px; padding-right:5px; padding-bottom:10px;"><?php
									$loopImg = "upload/$loopname/$loopname"."100.jpg";
							  if(file_exists($loopImg)) echo("<a href=RockerDetail.php?uid=$loopname class=one><img src=$loopImg width=80px style='border:0px #666666 solid' /></a>");
							  else echo("<a href=RockerDetail.php?uid=$loopname class=one><img src=img/NoUserIcon100.jpg width=80px /></a>");
							  ?></td>
                              <td height="30" align="left" valign="top" style="padding-left:10px; padding-top:5px; font-size:12px">
							  <?php
							  if($tbname=="user_check_info") 
							  	echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]><strong>$loopname</strong></font></a>");	
								if($_SESSION['lan']=="CN")echo " ÒÑ¼ÓÈë±¾ÉçÇø";
								else echo(" has joined the network.");
								?>                              </td>
                              <td height="30" align="right" valign="top" style="padding-right:5px; padding-top:5px; font-size:12px">
                                <?php
							  echo(getDateName($pdate)." | ".substr($ptime,0,5));
							  ?>                              </td>
                            </tr>
                            <tr>
                              <td height="30" valign="top" style="padding-left:10px; padding-top:; font-size:12px">
							  <?php 
							  	if($tbname=="user_check_info"){
									$pieces = explode('@', $id);
									if(stristr($pieces[1],'poly')==true) echo("From NYU-Poly ");
									else echo($id);
								} 
								?>
                                &nbsp;</td>
                              <td height="30" style="padding-right:5px; padding-top:5px" align="right" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="30" valign="top" style="padding-left:10px; padding-top:; font-size:12px">
							  <script type="text/javascript">
$(function() {
	$(".addFriendDiv<?php echo($loopname) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($loopname) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#addFriendDiv<?php echo($loopname) ?>").hide();
		$("#flashAddFriend<?php echo($loopname) ?>").show();
		$("#flashAddFriend<?php echo($loopname) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_frequest.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashAddFriend<?php echo($loopname) ?>").hide();
				$("#addFriendResult<?php echo($loopname) ?>").fadeIn(400).html("Requested");
			}
 		});
 		return false;
 	});
 });
</script>
							  <?php 
							  $rel_rstatus = "N";
if($loopname==$uname)$rel_rstatus ="S";
else{
	$q11 = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE (sender='$loopname' AND recipient='$uname') OR (recipient='$loopname' AND sender='$uname')");
	if(!$q11) die(mysql_error());
	$no_row_A = mysql_num_rows($q11);
	if($no_row_A>0)$rel_rstatus='A';
	
	$q21 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$loopname' AND recipient='$uname' AND rstatus='P'");
	if(!$q21) die(mysql_error());
	$no_row_P = mysql_num_rows($q21);
	if($no_row_P>0)$rel_rstatus='X';
	
	$q22 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uname' AND recipient='$loopname' AND rstatus='P'");
	if(!$q22) die(mysql_error());
	$no_row_X = mysql_num_rows($q22);
	if($no_row_X>0)$rel_rstatus='P';	
}

if($rel_rstatus=="S")echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:90px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding-left:10; padding-right:10; padding-top:5; padding-bottom:5; display:inline' align='center'><a href='EditUserInfo.php' class=one>+ Edit</a></div>&nbsp;");
	 else if($rel_rstatus=="P")echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:90px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding-left:10; padding-right:10; padding-top:5; padding-bottom:5; display:inline' align='center'>Requested</div>");
	 else if($rel_rstatus=="A")echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:90px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding-left:10; padding-right:10; padding-top:5; padding-bottom:5; display:inline' align='center'><a href='FriendConfirm.php?uid=$loopname&&pageName=RockerDetail' class=one>Defriend</a></div>");
	 else if($rel_rstatus=="X"){
	 	echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:90px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding-left:10; padding-right:10; padding-top:5; padding-bottom:5; display:inline' align='center'><a href='AcceptFriend.php?sender=$loopname'>Accept</a></div>&nbsp;&nbsp;");
	 	echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:90px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding-left:10; padding-right:10; padding-top:5; padding-bottom:5; display:inline' align='center'><a href='DenyFriend.php?sender=$loopname'>Decline</a></div>");
	 }else if($rel_rstatus=="N")echo("<div id='addFriendDiv$loopname' class='addFriendDiv$loopname' style='height:22; padding:2 7 2 7; background: url(img/master.jpg); cursor:pointer; border:1px solid #666666; font-size:12px; color:#000000; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif' align='center'>+ Friend</div>");
	 ?>
	 <span id="flashAddFriend<?php echo($loopname) ?>" class="flashAddFriend<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span>
 	 <span id="addFriendResult<?php echo($loopname) ?>" class="addFriendResult<?php echo($loopname) ?>" style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:90; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding-left:10; padding-right:10; padding-top:5; padding-bottom:5; display:none' align='center'></span>&nbsp;
	 <?php
	 if($rel_rstatus!="S"){?>
	 <a href="SendMessage.php?recipient=<?php echo($loopname) ?>">
	 <div style="height:22; padding:2 7 2 7; background: url(img/master.jpg); cursor:pointer; border:1px solid #666666; font-size:12px; color:#000000; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif" align="center">Message	</div>
	</a>
	<?php } ?>							  </td>
	<td height="30" style="padding-left:5">&nbsp;</td>
                            </tr>
                          </table>
						  </div>
						<?php 
							}else if($tbname=="rocker_rel_info"){
			?>
						<div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:5; padding-bottom: 5; border-bottom:1px #DDDDDD solid; background:#F5F5F5">
                          <table width="730" height="25" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="39" height="18" align="left" valign="middle" style="padding-left:5px;"><img src="img/littleStar.jpg" width="15"/></td>
                              <td width="536" align="left" valign="middle" style="padding-left:10px; font-size:13px; font-family:Arial, Helvetica, sans-serif"><?php
				$friend_tag = "";
				$hobbyTitle = "";
				
				$q_f = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE sender='$loopname' OR recipient='$loopname';");
				if(!$q_f) die(mysql_error());
				$no_row_f = mysql_num_rows($q_f);
				if($no_row_f == 0) {
					$q_hobby = mysql_query("SELECT * FROM rockinus.user_hobby_info WHERE uname='$loopname';");
					if(!$q_hobby) die(mysql_error());
					$object_hobby = mysql_fetch_object($q_hobby);
					$hobby = $object_hobby->hobby;
					if(strlen(trim($hobby))>0){
						$hobby_array = explode(",",$hobby);
						if(count($hobby_array)>3){
							$x = "";
							for( $i=0; $i<3; $i++ ){
								$x .= $hobby_array[$i];
								if($i<2) $x .= ", ";
							}
							$hobbyTitle = " <font color=#999999>(likes $x etc.)</font>";
						}else
							$hobbyTitle = " <font color=#999999>(likes $hobby)</font>";
					} 
					$friend_tag = "loopname";
				}else{
					$q_hobby = mysql_query("SELECT * FROM rockinus.user_hobby_info WHERE uname='$subject';");
					if(!$q_hobby) die(mysql_error());
					$object_hobby = mysql_fetch_object($q_hobby);
					//echo "SELECT * FROM rockinus.user_hobby_info WHERE uname='$subject';";
					$hobby = $object_hobby->hobby;
					if(strlen(trim($hobby))>0){
						$hobby_array = explode(",",$hobby);
						if(count($hobby_array)>3){
							$x = "";
							for( $i=0; $i<3; $i++ ){
								$x .= $hobby_array[$i];
								if($i<2) $x .= ", ";
							}
							$hobbyTitle = " <font color=#999999>(likes $x etc.)</font>";
						}else
							$hobbyTitle = " <font color=#999999>(likes $hobby)</font>";
					}
					$friend_tag = "subject";
				}

				$q_sender = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$loopname'");
				if(!$q_sender) die(mysql_error());
				$object = mysql_fetch_object($q_sender);
				$loopname_fname = $object->fname;
				$loopname_lname = $object->lname;
					
				$q_sender = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$subject'");
				if(!$q_sender) die(mysql_error());
				$object = mysql_fetch_object($q_sender);
				$subject_fname = $object->fname;
				$subject_lname = $object->lname;
					
				if($friend_tag == "loopname"){
					echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]><strong>$loopname_fname</strong></font></a>$hobbyTitle and <a href=RockerDetail.php?uid=$subject class=one><font color=$_SESSION[hcolor]><strong>$subject_fname</strong></font></a> are now friend");
				}else
					echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]><strong>$loopname_fname</strong></font></a> and <a href=RockerDetail.php?uid=$subject class=one><font color=$_SESSION[hcolor]><strong>$subject_fname</strong></font></a>$hobbyTitle are now friend");
				?>
                              </td>
                              <td width="155" height="18" align="right" valign="middle" style="padding-right:5; font-size:11px"><?php
							  echo(getDateName($pdate)." | ".substr($ptime,0,5));
							  ?>
                              </td>
                            </tr>
                          </table>
						  </div>
						<?php 
							}else if($tbname=="memo_info"){
			?>
                          <div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:10; padding-bottom: 0; border-bottom:1px #DDDDDD solid">
                            <table width="740" height="100" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="38" height="18" align="left" valign="top" style="padding-left:5px; padding-top:5px"><img src="img/writeamessageIcon.jpg" width="15" /> </td>
                                <td width="567" align="left" valign="top" style="padding-left:15px; padding-top:2; font-size:13px"><?php
			echo("<a href=RockerDetail.php?uid=$loopname><font color=$_SESSION[hcolor]><strong>$loopname_fname $loopname_lname</strong></font></a> has a new status");
							  ?>
                                </td>
                                <td width="125" height="18" align="right" valign="top" style="padding-right:5; padding-top:5px; font-size:12px"><?php
							  echo(getDateName($pdate)." | ".substr($ptime,0,5));
							  ?>
                                </td>
                              </tr>
                              <tr>
                                <td height="20" align="center" valign="middle" style="line-height:150%">&nbsp;</td>
                                <td height="20" align="left" valign="top" style="padding-left:15px; padding-right:5px; padding-top:3; padding-bottom:5; line-height:150%; border:0px #DDDDDD dashed; font-size:13px; font-weight:normal;"><?php 
								echo(str_replace("\\","",nl2br($action)));
								?>
                                </td>
                                <td height="20" align="left" valign="top" style="padding-left:15px; padding-right:5px; padding-top:; padding-bottom:5; line-height:150%; border:0px #DDDDDD dashed; font-size:13px; font-weight:bold; font-family:Arial, Helvetica, sans-serif" bgcolor="">&nbsp;</td>
                              </tr>
                              <tr>
                                <td height="40" align="center" valign="middle" style="line-height:150%">&nbsp;</td>
                                <td height="30" align="left" valign="top" style="padding-left:15px; padding-right:0px; padding-top:0; padding-bottom:15; line-height:120%; border:0px #DDDDDD dashed"><script>
$(document).ready(function() { 
	$("#commentStatusDiv<?php echo($id) ?>").hide();
	
	$("div .commentStatusBtn<?php echo($id) ?>").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#commentStatusBtn<?php echo($id) ?>").hide();
	  $("#commentStatusDiv<?php echo($id) ?>").show();
	});
	
	$("div .commentStatusCancelBtn<?php echo($id) ?>").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#commentStatusDiv<?php echo($id) ?>").hide();
	  $("#commentStatusBtn<?php echo($id) ?>").show();
	});
});
                          </script>
                                    <?php 
$q1 = mysql_query("SELECT * FROM rockinus.memo_follow_info WHERE memoid='$id' ORDER BY pdate ASC, ptime ASC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row > 0){ 
	while($object = mysql_fetch_object($q1)){
		$memofid = $object->memofid;	
		$sender = $object->sender;	
		$descrip = $object->descrip;
		$descrip = str_replace("\\","",nl2br($descrip));
		$reply_ptime = $object->ptime;
		$reply_pdate = $object->pdate; 
		
 $q_sender = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$sender'");
 if(!$q_sender) die(mysql_error());
 $object_sender = mysql_fetch_object($q_sender);
 $sender_fname = $object_sender->fname;
 $sender_lname = $object_sender->lname;
?>
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
			$("#flashdeletememo<?php echo($memofid) ?>").show();
 			$("#flashdeletememo<?php echo($memofid) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle"> <span class="loading">Deleting comment...</span>');
 
			$.ajax({
 				type: "POST",
				url: "memo_delete_friend.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#deleteReplyResult<?php echo($memofid) ?>").after(html);
					$("#flashDeleteReply<?php echo($memofid) ?>").hide();
					$("#statusReplyDiv<?php echo($memofid) ?>").hide();
				}
			});
		} return false;
 	});
 });
                            </script>
                                    <div style="margin-bottom:10; margin-top:5px; width: 550;" align="left" class="statusReplyDiv<?php echo($memofid) ?>" id="statusReplyDiv<?php echo($memofid) ?>">
                                      <table width="550" height="45" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-bottom:1px solid #DDDDDD;">
                                        <tr>
                                          <td width="285" height="20" align="left" valign="top" bgcolor="#F5F5F5" style="padding-left:10; font-size:12px; padding-top:5"><?php echo("<strong> <a href=RockerDetail.php?uid=$sender class=one><FONT color=$_SESSION[hcolor]>$sender_fname $sender_lname</font></a></strong> said:") ?> </td>
                                          <td width="139" height="20" align="right" valign="top" bgcolor="#F5F5F5" style="padding-top:7; font-size:12px"><?php if($sender==$uname){ ?>
                                              <div class="deleteReplyBtn<?php echo("$memofid"); ?>" id="deleteReplyBtn<?php echo("$memofid"); ?>" style="height:15; padding:2 6 2 6; border:1px solid #EEEEEE; color:#999999; display:inline; cursor:pointer">Delete</div>
                                              <?php } ?>
                                          </td>
                                          <td width="120" height="20" align="right" valign="top" bgcolor="#F5F5F5" style="font-size:11px; padding-right:10; color:#666666; padding-top:5"><?php echo(getDateName($reply_pdate)) ?> | <?php echo(substr($reply_ptime,0,5)) ?> </td>
                                        </tr>
                                        <tr>
                                          <td height="20" colspan="3" valign="top" style="line-height:120%; font-size:12px; padding:10; padding-top:3; padding-bottom:5"><?php
													if(strlen($descrip)>500)
														echo(substr($descrip,0,500)." ...<br>");
													else
														echo($descrip);
												?>
                                          </td>
                                        </tr>
                                      </table>
                                    </div>
                                  <div class="flashDeleteReply<?php echo($memofid) ?>" id="flashDeleteReply<?php echo($memofid) ?>"></div>
                                  <div class="deleteReplyResult<?php echo($memofid) ?>" id="deleteReplyResult<?php echo($memofid) ?>"></div>
                                  <?php }}?>
                                    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js">
                              </script>
                                    <script type="text/javascript" >
 $(function() {
 $(".commentStatusSubmitBtn<?php echo($id) ?>").click(function() {
var test = $("#content<?php echo($id) ?>").val();
var memoid = <?php echo($id) ?>;
var pdate = '<?php echo(date('Y-m-d')) ?>';
var ptime = '<?php echo(date("H:i:s", time())) ?>';
var sender = '<?php echo($uname) ?>';
var recipient = '<?php echo($loopname) ?>';
var dataString = 'content='+ test+'&memoid='+memoid+'&sender='+sender+'&recipient='+recipient+'&pdate='+pdate+'&ptime='+ptime; 

if(test=='')
{
 alert("Please Enter Some Text");
}
else
{
 $("#flash<?php echo($id) ?>").show();
 $("#flash<?php echo($id) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle"> <span class="loading">Loading Comment...</span>');
 
 $.ajax({
  type: "POST",
  url: "memo_insert.php",
  data: dataString,
  cache: false,
  success: function(html){
  $("#displayStatus<?php echo($id) ?>").after(html);
  document.getElementById('content<?php echo($id) ?>').value='';
  document.getElementById('content<?php echo($id) ?>').focus();
  $("#flashStatus<?php echo($id) ?>").hide();
  $("#commentStatusDiv<?php echo($id) ?>").hide();
  $("#commentStatusBtn<?php echo($id) ?>").show();
  }
 });
 } return false;
 });
 });
                              </script>
                                    <div id="flashStatus<?php echo($id) ?>" class="flashStatus<?php echo($id) ?>" style="padding-left:10px"></div>
                                  <div id="displayStatus<?php echo($id) ?>" class="displayStatus<?php echo($id) ?>" style="padding-left:10px"></div>
                                  <div class="commentStatusBtn<?php echo($id) ?>" id="commentStatusBtn<?php echo($id) ?>" style=" height:15; padding:2 5 2 5; background: url(img/master.png); display:; margin-top:5; margin-bottom:0; width:60; border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:11px; cursor:pointer" align="center">Comment</div>
                                  <div class="commentStatusDiv<?php echo($id) ?>" id="commentStatusDiv<?php echo($id) ?>">
                                      <form action="" method="post" name="form" id="form" style="margin-top:5; margin-bottom:0">
                                        <textarea name="content<?php echo($id) ?>" id="content<?php echo($id) ?>" rows="5" style="border:1px #DDDDDD solid; width:550; margin-bottom:10" onfocus="this.style.backgroundColor='#F5F5F5'; this.style.borderColor='#CCCCCC'; "></textarea>
                                        <br />
                                        <div class="commentStatusSubmitBtn<?php echo($id) ?>" id="commentStatusSubmitBtn<?php echo($id) ?>" style=" height:18; padding:3 8 3 8; background: url(img/black_cell_bg.jpg); display:inline; margin-top:15; width:60; border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:12px; cursor:pointer; color:#FFFFFF" align="center">Submit</div>
                                         
                                        <div class="commentStatusCancelBtn<?php echo($id) ?>" id="commentStatusCancelBtn<?php echo($id) ?>" style=" height:18; padding:3 8 3 8; background: url(img/master.png); display:inline; margin-top:15; width:70; border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:12px; cursor:pointer" align="center">Next time</div>
                                           
                                      </form>
                                  </div></td>
                                <td height="40" align="left" valign="top" style="padding-left:15px; padding-right:5px; padding-top:5px; padding-bottom:0; line-height:150%; border:0px #DDDDDD dashed">&nbsp;</td>
                              </tr>
                            </table>
                          </div>
                          <?php 
							}else if($tbname=="house_info"){
							?>
                          <div style="margin-top:5; margin-bottom:5px; padding-left:0; padding-top:5; padding-bottom:5; border-bottom:1px #DDDDDD solid ">
                            <table width="740" height="105" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="37" rowspan="3" align="left" bgcolor="#FFFFFF" style="padding:5px; padding-right:5px" valign="top"><?php 
			$target = "upload/h".$id;
			if(is_dir($target)){
				echo("<a href=HouseDetail.php?hid=$id class=one><img src=upload/h$id/1_100.jpg style=border:0 width='70px'></a>");
			}else 				  		
				echo("<a href=HouseDetail.php?hid=$id class=one><img src=img/NoHouse100_gray.jpg style=border:0 width='70px'></a>");
			?></td>
                                <td width="483" height="30" align="left" style="padding-left:15px; font-size:13px"><?php 
										  echo("<a href=HouseDetail.php?hid=$id class=one><strong>".substr($subject,0,45)." ...</strong></a>");
							  ?>
                                </td>
                                <td width="160" height="30" align="right" style="padding-right:5px; font-size:12px"><?php 
										  echo(getDateName($pdate)." | ".substr($ptime,0,5));
							  ?>
                                </td>
                              </tr>
                              <tr>
                                <td height="25" align="left" style="padding-left:15px; padding-bottom:5px; font-size:12px"><?php 
				echo("<font color=$_SESSION[hcolor]>$aname | $action | $city</font>");
				if($rate!=NULL && $rate>0)
					echo("<font color=$_SESSION[hcolor]> | $$rate/Month</font>");
							  ?>
                                </td>
                                <td height="25" align="right" style="padding-right:0px" valign="top">&nbsp;</td>
                              </tr>
                              <tr>
                                <td height="30" colspan="2" align="left" style="display:inline; padding-left:15px; padding-top:; padding-bottom:5px; padding-right:10px; font-size:12px; line-height:150%" valign="top"><?php
								  if(strlen($descrip)>20) 
									echo(substr(nl2br($descrip),0,500)."...");
								else
							  		echo("<a href=housedetail.php?hid=$id><font color=#000000>Click for details >></a></font>");
							  
							  $q1 = mysql_query("SELECT * FROM rockinus.house_comment WHERE hid='$id' ORDER BY pdate DESC, ptime DESC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("");}
if($no_row > 0){ 
while($object = mysql_fetch_object($q1)){
	$cid = $object->cid;
	$hid = $object->hid;
	$sender = $object->sender;
	$recipient = $object->recipient;
	$descrip = $object->descrip;
	$descrip = str_replace("\\","",nl2br($descrip));
	$ptime = $object->ptime;
	$pdate = $object->pdate; 
?>
                                    <div style="line-height:180%; margin-top:10px; width: 520px;">
                                      <table width="525" height="63" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5">
                                        <tr>
                                          <td width="265" height="25" align="left" bgcolor="#F5F5F5" style=" color:<?php echo($_SESSION['hcolor'])?>; padding:8"><script language="JavaScript" type="text/javascript">
$(document).ready(function() { 
	$('.<?php echo($cid) ?>').click(function(){ 
  		var txt = $(this).text();
		var uid = "<?php echo($uname) ?>";
		txt = $.trim(txt);
		uid = $.trim(uid);
		if(uid!=txt){ 
			$("#show_recipient_name").text("@"+txt);
			$("#recipient").val(txt);
		} 
	}); 
}); 
                                    </script>
                                              <strong> <a class="<?php echo($cid) ?>"> <font color="#000000"> <?php echo($sender) ?> </font> </a>
                                              <?php
				  if($sender!=$recipient)
				  	echo("@ $recipient");
				?>
                                            </strong> </td>
                                          <td width="255" height="25" align="right" bgcolor="#F5F5F5" style="padding:8"><font size="1"><?php echo($pdate) ?> | <?php echo($ptime) ?></font> </td>
                                        </tr>
                                        <tr>
                                          <td height="22" colspan="2" valign="top" style="padding:8;"><?php
													echo(substr(nl2br($descrip),0,500)." ...<br>");
												?>
                                          </td>
                                        </tr>
                                      </table>
                                    </div>
                                  <?php }}?>
                                </td>
                              </tr>
                            </table>
                          </div>
                          <?php 
							}else if($tbname=="article_info"){
							?>
                          <div style="margin-top:0px; margin-bottom:5px; padding-left:0; padding-top:15px; padding-bottom:15px; border-bottom:1px #DDDDDD solid">
                            <table width="740" height="90" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="30" rowspan="3" align="left" bgcolor="#FFFFFF" valign="top" style="padding-left:5px; padding-top:5px"><?php 
			$target = "upload/a".$id;
			if(is_dir($target)){
				echo("<a href=ArticleDetail.php?aid=$id class=one><img src=upload/a$id/1_100.jpg style=border:0 width='70px'></a>");
			}else 				  		
				echo("<a href=ArticleDetail.php?aid=$id class=one><img src=img/noarticle_gray100.jpg style=border:0 width='70px'></a>");
			?>
                                </td>
                                <td width="499" height="30" align="left" valign="middle" style="display:inline; padding-left:15px; border-bottom:0px #BBBBBB dotted; font-size:13px"><?php 
										  echo("<a href=ArticleDetail.php?aid=$id class=one><strong>".substr($subject,0,50)."...</a></font>");
							  ?>
                                </td>
                                <td width="121" height="30" align="right" valign="middle" style="display:inline; padding-right:0; font-size:12px">
								<?php echo("$pdate | ".substr($ptime,0,5))?>
								</td>
                              </tr>
                              <tr>
                                <td height="30" align="left" style="display:inline; padding-left:15px; padding-top:5px; font-size:12px" valign="top"><?php
				echo("<font color=$_SESSION[hcolor]>$aname | $action | $city</font>");	
				if($delivery=='N') echo("<font color=$_SESSION[hcolor]> | $$rate | Self take</font>");
				if($delivery=='Y') echo("<font color=$_SESSION[hcolor]> | $$rate | Can bring to you</font>");
				?>
                                </td>
                                <td height="30" align="right" style="display:inline; padding-right:10px" valign="top"></td>
                              </tr>
                              <tr>
                                <td height="30" colspan="2" align="left" style="display:inline; padding-left:15px; padding-top:5px; padding-bottom:5px; padding-right:10px; font-size:12px; line-height:150%" valign="top"><?php
								  if(strlen($descrip)>20){
									echo(substr(nl2br($descrip),0,500)."...<br>");
								}else echo("<a href=ArticleDetail.php?aid=$id class=one><font color=#999999><strong>See details ...</strong></font></a><br>");
								
$q1 = mysql_query("SELECT * FROM rockinus.article_comment WHERE aid='$id' ORDER BY pdate DESC, ptime DESC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("");}
if($no_row > 0){ 
while($object = mysql_fetch_object($q1)){
	$cid = $object->cid;
	$aid = $object->aid;
	$sender = $object->sender;
	$recipient = $object->recipient;
	$descrip = $object->descrip;
	$descrip = str_replace("\\","",nl2br($descrip));
	$ptime = $object->ptime;
	$pdate = $object->pdate; 
?>
                                    <div style="line-height:180%; margin-top:10px; width: 600px;">
                                      <table width="600" height="63" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5">
                                        <tr>
                                          <td width="269" height="30" align="left" bgcolor="#F5F5F5" style=" color:<?php echo($_SESSION['hcolor'])?>; padding:8"><script language="JavaScript" type="text/javascript">
$(document).ready(function() { 
	$('.<?php echo($cid) ?>').click(function(){ 
  		var txt = $(this).text();
		var uid = "<?php echo($uname) ?>";
		txt = $.trim(txt);
		uid = $.trim(uid);
		if(uid!=txt){ 
			$("#show_recipient_name").text("@"+txt);
			$("#recipient").val(txt);
		} 
	}); 
}); 
                                      </script>
                                              <strong> <a class="<?php echo($cid) ?>"> <font color="#000000"> <?php echo($sender) ?> </font> </a>
                                              <?php
				  if($sender!=$recipient)
				  	echo("@ $recipient");
				?>
                                            </strong> </td>
                                          <td width="251" height="30" align="right" bgcolor="#F5F5F5" style="padding:8"><font size="1"><?php echo($pdate) ?> | <?php echo($ptime) ?></font> </td>
                                        </tr>
                                        <tr>
                                          <td height="22" colspan="2" style="padding:8"><?php
									$len = strlen($descrip);
									$single_line_len = 95;
									$line_no = $len/$single_line_len; 
							
									for($i=0;$i<$line_no;$i++) {
										$str = substr($descrip,$i*$single_line_len, ($i+1)*$single_line_len)."<br>";
										echo $str;
									}?>
                                          </td>
                                        </tr>
                                      </table>
                                    </div>
                                  <?php }}?>
                                </td>
                              </tr>
                            </table>
                          </div>
                          <?php }else if($tbname=="course_memo_info"){ 
//						  		echo("SELECT * FROM rockinus.course_info WHERE coid='$id';");
								$memo_q = mysql_query("SELECT course_id, mid, course_name FROM rockinus.course_info WHERE course_id=(SELECT course_id FROM rockinus.unique_course_info WHERE course_uid ='$id');");
								if(!$memo_q) die(mysql_error());
								$obj = mysql_fetch_object($memo_q); 
								$course_id = $obj->course_id; 
								$mid = $obj->mid;
								$course_name = $obj->course_name;
						  
						  		$mid_sql = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid='$mid';");
								if(!$mid_sql) die(mysql_error());
								$obj_m = mysql_fetch_object($mid_sql); 
								$major_name = $obj_m->major_name; 
								
						  ?>
                          <div style="margin-top:0; margin-bottom:0; padding-left:0; padding-top:7; padding-bottom:3; border-bottom:1px #DDDDDD solid">
                            <table width="740" height="105" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="39" align="left" height="25" style="padding-top:5px; padding-left:5px"><img src="img/courseBlueIcon.jpg" width="18" /></strong></font></td>
                                <td width="556" height="25" style="padding-left:15px; font-size:13px"><?php
							  	echo("Comment on Course <font color=$_SESSION[hcolor]><strong>$course_id</strong></font> <font color='#666666'>($major_name)</font>"); 
							  ?></td>
                                <td width="135" height="25" align="right" style="padding-right:5px; font-size:12px"><?php echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?> </td>
                              </tr>
                              <tr>
                                <td align="center" height="20" style="padding-right:5px; padding-top:0">&nbsp;</td>
                                <td height="20" style="padding-left:15px; padding-top:0; font-size:12px" valign="top"><?php
							  	echo("<a href=CourseDetail.php?course_uid=$id class=one><font color=$_SESSION[hcolor]><strong>$course_name</strong></font></a> - $loop_pid");
							  ?></td>
                                <td height="20" align="right" style="padding-right:5; padding-top:0" valign="top"><?php 
								for($i=0;$i<$action;$i++)
									echo("<img src=img/yellowstar.jpg /> "); 
								?></td>
                              </tr>
                              <tr>
                                <td width="39" height="25" style="padding-left:5px">&nbsp;</td>
                                <td height="25" colspan="2" valign="top" style="padding:10px; padding-left:15px; padding-bottom:3; padding-top:5px; font-size:13px; line-height:120%;"><script>
$(document).ready(function() { 
	$("#commentCourseDiv<?php echo($loop_memoid) ?>").hide();
	
	$("div .commentCourseBtn<?php echo($loop_memoid) ?>").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#commentCourseBtn<?php echo($loop_memoid) ?>").hide();
	  $("#commentCourseDiv<?php echo($loop_memoid) ?>").show();
	});
	
	$("div .commentCancelBtn<?php echo($loop_memoid) ?>").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#commentCourseDiv<?php echo($loop_memoid) ?>").hide();
	  $("#commentCourseBtn<?php echo($loop_memoid) ?>").show();
	});
});
                          </script>
                                    <script type="text/javascript">
$(function() {
	$(".commentSubmitBtn<?php echo($loop_memoid) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var course_uid = '<?php echo($id) ?>';
		var anony_yesno = "N";
		if($('#anony_yesno<?php echo($loop_memoid) ?>').is(":checked")){
			anony_yesno = "Y";
		}
//		alert(anony_yesno);	
		var rating = $('input:radio[name=rating]:checked').val();
		var descrip = $('textarea#commentTextarea<?php echo($loop_memoid) ?>').val();
		var dataString = 'sender='+sender+'&&course_uid='+course_uid+'&&anony_yesno='+anony_yesno+'&&rating='+rating+'&&descrip='+descrip; 
		if (descrip.length<20 )
		{	
			alert("At least 20 letters...");
			return false;
		}
		
		$("#commentCourseDiv<?php echo($loop_memoid) ?>").hide();
		$("#flashCourseComment<?php echo($loop_memoid) ?>").show();
		$("#flashCourseComment<?php echo($loop_memoid) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_comment_course.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashCourseComment<?php echo($loop_memoid) ?>").hide();
				$("#commentCourseResult<?php echo($loop_memoid) ?>").after(html);
				$("#commentCourseResult<?php echo($loop_memoid) ?>").show();
				$("#commentCourseBtn<?php echo($loop_memoid) ?>").show();
				document.getElementById('commentTextarea<?php echo($loop_memoid) ?>').value='';
  			}
 		});
 		return false;
 	});
 });
                            </script>
                                    <?php 
								  echo("<font style='font-size:12px'>$subject</font>");
							  ?>
                                    <div class="flashCourseComment<?php echo($loop_memoid) ?>" id="flashCourseComment<?php echo($loop_memoid) ?>" style="margin-top:10"></div>
                                  <div class="commentCourseResult<?php echo($loop_memoid) ?>" id="commentCourseResult<?php echo($loop_memoid) ?>" style=" font-size:13px; margin-top:15; margin-bottom:5;"></div>
                                  <div class="commentCourseBtn<?php echo($loop_memoid) ?>" id="commentCourseBtn<?php echo($loop_memoid) ?>" style=" height:15; padding:2 5 2 5; background: url(img/master.png); display:; margin-top:15;  margin-bottom:10; width:90; border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:11px; cursor:pointer" align="center">Let me comment</div>
                                  <div class="commentCourseDiv<?php echo($loop_memoid) ?>" id="commentCourseDiv<?php echo($loop_memoid) ?>" style="width:650; margin-top:15; margin-bottom:10">
                                      <textarea name="textarea" class="commentTextarea<?php echo($loop_memoid) ?>" id="commentTextarea<?php echo($loop_memoid) ?>" style="border:1px solid #DDDDDD; height:90; width:650; font-size:13px; font-family:Arial, Helvetica, sans-serif; margin-bottom:15"></textarea>
                                      <div class="commentSubmitBtn<?php echo($loop_memoid) ?>" id="commentSubmitBtn<?php echo($loop_memoid) ?>" style=" height:18; padding:3 8 3 8; background: url(img/black_cell_bg.jpg); display:inline; margin-top:15; width:60; border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:12px; cursor:pointer; color:#FFFFFF" align="center">Submit</div>
                                     
                                      <div class="commentCancelBtn<?php echo($loop_memoid) ?>" id="commentCancelBtn<?php echo($loop_memoid) ?>" style=" height:18; padding:3 8 3 8; background: url(img/master.png); display:inline; margin-top:15; width:70; border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:12px; cursor:pointer" align="center">Next time</div>
                                       
                                      <input type="checkbox" name="anony_yesno" id="anony_yesno<?php echo($loop_memoid) ?>" class="anony_yesno<?php echo($loop_memoid) ?>" value="Y" />
                                    &nbsp; Anonymous &nbsp;&nbsp;&nbsp;&nbsp;
                                      <input type="radio" name="rating" value="5" />
                                      <img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" />&nbsp;&nbsp;
                                      <input type="radio" name="rating" value="4" />
                                      <img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" />&nbsp;&nbsp;
                                      <input type="radio" name="rating" value="3" />
                                      <img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" />&nbsp;&nbsp;
                                      <input type="radio" name="rating" value="2" />
                                      <img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" />&nbsp;&nbsp;
                                      <input type="radio" name="rating" value="1" />
                                      <img src="img/yellowstar.jpg" width="13" /> </div></td>
                              </tr>
                            </table>
                          </div>
                          <?php }else if($tbname=="news_info"){  
						  		?>
                          <div style="margin-top:0; margin-bottom:0; padding-left:0; padding-top:8; padding-bottom:12; border-bottom:1px #DDDDDD solid">
                            <table width="740" height="43" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="39" rowspan="2" bgcolor="#FFFFFF" valign="top" style="padding-left:5px; padding-top:5px"><img src="img/littleCalendar.jpg" width="18" /></strong></font></td>
                                <td width="551" height="25" style="padding-left:15px; padding-top:5px; font-size:13px; color:<?php echo($_SESSION['hcolor']) ?>; font-weight:normal" valign="top"><strong><?php echo("$subject") ?></strong> <font color="#000000">(Posted by <?php echo("<a href=RockerDetail.php?uid=$loopname class=one>$loopname_fname $loopname_lname</a>") ?>)</font></td>
                                <td width="140" height="25" align="right" style="padding-right:5px; padding-top:5px; font-size:12px" valign="top"><a href="SendMessage.php?recipient=<?php echo($loopname) ?>">
                                  <?php
								echo("<div style='background:url(img/master.png); display:inline; border:1px #DDDDDD solid; border-top:0px #DDDDDD solid; padding:2 5 2 5; height:15px; color:#333333; font-size:11px' onmouseover=this.style.cursor='hand'>+ Message</div>")
								?>
                                </a> </td>
                              </tr>
                              <tr>
                                <td height="18" colspan="2" valign="top" style="padding-left:15px; padding-top:0px; font-size:11px; font-weight:normal"><font color="#999999">Posted <?php echo(getDateName($pdate)." | ".substr($ptime,0,5)." | ") ?> </font> <span class="showFriendNewsDiv_<?php echo($id) ?>" id="showFriendNewsDiv_<?php echo($id) ?>" style="cursor:pointer; font-size:11px">+ Show Detail</span><span class="hideFriendNewsDiv_<?php echo($id) ?>" id="hideFriendNewsDiv_<?php echo($id) ?>" style="display:none; cursor:pointer; font-size:11px">+ Hide Detail</span>
                                    <div class="FriendNewsDiv_<?php echo($id) ?>" id="FriendNewsDiv_<?php echo($id) ?>" style="width:600; line-height:120%; font-size:12px; font-family:Arial, Helvetica, sans-serif; margin-top:5; display:none"> <?php echo(nl2br($action)) ?> </div></td>
                              </tr>
                            </table>
                          </div>
                          <?php } }?>
                        </td>
                      </tr>
                  </table>
				  </td>
                </tr>
            </table>
<script type="text/javascript">
function loadXMLDoc(str,div_id)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById(div_id).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","DefaultAjax3.php?page="+str+"&limit=25",true);
xmlhttp.setRequestHeader("Content-Type","text/html;charset=gb2312");
xmlhttp.send();
}
</script>
<?php
//echo("next page=".$next_page);
if($next_page <= $total_pages){ 
?>
<button type="button" onClick="loadXMLDoc('<?php echo($next_page) ?>','<?php echo($div_id) ?>')" style="color:black; font-size:18px; background-color: #F5F5F5; border:0px; height:30px; width:740px"> 
<?php if($_SESSION['lan']=="CN")echo("+ ¸ü¶à¶¯Ì¬"); else echo("+ Show More") ?>
</button>
<?php 
} 
?>
<br>
<div id=<?php echo($div_id) ?>></div>
<br>
</body>
</html>