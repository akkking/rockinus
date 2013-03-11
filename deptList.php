<?php 
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
$ua=getBrowser();
  
include 'dbconnect.php';
$pic210_Name = $uname.'210.jpg';
$ProPercent = 70;

$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$hcolor = $object->hcolor;

$q = mysql_query("SELECT * FROM rockinus.user_info INNER JOIN rockinus.user_check_info INNER JOIN rockinus.user_edu_info INNER JOIN rockinus.user_contact_info ON user_info.uname='$uname' AND user_info.uname=user_check_info.uname AND user_info.uname=user_edu_info.uname AND user_info.uname=user_contact_info.uname");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;
$fname = $object->fname;
$lname = $object->lname;
$birthdate = $object->birthdate;
$sterm = $object->sterm;
$fregion = $object->fregion;
$fcountry = $object->fcountry;
$email = $object->email;
$cmajor = $object->cmajor;
if(trim($cmajor)=="empty") $cmajor=NULL;
$cschool = $object->cschool;
if(trim($cschool)=="empty") $cschool=NULL;
$cdegree = $object->cdegree;
if(trim($cdegree)=="empty") $cdegree=NULL;
$cstate = $object->cstate;
$ccity = $object->ccity;

if($cschool!=NULL){
	$q = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
	if(!$q) die(mysql_error());
	$obj = mysql_fetch_object($q);
	$cschool = $obj->school_name;
}else $cschool = "Unknown School";

if($cmajor!=NULL){	
	$q = mysql_query("SELECT * FROM rockinus.major_info where mid='$cmajor'");
	if(!$q) die(mysql_error());
	$obj = mysql_fetch_object($q);
	$cmajor = $obj->major_name;
}else $cmajor = "Unknown Major";

if($ccity==NULL || $ccity=="empty" ) $ccity = "Unknown City";
if($cstate==NULL || $cstate=="em" ) $cstate = "Unknown State";
if($cdegree==NULL) $cdegree = "Unknown Diploma";
if($mstatus==NULL) $mstatus = "Unknown Status";

$z = mysql_query("SELECT * FROM rockinus.user_edu_info WHERE uname='$uname'");
if(!$z) die(mysql_error());
$objz = mysql_fetch_object($z);
$cmajor = $objz->cmajor;	

if($cmajor!=NULL && strlen($cmajor)>0){
	$m = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid='$cmajor'");
	if(!$m) die(mysql_error());
	$objm = mysql_fetch_object($m);
	$major_name = $objm->major_name;	
}

$sel_cond = NULL;
if( isset($_POST["category"]) && ($_POST["category"]!="Blank") ){
	$sel_cond.= " AND category='".$_POST["category"]."'";	
	$_SESSION['category'] = $_POST['category'];
}

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

while($object = mysql_fetch_object($q)){
$sid = $object->sid;
$school_name = $object->school_name;
$city = $object->city;
}
?>
<div align="center">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="center">
    <tr>
      <td width="300" align="left" valign="top" style=" border-right:1px #DDDDDD dashed">
	  <?php include("leftHomeMenu.php") ?>
	  </td>
      <td width="760" align="right" valign="top" style="border-right:0px #DDDDDD dashed"><table width="760" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="right" valign="top">
		  <?php include("HeaderEN.php"); ?>
		  <table border="0" cellpadding="0" cellspacing="0" width="740" style="margin-top:0">
            <tr>
              <td height="50" colspan="3" bgcolor="" style="border-bottom: 0px solid #DDDDDD; border-top: 0px solid #DDDDDD; padding-left:0; padding-top:0">
			  <img src="img/polyCampusFrontLib.jpg" width="740" style="border:2px solid #000000" /> </td>
            </tr>
            <tr>
              <td width="352" rowspan="3" valign="top" align="left" style="padding-top:0px; border-right:1px dashed #DDDDDD"><table width="337" height="198" border="0" cellpadding="0" cellspacing="0" bgcolor="" style="margin-top:0; border:0px #DDDDDD solid; border-bottom:1px #DDDDDD solid">
                  <tr>
                    <td width="337" height="40" style="padding-left:15; padding-top:20; font-size:16px; font-weight:bold"><img src="img/greenstartopi.jpg" /> &nbsp;Top Departments</td>
                  </tr>
                  <tr>
                    <td height="10" style="padding-left:15; padding-top:0; font-size:16px; font-weight:bold">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="25" style="padding-left:15; font-size:14px ">Computer Science &amp; Engineering</td>
                  </tr>
                  <tr>
                    <td height="25" style="padding-left:15; font-size:14px ">Electrical Engineering</td>
                  </tr>
                  <tr>
                    <td height="25" style="padding-left:15; font-size:14px ">Civil Engineering</td>
                  </tr>
                  <tr>
                    <td height="25" style="padding-left:15; font-size:14px">Biometric Engineering</td>
                  </tr>
                  <tr>
                    <td height="25" style="padding-left:15; font-size:14px"> Financial Engineering </td>
                  </tr>
                  <tr>
                    <td height="5" style="padding-left:15; font-size:14px">&nbsp;</td>
                  </tr>
                </table>
                  <table width="320" height="165" border="0" cellpadding="0" cellspacing="0" bgcolor="" style="margin-top:20px; border:0px #DDDDDD solid; border-bottom:0px #DDDDDD solid">
                    <tr>
                      <td height="30" colspan="2" style="padding-left:15; font-weight:bold; font-size:16px"><img src="img/greenstartopi.jpg" /> &nbsp;Class Profiles </td>
                    </tr>
                    <tr>
                      <td height="10" colspan="2" style="padding-left:15; font-weight:bold; font-size:16px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="25" style="padding-left:15; font-size:14px">Comments</td>
                      <td height="25" style="padding-right:15; font-size:14px;  font-weight:bold" align="left"><?php
					$q1 = mysql_query("SELECT * FROM rockinus.course_memo_info");
					if(!$q1) die(mysql_error());
					$no_row = mysql_num_rows($q1);
							 echo($no_row);
							  ?>
                      </td>
                    </tr>
                    <tr>
                      <td width="256" height="25" style="padding-left:15; font-size:14px">Uploaded Files</td>
                      <td width="64" height="25" align="left" style="padding-right:15; font-size:14px; font-weight:bold"><?php
					$q1 = mysql_query("SELECT * FROM rockinus.user_file_info");
					if(!$q1) die(mysql_error());
					$no_row = mysql_num_rows($q1);
							 echo($no_row);
							  ?>
                      </td>
                    </tr>
                    <tr>
                      <td height="25" style="padding-left:15; font-size:14px">Subscribed Students</td>
                      <td height="25" style="padding-right:15; font-size:14px; font-weight:bold" align="left"><?php
					$q1 = mysql_query("SELECT * FROM rockinus.user_course_info GROUP BY uname");
					if(!$q1) die(mysql_error());
					$no_row = mysql_num_rows($q1);
							 echo($no_row);
							  ?>
                      </td>
                    </tr>
                    <tr>
                      <td height="25" style="padding-left:15; font-size:14px">Subscribed Courses</td>
                      <td height="25" style="padding-right:15; font-size:14px; font-weight:bold" align="left"><?php
					$q1 = mysql_query("SELECT * FROM rockinus.user_course_info GROUP BY course_uid");
					if(!$q1) die(mysql_error());
					$no_row = mysql_num_rows($q1);
							 echo($no_row);
							  ?>
                      </td>
                    </tr>
                    <tr>
                      <td height="5" style="padding-left:15; font-size:14px">&nbsp;</td>
                      <td height="5" style="padding-right:10; font-size:14px" align="right">&nbsp;</td>
                    </tr>
                </table></td>
              <td width="392" height="40" align="left" valign="middle" style="padding-top:20px; padding-left:30px"><strong><font size="4">Masters</font></strong> </td>
            </tr>
            <tr>
              <td height="56" valign="top" style="padding-top:20; padding-left:15; padding-bottom:20; font-size:14px" align="left"><?php	
	$q1 = mysql_query("SELECT * FROM rockinus.school_major_info where sid='$sid' AND mtype='Master'");
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
?>
                &nbsp;&nbsp;&nbsp; <?php echo("<a href='MajorDetail.php?sid=$sid&&mtype=Master&&mid=$mid' class='one'>$major_name</a>") ?><br />
                <br />
                <?php } ?>
              </td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
