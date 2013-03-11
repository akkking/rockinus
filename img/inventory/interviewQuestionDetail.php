<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
include 'emailfuc.php';
require("class.phpmailer.php");
$uname = $_SESSION['usrname'];
//$uid = $uname;
header('Content-type: text/html; charset=utf-8');
$page_name = "interviewQuestions.php";
$sel_cond = " 1=1";

if(isset($_GET["q_id"])){
	$companyname = $_GET["q_id"];
	$sel_cond.= " AND q_id='".$_GET['q_id']."'";
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
    <td width="300" valign="top" align="left" style="border-right:0px dashed #DDDDDD">
	<?php include("leftHomeMenu.php") ?>
	</td>
    <td align="right" valign="top" style="margin-top:0;" width="760">
	<?php include("HeaderEN.php"); ?>
	<br />
    <?php 
if(isset($_SESSION['err_rst_msg'])) {
	echo($_SESSION['err_rst_msg']);
	unset($_SESSION['err_rst_msg']);
}
?>
    <table width="740" height="105" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #DDDDDD">
      <tr>
        <td width="130" height="30" align="right" style=" background: url(img/brownBtnBg.jpg); color:#FFFFFF; font-size:12px; font-weight:bold"> </td>
        <td width="304" align="" style=" background: url(img/brownBtnBg.jpg)">&nbsp;</td>
        <td width="306" style=" background: url(img/brownBtnBg.jpg); padding-right:15; font-size:12px; font-weight:bold" align="right">
		<a href="postInterviewQuestion.php">+&nbsp; Post Interview Questions</a>
		</td>
      </tr>
      <tr>
        <td height="73" colspan="3" valign="top" style="border-top:1px solid #333333; padding-bottom:0">
            <div style=" border-bottom:1px dashed #DDDDDD; height:25; padding-top:8; background: url(img/GrayGradbgDown.jpg); font-size:12px; font-family:Arial, Helvetica, sans-serif; margin-top:0; padding-left:15">
			 <?php
		mysql_query("SET NAMES GBK");
		$q = mysql_query("SELECT company FROM rockinus.interview_question ORDER BY q_id DESC");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		
		if ($no_row == 0)echo("<div style='background-color:#FFFFFF; border: 1 dashed #DDDDDD; width:730px; padding-top:50px; padding-bottom:50px' align='center'><font color=black size=4><strong>No interview question found with your search<p> <a href='postInterviewQuestion.php' class='one'>>> <font color=#B92828>Post a New Question</font></a> </strong></font></div>");
		$i=0; 
		while($object = mysql_fetch_object($q)){
			$companyname = $object->company;
			if($i==0)
				echo("<a href='interviewQuestions.php?company=$companyname' class=one><font style='color:$_SESSION[hcolor];; font-weight:bold'>$companyname</font></a>");
			else
				echo("<font style='color:$_SESSION[hcolor]; font-weight:bold'>,</font>&nbsp; <a href='interviewQuestions.php?company=$companyname' class=one><font style='color:$_SESSION[hcolor];; font-weight:bold'>$companyname</font></a>");
			$i++;
			}
			?>
			</div>
			
            <?php
		mysql_query("SET NAMES GBK");
		$q = mysql_query("SELECT * FROM rockinus.interview_question WHERE $sel_cond ORDER BY q_id DESC");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		
		if ($no_row == 0)echo("<div style='background-color:#FFFFFF; border: 1 dashed #DDDDDD; width:730px; padding-top:50px; padding-bottom:50px' align='center'><font color=black size=4><strong>No interview question found with your search<p> <a href='postInterviewQuestion.php' class='one'>>> <font color=#B92828>Post a New Question</font></a> </strong></font></div>");
		
			$object = mysql_fetch_object($q);
			$q_id = $object->q_id;
			$creater = $object->creater;
			$companyname = $object->company;
			$jobtitle = $object->position;
			$category = $object->category;
			$loopname = $object->creater;
			$descrip = $object->descrip;
			$descrip = nl2br($descrip);
			$descrip = str_replace("\\","",$descrip);
//			$descrip = substr($descrip,0,120)."...";
			$qdate = $object->qdate;
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			?>
<table width="740" height="61" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px dashed #DDDDDD; margin-bottom:0" onmouseover="this.style.backgroundColor = '#F5F5F5'; this.style.borderColor = '#DDDDDD';" onmouseout="this.style.backgroundColor = 'white';this.style.borderColor = '#DDDDDD';">
              <tr>
                <td height="60" valign="top" style="font-size:12px; padding-left:15; padding-bottom:15; line-height:200%; padding-top:10; padding-right:15">
				<?php 
				echo("<a href='interviewQuestions.php?company=$companyname' class='one'><font style='font-size:14px; font-weight:bold; color:#B92828;'>$companyname</font></a> | <font style='font-size:14px; font-weight:bold; color:#333333'>$jobtitle Position | $category</font><br><font style='font-size:11px; font-weight:normal; color:'>Interview Date: $qdate</font>&nbsp;&nbsp;<span style='background:#EEEEEE'>&nbsp; <font style='font-size:11px; font-weight:normal; color:'>Answers: 2</font> &nbsp;</span>&nbsp;&nbsp;<a href='SendMessage.php?recipient=$creater'><span style='background:#EEEEEE'>&nbsp; <font style='font-size:11px; font-weight:normal; color:#000000'>Message Owner</font> &nbsp;</span></a><br><br><font style='font-size:12px; font-weight:bold; color:$_SESSION[hcolor]'><u>Question:</u></font><br><div style='line-height:150%; font-size:12px; color:'>$descrip<div>");
				?>				</td>
              </tr>
            </table>
		  <table width="740" height="25" border="0" cellpadding="0" cellspacing="0" style="background: #EEEEEE; border-top:0px solid #DDDDDD; border-bottom:0px solid #">
              <tr>
                <td width="171" align="right"></td>
                <td width="569" align="right" style=" background:; color: <?php echo($_SESSION['hcolor']) ?>; font-size:12px; font-weight:bold; padding-right:15"></td>
              </tr>
            </table>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
