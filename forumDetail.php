<?php 
include 'dbconnect.php';
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];

if(isset($_GET['foid']))
	$foid = $_GET['foid'];
//else 
//	header("location:openForum.php");

if(isset($_POST['forumsubmit'])){
	//session_start();
	//$uname = $_SESSION['usrname'];
	$foid = $_POST['foid'];
	$sender = addslashes($_POST['sender']);
	$creator = addslashes($_POST['creator']);
	if($sender==$creator) $rstatus = "Y";
	else $rstatus = "N";
	$descrip = addslashes($_POST['descrip']);
	if( $descrip!=NULL && strlen($descrip)!=0 ){
		$sql = "INSERT INTO rockinus.forum_history (foid,sender,descrip,rstatus,pdate,ptime)VALUES('$foid','$sender','$descrip','$rstatus',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		mysql_close($link);
	}
}

include 'dbconnect.php';

$q1 = mysql_query("SELECT * FROM rockinus.forum_info where foid='$foid'");
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
	$t2 = mysql_query("SELECT * FROM rockinus.forum_history WHERE rstatus='N' AND foid=$foid");
	if(!$t2) die(mysql_error());
	$no_row_hist = mysql_num_rows($t2);
	
	if($no_row_hist>0){	
		$upd = mysql_query("UPDATE rockinus.forum_history SET rstatus='Y' WHERE foid='$foid' AND rstatus='N'");
		if(!$upd) die(mysql_error());
	}
}
?>
<div align="center" style="width:100%">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="center">
    <tr>
      <td width="300" align="left" valign="top" style="border-right:1px #DDDDDD dashed">
	  <?php include("leftHomeMenu.php"); ?>
	  </td>
      <td width="760" align="right" valign="top">
	  <?php include("HeaderEN.php"); ?>
	  <table border="0" cellspacing="0" cellpadding="0" width="760">
        <tr>
          <td align="right" valign="top" style="margin-right:10px; margin-left:0px; padding-left:10px">
		  <table width="740" height="221" border="0" cellpadding="0" cellspacing="0" style="border:1 #DDDDDD solid">
            <tr>
              <td height="35" colspan="2" align="left" background="img/master.png" style=" border-bottom:1 solid #CCCCCC; font-weight:bold; padding-left:15px; font-size:14px">
			  <a href="openForum.php" class="one">Back to Forum</a>
			  </td>
              <td width="209" height="35" align="right" background="img/master.png" style="padding-right:5px; border-bottom:1 solid #CCCCCC;"><div align="center" style="border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: #CC3300; padding-bottom:5; padding-top:5;  width:100px"><a href="postForum.php"><strong>+ New Post</strong></a></div></td>
            </tr>
            <tr>
              <td width="130" height="30" align="left" bgcolor="#EEEEEE" style="border-bottom:1px #666666 dashed; padding-left:15px">
			  <font color="#000000"> <Strong>Creator:</Strong> <?php echo($creator) ?></font>			  </td>
              <td width="539" height="30"  align="center" bgcolor="#EEEEEE" style="border-bottom:1px #666666 dashed">
			  <font color="#000000"> <Strong>Category:</Strong> <?php echo($category) ?></font>			  </td>
              <td height="30"  align="right" bgcolor="#EEEEEE" style="border-bottom:1px #666666 dashed; padding-right:10px">
			  <font color="#000000"> <strong>Post at:</strong> <?php echo($pdate) ?> | <?php echo(substr($ptime,0,5)) ?>	</font>			  </td>
              </tr>
            <tr>
              <td height="40" colspan="3" align="center" valign="top" style="padding:15px; line-height:180%; font-size:16px; border-bottom:2px dashed #F5F5F5">
			  <strong><?php echo($subject) ?></strong>               <?php 
	if(trim($creator)==trim($uname)) echo("<div align=center style='background-color:; padding-left:10px; display:inline'><a href=EditForum.php?foid=$foid class=one><font color=#999999><strong><u>+ Edit</u></strong></font></a></div>"); ?>
			</td>
              </tr>
            <tr>
              <td height="93" colspan="3" align="left" valign="top" style="padding:15px; line-height:180%; font-size:14px">
			  <?php
					echo nl2br($descrip);
				?>				</td>
              </tr>
          </table>
		  <table width="740" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px">
            <tr>
              <td width="710" height="41" colspan="3">
			  <?php
$q1 = mysql_query("SELECT * FROM rockinus.forum_history WHERE foid='$foid' ORDER BY pdate DESC, ptime DESC");
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
                  <div style="line-height:180%; margin-bottom:10px; width: 740; border:1 #DDDDDD solid;" align="left">
                    <table width="740" height="63" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="131" height="29" align="left" bgcolor="#F5F5F5" style=" color:#336633; padding-left:10px">
						<font color="#666666">From</font><strong> <a href="RockerDetail.php?uid=<?php echo($sender) ?>" class="one"> <?php echo($sender) ?></a> </strong> </td>
                        <td width="584" bgcolor="#F5F5F5">&nbsp;</td>
                        <td width="143" align="right" bgcolor="#F5F5F5" style=" color: #999999; font-size:13px; padding-right:10px">
						<?php echo(getDateName($pdate)) ?> | <?php echo(substr($ptime,0,5)) ?></td>
                      </tr>
                      <tr>
                        <td height="22" colspan="3" style=" border-top:1 solid #DDDDDD; padding:10px; line-height:150%; font-size:14px">
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
                      <table width="730" border="0" cellpadding="0" cellspacing="0" style="border-top:#CCCCCC solid 0">
                        <tr>
                          <td width="120" height="35" align="left" bgcolor="<?php echo($_SESSION['hcolor']) ?>" style="padding-left:10px"><font color="#FFFFFF"><strong>COMMENT</strong></font></td>
                          <td width="540" height="35" bgcolor="<?php echo($_SESSION['hcolor']) ?>">
                          <input type="hidden" name="foid" value=<?php echo($foid) ?> />
                          <input type="hidden" name="creator" value=<?php echo($creator) ?> />
						  <input type="hidden" name="sender" value=<?php echo($uname) ?> />
                          </td>
                          <td width="80" height="35" align="right" valign="middle" bgcolor="<?php echo($_SESSION['hcolor']) ?>" style="padding-right:10px">
						  <input type="submit" name="forumsubmit" value="submit" class="btn2" />
						  </td>
                        </tr>
                        <tr>
                          <td height="86" colspan="3" align="left" style="padding-top:10px; padding-bottom:10px; border-top:1 solid #CCCCCC;" bgcolor="#FFFFFF">
                                  <textarea name="descrip" rows="4" style="width:740" id="styled"></textarea>						  
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
