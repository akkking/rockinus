<?php  include("ValidCheck.php"); ?>
<html>
<head>
<title>G-Unit Records Check-in Check-out Inventory System</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="style.css" />
<link href="calendar.css" rel="stylesheet">
<script src="calendar.js"></script>
<style type="text/css">
<!--
.STYLE14 {font-weight: bold}
.STYLE15 {font-size: 12px}
.STYLE16 {font-size: 13px}
.STYLE17 {color: #999999}
.STYLE18 {color: #CCCCCC}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>
<body>
<div align="center" style="background: #B82929; padding-top:0px; padding-bottom:0px; border-bottom:#000000 solid 1; border-top:#000000 solid 1; margin-bottom: 0px; margin-top: 0px" >
  <div align="left" style="margin-left:20px"> 
      <table width="907" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="70"><font size="5"><a href=<?php if(isset($_SESSION['linkpage']))echo($_SESSION['linkpage']);else echo("login.php") ?>><img src="img/GUnitThisis50New_com.png" width="70" height="70" style="border:0px"></a></font></td>
          <td width="773" style="padding-left:20px">
		  <font size="5">
		  <a href=<?php if(isset($_SESSION['linkpage']))echo($_SESSION['linkpage']);else echo("login.php") ?>>
		  G-Unit Records Check-in Check-out Inventory System</a>
		  </font>
		  </td>
        </tr>
    </table>
  </div>
</div>
<div style="width:100%; background-color:#F9F8FE; border-bottom:1px #EEEEEE dotted; margin-bottom:15px" align="left">
  <table width="750" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="200" height="30" bgcolor="#F9F8FE" style=" border-bottom:0px dotted #CCCCCC; border-right:1px dotted #CCCCCC" align="center">
	  <font color="#000000" size=3>
        <?php
			if(isset($_SESSION['uname'])) {
				$uname = $_SESSION['uname']; 
 				echo "<strong><font color=#336633 size=3><em>Hi, $uname</em></font></strong>";
		}else echo("");
	?>
      </font></td>
      <td width="100" height="30" bgcolor="#EEEEEE" style="border-bottom:1px dotted #CCCCCC; border-right:1px dotted #CCCCCC" align="center">
	  <a href=<?php if(isset($_SESSION['linkpage']))echo($_SESSION['linkpage']);else echo("login.php") ?> class=one>
	  <font color="#000000" size=3>Home</font>	  </a>	  </td>
      <td width="130" height="30"  bgcolor="#EEEEEE" style="border-bottom:1px dotted #CCCCCC; border-right:1px dotted #CCCCCC" align="center"><?php
		if(isset($_SESSION['uname'])) {
		echo "<font size=3><a href=checkIn.php class=one>Check In</a></font>";
		}else echo("");
	?></td>
      <td width="130"  bgcolor="#EEEEEE" style="border-bottom:1px dotted #CCCCCC; border-right:1px dotted #CCCCCC" align="center"><?php
		if(isset($_SESSION['uname'])) {
		echo "<font size=3><a href=checkOut.php class=one>Check Out</a></font>";
		}else echo("");
	?></td>
      <td width="160"  bgcolor="#EEEEEE" style="border-bottom:1px dotted #CCCCCC; border-right:1px dotted #CCCCCC" align="center"><?php
		if(isset($_SESSION['uname'])) {
		echo "<font size=3><a href=pwdreset.php class=one>Passwd Reset</a></font>";
		}else echo("");
	?></td>
      <td width="130" height="30" align="center" style="border-bottom:1px dotted #CCCCCC; border-right:1px dotted #CCCCCC" bgcolor="#EEEEEE">
	  <?php
			if(isset($_SESSION['uname'])) 
				//$uname = $_SESSION['uname']; 
 				echo "<font size=3><a href=logoff.php class=one>Log Out</a></font>";
		?></td>
    </tr>
  </table>
</div>
</body>
</html>
