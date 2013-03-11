<?php
header("Content-Type: text/html; charset=gb2312");
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];

if(isset($_POST['openComment'])){
	$tag = 0;
	$nickname = $uname;
	$descrip = addslashes($_POST['descrip']);
	
	if( ( $descrip==NULL || strlen($descrip)==0 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "No content for the post?";
	}
	
	if($tag==0){	
		include 'dbconnect.php'; 
		$sql = "INSERT INTO rockinus.open_comment_info (sender,descrip,pdate,ptime)VALUES('$nickname','$descrip',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$rst_msg = "<img src='img/addsuccessIcon_F5.jpg' width=15>&nbsp;&nbsp;Thanks, we have received your reports, and will surely improve the service.";
		//mysql_close($link);
		$_SESSION['rst_msg']="<div align='left' style='width:720; border:0px solid #EEEEEE; padding:10; margin-bottom:15; background:#F5F5F5; margin-top:10'><font size=3 color=$_SESSION[hcolor]>$rst_msg</font></div>"; 
	}else
	$_SESSION['rst_msg']="<div align='left' style='width:720; border:0 solid #DDDDDD; padding-top:5; padding-bottom:5; margin-bottom:10; background:#F5F5F5; margin-top:10'><strong><font size=3 color=#B92828>&nbsp;<img src=img/stop.jpg width=18 height=18 />&nbsp;&nbsp;&nbsp;$rst_msg</font></strong></font></div>"; 
}
?> 
<div align="center" style="width:100%; margin-top:0">
<table width="1024" height="450" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="300" valign="top" align="left" style="border-right:1px dashed #DDDDDD">
	<?php include("leftHomeMenu.php"); ?>
	</td>
    <td width="760" align="right" valign="top" style="padding-top:0">
	<?php include("HeaderEN.php") ?>
	<div style="border:0px #DDDDDD solid; background-color:">
      <table width="680" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:25px">
        <tr>
          <td width="720" height="86" colspan="0" align="left" valign="top">
              <table width="720" height="70" border="0" cellpadding="0" cellspacing="0" style="border-top:1px solid #CCCCCC; margin-bottom:10" background="img/GrayGradbgDown.jpg">
                <tr>
                  <td align="left" style="background-color:; padding-left:15px; padding-right:10px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:18px" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;">
				  Work for Rockinus.com is An Exciting Thing
				  </td>
                  </tr>
              </table>
              <table width="720" height="41" border="0" cellpadding="0" cellspacing="0" style="border-top:0px dashed #CCCCCC">
                <tr>
                  <td height="41" align="left" style="background-color:; font-weight:bold; padding-left:15px; padding-right:10px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.background = ;"> 
				  We currently have 3 volunteer positions				   </td>
                </tr>
              </table>
              <table width="720" height="36" border="0" cellpadding="0" cellspacing="0" style="border-top:0px dashed #CCCCCC">
                <tr>
                  <td width="30" height="36" align="left" style="background-color:; padding-left:15px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.background = ;">
				  <img src="img/rightTriangleIcon.jpg" width="12" height="12" />				  </td>
                  <td width="694" align="left" style="background-color:; color:<?php echo($_SESSION['hcolor']) ?>; padding-left:0px; padding-right:10px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.background = ;">PHP Developer </td>
                </tr>
              </table>
              <table width="720" height="36" border="0" cellpadding="0" cellspacing="0" style="border-top:0px dashed #CCCCCC; margin-bottom:30;">
                <tr>
                  <td width="30" height="36" align="left" style="background-color:; padding-left:15px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.background = ;">&nbsp;</td>
                  <td width="694" align="left" style="background-color:; line-height:150%; padding-left:0px; padding-right:10px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.background = ;">
				  
				  Interested, experienced in PHP programming (Nice to show demos if you have)<br />
				  Understand Web front design, like HTML/CSS, Jquery, Ajax, XML, Json, e.g.<br />
				  Experiences in MySql, consistent passion and competitive knowledge is required<br />
				  Quality coding skills, can handle and resolve complex issues<br />
				  Independent, efficient working capability <br />
				  Outgoing, smooth communicative with other teammates <br />
				  <br />Responsibility:<br />
				  Fixing current PHP coding problems, implementing solutions<br />
				  Coding for new functionalities according to user requirement<br />
				  Debugging and testing existing issues<br />
				  Exploring for new ideas<br />
				   </td>
                </tr>
              </table>
              <table width="720" height="40" border="0" cellpadding="0" cellspacing="0" style="border-top:1px dashed #CCCCCC">
                <tr>
                  <td width="30" height="36" align="left" style="background-color:; padding-left:15px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.background = ;"><img src="img/rightTriangleIcon.jpg" width="12" height="12" /> </td>
                  <td width="694" align="left" style="background-color:; padding-left:0px; color:<?php echo($_SESSION['hcolor']) ?>; padding-right:10px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.background = ;">MySql DBA  </td>
                </tr>
              </table>
              <table width="720" height="36" border="0" cellpadding="0" cellspacing="0" style="border-top:0px dashed #CCCCCC; margin-bottom:30;">
                <tr>
                  <td width="30" height="36" align="left" style="background-color:; padding-left:15px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.background = ;">&nbsp;</td>
                  <td width="694" align="left" style="background-color:; line-height:150%; padding-left:0px; padding-right:10px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.background = ;">
				    Familiar with and interested in MySql programming<br />
                    Understand Front-End design of PHP/MySql working process<br />
                    Independent, efficient working capability <br />
                    Quality coding skills, can handle and resolve complex DB cases<br />
                    Consistent passion and competitive knowledge <br />
                    Outgoing, smooth communicative with other teammates <br />
					<br />
					Responsibility:<br />
                    Design, develop new DB models according to user requirement<br />
                    Develop code for performing routine DB backup work<br />
					Debugging, testing existing DB issues. Improve DB performance <br />
                    Exploring for new ideas, new structures<br />
                  </td>
                </tr>
              </table>
              <table width="720" height="40" border="0" cellpadding="0" cellspacing="0" style="border-top:1px dashed #CCCCCC">
                <tr>
                  <td width="30" height="36" align="left" style="background-color:; padding-left:15px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.background = ;"><img src="img/rightTriangleIcon.jpg" width="12" height="12" /> </td>
                  <td width="694" align="left" style="background-color:; padding-left:0px; color:<?php echo($_SESSION['hcolor']) ?>; padding-right:10px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.background = ;">QA / Data Analyst </td>
                </tr>
              </table>
              <table width="720" height="36" border="0" cellpadding="0" cellspacing="0" style="border-top:0px dashed #CCCCCC; margin-bottom:20;">
                <tr>
                  <td width="30" height="36" align="left" style="background-color:; padding-left:15px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.background = ;">&nbsp;</td>
                  <td width="694" align="left" style="background-color:; line-height:150%; padding-left:0px; padding-right:10px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.background = ;">
				    Highly responsible, reliable, self-motivated <br />
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
              <table width="720" height="36" border="0" cellpadding="0" cellspacing="0" style="border-top:0px dashed #CCCCCC; margin-bottom:20;">
                <tr>
                  <td width="30" height="36" align="left" valign="top" style="background-color: #EEEEEE; padding:15px; padding-right:0;  font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px"><img src="img/rightTriangleIcon.jpg" width="12" height="12" /> </td>
                  <td width="694" align="left" style="background-color:#EEEEEE; line-height:150%;  padding:10px; padding-left:0px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px">
                    <strong>Please send resume to:</strong> <u>superbarmuya@gmail.com</u> or <u>barmuya@hotmail.com</u><br />
					Interview will be required by Rockinus founder<br />
                    Look forward you work at your free time, not affecting your study <br />
                    We ensure that you will gain solid skills and experience with Rockinus.com<br /></td>
                </tr>
              </table></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>

  </div>
  
  <div class="loginDiv" id="loginDiv"></div>
<br>
<br>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</div>
</body>
</html>
