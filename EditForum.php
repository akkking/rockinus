<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");

if(isset($_POST['forum'])){
	$tag = 0;
	$foid = addslashes($_POST['foid']);
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
		$sql = "UPDATE rockinus.forum_info SET subject='$subject',descrip='$descrip',category='$category' WHERE foid='$foid'";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$rst_msg = "Your post has been modified and submitted successfully";
		mysql_close($link); 
		$_SESSION['rst_msg']="<div align='center' style='width=700; padding-top:20; padding-bottom:20; margin-top:10'><strong><font size=3><img src=img/addsuccessIcon_F5.jpg width=20>&nbsp;&nbsp; $rst_msg</font></strong><br><br><font size=3><a href=forumDetail.php?foid=$foid class=one>Go Back</a></font></div>";
		//header("location:forumDetail.php?foid=$foid");
	}else
	
		$_SESSION['rst_msg']="<div align='center' style='width=500; padding-top:20; padding-bottom:20; margin-top:10'><strong><font size=3 color=#B92828><img src=img/stop.jpg width=18 />&nbsp;&nbsp;&nbsp;$rst_msg</font></strong><br><br><font size=3><a href=EditForum.php?foid=$foid class=one>Go Back</a></font></div>";
		header("location:forumResult.php");
	}

if(isset($_GET["foid"])){
	$foid = $_GET["foid"];
	$fq = mysql_query("SELECT * FROM rockinus.forum_info WHERE foid='$foid'");
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
		    <table width="740" height="94" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid">
            <tr>
              <td height="34" colspan="2" align="left" background="img/master.png" style="padding-left:15px; border-bottom:1 solid #CCCCCC">&nbsp;</td>
              <td width="251" align="right" background="img/master.png" style="padding-right:15px; font-size:14px; border-bottom:1 solid #CCCCCC; font-weight:bold;">
			  <a href="openForum.php" class="one"><font color="<?php echo($_SESSION['hcolor']) ?>">Back to Open Forum</font></a>
			  </td>
            </tr>
            <tr>
              <td width="140" height="30" align="center" bgcolor="#F5F5F5">&nbsp;</td>
              <td width="472" height="30"  align="center" bgcolor="#F5F5F5">&nbsp;</td>
              <td height="30"  align="center" bgcolor="#F5F5F5">&nbsp;</td>
              </tr>
            <tr>
              <td height="30" colspan="3" align="left" style="padding:10px">
			  <form action="" method="post">
                <table width="740" height="322" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid; border-top:0px">
                  <tr>
                    <td width="159" height="22" style="padding-left:10px" align="right">&nbsp;</td>
                    <td width="639" height="22" style="padding-left:10px">&nbsp;</td>
                  </tr>
				  <tr>
                    <td height="40" style="padding-right:10px" align="right"><strong>It is about </strong></td>
                    <td height="40" style="padding-left:10px">
					<?php // echo $cmajor.$major_name.$category ?>
					<select name="category">
                        <option value=<?php echo($cmajor) ?> <?php if($category==$major_name)echo("selected") ?>><?php echo($major_name) ?></option>
                        <option value="Job" <?php if($category=="Job")echo("selected") ?>>Job/Interview</option>
                        <option value="Study" <?php if($category=="Study")echo("selected") ?>>Study | School</option>
                        <option value="Language Study" <?php if($category=="Study")echo("selected") ?>>Language study</option>
                        <option value="Travel" <?php if($category=="Study")echo("selected") ?>>Travel</option>
                        <option value="Suggestion" <?php if($category=="Study")echo("selected") ?>>Site Suggestion</option>
						<option value="Issues" <?php if($category=="Study")echo("selected") ?>>Site Issue Report</option>
                        <option value="Others" <?php if($category=="Others")echo("selected") ?>>Others</option>
                      </select>     
					  <input type="hidden" name="foid" value=<?php echo($_GET['foid']) ?> />               
					</td>
                  </tr>
                  <tr>
                    <td height="40" style="padding-right:10px" align="right"><strong>Subject /   Title </strong></td>
                    <td height="40" style="padding-left:10px"><input type="text" name="subject" size="65" value='<?php echo($subject) ?>'/></td>
                  </tr>
                  <tr>
                    <td height="170" style="padding-right:10px" align="right"><strong>Description </strong></td>
                    <td style="padding-left:10px; padding-top:10px" valign="top">
                      <textarea name="descrip" cols="65" rows="10" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><?php echo($descrip) ?></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td height="50" style="padding-right:10px" align="right">&nbsp;</td>
                    <td style="padding-left:10px; padding-top:20px; padding-bottom:20px" valign="top">
					<input name="forum" type="submit" class="btn" value=" Save " />
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
