<?php session_start(); 
	if(!isset($_SESSION['usrname'])) 
		header("location:index.php");
	else
		$uname = $_SESSION['usrname'];
?>