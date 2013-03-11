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

$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 13;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
if((!$limit) || (is_numeric($limit) == false)|| ($limit < 13) || ($limit > 50)) 
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
</script><?php				
$sql_stmt = "SELECT news_id,creater,subject,descrip,pdate,ptime,'news_info' AS tbname, category, NULL, NULL, NULL, NULL, NULL 
			FROM rockinus.news_info a WHERE 1<>1 
			UNION
			SELECT course_uid, sender, NULL, descrip, pdate, ptime, 'course_memo_info' AS tbname, rating, NULL, NULL, NULL, NULL, NULL
			FROM rockinus.course_memo_info d   
			ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit";
$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("");
while($object = mysql_fetch_object($q)){
	$id = $object->news_id;
	$subject = $object->subject;
	$subject = str_replace("\\","",nl2br($subject));
	$loopname = $object->creater;		
	$category = $object->category;		
	$descrip = $object->descrip;
	$descrip = str_replace("\\","",$descrip);
	$tbname = $object->tbname;			
	$pdate = $object->pdate;
	$ptime = $object->ptime;
//	$col_1 = $object->col_1;
	if(strlen($subject)>60) $subject = substr(trim($subject), 0, 60)."...";
	if($tbname=="news_info_"){
?>
<?php
	}else if($tbname=="house_info"){
?>
<table width="330" height="33" style=" font-family:Geneva, Arial, Helvetica, sans-serif; background:#FFFFFF; margin-bottom:; border-bottom:0 #DDDDDD solid" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="25" style="color:#000000; padding-right:10; padding-left:5; padding-top:7; line-height:150%; font-size:14px" valign='top' align='left'><img src="img/smallHouseIcon.jpg" width="18" /></td>
    <td width="690" style="color:#000000; padding-left:5; padding-top:5; line-height:150%; border-bottom:1px dashed #DDDDDD; padding-bottom:5; font-size:14px" valign='top'>
	<a href="HouseDetail.php?hid=<?php echo($id) ?>" class="one"><font color="<?php echo($_SESSION['hcolor'])?>"><strong><?php echo($subject) ?></strong></font></a>&nbsp;<font style="font-size:12px; color:#999999">(Posted@<?php echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?>)</font>	</td>
  </tr>
  <tr>
    <td style="color:#000000; padding-right:10; padding-left:5; padding-top:7; line-height:150%; font-size:14px" valign='top' align='left'>&nbsp;</td>
    <td style="color:#000000; padding-left:5; padding-top:5; line-height:150%; border-bottom:1px dashed #DDDDDD; padding-bottom:5; font-size:14px" valign='top'><?php echo($subject) ?></td>
  </tr>
</table>

<?php }else if($tbname=="article_info_"){
?>
<table width="330" height="33" style=" font-family:Geneva, Arial, Helvetica, sans-serif; background:#FFFFFF; margin-bottom:; border-bottom:0 #DDDDDD solid" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="35" style="color:#000000; padding-right:10; padding-left:5; padding-top:7; line-height:150%; font-size:14px" valign='top' align='left'><img src="img/smallCartIcon.jpg" width="20" /></td>
    <td width="295" style="color:#000000; padding-left:5; padding-top:5; line-height:150%; border-bottom:1px dashed #DDDDDD; padding-bottom:5; font-size:14px" valign='top'>
	<a href="ArticleDetail.php?aid=<?php echo($id) ?>" class="one"><font color="<?php echo($_SESSION['hcolor'])?>"><strong><?php echo($subject) ?></strong></font></a>&nbsp;<font style="font-size:12px; color:#999999">(Posted@<?php echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?>)</font>	</td>
  </tr>
  <tr>
    <td style="color:#000000; padding-right:10; padding-left:5; padding-top:7; line-height:150%; font-size:14px" valign='top' align='left'>&nbsp;</td>
    <td style="color:#000000; padding-left:5; padding-top:5; line-height:150%; border-bottom:1px dashed #DDDDDD; padding-bottom:5; font-size:14px" valign='top'><?php echo($subject) ?></td>
  </tr>
</table>

<?php }
}
?>
