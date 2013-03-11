<?php include("HeaderFreeTour.php"); ?>
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
<table width="1024" height="268" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="1024" height="268" align="center" valign="top" style=" border-right:#DDDDDD solid 0;border-left:#DDDDDD solid 0;">
        <?php
if(isset($_GET['foid']))
	$foid = $_GET['foid'];
else if(isset($_POST['foid']))
	$foid = $_POST['foid'];
$q1 = mysql_query("SELECT * FROM rockinus.forum_info where foid='$foid'");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
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

if($uname==$creator){
	$t2 = mysql_query("SELECT * FROM rockinus.forum_history WHERE rstatus='N' AND foid=$foid");
	if(!$t2) die(mysql_error());
	$no_row_hist = mysql_num_rows($t2);
	
	if($no_row_hist>0){	
		$upd = mysql_query("UPDATE rockinus.forum_history SET rstatus='Y' WHERE foid='$foid' AND rstatus='N'");
		if(!$upd) die(mysql_error());
	}
}
?>
<div style="width:1020px;"><table width="1020" height="196" border="0" cellpadding="0" cellspacing="0" style="border-left:0px #DDDDDD solid; border-right:0px #DDDDDD solid">

            <tr>
              <td width="166" height="38" align="left" background="img/master.png" style="border-bottom:0px #666666 dashed; padding-left:10px">Published by: <a href="FreeTourUser.php?uid=<?php echo($creator) ?>" class="one"><font color="#000000" style="font-weight:bold" size="2"> <?php echo($creator) ?></font></a></td>
              <td width="620" height="38"  align="center" background="img/master.png" style="border-bottom:0px #666666 dashed"> Topic in:  <font color="#000000" size='2'><strong><?php echo($category) ?></strong></font> </td>
              <td width="234" height="38"  align="right" background="img/master.png" style="border-bottom:0px #666666 dashed; padding-right:10px"><font color="#000000"> Posted at: <?php echo($pdate) ?> | <?php echo(substr($ptime,0,5)) ?> </font> </td>
            </tr>
            <tr>
              <td height="65" colspan="3" align="center" valign="middle" style="padding:15px; line-height:180%; border-left:1px solid #DDDDDD; border-right: 1px solid #DDDDDD"><font size="5"><strong><?php echo($subject) ?></strong>
                    <?php 
	if(trim($creator)==trim($uname)) echo("<div align=center style='background-color:; padding-left:10px; display:inline'><a href=EditForum.php?foid=$foid class=one><font color=#999999><strong><u>+ Edit</u></strong></font></a></div>"); ?>
              </font> </td>
            </tr>
            <tr>
              <td height="93" colspan="3" align="left" valign="top" style="padding:15px; line-height:180%; border-left:1px #DDDDDD solid; border-right:1px #DDDDDD solid; font-size:16px"><?php
					echo nl2br($descrip);
				?>              </td>
            </tr>
          </table>
          
      </div>
<div style="width:600; border:8px #DDDDDD solid; margin-top:30; margin-bottom:30; padding-bottom:30; padding-top:30; font-size:16px; font-weight:bold" align="center"> To reply to this post or to view more info, please:
  <p style="margin-top:30"/></p>
  <div style="border:1 #999999 solid; display:inline; padding-left:10; padding-right:10; padding-bottom:5; padding-top:5; height:10; background-image:url(img/master.png); font-weight:normal"> <a href="rockinus_relogin.php" class="one">Sign In</a> </div>
    <p style="margin-top:15"> </p>
  <div style=" margin-top:0; margin-bottom:0; border:0 #999999 solid; display:inline; padding-left:10; padding-right:10; padding-bottom:5; padding-top:5; height:10;">Or </div>
    <p style="margin-top:15"> </p>
  <div style="border:1 #999999 solid; display:inline; padding-left:10; padding-right:10; padding-bottom:5; padding-top:5; height:10; background-image:url(img/master.png); font-weight:normal"> <a href="joinus.php" class="one">Become a Member</a> </div>
</div></td>
    </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
</body>
</html>
