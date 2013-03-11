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
$usrname = "akkking"; 
$to = "barmuya@hotmail.com";
$subject = "Where are you!";
$msg = "I'm done now!";
$headers = "From: rockinus@localhost\r\nReply-To: barmuya@hotmail.com";

// Please specify your Mail Server - Example: mail.yourdomain.com.
ini_set("SMTP","localhost");

// Please specify an SMTP Number 25 and 8889 are valid SMTP Ports.
ini_set("smtp_port","25");

// Please specify the return address to use
ini_set('sendmail_from', 'rockinus@localhost.com');

if(mail("$to", "$subject", "$msg", "$headers")) echo "finished!";
else echo("failed");
//if( mail($email, $subject, $body, $headers, "-f rockinus@localhost")) echo "Successful~~~~~~~~~";
mysql_close($link);
?> <br>
</body>
</html>
