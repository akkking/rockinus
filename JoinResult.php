<?php
include("main_header.php");
include 'dbconnect.php'; 
?>
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

<table width="1024" height="58" border="0" cellpadding="0" cellspacing="0" style=" margin-top:10; margin-bottom:15px">
      <tr>
        <td colspan="2" valign="middle" width="400">&nbsp;</td>
        <td width="648" valign="middle" align="right">
		<?php 
	if(isset($_SESSION['usrname']))$uname = $_SESSION['usrname']; 
	if(isset($_SESSION['uname_tag'])) $uname_tag = $_SESSION['uname_tag']; else $uname_tag="";
	if(isset($_SESSION['rid'])) $rid = $_SESSION['rid']; else $rid="";
?>
		<div style="border:24px solid #CCCCCC; width:600; height:230; margin-bottom:120; -moz-border-radius: 10px; border-radius: 10px;">
          <table width="600" height="230" border="0" cellpadding="0" cellspacing="0" style="border:1px  #333333 solid; background-color:#FFFFFF">
            <tr>
              <td height="200" align="left" style="padding-bottom:10; padding-left:40; line-height:200%">
			  <?php 
		//if(!isset($_SESSION['rst_msg'])&&!isset($_SESSION['Delay'])){
		//	header("location:main.php");
		//}
		
		if(isset($_SESSION['rst_msg'])){
			echo($_SESSION['rst_msg']); 
			unset($_SESSION['rst_msg']);
		}
		
		if(isset($_SESSION['Delay'])&&$_SESSION['Delay']=="OK") {
			$result = mysql_query("INSERT INTO rockinus.user_log_info (uname,log_date,log_time, flag) VALUES('$uname', CURDATE(), NOW(), '1')");
			if (!$result) die('Invalid query: '.mysql_error());
			echo("&nbsp;&nbsp;<a href=ThingsRock.php class=one><u><strong><font size=4>Click Here</font></strong></u></a>");
			unset($_SESSION['Delay']); 
		 }
	?>              </td>
            </tr>
          </table>
        </div></td>
      </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
