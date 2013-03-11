<?php 
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
include 'dbconnect.php';

$tag = 0;
if(isset($_POST['eventSubmit'])){
	$eventTitle = addslashes($_POST['eventTitle']);
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
	
	if(strlen($eventSpot)<5){
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
		$upd = mysql_query("INSERT INTO rockinus.event_info (creater, eventTitle, unameList, eventDate, eventSpot, from_time, to_time, eventType, descrip, pdate, ptime, tbname) VALUE('$uname','$eventTitle', '$unameList', '$eventDate', '$eventSpot', '$from_time','$to_time', '$eventType', '$descrip', CURDATE(), NOW(), 'event_info');");
		if(!$upd) die(mysql_error());
		//mysql_close($link);
		$_SESSION['comment_rst_msg']="<div align='center' style='width=750;'><strong><FONT size=4 color=$_SESSION[hcolor]><img src=img/addsuccessIcon.jpg>&nbsp;&nbsp;Your Event has been posted successfully!<br><br><a href=eventList.php class=one>See Event List</a></font></strong><br></div>"; 
	}else
		$_SESSION['comment_rst_msg']="<div align='center' style='width=750;'><strong><FONT size=4 color=#B92828><img src=img/stop.jpg width=18 height=18 />&nbsp;&nbsp;&nbsp;$rst_msg</font></strong><br></div>"; 
	//header("location:createEventResult.php");
}
?>
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="center">
    <tr>
      <td width="300" align="left" valign="top" style="border-right:1 #DDDDDD dashed">
	  <?php include("leftHomeMenu.php"); ?>	  </td>
      <td width="760" align="right" valign="top" style=" border:#CCCCCC solid 0; padding-left:0; padding-right:0">
	  <?php include("HeaderEN.php"); ?>
	  <table border="0" cellspacing="0" cellpadding="0" style="border-left:0px #CCCCCC dotted" width="740">
        <tr>
          <td width="740" align="right" valign="top">
		    
              <?php if(isset($_SESSION['comment_rst_msg'])){
						echo ("<div style='padding:20; width:850; border:#999999 solid 4; background-color:#F5F5F5; margin-top:0px; margin-bottom:15px'>".$_SESSION['comment_rst_msg']."</div>"); 
						unset($_SESSION['comment_rst_msg']);
					}
			?>
		    <table width="740" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:#CCCCCC solid 1; margin-bottom:-2px">
            <tr>
              <td height="35" align="left" background="img/master.png" style="padding-left:15;"><strong>Creating an Event...</strong> </td>
              <td width="244" height="35" align="right" valign="middle" background="img/master.png" style="border-right: 0px dotted #999999; padding-right:10;">
			  <a href="eventList.php" class="one"><strong>Go to Event list</strong></a>			  </td>
            </tr>
          </table>
		  <form action="createEvent.php" method="post">
            <table width="740" height="538" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid; border-top:0px">
              <tr>
                <td width="164" height="22" style="padding-left:10px" align="right">&nbsp;</td>
                <td width="574" height="22" style="padding-left:10px">&nbsp;</td>
              </tr>
              
              <tr>
                <td height="40" style="padding-right:10px" align="right"><strong>The Event Title </strong></td>
                <td height="40" style="padding-left:10px"><input type="text" name="eventTitle" size="65"/></td>
              </tr>
              <tr>
                <td height="40" style="padding-right:10px" align="right"><strong>Invitee List </strong></td>
                <td height="40" style="padding-left:10px"><input type="text" name="unameList" size="65"/></td>
              </tr>
              <tr>
                <td height="40" style="padding-right:10px" align="right"><strong>Event Date</strong></td>
                <td height="40" style="padding-left:10px"><input type="text" class="calendarSelectDate" name="eventDate" size="10"/>
				<div id="calendarDiv"></div>				</td>
              </tr>
              <tr>
                <td height="40" style="padding-right:10px" align="right"><strong>From </strong></td>
                <td height="40" style="padding-left:10px">
                  <select name="from_hour">
				  <option value="0">Hour</option>
				  <option value="1">01</option>
				  <option value="2">02 </option>
				  <option value="3">03</option>
				  <option value="4">04</option>
				  <option value="5">05</option>
				  <option value="6">06</option>
				  <option value="7">07</option>
				  <option value="8">08</option>
				  <option value="9">09</option>
				  <option value="10">10</option>
				  <option value="11">11</option>
				  <option value="12">12</option>
                  </select> <select name="from_ampm">
				  <option value="AM">A.M.</option>
				  <option value="PM">P.M.</option>
				  </select>
				  <select name="from_minute">
				  <option value="00">00</option>
				  <option value="15">15</option>
				  <option value="30">30</option>
				  <option value="45">45</option>
                  </select>                </td>
              </tr>
              <tr>
                <td height="40" style="padding-right:10px" align="right"><strong>To</strong></td>
                <td height="40" style="padding-left:10px">
				<select name="to_hour">
                    <option value="0">Hour</option>
                    <option value="1">01</option>
                    <option value="2">02 </option>
                    <option value="3">03</option>
                    <option value="4">04</option>
                    <option value="5">05</option>
                    <option value="6">06</option>
                    <option value="7">07</option>
                    <option value="8">08</option>
                    <option value="9">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                  </select>
                    <select name="to_ampm">
                      <option value="AM">A.M.</option>
                      <option value="PM">P.M.</option>
                    </select>
                    <select name="to_minute">
                      <option value="00">00</option>
                      <option value="15">15</option>
                      <option value="30">30</option>
                      <option value="45">45</option>
                    </select>					</td>
              </tr>
              <tr>
				  <td height="40" style="padding-right:10px" align="right"><strong>Where </strong></td>
                <td height="40" style="padding-left:10px"><input type="text" name="eventSpot" class="box" size="50"/></td>
              </tr>
              <tr>
                <td height="40" style="padding-right:10px" align="right"><strong>It's about </strong></td>
                <td height="40" style="padding-left:10px">
				  <select name="eventType">
				  <option value="blank">Category</option>
				  <option value="soccer">Soccer</option>
				  <option value="cycling">Cycling</option>
				  <option value="basketball">Basketball</option>
				  <option value="swimming">Swimming</option>
				  <option value="cricket">Cricket</option>
				  <option value="food">Food/eating</option>
				  <option value="jobs">Jobs</option>
				  <option value="car">Car</option>
				  <option value="clothes">Clothes</option>
				  <option value="travel">Travel</option>
				  <option value="house">House</option>
				  <option value="shopping">Shopping</option>
				  <option value="movie">Movie</option>
				  <option value="music">Music</option>
				  <option value="dance">Dance</option>
				  <option value="market">Flea Market</option>
				  <option value="major">My major</option>
              </select>			  </td>
			  </tr>
              <tr>
                <td height="170" style="padding-right:10px" align="right"><strong>Description </strong></td>
                <td style="padding-left:10px; padding-top:10px" valign="top"><label>
                  <textarea name="descrip" cols="65" rows="10" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px"></textarea>
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
