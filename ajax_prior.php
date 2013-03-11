<?php

	include ("dbconnect.php");

	// CLIENT INFORMATION
	$uname = htmlspecialchars(trim($_POST['uname']));
	$prior = htmlspecialchars(trim($_POST['prior']));
	$k = substr($prior,0,1);
	$j = substr($prior,1,1);
	
	$sel_Prior = "SELECT * FROM rockinus.user_setting WHERE uname='$uname'";
	$q = mysql_query($sel_Prior) or die(mysql_error());
	$obj = mysql_fetch_object($q);
	$db_prior = $obj->priority;
	
	if( $prior=="D" ){
		$setPrior  = "UPDATE rockinus.user_setting SET priority = 'D' WHERE uname='$uname'";
    	mysql_query($setPrior) or die(mysql_error());	
	}else if( strpos($db_prior,$k)!=NULL || strpos($db_prior,$j)!=NULL || strlen($db_prior)>=10 || $db_prior=="D" ){
		$setPrior  = "UPDATE rockinus.user_setting SET priority = '$prior' WHERE uname='$uname'";
    	mysql_query($setPrior) or die(mysql_error());	
	}else{
		$setPrior  = "UPDATE rockinus.user_setting SET priority = concat(priority,'$prior') WHERE uname='$uname'";
    	mysql_query($setPrior) or die(mysql_error());	
	}
?>