<?php
include "dbconnect.php";
//include "Allfuc.php";
//header("Content-Type: text/html; charset=gb2312");
mysql_query("SET NAMES UTF8");

$sel_count = "
SELECT sum(total) as cnt FROM (
	SELECT count(*) as total FROM rockinus.house_info WHERE rstatus='Y'
	UNION 
	SELECT count(*) as total FROM rockinus.article_info WHERE rstatus='Y'
) as cnt";

$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 10;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
if((!$limit) || (is_numeric($limit) == false)|| ($limit < 10) || ($limit > 30)) 
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
<table width="370" height="29" border="0" cellpadding="0" cellspacing="0" background="img/master.jpg" style="font-size:12px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; padding-left:10; padding-top:; border-top:1px solid #DDDDDD; border-bottom:1px solid #999999; background: url(img/master.jpg) ?>); color:#FFFFFF">
  <tr>
    <td width="220" style="padding-left:0; font-size:14px; font-family: Arial, Helvetica, sans-serif; font-weight:bold; border-bottom:0px solid #CCCCCC; color:#000000" align="left">
	<a href="FleaMarket.php" class="one" style="color: #">Sales, Bargins</a></td>
    <td width="140" style="padding-right:15; font-size:12px; font-family: Arial, Helvetica, sans-serif; font-weight:bold; border-bottom:0px solid #CCCCCC; color:#000000" align="right"><img src="img/note-add.png" width="10" /> &nbsp;<a href="PostFlea.php" class="one"><font color="">Post New Sale</font></a></td>
  </tr>
</table>
<?php				
$sql_stmt = "SELECT aid, uname, subject, descrip, pdate, ptime, 'article_info' AS tbname, rate, aname, NULL, NULL, NULL, NULL, NULL
			FROM rockinus.article_info b WHERE b.rstatus='Y'
			ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit";
$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("");
$kk = 0;
while($object = mysql_fetch_object($q)){
	$kk++;
	$id = $object->aid;
	$subject = $object->subject;
	$subject = str_replace("\\","",nl2br($subject));
	$loopname = $object->uname;		
	$type = $object->aname;		
	$descrip = $object->descrip;
	$descrip = str_replace("\\","",$descrip);
	$tbname = $object->tbname;			
	$rate = $object->rate;			
	$pdate = $object->pdate;
	$ptime = $object->ptime;
	if($rate=="0") $rate = "No Price";
	else $rate = "$".$rate;

	if(strlen($subject)>50&&strlen($subject)%2==0) $subject = substr(trim($subject), 0, 47)." ...";
	else if(strlen($subject)>50&&strlen($subject)%2==1) $subject = substr(trim($subject), 0, 48)." ...";
	
	if(strlen($descrip)>50&&strlen($descrip)%2==0) $descrip = substr(trim($descrip), 0, 47)." ...";
	else if(strlen($descrip)>50&&strlen($descrip)%2==1) $descrip = substr(trim($descrip), 0, 48)." ...";
	
	if($tbname=="article_info"){
?>
<table width="370" height="69" style=" font-family:Geneva, Arial, Helvetica, sans-serif; background:<?php if($kk%2==1)echo("#FFFFFF");else echo("#F5F5F5");?>; margin-bottom:0; border-right:1px #EEEEEE solid; border-left:1px solid #EEEEEE; border-bottom:1px dotted #DDDDDD;" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50" rowspan="2" align='left' valign='top' style="color:#000000; padding-left:5; padding-top:10; line-height:100%; font-size:14px; border-bottom:0px solid #DDDDDD;">
	<?php 
			$target = "upload/a".$id;
			if(is_dir($target)){
				echo("<img src='upload/a$id/1_100.jpg' style='border:0' width=40>");
			}else 				  		
				echo("<img src='img/saleIcon.png' style='border:0' width=30>");
	?>	</td>
    <td width="270" height="64" valign='top' style="color:#000000; padding-left:0; padding-top:10; line-height:100%; border-bottom:0px dashed #DDDDDD; font-size:12px">
	<div style="margin-bottom:5">
	<a href="ArticleDetail.php?aid=<?php echo($id) ?>" class="one"><font color="<?php echo($_SESSION['hcolor'])?>"><strong><?php echo($subject) ?></strong></font></a></div>
	<font style="font-size:11px; color:#333333"><?php echo("<span style='font-size:11px'>$rate | $type </span>") ?>(<?php echo(getNoDateName($pdate)." | ".substr($ptime,0,5)) ?>)</font>
	<div style="color:#999999; padding-right:20; padding-left:0; padding-top:5; padding-bottom:0; border-bottom:0px solid #DDDDDD; line-height:100%; font-size:12px"><?php echo($descrip) ?></div>
	</td>
  </tr>
</table>

<?php }
}
?>
