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
      <td width="760" align="right" valign="top" style="border-right:0px #DDDDDD dashed"><table width="760" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="right" valign="top">
		  <?php include("HeaderEN.php"); ?></td>
        </tr>
      </table>
        <table width="740" height="40" border="0" cellpadding="0" cellspacing="0" background="img/black_bg_cell2.jpg" style="">
          <tr>
            <td style="color:#FFFFFF; font-weight:bold; font-size:16px; font-family:Arial, Helvetica, sans-serif; padding-left:10">
			Polytechnic Institute of New York University
			</td>
          </tr>
        </table>
        <table width="740" border="0" cellspacing="0" cellpadding="0" style="border:1px #DDDDDD solid">
          <tr>
            <td style="line-height:150%; font-size:14px; font-family:Arial, Helvetica, sans-serif; padding:15;">
			Polytechnic Institite of New York University has 20 schools as its branch colleages.<br><br>
                        Every year, students pack their bags and leave home in pursuit of a dream: to live and study at the University. <?php echo($school_name) ?>, one of the foremost private, global research institutions in the United States, is primarily located in the heart of downtown Manhattan. Over 160 undergraduate programs of study that match almost every professional interest are offered here. Beyond <?php echo($school_name) ?>, in Greenwich Village lies a whole world of job opportunity. As a student in a global network university with a portal campus in Abu Dhabi and 10 international academic centers, you're able to make progress toward your degree on five continents¡ªAfrica, Asia, Europe, North America, and South America. You broaden the scope of your education through study abroad programs, direct-exchange programs with world-renowned institutions, and curriculum-driven international programming. Around the world, you'll continue to work closely with faculty and fellow students who share your commitment, you'll apply what you've learned, and you'll develop the skills and qualities-both needed and expected in this increasingly integrated, global climate¡ªto make a real difference in the world around you.<br>
                        <br>Summer program locations are as diverse as Beijing and Shanghai, Barcelona and Dublin. Some programs, such as Journalism in Ghana, Filmmaking in Prague, and Urban Design in London, are major-specific, while others, such as the offerings in Athens, Florence, and Paris, are formulated to blend together different disciplines into a single avenue of knowledge.<br /><br />
			By google.com
			</td>
          </tr>
        </table></td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
