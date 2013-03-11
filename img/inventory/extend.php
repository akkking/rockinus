<?php include("Header.php");
$uname = $_SESSION['uname'];
$iid = $_GET['extend'];
if((isset($_POST['extend_days']))&&($_POST['extend_days']!=null))
{
	include 'dbconnect.php';
	$extend_days=$_POST['extend_days'];
	$sql="select * from inventory.item_info where iid='iid'";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	$row = mysql_fetch_array($result);
	$status = $row['status'];
	if($status=="Internal")
	{
		$sql="update inventory.item_info set tag='E' WHERE iid='$iid';";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$sql="insert inventory.item_info   (iid,uname,cond,descrip,takereturn,trdate,trtime,duration,tbname)VALUES('$iid','$uname','$cond','$descrip','extends',CURDATE(), NOW(),'$duration','item_history')";
		$_SESSION['rst_msg']="<font size=4 color=#CC3300><strong>Extends successfully<br></strong></font>";
	}
}
if((isset($_POST['extend_days']))&&($_POST['extend_days']==null))
{
	$_SESSION['rst_msg']="<font size=4 color=#CC3300><strong>Please Enter The time<br></strong></font>";
}
?>
<div align="left" style="padding-bottom:10px; padding-top:15px; padding-left:10px; background-color:">
  <table width="1024" height="142" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="50" colspan="2" valign="top"><div align="center" style="padding-top:5px">
	  <?php
	  	if(isset($_SESSION['rst_msg'])){
			echo($_SESSION['rst_msg']);
	  		unset($_SESSION['rst_msg']);
		}
	  ?>
	  </div></td>
    </tr>
    <tr>
      <td width="672" valign="top">
	  <form action="extend.php?extend=<?php echo $iid ?>" method="post">
	  <table width="672" height="120" border="0" cellpadding="0" cellspacing="0">
	  	<tr>
		<td width="214" height="40" align="center" colspan="2"><strong>The item:</strong><?php
		include 'dbconnect.php';
		$iid = $_GET['extend'];
		$sql="select * FROM inventory.item_info where iid='$iid'" ;
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$row = mysql_fetch_array($result);
		echo "<strong>".$row['type'].' '.$row['brand'].' '.$row['model']."</strong>";
		?></strong></td>
		</tr>
        <tr>
          <td width="214" height="40" align="center"><strong>How many days to Extend :</strong></td>
          <td width="458" height="40" ><div style="margin-left:30px">
            <input type="text" name="extend_days"></td>
        </tr>
      </table>
	  <div align=center style='width:80px; background-color: #EEEEEE; margin-left:250px; margin-bottom:3px;  border-bottom: 1px solid #000000; border-right: 1px solid #000000;'>
	  <input type="submit" value="submit" style="background-color:Transparent;border-color:Transparent;border-style:None;"  />
	  </div>
	  </form>	  
	  </td>
      <td width="352" valign="top"><img src="img/50-cent-2.jpg" />	  </td>
    </tr>
  </table>
</div>
</body>
</html>
