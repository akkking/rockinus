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
	  <td valign="top" align="center" style="padding-top:0px"><div style="border-left:1px #EEEEEE solid; border-right:1px #EEEEEE solid; border-bottom:1px #EEEEEE dashed">
        <table width="800" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:25px">
          <tr>
            <td width="800" height="86" colspan="0" align="center" style="border-left:0px #EEEEEE solid"><div style="background: url(img/green_bg_cell.jpg); border-bottom:4px #EEEEEE solid; margin-bottom:5px; margin-top:0px; padding-top:0px; padding-bottom:0px; padding-right:10px; font-size:11px;">
                <table width="790" height="30" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="262" style="padding-left:15px; padding-right:10px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px" align="left" bgcolor="" onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.backgroundColor = '';"><a href="composeComment.php" class="one"><strong><font color="#FFFFFF">+ Compose a Comment</font><font size="1">
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

				  echo("<font size=2></font>") ?>
                    </font></strong></a></td>
                    <td width="528" align="right"><font color="#FFFFFF" size="1"><span style="padding-left:10px">
                      <?php			
 $limit= (isset($_GET["limit"])) ? $_GET["limit"] : 15;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;

if((!$limit) || (is_numeric($limit) == false)|| ($limit < 15) || ($limit > 50)) {
	$limit = 1; //default
}
 
if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items)) { 
	$page = 1; //default 
}
 
//calculate total pages
$total_pages = ceil($total_items / $limit);
$set_limit = ($page * $limit) - $limit;
//echo "Total Pages: $total_pages <br/>";
if ($total_items != 0 )echo "Page ";
//prev. page
$prev_page = $page - 1;
if($prev_page >= 1) { 
	echo("<a href=$page_name?limit=$limit&page=$prev_page class=one>Previous</a>");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo(" <strong>$a</strong>  "); //no link
}else{ 
	echo("<a href=$page_name?limit=$limit&page=$a class=one> <strong>$a</strong> </a>   ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo("  <a href=$page_name?limit=$limit&page=$next_page class=one>Next</a>");
}
//if ($total_items != 0 )echo " ...";
?>
                    </span></font></td>
                  </tr>
                </table>
            </div>
                <?php
$q1 = mysql_query("SELECT * FROM rockinus.open_comment_info WHERE 1=1 ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
//echo ("SELECT * FROM rockinus.forum_info WHERE 1=1 $sel_cond ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("<font size=5><div style='padding:20px; margin-bottom:10px; margin-top:100px; align='center'><br>No comments so far.</div><div align='center' style='background-color:#B92828; height:50px; display:inline; margin-top:10px; padding-left:20px; border-bottom:1px #000000 solid; border-right:1px #000000 solid; padding-right:20px; padding-top:10px; padding-bottom:10px; color:white'><a href='composeComment.php' class='one'><font color=white>Write a Comment</font></a></div></font>");}
else if($no_row > 0){ 
	while($object = mysql_fetch_object($q1)){
		$comid = $object->comid;
		$sender = $object->sender;
		$descrip = $object->descrip;
		$ptime = $object->ptime;
		$pdate = $object->pdate;  
?>
                <div style="padding-top:10px; border-left:0px #DDDDDD solid; border-right:0px #DDDDDD dashed" onmouseover="this.style.backgroundColor = '#F5F5F5';" onmouseout="this.style.backgroundColor = 'white';">
                  <table width="800" height="64" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px #DDDDDD dashed">
                    <tr>
                      <td width="32" height="32" align="left" style=" color:#336633; padding-left:10px"><img src="img/rightTriangleIcon.jpg" width="12" height="12" /></td>
                      <td width="538" align="left" style=" font-family: Georgia, 'Times New Roman', Times, serif; font-size:14px"><?php echo("<font color=##336633 size=2><strong>$sender</strong></font> <font color=#999999></font>") ?> </td>
                      <td width="110" align="right" style="color: #999999; font-size:11px; padding-right:5px"><?php echo($pdate) ?> | <?php echo(substr($ptime,0,5)) ?></td>
                    </tr>
                    <tr>
                      <td align="left" style=" color:#336633; padding-bottom:20px">&nbsp;</td>
                      <td colspan="2" align="left" valign="top" style=" padding-right:5px; padding-bottom:15px; line-height:130%; padding-top:3px; font-family: 'Times New Roman', Times, serif; font-size:15px; border-bottom:0px #CCCCCC dashed"><?php 
					echo(substr($descrip,0,300)."...") ?>
                      </td>
                    </tr>
                  </table>
                </div>
              <?php }}?></td>
          </tr>
        </table>
	    </div>
      </div></td>
    </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
</body>
</html>
