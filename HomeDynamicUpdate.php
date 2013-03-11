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

$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 50;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
if((!$limit) || (is_numeric($limit) == false)|| ($limit < 50) || ($limit > 50)) 
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
$sql_stmt = "SELECT news_id,creater,subject,descrip,pdate,ptime,'news_info' AS tbname, category, eventdate, eventtime, NULL, NULL, NULL 
			FROM rockinus.news_info a 
			UNION
			SELECT rmate_id, uname, has_room, descrip, pdate, ptime, 'room_mate_info' AS tbname, mate_type, NULL,NULL, NULL, NULL, NULL 
			FROM rockinus.room_mate_info d 
			UNION
			SELECT book_id, uname, book_name, descrip, pdate, ptime, 'book_info' AS tbname, mid, NULL,NULL, NULL, NULL, NULL 
			FROM rockinus.book_info e 
			ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit";
$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("");
$i=0;
$seq_id = 0;
$array_show = array();
while($object = mysql_fetch_object($q)){
	if($seq_id>12) break;
	$i++;
	$id = $object->news_id;
	$subject = $object->subject;
	$subject = str_replace("\\","",nl2br($subject));
	$loopname = $object->creater;		
	$category = $object->category;		
	$descrip = nl2br($object->descrip);
	$descrip = str_replace("\\","",$descrip);
	if(strlen($descrip)>250) $descrip = substr(trim($descrip), 0, 250)." ...<br><br> "."<a href='newsList.php' class=one><font style='font-size:11px'><strong>:: Read More</strong></font></a>";
	$tbname = $object->tbname;			
	$pdate = $object->pdate;
	$ptime = $object->ptime;			
	$eventdate = $object->eventdate;
	$eventtime = $object->eventtime;
//	$col_1 = $object->col_1;
	$orig_subject = $subject;
	if(strlen($subject)>30) $subject = substr(trim($subject), 0, 28)."...";
	if($tbname=="news_info"){
		if(($category=='event' || $category=='seminar') && getCountTime($eventdate." ".$eventtime)=="<font color=#B92828>Expired</font>"){
			array_push($array_show, $id);
		}else{
			$seq_id++;
?>	
<script>
$(document).ready(function() { 
	$("#newsDiv_<?php echo($seq_id) ?>").hide();
//	$("#showNews_<?php echo($seq_id) ?>").show();
//	$("#newsTitleDiv_<?php echo($seq_id) ?>").hide();
	
	for(var j=1; j<=<?php echo($seq_id) ?>; j+=13){
		//$("#newsTitleDiv_<?php echo($seq_id) ?>").fadeOut("fast").fadeIn(1000); 
	} 
	
	$("div .showNews_<?php echo($seq_id) ?>").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  for(var i=1; i<=13; i++) $("#newsTitleDiv_"+i).hide(); 
	  $("#newsDiv_<?php echo($seq_id) ?>").show(); 
	  //$("#activeCourseDiv_1").hide();
	});

	$("div .hideNews_<?php echo($seq_id) ?>").click(function () {
	  $("#newsDiv_<?php echo($seq_id) ?>").hide();
	  for(var i=1; i<=13; i++) $("#newsTitleDiv_"+i).show(); 
	});
});
</script>
<div class="newsTitleDiv_<?php echo($seq_id) ?>" id="newsTitleDiv_<?php echo($seq_id) ?>" style="width:385; display:">
<table width="385" height="20" style="font-family: Arial, Helvetica, sans-serif; margin-bottom:; background:#FFFFFF; border-bottom:0 #DDDDDD solid" border="0" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor='#F5F5F5';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
  <tr>
    <td width="30" style="color:#000000; padding-left:3;  padding-top:; line-height:150%; font-size:14px" valign='top' align='left'><img src="img/newsIcon.png" width="20" /></td>
    <td width="340" align="left" valign='top' style="color:#000000; padding-left:0; padding-top:0; line-height:150%; border-bottom:1px solid #EEEEEE; padding-bottom:2; font-size:14px">
	<div class="showNews_<?php echo($seq_id) ?>" id="showNews_<?php echo($seq_id) ?>" style="cursor:pointer; display:inline">
	<font color=<?php if($i<4 && trim($category)!="lostfound")echo($_SESSION['hcolor']);else if(trim($category)=="lostfound")echo("#B92828");else echo("black") ?> style='font-weight:<?php if($i<4)echo("normal"); else echo("normal"); ?>'><?php echo($subject) ?></font>	
	<?php 
	if($category=="event"||$category=="seminar"){
	?>
		<font style="font-size:11px; color:#999999">(<?php echo(getCountTime($eventdate." ".$eventtime)) ?>)</font>
	<?php 
	}else{
	?>
		<font style="font-size:11px; color:#999999">(<?php echo("Posted @".getDateName($pdate)) ?>)</font>
	<?php 
	}
	?>
	
	</div>
	</td>
    </tr>
</table>
</div>
<div class="newsDiv_<?php echo($seq_id) ?>" id="newsDiv_<?php echo($seq_id) ?>" style="display: none; width:385; height:320; background-color:#F5F5F5">
<table width="385" height="33" style="font-family: Arial, Helvetica, sans-serif; margin-bottom:; background:; border-bottom:0 #DDDDDD solid" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign='top' style="color:#000000; padding-left:15; padding-top:5; line-height:150%; border-bottom:0px solid #EEEEEE; padding-bottom:5; padding-right:10; font-size:14px; font-family:Arial, Helvetica, sans-serif">
	<font color="<?php if($i<4 && trim($category)!="lostfound")echo($_SESSION['hcolor']);else if(trim($category)=="lostfound")echo("#B92828"); ?>"><strong><?php echo($orig_subject) ?></strong></font>	</td>
    </tr>
  <tr>
    <td height="20" align="left" valign='top' style="color:#999999; line-height:150%; padding-left:15; font-size:11px">
	<div style=" display:inline"><?php echo(getDateName($pdate)." | $loopname | ") ?><a href="SendMessage.php?recipient=<?php echo($loopname)?>" class="one"><font style="font-size:12px; color:#999999">+ Message</font></a></div></td>
    </tr>
</table>
<table width="385" height="33" style="font-family: Arial, Helvetica, sans-serif; margin-bottom:; background:; border-bottom:0 #DDDDDD solid" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align='left' valign='top' style="color:#000000; padding-left:15; padding-right:15;  padding-top:10; line-height:130%; font-size:14px">
	<div style="margin-bottom:20; font-family:Arial, Helvetica, sans-serif; font-size:13px"><?php echo($descrip) ?></div>
	<div class="hideNews_<?php echo($seq_id) ?>" id="hideNews_<?php echo($seq_id) ?>" style=" height:15; padding:0 5 4 5; background: url(img/master.jpg); display:; margin-top:5; margin-bottom:0; width:80; border:1px solid #999999; border-top:1px solid #DDDDDD; border-left:1px solid #DDDDDD; font-size:11px; cursor:pointer" align="center">Back to the list</div>
	</td>
    </tr>
</table>
</div>
<?php
		}
	}else if($tbname=="book_info_"){
?>
<table width="385" height="20" style=" font-family: Arial, Helvetica, sans-serif; background:; margin-bottom:; border-bottom:0 #DDDDDD solid" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="33" height="20" align='left' valign='top' style="color:#000000; padding-left:5; padding-top:2; line-height:150%; font-size:14px">
	<img src="img/smallBookIcon.jpg" width="15" /></td>
    <td height="20" align="left" valign='top' style="color:#000000; padding-left:0; padding-top:2; line-height:150%; border-bottom:1px solid #EEEEEE; padding-bottom:2; font-size:12px">
	<a href="eventDetail.php?eid=<?php echo($id) ?>" class="one"><font color="<?php if($i<4)echo($_SESSION['hcolor']); ?>"><?php echo($subject) ?></font></a>
	<font style="font-size:11px; color:#999999"><?php echo(getDateName($pdate." posted")) ?></font>
	</td>
  </tr>
</table>
<?php }else if($tbname=="room_mate_info_"){
		if($subject=="Y") $has_room_title = "<font color=#666666>(has Apt.)</font>";
		if($category=="all") $mate_type = "";
		else $mate_type = "<font color=#666666>($category)</font>";
?>
<table width="385" height="20" style=" font-family: Arial, Helvetica, sans-serif; background:; margin-bottom:; border-bottom:0 #DDDDDD solid" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="32" style="color:#000000; padding-left:5; padding-top:2; line-height:150%; font-size:14px" valign='top' align='left'><img src="img/smallManIcon.jpg" width="15" /></td>
    <td align="left" valign='top' style="color:#000000; padding-left:0; padding-top:2; line-height:150%; border-bottom:1px solid #EEEEEE; padding-bottom:2; font-size:12px">
	<a href="roomMateList.php" class="one"><?php if($i<4)echo("<a href=roomMateList.php class=one><font style='font-weight:normal; color=$_SESSION[hcolor]'>Someone looks for roomate$mate_type</font></a>"); else echo("<a href=roomMateList.php class=one><font style='font-weight:normal'>Someone looks for roomate$mate_type</font></a>") ?></a>
	<font style="font-size:11px; color:#999999">(<?php echo(getNoDateName($pdate)." posted") ?>)</font>
	</td>
  </tr>
</table>
<?php 
	}
}
?>