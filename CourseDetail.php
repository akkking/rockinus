<?php 
include 'mainHeader.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];
?><style type="text/css">
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
<script type="text/javascript">
$(document).ready(function(){
	$(".showUploadDiv").click(function(){
		$(".downloadDiv").fadeOut("fast"); 
		$(".uploadDiv").fadeIn("fast"); 
	});
	
	$(".innerUploadDiv").click(function(){
		$(".downloadDiv").fadeOut("fast"); 
		$(".uploadDiv").fadeIn("fast"); 
	});
	
	$(".showDownloadDiv").click(function(){
		$(".uploadDiv").fadeOut("fast"); 
		$(".downloadDiv").fadeIn("fast"); 
	});

	$(".showSubscribeDiv").click(function(){
		$(".subscribeDiv").fadeIn("fast"); 
	});	
});
</script>
<script type="text/javascript">
var ray={
ajax:function(st){
	 this.show('load');
},

show:function(el){
	 this.getID(el).style.display='';
},

getID:function(el){
	 return document.getElementById(el);
}
}
</script>
<div align="center" style="margin-top:0px">
<table width="1024" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top">
	<table width="990" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
	  <tr>
	    <td align="right"><table width="258" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px">
	      <tr  style="margin-bottom:5; padding-bottom:5">
	        <td width="258" style="padding-right:5"><?php
if( isset($_GET['subscribe']) && $_GET['subscribe']=='Y' && isset($_GET['course_uid'])){
	$course_uid = $_GET['course_uid'];
	$q_uid = mysql_query("SELECT * FROM rockinus.user_course_info WHERE uname='$uname' AND course_uid='$course_uid'");
	if(!$q_uid) die(mysql_error());
	$no_row_uid = mysql_num_rows($q_uid);
	if($no_row_uid == 0){
		$sql = "INSERT INTO rockinus.user_course_info(uname,course_uid,pdate,ptime)VALUES('$uname','$course_uid',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		//$_SESSION['common_rst_msg'] = "<div align='center' style='width:200px; padding-top:7px; padding-bottom:7px; font-size:16px; color:#000000; background:#F5F5F5'>&nbsp;&nbsp;<img src='img/addsuccessIcon_F5.jpg' width=15 />&nbsp;&nbsp; Subscribed Successful</div>"; 
	}else{
		$_SESSION['common_rst_msg'] = "<div align='center' style='width:200px; padding-top:5px; padding-bottom:5px; font-size:13px; color:#B92828; line-height:150%; background:; font-weight:bold'>You already subscribed :)</div>"; 
	}
}else{
	if(isset($_GET["course_uid"]))
		$course_uid = $_GET["course_uid"];
	else if(isset($_SESSION["course_uid"]))
		$course_uid = $_SESSION["course_uid"];
	
	$q_clicks = mysql_query("SELECT uname, clicks FROM rockinus.course_clicks WHERE course_uid='$course_uid'");
	if(!$q_clicks) die(mysql_error());
	$object = mysql_fetch_object($q_clicks);
	$clicks = $object->clicks;
	$click_uname = $object->uname;

	if($click_uname!=$uname){
		$result = mysql_query("UPDATE rockinus.course_clicks SET clicks=clicks+1, uname='$uname' WHERE course_uid='$course_uid'");
		if (!$result) die('Invalid query: ' . mysql_error());
	}
}
			  
			  
//Global Variable: 
$page_name = "SchoolCourse.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
if(isset($_GET["course_uid"]))
	$course_uid = $_GET["course_uid"];
else
	$course_uid = $_SESSION["course_uid"];
	
//$sql = "SELECT a.course_name, a.mid, a.sid, b.pid FROM rockinus.course_info a JOIN rockinus.unique_course_info b ON b.course_uid = '$course_uid'";
//mysql_query("SET NAMES GBK");
$q = mysql_query("SELECT a.course_name, a.mid, a.sid, b.pid FROM rockinus.course_info a JOIN rockinus.unique_course_info b ON b.course_uid = '$course_uid' AND a.course_id=b.course_id");
//echo($sql);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("No matches met your criteria.");
$object = mysql_fetch_object($q);
$pid = $object->pid;
$mid = $object->mid;
$sid = $object->sid;
$course_name = $object->course_name;

$q1 = mysql_query("SELECT * FROM rockinus.school_info where sid='$sid'");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0) echo("No matches met your criteria.");
$object = mysql_fetch_object($q1);
$school_name = $object->school_name;

$q_m = mysql_query("SELECT major_name FROM rockinus.major_info where mid='$mid'");
if(!$q_m) die(mysql_error());
$no_row = mysql_num_rows($q_m);
if($no_row == 0) echo("No Major Name found for this course.");
$object = mysql_fetch_object($q_m);
$major_name = $object->major_name;
?>	          </td>
              </tr>
	      </table></td>
        </tr>
	  <tr>
	    <td height="313" valign="top" align="left" style="padding:15px"><div style=" width:990; padding-bottom:10;" align="right">
	      <table width="990" border="0" cellspacing="0" cellpadding="0">
	        <tr>
	          <td align="right">
	            <?php  
						if(isset($_SESSION['rst_msg'])){
							echo($_SESSION['rst_msg']); 
							unset($_SESSION['rst_msg']); 
						}?> 
	            <table width="990" height="75" border="0" cellpadding="0" cellspacing="0" background="img/GrayGradbgDown.jpg" style="margin-top:10; margin-bottom:10px; border-top:1px solid #333333	">
	              <tr>
	                <td height="50" colspan="2" style=" background:<?php echo($_SESSION['hcolor']) ?>; padding-left:15; border-bottom:1px #CCCCCC solid; font-size:24px"><?php echo("<a href=CourseDetail.php?course_uid=$course_uid class=one><font color=#FFFFFF>$course_name </font></a>| <a href=MajorDetail.php?sid=$sid&&mtype=Master&&mid=$mid class=one><font color=#DDDDDD>$major_name</font></a>")?> 						</td>
                      </tr>
	              <tr>
	                <td width="714" height="50" align="left" valign="top" background="img/GrayGradbgDown.jpg" style="padding-left:15; padding-top:10; border-bottom:0 #EEEEEE solid; font-size:14px">
	                  <font color="#999999">Professor : </font><?php echo("$pid | <font color=#999999>$clicks click(s)</font>") ?>						</td>
                        <td width="310" height="50" align="right" background="img/GrayGradbgDown.jpg" style="border-bottom:0 #EEEEEE solid; padding-right:20px; color:#F5F5F5; font-size:18px"></td>
                      </tr>
	              </table>
                    <table width="990" height="50" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="521"><?php
				$q_uid = mysql_query("SELECT * FROM rockinus.user_course_info where uname='$uname' && course_uid='$course_uid'");
				if(!$q_uid) die(mysql_error());
				$no_row_uid = mysql_num_rows($q_uid);
				if($no_row_uid == 0){				
				?>
                          <a href="CourseDetail.php?subscribe=Y&amp;&amp;course_uid=<?php echo($course_uid) ?>">
                          <span style="color:#000000; border:1px #999999 solid; padding:3 8 3 8; background: url(img/master.png); display:inline; height:15px; font-size:12px; font-weight: normal; -moz-border-radius: 3px; border-radius: 3px; cursor:pointer" class="showSubscribeDiv" align="center" onmouseover="this.style.background='url(img/master.jpg)'" onmouseout="this.style.background='url(img/master.png)'"> + Subscribe </span></a>
                          <?php
				}else{
				?>
                          <span style="color:#000000; border:1px #333333 solid; padding:3 8 3 8; background: url(img/master.png); display:inline; height:15px; font-size:12px; font-weight: normal;" align="center"> <img src="img/addsuccessIcon_F5.jpg" width="12" />&nbsp;  Subscribed </span>
                          <?
				}
				?>
                          &nbsp;&nbsp; <span style="color:#000000; border:1px #999999 solid; padding:3 8 3 8; background: url(img/<?php echo(substr($_SESSION['hcolor'],1,6)."_ajax_button.jpg") ?>); display:inline; height:15px; font-size:12px; -moz-border-radius: 3px; border-radius: 3px; font-weight: normal; cursor:" align="center" class="showUploadDiv"> Comment List </span> &nbsp;&nbsp; <a href="CourseQuestionList.php?course_uid=<?php echo($course_uid) ?>"><span style="color:#000000; border:1px #999999 solid; padding:3 8 3 8; background: url(img/master.png); display:inline; height:15px; font-size:12px; font-weight: normal; -moz-border-radius: 3px; border-radius: 3px; cursor:pointer" align="center" class="showDownloadDiv" onmouseover="this.style.background='url(img/master.jpg)'" onmouseout="this.style.background='url(img/master.png)'"> Question Memory </span></a> </td>
                        <td width="219" align="right" style="padding-right:0px"><?php  
					if(isset($_SESSION['common_rst_msg'])){
						echo($_SESSION['common_rst_msg']); 
						unset($_SESSION['common_rst_msg']); 
				}?>                        </td>
                      </tr>
                    </table>
                    <table width="990" border="0" cellpadding="0" cellspacing="0" style="margin-top:15" id="memoTable" class="memoTable">
                      <tr>
                        <td width="710" height="41" colspan="3" align="left"><?php
mysql_query("SET NAMES UTF8");
$q1 = mysql_query("SELECT * FROM rockinus.course_memo_info a JOIN rockinus.user_info b ON a.course_uid='$course_uid' AND a.sender=b.uname ORDER BY a.memoid DESC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("<div style='padding: 25px; border:#DDDDDD solid 1px; background-color:#F5F5F5; margin-top:10; margin-bottom:20; vertical-align:top; font-size:18px; -moz-border-radius: 5px; border-radius: 5px; width:500px; padding-left:0' align='center'><font color=#333333>&nbsp;&nbsp;No comment made to this course so far!</font></div>");}
if($no_row > 0){ 
while($object = mysql_fetch_object($q1)){
	$memoid = $object->memoid;
	$loopfname = $object->fname;
	$looplname = $object->lname;
	$sender = $object->sender;
	$rating = $object->rating;
	$comment_rstatus = $object->rstatus;
	$descrip = $object->descrip;
	$descrip = str_replace("\\","",$descrip);
	$ptime = $object->ptime;
	$pdate = $object->pdate; 
?>
                          <div style="padding-left:0; line-height:180%; padding-bottom:10; padding-top:0; width: 990px; border-bottom:0px #DDDDDD solid">
                            <table width="990" height="63" border="0" cellpadding="0" cellspacing="0" style=" background:#F5F5F5; border:1px #EEEEEE solid">
                              <tr>
                                <td height="29" align="left" style="font-size:13px; padding-left:10px">
                                <?php 
				if($comment_rstatus=='N')
					echo("<strong><a href=RockerDetail.php?uid=$sender class=one><font color=$_SESSION[hcolor]>$loopfname $looplname</font></a></strong> commented:");
				else
					echo("<strong>Anonymous</strong> commented:");	
				?>					</td>
                                <td width="221" align="center"><?php 
							  	for($i=1;$i<=$rating;$i++)echo("<img src=img/yellowstar.jpg width=15 height=13>"); 
								?></td>
                                <td width="198" align="right" style=" color: #999999; font-size:11px; padding-right:10px"><?php echo(getDateName($pdate)) ?> | <?php echo(substr($ptime,0,5)) ?></td>
                              </tr>
                              <tr>
                                <td height="33" colspan="3" style="padding:10px; padding-top:5px; line-height:125%; font-size:14px"><?php
								echo(nl2br($descrip));
								?>                                  </td>
                              </tr>
                            </table>
                            </div>
                          <?php }}?></td>
                      </tr>
                    </table>
                    <form action="CourseComment.php" method="post" style="margin:0">
                      <table width="990" border="0" cellpadding="0" cellspacing="0" style="border-top:#CCCCCC solid 0; margin-top:15px">
                        <tr>
                          <td width="490" height="40" align="left" style="padding-left:5px; padding-top: 5px; font-size:18px; color: <?php echo($_SESSION['hcolor']) ?>; font-weight:normal"><img src="img/smileyIcon.png" width="20" />&nbsp; <?php echo($uname_fname) ?>, post your comment and maybe with a rating too!						  </td>
                          <td width="500" height="40" align="right" style="padding-right:15">
                            <input type="radio" name="rating" value="5" />
                              <img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" />&nbsp;&nbsp;
                              <input type="radio" name="rating" value="4" />
                              <img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" />&nbsp;&nbsp;
                              <input type="radio" name="rating" value="3" />
                              <img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" />&nbsp;&nbsp;
                              <input type="radio" name="rating" value="2" />
                              <img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" />&nbsp;&nbsp;
                              <input type="radio" name="rating" value="1" />
                          <img src="img/yellowstar.jpg" width="15" height="13" />                          </td>
                        </tr>
                        <tr>
                          <td height="86" colspan="3" align="left" style="padding-left:0px; padding-top:7">
                            <textarea name="description" rows="5" style="width:980; font-size:14px; padding:4px; line-height:130%; background:#F5F5F5; border:0px" id="styled"></textarea>
                            <div style="width:990; height:35; padding-top:8" align="left">
                              <input type="hidden" value="CourseDetail.php?course_uid=<?php echo($course_uid) ?>" name="pagename" />
                              <input type="hidden" value="<?php echo($course_uid) ?>" name="course_uid" />
                              <input type="submit" name="Submit2" value="Submit" style="height:22; padding:3 10 3 10; background: url(img/black_cell_bg.jpg); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:13px; cursor:pointer; color:#FFFFFF; display:inline" />&nbsp;&nbsp;
                              <input type="checkbox" name="anony_yesno" />&nbsp; 
                              <font color="#000000" style='font-size:13px'>Anonymous post &nbsp;&nbsp;</font>
                              <font color="#999999" style='font-size:12px'>(At least 20 letters, no more than 3000 letters)</font>                              </div>
                              <br />
                            <br />                          </td>
                        </tr>
                      </table>
                    </form>
                    <div align="left">
                      <table width="600" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td style="padding-left:10px"><table width="990" border="0" cellpadding="0" cellspacing="0" style="margin-top:5; margin-bottom:20; border:0 #DDDDDD solid;">
                              <tr>
                                <td height="35" align="left" style="padding-left:10; background: #EEEEEE; border-bottom:1px #CCCCCC solid; font-size:18px; color:">Course Descriptions</td>
                              </tr>
                              <tr>
                                <td height="40" style="padding:10; line-height:150%; font-size:14px;"><?php
					  	$q1 = mysql_query("SELECT * FROM rockinus.course_info a JOIN rockinus.unique_course_info b WHERE 
												b.course_id = a.course_id");
						if(!$q1) die(mysql_error());
						$no_row = mysql_num_rows($q1);
						if($no_row == 0)echo("This course is not found.");
						if($no_row > 0){ 
							$object = mysql_fetch_object($q1);
							$course_id = $object->course_id;
							$sid = $object->sid;
							$course_name = $object->course_name;
							$descrip = $object->descrip;
							$pid = $object->pid;
							echo("<em>".nl2br(addslashes($descrip))."</em>");
						}?>                                </td>
                              </tr>
                              </table>
                              <table width="990" border="0" cellpadding="0" cellspacing="0" style="margin-top:5; margin-bottom:15; border:0 #DDDDDD solid;">
                                <tr>
                                  <td height="35" colspan="2" align="left" style="padding-left:10; background: #EEEEEE; border-bottom:1px #CCCCCC solid; font-size:18px; color:">
                                  Students who also subscribed this course</td>
                                </tr>
                                <tr>
                                  <td height="40" colspan="2" align="left" bgcolor="#FFFFFF" style="padding-top:10; padding-left:10; padding-bottom:5; font-size:14px">
                                      <div style=" margin-bottom:20px; margin-top:0px; width:720" align="left">
                                        <?php 
				$q = mysql_query("SELECT * FROM rockinus.user_info a JOIN rockinus.user_course_info b ON a.uname = b.uname AND b.course_uid='$course_uid';");
				if(!$q) die(mysql_error());
				$no_row = mysql_num_rows($q);
				if($no_row==0){
					echo("<table style='margin-top:15'><tr><td><img src=img/gantanhao.png width=25px />&nbsp;&nbsp;</td><td style='font-size:14px'>No student subscribe this course yet!</td></tr></table>");
				}else{
					while($object = mysql_fetch_object($q)){					
						$loopname = $object->uname;
						$loopfname = $object->fname;
						$looplname = $object->lname;
				?>
                                        <script type="text/javascript">
$(function() {
	$(".addFriendHometownDiv<?php echo($loopname) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($loopname) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#addFriendHometownDiv<?php echo($loopname) ?>").hide();
		$("#flashAddFriendHometown<?php echo($loopname) ?>").show();
		$("#flashAddFriendHometown<?php echo($loopname) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_frequest.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashAddFriendHometown<?php echo($loopname) ?>").hide();
				$("#addFriendHometownResult<?php echo($loopname) ?>").html(html);
				$("#addFriendHometownResult<?php echo($loopname) ?>").show();
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
				
						$loop_uname = $loopname.'60.jpg';
						//date('Y-m-d, H:i');
						$target_loop_uname = "upload/".$loopname;
						echo("<table width='720' style='margin-bottom:10px'><tr>");
				
						if(is_dir($target_loop_uname)){
							echo("<td align='left' style='border:0px solid #EEEEEE; background-repeat:no-repeat' width='60' height='60' background='upload/$loopname/$loop_uname?".time()."'></td>");
						}else 
							echo("<td align='left' style='border:0px solid #EEEEEE; ' width='60px'><a href='RockerDetail.php?uid=$loopname' class=one title='$loopname'><img src='img/NoUserIcon_fixed.jpg' width=60 height=60 style='margin-right:0px;'></a></td>");
						
						echo("<td style='padding-left:15px; padding-top:2; line-height:120%; font-size:12px; font-family: Arial, Helvetica, sans-serif;' valign='top'><a href='RockerDetail.php?uid=$loopname' class=one><strong>$loopfname $looplname</strong></a><br><br>");
						if($rel_rstatus=="S")echo("<a href='EditEduInfo.php'><div style='font-size:11px; font-weight:normal; width:70; height:20; border-right:1px #CCCCCC solid; border-bottom:1px #CCCCCC solid; background: url(img/GrayGradbgDown.jpg); color:#333333;  padding:2 5 2 5; display:inline; cursor:pointer' align='center'>+ Edit</div></a>&nbsp;");
						else if($rel_rstatus=="P")echo("<div style='font-size:11px; font-weight:normal; width:70; height:20; border-right:1px #CCCCCC solid; border-bottom:1px #CCCCCC solid; background: url(img/GrayGradbgDown.jpg); color:$_SESSION[hcolor];  padding:2 5 2 5; display:inline' align='center'>Requested</div>");
						else if($rel_rstatus=="A")echo("<a href='FriendConfirm.php?uid=$loopname&&pageName=SchoolCourse'><div style='font-size:11px; font-weight:normal; width:70; height:20; border-right:1px #CCCCCC solid; border-bottom:1px #CCCCCC solid; background: url(img/GrayGradbgDown.jpg); color:#333333;  padding:2 5 2 5; display:inline; cursor:pointer' align='center'>Defriend</div></a>");
						else if($rel_rstatus=="X"){
							echo("<div style='font-size:11px; font-weight:normal; width:130px; height:20; border-right:1px #CCCCCC solid; border-bottom:1px #CCCCCC solid; background: $_SESSION[hcolor]; color:#FFFFFF;  padding:2 8 2 8; display:inline' align='center'><a href='AcceptFriend.php?sender=$loopname' class=>Accept Request</a></div>&nbsp;&nbsp;");
							echo("<div style='font-size:11px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; width:85px; width:70; height:20; border-right:1px #CCCCCC solid; border-bottom:1px #CCCCCC solid; background: url(img/black_cell_bg.jpg); color:#FFFFFF;  padding:2 5 2 5; display:inline; cursor:pointer' align='center'><a href='DenyFriend.php?sender=$loopname&&pageName=FriendGroupResult' class=>Ignore</a></div>");
							}else if($rel_rstatus=="N")echo("<div id='addFriendHometownDiv$loopname' class='addFriendHometownDiv$loopname' style='font-size:11px; font-weight:normal; width:80; height:20; border:1px #DDDDDD solid; border-right:1px #999999 solid; border-bottom:1px #999999 solid; background: url(img/".substr($_SESSION['hcolor'],1,6)."_ajax_button.jpg); color:#000000;  padding:2 5 2 5; display:inline; cursor:pointer' align='center'>+ Friend</div>");
						?>
                                        <span id="flashAddFriendHometown<?php echo($loopname) ?>" class="flashAddFriendHometown<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span>
                                        <span id="addFriendHometownResult<?php echo($loopname) ?>" class="addFriendHometownResult<?php echo($loopname) ?>" style='font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:none' align='center'></span>&nbsp;
                                        <?php
	 					if($rel_rstatus!="S"){?>
                                        <a href="SendMessage.php?recipient=<?php echo($loopname) ?>" class='one'>
                                        <div style="font-size:11px; font-weight:normal; width:70; height:20; border-right:1px #999999 solid; border-bottom:1px #999999 solid; background: url(img/master.jpg); color:#000000; padding:2 5 2 5; display:inline" align="center">Message</div>
                                        </a>
                                        <?php } 
	
						echo("</td></tr></table>");
					}
				}		
	?>	
                                    </div>                                  </td>
                                </tr>
                            </table></td>
                        </tr>
                      </table>
                  </div></td>
                </tr>
	        </table>
          </div></td>
        </tr>
    </table></td>
  </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
