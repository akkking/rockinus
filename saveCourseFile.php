<?php 
session_start(); 
$uname = $_SESSION['usrname'];
include 'dbconnect.php';

$file_id = $_POST["file_id"];
$sender = $_POST["sender"];
$dstatus = $_POST["dstatus"];

$upd = mysql_query("UPDATE rockinus.user_file_info SET dstatus='$dstatus' WHERE owner='$sender' AND file_id='$file_id'");
if(!$upd) die(mysql_error());

echo("<img src=img/addsuccessIcon_F5.jpg width=12 />&nbsp;&nbsp;Successfully updated :)");

mysql_close($link);
?>