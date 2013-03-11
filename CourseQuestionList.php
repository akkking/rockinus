<?php 
include 'mainHeader.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];
?><style type="text/css">
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
<script type="text/javascript">
$(document).ready(function(){
	$(".showUploadDiv").click(function(){
		$(".downloadDiv").fadeOut("fast"); 
		$(".uploadDiv").fadeIn("fast"); 
	});
	
	$(".innerUploadDiv").click(function(){
		$(".downloadDiv").fadeOut("fast"); 
		$(".uploadDiv").fadeIn("fast"); 
	});
	
	$(".showDownloadDiv").click(function(){
		$(".uploadDiv").fadeOut("fast"); 
		$(".downloadDiv").fadeIn("fast"); 
	});

	$(".showSubscribeDiv").click(function(){
		$(".subscribeDiv").fadeIn("fast"); 
	});	
});
</script>
<script type="text/javascript">
var ray={
ajax:function(st){
	 this.show('load');
},

show:function(el){
	 this.getID(el).style.display='';
},

getID:function(el){
	 return document.getElementById(el);
}
}
</script>
<div align="center" style="margin-top:0px">
<table width="1024" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
  <tr>
    <td align="center" valign="top" style="border-right:1px dashed #DDDDDD; padding-top:10px"><table width="760" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
      <tr>
        <td align="right"><table width="950" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px">
            <tr  style="margin-bottom:5; padding-bottom:5">
              <td width="258" style="padding-right:5"><?php
if( isset($_GET['subscribe']) && $_GET['subscribe']=='Y' && isset($_GET['course_uid'])){
	$course_uid = $_GET['course_uid'];
	$q_uid = mysql_query("SELECT * FROM rockinus.user_course_info WHERE uname='$uname' AND course_uid='$course_uid'");
	if(!$q_uid) die(mysql_error());
	$no_row_uid = mysql_num_rows($q_uid);
	if($no_row_uid == 0){
		$sql = "INSERT INTO rockinus.user_course_info(uname,course_uid,pdate,ptime)VALUES('$uname','$course_uid',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
		//$_SESSION['common_rst_msg'] = "<div align='center' style='width:200px; padding-top:7px; padding-bottom:7px; font-size:16px; color:#000000; background:#F5F5F5'>&nbsp;&nbsp;<img src='img/addsuccessIcon_F5.jpg' width=15 />&nbsp;&nbsp; Subscribed Successful</div>"; 
	}else{
		$_SESSION['common_rst_msg'] = "<div align='center' style='width:200px; padding-top:5px; padding-bottom:5px; font-size:13px; color:#B92828; line-height:150%; background:; font-weight:bold'>You already subscribed :)</div>"; 
	}
}else{
	if(isset($_GET["course_uid"]))
		$course_uid = $_GET["course_uid"];
	else if(isset($_SESSION["course_uid"]))
		$course_uid = $_SESSION["course_uid"];
	
	$q_clicks = mysql_query("SELECT uname, clicks FROM rockinus.course_clicks WHERE course_uid='$course_uid'");
	if(!$q_clicks) die(mysql_error());
	$object = mysql_fetch_object($q_clicks);
	$clicks = $object->clicks;
	$click_uname = $object->uname;

	if($click_uname!=$uname){
		$result = mysql_query("UPDATE rockinus.course_clicks SET clicks=clicks+1, uname='$uname' WHERE course_uid='$course_uid'");
		if (!$result) die('Invalid query: ' . mysql_error());
	}
}
			  
			  
//Global Variable: 
$page_name = "SchoolCourse.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
if(isset($_GET["course_uid"]))
	$course_uid = $_GET["course_uid"];
else
	$course_uid = $_SESSION["course_uid"];
	
//$sql = "SELECT a.course_name, a.mid, a.sid, b.pid FROM rockinus.course_info a JOIN rockinus.unique_course_info b ON b.course_uid = '$course_uid'";
//mysql_query("SET NAMES GBK");
$q = mysql_query("SELECT a.course_name, a.mid, a.sid, b.pid FROM rockinus.course_info a JOIN rockinus.unique_course_info b ON b.course_uid = '$course_uid' AND a.course_id=b.course_id");
//echo($sql);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
//if($no_row == 0) echo("No matches met your criteria.");
$object = mysql_fetch_object($q);
$pid = $object->pid;
$mid = $object->mid;
$sid = $object->sid;
$course_name = $object->course_name;

$q1 = mysql_query("SELECT * FROM rockinus.school_info where sid='$sid'");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
//if($no_row == 0) echo("No matches met your criteria.");
$object = mysql_fetch_object($q1);
$school_name = $object->school_name;

$q_m = mysql_query("SELECT major_name FROM rockinus.major_info where mid='$mid'");
if(!$q_m) die(mysql_error());
$no_row = mysql_num_rows($q_m);
if($no_row == 0) echo("No Major Name found for this course.");
$object = mysql_fetch_object($q_m);
$major_name = $object->major_name;
?>              </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="313" valign="top" align="right"><div style=" width:950; padding-bottom:10;" align="right">
            <table width="950" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left"><?php  
						if(isset($_SESSION['rst_msg'])){
							echo($_SESSION['rst_msg']); 
							unset($_SESSION['rst_msg']); 
						}?>
                    <table width="950" height="75" border="0" cellpadding="0" cellspacing="0" background="img/GrayGradbgDown.jpg" style="margin-top:10; margin-bottom:10px; border-top:1px solid #333333	">
                      <tr>
                        <td height="35" colspan="2" style=" background:<?php echo($_SESSION['hcolor']) ?>; padding-left:15; border-bottom:1px #CCCCCC solid"><strong> <?php echo("<a href=CourseDetail.php?course_uid=$course_uid class=one><font color=#FFFFFF size=3>$course_name </font></a>| <a href=MajorDetail.php?sid=$sid&&mtype=Master&&mid=$mid class=one><font size=3 color=#DDDDDD>$major_name</font></a>")?> </strong> </td>
                      </tr>
                      <tr>
                        <td width="714" height="50" align="left" valign="top" background="img/GrayGradbgDown.jpg" style="padding-left:15; padding-top:10; border-bottom:0 #EEEEEE solid; font-size:14px"><font color="#999999">Professor : </font><?php echo("$pid | <font color=#999999>$clicks click(s)</font>") ?> </td>
                        <td width="310" height="50" align="right" background="img/GrayGradbgDown.jpg" style="border-bottom:0 #EEEEEE solid; padding-right:20px; color:#F5F5F5; font-size:18px"></td>
                      </tr>
                    </table>
                  <table width="950" height="50" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="521"><?php
				$q_uid = mysql_query("SELECT * FROM rockinus.user_course_info where uname='$uname' && course_uid='$course_uid'");
				if(!$q_uid) die(mysql_error());
				$no_row_uid = mysql_num_rows($q_uid);
				if($no_row_uid == 0){				
				?>
                            <a href="CourseDetail.php?subscribe=Y&amp;&amp;course_uid=<?php echo($course_uid) ?>"> <span style="color:#000000; border:1px #999999 solid; padding:3 8 3 8; background: url(img/master.png); display:inline; height:15px; font-size:12px; font-weight: normal; -moz-border-radius: 3px; border-radius: 3px; cursor:pointer" class="showSubscribeDiv" align="center" onmouseover="this.style.background='url(img/master.jpg)'" onmouseout="this.style.background='url(img/master.png)'"> + Subscribe </span></a>
                            <?php
				}else{
				?>
                            <span style="color:#000000; border-bottom:1px #999999 solid; border-right:1px #999999 solid; padding:5 10 5 10; background: url(img/master.png); display:inline; height:20px; font-size:12px; font-weight: normal" align="center"> <img src="img/addsuccessIcon_F5.jpg" width="12" />&nbsp;  Subscribed </span>
                            <?
				}
				?>
                          &nbsp;&nbsp; <a href='CourseDetail.php?course_uid=<?php echo($course_uid) ?>'><span style="color:#000000; border:1px #999999 solid; padding:3 8 3 8; background: url(img/master.png); display:inline; height:15px; font-size:12px; font-weight: normal; -moz-border-radius: 3px; border-radius: 3px; cursor:pointer" align="center" class="showUploadDiv" onmouseover="this.style.background='url(img/master.jpg)'" onmouseout="this.style.background='url(img/master.png)'"> Comment List </span></a>&nbsp;&nbsp; <span style="color:#000000; border:1px #999999 solid; padding:3 8 3 8; background: url(img/<?php echo(substr($_SESSION['hcolor'],1,6)."_ajax_button.jpg") ?>); display:inline; -moz-border-radius: 3px; border-radius: 3px; height:15px; font-size:12px; font-weight: normal;" align="center" class="showDownloadDiv"> Question Memory </span> </td>
                        <td width="219" align="right" style="padding-right:0px"><?php  
					if(isset($_SESSION['common_rst_msg'])){
						echo($_SESSION['common_rst_msg']); 
						unset($_SESSION['common_rst_msg']); 
				}?>                        </td>
                      </tr>
                    </table>
                  <table width="950" border="0" cellpadding="0" cellspacing="0" style="margin-top:15" id="memoTable" class="memoTable">
                      <tr>
                        <td width="710" height="41" colspan="3" align="left"><?php
mysql_query("SET NAMES UTF8");
	$q1 = mysql_query("SELECT * FROM rockinus.course_question_info a JOIN rockinus.user_info b ON a.course_uid='$course_uid' AND a.sender=b.uname ORDER BY a.q_id DESC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("<div style='padding: 25px; border:#DDDDDD solid 1px; background-color:#F5F5F5; margin-top:10; margin-bottom:20; vertical-align:top; font-size:18px; -moz-border-radius: 5px; border-radius: 5px; width:500px; padding-left:0' align='center'><font color=#333333>&nbsp;&nbsp;No memorized questions made to this course so far!</font></div>");}
if($no_row > 0){ 
while($object = mysql_fetch_object($q1)){
	$q_id = $object->q_id;
	$loopfname = $object->fname;
	$looplname = $object->lname;
	$sender = $object->sender;
	$termType = $object->termType;
	$rating = $object->rating;
	$question_rstatus = $object->rstatus;
	$descrip = $object->descrip;
	$descrip = str_replace("\\","",$descrip);
	$ptime = $object->ptime;
	$pdate = $object->pdate; 
?>
                            <div style="padding-left:0; line-height:180%; padding-bottom:10; padding-top:0; width: 950px; border-bottom:0px #DDDDDD solid">
                              <table width="950" height="63" border="0" cellpadding="0" cellspacing="0" style=" background:#F5F5F5; border-bottom:1px #DDDDDD solid">
                                <tr>
                                  <td height="29" align="left" style="font-size:13px; padding-left:10px"><?php 
				if($question_rstatus=='N')
					echo("<strong><a href=RockerDetail.php?uid=$sender class=one><font color=$_SESSION[hcolor]>$loopfname $looplname</font></a></strong> posted a $termType question:");
				else
					echo("<strong>Anonymous</strong> posted a $termType question:");	
				?>                                  </td>
                                  <td width="221" align="center" style="font-size:12px; font-weight:normal; color:<?php echo($_SESSION['hcolor']) ?>"><?php 
								?></td>
                                  <td width="198" align="right" style=" color: #999999; font-size:11px; padding-right:10px"><?php echo(getDateName($pdate)) ?> | <?php echo(substr($ptime,0,5)) ?></td>
                                </tr>
                                <tr>
                                  <td height="33" colspan="3" style="padding:10px; padding-top:5px; line-height:125%; font-size:13px"><?php
								echo(nl2br($descrip));
								?>                                  </td>
                                </tr>
                              </table>
                            </div>
                          <?php }}?></td>
                      </tr>
                    </table>
                  <form action="CourseQuestion.php" method="post" style="margin:0">
                      <table width="950" border="0" cellpadding="0" cellspacing="0" style="border-top:#CCCCCC solid 0; margin-top:15px">
                        <tr>
                          <td width="404" height="30" align="left" style="padding-left:5px; padding-top: 5px; font-size:14px; color: <?php echo($_SESSION['hcolor']) ?>; font-size:18px"><img src="img/smileyIcon.png" width="20" />&nbsp; <?php echo($uname_fname) ?>, postPost your memorized question: </td>
                          <td width="253" height="30" align="left" style=" font-size:13px; font-family:Arial, Helvetica, sans-serif"><input type="radio" name="termType" value="Midterm" <?php if(isset($_SESSION['termType'])&&$_SESSION['termType']=="Midterm")echo("checked"); ?> />
                            Mid-term 
                            &nbsp;&nbsp;
                                                  <input type="radio" name="termType" value="Finals" <?php if(isset($_SESSION['termType'])&&$_SESSION['termType']=="Finals")echo("checked"); ?> />
                            Finals 
                          </td>
                          <td width="293" align="left" style=" font-size:13px; font-family:Arial, Helvetica, sans-serif">
						                                                    <input type="radio" name="season" value="Spring" <?php if(isset($_SESSION['season'])&&$_SESSION['season']=="Spring")echo("checked"); ?> />
                            Spring 
                            &nbsp;&nbsp;
                                                  <input type="radio" name="season" value="Fall" <?php if(isset($_SESSION['season'])&&$_SESSION['season']=="Fall")echo("checked"); ?> />
                            Fall
                            &nbsp;&nbsp;
                                                  <input type="radio" name="season" value="Forgot" <?php if(isset($_SESSION['season'])&&$_SESSION['season']=="Forgot")echo("checked"); ?> />
                            I forgot
						  </td>
                        </tr>
                        <tr>
                          <td height="86" colspan="4" align="left" style="padding-left:0px; padding-top:7"><textarea name="description" rows="8" style="width:900px; height:220px; padding:4px; line-height:130%; font-size:14px; border:0px; background:#F5F5F5"><?php if(isset($_SESSION['descrip']))echo($_SESSION['descrip']); ?></textarea>
                              <div style="width:950; height:35; padding-top:12px" align="left">
                                <input type="hidden" value="CourseQuestionList.php?course_uid=<?php echo($course_uid) ?>" name="pagename" />
                                <input type="hidden" value="<?php echo($course_uid) ?>" name="course_uid" />
                                <input type="submit" name="questionSubmit" value="Submit" style="height:22; padding:3 10 3 10; background: url(img/black_cell_bg.jpg); border:1px solid #333333; line-height:120%; font-size:13px; cursor:pointer; color:#FFFFFF; display:inline" />
                                &nbsp;&nbsp;
                                <input type="checkbox" name="anony_yesno" />
                                &nbsp; <font color="#000000" style='font-size:13px'>Anonymous &nbsp;&nbsp;</font> <font color="#999999" style='font-size:12px'>(Please mention the question season if you can) (Leastly 20 letters, no more than 3000 letters)</font> </div>
                            <br />
                              <br />                          </td>
                        </tr>
                      </table>
                  </form>
                  <div align="left">
                      <table width="600" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td style="padding-left:10px">&nbsp;</td>
                        </tr>
                      </table>
                  </div></td>
              </tr>
            </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
