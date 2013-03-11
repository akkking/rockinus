<?php
	session_start(); 
	if(!isset($_SESSION['uname']) || !isset($_SESSION['linkpage'])) 
		header("location:login.php");
?>