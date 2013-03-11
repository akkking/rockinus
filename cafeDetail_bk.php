<?php include("Header.php"); 

if(isset($_POST['cafefoodsubmit'])){ 
	$cafefoodid = $_POST['foodList'];
	if(substr($cafefoodid,0,4)=="cafe"){
		$type = "c";
		$cafefoodid = substr($cafefoodid,4,strlen($cafefoodid)-4);
	}else $type = "f";
	$sender = $_POST['uname'];
	$cafeid = $_POST['cafeid'];
	if(isset($_POST['rating'])) $rating = $_POST['rating'];
	else $rating = 0;
	$descrip = addslashes($_POST['limitedtextarea']);

	include 'dbconnect.php';

	$q = mysql_query("INSERT INTO rockinus.cafefood_memo_info (cafefoodid,type,descrip,rating,sender,pdate,ptime,tbname) VALUES ('$cafefoodid','$type','$descrip','$rating','$sender', CURDATE(), NOW(), 'cafefood_memo_info')");
	if(!$q) die(mysql_error());
}

if(isset($_GET['cafeid'])) 
$cafeid = $_GET['cafeid'];

include 'dbconnect.php';

$q = mysql_query("SELECT * FROM rockinus.cafe_info WHERE cafeid='$cafeid'");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
$object = mysql_fetch_object($q);
$cafeid = $object->cafeid;
$creater = $object->creater;
$cafeTitle = $object->cafeTitle;
$location = $object->location;
$rate = $object->rate;
$category = $object->category;
$descrip = $object->descrip;
$pdate = $object->pdate;
$ptime = $object->ptime;
?>
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="778" align="left" valign="top" style="padding-left:15px; border-right:0px #CCCCCC solid">
	  <table width="760" height="35" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-top:#CCCCCC solid 2; border-top:#EEEEEE solid 1; margin-bottom:2px">
        <tr>
          <td width="623" height="50" align="center" style="padding-left:0px; color:#FFFFFF"><strong><font size="3" color="black"><? echo($cafeTitle) ?></font></strong> </td>
          <td width="137" height="50" align="right" valign="middle" style="border-right: 0px dotted #999999; padding-right:5px;"><div align="center" style="border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: #CC3300; height:20px; padding-bottom:5; padding-top:5; margin-right:5px; display:inline; padding-left:10px; padding-right:10px"><a href="postCafe.php"><strong>+ Post New</strong></a></div>
              </div>
          </td>
        </tr>
      </table>
        <table width="753" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-bottom:40px; margin-right:0px; padding-top:5; padding-bottom:5; margin-left:0px; margin-top:0px; border-left:1px #EEEEEE solid; border-right:0px #EEEEEE solid">
          <tr>
            <td width="103" height="201" align="center" style="padding-left:5px; padding-top:15px" valign="top"><?php 
				if($category=="Turkish")
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/TurkishKebabIcon.jpg width=100 height=100 style=border:0></a>");
				else if($category=="Indian")
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/IndianFoodIcon.jpg style=border:0></a>");
				else if($category=="Chinese")
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/ChineseFoodIcon.jpg style=border:0></a>");
				else if($category=="Japanese")
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/JapaneseSushiIcon.jpg width=100 height=100 style=border:0></a>");
				else if($category=="Mideastern")
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/MideasternFoodIcon.jpg width=120 height=120 style=border:0></a>");		else if($category=="Thai")
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/ThaiFoodIcon.jpg width=120 height=120 style=border:0></a>");
				else if($category=="Korean")
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/KoreanFoodIcon.jpg width=120 height=120 style=border:0></a>");
				else
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/NoUserIcon250.jpg width=200 style=border:0></a>");
				?>            </td>
            <td width="650" valign="top"><table width="550" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="15" align="right" class="STYLE1" style="padding-right:15px">&nbsp;</td>
                <td height="15" colspan="2" align="left" valign="middle" class="STYLE1" style="padding-left:0px">&nbsp;</td>
              </tr>
              <tr>
                <td width="154" height="35" align="right" class="STYLE1" style="padding-right:15px"><strong>Food Type:</strong></td>
                <td height="35" colspan="2" align="left" valign="middle" class="STYLE1" style="padding-left:0px"><?php echo("$category Food")?></td>
              </tr>
              <tr>
                <td width="154" height="35" align="right" class="STYLE1" style="padding-right:15px"><strong>Average Rate:</strong></td>
                <td height="35" colspan="2" valign="middle" class="STYLE1" style="padding-left:0"><?php echo("<strong><font color=#CC3300>$ $rate / Person</font></strong>")?></td>
              </tr>
              <tr>
                <td width="154" height="35" align="right" class="STYLE1" style="padding-right:15px"><strong>Location:</strong></td>
                <td height="35" colspan="2" valign="middle" class="STYLE1" style="padding-left:0"><?php echo("$location")?></td>
              </tr>
              <tr>
                <td width="154" height="35" align="right" valign="middle" class="STYLE1" style="padding-right:15px"><strong>Posted by: </strong> </td>
                <td height="35" colspan="2" valign="middle" class="STYLE1" style="padding-left:0"><?php echo("<a href=RockerDetail.php?uid=$creater class=one><strong>$creater</strong></a> &nbsp;&nbsp;$pdate | ".substr($ptime,0,5))?> <font color="#CCCCCC"> </font> </td>
              </tr>
              <tr>
                <td width="154" height="35" align="right" valign="top" style="padding-right:15px; padding-top:10px"><strong>Food List: </strong></td>
                <td width="208" height="35" valign="top" style="padding-top:10; padding-bottom:10px"><?php 
					$foodList = NULL;
					$qf = mysql_query("SELECT * FROM rockinus.food_info WHERE cafeid='$cafeid'");
					if(!$qf) die(mysql_error());
					while($o = mysql_fetch_object($qf)){
						$foodname = $o->foodname;
						echo("<div style=padding-bottom:10px><strong>$foodname</strong></div>");
					}
					?>                </td>
                <td width="188" valign="top" align="right" style="padding-top:5; padding-bottom:10px"><div align="center" class="STYLE23" style="border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: #CC3300; padding-bottom:5; padding-top:5; margin-right:5px; padding-left:10px; padding-right:10px; display:inline"><a href="postCafe.php"><strong>+ Add Course/Cuisine</strong></a></div></td>
              </tr>
              <tr>
                <td height="35" colspan="3" align="left" valign="top" style="padding:10px; line-height:180%">
				  <font size=4><?php
									echo("\"");
									$len = strlen($descrip);
									$single_line_len = 100;
									$line_no = $len/$single_line_len; 
							
									for($i=0;$i<$line_no;$i++) {
										$str = substr($descrip,$i*$single_line_len, $single_line_len)."<br>";
										echo($str);
									}
									echo("\"");
									?>
									</font></td>
              </tr>
              
            </table></td>
          </tr>
          <tr>
            <td height="105" colspan="2" style="padding-top:15px;border-top:0px #DDDDDD solid; padding-left:10px" align="left">
              <?php 
$q1 = mysql_query("
	SELECT * FROM rockinus.cafefood_memo_info 
	WHERE (cafefoodid='$cafeid' AND type='c') 
	OR
	(type='f' AND cafefoodid IN (SELECT foodid FROM rockinus.food_info WHERE cafeid='$cafeid'))
	ORDER BY memoid DESC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0)
	echo("<img src=img/messageD.jpg height=30px width=30px style=border:0>&nbsp;&nbsp;&nbsp;<font size=4 color=#CCCCCC><strong>Be the No.1 replier to this cafe!</strong></font>");
else if($no_row > 0){ 
if($_SESSION['lan']=='CN')
				  $msg_title = "¡Ù—‘∞Â";
				  else if($_SESSION['lan']=='EN')
				  $msg_title = "Comments & Rating";
echo("<div align='left' style='margin-top:5px; padding-left:5px; margin-bottom:10px; padding-bottom:10px; padding-top:5px; background-color:#FFFFFF; border-top:0px solid #EEEEEE; width=750px'><font size=3 color=$_SESSION[hcolor]><strong><img src=img/messageboardIcon.jpg width=25 height=25> $msg_title</strong></font>
</div>");
while($obj = mysql_fetch_object($q1)){
$memoid = $obj->memoid;
$cafefoodid = $obj->cafefoodid;
$type = $obj->type;
if($type=='f'){
	$qfdname = mysql_query("SELECT * FROM rockinus.food_info WHERE foodid='$cafefoodid'"); 		
	if(!$qfdname) die(mysql_error());
	$obje = mysql_fetch_object($qfdname);
	$type = " <font color=$_SESSION[hcolor]>".$obje->foodname."</font>";
}
else if($type=='c') $type=" this cafe";

$sender = $obj->sender;
$rating = $obj->rating;
$descrip = $obj->descrip;
$pdate = $obj->pdate;
$ptime = $obj->ptime; 
?>
              <div style="line-height:180%; padding-bottom:10px; width: 750px;">
                <form action="MemoReplyDelete.php" method="post" style="margin:0">
                  <table width="760" height="63" border="0" cellpadding="0" cellspacing="0" style="border-top:1px solid #CCCCCC; margin-bottom:5px">
                    <tr>
                      <td width="271" height="40" align="left" bgcolor="#F5F5F5" style=" padding-left:8px; border-bottom:0px dashed #EEEEEE">
					  <strong>
					  <?php echo($sender." <font color=#999999>commented on $type:</font>") ?>					  </strong></td>
                      <td width="254" height="40" align="center" bgcolor="#F5F5F5" style="border-bottom:0px dashed #EEEEEE">
					  <input type="hidden" name="sender" value="<?php echo($sender) ?>" />
                      <input type="hidden" name="cafeid" value="<?php echo($cafeid) ?>" />
                      <input type="hidden" name="ddescrip" value="<?php echo($descrip) ?>" size="151" />
                      <input type="hidden" name="pdate" value="<?php echo($pdate) ?>" />
                      <input type="hidden" name="ptime" value="<?php echo($ptime) ?>" />
                      <input type="hidden" name="pagename" value="CafeDetail.php" />                     
					  <?php 
							  	for($i=1;$i<=$rating;$i++)echo("<img src=img/greenstartopi.jpg> "); 
								?>				      </td>
                      <td width="86" height="40" align="right" bgcolor="#F5F5F5" style="border-bottom:0px dashed #EEEEEE">&nbsp;<?php if($uname==$sender){?>
                          <input type="submit" class="btn" name="submit2" value="delete" ? />
                      <?php } ?></td>
                      <td width="139" height="40" align="right" bgcolor="#F5F5F5" style="padding-right:10px; border-bottom:0px dashed #EEEEEE"><font color="#999999" size="1"> <?php echo("$pdate | ".substr($ptime,0,5)) ?> </font> </td>
                    </tr>
                    <tr>
                      <td height="22" colspan="4" style="padding:10px;line-height:200%; border-top:0px #CCCCCC dashed">
					  <?php
									$len = strlen($descrip);
									$single_line_len = 120;
									$line_no = $len/$single_line_len; 
							
									for($i=0;$i<$line_no;$i++) {
										$str = substr($descrip,$i*$single_line_len, $single_line_len)."<br>";
										if($sender==$uname)echo("<font size=2>".$str."</font>");
										else echo($str);
									}?>                      </td>
                    </tr>
                  </table>
                </form>
              </div>
              <?php }}?>
                <form action="cafeDetail.php" method="post" style="margin-top:20px">
                  <table width="750" border="0" cellspacing="0" cellpadding="0" style="border-top:1px #CCCCCC solid; margin-bottom:20px; margin-left:5px">
                    <tr>
                      <td height="30" colspan="3" align="left" bgcolor="#F5F5F5" style=" padding-top:10px; padding-bottom:5px; padding-left:15px; border-top:0px #CCCCCC solid">
					  <select name="foodList">
					  <option value=<?php echo("cafe".$cafeid) ?> selected="selected"><?php echo($cafeTitle) ?></option>
					  <?php 
					$qfood = mysql_query("SELECT * FROM rockinus.food_info WHERE cafeid='$cafeid'");
					if(!$qfood) die(mysql_error());
					while($ob = mysql_fetch_object($qfood)){
						$foodid = $ob->foodid;
						$foodname = $ob->foodname;
					  ?>
					  <option value=<?php echo($foodid) ?>><?php echo($foodname) ?></option>
					  <?php } ?>
					  </select>
					  </td>
                      <td height="30" colspan="2" align="left" bgcolor="#F5F5F5" style=" padding-top:10px; padding-bottom:10px; padding-left:0px;  border-top:0px #CCCCCC solid">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="rating" value="5" />
                        <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" />&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="rating" value="4" />
                        <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" />&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="rating" value="3" />
                        <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> &nbsp;&nbsp;&nbsp;
                        <input type="radio" name="rating" value="2" />
                        <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> &nbsp;&nbsp;&nbsp;
                        <input type="radio" name="rating" value="1" />
                        <img src="img/greenstartopi.jpg" /></td>
                    </tr>
                    <tr>
                      <td height="80" colspan="5" align="left" bgcolor="#F5F5F5" style="padding:15px; border-top:0px #CCCCCC dashed">
					  <textarea cols="85" rows="5" style="color: #006699; background-color:#; font:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; border:1px #CCCCCC dotted; padding: 3px;" name="limitedtextarea" onkeydown="limitText(this.form.limitedtextarea,this.form.countdown,150);" 
onkeyup="limitText(this.form.limitedtextarea,this.form.countdown,150);"></textarea></td>
                    </tr>
                    <tr>
                      <td height="31" colspan="2" bgcolor="#F5F5F5">&nbsp;&nbsp;
                        <input type="hidden" name="cafeid" value="<?php echo($cafeid) ?>" />
                        <input type="hidden" name="pagename" value="<?php echo($pagename) ?>" />     
					  <input type="hidden" name="uname" value="<?php echo($uname) ?>" />
					  </td>
                      <td width="8" bgcolor="#F5F5F5">
					  <?php  
						if(isset($_SESSION['rst_msg'])){
						echo($_SESSION['rst_msg']); 
						unset($_SESSION['rst_msg']); }
						?></td>
                      <td width="301" align="center" bgcolor="#F5F5F5" style="padding-bottom:10px; padding-right:15px; padding-top:0px">&nbsp;</td>
                      <td width="301" align="center" bgcolor="#F5F5F5" style="padding-bottom:10px; padding-right:15px; padding-top:0px">
					  <input name="cafefoodsubmit" type="submit" class="btn" value=" Post " /></td>
                    </tr>
                  </table>
            </form></td>
          </tr>
      </table></td>
      <td width="246" align="left" valign="top" style=" border-left:1px #EEEEEE solid">
	  <table width="220" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
        <tr>
          <td height="35" style="padding-left:0px;" valign="top">
		  <div style=" border-bottom:1px #EEEEEE solid; padding-bottom:5px; padding-top:5px; padding-left:10px; background-color:#F5F5F5"><font size="3"><strong>Most Welcomed Food</strong></font></div>
		  </td>
        </tr>
        <tr>
          <td height="35" style="padding-left:10px"><?php 
$qx = mysql_query("SELECT * FROM rockinus.cafefood_memo_info WHERE type='f' AND rating<>'NULL' ORDER BY memoid DESC");
if(!$qx) die(mysql_error());
$no_row = mysql_num_rows($qx);
if($no_row == 0){
	echo("<font size=3 color=#CCCCCC><strong>There is no restaurant found!</strong></font>");
}else if($no_row > 0){ 
	while($obj = mysql_fetch_object($qx)){
	$memoid = $obj->memoid;
	$rating = $obj->rating;
	
	$qfd = mysql_query("SELECT * FROM rockinus.food_info");
	if(!$qfd) die(mysql_error());
	while($o = mysql_fetch_object($qfd)){
	$foodname = $o->foodname;
?>
            <div style="line-height:180%; padding-bottom:5px; width: 230px;">
                <table width="230" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #F5F5F5; margin-bottom:0px; padding-bottom:5px">
                  <tr>
                    <td width="133" height="25" align="left" style=" padding-left:0px; border-bottom:0px dashed #EEEEEE">
					<strong> <?php echo($foodname) ?> </strong></td>
                    <td width="67" height="25" align="center" style="border-bottom:0px dashed #EEEEEE"><input type="hidden" name="sender" value="<?php echo($sender) ?>" />
                        <?php 
							  	for($i=1;$i<=$rating;$i++)echo("<img src=img/greenstartopi.jpg> "); 
								?>                    </td>
                  </tr>
              </table>
            </div>
          <?php }}}?></td>
        </tr>
      </table>
        <table width="20" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="25" style="padding-left:0px;" valign="top"><div style=" border-bottom:1px #EEEEEE solid; padding-bottom:5px; padding-top:5px; padding-left:10px; background-color:#F5F5F5"><font size="3"><strong>Most Welcomed Cafe </strong></font></div></td>
          </tr>
          <tr>
            <td height="35" style="padding-left:10px"><?php 
$qx = mysql_query("SELECT * FROM rockinus.cafefood_memo_info WHERE type='c' ORDER BY memoid DESC");
if(!$qx) die(mysql_error());
$no_row = mysql_num_rows($qx);
if($no_row == 0){
	echo("<font size=3 color=#CCCCCC><strong>There is no restaurant found!</strong></font>");
}else if($no_row > 0){ 
	while($obj = mysql_fetch_object($qx)){
	$memoid = $obj->memoid;
	$rating = $obj->rating;
	
	$qfd = mysql_query("SELECT * FROM rockinus.cafe_info");
	if(!$qfd) die(mysql_error());
	while($o = mysql_fetch_object($qfd)){
	$cafeTitle = $o->cafeTitle;
?>
                <div style="line-height:180%; padding-bottom:10px; width: 230px;">
                  <form action="MemoReplyDelete.php" method="post" style="margin:0">
                    <table width="230" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:5px">
                      <tr>
                        <td width="133" height="40" align="left" style=" padding-left:0px; border-bottom:0px dashed #EEEEEE"><strong> <?php echo($cafeTitle) ?> </strong></td>
                        <td width="67" height="40" align="center" style="border-bottom:0px dashed #EEEEEE"><input type="hidden" name="sender2" value="<?php echo($sender) ?>" />
                            <?php 
							  	for($i=1;$i<=$rating;$i++)echo("<img src=img/greenstartopi.jpg> "); 
								?>
                        </td>
                      </tr>
                    </table>
                  </form>
                </div>
              <?php }}}?></td>
          </tr>
        </table>
	  </td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
<?php  ?>
