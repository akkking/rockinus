<?php 
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
$ua=getBrowser();
$uid = $uname;  
  
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
<style>
#myBox {
  margin: 0.5in auto;
  color: #fff;
  width: 250px;
  height: 300px;
  padding: 0px;
  text-align: left;
  background-image: url(
  <?php
  $pic250_Name = $uname.'250.jpg';
  	$target = "upload/".$uname;
	if(is_dir($target)){
		echo("upload/$uname/$pic250_Name?".time());
	}else 
		echo("img/NoUserIcon250.jpg");
	?>
  );
  background-repeat: no-repeat;
  margin-bottom:0px;
  margin-top:0px;
  border:0px #CCCCCC solid;
}
</style>
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
	  
	   <table height="30" width="740" border="0" cellspacing="0" cellpadding="0" style="border-bottom:0px solid #DDDDDD">
  <tr>
    <td width="100">
	<div style="width:90px; height:30; padding-top:5; border:1px #333333 solid; display:inline; background:<?php echo($_SESSION['hcolor']) ?>; border-bottom:0; font-weight:bold; font-size:14px" align="center"><a href="userPage.php">Home</a></div></td>
    <td width="100">
	<div style="width:90px; height:30; padding-top:5; border:1px #CCCCCC solid; display:inline; background:#F5F5F5; border-bottom:0; font-weight:bold; font-size:14px" align="center"><a href="manageStatus.php" class="one">Status</a></div></td>
    <td width="387">&nbsp;</td>
    <td width="75">&nbsp;</td>
    <td width="78">&nbsp;</td>
  </tr>
</table>

	   <table width="740" height="300" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px">
         <tr>
           <td width="250" valign="top"><div id="myBox"></div></td>
           <td width="490" valign="top" style="padding-left:30"><table width="450" height="300" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="50" valign="top" style=" font-weight:bold; font-size:32px; color:<?php echo($_SESSION['hcolor']) ?>; font-family:Verdana, Arial, Helvetica, sans-serif;">
	<?php echo($fname." ".$lname) ?></td>
  </tr>
  <tr>
    <td><font style="font-size:16px; color:#000000; font-weight:normal"><?php echo($cschool)?></font></td>
  </tr>
  <tr>
    <td><font style="font-size:16px; color:#000000; font-weight:normal"><?php echo($major_name)?></font></td>
  </tr>
  <tr>
    <td><font style="font-size:16px; color:#000000; font-weight:normal"><?php echo($cdegree." student ($sterm)")?></font></td>
  </tr>
  <tr>
    <td><font style="font-size:16px; color:#000000; font-weight:normal"><?php echo("From $fregion, ".$fcountry)?></font></td>
  </tr>
  <tr>
    <td><font style="font-size:16px; color:#000000; font-weight:normal"><?php echo("Now in $ccity, ".$cstate)?></font></td>
  </tr>
  <tr>
    <td>
	<div style="font-size:18px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:100px; height:35; border:1px #000000 solid; background: url(img/black_cell_bg.jpg); color:#FFFFFF; padding-top:5; display:inline" align="center">
	<a href="SendMessage.php?recipient=<?php echo($uid) ?>">Message</a>
	</div>
	</td>
  </tr>
</table>
		   <table border="0" cellpadding="0" cellspacing="0" style="margin-top:20">
		     <tr><td>

		   </td></tr></table>
		   </td>
           </tr>
       </table>
	   <table width="405" height="85" border="0" cellpadding="0" cellspacing="0" style="border-right:0 solid #DDDDDD">
         <tr>
           <td width="663" valign="top" style="padding-left:10; padding-bottom:5px; background-color:#FFFFFF; padding-top:15">
		   <table border="0" align="center" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid; border-top:0">
                <tr>
                  <td width="740" align="center" style="padding-bottom:10px" valign="top"><table width="740" height="30" border="0" cellpadding="0" cellspacing="0" background="img/master.png" style="border-top:0px #DDDDDD solid; border-bottom:2px #DDDDDD solid; margin-bottom:10px">
                      <tr>
                        <td width="660"><?php
		$q = mysql_query("SELECT a.*, b.course_id, b.pid, c.course_name FROM rockinus.user_file_info a JOIN rockinus.unique_course_info b JOIN rockinus.course_info c ON a.owner='$uid' AND a.course_uid=b.course_uid AND c.course_id=b.course_id GROUP BY a.course_uid ORDER BY a.file_id DESC LIMIT 0, 30");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($uid==$uname) 
			echo("<strong><div style='background-color: ; color: #000000; font-size:14px; padding-left:10px; padding-right:10px; display:inline; border-top:0px #CCCCCC solid; border-left:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding-top:6px; height:30px'>Your Course Files Upload List <font color=#666666>($no_row)</font></div></strong>");
else 
	echo("<strong><div style='background-color: ; color: #000000; font-size:14px; padding-left:10px; padding-right:10px; display:inline; border-top:0px #CCCCCC solid; border-left:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding-top:6px; height:30px'>$uid's Course Files Upload List <font color=#666666>($no_row)</font></div></strong>");
				?>                         </td>
                        <td width="80" align="center" bgcolor="#666666" style="font-size:14px; font-weight:bold; color:<?php echo($_SESSION['hcolor']) ?>">
						<?php if($uid==$uname)echo("<a href='uploadCourseFile.php'>+ Upload</a>") ?>						</td>
                      </tr>
                     </table>
                     <?php
		if ($no_row == 0){
			if($uid==$uname)
				echo("<div style='background-color:#FFFFFF; font-size:16px; width:710px; padding-top:15px;padding-bottom:25px; color:#666666' align='center'><strong>You have no course files uploaded ...<br><br><div style='display:inline; background:#EEEEEE; padding:5px; padding-left: 10px; padding-right:10px; border: 1px #DDDDDD solid' onmouseover='this.style.backgroundColor = #DDDDDD; this.style.borderColor = #CCCCCC;' onmouseout='this.style.backgroundColor = #EEEEEE;this.style.borderColor = #DDDDDD;'><a href='uploadCourseFile.php' class='one'><font color=$_SESSION[hcolor]>+ Upload</font></a></div></strong></div>");
			else
				echo("<div style='background-color:#FFFFFF; font-size:16px; width:710px; padding-top:15px;padding-bottom:20px; color:#666666' align='center'><strong>The user has no course files uploaded ...</strong></font></div>");
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
			if(trim($dstatus)=='F')$dstatus = "Only friends can download";
			else if(trim($dstatus)=='R')$dstatus = "Only for requested & approved";
			else if(trim($dstatus)=='A')$dstatus = "Everyone can download";
			if(strlen($descrip)==0 || $descrip==NULL) $descrip = "No description for this file";
		?>
                     <table width="740" height="30" border="0" cellpadding="0" cellspacing="0" background="" bgcolor="#FFFFFF" style="margin-top:5px; border-bottom:1px #EEEEEE dashed">
                       <tr>
                         <td width="30" height="30" align="left"><img src="img/fileWhiteIcon.jpg" width="25" /> </td>
                         <td width="210" height="30" align="left" style="padding-left:10px; font-size:12px; font-weight:bold"><?php echo("<a href='course_upload/$uid/$course_uid/$file_name' class=one>".substr($file_name,0,28)."...</a>"); ?> </td>
                         <td width="173" height="30" align="left" style="padding-left:10px; font-size:12px"><?php echo("<a href=CourseDetail.php?course_uid=$course_uid class=one><font color=$_SESSION[hcolor]>$course_id ".$pid."</font></a>") ?> </td>
                         <td width="65" height="30" align="right" style="font-size:12px; padding-right:10px"><?php echo($file_size) ?>KB</td>
                         <td width="208" height="30" align="left" style="font-size:12px; padding-left:10px"><?php echo($dstatus) ?></td>
                         <td width="54" height="30" align="right" style="font-size:12px; padding-right:10px"><a href="FileConfirm.php?file_id=<?php echo($file_id) ?>&amp;&amp;pageName=RockerDetail" class="one"> <font color="<?php echo($_SESSION['hcolor']) ?>">Delete</font> </a> </td>
                       </tr>
                       <tr>
                         <td height="35" style="padding-left:5px;">&nbsp;</td>
                         <td height="35" colspan="5" align="left" bgcolor="" style="padding-left:10px; font-size:12px; line-height:150%; color:#666666; font-weight:bold;">
						 <?php echo("$descrip") ?> </td>
                       </tr>
                    </table>
                    <?php } ?>                   </td>
                </tr>
           </table>
             <table border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="margin-top:25px; border:0px #DDDDDD solid; border-top:0">
                <tr>
                  <td width="740" align="center" style="padding-bottom:15px">
				  <table width="740" height="35" border="0" cellpadding="0" cellspacing="0" background="img/master.png" style="border-top:0px #DDDDDD solid; border-bottom:1px #999999 solid; margin-bottom:10px">
                       <tr>
                         <td width="657" valign="top"><?php
		$q_resume = mysql_query("SELECT * FROM rockinus.user_file_info WHERE course_uid='0' AND owner='$uid' ORDER BY file_id DESC LIMIT 0, 30");
		if(!$q_resume) die(mysql_error());
		$no_row_resume = mysql_num_rows($q_resume);
		if($uid==$uname) echo("<strong><div style='background-color: ; color: #000000; font-size:14px; padding-left:10px; padding-right:10px; display:inline; border-top:0px #CCCCCC solid; border-left:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding-top:6px; height:30px'>Your Resume & Cover Letter List <font color=#666666>($no_row_resume)</font></div></strong>");
else echo("<strong><div style='background-color: ; color: #000000; font-size:14px; padding-left:10px; padding-right:10px; display:inline; border-top:0px #CCCCCC solid; border-left:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding-top:6px; height:30px'>$uid's Resume & Cover Letter List <font color=#666666>($no_row_resume)</font></div></strong>");
				?>                         </td>
                         <td width="83" align="right" style="padding-right:10px; font-size:12px; font-weight:bold; color:<?php echo($_SESSION['hcolor']) ?>"><?php if($uid==$uname)echo("<a href='uploadCourseFile.php' class=one>+ Upload</a>") ?>                         </td>
                       </tr>
                    </table>
                      <?php
		if ($no_row_resume == 0){
			if($uid==$uname)
				echo("<div style='background-color:#FFFFFF; font-size:16px; width:710px; padding-top:15px;  color:#666666; padding-bottom:25px' align='center'><strong>You have no files uploaded ...<br><br><div style='display:inline; background:#EEEEEE; padding:5px; padding-left: 10px; padding-right:10px; border: 1px #DDDDDD solid' onmouseover='this.style.backgroundColor = #DDDDDD; this.style.borderColor = #CCCCCC;' onmouseout='this.style.backgroundColor = #EEEEEE;this.style.borderColor = #DDDDDD;'><a href='uploadCourseFile.php' class='one'><font color=$_SESSION[hcolor]>+ Upload</font></a></div></strong></div>");
			else
				echo("<div style='background-color:#FFFFFF;  color:#666666; font-size:16px; width:710px; padding-top:15px;padding-bottom:20px' align='center'><strong>The user has no files uploaded ...</strong></div>");
		}
		
		while($object = mysql_fetch_object($q_resume)){
			$file_name = $object->file_name;
			$file_id = $object->file_id;
			$file_size = $object->file_size;
			$dstatus = $object->dstatus;
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			$descrip = $object->descrip;
			if(trim($dstatus)=='F')$dstatus = "Only friends can download";
			else if(trim($dstatus)=='R')$dstatus = "Only for requested & approved";
			else if(trim($dstatus)=='A')$dstatus = "Everyone can download";
			if(strlen($descrip)==0 || $descrip==NULL) $descrip = "No description for this file";
		?>
           <table width="740" height="30" border="0" cellpadding="0" cellspacing="0" background="" bgcolor="#ffffff" style="border-bottom:1px #EEEEEE dashed; margin-top:5px">
                   <tr>
                          <td width="30" height="30" align="left"><img src="img/fileWhiteIcon.jpg" width="25" /> </td>
                          <td width="384" height="30" align="left" style="padding-left:10px; font-size:12px; font-weight:bold"><?php echo("<a href='resume_upload/$uid/$file_name' class=one>".substr($file_name,0,50)."</a>"); ?> </td>
                          <td width="65" height="30" align="right" style="font-size:12px; padding-right:10px"><?php echo($file_size) ?>KB</td>
                          <td width="207" height="30" align="left" style="font-size:12px; padding-left:10px"><?php echo($dstatus) ?></td>
                          <td width="54" height="30" align="right" style="font-size:12px; padding-right:10px"><a href="FileConfirm.php?file_id=<?php echo($file_id) ?>&amp;&amp;pageName=RockerDetail" class="one"> <font color="<?php echo($_SESSION['hcolor']) ?>">Delete</font> </a> </td>
                      </tr>
                        <tr>
                          <td height="35" style="padding-left:5px;">&nbsp;</td>
                          <td height="35" colspan="4" align="left" bgcolor="" style="padding-left:10px; font-size:12px; line-height:150%; color:#666666; font-weight:bold;"><?php echo("$descrip") ?> </td>
                        </tr>
                    </table>
                    <?php } ?>                   </td>
                </tr>
               </table>
             <table width="740" height="30" border="0" cellpadding="0" cellspacing="0" background="img/master.png" style="border-top:0px #DDDDDD solid; border-bottom:1px #999999 solid; margin-top:25px">
                 <tr>
                   <td width="657"><?php
		include 'dbconnect.php';
						
		$sql_stmt = "SELECT hid,uname,subject,rentlease,pdate,ptime,'house_info' AS tbname, type, city, rate, NULL as col_1, NULL as col_2, descrip 
					FROM rockinus.house_info a WHERE uname='$uid' 
					UNION 
					SELECT aid,uname,subject,buysale,pdate,ptime,'article_info' AS tbname,aname,city,rate,delivery,type, descrip 
					FROM rockinus.article_info b WHERE uname='$uid' 
					UNION 
					SELECT foid,creater,subject,category,pdate,ptime,'forum_info' AS tbname,NULL,NULL,NULL,NULL,NULL, descrip 
					FROM rockinus.forum_info b WHERE creater='$uid' 
					UNION 
					SELECT job_id,creater,subject,category,pdate,ptime,'job_info' AS tbname,rstatus,NULL,NULL,NULL,NULL, descrip 
					FROM rockinus.job_info b WHERE creater='$uid' 
					UNION 
					SELECT memoid,sender,NULL,NULL,pdate,ptime,'memo_info' AS tbname,NULL,NULL,NULL,NULL,level,descrip 
					FROM rockinus.memo_info b WHERE sender='$uid' AND descrip<>''
					UNION 
					SELECT course_uid, sender, descrip, rating, pdate, ptime, tbname, NULL, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.course_memo_info c WHERE sender='$uid'  
					UNION 
					SELECT eid, creater, eventTitle, descrip, pdate, ptime, tbname, eventSpot, NULL,NULL, NULL, NULL, NULL 
					FROM rockinus.event_info d WHERE creater='$uid'  
					UNION 
					SELECT cafeid, creater, cafeTitle, descrip, pdate, ptime, tbname, category, location, NULL, NULL, NULL, NULL 
					FROM rockinus.cafe_info e WHERE creater='$uid'  
					UNION 
					SELECT cafefoodid, sender, rating, descrip, pdate, ptime, tbname, type, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.cafefood_memo_info f WHERE sender='$uid'  
					UNION 
					SELECT cid,sender,recipient,NULL,pdate,ptime,'house_comment' AS tbname,hid,NULL,NULL,rstatus,NULL, descrip 
					FROM rockinus.house_comment g WHERE sender='$uid'
					ORDER BY pdate DESC, ptime DESC";
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		 
if($uid==$uname) echo("<strong><div style='background-color: ; color: $_SESSION[hcolor]; font-size:14px; padding-left:10px; padding-right:10px; display:inline; border-top:0px #CCCCCC solid; border-left:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding-top:6px; height:30px'>Personal Information Activity <font color=#666666>($no_row)</font></div></strong>");
else echo("<strong><div style='background-color: ; color: $_SESSION[hcolor]; font-size:14px;  padding-left:10px; padding-right:10px; display:inline; border-top:0px #CCCCCC solid; border-left:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding-top:6px; height:30px'>$uid's Information Activity <font color=#666666>($no_row)</font></div></strong>");
?></td>
                   <td width="83" align="right" style="padding-right:10px; font-size:12px">See All &gt;&gt;</td>
                 </tr>
                            </table>
             <?php
		if($no_row == 0) echo("<div style='padding-top:30px; padding-bottom:30px; padding-left:5px; color:#666666; font-size:16px' align='center'><strong><img src='img/join.jpg'>&nbsp;&nbsp; The user has nothing posted yet ...</strong></div>");
		while($object = mysql_fetch_object($q)){
			$id = $object->hid;			
			$loopname = $object->uname;
			$subject = $object->subject;
			$subject = str_replace("\\","",$subject);
			$action = $object->rentlease;		
			$pdate = $object->pdate;
			$ptime = $object->ptime;		
			$tbname = $object->tbname;	
			$xxxx = $object->col_1;
			$aname = $object->col_2;
			$descrip = $object->descrip;
			$descrip = str_replace("\\","",$descrip);
			$type = $object->type;
			$city = $object->city;
			$rate = $object->rate;
			//if(strlen($subject)>50) $subject = substr(trim($subject), 0, 50)."...";	
			if($tbname=="house_info"){
							?>
               <div style="border-bottom:1px #DDDDDD solid; border-top:1px #FFFFFF solid; padding-bottom:15px; padding-top:15px" onmouseover="document.getElementById('dh<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('mh<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('dh<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('mh<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
                 <table width="740" height="70" border="0" cellpadding="0" cellspacing="0">
                   <tr>
                     <td width="35" rowspan="2" align="center" valign="top" style="padding-top:10"><font size="2" color="<?php echo($_SESSION['hcolor'])?>"><img src="img/housewoodicon.jpg" width="25" height="25" /></font></td>
                     <td width="591" height="35" align="left" style="padding-left:10px; font-size:14px"><?php 
								  echo("<a href=HouseDetail.php?hid=$id class=one><strong>".substr($subject,0,50)." ...</strong></a>");
							  ?></td>
                     <td width="114" style="padding-right:10px" align="right"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5))?> </font> </td>
                   </tr>
                   <tr>
                     <td height="35" align="left" style="padding-left:10px; padding-top:5px; line-height:150%; font-size:14px"><?php 
						  if(strlen($descrip)>20)
						  	echo(substr(nl2br($descrip),0,500)." ...");
						  else
						    echo("<a href=HouseDetail.php?aid=$id class=one>Click for details >>></a>");
					  ?>                     </td>
                     <td style="padding-right:10px" align="right" valign="top"><?php 
					  if($uname==$loopname)echo("<span id='dh$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=HouseConfirm.php?hid=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='mh$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditHouse.php?hid=$id><font size=1>+ Edit</font></a></span>");
					  ?>                     </td>
                   </tr>
                 </table>
                 <?php
		$x = mysql_query("SELECT * FROM rockinus.house_comment WHERE hid='$id' ORDER BY pdate DESC, ptime DESC");
		if(!$x) die(mysql_error());
		$no_row_house = mysql_num_rows($x);
		if($no_row_house>0){
			while($ob = mysql_fetch_object($x)){
				$cid = $ob->cid;
				$descrip = $ob->descrip;
				$loopsender = $ob->sender;
				$rstatus = $ob->rstatus;
        ?>
                 <table width="740" height="60" border="0" cellpadding="0" cellspacing="0" bgcolor="" style="margin-top:15">
                   <tr>
                     <td height="25" align="right" valign="top" style="padding:8; padding-right:10"><?php
			if($rstatus=="N" && $uid==$uname && $loopsender!=$uname){
				echo("<span style='background-color:#B92828; color: #FFFFFF'><strong>&nbspNew&nbsp;</strong></span>");
				$q_hhis = mysql_query("UPDATE rockinus.house_comment SET rstatus='Y' WHERE cid='$cid';");
				if(!$q_hhis) die(mysql_error());
			}
		?></td>
                     <td width="704" height="25" align="left" valign="middle" bgcolor="#F5F5F5" style="padding-left:8;"><?php 
					  if($loopsender==$uname)echo("<font color=$_SESSION[hcolor]>You</font><font color=#CCCCCC> said:</font>");
					  else echo("<font color=$_SESSION[hcolor]>$loopsender</font><font color=#CCCCCC>  said:</font>") 
					  ?></td>
                   </tr>
                   <tr>
                     <td width="36" height="30" align="right" valign="top" style="padding-top:5px">&nbsp;</td>
                     <td height="30" align="left" valign="middle" bgcolor="#F5F5F5" style="padding:8; font-size:14px; line-height:150%"><?php 
						 echo($descrip);
					  ?>                     </td>
                   </tr>
                 </table>
                 <?php
					  				}
								} 
								?>
                              </div>
              <?php	}else if($tbname=="article_info"){
							?>
               <div style="border-bottom:1px #DDDDDD solid; border-top:0px #EEEEEE solid; padding-bottom:15px; padding-top:15px" onmouseover="document.getElementById('da<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('ma<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('da<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('ma<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
                 <table width="740" height="70" border="0" cellpadding="0" cellspacing="0">
                   <tr>
                     <td width="33" rowspan="2" align="center" valign="top" style="padding-top:10"><font size="2" color="<?php echo($_SESSION['hcolor'])?>"><img src="img/dollar.jpg" width="25" height="25" /></font></td>
                     <td width="586" height="35" align="left" style="padding-left:10px; font-size:14px"><?php 
						  echo("<a href=ArticleDetail.php?aid=$id class=one><strong>".substr($subject,0,40)." ...</strong></a>");
					?>                     </td>
                     <td width="121" style="padding-right:10px" align="right"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5))?></font></td>
                   </tr>
                   <tr>
                     <td height="35" align="left" valign="top" style="padding: 10; padding-top:5px; font-size:14px; line-height: 150%"><?php 
						  if(strlen($descrip)>20)
						  	echo(substr(nl2br($descrip),0,500)." ...");
						  else
						    echo("<a href=ArticleDetail.php?aid=$id class=one>Click for details >>></a>");
					  ?>                     </td>
                     <td style="padding-right:10px" align="right" valign="top"><?php 
					  if($uname==$loopname)echo("<span id='da$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=ArticleConfirm.php?aid=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='ma$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditArticle.php?aid=$id><font size=1>+ Edit</font></a></span>");
					  ?>                     </td>
                   </tr>
                 </table>
                 <?php
		$y = mysql_query("SELECT * FROM rockinus.article_comment WHERE aid='$id' ORDER BY pdate DESC, ptime DESC");
		if(!$y) die(mysql_error());
		$no_row_article = mysql_num_rows($y);
		if($no_row_article>0){
			while($obj = mysql_fetch_object($y)){
				$cid = $obj->cid;
				$descrip = $obj->descrip;
				$loopsender = $obj->sender;
				$rstatus = $obj->rstatus;
        ?>
                 <table width="740" height="64" border="0" cellpadding="0" cellspacing="0" bgcolor="" style="margin-top:15px">
                   <tr>
                     <td height="25" align="right" valign="middle" style="padding-right:10"><?php
			if($rstatus=="N" && $uid==$uname && $loopsender!=$uname){
				echo("<span style=background-color:#B92828; color:#FFFFFF><strong>&nbspNew&nbsp;</strong></span>");
				$q_ahis = mysql_query("UPDATE rockinus.article_comment SET rstatus='Y' WHERE cid='$cid';");
				if(!$q_ahis) die(mysql_error());
			}
		?>                     </td>
                     <td width="707" height="25" align="left" valign="middle" bgcolor="#F5F5F5" style="padding:8; font-size:14px"><?php 
					  if($loopsender==$uname)echo("<font color=$_SESSION[hcolor]>You</font><font color=#CCCCCC> said:</font>");
					  else echo("<font color=$_SESSION[hcolor]>$loopsender</font><font color=#CCCCCC>  said:</font>") 
					  ?></td>
                   </tr>
                   <tr>
                     <td width="33" height="39" align="right" valign="top" style="padding-top:10">&nbsp;</td>
                     <td height="39" align="left" valign="top" bgcolor="#F5F5F5" style="padding:8;"><?php 
								 echo($descrip);
							  ?></td>
                   </tr>
                 </table>
                 <?php
					  				}
								} 
								?>
                              </div>
              <?php 
							}else if($tbname=="forum_info"){
							?>
               <div style="border-bottom:1px #DDDDDD solid; border-top:1px #FFFFFF solid; padding-bottom:20px; padding-top:15px" onmouseover="document.getElementById('df<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('mf<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('df<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('mf<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
                 <table width="740" height="70" border="0" cellpadding="0" cellspacing="0">
                   <tr>
                     <td width="32" rowspan="2" align="center" valign="top" style="padding-top:10"><font size="2" color="<?php echo($_SESSION['hcolor'])?>"> <img src="img/notesicon.jpg" width="25" height="25" /></font></td>
                     <td width="572" height="35" align="left" style="padding-left:10px; line-height: 150%; font-size:14px"><?php 
						  echo("<a href=forumDetail.php?foid=$id class=one><strong>".substr($subject,0,80)." ...</strong></a>");
						?>                     </td>
                     <td width="136" style="padding-right:10px" align="right"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5))?> </font> </td>
                   </tr>
                   <tr>
                     <td height="35" align="left" style="padding:10px; padding-top:5px; line-height:150%; font-size:15px"><?php 
						  if(strlen($descrip)>20)
						  	echo(substr(nl2br($descrip),0,500)." ...");
						  else
						    echo("<a href=forumDetail.php?aid=$id class=one>Click for details >>></a>");
					  ?>                     </td>
                     <td style="padding-right:10px" align="right" valign="top"><?php 
					  if($uname==$loopname)echo("<span id='df$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=ForumConfirm.php?foid=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='mf$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditForum.php?foid=$id><font size=1>+ Edit</font></a></span>");
					  ?>                     </td>
                   </tr>
                 </table>
                 <?php
		$y = mysql_query("SELECT * FROM rockinus.forum_history WHERE foid='$id' ORDER BY pdate DESC, ptime DESC");
		if(!$y) die(mysql_error());
		$no_row_forum = mysql_num_rows($y);
		if($no_row_forum>0){
			while($obj = mysql_fetch_object($y)){
				$cid = $obj->cid;
				$descrip = $obj->descrip;
				$loopsender = $obj->sender;
				$rstatus = $obj->rstatus;
				$pdate = $obj->pdate;
				$ptime = $obj->ptime;
        ?>
                 <table width="730" height="30" border="0" cellpadding="0" cellspacing="0" bgcolor="" style="margin-top:15px">
                   <tr>
                     <td height="30" align="right" valign="middle" style="padding-right:10"><?php
			if($rstatus=="N" && $uid==$uname && $loopsender!=$uname){
				echo("<span style='background-color:#B92828; font-size:11px; color: #FFFFFF'><strong>&nbspNew&nbsp;</strong></span>");
				$q_fhis = mysql_query("UPDATE rockinus.forum_history SET rstatus='Y' WHERE cid='$cid';");
				if(!$q_fhis) die(mysql_error());
			}
		?>                     </td>
                     <td width="405" height="30" align="left" valign="middle" bgcolor="#F5F5F5" style="padding:8; font-size:14px"><?php 
					  if($loopsender==$uname)echo("<font color=$_SESSION[hcolor]><strong>You</strong></font> said:");
					  else echo("<font color=$_SESSION[hcolor]><strong>$loopsender</strong></font> said:") 
					  ?>                     </td>
                     <td width="293" align="right" valign="middle" bgcolor="#F5F5F5" style="padding-right:10; border-bottom:#DDDDDD solid 0"><font size="1"> <?php echo($pdate." | ".$ptime) ?> </font> </td>
                   </tr>
                   <tr>
                     <td width="32" height="30" align="right" valign="top" style="padding-top:10; padding-right:10"></td>
                     <td height="30" colspan="2" align="left" valign="top" bgcolor="#F5F5F5" style=" border:0 solid #F5F5F5; padding:8;line-height:150%; font-size:14px"><?php 
								 echo($descrip);
							  ?>                     </td>
                   </tr>
                 </table>
                 <?php
						}
					} 
				 ?>
                              </div>
              <?php }else if($tbname=="job_info"){
							?>
               <div style="border-bottom:1px #DDDDDD solid; border-top:1px #FFFFFF solid; padding-bottom:20px; padding-top:15px" onmouseover="document.getElementById('df<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('mf<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('df<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('mf<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
                 <table width="740" height="70" border="0" cellpadding="0" cellspacing="0">
                   <tr>
                     <td width="32" rowspan="2" align="center" valign="top" style="padding-top:10"><font size="2" color="<?php echo($_SESSION['hcolor'])?>"> <img src="img/notesicon.jpg" width="25" height="25" /></font></td>
                     <td width="572" height="35" align="left" style="padding-left:10px; line-height: 150%; font-size:14px"><?php 
						  echo("<a href=jobDetail.php?job_id=$id class=one><strong>".substr($subject,0,80)." ...</strong></a>");
						?>                     </td>
                     <td width="136" style="padding-right:10px" align="right"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5))?> </font> </td>
                   </tr>
                   <tr>
                     <td height="35" align="left" style="padding:10px; padding-top:5px; line-height:150%; font-size:15px"><?php 
						  if(strlen($descrip)>20)
						  	echo(substr(nl2br($descrip),0,500)." ...");
						  else
						    echo("<a href=jobDetail.php?aid=$id class=one>Click for details >>></a>");
					  ?>                     </td>
                     <td style="padding-right:10px" align="right" valign="top"><?php 
					  if($uname==$loopname)echo("<span id='df$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=JobConfirm.php?job_id=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='mf$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditJob.php?job_id=$id><font size=1>+ Edit</font></a></span>");
					  ?>                     </td>
                   </tr>
                 </table>
                 <?php
		$y = mysql_query("SELECT * FROM rockinus.job_history WHERE job_id='$id' ORDER BY pdate DESC, ptime DESC");
		if(!$y) die(mysql_error());
		$no_row_job = mysql_num_rows($y);
		if($no_row_job>0){
			while($obj = mysql_fetch_object($y)){
				$cid = $obj->cid;
				$descrip = $obj->descrip;
				$loopsender = $obj->sender;
				$rstatus = $obj->rstatus;
				$pdate = $obj->pdate;
				$ptime = $obj->ptime;
        ?>
                 <table width="730" height="30" border="0" cellpadding="0" cellspacing="0" bgcolor="" style="margin-top:15px">
                   <tr>
                     <td height="30" align="right" valign="middle" style="padding-right:10"><?php
			if($rstatus=="N" && $uid==$uname && $loopsender!=$uname){
				echo("<span style='background-color:#B92828; font-size:11px; color: #FFFFFF'><strong>&nbspNew&nbsp;</strong></span>");
				$q_fhis = mysql_query("UPDATE rockinus.job_history SET rstatus='Y' WHERE cid='$cid';");
				if(!$q_fhis) die(mysql_error());
			}
		?>                     </td>
                     <td width="405" height="30" align="left" valign="middle" bgcolor="#F5F5F5" style="padding:8; font-size:14px"><?php 
					  if($loopsender==$uname)echo("<font color=$_SESSION[hcolor]><strong>You</strong></font> said:");
					  else echo("<font color=$_SESSION[hcolor]><strong>$loopsender</strong></font> said:") 
					  ?>                     </td>
                     <td width="293" align="right" valign="middle" bgcolor="#F5F5F5" style="padding-right:10; border-bottom:#DDDDDD solid 0"><font size="1"> <?php echo($pdate." | ".$ptime) ?> </font> </td>
                   </tr>
                   <tr>
                     <td width="32" height="30" align="right" valign="top" style="padding-top:10; padding-right:10"></td>
                     <td height="30" colspan="2" align="left" valign="top" bgcolor="#F5F5F5" style=" border:0 solid #F5F5F5; padding:8;line-height:150%; font-size:14px"><?php 
								 echo($descrip);
							  ?>                     </td>
                   </tr>
                 </table>
                 <?php
						}
					} 
				 ?>
                              </div>
              <?php }else if($tbname=="memo_info"){ ?>
               <div style="padding-top:15px; padding-bottom: 15px; border-bottom:1px #DDDDDD solid; border-top:1px #FFFFFF solid">
                 <table width="730" height="131" border="0" cellpadding="0" cellspacing="0">
                   <tr>
                     <td width="32" rowspan="2" align="center" valign="top" style="padding-top:10px"><img src="img/writeamessageIcon.jpg" width="25" height="25"/> </td>
                     <td width="548" align="left" valign="top" style="padding-left:10px; font-size:14px; padding-top:10px; padding-bottom:5"><?php
							  	if($uname==$uid)	
									echo("You have a new status: ");
							  	else
									echo("$uid has a new status: ");
							  ?>                     </td>
                     <td width="155" height="18" align="right" valign="top" style="padding-right:10px; padding-top:10px"><font size="1"><a href='#' class="one"></a></font> <font size="1">
                       <?php
							  echo("$pdate | ".substr($ptime,0,5));
							  ?>
                     </font> </td>
                   </tr>
                   <tr>
                     <td height="18" colspan="2" align="left" valign="top" style="padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:15px; line-height:150%; border:0px #DDDDDD dashed; font-weight: bold; font-size:12px" bgcolor=""><font color="">
                       <?php 
								echo(nl2br($descrip));
								?>
                     </font> </td>
                   </tr>
                   <tr>
                     <td height="52" align="center" valign="middle" style="line-height:150%">&nbsp;</td>
                     <td height="52" colspan="2" align="left" valign="top" style="padding-left:10px; padding-right:5px; padding-top:10px; padding-bottom:5px; line-height:150%; border:0px #DDDDDD dashed"><?php 
$q_n = mysql_query("SELECT * FROM rockinus.memo_follow_info WHERE memoid='$memoid' ORDER BY memofid DESC");
if(!$q_n) die(mysql_error());
$no_row_memoreply = mysql_num_rows($q_n);

$q1 = mysql_query("SELECT * FROM rockinus.memo_follow_info WHERE memoid='$memoid' ORDER BY memofid DESC LIMIT 0,10");
if(!$q1) die(mysql_error());
if($no_row_memoreply == 0){ 
	if($gender=="Female")$g = "her something";
	else if($gender=="Male")$g = "him something";
	else $g=" something";
}else if($no_row_memoreply > 0){ 
	while($object = mysql_fetch_object($q1)){
		$memofid = $object->memofid;
		$sender = $object->sender;
		$recipient = $object->recipient;
		$descrip = $object->descrip;
		$ptime = $object->ptime;
		$pdate = $object->pdate; 
		$rstatus = $object->rstatus; 
 ?>
                         <div style="line-height:180%; margin-bottom:10px; width: 680px; border:0px #EEEEEE solid" align="left">
                           <form action="RockerDetail.php" method="post" style="margin:0">
                             <table width="680" height="63" border="0" cellpadding="2" cellspacing="0" bgcolor="#F5F5F5" style="border:0px solid #EEEEEE">
                               <tr>
                                 <td width="177" height="29" align="left" bgcolor="#F5F5F5" style=" padding-left:10; border-bottom:0px dashed #DDDDDD"><script language="JavaScript" type="text/javascript">
$(document).ready(function() { 
	$('.<?php echo($memofid) ?>').click(function(){ 
		var txt = $(this).text();
		var uid = "<?php echo($uname) ?>";
		txt = $.trim(txt);
		uid = $.trim(uid);
		if(uid!=txt){ 
			$("#show_recipient_name").text("@"+txt);
			$("#recipient").val(txt);
		} 
	}); 
}); 
           </script>
                                     <font size="2"> <a class="<?php echo($memofid) ?>"> <?php echo("<font color=$_SESSION[hcolor]><strong>$sender</strong></font> said :") ?> </a> </font>
                                     <?php
//				  if($recipient!=$uid)
//				  	echo("@ $uid");
				?>                                 </td>
                                 <td width="55" bgcolor="#F5F5F5" style="border-bottom:0px dashed #DDDDDD"><input type="hidden" name="memofid" value="<?php echo($memofid) ?>" />
                                     <input type="hidden" name="uid" value="<?php echo($uid) ?>" />                                 </td>
                                 <td width="214" align="right" valign="middle" bgcolor="#F5F5F5" style="border-bottom:0px dashed #DDDDDD">&nbsp;
                                     <?php if($uname==$sender){ ?>
                                     <input type="submit" style="font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 10px;background-color: #FFFFFF; border:1 #CCCCCC solid;" name="delmemosubmit" value="delete" />
                                     <?php }else if($rstatus=='N'){ ?>
                                     <div style="font-size: 10px; background-color: #B92828; border:1 #000000 solid; display:inline; color:#FFFFFF"> New </div>
                                     <?php 
						$q_mhis = mysql_query("UPDATE rockinus.memo_follow_info SET rstatus='Y' WHERE memofid='$memofid';");
						if(!$q_mhis) die(mysql_error());
					} ?>                                 </td>
                                 <td width="214" align="right" bgcolor="#F5F5F5" style="padding-right:10px; border-bottom:0px dashed #DDDDDD"><font color="#999999" size="1"> <?php echo(substr($pdate,5,8)." | ".substr($ptime,0,5)) ?> </font> </td>
                               </tr>
                               <tr>
                                 <td height="22" colspan="4" valign="top" style="padding:10; padding-top:5; line-height:180%; margin-bottom:10px; border-top:0px solid #EEEEEE; font-size:14px"><?php
						echo($descrip);
					?>                                 </td>
                               </tr>
                             </table>
                           </form>
                         </div>
                       <?php }} ?>
                         <script type="text/javascript" >
 $(function() {
 $(".comment_button<?php echo($id) ?>").click(function() {
var test = $("#content<?php echo($id) ?>").val();
var memoid = <?php echo($id) ?>;
var pdate = '<?php echo(date('Y-m-d')) ?>';
var ptime = '<?php echo(date("H:i:s", time())) ?>';
var sender = '<?php echo($uname) ?>';
var recipient = '<?php echo($loopname) ?>';
var dataString = 'content='+ test+'&memoid='+memoid+'&sender='+sender+'&recipient='+recipient+'&pdate='+pdate+'&ptime='+ptime; 

if(test=='')
{
 alert("Please Enter Something ok?");
}
else
{
 $("#flash<?php echo($id) ?>").show();
 $("#flash<?php echo($id) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle"> <span class="loading">Loading Comment...</span>');
 
 $.ajax({
  type: "POST",
  url: "memo_insert.php",
  data: dataString,
  cache: false,
  success: function(html){
  $("#display<?php echo($id) ?>").after(html);
  document.getElementById('content<?php echo($id) ?>').value='';
  document.getElementById('content<?php echo($id) ?>').focus();
  $("#flash<?php echo($id) ?>").hide();
  }
 });
 } return false;
 });
 });
              </script>
                         <div id="flash<?php echo($id) ?>" style="padding-left:10px"></div>
                       <div id="display<?php echo($id) ?>" style="padding-left:10px"></div>
                       <div style="padding-left:0px">
                           <form action="" method="post" name="form" id="form" style="margin-top:10px">
                             <textarea name="content<?php echo($id) ?>" id="content<?php echo($id) ?>" cols="60" rows="2" style="border:1px #DDDDDD solid;" onfocus="this.style.backgroundColor='#F5F5F5'; this.style.borderColor='#CCCCCC'; " onclick="this.rows=5" onmouseout="this.style.backgroundColor='#FFFFFF';  this.rows=2"></textarea>
                             &nbsp;&nbsp;&nbsp;
                             <input type="submit" value="Reply" name="submit" class="comment_button<?php echo($id) ?>" style="margin-top:5px; color:#000000;   font: bold 84%'trebuchet ms',helvetica,sans-serif;   background-color: #FFFFFF; "/>
                           </form>
                       </div></td>
                   </tr>
                 </table>
               </div>
              <?php }else if($tbname=="course_memo_info"){ 
			  					$memo_q = mysql_query("SELECT course_name,course_id FROM rockinus.course_info WHERE course_id=(SELECT course_id FROM rockinus.unique_course_info WHERE course_uid ='$id');");
								if(!$memo_q) die(mysql_error());
								$obj = mysql_fetch_object($memo_q); 
								$course_id = $obj->course_id;
								$course_name = $obj->course_name;
						  ?>
               <div style="border-bottom:1px #DDDDDD solid; border-top:0px #EEEEEE solid;  padding-bottom:20px; padding-top:15px">
                 <table width="740" height="70" border="0" cellpadding="0" cellspacing="0">
                   <tr>
                     <td width="33" rowspan="2" align="center" valign="top" style="padding-top:10"><img src="img/book100.jpg" width="25" height="25" /></td>
                     <td width="591" height="35" style="padding-left:10px; font-size:14px"><?php
							  	echo("Commented on <a href=CourseDetail.php?course_uid=$id class=one><font color=$_SESSION[hcolor]><strong>$course_id - ".substr($course_name,0,22)."</strong></font></a>");
							  ?></td>
                     <td width="116" height="35" align="right" style="padding-right:10px"><font size="1"><?php echo("$pdate | ".substr($ptime,0,5)) ?></font> </td>
                   </tr>
                   <tr>
                     <td height="35" style="padding-left:10px; line-height:150%; font-size:14px; padding-top: 10" valign="top"><?php 
						echo(nl2br($subject));
							  ?></td>
                     <td height="35" align="right" style="padding-right:10; padding-top:10" valign="top"><?php 
								for($i=0;$i<$action;$i++)
									echo("<img src=img/yellowstar.jpg /> "); 
								?>                     </td>
                   </tr>
                 </table>
               </div>
              <?php }else if($tbname=="event_info"){  ?>
               <div style=" padding-top:15px; padding-bottom:15px; border-bottom:1px #DDDDDD solid; border-top:0px #EEEEEE solid;" onmouseover="document.getElementById('de<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('me<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('de<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('me<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
                 <table width="740" height="110" border="0" cellpadding="0" cellspacing="0">
                   <tr>
                     <td width="32" height="40" align="center" style="padding-top:10px" valign="top"><img src="img/calendar100.jpg" width="25" height="25"/> </td>
                     <td width="589" height="40" style="padding-left:10; padding-top:10; font-size:14px" valign="top"><?php 
						echo("<a href=eventDetail.php?eid=$id class=one><strong>$subject</strong></a>");
						?>                     </td>
                     <td width="119" height="40" align="right" style="padding-right:10px"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5)) ?></font> </td>
                   </tr>
                   <tr>
                     <td width="32" height="35" style="padding-left:5px">&nbsp;</td>
                     <td height="35" style="padding-left:10px; padding-bottom:10px; padding-top:5px; line-height:150%; font-size:14px"><?php 
						  echo(nl2br($action));
					  ?>                     </td>
                     <td height="35" align="right" style="padding-right:10; padding-top:5" valign="top"><?php 
					  if($uname==$loopname)echo("<span id='de$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EventConfirm.php?eid=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='me$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditEvent.php?eid=$id&&pageName=RockerDetail><font size=1>+ Edit</font></a></span>");
					  ?>                     </td>
                   </tr>
                   <tr>
                     <td height="35" style="padding-left:5px">&nbsp;</td>
                     <td height="5" colspan="2" style="padding-left:10px; padding-bottom:10px; padding-top:5px; line-height:150%; font-size:14px"><?php 
$q_n = mysql_query("SELECT * FROM rockinus.event_history WHERE eid='$id' ORDER BY cid DESC");
if(!$q_n) die(mysql_error());
$no_row_memoreply = mysql_num_rows($q_n);
//echo($no_row_memoreply);
$q_e = mysql_query("SELECT * FROM rockinus.event_history WHERE eid='id' ORDER BY cid DESC LIMIT 0,10");
if(!$q_e) die(mysql_error());
//if($no_row_memoreply > 0){ 
if(1>2){
	$obj = mysql_fetch_object($q_e); 
	while($object = mysql_fetch_object($q_e)){
		$cid = $object->cid;
		$sender = $object->sender;
		$recipient = $object->recipient;
		$descrip = $object->descrip;
		$ptime = $object->ptime;
		$pdate = $object->pdate; 
		$rstatus = $object->rstatus; 
 ?>
                         <div style="line-height:180%; margin-bottom:15px; width: 680px; border:0px #EEEEEE solid" align="left">
                           <form action="RockerDetail.php" method="post" style="margin:0">
                             <table width="680" height="63" border="0" cellpadding="2" cellspacing="0" bgcolor="#F5F5F5" style="border:0px solid #EEEEEE">
                               <tr>
                                 <td width="177" height="29" align="left" bgcolor="#F5F5F5" style=" padding-left:10; border-bottom:0px dashed #DDDDDD"><script language="JavaScript" type="text/javascript">
$(document).ready(function() { 
	$('.<?php echo($memofid) ?>').click(function(){ 
		var txt = $(this).text();
		var uid = "<?php echo($uname) ?>";
		txt = $.trim(txt);
		uid = $.trim(uid);
		if(uid!=txt){ 
			$("#show_recipient_name").text("@"+txt);
			$("#recipient").val(txt);
		} 
	}); 
}); 
                        </script>
                                     <font size="2"> <a class="<?php echo($memofid) ?>"> <?php echo("<font color=$_SESSION[hcolor]><strong>$sender</strong></font> said :") ?> </a> </font>
                                     <?php
//				  if($recipient!=$uid)
//				  	echo("@ $uid");
				?>
                                     </font></td>
                                 <td width="55" bgcolor="#F5F5F5" style="border-bottom:0px dashed #DDDDDD"><input type="hidden" name="memofid2" value="<?php echo($cid) ?>" />
                                     <input type="hidden" name="uid2" value="<?php echo($uid) ?>" />                                 </td>
                                 <td width="214" align="right" valign="middle" bgcolor="#F5F5F5" style="border-bottom:0px dashed #DDDDDD">&nbsp;
                                     <?php if($uname==$sender){ ?>
                                     <input type="submit" style="font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 10px;background-color: #FFFFFF; border:1 #CCCCCC solid;" name="delmemosubmit2" value="delete" />
                                     <?php }else if($rstatus=='N'){ ?>
                                     <div style="font-size: 10px; background-color: #B92828; border:1 #000000 solid; display:inline; color:#FFFFFF"> New </div>
                                     <?php 
						$q_mhis = mysql_query("UPDATE rockinus.memo_follow_info SET rstatus='Y' WHERE memofid='$memofid';");
						if(!$q_mhis) die(mysql_error());
					} ?>                                 </td>
                                 <td width="214" align="right" bgcolor="#F5F5F5" style="padding-right:10px; border-bottom:0px dashed #DDDDDD"><font color="#999999" size="1"> <?php echo(substr($pdate,5,8)." | ".substr($ptime,0,5)) ?> </font> </td>
                               </tr>
                               <tr>
                                 <td height="22" colspan="4" valign="top" style="padding:10; padding-top:5; line-height:180%; margin-bottom:10px; border-top:0px solid #EEEEEE; font-size:14px"><?php
						echo($descrip);
					?>                                 </td>
                               </tr>
                             </table>
                           </form>
                         </div>
                       <?php }} ?>
                         <script type="text/javascript" >
                        </script></td>
                   </tr>
                 </table>
               </div>
              <?php }else if($tbname=="cafe_info"){  ?>
               <div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:0; padding-bottom:2px; border-bottom:1px #EEEEEE solid" onmouseover="this.style.backgroundColor = '#F5F5F5';this.style.borderColor = '#DDDDDD';" onmouseout="this.style.backgroundColor = 'white';this.style.borderColor = '#EEEEEE';">
                 <table width="740" height="95" border="0" cellpadding="0" cellspacing="0">
                   <tr>
                     <td width="65" height="30" rowspan="2" bgcolor="#FFFFFF" style="padding-right:5px; padding-top:10px" valign="top"><img src="img/<?php echo($aname."FoodIcon.jpg") ?>" width="50" height="50" /></td>
                     <td width="552" height="35" style="padding-left:10px; padding-top:10px" valign="top"><?php echo("<a href=RockerDetail.php?uid=$loopname><font color=$_SESSION[hcolor]><strong>$loopname</strong></font></a> introduced a <a href=foodcafe.php?cafeid=$id class=one>new Cafe</a>:") ?> </td>
                     <td width="123" height="35" align="right" style="padding-right:10px"><font size="1">
                       <?php 
	//							echo(date("y-m-d",time()));
	//							echo(substr(date(" G:i:s",time()),2,17));
								echo(" $pdate | ".substr($ptime,0,5)) ?>
                     </font> </td>
                   </tr>
                   <tr>
                     <td height="35" style="padding-left:10px; padding-top:5px" valign="top"><?php 
										  echo("<a href=CafeDetail.php?cafeid=$id class=one><font size=3><strong>$subject</strong></font></a>");
							  ?></td>
                     <td width="123" height="35" align="right" style="padding-right:10px"><?php 
					  if($uname==$loopname)echo("<a href=editHouse.php?hid=$id class=one><font size=1><strong>+ Edit</strong></font></a>");
					  ?>                     </td>
                   </tr>
                   <tr>
                     <td width="65" height="30" style="padding-left:5px">&nbsp;</td>
                     <td height="30" style="padding-left:10px; padding-bottom:10px; padding-top:5px; line-height:150%" valign="top"><font color="#999999"><?php echo("<font size=2 color=#666666><strong>$action</strong></font>") ?></font></td>
                     <td height="30" align="right" style="padding-right:5px">&nbsp;</td>
                   </tr>
                 </table>
               </div>
              <?php }else if($tbname=="cafefood_memo_info"){  
						  if($aname=="c"){
						  	$q1 = mysql_query("SELECT * FROM rockinus.cafe_info WHERE cafeid='$id' ;");
						  	if(!$q1) die(mysql_error());
						  	$obj = mysql_fetch_object($q1);
						  	$cafeTitle = $obj->cafeTitle;
						  	$category = $obj->category;
						  ?>
               <div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:0; padding-bottom:10px; border-bottom:1px #EEEEEE solid" onmouseover="this.style.backgroundColor = '#F5F5F5';this.style.borderColor = '#DDDDDD';" onmouseout="this.style.backgroundColor = 'white';this.style.borderColor = '#EEEEEE';">
                 <table width="740" height="80" border="0" cellpadding="0" cellspacing="0">
                   <tr>
                     <td width="65" height="40" rowspan="3" bgcolor="#FFFFFF" valign="top" style="padding-right:5px; padding-top:10px"><img src="img/<?php echo($category."FoodIcon.jpg") ?>" width="50" height="50" /> </td>
                     <td width="553" height="20" style="padding-left:10px; padding-top:10px" valign="top"><?php echo("<a href=RockerDetail.php?uid=$loopname><font color=black><strong>$loopname</strong></font></a> commented on <a href=cafeDetail.php?cafeid=$id class=one><strong><font color=$_SESSION[hcolor]>$cafeTitle</font></a> </strong>") ?> </td>
                     <td width="122" height="20" align="right" style="padding-right:10px"><font size="1">
                       <?php 
	//							echo(date("y-m-d",time()));
	//							echo(substr(date(" G:i:s",time()),2,17));
								echo(" $pdate | ".substr($ptime,0,5)) ?>
                     </font> </td>
                   </tr>
                   <tr>
                     <td height="20" style="padding-left:10px; padding-top:10px" valign="top"><?php echo("<strong><font color=#999999>[$category Food]</font></strong>"); ?> </td>
                     <td height="20" align="right" style="padding-right:10px">&nbsp;</td>
                   </tr>
                   <tr>
                     <td height="20" style="padding-left:10px; padding-top:10px" valign="top"><?php 
									echo("<a href=CafeDetail.php?cafeid=$id class=one><font size=2 color=#999999>");
										  
									$len = strlen($action);
									$single_line_len = 70;
									$line_no = $len/$single_line_len; 
							
									for($i=0;$i<$line_no;$i++) {
										$str = substr($action,$i*$single_line_len, $single_line_len)."<br>";
										echo("<font size=2 color=#666666><strong>$str</strong></font>");
									}
								echo("</font></a>");
							  ?>                     </td>
                     <td width="122" height="20" align="right" style="padding-right:10px"><?php 
								for($i=0;$i<$subject;$i++)
									echo("<img src=img/ThumbUpIcon20.jpg /> "); 
								?>                     </td>
                   </tr>
                 </table>
               </div>              <?php } } }?>           </td>
         </tr>
       </table></td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
