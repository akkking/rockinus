<?php 
include("GreenHeaderFreeTour.php"); 
if(isset($_POST['sendmsgform'])){
	include 'dbconnect.php'; 
	$tag = 0;
	$subject = addslashes($_POST['subject']);
	$sender = $_POST['sender']; 
	$recipient = $_POST['recipient'];
	$description = addslashes($_POST['description']);
	
	if($sender==NULL || strlen(trim($sender))==0){
		$sender = "Anonymous";
	}
	
	if($recipient==NULL || strlen($recipient)==0){
		$tag = 1;
		$rst_msg = "Who you want to send the message?";
	}
	
	if( ( $subject==NULL || strlen(trim($subject))==0 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "What is your Message Subject?";
	}
	 
	if( ( $description==NULL || strlen(trim($description))==0 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "No content for the Message, please check";
	}
	   
	$t = mysql_query("SELECT count(*) as cnt FROM rockinus.user_info WHERE uname='$recipient'");
	$a = mysql_fetch_object($t);
	$total_items = $a->cnt;
	
	if($total_items!=1 && $tag==0 ){
		$tag = 1;
		$rst_msg = "The Student you want to send does not exist";
	}
	
	if($tag==0){	
		$sql = "INSERT INTO rockinus.message_info (subject,recipient,descrip,iostatus,rstatus,sender,pdate,ptime)VALUES('$subject','$recipient','$description','O','N','$sender',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$rst_msg = "Your Message has been sent to $recipient Successfully!";
		mysql_close($link);
		$_SESSION['recipient'] = $recipient;
		$_SESSION['rst_msg']="<div align='center' style='width=750; padding-top:20; padding-bottom:20; margin-top:10; border:1px #DDDDDD solid; background:#F5F5F5; margin-top:15'><strong><FONT size=4><img src=img/addsuccessIcon.jpg>&nbsp;&nbsp; $rst_msg :)</font></strong><br><br><br><font size=3><a href=main.php class=one>Go Back</a></font></div>"; 
		//header("location:FreeTourMessageResult.php");
	}else
		$_SESSION['rst_msg']="<div align='center' style='width=750; padding-top:20; padding-bottom:20; margin-top:10; border:1px #DDDDDD solid; background:#F5F5F5; margin-top:15'><strong><FONT size=4 color=#B92828><img src=img/stop.jpg width=18 height=18 />&nbsp;&nbsp;&nbsp;$rst_msg</font></strong><br><br><br><font size=3><a href=FreeTourSendMsg.php?recipient=$recipient class=one>Go Back</a></font></div>"; 
}

if(!isset($_GET['recipient']) && !isset($_SESSION['rst_msg'])){
	header("location:main.php");
}

if(isset($_GET['recipient']))
	$recipient = $_GET['recipient'];
	
if(isset($_SESSION['recipient'])){
	$recipient = $_SESSION['recipient'];
	unset($_SESSION['recipient']);
}
?>
<style>
#HouseDiv {
	margin: 0px;
    color: #fff;
    width: 800px;
	height: 30px;
    padding: 0px;
    text-align: left;
	margin-bottom:0px;
	background-color:<?php echo($_SESSION['hcolor']) ?>;
    border: 1px solid #DDDDDD;
}
body,td,th {
	font-size: 14px;
}
</style>
<script type="text/JavaScript">
  curvyCorners.addEvent(window, 'load', initCorners);
  function initCorners() {
    var settings = {
      tl: { radius: 10 },
      tr: { radius: 10 },
      bl: { radius: 0 },
      br: { radius: 0 },
      antiAlias: true
    }
    curvyCorners(settings, "#HouseDiv");
}
</script>
<?php include("FreeHeader.php") ?>
<table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="margin-top:10px">
    <tr>
      <td width="1024" align="left" valign="top" style=" border-right:#DDDDDD solid 0;border-left:#DDDDDD solid 0;">
	  <form action="login_process.php" method="post">
	    <table width="204" height="340" border="0" cellpadding="0" cellspacing="0" style="border-left:0px #CCCCCC solid; border-bottom:0px #CCCCCC solid; border-top:0px #CCCCCC solid">
          <tr>
            <td width="204" height="10" align="left" style="padding-left:0px; padding-top:0px; padding-bottom:0px"><a href="main.php"><img src="img/rockinus.jpg" /></a></td>
          </tr>
          <tr>
            <td height="40" align="left" style="padding-left:0px; padding-top:0px; padding-bottom:5px"><?php 
		  	if(isset($_SESSION['logoff_tag'])){
		  		echo $_SESSION['logoff_tag'];
				unset($_SESSION['logoff_tag']);
			}
		  ?>
            </td>
          </tr>
          <tr>
            <td height="24" align="left" style="padding-left:15px"><strong><font size="3" color="#336633">Username</font></strong></td>
          </tr>
          <tr>
            <td height="35" align="left" style="padding-left:15px"><input type="text" style="height:22px" name="usrname" size="23" onmouseover="this.className='over'" onmouseout="this.className='out'" class="box" value="<?php if(isset($_COOKIE["user"])) echo($_COOKIE["user"]); ?>" /></td>
          </tr>
          <tr>
            <td height="25" align="left" style="padding-left:15px"><strong><font size="3" color="#336633">Password</font></strong></td>
          </tr>
          <tr>
            <td height="35" align="left" style="padding-left:15px"><input type="password" style="height:22px" name="passwd" onmouseover="this.className='over'" onmouseout="this.className='out'" class="box" size="23" />
            </td>
          </tr>
          <tr>
            <td height="40" align="left" style="padding-left:15px"><input type="checkbox" name="Login_Tag" />
              Remember Me </td>
          </tr>
          <tr>
            <td height="40" align="left" style="padding-left:15px"><input type="submit" name="Submit" value="Sign In" class="btn2" />
            </td>
          </tr>
          <tr>
            <td height="45" align="left" style="padding-left:15px"><img src="img/PenIcon.jpg" /> &nbsp;<a href="findPassword.php" class="one"><font size="2">Forget Password?</font></a></td>
          </tr>
          <tr>
            <td height="15" style="padding-left:15px; padding-top:10px" align="left"><hr width="170px" color="#000000" style="border:solid 1px" /></td>
          </tr>
          <tr>
            <td height="20" style="padding:15px; padding-bottom:20px; line-height:150%" align="left"><div style="margin-bottom:15px; padding-top:0px; margin-top:5px; "><strong><font size="3" color="#336633">NOT A MEMBER? </font></strong></div>
                <font style="font-size:11px"> Rockinus is an open, free, school-based social network for  students who study or wish to study in <span style="background-color:#ffffff; border-bottom:1px #999999 dashed"><strong><font size="2" color="#336633">Polytechnic Institute of</font> <font color="#660099">NYU</font></strong></span>. You can post house rentals, sales, class comments, events, etc. Also, it is a place to find friends, exchange   topics with other students as well.</font>
                <p style="margin-bottom:25px"> </p>
              <div> <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 30px; display:inline; margin-bottom:0px; background-color: #B92828; border-bottom:1 solid #333333; border-top:1 solid #333333"><a href="joinUs.php"><strong>Sign Up</strong></a></span> &nbsp; <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 30px; display:inline; margin-bottom:5px; background: url(img/black_cell_bg.jpg); border-bottom:1 solid #000000; border-top:1 solid #000000"><a href="commentUs.php"><strong>Comment</strong></a></span></div></td>
          </tr>
        </table>
	  </form>
	  </td>
	  <td valign="top" align="center" style="padding-top:0px; border-left:1px solid #DDDDDD; border-right:1px solid #DDDDDD;"><table width="810" height="35" border="0" cellpadding="0" cellspacing="0" background="img/master.png" style="border-bottom: 1px #CCCCCC solid; border-top:1px solid #CCCCCC; margin-bottom:5px">
        <tr>
          <td width="499" align="left" valign="middle" style="padding-left:10px"><font color="#999999"><strong> &nbsp;<a href="FreeTourHouse.php" class="one">House</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="FreeTourMarket.php" class="one">Sale</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="FreeTourEvent.php" class="one">Event</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="FreeTourClass.php" class="one">Class</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="FreeTourForum.php" class="one">Questions</a>&nbsp;</strong></font></td>
          <td width="227" valign="middle" align="left">&nbsp;</td>
          <td width="84" align="center" valign="middle" style="padding-left:0px"><form action="Header.php" id="switch_lan" name="switch_lan" method="post">
              <select name="lan" class="box" onchange="document.switch_lan.submit()" style="background-color:#F5F5F5; font-size:11px">
                <option value="EN" selected="selected">English</option>
              </select>
          </form></td>
        </tr>
      </table>
	    </div>
	  <?php 
	  if(isset($_SESSION['rst_msg'])){
		  echo $_SESSION['rst_msg'];
		  unset($_SESSION['rst_msg']); 
	}
	  ?> 	  
	  <form method="post" action="FreeTourSendMsg.php">
 		<div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:10; padding-bottom:15; border-bottom:1px #EEEEEE solid">
		  <table width="800" height="355" border="0" cellpadding="0" cellspacing="0" style="border:0px #CCCCCC dotted">
            <tr>
              <td height="20" colspan="3" align="left" style="padding-left:15px">&nbsp;</td>
            </tr>
            <tr>
              <td width="139" rowspan="4" align="right" valign="top" style="padding-right:5px; padding-top:10">
			  <a href="FreeTourUser.php?uid=<?php echo($recipient)?>">
			  <?php
			$loopImg = "upload/$recipient/$recipient.jpg";
			if(file_exists($loopImg)) echo("<img src=$loopImg width=100px style='border:0px #666666 solid' />");
			 else echo("<img src=img/NoUserIcon.jpg width=100px />");
		?>
		</a> 
		</td>
              <td width="113" align="right" style="padding-right:15px"><strong>Send to</strong></td>
              <td width="548" align="left" style="padding-right:8px"height="41"><?php 
				  if($recipient==NULL || strlen($recipient)==0){
						echo("<input type=text name=recipient size=15 class=box>"); 
					}else{
						echo("<input type=text class=box value='$recipient' disabled=disabled>");
						echo("<input type=hidden name=recipient size=15 class=box value='$recipient'>");
					}
			?></td>
            </tr>
            <tr>
              <td align="right" style="padding-right:15px"><strong>Your name</strong></td>
              <td align="left" style="padding-right:8px"height="41">
			  <input type="text" name="sender" size="15" class="box">&nbsp;&nbsp;&nbsp;<font color="#999999">(Leave blank as anonymous)</font>
			  </td>
            </tr>
            <tr>
              <td height="40" align="right" style="padding-right:15"><strong>Subject</strong></td>
              <td height="40"><input type="text" name="subject" size="75" class="box" /></td>
            </tr>
            <tr>
              <td height="100" align="right" valign="middle" style="padding-right:15px;">&nbsp;</td>
              <td height="100" style="padding-top:20px" valign="top">
			  <textarea name="description" rows="15" style="width:480" id="styled" onfocus="this.value=''; setbg('#e5fff3');" onblur="setbg('white')"></textarea>              </td>
            </tr>
            <tr>
              <td height="21" colspan="2" align="center" valign="top">&nbsp;</td>
              <td height="21" align="left" valign="top" style=" padding-top:10px">
			  <input type="submit" name="sendmsgform" value=" Send " class="btn" />              
			  </td>
            </tr>
          </table>
		</div>
		</form>
	  </td>
    </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
</body>
</html>
