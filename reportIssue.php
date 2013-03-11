<?php
include 'dbconnect.php';
include("Allfuc.php");
session_start();
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
include 'mainHeader.php';
?> 
<div align="center" style="width:100%; margin-top:0">
<table width="1024" height="450" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top">
	<?php 
	  if(isset($_SESSION['rst_msg'])){
		  echo $_SESSION['rst_msg'];
		  unset($_SESSION['rst_msg']); 
	}
	  ?>
	<div style="border:0px #DDDDDD solid; background-color:#FFFFFF" align="center">
	  <table width="680" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:25px">
	    <tr>
	      <td width="720" height="86" colspan="0" align="left" style="padding-top:50px">
	        <table width="720" height="50" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-bottom:1px solid #DDDDDD; margin-bottom:10px">
	          <tr>
	            <td align="left" style="background-color:; padding-left:15px; padding-right:10px; font-family: Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold" onMouseOver="this.style.backgroundColor = '';" onMouseOut="this.style.background = ;">
	              Issue Report to Rockinus.com				  </td>
                  </tr>
	          </table>
                <form action="reportIssue.php" method="post">
                  <table width="720" height="282" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="75" height="80" align="right" style="padding-right:10px; font-size:16px; font-family:Arial, Helvetica, sans-serif"><img src="img/letter_no_bg.jpg" width="30" height="28"></td>
                      <td width="645" height="80" style="padding-left:10px; font-size:14px; line-height:150%; font-family:Arial, Helvetica, sans-serif">
                      <?php echo("Hey ".$uname.", please write your findings, suggestions or anything you have.<br> We will handle it as soon as possible!"); ?>					  </td>
                    </tr>
                    <tr>
                      <td height="170" style="padding-right:10px; padding-top:10px" align="right" valign="top"><strong> </strong></td>
                      <td style="padding-left:10px; padding-top:10px" valign="top">
                        <textarea name="descrip" style="width:500; font-size:14px; font-family:Arial, Helvetica, sans-serif" rows="15"></textarea>                      </td>
                    </tr>
                    <tr>
                      <td height="50" style="padding-right:10px" align="right">&nbsp;</td>
                      <td style="padding-left:10px; padding-top:15; padding-bottom:50" valign="top">
                        <input name="openComment" type="submit" class="profile_btn" value=" Submit " />                      </td>
                    </tr>
                  </table>
              </form></td>
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
