<?php
include "dbconnect.php";
//include "Allfuc.php";
//header("Content-Type: text/html; charset=gb2312");
mysql_query("SET NAMES UTF8");

$sel_count = "
SELECT sum(total) as cnt FROM (
	SELECT count(*) as total FROM rockinus.news_info 
	UNION
	SELECT count(*) as total FROM rockinus.room_mate_info
	UNION 
	SELECT count(*) as total FROM rockinus.book_info
) as cnt";

$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 10;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
if((!$limit) || (is_numeric($limit) == false)|| ($limit < 10) || ($limit > 50)) 
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
<?php				
$sql_stmt = "SELECT news_id,creater,subject,descrip,pdate,ptime,'news_info' AS tbname, category, NULL, NULL, NULL, NULL, NULL 
			FROM rockinus.news_info a 
			UNION
			SELECT rmate_id, uname, has_room, descrip, pdate, ptime, 'room_mate_info' AS tbname, mate_type, NULL,NULL, NULL, NULL, NULL 
			FROM rockinus.room_mate_info d 
			UNION
			SELECT book_id, uname, book_name, descrip, pdate, ptime, 'book_info' AS tbname, mid, NULL,NULL, NULL, NULL, NULL 
			FROM rockinus.book_info e 
			ORDER BY pdate DESC, ptime DESC LIMIT 11, 10";
$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("");
$i=0;
$seq_id = 0;
while($object = mysql_fetch_object($q)){
	$i++;
	$seq_id ++;
	$id = $object->news_id;
	$subject = $object->subject;
	$subject = str_replace("\\","",nl2br($subject));
	$loopname = $object->creater;		
	$category = $object->category;		
	$descrip = nl2br($object->descrip);
	$descrip = str_replace("\\","",$descrip);
	if(strlen($descrip)>350) $descrip = substr(trim($descrip), 0, 350)." ...<br>>> "."<a href='newsList.php' class=one><strong>Check details</strong></a>";
	$tbname = $object->tbname;			
	$pdate = $object->pdate;
	$ptime = $object->ptime;
//	$col_1 = $object->col_1;
	$orig_subject = $subject;
	if(strlen($subject)>38) $subject = substr(trim($subject), 0, 35)."...";
	if($tbname=="news_info"){
?>

<script>
$(document).ready(function() { 
	$("#newsDiv_<?php echo($seq_id) ?>").hide();
//	$("#showNews_<?php echo($seq_id) ?>").show();
	$("#newsTitleDiv_<?php echo($seq_id) ?>").hide();
	
	for(var j=1; j<=<?php echo($seq_id) ?>; j+=10){
		$("#newsTitleDiv_<?php echo($seq_id) ?>").fadeOut("fast").fadeIn(1000); 
	} 
	
	$("div .showNews_<?php echo($seq_id) ?>").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  for(var i=1; i<=10; i++) $("#newsTitleDiv_"+i).hide(); 
	  $("#newsDiv_<?php echo($seq_id) ?>").show(); 
	  //$("#activeCourseDiv_1").hide();
	});

	$("div .hideNews_<?php echo($seq_id) ?>").click(function () {
	  $("#newsDiv_<?php echo($seq_id) ?>").hide();
	  for(var i=1; i<=10; i++) $("#newsTitleDiv_"+i).show(); 
	});
});
</script>
<div class="newsTitleDiv_<?php echo($seq_id) ?>" id="newsTitleDiv_<?php echo($seq_id) ?>" style="width:360; display:">
<table width="360" height="30" style="font-family: Arial, Helvetica, sans-serif; margin-bottom:; background:; border-bottom:0 #DDDDDD solid" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="33" style="color:#000000; padding-right:15;  padding-top:7; line-height:150%; font-size:14px" valign='top' align='right'><img src="img/smallNoticeIcon.jpg" width="18" /></td>
    <td width="262" style="color:#000000; padding-left:0; padding-top:5; line-height:150%; border-bottom:1px solid #EEEEEE; padding-bottom:5; font-size:13px" valign='top' align="left">
	<div class="showNews_<?php echo($seq_id) ?>" id="showNews_<?php echo($seq_id) ?>" style="cursor:pointer; display:inline">
	<font color="<?php if($i<4 && trim($category)!="lostfound")echo($_SESSION['hcolor']);else if(trim($category)=="lostfound")echo("#B92828"); ?>"><?php echo($subject) ?></font>
	</div>
	</td>
    <td width="65" style="color:#000000; padding-right:5; padding-top:5; line-height:150%; border-bottom:1px solid #EEEEEE; padding-bottom:5; font-size:14px" valign='top' align="right"><font style="font-size:12px; color:#999999"><?php echo(getNoDateName($pdate)) ?></font></td>
  </tr>
</table>
</div>
<div class="newsDiv_<?php echo($seq_id) ?>" id="newsDiv_<?php echo($seq_id) ?>" style="display: none; width:360; height:297; background-color:">
<table width="360" height="33" style="font-family: Arial, Helvetica, sans-serif; margin-bottom:; background:; border-bottom:0 #DDDDDD solid" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="33" style="color:#000000; padding-right:15;  padding-top:7; line-height:150%; font-size:14px" valign='top' align='right'><img src="img/smallNoticeIcon.jpg" width="18" /></td>
    <td colspan="2" align="left" valign='top' style="color:#000000; padding-left:0; padding-top:5; line-height:150%; border-bottom:0px solid #EEEEEE; padding-bottom:5; padding-right:10; font-size:14px; font-family:Arial, Helvetica, sans-serif">
	<font color="<?php if($i<4 && trim($category)!="lostfound")echo($_SESSION['hcolor']);else if(trim($category)=="lostfound")echo("#B92828"); ?>"><strong><?php echo($orig_subject) ?></strong></font>
	</td>
    </tr>
  <tr>
    <td height="25" align='right' valign='top' style="color:#000000; padding-right:15;  padding-top:7; line-height:150%; font-size:14px">&nbsp;</td>
    <td width="210" height="25" align="left" valign='top' style="color:#000000; padding-left:0; padding-top:0; line-height:150%; border-bottom:0px solid #EEEEEE; font-size:13px">
	<div style=" display:inline"><font style="font-size:12px; color:#999999"><?php echo(getDateName($pdate)." | $loopname | ") ?><a href="SendMessage.php?recipient=<?php echo($loopname)?>" class="one"><font style="font-size:12px; color:#999999">+ Message</font></a></font>	</div></td>
    <td width="119" height="25" align="right" valign='top' style="color:#000000; padding-right:5; padding-top:5; line-height:150%; border-bottom:0px solid #EEEEEE; font-size:14px">&nbsp;</td>
  </tr>
</table>
<table width="360" height="33" style="font-family: Arial, Helvetica, sans-serif; margin-bottom:; background:; border-bottom:0 #DDDDDD solid" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="32" style="color:#000000; padding-right:15;  padding-top:7; line-height:150%; font-size:14px" valign='top' align='right'>&nbsp;</td>
    <td width="328" align="left" valign='top' style="color:#000000; padding-left:0; padding-top:0; line-height:150%; border-bottom:0px solid #EEEEEE; padding-bottom:5; padding-right:5; font-size:13px">
	<div style="margin-bottom:15; font-family:Arial, Helvetica, sans-serif"><?php echo($descrip) ?></div>
	<div class="hideNews_<?php echo($seq_id) ?>" id="hideNews_<?php echo($seq_id) ?>" style="padding:3 10 3 10; background: url(img/master.png); display:inline; margin-bottom:0; border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:13px; cursor:pointer; color:#000000">Back to the list</div>&nbsp;
	</td>
  </tr>
</table>
</div>
<?php
	}else if($tbname=="book_info"){
?>
<table width="360" height="30" style=" font-family: Arial, Helvetica, sans-serif; background:; margin-bottom:; border-bottom:0 #DDDDDD solid" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="33" style="color:#000000; padding-right:15; padding-top:8; line-height:150%; font-size:14px" valign='top' align='right'><img src="img/smallBookIcon.jpg" width="18" /></td>
    <td width="262" style="color:#000000; padding-left:0; padding-top:5; line-height:150%; border-bottom:1px solid #EEEEEE; padding-bottom:5; font-size:14px" valign='top' align="left">
	<a href="eventDetail.php?eid=<?php echo($id) ?>" class="one"><font color="<?php if($i<4)echo($_SESSION['hcolor']); ?>"><strong><?php echo($subject) ?></strong></font></a></td>
    <td width="65" style="color:#000000; padding-right:5; padding-top:5; line-height:150%; border-bottom:1px solid #EEEEEE; padding-bottom:5; font-size:14px" valign='top' align="right"><font style="font-size:12px; color:#999999"><?php echo(getDateName($pdate)) ?></font></td>
  </tr>
</table>
<?php }else if($tbname=="room_mate_info"){
		if($subject=="Y") $has_room_title = "<font color=#666666>(has Apt.)</font>";
		if($category=="all") $mate_type = "";
		else $mate_type = "<font color=#666666>($category)</font>";
?>
<table width="360" height="30" style=" font-family: Arial, Helvetica, sans-serif; background:; margin-bottom:; border-bottom:0 #DDDDDD solid" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="32" style="color:#000000; padding-right:15; padding-top:8; line-height:150%; font-size:14px" valign='top' align='right'><img src="img/smallManIcon.jpg" width="17" /></td>
    <td width="263" style="color:#000000; padding-left:0; padding-top:5; line-height:150%; border-bottom:1px solid #EEEEEE; padding-bottom:5; font-size:14px" valign='top' align="left">
	<a href="roomMateList.php" class="one"><?php if($i<4)echo("<a href=roomMateList.php class=one><font style='font-weight:bold; color=$_SESSION[hcolor]'>Someone looks for roomate$mate_type</font></a>"); else echo("<a href=roomMateList.php class=one><font style='font-weight:bold'>Someone looks for roomate$mate_type</font></a>") ?></a></td>
    <td width="65" style="color:#000000; padding-right:5; padding-top:5; line-height:150%; border-bottom:1px solid #EEEEEE; padding-bottom:5; font-size:14px" valign='top' align="right"><font style="font-size:12px; color:#999999"> <?php echo(getNoDateName($pdate)) ?></font></td>
  </tr>
</table>
<?php 
	}
}
?>