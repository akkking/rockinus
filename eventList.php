<?php 
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
include 'dbconnect.php';
?>
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="center">
    <tr>
      <td width="300" align="left" valign="top" style="border-right:1 dashed #DDDDDD">
	  <?php include("leftHomeMenu.php"); ?>
	  </td>
      <td width="760" align="right" valign="top">
	  <?php include("HeaderEN.php"); ?>
	  <table width="740" height="35" border="0" cellpadding="0" cellspacing="0" background="img/master.png" style="border-bottom:#CCCCCC solid 1;">
        <tr>
          <td width="86" height="30" align="right" style="padding-right:15px; color:; font-size:14px"><strong>Category</strong> </td>
          <td width="79" height="30" align="left" style="padding-left:0px"><span style="border-right: 0px solid black; padding-left:0; ">
            <select name="country">
              <option value="All"  selected="selected">Any</option>
              <option value="soccer">Soccer</option>
              <option value="study">Study</option>
            </select>
          </span></td>
          <td width="451" height="30" align="right" style="padding-right:15px"><?php
$page_name = "eventList.php";

include 'dbconnect.php';
 
$q = "SELECT count(*) as cnt FROM rockinus.event_info ORDER BY pdate,ptime DESC";
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 15;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
if((!$limit) || (is_numeric($limit) == false)|| ($limit < 15) || ($limit > 50)) {
	$limit = 1; //default
}
 
if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items)) { 
	$page = 1; //default 
}
 
//calculate total pages
$total_pages = ceil($total_items / $limit);
$set_limit = ($page * $limit) - $limit;
//echo "Total Pages: $total_pages <br/>";
if ($total_items != 0 )echo "Page ";
//prev. page
$prev_page = $page - 1;
if($prev_page >= 1) { 
	echo("<a href=$page_name?limit=$limit&page=$prev_page class=one>Previous</a> ");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo(" <strong>$a</strong> "); //no link
}else{ 
	echo("<a href=$page_name?limit=$limit&page=$a class=one> <strong>$a </strong></a>   ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo(" <a href=$page_name?limit=$limit&page=$next_page class=one>Next</a>");
}
if ($total_items != 0 )echo "";
?></td>
          <td width="124" height="30" align="right" valign="middle" style="border-right: 0 dotted #999999; padding-right:5"><div align="center" style="border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: #CC3300; padding-bottom:5; padding-top:5; width:100px"><a href="createEvent.php"><strong>+ New Event</strong></a></div>
              </div>
          </td>
        </tr>
      </table>
	  <?php
if ($total_items == 0 )echo("<br><br><br><div align=center><font color=$_SESSION[hcolor] size=4><strong>There is, No Event Created ...</strong></font></div>");
else{
		$q = mysql_query("SELECT * FROM rockinus.event_info ORDER BY pdate,ptime DESC LIMIT $set_limit, $limit");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		
		while($object = mysql_fetch_object($q)){
			$eid = $object->eid;
			$creater = $object->creater;
			$eventTitle = $object->eventTitle;
			$unameList = $object->unameList;
			$eventDate = $object->eventDate;
			$from_time = $object->from_time;
			$to_time = $object->to_time;
			$eventType = $object->eventType;
			$descrip = $object->descrip;
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			?>
      <table width="740" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1 #EEEEEE solid; margin-bottom:5; margin-right:3; padding-top:3; padding-bottom:5; margin-left:15px; margin-right:15px; margin-top:15px">
        <tr>
          <td width="105" height="105" align="center" style="padding-top:5; padding-left:10; padding-bottom:15">
              <?php 
				if($eventType=="soccer")
				echo("<a href='eventDetail.php?eid=$eid' class='one'><img src=img/soccerIcon.jpg style=border:0 width=100px></a>");
				else if($eventType=="study")
				echo("<a href='eventDetail.php?eid=$eid' class='one'><img src=img/studyIcon.jpg style=border:0 width=100px></a>");
				else if($eventType=="swimming")
				echo("<a href='eventDetail.php?eid=$eid' class='one'><img src=img/swimmingIcon.jpg style=border:0 width=100px></a>");
				else if($eventType=="basketball")
				echo("<a href='eventDetail.php?eid=$eid' class='one'><img src=img/basketballIcon.jpg style=border:0 width=100px></a>");
				?>
          </td>
          <td width="710" colspan="2" valign="to()p"><table width="625" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="35" colspan="2" valign="middle" style="padding-left:45; font-size:14px">
				<a class="one" href="eventDetail.php?eid=<?php echo($eid) ?>" style="color:<?php echo($_SESSION['hcolor']) ?>"><strong><? echo($eventTitle) ?></strong></a></td>
              </tr>
              <tr>
                <td width="110" height="35" valign="middle" style="padding-right:15px; font-size:14px" align="right"><strong>When:</strong></td>
                <td width="630" valign="middle" style="padding-left:0"><?php echo("$eventDate")?></td>
              </tr>
            </table>
            <table width="625" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="110" height="40" valign="middle" style="padding-right:15px; font-size:14px" align="right">
				  <strong>Sponser:</strong></td>
                  <td width="630" valign="middle" style="padding-left:0">
				  <?php echo("<strong><font color=$_SESSION[hcolor]>$creater</font></strong>")?> | <?php echo("$pdate $ptime")?></td>
                </tr>
                <tr>
                  <td height="20" valign="middle" style="padding-right:15px" align="right">&nbsp;</td>
                  <td height="20" valign="middle" style="padding-left:0">&nbsp;</td>
                </tr>
            </table></td>
        </tr>
      </table>
      <?php } }?>
      </td>
    </tr>
</table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
