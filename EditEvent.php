<?php 
include("Header.php"); 

$tag = 0;

if(isset($_POST['eventSubmit'])){
	$eventTitle = addslashes($_POST['eventTitle']);
	$eid = $_POST['eid'];
	$pageName = $_POST['pageName'];
	$unameList = $_POST['unameList'];
	$from_hour = $_POST['from_hour'];
	$from_ampm = $_POST['from_ampm'];
	$from_minute = $_POST['from_minute'];
	$to_hour = $_POST['to_hour'];
	$to_ampm = $_POST['to_ampm'];
	$to_minute = $_POST['to_minute'];
	$eventType = $_POST['eventType'];
	$eventSpot = $_POST['eventSpot'];
	$eventDate = $_POST['eventDate'];
	$eventDate = date("Y-m-d", strtotime($eventDate));
	$descrip = addslashes($_POST['descrip']);
	
	if(strlen($eventTitle)<5){
		$rst_msg = "Your event title is too short!";
		$tag = 1;
	}
	
	if(strlen($eventTitle)<5){
		$rst_msg = "Your event place is not clear enough!";
		$tag = 1;
	}
	
	if($from_hour=="0") {
		$rst_msg = "You haven't set the beginning hour of the event!";
		$tag=1;
	}
	if($to_hour=="0" && $tag==0) {
		$rst_msg = "You haven't set the ending hour of the event!";
		$tag=1;
	}
	if($from_minute=="Any" && $tag==0) {
		$rst_msg = "You haven't set the beginning minute of the event!";
		$tag=1;
	}
	if($to_minute=="Any" && $tag==0) {
		$rst_msg = "You haven't set the ending hour of the event!";
		$tag=1;
	}
	
	if($from_ampm=="PM") $from_hour+=12;
	if($to_ampm=="PM") $to_hour+=12;
	$from_time = $from_hour.":".$from_minute.":00";
	$to_time = $to_hour.":".$to_minute.":00";
	
	if(trim($eventType)=="blank"){
		$_SESSION['rst_msg'] = "Please select your event type!";
		$tag = 1;
	}
	
	if($tag==0){
		
		$upd = mysql_query("UPDATE rockinus.event_info SET eventTitle='$eventTitle', unameList='$unameList', eventDate='$eventDate', eventSpot='$eventSpot', from_time='$from_time', to_time='$to_time', eventType='$eventType', descrip='$descrip', pdate=CURDATE(), ptime=NOW() WHERE eid='$eid';");
		if(!$upd) die(mysql_error());
		//mysql_close($link);
		$_SESSION['comment_rst_msg']="<div align='center' style='width=750;'><strong><FONT size=4 color=$_SESSION[hcolor]><img src=img/addsuccessIcon.jpg>&nbsp;&nbsp;Your Event has been updated successfully!<br><br><a href=$pageName.php class=one>Go Back</a></font></strong><br></div>"; 
		//header("location:eventResult.php");
	}else
		$_SESSION['comment_rst_msg']="<div align='center' style='width=750;'><strong><FONT size=4 color=#B92828><img src=img/stop.jpg width=18 height=18 />&nbsp;&nbsp;&nbsp;$rst_msg</font></strong><br></div>"; 
	//header("location:eventResult.php");
}

if(isset($_GET["eid"])&&isset($_GET["pageName"])){
	$eid = $_GET["eid"];
	$pageName = $_GET["pageName"];
	$fq = mysql_query("SELECT * FROM rockinus.event_info WHERE eid='$eid'");
	if(!$fq) die(mysql_error());
	$objevent = mysql_fetch_object($fq);
	$eventType = $objevent->eventType;
	$descrip = $objevent->descrip;
	$eventTitle = $objevent->eventTitle;	
	$unameList = $objevent->unameList;
	$eventDate = $objevent->eventDate;
	$eventSpot = $objevent->eventSpot;
	$from_time = $objevent->from_time;	
	$to_time = $objevent->to_time;	
	$pdate = $objevent->pdate;	
	$ptime = $objevent->ptime;	
	
	$array_from_time = explode(":", $from_time);
	$from_hour = $array_from_time[0];
	$from_minute = $array_from_time[1];

	$array_to_time = explode(":", $to_time);
	$to_hour = $array_to_time[0];
	$to_minute = $array_to_time[1];
	
	if($from_hour>12){
		$from_ampm="PM";
		$from_hour -= 12;
	}else 
		$from_ampm="AM";
	
	if($to_hour>12){
		$to_ampm="PM";
		$to_hour -= 12;
	}else 
		$to_ampm="AM";
}


$ua=getBrowser();
?>
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="120" align="left" valign="top" style="padding-left:2px; border-left:0px #EEEEEE solid">
	  <?php include("leftMenu".$_SESSION['lan'].".php"); ?>	  </td>
      <td width="876" align="left" valign="top" style=" border:#CCCCCC solid 0; padding-left:0; padding-right:0">
	  <table border="0" cellspacing="0" cellpadding="0" style="border-left:0px #CCCCCC dotted" width="876">
        <tr>
          <td align="center" valign="top" style="margin-right:15px; margin-left:10px;">
		    
              <?php if(isset($_SESSION['comment_rst_msg'])){
						echo ("<div style='padding:20; width:850; border:#999999 solid 4; background-color:#F5F5F5; margin-top:0px; margin-bottom:15px'>".$_SESSION['comment_rst_msg']."</div>"); 
						unset($_SESSION['comment_rst_msg']);
					}
			?>
		    <table width="850" height="40" border="0" cellpadding="0" cellspacing="0" bgcolor="<?php echo($_SESSION['hcolor']) ?>" style="border:#CCCCCC dotted 0; margin-bottom:-2px">
            <tr>
              <td width="230" height="50" align="left" style="padding-left:20px; padding-bottom:2px"><strong><font size="4" color="#FFFFFF">Create an Event</font></strong> </td>
              <td width="376" height="50" align="left" valign="middle" style="padding-right:10">&nbsp;</td>
              <td width="244" height="50" align="right" valign="middle" style="border-right: 0px dotted #999999; padding-right:15px;">
			  <a href="eventList.php" class="one"><strong><font size="4" color="#FFFFFF">Go to Event list</font></strong></a>
			  </td>
            </tr>
          </table>
		  <form action="EditEvent.php" method="post">
            <table width="850" height="538" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border:1px #DDDDDD solid; border-top:0px">
              <tr>
                <td width="159" height="22" style="padding-left:10px" align="right">&nbsp;</td>
                <td width="639" height="22" style="padding-left:10px">&nbsp;</td>
              </tr>
              
              <tr>
                <td height="40" style="padding-right:10px" align="right"><strong>The Event Title </strong></td>
                <td height="40" style="padding-left:10px">
				<input type="text" name="eventTitle" size="65" value='<?php echo($eventTitle) ?>' />
				<input type="hidden" name="eid" value='<?php echo($eid) ?>' />
				<input type="hidden" name="pageName" value='<?php echo($pageName) ?>'
				</td>
              </tr>
              <tr>
                <td height="40" style="padding-right:10px" align="right"><strong>Invitee List </strong></td>
                <td height="40" style="padding-left:10px"><input type="text" name="unameList" size="65" value='<?php echo($unameList) ?>' /></td>
              </tr>
              <tr>
                <td height="40" style="padding-right:10px" align="right"><strong>Event Date</strong></td>
                <td height="40" style="padding-left:10px"><input type="text" class="calendarSelectDate" name="eventDate" size="10" value='<?php echo($eventDate) ?>' />
				<div id="calendarDiv"></div>				</td>
              </tr>
              <tr>
                <td height="40" style="padding-right:10px" align="right"><strong>From </strong></td>
                <td height="40" style="padding-left:10px">
                  <select name="from_hour">
				  <option value="0">Hour</option>
				  <option value="1" <?php if($from_hour=="1")echo("selected") ?>>01</option>
				  <option value="2" <?php if($from_hour=="2")echo("selected") ?>>02 </option>
				  <option value="3" <?php if($from_hour=="3")echo("selected") ?>>03</option>
				  <option value="4" <?php if($from_hour=="4")echo("selected") ?>>04</option>
				  <option value="5" <?php if($from_hour=="5")echo("selected") ?>>05</option>
				  <option value="6" <?php if($from_hour=="6")echo("selected") ?>>06</option>
				  <option value="7" <?php if($from_hour=="7")echo("selected") ?>>07</option>
				  <option value="8" <?php if($from_hour=="8")echo("selected") ?>>08</option>
				  <option value="9" <?php if($from_hour=="9")echo("selected") ?>>09</option>
				  <option value="10" <?php if($from_hour=="10")echo("selected") ?>>10</option>
				  <option value="11" <?php if($from_hour=="11")echo("selected") ?>>11</option>
				  <option value="12" <?php if($from_hour=="12")echo("selected") ?>>12</option>
                  </select> <select name="from_ampm">
				  <option value="AM" <?php if($from_ampm=="AM")echo("selected") ?>>A.M.</option>
				  <option value="PM" <?php if($from_ampm=="PM")echo("selected") ?>>P.M.</option>
				  </select>
				  <select name="from_minute">
				  <option value="00" <?php if($from_minute=="00")echo("selected") ?>>00</option>
				  <option value="15" <?php if($from_minute=="15")echo("selected") ?>>15</option>
				  <option value="30" <?php if($from_minute=="30")echo("selected") ?>>30</option>
				  <option value="45" <?php if($from_minute=="45")echo("selected") ?>>45</option>
                  </select>                
				  </td>
              </tr>
              <tr>
                <td height="40" style="padding-right:10px" align="right"><strong>To</strong></td>
                <td height="40" style="padding-left:10px">
				<select name="to_hour">
                    <option value="0">Hour</option>
                    <option value="1" <?php if($to_hour=="1")echo("selected") ?>>01</option>
                    <option value="2" <?php if($to_hour=="2")echo("selected") ?>>02 </option>
                    <option value="3" <?php if($to_hour=="3")echo("selected") ?>>03</option>
                    <option value="4" <?php if($to_hour=="4")echo("selected") ?>>04</option>
                    <option value="5" <?php if($to_hour=="5")echo("selected") ?>>05</option>
                    <option value="6" <?php if($to_hour=="6")echo("selected") ?>>06</option>
                    <option value="7" <?php if($to_hour=="7")echo("selected") ?>>07</option>
                    <option value="8" <?php if($to_hour=="8")echo("selected") ?>>08</option>
                    <option value="9" <?php if($to_hour=="9")echo("selected") ?>>09</option>
                    <option value="10" <?php if($to_hour=="10")echo("selected") ?>>10</option>
                    <option value="11" <?php if($to_hour=="11")echo("selected") ?>>11</option>
                    <option value="12" <?php if($to_hour=="12")echo("selected") ?>>12</option>
                  </select>
                    <select name="to_ampm">
                      <option value="AM" <?php if($to_ampm=="AM")echo("selected") ?>>A.M.</option>
                      <option value="PM" <?php if($to_ampm=="PM")echo("selected") ?>>P.M.</option>
                    </select>
                    <select name="to_minute">
                      <option value="00" <?php if($to_minute=="00")echo("selected") ?>>00</option>
                      <option value="15" <?php if($to_minute=="15")echo("selected") ?>>15</option>
                      <option value="30" <?php if($to_minute=="30")echo("selected") ?>>30</option>
                      <option value="45" <?php if($to_minute=="45")echo("selected") ?>>45</option>
                    </select>					</td>
              </tr>
              <tr>
				  <td height="40" style="padding-right:10px" align="right"><strong>Where </strong></td>
                <td height="40" style="padding-left:10px"><input type="text" name="eventSpot" value='<?php echo($eventSpot) ?>' size="50"/></td>
              </tr>
              <tr>
                <td height="40" style="padding-right:10px" align="right"><strong>It's about </strong></td>
                <td height="40" style="padding-left:10px">
				  <select name="eventType">
				  <option value="blank">Category</option>
				  <option value="soccer" <?php if($eventType=="soccer")echo("selected") ?>>Soccer</option>
				  <option value="cycling" <?php if($eventType=="cycling")echo("selected") ?>>Cycling</option>
				  <option value="basketball" <?php if($eventType=="basketball")echo("selected") ?>>Basketball</option>
				  <option value="swimming" <?php if($eventType=="swimming")echo("selected") ?>>Swimming</option>
				  <option value="cricket" <?php if($eventType=="cricket")echo("selected") ?>>Cricket</option>
				  <option value="food" <?php if($eventType=="food")echo("selected") ?>>Food/eating</option>
				  <option value="jobs" <?php if($eventType=="job")echo("jobs") ?>>Jobs</option>
				  <option value="car" <?php if($eventType=="car")echo("selected") ?>>Car</option>
				  <option value="clothes" <?php if($eventType=="clothes")echo("selected") ?>>Clothes</option>
				  <option value="travel" <?php if($eventType=="travel")echo("selected") ?>>Travel</option>
				  <option value="house" <?php if($eventType=="house")echo("selected") ?>>House</option>
				  <option value="shopping" <?php if($eventType=="shopping")echo("selected") ?>>Shopping</option>
				  <option value="movie" <?php if($eventType=="movie")echo("selected") ?>>Movie</option>
				  <option value="music" <?php if($eventType=="music")echo("selected") ?>>Music</option>
				  <option value="dance" <?php if($eventType=="dance")echo("selected") ?>>Dance</option>
				  <option value="market" <?php if($eventType=="market")echo("selected") ?>>Flea Market</option>
				  <option value="major" <?php if($eventType=="major")echo("selected") ?>>My major</option>
              </select>			  
			  </td>
			  </tr>
              <tr>
                <td height="170" style="padding-right:10px" align="right"><strong>Description </strong></td>
                <td style="padding-left:10px; padding-top:10px" valign="top"><label>
                  <textarea name="descrip" cols="65" rows="10"><?php echo($descrip) ?></textarea>
                </label></td>
              </tr>
              <tr>
                <td height="50" style="padding-right:10px" align="right">&nbsp;</td>
                <td style="padding-left:10px; padding-top:10px" valign="top">
				<input type="submit" value=" Submit " name="eventSubmit" class="btn" />				</td>
              </tr>
            </table>
			</form>
		  </td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
