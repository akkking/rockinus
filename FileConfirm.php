<?php 
include 'ValidCheck.php';
include("Allfuc.php");
include 'dbconnect.php';
$uname = $_SESSION['usrname'];

if(isset($_POST['deleteFile'])){
	$file_id = $_POST['file_id'];
	$course_uid = $_POST['course_uid'];
	$file_name = trim($_POST['file_name']);
	$pageName = $_POST['pageName'];
	if(trim($pageName)=="RockerDetail")$pageName = "RockerDetail.php?uid=".$uname;
	if($course_uid==0) $file_path = "resume_upload/".$uname."/".$file_name;
	else $file_path = "course_upload/".$uname."/".$course_uid."/".$file_name;
	if(file_exists($file_path)){
		unlink($file_path);	
		$dlt_stmt = "DELETE FROM rockinus.user_file_info WHERE owner='$uname' and file_id='$file_id'";	
		$dlt = mysql_query($dlt_stmt);
		if(!$dlt) die(mysql_error());
	
		$_SESSION['rst_msg']="<div align='center' style='padding-top:10; padding-bottom:10; margin-top:10; color:#336633; display:200%;font-size:16px'><strong><img src=img/addsuccessIcon.jpg>&nbsp;&nbsp; The file ".$file_name." has been deleted successfully!</strong><br><br><a href=".$pageName." class=one>Go Back</a></div>";
	}else {
		$_SESSION['rst_msg']="<div align='center' style='padding-top:10; padding-bottom:10; margin-top:10; color:#B92828; display:200%; font-size:16px'><strong>&nbsp;&nbsp; Sorry, the file $file_name was not found, delete operation unsuccessful!</strong><br><br><a href=".$pageName." class=one>Go Back</a></div>";
	}
}else{
	if(isset($_GET['file_id'])){
		$file_id = $_GET['file_id'];
		//echo("SELECT * FROM rockinus.user_file_info WHERE file_id='$file_id'");
		$q1 = mysql_query("SELECT * FROM rockinus.user_file_info WHERE file_id='$file_id'");
		if(!$q1) die(mysql_error());
		$object = mysql_fetch_object($q1);
		$file_name = $object->file_name;
		$file_size = $object->file_size;
		$course_uid = $object->course_uid;
	}
	
	if(isset($_GET['pageName'])){
		$pageName = $_GET['pageName'];
		if(trim($pageName)=="RockerDetail")$pageName = "RockerDetail.php?uid=".$uname;
	}
}

?>
<style type="text/css">
#confirmButton {
	display: inline;
	padding-left: 10;
	padding-right: 10;
	padding-top: 5;
	padding-bottom: 5;
	background-color: #666666;
	color: #F5F5F5;
	font-weight: bold;
}
</style>
<div align="center" style="width:100%">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="300" align="left" valign="top" style="border-right: 1px dashed #DDDDDD;">
	  <?php include("leftHomeMenu.php"); ?>
      </td>
      <td width="760" align="right" valign="top">
	  <?php include("HeaderEN.php"); ?>
	  <div style="padding: 20; width:700; border:#CCCCCC solid 8; background-color:#EEEEEE; margin-top:10; margin-bottom:20; vertical-align:top" align="left">
	  <?php if(isset($_SESSION['rst_msg'])){
	  			echo($_SESSION['rst_msg']);
				unset($_SESSION['rst_msg']);
			}else{ 
		?>	
	  <form method="post" action="FileConfirm.php">
      <input type="hidden" name="file_id" value="<?php echo($file_id) ?>" />
      <input type="hidden" name="file_name" value="<?php echo($file_name) ?>" />
      <input type="hidden" name="course_uid" value="<?php echo($course_uid) ?>" />
      <input type="hidden" name="pageName" value="<?php echo($pageName) ?>" />
	  <font style="font-size:20px">
	  <?php 
	  		echo("You confirm that you will remove this file?");  
	  ?>
	  </font><br /><hr size="2" style="margin-top:15; width:700" /><br />
	  <font style="font-size:16px; color:<?php echo($_SESSION['hcolor']) ?>">
	  <font color="#000000">File Name: </font><strong><?php echo($file_name) ?></strong> (<?php echo($file_size."KB") ?>)</font>
	  <p style="margin-top:15" />
	  <p style="margin-top:20" />
	  <div style=" padding-top:5; font-size:14px">
	  <input type="submit" name="deleteFile" value=" Delete " style="background-color:#666666; padding-top:3; padding-left:5; padding-right:5; padding-bottom:3; height:25; border:0; color:#F5F5F5; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold"> &nbsp;
	  <input type="button" value=" No " style="background-color:#666666; padding-top:3; padding-left:5; padding-right:5; padding-bottom:3; height:25; border:0; color:#F5F5F5; font-size:14px; font-weight:bold; font-family:Verdana, Arial, Helvetica, sans-serif;" ONCLICK="window.location.href='<?php echo($pageName) ?>'">
	  </div>
	  </form>
	  <?php } ?>
	  </div>
	  </td>
    </tr>
  </table>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
