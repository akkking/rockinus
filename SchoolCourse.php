<?php 
include 'mainHeader.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];
//header("Content-Type: text/html; charset=utf-8");
$major_name = NULL;  
if($_POST['major_submit']){
	$cmajor = $_POST['cmajor'];

	$result = mysql_query("UPDATE rockinus.user_edu_info SET cmajor='$cmajor' WHERE uname='$uname'");
	if (!$result) die('Invalid query: ' . mysql_error());
}

$comment = mysql_query("SELECT * FROM rockinus.course_memo_info;");
if(!$comment) die(mysql_error());
$comment_cnt = mysql_num_rows($comment);				

$course_question = mysql_query("SELECT * FROM rockinus.course_question_info WHERE course_uid<>0;");
if(!$course_question) die(mysql_error());
$course_question_cnt = mysql_num_rows($course_question);				
?>
<style type="text/css">
<!--
.STYLE1 {color: #336633}
body,td,th {
	font-size: 14px;
}
-->
</style>
<div style="width:100%" align="center">
  <table align="center" width="1024" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0; background-color:#FFFFFF; margin-left:0px">
    <tr>
      <td height="163" align="left" valign="top" style="border-right:0px dashed #CCCCCC"><table width="1024" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
        <tr>
          <td width="1024" valign="top" align="left" style="padding:15px"><script>
$(document).ready(function() { 
    $("#allMajorDiv").hide();
	$("#hideAllDiv").hide();
	$("#showAllDiv").show();
	$("#ownMajorDiv").show(); 
	
	$("div .showAllDiv").click(function () {
      //$("#joinUsDiv").hide("slide", { direction: "up" }, 1000);
	  $("#showAllDiv").hide();
	  $("#ownMajorDiv").hide();
      $("#hideAllDiv").show(); 
	  $("#allMajorDiv").show();
	 });

	$("div .hideAllDiv").click(function () {
	  $("#hideAllDiv").hide();
	  $("#allMajorDiv").hide();
	  $("#showAllDiv").show();
	  $("#ownMajorDiv").show();
	});
});
</script> 
            <?php
				$q_edu = mysql_query("SELECT * FROM rockinus.user_edu_info WHERE uname='$uname';");
				if(!$q_edu) die(mysql_error());
//				$user_edu_row = mysql_num_rows($q_edu);
				$object_edu = mysql_fetch_object($q_edu);
				$cmajor = $object_edu->cmajor;
//				echo($cmajor);
				if($cmajor==NULL || strlen(trim($cmajor))==0){
					$q_uname = mysql_query("SELECT * FROM rockinus.user_info WHERE uname='$uname'");
					if(!$q_uname) die(mysql_error());
					$object_uname = mysql_fetch_object($q_uname);
					$u_fname = $object_uname->fname;
					$u_lname = $object_uname->lname;
		  			echo("<form action='SchoolCourse.php' method='post'><div style='width:1024; background:#F5F5F5; margin-bottom:20; border-top:1px solid #CCCCCC; border-bottom:1px solid #CCCCCC; padding-top:15; padding-bottom:15; font-size:16px' align='left'><strong>&nbsp;&nbsp;&nbsp; $u_fname, what do you study?</strong><br><br>&nbsp;&nbsp;&nbsp; <select name=cmajor style='font-size:13px; font-family:Arial, Helvetica, sans-serif; height:21'>"); 
					$q_major = mysql_query("SELECT * FROM rockinus.major_info ORDER BY major_name ASC");
					if(!$q_major) die(mysql_error());
					while($object_major = mysql_fetch_object($q_major)){
						$mid = $object_major->mid;
						$major_name = $object_major->major_name;
						echo ("<option value=$mid>$major_name</option>");
					}
					echo("</select> &nbsp;&nbsp;<input type='submit' name='major_submit' style='height:22; font-family: Arial, Helvetica, sans-serif; padding:2 8 2 8; background: url(img/black_cell_bg.jpg); border:0px solid #333333; font-size:12px; cursor:pointer; color:#FFFFFF' value=' Submit '></div></form>");
		   		}else{
					$q2_major = mysql_query("SELECT * FROM rockinus.major_info WHERE mid='$cmajor';");
					if(!$q2_major) die(mysql_error());
					$object2_major = mysql_fetch_object($q2_major);
					$cmajor_name = $object2_major->major_name;
				} ?>
            <table width="1024" height="40" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px #DDDDDD solid; margin-bottom:15">
              <tr>
                <td width="42" height="30" align="left" style="padding-left:15; border-top:0px #EEEEEE solid; font-size:13px"><?php
				$q = mysql_query("SELECT * FROM rockinus.user_course_info WHERE uname='$uname';");
				if(!$q) die(mysql_error());
				$user_no_row = mysql_num_rows($q);
				if($user_no_row==0) echo("<img src=img/warningIcon.jpg width=20>");
				else echo("<img src=img/addsuccessIcon_F5.jpg width=20>");
				  ?>                </td>
                  <td width="490" align="left" style="padding-left:0; font-size:18px; font-weight:normal; color:"><?php
				  if($user_no_row==0) echo("You currently have no courses subscribed");
					else echo("Currently you have subscribed <strong>$user_no_row</strong> course(s)");
				  ?>                </td>
                  <td width="492" align="right" style="padding-right:10; border-top:0px #EEEEEE solid; font-size:14px; font-weight:bold">
                    <?php if($user_no_row>0){ ?>
                    <a href="ManageCourse.php">
                    <div style="border:1px solid #666666; background-color: #CC3300; padding: 5 10 5 10; color:#FFFFFF; font-size:14px; font-family:Arial, Helvetica, sans-serif; width:100px; display:inline; -moz-border-radius: 3px; border-radius: 3px;" align="center" class="newPostDiv" id="newPostDiv" onMouseOver="this.style.cursor='hand'"><strong>+ Manage</strong></div>
                    </a> <?php }else if($cmajor!=NULL && strlen(trim($cmajor))>0){?>
                    <a href="MajorDetail.php?sid=NYPOLY&&mtype=Master&&mid=<?php echo($cmajor) ?>">
                    <div style="border-right:1 solid #666666; border-bottom:1 solid #666666; background-color: #CC3300; padding-bottom:4; padding-top:4; padding-left:7; padding-right:7; color:#FFFFFF; font-size:12px; font-family:Arial, Helvetica, sans-serif; width:210px; display:inline; -moz-border-radius: 3px; border-radius: 3px;" align="center" class="newPostDiv" id="newPostDiv" onMouseOver="this.style.cursor='hand'"><strong>Subscribe Now</strong></div>
                    </a>&nbsp; <span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal">(Why should I do?)</span>
                    <?php } ?>
                  <?php
if(isset($_POST['school'])){
	$sid = $_POST['school'];
	$sql_stmt = "SELECT * FROM rockinus.school_info WHERE sid = '$sid'";
}else 
	$sql_stmt = "SELECT * FROM rockinus.school_info WHERE sid = 'NYPOLY' ORDER BY pdate DESC";
//echo($sql_stmt."----<br>");
$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0){
	if(isset($_POST['school'])) 
		echo("<div style=padding-right:20><br>Sorry, we can not find the school info<font color=#336633><strong></strong></font>.</div>");
	else echo("<div style=padding-right:20><br><font color=#336633>Sorry, no school has been found</font></div>");
}
?>                </td>
                </tr>
              </table>
              <?php
		while($object = mysql_fetch_object($q)){
		$sid = $object->sid;
		$school_name = $object->school_name;
		$city = $object->city;
		?>
            <div style="border:10px solid #EEEEEE; width:1000; -moz-border-radius: 8px; border-radius: 8px;">
              <table width="1000" height="100" border="0" bgcolor="" cellpadding="0" cellspacing="0" style="border: 1px solid #999999;margin-right:0px; margin-top:0; margin-left:0px; background-image:url(img/GrayGradbgDown.jpg); background-repeat: repeat-x">
                <tr>
                  <td height="40" colspan="3" style="font-size:16px; padding-left:20; padding-top:15" valign="top">
                    <?php echo("<a href='SchoolDetail.php?sid=$sid' class=one><font style='font-weight:normal'>$school_name</font></a>") ?>
                    <font color="#999999" style="font-size:16px; font-weight:normal"> (<?php echo($comment_cnt." Comments") ?>) (<?php echo($course_question_cnt." Memorized Test Questions") ?>)</font></td>
                  </tr>
                <tr>
                  <td height="75" colspan="3" valign="top" style=" padding:0 20 15 20; font-size:36px;">
                    <div class="ownMajorDiv" id="ownMajorDiv" style="margin-bottom:10; font-weight:bold">
                      <?php 
					if($cmajor==NULL || strlen(trim($cmajor))==0){
						echo("<font style='font-size:; font-weight:'>We don't know what you study...</font>");
					}else
						echo("<a href='MajorDetail.php?sid=NYPOLY&&mtype=Master&&mid=$cmajor' class=><img src=img/arrow-right.png width=25 /> <font color=$_SESSION[hcolor]>$cmajor_name</font></a>"); 
					?>
                      </div>
					  <div class="showAllDiv" id="showAllDiv" style="font-size:16px; display:inline; margin-top:5; cursor: pointer; color:#999999">+ Show other Majors</div>	
                    <div class="hideAllDiv" id="hideAllDiv" style="font-size:13px; font-weight:normal; display:none; margin-top:5; cursor: pointer"><< Back to my Major</div>					<div class="allMajorDiv" id="allMajorDiv" style="width:700; margin-top:10; display:none">
                      <table width="700" border="0" cellpadding="0" cellspacing="0" background="" style="border:0px solid #DDDDDD; border-top:0">
                        <tr>
                          <td style="padding:0; padding-top:10; padding-bottom:0; font-size:14px; font-family: Arial, Helvetica, sans-serifArial, Helvetica, sans-serif; line-height:180%"><?php	
	$q1 = mysql_query("SELECT * FROM rockinus.school_major_info where sid='NYPOLY' AND mtype='Master' ORDER BY mid ASC");
	if(!$q1) die(mysql_error());
	$no_row = mysql_num_rows($q1);
	if($no_row == 0) echo("&nbsp;&nbsp;&nbsp;&nbsp;The course data is not ready!");
	while($object = mysql_fetch_object($q1)){
		$mid = $object->mid;

		$q2 = mysql_query("SELECT * FROM rockinus.major_info where mid='$mid'");
		if(!$q2) die(mysql_error());
		$no_row = mysql_num_rows($q2);
//		echo("SELECT * FROM rockinus.major_info where mid='$mid'");
		if($no_row == 0) echo("No matches met your criteria.$mid");
		$object = mysql_fetch_object($q2);
		$major_name = $object->major_name;
		
		$q_user = mysql_query("SELECT * FROM rockinus.user_course_info WHERE course_uid IN (SELECT course_uid FROM rockinus.unique_course_info WHERE course_id IN (SELECT course_id FROM rockinus.course_info WHERE mid='$mid'))");
		if(!$q_user) die(mysql_error());
		$no_row_user = mysql_num_rows($q_user);
		
		$q_comment = mysql_query("SELECT * FROM rockinus.course_memo_info WHERE course_uid IN (SELECT course_uid FROM rockinus.unique_course_info WHERE course_id IN (SELECT course_id FROM rockinus.course_info WHERE mid='$mid'))");
		if(!$q_comment) die(mysql_error());
		$no_row_comment = mysql_num_rows($q_comment);
		
		$q_clicks = mysql_query("SELECT * FROM rockinus.course_clicks WHERE course_uid IN (SELECT course_uid FROM rockinus.unique_course_info WHERE course_id IN (SELECT course_id FROM rockinus.course_info WHERE mid='$mid'))");
		if(!$q_clicks) die(mysql_error());
		$no_row_clicks = mysql_num_rows($q_clicks);
?>
                            <table width="700" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px dashed #CCCCCC;">
                              <tr>
                                <td valign='middle' style='height:20; border-bottom:0px dashed #CCCCCC; display:inline; font-size:14px; font-family:Arial, Helvetica, sans-serif'>&nbsp;<a href='MajorDetail.php?sid=<?php echo($sid) ?>&amp;&amp;mtype=Master&amp;&amp;mid=<?php echo($mid) ?>' class="one"><font color="#666666" style="font-size:18px; font-weight:bold"><?php echo($major_name) ?></font></a> </td>
                                </tr>
                              <tr>
                                <td valign='middle' style='height:20; border-bottom:0px dashed #CCCCCC; display:inline; font-size:14px; font-family:Arial, Helvetica, sans-serif'>&nbsp;<?php echo("<font color=#999999 style='font-size:12px'>($no_row_clicks clicks) ($no_row_user students subscribed) ($no_row_comment comments)</font>")?> </td>
                                </tr>
                              <tr>
                                <td height="10" valign='middle' style='height:10; border-bottom:0px dashed #CCCCCC; display:inline; font-size:14px; font-family:Arial, Helvetica, sans-serif'>&nbsp;</td>
                                </tr>
                              </table>
                          <?php } ?>                            </td></tr>
                        </table>
                    </div></td>
                  </tr>
                </table>
		      </div>
				    <?php } ?>
  <table border="0" cellpadding="0" cellspacing="0" width="1024" style="margin-top:15; margin-bottom:20">
    <tr>
      <td width="202" height="50" bgcolor="" valign="top" style="border-bottom: 0px solid #DDDDDD;border-top: 0px solid #DDDDDD; padding-left:0; padding-top:0" align="left">
        <?php include("CourseLatestCommentUpdate.php") ?></td>
                  <td width="203" bgcolor="" style="border-bottom: 0px solid #DDDDDD;border-top: 0px solid #DDDDDD; padding-top:0" valign="top" align="right">
                  <?php include("CourseLatestQuestionUpdate.php") ?></td>
		        </tr>
    </table></td>
          </tr>
      </table></td>
    </tr>
</table>
</div>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
