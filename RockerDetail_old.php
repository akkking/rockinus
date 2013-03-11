<?php 
include("Header.php");
include 'dbconnect.php';

$ua = getBrowser();

if(isset($_POST['delmemosubmit'])){
	$memofid = $_POST['memofid'];
	$uid = $_POST['uid'];
	$sql = "DELETE FROM rockinus.memo_follow_info WHERE memofid='$memofid'";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
}else{
	if(isset($_GET["uid"]))
		$uid = $_GET["uid"];
	else 
		$uid = $uname;
}	

$pic250_Name = $uid.'250.jpg';

if($uid==$uname){
	$submitFile = "MemoPost.php";
	$pagename = "RockerDetail.php?uid=$uid";
}else{
	$submitFile = "ReplyMemo.php";
	$pagename = "RockerDetail.php?uid=$uid";
	//$pagename = "RockerDetailReply.php?uid=$uid";
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

$q = mysql_query("SELECT *, b.email as eemail FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON a.uname='$uid' AND b.uname='$uid' AND c.uname='$uid' AND d.uname='$uid'");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("This user info no longer exist in system.");
$object = mysql_fetch_object($q);
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;
$birthdate = $object->birthdate;
$sterm = $object->sterm;
$fregion = $object->fregion;
$fcountry = $object->fcountry;
$ccity = $object->ccity;
$cstate = $object->cstate;
if($fcountry=="empty")$fcountry = NULL;
$email = $object->email;
$eemail = $object->eemail;
$cmajor = $object->cmajor;
$cschool = $object->cschool;
$cdegree = $object->cdegree;

if($gender=='M')$gender='Gentle Man';
else if($gender=='F')$gender='Female';

if($sstatus=='S')$sstatus='Student';
else if($sstatus=='E')$sstatus='Empolyee(r)';

if($cdegree=='G')$cdegree='Master Student';
else if($cdegree=='P')$cdegree='P.H.D.';
else if($cdegree=='U')$cdegree='Undergraduate';
else if($cdegree=='C')$cdegree='Certificate Student';

if($mstatus=='S')$mstatus='Single';
else if($mstatus=='M')$mstatus='Married';
else if($mstatus=='I')$mstatus='In a relationship';

if($cschool!=NULL&&$cschool!="empty"){
	$q1 = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
	if(!$q1) die(mysql_error());
	$obj1 = mysql_fetch_object($q1);
	$school_name = $obj1->school_name;
}else $school_name="<font color=#CCCCCC>Unknown school name</font>";

if($cmajor!=NULL){
	$q2 = mysql_query("SELECT * FROM rockinus.major_info where mid='$cmajor'");
	if(!$q2) die(mysql_error());
	$obj2 = mysql_fetch_object($q2);
	$cmajor = $obj2->major_name;
}

if($fcountry!=NULL){
	$q1 = mysql_query("SELECT * FROM rockinus.country_info where counid='$fcountry'");
//	echo("SELECT * FROM rockinus.country_info where counid='$fcountry'");
//	if(!$q1) die(mysql_error());
//	$obj1 = mysql_fetch_object($q1);
//	$fcountry = $obj1->country_name;
}

$q3 = mysql_query("SELECT * FROM rockinus.memo_info where sender='$uid' order by memoid DESC");
if(!$q3) die(mysql_error());
$obj3 = mysql_fetch_object($q3);
$uiddescrip = $obj3->descrip;
$memoid = $obj3->memoid;
if($uiddescrip==NULL) $uiddescrip="<font color=#CCCCCC>Nothing posted ...</font>";

$rstatus = NULL;
if($uid==$uname)$rstatus ="S";
else{
	$q11 = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE (sender='$uid' AND recipient='$uname') OR (recipient='$uid' AND sender='$uname')");
	if(!$q11) die(mysql_error());
	$no_row_A = mysql_num_rows($q11);
	if($no_row_A>0)$rstatus='A';
	
	$q21 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uid' AND recipient='$uname' AND rstatus='P'");
	if(!$q21) die(mysql_error());
	$no_row_P = mysql_num_rows($q21);
	if($no_row_P>0)$rstatus='X';
	
	$q22 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uname' AND recipient='$uid' AND rstatus='P'");
	if(!$q22) die(mysql_error());
	$no_row_X = mysql_num_rows($q22);
	if($no_row_X>0)$rstatus='P';	
}
?>
<link rel="stylesheet" href="js/demos.css" />
<link rel="stylesheet" href="js/jquery.ui.all.css" title="ui-theme" />
<script type="text/JavaScript">
  curvyCorners.addEvent(window, 'load', initCorners);
  function initCorners() {
    var settings = {
      tl: { radius: 0 },
      tr: { radius: 0 },
      bl: { radius: 0 },
      br: { radius: 0 },
      antiAlias: true
    }
    curvyCorners(settings, "#myBox");
  }
</script>
<style>
#myBox {
  margin: 0.5in auto;
  color: #fff;
  width: 250px;
  height: 300px;
  padding: 0px;
  text-align: left;
  background-image: url(
  <?php
  	$target = "upload/".$uid;
	if(is_dir($target)){
		echo("upload/$uid/$pic250_Name?".time());
	}else 
		echo("img/NoUserIcon250.jpg");
	?>
  );
  background-repeat: no-repeat;
  margin-bottom:0px;
  margin-top:0px;
  border:0px #CCCCCC solid;
}
</style>
<script src="js/jquery-1.7.1.js"></script>
<script src="js/jquery.ui.core.js"></script>
<script src="js/jquery.ui.widget.js"></script>
<script src="js/jquery.ui.position.js"></script>
<script src="js/jquery.ui.button.js"></script>
<script src="js/jquery.ui.popup.js"></script>
<table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td align="left" valign="top" style="border-right: 0px solid #CCCCCC; padding-left:0px" width="250px"><table width="1010" border="0" cellpadding="0" cellspacing="0">
      
      <tr>
        <td width="750" height="271" align="center" valign="top" style="padding-bottom:10px; padding-left:10px; padding-top:2px">
		<table width="405" height="85" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="663" height="85" valign="top" style="padding-left:0px; padding-top:0px;">
			<table width="250" border="0" cellspacing="0" cellpadding="0" style="border-top:0px #CCCCCC dashed;">
              <tr>
                <td style="padding-top:0px; " valign="top">
				<div id="myBox"></div>
				</td>
                <td valign="top" style="padding-top:0px"><table width="480" height="288" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="50" height="28" align="center" valign="top"><img src="img/starIcon.jpg" width="15" height="15" /> </td>
                      <td width="190" height="28" style="padding-left:0px;" valign="top"><?php 
				$sel_count = "
SELECT sum(total) as cnt FROM (
	SELECT count(*) as total FROM rockinus.house_info WHERE uname='$uid'
	UNION 
	SELECT count(*) as total FROM rockinus.article_info WHERE uname='$uid'
	UNION 
	SELECT count(*) as total FROM rockinus.course_memo_info WHERE sender='$uid' 
	UNION 
	SELECT count(*) as total FROM rockinus.event_info WHERE creater='$uid'
	UNION 
	SELECT count(*) as total FROM rockinus.forum_info WHERE creater='$uid'
	UNION 
	SELECT count(*) as total FROM rockinus.job_info WHERE creater='$uid' 
) as cnt";

$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
 
$a = mysql_fetch_object($t);
$t_cnt = $a->cnt;
echo("<a href=RockerDetail.php?uid=$uid class=one><font size=4 color=$_SESSION[hcolor]><strong>$uid</strong></font></a> <font color=#999999 size=3>($t_cnt posted)</font>");
				
			  ?>                      
			  &nbsp;</td>
                      <td width="249" height="28" align="right" style="padding-right:0px;" valign="middle">
					  <form action="/" id="friendrequest">
				<script>
	$(function() {
		var selected = {
			select: function( event, ui ) {
				$( "<div/>" ).text( "Selected: " + ui.item.text() ).appendTo( "#log" );
				$(this).popup("close");
			}
		};

		$("#request-form<?php echo($uid) ?>").popup()
			.find(":submit").button().click(function(event) {
				event.preventDefault();
			});
	});
	</script>
		<style type="text/css">
		.ui-popup { position: absolute; z-index: 5000; }

		#request-form<?php echo($uid) ?> {
			width: 14em; border: 2px solid #DDDDDD; border-radius: 5px;
			padding: 1em;
			box-shadow: 3px 3px 5px -1px rgba(0, 0, 0, 0.5);
			background: lightgray; background-image: -webkit-gradient(linear, left top, left bottom, from(#eee), to(#ddd));
			font-size: 1.1em; outline: none;
		}
		#request-form<?php echo($uid) ?> label { display: inline-block; width: 5em; }
		#request-form<?php echo($uid) ?> .submit { margin-left: 15em; }
 	</style>
             <?php if($rstatus=="A"){echo("<a href=SendMessage.php?recipient=$uid><img src=img/messageIconEN.jpg /></a><div></div>");}
			 		else if($rstatus=="S"){echo("<a href=EditUserInfo.php><img src=img/black_editinfo.jpg style='border:1px #000000 solid'/></a><div></div>");}
				  else if($rstatus=="P"){ ?> 
				  <div class="demo-description" style="padding-left:10px; padding-right:10px; padding-top:4px; padding-bottom:4px; background:#EEEEEE; border:#999999 1px solid; font-size=12px; margin-bottom:0px; display:inline; height:20px" align="center"><font color='#999999'><strong>Request sent ...</strong></font></div>
				  <div></div>
				  <?php }else if($rstatus=="X"){
				  ?>
				  <table align="right">
				  <tr><td style="padding-bottom:3px; padding-top:3px; background:<?php echo($_SESSION['hcolor']) ?>; border:#000000 1px solid; padding-left:10px; padding-right:10px;">
				  <a href="AcceptFriend.php?sender=<?php echo($uid)?>"><font color=#FFFFFF size="2"><strong>Accept</strong></font></a>
				  </td>
				  <td style="padding-bottom:3px; padding-top:3px; background:#666666; border:#000000 1px solid; padding-left:10px; padding-right:10px;">
				  <a href="DenyFriend.php?sender=<?php echo($uid)?>"><font color=#FFFFFF size="2"><strong>Ignore</strong></font></a>
				  </td></tr></table>
				  <div></div>
				  <?php 
				  }else{ 
				  ?> 
	<div class="demo" style="padding-top:0px; margin-bottom:0px; display:inline" align="right">
	<span style="padding-left:8px; padding-right:8px; margin-top:0px; padding-top:2px; padding-bottom:2px; border:1px #000000 solid; background-image:url(img/black_cell_bg.jpg); height:20px">
	<a href="#request-form<?php echo($uid) ?>">+ Request</a>
	</span>
				<?php } ?>
		<div class="ui-widget-content" id="request-form<?php echo($uid) ?>" aria-label="Login options" style="line-height:250%; background-color:#F5F5F5; padding-left:10px; margin-bottom:0px; margin-top:3px; padding-top:0px" align="left">
		<span>
		Are you sure you want to add <strong><?php echo($uid) ?></strong>?&nbsp;&nbsp;
		<input type="button" id="request-button<?php echo($uid) ?>" value="Sure" class="btn"/>
		</span>
		</div>
</div>
<input type="hidden" name="sender" id="sender" class="sender" value=<?php echo($uname) ?> />
<input type="hidden" name="recipient<?php echo($uid) ?>" id="recipient<?php echo($uid) ?>" class="recipient<?php echo($uid) ?>" value=<?php echo($uid) ?> />
	<script>
	$(document).ready(function(){
		$("#request-button<?php echo($uid) ?>").click(function () {
			//alert($("#sender").val());
			//alert($("#recipient<?php echo($uid) ?>").val());
			var o_v = $("#request-form<?php echo($uid) ?> span").html();
			$("#request-form<?php echo($uid) ?> span").html("Request has been sent");
		  	$("#request-form<?php echo($uid) ?>").delay(1000).fadeOut("slow");
		
			$.post(
				'ajax_frequest.php',
				{
					sender:$("#sender").val(),
					recipient:$("#recipient<?php echo($uid) ?>").val()
				}
			)
    	});
	});
	</script>
	</form>				
			   &nbsp;
			   <?php if($rstatus !="S")
				   //echo("<a href=SendMessage.php?recipient=$uid class='one'><img src=img/messageIconEN.jpg /></a>");
				   ?>
			  </td>
                    </tr>
                    <tr>
                      <td width="50" height="28" align="right" valign="top" style="padding-top:5px; padding-right:5px">&nbsp;</td>
                      <td height="28" colspan="2" bgcolor="" style="border:0px #DDDDDD solid; background-color: ; line-height:150%; display:inline; padding-top:0px; padding-bottom:5px; padding-left:0px; padding-right:5px; font-size:14px;" valign="top">
                        <?php
							if(strlen($uiddescrip)) echo($uiddescrip);		 
						?>
                      </td>
                      </tr>
                    <tr>
                      <td width="50" height="28" valign="middle" align="center"><img src="img/studentIcon.jpg" width="15" height="15" /> </td>
                      <td height="28" colspan="2" style="padding-top:3px; padding-bottom:5px; padding-left:0px; font-size:14px"><?php 
						  if($cdegree!=NULL)echo("<strong>$cdegree</strong>"); 
						  if($sstatus!=NULL)echo("<a href=FriendGroup.php class=one><strong>$sstatus</strong></a>");
						   ?>
						   </td>
                      </tr>
                    <tr>
                      <td width="50" height="28" align="right" valign="top" style="padding-top:5px; padding-right:5px">&nbsp;</td>
                      <td height="28" colspan="2" style="padding-top:3px; padding-bottom:5px; padding-left:0px; font-size:14px">
					  <span style="margin-top:10px">
                        <?php
					if(($sstatus!=NULL)&&($cschool!=NULL))echo("$school_name"); 
				?>
                      </span></td>
                    </tr>
                    <tr>
                      <td width="50" height="28" style="padding-right:5px" align="right"></td>
                      <td height="28" colspan="2" style="padding-left:0px; font-size:14px">
					  <?php 
						  if(($cdegree!=NULL)&&($cmajor!=NULL))echo("$cmajor ($sterm)"); 
						  else echo("<font color=#CCCCCC> Unknown major</font>");
						  ?>                      
						  </td>
                    </tr>
                    <tr>
                      <td width="50" height="28" align="center"><img src="img/hometownIcon.jpg" width="15" height="15" /></td>
                      <td height="28" colspan="2" style="padding-left:0px; font-size:14px"><?php 
							echo("<strong>Now Live in: &nbsp;</strong>  ");
						   if($ccity!=NULL)echo($ccity); else echo("<font color=#CCCCCC>Unkown City</font>"); 
						   		if(($cstate!=NULL)&&($cstate!=NULL)){
						   			if($ccity!=NULL)echo(", $cstate");
								}else 	
						   			echo("<font color=#CCCCCC>, Unknown State</font>"); 
						   ?>                      </td>
                    </tr>
                    <tr>
                      <td width="50" height="28" style="padding-left:0px; padding-right:5px">&nbsp;</td>
                      <td height="28" colspan="2" style="padding-left:0px; padding-left:0px; font-size:14px">
					  <?php 
						   echo("<strong>Home Town: &nbsp;</strong>");
						   if($fregion!=NULL&&$fregion!="empty")echo($fregion); else echo("<font color=#CCCCCC>Unknown City</font>");
						   if(($fregion!=NULL)&&($fcountry!=NULL))echo(", ".$fcountry); else echo("<font color=#CCCCCC>, Unknown Country</font>");
						   ?>                      </td>
                    </tr>
                    <tr>
                      <td width="50" height="28"  align="center"><img src="img/personIcon.jpg" width="15" height="15" /></td>
                      <td height="28" colspan="2" style="padding-left:0px; padding-left:0px; font-size:14px"><?php 
				echo("<strong>Martial Status: &nbsp;</strong>");
				if($gender=="Male")echo("He is ");
					else if($gender=="Female")echo("She is ");
						if($mstatus!=NULL)echo($mstatus); else echo("<font color=#CCCCCC>Unknown</font>");  ?></td>
                    </tr>
                    <tr>
                      <td width="50" height="28" style="" align="center"><img src="img/emailIcon.jpg" width="14" height="12" /></td>
                      <td height="28" colspan="2" style="padding-left:0px; font-size:14px">
					  <?php echo("<a href=SendMessage.php?recipient=$uid class=one>$eemail</a>") ?></td>
                    </tr>
                </table></td>
              </tr>
            </table>
			</td>
			</tr>
			<tr>
			<td valign="top" style="">
			<table style="margin-top:15px; border:1px #EEEEEE solid;" bgcolor="#F5F5F5" align="center">
			<tr><td width="740" align="center" style="padding-bottom:15px">
			<table width="710" height="35" border="0" cellpadding="0" cellspacing="0" bgcolor="#666666" style="border-top:0px #DDDDDD solid; border-bottom:2px #DDDDDD solid; margin-top:15px; margin-bottom:10px">
              <tr>
                <td width="657">
				<?php
		$q = mysql_query("SELECT a.*, b.course_id, b.pid, c.course_name FROM rockinus.user_file_info a JOIN rockinus.unique_course_info b JOIN rockinus.course_info c ON a.owner='$uid' AND a.course_uid=b.course_uid AND c.course_id=b.course_id GROUP BY a.course_uid ORDER BY a.file_id DESC LIMIT 0, 30");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($uid==$uname) 
			echo("<strong><div style='background-color: ; color: #FFFFFF; font-size:14px; padding-left:5px; padding-right:10px; display:inline; border-top:0px #CCCCCC solid; border-left:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding-top:6px; height:30px'>Your Course Files Upload List <font color=#666666>($no_row)</font></div></strong>");
else 
	echo("<strong><div style='background-color: ; color: #FFFFFF; font-size:14px; padding-left:10px; padding-right:10px; display:inline; border-top:0px #CCCCCC solid; border-left:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding-top:6px; height:30px'>$uid's Course Files Upload List <font color=#666666>($no_row)</font></div></strong>");
				?>
				</td>
                <td width="83" align="right" style="padding-right:10px; font-size:12px; font-weight:bold; color:<?php echo($_SESSION['hcolor']) ?>">
				<?php if($uid==$uname)echo("<a href='uploadCourseFile.php'>+ Upload</a>") ?>
				</td>
              </tr>
            </table>
			<?php
		if ($no_row == 0){
			if($uid==$uname)
				echo("<div style='background-color:#FFFFFF; font-size:16px; width:740px; padding-top:15px;padding-bottom:25px; color:#666666' align='center'><strong>You have no course files uploaded ...<br><br><div style='display:inline; background:#EEEEEE; padding:5px; padding-left: 10px; padding-right:10px; border: 1px #DDDDDD solid' onmouseover='this.style.backgroundColor = #DDDDDD; this.style.borderColor = #CCCCCC;' onmouseout='this.style.backgroundColor = #EEEEEE;this.style.borderColor = #DDDDDD;'><a href='uploadCourseFile.php' class='one'><font color=$_SESSION[hcolor]>+ Upload</font></a></div></strong></div>");
			else
				echo("<div style='background-color:#FFFFFF; font-size:16px; width:740px; padding-top:15px;padding-bottom:20px; color:#666666' align='center'><strong>The user has no course files uploaded ...</strong></font></div>");
		}
		
		while($object = mysql_fetch_object($q)){
			$file_id = $object->file_id;
			$file_name = $object->file_name;
			$course_uid = $object->course_uid;
			$file_size = $object->file_size;
			$dstatus = $object->dstatus;
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			$course_id = $object->course_id;
			$course_name = $object->course_name;
			$course_name = substr($course_name,0,20)."...";
			$pid = $object->pid;
			$descrip = $object->descrip;
			if(trim($pid)=="XXXXXXXXX")$pid="";
			else $pid = "| ".$pid;
			if(trim($dstatus)=='F')$dstatus = "Only friends can download";
			else if(trim($dstatus)=='R')$dstatus = "Only for requested & approved";
			else if(trim($dstatus)=='A')$dstatus = "Everyone can download";
			if(strlen($descrip)==0 || $descrip==NULL) $descrip = "No description for this file";
		?>
			<table width="710" height="30" border="0" cellpadding="0" cellspacing="0" background="" bgcolor="#FFFFFF" style="margin-top:5px">
              <tr>
                <td width="30" height="30" style="padding-left:5px">
				<img src="img/fileWhiteIcon.jpg" width="25" />				</td>
                <td width="210" height="30" align="left" style="padding-left:10px; font-size:12px; font-weight:bold">
				<?php echo("<a href='course_upload/$uid/$course_uid/$file_name' class=one>".substr($file_name,0,28)."...</a>"); ?>				</td>
                <td width="173" height="30" align="left" style="padding-left:10px; font-size:12px">
				<?php echo("<a href=CourseDetail.php?course_uid=$course_uid class=one><font color=$_SESSION[hcolor]>$course_id ".$pid."</font></a>") ?>				</td>
                <td width="65" height="30" align="right" style="font-size:12px; padding-right:10px"><?php echo($file_size) ?>KB</td>
                <td width="208" height="30" align="left" style="font-size:12px; padding-left:10px"><?php echo($dstatus) ?></td>
                <td width="54" height="30" align="right" style="font-size:12px; padding-right:10px">
				<a href="FileConfirm.php?file_id=<?php echo($file_id) ?>&&pageName=RockerDetail" class="one">
				<font color=<?php echo($_SESSION['hcolor']) ?>>Delete</font>
				</a>
				</td>
              </tr>
              <tr>
                <td height="35" style="padding-left:5px; border-bottom:1px #EEEEEE solid">&nbsp;</td>
             <td height="35" colspan="5" align="left" bgcolor="" style="padding-left:10px; font-size:12px; line-height:150%; color:#666666; font-weight:bold; border-bottom:1px #EEEEEE solid">
				<?php echo("$descrip") ?>				</td>
                </tr>
            </table>
			<?php } ?>
			</td></tr></table>
			<table style="margin-top:15px; border:1px #EEEEEE solid;" bgcolor="#F5F5F5" align="center">
			<tr><td width="740" align="center" style="padding-bottom:15px">
              <table width="710" height="35" border="0" cellpadding="0" cellspacing="0" bgcolor="#666666" style="border-top:0px #DDDDDD solid; border-bottom:1px #999999 solid; margin-top:15px; margin-bottom:10px">
                <tr>
                  <td width="657"><?php
		$q_resume = mysql_query("SELECT * FROM rockinus.user_file_info WHERE course_uid='0' AND owner='$uid' ORDER BY file_id DESC LIMIT 0, 30");
		if(!$q_resume) die(mysql_error());
		$no_row_resume = mysql_num_rows($q_resume);
		if($uid==$uname) echo("<strong><div style='background-color: ; color: #FFFFFF; font-size:14px; padding-left:5px; padding-right:10px; display:inline; border-top:0px #CCCCCC solid; border-left:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding-top:6px; height:30px'>Your Resume & Cover Letter List <font color=#666666>($no_row_resume)</font></div></strong>");
else echo("<strong><div style='background-color: ; color: #FFFFFF; font-size:14px; padding-left:10px; padding-right:10px; display:inline; border-top:0px #CCCCCC solid; border-left:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding-top:6px; height:30px'>$uid's Resume & Cover Letter List <font color=#666666>($no_row_resume)</font></div></strong>");
				?>
                  </td>
                  <td width="83" align="right" style="padding-right:10px; font-size:12px; font-weight:bold; color:<?php echo($_SESSION['hcolor']) ?>">
				  <?php if($uid==$uname)echo("<a href='uploadCourseFile.php'>+ Upload</a>") ?>
                  </td>
                </tr>
              </table>
			  <?php
		if ($no_row_resume == 0){
			if($uid==$uname)
				echo("<div style='background-color:#FFFFFF; font-size:16px; width:740px; padding-top:15px;  color:#666666; padding-bottom:25px' align='center'><strong>You have no files uploaded ...<br><br><div style='display:inline; background:#EEEEEE; padding:5px; padding-left: 10px; padding-right:10px; border: 1px #DDDDDD solid' onmouseover='this.style.backgroundColor = #DDDDDD; this.style.borderColor = #CCCCCC;' onmouseout='this.style.backgroundColor = #EEEEEE;this.style.borderColor = #DDDDDD;'><a href='uploadCourseFile.php' class='one'><font color=$_SESSION[hcolor]>+ Upload</font></a></div></strong></div>");
			else
				echo("<div style='background-color:#FFFFFF;  color:#666666; font-size:16px; width:740px; padding-top:15px;padding-bottom:20px' align='center'><strong>The user has no files uploaded ...</strong></div>");
		}
		
		while($object = mysql_fetch_object($q_resume)){
			$file_name = $object->file_name;
			$file_id = $object->file_id;
			$file_size = $object->file_size;
			$dstatus = $object->dstatus;
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			$descrip = $object->descrip;
			if(trim($dstatus)=='F')$dstatus = "Only friends can download";
			else if(trim($dstatus)=='R')$dstatus = "Only for requested & approved";
			else if(trim($dstatus)=='A')$dstatus = "Everyone can download";
			if(strlen($descrip)==0 || $descrip==NULL) $descrip = "No description for this file";
		?>
              <table width="710" height="30" border="0" cellpadding="0" cellspacing="0" background="" bgcolor="#ffffff" style="margin-top:5px">
                <tr>
                  <td width="30" height="30" style="padding-left:5px"><img src="img/fileWhiteIcon.jpg" width="25" /> </td>
                  <td width="384" height="30" align="left" style="padding-left:10px; font-size:12px; font-weight:bold"><?php echo("<a href='resume_upload/$uid/$file_name' class=one>".substr($file_name,0,50)."</a>"); ?> </td>
                  <td width="65" height="30" align="right" style="font-size:12px; padding-right:10px"><?php echo($file_size) ?>KB</td>
                  <td width="207" height="30" align="left" style="font-size:12px; padding-left:10px"><?php echo($dstatus) ?></td>
                  <td width="54" height="30" align="right" style="font-size:12px; padding-right:10px">
				  <a href="FileConfirm.php?file_id=<?php echo($file_id) ?>&&pageName=RockerDetail" class="one">
				<font color=<?php echo($_SESSION['hcolor']) ?>>Delete</font>
				</a>
				  </td>
                </tr>
                <tr>
                  <td height="35" style="padding-left:5px; border-bottom:1px #EEEEEE solid">&nbsp;</td>
                  <td height="35" colspan="4" align="left" bgcolor="" style="padding-left:10px; font-size:12px; line-height:150%; color:#666666; font-weight:bold; border-bottom:1px #EEEEEE solid"><?php echo("$descrip") ?> </td>
                </tr>
              </table>
			  <?php } ?>
            </td></tr></table>
			<table width="740" height="30" border="0" cellpadding="0" cellspacing="0" background="img/master.png" style="border-top:0px #DDDDDD solid; border-bottom:1px #999999 solid; margin-top:25px">
              <tr>
                <td width="657">
		<?php
		include 'dbconnect.php';
						
		$sql_stmt = "SELECT hid,uname,subject,rentlease,pdate,ptime,'house_info' AS tbname, type, city, rate, NULL as col_1, NULL as col_2, descrip 
					FROM rockinus.house_info a WHERE uname='$uid' 
					UNION 
					SELECT aid,uname,subject,buysale,pdate,ptime,'article_info' AS tbname,aname,city,rate,delivery,type, descrip 
					FROM rockinus.article_info b WHERE uname='$uid' 
					UNION 
					SELECT foid,creater,subject,category,pdate,ptime,'forum_info' AS tbname,NULL,NULL,NULL,NULL,NULL, descrip 
					FROM rockinus.forum_info b WHERE creater='$uid' 
					UNION 
					SELECT job_id,creater,subject,category,pdate,ptime,'job_info' AS tbname,rstatus,NULL,NULL,NULL,NULL, descrip 
					FROM rockinus.job_info b WHERE creater='$uid' 
					UNION 
					SELECT memoid,sender,NULL,NULL,pdate,ptime,'memo_info' AS tbname,NULL,NULL,NULL,NULL,level,descrip 
					FROM rockinus.memo_info b WHERE sender='$uid' AND descrip<>''
					UNION 
					SELECT course_uid, sender, descrip, rating, pdate, ptime, tbname, NULL, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.course_memo_info c WHERE sender='$uid'  
					UNION 
					SELECT eid, creater, eventTitle, descrip, pdate, ptime, tbname, eventSpot, NULL,NULL, NULL, NULL, NULL 
					FROM rockinus.event_info d WHERE creater='$uid'  
					UNION 
					SELECT cafeid, creater, cafeTitle, descrip, pdate, ptime, tbname, category, location, NULL, NULL, NULL, NULL 
					FROM rockinus.cafe_info e WHERE creater='$uid'  
					UNION 
					SELECT cafefoodid, sender, rating, descrip, pdate, ptime, tbname, type, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.cafefood_memo_info f WHERE sender='$uid'  
					UNION 
					SELECT cid,sender,recipient,NULL,pdate,ptime,'house_comment' AS tbname,hid,NULL,NULL,rstatus,NULL, descrip 
					FROM rockinus.house_comment g WHERE sender='$uid'
					ORDER BY pdate DESC, ptime DESC";
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		 
if($uid==$uname) echo("<strong><div style='background-color: ; color: $_SESSION[hcolor]; font-size:14px; padding-left:5px; padding-right:10px; display:inline; border-top:0px #CCCCCC solid; border-left:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding-top:6px; height:30px'>Personal Information Activity <font color=#666666>($no_row)</font></div></strong>");
else echo("<strong><div style='background-color: ; color: $_SESSION[hcolor]; font-size:14px;  padding-left:5px; padding-right:10px; display:inline; border-top:0px #CCCCCC solid; border-left:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding-top:6px; height:30px'>$uid's Information Activity <font color=#666666>($no_row)</font></div></strong>");
?></td>
                <td width="83" align="right" style="padding-right:10px; font-size:12px">See All &gt;&gt;</td>
              </tr>
            </table>
              <?php
		if($no_row == 0) echo("<div style='padding-top:30px; padding-bottom:30px; padding-left:5px; color:#666666; font-size:16px' align='center'><strong><img src='img/join.jpg'>&nbsp;&nbsp; The user has nothing posted yet ...</strong></div>");
		while($object = mysql_fetch_object($q)){
			$id = $object->hid;			
			$loopname = $object->uname;
			$subject = $object->subject;
			$action = $object->rentlease;		
			$pdate = $object->pdate;
			$ptime = $object->ptime;		
			$tbname = $object->tbname;	
			$xxxx = $object->col_1;
			$aname = $object->col_2;
			$descrip = $object->descrip;
			$type = $object->type;
			$city = $object->city;
			$rate = $object->rate;
			//if(strlen($subject)>50) $subject = substr(trim($subject), 0, 50)."...";	
			if($tbname=="house_info"){
							?>
                <div style="border-bottom:1px #DDDDDD solid; border-top:1px #FFFFFF solid; padding-bottom:15px; padding-top:15px" onmouseover="document.getElementById('dh<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('mh<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('dh<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('mh<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
                  <table width="740" height="70" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="35" rowspan="2" align="center" valign="top" style="padding-top:10">
					  <font size="2" color="<?php echo($_SESSION['hcolor'])?>"><img src="img/housewoodicon.jpg" width="25" height="25" /></font></td>
                      <td width="591" height="35" align="left" style="padding-left:10px; font-size:14px">
					  <?php 
								  echo("<a href=HouseDetail.php?hid=$id class=one><strong>".substr($subject,0,50)." ...</strong></a>");
							  ?></td>
                      <td width="114" style="padding-right:10px" align="right"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5))?> </font> </td>
                    </tr>
                    <tr>
                      <td height="35" align="left" style="padding-left:10px; padding-top:5px; line-height:150%; font-size:14px">
					  <?php 
						  if(strlen($descrip)>20)
						  	echo(substr(nl2br($descrip),0,500)." ...");
						  else
						    echo("<a href=HouseDetail.php?aid=$id class=one>Click for details >>></a>");
					  ?>					  </td>
                      <td style="padding-right:10px" align="right" valign="top">
					  <?php 
					  if($uname==$loopname)echo("<span id='dh$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=HouseConfirm.php?hid=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='mh$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditHouse.php?hid=$id><font size=1>+ Edit</font></a></span>");
					  ?>					  </td>
                    </tr>
                  </table>
                  <?php
		$x = mysql_query("SELECT * FROM rockinus.house_comment WHERE hid='$id' ORDER BY pdate DESC, ptime DESC");
		if(!$x) die(mysql_error());
		$no_row_house = mysql_num_rows($x);
		if($no_row_house>0){
			while($ob = mysql_fetch_object($x)){
				$cid = $ob->cid;
				$descrip = $ob->descrip;
				$loopsender = $ob->sender;
				$rstatus = $ob->rstatus;
        ?>
                  <table width="740" height="60" border="0" cellpadding="0" cellspacing="0" bgcolor="" style="margin-top:15">
                    <tr>
                      <td height="25" align="right" valign="top" style="padding:8; padding-right:10"><?php
			if($rstatus=="N" && $uid==$uname && $loopsender!=$uname){
				echo("<span style='background-color:#B92828; color: #FFFFFF'><strong>&nbspNew&nbsp;</strong></span>");
				$q_hhis = mysql_query("UPDATE rockinus.house_comment SET rstatus='Y' WHERE cid='$cid';");
				if(!$q_hhis) die(mysql_error());
			}
		?></td>
                      <td width="704" height="25" align="left" valign="middle" bgcolor="#F5F5F5" style="padding-left:8;"><?php 
					  if($loopsender==$uname)echo("<font color=$_SESSION[hcolor]>You</font><font color=#CCCCCC> said:</font>");
					  else echo("<font color=$_SESSION[hcolor]>$loopsender</font><font color=#CCCCCC>  said:</font>") 
					  ?></td>
                      </tr>
                    <tr>
                      <td width="36" height="30" align="right" valign="top" style="padding-top:5px">&nbsp;</td>
                      <td height="30" align="left" valign="middle" bgcolor="#F5F5F5" style="padding:8; font-size:14px; line-height:150%">
					  <?php 
						 echo($descrip);
					  ?>					  </td>
                      </tr>
                  </table>
                  <?php
					  				}
								} 
								?>
                </div>
              <?php	}else if($tbname=="article_info"){
							?>
                <div style="border-bottom:1px #DDDDDD solid; border-top:0px #EEEEEE solid; padding-bottom:15px; padding-top:15px" onmouseover="document.getElementById('da<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('ma<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('da<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('ma<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
                  <table width="740" height="70" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="33" rowspan="2" align="center" valign="top" style="padding-top:10">
					  <font size="2" color="<?php echo($_SESSION['hcolor'])?>"><img src="img/dollar.jpg" width="25" height="25" /></font></td>
                      <td width="586" height="35" align="left" style="padding-left:10px; font-size:14px">
					  <?php 
						  echo("<a href=ArticleDetail.php?aid=$id class=one><strong>".substr($subject,0,40)." ...</strong></a>");
					?>
					</td>
                      <td width="121" style="padding-right:10px" align="right"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5))?></font></td>
                    </tr>
                    <tr>
                      <td height="35" align="left" valign="top" style="padding: 10; padding-top:5px; font-size:14px; line-height: 150%">
					  <?php 
						  if(strlen($descrip)>20)
						  	echo(substr(nl2br($descrip),0,500)." ...");
						  else
						    echo("<a href=ArticleDetail.php?aid=$id class=one>Click for details >>></a>");
					  ?>					  </td>
                      <td style="padding-right:10px" align="right" valign="top">
					  <?php 
					  if($uname==$loopname)echo("<span id='da$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=ArticleConfirm.php?aid=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='ma$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditArticle.php?aid=$id><font size=1>+ Edit</font></a></span>");
					  ?>					  </td>
                    </tr>
                  </table>
                  <?php
		$y = mysql_query("SELECT * FROM rockinus.article_comment WHERE aid='$id' ORDER BY pdate DESC, ptime DESC");
		if(!$y) die(mysql_error());
		$no_row_article = mysql_num_rows($y);
		if($no_row_article>0){
			while($obj = mysql_fetch_object($y)){
				$cid = $obj->cid;
				$descrip = $obj->descrip;
				$loopsender = $obj->sender;
				$rstatus = $obj->rstatus;
        ?>
                  <table width="740" height="64" border="0" cellpadding="0" cellspacing="0" bgcolor="" style="margin-top:15px">
                    <tr>
                      <td height="25" align="right" valign="middle" style="padding-right:10">
                        <?php
			if($rstatus=="N" && $uid==$uname && $loopsender!=$uname){
				echo("<span style=background-color:#B92828; color:#FFFFFF><strong>&nbspNew&nbsp;</strong></span>");
				$q_ahis = mysql_query("UPDATE rockinus.article_comment SET rstatus='Y' WHERE cid='$cid';");
				if(!$q_ahis) die(mysql_error());
			}
		?>
                      </td>
                      <td width="707" height="25" align="left" valign="middle" bgcolor="#F5F5F5" style="padding:8; font-size:14px">
					  <?php 
					  if($loopsender==$uname)echo("<font color=$_SESSION[hcolor]>You</font><font color=#CCCCCC> said:</font>");
					  else echo("<font color=$_SESSION[hcolor]>$loopsender</font><font color=#CCCCCC>  said:</font>") 
					  ?></td>
                      </tr>
                    <tr>
                      <td width="33" height="39" align="right" valign="top" style="padding-top:10">&nbsp;</td>
                      <td height="39" align="left" valign="top" bgcolor="#F5F5F5" style="padding:8;"><?php 
								 echo($descrip);
							  ?></td>
                      </tr>
                  </table>
                  <?php
					  				}
								} 
								?>
                </div>
              <?php 
							}else if($tbname=="forum_info"){
							?>
                <div style="border-bottom:1px #DDDDDD solid; border-top:1px #FFFFFF solid; padding-bottom:20px; padding-top:15px" onmouseover="document.getElementById('df<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('mf<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('df<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('mf<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
                  <table width="740" height="70" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="32" rowspan="2" align="center" valign="top" style="padding-top:10">
					  <font size="2" color="<?php echo($_SESSION['hcolor'])?>">
					  <img src="img/notesicon.jpg" width="25" height="25" /></font></td>
                      <td width="572" height="35" align="left" style="padding-left:10px; line-height: 150%; font-size:14px">
					  <?php 
						  echo("<a href=forumDetail.php?foid=$id class=one><strong>".substr($subject,0,80)." ...</strong></a>");
						?>
						</td>
                      <td width="136" style="padding-right:10px" align="right"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5))?> </font> </td>
                    </tr>
                    <tr>
                      <td height="35" align="left" style="padding:10px; padding-top:5px; line-height:150%; font-size:15px">
					  <?php 
						  if(strlen($descrip)>20)
						  	echo(substr(nl2br($descrip),0,500)." ...");
						  else
						    echo("<a href=forumDetail.php?aid=$id class=one>Click for details >>></a>");
					  ?>					  </td>
                      <td style="padding-right:10px" align="right" valign="top">
					  <?php 
					  if($uname==$loopname)echo("<span id='df$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=ForumConfirm.php?foid=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='mf$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditForum.php?foid=$id><font size=1>+ Edit</font></a></span>");
					  ?>					  </td>
                    </tr>
                  </table>
                  <?php
		$y = mysql_query("SELECT * FROM rockinus.forum_history WHERE foid='$id' ORDER BY pdate DESC, ptime DESC");
		if(!$y) die(mysql_error());
		$no_row_forum = mysql_num_rows($y);
		if($no_row_forum>0){
			while($obj = mysql_fetch_object($y)){
				$cid = $obj->cid;
				$descrip = $obj->descrip;
				$loopsender = $obj->sender;
				$rstatus = $obj->rstatus;
				$pdate = $obj->pdate;
				$ptime = $obj->ptime;
        ?>
                  <table width="730" height="30" border="0" cellpadding="0" cellspacing="0" bgcolor="" style="margin-top:15px">
                    <tr>
                      <td height="30" align="right" valign="middle" style="padding-right:10">
					  <?php
			if($rstatus=="N" && $uid==$uname && $loopsender!=$uname){
				echo("<span style='background-color:#B92828; font-size:11px; color: #FFFFFF'><strong>&nbspNew&nbsp;</strong></span>");
				$q_fhis = mysql_query("UPDATE rockinus.forum_history SET rstatus='Y' WHERE cid='$cid';");
				if(!$q_fhis) die(mysql_error());
			}
		?>
					  </td>
                      <td width="405" height="30" align="left" valign="middle" bgcolor="#F5F5F5" style="padding:8; font-size:14px">
					  <?php 
					  if($loopsender==$uname)echo("<font color=$_SESSION[hcolor]><strong>You</strong></font> said:");
					  else echo("<font color=$_SESSION[hcolor]><strong>$loopsender</strong></font> said:") 
					  ?>					  </td>
                      <td width="293" align="right" valign="middle" bgcolor="#F5F5F5" style="padding-right:10; border-bottom:#DDDDDD solid 0">
					  <font size="1">
					  <?php echo($pdate." | ".$ptime) ?>					  </font>					  </td>
                    </tr>
                    <tr>
                      <td width="32" height="30" align="right" valign="top" style="padding-top:10; padding-right:10">					                        </td>
                      <td height="30" colspan="2" align="left" valign="top" bgcolor="#F5F5F5" style=" border:0 solid #F5F5F5; padding:8;line-height:150%; font-size:14px"><?php 
								 echo($descrip);
							  ?>						</td>
                      </tr>
                  </table>
                  <?php
						}
					} 
				 ?>
                </div>
              <?php }else if($tbname=="job_info"){
							?>
                <div style="border-bottom:1px #DDDDDD solid; border-top:1px #FFFFFF solid; padding-bottom:20px; padding-top:15px" onmouseover="document.getElementById('df<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('mf<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('df<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('mf<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
                  <table width="740" height="70" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="32" rowspan="2" align="center" valign="top" style="padding-top:10">
					  <font size="2" color="<?php echo($_SESSION['hcolor'])?>">
					  <img src="img/notesicon.jpg" width="25" height="25" /></font></td>
                      <td width="572" height="35" align="left" style="padding-left:10px; line-height: 150%; font-size:14px">
					  <?php 
						  echo("<a href=jobDetail.php?job_id=$id class=one><strong>".substr($subject,0,80)." ...</strong></a>");
						?>
						</td>
                      <td width="136" style="padding-right:10px" align="right"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5))?> </font> </td>
                    </tr>
                    <tr>
                      <td height="35" align="left" style="padding:10px; padding-top:5px; line-height:150%; font-size:15px">
					  <?php 
						  if(strlen($descrip)>20)
						  	echo(substr(nl2br($descrip),0,500)." ...");
						  else
						    echo("<a href=jobDetail.php?aid=$id class=one>Click for details >>></a>");
					  ?>					  </td>
                      <td style="padding-right:10px" align="right" valign="top">
					  <?php 
					  if($uname==$loopname)echo("<span id='df$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=JobConfirm.php?job_id=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='mf$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditJob.php?job_id=$id><font size=1>+ Edit</font></a></span>");
					  ?>					  </td>
                    </tr>
                  </table>
                  <?php
		$y = mysql_query("SELECT * FROM rockinus.job_history WHERE job_id='$id' ORDER BY pdate DESC, ptime DESC");
		if(!$y) die(mysql_error());
		$no_row_job = mysql_num_rows($y);
		if($no_row_job>0){
			while($obj = mysql_fetch_object($y)){
				$cid = $obj->cid;
				$descrip = $obj->descrip;
				$loopsender = $obj->sender;
				$rstatus = $obj->rstatus;
				$pdate = $obj->pdate;
				$ptime = $obj->ptime;
        ?>
                  <table width="730" height="30" border="0" cellpadding="0" cellspacing="0" bgcolor="" style="margin-top:15px">
                    <tr>
                      <td height="30" align="right" valign="middle" style="padding-right:10">
					  <?php
			if($rstatus=="N" && $uid==$uname && $loopsender!=$uname){
				echo("<span style='background-color:#B92828; font-size:11px; color: #FFFFFF'><strong>&nbspNew&nbsp;</strong></span>");
				$q_fhis = mysql_query("UPDATE rockinus.job_history SET rstatus='Y' WHERE cid='$cid';");
				if(!$q_fhis) die(mysql_error());
			}
		?>
					  </td>
                      <td width="405" height="30" align="left" valign="middle" bgcolor="#F5F5F5" style="padding:8; font-size:14px">
					  <?php 
					  if($loopsender==$uname)echo("<font color=$_SESSION[hcolor]><strong>You</strong></font> said:");
					  else echo("<font color=$_SESSION[hcolor]><strong>$loopsender</strong></font> said:") 
					  ?>					  </td>
                      <td width="293" align="right" valign="middle" bgcolor="#F5F5F5" style="padding-right:10; border-bottom:#DDDDDD solid 0">
					  <font size="1">
					  <?php echo($pdate." | ".$ptime) ?>					  </font>					  </td>
                    </tr>
                    <tr>
                      <td width="32" height="30" align="right" valign="top" style="padding-top:10; padding-right:10">					                        </td>
                      <td height="30" colspan="2" align="left" valign="top" bgcolor="#F5F5F5" style=" border:0 solid #F5F5F5; padding:8;line-height:150%; font-size:14px"><?php 
								 echo($descrip);
							  ?>						</td>
                      </tr>
                  </table>
                  <?php
						}
					} 
				 ?>
                </div>
              <?php }else if($tbname=="memo_info"){ ?>
			  <div style="padding-top:15px; padding-bottom: 15px; border-bottom:1px #DDDDDD solid; border-top:1px #FFFFFF solid">
                            <table width="730" height="131" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="32" rowspan="2" align="center" valign="top" style="padding-top:10px">
								<img src="img/writeamessageIcon.jpg" width="25" height="25"/> </td>
                                <td width="548" align="left" valign="top" style="padding-left:10px; font-size:14px; padding-top:10px; padding-bottom:5">
								<?php
							  	if($uname==$uid)	
									echo("You have a new status: ");
							  	else
									echo("$uid has a new status: ");
							  ?>                                </td>
                                <td width="155" height="18" align="right" valign="top" style="padding-right:10px; padding-top:10px"><font size="1"><a href='#' class="one"></a></font> <font size="1">
                                  <?php
							  echo("$pdate | ".substr($ptime,0,5));
							  ?>
                                </font> </td>
                              </tr>
                              <tr>
                                <td height="18" colspan="2" align="left" valign="top" style="padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:15px; line-height:150%; border:0px #DDDDDD dashed; font-weight: bold; font-size:12px" bgcolor=""><font color=>
                                  <?php 
								echo(nl2br($descrip));
								?>
                                </font> </td>
                              </tr>
                              <tr>
                                <td height="52" align="center" valign="middle" style="line-height:150%">&nbsp;</td>
                                <td height="52" colspan="2" align="left" valign="top" style="padding-left:10px; padding-right:5px; padding-top:10px; padding-bottom:5px; line-height:150%; border:0px #DDDDDD dashed">
								<?php 
$q_n = mysql_query("SELECT * FROM rockinus.memo_follow_info WHERE memoid='$memoid' ORDER BY memofid DESC");
if(!$q_n) die(mysql_error());
$no_row_memoreply = mysql_num_rows($q_n);

$q1 = mysql_query("SELECT * FROM rockinus.memo_follow_info WHERE memoid='$memoid' ORDER BY memofid DESC LIMIT 0,10");
if(!$q1) die(mysql_error());
if($no_row_memoreply == 0){ 
	if($gender=="Female")$g = "her something";
	else if($gender=="Male")$g = "him something";
	else $g=" something";
}else if($no_row_memoreply > 0){ 
	while($object = mysql_fetch_object($q1)){
		$memofid = $object->memofid;
		$sender = $object->sender;
		$recipient = $object->recipient;
		$descrip = $object->descrip;
		$ptime = $object->ptime;
		$pdate = $object->pdate; 
		$rstatus = $object->rstatus; 
 ?>
          <div style="line-height:180%; margin-bottom:10px; width: 680px; border:0px #EEEEEE solid" align="left">
            <form action="RockerDetail.php" method="post" style="margin:0">
              <table width="680" height="63" border="0" cellpadding="2" cellspacing="0" bgcolor="#F5F5F5" style="border:0px solid #EEEEEE">
                <tr>
                  <td width="177" height="29" align="left" bgcolor="#F5F5F5" style=" padding-left:10; border-bottom:0px dashed #DDDDDD"><script language="JavaScript" type="text/javascript">
$(document).ready(function() { 
	$('.<?php echo($memofid) ?>').click(function(){ 
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
                      <font size="2">
					  <a class="<?php echo($memofid) ?>">
					  <?php echo("<font color=$_SESSION[hcolor]><strong>$sender</strong></font> said :") ?>					  </a>					  </font>
                      <?php
//				  if($recipient!=$uid)
//				  	echo("@ $uid");
				?>
                    </td>
                  <td width="55" bgcolor="#F5F5F5" style="border-bottom:0px dashed #DDDDDD"><input type="hidden" name="memofid" value="<?php echo($memofid) ?>" />
                      <input type="hidden" name="uid" value="<?php echo($uid) ?>" />                  </td>
                  <td width="214" align="right" valign="middle" bgcolor="#F5F5F5" style="border-bottom:0px dashed #DDDDDD">&nbsp;
                      <?php if($uname==$sender){ ?>
                      <input type="submit" style="font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 10px;background-color: #FFFFFF; border:1 #CCCCCC solid;" name="delmemosubmit" value="delete" />
                    <?php }else if($rstatus=='N'){ ?>
					<div style="font-size: 10px; background-color: #B92828; border:1 #000000 solid; display:inline; color:#FFFFFF">
					New
					</div>
                    <?php 
						$q_mhis = mysql_query("UPDATE rockinus.memo_follow_info SET rstatus='Y' WHERE memofid='$memofid';");
						if(!$q_mhis) die(mysql_error());
					} ?>
					</td>
                  <td width="214" align="right" bgcolor="#F5F5F5" style="padding-right:10px; border-bottom:0px dashed #DDDDDD"><font color="#999999" size="1"> <?php echo(substr($pdate,5,8)." | ".substr($ptime,0,5)) ?> </font> </td>
                </tr>
                <tr>
                  <td height="22" colspan="4" valign="top" style="padding:10; padding-top:5; line-height:180%; margin-bottom:10px; border-top:0px solid #EEEEEE; font-size:14px">
				  <?php
						echo($descrip);
					?>                  </td>
                </tr>
              </table>
            </form>
          </div>
          <?php }} ?>
		  	
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
 alert("Please Enter Something ok?");
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
                                        <textarea name="content<?php echo($id) ?>" id="content<?php echo($id) ?>" cols="60" rows="2" style="border:1px #DDDDDD solid;" onfocus="this.style.backgroundColor='#F5F5F5'; this.style.borderColor='#CCCCCC'; " onClick="this.rows=5" onmouseout="this.style.backgroundColor='#FFFFFF';  this.rows=2"></textarea>
                                        &nbsp;&nbsp;&nbsp;
                                        <input type="submit" value="Reply" name="submit" class="comment_button<?php echo($id) ?>" style="margin-top:5px; color:#000000;   font: bold 84%'trebuchet ms',helvetica,sans-serif;   background-color: #FFFFFF; "/>
                            </form>
                                  </div>
		</td>
		       </tr>
            </table>
                  </div>
			  <?php }else if($tbname=="course_memo_info"){ 
			  					$memo_q = mysql_query("SELECT course_name,course_id FROM rockinus.course_info WHERE course_id=(SELECT course_id FROM rockinus.unique_course_info WHERE course_uid ='$id');");
								if(!$memo_q) die(mysql_error());
								$obj = mysql_fetch_object($memo_q); 
								$course_id = $obj->course_id;
								$course_name = $obj->course_name;
						  ?>
                <div style="border-bottom:1px #DDDDDD solid; border-top:0px #EEEEEE solid;  padding-bottom:20px; padding-top:15px">
                  <table width="740" height="70" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="33" rowspan="2" align="center" valign="top" style="padding-top:10">
					  <img src="img/book100.jpg" width="25" height="25" /></td>
                      <td width="591" height="35" style="padding-left:10px; font-size:14px"><?php
							  	echo("Commented on <a href=CourseDetail.php?course_uid=$id class=one><font color=$_SESSION[hcolor]><strong>$course_id - ".substr($course_name,0,22)."</strong></font></a>");
							  ?></td>
                      <td width="116" height="35" align="right" style="padding-right:10px"><font size="1"><?php echo("$pdate | ".substr($ptime,0,5)) ?></font> </td>
                    </tr>
                    <tr>
                      <td height="35" style="padding-left:10px; line-height:150%; font-size:14px; padding-top: 10" valign="top">
					  <?php 
						echo(nl2br($subject));
							  ?></td>
                      <td height="35" align="right" style="padding-right:10; padding-top:10" valign="top"><?php 
								for($i=0;$i<$action;$i++)
									echo("<img src=img/yellowstar.jpg /> "); 
								?>                      </td>
                    </tr>
                  </table>
                </div>
              <?php }else if($tbname=="event_info"){  ?>
                <div style=" padding-top:15px; padding-bottom:15px; border-bottom:1px #DDDDDD solid; border-top:0px #EEEEEE solid;" onmouseover="document.getElementById('de<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('me<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('de<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('me<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
                  <table width="740" height="110" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="32" height="40" align="center" style="padding-top:10px" valign="top">
					  <img src="img/calendar100.jpg" width="25" height="25"/>					  </td>
                      <td width="589" height="40" style="padding-left:10; padding-top:10; font-size:14px" valign="top">
					  <?php 
						echo("<a href=eventDetail.php?eid=$id class=one><strong>$subject</strong></a>");
						?>						</td>
                      <td width="119" height="40" align="right" style="padding-right:10px"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5)) ?></font> </td>
                    </tr>
                    <tr>
                      <td width="32" height="35" style="padding-left:5px">&nbsp;</td>
                      <td height="35" style="padding-left:10px; padding-bottom:10px; padding-top:5px; line-height:150%; font-size:14px">
					  <?php 
						  echo(nl2br($action));
					  ?>					  </td>
                      <td height="35" align="right" style="padding-right:10; padding-top:5" valign="top">
					  <?php 
					  if($uname==$loopname)echo("<span id='de$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EventConfirm.php?eid=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='me$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditEvent.php?eid=$id&&pageName=RockerDetail><font size=1>+ Edit</font></a></span>");
					  ?>					  </td>
                    </tr>
                    <tr>
                      <td height="35" style="padding-left:5px">&nbsp;</td>
                      <td height="5" colspan="2" style="padding-left:10px; padding-bottom:10px; padding-top:5px; line-height:150%; font-size:14px"><?php 
$q_n = mysql_query("SELECT * FROM rockinus.event_history WHERE eid='$id' ORDER BY cid DESC");
if(!$q_n) die(mysql_error());
$no_row_memoreply = mysql_num_rows($q_n);
//echo($no_row_memoreply);
$q_e = mysql_query("SELECT * FROM rockinus.event_history WHERE eid='id' ORDER BY cid DESC LIMIT 0,10");
if(!$q_e) die(mysql_error());
//if($no_row_memoreply > 0){ 
if(1>2){
	$obj = mysql_fetch_object($q_e); 
	while($object = mysql_fetch_object($q_e)){
		$cid = $object->cid;
		$sender = $object->sender;
		$recipient = $object->recipient;
		$descrip = $object->descrip;
		$ptime = $object->ptime;
		$pdate = $object->pdate; 
		$rstatus = $object->rstatus; 
 ?>
                        <div style="line-height:180%; margin-bottom:15px; width: 680px; border:0px #EEEEEE solid" align="left">
                          <form action="RockerDetail.php" method="post" style="margin:0">
                            <table width="680" height="63" border="0" cellpadding="2" cellspacing="0" bgcolor="#F5F5F5" style="border:0px solid #EEEEEE">
                              <tr>
                                <td width="177" height="29" align="left" bgcolor="#F5F5F5" style=" padding-left:10; border-bottom:0px dashed #DDDDDD"><script language="JavaScript" type="text/javascript">
$(document).ready(function() { 
	$('.<?php echo($memofid) ?>').click(function(){ 
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
                                    <font size="2"> <a class="<?php echo($memofid) ?>"> <?php echo("<font color=$_SESSION[hcolor]><strong>$sender</strong></font> said :") ?> </a> </font>
                                    <?php
//				  if($recipient!=$uid)
//				  	echo("@ $uid");
				?>
                                    </font></td>
                                <td width="55" bgcolor="#F5F5F5" style="border-bottom:0px dashed #DDDDDD"><input type="hidden" name="memofid2" value="<?php echo($cid) ?>" />
                                    <input type="hidden" name="uid2" value="<?php echo($uid) ?>" />                                </td>
                                <td width="214" align="right" valign="middle" bgcolor="#F5F5F5" style="border-bottom:0px dashed #DDDDDD">&nbsp;
                                    <?php if($uname==$sender){ ?>
                                    <input type="submit" style="font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 10px;background-color: #FFFFFF; border:1 #CCCCCC solid;" name="delmemosubmit2" value="delete" />
                                    <?php }else if($rstatus=='N'){ ?>
                                    <div style="font-size: 10px; background-color: #B92828; border:1 #000000 solid; display:inline; color:#FFFFFF"> New </div>
                                    <?php 
						$q_mhis = mysql_query("UPDATE rockinus.memo_follow_info SET rstatus='Y' WHERE memofid='$memofid';");
						if(!$q_mhis) die(mysql_error());
					} ?>                                </td>
                                <td width="214" align="right" bgcolor="#F5F5F5" style="padding-right:10px; border-bottom:0px dashed #DDDDDD"><font color="#999999" size="1"> <?php echo(substr($pdate,5,8)." | ".substr($ptime,0,5)) ?> </font> </td>
                              </tr>
                              <tr>
                                <td height="22" colspan="4" valign="top" style="padding:10; padding-top:5; line-height:180%; margin-bottom:10px; border-top:0px solid #EEEEEE; font-size:14px"><?php
						echo($descrip);
					?>                                </td>
                              </tr>
                            </table>
                          </form>
                        </div>
                        <?php }} ?>
                        <script type="text/javascript" >
                        </script></td>
                      </tr>
                  </table>
                </div>
              <?php }else if($tbname=="cafe_info"){  ?>
                <div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:0; padding-bottom:2px; border-bottom:1px #EEEEEE solid" onmouseover="this.style.backgroundColor = '#F5F5F5';this.style.borderColor = '#DDDDDD';" onmouseout="this.style.backgroundColor = 'white';this.style.borderColor = '#EEEEEE';">
                  <table width="740" height="95" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="65" height="30" rowspan="2" bgcolor="#FFFFFF" style="padding-right:5px; padding-top:10px" valign="top"><img src="img/<?php echo($aname."FoodIcon.jpg") ?>" width="50" height="50" /></td>
                      <td width="552" height="35" style="padding-left:10px; padding-top:10px" valign="top"><?php echo("<a href=RockerDetail.php?uid=$loopname><font color=$_SESSION[hcolor]><strong>$loopname</strong></font></a> introduced a <a href=foodcafe.php?cafeid=$id class=one>new Cafe</a>:") ?> </td>
                      <td width="123" height="35" align="right" style="padding-right:10px"><font size="1">
                        <?php 
	//							echo(date("y-m-d",time()));
	//							echo(substr(date(" G:i:s",time()),2,17));
								echo(" $pdate | ".substr($ptime,0,5)) ?>
                      </font> </td>
                    </tr>
                    <tr>
                      <td height="35" style="padding-left:10px; padding-top:5px" valign="top"><?php 
										  echo("<a href=CafeDetail.php?cafeid=$id class=one><font size=3><strong>$subject</strong></font></a>");
							  ?></td>
                      <td width="123" height="35" align="right" style="padding-right:10px">
					  <?php 
					  if($uname==$loopname)echo("<a href=editHouse.php?hid=$id class=one><font size=1><strong>+ Edit</strong></font></a>");
					  ?>
					  </td>
                    </tr>
                    <tr>
                      <td width="65" height="30" style="padding-left:5px">&nbsp;</td>
                      <td height="30" style="padding-left:10px; padding-bottom:10px; padding-top:5px; line-height:150%" valign="top"><font color="#999999"><?php echo("<font size=2 color=#666666><strong>$action</strong></font>") ?></font></td>
                      <td height="30" align="right" style="padding-right:5px">&nbsp;</td>
                    </tr>
                  </table>
                </div>
              <?php }else if($tbname=="cafefood_memo_info"){  
						  if($aname=="c"){
						  	$q1 = mysql_query("SELECT * FROM rockinus.cafe_info WHERE cafeid='$id' ;");
						  	if(!$q1) die(mysql_error());
						  	$obj = mysql_fetch_object($q1);
						  	$cafeTitle = $obj->cafeTitle;
						  	$category = $obj->category;
						  ?>
                <div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:0; padding-bottom:10px; border-bottom:1px #EEEEEE solid" onmouseover="this.style.backgroundColor = '#F5F5F5';this.style.borderColor = '#DDDDDD';" onmouseout="this.style.backgroundColor = 'white';this.style.borderColor = '#EEEEEE';">
                  <table width="740" height="80" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="65" height="40" rowspan="3" bgcolor="#FFFFFF" valign="top" style="padding-right:5px; padding-top:10px"><img src="img/<?php echo($category."FoodIcon.jpg") ?>" width="50" height="50" /> </td>
                      <td width="553" height="20" style="padding-left:10px; padding-top:10px" valign="top"><?php echo("<a href=RockerDetail.php?uid=$loopname><font color=black><strong>$loopname</strong></font></a> commented on <a href=cafeDetail.php?cafeid=$id class=one><strong><font color=$_SESSION[hcolor]>$cafeTitle</font></a> </strong>") ?> </td>
                      <td width="122" height="20" align="right" style="padding-right:10px"><font size="1">
                        <?php 
	//							echo(date("y-m-d",time()));
	//							echo(substr(date(" G:i:s",time()),2,17));
								echo(" $pdate | ".substr($ptime,0,5)) ?>
                      </font> </td>
                    </tr>
                    <tr>
                      <td height="20" style="padding-left:10px; padding-top:10px" valign="top"><?php echo("<strong><font color=#999999>[$category Food]</font></strong>"); ?> </td>
                      <td height="20" align="right" style="padding-right:10px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="20" style="padding-left:10px; padding-top:10px" valign="top"><?php 
									echo("<a href=CafeDetail.php?cafeid=$id class=one><font size=2 color=#999999>");
										  
									$len = strlen($action);
									$single_line_len = 70;
									$line_no = $len/$single_line_len; 
							
									for($i=0;$i<$line_no;$i++) {
										$str = substr($action,$i*$single_line_len, $single_line_len)."<br>";
										echo("<font size=2 color=#666666><strong>$str</strong></font>");
									}
								echo("</font></a>");
							  ?>                      </td>
                      <td width="122" height="20" align="right" style="padding-right:10px"><?php 
								for($i=0;$i<$subject;$i++)
									echo("<img src=img/ThumbUpIcon20.jpg /> "); 
								?>                      </td>
                    </tr>
                  </table>
                </div>
              <?php } } }?>            
			  </td>
          </tr>
        </table></td>
        <td width="5" colspan="0" align="left" valign="top" style="border-left: #EEEEEE solid 0; padding-right:0px">&nbsp;</td>
        <td width="256" rowspan="4" valign="top" style="border-left: #DDDDDD solid 0; padding-bottom:15px" align="right">
		<table width="240" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
          <tr>
            <td width="187" height="25" bgcolor="#EEEEEE" style="border-top:1px solid #DDDDDD; border-bottom:1px solid #DDDDDD; solid #DDDDDD; padding-top:5px; padding-bottom:5px; width:260px">
              <table width="250" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="padding-left:10px" align="left"><strong>Footprints</strong>
                    <?php
			  $v = mysql_query("SELECT visitor, vtime, vdate FROM rockinus.visit_info WHERE host='$uid' ORDER BY vdate DESC, vtime DESC;");
				if(!$v) die(mysql_error());
				$no_row_v = mysql_num_rows($v);
				
			  $v_total = mysql_query("SELECT visitor, vtime, vdate FROM rockinus.visit_history WHERE host='$uid' ORDER BY vdate DESC, vtime DESC;");
				if(!$v_total) die(mysql_error());
				$no_row_v_total = mysql_num_rows($v_total);
				echo("<font color=#999999 size=1>($no_row_v_total)</font>");
			?></td>
                    <td width="63" bgcolor="#F5F5F5" align="right" style="padding-right:5px"><font size="1">See All >></font> </td>
                  </tr>
                </table>
              </td>
            </tr>
          <tr>
            <td height="35" colspan="2" style="padding-top:10px; padding-left:4px; padding-bottom:0px"><?php
		if($no_row_v == 0) echo("<div style='padding-top:10px; padding-left:5px; margin-bottom:10px; font-size: 14px' align='center'><strong><img src='img/join.jpg'>&nbsp;&nbsp; Nobody visited yet...</strong></div>");
		$i = 0;
		while($objv = mysql_fetch_object($v)){
			$i++;
			$visitor = $objv->visitor;
			$vdate = $objv->vdate;
			$vtime = substr($objv->vtime,0,5);
			$visitpic100 = $visitor.'100.jpg';
			//date('Y-m-d, H:i');
			$target_visitor = "upload/".$visitor;
			if(is_dir($target_visitor)){
				echo("<a href='RockerDetail.php?uid=$visitor' class=one title='$visitor | $vdate, $vtime'><img src=upload/$visitor/$visitpic100?".time()." width=75 height=75 style='margin-right:9px'></a>");
			}else 
				echo("<a href='RockerDetail.php?uid=$visitor' class=one title='$visitor | $vdate, $vtime'><img src='img/NoUserIcon100.jpg' width=75 height=75 style='margin-right:9px'></a>");
			if($i%3==0)echo("<p style='margin-top:5px'>");
			if($i==6)break;
		}
		?>            </td>
            </tr>
          <tr>
            <td height="35" colspan="2" style="padding-top:15px"><?php 
			  	if($uid!=$uname){
					$mutal_q = mysql_query("SELECT sender FROM rockinus.rocker_rel_info WHERE recipient='$uid' AND 
										sender in (
											SELECT sender FROM rockinus.rocker_rel_info WHERE recipient='$uname'
											UNION 
											SELECT recipient FROM rockinus.rocker_rel_info WHERE sender='$uname'
										) AND sender<>'$uname'
									UNION
									SELECT recipient FROM rockinus.rocker_rel_info WHERE sender='$uid' AND
										recipient in (
											SELECT sender FROM rockinus.rocker_rel_info WHERE recipient='$uname'
											UNION 
											SELECT recipient FROM rockinus.rocker_rel_info WHERE sender='$uname'
										) AND recipient<>'$uname';");
					if(!$mutal_q) die(mysql_error());
					$no_row_mutal = mysql_num_rows($mutal_q);
					if($no_row_mutal>0){
				 ?>
              <div style="margin-top:5px; border-bottom:0px solid #DDDDDD; border-top:0px solid #DDDDDD; padding-top:5px; padding-bottom:5px; padding-left:0px; background-color:#EEEEEE">
                <table width="240" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td style="padding-left:10px" align="left"><strong>Mutal Friends</strong>
                      <?php
				echo("<font color=#999999 size=1>($no_row_mutal)</font>");
			?></td>
                        <td width="63" bgcolor="#F5F5F5" align="right" style="padding-right:5px"><font size="1">See All &gt;&gt;</font> </td>
                      </tr>
                  </table>
                  </div>
                <div style="padding: 8px; padding-left:2">
                  <?php
		$m = 0;
		while($obj_mutal = mysql_fetch_object($mutal_q)){
			$m++;
			$mutal_uname = $obj_mutal->sender;
			$mutal_unamepic100 = $mutal_uname.'100.jpg';
			//date('Y-m-d, H:i');
			$target_mutal_uname = "upload/".$mutal_uname;
			if(is_dir($target_mutal_uname)){
				echo("<a href='RockerDetail.php?uid=$mutal_uname' class=one title='$mutal_uname'><img src=upload/$mutal_uname/$mutal_unamepic100?".time()." width=75 height=75 style='margin-right:5px'></a>");
			}else 
				echo("<a href='RockerDetail.php?uid=$mutal_uname' class=one title='$mutal_uname'><img src='img/NoUserIcon100.jpg' width=75 height=75 style='margin-right:5px'></a>");
			if($m%3==0)echo("<p style='margin-top:5px'>");
			if($m==6)break;
		}
		?>
                  </div>
                <?php
				   } 
				  }
				  ?></div>
                </div>
                <table width="240" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:15px;">
                  <tr>
                    <td height="29" colspan="0" align="left" style="padding-left:10px; padding-top:6px; padding-bottom:6px; margin-bottom:2px; background: url(img/master.png); border-bottom:1px #CCCCCC solid; border-top:1px #EEEEEE solid;  width:250px; font-size:14px" class="hobbyDiv" id="hobbyDiv"><strong>
                      <?php 
				//query: **EDIT TO YOUR TABLE NAME, ETC.
				$sql_stmt = "SELECT * FROM rockinus.user_hobby_info WHERE uname='$uid';";
				$q = mysql_query($sql_stmt);
				if(!$q) die(mysql_error());
				$no_row = mysql_num_rows($q);
				if($no_row == 0) echo("");
				$object = mysql_fetch_object($q);
				$hobbyArray = explode(",",$object->hobby);
		
				if( $object->hobby == NULL ){
					if($_SESSION['lan']=='CN')
					  echo("我的关注");
					  else if($_SESSION['lan']=='EN')
					  echo("Interested things");
				}else{
					if($_SESSION['lan']=='CN')
					  echo("我的关注 | <a href=EditHobbyInfo.php class=one><font color=#999999>增加+</font></a>");
					  else if($_SESSION['lan']=='EN')
					  echo("Interested Items <a href=EditHobbyInfo.php class=one><font color=#999999 style='font-size:12px'>(+Add)</font></a>");
				}
				  ?>
                    </strong> </td>
                  </tr>
                  <tr>
                    <td style="padding-top:5px"><?php
					if( $object->hobby == NULL ){
						if($_SESSION['lan']=='CN')
					  		echo("<div style='padding:10px; line-height:150%; background-color=#F5F5F5' align=left>增加喜欢和关注的事物，会在第一时间收到所关心的内容. <a href=EditHobbyInfo.php class=one><strong><u><font color=$_SESSION[hcolor]>马上添加+</font></u></strong></a></div>");
					  	else if($_SESSION['lan']=='EN')
					  		echo("<table><tr><td style='padding:10px; line-height:150%; background-color=#F5F5F5; width:340px; font-size:14px' align=left>Adding interested items help you updated with things your cared about. <a href=EditHobbyInfo.php class=one><strong><u><font color=$_SESSION[hcolor]>Add Now+</font></u></strong></a></td></tr></table>");
				}else{
					for($i=0;$i<count($hobbyArray);$i++){
						$t = mysql_query("
						SELECT count(*) AS cnt FROM rockinus.user_hobby_info 
						WHERE hobby LIKE '%$hobbyArray[$i]%' AND uname in 
						(SELECT DISTINCT sender FROM rockinus.rocker_rel_info WHERE recipient='$uname'  
						UNION ALL
						SELECT DISTINCT recipient FROM rockinus.rocker_rel_info WHERE sender='$uname')");
						$a = mysql_fetch_object($t);
						$total_items = $a->cnt;
			?>
                        <table width="250" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px #EEEEEE dashed">
                          <tr>
                            <td width="40" height="35" style="padding-left:5px; padding-top: 3px"><?php
									$loopImg = "img/$hobbyArray[$i]"."100.jpg";
							  if(file_exists($loopImg)) echo("<img src=$loopImg width=25 />");
							  else echo("<img src=img/cactusct.jpg width=25 />");
							  ?></td>
                            <td width="290" align="left" style="padding-left:5px; font-size:12px"><a href="FriendGroup.php?hobby=<?php echo $hobbyArray[$i] ?>" class="one"> <font color="<?php echo($_SESSION['hcolor']) ?>"> <strong>
                              <?php 
								echo(ucfirst($hobbyArray[$i]));
								?>
                              </strong> </font> <font style="font-size:12px; color:#666666"> &nbsp;&nbsp;
                                <?php 
						  if($total_items>1)
							  echo "(".$total_items." students like it.)"; 
						  else 
						  	echo "(".$total_items." student likes it.)" ;
						  ?>
                            </font> </a> </td>
                          </tr>
                        </table>
                      <?php } }?>
                      </div></td>
                  </tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" style=" margin-top:15px">
				  <tr><td style="margin-top:25px; margin-bottom:0px; border-bottom:1px solid #DDDDDD; border-top:1px solid #DDDDDD; padding-top:5px; padding-bottom:5px; padding-left:10px; background-color:#EEEEEE; font-size:14px; width:250px"><strong>
                <?php 
					include 'dbconnect.php';
$sender = $_SESSION['usrname'];
$q = "SELECT count(*) as cnt FROM rockinus.user_course_info where uname='$uid'";
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if( $total_items==0 ){
	if($_SESSION['lan']=='CN'){
		if($uid==$uname)	
			echo("没有关心的课程 | <a href=EditHobbyInfo.php class=one><u>立即添加</u>>></a>");
	  	else echo("该同学没有关心的课程");
	}else if($_SESSION['lan']=='EN'){
	  	if($uid==$uname)	
			echo("No Courses | <a href=SchoolCourse.php class=one><u>Add Now+</u></a>");
	  	else echo("No Interested Courses");
	}
}else{
	if($_SESSION['lan']=='CN')
	  	echo("<a href=SchoolCourse.php class=one>关心的课程：</a>");
	  else if($_SESSION['lan']=='EN')
	  	echo("<a href=SchoolCourse.php class=one>Connected Courses (".$total_items.")</a>");
}
				?>
                </strong>
				</td>
				</tr>
				</table>
                <?php

if ($total_items == 0 ){
	if($_SESSION['lan']=='CN'){
		if($uid==$uname)
			echo("<div style='padding-top:2px; padding-left:5px; padding-right:5px; padding-bottom:5px; line-height:150%; background-color=#FFFFFFF' align=left>增加自己喜欢和关注的事物，将会在第一时间内更新你所关心的内容.</div>");
		else echo("<div style='padding-top:2px; padding-left:5px; padding-right:5px; padding-bottom:5px; line-height:150%; background-color=#FFFFFFF' align=left>告诉同学，选择关心的课程，会很方便他的学习，这里提供课程的第一手信息！</div>");
	}else if($_SESSION['lan']=='EN'){
		if($uid==$uname)
			echo("<div style='width:250; padding-top:10px; padding-left:10px; padding-right:5px; padding-bottom:10px; line-height:150%; background-color=#FFFFFFF; border:#EEEEEE 1 solid; color:#000000; font-size:14px' align=left>You can add some courses that you are interested, any updates of those courses by other students will reach you soon</div>");
		else echo("<div style='width:250; padding-top:10px; padding-left:10px; padding-right:5px; padding-bottom:10px; line-height:150%; background-color=#FFFFFFF; border:#EEEEEE 1 solid;  color:#000000; font-size:14px' align=left>Add some courses that your friend are interested, any updates of those courses by other students will reach them soon</div>");
	}
}
//echo("&nbsp;<font color=#000000> </font>");
else{
$q = mysql_query("SELECT * FROM rockinus.user_course_info a INNER JOIN rockinus.course_info b INNER JOIN rockinus.unique_course_info c ON a.uname='$uid' AND c.course_uid=a.course_uid AND c.course_id=b.course_id GROUP BY b.course_id ORDER BY a.pdate DESC");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
while($object = mysql_fetch_object($q)){
	$course_uid = $object->course_uid;
	$course_id = $object->course_id;
	$pid = $object->pid;
	$pdate = $object->pdate;
	$course_name = $object->course_name;
?>
              <table width="258" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE;border-left:1px solid #EEEEEE;border-right:1px solid #EEEEEE">
                <tr>
                  <td width="59" height="30" align="left" style="padding-left:0px; font-size:12px; padding-left:5px">
				  <?php echo("<a href=CourseDetail.php?course_uid=$course_uid class=one><font color=$_SESSION[hcolor]>$course_id</font></a>") ?>
				  </td>
                      <td width="130" height="30" align="left" style="font-size:12px">
					  <?php echo("<a href=CourseDetail.php?course_uid=$course_uid class=one>".substr($course_name,0,16)."...</a>") ?></td>
                      <td width="68" height="30" align="right" style="padding-right:5px; font-size:12px">
					  <?php if(strpos($pid,"XXX")=== false)echo(substr($pid,0,8)."..."); else echo("Unknown"); ?>					  </td>
                    </tr>
                </table>
                <?php }} ?></td>
            </tr>
          </table>
              <?php
		  	$sel_stmt = "SELECT * FROM rockinus.rocker_rel_info WHERE sender='$uid' OR recipient='$uid'";
			$q = mysql_query($sel_stmt);
			if(!$q) die(mysql_error());
			$no_row = mysql_num_rows($q);

			if($no_row == 0){
		  		if($uid==$uname)
					echo("<div style='margin-bottom:10px; background-color:#EEEEEE; padding-bottom:5px; font-size:14px; padding-top:5px; padding-left:10px; width:250px; border-top:1px solid #EEEEEE; border-bottom:1px solid #EEEEEE' align='left'><strong>You have no friend</strong></div>");
			  	else{
			  		echo("<div style='margin-bottom:10px; background-color:#EEEEEE; padding-bottom:5px; padding-top:5px; padding-left:10px; width:250px; border-top:1px solid #DDDDDD; margin-top:20px; border-bottom:1px solid #DDDDDD; font-size:14px' align='left'><strong><font color=$_SESSION[hcolor]>$uid</font> has no friend</strong></div>");
				}
			}else if($no_row > 0){
		  		if($uid==$uname)
					echo("<div style='margin-bottom:10px; background-color:#EEEEEE; padding-bottom:5px; padding-top:5px; padding-left:10px; margin-top:20px; width:250px; border-top:1px solid #DDDDDD; border-bottom:1px solid #DDDDDD; font-size:14px' align='left'><a href='FriendGroup.php?myfriends=1' class=one><strong>You have $no_row friend(s)</strong></a></div>");
			  	else 
			  		echo("<div style='margin-bottom:10px; background-color:#EEEEEE; padding-bottom:5px; padding-top:5px; padding-left:10px; margin-top:20px; width:250px; border-top:1px solid #DDDDDD; border-bottom:1px solid #DDDDDD; font-size:14px' align='left'><strong><font color=$_SESSION[hcolor]>$uid</font> has $no_row friend(s)</strong></div>");
			} ?>
          <div align="left">
            <?php 
			if($no_row>0){
			  	$sel_stmt_ten = "SELECT * FROM rockinus.rocker_rel_info WHERE sender='$uid' OR recipient='$uid' LIMIT 0,10";
				$q10 = mysql_query($sel_stmt_ten);
				if(!$q10) die(mysql_error());
		  		while($object = mysql_fetch_object($q10)){
					$loopsender = $object->sender;
					$looprecipient = $object->recipient;
					
						$sel_stmt_friend = "SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_edu_info b 
											ON a.uname='$looprecipient' AND a.uname=b.uname	AND a.uname<>'$uid'
						 					UNION ALL
											SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_edu_info b 
											ON a.uname='$loopsender' AND a.uname=b.uname AND a.uname<>'$uid'";		

					$qfriend = mysql_query($sel_stmt_friend);
					if(!$qfriend) die(mysql_error());
					$ob = mysql_fetch_object($qfriend);
					$loopName = $ob->uname;
					$pic100_Name = $loopName.'100.jpg';
					$fname = $ob->fname;
					$rstatus = NULL;
					$cschool = $ob->cschool;
					if($cschool=="empty") $cschool=NULL;
					$cmajor = $ob->cmajor;
					if($cmajor=="empty") $cmajor=NULL;
					$cdegree = $ob->cdegree;
					$sterm = $ob->sterm;
		  ?>
            <table width="240" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px; margin-left:5px">
              <tr>
                <td width="105" rowspan="3"><span style="padding-top:5; padding-bottom:5">
                  <?php 
					$target = "upload/".$loopName;
					if(is_dir($target))
				  echo("<a href='RockerDetail.php?uid=$loopName' class='one'><img src=upload/$loopName/$pic100_Name style=border:0></a>");
				  else 
				  	echo("<a href='RockerDetail.php?uid=$loopName' class='one'><img src=img/NoUserIcon100.jpg style=border:0></a>");
					?>
                  </span></td>
                  <td width="149" height="15" valign="top" style="padding-left:10px; font-size:14px; font-weight:bold">
				  <?php echo("<a href=RockerDetail.php?uid=$loopName class=one>
				  <font color=$_SESSION[hcolor]>$loopName</font></a>"); ?>
				  </td>
                </tr>
              <tr>
                <td valign="top" style="padding-left:8px; padding-top:5px">
				<a href="SendMessage.php?recipient=<?php echo($loopName) ?>" class="one"><img src="img/messageIconEN.jpg" /></a>
				</td>
                </tr>
              <tr>
                <td valign="top" style="padding-left:8px">&nbsp;</td>
              </tr>
              </table>
            </div>
          <?php }} ?>
		  </td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
