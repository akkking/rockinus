<?php
include("HeaderOut.php");
if(isset($_POST['uname'])){
	$uname = $_POST['uname']; 
	$passwd = trim(md5($_POST['passwd'])); 
	include 'dbconnect.php'; 
	$result = mysql_query("SELECT * from inventory.user_check_info a INNER JOIN inventory.user_info b ON (a.uname='$uname' OR a.email='$uname') AND a.uname=b.uname AND a.tag='A'");
	if (!$result) die('Invalid query: ' . mysql_error());
	$count = mysql_num_rows($result);
	if($count==1){
		$obj = mysql_fetch_object($result);
		if($passwd == trim($obj->passwd)){
 			$_SESSION['usrname']=$obj->uname; 
			setcookie("user", $uname, time()+3600);
			//setcookie("Login_Tag", $Login_Tag, time()+3600);
		
			$sql = "INSERT INTO inventory.user_log_info (uname,LogDate,LogTime, tag) VALUES('$uname', CURDATE(), NOW(), '1')";
			$result = mysql_query($sql);
			if (!$result) die('Invalid query: ' . mysql_error());
			session_start(); 
			$_SESSION['uname'] = $uname;
			if(trim($obj->level)=="Admin" || trim($obj->level)=="Manager") {
				$_SESSION['linkpage'] = "admin.php";
				header("location:admin.php");
			}else if(trim($obj->level)=="Regular") {
				$_SESSION['linkpage'] = "main.php";
				header("location:main.php");
			}else $_SESSION['rst_msg']="<strong><font color=red>Wrong Role, please contact Administrator.</font></strong>"; 
		}else $_SESSION['rst_msg']="<strong><font color=red>User Password is incorrect.</font></strong>"; 
	}else $_SESSION['rst_msg']="<strong><font color=red>User Name does not exist.</font></strong>"; 
	mysql_close($link); 
}
?>
<div align="left" style="padding-bottom:10px; padding-top:0px; padding-left:10px; background-color:">
  <table width="1024" height="142" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="233" valign="top">
	  <form action="login.php" method="post">
	  <table width="233" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-right:0px #333333 dotted; padding-right:15px; margin-bottom:25px">
        <tr>
          <td height="30" colspan="3" align="right"><div align="center">
     <?php
	  	if(isset($_SESSION['rst_msg'])){
			echo($_SESSION['rst_msg']);
	  		unset($_SESSION['rst_msg']);
		}
	  ?>
          </div></td>
          </tr>
        <tr>
          <td width="96" height="40" align="right" style="padding-right:10px;"><span class="STYLE12">User Name </span></td>
          <td height="40" colspan="2"><input name="uname" type="text" size="15" class="box" /></td>
        </tr>
        <tr>
          <td width="96" height="40" align="right" style="padding-right:10px;"><span class="STYLE12">Password </span></td>
          <td height="40" colspan="2"><input name="passwd" type="password" size="15" class="box" /></td>
        </tr>
        <tr>
          <td width="96" height="45" align="right" style="padding-right:10px;">&nbsp;</td>
          <td width="51" height="45"><input name="submit" type="submit" class="btn" value="Login" /></td>
          <td width="86" height="45">&nbsp;</td>
        </tr>
        <tr>
          <td width="96" height="45" align="right" style="padding-right:10px; padding-bottom:10px; padding-top:12px">&nbsp;</td>
          <td height="45" colspan="2"><div style="padding-top: 5px; padding-bottom: 5px; padding-left:10px;width: 110px; background:#EEEEEE" align="left"> 
		  <a href="join.php"><font color="#336633"><strong>+ New User </strong></font></a></div></td>
        </tr>
        <tr>
          <td width="96" height="35" align="left" style="padding:5px; border:0px #333333 solid">&nbsp;</td>
          <td height="35" colspan="2" align="left" style="border:0px #333333 solid">
		  <div style="padding-top: 5px; padding-bottom: 5px; padding-left:10px; width: 110px; background:#EEEEEE" align="left">
		  <a href="findpwd.php"><strong><font color="#336633">Find Passwd </font></strong></a></div></td>
          </tr>
      </table>
	  <div align="center"><img src="img/50cent.jpg" width="200" height="300" /></div>
	  </form>
	  </td>
      <td width="791" valign="top"><div align="center">
        <table width="700" height="23" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:5px; margin-top:0px">
          <tr>
            <td width="449" height="45" bgcolor="#EEEEEE" style="border-top:1px #000000 solid; padding-left:10px" align="left">
			<font size=4><strong>Recent Update</strong></font></td>
            <td width="251" height="45" bgcolor="#EEEEEE" style="border-top:1px #000000 solid; padding-right:10px" align="right"">
                <?php
//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

$q = "SELECT count(*) as cnt FROM  inventory.item_info WHERE tag='Y';";
$t = mysql_query($q);
if(!$t)	die("Error quering the Database: " . mysql_error());
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items > 0 )echo("<font color=#336633>Now <strong>$total_items</strong> Item(s) Available in Stock</font>");
else if ($total_items == 0 )echo("<font size=4>There Is No Item In Stock</font>");
?>            </td>
          </tr>
        </table>
        <table width="700" height="18" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:0px">
          <tr>
            <td height="30" align="left" style="border-bottom:1px #EEEEEE dotted; padding-left:10px">&nbsp;</td>
            <td width="324" height="30" style="border-bottom:1px #EEEEEE dotted"><div align="right" style="padding-right:10px">
                <?php
//Global Variable: 
$page_name = "login.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

$q = "SELECT count(*) as cnt FROM inventory.item_info a INNER JOIN inventory.item_history b ON a.iid=b.iid;";
$t = mysql_query($q);
//echo($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}

$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items == 0 )echo("<strong><font color=#336633 size=3>There Is No Update</font></strong>");
$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 10;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
	if((!$limit) || (is_numeric($limit) == false)|| ($limit < 10) || ($limit > 50)) {
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
		<?php 
include 'dbconnect.php';
$sql="select * from inventory.item_history ORDER BY trdate, trtime DESC";
$result = mysql_query($sql);
if (!$result) die('Invalid query: ' . mysql_error());
//set up a array to identify whether this item is latest
$sql2="SELECT MAX(iid) AS iid FROM inventory.item_history";
$result2=mysql_query($sql2);
if (!$result2) die('Invalid query: ' . mysql_error());
$row2=mysql_fetch_array($result2);
$max_iid=$row2['iid'];
$flag = array();
for($i=0;$i<=$max_iid;$i++)
{
	$flag[$i]=0;
	//echo "flag[".$i."] is: ".$flag[$i]."</br>";
}
while($arr = mysql_fetch_array($result))
{
	?>
<table width="700" height="60" border="0" cellpadding="0" cellspacing="0" bgcolor="#F9F8FE" style="border-bottom:1px dotted  #CCCCCC; margin-bottom:5px">
	<tr>
	<td width="312" height="35" style="padding-left:5px">
	<?php
	$iid=$arr['iid'];
	$sql1="select * from inventory.item_info where iid='$iid'";
	$result1=mysql_query($sql1);
	if(!$result1) die('Invalid query: ' . mysql_error());
	$row1=mysql_fetch_array($result1);
	echo "<font size=3 color=blue>".$row1['type']."</font> | <font size=3>".$row1['brand']." ".$row1['model']."</font>"; 
	?>	</td>
	<td width="223" height="35" >
	<?php
		if($arr['takereturn']=='in')
		{
			echo "<font color='green' size=3>Returned</font>";
		}
		else if(($arr['takereturn']=='out')&&($flag[$iid]==0))
		{
			if($row1['tag']=='R')
			{
				echo "<font color='Red' size=3>Request for Approval</font>";
				$flag[$iid]=1;
			}
			if($row1['tag']=='N')
			{
				echo "<font color='Red' size=3>Borrowed</font>";
			}
		}
		else 
		{
			echo "<font color='Red' size=3>Borrowed</font>";
		}
	?>	</td>
	<td width="165" height="35" style="padding-right:10px" align="right">
	<?php
	echo "On ".$arr['trdate'];
	?>
	</td>
	</tr>
	<tr>
	<td height="35" style="padding-left:7px; padding-bottom:5px">
	<?php
	echo "It's now ".$arr['cond'];
	?>
	</td>
	<td height="35" align="left">
	<?php
	$uname = $arr['uname'];
	$sql3="select * from inventory.user_info where uname='$uname' ";
	$result3=mysql_query($sql3);
	if(!$result3) die('Invalid query: ' . mysql_error());
	$row3=mysql_fetch_array($result3);
	$level=$row3['level'];
	echo ("By <strong><a href=userDetail.php?uname=$uname><font color=black>$uname</font></strong></a> <font color=#CCCCCC>(User)</font>") ;
	?>
	</td>
	<td height="35" align="right" style="padding-right:10px; padding-bottom:5px">
	<?php
	if(($arr['takereturn']=="out")&&$row1['tag']=='N')
	{
		$trtime=$arr['trtime'];
		$trdate=$arr['trdate'];
		$duration=$arr['duration'];
		date_default_timezone_set('America/New_York');
		$date = date( "Y-m-d   H:i:s ");
		//echo $date."</br>";
		$date1= $trdate." ".$trtime; 
		//echo $date1;
		$d1=strtotime($date1); 
		$d2=strtotime($date);
		$hour=round(($d2-$d1)/3600);
		$hour=$duration*24-$hour;
		if($hour<=0)
		{
			$hour=abs($hour);
			echo "<font color='red'><strong>Overdue </strong></font>".$hour." h(s)";
		}
		else if($hour>=24)
		{
			$days=intval($hour/24);
			$hour=$hour-$days*24;
			echo $days." day(s) and ".$hour." hr(s) left";
		}
		else echo $hour."hr(s) left";
		
	}
	else if($arr['takereturn']=="in")echo($arr['trtime']); 
	?>
	</td>
	</tr>
</table>
	<?php
}
?>
        </div></td>
    </tr>
  </table>
</div>
</body>
</html>
