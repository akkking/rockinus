<?php include("GreenHeaderFreeTour.php"); 
	if(isset($_GET["uid"]))
		$uid = $_GET["uid"]; 
	else
		echo "Error Page";
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
<script type="text/javascript">
function changeBgImage (image, id) {
	var element = document.getElementById(id);
	element.style.backgroundImage = "url("+image+")";
}
</script>
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
          <td width="204" height="10" align="left" style="padding-left:0px; padding-top:0px; padding-bottom:0px">
		  <a href="main.php"><img src="img/rockinus.jpg"></a></td>
        </tr>
        <tr>
          <td height="40" align="left" style="padding-left:0px; padding-top:0px; padding-bottom:5px">
		  <?php 
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
          <td height="35" align="left" style="padding-left:15px"><input type="password" style="height:22px" name="passwd" onmouseover="this.className='over'" onmouseout="this.className='out'" class="box" size="23">		  </td>
        </tr>
        <tr>
          <td height="40" align="left" style="padding-left:15px"><input type="checkbox" name="Login_Tag" />          
          Remember Me </td>
        </tr>
        <tr>
          <td height="40" align="left" style="padding-left:15px"><input type="submit" name="Submit" value="Sign In" class="btn2" />          </td>
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
	  <div style="border:1px #CCCCCC solid; line-height:150%; background-color:#EEEEEE; font-size:12px; width:160; margin-left:15; margin-top:10px; padding:10px; margin-bottom:20" align="top">
	  <strong>
	  Rockinus currently only supports registration with <font color="#B92828">.edu</font> email, thanks for your understanding. 
	  </strong>
	  </div></td>
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
		<table>
		<tr>
		<td valign="top" align="left" style="padding-left:15px; padding-top:10px">
		<?php
			$loopImg = "upload/$uid/$uid.jpg";
			if(file_exists($loopImg)) echo("<img src=$loopImg?".time()." width=300px style='border:0px #666666 solid' />");
			 else echo("<img src=img/NoUserIcon.jpg width=300px />");
		?>		
		</td>
		<td valign="top" style="padding-left:10px">
	    <table width="470" height="355" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="41" height="40" align="center"><img src="img/starIcon.jpg" width="15" height="15" /> </td>
            <td width="190" height="40" style="padding-left:5px;">
			<?php
			$sel_count = "
SELECT sum(total) as cnt FROM (
	SELECT count(*) as total FROM rockinus.house_info WHERE uname='$uid'
	UNION 
	SELECT count(*) as total FROM rockinus.article_info WHERE uname='$uid'
	UNION 
	SELECT count(*) as total FROM rockinus.course_memo_info WHERE sender='$uid' 
	UNION 
	SELECT count(*) as total FROM rockinus.event_info WHERE creater='$uid'
	UNION 
	SELECT count(*) as total FROM rockinus.cafe_info WHERE creater='$uid' 
	UNION 
	SELECT count(*) as total FROM rockinus.cafefood_memo_info WHERE sender='$uid' 
) as cnt";

$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
 
$a = mysql_fetch_object($t);
$t_cnt = $a->cnt;
echo("<font size=4 color=#000000><strong>$uid </strong></font> <font color=#999999 size=3>($t_cnt posted)</font>");

$q = mysql_query("SELECT *, b.email as eemail FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b INNER JOIN rockinus.user_edu_info c INNER JOIN rockinus.user_contact_info d ON a.uname='$uid' AND b.uname='$uid' AND c.uname='$uid' AND d.uname='$uid'");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("This user info no longer exist in system.");
$object = mysql_fetch_object($q);
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;
$birthdate = $object->birthdate;
$sterm = $object->sterm;
$fregion = $object->fregion;
$fcountry = $object->fcountry;
$ccity = $object->ccity;
$cstate = $object->cstate;
if($fcountry=="empty")$fcountry = NULL;
$email = $object->email;
$eemail = $object->eemail;
$cmajor = $object->cmajor;
$cschool = $object->cschool;
$cdegree = $object->cdegree;

if($gender=='M')$gender='Gentle Man';
else if($gender=='F')$gender='Female';

if($sstatus=='S')$sstatus='Student';
else if($sstatus=='E')$sstatus='Empolyee(r)';

if($cdegree=='G')$cdegree='Master Student';
else if($cdegree=='P')$cdegree='P.H.D.';
else if($cdegree=='U')$cdegree='Undergraduate';
else if($cdegree=='C')$cdegree='Certificate Student';

if($mstatus=='S')$mstatus='Single';
else if($mstatus=='M')$mstatus='Married';
else if($mstatus=='I')$mstatus='In a relationship';

if($cschool!=NULL&&$cschool!="empty"){
	$q1 = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
	if(!$q1) die(mysql_error());
	$obj1 = mysql_fetch_object($q1);
	$school_name = $obj1->school_name;
}else $school_name="<font color=#CCCCCC>Unknown school name</font>";

if($cmajor!=NULL){
	$q2 = mysql_query("SELECT * FROM rockinus.major_info where mid='$cmajor'");
	if(!$q2) die(mysql_error());
	$obj2 = mysql_fetch_object($q2);
	$cmajor = $obj2->major_name;
}

if($fcountry!=NULL){
	$q1 = mysql_query("SELECT * FROM rockinus.country_info where counid='$fcountry'");
//	echo("SELECT * FROM rockinus.country_info where counid='$fcountry'");
//	if(!$q1) die(mysql_error());
//	$obj1 = mysql_fetch_object($q1);
//	$fcountry = $obj1->country_name;
}

$q3 = mysql_query("SELECT * FROM rockinus.memo_info where sender='$uid' order by memoid DESC");
if(!$q3) die(mysql_error());
$obj3 = mysql_fetch_object($q3);
$uiddescrip = $obj3->descrip;
$memoid = $obj3->memoid;
if($uiddescrip==NULL) $uiddescrip="<font color=#CCCCCC>Nothing posted ...</font>";

$rstatus = NULL;
if($uid==$uname)$rstatus ="S";
else{
	$q11 = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE (sender='$uid' AND recipient='$uname') OR (recipient='$uid' AND sender='$uname')");
	if(!$q11) die(mysql_error());
	$no_row_A = mysql_num_rows($q11);
	if($no_row_A>0)$rstatus='A';
	
	$q21 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uid' AND recipient='$uname' AND rstatus='P'");
	if(!$q21) die(mysql_error());
	$no_row_P = mysql_num_rows($q21);
	if($no_row_P>0)$rstatus='X';
	
	$q22 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uname' AND recipient='$uid' AND rstatus='P'");
	if(!$q22) die(mysql_error());
	$no_row_X = mysql_num_rows($q22);
	if($no_row_X>0)$rstatus='P';	
}
			  ?>
              &nbsp;</td>
            <td width="249" height="40" align="right" style="padding-right:0px;" valign="middle">            </td>
          </tr>
          <tr>
            <td width="41" height="40" align="right" valign="top" style="padding-top:5px; padding-right:5px">&nbsp;</td>
            <td height="40" colspan="2" style="border:0px #DDDDDD solid; line-height:150%; display:inline; padding:5px; padding-right:10; font-size:14px; height:15">
            <?php
				if(strlen($uiddescrip)) echo($uiddescrip);		 
			?>
			</td>
          </tr>
          <tr>
            <td width="41" height="40" valign="middle" align="center"><img src="img/studentIcon.jpg" width="15" height="15" /> </td>
            <td height="40" colspan="2" style="padding-top:3px; padding-bottom:5px; padding-left:5px; font-size:14px"><?php 
						  if($cdegree!=NULL)echo("<strong>$cdegree</strong>"); 
						  if($sstatus!=NULL)echo("<strong>$sstatus</strong>");
						   ?>            </td>
          </tr>
          <tr>
            <td width="41" height="30" align="right" valign="top" style="padding-top:5px; padding-right:5px">&nbsp;</td>
            <td height="30" colspan="2" style="padding-top:3px; padding-bottom:5px; padding-left:5px; font-size: 14px">
			<span style="margin-top:10px">
              <?php
					if(($sstatus!=NULL)&&($cschool!=NULL))echo("$school_name"); 
					else{
							$pieces = explode('@', $eemail);
							if(stristr($pieces[1],'poly')==true) echo("From NYU-Poly ");
							else echo("From ".$pieces[1]);
					}
				?>
            </span></td>
          </tr>
          <tr>
            <td width="41" height="30" style="padding-right:5px" align="right"></td>
            <td height="30" colspan="2" style="padding-left:5px; font-size: 14px"><?php 
						  if(($cdegree!=NULL)&&($cmajor!=NULL))echo("$cmajor ($sterm)"); 
						  else echo("<font color=#CCCCCC> Unknown major</font>");
						  ?>            </td>
          </tr>
          <tr>
            <td height="10" style="padding-right:5px" align="right"></td>
            <td height="10" colspan="2" style="padding-left:5px">&nbsp;</td>
          </tr>
          <tr>
            <td width="41" height="30" align="center"><img src="img/hometownIcon.jpg" width="15" height="15" /></td>
            <td height="30" colspan="2" style="padding-left:5px; font-size:14px"><?php 
							echo("<strong>Now Live in: &nbsp;</strong>  ");
						   if($ccity!=NULL)echo($ccity); else echo("<font color=#CCCCCC>Unkown City</font>"); 
						   		if(($cstate!=NULL)&&($cstate!=NULL)){
						   			if($ccity!=NULL)echo(", $cstate");
								}else 	
						   			echo("<font color=#CCCCCC>, Unknown State</font>"); 
						   ?>            </td>
          </tr>
          <tr>
            <td width="41" height="30" style="padding-left:0px; padding-right:5px">&nbsp;</td>
            <td height="30" colspan="2" style="padding-left:0px; padding-left:5px; font-size:14px"><?php 
						   echo("<strong>Home Town: &nbsp;</strong>");
						   if($fregion!=NULL&&$fregion!="empty")echo($fregion); else echo("<font color=#CCCCCC>Unknown City</font>");
						   if(($fregion!=NULL)&&($fcountry!=NULL))echo(", ".$fcountry); else echo("<font color=#CCCCCC>, Unknown Country</font>");
						   ?>            </td>
          </tr>
          <tr>
            <td height="10" style="padding-left:0px; padding-right:5px">&nbsp;</td>
            <td height="10" colspan="2" style="padding-left:0px; padding-left:5px; font-size:14px">&nbsp;</td>
          </tr>
          <tr>
            <td width="41" height="40"  align="center"><img src="img/personIcon.jpg" width="15" height="15" /></td>
            <td height="40" colspan="2" style="padding-left:0px; padding-left:5px; font-size:14px"><?php 
				echo("<strong>Martial Status: &nbsp;</strong>");
				if($gender=="Male")echo("He is ");
					else if($gender=="Female")echo("She is ");
						if($mstatus!=NULL)echo($mstatus); else echo("<font color=#CCCCCC>Unknown</font>");  ?></td>
          </tr>
          <tr>
            <td width="41" height="40" style="" align="center"><img src="img/emailIcon.jpg" width="15" height="15" /></td>
            <td height="40" colspan="2" style="padding-left:5px; font-size:14px">
			<?php echo($eemail) ?></td>
          </tr>
        </table>		</td></tr>
		</table>
		<hr width="790" style="margin-top:15px; margin-bottom:75px; color:#DDDDDD; size:1px"/>
		<a href="FreeTourSendMsg.php?recipient=<?php echo($uid) ?>">
		<div style="display:inline; border:1px #CCCCCC solid; border-bottom:1px #CCCCCC solid; background: url(img/master.png); padding:12px; padding-top:6px; padding-bottom:6px; font-size:20px; color:#000000" id="sendmsg" onMouseOver="changeBgImage('img/GreenBg.jpg', 'sendmsg')" onMouseOut="changeBgImage('img/master.png', 'sendmsg')">
		Message Me
		</div>
		</a>
	  </td>
    </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
</body>
</html>
