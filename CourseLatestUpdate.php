
<table width="740" height="30" border="0" cellpadding="0" cellspacing="0" bgcolor="" style=" border-bottom:1px solid #999999; background:url(img/<?php echo(substr($_SESSION['hcolor'],1,6)."_MenuBar.jpg") ?>); margin-bottom:1">
  <tr>
    <td width="520" align="left" style="padding-left:10; font-size:12px; font-weight:bold; color:#FFFFFF; font-family:Arial, Helvetica, sans-serif"> ::&nbsp; 
	<?php if($cmajor==NULL || strlen(trim($cmajor))==0)
			echo("Comments on All courses"); 
		else
			echo("Recent Comments @$cmajor_name"); 
		?></td>
    <td width="220" align="right" style="padding-right:10; font-size:13px; font-family: Arial, Helvetica, sans-serif; font-weight:bold;">&nbsp;<?php
	include "dbconnect.php";
//include "Allfuc.php";
//header("Content-Type: text/html; charset=gb2312");
//mysql_query("SET NAMES GBK");
//mysql_query("SET NAMES UTF8");
$page_name = "SchoolCourse.php";

include 'dbconnect.php';
 
if($cmajor==NULL || strlen(trim($cmajor))==0){
$q = "SELECT count(*) FROM rockinus.course_memo_info";
}else
$q = "SELECT count(*) FROM rockinus.course_memo_info WHERE 
			course_uid IN (SELECT course_uid FROM rockinus.unique_course_info WHERE 
			course_id IN (SELECT course_id FROM rockinus.course_info WHERE mid='$cmajor'))";
			
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 25;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
if((!$limit) || (is_numeric($limit) == false)|| ($limit < 25) || ($limit > 50)) {
	$limit = 1; //default
}
 
if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items)) { 
	$page = 1; //default 
}
 
//calculate total pages
$total_pages = ceil($total_items / $limit);
$set_limit = ($page * $limit) - $limit;
//echo "Total Pages: $total_pages <br/>";
if ($total_items != 0 )echo "<font color=black>$total_items in all</font> ";
//prev. page
$prev_page = $page - 1;
if($prev_page >= 1) { 
	echo("<a class='one' href=$page_name?limit=$limit&page=$prev_page class=one>Previous</a>");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo(" <strong><font color=black>$a</font></strong> "); //no link
}else{ 
	echo("<a class='one' href=$page_name?limit=$limit&page=$a class=one> <strong>$a</strong></a>   ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo(" <a class='one' href=$page_name?limit=$limit&page=$next_page class=one>Next</a>");
}
if ($total_items != 0 )echo "";
?>	</td>
  </tr>
</table>
<?php
if($cmajor==NULL || strlen(trim($cmajor))==0){
$sql_stmt = "SELECT course_uid, sender, NULL, descrip, pdate, ptime, 'course_memo_info' AS tbname, rating, NULL, NULL, NULL, NULL, NULL
			FROM rockinus.course_memo_info
			ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit";
}else
$sql_stmt = "SELECT course_uid, sender, NULL, descrip, pdate, ptime, 'course_memo_info' AS tbname, rating, NULL, NULL, NULL, NULL, NULL
			FROM rockinus.course_memo_info WHERE course_uid IN (SELECT course_uid FROM rockinus.unique_course_info WHERE course_id IN (SELECT course_id FROM rockinus.course_info WHERE mid='$cmajor'))
			ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit";
mysql_query("SET NAMES GBK");

$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("<div style='width:740; background:#F5F5F5; padding-top:50; height:180; font-size:18px' align='center'>What a pity, $uname!<br><br> There is no comment on any course in your major...<br><br><a href='MajorDetail.php?sid=NYPOLY&&mtype=Master&&mid=$cmajor' class=one><font color=$_SESSION[hcolor]><strong>Go and comment some!</strong></font></a></div>");
while($object = mysql_fetch_object($q)){
	$id = $object->course_uid;
	$subject = $object->NULL;
	$loopname = $object->sender;		
	$descrip = $object->descrip;
	$descrip = str_replace("\\","",$descrip);
	$tbname = $object->tbname;			
	$pdate = $object->pdate;
	$ptime = $object->ptime;
//	$col_1 = $object->col_1;
	//if(strlen($subject)>50) $subject = substr(trim($subject), 0, 50)."...";
	 
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
<table width="740" height="30" style=" font-family:Geneva, Arial, Helvetica, sans-serif; background:#FFFFFF; margin-top:0; border-bottom:1px #DDDDDD dashed; border-left:1px solid #DDDDDD; border-right:1px solid #DDDDDD" border="0" cellspacing="0" cellpadding="0" onmouseover="this.style.backgroundColor='#F5F5F5';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
  <tr>
    <td width="20" style="color:#000000; padding-right:10; padding-left:13; padding-top:10; line-height:150%; font-size:14px" valign='top' align='left'><img src="img/courseAjaxIcon.jpg" width="12" height="12" /></td>
    <td width="710" style="color:<?php echo($_SESSION['hcolor']) ?>; padding-right:15; padding-top:8; line-height:150%; border-bottom:0px dotted #DDDDDD; padding-bottom:5; font-size:11px" valign='top' align="left">
	<font style="font-size:12px; color:"><?php echo($course_name." | ".$major_name) ?> | <?php echo(getDateName($pdate).", ".substr($ptime,0,5)) ?></font>&nbsp;<br />
	<a href="CourseDetail.php?course_uid=<?php echo($id) ?>" class="one"><font color="#666666"><?php echo($descrip) ?></font></a>
	</td>
  </tr>
</table>
<?php 
	}
}
?>