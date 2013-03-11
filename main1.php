<?php include("GreenHeaderFreeTour.php"); 

$q_user = mysql_query("SELECT * FROM rockinus.user_info;");
if(!$q_user) die(mysql_error());
$no_row_user = mysql_num_rows($q_user);

$q_house = mysql_query("SELECT * FROM rockinus.house_info WHERE rentlease='lease';");
if(!$q_house) die(mysql_error());
$no_row_house = mysql_num_rows($q_house);

$q_article = mysql_query("SELECT * FROM rockinus.article_info;");
if(!$q_article) die(mysql_error());
$no_row_article = mysql_num_rows($q_article);

$q_job = mysql_query("SELECT * FROM rockinus.job_info;");
if(!$q_job) die(mysql_error());
$no_row_job = mysql_num_rows($q_job);

$q_file = mysql_query("SELECT * FROM rockinus.user_file_info;");
if(!$q_file) die(mysql_error());
$no_row_file = mysql_num_rows($q_file);

$q_course_memo = mysql_query("SELECT * FROM rockinus.course_memo_info;");
if(!$q_course_memo) die(mysql_error());
$no_row_course_memo = mysql_num_rows($q_course_memo);

$q_friend = mysql_query("SELECT * FROM rockinus.rocker_rel_info;");
if(!$q_friend) die(mysql_error());
$no_row_friend = mysql_num_rows($q_friend);

$q_course = mysql_query("SELECT * FROM rockinus.unique_course_info;");
if(!$q_course) die(mysql_error());
$no_row_course = mysql_num_rows($q_course);

$q_major = mysql_query("SELECT * FROM rockinus.major_info;");
if(!$q_major) die(mysql_error());
$no_row_major = mysql_num_rows($q_major);
?>
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

<script>
$(document).ready(function() { 
    $('div .polyfont_cover_bg').mouseover(function(){ 
        $('div#polyfont_cover_bg img').fadeIn('slow'); 
    }); 
    $('img').mouseout(function(){ 
        $('div#polyfont_cover_bg img').fadeOut('slow'); 
    }); 
}); 
</script>

</head>
<body>
<div align="center">
<?php include("FreeHeader.php") ?>
<table width="1024" border="0" cellspacing="0" cellpadding="0" style="margin-top:30px">
  <tr>
    <td height="91" align="left" valign="top" style="padding-left:0px"><a href="main.php"><img src="img/rockinus_F5.jpg" /></a></td>
    <td height="91" align="right" valign="top" style="padding-top:10px; font-size:18px; font-weight:bold; padding-right:10px; color:#333333">	</td>
    <td width="667" colspan="2" rowspan="2" align="left" valign="top" style="font-size:16px; font-weight:normal; font-family:Arial, Helvetica, sans-serif; line-height:150%; padding:10px; padding-bottom:15px; padding-left:15px">Rockinus is an open, free, school-based social network for students who study, wish to study, or graduated in Polytechnic Institute of NYU. You can post house rentals, sales, course comments, upload course files, look for jobs, etc. Also, it is an exciting place to find new friends, exchange topics with other students as well. We hope you enjoy this network :)</td>
  </tr>
  <tr>
    <td height="35" colspan="2" align="left" style="padding-left:15px">
      <?php 
		  	if(isset($_SESSION['logoff_tag'])){
		  		echo $_SESSION['logoff_tag'];
				unset($_SESSION['logoff_tag']);
			}
		  ?>    </td>
  </tr>
  <tr>
    <td colspan="2" valign="top" style="padding-top:0px; padding-left:5px" align="left">
	<form action="login_process.php" method="post">
<table width="204" height="340" border="0" cellpadding="0" cellspacing="0" style="border-left:0px #CCCCCC solid; border-bottom:0px #CCCCCC solid; border-top:0px #CCCCCC solid">
      <tr>
        <td height="30" align="left" style="padding-left:15px; color:#333333"><strong>Username</strong></td>
      </tr>
      <tr>
        <td height="35" align="left" style="padding-left:15px;"><input type="text" style="height:21px;" name="usrname" size="25" onMouseOver="this.className='over'" onMouseOut="this.className='out'" class="box_login" value="<?php if(isset($_COOKIE["user"])) echo($_COOKIE["user"]); ?>" /></td>
      </tr>
      <tr>
        <td height="30" align="left" style="padding-left:15px; color:#33333"><strong>Password</strong></td>
      </tr>
      <tr>
        <td height="35" align="left" style="padding-left:15px"><input type="password" style="height:21px" name="passwd" onMouseOver="this.className='over'" onMouseOut="this.className='out'" class="box_login" size="25" />        </td>
      </tr>
      <tr>
        <td height="50" align="left" style="padding-left:15px; font-size:12px"><input type="checkbox" name="Login_Tag" />
          &nbsp;&nbsp;Remember Me </td>
      </tr>
      <tr>
        <td height="50" align="left" style="padding-left:15px"><input type="submit" name="Submit" value=" Sign In " class="btnlogin" />        </td>
      </tr>
      <tr>
        <td height="50" align="left" style="padding-left:15px; font-size:12px"><img src="img/PenIcon.jpg" /> &nbsp;<a href="findPassword.php" class="one">Forget Password?</a></td>
      </tr>
      <tr>
        <td height="30" style="padding-left:0px; padding-top:10px" align="left"><hr width="170px" color="#F5F5F5" style="border:solid 0px" /></td>
      </tr>
      <tr>
        <td height="20" style="padding:15px; padding-bottom:20px; line-height:150%" align="left">
          <div> <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 30px; display:inline; margin-bottom:0px; background-color: #666666; border-bottom:1 solid #333333; border-top:1 solid #333333"><a href="joinUs.php"><strong>Sign Up</strong></a></span> &nbsp; <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 30px; display:inline; margin-bottom:5px; background: #666666; border-bottom:1 solid #000000; border-top:1 solid #000000"><a href="commentUs.php"><strong>Comment</strong></a></span></div></td>
      </tr>
    </table>
	</form>	</td>
    <td height="74" colspan="2" align="left" valign="top" style="padding-left:15px; padding-top:10px">
	<table border="0" cellpadding="0" cellspacing="0" style="border:1px #DDDDDD solid; background-color:#FFFFFF"><tr><td style="padding:20px">
	<div id='polyfont_cover_bg' class='polyfont_cover_bg' style="width:620px; height:373px; background-image:url(img/polyfont_cover_bg.jpg)">
	<img src="img/polyfont_cover_color_bg.jpg" width="620" height="370" id='polyfont_cover_bg' class='polyfont_cover_bg' style="display:none" />
	</div>
	</td></tr></table>	</td>
  </tr>
  
  <tr>
    <td width="205" height="50" align="left" valign="top" style="padding-left:0px; font-size:16px; color:#000000;"><div style="border:1px #999999 dashed; line-height:150%; background-color:#F5F5F5; font-size:14px; width:165; margin-left:15; padding:10px; padding-left:15px; margin-bottom:20" align="top"> Rockinus currently only supports registration with <font color="#B92828">.edu</font> email, thanks for your understanding.</div></td>
    <td width="152" align="right" valign="top" style=" padding-top:45px; padding-right:10px; font-size:16px; font-weight:bold; color: #333333; font-family:Arial, Helvetica, sans-serif">&nbsp;<img src="img/grayStar_FFCC33.jpg" width="20" height="20" /></td>
    <td colspan="2" align="left" valign="top" style=" font-family:Arial, Helvetica, sans-serif; padding-left:10px; line-height:150%; padding-top:45px; font-size:16px"><table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="219" height="25" align="left" valign="top" style=" font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; padding-top:0px; font-size:16px">Registered students <?php echo $no_row_user ?></td>
        <td width="236" height="25" align="left" valign="top" style="padding-right:30px£» font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; padding-top:0px; font-size:16px">Avail. houses for rental <?php echo $no_row_house ?></td>
        <td width="195" align="left" valign="top" style="padding-right:30px£» font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; padding-top:0px; font-size:16px">Courses comments <?php echo $no_row_course_memo ?></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top" style=" font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; padding-top:0px; font-size:16px">Available job positions <?php echo $no_row_job ?></td>
        <td height="25" align="left" valign="top" style="padding-right:30px; font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; padding-top:0px; font-size:16px">Total items  for sale <?php echo $no_row_article ?></td>
        <td height="25" align="left" valign="top" style="padding-right:30px; font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; padding-top:0px; font-size:16px">Uploaded files <?php echo $no_row_file ?></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top" style=" font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; font-size:16px">Friendship connections <?php echo $no_row_friend ?></td>
        <td height="25" align="left" valign="top" style=" font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; padding-top:0px; font-size:16px">Total course number <?php echo $no_row_course ?></td>
        <td height="25" align="left" valign="top" style=" font-family:Arial, Helvetica, sans-serif; padding-right:15px; padding-bottom:0px; line-height:150%; padding-left:15px; padding-top:0px; font-size:16px">Total departments <?php echo $no_row_major ?></td>
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
			  <div align="left" style="margin-top:10px; font-size:13px; font-weight:bold; color:#336633; line-height:150%">Simply like this Network, coz helpful</div></td>
            </tr>
        </table></td>
        <td width="150" valign="top" style="padding-left:15px"><table width="130" height="150" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="170" height="150" style="padding:10px; background:#FFFFFF; border:1px #EEEEEE solid">
			  <img src="img/AndyCui_cover.jpg" width="130" />
			  <div align="left" style="margin-top:10px; font-size:13px; line-height:150%; font-weight:bold; color:#336633">I boost this Network, join us, my friends</div>			  </td>
            </tr>
        </table></td>
        <td width="150" valign="top" style="padding-left:15px"><table width="130" height="150" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="170" height="150" style="padding:10px; background:#FFFFFF; border:1px #EEEEEE solid">
			  <img src="img/kahliah_cover.jpg" width="130" />
			  <div align="left" style="margin-top:10px; font-size:13px; font-weight:bold; color:#336633; line-height:150%">I suppose you will like it as time runs</div>
			  </td>
            </tr>
        </table></td>
        <td width="150" valign="top" style="padding-left:15px"><table width="152" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="152" height="150" style="padding:10px; background:#FFFFFF; border:1px #EEEEEE solid">
			  <img src="img/adel_cover.jpg" width="130" />
			  <div align="left" style="margin-top:10px; font-size:13px; font-weight:bold; color:#336633; line-height:150%">Proud of being a Polyer, as always </div></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td height="120" colspan="2" align="right" valign="top" style=" padding-top:45px; padding-right:10px; font-size:16px; font-weight:bold; color:#B92828; font-family:Arial, Helvetica, sans-serif">
	News & Updates	</td>
    <td colspan="2" valign="top" style="padding-left:10px; padding-top:35px">
	  <div id="dailyupdate" style="padding-left:5px"></div>	</td>
  </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
</div>
</body>
</html>
