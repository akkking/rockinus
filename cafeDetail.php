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
	  <table width="760" height="35" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-top:#CCCCCC solid 2; border-top:#CCCCCC solid 1; margin-bottom:2px">
        <tr>
          <td width="623" height="50" align="center" style="padding-left:0px; color:#FFFFFF"><strong><font size="4" color="black"><? echo($cafeTitle) ?></font></strong> </td>
          <td width="137" height="50" align="right" valign="middle" style="border-right: 0px dotted #999999; padding-right:5px;"><div align="center" style="border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: #CC3300; height:20px; padding-bottom:5; padding-top:5; margin-right:5px; display:inline; padding-left:10px; padding-right:10px"><a href="postCafe.php"><strong>+ Post New</strong></a></div>
              </div>
          </td>
        </tr>
      </table>
        <table width="753" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-bottom:40px; margin-right:0px; padding-top:5; padding-bottom:5; margin-left:0px; margin-top:0px; border-left:1px #EEEEEE solid; border-right:0px #EEEEEE solid">
          <tr>
            <td width="103" height="192" align="center" style="padding-left:10px; padding-top:15px" valign="top"><?php 
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
            <td width="650" rowspan="2" valign="top"><table width="550" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="15" align="right" class="STYLE1" style="padding-right:15px">&nbsp;</td>
                <td height="15" colspan="2" align="left" valign="middle" class="STYLE1" style="padding-left:0px">&nbsp;</td>
              </tr>
              <tr>
                <td width="144" height="35" align="right" class="STYLE1" style="padding-right:15px"><strong>Food type:</strong></td>
                <td height="35" colspan="2" align="left" valign="middle" class="STYLE1" style="padding-left:0px"><?php echo("$category Food")?></td>
              </tr>
              <tr>
                <td width="144" height="35" align="right" class="STYLE1" style="padding-right:15px"><strong>Average rate:</strong></td>
                <td height="35" colspan="2" valign="middle" class="STYLE1" style="padding-left:0"><?php echo("<strong><font color=#CC3300>$ $rate / Person</font></strong>")?></td>
              </tr>
              <tr>
                <td width="144" height="35" align="right" class="STYLE1" style="padding-right:15px"><strong>Location:</strong></td>
                <td height="35" colspan="2" valign="middle" class="STYLE1" style="padding-left:0"><?php echo("$location")?></td>
              </tr>
              <tr>
                <td width="144" height="35" align="right" valign="middle" class="STYLE1" style="padding-right:15px"><strong>Posted by: </strong> </td>
                <td height="35" colspan="2" valign="middle" class="STYLE1" style="padding-left:0"><?php echo("<a href=RockerDetail.php?uid=$creater class=one><strong>$creater</strong></a> &nbsp;&nbsp;$pdate | ".substr($ptime,0,5))?> <font color="#CCCCCC"> </font> </td>
              </tr>
              <tr>
                <td width="144" height="35" align="right" valign="top" style="padding-right:15px; padding-top:10px"><strong>Menu: </strong></td>
                <td width="218" height="35" valign="top" style="padding-top:10; padding-bottom:10px"><?php 
					$foodList = NULL;
					$qf = mysql_query("SELECT * FROM rockinus.food_info WHERE cafeid='$cafeid'");
					if(!$qf) die(mysql_error());
					while($o = mysql_fetch_object($qf)){
						$foodname = $o->foodname;
						echo("<div style=padding-bottom:20px><strong><font color=$_SESSION[hcolor]>$foodname</font></strong></div>");
					}
					?></td>
                <td width="188" valign="top" align="right" style="padding-top:5; padding-bottom:10px"><div align="center" class="STYLE23" style="border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: #CC3300; padding-bottom:5; padding-top:5; margin-right:5px; padding-left:10px; padding-right:10px; display:inline"><a href="postCafe.php"><strong>+ Add food</strong></a></div></td>
              </tr>
              <tr>
                <td height="100" colspan="3" align="left" valign="top" style="padding:10px; padline-height:180%; border-top:0px #EEEEEE solid; border-bottom:0px #CCCCCC solid">
				  <font size=3 color="#999999"><?php
									echo("\"");
									$len = strlen($descrip);
									$single_line_len = 80;
									$line_no = intval($len/$single_line_len); 
									if($line_no==0)echo($descrip."\"");
									else{
										for($i=0;$i<$line_no;$i++) {
											if($i==$line_no-1 && $i!=0)
												$str = substr($descrip,$i*$single_line_len, $single_line_len);
											else
												$str = substr($descrip,$i*$single_line_len, $single_line_len)."<br>";
											echo($str);
										}
										echo("\"");
									}
									?>
									</font></td>
              </tr>
              
            </table></td>
          </tr>
          <tr>
            <td height="28" align="center" valign="top" style="padding-left:10px; padding-top:15px; border-bottom:px #CCCCCC solid">&nbsp;</td>
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
                  <table width="750" height="63" border="0" cellpadding="0" cellspacing="0" style="border-top:1px dashed #DDDDDD; margin-bottom:5px">
                    <tr>
                      <td width="245" height="40" align="left" style=" padding-left:8px; border-bottom:0px dashed #EEEEEE">
					  <strong>
					  <?php echo($sender." <font color=#999999>commented $type:</font>") ?>					  </strong></td>
                      <td width="280" height="40" align="center" style="border-bottom:0px dashed #EEEEEE">
					  <input type="hidden" name="sender" value="<?php echo($sender) ?>" />
                      <input type="hidden" name="cafeid" value="<?php echo($cafeid) ?>" />
                      <input type="hidden" name="ddescrip" value="<?php echo($descrip) ?>" size="151" />
                      <input type="hidden" name="pdate" value="<?php echo($pdate) ?>" />
                      <input type="hidden" name="ptime" value="<?php echo($ptime) ?>" />
                      <input type="hidden" name="pagename" value="CafeDetail.php" />                     
					  <?php 
							  	for($i=1;$i<=$rating;$i++)echo("<img src=img/greenstartopi.jpg> "); 
								?>				      </td>
                      <td width="86" height="40" align="right" style="border-bottom:0px dashed #EEEEEE">&nbsp;<?php if($uname==$sender){?>
                          <input type="submit" class="btn" name="submit2" value="delete" ? />
                      <?php } ?></td>
                      <td width="139" height="40" align="right" style="padding-right:10px; border-bottom:0px dashed #EEEEEE"><font color="#999999" size="1"> <?php echo("$pdate | ".substr($ptime,0,5)) ?> </font> </td>
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
                  <table width="735" border="0" cellpadding="0" cellspacing="0" style="border:1px #DDDDDD solid; margin-bottom:20px; margin-left:5px">
                    <tr>
                      <td height="40" align="left" valign="middle" bgcolor="#EEEEEE" style=" padding-top:10px; padding-bottom:5px; padding-left:15px; border-top:0px #CCCCCC solid">
					  <font size="2"><strong>Comment:</strong></font></td>
				      <td height="40" colspan="2" align="left" valign="middle" bgcolor="#EEEEEE" style=" padding-top:10px; padding-bottom:5px; padding-left:10px; border-top:0px #CCCCCC solid"><select name="foodList">
                        <option value="<?php echo("cafe".$cafeid) ?>" selected="selected"><?php echo($cafeTitle) ?></option>
                        <?php 
					$qfood = mysql_query("SELECT * FROM rockinus.food_info WHERE cafeid='$cafeid'");
					if(!$qfood) die(mysql_error());
					while($ob = mysql_fetch_object($qfood)){
						$foodid = $ob->foodid;
						$foodname = $ob->foodname;
					  ?>
                        <option value="<?php echo($foodid) ?>"><?php echo($foodname) ?></option>
                        <?php } ?>
                      </select></td>
				      <td height="40" align="left" valign="bottom" bgcolor="#EEEEEE" style=" padding-top:10px; padding-bottom:5px; padding-left:15px; border-top:0px #CCCCCC solid">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="25" colspan="4" align="left" style=" padding-top:10px; padding-bottom:5px; padding-left:15px; border-top:0px #CCCCCC solid">&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="rating" value="5" />
                          <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" />&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="rating" value="4" />
                          <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" />&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="rating" value="3" />
                          <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> &nbsp;&nbsp;&nbsp;
                          <input type="radio" name="rating" value="2" />
                          <img src="img/greenstartopi.jpg" /> <img src="img/greenstartopi.jpg" /> &nbsp;&nbsp;&nbsp;
                          <input type="radio" name="rating" value="1" />
                          <img src="img/greenstartopi.jpg" />					  </td>
                    </tr>
                    <tr>
                      <td height="80" colspan="4" align="left" style="padding:15px; border-top:0px #CCCCCC dashed">
					  <textarea cols="100" rows="5" style="color: #006699; background-color:#; font:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; border:1px #CCCCCC dotted; padding: 3px;" name="limitedtextarea"></textarea></td>
                    </tr>
                    <tr>
                      <td height="31">&nbsp;&nbsp;
                        <input type="hidden" name="cafeid" value="<?php echo($cafeid) ?>" />
                        <input type="hidden" name="pagename" value="<?php echo($pagename) ?>" />     
					  <input type="hidden" name="uname" value="<?php echo($uname) ?>" />					  </td>
                      <td width="157">
					  <?php  
						if(isset($_SESSION['rst_msg'])){
						echo($_SESSION['rst_msg']); 
						unset($_SESSION['rst_msg']); }
						?></td>
                      <td width="207" align="center" style="padding-bottom:10px; padding-right:15px; padding-top:0px">&nbsp;</td>
                      <td width="301" align="center" style="padding-bottom:10px; padding-right:15px; padding-top:0px">
					  <input name="cafefoodsubmit" type="submit" class="btn" value=" Post " /></td>
                    </tr>
                  </table>
            </form></td>
          </tr>
      </table></td>
      <td width="246" align="left" valign="top" style=" border-left:1px #EEEEEE solid"><table width="240" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px">
        <tr>
          <td height="35" bgcolor="#F5F5F5" style="padding-left:10px; border-bottom:1px #DDDDDD solid; border-top:1px #DDDDDD solid;"><font size="3"><strong>Food ranking</strong></font>
              <?php
$array_food = NULL; 
$array_food_num = NULL; 
$last_cafefoodid = NULL;
$qx = mysql_query("SELECT * FROM rockinus.cafefood_memo_info WHERE type='f' AND rating>0 ORDER BY cafefoodid");
if(!$qx) die(mysql_error());
$no_row = mysql_num_rows($qx);
echo("<font color=#999999> (Based on $no_row votes)</font>");
?></td>
        </tr>
        <tr>
          <td height="35" style="padding-left:10px"><?php
$array_food = NULL; 
$array_food_num = NULL; 
$last_cafefoodid = NULL;
$qx = mysql_query("SELECT * FROM rockinus.cafefood_memo_info WHERE type='c' AND rating>0 ORDER BY cafefoodid");
if(!$qx) die(mysql_error());
$no_row = mysql_num_rows($qx);
//echo($no_row);
if($no_row == 0){
	echo("<font size=3 color=#CCCCCC><strong>There is no restaurant found!</strong></font>");
}else if($no_row > 0){ 
	//$array_food = NULL;
	while($obj = mysql_fetch_object($qx)){
		$memoid = $obj->memoid;
		$rating = $obj->rating;
		$cafefoodid = $obj->cafefoodid;
		if($last_cafefoodid==NULL){
			$last_cafefoodid = $cafefoodid;
			$array_food[$cafefoodid] = $rating;
			$array_food_num[$cafefoodid] = 1;
		}else if($last_cafefoodid == $cafefoodid){			
			$array_food[$cafefoodid] += $rating;
			$array_food_num[$cafefoodid] += 1;
		}else{			
			$last_cafefoodid = $cafefoodid;
			$array_food[$cafefoodid] = $rating;
			$array_food_num[$cafefoodid] = 1;
		}
	}	
	
	arsort($array_food);
	foreach($array_food as $key=>$value){
		$qfd = mysql_query("SELECT * FROM rockinus.food_info WHERE cafeid='$key'");
		if(!$qfd) die(mysql_error());
		$o = mysql_fetch_object($qfd);
		$foodname = $o->foodname;
		
		$rating_sum = $value;
		$rating_cnt = $array_food_num[$key]; 
    	$rating_level = $rating_sum / $rating_cnt;
		?>
              <div style="line-height:180%; padding-bottom:0px; width: 230px;">
                <table width="230" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #F5F5F5; margin-bottom:0px; padding-bottom:5px">
                  <tr>
                    <td width="138" height="25" align="left" style=" padding-left:0px; border-bottom:0px dashed #EEEEEE; line-height:150%"><font size="2"><?php echo($foodname) ?></font></td>
                    <td width="102" height="25" align="right" style="border-bottom:0px dashed #EEEEEE"
					><input type="hidden" name="sender22" value="<?php echo($sender) ?>" />
                        <?php 
							  	for($i=1;$i<=$rating_level;$i++)echo("<img src=img/yellowstar.jpg width=13px> "); 
								?>
                    </td>
                  </tr>
                </table>
              </div>
            <?php }}?></td>
        </tr>
      </table>
        <table width="240" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px">
          <tr>
            <td height="35" bgcolor="#F5F5F5" style="padding-left:10px; border-bottom:1px #DDDDDD solid; border-top:1px #DDDDDD solid;"><font size="3"><strong>Cafe ranking</strong></font>
                <?php
$array_food = NULL; 
$array_food_num = NULL; 
$last_cafefoodid = NULL;
$qx = mysql_query("SELECT * FROM rockinus.cafefood_memo_info WHERE type='c' AND rating>0 ORDER BY cafefoodid");
if(!$qx) die(mysql_error());
$no_row = mysql_num_rows($qx);
echo("<font color=#999999> (Based on $no_row votes)</font>");
?></td>
          </tr>
          <tr>
            <td height="35" style="padding-left:10px"><?php
$array_cafe = NULL; 
$array_cafe_num = NULL; 
$last_cafefoodid = NULL;
$qx = mysql_query("SELECT * FROM rockinus.cafefood_memo_info WHERE type='c' AND rating>0 ORDER BY cafefoodid");
if(!$qx) die(mysql_error());
$no_row = mysql_num_rows($qx);
//echo($no_row);
if($no_row == 0){
	echo("<font size=3 color=#CCCCCC><strong>There is no restaurant found!</strong></font>");
}else if($no_row > 0){ 
	//$array_food = NULL;
	while($obj = mysql_fetch_object($qx)){
		$memoid = $obj->memoid;
		$rating = $obj->rating;
		$cafefoodid = $obj->cafefoodid;
		if($last_cafefoodid==NULL){
			$last_cafefoodid = $cafefoodid;
			$array_cafe[$cafefoodid] = $rating;
			$array_cafe_num[$cafefoodid] = 1;
		}else if($last_cafefoodid == $cafefoodid){			
			$array_cafe[$cafefoodid] += $rating;
			$array_cafe_num[$cafefoodid] += 1;
		}else{			
			$last_cafefoodid = $cafefoodid;
			$array_cafe[$cafefoodid] = $rating;
			$array_cafe_num[$cafefoodid] = 1;
		}
	}	
	
	arsort($array_cafe);
	foreach($array_cafe as $key=>$value){
		$qfd = mysql_query("SELECT * FROM rockinus.cafe_info WHERE cafeid='$key'");
		if(!$qfd) die(mysql_error());
		$o = mysql_fetch_object($qfd);
		$cafeTitle = $o->cafeTitle;
		
		$rating_sum = $value;
		$rating_cnt = $array_cafe_num[$key]; 
    	$rating_level = $rating_sum / $rating_cnt;
		?>
                <div style="line-height:180%; padding-bottom:0px; width: 230px;">
                  <table width="230" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #F5F5F5; margin-bottom:0px; padding-bottom:5px">
                    <tr>
                      <td width="138" height="25" align="left" style=" padding-left:0px; border-bottom:0px dashed #EEEEEE;  line-height:150%"><font size="2"><?php echo($cafeTitle) ?></font></td>
                      <td width="102" height="25" align="right" style="border-bottom:0px dashed #EEEEEE"
					><input type="hidden" name="sender2" value="<?php echo($sender) ?>" />
                          <?php 
							  	for($i=1;$i<=$rating_level;$i++)echo("<img src=img/yellowstar.jpg width=13px> "); 
								?>
                      </td>
                    </tr>
                  </table>
                </div>
              <?php }}?></td>
          </tr>
        </table></td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
<?php  ?>
