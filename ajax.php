<?php

	include ("dbconnect.php");

	// CLIENT INFORMATION
	$uname        = htmlspecialchars(trim($_POST['uname']));
	$hcolor       = htmlspecialchars(trim($_POST['hcolor']));

    $setColor  = "UPDATE rockinus.user_setting SET hcolor='$hcolor' WHERE uname='$uname'";
    mysql_query($setColor) or die(mysql_error());
?>