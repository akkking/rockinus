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
 		$_SESSION['rst_msg'] = "<div style='width:1004; background:#F5F5F5; border:1 #EEEEEE solid; height:25; font-size:16px; margin-bottom:15' align=left>&nbsp;&nbsp;<img src=img/error_new.jpg width=15 />&nbsp;&nbsp;Error, status not deleted, please contact admin</div>";
	}else{
	 	$_SESSION['rst_msg'] = "<div style='width:1004; background:#F5F5F5; border:1 #EEEEEE solid; height:25; font-size:16px; margin-bottom:15' align=left>&nbsp;&nbsp;<img src=img/addsuccessIcon_F5.jpg width=15 />&nbsp;&nbsp;Status was deleted successfully</div>";
	}
}
	
header("location:RockerDetail.php?uid=$uname");
?>
              