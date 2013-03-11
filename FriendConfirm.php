<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];

if(isset($_POST['deleteFriend'])){
	$uid = $_POST['uid'];
	$pageName = $_POST['pageName'];
	$t = mysql_query("SELECT count(*) as cnt FROM rockinus.rocker_rel_info WHERE sender='$uname' AND recipient='$uid'");
	if(!$t)	die("Error quering the Database: " . mysql_error());
	$a = mysql_fetch_object($t);
	if ( $a->cnt > 0 ){
		$dlt_stmt = "DELETE FROM rockinus.rocker_rel_info WHERE sender='$uname' and recipient='$uid'";
		$dlt_stmt_hist = "DELETE FROM rockinus.rocker_rel_history WHERE sender='$uname' and recipient='$uid'";
	}
	
	$t = mysql_query("SELECT count(*) as cnt FROM rockinus.rocker_rel_info WHERE sender='$uid' AND recipient='$uname'");
	if(!$t)	die("Error quering the Database: " . mysql_error());
	$b = mysql_fetch_object($t); 
	if ( $b->cnt > 0 ){
		$dlt_stmt = "DELETE FROM rockinus.rocker_rel_info WHERE sender='$uid' and recipient='$uname'";
		$dlt_stmt_hist = "DELETE FROM rockinus.rocker_rel_history WHERE sender='$uid' and recipient='$uname'";
	}

	$dlt = mysql_query($dlt_stmt);
	if(!$dlt) die(mysql_error());

	$dlt_hist = mysql_query($dlt_stmt_hist);
	if(!$dlt_hist) die(mysql_error());

	$_SESSION['rst_msg']="<div align='center' style='padding-top:10; padding-bottom:10; margin-top:10; color:#336633'><font size=3><strong><img src=img/addsuccessIcon_F5.jpg width=20>&nbsp;&nbsp; The user ".$uid." is no longer your friend.</strong><br><br><a href=$pageName class=one>Go Back</a></font></div>"; 
	//header("location:HouseFleaResult.php");
}else{
	if(isset($_GET['uid']) && isset($_GET['pageName'])){
		$uid = $_GET['uid'];
		$pageName = $_GET['pageName'];
		if(trim($pageName)=="RockerDetail")$pageName="RockerDetail.php?uid=$uid";
		else $pageName .= ".php";
	
		$q1 = mysql_query("SELECT * FROM rockinus.user_info a JOIN rockinus.user_check_info b WHERE a.uname='$uid' AND a.uname=b.uname");
		if(!$q1) die(mysql_error());
		$object = mysql_fetch_object($q1);
		$sstatus = $object->sstatus;
		$email = $object->email;	
		$fname = $object->fname;	
		$lname = $object->lname;	
		$gender = $object->gender;
		if($gender=="Male")$gender_name = "He";
		if($gender=="Female")$gender_name = "She";
		
		$q_uid = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$uid'");
if(!$q_uid) die(mysql_error());
$object_uid = mysql_fetch_object($q_uid);
$uid_fname = $object_uid->fname;
$uid_lname = $object_uid->lname;
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
<div align="center">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="300" align="left" valign="top" style="border-right: 1px dashed #DDDDDD;">
	  <?php include("leftHomeMenu.php"); ?>
      </td>
      <td width="760" align="right" valign="top">
	  <?php include("HeaderEN.php"); ?>
	  <div style="padding: 20; width:680; border:#DDDDDD solid 8; background-color:#F5F5F5; margin-top:10; margin-bottom:20; vertical-align:top" align="left">
	  <?php if(isset($_SESSION['rst_msg'])){
	  			echo($_SESSION['rst_msg']);
				unset($_SESSION['rst_msg']);
			}else{ 
		?>	
	  <form method="post" action="FriendConfirm.php">
      <input type="hidden" name="uid" value="<?php echo($uid) ?>" />
      <input type="hidden" name="pageName" value="<?php echo($pageName) ?>" />
	  <font style="font-size:20px">
	  <?php 
	  		echo("You confirm that you will remove this friend?");  
	  ?>
	  </font><br /><hr size="2" style="margin-top:15" /><br />
	  <font style="font-size:14px; color:<?php echo($_SESSION['hcolor']) ?>"><strong><?php echo($uid) ?></strong> (<?php echo($uid_fname." ".$uid_lname) ?>)</font>
	  <p style="margin-top:15" />
	  <div style="line-height:150%; font-size:12px"><?php echo("$gender_name's currently a ".nl2br($sstatus)) ?></div>
	  <p style="margin-top:20" />
	  <div style=" padding-top:5; font-size:14px">
	  <input type="submit" name="deleteFriend" value="Delete" style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:1px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif"> &nbsp;
	  <input type="button" value=" No, go back " style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:1px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif" ONCLICK="window.location.href='<?php echo($pageName) ?>'">
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
