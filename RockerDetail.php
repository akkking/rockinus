<?php 
include 'mainHeader.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];
?>
<style type="text/css">
<!--
.STYLE2 {color: #336633}
-->
</style>
<style type="text/css">
#load{
position:absolute;
z-index:1;
border:4px solid #DDDDDD;
background: #F5F5F5;
color:#FFFFFF;
width:250px;
padding-top:15px;
padding-bottom:15px;
margin-top:-150px;
margin-left:-150px;
top:50%;
left:50%;
text-align:center;
line-height:500px;
font-family:"Trebuchet MS", verdana, arial,tahoma;
font-size:14pt;
}
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>

<div align="center" style="margin-top:0px">
<table width="1024" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
  <tr>
    <td width="779" align="left" valign="top" style="padding-left:10px; padding-top:15px">
	<?php 
if(isset($_SESSION['rst_msg'])) {
	echo($_SESSION['rst_msg']);
	unset($_SESSION['rst_msg']);
}
?>


    <?php
if(isset($_GET['uid']) && strlen(trim($_GET['uid']))>0 ) $uid = $_GET['uid'];
else header("location:ThingsRock.php");

$rel_rstatus = "N";
if($uid==$uname)$rel_rstatus ="S";
else{
	$q11 = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE (sender='$uid' AND recipient='$uname') OR (recipient='$uid' AND sender='$uname')");
	if(!$q11) die(mysql_error());
	$no_row_A = mysql_num_rows($q11);
	if($no_row_A>0)$rel_rstatus='A';
	
	$q21 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uid' AND recipient='$uname' AND rstatus='P'");
	if(!$q21) die(mysql_error());
	$no_row_P = mysql_num_rows($q21);
	if($no_row_P>0)$rel_rstatus='X';
	
	$q22 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uname' AND recipient='$uid' AND rstatus='P'");
	if(!$q22) die(mysql_error());
	$no_row_X = mysql_num_rows($q22);
	if($no_row_X>0)$rel_rstatus='P';	
}

if( ($uid!=$uname) && (strlen(trim($uid))>0) && (strlen(trim($uname))>0) ){
	$result = mysql_query("INSERT INTO rockinus.visit_history(visitor, host, vdate, vtime) VALUES('$uname','$uid',CURDATE(),NOW())");
	if (!$result) die('Invalid query: ' . mysql_error());

	$q_v = mysql_query("SELECT * FROM rockinus.visit_info WHERE visitor='$uname' AND host='$uid';");
	if(!$q_v) die(mysql_error());
	$no_row_visit = mysql_num_rows($q_v);

	if($no_row_visit>0){
		$q_vi = mysql_query("UPDATE rockinus.visit_info SET vdate=CURDATE(), vtime=NOW() WHERE visitor='$uname' AND host='$uid';");
		if(!$q_vi) die(mysql_error());
	}else{
		$sql = "INSERT INTO rockinus.visit_info(visitor, host, vdate, vtime) VALUES('$uname','$uid',CURDATE(),NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
	}
}

$headicon_id = 0;

$target = "upload/".$uid;
if(!is_dir($target))$headicon_id = -1;
else{
	$q_h_t = mysql_query("SELECT headicon_id FROM rockinus.headicon_history WHERE uname='$uid'");
	if(!$q_h_t) die(mysql_error());
	$no_row_h_t = mysql_num_rows($q_h_t);
	if($no_row_h_t == 0){
		$result = mysql_query("INSERT INTO rockinus.headicon_history(uname,pdate,ptime)VALUES('$uid',CURDATE(), NOW())");
		if (!$result) die('Invalid query: ' . mysql_error());
	}

	$q_h_t2 = mysql_query("SELECT headicon_id FROM rockinus.headicon_history WHERE uname='$uid' ORDER BY headicon_id DESC");
	if(!$q_h_t2) die(mysql_error());	
	$obj_q_h_t2 = mysql_fetch_object($q_h_t2);
	$headicon_id = $obj_q_h_t2->headicon_id;
}

$q_uid = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$uid'");
if(!$q_uid) die(mysql_error());
$object_uid = mysql_fetch_object($q_uid);
$uid_fname = $object_uid->fname;
$uid_lname = $object_uid->lname;

$wid = ProfileProgress($uid);

$total_profile=2;
if($wid<50) $total_profile=2;
else if($wid>=50&&$wid<85) $total_profile=5;
else if($wid>=85) $total_profile=10;

$t_headicon = mysql_query("SELECT count(*) as cnt FROM rockinus.headicon_history WHERE uname='$uid'");
$a_headicon = mysql_fetch_object($t_headicon);
$total_headicon = $a_headicon->cnt;

$t_message = mysql_query("SELECT count(*) as cnt FROM rockinus.message_info where sender='$uid'");
$a_message = mysql_fetch_object($t_message);
$total_message = $a_message->cnt;

// calculate friend number, display by mutual friends at first then other friends. Put friends to array
$t_friend = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE sender='$uid' OR recipient='$uid'");
if(!$t_friend) die(mysql_error());
$total_friend = mysql_num_rows($t_friend);
	
$show_friend_arr = array();
if($total_friend>7){
	$mutual_friend_total = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE 
										sender='$uid' AND recipient<>'$uname' AND recipient=
										(
										 SELECT sender FROM rockinus.rocker_rel_info WHERE recipient='uname'
										 UNION
										 SELECT recipient FROM rockinus.rocker_rel_info WHERE sender='uname'
										)
										UNION
										SELECT * FROM rockinus.rocker_rel_info WHERE 
										recipient='$uid' AND sender<>'$uname' AND sender=
										(
										 SELECT sender FROM rockinus.rocker_rel_info WHERE recipient='uname'
										 UNION
										 SELECT recipient FROM rockinus.rocker_rel_info WHERE sender='uname'
										)
										");
	if(!$mutual_friend_total) die(mysql_error());
	$mutual_friend_num = mysql_num_rows($mutual_friend_total);
				
	while($obj_mutual = mysql_fetch_object($mutual_friend_total)){
		$mutual_sender = $obj_mutual->sender;
		$mutual_recipient = $obj_mutual->recipient;
		if($mutual_sender!=$uid)
			array_push($show_friend_arr,$mutual_sender);
		else
			array_push($show_friend_arr,$mutual_recipient);
		if(count($show_friend_arr)==7) break;
	}
				
	if(count($show_friend_arr)<7){				
		$t_friend_2 = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE sender='$uid' OR recipient='$uid'");
		if(!$t_friend_2) die(mysql_error());
		$k = 0;
		while($obj_friend_2 = mysql_fetch_object($t_friend_2)){
			$_sender = $obj_friend_2->sender;
			$_recipient = $obj_friend_2->recipient;
			$k++;
			
			if($_sender!=$uid&&!in_array($_sender,$show_friend_arr))
				array_push($show_friend_arr,$_sender);
			
			if($_recipient!=$uid&&!in_array($_recipient,$show_friend_arr))
				array_push($show_friend_arr,$_recipient);
			
			if( $k + count(mutual_friend_arr) == 7) break;
		}
	}
}else{
	while($obj_friend = mysql_fetch_object($t_friend)){
		$friend_sender = $obj_friend->sender;
		$friend_recipient = $obj_friend->recipient;
		if($friend_sender!=$uid)
			array_push($show_friend_arr,$friend_sender);
		else
			array_push($show_friend_arr,$friend_recipient);
		if(count($show_friend_arr)==7) break;
	}
}

$t_course_subs = mysql_query("SELECT * FROM rockinus.user_course_info WHERE uname='$uid';");
if(!$t_course_subs) die(mysql_error());
$total_course_subs = mysql_num_rows($t_course_subs);

$q_course_file = mysql_query("SELECT a.*, b.course_id, b.pid, c.course_name FROM rockinus.user_file_info a JOIN rockinus.unique_course_info b JOIN rockinus.course_info c ON a.owner='$uid' AND a.course_uid=b.course_uid AND c.course_id=b.course_id GROUP BY a.course_uid");
if(!$q_course_file) die(mysql_error());
$total_course_file = mysql_num_rows($q_course_file);
		
$t_login = mysql_query("SELECT count(*) as cnt FROM rockinus.user_log_info where uname='$uid' AND flag=0");
$a_login = mysql_fetch_object($t_login);
$total_login_times = $a_login->cnt;

$t_course_memo = mysql_query("SELECT count(*) as cnt FROM rockinus.course_memo_info where sender='$uid'");
$a_course_memo = mysql_fetch_object($t_course_memo);
$total_course_memo = $a_course_memo->cnt;

$t_memo = mysql_query("SELECT count(*) as cnt FROM rockinus.memo_info where sender='$uid' AND descrip<>NULL AND descrip<>''");
$a_memo = mysql_fetch_object($t_memo);
$total_memo = $a_memo->cnt;

$t_news = mysql_query("SELECT count(*) as cnt FROM rockinus.news_info where creater='$uid'");
$a_news = mysql_fetch_object($t_news);
$total_news = $a_news->cnt;

$t_house = mysql_query("SELECT count(*) as cnt FROM rockinus.house_info where uname='$uid'");
$a_house = mysql_fetch_object($t_house);
$total_house = $a_house->cnt;

$t_article = mysql_query("SELECT count(*) as cnt FROM rockinus.article_info where uname='$uid'");
$a_article = mysql_fetch_object($t_article);
$total_article = $a_article->cnt;

$t_visit_user = mysql_query("SELECT * FROM rockinus.visit_info WHERE visitor='$uid' ORDER BY vdate DESC, vtime DESC;");
if(!$t_visit_user) die(mysql_error());
$total_visit_user = mysql_num_rows($t_visit_user);
				
$t_visit_times = mysql_query("SELECT * FROM rockinus.visit_history WHERE visitor='$uid' ORDER BY vdate DESC, vtime DESC;");
if(!$t_visit_times) die(mysql_error());
$total_visit_times = mysql_num_rows($t_visit_times);

$total_point = $total_profile + $total_headicon*15 + $total_visit_user*2 + $total_article*10 + $total_house*10 + $total_message*5 + $total_news*10 + $total_memo*5 + $total_course_file*15 + $total_course_memo*4 + $total_course_subs*5 + $total_login_times*2 + $total_friend*4 ;       

$token_full = 0;
$token_half = 0;
$token_empty = 0;

$token="star";
$cal_unit=100;

if($total_point>=500&&$total_point<2500){
	$cal_unit=500;
	$token = "diamond";
}else if($total_point>=2500){
	$cal_unit=1000;
	$token = "gold";
}

if(($token=="star"&&$total_point<100) || ($token=="diamond"&&$total_point<1000) || ($token=="gold"&&$total_point<2500)) $token_full=0;
else $token_full = floor($total_point/$cal_unit);
//echo("$token<br>$token_full<br>$total_point<br>");

if($total_point%$cal_unit>0) {
	$token_half=1;
	$token_empty=5-$token_half-$token_full;
}else{
	$token_half=0;
	$token_empty=5-$token_full;
}

if($uid==$uname){
	$reply = mysql_query("SELECT count(*) as cnt FROM rockinus.memo_follow_info WHERE memoid in (SELECT memoid FROM rockinus.memo_info WHERE sender='$uname') AND rstatus = 'N'");
	if(!$reply)	die("Error quering the Database: " . mysql_error());
	$reply_obj = mysql_fetch_object($reply);
	$reply_cnt = $reply_obj->cnt;
}

$q = mysql_query("SELECT * FROM rockinus.user_info INNER JOIN rockinus.user_check_info INNER JOIN rockinus.user_edu_info INNER JOIN rockinus.user_contact_info ON user_info.uname='$uid' AND user_info.uname=user_check_info.uname AND user_info.uname=user_edu_info.uname AND user_info.uname=user_contact_info.uname");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;
$fname = $object->fname;
if($fname==NULL || strlen(trim($fname))==0) $fname=$uid;
$lname = $object->lname;
$birthdate = $object->birthdate;
if($birthdate!=NULL && strlen(trim($birthdate))==10 )$birthdate = substr($birthdate,5,5);
else $birthdate = "Unknown";
$sterm = $object->sterm;
$fregion = $object->fregion;
$fcountry = $object->fcountry;
if(trim($fcountry)=="empty")$fcountry="Unknown country";
if(trim($fregion)=="empty")$fregion="Unknown city";
$email = $object->email;
$cmajor = $object->cmajor;
if(trim($cmajor)=="empty") $cmajor=NULL;
$cschool = $object->cschool;
if(trim($cschool)=="empty") $cschool=NULL;
$cdegree = $object->cdegree;
if(trim($cdegree)=="empty") $cdegree="Unknown degree";
$cstate = $object->cstate;
$ccity = $object->ccity;
$icon_gender = $object->gender;
if($icon_gender=='Female')$tmp_gender="her";
else $tmp_gender="his";

if($cschool!=NULL){
	$q = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
	if(!$q) die(mysql_error());
	$obj = mysql_fetch_object($q);
	$cschool = $obj->school_name;
}else $cschool = "Unknown which school";

if($cmajor!=NULL && trim($cmajor)!="empty"){
	$m = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid='$cmajor'");
	if(!$m) die(mysql_error());
	$objm = mysql_fetch_object($m);
	$major_name = $objm->major_name;	
}else $major_name = "Unknown which major";

if($ccity==NULL || $ccity=="empty" ) $ccity = "Unknown city";
if($cstate==NULL || $cstate=="em" ) $cstate = "Unknown State";
if($cdegree==NULL) $cdegree = "Unknown which degree";
if($mstatus==NULL) $mstatus = "Unknown status";
?>
	<table width="740" height="116" border="0" cellpadding="0" cellspacing="0" style=" margin-top:5; margin-bottom:20">
	  <tr>
	    <td width="250" valign="top" style="padding-bottom:15">
	      <?php 
			$pic100_Name = $uid.'250.jpg';
				  $target = "upload/".$uid;
				  if(is_dir($target))
				  echo("<img src=upload/$uid/$pic100_Name?".time()." style=border:0>");
				  else {
				  	$headicon_id = -1;
					echo("<img src=img/NoUserIcon250.jpg style=border:0 width=230>");
			}?>		
	      
	      <div style="margin-top:10; padding-left:5; padding-top:10; width:240; background: ; border-top:0px dashed #CCCCCC;">
	        <script type="text/javascript">
$(function() {
	$(".likeBtn").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($uid) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#likeBtn").hide();
		$("#flashLikeDiv").show();
		$("#flashLikeDiv").fadeIn(400).html('<img src="img/loading42.gif" width="100" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_like_headicon.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashLikeDiv").hide();
				$("#likeResult").html(html);
				$("#likeResult").show();
			}
 		});
 		return false;
 	});
 });
    </script>
  <?php
$q_m = mysql_query("SELECT headicon_id FROM rockinus.headicon_history WHERE uname='$uid' ORDER BY headicon_id DESC");
if(!$q_m) die(mysql_error());
$no_row = mysql_num_rows($q_m);
if($no_row == 0) ;
//echo("Error, head icon not found");
else{
	$object = mysql_fetch_object($q_m);
	$headicon_id = $object->headicon_id;
}

$like_uname_list=NULL;	
$q_like_headicon_list = mysql_query("SELECT * FROM rockinus.headicon_like WHERE headicon_id='$headicon_id'");
if(!$q_like_headicon_list) die(mysql_error());
//echo("SELECT * FROM rockinus.headicon_like WHERE headicon_id='$headicon_id'");
$no_row_headicon_list = mysql_num_rows($q_like_headicon_list);
if($no_row_headicon_list == 0 && $headicon_id!=-1){
	$like_uname_list = "<font color='#999999' style='font-size:11px'>(Chance to be No.1 liker)</font>";
}else if($headicon_id==-1){
	$like_uname_list = "<font color='#999999' style='font-size:11px'>(Ask $uid_fname to upload a picture)</font>";
}else{
	$like_uname_seq = 1;
	$like_uname_list = "<div style='margin-bottom:5; margin-top:5'>So far $no_row_headicon_list people like this icon: </div>";
	while($object_headicon_list = mysql_fetch_object($q_like_headicon_list)){
		$like_uname = $object_headicon_list->uname;
		$q_like_uname = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$like_uname'");
		if(!$q_like_uname) die(mysql_error());
		$object_like_uname = mysql_fetch_object($q_like_uname);
		$like_fname = $object_like_uname->fname;
		$like_lname = $object_like_uname->lname;
		
		if($like_uname_seq==1) $like_uname_list .= "<a href='RockerDetail.php?uname=$like_uname' class=one><font color=$_SESSION[hcolor]>$like_fname $like_lname</font></a>";
		else $like_uname_list .= ", <a href='RockerDetail.php?uname=$like_uname' class=one><font color=$_SESSION[hcolor]>$like_fname $like_lname</font></a>";
		
		$like_uname_seq++;
	}
}

$q_like_headicon = mysql_query("SELECT * FROM rockinus.headicon_like WHERE uname='$uname' AND headicon_id='$headicon_id'");
if(!$q_like_headicon) die(mysql_error());
$no_row_headicon = mysql_num_rows($q_like_headicon);
if($headicon_id == -1){
?>
  <div style='background-image:; background: ; margin-bottom:0; display:inline; border:0px #DDDDDD solid; height:15px; color:#000000; font-weight:bold; font-size:14px'>I haven't uploaded an icon</div>
  <?php
}else if($no_row_headicon == 0){
?>
	        <div class="likeBtn" id="likeBtn" style=" height:20; padding:3 8 3 8; background: url(img/master.jpg); display:inline; margin-bottom:5; border:1px solid #999999; font-size:11px; cursor:pointer; color:#000000; -moz-border-radius: 3px; border-radius: 3px;"><img src="img/headicon_like.png" width="10" />&nbsp;&nbsp;Click if you like <?php echo($tmp_gender)?> icon</div>
	        <?php }else{ ?>
	        <div style='background-image:; background: ; margin-bottom:0; display:inline; border:0px #DDDDDD solid; height:15px; color:#000000; font-weight:bold; font-size:12px'><img src="img/headicon_like.png" width="12" />&nbsp;&nbsp;You like this icon :)</div>
	        <?php } ?>
	        <span id="flashLikeDiv" class="flashLikeDiv" style=" display:none; width:100; padding-right:5"></span> 
	        <span id="likeResult" class="likeResult" style='display:none'></span>
	        <div style=" margin-top:10; margin-bottom:10; font-size:11px"><?php echo($like_uname_list) ?></div>
  </div>
			  
			<div style="background:; border-top:0px dashed #CCCCCC; margin-top:25;">
			  <div style="width:250; margin-bottom:5; border-bottom:0px solid #999999; border-top:0px solid #CCCCCC">
			    <table width="250" height="25" border="0" cellpadding="0" cellspacing="0" st>
			      <tr>
			        <td align="left" valign="top" background="" style="font-size:18px; padding-left:5; padding-top:8; font-weight:bold; background:">
		           <img src="img/edit-rule.png" width="15" /> &nbsp;<?php echo("$uid_fname $uid_lname") ?>&nbsp;<font style="font-size:12px; padding-right:5; padding-top:8; font-weight:normal; color:#999999; font-family:Arial, Helvetica, sans-serif"></font>	</td>
      </tr>
  </table>
  </div>
			  <div style="width:250; margin-top:0; border-bottom:1px solid #EEEEEE; background:#FFFFFF">
			    <table width="250" height="25" border="0" cellpadding="0" cellspacing="0">
			      <tr>
			        <td align="left" style="font-size:11px; padding-left:5;"><?php echo($cschool) ?> </td>
                  </tr>
		        </table>
		      </div>
			  <div style="width:250; margin-top:0; border-bottom:1px solid #EEEEEE; background:#FFFFFF">
			    <table width="250" height="25" border="0" cellpadding="0" cellspacing="0">
			      <tr>
			        <td align="left" style="font-size:12px; padding-left:5"><?php echo($major_name) ?> </td>
                  </tr>
		        </table>
		      </div>
			  <div style="width:250; margin-top:0; border-bottom:1px solid #EEEEEE; background:#FFFFFF">
			    <table width="250" height="25" border="0" cellpadding="0" cellspacing="0">
			      <tr>
			        <td align="left" style="font-size:13px; padding-left:5"><?php echo($cdegree.", $sterm") ?> </td>
                  </tr>
		        </table>
		      </div>
			  <div style="width:250; margin-top:0; border-bottom:1px solid #EEEEEE; background:#FFFFFF">
			    <table width="250" height="25" border="0" cellpadding="0" cellspacing="0">
			      <tr>
			        <td align="left" style="font-size:12px; padding-left:5">
			          <?php echo($mstatus." | Birth Date : ".$birthdate)?>		            </td>
                  </tr>
		        </table>
		      </div>
			  <div style="width:250; margin-top:0; border-bottom:1px solid #EEEEEE; background:#FFFFFF">
			    <table width="250" height="25" border="0" cellpadding="0" cellspacing="0">
			      <tr>
			        <td align="left" style="font-size:12px; padding-left:5"><?php echo("From $fregion, ".$fcountry) ?> </td>
                  </tr>
		        </table>
		      </div>
			  <div style="width:250; margin-top:0; border-bottom:1px solid #EEEEEE; background:#FFFFFF">
			    <table width="250" height="25" border="0" cellpadding="0" cellspacing="0">
			      <tr>
			        <td align="left" style="font-size:12px; padding-left:5"><?php echo("Current: $ccity, ".$cstate)?></td>
                  </tr>
		        </table>
		      </div>
		    </div>
		    <br />
	      <?php if($rel_rstatus=="A") {?>
	      <a href='FriendConfirm.php?uid=<?php echo($uid) ?>&&pageName=RockerDetail'>
	        <div style=" height:18; padding:2 5 2 5; background: url(img/master.png); display:inline; border:1px solid #999999; border-top:0px solid #DDDDDD; border-left:1px solid #DDDDDD; font-size:11px; cursor:pointer; color:#000000" onmouseover="this.style.background='url(img/GrayGradbgDown.jpg)'" onmouseout="this.style.background='url(img/master.jpg)'">Unfriend&nbsp;<?php echo($uid_fname); ?></div>
	        </a>
	      <?php } ?>	      </td>
          <td width="490" valign="top" style="padding-left:20">
  <table cellpadding="0" border="0" cellspacing="0" width="510">
  <tr><td width="385">
  <div style="margin-bottom:15; padding-left:5; font-size:28px; line-height:125%; font-weight:bold; color:<?php echo($_SESSION['hcolor']) ?>">
  <?php 
echo("Hi, I'm $uid_fname<br>Please write on my Paper!") ?>
  </div>
  </td>
    <td width="115" align="right" valign="top" style="padding-top:0; padding-right:0">
  <script type="text/javascript">
$(function() {
	$(".addFriendDiv").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($uid) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#addFriendDiv").hide();
		$("#flashAddFriend").show();
		$("#flashAddFriend").fadeIn(400).html('<img src="img/loading42.gif" width="80" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_frequest.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashAddFriend").hide();
				$("#addFriendResult").fadeIn(400).html("Requested");
			}
 		});
 		return false;
 	});
 });
</script>
  <?php if($rel_rstatus=="S")echo("<a href='UpdateWall.php'><div style='font-size:11px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; width:80px; height:20; border:1px #999999 solid; background: url(img/master.jpg); color:#000000;  padding:2 5 2 5; display:inline; -moz-border-radius: 3px; border-radius: 3px;' align='center' onmouseover=this.style.background='url(img/GrayGradbgDown.jpg)' onmouseout=this.style.background='url(img/master.jpg)'>+ Edit Paper</div></a>&nbsp;");
	 else if($rel_rstatus=="P")echo("<div style='-moz-border-radius: 3px; border-radius: 3px; font-size:11px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; width:80px; height:20; border:1px #000000 solid; background: url(img/brownBtnBg.jpg); color:#FFFFFF;  padding:2 8 2 8; display:inline' align='center' onmouseover=this.style.background='url(img/GrayGradbgDown.jpg)' onmouseout=this.style.background='url(img/master.jpg)'>+ Edit Paper</div></a>>Requested</div>");
		 else if($rel_rstatus=="A")echo("<a href='SendMessage.php?recipient=$uid'><div style='-moz-border-radius: 3px; border-radius: 3px; font-size:11px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; width:80px; height:20; border:1px #999999 solid; border-left:1px #DDDDDD solid; border-top:1px #DDDDDD solid; background:url(img/master.jpg); color:#000000;  padding:2 8 2 8; display:inline' align='center'><img src='img/littleMessageIcon.jpg' style='border:0px' width='12' />&nbsp; Message</div></a>");
	 else if($rel_rstatus=="X"){
	 	echo("<div style='-moz-border-radius: 3px; border-radius: 3px; font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; width:80px; height:20; border:1px #000000 solid; background: url(img/brownBtnBg.jpg); color:#FFFFFF;  padding:2 8 2 8; display:inline' align='center'><a href='AcceptFriend.php?sender=$uid'>Accept</a></div>&nbsp;&nbsp;");
	 	echo("<div style='-moz-border-radius: 3px; border-radius: 3px; font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; width:80px; height:20; border:1px #000000 solid; background: url(img/black_cell_bg.jpg); color:#FFFFFF;  padding:2 8 2 8; display:inline' align='center'><a href='DenyFriend.php?sender=$uid'>Decline</a></div>");
	 }else if($rel_rstatus=="N")echo("<div id='addFriendDiv' class='addFriendDiv' style='-moz-border-radius: 3px; border-radius: 3px; font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; width:80px; height:20; border:1px #999999 solid; background: url(img/master.jpg); color:#000000;  padding:2 8 2 8; display:inline; cursor:pointer' align='center'>+ Friend</div>");
	 ?>
      <span id="flashAddFriend" class="flashAddFriend" style=" display:none; width:80; padding-right:5"></span>
      <span id="addFriendResult" class="addFriendResult" style='font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; width:80px; height:20; border:1px #000000 solid; background: url(img/black_cell_bg.jpg); color:#FFFFFF;  padding:2 8 2 8; display:none; cursor:pointer'></span>      </td>
  </tr></table>
  

        <table width="510" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:15px; background: #F5F5F5; background-repeat: repeat-x; border-top:1px solid #EEEEEE; border:1px solid #EEEEEE">
          <tr>
            <td style=" padding:10px; line-height:100%; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold" align="left" valign="top">
              <div style="margin-bottom:13px"><?php echo($uid_fname)?>'s friends <font color="#999999">(<?php echo($total_friend) ?>)</font></div>
          <?php
//			echo(count($show_friend_arr)."----------");
			if(count($show_friend_arr)==0) 
				echo("<div style='margin-top:50px; padding-left:15px'><font style='font-size:36px; color:#999999'>Currently no friends yet!</font></div>");
			for($x=0; $x<6; $x++){
				$friend_pic = $show_friend_arr[$x].'60.jpg';
				//date('Y-m-d, H:i');
				$friend_folder = "upload/".$show_friend_arr[$x];
				$target_friend = "upload/".$show_friend_arr[$x]."/".$friend_pic;

				if($x==0) echo("<table width=500 border=0 cellpadding=0 cellspacing=0 ><tr><td width='72px'>");
				else echo("<td width='72px'>")
					?>
              
              <div style='border:0px solid #EEEEEE; padding:0px; background:; background-repeat:no-repeat; width:70px; height:55px; overflow:hidden; display:block'>
                <?php
				if($x<count($show_friend_arr)){
					if(is_dir($friend_folder)){
						echo("<a href='RockerDetail.php?uid=$loopname' class='one'><img src=$target_friend?".time()." /></a>");
					}else{ 
						echo("<a href='RockerDetail.php?uid=$loopname' class='one'><img src=img/NoUserIcon100.jpg style='border:0' width=60px></a>");
					}
				} ?>
                </div>	
				  <div style=" margin-top:5px; padding-left:1px; width:70px; display:block; font-size:12px; font-weight:bold; overflow:hidden; display:block">
				    <?php echo("<a href='RockerDetail.php?uid=$show_friend_arr[$x]' class=one><font color=$_SESSION[hcolor]>".$show_friend_arr[$x]."</font></a>") ?>			      </div>			
			  <?php
			if($x==5) echo("</td></tr></table>");
				else echo("</td>");
		}		
		?>              </td>
	  </tr>
          </table>
  
<div style="margin-top:5">
  <?php
$q_memo = mysql_query("SELECT * FROM rockinus.memo_info WHERE sender='$uid' ORDER BY memoid DESC;");
if(!$q_memo) die(mysql_error());
$memo_no_row = mysql_num_rows($q_memo);
//echo("----------------".$memo_no_row);
if($memo_no_row==0)echo("<div style='color:#999999; width:520px; -moz-border-radius: 5px; border-radius: 5px; font-size:28px; padding-top:45; background: #F5F5F5; padding-bottom:45; font-weight:bold' align='center'><img src=img/date_error.png width=25 />&nbsp;&nbsp;Nothing posted</div>");
while($object = mysql_fetch_object($q_memo)){
	$memoid = $object->memoid;
	$descrip = $object->descrip;
	$descrip = str_replace("\\","",nl2br($descrip));
	$pdate = $object->pdate;
	$ptime = $object->ptime;
	if($descrip==NULL&&$memo_no_row==1){
		echo("<div style='width:500; background: #666666; padding:10; padding-top:5; padding-bottom:6; margin-top:0; margin-bottom:10; line-height:100%; border-top:1px solid #333333; border-bottom:1px solid #333333'><font style='font-size:12px; font-family: Arial, Helvetica, sans-serif; color:#FFFFFF; font-weight:normal'>&nbsp;I haven't written anything yet, just write me anyway :)</font></div>"); 
	}else if($descrip==NULL&&$memo_no_row>1){
		continue;
	}else{ 
		echo("<div style='width:500; -moz-border-radius: 3px; border-radius: 3px; background:#F5F5F5; padding:10; margin-top:0; line-height:125%; font-size:13px; border:1px solid #EEEEEE'>".addHyperLink($descrip)."<br><font color=#666666 style='font-size:11px'>(".getDateName($pdate)." | ".substr($ptime,0,5).")</font></div>"); 
	}

	$t = mysql_query("SELECT count(*) AS cnt FROM rockinus.memo_follow_info WHERE memoid='$memoid';");
	$a = mysql_fetch_object($t);
	$memo_follow_cnt = $a->cnt;
	
//	$t_u = mysql_query("SELECT count(*) AS cnt FROM rockinus.memo_follow_info WHERE memoid='$memoid' AND rstatus='N';");
//	$a_u = mysql_fetch_object($t_u);
//	$memo_follow_unread_cnt = $a_u->cnt;
?>
  <script>
$(document).ready(function() {
	$("#commentStatusDiv<?php echo($memoid) ?>").hide();
	$("#displayCommentStatus<?php echo($memoid) ?>").hide();
	
	$("div .commentStatusBtn<?php echo($memoid) ?>").click(function () {
	  //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#commentStatusBtn<?php echo($memoid) ?>").hide();
	  $("#commentStatusDiv<?php echo($memoid) ?>").show();
	});
	
	$("div .commentCancelBtn<?php echo($memoid) ?>").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#commentStatusDiv<?php echo($memoid) ?>").hide();
	  $("#commentStatusBtn<?php echo($memoid) ?>").show();
	});	
});
</script>
  
  <script type="text/javascript" >
$(function() {
	$(".commentSubmitBtn<?php echo($memoid) ?>").click(function() {
		var memoid = '<?php echo($memoid) ?>';
		var test = $("#contentforfriend<?php echo($memoid) ?>").val();
		var pdate = '<?php echo(date('Y-m-d')) ?>';
		var ptime = '<?php echo(date("H:i:s", time())) ?>';
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($uid) ?>';
		var dataString = 'content='+ test+'&sender='+sender+'&recipient='+recipient+'&memoid='+memoid+'&pdate='+pdate+'&ptime='+ptime; 

		if(test=='')
		{
			alert("Please Enter Something ok?");
		}
		else
		{
			$("#flashCommentStatus<?php echo($memoid) ?>").show();
			$("#flashCommentStatus<?php echo($memoid) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">');
 
 			$.ajax({
  				type: "POST",
  				url: "ajax_reply_status.php",
  				data: dataString,
  				cache: false,
  				success: function(html){
  					$("#displayCommentStatus<?php echo($memoid) ?>").after(html);
  					document.getElementById('contentforfriend<?php echo($memoid) ?>').value='';
  					document.getElementById('contentforfriend<?php echo($memoid) ?>').focus();
  					$("#flashCommentStatus<?php echo($memoid) ?>").hide();
					$("#commentStatusDiv<?php echo($memoid) ?>").hide();
	  				$("#commentStatusBtn<?php echo($memoid) ?>").show();
  				}
 			});
 		} return false;
 	});
});
</script>
  <table width="500" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10; border-bottom:0 solid #DDDDDD">
    <tr>
      <td width="334" height="30" align="left" valign="top" style=" font-weight:normal; font-size:14px; padding-left:10; padding-top:2; line-height:180%">
        <script type="text/javascript" >
$(function() {
 	$(".expandComment_button<?php echo($memoid) ?>").click(function() {
		var memoid = <?php echo($memoid) ?>;
		var memocnt = <?php echo($memo_follow_cnt) ?>;
		var dataString = 'memoid='+memoid; 

		if(memoid=='')
		{
			alert("not getting memo id!");
		}
		else if( memocnt>0 && !$("#display_expandComment<?php echo($memoid) ?>").is(':visible') )
		{
			$("#flash_expandComment<?php echo($memoid) ?>").show();
			$("#flash_expandComment<?php echo($memoid) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">&nbsp;<span class="loading"></span>');
 
			$.ajax({
  				type: "POST",
  				url: "load_memo_out.php",
  				data: dataString,
  				cache: false,
  				success: function(html){
  					$("#display_expandComment<?php echo($memoid) ?>").after(html);
					$("#display_expandComment<?php echo($memoid) ?>").show(html);
  					$("#flash_expandComment<?php echo($memoid) ?>").hide();
					$("#HideComment_button<?php echo($memoid) ?>").show();
					//alert($("#display_expandComment<?php echo($memoid) ?>").is(':visible'));
  					//alert("#display_expandComment<?php echo($memoid) ?>");
				}
 			});
 		} return false;
 	});
 });
</script>
        
        <span class="expandComment_button<?php echo($memoid) ?>" id="expandComment_button<?php echo($memoid) ?>" style="border-bottom:0 dashed #999999; font-color:#666666; font-weight:normal; font-size:11px; cursor:pointer">
          <?php 
			echo("Comment($memo_follow_cnt)");
	  ?>
          </span>
        <span class="HideComment_button<?php echo($memoid) ?>" id="HideComment_button<?php echo($memoid) ?>" style="border-bottom:0 dashed #999999; font-color:#666666; text-decoration:underline; font-weight:normal; font-size:11px; display:none; cursor:pointer">
          <?php 
			echo("Roll Up");
	  ?>
          </span>
        <?php if($uname==$uid){ ?> <font color="#666666" style="font-size:11px"">| </font><a href="deleteStatusManage.php?memoid=<?php echo($memoid); ?>" class="one" style="border-bottom:0 dashed #999999;font-color:#666666; font-weight:normal; font-size:11px">Delete</a><?php } ?>		</td>
	  <td width="123" align="right" valign="top" style=" font-weight:normal; font-size:13px; padding-right:20; padding-top:5;">
	    <div class="commentStatusBtn<?php echo($memoid) ?>" id="commentStatusBtn<?php echo($memoid) ?>" style="height:15; padding:2 4 2 4; background: url(img/master.jpg); border:1px solid #999999; font-size:11px; -moz-border-radius: 3px; border-radius: 3px; font-weight:bold; cursor:pointer; color:#000000" align="center">Write <?php echo($uid_fname) ?></div>	  </td>
	  </tr>
    <tr>
      <td height="5" colspan="2" align="left" valign="top" style="padding-left:5; padding-bottom:10; line-height:100%; font-size:12px">
        <div id="flash_expandComment<?php echo($memoid) ?>" class="flash_expandComment<?php echo($memoid) ?>" style="padding-left:0px" align="left"></div>
	  <div id="display_expandComment<?php echo($memoid) ?>" class="display_expandComment<?php echo($memoid) ?>" style="padding-left:0px; display:none" align="left"></div>	
	  
<script type="text/javascript" >
$(function() {
	$(".deleteComment_button<?php echo($memoid) ?>").click(function() {
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
					$("#deletefriendresult<?php echo($memofid) ?>").after(html);
					document.getElementById('contentforfriend').value='';
					document.getElementById('contentforfriend').focus();
					$("#flashdeletememo<?php echo($memofid) ?>").hide();
					$("#friendmemo<?php echo($memofid) ?>").hide();
				}
			});
		} return false;
 	});
 });
              </script>	
  <div id="flashCommentStatus<?php echo($memoid) ?>" class="flashCommentStatus<?php echo($memoid) ?>" style="padding-left:0px; margin-top:15; margin-bottom:15;"></div>
  <div id="displayCommentStatus<?php echo($memoid) ?>" class="displayCommentStatus<?php echo($memoid) ?>" style="padding-left:0px; width:500; background:#F5F5F5; padding:10; padding-top:20; margin-top:20; line-height:150%; font-size:13px; border:1px solid #EEEEEE"></div>	
  <div class="commentStatusDiv<?php echo($memoid) ?>" id="commentStatusDiv<?php echo($memoid) ?>" style=" margin-top:10; margin-bottom:15">
  <form action="postStatus.php" method="post" name="ownform" id="ownform" style="margin-top:0px">
  <textarea name="contentforown" id="contentforfriend<?php echo($memoid) ?>" style=" width:500; border:1px solid #DDDDDD; height:70px; font-size:13px; font-weight:normal; padding:4px; line-height:140%; font-family: Arial, Helvetica, sans-serif; margin-bottom:10px"></textarea>
    <div class="commentSubmitBtn<?php echo($memoid) ?>" id="commentSubmitBtn<?php echo($memoid) ?>" style=" height:18; padding:3 8 3 8; background: url(img/black_cell_bg.jpg); display:inline; margin-top:10; margin-bottom: width:60; border:1px solid #333333; font-size:11px; cursor:pointer; font-weight:bold; color:#FFFFFF; -moz-border-radius: 3px; border-radius: 3px;" align="center">Submit</div>&nbsp; <div class="commentCancelBtn<?php echo($memoid) ?>" id="commentCancelBtn<?php echo($memoid) ?>" style=" height:18; padding:3 8 3 8; background: url(img/master.png); display:inline; -moz-border-radius: 3px; border-radius: 3px; margin-top:10; width:70; border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; font-size:11px; font-weight:bold; cursor:pointer" align="center">Next time</div>
    </form>
  </div>	  </td>
	    </tr>
    </table>
  
<?php
}		
?>
  </div>  </td>
        </tr>
    </table></td>
    <td width="245" align="left" valign="top" style="padding:20px 10px 10px 15px">
			<?php include "HomeUserUpdate.php"; ?>	</td>
  </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
