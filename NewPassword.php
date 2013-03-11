<?php 
session_start(); 
include 'dbconnect.php'; 
$pagename="joinUsResult.php";

if( isset($_GET['rocker']) && isset($_GET['chkcode'])){
	$uid = $_GET['rocker'];
	$chkcode = trim($_GET['chkcode']); 
	
	$qresult = mysql_query("SELECT * FROM rockinus.user_check_info WHERE uname='$uid' AND chkcode='$chkcode' AND status='A'");
	$no_row = mysql_num_rows($qresult);
	if($no_row == 0) die("Sorry, your ID $uid is not registered or is invalid");
}else if(isset($_POST['uname']) && isset($_POST['passwd']) && isset($_POST['cpasswd'])){
	$uid = $_POST['uname'];
	$passwd = $_POST['passwd'];
	$cpasswd = $_POST['cpasswd'];
	$qresult = mysql_query("SELECT * FROM rockinus.user_check_info WHERE uname='$uid' AND status='A'");
	$no_row = mysql_num_rows($qresult);
	if($no_row == 0) die("Sorry, your ID $uid is not registered or is invalid");

	if( $passwd!= $cpasswd ) {
		$_SESSION['cpasswd_rst_msg'] = "<div style='background-color:#EEEEEE; width:320; padding-bottom:5; padding-top:5; border:1 #333333 solid'><font color=red><strong>&nbsp;&nbsp;Two passwords are not same</strong></font></div>";
	}else{ 
		$passwd = md5($passwd);
		$result = mysql_query("UPDATE rockinus.user_check_info SET passwd='$passwd' WHERE uname='$uid'");
		if (!$result) die('Invalid query: ' . mysql_error());
		$_SESSION['rst_msg'] = "<div style='background-color:#F5F5F5; width:600; margin-top:40; margin-bottom:100; padding-bottom:20; padding-top:20; border:8px #DDDDDD solid'><font size=3><strong><img src=img/addsuccessIcon_F5.jpg width=20>&nbsp;&nbsp; Your new passowrd has been reset successfully!</strong><br><br><a href=main.php class=one>Go Login</a></font></div>";
	}
}
mysql_close($link);
?>
<html>
<head>
<title>Rock In U.S.</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="form_valid.js"></script>
<script src="birthday.js"></script>
<script src="dropdown.js"></script>
<script src="autoSubmit.js"></script>
<STYLE>
A:LINK    {Color: White; Text-Decoration: none}
A:VISITED {Color: White; Text-Decoration: none}
A:HOVER   {Color: #EEEEEE}
A.one:link {color: black;}
A.one:visited {color: black;}
A.one:hover {color:#CC6633;}
</STYLE>
<style type="text/css">
<!--
span.label {color:black;width:30;height:16;text-align:center;margin-top:0;background:#ffF;font:bold 13px Arial}
span.c1 {cursor:hand;color:black;width:30;height:16;text-align:center;margin-top:0;background:#ffF;font:bold 13px Arial}
span.c2 {cursor:hand;color:red;width:30;height:16;text-align:center;margin-top:0;background:#ffF;font:bold 13px Arial}
span.c3 {cursor:hand;color:#b0b0b0;width:30;height:16;text-align:center;margin-top:0;background:#ffF;font:bold 12px Arial}
-->
</style>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-image: url(1);
}
body,td,th {
	font-size: 13px;
	font-family: Arial, Helvetica, sans-serif;
}
.STYLE7 {color: #CC3300}
.STYLE15 {color: #CCCCCC}
-->
</style>
</head>
<body>
<div align="center">
<?php include("main_header.php") ?>
<?php
		if(isset($_SESSION['rst_msg'])){
			echo($_SESSION['rst_msg']); 
			unset($_SESSION['rst_msg']); 
		}else{
		?>
  	<form action="NewPassword.php" method="post" style="margin-top:0; margin-bottom: 10;">
    <table width="940" height="215" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:0 solid #EEEEEE; margin-bottom:80">
      <tr>
        <td height="30" align="right" style="padding-right:10">&nbsp;</td>
        <td width="282" height="30" style="padding-left:10">&nbsp;</td>
        <td width="422" height="30" align="right" style="padding-right:30"></td>
      </tr>
      <tr>
        <td width="236" height="50" align="right" style="padding-right:10">
		<strong><img src="img/keyPasswd.jpg" width="25" height="30"></strong></td>
        <td height="50" style="padding-left:10">
          <input name="uname" type="hidden" class="box" size="15" maxlength="15" value=<?php echo($uid) ?>>
		  <font size="4" color="#336633"><strong><u><?php echo($uid) ?></u></strong></font>
&nbsp;&nbsp;</td>
        <td height="50" align="right" style="padding-right:30"></td>
      </tr>
      <tr>
        <td height="40" align="right" style="padding-right:5; font-size: 13px; font-family: Arial, Helvetica, sans-serifArial, Helvetica, sans-serif"><strong>New Password :</strong></td>
        <td height="40"  style="padding-left:10">
          <input name="passwd" type="password" class="box" id="passwd" size="30" />
          *</td>
        <td height="40" >&nbsp;</td>
      </tr>
      <tr>
        <td height="40" align="right" style="padding-right:5; font-size:13px; font-family:Arial, Helvetica, sans-serif"><strong>Re-enter New Password  :</strong></td>
        <td height="40"  style="padding-left:10">
          <input name="cpasswd" type="password" class="box" id="cpasswd" size="30" />
          <span class="STYLE12">* </span></td>
        <td height="40" style="padding-left:5">
		<?php 
		if(isset($_SESSION['cpasswd_rst_msg'])){
			echo($_SESSION['cpasswd_rst_msg']); 
			unset($_SESSION['cpasswd_rst_msg']); 
		}
		?>		</td>
      </tr>
      <tr>
        <td height="50">&nbsp;</td>
        <td colspan="2" rowspan="2" align="left" style="padding-left:10; padding-top:30" valign="top"> 
        <input name="Submit" type="submit" class="btn2" value="Submit" style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:1px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif">        </td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
      </tr>
    </table>
    </font>
    </form>
	<?php }
	include("bottomMenuEN.php"); ?>
</div><br>
</body>
</html>
