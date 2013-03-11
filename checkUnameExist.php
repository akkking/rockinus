<?php 
include 'emailfuc.php';
include("dbConnector.php");
$connector = new DbConnector();

$num = 0;
$username = trim(strtolower($_POST['username']));
$username = mysql_escape_string($username);

if(is_numeric(substr($username,0,1)))
	$num=1;
else if(!preg_match('/^[a-zA-Z0-9_]{5,}$/', $username)) { 
	// for english chars + numbers only 
    // valid username, alphanumeric & longer than or equals 5 chars 
	$num=1;
}else{
	$query = "SELECT uname FROM user_info WHERE uname = '$username' LIMIT 1";
	$result = $connector->query($query);
	$num = mysql_num_rows($result);
}

echo $num;
mysql_close();
?>