<?php
include 'dbconnect.php'; 
session_start(); 
$uid = $_SESSION['usrname']; 
$memofid = $_POST['memofid'];
$sql = "DELETE FROM rockinus.memo_follow_info WHERE memofid='$memofid'";
$result = mysql_query($sql);
if (!$result) die('Invalid query: ' . mysql_error());
mysql_close($link);
?>