<?php include("GreenHeaderFreeTour.php"); 
	include("Allfuc.php"); 
	$ua=getBrowser();
	
	//session_start(); 
	if (isset($_SESSION['usrname']))
		header("location:ThingsRock.php");
		
	if (isset($_COOKIE["user"]) && isset($_COOKIE["Login_Tag"])){
		$_SESSION['usrname'] = $_COOKIE["user"];
		header("location:ThingsRock.php");
	}
	
if(isset($_POST['openComment'])){
	$tag = 0;
	$nickname = addslashes($_POST['nickname']);
	$descrip = addslashes($_POST['descrip']);
	
	if( strlen($nickname)==0 || $nickname==NULL ){
		$nickname = "Visitor";
	} 
	
	if( ( $descrip==NULL || strlen($descrip)==0 ) && $tag ==0 ){
		$tag = 1;
		$rst_msg = "No content for the post, please check";
	}
	
	if($tag==0){	
		include 'dbconnect.php'; 
		$sql = "INSERT INTO rockinus.open_comment_info (sender,descrip,pdate,ptime)VALUES('$nickname','$descrip',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		$rst_msg = "Your comment has been submitted successfully!";
		mysql_close($link);
		$_SESSION['comment_rst_msg']="<div align='center' style='width=500; padding-top:20; padding-bottom:20; margin-top:10'><strong><FONT size=4 color=$_SESSION[hcolor]>$rst_msg ^^</font></strong><br><br><br><font size=3><a href=commentUs.php class=one>Go Back</a></font></div>"; 
	}else
	$_SESSION['comment_rst_msg']="<div align='center' style='width=500; padding-top:20; padding-bottom:20; margin-top:10'><strong><FONT size=4 color=#B92828><img src=img/stop.jpg width=18 height=18 />&nbsp;&nbsp;&nbsp;$rst_msg</font></strong><br><br><br><font size=3><a href=composeComment.php class=one>Go Back</a></font></div>"; 
	header("location:openCommentResult.php");
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
#scroll {position:relative; width:690; height:586; }
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
	  <td valign="top" align="left" style="padding-top:0px">
	  <div style="border:1px #DDDDDD solid; background-color:#F5F5F5">
        <table width="800" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:25px">
          <tr>
            <td width="800" height="86" colspan="0" align="left" style="border-left:1px #EEEEEE solid">
			<div style="background: url(img/green_bg_cell.jpg); border-bottom:4px #EEEEEE solid; margin-bottom:0px; font-size:11px; height:30px">
                <table width="800" height="30" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="235" align="left" style="background-color:; padding-left:15px; padding-right:10px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.background = ;"><a href="commentUs.php" class="one"><strong><font color="#FFFFFF"> Comment Board</font></strong></a>
                        <?php 
				  //Global Variable: 
$page_name = "commentUs.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
 
//**EDIT TO YOUR TABLE NAME, ETC.
$q = "SELECT count(*) as cnt FROM rockinus.open_comment_info WHERE 1=1 ORDER BY pdate,ptime DESC";
//echo("SELECT count(*) as cnt FROM rockinus.house_info WHERE $sel_cond ORDER BY pdate,ptime DESC");
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
//if ($total_items == 0 )echo("<strong>No post so far</strong>");

				  echo("<font size=2> ($total_items)</font>") ?>                    </td>
                    <td width="555" align="right"></td>
                  </tr>
                </table>
            </div>
                <form action="composeComment.php" method="post">
                  <table width="800" height="282" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border:0px #DDDDDD solid; border-top:0px">
                    <tr>
                      <td width="159" height="35" style="padding-left:10px" align="right">&nbsp;</td>
                      <td width="639" height="35" style="padding-left:10px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="80" style="padding-right:10px" align="right"><strong>Nick Name </strong></td>
                      <td height="80" style="padding-left:10px"><input type="text" name="nickname" size="25"/>
                        &nbsp;&nbsp;&nbsp;<font color="#999999" size="1">(Or leave it as blank for anonymous)</font></td>
                    </tr>
                    <tr>
                      <td height="170" style="padding-right:10px; padding-top:10px" align="right" valign="top"><strong> </strong></td>
                      <td style="padding-left:10px; padding-top:10px" valign="top"><textarea name="descrip" style="width:550" rows="15"></textarea>                      </td>
                    </tr>
                    <tr>
                      <td height="50" style="padding-right:10px" align="right">&nbsp;</td>
                      <td style="padding-left:10px; padding-top:30px; padding-bottom:30px" valign="top"><input name="openComment" type="submit" class="btn" value=" Submit " />                      </td>
                    </tr>
                  </table>
                </form></td>
          </tr>
        </table>
	    </div>
      </div></td>
    </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
</body>
</html>
