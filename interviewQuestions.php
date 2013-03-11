<?php 
include("mainHeader.php");
include 'dbconnect.php';
include("Allfuc.php");
include 'emailfuc.php';
require("class.phpmailer.php");
$uname = $_SESSION['usrname'];

$page_name = "interviewQuestions.php";
$sel_cond = " 1=1";

if(isset($_GET["company"])){
	$companyname = $_GET["company"];
	$sel_cond.= " AND company='".$_GET['company']."'";
}
?>
<style type="text/css">
<!--
.STYLE2 {color: #336633}
-->
</style>
<style type="text/css">
#load{
position:absolute;
z-index:1;
border:4px solid #DDDDDD;
background: #F5F5F5;
color:#FFFFFF;
width:250px;
padding-top:15px;
padding-bottom:15px;
margin-top:-150px;
margin-left:-150px;
top:50%;
left:50%;
text-align:center;
line-height:500px;
font-family:"Trebuchet MS", verdana, arial,tahoma;
font-size:14pt;
}
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>

<div align="center" style="margin-top:0px">
<table width="1024" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top" style="border-right:0px dashed #DDDDDD">
	<?php 
if(isset($_SESSION['err_rst_msg'])) {
	echo($_SESSION['err_rst_msg']);
	unset($_SESSION['err_rst_msg']);
}
?>
    <table width="1024" height="700" border="0" cellpadding="0" cellspacing="0"  bgcolor="#FFFFFF">
      <tr>
        <td width="285" valign="top" style="padding:0px 15 15 15">
		<?php
	  include "jobMenu.php";
	  ?>		</td>
        <td width="739" style="padding-top:20px; padding-bottom:15px" align="center" valign="top">
		<table width="700" height="105" border="0" cellpadding="0" cellspacing="0" style="border:0px solid #DDDDDD">
          <tr>
            <td width="455" height="50" align="left" style="padding-left:0px; font-size:28px; font-weight:normal; color:#000000"><img src="img/yellowChatIcon.png" width="25" />&nbsp;&nbsp; Interview Questions History</td>
            <td width="245" height="50" align="right" style="padding-right:15; font-size:18px; font-weight:normal; color:">
			<?php
$q = "SELECT count(*) as cnt FROM rockinus.interview_question WHERE $sel_cond";
//echo($q);
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 10;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
if((!$limit) || (is_numeric($limit) == false)|| ($limit < 10) || ($limit > 50)) {
	$limit = 1; //default
}
 
if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items)) { 
	$page = 1; //default 
}
 
//calculate total pages
$total_pages = ceil($total_items / $limit);
$set_limit = ($page * $limit) - $limit;
//echo "Total Pages: $total_pages <br/>";
if ($total_items != 0 )echo "Page";
//prev. page
$prev_page = $page - 1;
if($prev_page >= 1) { 
	echo("<a href=$page_name?limit=$limit&page=$prev_page class=one>Previous</a>");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo(" $a "); //no link
}else{ 
	echo("<a href=$page_name?limit=$limit&page=$a class=one> $a</a>   ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo(" <a href=$page_name?limit=$limit&page=$next_page class=one>Next</a>");
}
if ($total_items != 0 )echo "";
		  ?> </td>
          </tr>
          <tr>
            <td height="73" colspan="2" valign="top" style="border-top:0px solid #DDDDDD; background:#F5F5F5; background-repeat: repeat-x"><?php
		mysql_query("SET NAMES GBK");
		$q = mysql_query("SELECT * FROM rockinus.interview_question WHERE $sel_cond ORDER BY q_id DESC");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		
		if ($no_row == 0)echo("<div style='background-color:#FFFFFF; border: 1 dashed #DDDDDD; width:730px; padding-top:50px; padding-bottom:50px' align='center'><font color=black size=4><strong>No interview question found with your search<p> <a href='postInterviewQuestion.php' class='one'>>> <font color=#B92828>Post a New Question</font></a> </strong></font></div>");
		
		while($object = mysql_fetch_object($q)){
			$q_id = $object->q_id;
			$companyname = $object->company;
			$jobtitle = $object->position;
			$positionCategory = $object->positionCategory;
			$category = $object->category;
			$loopname = $object->creater;
			$descrip = $object->descrip;
			$descrip = nl2br($descrip);
			$descrip = str_replace("\\","",$descrip);
			$descrip = substr($descrip,0,120)."...";
			$qdate = $object->qdate;
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			
			$edit_part = "";
			if($loopname==$uname) $edit_part="&nbsp;&nbsp; <a href='EditInterviewQuestion.php?q_id=$q_id'><span style='background:'><font style='font-size:13px; font-weight:bold; color:$_SESSION[hcolor]'><img src='img/editIcon.jpg' width=13 /></font></span></a>";
			
			//mysql_query("SET NAMES GBK");
			$q_folllow = mysql_query("SELECT * FROM rockinus.interview_question_follow WHERE q_id='$q_id';");
			if(!$q_folllow) die(mysql_error());
			$no_follow_row = mysql_num_rows($q_folllow);
			?>
  <table width="700" height="61" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px dotted #CCCCCC; margin-bottom:0; background:#FFFFFF" onmouseover="this.style.backgroundColor = '#F5F5F5'; this.style.borderColor = '#DDDDDD';" onmouseout="this.style.backgroundColor = 'white';this.style.borderColor = '#DDDDDD';">
                    <tr>
                      <td height="60" valign="top" style="font-size:12px; padding-left:5px; padding-bottom:10; line-height:200%; padding-top:10; padding-right:5"><?php 
				echo("<a href='interviewQuestionDetail.php?q_id=$q_id' class='one'><font style='font-size:16px; font-weight:bold; color:#B92828;'>$companyname</font> | <font style='font-size:16px; font-weight:bold; color:#333333'>$jobtitle, $positionCategory, $category</a> $edit_part</font><br><font style='font-size:11px; font-weight:normal; color:'>Interview Date: $qdate</font>&nbsp;&nbsp;&nbsp; <span style='background:#EEEEEE'>&nbsp; <font style='font-size:11px; font-weight:normal; color:'>Answers: $no_follow_row</font> &nbsp;</span>&nbsp;&nbsp;&nbsp; <a href='interviewQuestionDetail.php?q_id=$q_id'><span style='background:#EEEEEE'>&nbsp; <font style='font-size:11px; font-weight:normal; color:#000000'>Check Detail</font> &nbsp;</span></a><br><div style='line-height:150%; font-size:11px; color:#999999'>$descrip<div>");
				?>
                      </td>
                    </tr>
                  </table>
                <?php } ?>
                  <table width="700" height="45" border="0" cellpadding="0" cellspacing="0" style=" border-top:1px solid #DDDDDD">
                    <tr>
                      <td width="171" align="right"></td>
                      <td width="569" align="right" style=" background:; color: <?php echo($_SESSION['hcolor']) ?>; font-size:18px; font-weight: normal; padding-right:15"><?php
$q = "SELECT count(*) as cnt FROM rockinus.interview_question WHERE $sel_cond";
//echo($q);
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 10;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
if((!$limit) || (is_numeric($limit) == false)|| ($limit < 10) || ($limit > 50)) {
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
	echo(" <font color=black>$a</font> "); //no link
}else{ 
	echo("<a class='one' href=$page_name?limit=$limit&page=$a class=one> $a</a>   ");
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
              </table></td></tr>
        </table></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
