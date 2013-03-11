<?php include("GreenHeaderFreeTour.php"); ?>
<style>
#HouseDiv {
	margin: 0px;
    color: #fff;
    width: 800px;
	height: 30px;
    padding: 0px;
    text-align: left;
	margin-bottom:0px;
	background-color:<?php echo($_SESSION['hcolor']) ?>;
    border: 1px solid #DDDDDD;
}
body,td,th {
	font-size: 14px;
}
</style>
<script type="text/JavaScript">
  curvyCorners.addEvent(window, 'load', initCorners);
  function initCorners() {
    var settings = {
      tl: { radius: 10 },
      tr: { radius: 10 },
      bl: { radius: 0 },
      br: { radius: 0 },
      antiAlias: true
    }
    curvyCorners(settings, "#HouseDiv");
}
</script>
 <?php include("FreeHeader.php") ?>
<table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="margin-top:10px">
    <tr>
      <td width="1024" align="left" valign="top" style=" border-right:#DDDDDD solid 0;border-left:#DDDDDD solid 0;">
	  <form action="login_process.php" method="post">
	    <table width="204" height="340" border="0" cellpadding="0" cellspacing="0" style="border-left:0px #CCCCCC solid; border-bottom:0px #CCCCCC solid; border-top:0px #CCCCCC solid">
          <tr>
            <td width="204" height="10" align="left" style="padding-left:0px; padding-top:0px; padding-bottom:0px"><a href="main.php"><img src="img/rockinus.jpg" /></a></td>
          </tr>
          <tr>
            <td height="40" align="left" style="padding-left:0px; padding-top:0px; padding-bottom:5px"><?php 
		  	if(isset($_SESSION['logoff_tag'])){
		  		echo $_SESSION['logoff_tag'];
				unset($_SESSION['logoff_tag']);
			}
		  ?>
            </td>
          </tr>
          <tr>
            <td height="24" align="left" style="padding-left:15px"><strong><font size="3" color="#336633">Username</font></strong></td>
          </tr>
          <tr>
            <td height="35" align="left" style="padding-left:15px"><input type="text" style="height:22px" name="usrname" size="23" onmouseover="this.className='over'" onmouseout="this.className='out'" class="box" value="<?php if(isset($_COOKIE["user"])) echo($_COOKIE["user"]); ?>" /></td>
          </tr>
          <tr>
            <td height="25" align="left" style="padding-left:15px"><strong><font size="3" color="#336633">Password</font></strong></td>
          </tr>
          <tr>
            <td height="35" align="left" style="padding-left:15px"><input type="password" style="height:22px" name="passwd" onmouseover="this.className='over'" onmouseout="this.className='out'" class="box" size="23" />
            </td>
          </tr>
          <tr>
            <td height="40" align="left" style="padding-left:15px"><input type="checkbox" name="Login_Tag" />
              Remember Me </td>
          </tr>
          <tr>
            <td height="40" align="left" style="padding-left:15px"><input type="submit" name="Submit" value="Sign In" class="btn2" />
            </td>
          </tr>
          <tr>
            <td height="45" align="left" style="padding-left:15px"><img src="img/PenIcon.jpg" /> &nbsp;<a href="findPassword.php" class="one"><font size="2">Forget Password?</font></a></td>
          </tr>
          <tr>
            <td height="15" style="padding-left:15px; padding-top:10px" align="left"><hr width="170px" color="#000000" style="border:solid 1px" /></td>
          </tr>
          <tr>
            <td height="20" style="padding:15px; padding-bottom:20px; line-height:150%" align="left"><div style="margin-bottom:15px; padding-top:0px; margin-top:5px; "><strong><font size="3" color="#336633">NOT A MEMBER? </font></strong></div>
                <font style="font-size:11px"> Rockinus is an open, free, school-based social network for  students who study or wish to study in <span style="background-color:#ffffff; border-bottom:1px #999999 dashed"><strong><font size="2" color="#336633">Polytechnic Institute of</font> <font color="#660099">NYU</font></strong></span>. You can post house rentals, sales, class comments, events, etc. Also, it is a place to find friends, exchange   topics with other students as well.</font>
                <p style="margin-bottom:25px"> </p>
              <div> <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 30px; display:inline; margin-bottom:0px; background-color: #B92828; border-bottom:1 solid #333333; border-top:1 solid #333333"><a href="joinUs.php"><strong>Sign Up</strong></a></span> &nbsp; <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 30px; display:inline; margin-bottom:5px; background: url(img/black_cell_bg.jpg); border-bottom:1 solid #000000; border-top:1 solid #000000"><a href="commentUs.php"><strong>Comment</strong></a></span></div></td>
          </tr>
        </table>
	  </form>
	  </td>
	  <td valign="top" align="center" style="padding-top:0px; border-left:1px solid #DDDDDD; border-right:1px solid #DDDDDD;"><table width="810" height="35" border="0" cellpadding="0" cellspacing="0" background="img/master.png" style="border-bottom: 1px #CCCCCC solid; border-top:1px solid #CCCCCC; margin-bottom:0px">
        <tr>
          <td width="499" align="left" valign="middle" style="padding-left:10px"><font color="#999999"><strong> &nbsp;<a href="FreeTourHouse.php" class="one">House</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="FreeTourMarket.php" class="one">Sale</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="FreeTourEvent.php" class="one">Event</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="FreeTourClass.php" class="one">Class</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="FreeTourForum.php" class="one">Questions</a>&nbsp;</strong></font></td>
          <td width="227" valign="middle" align="left">&nbsp;</td>
          <td width="84" align="center" valign="middle" style="padding-left:0px"><form action="Header.php" id="switch_lan" name="switch_lan" method="post">
              <select name="lan" class="box" onchange="document.switch_lan.submit()" style="background-color:#F5F5F5; font-size:11px">
                <option value="EN" selected="selected">English</option>
              </select>
          </form></td>
        </tr>
      </table>
		<?php
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
if ($total_items != 0 )echo "<font color=white>Page</font> ";
//prev. page
$prev_page = $page - 1;
if($prev_page >= 1) { 
	echo("<a href=$page_name?limit=$limit&page=$prev_page><font color=black>Previous</font></a>");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo(" <strong><font color=white>$a</font></strong> "); //no link
}else{ 
	echo("<a href=$page_name?limit=$limit&page=$a> <strong>$a </strong></a>   ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo(" <a href=$page_name?limit=$limit&page=$next_page><font color=white>Next</font></a>");
}
//if ($total_items != 0 )echo "";

if ($total_items == 0 )echo("<br><br><br><div align=center><font color=$_SESSION[hcolor] size=4><strong>There is, No Event Created ...</strong></font></div>");
else{
		$q = mysql_query("SELECT * FROM rockinus.event_info ORDER BY pdate,ptime DESC LIMIT $set_limit, $limit");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		
		while($object = mysql_fetch_object($q)){
			$eid = $object->eid;
			$creater = $object->creater;
			$eventTitle = $object->eventTitle;
			$eventSpot = $object->eventSpot;
			$unameList = $object->unameList;
			$eventDate = $object->eventDate;
			$from_time = $object->from_time;
			$from_time = substr($from_time,0,5);
			$to_time = $object->to_time;
			$to_time = substr($to_time,0,5);
			$eventType = $object->eventType;
			$descrip = $object->descrip;
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			
			$q_attend = mysql_query("SELECT * FROM rockinus.event_attendance WHERE eid='$eid' AND rstatus='Y'");
			$no_row_attend = mysql_num_rows($q_attend);
			//$attendance = $object->attendance;
			if($no_row_attend>0){
				while($object = mysql_fetch_object($q_attend)){
					$attendance = $object->sender." ";
				}
			}else
				$attendance = $creater;
			?>
	    <div style="padding-top:15; padding-bottom:15; border-bottom:1px #EEEEEE solid" onmouseover="this.style.backgroundColor = '#F5F5F5';this.style.borderColor = '#DDDDDD';" onmouseout="this.style.backgroundColor = 'white';this.style.borderColor = '#DDDDDD';">
	      <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" style="border-bottom:0 #EEEEEE solid; margin-bottom:5; margin-right:3; padding-top:3; padding-bottom:5; margin-left:0px; margin-right:0px; margin-top:15px">
            <tr>
              <td width="105" height="50" valign="top" style="padding-top:5px; padding-left:20px; padding-bottom:15">
                  <?php 
				if($eventType=="soccer")
				echo("<a href='FreeTourEvent.php?eid=$eid' class='one'><img src=img/soccerIcon.jpg style=border:0 width=80px></a>");
				else if($eventType=="study")
				echo("<a href='FreeTourEvent.php?eid=$eid' class='one'><img src=img/studyIcon.jpg style=border:0 width=80px></a>");
				else if($eventType=="swimming")
				echo("<a href='FreeTourEvent.php?eid=$eid' class='one'><img src=img/swimmingIcon.jpg style=border:0></a>");
				else if($eventType=="basketball")
				echo("<a href='FreeTourEvent.php?eid=$eid' class='one'><img src=img/basketballIcon.jpg style=border:0></a>");
				?>
              </td>
              <td width="710" colspan="2" valign="to()p"><table width="700" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="40" valign="middle" style="padding-right:15px; font-size:16px" align="right"><strong>Subject:</strong></td>
                    <td height="40" colspan="2" align="left" valign="middle" style="padding-left:0px; font-size:16px; color:#336633"><strong><? echo($eventTitle) ?></strong></td>
                  </tr>
                  <tr>
                    <td width="119" height="40" valign="middle" style="padding-right:15px; font-size:14px" align="right"><strong>When:</strong></td>
                    <td width="421" height="40" valign="middle" style="padding-left:0; font-size:14px"><?php echo("$eventDate")?></td>
                    <td width="160" height="40" valign="middle" align="right" style="font-size:14px; padding-right:15">
					<a href="FreeTourSendMsg.php?recipient=<?php echo($creater) ?>" class="one">
					<div style="display:inline; border:1px #333333 solid; border-bottom:1px #CCCCCC solid; background: #336633; padding:10px; padding-top:5px; padding-bottom:5px; font-size:14px; color:#FFFFFF; height:25" id="sendmsg" onmouseover="this.style.cursor='hand'">
		Contact Sponser
		</div></a>
					</td>
                  </tr>
                  <tr>
                    <td height="40" valign="middle" style="padding-right:15px; font-size:14px" align="right">&nbsp;</td>
                    <td height="40" colspan="2" valign="middle" style="padding-left:0; font-size:14px">
					From <?php echo("$from_time")?> to <?php echo("$to_time")?></td>
                  </tr>
                  <tr>
                    <td height="40" valign="middle" style="padding-right:15px; font-size:14px" align="right"><strong>Where:</strong></td>
                    <td height="40" colspan="2" valign="middle" style="padding-left:0; font-size:14px"><?php echo("$eventSpot")?></td>
                  </tr>
                    <tr>
                      <td width="119" height="40" valign="middle" style="padding-right:15px; font-size:14px" align="right"><strong>Sponser:</strong> </td>
                      <td height="40" colspan="2" valign="middle" style="padding-left:0; font-size:14px">
					  <?php echo("<a href=FreeTourUser.php?uid=$creater class=one><strong><font color=#336633>$creater</font></strong></a>")?> | <?php echo("$pdate ".substr($ptime,0,5)) ?></td>
                    </tr>
                    <tr>
                      <td height="40" style="padding-right:15px; padding-top:5px; font-size:14px" align="right" valign="top">
					  <strong>Description</strong></td>
                      <td height="40" colspan="2" valign="top" style=" padding:5; padding-left:0; line-height:150%; font-size:14px">
					  <?php echo(nl2br($descrip)) ?>					  </td>
                    </tr>
                    <tr>
                      <td height="40" style="padding-right:15px; padding-top:7px; font-size:14px" align="right" valign="top"><strong>Attendance</strong></td>
                      <td height="40" colspan="2" valign="top" style=" padding:5; padding-left:0; line-height:150%; font-size:14px">
					  <?php 
					  if(strlen(trim($attendance))==0 || $attendance==NULL ) echo($creater);
					  else echo($creater.",".$attendance); 
					  ?>					  </td>
                    </tr>
                </table></td>
            </tr>
          </table>
	    </div>
		<?php }} ?>
	  </td>
    </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
</body>
</html>
