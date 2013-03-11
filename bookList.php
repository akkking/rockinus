<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];

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

$sel_cond = "";
if(isset($_POST['mid'])){
	$_SESSION['mid'] = trim($_POST['mid']);
 	if($_POST['mid']!="all")
		$sel_cond = " AND mid='".trim($_POST['mid'])."'";
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
		  <table width="740" height="60" border="0" cellpadding="0" cellspacing="0" background="img/GrayGradbgDown.jpg" style="border-top:1px #CCCCCC solid;">
              <tr>
                <td height="35" colspan="2" align="left" style="padding-left:10">
				<form action="bookList.php" method="post" id="bookForm" name="bookForm" style="margin-bottom:0">
                    <select name="mid" onChange="document.bookForm.submit()" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
					<option value="all" selected="selected">All subjects</option>
					<?php 
						$m = mysql_query("SELECT mid, major_name FROM rockinus.major_info ORDER BY major_name ASC");
						if(!$m) die(mysql_error());
						while($objm = mysql_fetch_object($m)){
							$mid = $objm->mid;
							$major_name = $objm->major_name;
						?>
            	            <option value="<?php echo($mid) ?>" <?php if(isset($_SESSION['mid'])&&$_SESSION['mid']==$mid)echo(" selected")?>><?php echo($major_name) ?></option>
						<? 
						}
						?>
					  </select>
					</form>
                    <?php if(isset($_SESSION['category']))unset($_SESSION['category']); ?>
                </td>
                <td height="35" colspan="3" align="right" style="padding-right:25px">
                  <?php			
 //Global Variable: 
$page_name = "bookList.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
 
//**EDIT TO YOUR TABLE NAME, ETC.
$q = "SELECT count(*) as cnt FROM rockinus.book_info WHERE 1=1 $sel_cond ORDER BY pdate,ptime DESC";
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
                <td width="110" height="35" align="right" style="padding-right:15"><div align="center" style="border-right:1 solid #000000; border-bottom:1 solid #000000; background-color: <?php echo($_SESSION['hcolor']) ?>; padding-bottom:5; padding-top:5; margin-top:0; width:80px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif"><a href="postBook.php"><strong>+ New</strong></a></div></td>
              </tr>
		    </table>
			  <table width="740" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:25px">
                <tr>
                  <td width="710" height="41" colspan="0" align="right"><?php
$q1 = mysql_query("SELECT * FROM rockinus.book_info WHERE 1=1 $sel_cond ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
//echo ("SELECT * FROM rockinus.forum_info WHERE 1=1 $sel_cond ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("<div align='center' style='width:740; border:1px #DDDDDD dashed; padding-bottom:50; padding-top:50; font-size:18px'><img src=img/notfoundIcon.jpg width=25/>&nbsp;&nbsp;&nbsp;No books posting found<br><br><input type='button' class='profile_btn' style='background:$_SESSION[hcolor]' value=' + Post New Book' ONCLICK=window.location.href='postBook.php' /></div>");}
else if($no_row > 0){ 
	while($object = mysql_fetch_object($q1)){
		$book_id = $object->book_id;
		$creator = $object->uname;
		$book_name = $object->book_name;
		$textbook = $object->textbook;
		$rate = $object->rate;
		$rstatus = $object->rstatus;
		$buysale = $object->buysale;
		$descrip = $object->descrip;
		$ptime = $object->ptime;
		$pdate = $object->pdate;  
		
		if($textbook=="Y") $textbook_title = "<font color=#000000 style='font-weight:bold'>[textbook]</font>";
		else $textbook_title = "";

		$buysale_title = "<font color=#666666 style='font-weight:normal'>($buysale)</font>";
		$rate_title = "<font color=#666666 style='font-weight:normal'>($rate)</font>";
?>
                      <table width="740" height="64" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px #DDDDDD dashed; border-left:0px #DDDDDD solid; border-right:0px #DDDDDD dashed" onmouseover="this.style.backgroundColor = '#F5F5F5';" onmouseout="this.style.backgroundColor = 'white';">
                        <tr>
                          <td width="40" height="40" align="left" style=" color:#336633; padding-left:5px"><img src="img/rightTriangleIcon.jpg" width="12" height="12" /></td>
                          <td width="586" height="40" align="left" style="font-size:14px; font-weight:bold">
						  <?php echo($textbook_title." <font color=$_SESSION[hcolor]>".$book_name."</font> ".$buysale_title." ".$rate_title) ?> </td>
                          <td width="114" height="40" align="right" style="color: #999999; font-size:11px; padding-right:10px"><?php echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?></td>
                        </tr>
                        <tr>
                          <td height="32" align="left" style=" color:#336633; padding-left:5px">&nbsp;</td>
                          <td align="left" style="font-size:14px; font-weight:; line-height:150%; padding-top:0; padding-bottom:15" valign="top">
						  <?php echo($descrip);?>
						  </td>
                          <td align="center" style="color: #999999; font-size:11px; padding-right:10px">&nbsp;</td>
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
