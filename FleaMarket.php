<?php 
include 'mainHeader.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];
 ?>
<style>
#FleaDiv {
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
    curvyCorners(settings, "#FleaDiv");
}
</script>
<div align="center">
  <table width="1024" height="231" border="0" cellpadding="0" cellspacing="0" style="padding-top:0; margin-top:0px" bgcolor="#FFFFFF">
    <tr>
      <td width="300" align="left" valign="top" style="padding-left:<?php if(contains("Chrome",$ua['name']))echo("15px"); else echo("15"); ?>; padding-top:15px">
	  <?php include("leftHomeMarketMenu.php"); ?>
	  <br />
	  <br />
	  </td>
      <td width="760" align="left" valign="top" style=" padding-top:15px">
	  <table width="740" height="56" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-top:1px solid #DDDDDD; border-bottom:1px solid #DDDDDD; margin-bottom:15">
	    <tr><td width="514" align="left" valign="top" style=" font-size:14px; padding-left:15; padding-top:10; border-bottom:0px solid #CCCCCC; font-weight:bold; color:<?php echo($_SESSION['hcolor']) ?>"><img src="img/rightTriangleIcon.jpg" width="10" />&nbsp;&nbsp;&nbsp;Select filter
	  </td>
	      <td width="226" align="right" valign="top" style="padding-right:15; padding-top:10; font-size:14px; font-weight:bold">
		  	  <a href="PostFlea.php" style="font-size:14px; font-family:Arial, Helvetica, sans-serif" class="one">
			  + Publish</a>
		  </td>
	    </tr>
	    <tr>
	      <td height="22" colspan="2" align="left" valign="top" style=" font-size:14px; padding-left:; padding-top:5; border-bottom:0px solid #CCCCCC; font-weight:bold; color:<?php echo($_SESSION['hcolor']) ?>">
		  <form method="post" action="FleaMarket.php" id="delivery_form" name="delivery_form">
		    <table width="740" height="30" border="0" cellpadding="0" cellspacing="0" style=" margin-bottom:0; border:0px solid #DDDDDD; border-top:0px">
              <tr>
                <td width="514" height="25" align="left" style="padding-left:15; font-size:12px; font-family:Arial, Helvetica, sans-serif; padding-bottom:8;"> Delivery
                  <select name="delivery" onchange="document.delivery_form.submit()" style=" font-size:12px; font-family:Arial, Helvetica, sans-serif">
                      <option value="A" selected="selected">Both</option>
                      <option value="Y">Yes</option>
                      <option value="N">No</option>
                    </select>
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  About
                  <select name="buysale" onchange="document.delivery_form.submit()" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
                          <option value="All" selected="selected">Buy &amp; Sell</option>
                          <option value="sale">Sell</option>
                          <option value="buy">Buy</option>
                    </select>
                  &nbsp;&nbsp;&nbsp;&nbsp;			
                  Condition
                  <select name="quality" onchange="document.delivery_form.submit()" style=" font-size:12px; font-family:Arial, Helvetica, sans-serif">
                          <option value="All" selected="selected">All</option>
                          <option value="Brand New">Brand New</option>
                          <option value="Like New">Like New</option>
                          <option value="Good">Good</option>
                          <option value="Acceptable">Acceptable</option>
                          <option value="Broken">Broken</option>
                    </select>
                </td>
                <td width="226" height="25" align="right" valign="middle" style="padding-right:20; font-size:13px; font-family:Arial, Helvetica, sans-serif"><?php
$sel_cond = " 1=1";

$navi_type = "All Types";
$navi_city = "All Areas";
$navi_aname = "All Names";

if( !isset($_GET["type"]) && !isset($_GET["city"]) && !isset($_GET["aname"]) ){
	unset($_SESSION["type"]);
	unset($_SESSION["city"]);
	unset($_SESSION["aname"]);
}

if( isset($_GET["type"]) && ($_GET["type"]=="All") ){
	$navi_type = "All Types";
	if(isset($_SESSION["type"]))unset($_SESSION["type"]);
}else if( isset($_GET["type"]) && ($_GET["type"]!="All") ){
	unset($_SESSION["aname"]);
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

if( isset($_GET["aname"]) && ($_GET["aname"]=="All") ){
	$navi_aname = "All Names";
	if(isset($_SESSION["aname"]))unset($_SESSION["aname"]);
}else if( isset($_GET["aname"]) && ($_GET["aname"]!="All") ){
	unset($_SESSION["type"]);
	$_SESSION["aname"] = $_GET["aname"];
	$navi_aname = $_SESSION["aname"];
	$sel_cond.= " AND aname='".$_GET["aname"]."'";	
}else if( isset($_SESSION["aname"]) && ($_SESSION["aname"]!="All") ){
	$sel_cond.= " AND aname='".$_SESSION["aname"]."'";
	$navi_aname = $_SESSION["aname"];
}else $navi_aname = "All Names";

if(isset($_POST['delivery']) && $_POST['delivery']!="A" ) $sel_cond.= " AND delivery='". $_POST['delivery']."'";
if(isset($_POST['buysale']) && $_POST['buysale']!="All" ) $sel_cond.= " AND buysale='". $_POST['buysale']."'";
if(isset($_POST['quality']) && $_POST['quality']!="All" ) $sel_cond.= " AND quality='". $_POST['quality']."'";

$page_name = "FleaMarket.php";

include 'dbconnect.php';
 
$q = "SELECT count(*) as cnt FROM rockinus.article_info WHERE $sel_cond ORDER BY pdate,ptime DESC";
//echo($q);
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

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
if ($total_items != 0 )echo "<font color=black>Page</font> ";
//prev. page
$prev_page = $page - 1;
if($prev_page >= 1) { 
	echo("<a class='one' href=$page_name?limit=$limit&page=$prev_page class=one>Previous</a>");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo(" <strong><font color=black>$a</font></strong> "); //no link
}else{ 
	echo("<a class='one' href=$page_name?limit=$limit&page=$a class=one> <strong>$a</strong></a>   ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo(" <a class='one' href=$page_name?limit=$limit&page=$next_page class=one>Next</a>");
}
if ($total_items != 0 )echo "";
?>
                </td>
              </tr>
            </table>
		  </form></td>
        </tr>
	  </table>
	  <table width="740" height="24" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="740" align='left'>
			<table width="740" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #999999; border-top:1px solid #CCCCCC; background:url(img/<?php echo(substr($_SESSION['hcolor'],1,6)."_MenuBar.jpg") ?>)">
                <tr>
                  <td width="225" height="30" valign="middle" align="left" style="padding-left:15px; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#FFFFFF; font-weight:bold"><?php echo($navi_type)?>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;<?php echo($navi_city)?>&nbsp;&nbsp;&nbsp;</td>
                  <td width="225" valign="middle" align="left" style="padding-left:15px; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#FFFFFF; font-weight:bold">&nbsp;</td>
                  <td width="290" valign="middle" align="right" style="padding-right:10px; font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#FFFFFF"><?php echo($total_items)?>&nbsp;items found</td>
                </tr>
              </table>
                <?php
		$q = mysql_query("SELECT * FROM rockinus.article_info WHERE $sel_cond ORDER BY aid DESC LIMIT $set_limit, $limit");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		
		if ($no_row == 0)echo("<br><div style='background-color:#FFFFFF; border: 1 dashed #DDDDDD; width:730px; padding-top:50px; padding-bottom:50px; line-height:200%' align='center'><font color=black size=4><strong>No sales items found with your search<p> <a href='PostFlea.php' class='one'>>> <font color=#B92828>Post a New sale</font></a> </strong></font></div>");
		
		while($object = mysql_fetch_object($q)){
			$aid = $object->aid;
			$subject = $object->subject;
			$subject = str_replace("\\","",$subject);
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
			$delivery = $object->delivery;
			$rstatus = $object->rstatus;
			$description = $object->descrip;
			$description = str_replace("\\","",$description);
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			
			if($delivery=='Y')$delivery="Can bring";
			else $delivery="Self take"
			?>
                <div>
				<table width="740" border="0" align="" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor = '#F5F5F5'; this.style.borderColor = '#DDDDDD';" onmouseout="this.style.backgroundColor = 'white';this.style.borderColor = '#DDDDDD';" style="padding-top:0; padding-bottom:0; border-bottom:1px #DDDDDD dotted">
                  <tr>
                    <td width="90" height="80" align="left" style="padding:5; padding-left:0" valign="top">
                        <div align="left" style="padding:5">
                  <?php 
			$target = "upload/a".$aid;
			if(is_dir($target)){
				echo("<a href='ArticleDetail.php?aid=$aid' class='one'><img src=upload/a$aid/1_100.jpg width=75 style=border:0></a>");
			}else 				  		
				echo("<img src=img/noarticle_gray100.jpg width=75 style=border:0>");
			?>
              </div>
                    </td>
                    <td width="650" colspan="2" valign="to()p"><table width="630" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="520" height="25" valign="top" style="padding-left:5; padding-top:5; font-size:16px; font-family: Arial, Helvetica, sans-serif">
							<a class="one" href="ArticleDetail.php?aid=<?php echo($aid) ?>">
							<? echo("<font color=$_SESSION[hcolor]>$subject</font>") ?>							</a>							</td>
                          <td width="110" valign="middle" align="right" style="padding-right:0; padding-top:5; font-family:Arial, Helvetica, sans-serif; font-weight:; font-size:16px">
						  <?php 
	if(trim($rstatus)=='Y'){
		echo("<font color=#336633>Available</font>");
	}else 
		echo("<font color=#B92828>Expired</font>") ?>						  </td>
                        </tr>
                      </table>
                        <table width="630" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="520" height="25" valign="top" style="padding-left:5; padding-top:5; font-size:13px">
							<?php echo("<font color=#CC3300>$buysale</font> | <a href=FleaMarket.php?aname=$aname><font color=#333333>$aname</font></a> | $delivery")?>							</td>
                            <td width="110" valign="middle" align="right" style="font-size:16px">
							$ <?php echo("$rate")?></td>
                          </tr>
                      </table>
                      <table width="630" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="520" height="25" valign="middle" style="padding-left:5; font-size:13px"><?php echo(getDateName($pdate))?> <font color="#999999"> Posted</font> </span></td>
                            <td width="110" height="25" valign="top" align="right" style="padding-right:0; padding-top:2; font-size:16px; font-family:Arial, Helvetica, sans-serif">
                              <?php echo("$city")?>	</td>
                          </tr>
                    </table></td>
                  </tr>
              </table>
			  </div>
              <?php } ?>
            </td>
          </tr>
      </table></td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
