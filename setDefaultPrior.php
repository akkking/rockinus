<?php
	session_start();
	include 'dbconnect.php';
	$uname = $_SESSION['usrname'];
	$setPrior  = "UPDATE rockinus.user_setting SET priority = 'D' WHERE uname='$uname'";
   	mysql_query($setPrior) or die(mysql_error());	
	header("location:UserSetting.php");
?>