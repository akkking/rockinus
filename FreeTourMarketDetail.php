<?php include("HeaderFreeTour.php"); ?>
<style>
#HouseDiv {
	margin: 0px;
    color: #fff;
    width: 800px;
	height: 30px;
    padding: 0px;
    text-align: left;
	margin-bottom:0px;
	background-color:<?php echo($_SESSION['hcolor']) ?>;
    border: 1px solid #DDDDDD;
}
body,td,th {
	font-size: 14px;
}
</style>
<script type="text/JavaScript">
  curvyCorners.addEvent(window, 'load', initCorners);
  function initCorners() {
    var settings = {
      tl: { radius: 10 },
      tr: { radius: 10 },
      bl: { radius: 0 },
      br: { radius: 0 },
      antiAlias: true
    }
    curvyCorners(settings, "#HouseDiv");
}
</script>
<?php include("FreeHeader.php") ?>
<table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="1024" align="left" valign="top" style=" border-right:#DDDDDD solid 0;border-left:#DDDDDD solid 0;">
        <?php
if(isset($_GET['aid']))
	$aid = $_GET['aid'];
else if(isset($_POST['aid']))
	$aid = $_POST['aid'];
$q = mysql_query("SELECT * FROM rockinus.article_info where aid=$aid");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$aid = $object->aid;
$subject = $object->subject;
$type = $object->type;
$condition = $object->quality;
$delivery = $object->delivery;
if($delivery=='N')$delivery='No';else '$delivery=Yes';
$state = $object->state;
$city = $object->city;
$email = $object->email;
$rate = $object->rate;
$telephone = $object->telephone;
$num = $object->num;
$aname = $object->aname;
$postuname = $object->uname;
$rstatus = $object->rstatus;
$description = $object->descrip;
$pdate = $object->pdate;
$ptime = $object->ptime;

if($uname==$postuname){
	$t2 = mysql_query("SELECT * FROM rockinus.article_comment WHERE rstatus='N' AND aid=$aid");
	if(!$t2) die(mysql_error());
	$no_row_hist = mysql_num_rows($t2);
	
	if($no_row_hist>0){	
		$upd = mysql_query("UPDATE rockinus.article_comment SET rstatus='Y' WHERE aid='$aid' AND rstatus='N'");
		if(!$upd) die(mysql_error());
	}
}
?>
<div style="width:1024px;">
          <table width="1024" border="0" cellpadding="0" cellspacing="0" style="border:#F5F5F5 solid 4px; border-top:0px; margin-bottom:20px">
            <tr>
              <td height="30" background="img/master.png">&nbsp;</td>
              <td height="20" colspan="2" background="img/master.png">&nbsp;</td>
              <td height="20" background="img/master.png">&nbsp;</td>
              <td height="20" align="right" background="img/master.png" style="padding-right:10px; color:#999999">Posted : <?php echo($pdate) ?> | <?php echo($ptime) ?></td>
            </tr>
            <tr>
              <td height="70" colspan="5" align="center" style="border-bottom:0px #999999 solid; border-top:0px #999999 solid">
			  <font size="5" style="font-weight:bold"><?php echo($subject) ?></font></td>
            </tr>
            <tr>
              <td height="33" align="right" style="padding-right:15px">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="right" style="padding-right:10px">&nbsp;</td>
            </tr>
            <tr>
              <td width="176" height="33" align="right" style="padding-right:15px"><strong>Location</strong></td>
              <td><?php echo($city) ?>&nbsp;,&nbsp;<?php echo($state) ?></td>
              <td>&nbsp;</td>
              <td align="right" style="padding-right:15px"><strong>Available?</strong></td>
              <td align="left"><?php 
	if(trim($rstatus)=="Y") echo("<div align=center style='border-right:0 solid #000000; border-bottom:0 solid #000000; background-color: ; padding-bottom:3; padding-top:3; height:20px; color:#336633; font-size=16px; display:inline'><strong>Yes</strong></div>");
	else echo("<div align=center style='border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: ; padding-bottom:3; padding-top:3; padding-left:10px; padding-right:10px; height:20px; color: orange; font-size=16px; display:inline'><strong>No</strong></div>");
	 ?>              
	 </td>
            </tr>
            <tr>
              <td height="33" align="right" style="padding-right:15px"><strong>Name</strong></td>
              <td colspan="2"><?php echo($aname) ?>&nbsp;</td>
              <td width="134" align="right" style="padding-right:15px"><strong>Number</strong></td>
              <td width="381"><?php echo($num) ?>&nbsp;Piece(s)</td>
            </tr>
            <tr>
              <td height="34" align="right" style="padding-right:15px"><strong>Condition</strong></td>
              <td colspan="2"><?php echo($condition) ?>&nbsp;</td>
              <td align="right" style="padding-right:15px"><strong>Delivery</strong></td>
              <td><?php 
	if($delivery=='Y')
	echo("Yes"); else echo("No"); ?></td>
            </tr>
            <tr>
              <td height="37" align="right" style="padding-right:15px"><strong>Rate</strong></td>
              <td colspan="2"> $<?php echo($rate) ?>&nbsp;</td>
              <td align="right" style="padding-right:15px"><strong>Phone</strong></td>
              <td><?php echo($telephone) ?></td>
            </tr>
            <tr style="border-bottom:solid 1px #CCCCCC;">
              <td height="35" align="right" style="padding-right:15px;"><strong>Contact</strong></td>
              <td width="196"><a href="RockerDetail.php?uid=<?php echo($postuname) ?>" class="one"><?php echo($postuname) ?></a></td>
              <td width="129"><font color="#000000" size="2"><strong>
                <div style="background: url(img/bg_gray_1.jpg); display:inline; height:20px; padding-left:8px; padding-right:8px; padding-bottom:4px; padding-top:4px; border:#CCCCCC solid 1" align="right">
                  <?php 
				  echo("<a href=FreeTourSendMsg.php?recipient=$postuname class=one>Message</a>")
				  ?>
                </div>
              </strong></font></td>
              <td align="right" style="padding-right:15px"><strong>Email</strong></td>
              <td><?php echo($email) ?></td>
            </tr>
            <tr style="border-bottom:solid 1px #CCCCCC;">
              <td height="20" colspan="5" align="right" style="padding-right:15px;">&nbsp;</td>
            </tr>
            <tr>
              <td height="74" align="right" style="padding-right:15; border-top:#EEEEEE dotted 0; padding-top:10px" valign="top"><strong>Description</strong> </td>
              <td colspan="4" align="left" valign="top" style="border-bottom:1 #EEEEEE dotted; padding:10; padding-top:10px; line-height:150%; font-size:15px; width: 615px; font-size:16px; margin-left:5px"><?php
	  echo nl2br($description)
	  ?>              </td>
            </tr>
            <tr>
              <td height="30" align="right" style="padding-right:10; border-top:#EEEEEE dotted 0; padding-top:30px" valign="top">&nbsp;</td>
              <td height="30"colspan="4" valign="top" style="border-top:#EEEEEE dotted 0; padding-top:10px"><?php 
					$target = "upload/a".$aid;
					if(is_dir($target)){
						if(file_exists($target."/1_600.jpg")) echo("<img src=upload/a$aid/1_600.jpg style=border:0><br><br>");
				  		if(file_exists($target."/2_600.jpg")) echo("<img src=upload/a$aid/2_600.jpg style=border:0><br><br>");
						if(file_exists($target."/3_600.jpg")) echo("<img src=upload/a$aid/3_600.jpg style=border:0>");
					}
	?>              </td>
            </tr>
            <tr>
              <td height="30" align="right" style="padding-right:10; border-top:#EEEEEE dotted 0; padding-top:30px" valign="top">&nbsp;</td>
              <td height="30"colspan="4" valign="top" style="border-top:#EEEEEE dotted 0; padding-top:10px"><table style="margin-top:10px">
                  <tr>
                    <td width="710" height="41" colspan="3"><?php
$q1 = mysql_query("SELECT * FROM rockinus.article_comment WHERE aid='$aid' ORDER BY pdate DESC, ptime DESC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("");}
if($no_row > 0){ 
while($object = mysql_fetch_object($q1)){
	$cid = $object->cid;
	$aid = $object->aid;
	$sender = $object->sender;
	$recipient = $object->recipient;
	$descrip = $object->descrip;
	$ptime = $object->ptime;
	$pdate = $object->pdate; 
?>
                        <div style="padding-left:0; padding-right:0; line-height:180%; padding-top:0; padding-bottom:0; margin-bottom:10; width: 700px; background-color: ; border:2 #EEEEEE solid">
                          <table width="700" height="63" border="0" cellpadding="0" cellspacing="1">
                            <tr>
                              <td width="246" height="25" align="left" bgcolor="#F5F5F5" style="padding-left:10px">
                                  <strong><?php echo($sender); 
				  if($sender!=$recipient)
				  	echo("@ $recipient");
				?></strong> </td>
                              <td height="25" align="right" bgcolor="#F5F5F5" style="padding-right:10"><?php echo($pdate) ?> | <?php echo($ptime) ?></td>
                            </tr>
                            <tr>
                              <td height="22" colspan="2" style="padding:10px"><font size="3">
                                <?php
									$len = strlen($descrip);
									$single_line_len = 95;
									$line_no = $len/$single_line_len; 
							
									for($i=0;$i<$line_no;$i++) {
										$str = substr($descrip,$i*$single_line_len, ($i+1)*$single_line_len)."<br>";
										echo $str;
									}?>
                              </font> </td>
                            </tr>
                          </table>
                        </div>
                      <?php }}?></td>
                  </tr>
                </table>
                  <div style="width:600; border:8px #DDDDDD solid; padding-bottom:30; margin-top:30; margin-bottom:30; padding-top:30; font-size:16px; font-weight:bold" align="center">
				  To reply to this post or to view more info, please:
				    <p style="margin-top:30"/>
				  <div style="border:1 #999999 solid; display:inline; padding-left:10; padding-right:10; padding-bottom:5; padding-top:5; height:10; background-image:url(img/master.png); font-weight:normal; font-size:14px">
				  <a href="rockinus_relogin.php" class="one">Sign In</a>
				  </div>
				  <p style="margin-top:15">
				  <div style=" margin-top:0; margin-bottom:0; border:0 #999999 solid; display:inline; padding-left:10; padding-right:10; padding-bottom:5; padding-top:5; height:10;">Or
				  </div>
				  <p style="margin-top:15">
				  <div style="border:1 #999999 solid; display:inline; padding-left:10; padding-right:10; padding-bottom:5; padding-top:5; height:10; background-image:url(img/master.png); font-weight:normal; font-size:14px">
				  <a href="joinus.php" class="one">Become a Member</a>
				  </div>
				  </div>
			  </td>
            </tr>
          </table>
      </div></td>
    </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
</body>
</html>
