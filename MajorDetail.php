<?php 
include 'mainHeader.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];
 ?>
<script type="text/javascript" src="CheckAll.js"></script>
<link href="style.css" rel="stylesheet">
<style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
<div style="width:100%" align="center">
<table align="center" width="1024" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0; background-color:#FFFFFF; margin-left:0px">
  <tr>
    <td height="163" align="left" valign="top" style="border-right:0px dashed #CCCCCC">
      <table width="760" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
        <tr>
          <td width="760" align="right" style="">
            <?php
//Global Variable: 
$page_name = "SchoolCourse.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
$mid = $_GET["mid"];
$sid = $_GET["sid"];
$mtype = $_GET["mtype"];

$q = mysql_query("SELECT * FROM rockinus.major_info where mid='$mid'");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("No matches met your criteria.");
$object = mysql_fetch_object($q);
$major_name = $object->major_name;

$q_course = mysql_query("SELECT * FROM rockinus.course_info where mid='$mid'");
if(!$q_course) die(mysql_error());
$course_num = mysql_num_rows($q_course);
//echo($course_num);
//if($course_num == 0) echo("No matches met your criteria.");

$q1 = mysql_query("SELECT * FROM rockinus.school_info where sid='$sid'");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0) echo("No matches met your criteria.");
$object = mysql_fetch_object($q1);
$school_name = $object->school_name;

$course_array = array();
						
$q_user = mysql_query("SELECT * FROM rockinus.user_course_info WHERE uname='$uname';");
if(!$q_user) die(mysql_error());
$user_no_row = mysql_num_rows($q_user);
			
$q_major = mysql_query("SELECT a.course_id, a.course_name, a.descrip, b.pid, b.course_uid FROM rockinus.course_info a JOIN rockinus.unique_course_info b WHERE a.mid='$mid' AND a.mtype='$mtype' AND a.sid='$sid' AND a.course_id=b.course_id GROUP BY b.course_uid ASC;");
if(!$q_major) die(mysql_error());
$major_no_row = mysql_num_rows($q_major);
?>            </td>
          </tr>
        <tr>
          <td height="313" valign="top" align="right">
            <table width="1024" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="1024" style=" padding-bottom:5; padding:15px" align="left">
                  <form id="form_id" name="myform" action="selectCourse.php" method="post" style="margin:0">
                    <table width="1000" height="267" border="0" cellpadding="0" cellspacing="0" style="border:1px #DDDDDD solid; margin-top:5">
                      <tr>
                        <td height="32" colspan="2" background="img/master.jpg" bgcolor="#EEEEEE" style="padding-left:15; font-family:Arial, Helvetica, sans-serif; font-size:14px; border-bottom:1px solid #999999">
                          <strong><?php echo($major_name)?></strong>| <font color="#666666"><?php echo($school_name)?></font>
                          <input type="hidden" name="sid" value="<?php echo($sid) ?>" />
                          <input type="hidden" name="mtype" value="<?php echo($mtype) ?>" />
                          <input type="hidden" name="mid" value="<?php echo($mid) ?>" /></td>
                        </tr>
                      <tr>
                        <td height="18" colspan="2" align="right"><?php  
						if(isset($_SESSION['rst_msg'])){
							echo($_SESSION['rst_msg']); 
							unset($_SESSION['rst_msg']); 
						}
						
						if($major_no_row == 0)
							echo("<div style='padding:15px; width:710; border:#DDDDDD dashed 2px; background-color:#F5F5F5; margin-top:10; margin-bottom:20; font-size: 16px; font-family:Arial, Helvetica, sans-serif' align='left'>Unfortunately, we haven't added courses to this major, please come back later :) <br><br>
							<a href='SchoolCourse.php'><div style='border-right:1px solid #666666; border-bottom:1px solid #666666; background-color: #CC3300; padding-bottom:4; padding-top:4; padding-left:7; padding-right:7; color:#FFFFFF; font-size:14px; width:120px; font-family:Arial, Helvetica, sans-serif; display:inline' align='center' onMouseOver=this.style.cursor='hand'><strong>+ Go Back</strong></div></a></div>");
						?>                          </td>
                        </tr>
                      <tr>
                        <td height="46" colspan="2" align="right">
                          <?php if($course_num != 0){ ?>
                          <table width="1000" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px">
                            <tr>
                              <td width="570" height="36" valign="top" align="left" style="padding-left:15; font-size:14px; font-family:Arial, Helvetica, sans-serif"><?php
					if($major_no_row > 0)
						echo("<img src=img/addsuccessIcon.jpg width=15/>&nbsp;&nbsp;<a href='ManageCourse.php' class=one>You currently have <font color=#B92828 size=4><strong><em>".$user_no_row."</em></strong></font>  course(s) subscribed</a>");
					if( $user_no_row>0 ){
					// Form the user course array
						while($object = mysql_fetch_object($q_user)){
							$course_uid = $object->course_uid;
							array_push($course_array, $course_uid);
						}
					}
					?>						</td>
                                <td width="170" valign="top"  align="right" style="padding-right:20px; font-size:11px; font-family:Arial, Helvetica, sans-serif">
                                  <script type="text/javascript">
					function selectAll(x) {
						for(var i=0,l=x.form.length; i<l; i++)
						if(x.form[i].type == 'checkbox' && x.form[i].name != 'sAll')
						x.form[i].checked=x.form[i].checked?false:true
					}
				</script>
                                  Select All&nbsp;
                                  <input type="checkbox" name="sAll" onclick="selectAll(this)" />                                </td>
                              </tr>
                            </table>
                              <?php
							}
						while($object = mysql_fetch_object($q_major)){
							$course_uid = $object->course_uid;
							$pid = $object->pid;
							$course_id = $object->course_id;
							$course_name = $object->course_name;
							
							
		//$q2 = mysql_query("SELECT * FROM rockinus.user_course_info a JOIN rockinus.unique_course_info b JOIN rockinus.course_info c WHERE a.uname='$uname' AND b.course_id='$course_id' AND b.pid='$pid' AND a.course_uid=b.course_uid");
							//if(!$q2) die(mysql_error());
							if( in_array($course_uid,$course_array) ) {
								$chk_tag = " checked='checked'";
							}else $chk_tag = "";
							?>
  <table width="1000" height="25" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="762" height="30" align="left" valign="middle" style="padding-left:15; font-size:16px; font-family:Arial, Helvetica, sans-serif"><a href="CourseDetail.php?course_uid=<?php echo($course_uid) ?>" class="one">
        <?php 
							echo($course_id); 
						?>                                  
        
        <strong><?php 
							echo("<font color=$_SESSION[hcolor]>$course_name</font>"); 
							//echo("<input type='text' name='pid' value='".stripslashes($pid)."'>");
						?></strong></a> 
        <font style="color:#999999; font-size:12px">(<?php 
   					  	$q_reply = mysql_query("SELECT * FROM rockinus.course_memo_info WHERE course_uid='$course_uid';");
						if(!$q_reply) die(mysql_error());
						$reply_no_row = mysql_num_rows($q_reply);
						echo($reply_no_row." comments, "); 
						?>								  
          
          <?php 
   					  	$file_stmt = mysql_query("SELECT * FROM rockinus.user_file_info WHERE course_uid='$course_uid';");
						if(!$file_stmt) die(mysql_error());
						$file_no_row = mysql_num_rows($file_stmt);
						echo($file_no_row." questions"); 
						?>)</font>        </td>
                                <td width="186" valign="middle" style="font-size:14px; font-family:Arial, Helvetica, sans-serif"><?php echo($pid) ?> </td>
                                <td width="52" valign="middle" align="center"><input type="checkbox" name="course_uid[]" value="<?php echo($course_uid) ?>" <?php echo($chk_tag) ?> />                                  </td>
                              </tr>
    </table>
                            <?php
					  }?>                          </td>
                        </tr>
                      <tr>
                        <td height="22" colspan="2" align="right" valign="middle" style="padding-right:0; padding-top:0;"></td>
                        </tr>
                      </table>
				      <?php if($course_num != 0){ ?>
                    <table width="1002" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #DDDDDD; border-top:0">
                      <tr>
                        <td width="804" height="20" align="left" valign="middle" bgcolor="#EEEEEE" style="padding-left:20; padding-top:20; padding-bottom:20; font-weight:bold; font-size:12px; font-family:Arial, Helvetica, sans-serif"> * Select interested courses, and submit for subscribing </td>
                          <td width="194" height="20" align="right" valign="top" bgcolor="#EEEEEE" style="padding-right:25; padding-top:15; padding-bottom:15"><input type="submit" name="Submit2" style="height:24; padding:4 10 4 10; background: url(img/black_cell_bg.jpg); border:1px solid #333333; border-top:0px solid #DDDDDD; line-height:120%; font-size:13px; cursor:pointer; color:#FFFFFF; font-family:Arial, Helvetica, sans-serif; display:inline" value="Submit selected class(es)" /></td>
                        </tr>
                      </table>
				      <?php } ?>
                    </form>
                      <br />                  </td>
                  <td width="293" style="border-left: 0px solid #EEEEEE;">&nbsp;</td>
                </tr>
              </table>            </td>
          </tr>
      </table></td>
    </tr>
</table>
</div>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
