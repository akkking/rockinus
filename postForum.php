<?php 
if(isset($_POST['forum'])){
	if(!isset($_SESSION['usrname'])){
		session_start(); 
		$uname = $_SESSION['usrname']; 
	}
	$tag = 0;
	$subject = addslashes($_POST['subject']);
	$descrip = addslashes($_POST['descrip']);
	//$descrip = mysql_real_escape_string(addslashes($_POST['descrip']));
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
	
	if($tag==0){	
		include 'dbconnect.php'; 
		$sql = "INSERT INTO rockinus.forum_info (creater,subject,descrip,category,pdate,ptime)VALUES('$uname','$subject','$descrip','$category',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$rst_msg = "Your post has been submitted successfully!";
		mysql_close($link);
		$_SESSION['rst_msg']="<div align='center' style='width=500; padding-top:20; padding-bottom:20; margin-top:10'><strong><FONT size=4><img src=img/addsuccessIcon.jpg>&nbsp;&nbsp; $rst_msg ^^</font></strong><br><br><br><font size=3><a href=openForum.php class=one>Go Back</a></font></div>"; 
	}else
	$_SESSION['rst_msg']="<div align='center' style='width=500; padding-top:20; padding-bottom:20; margin-top:10'><strong><FONT size=4 color=#B92828><img src=img/stop.jpg width=18 height=18 />&nbsp;&nbsp;&nbsp;$rst_msg</font></strong><br><br><br><font size=3><a href=postForum.php class=one>Go Back</a></font></div>"; 
	header("location:forumResult.php");
}

if(isset($_GET["recipient"])) $recipient = $_GET["recipient"];
else $recipient = "";

include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php"); 

$z = mysql_query("SELECT * FROM rockinus.user_edu_info WHERE uname='$uname'");
if(!$z) die(mysql_error());
$objz = mysql_fetch_object($z);
$cmajor = $objz->cmajor;	

if($cmajor!=NULL && strlen($cmajor)>0){
	$m = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid='$cmajor'");
	if(!$m) die(mysql_error());
	$objm = mysql_fetch_object($m);
	$major_name = $objm->major_name;		
}
?><style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
<div align="center" style="width:100%">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="300" align="left" valign="top" style="border-right:1px #DDDDDD dashed">
	  <?php include("leftHomeMenu.php"); ?>
	  </td>
      <td width="760" align="right" valign="top" style="padding-left:0px">
	  <?php include("HeaderEN.php"); ?>
	  <table border="0" cellspacing="0" cellpadding="0" width="760">
        <tr>
          <td align="right" valign="top" style="margin-right:10px; padding-left:20px; padding-top:0px">
		  <table width="740" height="94" border="0" cellpadding="0" cellspacing="0" style="border:1px #DDDDDD solid">
            <tr>
              <td width="475" height="34" align="left" background="img/master.png" style="padding-left:15px; border-bottom:1 solid #CCCCCC">&nbsp;</td>
              <td width="265" align="right" background="img/master.png" style="padding-right:15px; font-size:14px; font-weight:bold; border-bottom:1 solid #CCCCCC">
			  <a href="openForum.php" class="one"><font color="<?php echo($_SESSION['hcolor']) ?>">Back to Open Questions</font></a>			  </td>
            </tr>
            <tr>
              <td height="30" colspan="2" align="center" bgcolor="#F5F5F5" style="border-bottom:1 #DDDDDD dashed">&nbsp;</td>
              </tr>
            <tr>
              <td height="30" colspan="2" align="left" style="padding:10px">
			  <form action="" method="post">
                <table width="720" height="322" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid; border-top:0px">
                  <tr>
                    <td width="221" height="22" style="padding-left:10px" align="right">&nbsp;</td>
                    <td width="579" height="22" style="padding-left:10px">&nbsp;</td>
                  </tr>
				  <tr>
                    <td height="40" style="padding-right:10px" align="right"><strong>The question is about </strong></td>
                    <td height="40" style="padding-left:10px">
					<select name="category">
                        <?php if($cmajor!=NULL && strlen($cmajor)>0){ ?>
						<option value=<?php echo($cmajor) ?> selected="selected"><?php echo($major_name) ?></option>
						<?php } ?>
                        <option value="job">Job/Interview</option>
						<option value="car">Car/Drive</option>
						<option value="food">Food/Eating</option>
						<option value="dance">Club</option>
                        <option value="study">Study | School</option>
                        <option value="language Study">Language study</option>
                        <option value="travel">Traveling</option>
                        <option value="lostfound">Lost + Found</option>
                        <option value="suggestion">Site Suggestion</option>
						<option value="issues">Site Issue Report</option>
						<option value="others">Others</option>
                      </select>					</td>
                  </tr>
                  <tr>
                    <td height="40" style="padding-right:10px" align="right"><strong>Subject /   Title </strong></td>
                    <td height="40" style="padding-left:10px"><input type="text" name="subject" size="60"/></td>
                  </tr>
                  <tr>
                    <td height="170" style="padding-right:10; padding-top:10" align="right" valign="top"><strong>Description </strong></td>
                    <td style="padding-left:10px; padding-top:10px" valign="top">
                      <textarea name="descrip" rows="10" style="width:400"></textarea>                    </td>
                  </tr>
                  <tr>
                    <td height="50" style="padding-right:10px" align="right">&nbsp;</td>
                    <td style="padding-left:10px; padding-top:20px; padding-bottom:20px" valign="top">
					<input name="forum" type="submit" class="btn" value=" Submit " />					</td>
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
