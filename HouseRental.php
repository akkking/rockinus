<?php 
include 'mainHeader.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];

$metro_sel_cond = " 1=1";

if(isset($_POST['metroSubmit'])){
	$metroline = $_POST['metroline'];
	$metrostop = $_POST['metrostop'];
	$metromins = $_POST['metromins'];
	
	if($metroline!="X")
		$metro_sel_cond .= " AND metroline='$metroline'";
	if($metrostop!="empty")
		$metro_sel_cond .= " AND metrostop='$metrostop'";	
	if($metromins!="0")
		$metro_sel_cond .= " AND metromins='$metromins'";	
}
 ?>
<link href="style.css" rel="stylesheet">
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
<script>
function getXMLHTTP() { //fuction to return the xml http object
	var xmlhttp=false;	
	try{
		xmlhttp=new XMLHttpRequest();
	}
	catch(e)	{		
		try{			
			xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e1){
				xmlhttp=false;
			}
		}
	}
		 	
	return xmlhttp;
}
	
function getMetro(strURL)
{         
 var req = getXMLHTTP(); // fuction to get xmlhttp object 
 if (req)
 {
  	req.onreadystatechange = function()
 	{
  		if (req.readyState == 4) { //data is retrieved from server
   			if (req.status == 200) { // which reprents ok status                    
     			document.getElementById('metrostopDiv').innerHTML=req.responseText;
  			}
  			else
  			{ 
     			alert("There was a problem while using XMLHTTP:\n");
  			}
  		}            
  	}        
	req.open("GET", strURL, true); //open url using get method
	req.send(null);
 	}
}

function getCity(strURL)
{         
 var req = getXMLHTTP(); // fuction to get xmlhttp object 
 if (req)
 {
  	req.onreadystatechange = function()
 	{
  		if (req.readyState == 4) { //data is retrieved from server
   			if (req.status == 200) { // which reprents ok status                    
     			document.getElementById('cityDiv').innerHTML=req.responseText;
  			}
  			else
  			{ 
     			alert("There was a problem while using XMLHTTP:\n");
  			}
  		}            
  	}        
	req.open("GET", strURL, true); //open url using get method
	req.send(null);
 	}
}
</script>
 <div align="center" style="width:100%"> 
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="218" align="left" valign="top" style=" padding:15px">
        <?php include("leftHomeHouseMenu.php"); ?>		</td>
      <td width="806" align="left" valign="top" style="padding-top:15px"><table width="740" height="70" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-top:#DDDDDD solid 1px; border-bottom:#DDDDDD solid 1px; margin-bottom:15">
        <tr>
          <td width="536" height="25" align="left" valign="top" style="color:<?php echo($_SESSION['hcolor']);?>; font-size:14px; padding-left:15; padding-top:10; font-family:Arial, Helvetica, sans-serif; font-weight:bold">Search by MTA
		  </td>
          <td height="25" align="right" valign="middle" style=" font-size:14px; font-family:Arial, Helvetica, sans-serif; padding-right:10px; padding-top:10">
            <div align="center" style=" height:17; background:url(img/black_cell_bg.jpg); padding:2 5 2 5; margin-bottom:0; border:1px solid #333333; width:80; font-size:14px; font-family:Arial, Helvetica, sans-serif"><a href="PostRental.php"><strong>+ Publish</strong></a>          </div></td>
        </tr>
        <tr>
          <td height="35" align="left" valign="top" style=" font-size:12px; padding-top:5;  padding-left:15; font-weight:bold">
		  <form action="HouseRental.php" method="post"> 
		  Line&nbsp; <select name="metroline" onchange="getMetro('findMetro.php?lineNo='+this.value)" style="font-size:12px; font-family:Arial, Helvetica, sans-serif">
                <option value="X">Any</option>
                <?php 
						$metro = mysql_query("SELECT lineNo FROM rockinus.metro_info GROUP BY lineNo ASC;");
						if(!$metro) die(mysql_error());
						while($obj_metro = mysql_fetch_object($metro)){
							$lineNo = $obj_metro->lineNo;
						?>
                <option value="<?php echo($lineNo) ?>"><?php echo($lineNo) ?></option>
                <? 
						}
						?>
            </select>
                <div id="metrostopDiv" class="metrostopDiv" style="display:inline">
                      <select name="metrostop" style="padding-right:10px; font-size:12px; font-family:Arial, Helvetica, sans-serif">
                        <option value="empty">Any Stop</option>
                      </select>
            </div>                  
					<select name="metromins" style="font-size:12px; font-family:Arial, Helvetica, sans-serif">
                      <option value="0">Any Mins</option>
                      <option value="5">0~5 Mins</option>
                      <option value="10">5~10 Mins</option>
                      <option value="15">10~15 Mins</option>
                      <option value="20">15~20 Mins</option>
                      <option value="25">20~25 Mins</option>
                      <option value="30">25~30 Mins</option>
          </select>
		  &nbsp; <input type="submit" name="metroSubmit" style="height:20; background-image:url(img/master.png); font-size:12px; padding:2 8 2 8; border:1px solid #999999; color:#000000; cursor:pointer; vertical-align: top" value=" Go " />
		  </form></td>
          <td height="35" align="right" style=" padding-top:10; font-size:12px; padding-bottom:10; font-family: Arial, Helvetica, sans-serif; padding-right:20; font-weight:normal" valign="top">
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

if(isset($_POST['metroSubmit'])) $sel_cond = $metro_sel_cond;

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
if ($total_items != 0 && $page==1 )echo "Page ";
//prev. page
$prev_page = $page - 1;
if($prev_page >= 1) { 
	echo("<a href=$page_name?limit=$limit&page=$prev_page class=one>Last page</a> ");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo(" $a "); //no link
}else{ 
	echo("<a class='one' href=$page_name?limit=$limit&page=$a class=one>$a</a> ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo("  <a class='one' href=$page_name?limit=$limit&page=$next_page class=one>Next</a>");
}
//if ($total_items != 0 )echo " ...";
?></td>
        </tr>
      </table>
        <div style="width:740px;" align="right">
          <table width="740" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #999999; border-top:1px #CCCCCC solid; background:url(img/<?php echo(substr($_SESSION['hcolor'],1,6)."_MenuBar.jpg") ?>)">
            <tr>
              <td width="534" height="30" valign="middle"align="left" style="padding-left:10; font-size:12px; font-family: Arial, Helvetica, sans-serif; color:#FFFFFF; font-weight:bold"><?php echo($navi_type)?>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;<?php echo($navi_city)?>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;<?php echo($navi_rate)?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td width="206" valign="middle" align="right" style="padding-right:10; font-weight:normal; font-size:12px; font-family:Arial, Helvetica, sans-serif; color: #FFFFFF">
			  <?php echo($total_items)?>&nbsp;items found</td>
            </tr>
          </table>
          <?php
		$q = mysql_query("SELECT * FROM rockinus.house_info WHERE $sel_cond ORDER BY hid DESC LIMIT $set_limit, $limit");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		
		if ($no_row == 0)echo("<br><div style='background-color:#FFFFFF; border: 1 dashed #DDDDDD; width:730px; padding-top:50px;padding-bottom:50px' align='center'><font color=black size=4><strong>No house items found with your search<p> <a href='PostRental.php' class='one'>>> <font color=#B92828>Post a New house</font></a> </strong></font></div>");
		
		while($object = mysql_fetch_object($q)){
			$hid = $object->hid;
			$subject = $object->subject;
			$subject = str_replace("\\","",$subject);
			$type = $object->type;
			$rentlease = $object->rentlease;
			$state = $object->state;
			$city = $object->city;
			$email = $object->email;
			$rate = $object->rate;
			$rstatus = $object->rstatus;
			$uname = $object->uname;
			$description = $object->descrip;
			$description = str_replace("\\","",nl2br($description));
			$duration = $object->duration;
			if($duration==30)$duration="1 Month";
else if($duration==7)$duration="1 Week";
else if($duration==91)$duration="3 Months";
else if($duration==182)$duration="6 Months";
else $duration="1 Year";
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			?>
          <div style="padding-top:5; padding-bottom:5; width:740; border-bottom:1px #DDDDDD dotted" onmouseover="this.style.backgroundColor = '#F5F5F5'; this.style.borderColor = '#DDDDDD';" onmouseout="this.style.backgroundColor = 'white';this.style.borderColor = '#DDDDDD';" align="right">
		  <table width="740" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="85" height="80" style="padding-left:5">
                  <?php 
			$target = "upload/h".$hid;
			if(is_dir($target)){
				echo("<a href='HouseDetail.php?hid=$hid' class='one'><img src=upload/h$hid/1_100.jpg width=70 style=border:0></a>");
			}else 				  		
				echo("<a href='HouseDetail.php?hid=$hid'><img src=img/NoHouse100_gray.jpg width=70 style=border:0></a>");
			?>			  </td>
              <td width="653" colspan="2" valign="top"><table width="640" height="20" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="530" height="25" valign="top" style="padding-left:5; padding-bottom:5; padding-top:10; font-size:16px; font-family:Arial, Helvetica, sans-serif">
					<?php echo("<a class='one' href='HouseDetail.php?hid=$hid'><font color=$_SESSION[hcolor]>$subject</font></a>")?>					</td>
                    <td width="110" valign="top" style="font-size:16px; padding-top:10; font-family:Arial, Helvetica, sans-serif; font-weight:" align="right">
					<?php 
	if(trim($rstatus)=='Y'){
		echo("<font color=#336633>Available</font>");
	}else 
		echo("<font color=#B92828>Expired</font>") ?>		</td>
                  </tr>
                </table>
                  <table width="640" height="20" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="530" height="20" valign="top" style="padding-left:5; font-size:13px; font-family:Arial, Helvetica, sans-serif">
					  <?php echo("<font color=#CC3300>$rentlease</font>, $type")?>					  </td>
                      <td width="110" valign="top" style="font-size:16px;" align="right">$<?php echo("$rate")?>/Month</td>
                    </tr>
                </table>
                <table width="640" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="530" height="25" valign="top"  style="padding-left:5; font-size:12px; font-family:Arial, Helvetica, sans-serif; padding-top:2">
					  <?php echo(getDateName($pdate))?> <font color="#999999"> Posted</font> </td>
                      <td width="110" valign="top" style="font-size:16px;" align="right">			  
	<?php echo("$city")?>	</td>
	</tr>
              </table></td>
            </tr>
          </table>
		  </div>
          <?php } ?>
      </div></td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
