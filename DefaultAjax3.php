<?php 
include("ValidCheck.php"); 
include("Allfuc.php");
include 'dbconnect.php';

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
<table width="599" height="115" border="0" cellpadding="0" cellspacing="0" style="margin-top:5px; margin-right:5px; margin-bottom:5px;">
                <tr>
                  <td height="85" colspan="2" valign="top" style="border-right:0 dotted #666666; border-left:0 dotted #666666"><table width="730" height="85" border="0" cellpadding="0" cellspacing="0">
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
	$page= (isset($_GET["page"]))? $_GET["page"] : 2;
	if((!$limit) || (is_numeric($limit) == false)|| ($limit < 40) || ($limit > 50)) {
		$limit = 1; //default
	}
 
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
		$page = 1; //default 

	$next_page = $page + 1;
	$div_id = "myDiv".$page;
	$total_pages = ceil($total_items / $limit);
	$set_limit = ($page * $limit) - $limit;
						
					//echo("set_limit=".$set_limit);
					//echo("limit=".$limit);
					//echo("page=".$page);
								
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
                              <td height="30" align="left" valign="top" style="padding-left:10px; padding-top:5px; font-size:12px"><?php
							  if($tbname=="user_check_info") 
							  	echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]><strong>$loopname</strong></font></a>");	
								if($_SESSION['lan']=="CN")echo " &Ograve;&Ntilde;&frac14;&Oacute;&Egrave;&euml;&plusmn;&frac34;&Eacute;&ccedil;&Ccedil;&oslash;";
								else echo(" has joined the network.");
								?>
                              </td>
                              <td height="30" align="right" valign="top" style="padding-right:5px; padding-top:5px; font-size:12px"><?php
							  echo(getDateName($pdate)." | ".substr($ptime,0,5));
							  ?>
                              </td>
                            </tr>
                            <tr>
                              <td height="30" valign="top" style="padding-left:10px; padding-top:; font-size:12px"><?php 
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
                              <td height="30" valign="top" style="padding-left:10px; padding-top:; font-size:12px"><script type="text/javascript">
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
                                  <span id="flashAddFriend<?php echo($loopname) ?>" class="flashAddFriend<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span> <span id="addFriendResult<?php echo($loopname) ?>" class="addFriendResult<?php echo($loopname) ?>" style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:90; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding-left:10; padding-right:10; padding-top:5; padding-bottom:5; display:none' align='center'></span>&nbsp;
                                  <?php
	 if($rel_rstatus!="S"){?>
                                  <a href="SendMessage.php?recipient=<?php echo($loopname) ?>">
                                  <div style="height:22; padding:2 7 2 7; background: url(img/master.jpg); cursor:pointer; border:1px solid #666666; font-size:12px; color:#000000; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif" align="center">Message </div>
                                  </a>
                                  <?php } ?>
                              </td>
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
						<div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:15px; padding-bottom: 15px; border-bottom:1px #DDDDDD solid">
                          <table width="730" height="131" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="30" height="18" align="left" valign="top" style="padding-left:5px; padding-top:5px"><img src="img/writeamessageIcon.jpg" width="30" height="25"/> </td>
                              <td width="475" align="left" valign="top" style="padding-left:15px; padding-top:5px; font-size:14px"><?php
			echo("<a href=RockerDetail.php?uid=$loopname><font color=$_SESSION[hcolor]>$loopname</font></a> has a new status");
							  ?>
                              </td>
                              <td width="145" height="18" align="right" valign="top" style="padding-right:0; padding-top:5px; font-size:12px"><?php
							  echo(getDateName($pdate)." | ".substr($ptime,0,5));
							  ?>
                              </td>
                            </tr>
                            <tr>
                              <td height="25" align="center" valign="middle" style="line-height:150%">&nbsp;</td>
                              <td height="25" colspan="2" align="left" valign="top" style="padding-left:15px; padding-right:5px; padding-top:10px; padding-bottom:5; line-height:150%; border:0px #DDDDDD dashed; font-size:14px; font-weight:normal; font-family:Verdana, Arial, Helvetica, sans-serif" bgcolor="">
							  <?php 
								echo(str_replace("\\","",nl2br($action)));
								?>
                              </td>
                            </tr>
                            <tr>
                              <td height="52" align="center" valign="middle" style="line-height:150%">&nbsp;</td>
                              <td height="52" colspan="2" align="left" valign="top" style="padding-left:15px; padding-right:5px; padding-top:10px; padding-bottom:5px; line-height:150%; border:0px #DDDDDD dashed"><?php 
$q1 = mysql_query("SELECT * FROM rockinus.memo_follow_info WHERE memoid='$id' ORDER BY pdate ASC, ptime ASC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row > 0){ 
	while($object = mysql_fetch_object($q1)){
		$sender = $object->sender;	
		$descrip = $object->descrip;
		$descrip = str_replace("\\","",nl2br($descrip));
		$ptime = $object->ptime;
		$pdate = $object->pdate; 
?>
                                  <div style="margin-bottom:20px; margin-top:5px; width: 600px;" align="left">
                                    <table width="600" height="65" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5">
                                      <tr>
                                        <td width="466" height="30" align="left" valign="top" bgcolor="#F5F5F5" style="padding:8"><?php echo("<strong> <a href=RockerDetail.php?uid=$sender class=one><FONT color=$_SESSION[hcolor]>$sender</font></a></strong> said:") ?> </td>
                                        <td width="134" height="30" align="right" valign="top" bgcolor="#F5F5F5" style="font-size:12px; padding:8"><?php echo(getDateName($pdate)) ?> | <?php echo(substr($ptime,0,5)) ?> </td>
                                      </tr>
                                      <tr>
                                        <td height="36" colspan="2" valign="top" style="line-height:150%; font-size:14px; padding:9"><?php
													if(strlen($descrip)>500)
														echo(substr(nl2br($descrip),0,500)." ...<br>");
													else
														echo(nl2br($descrip));
												?>
                                        </td>
                                      </tr>
                                    </table>
                                  </div>
                                <?php }}?>
                                  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js">
                              </script>
                                  <script type="text/javascript" >
 $(function() {
 $(".comment_button<?php echo($id) ?>").click(function() {
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
  $("#display<?php echo($id) ?>").after(html);
  document.getElementById('content<?php echo($id) ?>').value='';
  document.getElementById('content<?php echo($id) ?>').focus();
  $("#flash<?php echo($id) ?>").hide();
  }
 });
 } return false;
 });
 });
                              </script>
                                  <div id="flash<?php echo($id) ?>" style="padding-left:10px"></div>
                                <div id="display<?php echo($id) ?>" style="padding-left:10px"></div>
                                <div style="padding-left:0px">
                                    <form action="" method="post" name="form" id="form" style="margin-top:10px">
                                      <textarea name="content<?php echo($id) ?>" id="content<?php echo($id) ?>" rows="2" style="border:1px #DDDDDD solid; width:520" onfocus="this.style.backgroundColor='#F5F5F5'; this.style.borderColor='#CCCCCC'; " onclick="this.rows=4" onmouseout="this.style.backgroundColor='#FFFFFF';  this.rows=2"></textarea>
                                      &nbsp;&nbsp;&nbsp;
                                      <input type="submit" value="Reply" name="submit" class="comment_button<?php echo($id) ?>" style="margin-top:5px; color:#000000;   font: bold 84%'trebuchet ms',helvetica,sans-serif;   background-color: #FFFFFF; "/>
                                    </form>
                                </div></td>
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
                              <td width="121" height="30" align="right" valign="middle" style="display:inline; padding-right:0; font-size:12px"><?php echo("$pdate | ".substr($ptime,0,5))?> </td>
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
						<div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:15; padding-bottom:15; border-bottom:1px #DDDDDD solid">
                          <table width="730" height="105" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="30" align="left" height="35" style="padding-top:5px; padding-left:0px"><img src="img/book100.jpg" width="30" height="30" /></strong></font></td>
                              <td width="477" height="35" style="padding-left:15px; font-size:14px"><?php
							  	echo("Comment on Course <font color=$_SESSION[hcolor]><strong>$course_id</strong></font> <font color='#666666'>($major_name)</font>"); 
							  ?></td>
                              <td width="143" height="35" align="right" style="padding-right:0; font-size:12px"><?php echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?> </td>
                            </tr>
                            <tr>
                              <td align="center" height="30" style="padding-right:5px; padding-top:5px">&nbsp;</td>
                              <td height="30" style="padding-left:15px; padding-top:5px; font-size:14px" valign="top"><?php
							  	echo("<a href=CourseDetail.php?course_uid=$id class=one><font color=$_SESSION[hcolor]><strong>$course_name</strong></font></a>");
							  ?></td>
                              <td height="30" align="right" style="padding-right:0; padding-top:5px" valign="top"><?php 
								for($i=0;$i<$action;$i++)
									echo("<img src=img/yellowstar.jpg /> "); 
								?></td>
                            </tr>
                            <tr>
                              <td width="30" height="35" style="padding-left:5px">&nbsp;</td>
                              <td height="35" colspan="2" valign="top" style="padding:10px; padding-left:15px; padding-top:5px; font-size:14px; line-height:150%;"><?php 
								  echo("$subject");
							  ?>
                              </td>
                            </tr>
                          </table>
						  </div>
						<?php }else if($tbname=="news_info"){  
						  		?>
						<div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:15px; padding-bottom:15px; border-bottom:1px #DDDDDD solid">
						  <table width="730" height="110" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="35" rowspan="2" bgcolor="#FFFFFF" valign="top" align="left" style="padding-left:0px; padding-top:5px"><img src="img/calendar100.jpg" width="30" height="30" /></strong></font></td>
                              <td width="441" height="30" style="padding-left:15px; padding-top:5px; font-size:16px; font-weight:bold" valign="top"><?php echo("$subject") ?> </td>
                              <td width="174" height="30" align="right" style="padding-right:10px; padding-top:5px; font-size:12px" valign="top"><?php echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?></td>
                            </tr>
                            <tr>
                              <td colspan="2" rowspan="2" valign="top" style="padding:5px; padding-left:15px; font-size:14px"><font color=""><?php echo(nl2br($action)) ?></font></td>
                            </tr>
                            <tr>
                              <td width="35" height="35" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
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
xmlhttp.open("GET","DefaultAjax2.php?page="+str+"&limit=25",true);
xmlhttp.setRequestHeader("Content-Type","text/html;charset=gb2312");
xmlhttp.send();
}
</script>
<?php
if($next_page <= $total_pages){ 
?>
<button type="button" onClick="loadXMLDoc('<?php echo($next_page) ?>','<?php echo($div_id) ?>')" style="color:black; font-size:20px; background-color: #F5F5F5; border:0px; height:30px; width:730px">
<?php if($_SESSION['lan']=="CN")echo("+ ¸ü¶à¶¯Ì¬"); else echo("+ Show More") ?>
</button>
<?php } ?>
<br>
<div id=<?php echo($div_id) ?>></div>
</body>
</html>