<?php include("Header.php");
include("func.php");

$uname = $_SESSION['uname'];
if(isset($_POST['type'])){
	$type = trim($_POST['type']);
	$_SESSION['type_val'] = $type;
}else if(isset($_POST['cond'])){
	$iid = $_POST['iid'];
	$cond = $_POST['cond'];
	$type = trim($_POST['looptype']);
	$descrip = addslashes($_POST['descrip']);
	$_SESSION['cond_val'] = $cond;
	$_SESSION['descrip_val'] = $descrip;
	$tag=1;
	
	if( $cond=="empty" && $tag==1 ){
		$tag = 0;
		show_rst(1,"What Is The Condtion of This Item Now?");
	}else $_SESSION['cond_val'] = $cond;
	
	if($tag==1){
		include 'dbconnect.php';
		$sql = "UPDATE inventory.item_info SET tag='Y', cond='$cond' WHERE iid='$iid';";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		
		$sql = "INSERT INTO inventory.item_history(iid,uname,cond,descrip,takereturn,trdate,trtime,duration,tbname)VALUES('$iid','$uname','$cond','$descrip','in',CURDATE(), NOW(),0,'item_history')";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		show_rst(0,"Check In Successful");
	}
}else{
	$type = "all";
	$_SESSION['type_val']=$type;
}
?>
<style type="text/css">
<!--
.STYLE1 {color: #FFFFFF}
-->
</style>

<div align="left" style="padding-bottom:5px; padding-top:5px; padding-left:10px; background-color:">
  <table width="1024" height="142" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" colspan="2" valign="top" align="center">
        <?php
	  	if(isset($_SESSION['rst_msg'])){
			echo($_SESSION['rst_msg']);
	  		unset($_SESSION['rst_msg']);
		}
	  ?>
      </td>
    </tr>
    <tr>
      <td width="764" valign="top" align="center">
	  
	    <table width="650" height="35" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:0px">
          <tr>
            <td height="35" align="left" bgcolor="#666666" style="border-top:2px #000000 solid; padding-left:10px">
			<strong><a href="checkOut.php">See Items in Stock Now</a></td>
            <td width="324" height="35" bgcolor="#666666" style="border-top:2px #000000 solid">
			<div align="right" style="padding-right:10px">
			<?php
//Global Variable: 
$page_name = "checkIn.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

if($type=="all"){
	$q = "SELECT count(DISTINCT(a.iid)) as cnt FROM  inventory.item_history a INNER JOIN inventory.item_info b ON  b.tag='N' AND a.takereturn='out' AND a.uname='$uname' AND a.iid=b.iid;";
}else 
	$q = "SELECT count(DISTINCT(b.iid)) as cnt FROM  inventory.item_history a INNER JOIN inventory.item_info b ON a.takereturn='out' AND a.uname='$uname' AND b.tag='N' AND b.type='$type' AND a.iid=b.iid;";
	$t = mysql_query($q);
	//echo($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}

$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items == 0 )echo("&nbsp;");
$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 5;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
	if((!$limit) || (is_numeric($limit) == false)|| ($limit < 5) || ($limit > 50)) {
	$limit = 1; //default
}

if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items)) { 
	$page = 1; //default 
}

$total_pages = ceil($total_items / $limit);
$set_limit = ($page * $limit) - $limit;
if($total_items>0)echo "Page ";
	$prev_page = $page - 1;
if($prev_page >= 1) { 
	echo("<a class='one' href=$page_name?limit=$limit&page=$prev_page>Previous</a>");
}

//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
	if($a == $page) {
		echo(" <strong>$a</strong>  "); //no link
	}else{ 
		echo("<a class='one' href=$page_name?limit=$limit&page=$a> <strong>$a</strong> </a>   ");
	}
}

//Next page:
$next_page = $page + 1;

if($next_page <= $total_pages) {
	echo(" <a class='one' href=$page_name?limit=$limit&page=$next_page>Next</a>");
}
echo "";
?>
			</div></td>
          </tr>
        </table>
		<form name="typeselect" action="checkIn.php" method="post" style="margin-bottom:0px; margin-top:0px;width:650px">
	    <table width="650" height="35" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:5px">
          <tr>
            <td width="324" height="35" align="left" bgcolor="#EEEEEE" style="padding-left:5px">
			<select name="type" id="type" class="type" onChange="document.typeselect.submit()">
              <option value="all" 
			  <?php 
			  	if(isset($_SESSION['type_val']) && $_SESSION['type_val']=="all")echo(" selected");
			  ?>
			  >All items</option>
              <option value="camera" 
			  <?php 
			  	if(isset($_SESSION['type_val']) && $_SESSION['type_val']=="camera")echo(" selected");
			  ?>
			  >Camera List</option>
              <option value="lens" 
			  <?php 
			  	if(isset($_SESSION['type_val']) && $_SESSION['type_val']=="lens")echo(" selected");
			  ?>
			  >Lens List</option>
              <option value="battery" 
			  <?php 
			  	if(isset($_SESSION['type_val']) && $_SESSION['type_val']=="battery")echo(" selected");
			  ?>
			  >Battery List</option>
              <option value="memory" 
			  <?php 
			  	if(isset($_SESSION['type_val']) && $_SESSION['type_val']=="memory")echo(" selected");
			  ?>
			  >Memory Card List</option>
              <option value="grip" 
			  <?php 
			  	if(isset($_SESSION['type_val']) && $_SESSION['type_val']=="grip")echo(" selected");
			  ?>
			  >Grip List</option>
              <option value="light" 
			  <?php 
			  	if(isset($_SESSION['type_val']) && $_SESSION['type_val']=="light")echo(" selected");
			  ?>
			  >Light List</option>
              <option value="sound" 
			  <?php 
			  	if(isset($_SESSION['type_val']) && $_SESSION['type_val']=="sound")echo(" selected");
			  ?>
			  >Sound List</option>
              <option value="other" 
			  <?php 
			  	if(isset($_SESSION['type_val']) && $_SESSION['type_val']=="other")echo(" selected");
			  ?>
			  >Other</option>
            </select>
			<input name="uname" type="hidden" size="15" class="box" value=
		  "<?php echo($uname);?>"></td>
            <td width="326" height="35" align="right" bgcolor="#EEEEEE" style="padding-right:10px">
			<?php echo("You have <strong><font color=#336633>$total_items</font></strong> Item(s) to Check-In") ?></td>
          </tr>
        </table>
		</form>
		<?php 
		include 'dbconnect.php';
		if($type=="all"){
		$sql = "SELECT * FROM inventory.item_history a INNER JOIN inventory.item_info b ON  b.tag='N' AND a.takereturn='out' AND a.uname='$uname' AND a.iid=b.iid GROUP BY a.iid LIMIT $set_limit, $limit;";
		}else 
			$sql = "SELECT * FROM inventory.item_history a INNER JOIN inventory.item_info b ON a.takereturn='out' AND a.uname='$uname' AND b.tag='N' AND b.type='$type' AND a.iid=b.iid GROUP BY a.iid LIMIT $set_limit, $limit;";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		//echo($sql);
		while($object = mysql_fetch_object($result)){
			$iid = $object->iid;
			$cond = $object->cond;
			$brand = $object->brand;
			$model = $object->model;
			$loop_type = $object->type;
			if($loop_type=="Memory")$loop_type="Memory Card";
			$trdate = $object->trdate;
			$duration = $object->duration;
			$type_img = NULL;
			if(trim($loop_type)=="Camera")$type_img="img/camera.jpg";
			else if(trim($loop_type)=="Lens")$type_img="img/lens.jpg";
			else if(trim($loop_type=="Battery"))$type_img="img/battery.jpg";
			else if(trim($loop_type=="Memory")){$type_img="img/memory.jpg";$loop_type="Memory Card";}
			else if(trim($loop_type=="Grip"))$type_img="img/grip.jpg";
		?>
		<form name="checkOut" action="checkIn.php" method="post" style="margin-bottom:0px; margin-top:0px">
	    <table width="650" height="140" border="0" cellpadding="0" cellspacing="0" bgcolor="#F9F8FE" style="border-bottom:0px dotted  #EEEEEE; margin-bottom:10px">
          <tr>
            <td width="177" rowspan="4" style="padding-top:5px;padding-bottom:5px"><img width="150" height="150" src=<?php echo($type_img) ?>></td>
            <td width="396" height="25" >
			<?php echo("<strong><font size=3 color=#CC0033>$loop_type</font></strong> | <font size=3>$brand $model</font></font>") ?><span style="padding-left:5px">
              <input name="iid" type="hidden" size="15" class="box" value=
		  "<?php echo($iid);?>" />
              <input name="looptype" type="hidden" size="15" class="box" value=
		  "<?php echo($type);?>" />
            </span></td>
            <td width="77" height="25" style="padding-top:5px; padding-right:5px">
			<input name="submit" type="submit" class="btn" value="Check In" /></td>
          </tr>
          <tr>
            <td height="25" colspan="1">
			<span class="STYLE13"><?php echo("Taken at<strong> $trdate</strong> for <strong>$duration</strong> day(s)") ?></span></td>
			<td width="77" height="25" style="padding-top:5px; padding-right:5px">&nbsp;</td>
            </tr>
          <tr>
            <td height="25" colspan="2" style="padding-top:5px; padding-bottom:5px"><span class="STYLE13">The Condition now is  
                <label></label>
                <select name="cond" class="box">
                  <option value="empty"
			  <?php 
			  	if(isset($_SESSION['cond_val'])&&$_SESSION['cond_val']=="empty")
			  	echo(" selected");
			  ?>
			  >Select One</option>
                  <option value="Brand New"
			  <?php 
			  	if(isset($_SESSION['cond_val'])&&$_SESSION['cond_val']=="Brand New")
			  	echo(" selected");
			  ?>
			  >Brand New</option>
                  <option value="Like New"
			  <?php 
			  	if(isset($_SESSION['cond_val'])&&$_SESSION['cond_val']=="Like New")
			  	echo(" selected");
			  ?>
			  >Like New</option>
                  <option value="Average"
			  <?php 
			  	if(isset($_SESSION['cond_val'])&&$_SESSION['cond_val']=="Average")
			  	echo(" selected");
			  ?>
			  >Average</option>
                  <option value="Broken"
			  <?php 
			  	if(isset($_SESSION['cond_val'])&&$_SESSION['cond_val']=="Broken")
			  	echo(" selected");
			  ?>
			  >Broken</option>
                </select>
                </select>			  
              </span></td>
          </tr>
          <tr>
            <td height="35" colspan="2" style="padding-top:2px; padding-bottom:2px"><textarea name="descrip" cols="60" rows="4"><?php if(isset($_SESSION['decrip_val'])) echo(trim($_SESSION['descrip_val']));else echo ""?></textarea></td>
          </tr>
        </table>
	  </form>
	  <?php } 
	  
	 	$sql = "SELECT a.status FROM inventory.item_info a INNER JOIN inventory.user_info b ON b.uname='$uname' AND a.status='External';";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		//echo($sql);
		$object = mysql_fetch_object($result);
	?>
	  <table width="650" height="18" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:0px; margin-top:10px">
        <tr>
          <td height="35" align="left" bgcolor="#666666" style="border-top:2px #000000 solid; padding-left:10px">&nbsp;</td>
          <td width="324" height="35" bgcolor="#666666" style="border-top:2px #000000 solid"><div align="right" style="padding-right:10px">
              <?php
//Global Variable: 
$page_name = "checkIn.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

$q = "SELECT count(DISTINCT(a.iid)) as cnt FROM inventory.item_history a INNER JOIN inventory.item_info b ON a.uname='$uname' AND b.tag='R' AND a.iid=b.iid;";
$t = mysql_query($q);
//echo($q);
if(!$t) die("Error quering the Database: " . mysql_error());
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items == 0 )echo("&nbsp;");
$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 5;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
	if((!$limit) || (is_numeric($limit) == false)|| ($limit < 5) || ($limit > 50)) {
	$limit = 1; //default
}

if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items)) { 
	$page = 1; //default 
}

$total_pages = ceil($total_items / $limit);
$set_limit = ($page * $limit) - $limit;
if($total_items>0)echo "Page ";
	$prev_page = $page - 1;
if($prev_page >= 1) { 
	echo("<a href=$page_name?limit=$limit&page=$prev_page>Previous</a>");
}

//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
	if($a == $page) {
		echo(" <strong>$a</strong>  "); //no link
	}else{ 
		echo("<a href=$page_name?limit=$limit&page=$a> <strong>$a</strong> </a>   ");
	}
}

//Next page:
$next_page = $page + 1;

if($next_page <= $total_pages) {
	echo(" <a href=$page_name?limit=$limit&page=$next_page>Next</a>");
}
echo "";
?>
          </div></td>
        </tr>
      </table>
	  <table width="650" height="35" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:5px">
        <tr>
          <td width="248" height="35" align="left" bgcolor="#EEEEEE" style="padding-left:5px">&nbsp;</td>
          <td width="402" height="35" align="right" bgcolor="#EEEEEE" style="padding-right:10px">
		  <?php echo("You have <strong><font color=#336633>$total_items</font></strong> Item(s) Wait for Approval") ?></td>
        </tr>
      </table>
	  <?php 
		include 'dbconnect.php';
		$sql = "SELECT * FROM inventory.item_history a INNER JOIN inventory.item_info b ON  b.tag='R' AND a.takereturn='out' AND a.uname='$uname' AND a.iid=b.iid GROUP BY a.iid LIMIT $set_limit, $limit;";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		//echo($sql);
		while($object = mysql_fetch_object($result)){
			$iid = $object->iid;
			$cond = $object->cond;
			$brand = $object->brand;
			$model = $object->model;
			$loop_type = $object->type;
			if($loop_type=="Memory")$loop_type="Memory Card";
			$trdate = $object->trdate;
			$trtime = $object->trtime;
			$duration = $object->duration;
		?>
        <table width="650" height="45" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px dotted  #CCCCCC; margin-bottom:10px">
          <tr>
            <td width="293" height="45" style="padding-top:5px;padding-bottom:5px; padding-left:5px">
			<?php echo("<font size=3 color=blue><strong>$loop_type</strong></font> <font size=3>| $brand $model</font>") ?><span class="STYLE13">
              <label></label>
              </select>
            </span></td>
            <td width="143" height="45" style="padding-top:5px;padding-bottom:5px">
			<span class="STYLE13"><?php echo("For <strong>$duration</strong> day(s)") ?></span></td>
            <td width="214" height="45" style="padding-top:5px;padding-bottom:5px">
			<span class="STYLE13"><?php echo("<font color=#cccccc>Requested on</font> $trdate | $trtime") ?></span></td>
          </tr>
        </table>
      <?php } ?>	  </td>
      <td width="260" valign="top"><img src="img/50-cent-2.jpg" /></td>
    </tr>
  </table>
</div>
</body>
</html>
