<?php
session_start(); 
$uname = $_SESSION['usrname']; 
include 'dbconnect.php';

$sql_stmt = NULL;
$sid = $_POST['sid'];
$mid = $_POST['mid'];
$mtype = $_POST['mtype'];
$course_uid = $_POST['course_uid'];
$pagename = "MajorDetail.php?sid=$sid&&mid=$mid&&mtype=$mtype";
//$_SESSION['rst_msg']="$sid,$mid,$pid,$coidname";

$del_rst = mysql_query("DELETE FROM rockinus.user_course_info WHERE uname='$uname' AND course_uid in (SELECT course_uid FROM rockinus.unique_course_info WHERE course_id in (SELECT course_id FROM rockinus.course_info WHERE mid='$mid'))");
if(!$del_rst) die(mysql_error());

if(empty($course_uid)){
	$_SESSION['rst_msg']="<div align='left' style='width:725; padding-top:5; padding-bottom:5; color:#B92828; font-size:14px; background:#F5F5F5; margin-bottom:10; margin-top:10'><strong>&nbsp;&nbsp;No course is selected!</strong></div>";
}else{
	$N = count($course_uid);
	$qsql = "SELECT * FROM rockinus.unique_course_info;";
	$qresult = mysql_query($qsql);
	while($row = mysql_fetch_array($qresult)){
		$loop_course_uid = $row['course_uid'];
		for($i=0;$i<$N;$i++){
			if( $loop_course_uid==$course_uid[$i] ){ 
			$sql_stmt = "INSERT INTO rockinus.user_course_info (uname, course_uid, pdate, ptime) VALUES('$uname','$loop_course_uid', CURDATE(), NOW());"; 
				$result = mysql_query($sql_stmt);
				if (!$result)
					die('Invalid query: ' . mysql_error());
			}
		}
		
	}
}

//$_SESSION['rst_msg']="<div align='center' style='padding-top:10; padding-bottom:10; margin-top:10; color:#336633'><strong>Your have $N course(s) selected successfully!</strong><br></div>"; 

header("location:$pagename");
mysql_close($link);
?> <br>
</body>
</html>
