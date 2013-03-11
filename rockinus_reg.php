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
	background-image: url(img/empireSmallOne.jpg);
}
body,td,th {
	font-size: 13px;
	font-family: Arial, Helvetica, sans-serif;
}
.STYLE7 {color: #CC3300}
.STYLE9 {color: #CCCCCC}
-->
</style>
</head>
<body>
<?php 
	session_start(); 
	if(isset($_SESSION['uname']))$uname = $_SESSION['uname']; 
	if(isset($_SESSION['uname_tag'])) $uname_tag = $_SESSION['uname_tag']; else $uname_tag="";
	if(isset($_SESSION['rid'])) $rid = $_SESSION['rid']; else $rid="";
?>
<div align="center">
<div style="margin-bottom: 15; margin-top: 8; margin-left:0" align="center">
  <table width="1024" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><a href="main.php"><img src="img/rockinus_logo.jpg" border="0"></a></td>
    </tr>
  </table>
</div>
  <div style="margin-bottom: 4; margin-top: 4">
    <div align="center" style="background:#336633; padding-top:10px; padding-bottom:10px; margin-left:0" >
      <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="" height="16">
        <tr>
          <td width="170" valign="middle"><div align="center"><a href="#">Things Rock You </a></div></td>
          <td width="170" valign="middle"><div align="center"><a href="#">Buy-Sale-Rent-Lease </a></div></td>
          <td width="170" valign="middle"><div align="center"><a href="#">Schools &amp; Courses</a> </div></td>
          <td width="170" valign="middle"><div align="center"><a href="#">Friends &amp; Groups </a> </div></td>
          <td width="170" valign="middle"><div align="center"><a href="#">Message &amp; Profile </a></div></td>
          <td width="170" valign="middle"><div align="center"><a href="#">Wisdom Corner </a> </div></td>
        </tr>
      </table>
    </div>
  </div>
  <div align="center">
  	<form id="unameForm" action="unameExist.php" method="post" onSubmit="return checkForm(this);" style="margin-bottom:0; margin-top:0;">
    <table width="1014" height="35" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-left:1 dotted #CCCCCC; border-right:1 dotted #CCCCCC">
      <tr>
        <td width="219" height="35" valign="middle"><div align="right" style="padding-right:5; margin-bottom:-8"><strong>Rock ID: </strong></div></td>
        <td width="790" colspan="2" valign="middle">&nbsp;
			<input name="uname" type="text" class="box" maxlength="15" onFocus="this.value=''" onBlur="if(checkForm(this.form))this.form.submit();" value=<?php echo($rid) ?> >
			<input type="submit" value="Check" />
		<span class="STYLE7">*</span> 
        <?php echo $uname_tag; $_SESSION['uname_tag'] = ""; ?>
		  </td>
      </tr>
    </table>
  </form>
  <form action="reg_process.php" method="post" name="profile" onSubmit="return validateForm()" style="margin-top:0; margin-bottom: 11;">
    <table width="1014" height="484" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-left:1 #CCCCCC dotted;border-right:1 #CCCCCC dotted">
      <tr>
        <td width="219" height="35"><div align="right" style="padding-right:5"><strong>Password: </strong></div></td>
        <td colspan="2">&nbsp;
            <input name="passwd" type="password" class="box">
            <span class="STYLE7">*</span> <span class="STYLE9">[ Higher complexity is recommended ] </span></td>
      </tr>
      <tr>
        <td height="33"><div align="right" style="padding-right:5"><strong>Confirm Password: </strong></div></td>
        <td colspan="2">&nbsp;
            <input name="cpasswd" type="password" class="box">
            <span class="STYLE7">*</span> </td>
      </tr>
      <tr>
        <td height="33"><div align="right" style="padding-right:5"><strong>Your Name: </strong></div></td>
        <td colspan="2">&nbsp;
            <input name="fname" type="text" class="box" onFocus="value=''" value="First Name">
            <input name="lname" type="text" class="box" onFocus="value=''"  value="Last name"></td>
      </tr>
      <tr>
        <td height="33"><div align="right" style="padding-right:5"><strong>Birthdate:</strong></div></td>
        <td colspan="2">&nbsp;
            <input name="birthdate" type="text" class="box" id="birthdate" onFocus="show_cele_date(birthdate,'','',birthdate)" size="10" maxlength="10">
            <span class="STYLE7">*
              <div id="calendar"></div>
            </span></td>
      </tr>
      <tr>
        <td height="33"><div align="right" style="padding-right:5"><strong>I am </strong></div></td>
        <td colspan="2">&nbsp;
            <input type="radio" name="gender" value="M" checked="checked">
          Male
          <input type="radio" name="gender" value="F">
          Female </td>
      </tr>
      <tr>
        <td height="33"><div align="right" style="padding-right:5"><strong>I am a </strong></div></td>
        <td colspan="2">&nbsp;
            <input type="radio" name="sstatus" value="S"  checked="checked">
          Student
          <input type="radio" name="sstatus" value="E">
          Employe(e/r) </td>
      </tr>
      <tr>
        <td height="33"><div align="right" style="padding-right:5"><strong>Where you stay? </strong></div></td>
        <td colspan="2">&nbsp;
            <select name="cstate" id="cstate" onChange="cityChange(this);">
              <option value="empty">Select a State</option>
              <option value="NY">New York</option>
            </select>
            <select name="ccity" id="ccity">
              <option value="empty">Select a City</option>
            </select>
            <span class="STYLE7">* <span class="STYLE9">[ Current only New York is avaliable ]</span></span></td>
      </tr>
      <tr>
        <td height="33"><div align="right" style="padding-right:5"><strong>Current School: </strong></div></td>
        <td colspan="2">&nbsp;
            <select name="cschool" id="cschool">
              <option value="empty">Select a School</option>
              <option value="NYNYU">New York University</option>
              <option value="NYCOLUMBIA">Columbia University</option>
              <option value="NYPOLY">Polytechnic University of New York University</option>
              <option value="NYCUNY">City University of New York</option>
              <option value="NYLIU">Long Island University</option>
              <option value="NYNYIT">New York Institute of Technology</option>
            </select>
            <span class="STYLE7">*</span> <span class="STYLE9">[ If not a student, type the most recent school studied ] </span></td>
      </tr>
      <tr>
        <td height="33"><div align="right" style="padding-right:5"><strong>I am a(n) </strong></div></td>
        <td colspan="2">&nbsp;
            <input type="radio" name="cdegree" value="U"  checked="checked">
          Undergraduate
          <input type="radio" name="cdegree" value="G">
          Graduate
          <input type="radio" name="cdegree" value="P">
          PHD/Doctor
          <input type="radio" name="cdegree" value="C">
          Certificate Program</td>
      </tr>
      <tr>
        <td height="33"><div align="right" style="padding-right:5"><strong>Which Program Study? </strong></div></td>
        <td colspan="2">&nbsp;
            <select name="cmajor">
              <option>Select a program</option>
              <option value="ECVE">Civil Engineering</option>
              <option value="ECS">Computer Science</option>
              <option value="EEE">Electrical Engineering</option>
              <option value="ECBE">Chemical and Biomolecular Engineering</option>
              <option value="ECE">Chemical Engineering</option>
              <option value="EBS">Biomolecular Science</option>
              <option value="EBENT">Biotechnology and Entrepreneurship</option>
              <option value="EC">Chemistry</option>
              <option value="EBENG">Biomedical Engineering</option>
              <option value="EBT">Biotechnology</option>
              <option value="EMC">Materials Chemistry</option>
              <option value="EBI">Bioinstrumentation</option>
              <option value="EBM">Biomedical Materials</option>
            </select>
            <span class="STYLE7">*</span> <span class="STYLE9">[ The major you study(ied) at current or most recent school ] </span></td>
      </tr>
      <tr>
        <td height="33"><div align="right" style="padding-right:5"><strong>Where  From? </strong></div></td>
        <td colspan="2">&nbsp;
            <select name="fcountry" id="fcountry" onChange="gcityChange(this);">
              <option value="empty">Select a country</option>
              <option value="IN">India</option>
              <option value="CN">P.R. China</option>
              <option value="TK">Turkey</option>
              <option value="KO">Korea</option>
              <option value="MX">Mexico</option>
              <option value="TW">Taiwan</option>
              <option value="JP">Japan</option>
              <option value="US">United States</option>
              <option value="UK">United Kingdom</option>
              <option value="SP">Spain</option>
            </select>
            <span class="STYLE7">
            <select name="fcity" id="fcity">
              <option value="empty">Select a city</option>
            </select>
              *</span> </td>
      </tr>
      <tr>
        <td height="33"><div align="right" style="padding-right:5"><strong>I am currently </strong></div></td>
        <td colspan="2">&nbsp;
            <input type="radio" name="mstatus" value="S" checked="checked">
          Single
          <input type="radio" name="mstatus" value="M">
          Married
          <input type="radio" name="mstatus" value="I">
          In a relationship</td>
      </tr>
      <tr>
        <td height="33"><div align="right" style="padding-right:5"><strong>Email: </strong></div></td>
        <td colspan="2">&nbsp;
            <input name="email" type="text" class="box" size=30>
            <span class="STYLE7">*</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="emailcheck" value="checkbox" checked="checked">
          Keep me informed </td>
      </tr>
      <tr>
        <td height="33"><div align="right" style="padding-right:5"><strong>Phone: </strong></div></td>
        <td colspan="2">&nbsp;
            <input name="phone" type="text" class="box"></td>
      </tr>
      <tr>
        <td height="33"><div align="right" style="padding-right:5"><strong>Address:</strong></div></td>
        <td colspan="2">&nbsp;
            <input name="address" type="text" class="box" size="80"></td>
      </tr>
      <tr>
        <td height="33">&nbsp;</td>
        <td width="538"><div align="center"> <br>
              <input name="Submit" type="submit" class="btn" value="Submit">
          <p>         
        </div></td>
        <td width="252">&nbsp;</td>
      </tr>
    </table>
    </font>
    </form>
	<div style="font-size:12px">
  <a class="one" href="rockinus_intro.php">About Us</a>&nbsp;|&nbsp; Jobs &nbsp;|&nbsp; Advertising&nbsp; |&nbsp; <span class="STYLE7">Give us a feedback.</span></div>
  <div style="margin-bottom:4; margin-top:4; font-size:12px">Copyright &copy; 2011 Rockinus Inc. </div>
</div>
</div>
</body>
</html>
