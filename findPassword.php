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
	background-image: url(%20);
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
<?php 
	session_start(); 
	if(isset($_SESSION['uname']))$uname = $_SESSION['uname']; 
	if(isset($_SESSION['uname_tag'])) $uname_tag = $_SESSION['uname_tag']; else $uname_tag="";
	if(isset($_SESSION['rid'])) {$rid = $_SESSION['rid']; unset($_SESSION['rid']); }else $rid="";
?>
<div align="center">
 <?php include("FreeHeader.php") ?>
  <form action="findPass_process.php" method="post" style="margin-top:0;">
  <table width="1024" height="325" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-left:1 #DDDDDD solid;border-right:1 #DDDDDD solid; border-bottom:1 #DDDDDD solid; margin-bottom:15px">
      <tr>
        <td height="50" align="right" style="padding-right:8">&nbsp;</td>
        <td height="50" style="padding-left:10">&nbsp;</td>
        <td height="50" align="left">&nbsp;</td>
        <td height="50" style="border-right:0 #CCCCCC solid; padding-left:5">&nbsp;</td>
      </tr>
      <tr>
        <td width="238" height="45" align="right" style="padding-right:8"><font size="3"><strong>Username</strong></font></td>
        <td width="228" height="45" style="padding-left:10"><input name="uname" type="text" class="box" style="height:22px"  maxlength="15"></td>
        <td width="95" height="45" align="left">&nbsp;</td>
        <td height="45" style="border-right:0 #CCCCCC solid; padding-left:5">
          <?php 
		if(isset($_SESSION['uname_rst_msg'])){
			echo $_SESSION['uname_rst_msg']; 
			unset($_SESSION['uname_rst_msg']); 
		}
		?>        </td>
      </tr>
      <tr>
        <td height="45" align="right" style="padding-right:8"><font size="3"><strong>Email Account</strong></font></td>
        <td height="45" colspan="2" style="padding-left:10"><input name="email" type="text" class="box" style="height:22px" size=30></td>
        <td height="45" style="border-right:1 #CCCCCC solid; padding-left:5">
		<?php 
		if(isset($_SESSION['email_rst_msg'])){
			echo $_SESSION['email_rst_msg']; 
			unset($_SESSION['email_rst_msg']); 
		}
		?>		</td>
      </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" colspan="2" style="padding-left:5px">&nbsp;<img src='code.php' id='safecode' onclick='reloadcode()' onBlur='' title='Click to Change'></img>		</td>
        <td height="45" >&nbsp;</td>
      </tr>
      <tr>
        <td height="45" align="right" style="padding-right:8"><font size="3"><strong>Check Code</strong></strong></td>
        <td height="45" colspan="2" style="padding-left:10"><input name="rancode" type="text" class="box"  style="height:22px" maxlength="4" size="4"></td>
        <td height="45" style="padding-left:5">
		<?php 
		if(isset($_SESSION['chk_rst_msg'])){
			echo($_SESSION['chk_rst_msg']); 
			unset($_SESSION['chk_rst_msg']); 
		}
		?>		</td>
      </tr>
      <tr>
        <td height="120">&nbsp;</td>
        <td height="120" colspan="2" align="left" valign="middle" style="padding-left:10px; padding-bottom:25px">
        <input name="Submit" type="submit" class="btn" value=" Submit ">        </td>
        <td width="463" height="120">&nbsp;</td>
      </tr>
  </table>
</form>
</div>
<?php include("bottomMenuEN.php"); ?>
</body>
</html>
