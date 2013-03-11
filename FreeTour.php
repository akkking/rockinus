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

  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="1024" align="left" valign="top" style=" border-right:#DDDDDD solid 0;border-left:#DDDDDD solid 0;">	  
	  <table width="1024" height="35" border="0" cellpadding="0" cellspacing="0" style="border:#DDDDDD solid 0;" bgcolor="#EEEEEE">
        <tr>
          <td height="27" align="right" style="border-right: 0px solid black; padding-right:15">&nbsp;</td>
          <td align="right" valign="middle" style="border-right: 0px solid black; padding-right:15;">&nbsp;</td>
          <td align="right" valign="middle" style="border-right: 0px dotted #999999; padding-right:15px;">
		 <font color="#000000" size="4">
              <?php
$sel_cond = " 1=1";

$navi_type = "All Types";
$navi_city = "All Areas";
$navi_rate = "All Rates";

if( !isset($_GET["type"]) && !isset($_GET["city"]) && !isset($_GET["rate"]) ){
	unset($_SESSION["type"]);
	unset($_SESSION["city"]);
	unset($_SESSION["rate"]);
}

if( isset($_GET["type"]) && ($_GET["type"]=="All") ){
	$navi_type = "All Types";
	if(isset($_SESSION["type"]))unset($_SESSION["type"]);
}else if( isset($_GET["type"]) && ($_GET["type"]!="All") ){
	$_SESSION["type"]=$_GET["type"];
	$navi_type = $_SESSION["type"];
	$sel_cond.= " AND type='".$_GET['type']."'";
}else if( isset($_SESSION["type"]) && ($_SESSION["type"]!="All") ){
	$sel_cond.= " AND type='".$_SESSION["type"]."'";
	$navi_type = $_SESSION["type"];
}else $navi_type = "All Types";

if( isset($_GET["city"]) && ($_GET["city"]=="All") ){
	$navi_city = "All Areas";
	if(isset($_SESSION["city"]))unset($_SESSION["city"]);
}else if( isset($_GET["city"]) && ($_GET["city"]!="All") ){
	$_SESSION["city"]=$_GET["city"];
	$navi_city = $_SESSION["city"];
	$sel_cond.= " AND city='".$_GET["city"]."'";	
}else if( isset($_SESSION["city"]) && ($_SESSION["city"]!="All") ){
	$sel_cond.= " AND city='".$_SESSION["city"]."'";
	$navi_city = $_SESSION["city"];
}else $navi_city = "All Areas";

if( isset($_GET["rate"]) && ($_GET["rate"]=="All") ){
	$navi_rate = "All Rates";
	if(isset($_SESSION["rate"]))unset($_SESSION["rate"]);
}else if( isset($_GET["rate"]) && ($_GET["rate"]!="All") ){
	$_SESSION["rate"]=$_GET["rate"];
	if($_SESSION["rate"]==300) $navi_rate = "$0 - 300";
	else if($_SESSION["rate"]==400) $navi_rate = "$300 - 400";
	else if($_SESSION["rate"]==500) $navi_rate = "$400 - 500";
	else if($_SESSION["rate"]==600) $navi_rate = "$500 - 600";
	else if($_SESSION["rate"]==1000) $navi_rate = "$600 - 1000";
	else $navi_rate = ">1000";
	$sel_cond.= " AND rate<".$_GET["rate"];
}else if( isset($_SESSION["rate"]) && ($_SESSION["rate"]!="All")){
	$sel_cond.= " AND rate<".$_SESSION["rate"];
	if($_SESSION["rate"]==300) $navi_rate = "$0 - 300";
	else if($_SESSION["rate"]==400) $navi_rate = "$300 - 400";
	else if($_SESSION["rate"]==500) $navi_rate = "$400 - 500";
	else if($_SESSION["rate"]==600) $navi_rate = "$500 - 600";
	else if($_SESSION["rate"]==1000) $navi_rate = "$600 - 1000";
}else $navi_rate = "All Rates";


//Global Variable: 
$page_name = "HouseRental.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
 
//**EDIT TO YOUR TABLE NAME, ETC.
$q = "SELECT count(*) as cnt FROM rockinus.house_info WHERE $sel_cond ORDER BY pdate,ptime DESC";
//echo("SELECT count(*) as cnt FROM rockinus.house_info WHERE $sel_cond ORDER BY pdate,ptime DESC");
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
//if ($total_items == 0 )echo("<font color=white><strong>No House Info found.</strong></font>");

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
	echo("<a class='one' href=$page_name?limit=$limit&page=$a> <strong><font color=#000000>$a</font></strong> </a>   ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo("  <a class='one' href=$page_name?limit=$limit&page=$next_page><font color=#000000>Next</font></a>");
}
//if ($total_items != 0 )echo " ...";
?>
          </font></td>
        </tr>
      </table>
	  </div>
        <div style="width:1024px;">
          <table width="1024" height="45" border="0" cellpadding="0" cellspacing="0" bgcolor="" style=" margin-bottom:0px; border-bottom:5px solid #EEEEEE">
            <tr>
              <td width="855" height="30" valign="middle"align="left" style="padding-left:15"><?php echo($navi_type)?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="img/RightArrow.jpg" width="12" height="12" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo($navi_city)?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="img/RightArrow.jpg" width="12" height="12" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo($navi_rate)?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td width="169" valign="middle" align="right" style="padding-right:15px"><font color="#990000"><strong><?php echo($total_items)?></strong></font>&nbsp; items in total</td>
            </tr>
          </table>
          <?php
		//query: **EDIT TO YOUR TABLE NAME, ETC.
		$q = mysql_query("SELECT * FROM rockinus.house_info WHERE $sel_cond ORDER BY hid DESC LIMIT $set_limit, $limit");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		
		if ($no_row == 0)echo("<div style='background-color:#EEEEEE;width:875px; padding-top:50px;padding-bottom:50px' align='center'><font color=black size=3><strong>No house info found.<p> <a href='PostRental.php' class='one'>>> <font color=#B92828>Click to Post</font></a> </strong></font></div>");
		
		while($object = mysql_fetch_object($q)){
			$hid = $object->hid;
			$subject = $object->subject;
			$type = $object->type;
			$rentlease = $object->rentlease;
			$state = $object->state;
			$city = $object->city;
			$email = $object->email;
			$rate = $object->rate;
			$uname = $object->uname;
			$description = $object->descrip;
			$duration = $object->duration;
			if($duration==30)$duration="1 Month";
else if($duration==7)$duration="1 Week";
else if($duration==91)$duration="3 Months";
else if($duration==182)$duration="6 Months";
else $duration="1 Year";
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			?>
          <table width="1024" align="center" cellpadding="0" cellspacing="0" style="margin-bottom:0; padding:5; border-bottom:1px #DDDDDD solid" onmouseover="this.style.backgroundColor = '#F5F5F5';this.style.borderColor = '#DDDDDD';" onmouseout="this.style.backgroundColor = 'white';this.style.borderColor = '#DDDDDD';">
            <tr>
              <td width="105" height="130">
			  <div align="center" style="padding:5">
                  <?php 
			$target = "upload/h".$hid;
			if(is_dir($target)){
				echo("<a href='HouseDetail.php?hid=$hid' class='one'><img src=upload/h$hid/1_100.jpg style=border:0></a>");
			}else 				  		
				echo("<img src=img/NoHouse100_gray.jpg style=border:0>");
			?>
              </div>
			  </td>
              <td width="718" colspan="2" valign="top"><table width="910" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px">
                  <tr>
                    <td width="780" height="35" valign="middle" style="padding-left:20; padding-top:5">
					<?php echo("<a class='one' href='HouseDetail.php?hid=$hid'><strong><font size=3>$subject</font></strong></a>")?>					</td>
                    <td width="130" valign="middle"><font size="3"><?php echo("$city")?></font></td>
                  </tr>
                </table>
                  <table width="910" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="780" height="35" valign="middle" style="padding-left:20">
					  <?php echo("<strong><font color=#CC3300 size=3>[$rentlease]</strong> <font color=black>$type</font></font>")?>					  </td>
                      <td width="130" valign="middle"><font size="3">$ <?php echo("$rate")?> /Month</font></td>
                    </tr>
                </table>
                <table width="910" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="780" height="35" valign="middle"  style="padding-left:20"><font size="3"><?php echo("$pdate")?></font> <font color="#CCCCCC" size="3"> Posted</font> </td>
                      <td width="130" valign="middle"><?php echo("$duration")?></td>
                    </tr>
                </table></td>
            </tr>
          </table>
          <?php } ?>
      </div></td>
    </tr>
</table>
<?php include("bottomMenuEN_login.php"); ?>
</body>
</html>
