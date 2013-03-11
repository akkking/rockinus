<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");

if(isset($_POST['news'])){
	$tag = 0;
	$news_id = addslashes($_POST['news_id']);
	$newsTitle = addslashes($_POST['newsTitle']);
	$descrip = addslashes($_POST['descrip']);
	$newsType = addslashes($_POST['newsType']);
	$rstatus = addslashes($_POST['attendOrNot']);
	
	if( ( $newsTitle==NULL || strlen($newsTitle)==0 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "What is your Notice title?";
	}
	
	if( $newsType=="blank" && $tag==0 ){
		$tag = 1;
		$rst_msg = "What is the Notice type?";
	} 
	
	if( ( $descrip==NULL || strlen($descrip)==0 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "No content for the post, please check";
	}
	
	session_start();
	if($tag==0){	
		mysql_query('set character_set_connection=gbk, character_set_results=gbk, character_set_client=binary');
		$sql = "UPDATE rockinus.news_info SET subject='$newsTitle',descrip='$descrip',category='$newsType' WHERE news_id='$news_id'";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		
		if($newsType=='seminar'||$newsType=='event'){
			$sql = "UPDATE rockinus.event_attendance SET rstatus='$rstatus' WHERE news_id='$news_id' AND uname='$uname'";
			$result = mysql_query($sql);
			if (!$result) die('Invalid query: ' . mysql_error());
		}
		
		$rst_msg = "Your post has been modified and submitted successfully";
		mysql_close($link); 
		$_SESSION['rst_msg']="<div align='center' style='width=700; padding-top:20; padding-bottom:20; margin-top:10'><strong><font size=3><img src=img/addsuccessIcon_F5.jpg width=20>&nbsp;&nbsp; $rst_msg</font></strong><br><br><font size=3><a href=newsList.php class=one>Go Back</a></font></div>";
		//header("location:forumDetail.php?news_id=$news_id");
	}else
		$_SESSION['rst_msg']="<div align='center' style='width=500; padding-top:20; padding-bottom:20; margin-top:10'><strong><font size=3 color=#B92828><img src=img/stop.jpg width=18 />&nbsp;&nbsp;&nbsp;$rst_msg</font></strong><br><br><font size=3><a href=EditForum.php?news_id=$news_id class=one>Go Back</a></font></div>";
		header("location:newsResult.php");
	}

if(isset($_GET["news_id"])){
	$news_id = $_GET["news_id"];
	mysql_query("SET NAMES GBK");
	$fq = mysql_query("SELECT * FROM rockinus.news_info WHERE news_id='$news_id'");
	if(!$fq) die(mysql_error());
	$objfq = mysql_fetch_object($fq);
	$newsType = $objfq->category;
	$creator = $objfq->creater;
	$descrip = $objfq->descrip;
	$descrip = str_replace("\\","",$descrip);
	$newsTitle = $objfq->subject;	
	$newsTitle = str_replace("\\","",$newsTitle);
	
	$attendance_q = mysql_query("SELECT * FROM rockinus.event_attendance WHERE news_id='$news_id'");
	if(!$attendance_q) die(mysql_error());
	$obj_attendance = mysql_fetch_object($attendance_q);
	$rstatus = $obj_attendance->rstatus;
}	
?>
<div align="center" style="width:100%">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="300" align="left" valign="top" style=" border-right:1 #DDDDDD dashed">
	  <?php include("leftHomeMenu.php"); ?>
	  </td>
      <td width="760" align="right" valign="top" style="padding-left:0px">
	  <?php include("HeaderEN.php"); ?>
	  <table border="0" cellspacing="0" cellpadding="0" width="740">
        <tr>
          <td width="740" align="right" valign="top">
		    <table width="740" height="64" border="0" cellpadding="0" cellspacing="0" style="border:1px #DDDDDD solid">
            <tr>
              <td width="612" height="34" align="left" background="img/master.jpg" style="padding-left:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; border-bottom:1px solid #999999">Editing Notice ...</td>
              <td width="251" align="right" background="img/master.jpg" style="padding-right:15px; font-size:13px; border-bottom:1px solid #999999; font-weight:bold;">			  </td>
            </tr>
            <tr>
              <td height="30" colspan="2" align="left" style="padding:10px" bgcolor="#F5F5F5">
			  <form action="EditNews.php" method="post">
                <table width="720" height="322" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid; border-top:0px">
                  <tr>
                    <td width="120" height="22" style="padding-left:10px" align="right">&nbsp;</td>
                    <td width="600" height="22" style="padding-left:10px">&nbsp;</td>
                  </tr>
				  <tr>
                    <td height="35" style="padding-right:10px; font-size:13px; font-family:Arial, Helvetica, sans-serif" align="right"><strong>Category </strong></td>
                    <td height="35" style="padding-left:10px">
					<select name="newsType" style="font-size:13px; font-family:Arial, Helvetica, sans-serif">
				  <option value="blank">Choose a Type</option>
				  <option value="clubrecruit" <?php if($newsType=="clubrecruit")echo(" selected")?>>Club/Group Recruitment</option>
				  <option value="event" <?php if($newsType=="event")echo(" selected")?>>Event/Activity</option>
				  <option value="lostfound" <?php if($newsType=="lostfound")echo(" selected")?>>Lost+Found</option>
				  <option value="question" <?php if($newsType=="question")echo(" selected")?>>Open question</option>
				  <option value="work" <?php if($newsType=="work")echo(" selected")?>>Part Time/Volunteer</option>
				  <option value="seminar" <?php if($newsType=="seminar")echo(" selected")?>>Seminar</option>
				  <option value="others" <?php if($newsType=="others")echo(" selected")?>>Others</option>
                      </select>     
					  <input type="hidden" name="news_id" value=<?php echo($_GET['news_id']) ?> /> 
					  &nbsp;
					  <?php if($newsType=='seminar'||$newsType=='event'){ ?>
					  <select name="attendOrNot" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; display:">		
			  <option value="Y" <?php if($rstatus=='Y')echo("selected='selected'"); ?>>I'm attending</option>
			  <option value="N" <?php if($rstatus=='N')echo("selected='selected'"); ?>>I'm not attending</option>
			  <option value="O" <?php if($rstatus=='O')echo("selected='selected'"); ?>>I'm not sure</option>
			  </select>              
			  <?php } ?>					</td>
                  </tr>
                  <tr>
                    <td height="35" style="padding-right:10px; font-size:13px; font-family:Arial, Helvetica, sans-serif" align="right"><strong>What Title? </strong></td>
                    <td height="35" style="padding-left:10px; font-size:13px; font-family:Arial, Helvetica, sans-serif"><input type="text" name="newsTitle" size="80" value='<?php echo($newsTitle) ?>' style="font-size:13px; font-family: Arial, Helvetica, sans-serif"/></td>
                  </tr>
                  <tr>
                    <td height="170" style="padding:10px; font-size:13px; font-family:Arial, Helvetica, sans-serif" align="right" valign="top">
					<strong>Description </strong></td>
                    <td style="padding-left:10px; padding-top:10px" valign="top">
                      <textarea name="descrip" cols="85" rows="15" style="font-size:13px; font-family:Arial, Helvetica, sans-serif"><?php echo($descrip) ?></textarea>                    </td>
                  </tr>
                  <tr>
                    <td height="50" style="padding-right:10px; font-size:13px; font-family:Arial, Helvetica, sans-serif" align="right">&nbsp;</td>
                    <td style="padding-left:10px; padding-top:20px; padding-bottom:20px" valign="top">
					<input name="news" type="submit" style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:0px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif" value="Submit" />					</td>
                  </tr>
                </table>
              </form>			  </td>
              </tr>
          </table>
		  </td>
        </tr>
      </table>
	  </td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
