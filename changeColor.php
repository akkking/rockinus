<?php
	session_start();
	$uname = trim($_SESSION['usrname']);
	$hcolor = trim($_GET['hcolor']);
	$hcolor = "#".$hcolor;

	include ("dbconnect.php");

	// CLIENT INFORMATION
//	echo("UPDATE rockinus.user_setting SET hcolor='$hcolor' WHERE uname='$uname'");
    $setColor  = "UPDATE rockinus.user_setting SET hcolor='$hcolor' WHERE uname='$uname'";
    mysql_query($setColor) or die(mysql_error());
	header("location:ThingsRock.php");
?>