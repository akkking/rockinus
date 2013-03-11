<?php
include 'dbconnect.php';
include 'Allfuc.php';
session_start();
$uname = $_SESSION['usrname'];
 
if(isset($_POST['content'])){
	$descrip=addslashes($_POST['content']);
	$sender=$_POST['sender'];
	$pdate=$_POST['pdate'];
	$ptime=$_POST['ptime'];

	$del = mysql_query("INSERT INTO rockinus.memo_info(descrip,sender,pdate,ptime,level) VALUES ('$descrip','$uname',CURDATE(), NOW(),'Y');"); 
	echo("<div style='font-size:13px; font-family: Arial, Helvetica, sans-serif; line-height:150%; background:#F5F5F5; padding:10; width:450; margin-top:15'>".addHyperLink(nl2br($descrip))."</font><br><font color=#999999>".getDateName($pdate)." | ".$ptime." | </font><font color=$_SESSION[hcolor] style='font-size:12px'>$sender</font></a></div>");	
}?>