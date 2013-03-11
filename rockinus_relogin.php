<html>
<head>
<title>Rock In U.S.</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="style.css" />
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
body {
	margin-left: 0px;
	margin-top: 0px;
	background-image: url(%20);
}
body,td,th {
	font-size: 13px;
	font-family: Arial, Helvetica, sans-serif;
}
.STYLE10 {	color: #000000;
	font-weight: bold;
}
input.btn {color:#050;   font: bold 84%'trebuchet ms',helvetica,sans-serif;   background-color: #fed; }
.STYLE11 {color: #339933}
.STYLE12 {color: #CC6633}
-->
</style></head>
<body>
<div align="center">
<?php include("FreeHeader.php") ?>
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="margin-bottom:15px">
  <tr>
    <td align="center" bgcolor="#F5F5F5" style="border-top:1px #999999 dashed">
	<?php 
	session_start(); 
	if(isset($_SESSION['rst_msg'])){
		echo($_SESSION['rst_msg']);
		unset($_SESSION['rst_msg']);
	}
?>
      <form action="login_process.php" method="post">
        <div style="margin-top: 10">
          <div align="center" style="background-color: #FFFFFF; opacity:0.9; filter:alpha(opacity=85); padding-top: 50px; padding-bottom: 20px; margin-top:70px; margin-bottom:70px; padding-left: 10px; padding-right:10px; border:12px #DDDDDD solid; width:450;">
            <table width="400" height="270" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="145" height="30" align="right" style="padding-right:15px"><strong><font size="3">Username</font></strong></td>
                <td width="255" height="30"><input type="text" style="height:22px" name="usrname" class="box" size="22"></td>
              </tr>
              <tr>
                <td width="145" height="30" align="right" style="padding-right:15px"><strong><font size="3">Password</font></strong></td>
                <td width="255" height="30"><input type="password" style="height:22px"  name="passwd" size="22" class="box">
                </td>
              </tr>
              <tr>
                <td width="145" height="35" align="right" style="padding-right:15px">
                  <input type="checkbox" name="checkbox" value="checkbox">
                </td>
                <td width="255" height="35">Keep me logged in </td>
              </tr>
              <tr>
                <td width="145" height="35">&nbsp;</td>
                <td width="255" height="35"><input type="submit" name="Submit" value=" Sign In " class="btn">
                </td>
              </tr>
              <tr>
                <td width="145" height="80">&nbsp;</td>
                <td width="255" height="80" valign="top" style="padding-top:10px">
				<a href="findPassword.php" class="one">Forget Password?				</a>
				<p style="margin-bottom:25px">
				<div align="center" style="padding-top:5px; padding-bottom:5px; padding-left:8px; padding-right:8px; margin-top: 10px; display:inline; margin-bottom:0px; background-color: #B92828; border-bottom:1 solid #000000; border-right:1 solid #000000"><a href="joinUs.php"><strong>&nbsp;Sign Up&nbsp;</strong></a></div>
				</td>
              </tr>
            </table>
          </div>
        </div>
    </form></td>
  </tr>
</table>
<?php include("bottomMenuEN.php"); ?>
</div>
</body>
</html>
