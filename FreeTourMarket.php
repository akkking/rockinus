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
            <td width="204" height="20" align="left" style="padding-left:0px; padding-top:0px; padding-bottom:30px"><a href="main.php"><img src="img/rockinus.jpg" /></a></td>
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
	  <td valign="top" align="center" style="padding-top:0px; border-left:1px #DDDDDD solid; border-right: 1px #DDDDDD solid"><table width="810" height="35" border="0" cellpadding="0" cellspacing="0" background="img/master.png" style="border-bottom: 1px #CCCCCC solid; border-top:1px solid #CCCCCC; margin-bottom:5px">
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
	    <div style="margin-top: 10; margin-bottom: 10; margin-left:0; margin-right: 0; background-color:#F5F5F5; padding-top:5px; padding-bottom:5px; width:790px; border:1px #EEEEEE solid" align="center">
          <table width="790" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="790"><table width="790" height="27" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="25" style="border-bottom: 0px dotted #999999; margin-bottom:10; padding-left:10px; width:800px; padding-bottom:4; padding-top:4;"><font color="#000000" size="3"><strong>Category</strong></font> &nbsp; &nbsp;&nbsp;<span class="STYLE25 STYLE83"><a href="FreeTourHouse.php?type=<?php echo("All") ?>" class="one">All Types</a></span>&nbsp;&nbsp;&nbsp;<span class="STYLE25 STYLE83"><a href="FreeTourHouse.php?type=<?php echo("Single Room") ?>" class="one">Electronics</a></span>&nbsp;&nbsp;&nbsp;<span class="STYLE25 STYLE83"><a href="FreeTourHouse.php?type=<?php echo("Apartment") ?>" class="one">Books</a></span>&nbsp;&nbsp;&nbsp;<span class="STYLE25 STYLE83"><a href="FreeTourHouse.php?type=<?php echo("Room Shared") ?>" class="one">Furniture</a></span>&nbsp;&nbsp;&nbsp;<a href="FreeTourHouse.php?type=<?php echo("Studio") ?>" class="one">Costume</a> &nbsp;&nbsp;&nbsp; <a href="FreeTourHouse.php?type=<?php echo("House") ?>" class="one">Transport</a>&nbsp;&nbsp;&nbsp;<a href="FreeTourHouse.php?type=<?php echo("House") ?>" class="one">Cosmetics</a>&nbsp;&nbsp;&nbsp;<a href="FreeTourHouse.php?type=<?php echo("House") ?>" class="one">Instruments</a>&nbsp;&nbsp;&nbsp;<a href="FreeTourHouse.php?type=<?php echo("House") ?>" class="one">Cards&Tix</a>&nbsp;&nbsp;&nbsp;<a href="FreeTourHouse.php?type=<?php echo("Others") ?>" class="one">Others</a></td>
                  </tr>
              </table></td>
            </tr>
          </table>
	      <table width="790" height="28" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="25" class="STYLE14" style="border-bottom: 0px dotted #999999; margin-bottom:10; padding-left:10; width:790; padding-bottom:4; padding-top:4;"><font color="#000000" size="3"><strong>Location</strong></font> &nbsp;&nbsp; &nbsp; <span class="STYLE25 STYLE83"><a href="FreeTourHouse.php?city=<?php echo("All") ?>" class="one">All Areas</a></span>&nbsp;&nbsp;&nbsp; <span class="STYLE25 STYLE83"><a href="FreeTourHouse.php?city=<?php echo("Brooklyn") ?>" class="one">Brooklyn</a></span>&nbsp;&nbsp;&nbsp; <span class="STYLE25 STYLE83"><a href="FreeTourHouse.php?city=<?php echo("Manhattan") ?>" class="one">Manhattan</a></span>&nbsp;&nbsp;&nbsp; <span class="STYLE25 STYLE83"><a href="FreeTourHouse.php?city=<?php echo("Queens") ?>" class="one">Queens</a></span>&nbsp;&nbsp;&nbsp; <a href="FreeTourHouse.php?city=<?php echo("Bronx") ?>" class="one">Bronx</a> &nbsp;&nbsp;&nbsp; <a href="FreeTourHouse.php?city=<?php echo("Long Island") ?>" class="one">Long Island</a>&nbsp;&nbsp;&nbsp; <a href="FreeTourHouse.php?city=<?php echo("Others") ?>" class="one">Others</a></td>
            </tr>
          </table>
        </div>
	    <div style="width:780">
          <?php
		$q = mysql_query("SELECT * FROM rockinus.article_info ORDER BY aid DESC LIMIT 0, 15");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		
		if ($no_row == 0)echo("<div style='background-color:#EEEEEE;width:810px; padding-top:50px;padding-bottom:50px; margin-top:5px' align='center'><font color=black size=4><strong>No sales info found.<p> <a href='PostFlea.php' class='one'>>> <font color=#B92828>Click to Post</font></a> </strong></font></div>");
		
		while($object = mysql_fetch_object($q)){
			$aid = $object->aid;
			$subject = $object->subject;
			$type = $object->type;
			$buysale = $object->buysale;
			$state = $object->state;
			$quality = $object->quality;
			$city = $object->city;
			$email = $object->email;
			$rate = $object->rate;
			$num = $object->num;
			$aname = $object->aname;
			$uname = $object->uname;
			$description = $object->descrip;
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			?>
			<div style="border-bottom:1 #EEEEEE solid; padding-top:10; padding-bottom:10; margin-left:0px; margin-top:0px" onmouseover="this.style.backgroundColor = '#F5F5F5';this.style.borderColor = '#DDDDDD';" onmouseout="this.style.backgroundColor = 'white'; this.style.borderColor = '#EEEEEE';">
          <table width="780" align="center" height="105" cellpadding="0" cellspacing="0">
            <tr>
              <td width="105" height="103" align="center" style="padding:5; padding-left:10" valign="top"><div align="center" style="padding:5">
                  <?php 
			$target = "upload/a".$aid;
			if(is_dir($target)){
				echo("<a href='FreeTourMarketDetail.php?aid=$aid' class='one'><img src=upload/a$aid/1_100.jpg style=border:0></a>");
			}else 				  		
				echo("<img src=img/noarticle_gray100.jpg style=border:0>");
			?>
              </div></td>
              <td width="710" colspan="2" valign="top"><table width="685" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="571" height="35" valign="top" style="padding-left:10; padding-top:10"><font size="3"> <a class="one" href="FreeTourMarketDetail.php?aid=<?php echo($aid) ?>" target="_blank"><strong><? echo($subject) ?></strong></a> </font> </td>
                    <td width="107" valign="middle">
					<span style="padding-bottom:5; margin-left:0; margin-right:0; padding-top:10; font-size:14px"><?php echo("$city")?></span>
					</td>
                  </tr>
                    <tr>
                      <td width="571" height="35" valign="middle" style="padding-left:10; font-size:14px">
					  <?php echo("<font color=#999999><strong>$aname | $buysale | $quality</strong></font> ")?> </td>
                      <td width="107" valign="middle"><a href="RemoveFriend.php?recipient=<?php echo($recipient) ?>" class="one">
					  <span style="padding-bottom:5; margin-left:0; margin-right:0; padding-top:10; font-size:14px">$ <?php echo("$rate")?></span></a>
					  </td>
                    </tr>
                    <tr>
                      <td width="571" valign="top" style="padding:10; padding-top:5; padding-right:15; font-size:14px; line-height:150%">
					    <?php echo(nl2br($description)) ?>					  </td>
                      <td width="107" align="left" valign="top" style="padding-top:5; font-size:14px">
					  <?php echo("$pdate")?>
					  </td>
                    </tr>
                </table></td>
            </tr>
          </table>
		  </div>
          <?php } ?>
      </div></td>
    </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
</body>
</html>
