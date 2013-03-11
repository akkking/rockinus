<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];

if(isset($_GET['notice_id'])&&$_GET['action']=='d'){
	$notice_id = $_GET['notice_id'];
	$sql = "DELETE FROM rockinus.system_notice WHERE creater='$uname' AND notice_id='$notice_id'";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	
	$rst_msg = "Notice has been deleted successfully!";
	$_SESSION['rst_msg']="<div align='left' style='-moz-border-radius: 5px; border-radius: 5px; width:700px; font-size:18px; color:#000000; padding:15 25 15 25; margin-bottom:5px; border:1px solid #DDDDDD; background: #F5F5F5'><img src=img/addsuccessIcon.jpg width=15>&nbsp;&nbsp;&nbsp; $rst_msg</div>";
}
?>
<LINK REL="SHORTCUT ICON" HREF="img/rockinTag.png">
<link rel="stylesheet" type="text/css" href="style.css" />
<div align="center" style="padding-top:15px">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="center">
    <tr>
      <td width="300" align="left" valign="top" style=" padding-bottom:100px">
	  <a href="systemNoticeList.php">
		<img src="img/rockinus_home_admin.jpg" />	</a>	
		
		<a href="ThingsRock.php" class="two">
	  <div style="margin-top:50px; -moz-border-radius: 2px; border-radius: 2px; width:180px; height:25px; padding:10 0 5 0; background: url(img/GrayGradbgDown.jpg); border:1px solid #DDDDDD; font-size:14px; color:<?php echo($_SESSION['hcolor']) ?>; cursor:pointer" align="center" onmouseover="this.style.border='1px #CCCCCC solid'" onmouseout="this.style.border='1px #DDDDDD solid'">
	  Rockinus Home Page
	  </div></a>

		<a href="postSystemNotice.php" class="two">
	  <div style="margin-top:15px; -moz-border-radius: 2px; border-radius: 2px; width:180px; height:25px; padding:10 0 5 0; background: url(img/GrayGradbgDown.jpg); border:1px solid #DDDDDD; font-size:14px; color:<?php echo($_SESSION['hcolor']) ?>; cursor:pointer" align="center" onmouseover="this.style.border='1px #CCCCCC solid'" onmouseout="this.style.border='1px #DDDDDD solid'">
	  + Compose New
	  </div></a>
	  
	  <a href="systemNoticeList.php" class="two">
	  <div style="margin-top:15px; -moz-border-radius: 2px; border-radius: 2px; width:180px; height:25px; padding:10 0 5 0; background: url(img/GrayGradbgDown.jpg); border:1px solid #DDDDDD; font-size:14px; color:<?php echo($_SESSION['hcolor']) ?>; cursor:pointer" align="center" onmouseover="this.style.border='1px #CCCCCC solid'" onmouseout="this.style.border='1px #DDDDDD solid'">
	  Notice History
	  </div></a>
		</td>
      <td width="" align="right" valign="top" style="border-right:0px #DDDDDD dashed"><table width="760" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="top" style="padding-bottom:30px">
		  <?php
	  	if(isset($_SESSION['rst_msg'])){
			echo($_SESSION['rst_msg']);
			unset($_SESSION['rst_msg']);
		}
		
		if(isset($_SESSION['err_rst_msg'])){
			echo($_SESSION['err_rst_msg']);
			unset($_SESSION['err_rst_msg']);
		}
	  ?>
	  <table width="740" height="30" border="0" cellpadding="0" cellspacing="0" background="img/master.jpg" style=" margin-top:25px; margin-bottom:15px">
              <tr>
                <td height="35" colspan="2" align="left" style="padding-left:10; font-size:18px">Pick Category
				</td>
				<td width="291" align="left" style="padding-left:15px">  
				<form action="systemNoticeList.php" method="post" id="systemNoticeForm" name="systemNoticeForm" style="margin-bottom:0">
                    <select name="category">
					<option value="New Features" selected="selected">New Features</option>
					<option value="System Upgrade">System Upgrade</option>
					<option value="Job Openning">Job Openning</option>
					</select>
					</form>
                    <?php if(isset($_SESSION['category']))unset($_SESSION['category']); ?>
                </td>
                <td width="293" height="35" colspan="3" align="right" style="padding-right:25px">
                  <?php			
 //Global Variable: 
$page_name = "systemNoticeList.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
 
//**EDIT TO YOUR TABLE NAME, ETC.
$q = "SELECT count(*) as cnt FROM rockinus.system_notice WHERE 1=1 $sel_cond ORDER BY pdate,ptime DESC";
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
              </tr>
		    </table>
			  <table width="740" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:25px">
                <tr>
                  <td width="710" height="41" colspan="0" align="right"><?php
$q1 = mysql_query("SELECT * FROM rockinus.system_notice WHERE 1=1 $sel_cond ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
//echo ("SELECT * FROM rockinus.forum_info WHERE 1=1 $sel_cond ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("<div align='center' style='width:600; border:1px #DDDDDD dashed; padding:50px; font-size:18px'><img src=img/notfoundIcon.jpg width=25/>&nbsp;&nbsp;&nbsp;No system notice posting found</div>");}
else if($no_row > 0){ 
	while($object = mysql_fetch_object($q1)){
		$notice_id = $object->notice_id;
		$creater = $object->creater;
		$title = $object->title;
		$category = $object->category;
		$rstatus = $object->rstatus;
		$descrip = $object->descrip;
		$ptime = $object->ptime;
		$pdate = $object->pdate;  
		
?>
                      <table width="740" height="64" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px #DDDDDD dashed; border-left:0px #DDDDDD solid; border-right:0px #DDDDDD dashed" onmouseover="this.style.backgroundColor = '#F5F5F5';" onmouseout="this.style.backgroundColor = 'white';">
                        <tr>
                          <td width="40" height="40" align="left" style=" color:#336633; padding-left:5px"><img src="img/people.png" width="20" /></td>
                          <td width="586" height="40" align="left" style="font-size:16px; font-weight:bold">
						  <?php echo("<font color='$_SESSION[hcolor]'>$title</font> <font style='font-weight:normal; color:#999999'>[$category][$creater]</font> ") ?> </td>
                          <td width="114" height="40" align="right" style="color: #999999; font-size:11px; padding-right:10px">
						  <?php echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?>
						  </td>
                        </tr>
                        <tr>
                          <td height="32" align="left" style=" color:#336633; padding-left:5px">&nbsp;</td>
                          <td align="left" style="font-size:14px; font-weight:; line-height:150%; padding-top:0; padding-bottom:15" valign="top">
						  <?php echo($descrip);?>
						  </td>
                          <td align="right" style="color: #999999; font-size:11px; padding-right:10px" valign="top">
						  <?php
						  if($uname == $creater){
						  	echo("<div style='height:15px; padding:2px 5px 2px 5px; background: url(img/master.jpg); display:inline; margin-top:5px; width:60px; border:1px solid #999999; font-size:11px; cursor:pointer; color:#000000; -moz-border-radius: 3px; border-radius: 3px;' align='center'  onmouseover=\"this.style.border='1px #CCCCCC solid'\" onmouseout=\"this.style.border='1px #DDDDDD solid'\"><a href='systemNoticeList.php?action=d&&notice_id=$notice_id' class='two'>Delete</a></div>");
						  }
						  ?>
						  </td>
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
