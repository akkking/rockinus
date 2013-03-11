<?php 
include("Allfuc.php");
include 'dbconnect.php';
include 'emailfuc.php';
require("class.phpmailer.php");
session_start();
$uname = $_SESSION['usrname'];
$tag = 0;
if(isset($_POST['newsSubmit'])){
	$newsTitle = addslashes($_POST['newsTitle']);
	$newsTitle = str_replace("\\","",$newsTitle);
	$newsTitle = str_replace("'","\'",$newsTitle);
	$newsType = $_POST['newsType'];
	$rstatus = $_POST['attendOrNot'];
	$descrip = addslashes($_POST['descrip']);
	//$descrip = str_replace("\\","",$descrip);
	$descrip = str_replace("\\","",$descrip);
	$descrip = str_replace("'","\'",$descrip);
	//echo($descrip);
	
	$eventYear = $_POST['eventYear'];
	$eventMonth = $_POST['eventMonth'];
	$eventDay = $_POST['eventDay'];
	$startHour = $_POST['startHour'];
	$startampm = $_POST['startampm'];
	$startMinute = $_POST['startMinute'];
	$eventdate = "2012-12-01";
	$eventtime = "00:00:00";
	
	if(trim($newsType)=="blank"){
		$rst_msg = "You haven't select any notice category!";
		$_SESSION['newsTitle'] = $newsTitle;
		$_SESSION['notice_descrip'] = $descrip;
		$tag = 1;
	}
	
	if((trim($newsType)=="event"||trim($newsType)=="seminar")){
		if(trim($eventMonth)=="00"){
			$_SESSION['eventDay'] = $eventDay;
			$_SESSION['startHour'] = $startHour;
			$_SESSION['startampm'] = $startampm;
			$_SESSION['startMinute'] = $startMinute;
			$rst_msg = "You haven't select the start month!";
			$tag = 1;
		}
		
		if(trim($eventDay)=="00" && $tag == 0){
			$_SESSION['eventMonth'] = $eventMonth;
			$_SESSION['startHour'] = $startHour;
			$_SESSION['startampm'] = $startampm;
			$_SESSION['startMinute'] = $startMinute;
			$rst_msg = "You haven't select the start day!";
			$tag = 1;
		}
		
		if(trim($startHour)=="00" && $tag == 0){
			$_SESSION['eventMonth'] = $eventMonth;
			$_SESSION['eventDay'] = $eventDay;
			$_SESSION['startampm'] = $startampm;
			$_SESSION['startMinute'] = $startMinute;
			$rst_msg = "You haven't select the start hour!";
			$tag = 1;
		}
		
		if(trim($startampm)=="00" && $tag == 0){
			$_SESSION['eventMonth'] = $eventMonth;
			$_SESSION['eventDay'] = $eventDay;
			$_SESSION['startHour'] = $startHour;
			$_SESSION['startMinute'] = $startMinute;
			$rst_msg = "Is your event for AM or PM?";
			$tag = 1;
		}
				
		if($tag == 1){
			$_SESSION['newsType'] = "blank";
			$_SESSION['newsTitle'] = $newsTitle;
			$_SESSION['notice_descrip'] = $descrip;	
		}
	}
	
	if(strlen($newsTitle)<10 && $tag == 0){
		$rst_msg = "Title has to be leastly 10 characters!";
		$_SESSION['newsType'] = $newsType;
		$_SESSION['newsTitle'] = $newsTitle;
		$_SESSION['notice_descrip'] = $descrip;
		$tag = 1;
	}
	
	if(strlen($descrip)<50 && $tag == 0){
		$rst_msg = "Content cannot be less than 50 letters!";
		$_SESSION['newsTitle'] = $newsTitle;
		$_SESSION['notice_descrip'] = $descrip;
		$tag = 1;
	}
	
	if($tag==0){
		if($newsType=="event"||$newsType=="seminar"){
			$eventdate = $eventYear."-".$eventMonth."-".$eventDay;
			if($startampm=='PM'){ 
				$startHour += 12;
				$eventtime = $startHour.":".$startMinute.":00";
			}else 
				$eventtime = $startHour.":".$startMinute.":00";
		} 
		
		//strtotime($eventtime);
	
		//mysql_query("SET NAMES UTF8");
		mysql_query('set character_set_connection=gbk, character_set_results=gbk, character_set_client=binary');
		$upd = mysql_query("INSERT INTO rockinus.news_info (creater, subject, category, descrip, pdate, ptime,eventdate,eventtime) VALUE('$uname','$newsTitle', '$newsType', '$descrip', CURDATE(), NOW(),'$eventdate','$eventtime');");
		if(!$upd) die(mysql_error());
		//mysql_close($link);
		
		$q_event = mysql_query("SELECT news_id FROM rockinus.news_info WHERE creater='$uname' AND category='event' ORDER BY news_id DESC");
		if(!$q_event) die(mysql_error());
		$object = mysql_fetch_object($q_event);
		$event_id = $object->news_id;
		
		$result = mysql_query("INSERT INTO rockinus.event_attendance(news_id,uname,rstatus,pdate,ptime)VALUES('$event_id','$uname','$rstatus',CURDATE(), NOW())");
		if (!$result) die('Invalid query: ' . mysql_error());
		
		$q_email = mysql_query("SELECT a.email, a.uname FROM rockinus.user_check_info a JOIN rockinus.user_email_setting b ON a.uname=b.uname AND b.eventnews='Y'");
		if(!$q_email) die(mysql_error());
		while($object = mysql_fetch_object($q_email)){
			$email_list .= $object->email.";";
			$recipient_list .= $object->uname.";";
		}
		
		if(substr($email_list,strlen($email_list)-1,1)==";"){
			$email_list = substr($email_list,0,strlen($email_list)-1);
			$recipient_list = substr($recipient_list,0,strlen($recipient_list)-1);
		}	
		smtp_mail($email_list, "[Rockinus News]".$newsTitle, nl2br($descrip), "admin@rockinus.com", $recipient_list, "", ""); 
		
		$_SESSION['rst_msg']="<div align='center' style='width:680px; margin-bottom:10; padding:15px; font-size:14px'><strong><font  color=$_SESSION[hcolor]><img src=img/right_arrow.png.png width=20>&nbsp;&nbsp; Your notice has been posted successfully! <br><br><a href='newsList.php'><div align='center' style='padding:3px; width:200px; ; font-weight:bold; color:#000000'>View all campus notices</div></a></font></strong></div>"; 
		unset($_SESSION['newsType']);
		unset($_SESSION['newsTitle']);
		unset($_SESSION['notice_descrip']);
		header("location:newsResult.php");
	}else
		$_SESSION['err_rst_msg']="<div align='left' style='width:740; margin-bottom:5; padding-top:5; padding-bottom:5; font-weight:bold; background:; font-size:12px; color:#B92828'>&nbsp;&nbsp;<img src=img/stop.jpg width=10 />&nbsp;&nbsp;&nbsp;$rst_msg</div>"; 
	//header("location:createnewsResult.php");
}else{
	if(isset($_SESSION['newsType'])) unset($_SESSION['newsType']);
	if(isset($_SESSION['newsTitle'])) unset($_SESSION['newsTitle']);
	if(isset($_SESSION['rstatus'])) unset($_SESSION['rstatus']);
	if(isset($_SESSION['eventYear'])) unset($_SESSION['eventYear']);
	if(isset($_SESSION['eventMonth'])) unset($_SESSION['eventMonth']);
	if(isset($_SESSION['eventDay'])) unset($_SESSION['eventDay']);
	if(isset($_SESSION['startHour'])) unset($_SESSION['startHour']);
	if(isset($_SESSION['startampm'])) unset($_SESSION['startampm']);
	if(isset($_SESSION['startMinute'])) unset($_SESSION['startMinute']);
}
include("mainHeader.php");
?><style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
<div style="width:100%" align="center">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="center">
    <tr>
      <td align="center" valign="top" style=" padding-top:20px">
	  <?php 
			  if(isset($_SESSION['err_rst_msg'])){
					echo($_SESSION['err_rst_msg']);
					unset($_SESSION['err_rst_msg']);
			  }
			?>
	  <table width="740" height="35" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10; border:1px #CCCCCC solid; background:#EEEEEE">
	    <tr>
	      <td align='left' valign='top' style="color:#333333; padding:10; padding-bottom:7; padding-top:7; line-height:150%; font-size:11px; font-family:Arial, Helvetica, sans-serif"><strong>[Reminder]</strong> Suggest to compose in English, so everyone could understand. It's fine to post in a different language, please remember to leave a brief translation for other users convenience. We really need to be considerate, helpful and great.</td>
          </tr>
	    </table>	  <table border="0" cellspacing="0" cellpadding="0" style="border:0px #DDDDDD solid; background:; margin-bottom:10" width="740">
	    <tr>
	      <td width="740" align="right" valign="top">
	        <table width="740" height="75" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px; background:">
	          <tr>
	            <td height="32" align="center" style="color:#000000; font-size:24px"><img src="img/post.png" width="25" />&nbsp;&nbsp; Composing Campus Notice </td>
                <td width="244" height="32" align="right" valign="middle" style="border-right: 0px dotted #999999; padding-right:10;">&nbsp;			  </td>
              </tr>
	          </table>
		    <form action="createNews.php" method="post">
		      <table width="740" height="323" border="0" cellpadding="0" cellspacing="0" style=" margin-bottom:10px">
		        <tr>
		          <td width="145" height="30" align="right" valign="top" style="padding-right:10px; padding-top:5">
		            It is about				
		            
		            <div id="attendOrNotTag1" class="attendOrNotTag1" style="display:none; margin-top:15; margin-bottom:5">
		              Which Date		              </div>
				  <div id="attendOrNotTag2" class="attendOrNotTag2" style="display:none; margin-top:15; margin-bottom:5">
				    Start Time				    </div>				  </td>
                  <td width="595" height="30" valign="top" style="padding-left:10px; padding-top:5">
  <script>
$(document).ready(function() { 
	<?php 
	//if(isset($_SESSION['newsType'])&&($_SESSION['newsType']=="event"||$_SESSION['newsType']=='seminar'))
		//echo("$'#attendOrNot').show()");
	//else
		//echo("$('#attendOrNot').hide()");
	?>
	$("#attendOrNot").hide();
	$('#newsType').change(function(){
    	var selected_item = $(this).val()
		//alert("111");
    	if(selected_item == "event" || selected_item == "seminar"){
        	$('#attendOrNot').show();
			$('#attendSchedule').show();
			$('#attendTime').show();
			$('#attendOrNotTag1').show();
			$('#attendOrNotTag2').show();
    	}else{
       		$('#attendOrNot').hide();
			$('#attendSchedule').hide();
			$('#attendTime').hide();
			$('#attendOrNotTag1').hide();
			$('#attendOrNotTag2').hide();
    	}
	});
});
</script>
                    <select name="newsType" id="newsType" class="newsType" style="; font-family:Arial, Helvetica, sans-serif">
                      <option value="blank">Which category</option>
                      <option value="clubrecruit" <?php if(isset($_SESSION['newsType'])&&$_SESSION['newsType']=="clubrecruit")echo(" selected")?>>Club/Group Recruitment</option>
                      <option value="event" <?php if(isset($_SESSION['newsType'])&&$_SESSION['newsType']=="event")echo(" selected")?>>Event/Activity</option>
                      <option value="lostfound" <?php if(isset($_SESSION['newsType'])&&$_SESSION['newsType']=="lostfound")echo(" selected")?>>Lost+Found</option>
                      <option value="question" <?php if((isset($_SESSION['newsType'])&&$_SESSION['newsType']=="question")||(isset($_GET['newsType'])&&$_GET['newsType']=="question"))echo(" selected")?>>Open question/Topic</option>
                      <option value="work" <?php if(isset($_SESSION['newsType'])&&$_SESSION['newsType']=="work")echo(" selected")?>>Part Time/Volunteer</option>
                      <option value="seminar" <?php if(isset($_SESSION['newsType'])&&$_SESSION['newsType']=="seminar")echo(" selected")?>>Seminar/Lecture</option>
                      <option value="others" <?php if(isset($_SESSION['newsType'])&&$_SESSION['newsType']=="others")echo(" selected")?>>Others</option>
                      </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			  
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <div id="attendOrNot" class="attendOrNot" style="display:inline; width:300">
                      <font style="font-size:12px">Are you attending?</font>&nbsp;&nbsp;&nbsp;
                      <select name="attendOrNot" style=";  display:">		
                        <option value="Y" selected="selected">Yes</option>
                        <option value="N">No</option>
                        <option value="O">Not sure</option>
                        </select>
                      </div>
                    
                    <div id="attendSchedule" class="attendSchedule" style="display:none; margin-top:10; margin-bottom:5">
                      <select name="eventYear" style="; font-family:Arial, Helvetica, sans-serif">
                        <option value="2012" <?php if(isset($_SESSION['eventYear'])&&$_SESSION['eventYear']=="2012")echo(" selected"); ?> selected>2012</option>
                        <option value="2013" <?php if(isset($_SESSION['eventYear'])&&$_SESSION['eventYear']=="2012")echo(" selected"); ?>>2013</option>
                        </select>&nbsp;
                      <select name="eventMonth" style="; font-family:Arial, Helvetica, sans-serif">
                        <option value="00">Month</option>
                        <option value="01" <?php if(isset($_SESSION['eventMonth'])&&$_SESSION['eventMonth']=="01")echo(" selected"); ?>>January</option>
                        <option value="02" <?php if(isset($_SESSION['eventMonth'])&&$_SESSION['eventMonth']=="02")echo(" selected"); ?>>February</option>
                        <option value="03" <?php if(isset($_SESSION['eventMonth'])&&$_SESSION['eventMonth']=="03")echo(" selected"); ?>>March</option>
                        <option value="04" <?php if(isset($_SESSION['eventMonth'])&&$_SESSION['eventMonth']=="04")echo(" selected"); ?>>April</option>
                        <option value="05" <?php if(isset($_SESSION['eventMonth'])&&$_SESSION['eventMonth']=="05")echo(" selected"); ?>>May</option>
                        <option value="06" <?php if(isset($_SESSION['eventMonth'])&&$_SESSION['eventMonth']=="06")echo(" selected"); ?>>June</option>
                        <option value="07" <?php if(isset($_SESSION['eventMonth'])&&$_SESSION['eventMonth']=="07")echo(" selected"); ?>>July</option>
                        <option value="08" <?php if(isset($_SESSION['eventMonth'])&&$_SESSION['eventMonth']=="08")echo(" selected"); ?>>August</option>
                        <option value="09" <?php if(isset($_SESSION['eventMonth'])&&$_SESSION['eventMonth']=="09")echo(" selected"); ?>>September</option>
                        <option value="10" <?php if(isset($_SESSION['eventMonth'])&&$_SESSION['eventMonth']=="10")echo(" selected"); ?>>October</option>
                        <option value="11" <?php if(isset($_SESSION['eventMonth'])&&$_SESSION['eventMonth']=="11")echo(" selected"); ?>>November</option>
                        <option value="12" <?php if(isset($_SESSION['eventMonth'])&&$_SESSION['eventMonth']=="12")echo(" selected"); ?> selected>December</option>
                        </select>&nbsp;
                      <select name="eventDay" style="; font-family:Arial, Helvetica, sans-serif">
                        <option value="00">Day</option>
                        <option value="01" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="01")echo(" selected"); ?>>01</option>
                        <option value="02" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="02")echo(" selected"); ?>>02</option>
                        <option value="03" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="03")echo(" selected"); ?>>03</option>
                        <option value="04" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="04")echo(" selected"); ?>>04</option>
                        <option value="05" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="05")echo(" selected"); ?>>05</option>
                        <option value="06" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="06")echo(" selected"); ?>>06</option>
                        <option value="07" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="07")echo(" selected"); ?>>07</option>
                        <option value="08" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="08")echo(" selected"); ?>>08</option>
                        <option value="09" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="09")echo(" selected"); ?>>09</option>
                        <option value="10" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="10")echo(" selected"); ?>>10</option>
                        <option value="11" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="11")echo(" selected"); ?>>11</option>
                        <option value="12" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="12")echo(" selected"); ?>>12</option>
                        <option value="13" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="13")echo(" selected"); ?>>13</option>
                        <option value="14" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="14")echo(" selected"); ?>>14</option>
                        <option value="15" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="15")echo(" selected"); ?>>15</option>
                        <option value="16" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="16")echo(" selected"); ?>>16</option>
                        <option value="17" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="17")echo(" selected"); ?>>17</option>
                        <option value="18" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="18")echo(" selected"); ?>>18</option>
                        <option value="19" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="19")echo(" selected"); ?>>19</option>
                        <option value="20" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="20")echo(" selected"); ?>>20</option>
                        <option value="21" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="21")echo(" selected"); ?>>21</option>
                        <option value="22" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="22")echo(" selected"); ?>>22</option>
                        <option value="23" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="23")echo(" selected"); ?>>23</option>
                        <option value="24" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="24")echo(" selected"); ?>>24</option>
                        <option value="25" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="25")echo(" selected"); ?>>25</option>
                        <option value="26" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="26")echo(" selected"); ?>>26</option>
                        <option value="27" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="27")echo(" selected"); ?>>27</option>
                        <option value="28" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="28")echo(" selected"); ?>>28</option>
                        <option value="29" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="29")echo(" selected"); ?>>29</option>
                        <option value="30" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="30")echo(" selected"); ?>>30</option>
                        <option value="31" <?php if(isset($_SESSION['eventDay'])&&$_SESSION['eventDay']=="31")echo(" selected"); ?>>31</option>
                        </select>
&nbsp;&nbsp;                      </div>
			    
			  <div id="attendTime" class="attendTime" style="display:none; margin-top:10; margin-bottom:5">
			    <select name="startampm">
			      <option value="AM" <?php if(isset($_SESSION['startampm'])&&$_SESSION['startampm']=="AM")echo(" selected"); ?>>A.M.</option>
			      <option value="PM" <?php if(isset($_SESSION['startampm'])&&$_SESSION['startampm']=="PM")echo(" selected"); ?>>P.M.</option>
			      </select>&nbsp;
			    <select name="startHour">
			      <option value="0" <?php if(isset($_SESSION['startHour'])&&$_SESSION['startHour']=="01")echo(" selected"); ?>>Hour</option>
			      <option value="1" <?php if(isset($_SESSION['startHour'])&&$_SESSION['startHour']=="1")echo(" selected"); ?>>01</option>
			      <option value="2" <?php if(isset($_SESSION['startHour'])&&$_SESSION['startHour']=="2")echo(" selected"); ?>>02</option>
			      <option value="3" <?php if(isset($_SESSION['startHour'])&&$_SESSION['startHour']=="3")echo(" selected"); ?>>03</option>
			      <option value="4" <?php if(isset($_SESSION['startHour'])&&$_SESSION['startHour']=="4")echo(" selected"); ?>>04</option>
			      <option value="5" <?php if(isset($_SESSION['startHour'])&&$_SESSION['startHour']=="5")echo(" selected"); ?>>05</option>
			      <option value="6" <?php if(isset($_SESSION['startHour'])&&$_SESSION['startHour']=="6")echo(" selected"); ?>>06</option>
			      <option value="7" <?php if(isset($_SESSION['startHour'])&&$_SESSION['startHour']=="7")echo(" selected"); ?>>07</option>
			      <option value="8" <?php if(isset($_SESSION['startHour'])&&$_SESSION['startHour']=="8")echo(" selected"); ?>>08</option>
			      <option value="09" <?php if(isset($_SESSION['startHour'])&&$_SESSION['startHour']=="9")echo(" selected"); ?>>09</option>
			      <option value="10" <?php if(isset($_SESSION['startHour'])&&$_SESSION['startHour']=="10")echo(" selected"); ?>>10</option>
			      <option value="11" <?php if(isset($_SESSION['startHour'])&&$_SESSION['startHour']=="11")echo(" selected"); ?>>11</option>
			      <option value="12" <?php if(isset($_SESSION['startHour'])&&$_SESSION['startHour']=="12")echo(" selected"); ?>>12</option>
			      </select>&nbsp;
			    <select name="startMinute">
			      <option value="00" <?php if(isset($_SESSION['startMinute'])&&$_SESSION['startMinute']=="00")echo(" selected"); ?>>00</option>
			      <option value="15" <?php if(isset($_SESSION['startMinute'])&&$_SESSION['startMinute']=="15")echo(" selected"); ?>>15</option>
			      <option value="30" <?php if(isset($_SESSION['startMinute'])&&$_SESSION['startMinute']=="30")echo(" selected"); ?>>30</option>
			      <option value="45" <?php if(isset($_SESSION['startMinute'])&&$_SESSION['startMinute']=="45")echo(" selected"); ?>>45</option>
			      </select>
			    </div>			    </td>
			    </tr>
		        <tr>
		          <td height="30" style="padding-right:10px; ; font-family:Arial, Helvetica, sans-serif" align="right">
		            Write a Title				</td>
                  <td height="30" style="padding-left:10px">
                    <input type="text" name="newsTitle" size="74" value="<?php if(isset($_SESSION['newsTitle']))echo($_SESSION['newsTitle']) ?>" style="; font-family:Arial, Helvetica, sans-serif"/></td>
                </tr>
		        <tr>
		          <td height="183" style="padding-right:10; padding-top:10; ; font-family:Arial, Helvetica, sans-serif" align="right" valign="top">
		            Description				</td>
                  <td style="padding-left:10px; padding-top:10" valign="top"><label>
                    <textarea name="descrip" rows="15" style="width:480;  ; line-height:130%; padding:4px;"><?php if(isset($_SESSION['notice_descrip']))echo($_SESSION['notice_descrip']) ?></textarea>
                    </label></td>
                </tr>
		        <tr>
		          <td height="80" style="padding-right:10px" align="right">&nbsp;</td>
                  <td height="80" valign="top" style="padding-left:10px; padding-top:20">
                    <input type="submit" value="Submit" name="newsSubmit" style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:1px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif" />				</td>
                </tr>
		        </table>
			  </form>		    </td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
