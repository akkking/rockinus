<?php include("ValidCheck.php"); ?>
<html>
<head>
<title>Rock In U.S.</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div align="center">
  <div style="margin-bottom: 15; margin-top: 8; margin-left:0" align="center">
    <table width="1024" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="205" rowspan="3"><a href="main.php"><img src="img/rockinus_logo.jpg" border="0"></a></td>
        <td width="743">&nbsp;</td>
        <td width="76"><div align="center" class="STYLE12" style="margin-left:12; width:66; background-color:#EEEEEE; border-bottom: 1px dotted #CCCCCC;">
		<?php 
		$uname = $_SESSION['usrname']; 
 		if($_SESSION['usrname']=="")echo(Login);
		else echo "Hi, $uname";
	?>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="center" style="width:50; background-color:#EEEEEE; margin-left:12; border-bottom: 1px dotted #CCCCCC;"> <a href="logoff.php" class="one STYLE12">Log Out</a></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div>
  <div style="margin-bottom: 4; margin-top: 4">
<div align="center" style="background:#336633; padding-top:10px; padding-bottom:10px" >
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#336633" height="16">
    <tr>
      <td width="170" valign="middle"><div align="center"><a href="ThingsRock.php">Things Rock You</a> </div></td>
      <td width="170" valign="middle"><div align="center"><a href="#">Buy-Sale-Rent-Lease </a></div></td>
      <td width="170" valign="middle"><div align="center"><a href="SchoolCourse.php">Schools &amp; Courses </a> </div></td>
      <td width="170" valign="middle"><div align="center"><a href="FriendGroup.php">Friends &amp; Groups</a>  </div></td>
      <td width="170" valign="middle"><div align="center"><a href="MessageList.php">Message &amp; Profile</a> </div></td>
      <td width="170" valign="middle"><div align="center"><a href="#">Wisdom Corner </a> </div></td>
    </tr>
  </table>
</div>
  </div>
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" style="padding-top:-5; margin-top:5;">
    <tr>
      <td width="128" align="left" valign="top" style="border-right: 1px solid #EEEEEE; padding-right:0; width:10">
	  <form action="login_process.php" method="post">
          <div style="margin-top: 0; margin-bottom: 0; margin-left:10; margin-right: 0" align="center">
            <table width="127" height="84" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="22"><span class="STYLE8"><div style="border-bottom: 1px dotted #999999; padding-right:0; width:80; padding-bottom:4"><a href="HouseRental.php" class="one"> House Rental </a></div></span></td>
              </tr>
              <tr>
                <td height="20" style="padding-top:5">Rent</td>
              </tr>
              <tr>
                <td height="20" style="padding-top:0">Lease</td>
              </tr>
            </table>
		  </div>
			<div style="margin-top: 25; margin-bottom: 0; margin-left:10; margin-right: 0" align="center">
            <table width="124" height="86" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="22"><span class="STYLE8"><div style="border-bottom: 1px dotted #999999; padding-right:0; width:72; padding-bottom:4"> <a href="FleaMarket.php" class="one">Flea Market</a> </div></span></td>
              </tr>
              <tr>
                <td height="25" style="padding-top:5">Purchase</td>
              </tr>
              <tr>
                <td height="25" style="padding-top:0">Sale</td>
              </tr>
            </table>
          </div>
      </form>
	  </td>
      <td width="860" align="left" valign="top" style=" border:#CCCCCC solid 0; padding-left:3;">
	  <table width="864" height="96" border="0" cellpadding="0" cellspacing="0" style="border:#CCCCCC dotted 0; margin-bottom:3">
        <tr>
          <td width="86" align="center" valign="middle" style="border-right: 0px solid black; padding-right:0;" ><img src="img/category.jpg" width="80" height="28"></td>
          <td width="105" height="27" align="left" valign="middle" style="border-right: 0px solid black; padding-right:0; padding-left:10" ><span class="STYLE25 STYLE83">Single Room </span></td>
          <td width="85" align="left" valign="middle" style="border-right: 0px solid black; padding-right:0; padding-left:10"><span class="STYLE25 STYLE83">Apartment</span></td>
          <td width="118" align="left" valign="middle" style="border-right: 0px solid black; padding-right:0; padding-left:15"><span class="STYLE25 STYLE83">Room Shared </span></td>
          <td width="72" align="left" valign="middle" style="border-right: 0px solid black; padding-right:0; padding-left:10"><span class="STYLE25 STYLE83">Studio</span></td>
          <td width="96" align="left" valign="middle" style="border-right: 0px solid black; padding-right:0; padding-left:5"><span class="STYLE25 STYLE83">House</span></td>
          <td width="98" align="left" valign="middle" style="border-right: 0px solid black; padding-right:0; padding-left:10"><span class="STYLE25 STYLE83">Others </span></td>
          <td width="65" align="left" valign="middle" style="border-right: 0px dotted #999999; padding-right:0;padding-left:12">&nbsp;</td>
          <td width="139" align="left" valign="middle" style="border-right: 0px dotted #999999; padding-right:0;"><div align="right">
              <div align="center" class="STYLE23" style="border:1 solid #EEEEEE; background-color: #336633; padding-bottom:5; padding-top:5; margin-top:3; width:120"><a href="PostRental.php">I wanna lease </a></div>
          </div></td>
        </tr>
        <tr>
          <td align="center" valign="middle" style="border-right: 0px solid black; padding-right:0;" ><img src="img/category.jpg" width="80" height="28"></td>
          <td height="29" align="left" valign="middle" style="border-right: 0px solid black; padding-right:0; padding-left:10" ><span class="STYLE89">Brooklyn</span></td>
          <td align="left" valign="middle" style="border-right: 0px solid black; padding-right:0; padding-left:10"><span class="STYLE89">Manhattan</span></td>
		    <td align="left" valign="middle" style="border-right: 0px solid black; padding-right:0; padding-left:15"><span class="STYLE89">Queens</span></td>
          <td align="left" valign="middle" style="border-right: 0px solid black; padding-right:0; padding-left:10"><span class="STYLE89">Bronx</span></td>
          <td align="left" valign="middle" style="border-right: 0px solid black; padding-right:0; padding-left:5"><span class="STYLE89">Long Island </span></td>
          <td align="left" valign="middle" style="border-right: 0px solid black; padding-right:0; padding-left:10">&nbsp;</td>
          <td align="left" valign="middle" style="border-right: 0px dotted #999999; padding-right:0; "><span class="STYLE86"></span></td>
          <td width="139" align="center" valign="middle" style="border-right: 0px dotted #999999; padding-right:0;">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="middle" style="border-right: 0px solid black; padding-right:0;" >  <strong>Country</strong>
          <td height="33" align="left" valign="middle" style="border-right: 0px solid black; padding-right:0; padding-left:10" ><select name="country">
              <option value="All"  selected="yes">All</option>
			  <option value="India">India</option>
              <option value="China">China</option>
          </select></td>
          <td height="33" align="left" valign="middle" style="border-right: 0px solid black; padding-right:0; padding-left:0" ><div align="center"><strong>Rate Scale </strong></div></td>
          <td align="center" valign="middle" style="border-right: 0px solid black; padding-right:0; padding-left:0">
		  <span style="border-right: 0px solid black; padding-right:0; padding-left:0 ">
            <select name="rate">
			   <option value="all" selected="selected">All</option>
              <option value="300">0-$300</option>
              <option value="400">$300-$400</option>
              <option value="500">$400-$500</option>
              <option value="600">$500-$600</option>
			  <option value="1000">$600-$1000</option>
			  <option value="1000">>$1000</option>
            </select>
          </span></td>
          <td align="center" valign="middle" style="border-right: 0px solid black; padding-right:0; ">&nbsp;</td>
          <td align="center" valign="middle" style="border-right: 0px solid black; padding-right:0; ">&nbsp;</td>
          <td align="center" valign="middle" style="border-right: 0px solid black; padding-right:0; ">&nbsp;</td>
          <td align="center" valign="middle" style="border-right: 0px dotted #999999; padding-right:0; ">&nbsp;</td>
          <td align="center" valign="middle" style="border-right: 0px dotted #999999; padding-right:0;">
		  <div align="right">
            <?php
//Global Variable: 
$page_name = "HouseRental.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
 
//**EDIT TO YOUR TABLE NAME, ETC.
$q = "SELECT count(*) as cnt FROM rockinus.house_info ORDER BY pdate,ptime DESC";
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items == 0 )die("No matches met your criteria.");
//echo "Total Number: $total_items &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//echo "<br/>";
$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 15;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
//echo "This is Page Number: " . $page . "<br/>";
//echo "Current Limit: ". $limit. "<br/>";
//Set defaults if: $limit is empty, non numerical,
//less than 10, greater than 50
if((!$limit) || (is_numeric($limit) == false)|| ($limit < 15) || ($limit > 50)) {
	$limit = 1; //default
}
 
//Set defaults if: $page is empty, non numerical,
//less than zero, greater than total available
if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items)) { 
	$page = 1; //default 
}
 
//calculate total pages
$total_pages = ceil($total_items / $limit);
$set_limit = ($page * $limit) - $limit;
//echo "Total Pages: $total_pages <br/>";
echo "... ";
//prev. page
$prev_page = $page - 1;
if($prev_page >= 1) { 
	echo("<a class='one' href=$page_name?limit=$limit&page=$prev_page>Previous</a>");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo(" <strong>$a</strong>  "); //no link
}else{ 
	echo("<a class='one' href=$page_name?limit=$limit&page=$a> <strong>$a</strong> </a>   ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo("  <a class='one' href=$page_name?limit=$limit&page=$next_page>Next</a>");
}
echo " ...";
?>
          </div></td>
        </tr>
      </table>
              <div style="border:0 #CCCCCC solid; width:860; margin-left:5; border-top:#EEEEEE solid 1">
                <table width=870 height="5" border="0" cellpadding="0" cellspacing="0">
                  <tr style="font-weight:600; padding-bottom:2; padding-top:2;" align="center">
                    <td width="152"></td>
					<td width="105"></td>
                    <td width="403"></td>
                    <td width="107"></td>
                    <td width="93"></td>
                  </tr>
	  <?php
		//query: **EDIT TO YOUR TABLE NAME, ETC.
		$q = mysql_query("SELECT * FROM rockinus.house_info ORDER BY pdate,ptime DESC LIMIT $set_limit, $limit");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($no_row == 0) die("No matches met your criteria.");
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
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			?>
			<tr><td style="padding-bottom:5; margin-left:0; margin-right:0; padding-top:10; width:135" align="center"><?php echo("[$rentlease] [$city]")?></td>
			<td style="padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:800" align="center">
			<?php echo("<a class='one' href='HouseDetail.php?hid=$hid'>$subject</a>)")?></td>
			<td style="padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:70" align="center"><?php echo("$uname")?></td>
			<td style="padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:100" align="center"><?php echo("$pdate")?></td>
			</tr>
		<?php } ?>
</table>
<div style="padding-top:5;"></div>
</div>
	  </td>
    </tr>
  </table>
  <p style="border-bottom: 1px dotted #336633; margin-top:-10; margin-left:12; margin-bottom:10; width: 1010"></p>
  </font>
  <div style="font-size:12px">
  <a class="one" href="rockinus_intro.php">About us</a>&nbsp;|&nbsp; Jobs &nbsp;|&nbsp; Advertising&nbsp; |&nbsp; <span class="STYLE7">Give us a feedback.</span></div>
  <div style="margin-bottom:4; margin-top:4; font-size:12px">Copyright &copy; 2011 Rockinus Inc. </div>
</div>
</body>
</html>
