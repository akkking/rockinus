<?php 
include 'ValidCheck.php';

if(isset($_POST['bookSubmit'])){
	$tag = 0;
	$book_name = $_POST['book_name'];
	$textbook = $_POST['textbook'];
	$buysale = $_POST['buysale'];
	$mid = $_POST['mid'];
	$course_id = $_POST['course_id'];
	$rate = trim($_POST['rate']);
	$descrip = addslashes($_POST['descrip']);
	$_SESSION['descrip'] = addslashes($_POST['descrip']);
	
	if( ( strlen(trim($rate))>0 && !is_numeric($rate) ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "Please enter a legal rate number.";
	}
	
	if( ( $book_name==NULL || strlen($book_name)<10 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "Book name is too short, has to be more than 10 characters.";
	}
	
	if( ( $descrip==NULL || strlen($descrip)<20 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "Description is too short, has to be more than 20 characters.";
	}
	
	if($tag==0){	
		include 'dbconnect.php'; 
		$sql = "INSERT INTO rockinus.book_info(book_name,textbook,buysale,mid,course_id,uname,rate,descrip, rstatus,pdate,ptime)VALUES('$book_name','$textbook','$buysale','$mid','$course_id','$uname','$rate','$descrip','N',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$rst_msg = "Your post has been submitted successfully!";
		mysql_close($link);
		$_SESSION['rst_msg']="<div align='center' style='width=720; background:#F5F5F5; border:0 #DDDDDD solid; padding-top:10; padding-bottom:10; margin-top:0; margin-bottom:0'><strong><font size=3><img src=img/addsuccessIcon_F5.jpg width=15>&nbsp;&nbsp;&nbsp; $rst_msg</font></strong><br><br><font size=3><a href=bookList.php class=one>Go Back</a></font></div>"; 
		header("location:jobResult.php");
	}else
	$_SESSION['err_rst_msg']="<table width=740><tr><td align='right'><div align='left' style='width=740; background:#F5F5F5; border:0 #DDDDDD solid; padding-top:10; padding-bottom:10; margin-top:0; margin-bottom:0'><strong><font size=3 color=#B92828>&nbsp;&nbsp;<img src=img/stop.jpg width=15>&nbsp;&nbsp;&nbsp;$rst_msg</font></strong></div></td></tr></table>"; 
}

if(isset($_GET["recipient"])) $recipient = $_GET["recipient"];
else $recipient = "";

include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];

$z = mysql_query("SELECT * FROM rockinus.user_edu_info WHERE uname='$uname'");
if(!$z) die(mysql_error());
$objz = mysql_fetch_object($z);
$cmajor = $objz->cmajor;	

if($cmajor!=NULL && strlen($cmajor)>0){
	$m = mysql_query("SELECT major_name FROM rockinus.major_info");
	if(!$m) die(mysql_error());
	$objm = mysql_fetch_object($m);
	$major_name = $objm->major_name;		
}
?><style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
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
<div style="width:100%" align="center">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="300" align="left" valign="top" style="border-right:1 #DDDDDD dashed">
	  <?php include("leftHomeMenu.php"); ?>
	  </td>
      <td width="760" align="right" valign="top">
	  <?php include("HeaderEN.php"); ?>
	  <?php
	  	if(isset($_SESSION['err_rst_msg'])){
			echo($_SESSION['err_rst_msg']);
			unset($_SESSION['err_rst_msg']);
		}
	  ?>
	  <table border="0" cellspacing="0" cellpadding="0" width="760">
        <tr>
          <td align="right" valign="top" width="760">
		  <table width="740" height="35" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="margin-bottom:10; margin-top:10; border:4px #CCCCCC solid">
            <tr>
              <td width="20" style="color:#000000; padding-right:10; padding-left:5; padding-top:10; line-height:150%; font-size:14px" valign='top' align='left'><img src="img/PenIcon.jpg" width="14" height="14" /></td>
              <td width="690" style="color:#000000; padding:5; padding-left:0; line-height:150%; border-bottom:1 dashed #EEEEEE; font-size:14px" valign='top'><strong>[Notice]</strong> Please compose in English, so others can understand. It's OK to post in a different language, however make sure to leave a brief translation for others convenience. Remember, we are cool Poly students</td>
            </tr>
          </table>
		  <table width="740" height="94" border="0" cellpadding="0" cellspacing="0" style="border:0 #DDDDDD solid">
            <tr>
              <td width="298" height="60" align="left" background="img/GrayGradbgDown.jpg" style="padding-left:15; border-top:1px dashed #CCCCCC; font-size:16px; font-weight:bold">&nbsp;</td>
              <td width="442" align="right" background="img/GrayGradbgDown.jpg" style="padding-right:15px; font-size:16px; font-weight:bold; border-top:1px dashed #CCCCCC">
			  <a href="bookList.php" class="one" style=" color:<?php echo($_SESSION['hcolor']) ?>">Check all book information</a>			  </td>
            </tr>
            <tr>
              <td height="30" colspan="2" align="center">
			  <form action="postBook.php" method="post">
                <table width="740" height="402" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
                  <tr>
                    <td height="40" style="padding-right:10px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif" align="right">
					What you want?					</td>
                    <td height="40" colspan="2" align="left" style="padding-left:10px">
					<select name="buysale" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
                        <option value="sell" selected="selected">Sell or Lend</option>
                      	<option value="buy">Buy or Borrow</option>
                    </select>
					</td>
					</tr>
					<tr>
				    <td width="222" height="40" align="right" style="padding-right:10px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
					Book Name					</td>
				    <td height="40" colspan="2" style="padding-left:10px">
					<input name="book_name" size="55" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">					</td>
				    </tr>
                    <tr>
				    <td height="40" style="padding-right:10px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif" align="right">
					Is it a textbook?					</td>
				    <td width="298" height="40" style="padding-left:10px">
					<select name="textbook" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
                        <option value="Y" selected="selected">Yes</option>
						<option value="N">No</option>
						</select>					</td>
				    <td width="220" style="padding-left:10px; font-size:14px">&nbsp;</td>
				    </tr>
				  <tr>
				    <td height="40" style="padding-right:10px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif" align="right">
					Which subject					</td>
				    <td height="40" colspan="2" style="padding-left:10px">
					<select name="mid" onChange="getCourse('findCourse.php?mid='+this.value)" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
					<option value="all" selected="selected">All subjects</option>
					<?php 
						$m = mysql_query("SELECT mid, major_name FROM rockinus.major_info ORDER BY major_name ASC");
						if(!$m) die(mysql_error());
						while($objm = mysql_fetch_object($m)){
							$mid = $objm->mid;
							$major_name = $objm->major_name;
						?>
            	            <option value="<?php echo($mid) ?>"><?php echo($major_name) ?></option>
						<? 
						}
						?>
						</select>						</td>
				    </tr>
					<tr>
				    <td height="40" style="padding-right:10px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif" align="right">
					Course					</td>
				    <td height="40" colspan="2" style="padding-left:10px">
					<div id="courseDiv" class="courseDiv">
					<select name="course_id" style="padding-right:10px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
                    	<option value="all" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">Any course</option>
						</select>					
						</div>						</td>
				    </tr>
                  <tr>
                    <td height="40" style="padding-right:10px; font-size:14px; font-weight:" align="right">Expected Rate </strong></td>
                    <td height="40" colspan="2" style="padding-left:10px">
                        $ <input type="text" name="rate" size="5" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif" />
						&nbsp;<font color="#999999">(Leave blank to skip pricing)</font>						</td>
                  </tr>
                  <tr>
                    <td height="170" style="padding-right:10px; padding-top:10; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif" valign="top" align="right">
					Brief description<br />
					<br />
					<font style="font-size:12px; color:#666666">(More than 20 characters)</font>					</td>
                    <td colspan="2" valign="top" style="padding-left:10px; padding-top:10px">
                      <textarea name="descrip" rows="10" style="width:420; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><?php if(isset($_SESSION['descrip'])){echo($_SESSION['descrip']);unset($_SESSION['descrip']);}?></textarea>					  </td>
                  </tr>
                  <tr>
                    <td height="80" style="padding-right:10px" align="right">&nbsp;</td>
                    <td height="80" colspan="2" valign="top" style="padding-left:10px; padding-top:10px;">
					<input name="bookSubmit" type="submit" class="profile_btn" value=" Submit " />					</td>
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
