<?php include("Header.php"); 

$ua=getBrowser();
  
$pic210_Name = $uname.'210.jpg';
$ProPercent = 70;
		
//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$hcolor = $object->hcolor;

$q = mysql_query("SELECT * FROM rockinus.user_info INNER JOIN rockinus.user_check_info INNER JOIN rockinus.user_edu_info INNER JOIN rockinus.user_contact_info ON user_info.uname='$uname' AND user_info.uname=user_check_info.uname AND user_info.uname=user_edu_info.uname AND user_info.uname=user_contact_info.uname");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;
$fname = $object->fname;
$lname = $object->lname;
$birthdate = $object->birthdate;
$sterm = $object->sterm;
$fregion = $object->fregion;
$fcountry = $object->fcountry;
$email = $object->email;
$cmajor = $object->cmajor;
if(trim($cmajor)=="empty") $cmajor=NULL;
$cschool = $object->cschool;
if(trim($cschool)=="empty") $cschool=NULL;
$cdegree = $object->cdegree;
if(trim($cdegree)=="empty") $cdegree=NULL;
$cstate = $object->cstate;
$ccity = $object->ccity;

if($cschool!=NULL){
	$q = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
	if(!$q) die(mysql_error());
	$obj = mysql_fetch_object($q);
	$cschool = $obj->school_name;
}else $cschool = "Unknown School";

if($cmajor!=NULL){	
	$q = mysql_query("SELECT * FROM rockinus.major_info where mid='$cmajor'");
	if(!$q) die(mysql_error());
	$obj = mysql_fetch_object($q);
	$cmajor = $obj->major_name;
}else $cmajor = "Unknown Major";

if($ccity==NULL || $ccity=="empty" ) $ccity = "Unknown City";
if($cstate==NULL || $cstate=="em" ) $cstate = "Unknown State";
if($cdegree==NULL) $cdegree = "Unknown Diploma";
if($mstatus==NULL) $mstatus = "Unknown Status";

$z = mysql_query("SELECT * FROM rockinus.user_edu_info WHERE uname='$uname'");
if(!$z) die(mysql_error());
$objz = mysql_fetch_object($z);
$cmajor = $objz->cmajor;	

if($cmajor!=NULL && strlen($cmajor)>0){
	$m = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid='$cmajor'");
	if(!$m) die(mysql_error());
	$objm = mysql_fetch_object($m);
	$major_name = $objm->major_name;	
}

$sel_cond = NULL;
if( isset($_POST["category"]) && ($_POST["category"]!="Blank") ){
	$sel_cond.= " AND category='".$_POST["category"]."'";	
	$_SESSION['category'] = $_POST['category'];
}
?>
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td align="left" valign="top" style="padding-left:<?php if(contains("Chrome",$ua['name']))echo("10px"); else echo("10"); ?>; border-right:0px #DDDDDD dashed">
	    <table border="0" cellspacing="0" cellpadding="0" width="874">
        <tr>
          <td align="left" valign="top">
		  <table width="1000" height="59" border="0" cellpadding="0" cellspacing="0" style="border-top:1px #DDDDDD solid;border-bottom:1px #CCCCCC solid;">
            <tr>
              <td height="37" colspan="2" align="left" background="img/black_bg_cell2.jpg" style="padding-left:10px">			  
			  <form action="openForum.php" method="post" id="forum_type" name="forum_type" style="margin-bottom:0">
			  <select name="category" onChange="document.forum_type.submit()">
                <option value="Blank" <?php if(isset($_SESSION['category']) && $_SESSION['category']=="Blank")echo("selected") ?>>Select a Category</option>
                <?php if($cmajor!=NULL && strlen($cmajor)>0){ ?>
				<option value="<?php echo($cmajor) ?>" <?php if(isset($_SESSION['category']) && $_SESSION['category']==$cmajor)echo("selected") ?>><?php echo($major_name) ?></option> <?php } ?>
                <option value="Job" <?php if(isset($_SESSION['category']) && $_SESSION['category']=="Job")echo("selected") ?>>Job/Interview</option>
                <option value="Study" <?php if(isset($_SESSION['category']) && $_SESSION['category']=="Study")echo("selected") ?>>Study | School</option>
                <option value="Language Study" <?php if(isset($_SESSION['category']) && $_SESSION['category']=="Language Study")echo("selected") ?>>Language study</option>
                <option value="Travel" <?php if(isset($_SESSION['category']) && $_SESSION['category']=="Travel")echo("selected") ?>>Travel</option>
                <option value="Suggestion" <?php if(isset($_SESSION['category']) && $_SESSION['category']=="Suggestion")echo("selected") ?>>Site Suggestion</option>
                <option value="Issues" <?php if(isset($_SESSION['category']) && $_SESSION['category']=="Issues")echo("selected") ?>>Site Issue Report</option>
              </select>
			  </form>			  
			  <?php if(isset($_SESSION['category']))unset($_SESSION['category']); ?>			  </td>
              <td height="37" colspan="3" align="right" background="img/black_bg_cell2.jpg" style="padding-right:25px">
			<font color=#FFFFFF size="2">
			<?php			
 //Global Variable: 
$page_name = "openForum.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
 
//**EDIT TO YOUR TABLE NAME, ETC.
$q = "SELECT count(*) as cnt FROM rockinus.forum_info WHERE 1=1 $sel_cond ORDER BY pdate,ptime DESC";
//echo("SELECT count(*) as cnt FROM rockinus.house_info WHERE $sel_cond ORDER BY pdate,ptime DESC");
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items == 0 )echo("<strong>No post so far</strong>");

$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 30;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;

if((!$limit) || (is_numeric($limit) == false)|| ($limit < 30) || ($limit > 50)) {
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
	echo("<a href=$page_name?limit=$limit&page=$prev_page>Previous</a>");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo(" <strong>$a</strong>  "); //no link
}else{ 
	echo("<a href=$page_name?limit=$limit&page=$a> <strong>$a</strong> </a>   ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo("  <a href=$page_name?limit=$limit&page=$next_page>Next</a>");
}
//if ($total_items != 0 )echo " ...";
?>
</font>			  </td>
              <td width="105" height="37" align="right" background="img/black_bg_cell2.jpg" style="padding-right:5px">
			  <div align="center" style="border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: #CC3300; padding-bottom:5; padding-top:5; margin-top:0; width:100px"><a href="postForum.php"><strong>+ New Post</strong></a></div>			  </td>
            </tr>
            <tr>
              <td width="37" height="20" align="center" bgcolor="#EEEEEE">&nbsp;</td>
              <td width="479" height="20"  align="center" bgcolor="#EEEEEE"><strong><font size="1">Subject</font></strong></td>
              <td width="61" height="20"  align="center" bgcolor="#EEEEEE"><strong><font size="1">Reply</font></strong></td>
              <td width="205" height="20"  align="center" bgcolor="#EEEEEE"><strong><font size="1">Category</font></strong></td>
              <td width="113" height="20"  align="center" bgcolor="#EEEEEE"><strong><font size="1">Creator</font></strong></td>
              <td height="20"  align="center" bgcolor="#EEEEEE"><strong><font size="1">Post Time</font></strong></td>
              </tr>
          </table>
		  <table width="1000" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:25px">
            <tr>
              <td width="710" height="41" colspan="0" align="left"><?php
$q1 = mysql_query("SELECT * FROM rockinus.forum_info WHERE 1=1 $sel_cond ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
//echo ("SELECT * FROM rockinus.forum_info WHERE 1=1 $sel_cond ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("<center><font size=5><br><br>No posting found.<br><br><br></font></center>");}
else if($no_row > 0){ 
	while($object = mysql_fetch_object($q1)){
		$foid = $object->foid;
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
?>
                  <table width="1000" height="50" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px #DDDDDD dashed; border-left:0px #DDDDDD solid; border-right:0px #DDDDDD dashed" onmouseover="this.style.backgroundColor = '#F5F5F5';" onmouseout="this.style.backgroundColor = 'white';">
                    <tr>
                      <td width="38" height="32" align="left" style=" color:#336633; padding-left:5px"><img src="img/rightTriangleIcon.jpg" width="12" height="12" /></td>
                      <td width="477" align="center" style="font-size:14px; font-weight:bold">
					  <?php echo("<a href=forumDetail.php?foid=$foid class=one><font color=$_SESSION[hcolor]>$subject</font></a>") ?>
					  </td>
                      <td width="61" align="center"><?php 
						$qh = mysql_query("SELECT * FROM rockinus.forum_history WHERE foid='$foid'");
						if(!$qh) die(mysql_error());
						$no_row_reply = mysql_num_rows($qh);
						echo("<font size=2>$no_row_reply</font>");
					?>                      </td>
                      <td width="206" align="center" style="font-size:12px;"><?php echo("$category") ?></td>
                      <td width="114" align="center" style="font-size:11px;"><?php echo("<a href=RockerDetail.php?uid=$creator><font color=#999999>$creator</font></a>") ?></td>
                      <td width="104" align="center" style="color: #999999; font-size:11px; padding-right:10px"><?php echo($pdate) ?> | <?php echo(substr($ptime,0,5)) ?></td>
                    </tr>
                  </table>
                <?php }}?></td>
            </tr>
          </table></td>
        </tr>
        </table></td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
