<?php 
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
$ua=getBrowser();
  
include 'dbconnect.php';
$pic210_Name = $uname.'210.jpg';
$ProPercent = 70;

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
<div align="center">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="center">
    <tr>
      <td width="300" align="left" valign="top" style=" border-right:1px #DDDDDD dashed">
	  <?php include("leftHomeMenu.php") ?>
	  </td>
      <td width="" align="right" valign="top" style="border-right:0px #DDDDDD dashed"><table width="760" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="right" valign="top">
		  <?php include("HeaderEN.php"); ?>
		  <table width="740" height="35" border="0" cellpadding="0" cellspacing="0" background="img/master.png" style="border-bottom:1 #CCCCCC solid;">
              <tr>
                <td height="35" colspan="2" align="left" style="padding-left:5">
				<form action="jobList.php" method="post" id="job_type" name="job_type" style="margin-bottom:0">
                    <select name="category" onchange="document.forum_type.submit()">
                      <option value="Blank" <?php if(isset($_SESSION['category']) && $_SESSION['category']=="Blank")echo("selected") ?>>Select a Category</option>
                      <?php if($cmajor!=NULL && strlen($cmajor)>0){ ?>
                      <option value="<?php echo($cmajor) ?>" <?php if(isset($_SESSION['category']) && $_SESSION['category']==$cmajor)echo("selected") ?>><?php echo($major_name) ?></option>
                      <?php } ?>
                      <option value="others">Others</option>
                    </select>
                  </form>
                    <?php if(isset($_SESSION['category']))unset($_SESSION['category']); ?>
                </td>
                <td height="35" colspan="3" align="right" style="padding-right:25px">
                  <?php			
 //Global Variable: 
$page_name = "openForum.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
 
//**EDIT TO YOUR TABLE NAME, ETC.
$q = "SELECT count(*) as cnt FROM rockinus.job_info WHERE 1=1 $sel_cond ORDER BY pdate,ptime DESC";
//echo("SELECT count(*) as cnt FROM rockinus.house_info WHERE $sel_cond ORDER BY pdate,ptime DESC");
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
//if ($total_items == 0 )echo("<strong>No job post so far</strong>");

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
?>                </td>
                <td width="110" height="35" align="right" style="padding-right:5"><div align="center" style="border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: <?php echo($_SESSION['hcolor']) ?>; padding-bottom:5; padding-top:5; margin-top:0; width:100px"><a href="postJob.php"><strong>+ New Post</strong></a></div></td>
              </tr>
		    </table>
			  <table width="740" height="30" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-top:1px solid #DDDDDD;border-bottom:1px solid #EEEEEE; margin-bottom:10">
              <tr>
                <td width="29" height="30" align="center" style="color:#F5F5F5"></td>
                <td width="345" height="30"  align="center" style="color:#666666"><strong>Subject</strong></td>
                <td width="56" height="30"  align="center" style="color:#666666"><strong>Reply</strong></td>
                <td width="150" height="30"  align="center" style="color:#666666"><strong>Category</strong></td>
                <td width="83" height="30"  align="center" style="color:#666666"><strong>Creator</strong></td>
                <td width="97" height="30"  align="center" style="color:#666666"><strong>Post Time</strong></td>
              </tr>
            </table>
              <table width="740" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:25px">
                <tr>
                  <td width="710" height="41" colspan="0" align="right"><?php
$q1 = mysql_query("SELECT * FROM rockinus.job_info WHERE 1=1 $sel_cond ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
//echo ("SELECT * FROM rockinus.forum_info WHERE 1=1 $sel_cond ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("<div align='center' style='width:740; border:1px #DDDDDD dashed; margin-top:0; font-size:16px'><br><br><img src=img/notfoundIcon.jpg width=25/>&nbsp;&nbsp;&nbsp;No job posting found<br><br><br></div>");}
else if($no_row > 0){ 
	while($object = mysql_fetch_object($q1)){
		$job_id = $object->job_id;
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
                      <table width="740" height="50" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px #DDDDDD dashed; border-left:0px #DDDDDD solid; border-right:0px #DDDDDD dashed" onmouseover="this.style.backgroundColor = '#F5F5F5';" onmouseout="this.style.backgroundColor = 'white';">
                        <tr>
                          <td width="38" height="32" align="left" style=" color:#336633; padding-left:5px"><img src="img/rightTriangleIcon.jpg" width="12" height="12" /></td>
                          <td width="477" align="left" style="font-size:14px; font-weight:"><?php echo("<a href=jobDetail.php?job_id=$job_id class=one><font color=>".substr($subject,0,44)."...</font></a>") ?> </td>
                          <td width="61" align="center"><?php 
						$qh = mysql_query("SELECT * FROM rockinus.job_history WHERE job_id='$job_id'");
						if(!$qh) die(mysql_error());
						$no_row_reply = mysql_num_rows($qh);
						echo("<font size=2>$no_row_reply</font>");
					?>
                          </td>
                          <td width="206" align="center" style="font-size:12px;"><?php if(strlen($category)>20)echo(substr($category,0,18)."..."); else echo($category); ?></td>
                          <td width="114" align="center" style="font-size:11px;"><?php echo("<a href=RockerDetail.php?uid=$creator><font color=#999999>$creator</font></a>") ?></td>
                          <td width="104" align="center" style="color: #999999; font-size:11px; padding-right:10px"><?php echo($pdate) ?></td>
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
