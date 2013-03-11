<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];
?>

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
<script type="text/javascript">
 $(document).ready(function(){
	$("#FadeCourseInMajor").click(function(){
		$("#CourseInMajor").fadeIn("fast");
		//$("#swfupload-control").fadeIn("fast");
		$("#CourseInSubscribed").fadeOut("fast");
	});
 });
</script>
<script type="text/javascript">
 $(document).ready(function(){
	$("#FadeCourseInSubscribed").click(function(){
		$("#CourseInSubscribed").fadeIn("fast");
		//$("#swfupload-control").fadeOut("fast");
		//$("#swfupload-control").fadeIn("fast");
		$("#CourseInMajor").fadeOut("fast");
	});
 });
</script>
<div align="center" style="width:100%">
<table width="1024" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="300" align="left" valign="top" style="border-right: 1 dashed #DDDDDD;">
	  <?php include("leftHomeFileMenu.php"); ?>
	  </td>
<td width="760" valign="top" align="right">
  <?php include("HeaderEN.php"); ?>
  <table width="740" border="0" cellpadding="0" cellspacing="0" style="border:0px solid #DDDDDD">
    <tr><td align="center" style="padding-bottom:10px; border:0 #DDDDDD solid;">
  <table width="740" height="60" border="0" cellpadding="0" cellspacing="0" background="img/GrayGradbgDown.jpg" style="border-top:0px #DDDDDD solid; border-top:1px #DDDDDD dashed; margin-top:0px; margin-bottom:0px">
    <tr>
      <td width="596" height="35" align="left" style="padding-left:10px">
	  <?php
		$q = mysql_query("SELECT a.*, b.course_id, b.pid, c.course_name FROM rockinus.user_file_info a JOIN rockinus.unique_course_info b JOIN rockinus.course_info c ON a.owner='$uname' AND a.course_uid=b.course_uid AND c.course_id=b.course_id GROUP BY a.course_uid ORDER BY a.file_id DESC LIMIT 0, 30");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		echo("<div style='background-color: ; color: $_SESSION[hcolor]; font-size:18px; padding-left:5px; padding-right:10px; display:inline; border-top:0px #CCCCCC solid; border-left:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding-top:6px; height:30px'>Your Course Files Upload List <font color=#666666>($no_row)</font></div>");
		?>      </td>
      <td width="144" height="35" align="right" style="">&nbsp;</td>
    </tr>
  </table>
  <?php
			  if(isset($_SESSION['rst_msg'])){
			  	echo $_SESSION['rst_msg'];
				echo("<br>");
				unset($_SESSION['rst_msg']);
			  }
			  ?>
  <?php
		if ($no_row == 0){
		echo("<div style='background-color:#FFFFFF; font-size:16px; width:740px; padding-top:25px; padding-bottom:25px; color:#333333' align='center'><strong>You have no course files uploaded ...<br><br>");
		}
		while($object = mysql_fetch_object($q)){
			$file_id = $object->file_id;
			$file_name = $object->file_name;
			$course_uid = $object->course_uid;
			$file_size = $object->file_size;
			$dstatus = $object->dstatus;
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			$course_id = $object->course_id;
			$course_name = $object->course_name;
			$course_name = substr($course_name,0,20)."...";
			$pid = $object->pid;
			$descrip = $object->descrip;
			if(trim($pid)=="XXXXXXXXX")$pid="";
			else $pid = "| ".$pid;
			if(trim($dstatus)=='F')$dstatus_title = "Only friends can download";
			else if(trim($dstatus)=='R')$dstatus_title = "Only for requested & approved";
			else if(trim($dstatus)=='A')$dstatus_title = "Everyone can download";
			if(strlen($descrip)==0 || $descrip==NULL) $descrip = "No description for this file";
		?>
		<form action="post">
  <table width="740" height="30" border="0" cellpadding="0" cellspacing="0" background="" bgcolor="" style=" border-bottom:1px #DDDDDD solid; margin-top:10px; margin-bottom:10px">
    <tr>
      <td width="33" height="30" bgcolor="#FFFFFF" style="padding-left:5px" align="left"><img src="img/fileWhiteIcon.jpg" width="25" /> </td>
      <td width="215" height="30" align="left" style="padding-left:10px; font-size:14px; font-weight:normal; font-family:">
	  <?php echo("<a href='course_upload/$uname/$course_uid/$file_name' class=one>".substr($file_name,0,25)."...</a>"); ?> </td>
      <td width="145" height="30" align="left" style="padding-left:5px; font-size:12px">
	  <?php echo("<a href=CourseDetail.php?course_uid=$course_uid class=one>$course_id ".$pid."</a>") ?> </td>
      <td width="69" height="30" align="right" style="font-size:12px; padding-right:10px"><?php echo($file_size) ?>KB</td>
      <td width="210" height="30" align="right" style="font-size:12px; padding-right:10px; font-weight:bold">
	  <select name="dstatus" class="dstatus<?php echo($file_id) ?>" id="dstatus<?php echo($file_id) ?>">
	  <option value="A" <?php if($dstatus=='A')echo(" selected") ?>>Everyone can download</option>
	  <option value="R" <?php if($dstatus=='R')echo(" selected") ?>>Requested & Approved</option>
	  <option value="F" <?php if($dstatus=='F')echo(" selected") ?>>Only friend can download</option>
	  </select>
	  </td>
      <td width="68" height="30" align="right" style="font-size:12px; padding-right:10px">
<script type="text/javascript" >
$(function() {
	$(".save_course_file<?php echo($file_id) ?>").click(function() {
	var file_id = <?php echo($file_id) ?>;	
	var dstatus = $("#dstatus<?php echo($file_id) ?>").val();
	var sender = '<?php echo($uname) ?>';
	var dataString = 'file_id='+file_id+'&dstatus='+dstatus+'&sender='+sender; 

	$("#flashcoursefile<?php echo($file_id) ?>").show();
	$("#flashcoursefile<?php echo($file_id) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle"> <span class="loading">Saving Updates ...</span>');
 
	$.ajax({
		type: "POST",
		url: "saveCourseFile.php",
		data: dataString,
		cache: false,
		success: function(html){
			$("#displayfilerst<?php echo($file_id) ?>").after(html);
			$("#flashcoursefile<?php echo($file_id) ?>").hide();
  		}
 	});
 	return false;
 });
});
</script>
	  <span id="save_course_file<?php echo($file_id) ?>" class="save_course_file<?php echo($file_id) ?>" style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; height:15; padding: 3 5 3 5; border:1px #DDDDDD solid; background:#F5F5F5" onMouseOver="this.style.cursor='hand';">
	  Save 
	  </span>
	  </td>
    </tr>
    <tr>
      <td height="30" bgcolor="#FFFFFF" style="padding-left:3px" align="left">&nbsp;</td>
      <td height="30" align="left" style="padding-left:10px; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal">
	  <?php echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?>
	  </td>
      <td height="30" align="right" style="font-size:12px; padding-right:10px">&nbsp;</td>
      <td height="30" align="left" style="font-size:12px; padding-left:10px; font-weight:bold">&nbsp;</td>
      <td height="30" align="left" style="font-size:12px; padding-left:0px; font-weight:normal;">
      <div id="flashcoursefile<?php echo($file_id) ?>" class="flashcoursefile<?php echo($file_id) ?>" style="padding-left:0px; padding-bottom:3; padding-top:3; height:20"></div>
      <div id="displayfilerst<?php echo($file_id) ?>" class="displayfilerst<?php echo($file_id) ?>" style="padding-left:0px"></div>
	  </td>
      <td height="30" align="right" style="font-size:12px; padding-right:10px">
	  <span style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; height:15; padding: 3 5 3 5; border:1px #DDDDDD solid; background:#F5F5F5">
	  <a href="userFileList.php?action=d&&file_id=<?php echo($file_id) ?>" class="one"> Delete </a> 
	  </span>
	  </td>
    </tr>
	<tr>
      <td height="40" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
      <td height="40" colspan="5" align="left" valign="top" style=" padding:5px; padding-left:10px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; line-height:150%; color:#666666; font-weight:normal">
	  <?php echo("$descrip") ?> </td>
    </tr>
  </table>
  </form>
  <?php } ?>
</td></tr></table>
</td>
</tr>
</table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
	</body>
</html>