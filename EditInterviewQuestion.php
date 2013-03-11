<?php 
include 'dbconnect.php';
include("Allfuc.php");
include 'emailfuc.php';
require("class.phpmailer.php");
$uname = $_SESSION['usrname'];
//$uid = $uname;
header('Content-type: text/html; charset=utf-8');

$tag = 0;
if(isset($_POST['questionSubmit'])){
	$companyname = addslashes($_POST['companyname']);
	$companyname = str_replace("'","\'",$companyname);
	$companyname = str_replace("\\","",$companyname);
	$jobtitle = $_POST['jobtitle'];
	$positionCategory = $_POST['positionCategory'];
	$category = $_POST['category'];
	if(isset($_POST['anony_yesno'])) $rstatus = "Y";
	else $rstatus = "N";
	$descrip = addslashes($_POST['descrip']);
	$descrip = str_replace("\\","",$descrip);
	$descrip = str_replace("'","\'",$descrip);
	
	$questionYear = $_POST['questionYear'];
	$questionMonth = $_POST['questionMonth'];
	$questionDay = $_POST['questionDay'];
	$questionDate = "2012-12-01";
	
	if(trim($companyname)=="empty"){
		$rst_msg = "Please select the company name!";
		$_SESSION['jobtitle'] = $jobtitle;
		$_SESSION['category'] = $category;
		$_SESSION['positionCategory'] = $positionCategory;
		$_SESSION['descrip'] = $descrip;
		$tag = 1;
	}
	
	if(trim($jobtitle)=="empty" && $tag == 0){
		$rst_msg = "Please select the position!";
		$_SESSION['companyname'] = $companyname;
		$_SESSION['positionCategory'] = $positionCategory;
		$_SESSION['category'] = $category;
		$_SESSION['descrip'] = $descrip;
		$tag = 1;
	}
	
	
	if(trim($positionCategory)=="empty" && $tag == 0){
		$rst_msg = "Please select the position category!";
		$_SESSION['companyname'] = $companyname;
		$_SESSION['jobtitle'] = $jobtitle;
		$_SESSION['category'] = $category;
		$_SESSION['descrip'] = $descrip;
		$tag = 1;
	}
	
	if(trim($category)=="empty" && $tag == 0){
		$rst_msg = "Please select your intervew type!";
		$_SESSION['companyname'] = $companyname;
		$_SESSION['jobtitle'] = $jobtitle;
		$_SESSION['positionCategory'] = $positionCategory;
		$_SESSION['descrip'] = $descrip;
		$tag = 1;
	}
	
	if($questionDay=="00" && $tag == 0){
		$rst_msg = "Please select your interview date!";
		$_SESSION['companyname'] = $companyname;
		$_SESSION['positionCategory'] = $positionCategory;
		$_SESSION['jobtitle'] = $jobtitle;
		$_SESSION['category'] = $category;
		$_SESSION['descrip'] = $descrip;
		$tag = 1;
	}else{
		$questionDate = $questionYear."-".$questionMonth."-".$questionDay;
	} 
	
	if(strlen($descrip)<50 && $tag == 0){
		$rst_msg = "Question cannot be less than 50 letters!";
		$_SESSION['companyname'] = $companyname;
		$_SESSION['positionCategory'] = $positionCategory;
		$_SESSION['jobtitle'] = $jobtitle;
		$_SESSION['category'] = $category;
		$_SESSION['descrip'] = $descrip;
		$tag = 1;
	}
	
	if($tag==0){
		//mysql_query("SET NAMES UTF8");
		mysql_query('set character_set_connection=gbk, character_set_results=gbk, character_set_client=binary');
		$upd = mysql_query("UPDATE rockinus.interview_question SET creater='$uname', company='$companyname', position='$jobtitle', positionCategory='$positionCategory', category='$category', rstatus='$rstatus', descrip='$descrip', qdate='$questionDate' WHERE q_id='$q_id';");
		if(!$upd) die(mysql_error());
		//mysql_close($link);
				
		$_SESSION['rst_msg']="<div align='center' style='width:700; margin-bottom:10; padding-top:10; padding-bottom:10; color:$_SESSION[hcolor];font-size:14px'><strong><img src=img/addsuccessIcon_F5.jpg width=12>&nbsp;&nbsp;&nbsp;Question has been modified successful! <br><br><a href='interviewQuestions.php'><div align='center' style='border:1px solid #DDDDDD; border-right:1px solid #999999; border-bottom:1px solid #999999; background:url(img/".substr($_SESSION['hcolor'],1,6)."_ajax_button.jpg); padding-bottom:3; padding-top:3; width:200; font-size:13px; font-weight:normal; color:#000000'>View All Interview Questions</div></a></font></strong></div>"; 
		if(isset($_SESSION['companyname'])) unset($_SESSION['companyname']);
		if(isset($_SESSION['jobtitle'])) unset($_SESSION['jobtitle']);
		if(isset($_SESSION['positionCategory'])) unset($_SESSION['positionCategory']);
		if(isset($_SESSION['category'])) unset($_SESSION['category']);
		if(isset($_SESSION['descrip'])) unset($_SESSION['descrip']);
		if(isset($_SESSION['questionDay'])) unset($_SESSION['questionDay']);
		header("location:newsResult.php");
	}else
		$_SESSION['err_rst_msg']="<div align='left' style='width:740; margin-bottom:5; padding-top:5; padding-bottom:5; font-weight:bold; background:; font-size:12px; color:#B92828'>&nbsp;&nbsp;<img src=img/stop.jpg width=10 />&nbsp;&nbsp;&nbsp;$rst_msg</div>"; 
	//header("location:createnewsResult.php");
}else if(isset($_GET['q_id'])){
	$q_id = $_GET['q_id'];
	mysql_query("SET NAMES GBK");
	$q = mysql_query("SELECT * FROM rockinus.interview_question WHERE q_id='$q_id'");
	if(!$q) die(mysql_error());
	$no_row = mysql_num_rows($q);
		
	if ($no_row == 0)echo("<div style='background-color:#FFFFFF; border: 1 dashed #DDDDDD; width:730px; padding-top:50px; padding-bottom:50px' align='center'><font color=black size=4><strong>Error, no interview question found with id $q_id<p></strong></font></div>");
		
	$object = mysql_fetch_object($q);
	$creater = $object->creater;
	$companyname = $object->company;
	$jobtitle = $object->position;
	$positionCategory = $object->positionCategory;
	$category = $object->category;
	$loopname = $object->creater;
	$rstatus = $object->rstatus;
	$descrip = $object->descrip;
//	$descrip = nl2br($descrip);
	$descrip = str_replace("\\","",$descrip);
	$qdate = $object->qdate;
	$questionYear = substr($qdate,0,4);
	$questionMonth = substr($qdate,6,2);
	$questionDay = substr($qdate,8,2);
}

include("mainHeader.php");
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
    <td align="center" valign="top" style=" padding-top:50px">
	<?php 
if(isset($_SESSION['err_rst_msg'])) {
	echo($_SESSION['err_rst_msg']);
	unset($_SESSION['err_rst_msg']);
}
?>	<table width="740" height="337" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #DDDDDD; margin-bottom:50px">
	  <tr>
	    <td height="50" align="left" bgcolor="#F5F5F5" style="padding-left:15px; font-size:18px; font-weight:bold">
	  <a href="interviewQuestions.php" class="one">Review All Interview Questions</a></td>
    </tr>
	  <tr>
	    <td height="305" colspan="2" valign="top" style="border-top:1px solid #DDDDDD; padding-bottom:0">
	      <form method="post">
	        <div style="height:40">
	          <table width="740" height="40" border="0" cellpadding="0" cellspacing="0">
	            <tr>
	              <td width="171" style="font-size:12px; padding-right:10;" align="right">&nbsp;</td>
            <td width="587">&nbsp;</td>
          </tr>
	            </table>
	  </div>
	  <div style="height:27; border-bottom:0px solid #EEEEEE; margin-bottom:5">
	    <table width="740" height="25" border="0" cellpadding="0" cellspacing="0">
	      <tr>
	        <td width="171" style="font-size:12px; padding-right:10;" align="right">Company Name </td>
            <td width="587" style="border-bottom:0px solid #EEEEEE; padding-left:10" align="left">
              <select name="companyname" id="companyname" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
                <option value="empty">Select a Company</option>
                <?php
							$q = mysql_query("SELECT * FROM rockinus.company_info ORDER by company_name ASC");
						
							if(!$q) die(mysql_error());
							while($obj = mysql_fetch_object($q)){
								$loop_company_name = trim($obj->company_name);
								if($loop_company_name == trim($companyname)){
									$selected = " selected"; 
								}else $selected = "";
								
								echo ("<option value='$loop_company_name' $selected>$loop_company_name</option>");
							}
						?>
                <option value="Others">Not in this list..</option>
                </select>		  </td>
          </tr>
	      </table>
	    </div>
	  <div style="height:27; border-bottom:0px solid #EEEEEE; margin-bottom:5">
	    <table width="740" height="25" border="0" cellpadding="0" cellspacing="0">
	      <tr>
	        <td width="171" style="font-size:12px; padding-right:10;" align="right">Interview Position  </td>
            <td width="587" style="border-bottom:0px solid #EEEEEE; padding-left:10" align="left">
              <select name="jobtitle" id="jobtitle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
                <option value="empty">Select a Position</option>
                <option value="Software Engineer" <?php if($jobtitle=="Software Engineer")echo(" selected") ?>>
                  Software Engineer</option>
                <option value="UI Engineer" <?php if($jobtitle=="UI Engineer")echo(" selected") ?>>
                  UI Engineer</option>
                <option value="Developer" <?php if($jobtitle=="Developer")echo(" selected") ?>>
                  Software Developer</option>
                <option value="Analyst" <?php if($jobtitle=="Analyst")echo(" selected") ?>>
                  Software Analyst</option>
                <option value="Quality Assurance" <?php if($jobtitle=="Quality Assurance")echo(" selected") ?>>
                  Quality Assurance</option>
                <option value="Software Manager" <?php if($jobtitle=="Software Manager")echo(" selected") ?>>
                  Software Manager</option>
                <option value="Electrical Engineer" <?php if($jobtitle=="Electrical Engineer")echo(" selected") ?>>
                  Electrical Engineer</option>
                <option value="Civil Engineer" <?php if($jobtitle=="Civil Engineer")echo(" selected") ?>>
                  Software Manager</option>
                <option value="Others" <?php if($jobtitle=="Others")echo(" selected") ?>>
                  Not in the list..</option>
                </select>		  </td>
          </tr>
	      </table>
	    </div>
	  <div style="height:27; border-bottom:0px solid #EEEEEE; margin-bottom:5">
	    <table width="740" height="25" border="0" cellpadding="0" cellspacing="0">
	      <tr>
	        <td width="171" style="font-size:12px; padding-right:10;" align="right">Position Category</td>
            <td width="587" style="border-bottom:0px solid #EEEEEE; padding-left:10" align="left"><select name="positionCategory" id="select" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
              <option value="empty">Select a Category</option>
              <option value="Internship" <?php if($positionCategory=="Internship")echo(" selected") ?>>Internship</option>
              <option value="Full-time" <?php if($positionCategory=="Full-time")echo(" selected") ?>>Full-time</option>
              <option value="Part-time" <?php if($positionCategory=="Part-time")echo(" selected") ?>>Part-time</option>
              <option value="Others" <?php if($positionCategory=="Others")echo(" selected") ?>>Others</option>
              </select>              </td>
          </tr>
	      </table>
	    </div>
	  <div style="height:27; border-bottom:0px solid #EEEEEE; margin-bottom:2">
	    <table width="740" height="25" border="0" cellpadding="0" cellspacing="0">
	      <tr>
	        <td width="171" style="font-size:12px; padding-right:10;" align="right">Interview Type  </td>
            <td width="587" style="border-bottom:0px solid #EEEEEE; padding-left:10; font-size:12px" align="left">
              <select name="category" id="category" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
                <option value="empty" selected>Select a Type</option>
                <option value="phone interview" <?php if($category=="phone interview")echo(" selected") ?>>Phone Interview</option>
                <option value="onsite interview" <?php if($category=="onsite interview")echo(" selected") ?>>Onsite Interview</option>
                <option value="offline interview" <?php if($category=="offline interview")echo(" selected") ?>>Offline Interview</option>
                </select>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Interview Date&nbsp;&nbsp;&nbsp; 
              <select name="questionYear" style="font-size:12px; font-family:Arial, Helvetica, sans-serif">
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013" selected>2013</option>
                </select>&nbsp;
              <select name="questionMonth" style="font-size:12px; font-family:Arial, Helvetica, sans-serif">
                <option value="01" selected="selected">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
                </select>&nbsp;
              <select name="questionDay" style="font-size:12px; font-family:Arial, Helvetica, sans-serif">
                <option value="00">Day</option>
                <option value="01" <?php if($questionDay=="01")echo(" selected") ?>>01</option>
                <option value="02" <?php if($questionDay=="02")echo(" selected") ?>>02</option>
                <option value="03" <?php if($questionDay=="03")echo(" selected") ?>>03</option>
                <option value="04" <?php if($questionDay=="04")echo(" selected") ?>>04</option>
                <option value="05" <?php if($questionDay=="05")echo(" selected") ?>>05</option>
                <option value="06" <?php if($questionDay=="06")echo(" selected") ?>>06</option>
                <option value="07" <?php if($questionDay=="07")echo(" selected") ?>>07</option>
                <option value="08" <?php if($questionDay=="08")echo(" selected") ?>>08</option>
                <option value="09" <?php if($questionDay=="09")echo(" selected") ?>>09</option>
                <option value="10" <?php if($questionDay=="10")echo(" selected") ?>>10</option>
                <option value="11" <?php if($questionDay=="11")echo(" selected") ?>>11</option>
                <option value="12" <?php if($questionDay=="12")echo(" selected") ?>>12</option>
                <option value="13" <?php if($questionDay=="13")echo(" selected") ?>>13</option>
                <option value="14" <?php if($questionDay=="14")echo(" selected") ?>>14</option>
                <option value="15" <?php if($questionDay=="15")echo(" selected") ?>>15</option>
                <option value="16" <?php if($questionDay=="16")echo(" selected") ?>>16</option>
                <option value="17" <?php if($questionDay=="17")echo(" selected") ?>>17</option>
                <option value="18" <?php if($questionDay=="18")echo(" selected") ?>>18</option>
                <option value="19" <?php if($questionDay=="19")echo(" selected") ?>>19</option>
                <option value="20" <?php if($questionDay=="20")echo(" selected") ?>>20</option>
                <option value="21" <?php if($questionDay=="21")echo(" selected") ?>>21</option>
                <option value="22" <?php if($questionDay=="22")echo(" selected") ?>>22</option>
                <option value="23" <?php if($questionDay=="23")echo(" selected") ?>>23</option>
                <option value="24" <?php if($questionDay=="24")echo(" selected") ?>>24</option>
                <option value="25" <?php if($questionDay=="25")echo(" selected") ?>>25</option>
                <option value="26" <?php if($questionDay=="26")echo(" selected") ?>>26</option>
                <option value="27" <?php if($questionDay=="27")echo(" selected") ?>>27</option>
                <option value="28" <?php if($questionDay=="28")echo(" selected") ?>>28</option>
                <option value="29" <?php if($questionDay=="29")echo(" selected") ?>>29</option>
                <option value="30" <?php if($questionDay=="30")echo(" selected") ?>>30</option>
                <option value="31" <?php if($questionDay=="31")echo(" selected") ?>>31</option>
                </select>		  </td>
          </tr>
	      </table>
	    </div>
	    <table width="740" height="225" border="0" cellpadding="0" cellspacing="0">
	      <tr>
	        <td width="174" height="175" align="right" valign="top" style="font-size:12px; padding-right:10; padding-top:10">Interview Question</td>
            <td width="566" style="border-bottom:0px solid #EEEEEE; padding-left:10; padding-top:10" valign="top" align="left">
              <textarea name="descrip" style="width:450; height:200px; font-size:13px; font-family:Arial, Helvetica, sans-serif; padding:4"><?php echo($descrip)?></textarea><br /><br />
              <input type="submit" name="questionSubmit" value="Submit" style="background-image: url(img/black_cell_bg.jpg); border:1px #333333 solid;height:21; font-weight: bold; width:55; margin-top:1; padding:1 5 2 5; color:#FFFFFF; font-size:11px; font-family:Arial, Helvetica, sans-serif; cursor:pointer ">&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="checkbox" name="anony_yesno" <?php if($rstatus=='Y')echo("checked") ?> />&nbsp; 
              <font color="#000000" style='font-size:12px'>Anonymous post &nbsp;&nbsp;</font>
              <font color="#999999" style='font-size:11px'>(At least 20 letters, no more than 3000 letters)</font>              </td>
          </tr>
	      <tr>
	        <td height="50" align="right" valign="top" style="font-size:12px; padding-right:10; padding-top:5">&nbsp;</td>
            <td height="50" align="left" style="border-bottom:0px solid #EEEEEE; padding-left:10; padding-top:5">&nbsp;</td>
          </tr>
	      </table>
	      </form>	  </td>
    </tr>
    </table></td>
  </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
