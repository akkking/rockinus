<?php 
include("Header.php"); 

if(isset($_POST['deleteEvent'])){
	$eid = $_POST['eid'];
	$pageName = $_POST['pageName'];
	$q = mysql_query("DELETE FROM rockinus.event_info where eid=$eid");
	if(!$q) die(mysql_error());
	$_SESSION['rst_msg']="<div align='center' style='padding-top:10; padding-bottom:10; margin-top:10; color:#336633'><font size=4><strong><img src=img/addsuccessIcon.jpg>&nbsp;&nbsp; This event has been deleted successfully!</strong><br><br><a href=".$pageName.".php class=one>Go Back</a></font></div>"; 
	//header("location:HouseFleaResult.php");
}else if(isset($_POST['attendEvent'])){
	$eid = $_POST['eid'];
	$pageName = $_POST['pageName'];
	
//	$q1 = mysql_query("SELECT * FROM rockinus.event_info where eid='$eid'");
	$q1 = mysql_query("INSERT INTO rockinus.event_attendance (eid, sender, descrip, rstatus, pdate, ptime) VALUES('$eid','$uname','','Y', CURDATE(), NOW());");
	if(!$q1) die(mysql_error());
//	$object = mysql_fetch_object($q1);
//	$attendance = $object->attendance;
//	if(strlen(trim($attendance))==0 || $attendance==NULL)
//		$upd_sql = "UPDATE rockinus.event_info SET attendance='$uname' WHERE eid=$eid";
//	else{
//		$upd_name = ",".$uname;
//		$upd_sql = "UPDATE rockinus.event_info SET attendance = CONCAT(attendance, '$upd_uname') WHERE eid=$eid";
//	}
	
	//$q = mysql_query($upd_sql);
	//if(!$q) die(mysql_error());
	$_SESSION['rst_msg']="<div align='center' style='padding-top:10; padding-bottom:10; margin-top:10; color:#336633'><font size=4><strong><img src=img/addsuccessIcon.jpg>&nbsp;&nbsp; You have been added to the attendant list for this event!</strong><br><br><a href=".$pageName.".php class=one>Go Back</a></font></div>"; 
	//header("location:HouseFleaResult.php");
}else{
	if(isset($_GET['eid'])){
		$eid = $_GET['eid'];
		$q1 = mysql_query("SELECT * FROM rockinus.event_info where eid='$eid'");
		if(!$q1) die(mysql_error());
		$object = mysql_fetch_object($q1);
		$creater = $object->creater;
		$subject = $object->eventTitle;
		$descrip = $object->descrip;
	
		$q_attend = mysql_query("SELECT * FROM rockinus.event_attendance WHERE eid='$eid' AND rstatus='Y'");
		$no_row_attend = mysql_num_rows($q_attend);
		//$attendance = $object->attendance;
		if($no_row_attend>0){
			while($object = mysql_fetch_object($q_attend)){
				$attendance = $object->sender." ";
			}
		}else
			$attendance = $creater;
	}
	
	if(isset($_GET['pageName'])){
		$pageName = $_GET['pageName'];
	}
	
	if(isset($_GET['attend'])){
		$attend = $_GET['attend'];
	}else
		$attend = "N";
}

if(isset($_SESSION['usrname'])){
	$uid = $_SESSION['usrname'];
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
<div align="center">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" style="padding-top:-5; margin-top:5;">
    <tr>
      <td width="128" align="left" valign="top" style="border-right: 0px solid #EEEEEE; padding-left:10; width:10">
	  <?php include("leftMenu".$_SESSION['lan'].".php"); ?>
      </td>
      <td width="860" align="center" valign="top" style=" border:#CCCCCC solid 0">
	  <div style="padding: 20; width:700; border:#CCCCCC solid 8; background-color:#EEEEEE; margin-top:10; margin-bottom:20; vertical-align:top" align="left">
	  <?php if(isset($_SESSION['rst_msg'])){
	  			echo($_SESSION['rst_msg']);
				unset($_SESSION['rst_msg']);
			}else{ 
		?>	
	  <form method="post" action="EventConfirm.php">
      <input type="hidden" name="eid" value="<?php echo($eid) ?>" />
      <input type="hidden" name="pageName" value="<?php echo($pageName) ?>" />
      <input type="hidden" name="attend" value="<?php echo($attend) ?>" />
	  <font style="font-size:20px">
	  <?php 
	    if($attend=="Y"){
	  		echo("You confirm that you will attend this event?");
		}else
			echo("Are you sure, you want to delete this event?");
	  ?>
	  </font><br /><hr size="2" style="margin-top:15" /><br />
	  <font style="font-size:16px; color:<?php echo($_SESSION['hcolor']) ?>"><strong><?php echo($subject) ?></strong></font>
	  <p style="margin-top:15" />
	  <div style="line-height:150%"><?php echo(nl2br($descrip)) ?></div>
	  <p style="margin-top:20" />
	  <div style=" padding-top:5">
	  <input type="submit" name="<?php if($attend=="Y")echo("attendEvent"); else echo("deleteEvent"); ?>" value="<?php if($attend=="Y")echo("Yes, I will attend"); else echo("delete"); ?>" style="background-color:#666666; padding-top:5; padding-left:5; padding-right:5; padding-bottom:5; height:25; border:0; color:#F5F5F5"> &nbsp;
	  <input type="button" value=" No " style="background-color:#666666; padding-top:5; padding-left:5; padding-right:5; padding-bottom:5; height:25; border:0; color:#F5F5F5" ONCLICK="window.location.href='<?php echo($pageName.'.php?uid='.$uid) ?>'">
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
