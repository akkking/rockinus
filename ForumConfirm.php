<?php 
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
include 'dbconnect.php';

if(isset($_POST['deleteTopic'])){
	$foid = $_POST['foid'];
	$pageName = $_POST['pageName'];
	$q = mysql_query("DELETE FROM rockinus.forum_info where foid=$foid");
	if(!$q) die(mysql_error());
	$_SESSION['rst_msg']="<div align='center' style='padding-top:10; padding-bottom:10; margin-top:10; color:#336633'><font size=4><strong><img src=img/addsuccessIcon.jpg>&nbsp;&nbsp; This topic has been deleted successfully!</strong><br><br><a href=".$pageName.".php class=one>Go Back</a></font></div>"; 
	//header("location:HouseFleaResult.php");
}else{
	if(isset($_GET['foid'])){
		$foid = $_GET['foid'];
		$q1 = mysql_query("SELECT * FROM rockinus.forum_info where foid='$foid'");
		if(!$q1) die(mysql_error());
		$object = mysql_fetch_object($q1);
		$subject = $object->subject;
	}

	if(isset($_GET['pageName'])){
		$pageName = $_GET['pageName'];
	}
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
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="300" align="left" valign="top" style="border-right: 1px dashed #DDDDDD;">
	  <?php include("leftHomeMenu.php"); ?>
      </td>
      <td width="760" align="right" valign="top" style=" border:#CCCCCC solid 0">
	  <?php include("HeaderEN.php"); ?>
      <div style="padding: 20; width:700; border:#CCCCCC solid 8; background-color:#EEEEEE; margin-top:20; vertical-align:top" align="left">
	  <?php if(isset($_SESSION['rst_msg'])){
	  			echo($_SESSION['rst_msg']);
				unset($_SESSION['rst_msg']);
			}else{ 
		?>	
	  <form method="post" action="ForumConfirm.php">
      <input type="hidden" name="foid" value="<?php echo($foid) ?>" />
      <input type="hidden" name="pageName" value="<?php echo($pageName) ?>" />
	  <font style="font-size:20px">Are you sure, you want to delete this Topic?</font><br /><hr size="2" style="margin-top:15" /><br />
	  <font style="font-size:16px; color:<?php echo($_SESSION['hcolor']) ?>"><strong><?php echo($subject) ?></strong></font>
	  <p style="margin-top:25" />
	  <div style=" padding-top:5">
	  <input type="submit" name="deleteTopic" value="Delete" style="background-color:#666666; padding-top:5; padding-left:5; padding-right:5; padding-bottom:5; height:25; border:0; color:#F5F5F5"> &nbsp;
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
