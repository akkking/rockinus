<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Mysql process</title>
</head>
<body>
<?php
include 'dbconnect.php'; 
session_start(); 
$sender = $_SESSION['usrname']; 
$sid = $_POST['sid'];
$rating = $_POST['rating'];
$pagename = $_POST['pagename'];
$memoid = 1;
$descrip = addslashes($_POST['description']);
$qsql = "SELECT * FROM rockinus.school_memo_info";
$qresult = mysql_query($qsql);
while($row = mysql_fetch_array($qresult)){
	$c_memoid = $row['memoid'];
	if($memoid < $c_memoid)$memoid = $c_memoid;
	$memoid += 1;
}

$sql = "INSERT INTO rockinus.school_memo_info (memoid,sid,rating,descrip,sender,pdate,ptime) VALUES('$memoid','$sid','$rating','$descrip','$sender',CURDATE(), NOW())";
$result = mysql_query($sql);
if (!$result) {
   	die('Invalid query: ' . mysql_error());
}

$_SESSION['rst_msg']="<strong><font color=red>Posted!</font></strong>"; 
header("location:$pagename");
mysql_close($link);
?> <br>
</body>
</html>