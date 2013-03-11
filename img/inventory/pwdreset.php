<?php include("Header.php");
$uname = $_SESSION['uname'];
if((isset($_POST['original_pwd']))&&($_POST['original_pwd']!=null))
{
	include 'dbconnect.php';
	$sql = "SELECT * FROM inventory.user_check_info WHERE uname='$uname';";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	$row = mysql_fetch_array($result);
	if($row['passwd']!=md5($_POST['original_pwd']))
		$_SESSION['rst_msg']="<font size=4 color=#CC3300><strong>Please Enter Your Correct Password</strong></font><p>";
	else
	{
		if($_POST['new_pwd']!=$_POST['new_pwds'])
			$_SESSION['rst_msg']="<font size=4 color=#CC3300><strong>Two Passwords Are Not Same<br></strong></font><p>";
		else
		{
			$new_pwd=md5($_POST['new_pwd']);
			$sql="update inventory.user_check_info set passwd='$new_pwd' WHERE uname='$uname';";
			$result = mysql_query($sql);
			if (!$result) die('Invalid query: ' . mysql_error());
			$_SESSION['rst_msg']="<font size=4 color=#CC3300><strong>Your New Password Has Been Set Up Successfully</strong></font><p>";
		}
	}
}
if((isset($_POST['original_pwd']))&&($_POST['original_pwd']==null))
{
	$_SESSION['rst_msg']="<font size=4 color=#CC3300><strong>Please Enter Your Password</strong></font><p>";
}
?>
<div align="left" style="padding-bottom:10px; padding-top:0px; padding-left:10px; background-color:">
  <table width="1024" height="142" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" colspan="2" valign="top"><div align="center" style="padding-top:5px">
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
	  <form action="pwdreset.php" method="post">
	  <table width="672" height="279" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="30" align="right" style="padding-right:20px"><img src="img/keyPasswd.jpg" width="25" height="30" /></td>
          <td height="30" ><font size="4" color="336633"><strong>PASSWORD RESET </strong></font></td>
        </tr>
        <tr>
          <td height="20" align="right" style="padding-right:20px">&nbsp;</td>
          <td height="20" >&nbsp;</td>
        </tr>
        <tr>
          <td width="178" height="30" align="right">Original Password</td>
          <td width="494" height="30" style="padding-left:15px">
            <input type="password" name="original_pwd"></td>
        </tr>
        <tr>
          <td align="right" height="30">New Password</td>
          <td width="494" height="30"  style="padding-left:15px">
            <input type="password" name="new_pwd"></td>
        </tr>
        <tr>
          <td align="right" height="30">New Password Again</td>
          <td width="494" height="30"  style="padding-left:15px">
            <input type="password" name="new_pwds"></td>
          </tr>
        <tr>
          <td align="right" height="86">&nbsp;</td>
          <td height="86"  style="padding-left:15px">
		  <input name="submit" type="submit" class="btn" value="submit"></td>
        </tr>
      </table>
	  </form>	  
	  </td>
      <td width="352" valign="top"><img src="img/50-cent-2.jpg" />	  </td>
    </tr>
  </table>
</div>
</body>
</html>
