<?php 
include 'ValidCheck.php';

if(isset($_POST['systemNoticeSubmit'])){
	$tag = 0;
	$title = $_POST['title'];
	$rstatus = $_POST['rstatus'];
	$category = $_POST['category'];
	$descrip = addslashes($_POST['descrip']);
	$_SESSION['descrip'] = addslashes($_POST['descrip']);
	
	if( strlen(trim($category))==0 && $tag ==0 ){
		$tag = 1;
		$rst_msg = "Please select category.";
	}
	
	if( ( $title==NULL || strlen($title)<10 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "Subject | Title is too short, has to be > 10 characters.";
	}
	
	if( ( $descrip==NULL || strlen($descrip)<20 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "Description is too short, has to be > 20 characters.";
	}
	
	if($tag==0){	
		include 'dbconnect.php'; 
		$sql = "INSERT INTO rockinus.system_notice(creater,category,title,descrip,rstatus,pdate,ptime)VALUES('$uname','$category','$title','$descrip','$rstatus', CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$rst_msg = "Your post has been submitted successfully!";
		mysql_close($link);
		$_SESSION['rst_msg']="<div align='left' style='-moz-border-radius: 5px; border-radius: 5px; width:600px; font-size:18px; color:#000000; padding:15 25 15 25; margin-bottom:5px; border:1px solid #DDDDDD; background: #F5F5F5'><img src=img/addsuccessIcon.jpg width=15>&nbsp;&nbsp;&nbsp; $rst_msg</div>"; 
		//header("location:jobResult.php");
	}else
	$_SESSION['err_rst_msg']="<div align='left' style='-moz-border-radius: 5px; border-radius: 5px; width:600px; font-size:18px; color:#B92828; padding:15 25 15 25; margin-bottom:5px; border:1px solid #DDDDDD; background: #F5F5F5'><img src=img/stop.jpg width=15>&nbsp;&nbsp;&nbsp;$rst_msg</font></strong></div>"; 
}
?><style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/ajax.jquery.min.js"></script>
<script>
function getXMLHTTP() { //fuction to return the xml http object
	var xmlhttp=false;	
	try{
		xmlhttp=new XMLHttpRequest();
	}
	catch(e)	{		
		try{			
			xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e1){
				xmlhttp=false;
			}
		}
	}
		 	
	return xmlhttp;
}
	
function getCourse(strURL)
{         
 var req = getXMLHTTP(); // fuction to get xmlhttp object 
 if (req)
 {
  	req.onreadystatechange = function()
 	{
  		if (req.readyState == 4) { //data is retrieved from server
   			if (req.status == 200) { // which reprents ok status                    
     			document.getElementById('courseDiv').innerHTML=req.responseText;
  			}
  			else
  			{ 
     			alert("There was a problem while using XMLHTTP:\n");
  			}
  		}            
  	}        
	req.open("GET", strURL, true); //open url using get method
	req.send(null);
 	}
}
</script>
<div style="width:100%; padding-top:15px" align="center">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="241" align="left" valign="top" style="line-height:125%">
	  <a href="systemNoticeList.php">
		<img src="img/rockinus_home_admin.jpg" />	</a>	
		
		<a href="postSystemNotice.php" class="two">
	  <div style="margin-top:50px; -moz-border-radius: 2px; border-radius: 2px; width:180px; height:25px; padding:10 0 5 0; background: url(img/GrayGradbgDown.jpg); border:1px solid #DDDDDD; font-size:14px; color:<?php echo($_SESSION['hcolor']) ?>; cursor:pointer" align="center" onmouseover="this.style.border='1px #CCCCCC solid'" onmouseout="this.style.border='1px #DDDDDD solid'">
	  + Compose New
	  </div></a>
	  
	  <a href="systemNoticeList.php" class="two">
	  <div style="margin-top:15px; -moz-border-radius: 2px; border-radius: 2px; width:180px; height:25px; padding:10 0 5 0; background: url(img/GrayGradbgDown.jpg); border:1px solid #DDDDDD; font-size:14px; color:<?php echo($_SESSION['hcolor']) ?>; cursor:pointer" align="center" onmouseover="this.style.border='1px #CCCCCC solid'" onmouseout="this.style.border='1px #DDDDDD solid'">
	  Notice History
	  </div></a>
		</td>
      <td width="783" align="center" valign="top">
	  <?php
	  	if(isset($_SESSION['rst_msg'])){
			echo($_SESSION['rst_msg']);
			unset($_SESSION['rst_msg']);
		}
		
		if(isset($_SESSION['err_rst_msg'])){
			echo($_SESSION['err_rst_msg']);
			unset($_SESSION['err_rst_msg']);
		}
	  ?>
	  <table border="0" cellspacing="0" cellpadding="0" width="740">
        <tr>
          <td align="left" valign="top" width="740"><table width="740" height="94" border="0" cellpadding="0" cellspacing="0" style="margin-top:25px">
            <tr>
              <td height="35" align="left" style="padding-left:75; color: <?php echo($_SESSION['hcolor']) ?>; font-size:24px; font-weight:bold">Composing	System	Notice	  </td>
              </tr>
            <tr>
              <td height="30" align="center">
			  <form method="post">
                <table width="740" height="370" border="0" cellpadding="0" cellspacing="0" style=" margin-bottom:100px; margin-top:30px">
                  <tr>
                    <td height="40" style="padding-right:10px;  " align="right">
					Category					</td>
                    <td height="40" colspan="2" align="left" style="padding-left:10px">
					<select name="category">
					<option value="New Features" selected="selected">New Features</option>
					<option value="System Upgrade">System Upgrade</option>
					<option value="Job Openning">Job Openning</option>
					</select>					</td>
					</tr>
					<tr>
				    <td width="222" height="40" align="right" style="padding-right:10px;  ">Title | Subject</td>
				    <td height="40" colspan="2" style="padding-left:10px">
					<input name="title" size="70" style=" ">					</td>
				    </tr>
                    <tr>
				    <td height="40" style="padding-right:10px;  " align="right">
					Visible?					</td>
				    <td width="298" height="40" style="padding-left:10px">
					<select name="rstatus">
                        <option value="Y" selected="selected">Yes</option>
						<option value="N">No</option>
						</select>					</td>
				    <td width="220" style="padding-left:10px; font-size:14px">&nbsp;</td>
				    </tr>
                  <tr>
                    <td height="170" style="padding-right:10px; padding-top:10;  " valign="top" align="right">
					Description | Details <br />
					<br />
					<font style="font-size:12px; color:#666666">(More than 20 characters)</font>					</td>
                    <td colspan="2" valign="top" style="padding-left:10px; padding-top:10px">
                      <textarea name="descrip" rows="12" style="width:450; font-size:14px"><?php if(isset($_SESSION['descrip'])){echo($_SESSION['descrip']);unset($_SESSION['descrip']);}?></textarea>					  </td>
                  </tr>
                  <tr>
                    <td height="80" style="padding-right:10px" align="right">&nbsp;</td>
                    <td height="80" colspan="2" valign="top" style="padding-left:10px; padding-top:10px;">
					<input name="systemNoticeSubmit" type="submit" class="profile_btn" value=" Submit " />					</td>
                  </tr>
                </table>
              </form>		    </td>
              </tr>
          </table>
		  </td>
        </tr>
      </table>
	  </td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
