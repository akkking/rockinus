<?php 
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
include 'dbconnect.php';

if(isset($_POST['job'])){
	$tag = 0;
	$job_id = addslashes($_POST['job_id']);
	$subject = addslashes($_POST['subject']);
	$descrip = addslashes($_POST['descrip']);
	$category = addslashes($_POST['category']);
	
	if( ( $subject==NULL || strlen($subject)==0 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "What is your subject or title?";
	}
	
	if( $category=="blank" && $tag==0 ){
		$tag = 1;
		$rst_msg = "What is the category of your post?";
	} 
	
	if( ( $descrip==NULL || strlen($descrip)==0 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "No content for the post, please check";
	}
	
	session_start();
	if($tag==0){	
		$sql = "UPDATE rockinus.job_info SET subject='$subject',descrip='$descrip',category='$category' WHERE job_id='$job_id'";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$rst_msg = "Your job post has been modified and submitted successfully!";
		mysql_close($link); 
		$_SESSION['rst_msg']="<div align='center' style='width=700; padding-top:20; padding-bottom:20; margin-top:10'><strong><FONT size=4><img src=img/addsuccessIcon.jpg>&nbsp;&nbsp; $rst_msg</font></strong><br><br><br><font size=3><a href=jobDetail.php?job_id=$job_id class=one>Go Back</a></font></div>";
		//header("location:forumDetail.php?job_id=$job_id");
	}else
		$_SESSION['rst_msg']="<div align='center' style='width=500; padding-top:20; padding-bottom:20; margin-top:10'><strong><FONT size=4 color=#B92828><img src=img/stop.jpg width=18 height=18 />&nbsp;&nbsp;&nbsp;$rst_msg</font></strong><br><br><br><font size=3><a href=EditJob.php?job_id=$job_id class=one>Go Back</a></font></div>";
		header("location:jobResult.php");
	}

if(isset($_GET["job_id"])){
	$job_id = $_GET["job_id"];
	$fq = mysql_query("SELECT * FROM rockinus.job_info WHERE job_id='$job_id'");
	if(!$fq) die(mysql_error());
	$objfq = mysql_fetch_object($fq);
	$category = $objfq->category;
	$creator = $objfq->creater;
	$descrip = $objfq->descrip;
	$subject = $objfq->subject;	
}

$z = mysql_query("SELECT * FROM rockinus.user_edu_info WHERE uname='$uname'");
if(!$z) die(mysql_error());
$objz = mysql_fetch_object($z);
$cmajor = $objz->cmajor;	

$m = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid='$cmajor'");
if(!$m) die(mysql_error());
$objm = mysql_fetch_object($m);
$major_name = $objm->major_name;		
?>
<div align="center">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="300" align="left" valign="top" style="border-right:1px #DDDDDD dashed">
	  <?php include("leftHomeMenu.php"); ?>
	  </td>
      <td width="760" align="right" valign="top">
	  <?php include("HeaderEN.php"); ?>
	  <table border="0" cellspacing="0" cellpadding="0" width="740">
        <tr>
          <td align="right" valign="top" style="padding-top:0px">
		  <table width="740" height="94" border="0" cellpadding="0" cellspacing="0" style="border:1px #DDDDDD solid">
            <tr>
              <td height="34" colspan="2" align="left" bgcolor=#666666 style="padding-left:15px">&nbsp;</td>
              <td width="251" align="right" bgcolor=#666666 style="padding-right:15px">
			  <font size="3"><a href="jobList.php">Back to Job List</a></font>			  </td>
            </tr>
            <tr>
              <td width="140" height="30" align="center" bgcolor="#F5F5F5">&nbsp;</td>
              <td width="472" height="30"  align="center" bgcolor="#F5F5F5">&nbsp;</td>
              <td height="30"  align="center" bgcolor="#F5F5F5">&nbsp;</td>
              </tr>
            <tr>
              <td height="30" colspan="3" align="right">
			  <form action="EditJob.php" method="post">
                <table width="740" height="322" border="0" cellpadding="0" cellspacing="0" align="right">
                  <tr>
                    <td width="159" height="22" style="padding-left:10px" align="right">&nbsp;</td>
                    <td width="639" height="22" style="padding-left:10px">&nbsp;</td>
                  </tr>
				  <tr>
                    <td height="40" style="padding-right:10px" align="right"><strong>It is about </strong></td>
                    <td height="40" style="padding-left:10px">
					<?php // echo $cmajor.$major_name.$category ?>
					<select name="category">
                        <?php 
							$m = mysql_query("SELECT * FROM rockinus.major_info ORDER BY major_name ASC");
							if(!$m) die(mysql_error());
							while($objm = mysql_fetch_object($m)){
								$mid = $objm->mid;	
								$major_name = $objm->major_name;		
							
						//if($cmajor!=NULL && strlen($cmajor)>0){ 
						?>
						<option value="<?php echo($mid) ?>" <?php if(trim($mid)==trim($category))echo "selected"?>><?php echo($major_name) ?></option>
						<?php } ?>
                        <option value="others" <?php if(trim($mid)==trim($category))echo "selected"?>>Others</option>
                      </select>   
					  <input type="hidden" name="job_id" value=<?php echo($_GET['job_id']) ?> />               
					</td>
                  </tr>
                  <tr>
                    <td height="40" style="padding-right:10px" align="right"><strong>Subject /   Title </strong></td>
                    <td height="40" style="padding-left:10px"><input type="text" name="subject" size="65" value='<?php echo($subject) ?>'/></td>
                  </tr>
                  <tr>
                    <td height="170" style="padding-right:10px" align="right"><strong>Description </strong></td>
                    <td style="padding-left:10px; padding-top:10px" valign="top">
                      <textarea name="descrip" cols="65" rows="10"><?php echo($descrip) ?></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td height="50" style="padding-right:10px" align="right">&nbsp;</td>
                    <td style="padding-left:10px; padding-top:20px; padding-bottom:20px" valign="top">
					<input name="job" type="submit" class="btn" value=" Save " />
					</td>
                  </tr>
                </table>
              </form>
			  </td>
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
