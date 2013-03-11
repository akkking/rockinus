<?php 
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
$ua=getBrowser();
  
include 'dbconnect.php';

if(isset($_GET['job_id']))
	$job_id = $_GET['job_id'];
//else 
//	header("location:openForum.php");

if(isset($_POST['jobsubmit'])){
	//session_start();
	//$uname = $_SESSION['usrname'];
	$job_id = $_POST['job_id'];
	$sender = addslashes($_POST['sender']);
	$creator = addslashes($_POST['creator']);
	if($sender==$creator) $rstatus = "Y";
	else $rstatus = "N";
	$descrip = addslashes($_POST['descrip']);
	if( $descrip!=NULL && strlen($descrip)!=0 ){
		$sql = "INSERT INTO rockinus.job_history (job_id,sender,descrip,rstatus,pdate,ptime)VALUES('$job_id','$sender','$descrip','$rstatus',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		mysql_close($link);
	}
}

include 'dbconnect.php';

$q1 = mysql_query("SELECT * FROM rockinus.job_info where job_id='$job_id'");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$creator = $object->creater;
$category = $object->category;
$descrip = $object->descrip;
$subject = $object->subject;
$ptime = $object->ptime;
$pdate = $object->pdate;  
if(ctype_upper($category)){
	$m = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid='$category'");
	if(!$m) die(mysql_error());
	$objm = mysql_fetch_object($m);
	$category = $objm->major_name;
}

if($uname==$creator){
	$t2 = mysql_query("SELECT * FROM rockinus.job_history WHERE rstatus='N' AND job_id=$job_id");
	if(!$t2) die(mysql_error());
	$no_row_hist = mysql_num_rows($t2);
	
	if($no_row_hist>0){	
		$upd = mysql_query("UPDATE rockinus.job_history SET rstatus='Y' WHERE job_id='$job_id' AND rstatus='N'");
		if(!$upd) die(mysql_error());
	}
}
?><style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
<div align="center">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="center">
    <tr>
      <td width="300" align="left" valign="top" style="border-right:1px #DDDDDD dashed">
	  <?php include("leftHomeMenu.php"); ?>
	  </td>
      <td width="760" align="left" valign="top" style="padding-left:0px">
	  <?php include("HeaderEN.php"); ?>
	  <table border="0" cellspacing="0" cellpadding="0" width="760">
        <tr>
          <td align="right" valign="top">
		  <table width="740" height="221" border="0" cellpadding="0" cellspacing="0" style="border:0 #DDDDDD solid">
            <tr>
              <td height="33" colspan="2" align="left" background="img/master.png" bgcolor=#666666 style="padding-left:15px; border-bottom:1 solid #CCCCCC; font-size:16px">
			  <a href="jobList.php" class="one">Back to job list</a>
			  </td>
              <td width="210" align="right" background="img/master.png" bgcolor=#666666 style="padding-right:5px; border-bottom:1 solid #CCCCCC;"><div align="center" style="border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: #CC3300; padding-bottom:5; padding-top:5; width:100px"><a href="postJob.php"><strong>+ New Post</strong></a></div></td>
            </tr>
            <tr>
              <td width="130" height="40" align="left" bgcolor="#EEEEEE" style="border-bottom:1px #666666 dashed; padding-left:15px">
			  <font color="#000000"> <Strong>Creator:</Strong> <?php echo($creator) ?></font>			  </td>
              <td width="538" height="40"  align="center" bgcolor="#EEEEEE" style="border-bottom:1px #666666 dashed">
			  <font color="#000000"> <Strong>Hiring field : </Strong> <?php echo($category) ?></font>			  </td>
              <td height="40"  align="right" bgcolor="#EEEEEE" style="border-bottom:1px #666666 dashed; padding-right:10px">
			  <font color="#000000"> <strong>Post at:</strong> <?php echo($pdate) ?> | <?php echo(substr($ptime,0,5)) ?>	</font>			  </td>
              </tr>
            <tr>
              <td height="40" colspan="3" align="center" valign="top" style="padding:15px; line-height:180%; border-bottom:2px dashed #F5F5F5">
			  <font size="4"><strong><?php echo($subject) ?></strong>			  
                <?php 
	if(trim($creator)==trim($uname)) echo("<div align=center style='background-color:; padding-left:10px; display:inline'><a href=EditJob.php?job_id=$job_id class=one><font color=#999999><strong><u>+ Edit</u></strong></font></a></div>"); ?>
			</font>
                </td>
              </tr>
            <tr>
              <td height="93" colspan="3" align="left" valign="top" style="padding:20px; line-height:180%; font-size:14px">
			  <?php
					echo nl2br($descrip);
				?>				</td>
              </tr>
          </table>
		  <table width="740" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px">
            <tr>
              <td width="710" height="41" colspan="3">
			  <?php
$q1 = mysql_query("SELECT * FROM rockinus.job_history WHERE job_id='$job_id' ORDER BY pdate DESC, ptime DESC");
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
                  <div style="line-height:180%; margin-bottom:10px; width: 740px; border:4 #EEEEEE solid;" align="left">
                    <table width="740" height="63" border="0" cellpadding="0" cellspacing="0" bgcolor="">
                      <tr>
                        <td width="131" height="29" align="left" style=" color:#336633; padding-left:10px">
						<strong> <a href="RockerDetail.php?uid=<?php echo($sender) ?>" class="one"><?php echo($sender) ?></a> </strong> </td>
                        <td width="584">&nbsp;</td>
                        <td width="143" align="right" style=" color: #999999; font-size:13px; padding-right:10px">
						<?php echo($pdate) ?> | <?php echo($ptime) ?></td>
                      </tr>
                      <tr>
                        <td height="22" colspan="3" style="padding:10px; line-height:150%; font-size:14px">
                          <?php
							echo nl2br($descrip);
							?>
                        </font> </td>
                      </tr>
                    </table>
                  </div>
                <?php }}?></td>
            </tr>
          </table>
		  <form action="forumDetail.php" method="post" style="margin-top:5">
                      <table width="740" border="0" cellpadding="0" cellspacing="0" background="img/master.png" style="border-top:#CCCCCC solid 1">
                        <tr>
                          <td width="123" height="35" align="left" style="padding-left:10px"><font color="#000000"><strong>COMMENT</strong></font></td>
                          <td width="619" height="35">
                          <input type="hidden" name="job_id" value=<?php echo($job_id) ?> />
                          <input type="hidden" name="creator" value=<?php echo($creator) ?> />
						  <input type="hidden" name="sender" value=<?php echo($uname) ?> />
                          </td>
                          <td width="68" height="35" align="right" valign="middle" style="padding-right:10px">
						  <input type="submit" name="forumsubmit" value="submit" class="btn2" />
						  </td>
                        </tr>
                        <tr>
                          <td height="86" colspan="3" align="left" style="padding-top:10px; padding-bottom:10px; padding-right:10px" bgcolor="#FFFFFF">
                                  <textarea name="descrip" rows="4" style="width:730" id="styled"></textarea>						  
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
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
