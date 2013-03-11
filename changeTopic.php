<?php

	include ("dbconnect.php");

	// CLIENT INFORMATION
	$uname        = htmlspecialchars(trim($_POST['uname']));
	$topi       = htmlspecialchars(trim($_POST['topi']));

    $setTopic  = "UPDATE rockinus.user_setting SET topi='$topi' WHERE uname='$uname'";
    mysql_query($setTopic) or die(mysql_error());
?>