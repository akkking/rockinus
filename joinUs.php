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
  	<form id="unameForm" action="unameExist.php" method="post" onSubmit="return checkForm(this);" style="margin-bottom:0; margin-top:0;">
  	  <table width="1000" height="85" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="margin-top:10">
      <tr>
        <td height="40" valign="middle" bgcolor="#F5F5F5" style="border-top:0px #999999 solid">&nbsp;</td>
        <td width="402" height="40" valign="middle" bgcolor="#F5F5F5" style="border-top:0px #999999 solid">&nbsp;</td>
        <td width="408" height="40" valign="middle" bgcolor="#F5F5F5" style="border-top:0px #999999 solid">&nbsp;</td>
      </tr>
      <tr>
        <td width="190" height="45" align="right" valign="middle" bgcolor="#F5F5F5" style="padding-right:7; font-size:14px"><strong>Username</strong></td>
        <td height="45" valign="middle" bgcolor="#F5F5F5" style="padding-left:10">
	      <input name="uname" type="text" class="box" maxlength="15" size="15" onFocus="this.value=''" onBlur="if(checkForm(this.form))this.form.submit();" value=<?php echo($rid); ?> >
	    <input type="submit" class="btn2" value="Check" />		  &nbsp;&nbsp;&nbsp;</td>
        <td height="45" valign="middle" bgcolor="#F5F5F5" style="padding-left:10">
		<?php echo $uname_tag; $_SESSION['uname_tag'] = ""; ?>		</td>
      </tr>
    </table>
  </form>
  <form id="infoForm" action="joinUs_process.php" method="post" name="infoForm" onSubmit="return validateForm()" style="margin-top:0; margin-bottom: 11;">
    <table width="1000" height="430" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-right:0 #000000 solid; border-bottom:0 #999999 solid">
      <tr>
        <td width="191" height="40" align="right" style="padding-right:7; font-size:14px"><strong>Password </strong></td>
        <td  style="padding-left:10">
            <input name="passwd" type="password" class="box" size=15>
		  <input type="hidden" name="usrname" value=<?php echo($rid) ?>></td>
        <td style="padding-left:10"><?php if(isset($_SESSION['passwd_rst_msg'])) echo($_SESSION['passwd_rst_msg']); unset($_SESSION['passwd_rst_msg']); ?>		</td>
      </tr>
      <tr>
        <td height="40" align="right" style="padding-right:7; font-size:14px">&nbsp;</td>
        <td  style="padding-left:10">
		<div style="background:#EEEEEE; padding:10; margin-top:5; margin-bottom:10; border:1 #CCCCCC solid; font-size:11px">
		<strong><font color=#336633 size=2>Passwords must meet the following criteria:</font></strong> 
		<br><br>
1. Must be 6 to 16 characters long.<br> 
2. Must contain at least one alphabetic and one non-alphabetic character, or one number and one non-alphanumeric character. <br>
3. Cannot contain the user's user ID. <br>
4. Is case-sensitive. <br>
5. Allowable characters are: a-z, A-Z, 0-9, and the symbols !@#$%&*(). </div>		</td>
        <td style="padding-left:10">&nbsp;</td>
      </tr>
      <tr>
        <td height="40" align="right" style="padding-right:7; font-size:14px"><strong>Confirm Password </strong></td>
        <td  style="padding-left:10">
          <input name="cpasswd" type="password" class="box" size="15" ></td>
        <td style="padding-left:10"><?php if(isset($_SESSION['cpasswd_rst_msg'])) echo($_SESSION['cpasswd_rst_msg']); unset($_SESSION['cpasswd_rst_msg']); ?>		</td>
      </tr>
      <tr>
        <td height="40" align="right" style="padding-right:7; font-size:14px"><strong>I am a </strong></td>
        <td >&nbsp;
            <input type="radio" name="sstatus" value="Student"  checked="checked">
          Student
          <input type="radio" name="sstatus" value="Employee">
          Employe(e/r) </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="40" align="right" style="padding-right:7; font-size:14px"><strong>Email Account </strong></td>
        <td  style="padding-left:10">
            <input name="email" type="text" class="box" size=30 value=<?php if(isset($_SESSION['email'])){echo($_SESSION['email']);unset($_SESSION['email']);} ?>>            
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="emailcheck" value="checkbox" checked="checked">
          Keep informed &nbsp;&nbsp;</td>
        <td style="border-right:0 #CCCCCC solid; padding-left:10"><?php if(isset($_SESSION['erst_msg'])) echo($_SESSION['erst_msg']); unset($_SESSION['erst_msg']); ?></td>
      </tr>
      <tr>
        <td height="40" align="right" style="padding-right:7; font-size:14px">&nbsp;</td>
        <td  style="padding-left:10"><div style="background:#EEEEEE; padding:10; padding-top:5; padding-bottom:5; margin-top:5; margin-bottom:5; border:1 #CCCCCC solid; font-size:11px"> <strong><font color="#CC6600">Currently we only support .edu sign-up</font></strong> <br>
        </div></td>
        <td style="border-right:0 #CCCCCC solid; padding-left:10">&nbsp;</td>
      </tr>
      <tr>
        <td height="40" align="right" style="padding-right:7; font-size:14px"><strong>Check Code : </strong></td>
        <td  style="padding-left:10"><img src='code.php' id='safecode' onclick='reloadcode()' onBlur='' title='Click to Change'></img>		</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="45" align="right" style="padding-right:7; font-size:14px"><strong>Enter Check Code : </strong></td>
        <td height="45"  style="padding-left:10">
		<input name="rancode" type="text" class="box" maxlength="4" size="4"></td>
        <td height="45" style="padding-left:10"><?php if(isset($_SESSION['rst_msg'])) echo($_SESSION['rst_msg']); unset($_SESSION['rst_msg']); ?>		</td>
      </tr>
      <tr>
        <td height="110">&nbsp;</td>
        <td width="404" height="110" valign="top" style="padding-left:10px; padding-top:30px"> 
        <input name="Submit" type="submit" class="btn" value=" Submit ">        </td>
        <td width="405" height="110">&nbsp;</td>
      </tr>
    </table>
    </font>
</form>
<?php include("bottomMenuEN.php"); ?>
</body>
</html>
