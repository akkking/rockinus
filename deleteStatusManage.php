<?php
include 'dbconnect.php';
include 'Allfuc.php';
session_start();
 
if(isset($_GET['memoid'])&&isset($_SESSION['usrname']))
{
 	$memoid = $_GET['memoid'];
	$uname = $_SESSION['usrname'];
 	$q_delete = mysql_query("DELETE FROM rockinus.memo_info WHERE memoid='$memoid';");
	if(!$q_delete){
		$output = mysql_error();
 		$_SESSION['rst_msg'] = "<div style='width:740; background:#F5F5F5; border:0 #EEEEEE solid; height:30; padding-top:5; font-size:16px; margin-bottom:15' align=left>&nbsp;&nbsp;<img src=img/error_new.jpg width=15 />&nbsp;&nbsp;Error, status not deleted, please contact admin</div>";
	}else{
		$q_follow_delete = mysql_query("DELETE FROM rockinus.memo_follow_info WHERE memoid='$memoid';");
	 	if(!$q_follow_delete) die(mysql_error());
		$_SESSION['rst_msg'] = "<div style='width:740; background:#F5F5F5; border:0 #EEEEEE solid; height:30; padding-top:5; font-size:14px; font-weight:bold; margin-bottom:15' align=left>&nbsp;&nbsp;<img src=img/addsuccessIcon_F5.jpg width=15 />&nbsp;&nbsp;Status was deleted successfully</div>";
	}
}
	
header("location:UpdateWall.php");
?>