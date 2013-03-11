<?php 
include 'dbconnect.php';
include("Allfuc.php");
 
if(isset($_GET['action'])&&isset($_GET['course_uid'])&&isset($_GET['course_id'])&&$_GET['action']=='d'){
	$d_course_id = $_GET['course_id'];
	$d_course_uid = $_GET['course_uid'];
	$sql = "DELETE FROM rockinus.user_course_info WHERE uname='$uname' AND course_uid='$d_course_uid'";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	
	$rst_msg = "<img src=img/greencoricon.jpg width=15 />&nbsp;&nbsp;&nbsp;Course $d_course_id has been canceled successfully!";
	$_SESSION['rst_msg']="<div align='left' style='width:720; font-size:16px; background:#F5F5F5; padding:5 10 5 10;'>$rst_msg :)<br></div>";
}
include 'mainHeader.php';

?>
<style type="text/css">
<!--
.STYLE1 {color: #336633}
body,td,th {
	font-size: 14px;
}
-->
</style>
<div align="center" style="width:100%">  
  <table width="1024" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0; background-color:#FFFFFF; margin-left:0px">
    <tr>
      <td height="163" align="left" valign="top">
	  <table width="1015" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1003" height="148" valign="top" align="right" style="padding-top:20px">
            <table width="1005" height="45" border="0" cellpadding="0" cellspacing="0" background="" bgcolor="" style="margin-left:10px; border-bottom:0px #EEEEEE solid; border-top:0px #CCCCCC solid;">
              <tr>
                <td width="822" height="30px" align="left" style="padding-left:10; font-size:24px; font-weight:normal; color:">
                  <?php
				  if($user_no_row==0) echo("Course Subscribed List");
					else echo("You have subscribed <strong>$user_no_row</strong> course(s)");
				  ?>                </td>
                  <td width="112" align="right" valign="middle" style="">
                  <?php 
					$q_edu = mysql_query("SELECT * FROM rockinus.user_edu_info WHERE uname='$uname';");
				if(!$q_edu) die(mysql_error());
//				$user_edu_row = mysql_num_rows($q_edu);
				$object_edu = mysql_fetch_object($q_edu);
				$cmajor = $object_edu->cmajor;
				if($cmajor==NULL || strlen(trim($cmajor))==0){
					echo("<a href='SchoolCourse.php'><div style='height:15px; padding:2px 5px 2px 5px; background: url(img/master.jpg); display:inline; margin-top:5px; width:75px; border:1px solid #999999; font-size:11px; cursor:pointer; color:#000000; -moz-border-radius: 3px; border-radius: 3px;' align=center>+ Add</div></a>");
				}else{
					$q_major = mysql_query("SELECT * FROM rockinus.major_info WHERE mid='$cmajor' ORDER BY major_name ASC");
					if(!$q_major) die(mysql_error());
					$object_major = mysql_fetch_object($q_major);
					$mid = $object_major->mid;
					$major_name = $object_major->major_name;
					echo ("<a href='MajorDetail.php?sid=NYPOLY&&mtype=Master&&mid=$cmajor' class=one><div style='height:15px; padding:2px 5px 2px 5px; background: url(img/master.jpg); display:inline; margin-top:5px; width:75px; border:1px solid #999999; font-size:11px; cursor:pointer; color:#000000; -moz-border-radius: 3px; border-radius: 3px;' align=center>+ Add</div></a>");
				}
				?>                  </td>
                  <td width="71" align="left" valign="middle" style="padding-left:6px">
                    <a href="SchoolCourse.php">
                    <div style=" height:15px; padding:2px 5px 2px 5px; background: url(img/master.jpg); display:inline; margin-top:5px; width:75px; border:1px solid #999999; font-size:11px; cursor:pointer; color:#000000; -moz-border-radius: 3px; border-radius: 3px;" align="center" class="newPostDiv" id="newPostDiv" onMouseOver="this.style.cursor='hand'">Go Back</div>
                    </a>
                  <?php
if(isset($_POST['school'])){
	$sid = $_POST['school'];
	$sql_stmt = "SELECT * FROM rockinus.school_info WHERE sid = '$sid'";
}else 
	$sql_stmt = "SELECT * FROM rockinus.school_info ORDER BY pdate DESC";

$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0){
	if(isset($_POST['school'])) 
		echo("<div style=padding-right:20><br>Sorry, we can not find the school info<font color=#336633><strong></strong></font>.</div>");
	else echo("<div style=padding-right:20><br><font color=#336633>Sorry, no school has been found</font></div>");
}
?>	</td>
                </tr>
              </table>
			  <div style="width:1005px" align="right">
			    <?php
			  if(isset($_SESSION['rst_msg'])){
			  	echo $_SESSION['rst_msg'];
				unset($_SESSION['rst_msg']);
			  }
			  ?>
			    
			    <table width="990" border="0" cellpadding="0" cellspacing="0">
			      <tr>
			        <td width="990" align="right" style="border:0px #999999 solid; padding-top:10px; padding-bottom:30px"><?php 
					include 'dbconnect.php';
$sender = $_SESSION['usrname'];
$q = "SELECT count(*) as cnt FROM rockinus.user_course_info where uname='$uname'";
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if( $total_items==0 ){
//	echo("No Courses | <a href=SchoolCourse.php class=one><u>Add Now+</u></a>");
}else{
//  	echo("<a href=SchoolCourse.php class=one>Connected Courses (".$total_items.")</a>");
}

if($total_items == 0 ){
	echo("<div style='width:710; line-height:100%; background-color=#F5F5F5; font-weight:bold; border:0 #EEEEEE solid; color:#000000; font-size:13px; padding:10' align=left>You got no courses subscribed.<br><br>
	<img src='img/rightTriangleIcon.jpg' />&nbsp;&nbsp;<a href='SchoolCourse.php' class=one>Go Back</a></div>");
}
//echo("&nbsp;<font color=#000000> </font>");
else{
$q = mysql_query("SELECT * FROM rockinus.user_course_info a INNER JOIN rockinus.course_info b INNER JOIN rockinus.unique_course_info c ON a.uname='$uname' AND c.course_uid=a.course_uid AND c.course_id=b.course_id GROUP BY b.course_id ORDER BY a.pdate DESC");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
while($object = mysql_fetch_object($q)){
	$course_uid = $object->course_uid;
	$course_id = $object->course_id;
	$pid = $object->pid;
	$pdate = $object->pdate;
	$course_name = $object->course_name;
	$descrip = "No description for this course now..."
	?>
			          <table width="1005" height="74" border="0" cellpadding="0" cellspacing="0" background="" style="margin-top:0px; margin-bottom:10px; border-bottom:0px solid #DDDDDD">
			            <tr>
			              <td width="45" rowspan="3" align="left" bgcolor="#FFFFFF" style="padding-left:5px; padding-top:5" valign="top">
		                  <img src="img/bookIcon.png" width="35" /> </td>
                          <td height="30" colspan="2" align="left" valign="top" style=" padding-top:5; padding-left:10px; font-size:16px; font-weight:">
                          <?php echo("<a href='CourseDetail.php?course_uid=$course_uid' class=one><font color=$_SESSION[hcolor]>$course_id | ".$course_name."</font></a> | $pid"); ?> </td>
                          <td width="80" height="30" align="center">
                          <a href="ManageCourse.php?action=d&amp;&amp;course_id=<?php echo($course_id) ?>&amp;&amp;course_uid=<?php echo($course_uid) ?>">
                          <img src="img/cancelIcon.png" />						  </a></td>
                        </tr>
			            <tr>
			              <td width="569" height="30" align="left" style="padding-left:10px; font-size:14px; font-weight:normal"> Subscribed @ <?php echo($pdate) ?> </td>
                          <td width="296" height="30" align="left" style="font-size:12px; padding-left:10px; font-weight:bold">&nbsp;</td>
                          <td width="80" height="30" align="center" style="font-size:20px; font-weight:normal; font-family:Arial, Helvetica, sans-serif; padding-right:10px; color:#FFFFFF">&nbsp;</td>
                        </tr>
			            <tr>
			              <td height="30" colspan="4" align="left" valign="top" style=" padding-top:0px; padding-bottom:10px; padding-left:10px; font-size:14px; line-height:150%; color:#666666; font-weight:normal"><?php echo("$descrip") ?> </td>
                        </tr>
		              </table>
                      <?php } } ?>		            </td>
                  </tr>
		        </table>
		    </div>		    </td>
          </tr>
      </table></td>
    </tr>
</table>
</div>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
