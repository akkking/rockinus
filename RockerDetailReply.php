<?php include("Header.php"); ?>
<style type="text/css">
<!--
.STYLE1 {	color: #336633;
	font-weight: bold;
}
-->
</style>

<div align="center" style="background-image:url(<?php echo("img/".$_SESSION['topi'].".jpg")?>)">
<?php
		include 'dbconnect.php';
		$uid = $_GET["uid"];
		$pic250_Name = $uid.'250.jpg';

if($uid==$uname){
	$submitFile = "MemoPost.php";
	$pagename = "RockerDetail.php?uid=$uid";
}else{
	$submitFile = "ReplyMemo.php";
	$pagename = "RockerDetailReply.php?uid=$uid";
}
$q = mysql_query("SELECT * FROM rockinus.user_info INNER JOIN rockinus.user_check_info INNER JOIN rockinus.user_edu_info ON user_info.uname='$uid'");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;
$birthdate = $object->birthdate;
$fregion = $object->fregion;
$fcountry = $object->fcountry;
if($fcountry=="empty")$fcountry = NULL;
$email = $object->email;
$cmajor = $object->cmajor;
$cschool = $object->cschool;
$cdegree = $object->cdegree;
$sterm = $object->sterm;

if($mstatus=='S')$mstatus='Single';
else if($mstatus=='M')$mstatus='Married';
else if($mstatus=='I')$mstatus='In a relationship';

if($cschool!=NULL){
	$q1 = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
	if(!$q1) die(mysql_error());
	$obj1 = mysql_fetch_object($q1);
	$cschool = $obj1->school_name;
}

if($cmajor!=NULL){
	$q2 = mysql_query("SELECT * FROM rockinus.major_info where mid='$cmajor'");
	if(!$q2) die(mysql_error());
	$obj2 = mysql_fetch_object($q2);
	$cmajor = $obj2->major_name;
}

if($fcountry!=NULL){
//	$q1 = mysql_query("SELECT * FROM rockinus.country_info where counid='$fcountry'");
//	if(!$q1) die(mysql_error());
//	$obj1 = mysql_fetch_object($q1);
//	$fcountry = $obj1->country_name;
}

$q3 = mysql_query("SELECT * FROM rockinus.memo_info where sender='$uid' order by memoid DESC");
if(!$q3) die(mysql_error());
$obj3 = mysql_fetch_object($q3);
$descrip = $obj3->descrip;
$memoid = $obj3->memoid;
if($descrip==NULL)$descrip="<font color=#999999>".$uid." has nothing posted...</font>";
?>
  <table width="1018" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="136" align="left" valign="top" style="border-right: 0px solid #CCCCCC; padding-left:15px">
        <?php include("leftMenuFriendGroup".$_SESSION['lan'].".php"); ?>
	  </td>
      <td width="882" align="left" valign="top" style=" border:#CCCCCC solid 0; padding-left:3;">
	  <table width="885" height="527" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="527" valign="top" align="center">
			<table width="830" height="502" border="0" cellpadding="0" cellspacing="0" style="border:0 #EEEEEE solid; padding-left:10px">
              <tr>
                <td width="260" height="30" colspan="2" valign="top"><div align="center" style="padding-bottom:0; padding-right:5; padding-top:5">
                    <?php 
					$target = "upload/".$uid;
					if(is_dir($target)){
						echo("<img src=upload/$uid/$pic250_Name style=border:0>");
				  	}else 
				  		echo("<img src=img/NoUserIcon250.jpg style=border:0>");
					?>
                  </div>
                    <br />
                    <table width="250" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="144" height="30" align="right" bgcolor="#EEEEEE" style="padding-right:10; border-bottom:1 dotted #CCCCCC"><span class="STYLE1">Courses selected </span></td>
                        <td width="106" align="left" bgcolor="#EEEEEE" style="padding-left:5; border-bottom:1 dotted #CCCCCC"><div align="center">0</div></td>
                      </tr>
                      <tr>
                        <td height="30" align="right" bgcolor="#EEEEEE" style="padding-right:10; border-bottom:1 dotted #CCCCCC"><span class="STYLE1">Friends Number </span></td>
                        <td align="left" bgcolor="#EEEEEE" style="padding-left:5; border-bottom:1 dotted #CCCCCC"><div align="center">1</div></td>
                      </tr>
                      <tr>
                        <td height="30" align="right" bgcolor="#EEEEEE" style="padding-right:10; border-bottom:1 dotted #CCCCCC"><span class="STYLE1">Posts Number </span></td>
                        <td align="left" bgcolor="#EEEEEE" style="padding-left:5; border-bottom:1 dotted #CCCCCC"><div align="center">3</div></td>
                      </tr>
                  </table></td>
                <td colspan="3" rowspan="5" valign="top" style="border-bottom: #EEEEEE dotted 1"><div align="center">
                    <table width="550" height="167" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="465" height="35" style="padding-left:10; border-bottom:1 #EEEEEE dotted; padding-bottom:5"><?php echo("<font size=4>".$uid."</font>") ?>
                            <?php if($gender!=NULL)echo("(".$gender.")");
						if($mstatus!=NULL)echo(" (".$mstatus.")");  ?>                        </td>
                        <td width="100" height="35" align="center" bgcolor="#F5F5F5" style="border-bottom:#EEEEEE solid 1px">
                          <?php 
							if($uid==$uname)
							echo("<a href=EditUserInfo.php class=one><strong> + Edit </strong></a>");
							else
							echo("<a href=AddFriend.php?sender=$uid&recipient=$uname class=one><strong> Connect </strong></a>");
							?>						</td>
                      </tr>
                      <tr>
                        <td height="35" style="padding-left:10; border-bottom:1 #EEEEEE dotted; padding-bottom:5" ><?php echo($sstatus) ?>, at <?php echo($cschool) ?></td>
                        <td height="35" align="center" bgcolor="#F5F5F5"><?php echo("<a href=SendMessage.php?recipient=$uid class=one><strong>Message</strong></a>") ?>						</td>
                      </tr>
                      <tr>
                        <td colspan="2" height="35" style="padding-left:10; border-bottom:1 #EEEEEE dotted; padding-bottom:5"><span style="padding-left:10px; border-bottom:1 #EEEEEE dotted; padding-bottom:5">
                          <?php 
						  if($cdegree!=NULL)echo($cdegree); 
						  if(($cdegree!=NULL)&&($cmajor!=NULL))echo(", in ".$cmajor." (".$sterm.")"); 
						  ?>
                        </span></td>
                      </tr>
                      <tr>
                        <td colspan="2" height="35" style="padding-left:10; border-bottom:1 #EEEEEE dotted; padding-bottom:5"><?php 
						   if($fregion!=NULL)echo("<font size=3>From :  </font> ".$fregion);
						   if(($fregion!=NULL)&&($fcountry!=NULL))echo(", ".$fcountry); ?></td>
                      </tr>
                      <tr>
                        <td height="35" style="padding-left:10; border-bottom:1 #EEEEEE dotted; padding-bottom:5">
						<font size="3">Email : </font> <?php echo($email) ?> 
						</td>
                        <td height="35" align="center" style="padding-top: 2; padding-bottom: 6; display:inline"><table width="84" height="29" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
                            <tr>
                              <td width="80" height="26" bgcolor="#FFFFFF"><div align="center"><a href="RockerDetail.php?uid=<?php echo($uid) ?>" class="one">Back</a></div></td>
                            </tr>
                          </table>
                          <a href="RockerDetailReply.php?uid=<?php echo($uid)?>" class="one"></a><a href="RockerDetailReply.php?uid=<?php echo($uid)?>" class="one"></a> </td>
                      </tr>
                      <tr>
                        <td height="35" colspan="2" align="left" style="padding-left:10; padding-right:10; padding-bottom:10; line-height:180%; font-size:16px; padding-top:5; padding-bottom:5; width: 555; background-color:#F5F5F5; margin-left:5"><?php 
						  			$len = strlen($descrip);
									$single_line_len = 80;
									$line_no = $len/$single_line_len; 
							
									for($i=0;$i<$line_no;$i++) {
										$str = substr($descrip,$i*$single_line_len, ($i+1)*$single_line_len)."<br>";
										echo $str; }?>
                        </td>
                      </tr>
                      <tr>
                        <td height="35" colspan="2"><div style="padding-left:5; border-bottom:1 #EEEEEE dotted; padding-bottom:10; line-height:200%; font-size:16px; padding-top:5; padding-bottom:5; width: 555; border: dotted #999999 0; background-color:#; margin-left:0">
                            <div style="width:268; margin-top:5; margin-bottom:0; padding-left:-5; padding-right:2" align="right">
                              <form action="<?php echo($submitFile) ?>" method="post" style="margin-bottom:0">
                                <table width="200" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td height="80" colspan="3"><textarea cols="75" rows="4" style="color: #006699; background-color:#; font:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; border-color: #CCCCCC; border-style: dotted; border-width: 1; padding: 3px;" name="limitedtextarea" onkeydown="limitText(this.form.limitedtextarea,this.form.countdown,150);" 
onkeyup="limitText(this.form.limitedtextarea,this.form.countdown,150);">
<?php //echo($descrip) ?>
            </textarea>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td width="260" height="31">&nbsp;&nbsp;
                                        <input readonly="readonly" type="text" name="countdown" size="3" value="150" style="border:0;" />
                                      / &nbsp;<font size="-1.5">150</font>
                                      <input readonly="readonly" type="hidden" name="uid" size="3" value="<?php echo($uid) ?>" style="border:0;" />
                                      <input type="hidden" name="pagename" value="<?php echo($pagename) ?>" />
                                    </td>
                                    <td width="198"><span style="padding-left:8">
                                      <?php  
						if(isset($_SESSION['rst_msg'])){
						echo($_SESSION['rst_msg']); 
						unset($_SESSION['rst_msg']); }
						?>
                                    </span></td>
                                    <td width="53"><input name="submit" type="submit" class="btn" value=" Done " /></td>
                                  </tr>
                                </table>
                              </form>
                            </div>
                        </div></td>
                      </tr>
                      <tr>
                        <td height="35" colspan="2"><?php
$q1 = mysql_query("SELECT * FROM rockinus.memo_follow_info WHERE memoid='$memoid' ORDER BY memofid DESC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row > 0){ 
while($object = mysql_fetch_object($q1)){
$memofid = $object->memofid;
$sender = $object->sender;
$descrip = $object->descrip;
$ptime = $object->ptime;
$pdate = $object->pdate; 
?>
                            <div style="padding-left:5; padding-right:5; border-bottom:1 #EEEEEE solid; padding-bottom:10; line-height:180%; font-size:13px; padding-top:5; padding-bottom:5; width: 555px; background-color:#; margin-left:5; margin-top:0; margin-bottom:4;">
                              <form action="MemoReplyDelete.php" method="post" style="margin:0">
                                <table width="546" height="63" border="0" cellpadding="0" cellspacing="4">
                                  <tr>
                                    <td width="103" height="29"><div align="left" style=" color:#336633"><?php echo($sender) ?></div></td>
                                    <td width="226"><input type="hidden" name="sender" value="<?php echo($sender) ?>" />
                                        <input type="hidden" name="ddescrip" value="<?php echo($descrip) ?>" size="151" />
                                        <input type="hidden" name="pdate" value="<?php echo($pdate) ?>" />
                                        <input type="hidden" name="ptime" value="<?php echo($ptime) ?>" />
                                        <input type="hidden" name="pagename" value="RockerDetail.php" />
                                    </td>
                                    <td width="61"><?php if($uid==$sender){?>
                                        <input type="submit" style="font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 12px;background-color: #FFFFFF; border:0 solid #CCCCCC; border-bottom:1 #CCCCCC solid; border-right:1 #CCCCCC solid; color:#999999" name="submit2" value="delete" ? />
                                        <?php } ?></td>
                                    <td width="135"><div align="left" style=" color: #999999; font-size:13px"><?php echo($pdate) ?> | <?php echo($ptime) ?></div></td>
                                  </tr>
                                  <tr>
                                    <td height="22" colspan="4"><?php
									$len = strlen($descrip);
									$single_line_len = 95;
									$line_no = $len/$single_line_len; 
							
									for($i=0;$i<$line_no;$i++) {
										$str = substr($descrip,$i*$single_line_len, ($i+1)*$single_line_len)."<br>";
										echo $str;
									}?>
                                    </td>
                                  </tr>
                                </table>
                              </form>
                            </div>
                          <?php }}?></td>
                      </tr>
                    </table>
                </div></td>
              </tr>
              <tr>
                <td colspan="2" valign="top">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
