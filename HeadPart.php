<html>
<head>
<title>Rock In U.S.</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <div style="margin-bottom: 15; margin-top: 8; margin-left:0" align="center">
    <table width="1024" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="205" rowspan="3"><a href="main.php"><img src="img/rockinus_logo.jpg" border="0"></a></td>
        <td width="743">&nbsp;</td>
        <td width="76"><div align="center" style="margin-left:12; width:66; background-color:#EEEEEE; border-bottom: 1px dotted #CCCCCC;">
            <?php 
 		session_start(); 
		$uname = $_SESSION['usrname']; 
 		if($_SESSION['usrname']=="")echo(Login);
		else echo "Hi, $uname";
	?>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="center" style="width:50; background-color:#EEEEEE; margin-left:12; border-bottom: 1px dotted #CCCCCC;"> <a href="logoff.php" class="one STYLE12">Log Out</a></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
  <a href="rockinus.php"></a></div>
  <div style="margin-bottom: 4; margin-top: 4">
<div align="center" style="background:#336633; padding-top:10px; padding-bottom:10px; margin-bottom:8" >
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#336633" height="16">
    <tr>
      <td width="170" valign="middle"><div align="center"><a href="#">Things Rock You </a></div></td>
      <td width="170" valign="middle"><div align="center"><a href="HouseRental.php">Buy-Sale-Rent-Lease </a></div></td>
      <td width="170" valign="middle"><div align="center"><a href="SchoolCourse.php">Schools &amp; Courses</a>  </div></td>
      <td width="170" valign="middle"><div align="center"><a href="FriendGroup.php">Friends &amp; Groups </a> </div></td>
      <td width="170" valign="middle"><div align="center"><a href="MessageList.php">Message &amp; Profile</a> </div></td>
      <td width="170" valign="middle"><div align="center"><a href="#">Wisdom Corner </a> </div></td>
    </tr>
  </table>
</div>
  </div>
</font>
</body>
</html>
