<?php
header("Content-Type: text/html; charset=gb2312");
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];

if(isset($_POST['openComment'])){
	$tag = 0;
	$nickname = $uname;
	$descrip = addslashes($_POST['descrip']);
	
	if( ( $descrip==NULL || strlen($descrip)==0 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "No content for the post?";
	}
	
	if($tag==0){	
		include 'dbconnect.php'; 
		$sql = "INSERT INTO rockinus.open_comment_info (sender,descrip,pdate,ptime)VALUES('$nickname','$descrip',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$rst_msg = "<img src='img/addsuccessIcon_F5.jpg' width=15>&nbsp;&nbsp;Thanks, we have received your reports, and will surely improve the service.";
		//mysql_close($link);
		$_SESSION['rst_msg']="<div align='left' style='width:720; border:0px solid #EEEEEE; padding:10; margin-bottom:15; background:#F5F5F5; margin-top:10'><font size=3 color=$_SESSION[hcolor]>$rst_msg</font></div>"; 
	}else
	$_SESSION['rst_msg']="<div align='left' style='width:720; border:0 solid #DDDDDD; padding-top:5; padding-bottom:5; margin-bottom:10; background:#F5F5F5; margin-top:10'><strong><font size=3 color=#B92828>&nbsp;<img src=img/stop.jpg width=18 height=18 />&nbsp;&nbsp;&nbsp;$rst_msg</font></strong></font></div>"; 
}
?> 
<div align="center" style="width:100%; margin-top:0">
<table width="1024" height="450" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="300" valign="top" align="left" style="border-right:1px dashed #DDDDDD">
	<?php include("leftHomeMenu.php"); ?>
	</td>
    <td width="760" align="right" valign="top" style="padding-top:0">
	<?php include("HeaderEN.php") ?>
	<div style="border:0px solid #EEEEEE; margin-top:0; width:740">
      <div style="padding:25; line-height:; font-family:Arial, Helvetica, sans-serif, sans-serif; font-size:13px; border:0px solid #CCCCCC; cursor:default" align="left">
        <p style="margin-bottom:30"><strong><font size="3">Who We Are,</font></strong></p>
        <p style="line-height:200%">This network is volunteered, built by NYU-Poly Computer Science students. Currently the team consists one formal member for overall development, implementation and in-time updates. The original idea of this network is based on builder's real life experience in NYU-Poly. Meanwhile, after observing and researching a lot among other Polyers, this work has eventually been invented. Great thanks for earlier effort by Ethan Wang, Tian Liang and others as well. Without your inspirations and hard working, the site would not go this far. </p>
        <p style="margin-bottom:30; margin-top:30"> <a href="RockerDetail.php?uid=harvey"><img src="img/Aziz_AboutUs.jpg" width="150" /></a>&nbsp;&nbsp;&nbsp; <a href="RockerDetail.php?uid=yuchen"><img src="img/Ethan_AboutUs.jpg" width="150" /></a>&nbsp;&nbsp;&nbsp; <a href="RockerDetail.php?uid=liangtian"><img src="img/LiangTian_AboutUs.jpg" width="150" /></a> </p>
        <p style="margin-bottom:20"><strong><font size="3">Growing History,</font></strong></p>
        <table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="172" height="25" style="color:#000000; font-weight:normal; font-size:13px; font-family:Arial, Helvetica, sans-serif, sans-serif">Jun. 2011</td>
				<td width="448" height="25" style="font-size:13px"> Rockinus idea was conceived, after a spring semester's end</td>
          </tr>
          <tr>
            <td height="25" style="color:#000000; font-weight:normal; font-size:13px; font-family:Arial, Helvetica, sans-serif, sans-serif">Nov. 2011</td>
            <td height="25" style="font-size:13px">Conceptions and ideas were first drafted in tech paper</td>
          </tr>
          <tr>
            <td height="25" style="color:#000000; font-weight:normal; font-size:13px; font-family:Arial, Helvetica, sans-serif, sans-serif">Dec. 2011</td>
            <td height="25" style="font-size:13px">Development work started, only 1 student was involved</td>
          </tr>
          <tr>
            <td height="25" style="color:#000000; font-weight:normal; font-size:13px; font-family:Arial, Helvetica, sans-serif, sans-serif">Mar. 2012</td>
            <td height="25" style="font-size:13px">Ethan Wang was involved, developed codes and helped desigining</td>
          </tr>
          <tr>
            <td height="25" style="color:#000000; font-weight:normal; font-size:13px; font-family:Arial, Helvetica, sans-serif, sans-serif">May. 2012</td>
            <td height="25" style="font-size:13px">Development was interrupted for a month due to final exams</td>
          </tr>
          <tr>
            <td height="25" style="color:#000000; font-weight:normal; font-size:13px; font-family:Arial, Helvetica, sans-serif, sans-serif">Jun. 2012</td>
            <td height="25" style="font-size:13px"> Work resumed, only 1 student worked, in evening after internship</td>
          </tr>
          <tr>
            <td height="25" style="color:#000000; font-weight:normal; font-size:13px; font-family:Arial, Helvetica, sans-serif, sans-serif">Aug. 2012</td>
            <td height="25" style="font-size:13px">Full time on Network development, by 1 student</td>
          </tr>
          <tr>
            <td height="25" style="color:#B92828; font-weight:normal; font-size:13px; font-family:Arial, Helvetica, sans-serif, sans-serif"><span class="STYLE6">31th Aug. 2012</span></td>
            <td height="25" style="font-size:13px">Planed release date. Advertisement, marketing will follow up</td>
          </tr>
          <tr>
            <td height="25" style="color:#B92828; font-weight:normal; font-family:Arial, Helvetica, sans-serif, sans-serif">30th Sept. 2012</td>
            <td height="25" style="font-size:13px">Postpone to this date to release, due to unsuccessful testing result </td>
          </tr>
        </table>
        <p style="margin-bottom:30"> </p>
        <p style="margin-bottom: 30"> <strong><font size="3">Short writing to new  people,</font></strong> </p>
        <p style="line-height:200%">Under the thunder and storm, there is a place like home that keeps us  warm and cool.
          Before coming to university study in United States, many of us, with a simple American dream  shaped in our minds.The unknown tomorrow,  full of doubtness, thorns, estranged environments with a whole lost, all putting together baffled our march again and again. We stay alert, know that we are  young, and we keep replenishing ourselves, do what we can. Those different desires in our studies, work, lives combined with all tricky situations had determined us a disparate one. We sometimes may have been deviated. Today, standing at the point, just keep rocking to summit, cause this time would be more enjoyable and expecting.
          Rockinus dedicates your study and social life in many aspects, boosting your life as much as it could. </p>
        <p style="line-height:200%">We look forward to see your days turning great,  being considered more carefully, and that is exactly why we are here. As said, you only live once, but if you do it right, once is enough. Do, rock in U.S. </p>
        <br />
        <p style="margin-top:30px"> </p>
        <div style="margin-left:320px; margin-bottom:10px"><strong>Rockinus Team | In God's Country </strong></div>
        <div style="margin-left:320px; margin-bottom:0px; display:inline"> <a href='http://akkking.blogbus.com' class="one"> <strong><font color=<?php echo($_SESSION['hcolor']) ?> style="font-size:12px"> Check More @ Builder's Blog </font></strong> </a></div>
        </p>
      </div>
	  </div></td>
  </tr>
</table>

  </div>
  
  <div class="loginDiv" id="loginDiv"></div>
<br>
<br>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</div>
</body>
</html>
