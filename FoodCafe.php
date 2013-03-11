<?php include("Header.php"); ?>
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="120" align="left" valign="top" style="padding-left:13px; border-left:0px #EEEEEE solid">
	  <table width="752" border="0" cellpadding="0" cellspacing="0" style="border:1px #DDDDDD solid">
	  <tr>
	  <td width="750">
	  <table width="750" height="35" border="0" cellpadding="0" cellspacing="0" bgcolor="<?php echo($_SESSION['hcolor']) ?>" style="border-top:#999999 solid 1; margin-bottom:-2px">
        <tr>
          <td height="35" align="left" style="padding-left:5px;"><div align="center" style="border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: #CC3300; padding-bottom:5px; padding-top:5px; width:100px"><a href="postCafe.php"><strong>+ Post Cafe </strong></a></div></td>
          <td width="109" height="35" align="right" valign="middle" style="border-right: 0px dotted #999999; padding-right:5px;"></div>
          </td>
        </tr>
		</table>
		<table width="750" height="30" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="30" colspan="3" align="right" bgcolor="#F5F5F5" style="padding-right:15px; border-bottom:1px #CCCCCC dashed">
		  &nbsp;
		    <?php if(isset($_SESSION['rst_msg'])){
				  			echo($_SESSION['rst_msg']);
							unset($_SESSION['rst_msg']);
				  }?>		  </td>
          <td width="244" height="30" colspan="2" align="right" bgcolor="#F5F5F5" style="padding-right:15px; border-bottom:1px #CCCCCC dashed">
		  <?php
$page_name = "eventList.php";

include 'dbconnect.php';
 
$q = "SELECT count(*) as cnt FROM rockinus.cafe_info";
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 15;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
if((!$limit) || (is_numeric($limit) == false)|| ($limit < 15) || ($limit > 50)) {
	$limit = 1; //default
}
 
if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items)) { 
	$page = 1; //default 
}
 
//calculate total pages
$total_pages = ceil($total_items / $limit);
$set_limit = ($page * $limit) - $limit;
//echo "Total Pages: $total_pages <br/>";
if ($total_items != 0 )echo "<font color=black>Page</font> ";
//prev. page
$prev_page = $page - 1;
if($prev_page >= 1) { 
	echo("<a href=$page_name?limit=$limit&page=$prev_page><font color=black>Previous</font></a>");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo(" <strong><font color=black>$a</font></strong> "); //no link
}else{ 
	echo("<a href=$page_name?limit=$limit&page=$a class=one> <strong>$a </strong></a>   ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo(" <a href=$page_name?limit=$limit&page=$next_page><font color=black>Next</font></a>");
}
if ($total_items != 0 )echo "";
?></td>
          </tr>
      </table>
	  <?php
if ($total_items == 0 )echo("<br><br><br><div align=center><font color=$_SESSION[hcolor] size=4><strong>There is, No Cafe Posted ...</strong></font></div><br><br><br>");
else{
		$q = mysql_query("SELECT * FROM rockinus.cafe_info ORDER BY cafeid DESC LIMIT $set_limit, $limit");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		
		while($object = mysql_fetch_object($q)){
			$cafeid = $object->cafeid;
			$creater = $object->creater;
			$cafeTitle = $object->cafeTitle;
			$location = $object->location;
			$rate = $object->rate;
			$category = $object->category;
			$descrip = $object->descrip;
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			
			$foodList = NULL;
			$qfood = mysql_query("SELECT * FROM rockinus.food_info WHERE cafeid='$cafeid'");
			if(!$qfood) die(mysql_error());
			while($ob = mysql_fetch_object($qfood)){
				if($foodList != NULL)$foodList.=",";
				$foodname = $ob->foodname;
				$foodList.= $foodname;
			}
			?>
      <table width="680" border="0" align="center" cellpadding="0" cellspacing="0" style="border-bottom:1 #EEEEEE solid; margin-bottom:5; margin-right:3; padding-top:3; padding-bottom:5; margin-left:15px; margin-right:15px; margin-top:15px">
        <tr>
          <td width="105" height="105" align="center" style="padding-top:5; padding-bottom:15">
              <?php 
				if($category=="Turkish")
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/TurkishKebabIcon.jpg width=100 height=100 style=border:0></a>");
				else if($category=="Indian")
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/IndianFoodIcon.jpg width=100 height=100 style=border:0></a>");
				else if($category=="Chinese")
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/ChineseFoodIcon.jpg width=100 height=100 style=border:0></a>");
				else if($category=="Japanese")
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/JapaneseSushiIcon.jpg width=100 height=100 style=border:0></a>");			else if($category=="Mideastern")
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/MideasternFoodIcon.jpg width=100 height=100 style=border:0></a>");	else if($category=="Thai")
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/ThaiFoodIcon.jpg width=100 height=100 style=border:0></a>");
				else if($category=="Korean")
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/KoreanFoodIcon.jpg width=100 height=100 style=border:0></a>");
				else
				echo("<a href='cafeDetail.php?cafeid=$cafeid' class='one'><img src=img/NoUserIcon250.jpg width=100 style=border:0></a>");
				?>
          </td>
          <td width="546" colspan="2" valign="top"><table width="600" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="436" height="35" valign="middle" style="padding-left:20px">
				<font size="3"> <a class="one" href="cafeDetail.php?cafeid=<?php echo($cafeid) ?>"><strong><? echo($cafeTitle) ?></strong></a> | <a class="one" href="cafeDetail.php?cafeid=<?php echo($cafeid) ?>"><strong><? echo("<font color=#999999>$category food</font>") ?></strong></a></font></td>
                <td height="35" valign="middle" align="right" style="padding-right:0px"><font color="#999999" size="1">Posted on <?php echo("$pdate")?></font></td>
              </tr>
              <tr>
                <td height="35" align="left" valign="middle" style="padding-left:20px">
				<font size="2">Menu - </font> 
				<?php echo("<strong><font color=#CC3300>$foodList</font></strong>")?></td>
                <td width="164" valign="middle" align="right" style="padding-left:0">
				<font size="2">
				<?php
				$qc = mysql_query("SELECT count(*) AS cnt, SUM(rating) AS rating_sum 
									FROM rockinus.cafefood_memo_info 
									WHERE (cafefoodid='$cafeid' AND type='c') 
									OR (type='f' AND cafefoodid IN (SELECT foodid FROM rockinus.food_info WHERE cafeid='$cafeid'))");
				if(!$qc) die("Error quering the Database: " . mysql_error());
				$c = mysql_fetch_object($qc);
				$cmt_cnt = $c->cnt;
				$rating_sum = $c->rating_sum;
				$rating_level = $rating_sum/$cmt_cnt;
				echo($cmt_cnt." comments");
				?>				
				</font>
				</td>
              </tr>
            </table>
            <table width="600" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="35" colspan="2" align="left" valign="middle" style="padding-left:20px">
				  <font size="2">Location:</font>				  
				  <?php echo($location)?>				  </td>
                  <td width="165" height="35" align="right" valign="middle" style="padding-left:0">
				  <font color="#999999" size="1">Overall : </font> 
				  <?php 
					  	for($i=1;$i<=$rating_level;$i++)echo("<img src=img/yellowstar.jpg width=13px> "); 
					?>					</td>
                </tr>
                <tr>
                  <td width="434" height="10" align="right" valign="middle" style="padding-right:15px">&nbsp;</td>
                  <td height="10" colspan="2" align="right" valign="top" style="padding-left:0">&nbsp;</td>
                </tr>
            </table></td>
        </tr>
      </table>
      <?php } }?>
	  </td></tr></table>
	  <br />
	  </td>
      <td width="876" align="left" valign="top" style="padding-left:5px; border-right:0px #DDDDDD solid; padding-bottom:5px"><table width="240" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px">
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
                    <td width="138" height="25" align="left" style=" padding-left:0px; border-bottom:0px dashed #EEEEEE; line-height:150%">
					<font size="2" color="#000000"><?php echo($foodname) ?></font></td>
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
                    <td width="138" height="25" align="left" style=" padding-left:0px; border-bottom:0px dashed #EEEEEE;  line-height:150%">
					<a href="cafeDetail.php?cafeid=<?php echo($key) ?>"><font size="2" color="#333333"><?php echo($cafeTitle) ?></font></a></td>
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
