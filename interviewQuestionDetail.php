<?php 
include("mainHeader.php");
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
include 'emailfuc.php';
require("class.phpmailer.php");
$uname = $_SESSION['usrname'];

if(isset($_POST['solutionSubmit'])){
	$q_id = addslashes($_POST['q_id']);
	$descrip = addslashes($_POST['descrip']);
	$descrip = str_replace("\\","",$descrip);
	$descrip = str_replace("'","\'",$descrip);
		
	if(strlen($descrip)<50 && $tag == 0){
		$rst_msg = "Content cannot be less than 50 letters!";
		$_SESSION['descrip'] = $descrip;
		$tag = 1;
	}
	
	if($tag==0){
		//mysql_query("SET NAMES UTF8");
		mysql_query('set character_set_connection=gbk, character_set_results=gbk, character_set_client=binary');
		$upd = mysql_query("INSERT INTO rockinus.interview_question_follow (q_id, uname, descrip, rstatus, pdate, ptime) VALUE ('$q_id', '$uname', '$descrip', 'N', CURDATE(), NOW());");
		if(!$upd) die(mysql_error());
		//mysql_close($link);
		
		$q_creater_email = mysql_query("SELECT a.email, a.uname FROM rockinus.user_check_info a JOIN rockinus.interview_question b ON a.uname=b.creater AND b.q_id='$q_id'");
		if(!$q_creater_email) die(mysql_error());
		$creater_object = mysql_fetch_object($q_creater_email);
		$creater_email .= $creater_object->email;
		$creater_uname .= $creater_object->uname;
		
		$q_email = mysql_query("SELECT a.email, a.uname FROM rockinus.user_check_info a JOIN rockinus.interview_question_follow b ON a.uname=b.uname AND b.q_id='$q_id'");
		if(!$q_email) die(mysql_error());
		while($object = mysql_fetch_object($q_email)){
			$email_list .= $object->email.";";
			$recipient_list .= $object->uname.";";
		}
		
		$email_list .= $creater_email;
		$recipient_list .= $creater_uname;
		
		smtp_mail($email_list, "[Rockinus.Interview.Question] $uname has posted comment", nl2br($descrip), "admin@rockinus.com", $recipient_list, "", ""); 
		
		$_SESSION['rst_msg']="<div align='left' style='width:700; margin-bottom:5; padding-top:5; padding-bottom:5; font-size:12px; color:#000000; font-weight:bold'>&nbsp;<img src=img/addsuccessIcon.jpg width=10 />&nbsp;&nbsp; Comment/Solution posted successful.</div>"; 
		unset($_SESSION['descrip']);
		//header("location:newsResult.php");
	}else
		$_SESSION['rst_msg']="<div align='left' style='width:700; margin-bottom:5; padding-top:5; padding-bottom:5; font-weight:bold; background:; font-size:12px; color:#B92828'>&nbsp;&nbsp;<img src=img/stop.jpg width=10 />&nbsp;&nbsp;&nbsp;$rst_msg</div>"; 
	//header("location:createnewsResult.php");
}else if(isset($_GET['q_follow_id'])){
	$delete_q_follow_id = $_GET['q_follow_id'];
	$sql = "DELETE FROM rockinus.interview_question_follow WHERE q_follow_id='$delete_q_follow_id'";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	
	$rst_msg = "";
	$_SESSION['rst_msg']="<div align='left' style='width:700; margin-bottom:5; padding-top:0; padding-bottom:5; font-size:12px; color:#000000; font-weight:bold'>&nbsp;<img src=img/addsuccessIcon.jpg width=10 />&nbsp;&nbsp; Your reply/solution has been removed succssfully.</div>";
}


//header('Content-type: text/html; charset=utf-8');
$page_name = "interviewQuestions.php";
$sel_cond = " 1=1";

if(isset($_GET["q_id"])){
	$companyname = $_GET["q_id"];
	$sel_cond.= " AND q_id='".$_GET['q_id']."'";
}

mysql_query("SET NAMES GBK");
$q_folllow = mysql_query("SELECT * FROM rockinus.interview_question_follow WHERE $sel_cond ORDER BY q_follow_id ASC");
if(!$q_folllow) die(mysql_error());
$no_follow_row = mysql_num_rows($q_folllow);
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
<table width="1024" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
  <tr>
    <td width="275" valign="top" align="left" style=" padding:0px 15 15 15">
	<?php
	  include "jobMenu.php";
	  ?>
	  </td>
    <td width="749" align="center" valign="top" style="padding-top:20; padding-bottom:25">
    <?php 
if(isset($_SESSION['rst_msg'])) {
	echo($_SESSION['rst_msg']);
	unset($_SESSION['rst_msg']);
}
?>
    <table width="700" height="105" border="0" cellpadding="0" cellspacing="0" style="border:0px solid #CCCCCC" bgcolor="#FFFFFF">
      <tr>
        <td width="374" height="50" align="left" style="padding-left:5px; font-size:28px; font-weight:normal; color:#000000"><img src="img/yellowChatIcon.png" width="25" />&nbsp;&nbsp; Interview Question</td>
        <td width="346" height="50" align="right" style=" background: ; padding-right:15; font-size:12px; font-weight:bold">&nbsp;		</td>
      </tr>
      <tr>
        <td height="73" colspan="2" valign="top" style="border-top:0px solid #333333; padding-bottom:0"><?php
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
			$positionCategory = $object->positionCategory;
			$category = $object->category;
			$loopname = $object->creater;
			$rstatus = $object->rstatus;
			$descrip = $object->descrip;
			$descrip = nl2br($descrip);
			$descrip = str_replace("\\","",$descrip);
//			$descrip = substr($descrip,0,120)."...";
			$qdate = $object->qdate;
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			$edit_part = "";
			if($loopname==$uname) $edit_part="&nbsp;|&nbsp;<a href='EditInterviewQuestion.php?q_id=$q_id'><span style='background:'><font style='font-size:14px; font-weight:bold; color:$_SESSION[hcolor]'><u>+ Edit</u></font></span></a>";
			
			if($rstatus=='N') $message_part = "<a href='SendMessage.php?recipient=$creater'>&nbsp; <img src='img/msgIcon.jpg' width=18 /></a>";
			?>
<table width="700" height="61" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px dashed #DDDDDD; margin-bottom:0">
              <tr>
                <td height="60" valign="top" style="font-size:12px; font-family: ; padding-left:5px; padding-bottom:20; line-height:200%; padding-top:10; padding-right:15">
				<?php 
				echo("<a href='interviewQuestions.php?company=$companyname' class='one'><font style='font-size:18px; font-weight:bold; color:#B92828;'>$companyname</font></a> | <font style='font-size:18px; font-weight:bold; color:#333333'>$jobtitle Position, $positionCategory, $category</font>$edit_part<br><font style='font-size:12px; font-weight:normal; color:'>Interview Date: $qdate</font>&nbsp;&nbsp;<span style='background:#EEEEEE'>&nbsp; <font style='font-size:11px; font-weight:normal; color:'>Answers: $no_follow_row</font> &nbsp;</span>&nbsp;&nbsp;$message_part<br><br><font style='font-size:14px; font-weight:bold; color:$_SESSION[hcolor]'><u>Question:</u></font><br><div style='line-height:130%; font-size:16px; font-family:Geneva, Arial, Helvetica, sans-serif; color:'>$descrip<div>");
				?>				</td>
              </tr>
            </table>
		  </td>
      </tr>
    </table>
	<?php
				$i=0;
		while($object = mysql_fetch_object($q_folllow)){
			$i++;
			$q_follow_id = $object->q_follow_id;
			$loopname = $object->uname;
			$follow_descrip = $object->descrip;
			$follow_descrip = nl2br($follow_descrip);
			$follow_descrip = str_replace("\\","",$follow_descrip);
			$pdate = $object->pdate;
			$ptime = $object->ptime;
	?>
    <table width="700" border="0" cellspacing="0" cellpadding="0" style="margin-top:15; border:1px solid #DDDDDD">
      <tr>
        <td height="22" style=" font-size:12px; background: url(img/master.jpg); color:<?php echo($_SESSION['hcolor']) ?>; font-weight:bold; padding-left:10px" align="left">
		<?php echo("$loopname (No.$i Supporter)") ?>
		</td>
        <td style=" font-size:11px; background: url(img/master.jpg); padding-right:10px" align="right">
		<?php 
		if($loopname==$uname)echo("<a href='interviewQuestionDetail.php?q_follow_id=$q_follow_id' class='one'>Delete</a>&nbsp;&nbsp;|&nbsp;&nbsp;");
		echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?>
		</td>
      </tr>
      <tr>
        <td colspan="2" align="left" style="padding:10; border-top:1px solid #999999; padding-left:10; font-size:12px; font-family:Arial, Helvetica, sans-serif; line-height:130%">
		<?php echo(addHyperLink($follow_descrip)) ?>		</td>
      </tr>
    </table>
	<?php } ?>
	
	<form method="post">
    <table width="700" border="0" cellspacing="0" cellpadding="0" style="margin-top:15; border:0px solid #DDDDDD">
      <tr>
        <td width="86" align="left" style="padding-top:5; border-top:0px solid #999999" valign="top">
		<?php echo($unameImg) ?>		</td>
        <td width="634" align="left" style="padding-top:5; border-top:0px solid #999999">
		<textarea name="descrip" style="width:600px; border:1px solid #999999; height:150px; background:#F5F5F5; font-size:14px; font-family:Arial, Helvetica, sans-serif; padding:4"></textarea>
		</td>
      </tr>
      <tr>
        <td align="center" style="padding-top:10; border-top:0px solid #999999">
		 </td>
        <td align="left" style="padding-top:10; border-top:0px solid #999999">
		<input type="hidden" name="q_id" value="<?php echo($q_id) ?>" />
		<input type="submit" value="Submit" name="solutionSubmit" style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:1px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif" />
		&nbsp;&nbsp;&nbsp;<font style="font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#999999">Every solution gains 25 points. Maximum 10000 letters input. </font>		</td>
      </tr>
    </table>
	</form>
	
    </td>
  </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
