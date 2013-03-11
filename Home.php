<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>NYU-Poly's Local Social Network</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
<!--
body {
	background-color: #F5F5F5;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
-->
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script>
 $(document).ready(function() {
 	 $("#dailyupdate").load("HomeDailyUpdate.php");
   var refreshId = setInterval(function() {
      $("#dailyupdate").load('HomeDailyUpdate.php?randval='+ Math.random());
   }, 2000);
   $.ajaxSetup({ cache: false });
});
</script>
</head>

<body>
<div align="center">
<table width="1024" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px">
  <tr>
    <td height="91" align="left" valign="top" style="padding-left:0px"><img src="img/rockinus_F5.jpg" /></td>
    <td height="91" align="right" valign="top" style="padding-top:10px; font-size:18px; font-weight:bold; padding-right:10px; color:#333333">	</td>
    <td width="667" colspan="2" rowspan="2" align="left" valign="top" style="font-size:16px; font-weight:normal; font-family:Arial, Helvetica, sans-serif; line-height:150%; padding:10px; padding-bottom:15px; padding-left:15px">Rockinus is an open, free, school-based social network for students who study, wish to study, or graduated in Polytechnic Institute of NYU. You can post house rentals, sales, course comments, find jobs, etc. Also, it is a place to find friends, exchange topics with other students as well. We hope you enjoy this network :)</td>
  </tr>
  <tr>
    <td height="35" colspan="2" align="left" style="padding-left:15px">
      <?php 
		  	if(isset($_SESSION['logoff_tag'])){
		  		echo $_SESSION['logoff_tag'];
				unset($_SESSION['logoff_tag']);
			}
		  ?>
    </td>
  </tr>
  <tr>
    <td colspan="2" rowspan="2" valign="top" style="padding-left:0px">
	<form action="login_process.php" method="post">
<table width="204" height="340" border="0" cellpadding="0" cellspacing="0" style="border-left:0px #CCCCCC solid; border-bottom:0px #CCCCCC solid; border-top:0px #CCCCCC solid">
      <tr>
        <td height="24" align="left" style="padding-left:15px; color:#333333"><strong>Username</strong></td>
      </tr>
      <tr>
        <td height="35" align="left" style="padding-left:15px;"><input type="text" style="height:21px;" name="usrname" size="25" onmouseover="this.className='over'" onmouseout="this.className='out'" class="box_login" value="<?php if(isset($_COOKIE["user"])) echo($_COOKIE["user"]); ?>" /></td>
      </tr>
      <tr>
        <td height="25" align="left" style="padding-left:15px; color:#33333"><strong>Password</strong></td>
      </tr>
      <tr>
        <td height="35" align="left" style="padding-left:15px"><input type="password" style="height:21px" name="passwd" onmouseover="this.className='over'" onmouseout="this.className='out'" class="box_login" size="25" />        </td>
      </tr>
      <tr>
        <td height="50" align="left" style="padding-left:15px; font-size:12px"><input type="checkbox" name="Login_Tag" />
          &nbsp;&nbsp;Remember Me </td>
      </tr>
      <tr>
        <td height="30" align="left" style="padding-left:15px"><input type="submit" name="Submit" value=" Sign In " class="btn2" />        </td>
      </tr>
      <tr>
        <td height="50" align="left" style="padding-left:15px; font-size:12px"><img src="img/PenIcon.jpg" /> &nbsp;<a href="findPassword.php" class="one">Forget Password?</a></td>
      </tr>
      <tr>
        <td height="15" style="padding-left:0px; padding-top:10px" align="left"><hr width="170px" color="#000000" style="border:solid 0px" /></td>
      </tr>
      <tr>
        <td height="20" style="padding:15px; padding-bottom:20px; line-height:150%" align="left">
          <div> <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 30px; display:inline; margin-bottom:0px; background-color: #B92828; border-bottom:1 solid #333333; border-top:1 solid #333333"><a href="joinUs.php"><strong>Sign Up</strong></a></span> &nbsp; <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 30px; display:inline; margin-bottom:5px; background: #666666; border-bottom:1 solid #000000; border-top:1 solid #000000"><a href="commentUs.php"><strong>Comment</strong></a></span></div></td>
      </tr>
    </table>
	</form>	</td>
    <td height="74" colspan="2" align="left" valign="top" style="padding-left:15px; padding-top:5px">
	<img src="img/polyfont_cover_bg.jpg" />	</td>
  </tr>
  <tr>
    <td height="45" colspan="2" valign="top" style="padding-left:15px">&nbsp;</td>
  </tr>
  <tr>
    <td width="205" height="50" align="left" valign="top" style="padding-left:15px; font-size:16px; color:#000000;"><div style="border:1px #CCCCCC dashed; line-height:180%; background-color:#FFFFFF; font-size:14px; width:165; margin-left:15; padding:10px; margin-bottom:20" align="top"> Rockinus currently only supports registration with <font color="#B92828">.edu</font> email, thanks for your understanding.</div></td>
    <td width="152" align="right" valign="top" style=" padding-top:0px; padding-right:10px; font-size:16px; font-weight:bold; color: #333333; font-family:Arial, Helvetica, sans-serif">&nbsp;<img src="img/grayStar_FFCC33.jpg" width="20" height="20" /></td>
    <td colspan="2" align="left" valign="top" style=" font-family:Arial, Helvetica, sans-serif; padding-bottom:0px; line-height:150%; padding-top:0px; font-size:16px"><table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="343" height="25" align="left" valign="top" style=" font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; padding-top:0px; font-size:16px">Registered student number 25</td>
        <td width="307" height="25" align="left" valign="top" style="padding-right:30px； font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; padding-top:0px; font-size:16px">Current house rental/lease 17</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top" style=" font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; padding-top:0px; font-size:16px">Available job positions 14</td>
        <td height="25" align="left" valign="top" style="padding-right:30px; font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; padding-top:0px; font-size:16px">Total items  for sale 35</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top" style=" font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; padding-top:0px; font-size:16px">Courses comments  12</td>
        <td height="25" align="left" valign="top" style="padding-right:30px; font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; padding-top:0px; font-size:16px">Uploaded file number 8</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top" style=" font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; font-size:16px">Friendship connections 13</td>
        <td height="25" align="left" valign="top" style=" font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; padding-top:0px; font-size:16px"></td>
      </tr>
      
    </table></td>
    </tr>
  
  <tr>
    <td height="121" colspan="2" align="right" valign="top" style=" padding-top:10px; font-size:16px; font-weight:bold; color:#000000; font-family:Arial, Helvetica, sans-serif"></td>
    <td colspan="2" valign="top" style="padding-left:0px"><table width="600" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="15" valign="top" style="padding-left:15px">&nbsp;</td>
        <td height="15" valign="top" style="padding-left:15px">&nbsp;</td>
        <td height="15" valign="top" style="padding-left:15px">&nbsp;</td>
        <td height="15" valign="top" style="padding-left:15px">&nbsp;</td>
      </tr>
      <tr>
        <td width="150" valign="top" style="padding-left:15px"><table width="152" height="150" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="152" style="padding:10px; background:#FFFFFF; border:1px #EEEEEE solid">
			  <img src="img/sri_cover.jpg" width="130" />
			  <div align="left" style="margin-top:10px; font-size:13px; font-weight:bold">I like this Network :)</div></td>
            </tr>
        </table></td>
        <td width="150" valign="top" style="padding-left:15px"><table width="130" height="150" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="170" height="150" style="padding:10px; background:#FFFFFF; border:1px #EEEEEE solid">
			  <img src="img/AndyCui_cover.jpg" width="130" />
			  <div align="left" style="margin-top:10px; font-size:13px; font-weight:bold">I boost this Network!</div>			  </td>
            </tr>
        </table></td>
        <td width="150" valign="top" style="padding-left:15px"><table width="130" height="150" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="170" height="150" style="padding:10px; background:#FFFFFF; border:1px #EEEEEE solid">
			  <img src="img/kahliah_cover.jpg" width="130" />
			  <div align="left" style="margin-top:10px; font-size:13px; font-weight:bold">Try you won't regret.</div>			  </td>
            </tr>
        </table></td>
        <td width="150" valign="top" style="padding-left:15px"><table width="152" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="152" height="150" style="padding:10px; background:#FFFFFF; border:1px #EEEEEE solid">
			  <img src="img/adel_cover.jpg" width="130" />
			  <div align="left" style="margin-top:10px; font-size:13px; font-weight:bold">Proud of NYU-Poly!</div></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td height="120" colspan="2" align="right" valign="top" style=" padding-top:35px; font-size:16px; font-weight:bold; color:#B92828; font-family:Arial, Helvetica, sans-serif">
	News & Updates
	</td>
    <td colspan="2" valign="top" style="padding-left:10px; padding-top:30px">
	  <div id="dailyupdate" style="padding-left:10px"></div>	</td>
  </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
</div>
</body>
</html>
