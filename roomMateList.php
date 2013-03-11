<?php 
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
  
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
	  <?php include("leftHomeHouseMenu.php") ?>
	  </td>
      <td width="" align="right" valign="top" style="border-right:0px #DDDDDD dashed"><table width="760" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="right" valign="top">
		  <?php include("HeaderEN.php"); ?>
		  <table width="740" height="60" border="0" cellpadding="0" cellspacing="0" background="img/GrayGradbgDown.jpg" style="border-top:1px #DDDDDD dashed;">
              <tr>
                <td height="35" colspan="2" align="left" style="padding-left:5">
				<form action="roomMateList.php" method="post" id="job_type" name="job_type" style="margin-bottom:0">
                    
                  </form>
                    <?php if(isset($_SESSION['category']))unset($_SESSION['category']); ?>
                </td>
                <td height="35" colspan="3" align="right" style="padding-right:25px">
                  <?php			
 //Global Variable: 
$page_name = "roomMateList.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
 
//**EDIT TO YOUR TABLE NAME, ETC.
$q = "SELECT count(*) as cnt FROM rockinus.room_mate_info WHERE 1=1 $sel_cond ORDER BY pdate,ptime DESC";
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
                <td width="110" height="35" align="right" style="padding-right:10"><div align="center" style="border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: #CC3300; padding-bottom:5; padding-top:5; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; width:80px">
				<a href="postRoomMate.php"><strong>+ New</strong></a></div></td>
              </tr>
		    </table>
			  <table width="740" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:25px">
                <tr>
                  <td width="710" height="41" colspan="0" align="right"><?php
mysql_query("SET NAMES GBK");
$q1 = mysql_query("SELECT * FROM rockinus.room_mate_info WHERE 1=1 $sel_cond ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
//echo ("SELECT * FROM rockinus.forum_info WHERE 1=1 $sel_cond ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("<div align='center' style='width:740; border:1px #DDDDDD dashed; margin-top:0; font-size:16px'><br><br><img src=img/notfoundIcon.jpg width=25/>&nbsp;&nbsp;&nbsp;No room mate posting found<br><br><br></div>");}
else if($no_row > 0){ 
	while($object = mysql_fetch_object($q1)){
		$rmate_id = $object->rmate_id;
		$creator = $object->uname;
		$mate_type = $object->mate_type;
		$location = $object->location;
		$rate = $object->rate;
		$expireday = $object->expireday;
		$extra_fee = $object->extra_fee;
		$rstatus = $object->rstatus;
		$has_room = $object->has_room;
		$descrip = $object->descrip;
		$descrip = str_replace("\\","",$descrip);
		$ptime = $object->ptime;
		$pdate = $object->pdate;  
		
		$has_room_title = "";
		if($has_room=="Y") $has_room_title = "<font color=#666666>(has room)</font>";
		if($mate_type=="all") $mate_type = "";
		else $mate_type = "<font color=#666666>(from $mate_type)</font>";
?>
                      <table width="740" height="64" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px #DDDDDD dashed; border-left:0px #DDDDDD solid; border-right:0px #DDDDDD dashed" onmouseover="this.style.backgroundColor='#F5F5F5';document.getElementById('dr<?php echo($rmate_id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('mr<?php echo($rmate_id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; " onmouseout="this.style.backgroundColor='#FFFFFF';document.getElementById('dr<?php echo($rmate_id)?>').style.backgroundColor='#FFFFFF';document.getElementById('mr<?php echo($rmate_id)?>').style.backgroundColor='#FFFFFF'; ">
                        <tr>
                          <td width="40" height="40" align="left" style=" color:#336633; padding-left:5px"><img src="img/rightTriangleIcon.jpg" width="12" height="12" /></td>
                          <td width="586" height="40" align="left" style="font-size:14px; font-weight:bold">
						  <?php echo("<a href=RockerDetail.php?uid=$creator class=one>$creator</a>$has_room_title is seeking for roomate$mate_type") ?> </td>
                          <td width="114" rowspan="2" valign="top" align="right" style="color: #999999; font-size:11px; padding:10">
						  <?php echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?><br /><br />
						  <?php 
					  if($uname==$creator)echo("<span id='dr$rmate_id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=roomMateConfirm.php?rmate_id=$rmate_id&&pageName=roomMateList><font size=1>Delete</font></a></span> <span id='mr$rmate_id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditRoomMate.php?rmate_id=$rmate_id><font size=1>+ Edit</font></a></span>");
					  ?></td>
                        </tr>
                        <tr>
                          <td height="32" align="left" style=" color:#336633; padding-left:5px">&nbsp;</td>
                          <td align="left" style="font-size:14px; font-weight:; line-height:150%; padding-top:0; padding-bottom:15" valign="top">
						  <?php echo(nl2br($descrip));?>						  </td>
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
