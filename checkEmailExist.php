<?php
include("emailfuc.php");
include("dbConnector.php");
$connector = new DbConnector();

$email = trim(strtolower($_POST['email']));
$email = mysql_escape_string($email);

if( is_email($email) == 0 ) {
	$num = 1;
}else{
	$query = "SELECT email FROM user_check_info WHERE email = '$email' LIMIT 1";
	$result = $connector->query($query);
	$num = mysql_num_rows($result);
	mysql_close();
}
echo $num;
?>