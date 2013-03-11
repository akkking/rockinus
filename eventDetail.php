<?php 
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
include 'dbconnect.php';

if(isset($_POST['eventSubmit'])){
	//session_start();
	//$uname = $_SESSION['usrname'];
	$eid = $_POST['eid'];
	$sender = addslashes($_POST['sender']);
	$rstatus = "N";
	$descrip = addslashes($_POST['description']);
	if( $descrip!=NULL && strlen($descrip)!=0 ){
		$sql = "INSERT INTO rockinus.event_history (eid,sender,descrip,rstatus,pdate,ptime)VALUES('$eid','$sender','$descrip','$rstatus',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		mysql_close($link);
	}
}else if(isset($_GET['eid'])){ 
	$eid = $_GET['eid'];
}

include 'dbconnect.php';

$q = mysql_query("SELECT * FROM rockinus.event_info WHERE eid='$eid'");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
$object = mysql_fetch_object($q);
$creater = $object->creater;
$eventTitle = $object->eventTitle;
$unameList = $object->unameList;
$eventDate = $object->eventDate;
$eventSpot = $object->eventSpot;
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
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="center">
    <tr>
      <td width="300" rowspan="2" align="left" valign="top" style="border-right:1 #DDDDDD dashed">
	  <?php include("leftHomeMenu.php"); ?></td>
      <td width="760" align="right" valign="top">
	  <?php include("HeaderEN.php"); ?>
	  <table border="0" cellspacing="0" cellpadding="0" style="border-left:0px #CCCCCC dotted" width="740">
        <tr>
          <td align="center" valign="top" style=" border-left:0px #DDDDDD solid">
		  <table width="740" height="35" border="0" cellpadding="0" cellspacing="0" background="img/master.png" style="border-bottom:#CCCCCC solid 1;">
            <tr>
              <td width="595" height="35" align="center" style="padding-left:0px; color:; font-size:16px; font-weight:bold">
			  <? echo($eventTitle) ?>			  </td>
              <td width="145" height="35" align="right" valign="middle" style="border-right: 0px dotted #999999; padding-right:5;">
			  <div align="center" style="border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: #CC3300; padding-bottom:5; padding-top:5; padding-left:10; padding-right:10; height:25; margin-right:5px; display:inline"><a href="createEvent.php"><strong>+ Create Event</strong></a></div>
               </div>			   </td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="740" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-bottom:25px; margin-right:0px; padding-top:3; padding-bottom:5; margin-left:0px; margin-top:20px">
        <tr>
          <td width="82" rowspan="2" align="center" style="padding-left:25px; padding-top:5" valign="top">
              <?php 
				if($eventType=="soccer")
				echo("<a href='eventDetail.php?eid=$eid' class='one'><img src=img/soccerIcon.jpg style=border:0></a>");
				else if($eventType=="study")
				echo("<a href='eventDetail.php?eid=$eid' class='one'><img src=img/studyIcon.jpg style=border:0></a>");
				else if($eventType=="swimming")
				echo("<a href='eventDetail.php?eid=$eid' class='one'><img src=img/swimmingIcon.jpg style=border:0></a>");
				else if($eventType=="basketball")
				echo("<a href='eventDetail.php?eid=$eid' class='one'><img src=img/basketballIcon.jpg style=border:0></a>");
				?>          </td>
          <td height="105" colspan="2" valign="to()p"><table width="610" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td width="117" height="40" align="right" class="STYLE1" style="padding-right:15px; font-size:14px"><strong>When:</strong></td>
                <td width="306" height="40" align="left" valign="middle" style="padding-left:0px; font-size:14px"><?php echo("$eventDate")?></td>
                <td width="187" height="40" align="right" valign="middle" style="font-size:14px">
				<span style="background-color:#666666; padding:10; padding-top:5; padding-bottom:5; height:15; border:1 #000000 solid; font-size:14px">
			<?php 
			$q_attend = mysql_query("SELECT count(*) AS cnt FROM rockinus.event_attendance WHERE eid='$eid' AND sender='$uname' AND rstatus='Y'");
			//if(!$q_attend) die(mysql_error());
			$object = mysql_fetch_object($q_attend);
			$total_num = $object->cnt;
			if($total_num>0)$attend_tag=0;
			else $attend_tag=1;
			if($attend_tag == 1){ ?>
			<a href="EventConfirm.php?eid=<?php echo($eid) ?>&&pageName=ThingsRock&&attend=Y">Attend this event</a>
			<?php }else{ ?>
			<font color=yellow>You are attended</font>
			<?php } ?>
			</span>				</td>
              </tr>
              <tr>
                <td height="30" align="right" class="STYLE1" style="padding-right:15px">&nbsp;</td>
                <td height="30" colspan="2" align="left" valign="middle" style="padding-left:0px; font-size:14px">
				From <?php echo("$from_time")?> to <?php echo("$to_time")?>				</td>
              </tr>
              <tr>
                <td width="117" height="40" align="right" class="STYLE1" style="padding-right:15px;font-size:14px"><strong>Where:</strong></td>
                <td height="40" colspan="2" valign="middle" class="STYLE1" style="padding-left:0; font-size:14px"><?php echo("$eventSpot")?></td>
              </tr>
            </table>
              <table width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="116" height="40" align="right" class="STYLE1" style="padding-right:15px; font-size:14px"><strong>Invitees:</strong></td>
                  <td width="484" height="40" valign="middle" class="STYLE1" style="padding-left:0; font-size:14px"><?php echo("<strong><font color=#CC3300>$unameList</font></strong>")?></td>
                </tr>
            </table>
            <table width="600" height="35" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="126" height="40" align="right" valign="middle" style="padding-right:15px; font-size:14px">
				  <strong>Sponser:				  </strong>				  </td>
                  <td width="614" height="40" valign="middle" class="STYLE1" style="padding-left:0; font-size:14px">
				  <?php echo("<strong><font color=#CC3300>$creater</font></strong>")?> | <?php echo(getDateName($pdate)." | ".substr($ptime,0,5))?> 
				  <font color="#999999"> Posted</font> </td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td width="111" height="37" align="right" valign="top" style="padding-right:15px; padding-top:10; font-size:14px">
		  <strong>
		  Description:
		  </strong></td>
          <td width="547" align="left" style="padding:10; padding-left:0; line-height:150%; font-size:14px" valign="top">
		  <?php echo(nl2br($descrip)) ?>		  </td>
        </tr>
        <tr>
          <td align="center" style="padding-left:25px; padding-top:5" valign="top">&nbsp;</td>
          <td height="37" align="right" valign="top" style="padding-right:15px; padding-top:10; font-size:14px">
		  <strong>Attendance:</strong></td>
          <td align="left" style="padding:10; padding-left:0; line-height:150%; font-size:14px" valign="top">
		  <?php 
			echo($attendance); 
		  ?>
		  </td>
        </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td align="right" valign="top" style="padding-top:0; padding-bottom:20">
	    <table width="740" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px">
          <tr>
            <td width="710" height="41" colspan="3" style="padding-top:5"><?php
$q1 = mysql_query("SELECT * FROM rockinus.event_history WHERE eid='$eid' ORDER BY pdate DESC, ptime DESC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0) echo("");
if($no_row > 0){ 
while($object = mysql_fetch_object($q1)){
	$sender = $object->sender;	
	$descrip = $object->descrip;
	$ptime = $object->ptime;
	$pdate = $object->pdate; 
?>
                <div style="line-height:180%; margin-bottom:10px; width: 740; border:4 #EEEEEE solid;" align="left">
                  <table width="740" height="63" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5">
                    <tr>
                      <td width="218" height="29" align="left" style="padding-left:10px"><strong> <a href="RockerDetail.php?uid=<?php echo($sender) ?>" class="one"><font color="<?php echo($_SESSION['hcolor']) ?>"><?php echo($sender) ?></font></a></strong><font color="#666666"> commented:</font> </td>
                      <td width="491">&nbsp;</td>
                      <td width="143" align="right" style=" color: #999999; font-size:13px; padding-right:10px"><?php echo($pdate) ?> | <?php echo($ptime) ?></td>
                    </tr>
                    <tr>
                      <td height="22" colspan="3" style="padding:10px; line-height:150%; font-size:14px"><?php
							echo nl2br($descrip);
							?>
                          </font> </td>
                    </tr>
                  </table>
                </div>
              <?php }}?></td>
          </tr>
        </table>
	    <form action="eventDetail.php" method="post">
	  <table width="740" border="0" cellpadding="0" cellspacing="0" style="border-top:#CCCCCC solid 0">
        <tr>
          <td width="289" height="30" background="img/master.png" style="padding-left:10"><strong>Comment on this event</strong></td>
          <td width="453" height="30" background="img/master.png">
		  <input type="hidden" name="sender" value="<?php echo($uname) ?>" />
		  <input type="hidden" name="eid" value="<?php echo($eid) ?>" />
		  </td>
          <td width="58" background="img/master.png">
		  <input type="submit" name="eventSubmit" value="Submit" class="btn" /></td>
        </tr>
        <tr>
          <td height="86" colspan="3" style="padding-top:10; border-top:1 solid #CCCCCC">
              <textarea name="description" rows="4" style="width:740" id="styled"></textarea>
          </td>
        </tr>
      </table>
	  </form></td>
    </tr>
</table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
