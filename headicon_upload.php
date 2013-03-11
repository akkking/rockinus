<html>
<head>
<title>Rock In U.S.</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
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
	background-image: url(img/empireSmallOne.jpg);
}
body,td,th {
	font-size: 14px;
	font-family: Arial, Helvetica, sans-serif;
}
.STYLE10 {	color: #000000;
	font-weight: bold;
}
input.btn {color:#050;   font: bold 84%'trebuchet ms',helvetica,sans-serif;   background-color: #fed; }
.STYLE12 {color: #CC6633}
.STYLE13 {
	color: #336633;
	font-weight: bold;
}
.STYLE14 {color: #FF3300}
.STYLE9 {color: #339933}
-->
</style></head>
<body>
<div style="margin-bottom: 15; margin-top: 8; margin-left:0" align="center">
  <table width="1024" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><a href="main.php"><img src="img/rockinus_logo.jpg" border="0"></a></td>
    </tr>
  </table>
  <a href="rockinus.php"></a></div>
<div style="margin-bottom: 4; margin-top: 4">
<div align="center" style="background:#336633; padding-top:10px; padding-bottom:10px" >
  <div align="center">
    <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#336633" height="16">
      <tr>
        <td width="170" valign="middle"><div align="center"><a href="#">Things Rock You </a></div></td>
          <td width="170" valign="middle"><div align="center"><a href="#">Buy-Sale-Rent-Lease </a></div></td>
          <td width="170" valign="middle"><div align="center"><a href="#">Schools &amp; Courses </a> </div></td>
          <td width="170" valign="middle"><div align="center"><a href="#">Friends &amp; Groups </a> </div></td>
          <td width="170" valign="middle"><div align="center"><a href="#">Profile &amp; Resume </a></div></td>
          <td width="170" valign="middle"><div align="center"><a href="#">Wisdom Corner </a> </div></td>
        </tr>
    </table>
  </div>
</div>
</div>
<div align="center">
<form enctype="multipart/form-data" action="upload.php"  method="post">
	<div style="margin-top: 10"><br>
	  <span class="STYLE13"><span class="STYLE14">Congratulations 
      </span><?php 
 		session_start(); 
		$uname = $_SESSION['usrname']; 
 		echo "$uname";?>. <p>You have successfully registered Rockinus.</span>
	  <div align="center" style="background-color: #FFFFFF; opacity:0.9; filter:alpha(opacity=60); padding-top: 15; padding-bottom: 15; margin-top:40; margin-bottom:50; padding-left: 10; padding-right:10; border-color: #999999; border-style: solid; width:300;; border-width: 2;">
	    <table width="550" height="89" border="0" cellpadding="0" cellspacing="8">
          <tr>
            <td width="270" height="39" align="right" class="STYLE10">Now, please upload your head icon: </td>
            <td colspan="2"><input name="uploaded" type="file" style="border-style: solid; border-width: 1px;border-color: black;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #FFFFFF" /></td>
          </tr>
          <tr>
            <td height="24">&nbsp;</td>
            <td width="66"><input type="submit" name="Submit" value="Upload" class="btn"></td>
            <td width="182"><div style="padding-top: 3; padding-bottom: 3; margin-top: 0; margin-bottom:0; width: 120; background-color:#336633; border-bottom:#000000 solid 1" align="center"><span class="STYLE9"><a href="ThingsRock.php">Skip this step</a></span></div></td>
          </tr>
        </table>
      </div>
	</div>
  </form><br>
  <div align="center">
    <div align="center"></font>
        <p style="border-bottom: 1px dotted #336633; margin-top:-15; margin-left:0; margin-bottom:10; width: 100%"></p>
      <div style="font: smaller" >Copyright &copy; 2011 Rockinus Inc. &nbsp; &nbsp; &nbsp; </div>
      <div style="font: smaller; margin-top:5"><a class="one" href="rockinus_intro.php">About us</a>&nbsp;|&nbsp; <a href="jobs.php" class="one">Jobs</a> &nbsp;|&nbsp; Contact us &nbsp;|&nbsp; <span class="STYLE12">Give us a feedback.</span></div>
      <br>
    </div>
  </div>
</div>
</body>
</html>
