<?php
include 'dbconnect.php';
$q_uname = mysql_query("SELECT uname FROM rockinus.user_check_info WHERE status='A';");
if(!$q_uname) die(mysql_error());
while($object = mysql_fetch_object($q_uname)){
	$uname = $object->uname;
	$upd = mysql_query("INSERT INTO rockinus.user_email_setting (uname,features,frequest,message,ccomment,fcourse,fsupdate,eventnews,house,article,roommate) VALUES('$uname','Y','Y','N','Y','N','Y','N','N','N','N')");
	if(!$upd) die(mysql_error());
}
echo("Insertion Successful.");
?>