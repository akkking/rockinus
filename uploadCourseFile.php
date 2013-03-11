<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];

$q = mysql_query("SELECT sum(file_size) as total_file_size FROM rockinus.user_file_info WHERE owner = '$uname'");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) $wid=0;
else{
	$object = mysql_fetch_object($q);
	$total_file_size = $object->total_file_size;
	$wid = $total_file_size/(1024 * 50) * 100;
	//echo $wid."<br>";
//	$arr = explode('.', $total_file_size/1024);
	$used_MB = substr(50 - $total_file_size/1024,0,4);
	$left_MB = 50 - $used_MB;
	$wid_left = 100 - $wid-0.01;
}

if(isset($_POST["CourseUid"])){
	if(isset($_SESSION["course_uid"])) unset($_SESSION["course_uid"]);
	if(isset($_GET['resume'])) unset($_GET['resume']);
	$_SESSION["course_uid"] = $_POST["CourseUid"];
	$course_uid = $_SESSION['course_uid'];
	//$uploaddir = "upload/course/".$uname."/".$course_uid;
	//if(!is_dir($uploaddir)) mkdir($uploaddir,0777,true);
}
//echo $_SESSION["course_uid"] ;

if(isset($_POST["uploadSubmit"])){
	$ok = 1;
	$course_uid = $_POST['course_uid'];
	$dstatus = $_POST['dstatus'];
	$file1_name = $_FILES['uploaded1']['name'];
	$file2_name = $_FILES['uploaded2']['name'];
	$file3_name = $_FILES['uploaded3']['name'];
	$content_1 = $_POST['content_1'];
	$content_2 = $_POST['content_2'];
	$content_3 = $_POST['content_3'];
	if(trim($content_1)=="Please write description")$content_1 = null;
	if(trim($content_2)=="Please write description")$content_2 = null;
	if(trim($content_3)=="Please write description")$content_3 = null;
	
	if( trim($file1_name)!=NULL || trim($file2_name)!=NULL || trim($file3_name)!=NULL ) {
		if(trim($course_uid)=='Y'){
			$target = "resume_upload/".$uname."/";			
			$_GET['resume'] = 'Y';
		}else
			$target = "course_upload/".$uname."/".$_SESSION['course_uid']."/";
		if(!is_dir($target)) mkdir($target,0777,true);
	}

	if( trim($file1_name)!=NULL ) {
		$uploaded1_size = ($_FILES["uploaded1"]["size"]) / 1024;
		$uploaded1_type = $_FILES["uploaded1"]["type"];
		$new_file1_name = $target.$file1_name;
		
		//$fileNameParts   = explode( ".", $file1_name ); // explode file name to two part
 		//$fileExtension   = end( $fileNameParts ); // give extension
 		//$fileExtension   = strtolower( $fileExtension ); // convert to lower case
 		//$new_file1_name  = "1.".$fileExtension;  // new file name
 		//$new_file1_name  = $target.$new_file1_name;

		//This is our size condition 
		if($uploaded1_size > 2048){ 
 			$tmp_rst_msg = "the file ".$file1_name." is too large"; 
 			$ok=0; 
		} 
	}
	
	if( trim($file2_name)!=NULL  ) {
		$uploaded2_size = ($_FILES["uploaded2"]["size"]) / 1024;
		$uploaded2_type = $_FILES["uploaded2"]["type"];
		$new_file2_name = $target.$file2_name;
		
		//$fileNameParts   = explode( ".", $file2_name ); // explode file name to two part
 		//$fileExtension   = end( $fileNameParts ); // give extension
 		//$fileExtension   = strtolower( $fileExtension ); // convert to lower case
 		//$new_file2_name   = "2.".$fileExtension;  // new file name
 		//$new_file2_name   	 = $target.$new_file2_name;

		if(trim($file2_name)==trim($file1_name)){ 
 			$tmp_rst_msg = "having same file name ".$file2_name." confliction "; 
 			$ok=0; 
		} 
		
		//This is our size condition 
		if($uploaded2_size > 2048){ 
 			$tmp_rst_msg = "the file ".$file2_name." is too large"; 
 			$ok=0; 
		} 
	}
	
	if( trim($file3_name)!=NULL  ) {
		$uploaded3_size = ($_FILES["uploaded3"]["size"]) / 1024;
		$uploaded3_type = $_FILES["uploaded3"]["type"];
		$new_file3_name = $target.$file3_name;
		
		//$fileNameParts   = explode( ".", $file3_name ); // explode file name to two part
 		//$fileExtension   = end( $fileNameParts ); // give extension
 		//$fileExtension   = strtolower( $fileExtension ); // convert to lower case
 		//$new_file3_name   = "3.".$fileExtension;  // new file name
 		//$new_file3_name   = $target.$new_file3_name;
 
		if(trim($file3_name)==trim($file1_name)){ 
 			$tmp_rst_msg = "having same file name ".$file3_name." confliction "; 
 			$ok=0; 
		} 
		
		if(trim($file3_name)==trim($file2_name)){ 
 			$tmp_rst_msg = "having same file name ".$file3_name." confliction "; 
 			$ok=0; 
		} 
		
		//This is our size condition 
		if($uploaded3_size > 2048){ 
 			$tmp_rst_msg = "the file ".$file3_name." is too large"; 
 			$ok=0; 
		} 
	}
	
	if($ok==0){ 
 		$_SESSION['rst_msg'] = "<div align='center' style='width:650px; padding-top:20px; padding-bottom:20px; font-size:16px; color:#B92828; border: 4px solid #DDDDDD; line-height:150%; background:#F5F5F5'><strong>Sorry your file(s) were not uploaded, because ".$tmp_rst_msg.", please try again.</strong><br></div>"; 
		//header("location:ChangeHeadIcon.php");
 	}else{ 
 		if( (trim($file1_name)!=NULL) && move_uploaded_file($_FILES['uploaded1']['tmp_name'], trim($new_file1_name)) ) { 
			//$dstatus = "F";
			$sql = "INSERT INTO rockinus.user_file_info(file_name,file_size,owner,course_uid,dstatus,descrip,pdate,ptime)VALUES('$file1_name','$uploaded1_size','$uname','$course_uid','$dstatus','$content_1',CURDATE(), NOW())";
			$result = mysql_query($sql);
			if (!$result) die('Invalid query: ' . mysql_error());
		}
		
		if( (trim($file2_name)!=NULL) && move_uploaded_file($_FILES['uploaded2']['tmp_name'], trim($new_file2_name)) ) { 
			// Only friend can download
			//$dstatus = "F";
			$sql = "INSERT INTO rockinus.user_file_info(file_name,file_size,owner,course_uid,dstatus,descrip,pdate,ptime)VALUES('$file2_name','$uploaded2_size','$uname','$course_uid','$dstatus','$content_2',CURDATE(), NOW())";
			$result = mysql_query($sql);
			if (!$result) die('Invalid query: ' . mysql_error());
		}
		
		if( (trim($file3_name)!=NULL) && move_uploaded_file($_FILES['uploaded3']['tmp_name'], trim($new_file3_name)) ) { 
			//$dstatus = "F";
			$sql = "INSERT INTO rockinus.user_file_info(file_name,file_size,owner,course_uid,dstatus,descrip,pdate,ptime)VALUES('$file3_name','$uploaded3_size','$uname','$course_uid','$dstatus','$content_3',CURDATE(), NOW())";
			$result = mysql_query($sql);
			if (!$result) die('Invalid query: ' . mysql_error());
		}
		
		$_SESSION['rst_msg'] = "<div align='center' style='width:640px; padding-top:20px; padding-bottom:20px; font-size:18px; color:#000000; border: 4px solid #DDDDDD; background:#F5F5F5'><strong><img src='img/addsuccessIcon.jpg' width=25px />&nbsp;&nbsp; File(s) have been uploaded succeussfully.</strong><br></div>"; 

		if(isset($_SESSION["course_uid"])) unset($_SESSION["course_uid"]);
		if(isset($_GET["resume"])) unset($_GET["resume"]);
		//$sql = "INSERT INTO rockinus.user_file_info (subject,type, buysale, aname, quality, delivery, city, state, num,rate,telephone,rstatus,descrip,uname, email, pdate,ptime, edate, tbname) VALUES('$subject','$type','$buysale','$aname','$quality','$delivery','$city','$state','$num','$rate','$telephone','Y','$description','$uname','$email',CURDATE(),NOW(),'$edate', 'article_info')";
		//$result = mysql_query($sql);
		//if (!$result) die('Invalid query: ' . mysql_error());
	}
}
?>
<link href="style.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery.min.js"></script>
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
<script type="text/javascript">
 $(document).ready(function(){
	$("#FadeCourseInMajor").click(function(){
		$("#CourseInMajor").fadeIn("fast");
		//$("#swfupload-control").fadeIn("fast");
		$("#CourseInSubscribed").fadeOut("fast");
	});
 });
</script>
<script type="text/javascript">
 $(document).ready(function(){
	$("#FadeCourseInSubscribed").click(function(){
		$("#CourseInSubscribed").fadeIn("fast");
		//$("#swfupload-control").fadeOut("fast");
		//$("#swfupload-control").fadeIn("fast");
		$("#CourseInMajor").fadeOut("fast");
	});
 });
</script>
<div align="center" style="width:100%">
<table width="1024" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="300" align="left" valign="top" style="border-right: 1px dashed #DDDDDD;">
	  <?php include("leftHomeFileMenu.php"); ?>
</td>
<td height="760" align="right" valign="top">
	  <?php include("HeaderEN.php"); ?>
<div align="right" style="width:740px;">
<table width="740" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid; border-top:0px; background-color:">
<tr>
<td height="60" align="left" background="#F5F5F5" style="width:650; border-top:1px #CCCCCC solid; background-color:#F5F5F5; margin-bottom:20px; font-size:18px; color:<?php echo($_SESSION['hcolor']) ?>; padding-top:7px; padding-bottom:7px">&nbsp;&nbsp;<img src="img/fileIcon.jpg" width="20" />&nbsp;&nbsp; 
	User Course Files Upload Instruction and Notice</td>
</tr>
<tr>
  <td valign="top" align="left" style="padding-left:40px; padding-top:15px; font-size:16px; font-family:Arial, Helvetica, sans-serif">  
<img src="img/greenstartopi.jpg" width="15" />&nbsp;&nbsp;&nbsp;You have <strong><?php echo substr($wid_left,0,2) ?>%</strong> space left, which is <strong><?php echo $used_MB ?></strong>MB out of 50MB
<div align="left" style="width:650px; border:1px #666666 solid; background: #EEEEEE; margin-bottom:20px; margin-top:10px">
<table height="20" border="0" cellpadding="0" cellspacing="0" style="border:1px #CCCCCC solid">
<tr>
<td height="20" width="<?php echo(6.5*$wid)?>" background="img/black_cell_bg.jpg" align="left">&nbsp;</td>
</tr>
</table>
</div>
<div style=" font-family:Arial, Helvetica, sans-serif; font-size:13px; background-color:; display:inline; margin-bottom:15; margin-top:5; line-height:150%; width:630px">
	&raquo; &nbsp;Upload upto 3 files at one time, each having maximum size of 2MB<br />
	&raquo; &nbsp;Each user has maximum 50MB space for uploading files<br />
	&raquo; &nbsp;Make sure your uploaded files are not violating original author's copyrights <br />
	&raquo; &nbsp;The purpose of uploading files are to improve students' study in courses<br />
	&raquo; &nbsp;If uploading others' works, please let actual users noticed, also declare in description<br />
	&raquo; &nbsp;If files are from professor's class notes or related, mark the original source<br />
	&raquo; &nbsp;Please do not upload virus program. Once doing so, ID will be closed permanently
	</div>
	<p style="margin-bottom:20px">
<hr style="height:2px; width:650px; color:#999999; background-color:#666666; border:2px solid #666666; margin-left:0px; margin-bottom:15px" align="left"/>
<?php 
	  if(isset($_SESSION['rst_msg'])){
	  	echo $_SESSION['rst_msg'];
	  	unset($_SESSION['rst_msg']); }
	  ?>
<p style="margin-bottom:25px">
<div style="border:0 #DDDDDD solid; background-color:; display:inline; padding:0; margin-top:10px; font-size:16px; color:<?php echo($_SESSION['hcolor']) ?>">
	<img src="img/greenstartopi.jpg" />&nbsp;&nbsp; <strong>Please select where or what you want to upload?</strong>  </div>
	<table width="650" border="0" cellspacing="0" cellpadding="0" style="margin-top:25px">
      <tr>
        <td height="40" valign="top" style="padding-left:10px">
		<div id="FadeCourseInSubscribed" style="display: inline; font-size: 14px; cursor:pointer">
<strong>+&nbsp;&nbsp;<u>Upload to my subscribed courses</u></strong></div>
<div style="display:none; padding-left:15px; padding-top:10px; padding-bottom:10px" id="CourseInSubscribed">
<form name="SetSession" method="post">
<select name="CourseUid" id="CourseUid" onChange="this.form.submit()" style="margin-top:10px; margin-bottom:15px; font-size:14px; font-family: Arial, Helvetica, sans-serif">
<option value="empty">Please select the course you want to upload </option>
<?php
$q1 = mysql_query("SELECT a.course_uid, a.pid, a.course_id, b.course_name FROM rockinus.unique_course_info a JOIN rockinus.course_info b JOIN rockinus.user_course_info c ON c.uname='$uname' AND a.course_id=b.course_id AND a.course_uid = c.course_uid GROUP BY c.course_uid;");
if(!$q1) die(mysql_error());
while($object = mysql_fetch_object($q1)){
	$course_uid = $object->course_uid;
	$course_id = $object->course_id;
	$course_name = $object->course_name;
	$pid = $object->pid;
	echo("<option value=$course_uid>$course_id | $course_name | $pid</option>");
} 
?>
</select>
</form>	
</div></td>
        </tr>
      <tr>
        <td height="40" valign="top" style="padding-left:10px">
		<div id="FadeCourseInMajor" style="display: inline; font-size: 14px; cursor:pointer">
	<strong>+&nbsp;&nbsp;<u>Upload to courses under my major</u></strong>	</div>
<div style="display:none; padding-left:15px; padding-top:10px; padding-bottom:10px" id="CourseInMajor">
<form name="SetSession" method="post">
<select name="CourseUid" id="CourseUid" onChange="this.form.submit()" style="margin-top:10px; margin-bottom:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">
<option value="empty">Please select the course you want to upload </option>
<?php
//REMEMBER TO CONNECT TO DATABASE!
include '../dbconnect.php';

$q1 = mysql_query("SELECT a.course_uid, a.pid, a.course_id, b.course_name FROM rockinus.unique_course_info a JOIN rockinus.course_info b ON a.course_id=b.course_id AND a.course_id LIKE 'CS%' GROUP BY a.course_uid;");
if(!$q1) die(mysql_error());
while($object = mysql_fetch_object($q1)){
	$course_uid = $object->course_uid;
	$course_id = $object->course_id;
	$course_name = $object->course_name;
	$pid = $object->pid;
	echo("<option value=$course_uid>$course_id | $course_name | $pid</option>");
} 
?>
</select>
</form>	
</div>	</td>
        </tr>
      <tr>
        <td height="40" valign="top" style="padding-left:10px">
<div id="FadeResume" style="display: inline; font-size: 14px; cursor:pointer">
	<strong>+&nbsp;&nbsp;<a href="uploadCourseFile.php?resume=Y" class="one"><u>Upload my resume & cover letter</u></a></strong>	
	</div>
		</td>
      </tr>
      <tr>
        <td valign="middle" align="left" height="90px" style="padding-top:20px"> 
		<?php
			if( isset($_GET['resume']) && $_GET['resume']=="Y" ){
				echo("<div style='background-color:; padding:5px; font-size:16px; font-weight:bold; color:$_SESSION[hcolor]; padding-left:0px; padding-right:10px; border:0px #666666 solid; display:inline'><img src='img/addsuccessIcon.jpg' width=15px />&nbsp;&nbsp;&nbsp;$uname, just a reminder that your current upload target is :</div><p style='margin-top: 30px'><div style='background-color:#F5F5F5; padding:5px; color:#FFFFFF; padding-left:10px; padding-right:10px; border:2px #DDDDDD solid; display:inline; margin-left:25px'><font color=#B92828><strong>Resume | Cover Letter</strong></font></div><p style='margin-bottom: 10px'>");
			}else if( isset($_SESSION['course_uid']) && $_SESSION['course_uid']!="empty" ){
				$course_uid = $_SESSION['course_uid'];
				$q1 = mysql_query("SELECT a.pid, a.course_id, b.course_name FROM rockinus.unique_course_info a JOIN rockinus.course_info b ON a.course_uid='$course_uid' AND a.course_id=b.course_id GROUP BY a.course_uid;");
				if(!$q1) die(mysql_error());
				$object = mysql_fetch_object($q1);
				$course_id = $object->course_id;
				$course_name = $object->course_name;
				$pid = $object->pid;
					echo("<div style='background-color:#F5F5F5; padding-top:10; padding-bottom:0; padding:10; margin-bottom: 20; font-size:14px; font-weight:bold; color:; border-top:1px #CCCCCC solid; border-bottom:1px #CCCCCC solid; line-height:300%'><img src='img/addsuccessIcon_F5.jpg' width=15px />&nbsp;&nbsp;&nbsp;Just a reminder that your current selected course is : <br> <font color=$_SESSION[hcolor]><strong>". $course_id." | ".$course_name." | ".$pid."</strong></font></div>");
			}
		?>		</td>
	  </tr>
	  <tr>
        <td valign="middle" align="left" height="50px" style="padding-left:0px">
		<div id="load" style="display:none;"><img src="img/loading42.gif" /></div>
		<form method="post" enctype="multipart/form-data"  action="uploadCourseFile.php" onSubmit="return ray.ajax()">
		<div id="swfupload-control" style="
		<?php if( (isset($_SESSION["course_uid"]) && $_SESSION["course_uid"] =="empty") || !isset($_SESSION["course_uid"]) && !isset($_GET["resume"]) ) echo("display:none;");else echo("display:visible;"); ?> margin-top:20px; margin-bottom:20px; width:650px">
		<table width="650" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td height="40" colspan="4" align="left" valign="top" style="padding-left:0; padding-top:15px; font-size:16px; color:<?php echo($_SESSION['hcolor']) ?>">
		  <img src="img/greenstartopi.jpg" />&nbsp;&nbsp; <strong>Please select your files to upload</strong>		  </td>
		  </tr>
		<tr>
              <td width="21" height="35" align="right" style="padding-right:10; font-size:14px"></td>
              <td width="629" height="35" colspan="3" style="font-size:12px " align="left">
			  <input name="uploaded1" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif; background-color: #" />
                  <font color="#CCCCCC">&nbsp;&nbsp;Smaller than 2MB</font></td>
            </tr>
		<tr>
		  <td height="35" align="right" style="padding-right:10; font-size:14px"></td>
		  <td height="35" colspan="3" style="font-size:12px " align="left">
		  <textarea name="content_1" id="content_1" cols="60" rows="5" style="border:1px #DDDDDD solid; font-size:13px; font-family:Arial, Helvetica, sans-serif" onFocus="this.style.backgroundColor='#F5F5F5'; this.style.borderColor='#CCCCCC';">Please write description</textarea>		  </td>
		  </tr>
		<tr>
		  <td height="15" align="right" style="padding-right:10; font-size:14px"></td>
		  <td height="15" colspan="3" style="padding-left: 10px; font-size:12px ">&nbsp;</td>
		  </tr>
            <tr>
              <td height="35">
			  <input type="hidden" name="course_uid" value="<?php if(isset($_GET['resume']))echo($_GET['resume']);else if(isset($_SESSION['course_uid']))echo($_SESSION['course_uid']); ?>" />			  </td>
              <td height="35" colspan="3" style="font-size:12px" align="left">
			  <input name="uploaded2" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif; background-color: #" />
              <font color="#CCCCCC">&nbsp;&nbsp;Smaller than 2MB</font></td>
            </tr>
            <tr>
              <td height="35">&nbsp;</td>
              <td height="35" colspan="3" style="font-size:12px" align="left">
			  <textarea name="content_2" id="content_2" cols="60" rows="5" style="border:1px #DDDDDD solid; font-size:13px; font-family:Arial, Helvetica, sans-serif" onFocus="this.style.backgroundColor='#F5F5F5'; this.style.borderColor='#CCCCCC';" >Please write description</textarea>
			  </td>
            </tr>
            <tr>
              <td height="15">&nbsp;</td>
              <td height="15" colspan="3" style="padding-left: 10px; font-size:12px">&nbsp;</td>
            </tr>
            <tr>
              <td height="35">&nbsp;</td>
              <td height="35" colspan="3" style="font-size:12px" align="left">
			  <input name="uploaded3" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif; background-color: #" />
              <font color="#CCCCCC">&nbsp;&nbsp;Smaller than 2MB</font></td>
            </tr>
            <tr>
              <td height="35">&nbsp;</td>
              <td height="35" colspan="3" style="font-size:12px" align="left">
			  <textarea name="content_3" id="content_3" cols="60" rows="5" style="border:1px #DDDDDD solid; font-size:13px; font-family:Arial, Helvetica, sans-serif" onFocus="this.style.backgroundColor='#F5F5F5'; this.style.borderColor='#CCCCCC';">Please write description</textarea>		  </td>
            </tr>
            <tr>
              <td height="40">&nbsp;</td>
              <td height="40" colspan="3" style="font-size:14px; font-weight:bold" valign="bottom" align="left">Who can download?</td>
            </tr>
            <tr>
              <td height="40">&nbsp;</td>
              <td height="40" colspan="3" style="font-size:12px" align="left">
			  <select name="dstatus">
			  <option value="F">Only for Friends</option>
			  <option value="R" selected="selected">Approval Required</option>
			  <option value="A">Public to Everyone</option>
			  </select>			  </td>
            </tr>
			<tr>
              <td height="30">&nbsp;</td>
              <td height="70" colspan="3" style="font-size:14px" align="left">
			  <input type="submit" name="uploadSubmit" value=" Submit " class="profile_btn" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
			  </td>
            </tr>
			</table>
</div>
</form>		</td>
      </tr>
    </table>

</td>
</tr>
</table>
</div>
</td>
</tr>
</table>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
	</body>
</html>