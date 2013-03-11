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
		
		$_SESSION['rst_msg'] = "<div align='center' style='width:640px; padding-top:20px; padding-bottom:20px; font-size:18px; color:#000000; border: 4px solid #DDDDDD; background:#F5F5F5'><strong><img src='img/addsuccessIcon.jpg' width=25px />&nbsp;&nbsp; All file(s) have been uploaded succeussfully.</strong><br></div>"; 

		if(isset($_SESSION["course_uid"])) unset($_SESSION["course_uid"]);
		if(isset($_GET["resume"])) unset($_GET["resume"]);
		//$sql = "INSERT INTO rockinus.user_file_info (subject,type, buysale, aname, quality, delivery, city, state, num,rate,telephone,rstatus,descrip,uname, email, pdate,ptime, edate, tbname) VALUES('$subject','$type','$buysale','$aname','$quality','$delivery','$city','$state','$num','$rate','$telephone','Y','$description','$uname','$email',CURDATE(),NOW(),'$edate', 'article_info')";
		//$result = mysql_query($sql);
		//if (!$result) die('Invalid query: ' . mysql_error());
	}
}
?>

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
<table width="1024" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="300" align="left" valign="top" style="border-right: 1px dashed #DDDDDD;">
  <?php include("leftHomeFileMenu.php"); ?></td>
<td height="760" style="padding-left:30px" valign="top" align="right">
<?php include("HeaderEN.php"); ?>
<table width="740"><tr><td align="center" style="padding-bottom:10px; border:0 #DDDDD solid">
  <table width="740" height="40" border="0" cellpadding="0" cellspacing="0" style=" margin-bottom:15; border-top:1px #DDDDDD dashed; background-color:#F5F5F5">
    <tr>
      <td width="596" align="left" style="padding-left:10px">
	  <?php
		$q = mysql_query("SELECT * FROM rockinus.user_file_info WHERE course_uid='0' AND owner='$uname' ORDER BY file_id DESC LIMIT 0, 30");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		echo("<div style='background-color: ; color: $_SESSION[hcolor]; font-size:18px; padding-left:5px; padding-right:10px; display:inline; border-top:0px #CCCCCC solid; border-left:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding-top:6px; height:30px'>Your Resume & Cover Letters <font color=#666666>($no_row)</font></div>");
		?>      </td>
      <td width="144" align="right" style="">&nbsp;</td>
    </tr>
  </table>
  <?php
		if ($no_row == 0){
		echo("<div style='background-color:#FFFFFF; font-size:16px; width:740px; padding-top:25px; padding-bottom:25px; color:#333333' align='center'><strong>You have no resume uploaded ...<br><br>");
		}
		while($object = mysql_fetch_object($q)){
			$file_id = $object->file_id;
			$file_name = $object->file_name;
			$course_uid = $object->course_uid;
			$file_size = $object->file_size;
			$dstatus = $object->dstatus;
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			$descrip = $object->descrip;
			if(trim($dstatus)=='F')$dstatus_title = "Only for Friends";
			else if(trim($dstatus)=='R')$dstatus_title = "Approval required";
			else if(trim($dstatus)=='A')$dstatus_title = "Public to Everyone";
			if(strlen($descrip)==0 || $descrip==NULL) $descrip = "No description for this file";
		?>
  <table width="740" height="100" border="0" cellpadding="0" cellspacing="0" background="" style="margin-top:5px; margin-bottom:10px; border-bottom:1px solid #DDDDDD">
    <tr>
      <td width="48" height="30" bgcolor="#FFFFFF" style="padding-left:10px" align="left"><img src="img/fileWhiteIcon.jpg" width="25" /> </td>
      <td width="312" height="30" align="left" style="padding-left:10px; font-size:14px; font-weight:normal"><?php echo("<a href='course_upload/$uname/$course_uid/$file_name' class=one>".$file_name."</a>"); ?> </td>
      <td width="65" height="30" align="right" style="font-size:12px; padding-right:15px"><?php echo($file_size) ?>KB</td>
      <td width="210" height="30" align="right" style="font-size:12px; padding-right:10px;">
	  <select name="dstatus" style="font-size:12px">
	  <option value="A" <?php if($dstatus=='A')echo(" selected") ?>>Public to Everyone</option>
	  <option value="R" <?php if($dstatus=='R')echo(" selected") ?>>Approved required</option>
	  <option value="F" <?php if($dstatus=='F')echo(" selected") ?>>Only for Friends</option>
	  </select>
	  </td>
      <td width="105" height="30" align="right" style="font-size:12px; padding-right:5px">
	  <input type="submit" name="deleteFile" value=" Save " style=" height:23; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:12px; cursor:pointer; color:#000000;"/> 
	  </td>
    </tr>
    <tr>
      <td height="30" bgcolor="#FFFFFF" style="padding-left:3px" align="left">&nbsp;</td>
      <td height="30" align="left" style="padding-left:10px; font-size:11px; font-weight:normal">
	  <?php echo("$pdate | $ptime") ?>
	  </td>
      <td height="30" align="right" style="font-size:12px; padding-right:10px">&nbsp;</td>
      <td height="30" align="left" style="font-size:12px; padding-left:10px; font-weight:bold">&nbsp;</td>
      <td height="30" align="right" style="font-size:12px; padding-right:5px">
	  <input type="submit" name="deleteFile" value=" Delete " style=" height:23; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:12px; cursor:pointer; color:#000000;"/> 
	  </td>
    </tr>
    <tr>
      <td height="40" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
      <td height="40" colspan="5" align="left" style="padding:10px; padding-top:5; font-size:12px; line-height:150%; color:#666666; font-weight:bold"><?php echo("$descrip") ?> </td>
    </tr>
  </table>
  <?php } ?>
</td></tr></table>
</td>
</tr>
</table>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
	</body>
</html>