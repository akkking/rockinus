<?php include("Header.php"); ?>
<div align="center" style="background-image:url(<?php echo("img/".$_SESSION['topi'].".jpg")?>)">
  <table width="1018" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="130" align="left" valign="top" style="border-right: 1px solid #EEEEEE; padding-left:15px; padding-bottom:20px">
	  <?php include("leftMenuFriendGroup".$_SESSION['lan'].".php"); ?>	  </td>
      <td width="888" align="left" valign="top" style=" border:#CCCCCC solid 0; padding-left:3;">
	  <table width="875" height="500" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="685" valign="top"><div align="right">
              <table width="665" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-bottom:0; border-bottom:0 dotted #CCCCCC">
                <tr>
                  <td width="206" height="26" style="border:#CCCCCC solid 0; border-bottom:0 #CCCCCC solid;">
				  <div align="center" style="display:inline; padding-left:10px; padding-right:10px; background-color:#EEEEEE; padding-bottom:5px; padding-top:15px"><strong>Friend Requst List </strong></div></td>
                  <td width="466"><div align="right"><span style="padding-left:10; padding-top:0; margin-top:0; padding-bottom:0; padding-right:3; border-top-style: dotted; border-top-width:0">
                    <?php
//Global Variable: 
$page_name = "RequestList.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

$q = "SELECT count(*) as cnt FROM rockinus.rocker_rel_info where recipient='$uname' and rstatus='P'";
//$q = "SELECT count(*) as cnt FROM rockinus.rocker_rel_info where sender='$uname' or recipient='$uname' and rstatus='A'";

//**EDIT TO YOUR TABLE NAME, ETC.
//$q = "SELECT count(*) as cnt FROM rockinus.school_info";
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
//if ($total_items == 0 )echo("You have no friend request.");

//echo "Total Number: $total_items &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//echo "<br/>";
$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 10;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
//echo "This is Page Number: " . $page . "<br/>";
//echo "Current Limit: ". $limit. "<br/>";
//Set defaults if: $limit is empty, non numerical,
//less than 10, greater than 50
if((!$limit) || (is_numeric($limit) == false)|| ($limit < 5) || ($limit > 50)) {
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
	echo(" <a class='one' href=$page_name?limit=$limit&page=$next_page>Next</a>");
}
echo " ...";
?>
                  </span>&nbsp;&nbsp;&nbsp;</div></td>
                </tr>
              </table>
              <span style="padding-left:8px; padding-bottom:5; padding-right:5px;">
              <?php
//query: **EDIT TO YOUR TABLE NAME, ETC.
$q = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE recipient='$uname' AND rstatus='P' ORDER BY pdate DESC LIMIT $set_limit, $limit");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("<br><center><strong><font color=red>You have no friend request. &nbsp;&nbsp;&nbsp;&nbsp;</font></strong></center>");
while($object = mysql_fetch_object($q)){
	$sender = $object->sender;
	$ptime = $object->ptime;
	$pdate = $object->pdate;
	
	$q1 = mysql_query("SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_edu_info b INNER JOIN rockinus.user_contact_info ON a.uname='$sender' AND a.uname=b.uname");
	if(!$q1) die(mysql_error());
	$obj1 = mysql_fetch_object($q1);
//	$cschool = $obj1->school_name;
	$loopName = $obj1->uname;
	$pic100_Name = $loopName.'100.jpg';
	$fname = $obj1->fname;
	$cschool = $obj1->cschool;
	$sid = $cschool;
	$cmajor = $obj1->cmajor;
	$cdegree = $obj1->cdegree;
	if($cdegree=='G')$cdegree='Master Student';
	else if($cdegree=='P')$cdegree='P.H.D.';
	else if($cdegree=='U')$cdegree='Undergraduate';
	else $cdegree='Certificate Student';
	$ccity = $obj1->ccity;
	$cstate = $obj1->cstate;
	
	$q1 = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
	if(!$q1) die(mysql_error());
	$obj1 = mysql_fetch_object($q1);
	$cschool = $obj1->school_name;
	
	$q2 = mysql_query("SELECT * FROM rockinus.major_info where mid='$cmajor'");
	//echo("SELECT * FROM rockinus.major_info where mid='$cmajor'");
	if(!$q2) die(mysql_error());
	$obj2 = mysql_fetch_object($q2);
	$cmajor = $obj2->major_name;
	
	$q3 = mysql_query("SELECT * FROM rockinus.memo_info where sender='$loopName' order by memoid DESC");
	if(!$q3) die(mysql_error());
	$obj3 = mysql_fetch_object($q3);
	$descrip = $obj3->descrip;
	if($descrip==NULL){
		$descrip="Nothing Posted...";
		$fontcolor = "#CCCCCC";
	}else $fontcolor = "#336633";
?>
              </span>
              <table width="662" border="0" align="center" cellpadding="0" cellspacing="0" style="border-bottom:1 #EEEEEE dotted; margin-top:15px; margin-right:3; padding-top:3">
                <tr>
                  <td width="110"><div align="center" style="padding-top:5; padding-bottom:5"><?php echo("<a href='RockerDetail.php?uid=$loopName' class='one'><img src=upload/$loopName/$pic100_Name style=border:0></a>")?></div></td>
                  <td colspan="2" valign="top"><table width="550" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="475" height="35" valign="middle">&nbsp;&nbsp;&nbsp;<span class="STYLE20 "><?php echo("<a href='RockerDetail.php?uid=$loopName' class='one'>$loopName</a>")?> - <?php echo($ccity) ?>, <?php echo($cstate) ?> </span></td>
                        <td width="75" valign="middle" style="padding-right:5px">
                          <div align="center" class="STYLE9" style="padding-top: 5px; padding-bottom: 5px; width: 70; background-color:#336633"> <?php echo("<a href=AcceptFriend.php?sender=$loopName> Accept </a>") ?>
                        </div></td>
                      </tr>
                    </table>
                      <table width="550" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="446" height="35" valign="middle">&nbsp;&nbsp;&nbsp;<?php echo($cdegree) ?> @ <?php echo($cschool) ?> </td>
                          <td width="104" height="35" valign="middle">&nbsp;</td>
                        </tr>
                    </table>
                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="446" height="35" valign="middle">&nbsp;&nbsp;&nbsp;<?php echo($cmajor) ?> | 2010 Fall </td>
                          <td width="104" height="35" valign="middle">&nbsp;</td>
                        </tr>
                    </table>
                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="492" height="25" valign="middle" style="padding-bottom:15px">
						  <div style=" width:460; color:<?php echo($fontcolor) ?>; margin-left:11; line-height:180%">
                              <?php
									$len = strlen($descrip);
									$single_line_len = 70;
									$line_no = $len/$single_line_len; 
							
									for($i=0;$i<$line_no;$i++) {
										$str = substr($descrip,$i*$single_line_len, ($i+1)*$single_line_len)."<br>";
										echo $str;
									}?>
                          </div></td>
                          <td width="65" valign="middle">&nbsp;</td>
                        </tr>
                    </table></td>
                </tr>
              </table>
            <?php } ?></td>
            <td width="187" rowspan="2" bgcolor="#EEEEEE" style="border-left: 1px solid #CCCCCC; margin-left:5">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
