<?php
 	session_start(); 
 	$_SESSION['usrname']=$usrname; 
	header("location:aaa.php");
//	echo "Your rocker name is:  ". $usrname . " . and password is ".$passwd . ".<br />"; 
//	echo "Login Successful!<br />"; 
//  this starts the session 
//  this sets variables in the session 

// 	$_SESSION['size']='small'; 
// 	$_SESSION['shape']='round'; 
// 	print "Done";

//	$previous_name = session_name("usrname");
//	echo($previous_name);
}else{
	echo "Wrong Username or Password.";
	header("location:rockinus_relogin.php");
}
?>