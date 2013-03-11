<?php include("Header.php");
require("class.phpmailer.php");
include("func.php");

$uname = $_SESSION['uname'];
include 'dbconnect.php';
$sql = "SELECT * FROM inventory.user_info WHERE uname='$uname'";
$result = mysql_query($sql);
if (!$result) die('Invalid query: ' . mysql_error());
$object = mysql_fetch_object($result);
if( trim($object->level)!="Admin" && trim($object->level)!="Manager" )header("location:main.php");

if(isset($_POST['type'])){
	$type = trim($_POST['type']);
	$brand = trim($_POST['brand']);
	$model = $_POST['model'];
	$price = trim($_POST['price']);
	$cond = addslashes($_POST['cond']);
	$file_name = $_FILES['uploaded']['name'];
	$descrip = addslashes($_POST['descrip']);
	$_SESSION['descrip_val'] = $descrip;
	$tag=1;
	
	if($type=="empty" && $tag==1){
		$tag = 0;
		$_SESSION['type_rst_msg']="<font color=red><strong>Category is not selected</strong></font>";
	}else $_SESSION['type_val'] = $type;
	
	if($brand=="empty" && $tag==1){
		$tag = 0;
		$_SESSION['brand_rst_msg']="<font color=red><strong>Brand is not selected</strong></font>";
	}else $_SESSION['brand_val'] = $brand;
	
	if($model==NULL && $tag==1){
		$tag = 0;
		$_SESSION['model_rst_msg']="<font color=red><strong>Model is not entered</strong></font>";
	}else $_SESSION['model_val'] = $model;
	
	if($price==NULL && $tag==1){
		$tag = 0;
		$_SESSION['price_rst_msg']="<font color=red><strong>Price is not entered</strong></font>";
	}else $_SESSION['price_val'] = $price;
		
	if($cond=="empty" && $tag==1){
		$tag = 0;
		$_SESSION['cond_rst_msg']="<font color=red><strong>Condition is not selected</strong></font>";
	}else $_SESSION['cond_val'] = $cond;
	
	if( trim($file_name)==NULL && $tag==1 ){
		$tag=0;
		$_SESSION['tmp_rst_msg']="<font color=red><strong>Select an image for item</strong></font>";
	}else{
		$uploaded_size = ($_FILES["uploaded"]["size"]) / 1024;
		$uploaded_type = $_FILES["uploaded"]["type"];
	}

	//This is our size condition 
	if($uploaded_size > 500 && $tag==1){ 
 		$_SESSION['tmp_rst_msg']="<font color=red><strong>The file cannot be larger than 500KB</strong></font>";			
 		$tag=0; 
	} 
 
	//This is our limit file type condition 
	if( (trim($uploaded_type) != 'image/pjpeg') && (trim($uploaded_type) != 'image/jpeg') && $tag==1  ){ 
 		$_SESSION['tmp_rst_msg']="<font color=red><strong>Only JPG file is valid</strong></font>";			
 		$tag=0;
	}

	if($tag==1){
		include 'dbconnect.php';

		$sql = "INSERT INTO inventory.item_info(type,brand,model,price,cond,SignDate,SignTime,descrip, tag,tbname,status)VALUES('$type','$brand','$model','$price','$cond',CURDATE(), NOW(),'$descrip','Y','item_info','Internal')";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());

		$qresult = mysql_query("SELECT * FROM inventory.item_info ORDER BY iid DESC");
		$row = mysql_fetch_array($qresult);
		$iid = $row['iid'];

		$target = "upload/";
		if(!is_dir($target)) mkdir($target);

		$fileNameParts   = explode( ".", $file_name ); // explode file name to two part
 		$fileExtension   = end( $fileNameParts ); // give extension
 		$fileExtension   = strtolower( $fileExtension ); // convert to lower case
 		$new_file_name   = $iid.".".$fileExtension;  // new file name  
 		$new_file_name   = $target.$new_file_name;

		if( ( trim($file_name)!=NULL ) && move_uploaded_file($_FILES['uploaded']['tmp_name'], $file_name) ) { 
   			include('SimpleImage.php');
   			$image150 = new SimpleImage();
   			$image150->load($file_name);
   			$image150->resizeToWidth(150);
   			$image150->save($new_file_name);
		}

		show_rst(0,"Item Added Successfully");
	}
}else if(isset($_POST['loopname'])){
	$loopname = $_POST['loopname'];
	include 'dbconnect.php';
	$sql = "UPDATE inventory.user_check_info SET tag='A' WHERE uname='$loopname'";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	show_rst(0,"User $loopname Has Been Accepted");
}else if(isset($_POST['iid'])){
	$iid = $_POST['iid'];
	include 'dbconnect.php';
	$sql = "UPDATE inventory.item_info SET tag='N' WHERE iid='$iid'";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	show_rst(0,"Item Request Has Been Approved");
}else{
	if(isset($_SESSION['type_val']))unset($_SESSION['type_val']);
	if(isset($_SESSION['descrip_val']))unset($_SESSION['descrip_val']);
	if(isset($_SESSION['model_val']))unset($_SESSION['model_val']);
	if(isset($_SESSION['price_val']))unset($_SESSION['price_val']);
	if(isset($_SESSION['cond_val']))unset($_SESSION['cond_val']);
	if(isset($_SESSION['brand_val']))unset($_SESSION['brand_val']);
}

if(isset($_POST['item_id']))
{
	$iid = $_POST['item_id'];
	include 'dbconnect.php';
	//get and delete the latest checkout info where iid=$iid from the item_history
	$sql="select MAX(hiid) as hiid from (select * from inventory.item_history where takereturn='out' and iid='$iid' ORDER BY trdate, trtime DESC) as a";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	$row = mysql_fetch_array($result);
	$hiid=$row['hiid']; 
	$sql="delete from inventory.item_history where hiid='$hiid' ";
	$result=mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	//update the item_info where iid=$iid set status to Y
	$sql="update inventory.item_info set tag='Y' where iid='$iid' ";
	$result=mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	//email to the user
	$applier_name=$_POST['applier_name'];
	$sql = "SELECT * FROM inventory.user_check_info WHERE uname='$applier_name';";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	$row = mysql_fetch_array($result);
	$email=$row['email'];
	$chkcode = addslashes($_POST['denyreason']);
	$sql="select * from inventory.item_info where iid='$iid'";
	$result=mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	$row=mysql_fetch_array($result);
	$item_info=$row['brand']." ".$row['type']." ".$row['model'];
	//smtp_mail($email, "Request is denied", NULL, "bjorn@bjorncg.com", $item_info, $chkcode, "deny"); 
	show_rst(0,"Request Has Been Denied with an Email");
}
?>
<?php
//delete the user
if((isset($_GET['loopname']))&&($_GET['loopname']!=null))
{
	include 'dbconnect.php';
	$loopname=$_GET['loopname'];
	$sql="select * from inventory.item_history where uname='$loopname' and takereturn='out'";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	$row = mysql_num_rows($result);
	$sql="select * from inventory.item_history where uname='$loopname' and takereturn='in'";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	$row1 = mysql_num_rows($result);
	if($row!=$row1) show_rst(1,"User $loopname Has Some Items now");
	else
	{
		//$sql="delete from inventory.user_info where uname='$loopname'";
		//$sql1="delete from inventory.user_check_info where uname='$loopname'";
		$sql = "update inventory.user_check_info set tag='D' where uname='$loopname'";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		//$result = mysql_query($sql1);
		//if (!$result) die('Invalid query: ' . mysql_error());
		show_rst(0,"User $loopname Has Been Deleted");
	}
	unset($_GET['loopname']);
}
//ignore the approval request
if(($uname=="admin")&&(isset($_POST['ignore_name'])))
{
	include 'dbconnect.php';
	$ignore=$_POST['ignore_name'];
	$str=addslashes($_POST['ignorereason']);
	$sql = "select * from inventory.user_check_info where uname='$ignore' ";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	$row = mysql_fetch_array($result);
	$email = $row['email'];
	$sql = "delete from inventory.user_info where uname='$ignore' ";
	$sql1= "delete from inventory.user_check_info where uname='$ignore'";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	$result1 = mysql_query($sql1);
	if (!$result1) die('Invalid query: ' . mysql_error());
	//email to the user
	//smtp_mail($email, "New User Request is Denied", NULL, "bjorn@bjorncg.com", "admin", $str, "ignore");
	show_rst(0,"User $ignore Has Been Ignored With An Email");
	unset($_POST['ignore_name']);
}

if((isset($_GET['resetpwd']))&&($_GET['resetpwd']!=null))
{
	include 'dbconnect.php';
	$loopname=$_GET['resetpwd'];
	$chkcode = trim(getRam(6));
	$new_pwd=md5($chkcode);
	$sql="update inventory.user_check_info set passwd='$new_pwd' WHERE uname='$loopname';";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	show_rst(0,"User $loopname Has Been Set to $chkcode");
	unset($_GET['resetpwd']);
}
?>
<div align="left" style="padding-bottom:10px; padding-top:0px; padding-left:10px; margin-top:0px">
  <table width="1024"border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25px" colspan="2" valign="top" align="center">
	  <?php
	  	if(isset($_SESSION['rst_msg'])){
			echo($_SESSION['rst_msg']);
	  		unset($_SESSION['rst_msg']);
		}
	  ?></td>
    </tr>
    <tr>
      <td width="559" valign="top">
	  <form enctype="multipart/form-data" action="admin.php" method="post">
	  <table width="536" height="415" border="0" cellpadding="0" cellspacing="0">

        <tr>
          <td height="40" colspan="2" bgcolor="#EEEEEE" align="center" style="border-top:2px solid #CCCCCC">
		  <font size=4><strong>Welcome, Admin | Manager </strong></font>
		  </td>
          <td height="40"><div align="center">
            <div align="center" style="background-color:#B82929; width:180px; padding-top:5px; padding-bottom:5px; border:1px solid #000000"> <font size="3"><a href="main.php">GO CHECK IN / OUT </a></font></div>
          </div></td>
        </tr>
        <tr>
          <td height="20" colspan="2">&nbsp;</td>
          <td height="20">&nbsp;</td>
        </tr>
        <tr>
          <td width="106" height="35"><div align="right" style="padding-right:15px">Category</div></td>
          <td width="188" height="35"><select name="type" class="box" />
		  	  <option value="empty" 
			  <?php 
			  	if(isset($_SESSION['type_val'])&&$_SESSION['type_val']=="empty")
			  	echo(" selected");
			  ?>
			  >Select One</option>
              <option value="Camera"
			  <?php 
			  	if(isset($_SESSION['type_val'])&&$_SESSION['type_val']=="Camera")
			  	echo(" selected");
			  ?>
			  >Camera</option>
              <option value="Lens"
			  <?php 
			  	if(isset($_SESSION['type_val'])&&$_SESSION['type_val']=="Lens")
			  	echo(" selected");
			  ?>
			  >Lens</option>
              <option value="Battery"
			  <?php 
			  	if(isset($_SESSION['type_val'])&&$_SESSION['type_val']=="Battery")
			  	echo(" selected");
			  ?>
			  >Battery</option>
              <option value="Memory"
			  <?php 
			  	if(isset($_SESSION['type_val'])&&$_SESSION['type_val']=="Memory")
			  	echo(" selected");
			  ?>
			  >Memory Card</option>
              <option value="Grip"
			  <?php 
			  	if(isset($_SESSION['type_val'])&&$_SESSION['type_val']=="Grip")
			  	echo(" selected");
			  ?>
			  >Grip</option>
              <option value="Light"
			  <?php 
			  	if(isset($_SESSION['type_val'])&&$_SESSION['type_val']=="Light")
			  	echo(" selected");
			  ?>
			  >Lights</option>
              <option value="Sound"
			  <?php 
			  	if(isset($_SESSION['type_val'])&&$_SESSION['type_val']=="Sound")
			  	echo(" selected");
			  ?>
			  >Sounds</option>
              <option value="Other"
			  <?php 
			  	if(isset($_SESSION['type_val'])&&$_SESSION['type_val']=="Other")
			  	echo(" selected");
			  ?>
			  >Other</option>
              </select>
			  </td>
          <td width="242" height="35"  style="padding-left: 10px"><?php
	  	if(isset($_SESSION['type_rst_msg'])){
			echo($_SESSION['type_rst_msg']);
	  		unset($_SESSION['type_rst_msg']);
		}
	  ?>
            <input name="uname" type="hidden" size="15" class="box" value=
		  <?php echo($uname);?> 
		  ></td>
        </tr>
        <tr>
          <td height="35"><div align="right" style="padding-right:15px">Brand </div></td>
          <td height="35"><select name="brand" class="box" />
		  	  <option value="empty"
			  <?php 
			  	if(isset($_SESSION['brand_val'])&&$_SESSION['brand_val']=="empty")
			  	echo(" selected");
			  ?>
			  >Select One</option>
		  	  <option value="Canon"
			  <?php 
			  	if(isset($_SESSION['brand_val'])&&$_SESSION['brand_val']=="Canon")
			  	echo(" selected");
			  ?>
			  >Canon</option>
              <option value="Nikon"
			  <?php 
			  	if(isset($_SESSION['brand_val'])&&$_SESSION['brand_val']=="Nikon")
			  	echo(" selected");
			  ?>
			  >Nikon</option>
              <option value="Sony"
			  <?php 
			  	if(isset($_SESSION['brand_val'])&&$_SESSION['brand_val']=="Sony")
			  	echo(" selected");
			  ?>
			  >Sony</option>
              <option value="Koda"
			  <?php 
			  	if(isset($_SESSION['brand_val'])&&$_SESSION['brand_val']=="Koda")
			  	echo(" selected");
			  ?>
			  >Koda</option>
			  <option value="Other"
			  <?php 
			  	if(isset($_SESSION['brand_val'])&&$_SESSION['brand_val']=="Other")
			  	echo(" selected");
			  ?>
			  >Other</option></td>
          <td height="35"  style="padding-left: 10px"><?php
	  	if(isset($_SESSION['brand_rst_msg'])){
			echo($_SESSION['brand_rst_msg']);
	  		unset($_SESSION['brand_rst_msg']);
		}
	  ?></td>
        </tr>
        <tr>
          <td height="35"><div align="right" style="padding-right:15px">Model </div></td>
          <td height="35"><input name="model" type="text" size="25" class="box"  value=
		  <?php if(isset($_SESSION['model_val'])) echo($_SESSION['model_val']);?> ></td>
          <td height="35"  style="padding-left: 10px"><?php
	  	if(isset($_SESSION['model_rst_msg'])){
			echo($_SESSION['model_rst_msg']);
	  		unset($_SESSION['model_rst_msg']);
		}
	  ?></td>
        </tr>
        <tr>
          <td height="35"><div align="right" style="padding-right:15px">$ Price </div></td>
          <td height="35"><input name="price" type="text" size="8" class="box"  value=
		  <?php if(isset($_SESSION['price_val'])) echo($_SESSION['price_val']); else echo("0");?> ></td>
          <td height="35"  style="padding-left: 10px"><?php
	  	if(isset($_SESSION['price_rst_msg'])){
			echo($_SESSION['price_rst_msg']);
	  		unset($_SESSION['price_rst_msg']);
		}
	  ?></td>
        </tr>
        <tr>
          <td height="35"><div align="right" style="padding-right:15px">Condition </div></td>
          <td height="35">
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
			</select>			</td>
          <td height="35" style="padding-left: 10px"><?php
	  	if(isset($_SESSION['cond_rst_msg'])){
			echo($_SESSION['cond_rst_msg']);
	  		unset($_SESSION['cond_rst_msg']);
		}
	  ?></td>
        </tr>
        <tr>
          <td height="35"><div align="right" style="padding-right:15px">Image </div></td>
          <td height="35"><input name="uploaded" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #ffffff" /></td>
          <td height="35" style="padding-left:15px"><?php
	  	if(isset($_SESSION['tmp_rst_msg'])){
			echo($_SESSION['tmp_rst_msg']);
	  		unset($_SESSION['tmp_rst_msg']);
		}
	  ?></td>
        </tr>
        <tr>
          <td height="20">&nbsp;</td>
          <td height="20" colspan="2"><font color="#999999"> .JPG is supported <strong>|</strong> Size has to be &lt; 500KB</font></td>
          </tr>
        <tr>
          <td height="40"><div align="right" style="padding-right:15px">Description</div></td>
          <td height="40" colspan="2" style="padding-top:10px">
		  <textarea name="descrip" cols="55" rows="5"><?php if(isset($_SESSION['decrip_val'])) echo($_SESSION['descrip_val']);?></textarea>		  </td>
        </tr>
        <tr>
          <td height="70">&nbsp;</td>
          <td height="70" colspan="2"><input name="submit" type="submit" class="btn" value="Submit" /></td>
        </tr>
      </table>
	  </form>	  </td>
      <td width="465" valign="top">
	    <table width="500" height="23" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:5px">
          <tr>
            <td width="246" height="40" bgcolor="#EEEEEE" style="border-top:1px #000000 solid; padding-left:10px"><div align="left"><span style="padding-right:10px">
                <?php
//Global Variable: 
$page_name = "admin.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

$q = "SELECT count(*) as cnt FROM inventory.item_info WHERE tag='R';";
$t = mysql_query($q);
if(!$t)	die("Error quering the Database: " . mysql_error());
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items > 0 )echo("<font color=#CC0033><strong> $total_items Check-out Items Need Approval</strong></font>");
?>
            </span></div></td>
            <td width="254" height="40" bgcolor="#EEEEEE" style="border-top:1px #000000 solid; padding-right:10px" align="right">
			<?php
if ($total_items == 0 )echo("<font color=#336633><strong>No Check-Out Item Request</strong></font>");
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
            </td>
          </tr>
        </table>
	    <?php 
		include 'dbconnect.php';
		$sql = "select * from  inventory.item_info where tag='R' ";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		while($object = mysql_fetch_object($result)){
			$iid = $object->iid;
			$type=$object->type;
			$brand=$object->brand;
			$model=$object->model;
			$sql1 = "select * from inventory.item_history where iid='$iid' ORDER BY hiid DESC";
			$result1 = mysql_query($sql1);
			if (!$result1) die('Invalid query: ' . mysql_error());
			$object1 = mysql_fetch_object($result1);
			$hiid = $object1->hiid;
			$uname = $object1->uname;
			$duration = $object1->duration;
			$descrip = $object1->descrip;
			$sql2 = "select * from inventory.user_info where uname='$uname' ";
			$result2 = mysql_query($sql2);
			if (!$result2) die('Invalid query: ' . mysql_error());
			$object2 = mysql_fetch_object($result2);
			$lname = $object2->lname;
			$fname = $object2->fname;
			
			if(trim($descrip)==NULL||trim($descrip)=="")$descrip="<font color=#CCCCCC>No Description</font>";		
		?>
        <form method="post" action="admin.php" style="margin-bottom:0px; margin-top:5px">
          <table width="500" height="30" border="0" cellpadding="0" cellspacing="0" bgcolor="#F9F8FE" style="border-top:1px dotted  #CCCCCC; margin-bottom:0px">
            <tr>
              <td width="203" height="30" style="padding-left:5px">
			  <?php echo("<strong>$type</strong> | $brand $model") ?>
                  <input name="iid" type="hidden" value="<?php echo($iid) ?>" />              </td>
              <td width="227" height="30" ><div align="left">
			  <?php echo("<font color=#CCCCCC>(From)</font> $fname $lname | for $duration day(s)") ?></div></td>
              <td width="70" height="30" style="padding-right:8px; padding-top:8px" align="right">
                  <input name="submit" type="submit" value="Approve" class="btn"/>
              </td>
            </tr>
          </table>
        </form>
          <table width="500" border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px #EEEEEE dotted">
            <tr>
              <td width="79" bgcolor="#F9F8FE" style="padding-left:5px"><font color="#CCCCCC"><strong>Purpose </strong></font></em></td>
              <td width="421" bgcolor="#F9F8FE" style="padding-right:5px;padding-top:10px;padding-bottom:10px">
			  <?php 
						  			$len = strlen($descrip);
									$single_line_len = 80;
									$line_no = $len/$single_line_len; 
							
									for($i=0;$i<$line_no;$i++) {
										$str = substr($descrip,$i*$single_line_len, ($i+1)*$single_line_len)."<br>";
										echo $str; }?>
			  </td>
            </tr>
          </table>
		  <form method="post" action="admin.php" style="margin:0px">
          <table width="500" border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px #CCCCCC dotted">
            <tr>
              <td width="79" bgcolor="#F9F8FE" style="padding-left:5px"><font color="#CCCCCC"><strong>Reason</strong></font></em></td>
              <td width="358" bgcolor="#F9F8FE" style="padding-right:5px;padding-top:10px;padding-bottom:10px">
                <textarea name="denyreason" cols="45" rows="4"></textarea>
				<input name="item_id" type="hidden" value="<?php echo($iid) ?>" />
				<input name="applier_name" type="hidden" value="<?php echo($uname) ?>" />
				</td>
              <td width="63" valign="middle" bgcolor="#F9F8FE" style="padding-right:5px;padding-bottom:10px">
                <input name="deny" type="submit" value=" Deny " class="btn"/>
              </td>
            </tr>
          </table>
		  </form>
        <?php }?>
<table width="500" height="23" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px; margin-top:10px">
          <tr>
            <td width="277" height="40" bgcolor="#EEEEEE" style="border-top:1px #000000 solid; padding-left:10px"><div align="left"><span style="padding-right:10px">
                <?php
//Global Variable: 
$page_name = "admin.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

$q = "SELECT count(*) as cnt FROM inventory.user_check_info WHERE tag='P';";
$t = mysql_query($q);
if(!$t)	die("Error quering the Database: " . mysql_error());
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items > 0 )echo("<font color=#CC0033><strong> $total_items User Need Approval</strong></font>");
?>
            </span></div></td>
            <td width="223" height="40" bgcolor="#EEEEEE" style="border-top:1px #000000 solid; padding-right:10px" align="right">
                <?php
if ($total_items == 0 )echo("<font color=#336633><strong>No New User Request</strong></font>");
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
            </td>
          </tr>
        </table>
	    <?php 
		include 'dbconnect.php';
		$sql = "SELECT * FROM inventory.user_check_info a INNER JOIN inventory.user_info b WHERE a.tag='P' AND a.uname=b.uname;";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		while($object = mysql_fetch_object($result)){
			$uname = $object->uname;
			//$status = $object->status;
			$fname = $object->fname;
			$lname = $object->lname;
			$level = $object->level;
			$signup_date = $object->signup_date;
			$signup_time = $object->signup_time;
			$uname = $object->uname;
		?>
		<form method="post" action="admin.php" style="margin-bottom:0px; margin-top:0px">
        <table width="500" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px dotted  #CCCCCC; margin-bottom:2px">
          <tr>
            <td width="186" height="30" style="padding-left:5px">
			<?php echo("<font color=#336633><strong>$uname</strong></font> <font color=#CCCCCC>($level)</font>") ?>
			<input name="loopname" type="hidden" value=<?php echo($uname) ?> />			</td>
            <td width="178" height="30" align="left">
			<?php echo("$fname."."$lname <font color=#CCCCCC>(Full Name)</font>") ?>			</td>
            <td width="79" height="30" style="padding-right:10px">
			<div align="right">
			<input name="submit" type="submit" value="Approve" class="btn" />
			</div>			</td>
          </tr>
        </table>
		</form>
		<form method="post" action="admin.php" style="margin:0px">
          <table width="500" border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px #CCCCCC dotted">
            <tr>
              <td width="79" bgcolor="#F9F8FE" style="padding-left:5px"><font color="#CCCCCC"><strong>Reason</strong></font></em></td>
              <td width="358" bgcolor="#F9F8FE" style="padding-right:5px;padding-top:10px;padding-bottom:10px">
                <textarea name="ignorereason" cols="45" rows="2"></textarea>
				<input name="ignore_name" type="hidden" value="<?php echo($uname) ?>" />
				</td>
              <td width="63" valign="middle" bgcolor="#F9F8FE" style="padding-right:5px;padding-bottom:10px">
                <input name="ignore" type="submit" value="Ignore" class="btn"/>
              </td>
            </tr>
          </table>
		  </form>
        <?php }?>
        <table width="500" height="23" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px; margin-top:10px">
        <tr>
          <td width="255" height="40" bgcolor="#EEEEEE" style="border-top:1px #000000 solid; padding-left:10px">
		  <div align="left">&nbsp;</div>
		  </td>
          <td width="245" height="40" bgcolor="#EEEEEE" style="border-top:1px #000000 solid; padding-right:10px" align="right">
              <?php
//Global Variable: 
$page_name = "admin.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

$q = "SELECT count(*) as cnt FROM  inventory.item_info WHERE tag='Y';";
$t = mysql_query($q);
if(!$t)	die("Error quering the Database: " . mysql_error());
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items > 0 )echo("<strong><a href=checkOut.php><font color=#336633><u>$total_items Item(s) Now in Stock</u></a></strong></font>");
else if ($total_items == 0 )echo("<font color=#336633><strong>There is no item in Stock</strong></font>");
?>
          </td>
        </tr>
      </table>
        <table width="500" height="23" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:5px">
          <tr>
            <td width="256" height="40" bgcolor="#EEEEEE" style="border-top:1px #000000 solid; padding-left:10px">
			<div align="left"><span style="padding-right:10px">
                <?php
//Global Variable: 
$page_name = "admin.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

$q = "SELECT count(*) as cnt FROM  inventory.item_info WHERE tag='N';";
$t = mysql_query($q);
if(!$t)	die("Error quering the Database: " . mysql_error());
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items > 0 )echo("<font color=#CC0033><strong>$total_items Item(s) Out Of Stock Now</font></strong>");
?>
            </span></div></td>
            <td width="244" height="40" bgcolor="#EEEEEE" style="border-top:1px #000000 solid; padding-right:10px" align="right">
                <?php
if ($total_items == 0 )echo("<font color=#336633><strong>No Item Is Out of Stock</strong></font>");
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
            </td>
          </tr>
        </table>
        <?php 
		include 'dbconnect.php';
		$sql = "SELECT * FROM  inventory.item_info a INNER JOIN inventory.item_history b ON a.tag='N' AND a.iid=b.iid AND b.takereturn='out' GROUP BY a.iid LIMIT $set_limit, $limit;";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$i=1;
		while($object = mysql_fetch_object($result)){
			if($i%2==0) $bgcolor= " bgcolor=#F9F8FE";
			if($i%2==1) $bgcolor= " bgcolor=#FFFFFF"; 
			$i+=1;
			$iid = $object->iid;
			$cond = $object->cond;
			$brand = $object->brand;
			$model = $object->model;
			$loop_type = $object->type;
			$SignDate = $object->SignDate;
			$trdate = $object->trdate;
			$trtime = $object->trtime;
			$uname = $object->uname;
			$duration = $object->duration;
		?>
      <table width="500" height="60" border="0" cellpadding="0" cellspacing="0" <?php echo($bgcolor) ?> style="border-bottom:1px dotted  #EEEEEE; margin-bottom:0px">
        <tr>
          <td width="202" height="30" style="padding-left:7px"><?php echo("<font size=3><strong>$brand $model</strong></font>") ?></td>
          <td width="147" height="30" ><span style="padding-left:5px"><?php echo("Taken by <strong><font color=#336633>$uname</font></strong>") ?></span></td>
          <td width="151" height="30" style="padding-right:10px"><div align="right"><?php echo("For $duration Day(s)") ?></div></td>
          </tr>
        <tr>
          <td height="30" style="padding-left:7px; padding-bottom:5px"><?php echo("<font size=3 color=#999999>$cond</font>") ?></td>
          <td height="30" colspan="2" align="right" style="padding-right:10px; padding-bottom:5px">
		  <?php echo("From $trdate | $trtime") ?>
		  </td>
          </tr>
      </table>
      <?php }?>
      <table width="500" height="23" border="0" cellpadding="0" cellspacing="0" style="border-top:1px #000000 solid; border-left:1px #CCCCCC dotted; border-right:1px #CCCCCC dotted; border-bottom:1px #CCCCCC dotted; margin-bottom:0px; margin-top:10px">
        <tr>
          <td width="204" height="40" bgcolor="#EEEEEE" style="padding-left:10px"><div align="left">&nbsp;</div></td>
          <td width="296" height="40" bgcolor="#EEEEEE" style="padding-right:10px" align="right">
            <?php
//Global Variable: 
$page_name = "admin.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

$q = "SELECT count(*) as cnt FROM  inventory.user_check_info WHERE tag='A';";
$t = mysql_query($q);
if(!$t)	die("Error quering the Database: " . mysql_error());
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items > 0 )echo("<font color=#336633><strong>$total_items user(s) in the System</font></strong>");
?>	</td>
        </tr>
      </table>
      <?php 
		include 'dbconnect.php';
		$sql = "SELECT * FROM  inventory.user_check_info a INNER JOIN inventory.user_info b ON a.tag='A' AND a.uname=b.uname GROUP BY b.uname;";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$i=1;
		while($object = mysql_fetch_object($result)){
			if($i%2==0) $bgcolor= " bgcolor=#F9F8FE";
			if($i%2==1) $bgcolor= " bgcolor=#FFFFFF"; 
			$i+=1;
			$loopname = $object->uname;
			$fname = $object->fname;
			$lname = $object->lname;
			$level = $object->level;
			if(trim($level)=="Admin")$level = " Administrator";
		?>
      <table width="500" height="30" border="0" cellpadding="0" cellspacing="0" <?php echo($bgcolor) ?> style="border-left:1px #EEEEEE dotted; border-right:1px #EEEEEE dotted; border-bottom:1px dotted  #EEEEEE; margin-bottom:0px">
        <tr>
          <td width="108" height="30" style="padding-left:7px">
		  <?php echo("<font color=#CCCCCC>(ID)</font> <font color=blue size=3>$loopname</font>") ?></td>
          <td width="184" height="30" ><span style="padding-left:7px"><?php echo("<font color=#CCCCCC>(Name)</font> $fname $lname") ?></span></td>
          <td width="114" height="30" style="padding-right:5px" align="center"><?php echo("<font color=#CCCCCC></font> $level") ?></td>
		  <td width="92" height="30" style="padding:10px" align="center">
		  <?php 
		  if($level == "Regular") 
		  {
		  ?>
		  <div style="margin-bottom:5px">
		  <a href="admin.php?loopname=<?php echo $loopname ?>" class="one"><u>Delete</u></a>
		  </div>
		  <a href="admin.php?resetpwd=<?php echo $loopname ?>" class="one"><u>Passwd Reset</u></a>
		  <?php
		  }
		  ?>		  </td>
        </tr>
      </table>
      <?php }?></td>
    </tr>
  </table>
</div>
</body>
</html>
