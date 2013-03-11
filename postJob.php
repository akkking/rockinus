<?php 
if(isset($_POST['job'])){
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
		$rst_msg = "Which category this job about?";
	} 
	
	if( ( $descrip==NULL || strlen($descrip)<50 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "Job description has to be more than 50 letters";
	}
	
	if($tag==0){	
		include 'dbconnect.php'; 
		$sql = "INSERT INTO rockinus.job_info (creater,subject,descrip,category,rstatus,pdate,ptime)VALUES('$uname','$subject','$descrip','$category','Y',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$rst_msg = "Your job post has been submitted successfully!";
		mysql_close($link);
		$_SESSION['rst_msg']="<div align='center' style='width=500; padding-top:20; padding-bottom:20; margin-top:10'><strong><FONT size=4><img src=img/addsuccessIcon.jpg>&nbsp;&nbsp; $rst_msg ^^</font></strong><br><br><br><font size=3><a href=jobList.php class=one>Go Back</a></font></div>"; 
	}else
	$_SESSION['rst_msg']="<div align='center' style='width=500; padding-top:20; padding-bottom:20; margin-top:10'><strong><FONT size=4 color=#B92828><img src=img/stop.jpg width=18 height=18 />&nbsp;&nbsp;&nbsp;$rst_msg</font></strong><br><br><br><font size=3><a href=postForum.php class=one>Go Back</a></font></div>"; 
	header("location:jobResult.php");
}

if(isset($_GET["recipient"])) $recipient = $_GET["recipient"];
else $recipient = "";

include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];

$z = mysql_query("SELECT * FROM rockinus.user_edu_info WHERE uname='$uname'");
if(!$z) die(mysql_error());
$objz = mysql_fetch_object($z);
$cmajor = $objz->cmajor;	

if($cmajor!=NULL && strlen($cmajor)>0){
	$m = mysql_query("SELECT major_name FROM rockinus.major_info");
	if(!$m) die(mysql_error());
	$objm = mysql_fetch_object($m);
	$major_name = $objm->major_name;		
}

include 'mainHeader.php';
?><style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
<div style="width:100%" align="center">
  <table width="1024" height="530" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="291" align="left" valign="top" style=" padding:0px 0 25px 15px">
	  <?php
	  include "jobMenu.php";
	  ?>
	  </td>
      <td width="733" align="center" valign="top" style=" padding-top:25px; padding-bottom:25px"><table border="0" cellspacing="0" cellpadding="0" width="700">
        <tr>
          <td align="center" valign="top" width="760"><table width="702" height="60" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid">
              <tr>
                <td width="702" height="45" align="left" bgcolor="" style="border-bottom:0px solid #CCCCCC; font-size:28px; padding-left:35px"><img src="img/yellowCase.png" width="25" />&nbsp;&nbsp; Post Job Position</td>
              </tr>
              <tr>
                <td height="30" align="center"><form action="postJob.php" method="post">
                    <table width="700" height="322" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid; border-top:0px">
                      <tr>
                        <td width="159" height="22" style="padding-left:10px" align="right">&nbsp;</td>
                        <td width="639" height="22" style="padding-left:10px">&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="40" style="padding-right:10px" align="right">Hiring field </td>
                        <td height="40" style="padding-left:10px"><select name="category">
                            <?php 
							$m = mysql_query("SELECT * FROM rockinus.major_info ORDER BY major_name ASC");
							if(!$m) die(mysql_error());
							while($objm = mysql_fetch_object($m)){
								$mid = $objm->mid;	
								$major_name = $objm->major_name;		
							
						//if($cmajor!=NULL && strlen($cmajor)>0){ 
						?>
                            <option value="<?php echo($mid) ?>" <?php if($mid==$cmajor)echo "selected"?>><?php echo($major_name) ?></option>
                            <?php } ?>
                            <option value="others" <?php if($mid==$cmajor)echo "selected"?>>Others</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td height="40" style="padding-right:10px" align="right">Subject / Title </td>
                        <td height="40" style="padding-left:10px"><input type="text" name="subject" size="70"/></td>
                      </tr>
                      <tr>
                        <td height="170" style="padding-right:10px" align="right">Description </td>
                        <td style="padding-left:10px; padding-top:10px" valign="top"><textarea name="descrip" rows="10" style="width:500"></textarea>
                        </td>
                      </tr>
                      <tr>
                        <td height="50" style="padding-right:10px" align="right">&nbsp;</td>
                        <td style="padding-left:10px; padding-top:10px; padding-bottom:30px" valign="top"><input name="job" type="submit" class="btn2" value=" Submit " />
                        </td>
                      </tr>
                    </table>
                </form></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
