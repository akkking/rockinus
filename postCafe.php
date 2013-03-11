<?php include("Header.php"); 

include 'dbconnect.php';
$uname = $_SESSION['usrname'];

if(isset($_POST['cafeForm'])){
	$cafeTitle = addslashes($_POST['cafeTitle']);
	$foodList = addslashes($_POST['foodList']);
	$location = $_POST['location'];
	$category = $_POST['category'];
	$rate = $_POST['rate'];
	$descrip = addslashes($_POST['descrip']);
	
	$sql_1 = mysql_query("INSERT INTO rockinus.cafe_info (creater, cafeTitle, url, location, rate, category, descrip, pdate, ptime) VALUE('$uname','$cafeTitle', 'NULL', '$location', '$rate', '$category', '$descrip', CURDATE(), NOW());");
	if(!$sql_1) die(mysql_error());
	
	$qs = mysql_query("SELECT * FROM rockinus.cafe_info WHERE cafeTitle='$cafeTitle' ORDER BY pdate DESC, ptime DESC");
	if(!$qs) die(mysql_error());
//	$no_row = mysql_num_rows($qs);
	$obj = mysql_fetch_object($qs);
	$cafeid = $obj->cafeid;
	
	if( $foodList!=NULL && strlen($foodList)>0 && count(explode(",",$foodList))>0 ){
		$foodname = explode(",",$foodList);
		for($i=0;$i<count($foodname);$i++){
			$food = $foodname[$i];
			$sql_2 = mysql_query("INSERT INTO rockinus.food_info (foodname, cafeid, rate, descrip) VALUE('$food','$cafeid', '0.00',NULL)");
			if(!$sql_2) die(mysql_error());
		}
	}
	
	$_SESSION['rst_msg'] = "<strong><font color=#336633>Successful</font></strong>";
	//header("location:FoodCafe.php");
//		mysql_close($link);
	}
?>
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="120" align="left" valign="top" style="padding-left:13px; border-left:0px #EEEEEE solid">
	  <table width="752" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid">
	  <tr>
	  <td width="750"><table border="0" cellspacing="0" cellpadding="0" style="border-left:0px #CCCCCC dotted" width="748">
        <tr>
          <td width="748" align="left" valign="top" style="margin-right:15px; margin-left:10px;"><table width="748" height="40" border="0" cellpadding="0" cellspacing="0" bgcolor="<?php echo($_SESSION['hcolor']) ?>" style="border:#CCCCCC dotted 0; margin-bottom:-2px">
              <tr>
                <td width="180" height="35" align="left" style="padding-left:15px;">
				<strong><font size="3" color="#FFFFFF">Posting Cafe... </font></strong>				</td>
                <td height="35" align="right" valign="middle" style="padding-right:10px">
				<div align="center" style="border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: #CC3300; padding-bottom:5px; padding-top:5px; width:100px"><a href="FoodCafe.php"><strong> Cafe List </strong></a></div>
				</td>
                </tr>
            </table>
              <form action="postCafe.php" method="post">
                <table width="748" height="452" border="0" cellpadding="0" cellspacing="0" style="border:1px #DDDDDD solid; border-top:0px">
                  <tr>
                    <td width="222" height="22" style="padding-left:10px" align="right">&nbsp;</td>
                    <td height="22" colspan="2" style="padding-left:10px">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="40" style="padding-right:10px" align="right"><strong>Cafe Name </strong></td>
                    <td height="40" colspan="2" style="padding-left:10px"><input type="text" name="cafeTitle" size="50"/></td>
                  </tr>
                  <tr>
                    <td height="40" style="padding-right:10px" align="right"><strong>What kind of food </strong></td>
                    <td height="40" colspan="2" style="padding-left:10px"><select name="category">
                        <option value="blank">Category</option>
                        <option value="American">American</option>
                        <option value="Italien">Italien</option>
                        <option value="Chinese">Chinese</option>
                        <option value="Turkish">Turkish</option>
                        <option value="Japanese">Japense</option>
                        <option value="Korean">Korean</option>
                        <option value="Mexican">Mexican</option>
                        <option value="Indian">Indian</option>
                        <option value="Mideastern">Mideastern</option>
                        <option value="Thai">Thai</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td height="40" style="padding-right:10px" align="right"><strong>Which food you suggest </strong></td>
                    <td height="40" colspan="2" style="padding-left:10px"><input type="text" name="foodList" size="65"/></td>
                  </tr>
                  <tr>
                    <td height="40" style="padding-right:10px" align="right"><strong>$ Overall Rate /Person </strong></td>
                    <td width="174" height="40" style="padding-left:10px"><input type="text" name="rate" size="5"/>
                        <div id="calendarDiv"></div></td>
                    <td width="350" style="padding-left:10px" valign="top">
					<font color="#999999">Use comma seperate your suggested foods</font></td>
                  </tr>

                  <tr>
                    <td height="40" style="padding-right:10px" align="right"><strong>Where </strong></td>
                    <td height="40" colspan="2" style="padding-left:10px"><input type="text" name="location" size="50"/></td>
                  </tr>

                  <tr>
                    <td height="170" style="padding-right:10px" align="right"><strong>Description </strong></td>
                    <td colspan="2" valign="top" style="padding-left:10px; padding-top:10px"><label>
                      <textarea name="descrip" cols="65" rows="10"></textarea>
                    </label></td>
                  </tr>
                  <tr>
                    <td height="60" style="padding-right:10px" align="right">&nbsp;</td>
                    <td height="60" colspan="2" valign="top" style="padding-left:10px; padding-top:10px">
					<input name="cafeForm" type="submit" class="btn" value=" Submit " />                    </td>
                  </tr>
                </table>
              </form></td>
        </tr>
      </table></td>
	  </tr></table>
	  <br />
	  </td>
      <td width="876" align="left" valign="top" style="border-left:0px #DDDDDD solid; border-right:0px #DDDDDD solid; padding-left:3px"><table width="240" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px">
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
                    <td width="138" height="25" align="left" style=" padding-left:0px; border-bottom:0px dashed #EEEEEE; line-height:150%"><font size="2" color="#000000"><?php echo($foodname) ?></font></td>
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
                      <td width="138" height="25" align="left" style=" padding-left:0px; border-bottom:0px dashed #EEEEEE;  line-height:150%"><a href="cafeDetail.php?cafeid=<?php echo($key) ?>"><font size="2" color="#333333"><?php echo($cafeTitle) ?></font></a></td>
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
