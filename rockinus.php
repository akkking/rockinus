<html>
<head>
<title>Rock In U.S.</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div align="center">
  <div style="margin-bottom: 15; margin-top: 8; margin-left:0" align="center">
    <table width="1024" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="1024" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="205" rowspan="3"><a href="rockinus.php"><img src="img/rockinus_logo.jpg" border="0"></a></td>
            <td width="742" height="25">&nbsp;</td>
            <td width="77">
			<div align="center" style="padding-right:8; margin-left:12; padding-left:4; background-color:#EEEEEE; width:74; padding-top:3; padding-bottom:3">
              <?php 
 		session_start(); 
		$_SESSION['aaa']="123"; 
//		$uname = $_SESSION['usrname']; 
// 		if($_SESSION['usrname']=="")echo(Login);
//		else echo "Hi, $uname";
	?>
            </div></td>
          </tr>
          <tr>
            <td height="20">&nbsp;</td>
            <td height="20">
			<div align="center" style="padding-right:8; margin-left:12; padding-left:3; background-color:#EEEEEE; width:60; padding-top:3; padding-bottom:3">
			<a href="logoff.php" class="one STYLE12">Log Out</a></div>
			</td>
          </tr>
          <tr>
            <td colspan="2"><div align="right"></div></td>
          </tr>
        </table>          
        <a href="rockinus.php"></a></td>
      </tr>
    </table>
  </div>
  <div style="margin-bottom: 4; margin-top: 4">
<div align="center" style="background:#336633; padding-top:10px; padding-bottom:10px" >
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#336633" height="16">
    <tr>
      <td width="170" valign="middle"><div align="center"><a href="#">Things Rock You </a></div></td>
      <td width="170" valign="middle"><div align="center"><a href="HouseRental.php">Buy-Sale-Rent-Lease </a></div></td>
      <td width="170" valign="middle"><div align="center"><a href="SchoolCourse.php">Schools &amp; Courses</a>  </div></td>
      <td width="170" valign="middle"><div align="center"><a href="FriendGroup.php">Friends &amp; Groups </a> </div></td>
      <td width="170" valign="middle"><div align="center"><a href="#">Profile &amp; Resume </a></div></td>
      <td width="170" valign="middle"><div align="center"><a href="#">Wisdom Corner </a> </div></td>
    </tr>
  </table>
</div>
  </div>
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="339" align="left" valign="top" style="border-right: 0px solid black; padding-right:0">
	  <form action="login_process.php" method="post">
          <div style="margin-top: 0; margin-bottom: 0; margin-left:0; margin-right: -12" align="center">
            <div align="center" style="background-color: #EEEEEE; opacity:0.9; filter:alpha(opacity=90); padding-top: 13; padding-bottom: 6; margin-bottom: -20; margin-top:0; border-color: #CCCCCC; margin-left: 0; margin-right:0; padding-left:-10; border-style: solid; width:300; border-width: 1;">
              <table width="308" height="137" border="0" cellpadding="0" cellspacing="8">
                <tr>
                  <td width="112" height="24" align="right"><span class="STYLE10">Rocker ID: </span></td>
                  <td width="172"><input type="text" name="usrname" style="border-style: solid; border-width: 1px;border-color: black;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #FFFFFF">                  </td>
                </tr>
                <tr>
                  <td height="24" align="right"><span class="STYLE10">Password: </span></td>
                  <td><input type="password" name="passwd" style="border-style: solid; border-width: 1px;border-color: black;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #FFFFFF" size="17" >                  </td>
                </tr>
                <tr>
                  <td height="25" align="right"><label>
                    <input type="checkbox" name="checkbox" value="checkbox">
                  </label></td>
                  <td>Keep me logged in </td>
                </tr>
                <tr>
                  <td height="24">&nbsp;</td>
                  <td><input type="submit" name="Submit" value="Rock In" class="btn">                  </td>
                </tr>
              </table>
              <div style="padding-top: 6; padding-bottom: 8; margin-top: 10; margin-bottom:25; width: 160; background-image:url(img/Green Gray.jpg)" align="center"><span class="STYLE9"><a class="one" href="#">Forget Password?</a></span></div>
              <div style="background-color:#EEEEEE; padding-top: 18; padding-bottom: 11; margin-top: 20; padding-left: 10; border-color: #999999; border-style: solid; width:290; margin-left:15; margin-right:20; margin-bottom:0; border-width: 1; border-top-width:2px; border-left:none; border-bottom:none; border-right:none; opacity:0.9; filter:alpha(opacity=90); " align="left"><strong> NOT A MEMBER? </strong>
                  <div align="left" class="STYLE11" style="padding-top: 3; padding-bottom: 4; padding-right:5; margin-top: 10; margin-bottom:3; width: 280;">Rockinus is a school-based social network in America. You can find info about schools, courses, rentals, things for sale, and other info as well. You can make friends, build up resume, share  concerned problems with other rockers. </div>
                  <div align="center" class="STYLE6" style="padding-top: 4; padding-bottom: 6; margin-top: 15; margin-bottom:3; width: 120; background-color: #336633; background-image:url(img/Green .jpg)"><a href="rockinus_reg.php">Join Rockinus </a><a class="one" href="#"></a></div>
              </div>
            </div>
          </div>
      </form>
	  <div align="center"></div></td>
      <td width="685" align="left" valign="top"><div align="center" style="margin-left:5; margin-top: 0"><img src="img/Flag_cover_Students.jpg" width="680" height="400"><br />
      </div></td>
    </tr>
  </table>
  <p style="border-bottom: 1px dotted #336633; margin-top:-10; margin-left:12; margin-bottom:10; width: 1010"></p>
  </font>
  <div style="font-size:12px">
  <a class="one" href="rockinus_intro.php">About us</a>&nbsp;|&nbsp; Jobs &nbsp;|&nbsp; <a href="advertise.php" class=one>Advertising</a>&nbsp; |&nbsp; <span class="STYLE7">Give us a feedback.</span>  </div>
  <div style="margin-bottom:4; margin-top:4; font-size:12px">Copyright &copy; 2011 Rockinus Inc. </div>
</div>
</body>
</html>
