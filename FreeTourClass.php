<?php 
include("GreenHeaderFreeTour.php"); 
include("FreeHeader.php") 
?><style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
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
$q1 = mysql_query("SELECT * FROM rockinus.course_memo_info a JOIN rockinus.unique_course_info b ON a.course_uid=b.course_uid ORDER BY a.pdate DESC, a.ptime DESC LIMIT 0, 30");
//echo ("SELECT * FROM rockinus.forum_info WHERE 1=1 $sel_cond ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("<center><font size=5><br><br>Unfortunately, no class comments posted.<br><br><br></font></center>");}
else if($no_row > 0){ 
	while($object = mysql_fetch_object($q1)){
		$memoid = $object->memoid;
		$course_id = $object->course_id;
		//$sid = $object->sid;
		$pid = $object->pid;
		$sender = $object->sender;
		$rating = $object->rating;
		$descrip = $object->descrip;
		$ptime = $object->ptime;
		$pdate = $object->pdate;  
		
		$q2 = mysql_query("SELECT * FROM rockinus.course_info where course_id='$course_id'");
		if(!$q2) die(mysql_error());
		$no_row = mysql_num_rows($q2);
		if($no_row == 0) echo("No matches met your criteria.");
		$objectx = mysql_fetch_object($q2);
		$course_name = $objectx->course_name;
?>
		<div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:15; padding-bottom:15; border-bottom:1px #EEEEEE solid">
          <table width="800" height="105" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="60" rowspan="3" align="center" style="padding-right:5px; padding-top:5px" valign="top">
			  <img src="img/book100.jpg" width="35" height="35" /></strong></font></td>
              <td width="605" height="30" style="padding-left:10px; font-size:14px"><?php
							  	echo("Comment on Course <font color=#000000><strong>$course_id</strong></font>");
							  ?></td>
              <td width="135" height="30" align="right" style="padding-right:10px"><font size="1"><?php echo("$pdate | ".substr($ptime,0,5)) ?></font> </td>
            </tr>
            <tr>
              <td height="30" style="padding-left:10px; font-size:14px"><?php
							  	echo("<strong>$course_name</strong>");
							  ?></td>
              <td height="30" align="right" style="padding-right:10px"><?php 
								for($i=0;$i<$rating;$i++)
									echo("<img src=img/yellowstar.jpg /> "); 
								?></td>
            </tr>
            <tr>
              <td height="30" style="padding-left:10px; padding-top:5px; line-height:150%; font-size:14px" valign="top">
			  <?php 
				echo("$descrip");
			  ?>
			  </td>
              <td height="30" align="right" style="padding-right:10px">&nbsp;</td>
            </tr>
          </table>
	    </div>
		<?php } }?>
	  </td>
    </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
</body>
</html>
