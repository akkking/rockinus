<?php 
include("HeaderOut.php");
require("class.phpmailer.php");
include("func.php");
include 'dbconnect.php';

if(isset($_POST['ID_email'])&&($_POST['ID_email']!=null))
{
	$uname=$_POST['ID_email'];
	$sql = "SELECT * FROM inventory.user_check_info WHERE uname='$uname' or email='$uname';";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	$no_row = mysql_num_rows($result);
	if($no_row==0)
		$_SESSION['rst_msg']="<font size=4 color=#CC3300><strong>Your ID or Email is incorrect<br></strong></font>";
	else
	{
		$chkcode = trim(getRam(6));
		$new_pwd=md5($chkcode);
		$sql="update inventory.user_check_info set passwd='$new_pwd' WHERE uname='$uname';";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$sql = "SELECT * FROM inventory.user_check_info WHERE uname='$uname' or email='$uname';";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$row = mysql_fetch_array($result);
		$email=$row['email'];
		smtp_mail($email, "Password Reset Request", NULL, "bjorn@bjorncg.com", $uname, $chkcode, "passwd"); 
		$_SESSION['rst_msg']="<font size=4 color=#CC3300><strong>Your New Password Has Been Sent to Your Email<br></strong></font>";
	}
}
if(isset($_POST['ID_email'])&&($_POST['ID_email']==null))
{
	$_SESSION['rst_msg']="<font size=4 color=#CC3300><strong>Please Enter Your ID or Email Address<br></strong></font>";
}
?>
<div align="left" style="padding-bottom:10px; padding-top:0px; padding-left:10px; background-color:">
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
	  <form action="findpwd.php" method="post">
	  <table width="672" height="160" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="30" align="right" style="padding-right:20px"><img src="img/keyPasswd.jpg" width="25" height="30" /></td>
          <td height="30" ><font size=4 color="336633"><strong>PASSWORD LOST | FOUND</strong></font></td>
        </tr>
        <tr>
          <td width="178" height="70" align="right" style="padding-right:20px"><strong>Your ID or Email</strong></td>
          <td width="494" height="70" >
            <input type="text" name="ID_email">			</td>
        </tr>
        <tr>
          <td height="20" align="center">&nbsp;</td>
          <td height="20" ><input name="submit" type="submit" class="btn" value="submit"/></td>
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
