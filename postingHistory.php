<?php 
//header("Content-Type: text/html; charset=gb2312");
header("Content-Type: text/html; charset=utf-8");
include 'ValidCheck.php';
include("Allfuc.php");
include 'dbconnect.php';
$uid = $_SESSION['usrname'];

//$uname = $_SESSION['usrname'];
//$ua=getBrowser();

//if(isset($_GET['uid']) && strlen(trim($_GET['uid']))>0 ) $uid = $_GET['uid'];
//else header("location:ThingsRock.php");

if( ($uid!=$uname) && (strlen(trim($uid))>0) && (strlen(trim($uname))>0) ){
	$result = mysql_query("INSERT INTO rockinus.visit_history(visitor, host, vdate, vtime) VALUES('$uname','$uid',CURDATE(),NOW())");
	if (!$result) die('Invalid query: ' . mysql_error());

	$q_v = mysql_query("SELECT * FROM rockinus.visit_info WHERE visitor='$uname' AND host='$uid';");
	if(!$q_v) die(mysql_error());
	$no_row_visit = mysql_num_rows($q_v);

	if($no_row_visit>0){
		$q_vi = mysql_query("UPDATE rockinus.visit_info SET vdate=CURDATE(), vtime=NOW() WHERE visitor='$uname' AND host='$uid';");
		if(!$q_vi) die(mysql_error());
	}else{
		$sql = "INSERT INTO rockinus.visit_info(visitor, host, vdate, vtime) VALUES('$uname','$uid',CURDATE(),NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
	}
}

if($uid==$uname){
	$reply = mysql_query("SELECT count(*) as cnt FROM rockinus.memo_follow_info WHERE memoid in (SELECT memoid FROM rockinus.memo_info WHERE sender='$uname') AND rstatus = 'N'");
	if(!$reply)	die("Error quering the Database: " . mysql_error());
	$reply_obj = mysql_fetch_object($reply);
	$reply_cnt = $reply_obj->cnt;
}

$rel_rstatus = "N";
if($uid==$uname)$rel_rstatus ="S";
else{
	$q11 = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE (sender='$uid' AND recipient='$uname') OR (recipient='$uid' AND sender='$uname')");
	if(!$q11) die(mysql_error());
	$no_row_A = mysql_num_rows($q11);
	if($no_row_A>0)$rel_rstatus='A';
	
	$q21 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uid' AND recipient='$uname' AND rstatus='P'");
	if(!$q21) die(mysql_error());
	$no_row_P = mysql_num_rows($q21);
	if($no_row_P>0)$rel_rstatus='X';
	
	$q22 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uname' AND recipient='$uid' AND rstatus='P'");
	if(!$q22) die(mysql_error());
	$no_row_X = mysql_num_rows($q22);
	if($no_row_X>0)$rel_rstatus='P';	
}

$pic210_Name = $uname.'210.jpg';
$ProPercent = 70;

$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$hcolor = $object->hcolor;

mysql_query("SET NAMES GBK");
$q = mysql_query("SELECT * FROM rockinus.user_info INNER JOIN rockinus.user_check_info INNER JOIN rockinus.user_edu_info INNER JOIN rockinus.user_contact_info ON user_info.uname='$uid' AND user_info.uname=user_check_info.uname AND user_info.uname=user_edu_info.uname AND user_info.uname=user_contact_info.uname");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;
$uid_fname = $object->fname;
if($fname==NULL || strlen(trim($fname))==0) $fname=$uid;
$uid_lname = $object->lname;
$birthdate = $object->birthdate;
if($birthdate!=NULL && strlen(trim($birthdate))==10 )$birthdate = substr($birthdate,5,5);
else $birthdate = "Unknown";
$sterm = $object->sterm;
$fregion = $object->fregion;
$fcountry = $object->fcountry;
if(trim($fcountry)=="empty")$fcountry="Unknown country";
if(trim($fregion)=="empty")$fregion="Unknown city";
$email = $object->email;
$cmajor = $object->cmajor;
if(trim($cmajor)=="empty") $cmajor=NULL;
$cschool = $object->cschool;
if(trim($cschool)=="empty") $cschool=NULL;
$cdegree = $object->cdegree;
if(trim($cdegree)=="empty") $cdegree="Unknown degree";
$cstate = $object->cstate;
$ccity = $object->ccity;

if($cschool!=NULL){
	$q = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
	if(!$q) die(mysql_error());
	$obj = mysql_fetch_object($q);
	$cschool = $obj->school_name;
}else $cschool = "Unknown School";

if($cmajor!=NULL && trim($cmajor)!="empty"){
	$m = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid='$cmajor'");
	if(!$m) die(mysql_error());
	$objm = mysql_fetch_object($m);
	$major_name = $objm->major_name;	
}else $major_name = "Unknown Major";

if($ccity==NULL || $ccity=="empty" ) $ccity = "Unknown City";
if($cstate==NULL || $cstate=="em" ) $cstate = "Unknown State";
if($cdegree==NULL) $cdegree = "Unknown Diploma";
if($mstatus==NULL) $mstatus = "Unknown Status";

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
  $pic250_Name = $uid.'250.jpg';
  	$target = "upload/".$uid;
	if(is_dir($target)){
		echo("upload/$uid/$pic250_Name?".time());
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
<table width="752" height="85" border="0" cellpadding="0" cellspacing="0" style=" margin-bottom:40; margin-top:0">
  <tr>
    <td width="752" valign="top" style="padding-left:10; padding-bottom:5px; background-color:#FFFFFF; padding-top:0"><span style="font-size:14px; padding-left:10">
      <?php
		include 'dbconnect.php';
		
		mysql_query("SET NAMES UTF-8");
		$sql_stmt = "SELECT hid,uname,subject,rentlease,pdate,ptime,'house_info' AS tbname, type, city, rate, NULL as col_1, NULL as col_2, descrip 
					FROM rockinus.house_info a WHERE uname='$uid' 
					UNION 
					SELECT aid,uname,subject,buysale,pdate,ptime,'article_info' AS tbname,aname,city,rate,delivery,type, descrip 
					FROM rockinus.article_info b WHERE uname='$uid' 
					UNION 
					SELECT news_id,creater,subject,category,pdate,ptime,'news_info' AS tbname,NULL,NULL,NULL,NULL,NULL, descrip 
					FROM rockinus.news_info c WHERE creater='$uid' 
					UNION 
					SELECT rmate_id,uname,NULL,mate_type,pdate,ptime,'room_mate_info' AS tbname,rstatus,NULL,NULL,NULL,NULL, descrip 
					FROM rockinus.room_mate_info d WHERE uname='$uid' 
					UNION 
					SELECT memoid,sender,NULL,NULL,pdate,ptime,'memo_info' AS tbname,NULL,NULL,NULL,NULL,level,descrip 
					FROM rockinus.memo_info b WHERE sender='$uid' AND descrip<>''
					UNION 
					SELECT course_uid, sender, descrip, rating, pdate, ptime, tbname, NULL, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.course_memo_info c WHERE sender='$uid'  
					UNION 
					SELECT book_id, uname, book_name, descrip, pdate, ptime, 'book_info' AS tbname, buysale, NULL,NULL, NULL, NULL, NULL 
					FROM rockinus.book_info d WHERE uname='$uid'  
					UNION
					SELECT cid,sender,recipient,NULL,pdate,ptime,'house_comment' AS tbname,hid,NULL,NULL,rstatus,NULL, descrip 
					FROM rockinus.house_comment g WHERE sender='$uid'
					ORDER BY pdate DESC, ptime DESC";
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		 
//if($uid==$uname) echo("<strong><div style='background-color: ; color: $_SESSION[hcolor]; font-size:14px; padding-left:0px; padding-right:10px; display:inline; border-top:0px #CCCCCC solid; border-left:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding-top:6px; height:30px'><font color=#999999></font></div></strong>");
?>
    </span>
      <?php
		if($no_row == 0) echo("<div style='padding-top:30px; padding-bottom:30px; padding-left:5px; width:500; color:#999999; font-size:18px' align='center'><strong><img src='img/join.jpg'>&nbsp;&nbsp; You currently have nothing posted</strong></div>");
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
  <div style="border-bottom:1px #DDDDDD solid; border-top:1px #FFFFFF solid; padding-bottom:10px; margin-bottom:10px" onmouseover="document.getElementById('dh<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('mh<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('dh<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('mh<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
            <table width="740" height="58" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="35" rowspan="2" align="center" valign="top" style="padding-top:10"><font size="2" color="<?php echo($_SESSION['hcolor'])?>"><img src="img/houseMenuIcon.jpg" width="20" /></font></td>
                <td width="591" height="35" align="left" style="padding-left:10px; font-size:14px"><?php 
								  echo("<a href=HouseDetail.php?hid=$id class=one><strong><font color=$_SESSION[hcolor]>$subject</font></strong></a>");
							  ?></td>
                <td width="114" style="padding-right:10px" align="right"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5))?> </font> </td>
              </tr>
              <tr>
                <td height="23" align="left" style="padding-left:10px; padding-top:5px; padding-bottom:5; line-height:130%; font-size:13px" valign="top">
				<?php 
						  if(strlen($descrip)>1000)
						  	echo(substr(nl2br($descrip),0,1000)." ...");
						  else
						    echo(nl2br($descrip));
					  ?>                </td>
                <td style="padding-right:10px" align="right" valign="top"><?php 
					  if($uname==$loopname)echo("<span id='dh$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=HouseConfirm.php?hid=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='mh$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditHouse.php?hid=$id><font size=1>+ Edit</font></a></span>");
					  ?>
                </td>
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
                <td height="30" align="left" valign="middle" bgcolor="#F5F5F5" style="padding:8; font-size:13px; line-height:150%"><?php 
						 echo($descrip);
					  ?>
                </td>
              </tr>
            </table>
            <?php
					  				}
								} 
								?>
          </div>
        <?php	}else if($tbname=="article_info"){
							?>
          <div style="border-bottom:1px #DDDDDD solid; border-top:0px #EEEEEE solid; padding-bottom:10px; margin-bottom:10px" onmouseover="document.getElementById('da<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('ma<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('da<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('ma<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
            <table width="740" height="68" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="33" rowspan="2" align="center" valign="top" style="padding-top:10"><font size="2" color="<?php echo($_SESSION['hcolor'])?>"><img src="img/colorBuyIcon.jpg" width="20" /></font></td>
                <td width="586" height="35" align="left" style="padding-left:10px; font-size:14px"><?php 
						  echo("<a href=ArticleDetail.php?aid=$id class=one><strong><font color=$_SESSION[hcolor]>$subject</font></strong></a>");
					?>
                </td>
                <td width="121" style="padding-right:10px" align="right"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5))?></font></td>
              </tr>
              <tr>
                <td height="33" align="left" valign="top" style="padding: 10; padding-top:5px; font-size:13px; line-height: 130%"><?php 
						  if(strlen($descrip)>1000)
						  	echo(substr(nl2br($descrip),0,1000)." ...");
						  else
						    echo(nl2br($descrip));
					  ?>                </td>
                <td style="padding-right:10px" align="right" valign="top"><?php 
					  if($uname==$loopname)echo("<span id='da$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=ArticleConfirm.php?aid=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='ma$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditArticle.php?aid=$id><font size=1>+ Edit</font></a></span>");
					  ?>
                </td>
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
		?>
                </td>
                <td width="707" height="25" align="left" valign="middle" bgcolor="#F5F5F5" style="padding:8; font-size:14px"><?php 
					  if($loopsender==$uname)echo("<font color=$_SESSION[hcolor]>You</font><font color=#CCCCCC> said:</font>");
					  else echo("<font color=$_SESSION[hcolor]>$loopsender</font><font color=#CCCCCC>  said:</font>") 
					  ?></td>
              </tr>
              <tr>
                <td width="33" height="39" align="right" valign="top" style="padding-top:10">&nbsp;</td>
                <td height="39" align="left" valign="top" bgcolor="#F5F5F5" style="padding:8; font-size:13px"><?php 
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
							}else if($tbname=="news_info"){
							?>
          <div style="border-bottom:1px #DDDDDD solid; border-top:1px #FFFFFF solid; padding-bottom:10px; margin-bottom:10px" onmouseover="document.getElementById('df<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('mf<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('df<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('mf<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
            <table width="740" height="68" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="35" rowspan="2" align="center" valign="top" style="padding-top:10"><font size="2" color="<?php echo($_SESSION['hcolor'])?>"> <img src="img/newsMenuIcon.jpg" width="20" /></font></td>
                <td width="572" height="35" align="left" style="padding-left:10px; line-height: 150%; font-size:14px; font-weight:bold"><?php 
						  echo(substr($subject,0,80)." ...");
						?>
                </td>
                <td width="136" style="padding-right:10px" align="right"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5))?> </font> </td>
              </tr>
              <tr>
                <td height="33" align="left" style="padding:10px; padding-top:5px; line-height:130%; font-size:13px"><?php 
						  if(strlen($descrip)>20)
						  	echo(substr(nl2br($descrip),0,500)." ...");
						  else
						    echo("<a href=forumDetail.php?aid=$id class=one>Click for details >>></a>");
					  ?>                </td>
                <td style="padding-right:10px" align="right" valign="top"><?php 
					  if($uname==$loopname)echo("<span id='df$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=ForumConfirm.php?news_id=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='mf$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditNews.php?news_id=$id><font size=1>+ Edit</font></a></span>");
					  ?>
                </td>
              </tr>
            </table>
          </div>
        <?php }else if($tbname=="room_mate_info"){
							?>
          <div style="border-bottom:1px #DDDDDD solid; border-top:1px #FFFFFF solid; padding-bottom:10px; margin-bottom:10px" onmouseover="document.getElementById('df<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('mf<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('df<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('mf<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
            <table width="740" height="70" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="35" rowspan="2" align="center" valign="top" style="padding-top:10"><img src="img/headIcon.jpg" width="20" /></td>
                <td width="572" rowspan="2" align="left" valign="top" style="padding:10px; line-height: 150%; font-size:13px"><?php 
						  if(strlen($descrip)>20)
						  	echo(substr(nl2br($descrip),0,500)." ...");
						  else
						    echo("Nothing to show >>>");
					  ?>
                </td>
                <td width="136" height="35" align="right" style="padding:10" valign="top"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5))?> </font> <br />
                    <br />
                    <?php 
					  if($uname==$loopname)echo("<span id='df$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=roomMateConfirm.php?rmate_id=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='mf$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditRoomMate.php?rmate_id=$id><font size=1>+ Edit</font></a></span>");
					  ?>
                </td>
              </tr>
              <tr>
                <td height="35" align="right" valign="top" style="padding-top:10; padding-right:10">&nbsp;</td>
              </tr>
            </table>
          </div>
        <?php }else if($tbname=="memo_info_"){ ?>
          <div style=" margin-bottom:10px; padding-bottom: 10px; border-bottom:1px #DDDDDD solid; border-top:1px #FFFFFF solid">
            <table width="740" height="131" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="29" align="center" valign="top" style="padding-top:10px"><img src="img/messageMenuIcon.jpg" width="20"/> </td>
                <td width="581" align="left" valign="top" style="padding-left:10px; font-size:14px; font-weight:bold; padding-top:10px; padding-bottom:5"><?php 
								echo(nl2br($descrip));
								?>
                </td>
                <td width="120" align="right" valign="top" style="padding-right:5px; padding-top:10px"><font size="1">
                  <?php
							  echo("$pdate | ".substr($ptime,0,5));
							  ?>
                </font> </td>
              </tr>
              <tr>
                <td height="52" align="center" valign="middle" style="line-height:150%">&nbsp;</td>
                <td height="52" colspan="2" align="left" valign="top" style="padding-left:10px; padding-right:5px; padding-top:5px; padding-bottom:5px; line-height:150%; border:0px #DDDDDD dashed"><?php 
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
                    <div style="line-height:180%; margin-bottom:5px; width: 680px; border:0px #EEEEEE solid" align="left">
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
                            </td>
                            <td width="55" bgcolor="#F5F5F5" style="border-bottom:0px dashed #DDDDDD"><input type="hidden" name="memofid" value="<?php echo($memofid) ?>" />
                                <input type="hidden" name="uid" value="<?php echo($uid) ?>" />
                            </td>
                            <td width="214" align="right" valign="middle" bgcolor="#F5F5F5" style="border-bottom:0px dashed #DDDDDD">&nbsp;
                                <?php if($uname==$sender){ ?>
                                <input type="submit" style="font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 10px;background-color: #FFFFFF; border:1 #CCCCCC solid;" name="delmemosubmit" value="delete" />
                                <?php }else if($rstatus=='N'){ ?>
                                <div style="font-size: 10px; background-color: #B92828; border:1 #000000 solid; display:inline; color:#FFFFFF"> New </div>
                              <?php 
						$q_mhis = mysql_query("UPDATE rockinus.memo_follow_info SET rstatus='Y' WHERE memofid='$memofid';");
						if(!$q_mhis) die(mysql_error());
					} ?>
                            </td>
                            <td width="214" align="right" bgcolor="#F5F5F5" style="padding-right:10px; border-bottom:0px dashed #DDDDDD"><font color="#999999" size="1"> <?php echo(substr($pdate,5,8)." | ".substr($ptime,0,5)) ?> </font> </td>
                          </tr>
                          <tr>
                            <td height="22" colspan="4" valign="top" style="padding:10; padding-top:5; line-height:180%; margin-bottom:10px; border-top:0px solid #EEEEEE; font-size:14px"><?php
						echo($descrip);
					?>
                            </td>
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
                      <form action="" method="post" name="form" id="form" style="margin-top:0px">
                        <textarea name="content<?php echo($id) ?>" id="content<?php echo($id) ?>" rows="4" style="border:1px #DDDDDD solid; width:680; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; margin-bottom:5" onfocus="this.style.backgroundColor='#F5F5F5'; this.style.borderColor='#CCCCCC'; " onclick="this.rows=4" onmouseout="this.style.backgroundColor='#FFFFFF';  this.rows=4"></textarea>
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
          <div style="border-bottom:1px #DDDDDD solid; border-top:0px #EEEEEE solid;  padding-bottom:10px; margin-bottom:10px">
            <table width="740" height="63" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="35" rowspan="2" align="center" valign="top" style="padding-top:10"><img src="img/studyMenuIcon.jpg" width="20" /></td>
                <td width="591" height="30" style="padding-left:10px; font-size:14px"><?php
							  	echo("Commented on <a href=CourseDetail.php?course_uid=$id class=one><font color=$_SESSION[hcolor]><strong>$course_id - $course_name</strong></font></a>");
							  ?></td>
                <td width="116" height="30" align="right" style="padding-right:10px"><font size="1"><?php echo("$pdate | ".substr($ptime,0,5)) ?></font> </td>
              </tr>
              <tr>
                <td height="28" style="padding-left:10px; line-height:130%; font-size:13px; padding-top:5px" valign="top"><?php 
						echo(nl2br($subject));
							  ?></td>
                <td height="28" align="right" style="padding-right:10; padding-top:10" valign="top"><?php 
								for($i=0;$i<$action;$i++)
									echo("<img src=img/yellowstar.jpg /> "); 
								?>                </td>
              </tr>
            </table>
          </div>
        <?php }else if($tbname=="book_info"){  ?>
          <div style=" margin-bottom:10px; padding-bottom:10px; border-bottom:1px #DDDDDD solid; border-top:0px #EEEEEE solid;" onmouseover="document.getElementById('de<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('me<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('de<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('me<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
            <table width="740" height="110" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="32" height="40" align="center" style="padding-top:10px" valign="top"><img src="img/newsMenuIcon.jpg" width="20"/> </td>
                <td width="589" height="40" style="padding-left:10; padding-top:10; font-size:14px" valign="top"><?php 
						echo("<a href=eventDetail.php?eid=$id class=one>$subject</a>");
						?>
                </td>
                <td width="119" height="40" align="right" style="padding-right:10px"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5)) ?></font> </td>
              </tr>
              <tr>
                <td width="32" height="35" style="padding-left:5px">&nbsp;</td>
                <td height="35" style="padding-left:10px; padding-bottom:10px; padding-top:5px; line-height:150%; font-size:13px"><?php 
						  echo(nl2br($action));
					  ?>
                </td>
                <td height="35" align="right" style="padding-right:10; padding-top:5" valign="top"><?php 
					  if($uname==$loopname)echo("<span id='de$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EventConfirm.php?eid=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='me$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditEvent.php?eid=$id&&pageName=RockerDetail><font size=1>+ Edit</font></a></span>");
					  ?>
                </td>
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
                                <input type="hidden" name="uid2" value="<?php echo($uid) ?>" />
                            </td>
                            <td width="214" align="right" valign="middle" bgcolor="#F5F5F5" style="border-bottom:0px dashed #DDDDDD">&nbsp;
                                <?php if($uname==$sender){ ?>
                                <input type="submit" style="font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 10px;background-color: #FFFFFF; border:1 #CCCCCC solid;" name="delmemosubmit2" value="delete" />
                                <?php }else if($rstatus=='N'){ ?>
                                <div style="font-size: 10px; background-color: #B92828; border:1 #000000 solid; display:inline; color:#FFFFFF"> New </div>
                              <?php 
						$q_mhis = mysql_query("UPDATE rockinus.memo_follow_info SET rstatus='Y' WHERE memofid='$memofid';");
						if(!$q_mhis) die(mysql_error());
					} ?>
                            </td>
                            <td width="214" align="right" bgcolor="#F5F5F5" style="padding-right:10px; border-bottom:0px dashed #DDDDDD"><font color="#999999" size="1"> <?php echo(substr($pdate,5,8)." | ".substr($ptime,0,5)) ?> </font> </td>
                          </tr>
                          <tr>
                            <td height="22" colspan="4" valign="top" style="padding:10; padding-top:5; line-height:180%; margin-bottom:10px; border-top:0px solid #EEEEEE; font-size:14px"><?php
						echo($descrip);
					?>
                            </td>
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
					  ?>
                </td>
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
							  ?>
                </td>
                <td width="122" height="20" align="right" style="padding-right:10px"><?php 
								for($i=0;$i<$subject;$i++)
									echo("<img src=img/ThumbUpIcon20.jpg /> "); 
								?>
                </td>
              </tr>
            </table>
          </div>
        <?php } } }?>
    </td></tr>
</table>
</body>
</html>
