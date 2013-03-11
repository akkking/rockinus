<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Mysql process</title>
</head>

<body>
<?php
include 'dbconnect.php'; 

$result = mysql_query('SELECT * from rockinus.user_info WHERE 1=1');
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
while ($row = mysql_fetch_assoc($result)) {
    echo $row['uid'];
    echo $row['uname'];
}

$usrname = $_POST['usrname']; 
$pswd = $_POST['pswd']; 
echo "Your rocker name is:  ". $usrname . " . and password is ".$pswd . ".<br />"; 
echo "Thank you for join Rockinus!<br />"; 
?> 
<a href="rockinus.php">Back Home</a>

mysql_close($link);
?> 
</body>
</html>
