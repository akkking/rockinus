<?php
include 'dbconnect.php';
session_start();
 
if(isset($_POST['ownformSubmit']) && isset($_SESSION['usrname']))
{
 	$descrip=addslashes($_POST['contentforown']);
 	$uname = $_SESSION['usrname'];
	$ok = 1;
	
	if(!isset($_POST['contentforown'])||trim(addslashes($_POST['contentforown']))==NULL){
		//$pagename = "PostRental.php";
		$ok = 0;
		$tmp_rst_msg = "Sorry, please make sure you have written something ...";
	}
	
	if($ok==1){
		$del = mysql_query("INSERT INTO rockinus.memo_info(descrip,sender,pdate,ptime,level) VALUES ('$descrip','$uname',CURDATE(), NOW(),'Y');");
 		if(!$del) die("Error quering the Database: " . mysql_error());
		$_SESSION['rst_msg'] = "<div style='width:740; background:#F5F5F5; border:0 #EEEEEE solid; height:30; font-size:16px; margin-bottom:15; padding-top:5;' align=left>&nbsp;&nbsp;<img src=img/addsuccessIcon_F5.jpg width=15 />&nbsp;&nbsp;New Status Posted Successfully</div>";
	}else{
		$_SESSION['rst_msg'] = "<div align='left' style='padding-top:10; padding-bottom:10; width:740; height:20; background-color:#F5F5F5; margin-bottom:10; font-size:16px; color:#B92828'>&nbsp;&nbsp;<img src='img/error_new.jpg' height=15>&nbsp;&nbsp;&nbsp;<strong>".$tmp_rst_msg."</strong></div>"; 
	}
}
header("location:manageStatus.php?uid=$uname");
?>