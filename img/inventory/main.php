<?php include("Header.php");
include("func.php");

$uname = $_SESSION['uname'];
if(isset($_POST['takereturn'])){
	$takereturn = $_POST['takereturn'];

	if($takereturn=='in'){
		include 'dbconnect.php';
		$sql = "SELECT * FROM inventory.item_history a INNER JOIN inventory.item_info b ON a.uname='$uname' AND b.tag='N' AND a.takereturn='out'";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$no_row = mysql_num_rows($result);
		if($no_row == 0){
			show_rst(0,"You Have No Item to Check in");
			mysql_close($link);
		}else header("location:checkIn.php");
	}else header("location:checkOut.php");
}else if(isset($_SESSION['takereturn_val']))unset($_SESSION['takereturn_val']);
?>
<div align="left" style="padding-bottom:10px; padding-top:15px; padding-left:10px; background-color:">
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
      <td width="672" valign="top">
	  <form name="checkinout" action="main.php" method="post">
	  <table width="672" height="120" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="40" colspan="2">&nbsp;</td>
          <td width="268" height="40" ><span style="padding-right:15px">
            <input name="uname" type="hidden" size="15" class="box" value=
		  <?php echo($uname);?> 
		  >
          </span></td>
        </tr>
        <tr>
          <td width="338" height="40"><div align="right"><font size="5">Check-In / Check-Out? </font></div></td>
          <td height="40" colspan="2"><div align="left" style="padding-left:20px">
            <select name="takereturn" class="box" onChange="document.checkinout.submit()" />
            
            <option value="empty" 
			  <?php 
			  	if(isset($_SESSION['takereturn_val'])&&$_SESSION['takereturn_val']=="empty")
			  	echo(" selected");
			  ?>
			  >Select One</option>
            <option value="in"
			  <?php 
			  	if(isset($_SESSION['takereturn_val'])&&$_SESSION['takereturn_val']=="in")
			  	echo(" selected");
			  ?>
			  >Check-In</option>
            <option value="out"
			  <?php 
			  	if(isset($_SESSION['takereturn_val'])&&$_SESSION['takereturn_val']=="out")
			  	echo(" selected");
			  ?>
			  >Check-Out</option>
            </select>
          </div></td>
          </tr>
        <tr>
          <td height="70" valign="bottom" >
		  <?php 
		include 'dbconnect.php';
		$sql = "SELECT * FROM inventory.user_info WHERE uname='$uname' AND (level='Admin' OR level='Manager')";
		$result = mysql_query($sql);
		if(!$result) die('Invalid query: ' . mysql_error());
		$no_row = mysql_num_rows($result);
		if($no_row == 1){
		?>		
		  <div align="right">
            <div align="center" style="background-color:#B82929; width:200px; padding-top:5px; padding-bottom:5px; border:1px solid #000000"> <font size="3"><a href="admin.php">BACK TO ADMIN PAGE </a></font></div>
          </div>
		  <?php } ?>
		  </td>
          <td height="70" colspan="2">&nbsp;</td>
          </tr>
      </table>
	  </form>	  </td>
      <td width="352" valign="top"><img src="img/50-cent-2.jpg" />	  </td>
    </tr>
  </table>
</div>
</body>
</html>
