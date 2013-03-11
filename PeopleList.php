<?php 
include 'dbconnect.php';
//include 'Allfuc.php';

//session_start();
//$uname = $_SESSION['usrname'];

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
//echo("111");
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
<script>
function do_resize(textbox) {

var maxrows=5;
var txt=textbox.value;
var cols=textbox.cols;

var arraytxt=textbox.split('\n');
var rows=arraytxt.length;

for (i=0;imaxrows)
textbox.rows=maxrows;
else
textbox.rows=rows;

}
</script>
<table width="320" height="115" border="0" cellpadding="0" cellspacing="0" style="margin-top:5px; margin-bottom:5px;  -moz-border-radius: 5px; border-radius: 5px;">
                <tr>
                  <td width="577" height="85" colspan="2" valign="top">
				  <table width="350" height="788" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="350" height="788" valign="top" >
						<?php
			include 'dbconnect.php';
			
			$sel_count = "
SELECT sum(total) as cnt FROM (
	SELECT count(*) as total FROM rockinus.user_check_info a
			WHERE uname in (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname'
						UNION
						SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname') AND uname <> '$uname' AND 1<>1
	UNION
	SELECT count(*) as total FROM rockinus.course_memo_info e JOIN rockinus.user_custom_setting fcustom ON fcustom.ccomment='Y' and fcustom.uname='$uname'
	UNION 
	SELECT count(*) as total FROM rockinus.memo_info i 
		WHERE sender in (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname'
						UNION
						SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname') AND sender <> '$uname'
	UNION 
	SELECT count(*) as total FROM rockinus.rocker_rel_info j
		WHERE sender in (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname'
						UNION
						SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname')
		OR  recipient in (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname' 
						UNION
						SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname')
	UNION 
	SELECT count(*) as total FROM rockinus.headicon_history k 
		WHERE uname in (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname'
						UNION
						SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname') 
		OR uname = '$uname'
		GROUP BY uname
) as cnt";

$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

if($total_items<2) include "HomeUserUpdateWid.php";

	$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 30;
	$page= (isset($_GET["page"]))? $_GET["page"] : 1;
	if((!$limit) || (is_numeric($limit) == false)|| ($limit < 30) || ($limit > 40)) 
		$limit = 1; //default
	
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
		$page = 1; //default 

	$next_page = $page + 1;
	$div_id = "peopleDiv".$page;
	$total_pages = ceil($total_items / $limit);
	$set_limit = ($page * $limit) - $limit;
	
	if( $total_items==0 && $page==1 )echo("<div style='padding-top:20px; padding-bottom:20px; background-color: #F5F5F5; margin-top:10px; border:6px #DDDDDD solid;' align=center><font size=3 color=#999999><strong>Hello $uname, there is no updates found in your community network.<br><br>We strongly recommand you <span style='border-bottom:1px dashed #999999'><a href=EditUserInfo.php class='three'><font size=3 color=#B92828>Improve profile</font></a></span> or <span style='border-bottom:1px dashed #999999'><a href=FriendGroup.php class='three'><font size=3 color=#B92828>make some friends</font></a></span>.<br><br>You can also click the tab above to see \"Every People Rock\" :)</strong></font></div>");
						
    	$arr_loopname = array();
		$tmp_arr_loopname = array();
		$sql_stmt = "SELECT email,uname, NULL as subject, status, signup_date,signup_time,tbname, NULL as col_2, NULL as col_3, NULL as col_4, NULL as col_5, NULL as col_6, NULL as col_7 
					FROM rockinus.user_check_info a
						WHERE uname in (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname'
											UNION
											SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname') AND uname <> '$uname' AND 1<>1
					UNION 
					SELECT memoid, sender, level, descrip, pdate, ptime, 'memo_info', NULL, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.memo_info i 
						WHERE sender in (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname'
											UNION
											SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname') AND sender <> '$uname' AND descrip <> ''
					UNION 
					SELECT NULL, sender, recipient, NULL, pdate, ptime, 'rocker_rel_info', NULL, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.rocker_rel_info j
						WHERE sender in (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname'
										UNION
										SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname')
						OR  recipient in (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname' 
										UNION
										SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname') 
					UNION
					SELECT NULL, uname, NULL, NULL, pdate, ptime, 'headicon_history', NULL, NULL, NULL, NULL, NULL, NULL
					FROM rockinus.headicon_history k
						WHERE uname in (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname'
											UNION
											SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname') 
					OR uname = '$uname'
					ORDER BY signup_date DESC, signup_time DESC LIMIT $set_limit, $limit";
					//echo($sql_stmt);
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($no_row == 0) echo("");
		$ik=0;
		while($object = mysql_fetch_object($q)){
			$ik++;
//			echo($ik."-----<br>");
			$loopname = $object->uname;		
			$tbname = $object->tbname;			
			$pdate = $object->signup_date;
			$ptime = $object->signup_time;
			$id = $object->email;
			$subject = $object->subject;
			$subject = str_replace("\\","",nl2br($subject));
			$aname = $object->col_2;
			$city = $object->col_3;
			$rate = $object->col_4;
			$delivery = $object->col_5;
			$type = $object->col_6;
			$descrip = $object->col_7;
			$descrip = str_replace("\\","",$descrip);
			$action = $object->status;
			$action = str_replace("\\","", $action);
			//if(strlen($subject)>50) $subject = substr(trim($subject), 0, 50)."...";
            if($tbname=="rocker_rel_info"){
			?>
						<div style="margin-top:0; margin-bottom:15px; padding-left:0; background: #FFFFFF; width:350px;  -moz-border-radius: 5px; border-radius: 5px;">
						  <table width="350" height="36" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="70" align="left" valign="top" style="padding-left:2px;">
							  <?php
							  $pic100_Name = $loopname.'60.jpg';
				  $target = "upload/".$loopname;
				  if(is_dir($target))
				  	echo("<a href='UpdateWall.php' class='one'><div style='border:0px solid #EEEEEE'><img src=upload/$loopname/$pic100_Name?".time()." style='border:0px solid #999999' width=55></div></a>");
				  else {
//				  	$headicon_id = -1;
					echo("<a href='EditHeadIcon.php' class='one'><img src=img/NoUserIcon100.jpg style='border:0; border-top:5px solid #FFFFFF' width=55></a>");
					}
							  ?>							  </td>
                              <td height="18" align="left" valign="top" style="padding-left:0px; padding-right:10px; font-size:14px;  padding-bottom:5px; line-height:125%"><?php
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
				
			$friend = mysql_query("SELECT count(*) as cnt FROM rockinus.rocker_rel_info WHERE (sender='$uname' AND recipient='$subject')
									OR 
								(sender='$subject' AND recipient='$uname');");
			if(!$friend) die("Error quering the Database: " . mysql_error());
			$friend_f = mysql_fetch_object($friend);
			$friend_tag = $friend_f->cnt;
			$friend_rmk = "";
			if($friend_tag>0) $friend_rmk = "$subject_fname is also your friend";
			else{
				$mutual_friend_num = getMutalFriends($subject,$uname);
				if($mutual_friend_num>0) $friend_rmk = "$subject_fname and you have ".count($mutual_friend_num)." mutual friend(s)";
			}		
				
				
				if($friend_tag == "loopname"){
					echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]><strong>$loopname_fname</strong></font></a>$hobbyTitle has a new friend <a href=RockerDetail.php?uid=$subject class=one><font color=$_SESSION[hcolor]><strong>$subject_fname</strong></font></a>");
				}else
					echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]><strong>$loopname_fname</strong></font></a>'s new friend <a href=RockerDetail.php?uid=$subject class=one><font color=$_SESSION[hcolor]><strong>$subject_fname $subject_lname</strong></font></a>");
				?>               
				<br />              
				<?php echo("<font color='#999999' style='font-size:12px'>Now $loopname_fname has $no_row_f friend(s) <br>$friend_rmk</font>") ?>
				<br /> 
				                <font color="#999999" style=" font-size:11px"><?php
							  echo(getDateName($pdate)." | ".substr($ptime,0,5));
							  ?>                              
							  </font></td>
                            </tr>
                          </table>
						</div>
						<?php 
							}else if($tbname=="memo_info"){
				$q_sender = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$loopname'");
				if(!$q_sender) die(mysql_error());
				$object = mysql_fetch_object($q_sender);
				$loopname_fname = $object->fname;
				$loopname_lname = $object->lname;
			?>
<div style="margin-bottom:15px; background:#FFFFFF; width:350px;  -moz-border-radius: 5px; border-radius: 5px;">
                            <table width="350" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="73" height="78" align="left" valign="top">
								<?php
							  $pic100_Name = $loopname.'60.jpg';
				  $target = "upload/".$loopname;
				  if(is_dir($target))
				  	echo("<a href='UpdateWall.php' class='one'><div style='border:0px solid #EEEEEE'><img src=upload/$loopname/$pic100_Name?".time()." style='border:0px solid #999999' width=55></div></a>");
				  else {
//				  	$headicon_id = -1;
					echo("<a href='EditHeadIcon.php' class='one'><img src=img/NoUserIcon100.jpg style='border:0; border-top:5px solid #FFFFFF' width=55></a>");
					}
							  ?>								</td>
                                <td width="277" align="left" valign="top" style="padding:0px 10px 5px 5px; font-size:14px; line-height:125%">
								<?php
			echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]><strong>$loopname_fname $loopname_lname</strong></font></a> ");
			echo("<font color='#999999' style='font-size:11px'>(".getDateName($pdate)." | ".substr($ptime,0,5).")</font>");
							  ?>    
							  <div style="margin-top:10px 10px 10px 0px; font-size:12px; width:260px">                           
								<?php 
								echo(addHyperLink(str_replace("\\","",nl2br($action))));
								?>	
								</div>							
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
							  
								  <div style="margin-bottom:5px; margin-top:5px; width: 260px;" align="left" class="statusReplyDiv<?php echo($memofid) ?>" id="statusReplyDiv<?php echo($memofid) ?>">
                                    <table width="260" height="45" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-bottom:0px solid #DDDDDD;">
                                      <tr>
                                        <td width="102" height="20" align="left" valign="top" bgcolor="#F5F5F5" style="padding-left:5px; font-size:12px; padding-top:5px"><?php echo("<strong> <a href=RockerDetail.php?uid=$sender class=one><FONT color=$_SESSION[hcolor]>$sender_fname $sender_lname</font></a></strong>") ?> </td>
                                        <td width="48" height="20" align="right" valign="top" bgcolor="#F5F5F5" style="padding-top:7px; font-size:12px">
										<?php if($sender==$uname){ ?>
										<div class="deleteReplyBtn<?php echo("$memofid"); ?>" id="deleteReplyBtn<?php echo("$memofid"); ?>" style="height:15; padding:0 0 5 0; border:0px solid #DDDDDD; font-size:10px; color:#999999; display:inline; cursor:pointer">Delete</div>
										<?php } ?>										</td>
                                        <td width="100" height="20" align="right" valign="top" bgcolor="#F5F5F5" style="font-size:10px; padding-right:5px; color:#666666; padding-top:5px">
										<?php echo(getDateName($reply_pdate)) ?> | <?php echo(substr($reply_ptime,0,5)) ?> </td>
                                      </tr>
                                      <tr>
                                        <td height="20" colspan="3" valign="top" style="line-height:120%; font-size:13px; padding:5px"><?php
													if(strlen($descrip)>500)
														echo(substr($descrip,0,500)." ...<br>");
													else
														echo($descrip);
												?>										</td>
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

if(test==''||test=='Write here...')
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
  $("#commentStatusBtn<?php echo($id) ?>").show();
  }
 });
 } return false;
 });
 });
                                  </script>
                                  <div id="flashStatus<?php echo($id) ?>" class="flashStatus<?php echo($id) ?>" style="padding-left:10px"></div>
                                  <div id="displayStatus<?php echo($id) ?>" class="displayStatus<?php echo($id) ?>" style="padding-left:10px"></div>
                                  <div class="commentStatusDiv<?php echo($id) ?>" id="commentStatusDiv<?php echo($id) ?>" style="margin-top:5;">
                                    <textarea name="content<?php echo($id) ?>" id="content<?php echo($id) ?>" style="border:1px #DDDDDD solid; width:260px; margin-bottom:5px; height:30px; font-family:Arial, Helvetica, sans-serif; font-size:12px; padding:4px; line-height:130%; padding:4px; color:#888888" onclick="this.style.height = '40px'; if(this.value=='Write here...')this.value=''" onFocus="this.style.height = '40px'; this.select(); inputFocus(this)" onBlur="this.style.height = '40px'; this.value=!this.value?'Write here...':this.value; inputBlur(this)">Write here...</textarea>
                                    <br />
                                <div class="commentStatusSubmitBtn<?php echo($id) ?>" id="commentStatusSubmitBtn<?php echo($id) ?>" style=" height:15px; padding:2px 5px 2px 5px; background: url(img/master.jpg); display:inline; margin-top:5px; width:60px; border:1px solid #999999; font-size:11px; cursor:pointer; color:#000000; -moz-border-radius: 3px; border-radius: 3px;" align="center">Submit</div>   <font style="font-size:11px; color:#999999">(Less than 500 letters)</font>                                </div></td>
                              </tr>
                            </table>
                          </div>
                          <script>
$(document).ready(function() { 
	$("#showFriendNewsDiv_<?php echo($id) ?>").click(function () {
	  $("#showFriendNewsDiv_<?php echo($id) ?>").hide();
	  $("#hideFriendNewsDiv_<?php echo($id) ?>").show();
	  $("#FriendNewsDiv_<?php echo($id) ?>").show();
	});

	$("#hideFriendNewsDiv_<?php echo($id) ?>").click(function () {
	  $("#hideFriendNewsDiv_<?php echo($id) ?>").hide();
	  $("#FriendNewsDiv_<?php echo($id) ?>").hide();
	  $("#showFriendNewsDiv_<?php echo($id) ?>").show();
	});
});
</script>
<?php }else if($tbname=="headicon_history"){  
						  //echo("---$loopname<br>");
						  if(!in_array($loopname,$arr_loopname)){
						  	//array_push($tmp_arr_loopname,$loopname);
						  	//if(count($tmp_arr_loopname)==2){
							//$loopname1 = $tmp_arr_loopname[0];
							//$loopname2 = $tmp_arr_loopname[1];
						  ?>
<div style="margin-bottom:20px; margin-top:0px; border:0px #DDDDDD solid; width:350px; background:#FFFFFF;  -moz-border-radius: 5px; border-radius: 5px;">
                            <table width="350" height="250" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="472" height="25" valign="top" style="padding:2px 0 5px 0; font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal"><img src="img/user-silhouette.png" width="11" />&nbsp; <?php 
				$q_loopName = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$loopname'");
				if(!$q_loopName) die(mysql_error());
				$object_icon = mysql_fetch_object($q_loopName);
				$icon_fname = $object_icon->fname;
				$icon_lname = $object_icon->lname;
				$icon_gender = $object_icon->gender;
				if($icon_gender=='Female')$tmp_gender="her";
				else $tmp_gender="his";
								echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]><strong>$icon_fname $icon_lname</strong></font></a>");
								
								echo("&nbsp;<font color=#999999 style='font-weight:normal; font-size:11px'>(".getDateName($pdate)." | ".substr($ptime,0,5).")</font>");
								?>                                </td>
                              </tr>
                              <tr>
                                <td height="18" align="left" valign="top" style="padding-left:0px; font-size:14px">

<?php
									$loopImg = "upload/$loopname/$loopname.jpg";
							  		$data = getimagesize($loopImg); 
									$width = $data[0]; 
									if($width>350){
										$loopImg = "upload/$loopname/$loopname.jpg";
										$width = 350;
									}else if($width>300){
										$loopImg = "upload/$loopname/$loopname.jpg";
										$width = 300;
									}else if($width>250){
										$loopImg = "upload/$loopname/$loopname.jpg";
										$width = 250;
									}else{
										$loopImg = "upload/$loopname/$loopname"."250.jpg";
										$width = 100;
									}
									
									if(file_exists($loopImg)) echo("<a href=RockerDetail.php?uid=$loopname class=one><img src=$loopImg?".time()." style='border:0px #666666 solid; margin-bottom:0px' width=$width /></a>");
							  else echo("<a href=RockerDetail.php?uid=$loopname class=one><img src=img/NoUserIcon100.jpg width=80px style='margin-bottom:0px' /></a>");
							  ?>							  </td></tr>
                              <tr>
                                <td height="35" align="left" valign="top" style=" padding-left:0px; font-size:14px">
								<script type="text/javascript">
$(function() {
	$(".likeBtn<?php echo($loopname) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($loopname) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#likeBtn<?php echo($loopname) ?>").hide();
		$("#flashLikeDiv<?php echo($loopname) ?>").show();
		$("#flashLikeDiv<?php echo($loopname) ?>").fadeIn(400).html('');
 
		$.ajax({
			type: "POST",
			url: "ajax_like_headicon.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashLikeDiv<?php echo($loopname) ?>").hide();
				$("#likeResult<?php echo($loopname) ?>").html(html);
				$("#likeResult<?php echo($loopname) ?>").show();
			}
 		});
 		return false;
 	});
 });
                            </script>
                                    <?php
$headicon_id = 0;
$headicon_descrip = "";
$q_m = mysql_query("SELECT headicon_id FROM rockinus.headicon_history WHERE uname='$loopname' ORDER BY headicon_id DESC");
if(!$q_m) die(mysql_error());
$no_row = mysql_num_rows($q_m);
if($no_row == 0) echo("Error, head icon not found");
else{
	$object = mysql_fetch_object($q_m);
	$headicon_id = $object->headicon_id;
	$headicon_descrip = $object->descrip;
}

$like_uname_list=NULL;	
$q_like_headicon_list = mysql_query("SELECT * FROM rockinus.headicon_like WHERE headicon_id='$headicon_id'");
if(!$q_like_headicon_list) die(mysql_error());
$no_row_headicon_list = mysql_num_rows($q_like_headicon_list);
if($no_row_headicon_list == 0){
	//$like_uname_list = "<font color='#000000'>No friends clicked yet ...</font>";
	$like_uname_list = "";
}else{
	$like_uname_seq = 1;
	$like_uname_list = "<div style='border:0px solid #DDDDDD; padding:2px; background:'><span style='font-size:12px'>$no_row_headicon_list people like it:</span>&nbsp;";
	while($object_headicon_list = mysql_fetch_object($q_like_headicon_list)){
		$like_uname = $object_headicon_list->uname;
		$q_like_uname = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$like_uname'");
		if(!$q_like_uname) die(mysql_error());
		$object_like_uname = mysql_fetch_object($q_like_uname);
		$like_fname = $object_like_uname->fname;
		$like_lname = $object_like_uname->lname;
		
		if($like_uname_seq==1) $like_uname_list .= "<a href='RockerDetail.php?uname=$like_uname' class=one><font color=$_SESSION[hcolor] style='font-size:12px; font-weight:bold'>$like_fname $like_lname</font></a>";
		else $like_uname_list .= ", <a href='RockerDetail.php?uname=$like_uname' class=one><font color=$_SESSION[hcolor] style='font-size:12px; font-weight:bold'>$like_fname $like_lname</font></a>&nbsp;";
		
		$like_uname_seq++;
	}
	echo("</div>");
}

$q_like_headicon = mysql_query("SELECT * FROM rockinus.headicon_like WHERE uname='$uname' AND headicon_id='$headicon_id'");
if(!$q_like_headicon) die(mysql_error());
$no_row_headicon = mysql_num_rows($q_like_headicon);
?>

                                  <?php
if($no_row_headicon == 0){
?>
                                    <div class="likeBtn<?php echo($loopname) ?>" id="likeBtn<?php echo($loopname) ?>" style=" padding:3 0 2 0; background: ; height:15px; font-weight:normal; widows: inherit; margin-top:5px; border:1px solid #DDDDDD; font-size:11px; font-family:Arial, Helvetica, sans-serif; width:65px; background:#EEEEEE; cursor:pointer; color:#000000; -moz-border-radius: 2px; border-radius: 2px;" align="center" onmouseover="this.style.backgroundColor='#DDDDDD';" onmouseout=" this.style.backgroundColor='#EEEEEE';"> <img src="img/headicon_like.png" width="11" />&nbsp;&nbsp; Like </div>
                                    <?php }else{ ?>
                                    <div style='background-image:; background: ; margin-bottom:0; display:inline; border:0px #DDDDDD solid; height:5px; color:<?PHP echo($_SESSION['hcolor']); ?>; margin-top:5; font-weight:bold; font-size:12px'></div>
                                    <?php } ?>
									
                                    <div style="height:15; padding:2 5 2 5; background: url(img/master.png); width: auto; border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; margin-bottom:5; font-size:11px; cursor:pointer; color:#000000; display:none" align="center">Comment <?php echo($icon_fname) ?> Next Time</div>
                                    <div id="flashLikeDiv<?php echo($loopname) ?>" class="flashLikeDiv<?php echo($loopname) ?>" style=" display:none; width:100px; padding-right:5px; margin-top:5px"></div> 
									<div id="likeResult<?php echo($loopname) ?>" class="likeResult<?php echo($loopname) ?>" style='display:none; margin-top:5px'></div>
									<?php if(strlen(trim($like_uname_list))>0){ ?>
                                <div style=" margin-top:5px; width:345px; margin-bottom:10px; font-size:11px"><?php echo($like_uname_list) ?></div>                                
								<?php } ?>
								</td>
                              </tr>
							  <tr><td style="padding-left:0px" align="left" valign="top">
<?php
	$q1_sel = mysql_query("SELECT * FROM rockinus.headicon_comment WHERE headicon_id='$headicon_id'");
	if(!$q1_sel){
		$output = mysql_error();
		echo($output);
	}
	$no_row_headicon_comment = mysql_num_rows($q1_sel);
	$start_line_no = $no_row_headicon_comment-5;
?>
							  
<script type="text/javascript" >
$(function() {
 	$(".expandHeadIconComment_button<?php echo($headicon_id) ?>").click(function() {
		var headicon_id = <?php echo($headicon_id) ?>;
		var start_line_no = <?php echo($start_line_no) ?>;
		var dataString = 'headicon_id='+headicon_id+'&start_line_no='+start_line_no; 

		if(headicon_id=='')
		{
			alert("not getting memo id!");
		}
		else if( !$("#display_expandHeadIconComment<?php echo($headicon_id) ?>").is(':visible') )
		{
			$("#flash_expandHeadIconComment<?php echo($headicon_id) ?>").show();
			$("#flash_expandHeadIconComment<?php echo($headicon_id) ?>").fadeIn(400).html('');
 
			$.ajax({
  				type: "POST",
  				url: "load_headicon_memo.php",
  				data: dataString,
  				cache: false,
  				success: function(html){
  					$("#display_expandHeadIconComment<?php echo($headicon_id) ?>").after(html);
					//$("#display_expandHeadIconComment<?php echo($headicon_id) ?>").show(html);
  					$("#flash_expandHeadIconComment<?php echo($headicon_id) ?>").hide();
  					$("#expandHeadIconComment_button<?php echo($headicon_id) ?>").hide();
				}
 			});
 		} return false;
 	});
 });
</script>

<div id="flash_expandHeadIconComment<?php echo($headicon_id) ?>" class="flash_expandComment<?php echo($headicon_id) ?>" style="display:none" align="left"></div>
<div id="display_expandHeadIconComment<?php echo($headicon_id) ?>" class="display_expandHeadIconComment<?php echo($headicon_id) ?>" style=" margin-top:10; width:225px; margin-bottom:10; font-size:11px; background:; display:none" align="left"></div>
<?php	
	$q_sel = "";
	if($no_row_headicon_comment>5){
		$q_sel = mysql_query("SELECT * FROM rockinus.headicon_comment WHERE headicon_id='$headicon_id' ORDER BY hi_follow_id ASC LIMIT $start_line_no,5;");
		if(!$q_sel){
			$output = mysql_error();
			echo($output);
		}
	}else{
		$q_sel = mysql_query("SELECT * FROM rockinus.headicon_comment WHERE headicon_id='$headicon_id' ORDER BY hi_follow_id ASC");
		if(!$q_sel){
			$output = mysql_error();
			echo($output);
		}
	}
	
	if($no_row_headicon_comment>5){
	 	$tmp_headicon_comment_cnt = $no_row_headicon_comment-5;
		echo("<div class='expandHeadIconComment_button$headicon_id' id='expandHeadIconComment_button$headicon_id' style='width:315px; font-size:11px; font-weight:bold; margin-bottom:7; color:$_SESSION[hcolor]; cursor:pointer'>&nbsp; + Show previous $tmp_headicon_comment_cnt comment(s)</div>");
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
	$("#replyStatusDiv<?php echo($hi_follow_id) ?>").hide();
	$("#flashReply<?php echo($hi_follow_id) ?>").hide();
	$("#displayReplyResult<?php echo($hi_follow_id) ?>").hide();
	
	$("div .replyStatusBtn<?php echo($hi_follow_id) ?>").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#replyStatusBtn<?php echo($hi_follow_id) ?>").hide();
	  $("#commentHeadIconDiv<?php echo($loopname) ?>").hide();
	  $("#replyStatusDiv<?php echo($hi_follow_id) ?>").show();
	  $("#commentStatusDiv_<?php echo($hi_follow_id) ?>").hide();
	});
	
	$("div .replyCancelBtn<?php echo($hi_follow_id) ?>").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#replyStatusDiv<?php echo($hi_follow_id) ?>").hide();
	  $("#commentHeadIconDiv<?php echo($loopname) ?>").show();
	  $("#replyStatusBtn<?php echo($hi_follow_id) ?>").show();
	});
});
    </script>
    <script type="text/javascript" >
$(function() {
	$(".replySubmitBtn<?php echo($hi_follow_id) ?>").click(function() {
		var test = $("#replyContent<?php echo($hi_follow_id) ?>").val();
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
			$("#replyStatusDiv<?php echo($hi_follow_id) ?>").hide();
			$("#flashReply<?php echo($hi_follow_id) ?>").show();
			$("#flashReply<?php echo($hi_follow_id) ?>").fadeIn(400).html('');
 
 			$.ajax({
  				type: "POST",
  				url: "ajax_reply_status.php",
  				data: dataString,
  				cache: false,
  				success: function(html){
  					$("#displayReplyResult<?php echo($hi_follow_id) ?>").after(html);
					document.getElementById('replyContent<?php echo($hi_follow_id) ?>').value='';
					//document.getElementById('replyContent<?php echo($hi_follow_id) ?>').focus();
  					$("#flashReply<?php echo($hi_follow_id) ?>").hide();
					$("#replyStatusBtn<?php echo($hi_follow_id) ?>").show();
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
			alert("not getting headicon id!");
		}
		else
		{
			$("#replyInfoDiv<?php echo($hi_follow_id) ?>").hide();
			$("#flashdeleteHeadIconReply<?php echo($hi_follow_id) ?>").show();
 			$("#flashdeleteHeadIconReply<?php echo($hi_follow_id) ?>").fadeIn(400).html('');
 
			$.ajax({
 				type: "POST",
				url: "ajax_delete_headicon_reply.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#deleteHeadIconReplyResult<?php echo($hi_follow_id) ?>").after(html);
					document.getElementById('replyHeadIconContent<?php echo($hi_follow_id) ?>').value='';
					document.getElementById('replyHeadIconContent<?php echo($hi_follow_id) ?>').focus();
					$("#flashdeleteHeadIconReply<?php echo($hi_follow_id) ?>").hide();
					$("#deleteHeadIconReplyResult<?php echo($hi_follow_id) ?>").fadeOut("slow");
				}
			});
		} return false;
 	});
 });
 </script>
    <div class="flashdeleteHeadIconReply<?php echo($hi_follow_id) ?>" id="flashdeleteHeadIconReply<?php echo($hi_follow_id) ?>"></div>
    <div class="deleteHeadIconReplyResult<?php echo($hi_follow_id) ?>" id="deleteHeadIconReplyResult<?php echo($hi_follow_id) ?>"></div>
    <div id="replyInfoDiv<?php echo($hi_follow_id) ?>" class="replyInfoDiv<?php echo($hi_follow_id) ?>" style=" padding-top:0; margin-bottom:5; width:345px; border-top:1px solid #EEEEEE">
      <table width="345" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="margin-bottom:0; border-bottom:0 dashed #DDDDDD">
        <tr>
          <td width="478" height="25" align="left" valign="top" style=" font-weight:normal; font-size:12px; padding:5; padding-left:7; padding-bottom:2; line-height:120%">
            <?php 
			if($sender==$uname)
				echo("<strong><font color=$_SESSION[hcolor]>You</font></strong> : ".addHyperLink($descrip)."");
			else
				echo("<strong><font color=$_SESSION[hcolor]>$sender_fname $sender_lname</font></strong> : ".addHyperLink($descrip)."");
	?>	</td>
	    </tr>
        <tr>
          <td height="15" align="left" valign="top" style=" font-weight:normal; font-size:10px; padding:1 5 5 7; color:#999999; line-height:150%">
            <?php echo(getDateName($pdate).", ".substr($ptime,0,5)) ?>
            <?php if($uname==$sender){ ?>&nbsp;<span style=" height:6; padding:0; background: #F5F5F5; width:40; display:inline; border:0px solid #DDDDDD; font-size:10px; cursor:pointer; color:<?php echo($_SESSION['hcolor']) ?>" align="center" id="deleteHeadIconReplyBtn<?php echo($hi_follow_id) ?>" class="deleteHeadIconReplyBtn<?php echo($hi_follow_id) ?>">Delete</span>
            <?php }else if($sender!=$recipient){ ?>
            &nbsp;<div class="replyStatusBtn<?php echo($hi_follow_id) ?>" id="replyStatusBtn<?php echo($hi_follow_id) ?>" style=" height:6; padding:1; background: ; width:50; display:inline; border:0px solid #999999;  border-top:0px solid #CCCCCC; border-left:0px solid #CCCCCC; font-size:10px; cursor:pointer; color:#000000" align="center"> | &nbsp;Reply</div>
            <?php } ?>        </td>
        </tr>
        </table>
      </div>
    <div class="flashReply<?php echo($hi_follow_id) ?>" id="flashReply<?php echo($hi_follow_id) ?>" style=" margin-top:30; display:none"></div>
    <div class="displayReplyResult<?php echo($hi_follow_id) ?>" id="displayReplyResult<?php echo($hi_follow_id) ?>" style="margin-top:30; display:none"></div>
    <div class="replyStatusDiv<?php echo($hi_follow_id) ?>" id="replyStatusDiv<?php echo($hi_follow_id) ?>" style=" margin-top:5; margin-bottom:10; width:450px; display:none">
      <textarea name="replyContent" id="replyContent<?php echo($hi_follow_id) ?>" style=" width:450px; border:1px solid #DDDDDD; height:50px; font-size:13px; padding:4; font-weight:normal; font-family: Arial, Helvetica, sans-serif; margin-bottom:10px"></textarea><br />
      <div class="replySubmitBtn<?php echo($hi_follow_id) ?>" id="replySubmitBtn<?php echo($hi_follow_id) ?>" style=" height:15; padding:2 4 2 4; background: url(img/black_cell_bg.jpg); display:inline; margin-top:10; margin-bottom: width:60; border:1px solid #333333; font-size:11px; cursor:pointer; font-weight:bold; color:#FFFFFF" align="center">Submit</div> 
      <div class="replyCancelBtn<?php echo($hi_follow_id) ?>" id="replyCancelBtn<?php echo($hi_follow_id) ?>" style=" height:15; padding:2 4 2 4; background: url(img/master.png); display:inline; margin-top:10; width:70; border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; font-size:11px; font-weight:bold; cursor:pointer" align="center">Next time</div>
    </div>
    <div id="flashDeleteReply<?php echo($hi_follow_id) ?>" class="flashDeleteReply<?php echo($hi_follow_id) ?>" style="padding-left:0px; margin-top:15; margin-bottom:15; display:none"></div>
    <div id="deleteReplyResult<?php echo($hi_follow_id) ?>" class="deleteReplyResult<?php echo($hi_follow_id) ?>" style="padding-left:0px; width:450; background:#F5F5F5; padding:10; margin-top:20; display:none"></div>
    <? 
}
?>
								<?php if($no_row_headicon_comment==0){?><?php } ?>
								<div id="flashHeadIconStatus<?php echo($headicon_id) ?>" class="flashHeadIconStatus<?php echo($headicon_id) ?>" style="padding-left:0px; margin-top:15; margin-bottom:15; display:none"></div>
								<div id="displayHeadIconStatus<?php echo($headicon_id) ?>" class="displayHeadIconStatus<?php echo($headicon_id) ?>" style="padding-left:0px; width:315; display:none; background:#F5F5F5; padding:10; padding-top:20; margin-top:20; line-height:150%; font-size:13px; border:1px solid #EEEEEE"></div>								<div style="margin-top:0; padding-left:0; display:; width:320px; background:" class="commentHeadIconDiv<?php echo($loopname) ?>" id="commentHeadIconDiv<?php echo($loopname) ?>" >

<script type="text/javascript" >

$(document).ready(function() {
	$(".commentHeadIconBtn<?php echo($headicon_id) ?>").click(function() {
		var headicon_id = '<?php echo($headicon_id) ?>';
		var test = $("#contentforHeadicon<?php echo($headicon_id) ?>").val();
		var pdate = '<?php echo(date('Y-m-d')) ?>';
		var ptime = '<?php echo(date("H:i:s", time())) ?>';
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($loopname) ?>';
		var dataString = 'content='+ test+'&sender='+sender+'&recipient='+recipient+'&headicon_id='+headicon_id+'&pdate='+pdate+'&ptime='+ptime; 

		if(test==''||test=='Write here...')
		{
			alert("Please Enter Something ok?");
		}
		else
		{
			$("#flashHeadIconStatus<?php echo($headicon_id) ?>").show();
			$("#flashHeadIconStatus<?php echo($headicon_id) ?>").fadeIn(400).html('');
 
 			$.ajax({
  				type: "POST",
  				url: "ajax_reply_headicon.php",
  				data: dataString,
  				cache: false,
  				success: function(html){
  					$("#displayHeadIconStatus<?php echo($headicon_id) ?>").after(html);
  					document.getElementById('contentforHeadicon<?php echo($headicon_id) ?>').value='';
  					document.getElementById('contentforHeadicon<?php echo($headicon_id) ?>').focus();
  					$("#flashHeadIconStatus<?php echo($headicon_id) ?>").hide();
					$("#commentHeadIconDiv<?php echo($headicon_id) ?>").hide();
	  			}
 			});
 		} return false;
 	});
});
</script>
  <script>
function inputFocus(i){
    if(i.value==i.defaultValue){ i.value=""; i.style.color="#000"; }
}
function inputBlur(i){
    if(i.value==""||i.value=="Write here..."){ i.value=i.defaultValue; i.style.color="#888"; }
}
</script>
								  <textarea name="contentforHeadicon<?php echo($headicon_id) ?>" id="contentforHeadicon<?php echo($headicon_id) ?>" onclick="this.style.height = '50px'; if(this.value=='Write here...')this.value=''" style=" width:345px; border:0px solid #EEEEEE; background:#F5F5F5; height:30px; font-size:12px; font-weight:normal; font-family: Arial, Helvetica, sans-serif; margin-bottom:3px; padding:3; line-height:130%; color:#888888" onFocus="this.style.height = '50px'; this.select(); inputFocus(this)" onBlur="this.style.height = '30px'; this.value=!this.value?'Write here...':this.value; inputBlur(this)">Write here...</textarea>
							    
								<div class="commentHeadIconBtn<?php echo($headicon_id) ?>" id="commentHeadIconBtn<?php echo($headicon_id) ?>" style=" height:12; padding:1 5 1 5; background: url(img/master.jpg); display:inline; margin-top:5px; margin-bottom: ;width:60; border:1px solid #999999; font-size:11px; cursor:pointer; font:Arial, Helvetica, sans-serif;  -moz-border-radius: 3px; border-radius: 3px; color:#000000" align="center">Submit</div>  <font style="color:#999999; font-size:11px">(Comment your friends, less than 500 inputs limited)</font>							    </div></td>
                              </tr>
                            </table>
                          </div>
                          <?php 
						  	//unset($tmp_arr_loopname);
						  //}
						  array_push($arr_loopname,$loopname);
						  } } }?>
                        </td>
                      </tr>
                  </table>
				  
				  <div id='<?php echo($div_id) ?>'></div>
				  
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
xmlhttp.open("GET","PeopleList2.php?page="+str+"&limit=30",true);
xmlhttp.setRequestHeader("Content-Type","text/html;charset=utf8");
xmlhttp.send();
document.getElementById('extendBtnPeopleDiv_<?php echo($div_id) ?>').style.display = 'none';
}
</script>
<?php
//echo("next page=".$next_page);
if($next_page <= $total_pages){ 
?>
<div id="extendBtnPeopleDiv_<?php echo($div_id) ?>" class="extendBtnPeopleDiv_<?php echo($div_id) ?>" style="padding-bottom:0px; margin-bottom:0px">
<button type="button" onClick="loadXMLDoc('<?php echo($next_page) ?>','<?php echo($div_id) ?>')" style="cursor: hand; color:black; font-size:18px; background-color: #DDDDDD; border:0px; height:30; width:350px; cursor:pointer;  -moz-border-radius: 5px; border-radius: 5px;"> 
<?php if($_SESSION['lan']=="CN")echo("+ 更多动态"); else echo("+ Show More") ?>
</button>
</div>
<?php 
} 
?>