<?php include("GreenHeaderFreeTour.php"); ?>
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
$q1 = mysql_query("SELECT * FROM rockinus.forum_info ORDER BY pdate DESC, ptime DESC LIMIT 0, 30");
//echo ("SELECT * FROM rockinus.forum_info WHERE 1=1 $sel_cond ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("<center><font size=5><br><br>No posting found.<br><br><br></font></center>");}
else if($no_row > 0){ 
	while($object = mysql_fetch_object($q1)){
		$foid = $object->foid;
		$creator = $object->creater;
		$category = $object->category;
		$descrip = $object->descrip;
		$subject = $object->subject;
		$ptime = $object->ptime;
		$pdate = $object->pdate;  
		if(ctype_upper($category)){
			$m = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid='$category'");
			if(!$m) die(mysql_error());
			$objm = mysql_fetch_object($m);
			$category = $objm->major_name;
		}
?>
	    <div style="margin-top:5; margin-bottom:5px; padding-left:0; padding-top:15; padding-bottom:15; border-bottom:1px #DDDDDD solid ">
          <table width="800" height="105" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50" rowspan="3" align="left" valign="top" bgcolor="#FFFFFF" style="padding-top:5px; padding-left:15px"><img src="img/eventlmIcon.jpg" width="40" height="40" /></td>
              <td width="633" height="30" align="left" style="padding-left:15px; font-size:14px"><?php 
										  echo("<a href=RockerDetail.php?uid=$creator class=one><font color=#336633><strong>$creator</strong></font></a> posted in forum");
							  ?>              </td>
              <td width="131" height="30" align="right" style="padding-right:10px; font-size:14px">
                <?php 
										  echo("$pdate | ".substr($ptime,0,5));
							  ?>              </td>
            </tr>
            <tr>
              <td height="30" colspan="2" align="left" style="padding-left:15px; font-size:14px"><?php 
				echo("<a href=FreeTourForumDetail.php?foid=$foid class=one><strong>".substr($subject,0,110)." ...</strong></a>");
				
							  ?>              </td>
            </tr>
            <tr>
              <td height="35" colspan="2" align="left" style="padding-left:15px; padding-right:10px; padding-top:5px; padding-bottom:5px; line-height:150%; font-size:14px">
			  <?php 
				echo(substr(nl2br($descrip),0,600)."...");
?></td>
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
