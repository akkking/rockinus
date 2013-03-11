<?php
session_start(); 
$uname = $_SESSION['usrname'];
include 'dbconnect.php';
include 'Allfuc.php';

$del = mysql_query("Delete FROM rockinus.user_info WHERE uname='$uname'");
if(!$del) die(mysql_error());

$del = mysql_query("Delete FROM rockinus.user_check_info WHERE uname='$uname'");
if(!$del) die(mysql_error());

$del = mysql_query("Delete FROM rockinus.user_contact_info WHERE uname='$uname'");
if(!$del) die(mysql_error());

$del = mysql_query("Delete FROM rockinus.user_edu_info WHERE uname='$uname'");
if(!$del) die(mysql_error());

$del = mysql_query("Delete FROM rockinus.user_hobby_info WHERE uname='$uname'");
if(!$del) die(mysql_error());

$del = mysql_query("Delete FROM rockinus.user_setting WHERE uname='$uname'");
if(!$del) die(mysql_error());

$target = "upload/".$uname;
if(file_exists($target))
deleteDir($target);

include 'logoff.php';
session_start(); 
$_SESSION['rst_msg']="<div align='center' style='width=300; padding-top:10; padding-bottom:10; margin-top:10'><strong>You have quitted Rockinus successfully.</strong><br></div>"; 
?>