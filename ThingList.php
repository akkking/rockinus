<?php 
include 'dbconnect.php';
//include 'Allfuc.php';

//session_start();
//$uname = $_SESSION['usrname'];

$q_custom = mysql_query("SELECT * FROM rockinus.user_custom_setting WHERE uname='$uname';");
if(!$q_custom) die(mysql_error());
$object_custom = mysql_fetch_object($q_custom);
$custom_features = $object_custom->features;
$custom_ccomment = $object_custom->ccomment;
$custom_eventnews = $object_custom->eventnews;
$custom_house = $object_custom->house;
$custom_article = $object_custom->article;
$custom_examQuestion = $object_custom->examQuestion;
$custom_jobReferral = $object_custom->jobReferral;
$custom_interviewQuestion = $object_custom->interviewQuestion;

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

<?php include("smallMenu.php") ?>

<table width="630" height="115" border="0" cellpadding="0" cellspacing="0" style="margin-top:35px; margin-right:5px; margin-bottom:5px;">
                <tr>
                  <td width="577" height="85" colspan="2" valign="top" style="border-right:0 dotted #666666; border-left:0 dotted #666666">
				  <table width="630" height="85" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="630" height="85" valign="top" >
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
	SELECT count(*) as total FROM rockinus.news_info f JOIN rockinus.user_custom_setting fcustom ON fcustom.eventnews='Y' and fcustom.uname='$uname'
	UNION 
	SELECT count(*) as total FROM rockinus.interview_question l JOIN rockinus.user_custom_setting fcustom ON fcustom.interviewQuestion='Y' and fcustom.uname='$uname'
	UNION 
	SELECT count(*) as total FROM rockinus.course_question_info cqi JOIN rockinus.user_custom_setting fcustom ON fcustom.examQuestion='Y' and fcustom.uname='$uname'
) as cnt";

$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

	$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 35;
	$page= (isset($_GET["page"]))? $_GET["page"] : 1;
	if((!$limit) || (is_numeric($limit) == false)|| ($limit < 35) || ($limit > 40)) 
		$limit = 1; //default
	
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
		$page = 1; //default 

	$next_page = $page + 1;
	$div_id = "myDiv".$page;
	$total_pages = ceil($total_items / $limit);
	$set_limit = ($page * $limit) - $limit;
	
	if( $total_items==0 && $page==1 )echo("<div style='padding:10px; margin-bottom:50px; margin-top:10px; border:8px #FFFFFF solid; width:560px; font-size:24px; line-height:100%;' align=left><div align='left' style='line-height:150%;'>Hey $uname_fname, there's no updates in your network.<br>What you should do? </div><div style='-moz-border-radius: 10px; border-radius: 10px; margin-bottom:5px; margin-top:25px; padding:15px 15px 15px 20px; font-family:Georgia; width:550px; border:1px solid #DDDDDD; background:#F5F5F5'><div style='margin-top:0px; font-size:18px; width:550px; height:25px; padding:5 0 5 0; font-weight:bold; color:$_SESSION[hcolor]' align='left'><img src='img/news_32.png' width='17px' />&nbsp;&nbsp; Turn on \"My Channels\" from menu on the top!</div><div style='font-size:18px; width:550px; height:25px; padding:5 0 5 0; font-weight:bold; color:$_SESSION[hcolor]' align='left'><img src='img/people.png' width='17px' />&nbsp;&nbsp; <a href=EditUserInfo.php class=one><font style='color:$_SESSION[hcolor]'>Click here to improve your profile</font></a></div><div style='font-size:18px; width:550px; height:25px; padding:5 0 5 0; font-weight:bold; color:$_SESSION[hcolor]' align='left'><img src='img/friends.png' width='17px' />&nbsp;&nbsp; <a href=FriendGroup.php class=one><font style='color:$_SESSION[hcolor]'>Click here to find your alumnus</font></a></div></div></div>");
						
    	$arr_loopname = array();
		$tmp_arr_loopname = array();
		$sql_stmt = "SELECT email,uname, NULL as subject, status, signup_date,signup_time,tbname, NULL as col_2, NULL as col_3, NULL as col_4, NULL as col_5, NULL as col_6, NULL as col_7 
					FROM rockinus.user_check_info a
						WHERE uname in (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname'
											UNION
											SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname') AND uname <> '$uname' AND 1<>1
					UNION 
					SELECT course_uid, sender, descrip, rating, pdate, ptime, 'course_memo_info', memoid, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.course_memo_info cmi JOIN rockinus.user_custom_setting fcustom ON fcustom.ccomment='Y' and fcustom.uname='$uname'
					UNION 
					SELECT course_uid, sender, descrip, rstatus, pdate, ptime, 'course_question_info', q_id, termType, season, NULL, NULL, NULL 
					FROM rockinus.course_question_info cqi JOIN rockinus.user_custom_setting fcustom ON fcustom.examQuestion='Y' and fcustom.uname='$uname'
					UNION 
					SELECT news_id, creater, subject, descrip, pdate, ptime, 'news_info', category, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.news_info f 
						JOIN rockinus.user_custom_setting fcustom ON fcustom.eventnews='Y' and fcustom.uname='$uname'
					UNION
					SELECT q_id, creater, rstatus, descrip, pdate, ptime, 'interview_question', company, position, qdate, category, positionCategory, NULL
					FROM rockinus.interview_question iq JOIN rockinus.user_custom_setting fcustom ON fcustom.interviewQuestion='Y' and fcustom.uname='$uname'
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
						<div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:10px; padding-bottom:10px; border-bottom:1px #DDDDDD solid; background: url(); width:630px">
						  <table width="630" height="36" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="75" align="left" valign="top" style="padding-left:0;">
							  <?php
							  $pic100_Name = $loopname.'60.jpg';
				  $target = "upload/".$loopname;
				  if(is_dir($target))
				  	echo("<a href='UpdateWall.php' class='one'><div style='border:0px solid #EEEEEE'><img src=upload/$loopname/$pic100_Name?".time()." style='border:0px solid #999999' width=60></div></a>");
				  else {
//				  	$headicon_id = -1;
					echo("<a href='EditHeadIcon.php' class='one'><img src=img/NoUserIcon100.jpg style='border:0; border-top:5px solid #FFFFFF' width=60></a>");
					}
							  ?>							  </td>
                              <td height="18" align="left" valign="top" style="padding-left:5px; font-size:14px;  padding-bottom:5px; line-height:125%"><?php
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
			if($friend_tag>0) $friend_rmk = ", $subject_fname is also your friend";
			else{
				$mutual_friend_num = getMutalFriends($subject,$uname);
				if($mutual_friend_num>0) $friend_rmk = ", $subject_fname and you have ".count($mutual_friend_num)." mutual friend(s)";
			}		
				
				
				if($friend_tag == "loopname"){
					echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]><strong>$loopname_fname</strong></font></a>$hobbyTitle has a new friend - <a href=RockerDetail.php?uid=$subject class=one><font color=$_SESSION[hcolor]><strong>$subject_fname</strong></font></a>");
				}else
					echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]><strong>$loopname_fname</strong></font></a> has a new friend - <a href=RockerDetail.php?uid=$subject class=one><font color=$_SESSION[hcolor]><strong>$subject_fname</strong></font></a>$hobbyTitle");
				?>               
				<br />              
				<?php echo("<font color='#999999' style='font-size:12px'>Now $loopname_fname has $no_row_f friend(s) $friend_rmk</font>") ?>
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
						<?php 
							}else if($tbname=="course_question_info"){
								$loop_qid = $aname;
						  		$memo_c_q = mysql_query("SELECT course_id, mid, course_name FROM rockinus.course_info WHERE course_id=(SELECT course_id FROM rockinus.unique_course_info WHERE course_uid ='$id');");
								if(!$memo_c_q) die(mysql_error());
								$obj = mysql_fetch_object($memo_c_q); 
								$course_id = $obj->course_id; 
								$mid = $obj->mid;
								$course_name = $obj->course_name;
						  
						  		$mid_sql = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid='$mid';");
								if(!$mid_sql) die(mysql_error());
								$obj_m = mysql_fetch_object($mid_sql); 
								$major_name = trim($obj_m->major_name);
								
								$unique_course_sql = mysql_query("SELECT pid FROM rockinus.unique_course_info WHERE course_uid='$id';");
								if(!$unique_course_sql) die(mysql_error());
								$obj_uni = mysql_fetch_object($unique_course_sql); 
								$loop_pid = trim($obj_uni->pid);
						  ?>
<div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:10px; padding-bottom: 10px; border-bottom:1px #DDDDDD solid; width:630px">
                            <table width="630" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="75" height="78" align="left" valign="top" style="padding-left:5px; padding-top:5px"><img src="img/examPaper.png" width="60" /> </td>
                                <td width="475" align="left" valign="top" style="padding-left:5px; padding-top:3; padding-right:5px; font-size:14px; color:#999999"><?php
			echo("<a href='CourseQuestionList.php?course_uid=$id' class='one'><font color=$_SESSION[hcolor]><strong>$course_name</strong></font></a> <font style='font-size:13px'>($major_name)</font><div style='margin-top:4px'> <font style='font-size:12px' color=#000000>$city exam, $rate semester | ".getDateName($pdate).", ".substr($ptime,0,5)."</font></div>");
							  ?>
                                    <div style="margin-top:10px; margin-bottom:10px; padding-right:10px; font-size:12px">
                                      <?php 
									  if(strlen($subject)>500)
										echo(substr(addHyperLink(str_replace("\\","",$subject)),0,500)."...");
									  else
										echo(addHyperLink(str_replace("\\","",$subject)));
								?>
                                    </div>
								</td>
                              </tr>
                            </table>
					      </div>
						  <?php
							}else if($tbname=="interview_question"){
			?>
<div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:10px; padding-bottom: 10px; border-bottom:1px #DDDDDD solid; width:630px">
                            <table width="630" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="75" height="78" align="left" valign="top" style="padding-left:5px; padding-top:5px">
								<img src="img/tests.png" width="60" /> </td>
                                <td width="513" align="left" valign="top" style="padding-left:15px; padding-top:3; padding-right:5px; font-size:14px; padding-bottom:10px">
								<?php
			echo("<a href='interviewQuestionDetail.php?q_id=$id' class=one><font color=$_SESSION[hcolor]><strong>$aname</strong></font></a><br><div style='margin-top:5; font-size:12px'>".ucfirst($delivery).", $city @$rate</div>");
			echo("<div style='margin-top:5px'><font color='#999999' style='font-size:11px'>Posted ".getDateName($pdate)." | ".substr($ptime,0,5)."</font></div>");
							  ?>    
							  <div style="margin-top:10px; margin-bottom:10px; padding-right:10px; font-size:13px; color:#000000">                           
								<?php 
								if(strlen($action)>200)
									echo(substr(addHyperLink(str_replace("\\","",nl2br($action))),0,200)."... <div style='margin-top:5px'><a href='interviewQuestionDetail.php?q_id=$id' class='one'><font color=$_SESSION[hcolor]>+ Read more</font></a></div>");
								else
									echo(addHyperLink(str_replace("\\","",nl2br($action))));
								?>	
								</div>							
                                <?php 
$q1 = mysql_query("SELECT * FROM rockinus.interview_question_follow WHERE q_id='$id' ORDER BY pdate ASC, ptime ASC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row > 0){ 
	while($object = mysql_fetch_object($q1)){
		$q_follow_id = $object->q_follow_id;	
		$sender = $object->uname;	
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
	$(".deleteInterviewReplyBtn<?php echo($q_follow_id) ?>").click(function() {
		var q_follow_id = <?php echo($q_follow_id) ?>;
		var dataString = 'q_follow_id='+q_follow_id; 

		if(q_follow_id=='')
		{
			alert("not getting interview question id!");
		}
		else
		{
			$("#flashDeleteInterviewReply<?php echo($q_follow_id) ?>").show();
 			$("#flashDeleteInterviewReply<?php echo($q_follow_id) ?>").fadeIn(400).html('');
 
			$.ajax({
 				type: "POST",
				url: "ajax_delete_interview_question.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#deleteInterviewReplyResult<?php echo($q_follow_id) ?>").after(html);
					$("#flashDeleteInterviewReply<?php echo($q_follow_id) ?>").hide();
					$("#interviewReplyDiv<?php echo($q_follow_id) ?>").hide();
				}
			});
		} return false;
 	});
 });
                                </script>
							  
								  <div style="margin-bottom:5px; margin-top:5px; width: 530px;" align="left" class="interviewReplyDiv<?php echo($memofid) ?>" id="interviewReplyDiv<?php echo($q_follow_id) ?>">
                                    <table width="530" height="45" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-bottom:0px solid #DDDDDD;">
                                      <tr>
                                        <td width="241" height="20" align="left" valign="top" bgcolor="#F5F5F5" style="padding-left:5; font-size:12px; padding-top:5"><?php echo("<strong> <a href=RockerDetail.php?uid=$sender class=one><FONT color=$_SESSION[hcolor]>$sender_fname $sender_lname</font></a></strong>") ?> </td>
                                        <td width="115" height="20" align="center" valign="top" bgcolor="#F5F5F5" style="padding-top:7; font-size:12px">
										<?php if($sender==$uname){ ?>
										<div class="deleteInterviewReplyBtn<?php echo("$q_follow_id"); ?>" id="deleteInterviewReplyBtn<?php echo("$q_follow_id"); ?>" style="height:10; padding:1 4 1 4; border:0px solid #DDDDDD; font-size:10px; color:<?php echo($_SESSION['hcolor']) ?>; display:inline; cursor:pointer">Delete</div>
										<?php } ?>										</td>
                                        <td width="104" height="20" align="right" valign="top" bgcolor="#F5F5F5" style="font-size:11px; padding-right:5; color:#666666; padding-top:5"><?php echo(getDateName($reply_pdate)) ?> | <?php echo(substr($reply_ptime,0,5)) ?> </td>
                                      </tr>
                                      <tr>
                                        <td height="20" colspan="3" valign="top" style="line-height:120%; font-size:12px; padding:5">
										<?php
													if(strlen($descrip)>500){
														echo("<a href=interviewQuestionDetail.php?q_id=$id class=one>");
														echo(substr($descrip,0,500)." ...<br>");
														echo("</a>");
													}else
														echo($descrip);
												?>										</td>
									  </tr>
                                    </table>
                                  </div>
								  <div class="flashDeleteInterviewReply<?php echo($q_follow_id) ?>" id="flashDeleteInterviewReply<?php echo($q_follow_id) ?>"></div>
								  <div class="deleteInterviewReplyResult<?php echo($q_follow_id) ?>" id="deleteInterviewReplyResult<?php echo($q_follow_id) ?>" style="width:530px"></div>
								  <?php }}?>
                                  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js">
                                  </script>
                                  <script type="text/javascript" >
 $(function() {
 $(".commentInterviewSubmitBtn<?php echo($id) ?>").click(function() {
var test = $("#contentInterviewQuestion<?php echo($id) ?>").val();
var q_id = <?php echo($id) ?>;
var pdate = '<?php echo(date('Y-m-d')) ?>';
var ptime = '<?php echo(date("H:i:s", time())) ?>';
var sender = '<?php echo($uname) ?>';
var dataString = 'content='+ test+'&q_id='+q_id+'&sender='+sender+'&pdate='+pdate+'&ptime='+ptime; 

if(test==''||test=='Write here...')
{
 alert("Please Enter Some Text");
}
else
{
 $("#flashInterviewMemo<?php echo($id) ?>").show();
 $("#flashInterviewMemo<?php echo($id) ?>").fadeIn(400).html('');
 
 $.ajax({
  type: "POST",
  url: "ajax_insert_interview_memo.php",
  data: dataString,
  cache: false,
  success: function(html){
  $("#displayInterviewMemo<?php echo($id) ?>").after(html);
  document.getElementById('contentInterviewQuestion<?php echo($id) ?>').value='';
  document.getElementById('contentInterviewQuestion<?php echo($id) ?>').focus();
  $("#flashInterviewMemo<?php echo($id) ?>").hide();
  $("#commentInterviewQuestionDiv<?php echo($id) ?>").hide();
  $("#commentInterviewSubmitBtn<?php echo($id) ?>").show();
  }
 });
 } return false;
 });
 });
                                  </script>
                                  <div id="flashInterviewMemo<?php echo($id) ?>" class="flashInterviewMemo<?php echo($id) ?>" style="padding-left:10px"></div>
                                  <div id="displayInterviewMemo<?php echo($id) ?>" class="displayInterviewMemo<?php echo($id) ?>" style="padding-left:10px"></div>
                                  <div class="commentInterviewQuestionDiv<?php echo($id) ?>" id="commentInterviewQuestionDiv<?php echo($id) ?>" style="margin-top:5; width:530px">
                                    <textarea name="contentInterviewQuestion<?php echo($id) ?>" id="contentInterviewQuestion<?php echo($id) ?>" rows="4" style="border:1px #DDDDDD solid; width:520px; margin-bottom:5px; height:40px; font-family:Arial, Helvetica, sans-serif; font-size:12px; padding:4px; line-height:130%; padding:4px; color:#888888" onclick="this.style.height = '60px'; if(this.value=='Write here...')this.value=''" onFocus="this.style.height = '60px'; this.select(); inputFocus(this)" onBlur="this.style.height = '40px'; this.value=!this.value?'Write here...':this.value; inputBlur(this)">Write here...</textarea>
                                    <br />
                                <div class="commentInterviewSubmitBtn<?php echo($id) ?>" id="commentInterviewSubmitBtn<?php echo($id) ?>" style=" height:15px; padding:2px 5px 2px 5px; background: url(img/master.jpg); display:inline; margin-top:5px; width:60px; border:1px solid #999999; font-size:11px; cursor:pointer; color:#000000" align="center">Submit</div>   
                                <font style="font-size:11px; color:#999999">(Less than 5000 letters)</font>                                
								</div>
								</td>
                              </tr>
                            </table>
                          </div>
                          <?php 
							}else if($tbname=="house_info"){
							?>
                            <div style="margin-top:5; margin-bottom:5px; padding-left:0; padding-top:15; padding-bottom:15; border-bottom:1px #DDDDDD solid; width:630px">
                              <table width="630" height="105" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td width="27" rowspan="3" align="left" bgcolor="#FFFFFF" style="padding:5px; padding-right:5px" valign="top">
								  <?php 
			$target = "upload/h".$id;
			if(is_dir($target)){
				echo("<a href=HouseDetail.php?hid=$id class=one><img src=upload/h$id/1_100.jpg style=border:0 width='70px'></a>");
			}else 				  		
				echo("<a href=HouseDetail.php?hid=$id class=one><img src=img/NoHouse100_gray.jpg style=border:0 width='70px'></a>");
			?></td>
                                  <td width="413" height="30" align="left" style="padding-left:15px"><?php 
										  echo("<a href=HouseDetail.php?hid=$id class=one><strong>".substr($subject,0,45)." ...</strong></a>");
							  ?>                                  </td>
                                  <td width="132" height="30" align="right" style="padding-right:5px; font-size:12px">
                                    <?php 
										  echo(getDateName($pdate)." | ".substr($ptime,0,5));
							  ?>                                  </td>
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
                                  <td height="30" colspan="2" align="left" style="display:inline; padding-left:15px; padding-top:5px; padding-bottom:5px; font-size:14px; line-height:150%"><?php
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
                                      <div style="line-height:180%; margin-top:10px; width: 510px;">
                                        <table width="510" height="63" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5">
                                          <tr>
                                            <td width="265" height="25" align="left" bgcolor="#F5F5F5" style=" color:<?php echo($_SESSION['hcolor'])?>; padding:8">
<script language="JavaScript" type="text/javascript">
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
                                            <td width="255" height="25" align="right" bgcolor="#F5F5F5" style="padding:8">
											<font size="1"><?php echo($pdate) ?> | <?php echo($ptime) ?></font> </td>
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
							<div style="margin-top:0px; margin-bottom:5px; padding-left:0; padding-top:5; padding-bottom:5; border-bottom:1px #DDDDDD solid; width:630px">
							  <table width="630" height="90" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td width="30" rowspan="3" align="left" bgcolor="#FFFFFF" valign="top" style="padding-left:5px; padding-top:5px"><?php 
			$target = "upload/a".$id;
			if(is_dir($target)){
				echo("<a href=ArticleDetail.php?aid=$id class=one><img src=upload/a$id/1_100.jpg style=border:0 width='70px'></a>");
			}else 				  		
				echo("<a href=ArticleDetail.php?aid=$id class=one><img src=img/noarticle_gray100.jpg style=border:0 width='70px'></a>");
			?>
                                  </td>
                                  <td width="499" height="25" align="left" valign="middle" style="display:inline; padding-left:15px; border-bottom:0px #BBBBBB dotted; font-size:13px; font-family:Arial, Helvetica, sans-serif; color:<?php echo($_SESSION['hcolor'])?>"><?php 
										  echo("<a href=ArticleDetail.php?aid=$id class=one><strong>".substr($subject,0,50)." ...</strong></a>");
							  ?>                                  </td>
                                  <td width="121" height="25" align="right" valign="middle" style="display:inline; padding-right:5px; border-bottom:0px #BBBBBB dotted; font-size:12px">
								  <?php echo(getDateName($pdate)." | ".substr($ptime,0,5))?>								  </td>
                                </tr>
                                <tr>
                                  <td height="25" align="left" style="display:inline; padding-left:15px; padding-top:0; font-size:12px;color:#999999" valign="top">
			<?php
				echo("<font color=$_SESSION[hcolor]>$aname | $action | $city");	
				if($delivery=='N') echo(" | $$rate | Self take");
				if($delivery=='Y') echo(" | $$rate | Can bring to you");
				?>
				</td>
                                  <td height="25" align="right" style="display:inline; padding-right:10px" valign="top"></td>
                                </tr>
                                <tr>
                                  <td height="30" colspan="2" align="left" style="display:inline; padding-left:15px; padding-top:0; font-size:13px; line-height:120%" valign="top"><?php
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
	$descrip = str_replace("\\","",nl2br($descrip));
	$descrip = $object->descrip;
	$ptime = $object->ptime;
	$pdate = $object->pdate; 
?>
                                      <div style="line-height:180%; margin-top:10px; width: 510px;">
                                        <table width="510" height="63" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5">
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
						  		$loop_memoid = $aname;
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
								$major_name = trim($obj_m->major_name);
								
								$unique_course_sql = mysql_query("SELECT pid FROM rockinus.unique_course_info WHERE course_uid='$id';");
								if(!$unique_course_sql) die(mysql_error());
								$obj_uni = mysql_fetch_object($unique_course_sql); 
								$loop_pid = trim($obj_uni->pid); 	
						  ?>
						  <div style="margin-top:0; margin-bottom:0; padding-left:0; padding-top:10; padding-bottom:5; border-bottom:1px #DDDDDD solid; width:630px">
						    <table width="630" height="105" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="70" align="left" valign="top" style="padding-top:0px; padding-left:5px">
								<img src="img/Messages_Green.png" width="60" /></strong></font></td>
                                <td width="560" align="left" valign="top" style="padding-left:20px; font-size:14px; line-height:130%; padding-top:0px">
								<?php
							  	echo("<a href='CourseDetail.php?course_uid=$id' class=one><font color=$_SESSION[hcolor]><strong>$course_id - $course_name</strong></font></a>"); 
							  ?><br />
								<?php
							  	echo("<font style='font-size:11px'><a href=CourseDetail.php?course_uid=$id class=one><font color=$_SESSION[hcolor]><strong></strong></font></a>$loop_pid</font> <font color='#666666' style='font-size:12px'>($major_name)</font>");
							  ?><br />
								<font color="#999999" style="font-size:11px">
								<?php echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?>								
								</font>
                                <script>
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
								<br />
								<div style="margin-top:10px">
								<?php 
								  echo("<font style='font-size:12px'>$subject</font> ");
							  ?> 
							  <?php 
								for($i=0;$i<$action;$i++){
									if($i==0) 
										echo("<div style='margin-top:5px'><font style='font-size:12px; font-weight:bold'>Rating: &nbsp;</font>");
										echo("<img src=img/yellowstar.jpg width='12px'/> "); 
									if($i==($action-1)) 
										echo("</div>");
								}
									?>              
								</div>
				                <div class="flashCourseComment<?php echo($loop_memoid) ?>" id="flashCourseComment<?php echo($loop_memoid) ?>" style="margin-top:10"></div>
				                <div class="commentCourseResult<?php echo($loop_memoid) ?>" id="commentCourseResult<?php echo($loop_memoid) ?>" style=" font-size:13px; margin-top:15; margin-bottom:5;"></div>
				                <div class="commentCourseBtn<?php echo($loop_memoid) ?>" id="commentCourseBtn<?php echo($loop_memoid) ?>" style=" height:15; padding:0 5 2 5; background: url(img/master.jpg); display:; margin-top:15;  margin-bottom:10; width:90; border:1px solid #666666; border-top:1px solid #DDDDDD; border-left:1px solid #DDDDDD; font-size:11px; cursor:pointer" align="center">Let me comment</div>				                <div class="commentCourseDiv<?php echo($loop_memoid) ?>" id="commentCourseDiv<?php echo($loop_memoid) ?>" style="width:450px; margin-top:15; margin-bottom:10; display:none">
							  <textarea id="commentTextarea<?php echo($loop_memoid) ?>" class="commentTextarea<?php echo($loop_memoid) ?>" style="border:1px solid #DDDDDD; height:90; width:450px; font-size:13px; font-family:Arial, Helvetica, sans-serif; margin-bottom:15"></textarea>

					<div style="margin-bottom:8px; margin-top:">
					<input type="checkbox" name="anony_yesno" id="anony_yesno<?php echo($loop_memoid) ?>" class="anony_yesno<?php echo($loop_memoid) ?>" value="Y" />&nbsp; <font style=" font-size:12px">Anonymous</font> &nbsp;&nbsp;&nbsp;&nbsp;
							  <input type="radio" name="rating" value="5" />
                              <img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" />&nbsp;&nbsp;
                              <input type="radio" name="rating" value="4" />
                              <img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" />&nbsp;&nbsp;
                              <input type="radio" name="rating" value="3" />
                              <img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" />&nbsp;&nbsp;
                              <input type="radio" name="rating" value="2" />
                              <img src="img/yellowstar.jpg" width="13" /><img src="img/yellowstar.jpg" width="13" />&nbsp;&nbsp;
                              <input type="radio" name="rating" value="1" />
                          <img src="img/yellowstar.jpg" width="13" />							
						  </div>  
						  <div class="commentSubmitBtn<?php echo($loop_memoid) ?>" id="commentSubmitBtn<?php echo($loop_memoid) ?>" style=" height:15px; padding:2 5 2 5; background: url(img/black_cell_bg.jpg); display:inline; margin-top:15; width:60; border:1px solid #333333; font-size:11px; cursor:pointer; color:#FFFFFF" align="center">Submit</div> 
							  <div class="commentCancelBtn<?php echo($loop_memoid) ?>" id="commentCancelBtn<?php echo($loop_memoid) ?>" style=" height:15px; padding:2 5 2 5; background: url(img/master.png); display:inline; margin-top:15; width:70; border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; font-size:11px; cursor:pointer" align="center">Next time</div>  
						  </div></td>
                              </tr>
                            </table>
						  </div>
						  <?php }else if($tbname=="news_info"){  
						  $q_sender = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$loopname'");
				if(!$q_sender) die(mysql_error());
				$object = mysql_fetch_object($q_sender);
				$loopname_fname = $object->fname;
				$loopname_lname = $object->lname;
						  ?>
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
						  <div style="margin-top:0; margin-bottom:0; padding-left:0; padding-top:10; padding-bottom:10; border-bottom:1px #DDDDDD solid">
						    <table width="630" height="43" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="75" rowspan="2" bgcolor="#FFFFFF" valign="top" style="padding-left:5px; padding-top:5px"><img src="img/poster.png" width="55" /></strong></font></td>
                                <td width="440" rowspan="2" valign="top" style="padding-left:5px; padding-top:2px; font-size:13px; color:<?php echo($_SESSION['hcolor']) ?>; font-weight:normal; line-height:150%">
								<span class="showFriendNewsDiv_<?php echo($id) ?>" id="showFriendNewsDiv_<?php echo($id) ?>" style="cursor:pointer; font-size:14px"><strong><?php echo("$subject") ?></strong></span>
								<span class="hideFriendNewsDiv_<?php echo($id) ?>" id="hideFriendNewsDiv_<?php echo($id) ?>" style="display:none; cursor:pointer; font-size:14px"><strong><?php echo("$subject") ?></strong></span><br />								
							<font color="#999999" style="font-size:12px">Notice Category: <?php echo(ucfirst($aname)) ?></font><br />
								<font color="#999999" style="font-size:11px">Posted by <?php echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=#999999>$loopname_fname $loopname_lname</font></a> | ".getDateName($pdate).", ".substr($ptime,0,5)) ?></font>
								<div class="FriendNewsDiv_<?php echo($id) ?>" id="FriendNewsDiv_<?php echo($id) ?>" style="width:350px; line-height:140%; font-size:12px; font-family:Arial, Helvetica, sans-serif; margin-top:10; color:#000000; margin-bottom:5; display:none; padding-left:0px">
								<?php echo(addHyperLink(nl2br($action))) ?>								</div></td>
                                <td width="35" height="20" align="right" style="padding-right:5px; padding-top:; font-size:11px" valign="top">
								<a href="SendMessage.php?recipient=<?php echo($loopname) ?>">
                                  <img src="img/littleMessageIcon.jpg" width="18" />
                                </a> </td>
                              </tr>
                              <tr>
                                <td height="18" valign="top" style="padding-left:10px; padding-bottom:5px; font-size:11px; font-weight:normal">&nbsp;</td>
                              </tr>
                            </table>
						  </div>
                          <?php }else if($tbname=="headicon_history_"){  
						  //echo("---$loopname<br>");
						  if(!in_array($loopname,$arr_loopname)){
						  	//array_push($tmp_arr_loopname,$loopname);
						  	//if(count($tmp_arr_loopname)==2){
							//$loopname1 = $tmp_arr_loopname[0];
							//$loopname2 = $tmp_arr_loopname[1];
						  ?>
                          <?php 
						  	//unset($tmp_arr_loopname);
						  //}
						  array_push($arr_loopname,$loopname);
						  } } }?>
                        </td>
                      </tr>
                  </table>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
function loadXMLDocs(str,div_id)
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
	xmlhttp.open("GET","ThingList2.php?page="+str+"&limit=35",false);
	xmlhttp.setRequestHeader("Content-Type","text/html;charset=utf8");
	xmlhttp.send();
	document.getElementById('extendBtnDiv_<?php echo($div_id) ?>').style.display = 'none';
}
</script>
<?php
//echo("next page=".$next_page);
if($next_page <= $total_pages){ 
?>
<div id="extendBtnDiv_<?php echo($div_id) ?>" class="extendBtnDiv_<?php echo($div_id) ?>" style="padding-bottom:0px; margin-bottom:0px">
<button type="button" onClick="loadXMLDocs('<?php echo($next_page) ?>','<?php echo($div_id) ?>')" style="cursor: hand; color:black; font-size:18px; background-color: #DDDDDD; border:0px; height:30; width:630px; cursor:pointer; -moz-border-radius: 5px; border-radius: 5px;"> 
<?php if($_SESSION['lan']=="CN")echo("+ 更多动态"); else echo("+ Show More") ?>
</button>
</div>
<?php 
} 
?>
<div id=<?php echo($div_id) ?>></div>
</td>
</tr>
</table> 
