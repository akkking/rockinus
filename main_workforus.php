<?php
include("main_header.php");
include 'dbconnect.php';
include("Allfuc.php"); 	
?>
<LINK REL="SHORTCUT ICON" HREF="img/rockinTag.png">
<title>New York Community Network</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<style type="text/css">
.bg1 { background-color: #6c0000; }
.bg2 { background-color: #5A2A00; }
.bg3 { background-color: #00345B; }
ul.switchcolor {
	margin: 0;
	padding: 0;
	height: 33px;
	line-height: 33px;
	border:0px #CCCCCC dotted
}

ul.switchcolor a {
	text-decoration: none;
	color: #B82929;
	display: block;
	padding: 0 20px;
	outline: none;
}
ul a:hover {
	background:;
}	

html ul.tabs li.active, html ul.tabs li.active a:hover  {
	background: #09F;
	border-bottom: 0px solid #fff;
}

p { 
font-size:100%; cursor:pointer; line-height: 300% }

.capfontClass {
	font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;
   color:  #999999;
}  

.capfontClass A {color: #666666; font-size: 9px;}
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
span.error{
	font-size:14px;
	display:inline;
	color: #B92828;
}
-->
</style>
<link type="text/css" href="style/PasswordStyle.css" rel="stylesheet" />
<script type="text/javascript" src="js/mocha.js"></script>
<script src="autoSubmit.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
</head>
<body>
<?php 
	if(isset($_SESSION['uname']))$uname = $_SESSION['uname']; 
	if(isset($_SESSION['uname_tag'])) $uname_tag = $_SESSION['uname_tag']; else $uname_tag="";
	if(isset($_SESSION['rid'])) {$rid = $_SESSION['rid']; unset($_SESSION['rid']); }else $rid="";
?>
<div align="center">
  <div class="dailyUpdateDiv" id="dailyUpdateDiv" style="margin-top:10">
  <table width="1024" height="450" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="250" valign="top" align="left" style="border-right:0px dashed #CCCCCC">
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main.php" class="one">Home</a></td>
          <td width="40" style="font-size:12px; font-family:Arial, Helvetica, sans-serif, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif; font-weight:bold">&nbsp;&nbsp;Work for Us</td>
          <td width="40" style="font-size:12px; font-family:Arial, Helvetica, sans-serif, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main_leaveComment.php" class="one">Comment</a></td>
          <td width="40" style="font-size:12px; font-family:Arial, Helvetica, sans-serif, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="45" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="25"><img src="img/blackArrow.png" width="20"></td>
          <td width="135" style="font-size:14px; font-family:Arial, Helvetica, sans-serif, sans-serif; font-weight:bold">&nbsp;&nbsp;<a href="main_aboutUs.php" class="one">About Us</a></td>
          <td width="40" style="font-size:12px; font-family:Arial, Helvetica, sans-serif, sans-serif; color:; font-weight:bold; padding-right:5" align="right">>></td>
        </tr>
      </table>
      <table width="200" height="150" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px solid #DDDDDD">
        <tr>
          <td valign="bottom">&nbsp;</td>
        </tr>
      </table></td>
    <td width="68">&nbsp;</td>
    <td width="706" align="right" valign="top"><div style="border:1px #DDDDDD solid; background-color:#FFF; margin-top:-50px">
      <table width="680" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="720" height="86" colspan="0" align="left" valign="top"><table width="729" height="35" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333" style="border-bottom:1px solid #999999; margin-bottom:10">
              <tr>
                <td width="729" align="left" style="background-color:; padding-left:15px; padding-right:10px; font-family: Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; color:#FFFFFF" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;"> Work for Rockinus.com - Great Experience </td>
              </tr>
            </table>
              <table width="729" height="41" border="0" cellpadding="0" cellspacing="0" style="border-top:0px dashed #CCCCCC">
                <tr>
                  <td width="729" height="41" align="left" style="background-color:; font-weight:bold; padding-left:15px; padding-right:10px; font-family: Arial, Helvetica, sans-serif; font-size:13px" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;"> We currently need 3 volunteers </td>
                </tr>
              </table>
            <table width="720" height="36" border="0" cellpadding="0" cellspacing="0" style="border-top:0px dashed #CCCCCC">
                <tr>
                  <td width="30" height="40" align="left" style="background-color:; padding-left:15px; font-family: Arial, Helvetica, sans-serif; font-size:16px" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;"><img src="img/rightTriangleIcon.jpg" width="12" height="12" /> </td>
                  <td width="694" height="40" align="left" style="background-color:; color:#660099; padding-left:0px; padding-right:10px; font-family: Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;">PHP Developer </td>
                </tr>
              </table>
            <table width="720" height="36" border="0" cellpadding="0" cellspacing="0" style="border-top:0px dashed #CCCCCC; margin-bottom:20;">
                <tr>
                  <td width="30" height="36" align="left" style="background-color:; padding-left:15px; font-family: Arial, Helvetica, sans-serif; font-size:16px" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;">&nbsp;</td>
                  <td width="690" align="left" style="background-color:; line-height:130%; padding-left:0px; padding-right:10px; font-family: Arial, Helvetica, sans-serif; font-size:13px" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;"> Interested, experienced in PHP programming (Nice to show demos if you have)<br />
                    Understand Web front design, like HTML/CSS, Jquery, Ajax, XML, Json, e.g.<br />
                    Experiences in MySql, consistent passion and competitive knowledge is required<br />
                    Quality coding skills, can handle and resolve complex issues<br />
                    Independent, efficient working capability <br />
                    Outgoing, smooth communicative with other teammates <br />
                    <br />
                    Responsibility:<br />
                    Fixing current PHP coding problems, implementing solutions<br />
                    Coding for new functionalities according to user requirement<br />
                    Debugging and testing exist issues<br />
                    Exploring for new ideas<br />
                  </td>
                </tr>
              </table>
            <table width="720" height="40" border="0" cellpadding="0" cellspacing="0" style="border-top:1px dashed #CCCCCC">
                <tr>
                  <td width="30" height="40" align="left" style="background-color:; padding-left:15px; font-family: Arial, Helvetica, sans-serif; font-size:16px" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;"><img src="img/rightTriangleIcon.jpg" width="12" height="12" /> </td>
                  <td width="694" height="40" align="left" style="background-color:; padding-left:0px; color:#660099; padding-right:10px; font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:14px" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;">MySql DBA </td>
                </tr>
              </table>
            <table width="720" height="36" border="0" cellpadding="0" cellspacing="0" style="border-top:0px dashed #CCCCCC; margin-bottom:20;">
                <tr>
                  <td width="29" height="36" align="left" style="background-color:; padding-left:15px; font-family: Arial, Helvetica, sans-serif; font-size:16px" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;">&nbsp;</td>
                  <td width="691" align="left" style="background-color:; line-height:130%; padding-left:0px; padding-right:10px; font-family: Arial, Helvetica, sans-serif; font-size:13px" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;"> Familiar with and interested in MySql programming<br />
                    Understand Front-End design of PHP/MySql working process<br />
                    Independent, efficient working capability <br />
                    Quality coding skills, can handle and resolve complex DB cases<br />
                    Consistent passion and competitive knowledge <br />
                    Outgoing, smooth communicative with other teammates <br />
                    <br />
                    Responsibility:<br />
                    Design, develop new DB models according to user requirement<br />
                    Develop code for performing routine DB backup work<br />
					Debugging, testing exist DB issues.Improve DB performance <br />
                    Exploring for new ideas, new structures<br />
                  </td>
                </tr>
              </table>
            <table width="720" height="40" border="0" cellpadding="0" cellspacing="0" style="border-top:1px dashed #CCCCCC">
                <tr>
                  <td width="30" height="40" align="left" style="background-color:; padding-left:15px; font-family: Arial, Helvetica, sans-serif; font-size:16px" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;"><img src="img/rightTriangleIcon.jpg" width="12" height="12" /> </td>
                  <td width="694" height="40" align="left" style="background-color:; padding-left:0px; color:#660099; padding-right:10px; font-family: Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;">QA / Data Analyst </td>
                </tr>
              </table>
            <table width="720" height="36" border="0" cellpadding="0" cellspacing="0" style="border-top:0px dashed #CCCCCC; margin-bottom:20;">
                <tr>
                  <td width="30" height="36" align="left" style="background-color:; padding-left:15px; font-family: Arial, Helvetica, sans-serif; font-size:16px" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;">&nbsp;</td>
                  <td width="694" align="left" style="background-color:; line-height:130%; padding-left:0px; padding-right:10px; font-family: Arial, Helvetica, sans-serif; font-size:13px" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;"> Highly responsible, reliable, self-motivated <br />
                    Great enthusiam in working with speedy paces and big pressures<br />
                    Consistent passion in learning new knowledge from others <br />
                    Outgoing, smooth communicative with other teammates <br />
                    <br />
                    Responsibility:<br />
                    This position is multi-tasking, and very flexible<br />
                    Collecting notices and required info routinely<br />
                    Testing functions of system required by the team<br />
                    Generate required reports in a timely fashion manner<br />
                    Help other teammates out on-demand<br />
                  </td>
                </tr>
              </table>
            <table width="720" height="36" border="0" cellpadding="0" cellspacing="0" style="border-top:0px dashed #CCCCCC; margin-bottom:20; margin-top:10">
                <tr>
                  <td width="30" height="36" align="left" valign="top" style="background-color: ; padding:15px; padding-right:0;  font-family: Arial, Helvetica, sans-serif; font-size:14px"><img src="img/rightTriangleIcon.jpg" width="12" height="12" /> </td>
                  <td width="694" align="left" style="background-color:; line-height:130%;  padding:10px; padding-left:0px; font-family: Arial, Helvetica, sans-serif; font-size:13px"> 
                    <strong>Please send resume to:</strong> <u>superbarmuya@gmail.com</u> or <u>barmuya@hotmail.com</u><br />
					Interview will be required by Rockinus founder<br />
                    Look forward you work at your free time, not affecting your study <br />
                    We ensure that you will gain solid skills and experience with Rockinus.com<br />
                  </td>
                </tr>
            </table></td>
        </tr>
      </table>
    </div></td>
  </tr>
      </table>
    </div></td>
  </tr>
</table>

  </div>
  
  <div class="loginDiv" id="loginDiv"></div>
<br>
<br>
<?php include("bottomMenuEN_login.php"); ?>
</div>
</body>
</html>
