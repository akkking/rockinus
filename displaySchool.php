<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Display</title>
</head>
<?php
include 'dbconnect.php'; 
$uid = 0;
$school = $_POST['school']; 
if($school=='all')$qsql = "SELECT * FROM rockinus.school_info";
else $qsql = "SELECT * FROM rockinus.school_info where sid=$school";
$qresult = mysql_query($qsql);
while($row = mysql_fetch_array($qresult)){
	
//	echo "<br />";
}
?>
<body>
</body>
</html>
