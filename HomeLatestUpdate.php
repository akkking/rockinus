<?php
include "dbconnect.php";
//include "Allfuc.php";
//header("Content-Type: text/html; charset=gb2312");
mysql_query("SET NAMES UTF8");

$sel_count = "
SELECT sum(total) as cnt FROM (
	SELECT count(*) as total FROM rockinus.course_memo_info 
	UNION 
	SELECT count(*) as total FROM rockinus.user_course_info
) as cnt";

$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 8;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
if((!$limit) || (is_numeric($limit) == false)|| ($limit < 8) || ($limit > 50)) 
	$limit = 1; //default

if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
	$page = 1; //default 

$next_page = $page + 1;
$div_id = "myDiv".$page;
$total_pages = ceil($total_items / $limit);
$set_limit = ($page * $limit) - $limit;
?>
<script>
$(document).ready(function() {  
	$("#houseDiv").hide();
	$("#saleDiv").hide();
	$("#roommateDiv").hide();
	$("#questionDiv").hide();
	$("#eventDiv").hide();  
	$("#backPostDiv").hide();  
	//$("#dailyUpdate").show();

	$("div .newPostDiv").click(function () {
      //$("#joinUsDiv").hide("slide", { direction: "up" }, 1000);
	  $("#newPostDiv").hide();
	  $("#houseDiv").show();
	  $("#saleDiv").show();
	  $("#roommateDiv").show();
	  $("#questionDiv").show();
	  $("#backPostDiv").show();
	  //$("#joinUsDiv").show("slide", { direction: "up" }, 500);
	});

	$("div .backPostDiv").click(function () {
      //$("#joinUsDiv").hide("slide", { direction: "up" }, 1000);
	  $("#houseDiv").hide();
	  $("#saleDiv").hide();
	  $("#roommateDiv").hide();
	  $("#questionDiv").hide();
	  $("#backPostDiv").hide();
	  $("#newPostDiv").show();
	  //$("#joinUsDiv").show("slide", { direction: "up" }, 500);
	});
});
</script> 
<table width="320" height="30" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; padding-left:10; padding-top:; border-top:1px solid #DDDDDD; border-bottom:1px solid #999999; background: url(img/master.jpg); color:#FFFFFF">
  <tr>
    <td width="240" style="padding-left:0; font-size:13px; font-family: Arial, Helvetica, sans-serif; font-weight:bold; border-bottom:0px solid #CCCCCC" align="left">
	<a href="SchoolCourse.php" class="one" style="color:<?php echo($_SESSION['hcolor']) ?>">Course Comments</a></td>
    <td width="90" style="padding-right:15; font-size:12px; font-family: Arial, Helvetica, sans-serif; font-weight:normal; border-bottom:0px solid #CCCCCC" align="right"><strong>&middot;</strong> <a href="SchoolCourse.php" class="one"><font color="">More</font></a></td>
  </tr>
</table>
<?php
$q_edu = mysql_query("SELECT * FROM rockinus.user_edu_info WHERE uname='$uname';");
if(!$q_edu) die(mysql_error());
$user_edu_row = mysql_num_rows($q_edu);
$object_edu = mysql_fetch_object($q_edu);
$cmajor = $object_edu->cmajor;
$course_no_row = $limit;
$sql_stmt_2 = NULL;

if($cmajor==NULL || strlen(trim($cmajor))==0){
$sql_stmt = "SELECT course_uid, sender, NULL AS col_1, descrip, pdate, ptime, 'course_memo_info' AS tbname, rating, NULL, NULL, NULL, NULL, NULL
			FROM rockinus.course_memo_info
			ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit";
}else{
$sql_stmt = "SELECT course_uid, sender, NULL AS col_1, descrip, pdate, ptime, 'course_memo_info' AS tbname, rating, NULL, NULL, NULL, NULL, NULL
			FROM rockinus.course_memo_info WHERE course_uid IN (SELECT course_uid FROM rockinus.unique_course_info WHERE course_id IN (SELECT course_id FROM rockinus.course_info WHERE mid='$cmajor'))
			ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit";
	//mysql_query("SET NAMES GBK");
	$q = mysql_query($sql_stmt);
	if(!$q) die(mysql_error());
	$course_no_row = mysql_num_rows($q);
	if($course_no_row < $limit){
		$left_course_no_row = $limit - $course_no_row;
		$sql_stmt = "SELECT course_uid, sender, NULL AS col_1, descrip, pdate, ptime, 'course_memo_info' AS tbname, rating, NULL, NULL, NULL, NULL, NULL
			FROM rockinus.course_memo_info WHERE course_uid IN (SELECT course_uid FROM rockinus.unique_course_info WHERE course_id IN (SELECT course_id FROM rockinus.course_info WHERE mid='$cmajor'))
			ORDER BY pdate DESC, ptime DESC LIMIT 0, $course_no_row";
		$sql_stmt_2 = "SELECT course_uid, sender, NULL AS col_1, descrip, pdate, ptime, 'course_memo_info' AS tbname, rating, NULL, NULL, NULL, NULL, NULL
			FROM rockinus.course_memo_info WHERE course_uid IN (SELECT course_uid FROM rockinus.unique_course_info WHERE course_id IN (SELECT course_id FROM rockinus.course_info WHERE mid<>'$cmajor'))
			ORDER BY pdate DESC, ptime DESC LIMIT 0, $left_course_no_row";
	}
} 

$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("");
while($object = mysql_fetch_object($q)){
	$id = $object->course_uid;
	$subject = $object->col_1;
	$subject = str_replace("\\","",nl2br($subject));
	$loopname = $object->sender;		
	$category = $object->category;		
	$descrip = $object->descrip;
	$descrip = str_replace("\\","",$descrip);
	$tbname = $object->tbname;			
	$pdate = $object->pdate;
	$ptime = $object->ptime;
//	$col_1 = $object->col_1;
	//if(strlen($subject)>65) $subject = substr(trim($subject), 0, 60)."...";
	$subject = cnSubstr(trim($subject), 40, "...");
	if($tbname=="course_memo_info"){
		$memo_q = mysql_query("SELECT course_id, mid, course_name FROM rockinus.course_info WHERE course_id=(SELECT course_id FROM rockinus.unique_course_info WHERE course_uid ='$id');");
		if(!$memo_q) die(mysql_error());
		$obj = mysql_fetch_object($memo_q); 
		$course_id = $obj->course_id; 
		$mid = $obj->mid;
		$course_name = $obj->course_name;
			  
		$mid_sql = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid='$mid';");
		if(!$mid_sql) die(mysql_error());
		$obj_m = mysql_fetch_object($mid_sql); 
		$major_name = $obj_m->major_name; 
?>
<table width="320" height="33" style=" border-bottom:1px dashed #DDDDDD; font-family:Geneva, Arial, Helvetica, sans-serif; background:#FFFFFF; margin-bottom:;" border="0" cellspacing="0" cellpadding="0" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
  <tr>
    <td width="35" rowspan="2" align='left' valign='top' style="color:#000000; padding-left:10; padding-top:15; line-height:150%; font-size:14px"><img src="img/smallCommentIcon.jpg" width="18" /></td>
    <td width="295" height="30" valign='bottom'  align="left" style="color:#000000; padding-left:5; padding-top:5; padding-bottom:5; line-height:150%; border-bottom:0 dashed #EEEEEE; padding-bottom:0; font-size:12px">
	<?php echo("<span style='color:$_SESSION[hcolor]; font-size:12px; font-weight:bold'><a href=CourseDetail.php?course_uid=$id class=one><font style='font-size:12px; color:$_SESSION[hcolor]; font-weight:bold'>$course_name</font></a></span> "); ?>	</td>
  </tr>
  <tr>
    <td width="295" align="left" valign='top' style="color:#000000; padding-left:5; padding-top:0; padding-bottom:5; line-height:150%; border-bottom:0px dashed #DDDDDD; font-size:12px"><?php echo("<span style='color:#999999; font-size:11px'>(<a href=MajorDetail.php?sid=NYPOLY&&mtype=Master&&mid=$mid class=one><font style='font-size:11px; color:#333333'>".trim($major_name)."</font></a>, <font style='font-size:11px; color:#333333'>".getNoDateName($pdate).")</font></span>")?></td>
  </tr>
  <tr>
    <td width="35" align='left' valign='top' style="color:#000000; padding-right:10; padding-left:5; padding-top:; line-height:150%; border-bottom:0px solid #DDDDDD; font-size:14px">&nbsp;</td>
    <td width="295" align="left" valign='top' style="color:#999999; padding:5; line-height:150%; border-bottom:0px solid #DDDDDD; padding-top:0; padding-bottom:10; padding-right:30; font-size:12px">
	<?php 
	// if(strlen($descrip)>150)	echo(substr($descrip,0,148)."...");
	// else		echo($descrip); 
	// $descrip = cnSubstr(trim($descrip), 0, 200)."...";
	$descrip = cutStr(trim($descrip), 55, "")."...";
	// $descrip = iconv_substr($descrip,0,180, 'gbk');
	echo($descrip);
	?>	</td>
  </tr>
</table>
<?php 
	}
}

if($course_no_row < $limit){
	$q = mysql_query($sql_stmt_2);
	if(!$q) die(mysql_error());
	$no_row = mysql_num_rows($q);
	if($no_row == 0) echo("");
	while($object = mysql_fetch_object($q)){
		$id = $object->course_uid;
		$subject = $object->col_1;
		$subject = str_replace("\\","",nl2br($subject));
		$loopname = $object->sender;		
		$category = $object->category;		
		$descrip = $object->descrip;
		$descrip = str_replace("\\","",$descrip);
		$tbname = $object->tbname;			
		$pdate = $object->pdate;
		$ptime = $object->ptime;
		if(strlen($subject)>65) $subject = substr(trim($subject), 0, 60)."...";
	
		if($tbname=="course_memo_info"){
		$memo_q = mysql_query("SELECT course_id, mid, course_name FROM rockinus.course_info WHERE course_id=(SELECT course_id FROM rockinus.unique_course_info WHERE course_uid ='$id');");
		if(!$memo_q) die(mysql_error());
		$obj = mysql_fetch_object($memo_q); 
		$course_id = $obj->course_id; 
		$mid = $obj->mid;
		$course_name = $obj->course_name;
			  
		$mid_sql = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid='$mid';");
		if(!$mid_sql) die(mysql_error());
		$obj_m = mysql_fetch_object($mid_sql); 
		$major_name = $obj_m->major_name; 
?>
<table width="320" height="33" style=" border-bottom:1px dashed #DDDDDD; font-family:Geneva, Arial, Helvetica, sans-serif; background:#FFFFFF" border="0" cellspacing="0" cellpadding="0" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
  <tr>
    <td width="35" rowspan="2" align='left' valign='top' style="color:#000000; padding-left:10; padding-top:15; line-height:150%; font-size:14px"><img src="img/smallCommentIcon.jpg" width="18" /></td>
    <td width="295" height="30" valign='bottom' style="color:#000000; padding-left:5; padding-top:5; padding-top:5; line-height:150%; border-bottom:0 dashed #EEEEEE; padding-bottom:0; font-size:12px" align="left">
	<?php echo("<span style='color:$_SESSION[hcolor]; font-size:12px; font-weight:bold'><a href=CourseDetail.php?course_uid=$id class=one><font style='font-size:12px; color:$_SESSION[hcolor]; font-weight:bold'>$course_name</font></a></span> "); ?>	</td>
  </tr>
  <tr>
    <td width="295" align="left" valign='top' style="color:#000000; padding:5; padding-top:0; line-height:150%; border-bottom:0px dashed #DDDDDD; font-size:12px"><?php echo("<span style='color:#999999; font-size:11px'>(<a href=MajorDetail.php?sid=NYPOLY&&mtype=Master&&mid=$mid class=one><font style='font-size:11px; color:#333333'>$major_name</font></a>&nbsp; <font style='font-size:11px; color:#333333'>".getNoDateName($pdate).")</font></span>")?></td>
  </tr>
  <tr>
    <td width="35" align='left' valign='top' style="color:#000000; padding-right:10; padding-left:5; padding-top:; line-height:150%; border-bottom:0px solid #DDDDDD; font-size:14px">&nbsp;</td>
    <td width="295" align="left" valign='top' style="color:#999999; padding:5; line-height:150%; border-bottom:0px solid #DDDDDD; padding-top:0; padding-bottom:10; padding-right:30; font-size:12px">
	<?php 
	// if(strlen($descrip)>150)	echo(substr($descrip,0,148)."...");
	// else		echo($descrip); 
	// $descrip = cnSubstr(trim($descrip), 0, 200)."...";
	$descrip = cutStr(trim($descrip), 55, "")."...";
	// $descrip = iconv_substr($descrip,0,180, 'gbk');
	echo($descrip);
	?>	</td>
  </tr>
</table>
<?php 
		}
	}
}
?>