<?php include("Header.php"); ?>
<style type="text/css">
<!--
.STYLE1 {
	color: #FFFFFF;
	font-weight: bold;
}
.STYLE2 {color: #FFFFFF}
-->
</style>
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" style="padding-top:-5; margin-top:-1;" bgcolor="#FFFFFF">
    <tr>
      <td width="136" align="left" valign="top" style="padding-left:15px">
	  <?php include("leftMenuFriendGroup".$_SESSION['lan'].".php"); ?>
	  <br /><br /></td>
      <td width="876" align="left" valign="top" style=" border-left:#DDDDDD solid 1;border-right:#DDDDDD solid 1;">
	  <table width="876" height="430" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="35" colspan="2" valign="top" align="left">
              <table width="875" height="35" align="left" cellpadding="0" cellspacing="0" background="<?php echo($_SESSION['hcolor']) ?>" bgcolor="<?php echo($_SESSION['hcolor']) ?>" style="margin-bottom:0px; border-top: 0px #CCCCCC dotted; border-bottom:0px #CCCCCC solid; border-right:1px solid #EEEEEE">
                <tr>
                  <td width="82" height="30" align="right" style="padding-right:15px;"> <strong><font color="#FFFFFF">Category </font></strong></td>
                  <td width="133"><select name="select" class="school" id="select" onchange="document.schoolme.submit()">
                      <option value="all" selected="selected">All Results</option>
                      <option value="hometown">Hometown</option>
                      <option value="course">Course</option>
                      <option value="major">Major</option>
                      <option value="school">School</option>
                  </select>                  
				  </td>
                  <form action="FriendGroup.php" method="post" style="margin:0; padding:0">
                    <td width="70" align="right" style="padding-right:15px"><strong><font color="#FFFFFF">Name</font></strong></td>
                    <td width="132"><span class="STYLE2">
                    <input type="text" name="FindName2" size="12" class="box" maxlength="15" />
                    <input type="hidden" name="pagename2" value="FindGroup.php" />
                    </span></td>
                    <td width="64"><div align="center" class="STYLE2">
                        <input name="submit2" type="submit" class="btn" value="Search" />
                    </div></td>
                  </form>
                  <td width="392"><div align="right" class="STYLE2"><span style="padding-left:10; padding-top:0; margin-top:0; padding-bottom:0; padding-right:0; border-top-style: dotted; border-top-width:0">
                    <?php
//Global Variable: 
$page_name = "FriendGroup.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

$q = "SELECT count(*) as cnt FROM rockinus.rocker_rel_info WHERE (sender='$uname' OR recipient='$uname') AND rstatus='A'";
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items == 0 )die("No matches met your criteria.");
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
echo "Page ";
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
echo "";
?>
                  </span></span>&nbsp;&nbsp;&nbsp;</div></td>
                </tr>
            </table>		    
			</td></tr>
			  <tr><td width="682" valign="top">
              <?php
//query: **EDIT TO YOUR TABLE NAME, ETC.
$q = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE (sender='$uname' OR recipient='$uname') AND rstatus='A' ORDER BY pdate DESC LIMIT $set_limit, $limit");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("<br><center><strong><font color=red>You have no friend connected. &nbsp;&nbsp;&nbsp;&nbsp;</font></strong></center>");
while($obj = mysql_fetch_object($q)){
	$sender = $obj->sender;
	$recipient = $obj->recipient;
	$loopName=$sender;
	if($sender==$uname)$loopName=$recipient;

	$q1 = mysql_query("SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_edu_info b INNER JOIN rockinus.user_contact_info c ON a.uname='$loopName' AND a.uname=b.uname");
	if(!$q1) die(mysql_error());
	$object = mysql_fetch_object($q1);
	$loopName = $object->uname;
	$pic100_Name = $loopName.'100.jpg';
	$fname = $object->fname;
	$cschool = $object->cschool;
	$sid = $cschool;
	$cmajor = $object->cmajor;
	$cdegree = $object->cdegree;
	if($cdegree=='G')$cdegree='Master Student';
	else if($cdegree=='P')$cdegree='P.H.D.';
	else if($cdegree=='U')$cdegree='Undergraduate';
	else $cdegree='Certificate Student';
	$ccity = $object->ccity;
	$cstate = $object->cstate;
	
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
              <table width="662" border="0" align="center" cellpadding="0" cellspacing="0" style="border-bottom:1 #CCCCCC dotted; margin-bottom:10; margin-top:10px; margin-right:10px; margin-left:10px; padding-top:3">
                <tr>
                  <td width="110"><div align="center" style="padding-top:5; padding-bottom:5"> <?php echo("<a href='RockerDetail.php?uid=$loopName' class='one'><img src=upload/$loopName/$pic100_Name style=border:0></a>")?> </div></td>
                  <td colspan="2" valign="top"><table width="550" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="492" height="25" valign="middle">&nbsp;&nbsp;&nbsp;<span class="STYLE20 STYLE12"><strong><?php echo("<a href='RockerDetail.php?uid=$loopName' class='one'>$loopName</a>")?> </strong> - <?php echo($ccity) ?>, <?php echo($cstate) ?> </span></td>
                        <td width="65" valign="middle"><a href="SendMessage.php?recipient=<?php echo($recipient) ?>" class="one">Message</a></td>
                      </tr>
                    </table>
                      <table width="550" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="492" height="25" valign="middle">&nbsp;&nbsp;&nbsp;<span class="STYLE12"><?php echo($cdegree) ?> | <?php echo($cschool) ?> </span></td>
                          <td width="65" valign="middle"><a href="RemoveFriend.php?recipient=<?php echo($recipient) ?>" class="one">Remove</a></td>
                        </tr>
                      </table>
                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="492" height="25" valign="middle">&nbsp;&nbsp;&nbsp;<span class="STYLE12"><?php echo($cmajor) ?> | 2010 Fall </span></td>
                          <td width="65" valign="middle">&nbsp;</td>
                        </tr>
                    </table>
                    <table width="550" height="35" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="485" height="25" valign="middle"><div style=" width:460; color:<?php echo($fontcolor) ?>; margin-left:11; line-height:180%">
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
            <?php } ?>
			</td>
                <td width="221" valign="top" bgcolor="#F5F5F5">&nbsp;</td>
		  </tr>
        </table>
      </td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
