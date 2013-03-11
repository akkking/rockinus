<?php
include 'dbconnect.php';
$q_uname = mysql_query("SELECT uname FROM rockinus.user_check_info WHERE status='A';");
if(!$q_uname) die(mysql_error());
while($object = mysql_fetch_object($q_uname)){
	$uname = $object->uname;
	$upd = mysql_query("INSERT INTO rockinus.user_basic_setting (uname,whoVisit,directPage) VALUES('$uname','A','H')");
	if(!$upd) die(mysql_error());
}
echo("Insertion Successful.");
?>