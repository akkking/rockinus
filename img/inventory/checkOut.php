<?php include("Header.php");
require("class.phpmailer.php");
include("func.php");
$uname = $_SESSION['uname'];

if(isset($_POST['type'])){
	$type = trim($_POST['type']);
	$_SESSION['type_val'] = $type;
}else if(isset($_POST['date_from'])){
	$iid = $_POST['iid'];
	$type = $_POST['looptype'];	
	$descrip = addslashes($_POST['descrip']);
	$cond = $_POST['cond'];
	$status = $_POST['status'];
	$from=$_POST['date_from'];
	$to=$_POST['date_to'];
	$_SESSION['descrip_val'] = $descrip;
	$tag=1;
	
	if(trim($status)=="empty"&&$tag==1 ){
	$tag = 0;
	show_rst(1,"Where You Wanna Use It?");
	}else $_SESSION['status_val'] = $status;
	
	if($_POST['date_from']==null&&$tag==1){
		$tag = 0;
		show_rst(1,"When Will You Borrow It?");
	}else if($_POST['date_from']!=null)
	{
	 	$_SESSION['status_val'] = $status;
		$from=$_POST['date_from'];
		$arr=explode("/",$from);
		if(count($arr)==3)
		{
			$from=$arr[2]."-".$arr[0]."-".$arr[1];
		}
	}
	
	
	if($_POST['date_to']==null&&$tag==1){
		$tag = 0;
		show_rst(1,"When Will You Return It?");
	}else if($_POST['date_to']!=null)
	{
	 	$_SESSION['status_val'] = $status;
		$to=$_POST['date_to'];
		$arr=explode("/",$to);
		if(count($arr)==3)
		{
			$to=$arr[2]."-".$arr[0]."-".$arr[1];
		}
	}
	
	date_default_timezone_set('America/New_York');
	$trdate=$from;
	$trtime="12:00:00";
	$date1= $trdate." ".$trtime;
	$trdate=$to;
	$date2= $trdate." ".$trtime;
	$curdate = date("Y-m-d");
	$date3 = $curdate." ".$trtime;
	$d1=strtotime($date1); 
	$d2=strtotime($date2);
	$d3=strtotime($date3);
	$hour=round(($d2-$d1)/3600);
	$hour1=round(($d1-$d3)/3600);
	$duration = $hour/24;
	$duration1 = $hour1/24;
	//echo $date1."</br>";
	//echo $date2."</br>";
	//echo $duration;
	
	if(((!is_date($_POST['date_from']))||(!is_date($_POST['date_to'])))&&$tag==1){
		$tag = 0;
		show_rst(1,"Date Form Is Incorrect Or Empty!");
	}else $_SESSION['status_val'] = $status;
	
	if($hour1<0&&$tag==1){
		$tag = 0;
		show_rst(1,"Reservation Date Should Be Later Or Today!");
	}else $_SESSION['status_val'] = $status;
	
	if($hour<=0&&$tag==1){
		$tag = 0;
		show_rst(1,"Return Date Should Be Later Than Borrow Date!");
	}else $_SESSION['status_val'] = $status;
	
	

	
	if($tag==1){
		include 'dbconnect.php';

		//check whether this item is available now
		if(checkAvail($iid))
		{
			if(trim($status)=='Internal' || trim(strtolower($uname))=="admin")
				$sql = "UPDATE inventory.item_info SET tag='N', status='Internal' WHERE iid='$iid';";
			else if(trim($status)=='External')
				$sql = "UPDATE inventory.item_info SET tag='R', status='External' WHERE iid='$iid';";
			$result = mysql_query($sql);
			if (!$result) die('Invalid query: ' . mysql_error());
			
			
			$sql = "INSERT INTO inventory.item_history(iid,uname,cond,descrip,takereturn,trdate,trtime,duration,tbname)VALUES('$iid','$uname','$cond','$descrip','out','$from', '$trtime','$duration','item_history')";
			$result = mysql_query($sql);
			if (!$result) die('Invalid query: ' . mysql_error());
			
			if(trim($status)=='Internal' || trim(strtolower($uname))=="admin")
				show_rst(0,"Check Out Successfully");
			else if(trim($status)=='External'){
				$sql="select * from inventory.item_info where iid='$iid'";
				$result=mysql_query($sql);
				if (!$result) die('Invalid query: ' . mysql_error());
				$row=mysql_fetch_array($result);
				$from = $_POST['date_from'];
				$to = $_POST['date_to'];
				$chkcode=$row['brand']." ".$row['type']." ".$row['model'];
				//email to the admin 
				smtp_mail("ethan.wang2011@gmail.com", "Borrow Request", $from, $to, $uname, $chkcode, "checkout");
				show_rst(0,"Your Request Has Been Sent to Administrator");
			}
		}
	}
}
else
{
	if(isset($_GET['type']))$type=$_GET['type'];
	else $type = "all";
	$_SESSION['type_val']=$type;
}

?>
<?php
if(($uname=="admin")&&(isset($_GET['delete'])))
{
	include 'dbconnect.php';
	$iid = $_GET['delete'];
	$sql = "select * from inventory.item_history where iid='$iid' ";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	$row=mysql_num_rows($result);
	if($row==0)
	{
		$sql = "delete from inventory.item_info where iid='$iid'";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$file_name= "upload/".$iid.".jpg";
		if(file_exists($file_name))
		{
		   unlink($file_name);
		}
		show_rst(0,"Item Has Been Deleted");
	}
	else show_rst(1,"This Item Can Not Be Deleted Now");
}
?>
<div align="left" style="padding-bottom:5px; padding-top:5px; padding-left:10px; background-color:">
  <table width="1024" height="342" border="0" cellpadding="0" cellspacing="0">
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
      <td width="764" height="302" align="center" valign="top">
	  
	    <table width="650" height="18" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:0px; border-bottom:0px dotted #333333; border-top:2px solid #000000">
          <tr>
            <td height="35" align="left" bgcolor="#666666" style="padding-left:10px">
			<a href="checkIn.php"><strong>See My Borrowed Items</strong></a></td>
            <td width="324" height="35" bgcolor="#666666">
			<div align="right" style="padding-right:10px">
			<?php
//Global Variable: 
$page_name = "checkOut.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

if($type=="all"){
	$q = "SELECT count(*) as cnt FROM  inventory.item_info WHERE tag='Y';";
}else 
	$q = "SELECT count(*) as cnt FROM  inventory.item_info WHERE type='$type' AND tag='Y';";
	$t = mysql_query($q);
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
	echo("<a class='one' href=$page_name?type=$type&limit=$limit&page=$prev_page>Previous</a>");
}

//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
	if($a == $page) {
		echo(" <strong>$a</strong>  "); //no link
	}else{ 
		echo("<a class='one' href=$page_name?type=$type&limit=$limit&page=$a> <strong>$a</strong> </a>   ");
	}
}

//Next page:
$next_page = $page + 1;

if($next_page <= $total_pages) {
	echo(" <a class='one' href=$page_name?type=$type&limit=$limit&page=$next_page>Next</a>");
}
echo "";
?>
			</div></td>
          </tr>
        </table>
		<form name="typeselect" action="checkOut.php" method="post" style="margin-bottom:0px; margin-top:0px;width:650px">
	    <table width="650" height="35" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:5px">
          <tr>
            <td width="381" height="35" align="left" bgcolor="#EEEEEE" style="padding-left:5px">
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
            <td width="269" height="35" align="right" bgcolor="#EEEEEE" style="padding-right:10px">
			<?php echo("Currently <strong><font color=#336633>$total_items</font></strong> Item(s) Available in Stock") ?></td>
          </tr>
        </table>
		</form>
		<?php 
		include 'dbconnect.php';
		if($type=="all"){
			$sql = "SELECT * FROM  inventory.item_info WHERE tag='Y' ORDER BY iid DESC LIMIT $set_limit, $limit;";
		}else 
			$sql = "SELECT * FROM  inventory.item_info WHERE type='$type' AND tag='Y' ORDER BY iid DESC LIMIT $set_limit, $limit;";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		while($object = mysql_fetch_object($result)){
			$iid = $object->iid;
			$cond = $object->cond;
			$brand = $object->brand;
			$model = $object->model;
			$loop_type = $object->type;
			$type_img = NULL;
			if(trim($loop_type)=="Camera")$type_img="img/camera.jpg";
			else if(trim($loop_type)=="Lens")$type_img="img/lens.jpg";
			else if($loop_type=="Battery")$type_img="img/battery.jpg";
			else if($loop_type=="Memory"){$type_img="img/memory.jpg";$loop_type="Memory Card";}
			else if($loop_type=="Grip")$type_img="img/grip.jpg";
			if(strtolower(trim($brand))=="other")$brand=NULL;
		?>
		<form name="checkOut" action="checkOut.php" method="post" style="margin-bottom:0px; margin-top:0px">
	    <table width="650" height="140" border="0" cellpadding="0" cellspacing="0" bgcolor="#F9F8FE" style="border-bottom:1px solid  #EEEEEE; margin-bottom:10px">
          <tr>
            <td width="177" rowspan="4" style="padding-top:5px;padding-bottom:5px"><img src=<?php echo("upload/".$iid.".jpg") ?>></td>
            <td width="328" height="25" >
			<span class="STYLE13"><?php echo("<font size=3 color=#CC0033><strong>$loop_type</font> | <font size=3>$brand $model</font></strong>") ?></span> 
			<input name="iid" type="hidden" size="15" class="box" value=
		  <?php echo($iid);?> 
		  >
			<input name="cond" type="hidden" size="15" class="box" value=
		  "<?php echo($cond);?>">
			<input name="looptype" type="hidden" size="15" class="box" value=
		  "<?php echo($type);?>" /></td>
		  <td width="61" height="25" style="padding-top:6px; padding-right:5px">
		  <?php
		  if($uname=='admin')
		  {?>
			<input type="button" value="Delete" onclick="window.location.href='checkOut.php?delete=<?php echo $iid; ?>'" class="btn"/>
			<?php
		  }
			?>
			</td>
            <td width="84" height="25" style="padding-top:5px; padding-right:5px">
			<input name="submit" type="submit" class="btn" value="Check Out" /></td>
          </tr>
          <tr>
            <td height="25" colspan="3"><span class="STYLE13"><?php echo("Condition: <font color=#336633>$cond</font>") ?></span></td>
            </tr>
          <tr>
            <td height="25" colspan="3" style="padding-top:5px; padding-bottom:5px">
		  Use it <select name="status" class="box" />
              <option value="empty">Where?</option>
              <option value="Internal">internally</option>
              <option value="External">externally</option>
              </select>
			 &nbsp;&nbsp;&nbsp; From:
		      <input type="text" class="calendarSelectDate" name="date_from" size="10" />  
		    To: 
		    <input type="text" class="calendarSelectDate" name="date_to" size="10" />
		  <div id="calendarDiv"></div>
		   </td>
          </tr>
          <tr>
            <td height="35" colspan="3" style="padding-top:2px; padding-bottom:10px"><textarea name="descrip" cols="60" rows="4"><?php if(isset($_SESSION['decrip_val'])) echo(trim($_SESSION['descrip_val']));?></textarea></td>
          </tr>
        </table>
	  </form>
	  <?php }?>
	  </td>
      <td width="260" valign="top">
<!--
	  <img src="img/50-cent-2.jpg" />
-->
	  </td>
    </tr>
  </table>
</div>
</body>
</html>
