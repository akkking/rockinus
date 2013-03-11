<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
include 'emailfuc.php';
require("class.phpmailer.php");
$uname = $_SESSION['usrname'];
//$uid = $uname;
header('Content-type: text/html; charset=utf-8');

$reply_sel_count = "
SELECT sum(total) as cnt FROM (
	SELECT count(*) as total FROM rockinus.house_comment WHERE hid in (SELECT hid FROM rockinus.house_info WHERE uname='$uname') AND rstatus = 'N' AND sender<>'$uname'
	UNION 
	SELECT count(*) as total FROM rockinus.article_comment WHERE aid IN (SELECT aid FROM rockinus.article_info WHERE uname='$uname') AND rstatus = 'N' AND sender<>'$uname' 
	UNION 
	SELECT count(*) as total FROM rockinus.interview_question_follow WHERE q_id IN (SELECT q_id FROM rockinus.interview_question WHERE creater='$uname') AND rstatus = 'N' AND uname<>'$uname' 
	UNION 
	SELECT count(*) as total FROM rockinus.memo_follow_info WHERE recipient='$uname' AND rstatus = 'N' AND memoid IN (SELECT memoid FROM rockinus.memo_info WHERE sender='$uname')
	UNION 
	SELECT count(*) as total FROM rockinus.headicon_like WHERE headicon_id IN (SELECT headicon_id FROM rockinus.headicon_history WHERE uname='$uname') AND rstatus = 'N'
) as cnt";

$t = mysql_query($reply_sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());

$a = mysql_fetch_object($t);
$replied_cnt = $a->cnt;
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
    <td width="300" valign="top" align="left" style="border-right:1px dashed #DDDDDD">
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
	<table width="740" border="0" cellspacing="0" cellpadding="0" style=" border:0px solid #DDDDDD">
  <tr>
    <td height="31" align="left" bgcolor="" style='margin-bottom:0; width:740; padding: 5 10 10 20'>
	<table width="730" border="0" style="border-bottom:4px solid #EEEEEE;"><tr><td width="618" style="font-size:18px; font-family: Arial, Helvetica, sans-serif; font-weight:normal; padding: 0 0 8 0; background: ; color:#666666; border-top:0px solid #DDDDDD;">
	Currently you have <?php if($replied_cnt==0)echo("<strong>0</strong>"); else echo("<strong>$replied_cnt</strong>") ?> new update(s) 
	</td>
	<td width="100" style="padding-bottom:5">
	<a href="ThingsRock.php">
<div style="height:18px; background: url(img/master.jpg); border:1px solid #DDDDDD; border-right:1px solid #999999; border-bottom:1px solid #999999; font-size:11px; font-weight:bold; margin-left:17; margin-top:; font-family:Arial, Helvetica, sans-serif; width: 75; padding:0 3 0 3; color:<?php echo($_SESSION['hcolor']) ?>; line-height:150%" align="center" onmouseover="this.style.background='url(img/GrayGradbgDown.jpg)'" onmouseout="this.style.background='url(img/master.jpg)'">Home Page</div>
	</td>
	</tr></table>
	</td>
  </tr>
  <tr>
    <td height="384" style=" border-top:0px solid #CCCCCC; padding-left:5" valign="top"; align="left">
	<?php if($replied_cnt==0){ ?>
	<table width="740" height="85" border="0" cellpadding="0" cellspacing="0" style=" margin-bottom:40; margin-top:0">
      <tr>
        <td valign="top" style="padding-left:10; padding-bottom:5px; background-color:#FFFFFF; padding-top:0">
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
					SELECT headicon_id,uname,NULL,NULL,pdate,ptime,'headicon_history' AS tbname,NULL,NULL,NULL,NULL,NULL, descrip 
					FROM rockinus.headicon_history hl WHERE uname='$uid' 
					UNION 
					SELECT hi_follow_id,sender,recipient,NULL,pdate,ptime,'headicon_comment' AS tbname,NULL,NULL,NULL,NULL,NULL, descrip FROM rockinus.headicon_comment hc WHERE sender='$uid' 
					UNION 
					SELECT q_id,creater,company,category,pdate,ptime,'interview_question' AS tbname,position,positionCategory,rstatus,qdate,NULL, descrip 
					FROM rockinus.interview_question iq WHERE creater='$uid' 
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
            <div style="border-bottom:0px #EEEEEE solid; border-top:1px #FFFFFF solid; padding-bottom:10px;" onmouseover="document.getElementById('dh<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('mh<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('dh<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('mh<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
              <table width="740" height="58" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="35" rowspan="2" align="center" valign="top" style="padding-top:5"><font size="2" color="<?php echo($_SESSION['hcolor'])?>"><img src="img/houseMenuIcon.jpg" width="15" /></font></td>
                  <td width="591" height="30" align="left" valign="top" style="padding-left:10px; padding-top:5; font-size:14px"><?php 
								  echo("<a href=HouseDetail.php?hid=$id class=one><font color=$_SESSION[hcolor]>$subject</font></strong></a>");
							  ?></td>
                  <td width="114" style="padding-right:10px" align="right"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5))?> </font> </td>
                </tr>
                <tr>
                  <td height="23" align="left" style="padding-left:10px; padding-top:0px; color:#999999; padding-bottom:5; line-height:130%; font-size:13px" valign="top"><?php 
						  if(strlen($descrip)>1000)
						  	echo(substr(nl2br($descrip),0,1000)." ...");
						  else
						    echo(nl2br($descrip));
					  ?>
                  </td>
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
                  <td height="30" align="left" valign="middle" bgcolor="#F5F5F5" style="padding:8; color:#999999; font-size:13px; line-height:150%"><?php 
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
            <div style="border-bottom:0px #EEEEEE solid; border-top:0px #EEEEEE solid; padding-bottom:10px;" onmouseover="document.getElementById('da<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('ma<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('da<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('ma<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
              <table width="740" height="59" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="33" rowspan="2" align="center" valign="top" style="padding-top:5"><font color="<?php echo($_SESSION['hcolor'])?>"><img src="img/colorBuyIcon.jpg" width="15" /></font></td>
                  <td width="586" height="31" align="left" valign="top" style="padding-left:10px; padding-top:5; font-size:14px; font-weight:"><?php 
						  echo("<a href=ArticleDetail.php?aid=$id class=one><font color=$_SESSION[hcolor]>$subject</font></a>");
					?>                  </td>
                  <td width="121" style="padding-right:10px" align="right"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5))?></font></td>
                </tr>
                <tr>
                  <td height="28" align="left" valign="top" style="padding: 10; color:#999999; padding-top:0px; font-size:13px; line-height: 130%"><?php 
						  if(strlen($descrip)>1000)
						  	echo(substr(nl2br($descrip),0,1000)." ...");
						  else
						    echo(nl2br($descrip));
					  ?></td>
                  <td style="padding-right:10px" align="right" valign="top"><?php 
					  if($uname==$loopname)echo("<span id='da$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=ArticleConfirm.php?aid=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='ma$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditArticle.php?aid=$id><font size=1>+ Edit</font></a></span>");
					  ?>                  </td>
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
            <div style="border-bottom:0px #EEEEEE solid; border-top:1px #FFFFFF solid; padding-bottom:10px; " onmouseover="document.getElementById('df<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('mf<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('df<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('mf<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
              <table width="740" height="63" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="35" rowspan="2" align="center" valign="top" style="padding-top:10"><font size="2" color="<?php echo($_SESSION['hcolor'])?>"> <img src="img/newsMenuIcon.jpg" width="15" /></font></td>
                  <td width="572" height="30" align="left" valign="top" style="padding-left:10px; padding-top:5; line-height: 150%; font-size:16px; font-weight:; color:<?php echo($_SESSION['hcolor']) ?>"><?php 
						  echo($subject);
						?>                  </td>
                  <td width="136" style="padding-right:10px" align="right"><font size="1"> <?php echo("$pdate | ".substr($ptime,0,5))?> </font> </td>
                </tr>
                <tr>
                  <td height="33" align="left" valign="top" style="padding:0 10 10 10; color:#999999; line-height:130%; font-size:13px"><?php 
						  if(strlen($descrip)>20)
						  	echo(substr(nl2br($descrip),0,500)." ...");
						  else
						    echo("<a href=forumDetail.php?aid=$id class=one>Click for details >>></a>");
					  ?>
                  </td>
                  <td style="padding-right:10px" align="right" valign="top"><?php 
					  if($uname==$loopname)echo("<span id='df$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=ForumConfirm.php?news_id=$id&&pageName=RockerDetail><font size=1>Delete</font></a></span> <span id='mf$id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditNews.php?news_id=$id><font size=1>+ Edit</font></a></span>");
					  ?>
                  </td>
                </tr>
              </table>
            </div>
          <?php }else if($tbname=="room_mate_info"){
							?>
            <div style="border-bottom:0px #EEEEEE solid; border-top:1px #FFFFFF solid; padding-bottom:10px; margin-bottom:10px" onmouseover="document.getElementById('df<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('mf<?php echo($id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>';" onmouseout="document.getElementById('df<?php echo($id)?>').style.backgroundColor='#FFFFFF';document.getElementById('mf<?php echo($id)?>').style.backgroundColor='#FFFFFF';">
              <table width="740" height="70" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="35" rowspan="2" align="center" valign="top" style="padding-top:10">
				  <img src="img/headIcon.jpg" width="15" /></td>
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
          <?php }else if($tbname=="memo_info"){ ?>
          <div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:10px; padding-bottom: 10px; border-bottom:0px #DDDDDD solid; width:740px">
            <table width="740" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="35" height="78" align="center" valign="top" style="padding-left:0px; padding-top:5px">
				<img src="img/status_blue.png" width="15" /> </td>
                <td width="705" align="left" valign="top" style="padding-left:10px; padding-top:2; font-size:16px"><?php
			echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]>Status Post</font></a> ");
			echo("<font color='#999999' style='font-size:11px'>(".getDateName($pdate)." | ".substr($ptime,0,5).")</font>");
							  ?>
                    <div style="margin-top:10px; margin-bottom:10px; font-size:12px">
                      <?php 
								echo(addHyperLink(str_replace("\\","",nl2br($descrip))));
								?>
                    </div>
                  <?php 
$q1 = mysql_query("SELECT * FROM rockinus.memo_follow_info WHERE memoid='$id' ORDER BY pdate ASC, ptime ASC LIMIT 0,5");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row > 0){ 
	while($object = mysql_fetch_object($q1)){
		$memofid = $object->memofid;	
		$sender = $object->sender;	
		$descrip = $object->descrip;
		$descrip = str_replace("\\","",nl2br($descrip));
		$reply_ptime = $object->ptime;
		$reply_pdate = $object->pdate; 
		
 $q_sender = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$sender'");
 if(!$q_sender) die(mysql_error());
 $object_sender = mysql_fetch_object($q_sender);
 $sender_fname = $object_sender->fname;
 $sender_lname = $object_sender->lname;
?>
                    <div style="margin-bottom:5px; margin-top:5px; width: 450;" align="left" class="statusReplyDiv<?php echo($memofid) ?>" id="statusReplyDiv<?php echo($memofid) ?>">
                      <table width="450" height="45" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-bottom:0px solid #DDDDDD;">
                        <tr>
                          <td width="285" height="20" align="left" valign="top" bgcolor="#F5F5F5" style="padding-left:5; font-size:12px; padding-top:5"><?php echo(" <a href=RockerDetail.php?uid=$sender class=one><FONT color=$_SESSION[hcolor]>$sender_fname $sender_lname</font></a>") ?> </td>
                          <td width="139" height="20" align="right" valign="top" bgcolor="#F5F5F5" style="padding-top:7; font-size:12px">                         </td>
                          <td width="120" height="20" align="right" valign="top" bgcolor="#F5F5F5" style="font-size:10px; padding-right:5; color:#666666; padding-top:5"><?php echo(getDateName($reply_pdate)) ?> | <?php echo(substr($reply_ptime,0,5)) ?> </td>
                        </tr>
                        <tr>
                          <td height="20" colspan="3" valign="top" style="line-height:120%; font-size:11px; padding:5"><?php
													if(strlen($descrip)>500)
														echo(substr($descrip,0,500)." ...<br>");
													else
														echo($descrip);
												?>
                          </td>
                        </tr>
                      </table>
                    </div>
                    <?php }}?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js">
                                  </script>
                    <script type="text/javascript" >
 $(function() {
 $(".commentStatusSubmitBtn<?php echo($id) ?>").click(function() {
var test = $("#content<?php echo($id) ?>").val();
var memoid = <?php echo($id) ?>;
var pdate = '<?php echo(date('Y-m-d')) ?>';
var ptime = '<?php echo(date("H:i:s", time())) ?>';
var sender = '<?php echo($uname) ?>';
var recipient = '<?php echo($loopname) ?>';
var dataString = 'content='+ test+'&memoid='+memoid+'&sender='+sender+'&recipient='+recipient+'&pdate='+pdate+'&ptime='+ptime; 

if(test==''||test=='Write here...')
{
 alert("Please Enter Some Text");
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
  $("#displayStatus<?php echo($id) ?>").after(html);
  document.getElementById('content<?php echo($id) ?>').value='';
  document.getElementById('content<?php echo($id) ?>').focus();
  $("#flashStatus<?php echo($id) ?>").hide();
  $("#commentStatusDiv<?php echo($id) ?>").hide();
  $("#commentStatusBtn<?php echo($id) ?>").show();
  }
 });
 } return false;
 });
 });
                                  </script>
                    <div id="flashStatus<?php echo($id) ?>" class="flashStatus<?php echo($id) ?>" style="padding-left:10px"></div>
                  <div id="displayStatus<?php echo($id) ?>" class="displayStatus<?php echo($id) ?>" style="padding-left:10px"></div>
                  </td>
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
            <div style="border-bottom:0px #EEEEEE solid; border-top:0px #EEEEEE solid;  padding-bottom:10px;">
              <table width="740" height="59" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="35" rowspan="2" align="center" valign="top" style="padding-top:5">
					  <img src="img/studyMenuIcon.jpg" width="15" /></td>
                  <td width="591" height="28" style="padding-left:10px; font-size:14px; padding-top:5" valign="top">
				  <?php
							  	echo("<a href=CourseDetail.php?course_uid=$id class=one><font color=$_SESSION[hcolor]>$course_id - $course_name</font></a>");
							  ?></td>
                  <td width="116" height="28" align="right" style="padding-right:10px"><font size="1"><?php echo("$pdate | ".substr($ptime,0,5)) ?></font> </td>
                </tr>
                <tr>
                  <td height="28" style="padding-left:10px; line-height:130%; color:#999999; font-size:13px; padding-top:0px" valign="top"><?php 
						echo(nl2br($subject));
							  ?></td>
                  <td height="28" align="right" style="padding-right:10; padding-top:0" valign="top"><?php 
								for($i=0;$i<$action;$i++)
									echo("<img src=img/yellowstar.jpg /> "); 
								?>
                  </td>
                </tr>
              </table>
            </div>
          <?php }else if($tbname=="interview_question"){  ?>
          <div style="padding-left:0; padding-top:; padding-bottom: 10px; border-bottom:0px #DDDDDD solid; width:740px">
            <table width="740" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="35" height="69" align="center" valign="top" style="padding-left:0px; padding-top:5px">
				<img src="img/calendar100_back.jpg" width="15" /> </td>
                <td width="698" align="left" valign="top" style="padding-left:10px; padding-top:3; font-size:16px; padding-bottom:10px"><?php
			echo("<a href='interviewQuestionDetail.php?q_id=$id' class=one><font color=$_SESSION[hcolor]>$subject</font></a><br><div style='margin-top:5; font-size:13px'>".ucfirst($action).", $city, $type position@$xxxx</div>");
			echo("<div style='margin-top:5px'><font color='#999999' style='font-size:11px'>".getDateName($pdate)." | ".substr($ptime,0,5)."</font></div>");
							  ?>
                    <div style="margin-top:10px; margin-bottom:0px; font-size:12px; color:#999999">
                      <?php 
								if(strlen($descrip)>200)
								echo(substr(addHyperLink(str_replace("\\","",nl2br($descrip))),0,200)."...");
								else
								echo(addHyperLink(str_replace("\\","",nl2br($descrip))));
								?>
                    </div>
                    </td>
              </tr>
            </table>
          </div>
          <?php }else if($tbname=="headicon_history"){  ?>
          <div style="width:700px; margin-bottom:10">
            <table width="700" height="132" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="35" rowspan="2" valign="top" align="center" style="padding-top:5px; font-size:14px; font-weight:normal">
				<img src="img/user_man.png" width="15" /><br />
				</td>
                <td width="667" height="30" valign="top" style="padding:5px; padding-top:2; padding-left:10px; font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:normal"><?php 
				$q_loopName = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$loopname'");
				if(!$q_loopName) die(mysql_error());
				$object_icon = mysql_fetch_object($q_loopName);
				$icon_fname = $object_icon->fname;
				$icon_lname = $object_icon->lname;
				$icon_gender = $object_icon->gender;
				if($icon_gender=='Female')$tmp_gender="her";
				else $tmp_gender="his";
								echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]>$icon_fname $icon_lname</font></a> (New icon)");
								?>                </td>
              </tr>
              <tr>
                <td align="left" valign="top" style="padding:0 0 5 10; font-size:14px"><?php
									$loopImg = "upload/$loopname/$loopname.jpg";
							  		$data = getimagesize($loopImg); 
									$width = $data[0]; 
									if($width>300){
										$loopImg = "upload/$loopname/$loopname.jpg";
										$width = 210;
									}else if($width>250){
										$loopImg = "upload/$loopname/$loopname.jpg";
										$width = 210;
									}else if($width>200){
										$loopImg = "upload/$loopname/$loopname.jpg";
										$width = 200;
									}else{
										$loopImg = "upload/$loopname/$loopname"."250.jpg";
										$width = 100;
									}
									
									if(file_exists($loopImg)) echo("<a href=RockerDetail.php?uid=$loopname class=one><img src=$loopImg?".time()." style='border:0px #666666 solid; margin-bottom:10px' width=$width /></a>");
							  else echo("<a href=RockerDetail.php?uid=$loopname class=one><img src=img/NoUserIcon100.jpg width=80px style='margin-bottom:10px' /></a>");
							  echo("<br><font color=#999999 style='font-weight:normal; font-size:11px'>".getDateName($pdate)." | ".substr($ptime,0,5)."</font><br>");
							  ?>
                    </td>
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
        </td>
      </tr>
    </table>
	<?php
	}else{ 
$sql_stmt = "
	SELECT hid, descrip, sender, pdate, ptime, 'house_info' AS tbname FROM rockinus.house_comment WHERE hid in (SELECT hid FROM rockinus.house_info WHERE uname='$uname') AND rstatus = 'N' AND sender<>'$uname'
	UNION 
	SELECT aid, descrip, sender, pdate, ptime, 'article_info' AS tbname FROM rockinus.article_comment WHERE aid IN (SELECT aid FROM rockinus.article_info WHERE uname='$uname') AND rstatus = 'N' AND sender<>'$uname' 
	UNION 
	SELECT q_id, descrip, uname, pdate, ptime, 'interview_question' AS tbname FROM rockinus.interview_question_follow WHERE q_id IN (SELECT q_id FROM rockinus.interview_question WHERE creater='$uname') AND rstatus = 'N' AND uname<>'$uname' 
	UNION 
	SELECT memoid, descrip, sender, pdate, ptime, 'memo_follow_info' AS tbname FROM rockinus.memo_follow_info x WHERE recipient='$uname' AND rstatus = 'N' GROUP BY x.memoid
	UNION 
	SELECT headicon_id, null, uname, pdate, ptime, 'headicon_like' AS tbname FROM rockinus.headicon_like WHERE headicon_id IN (SELECT headicon_id FROM rockinus.headicon_history WHERE uname='$uname') AND rstatus = 'N'";
	//echo($sql_stmt);
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($no_row == 0) echo("");
		while($object = mysql_fetch_object($q)){
			$loopname = $object->sender;			
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			$id = $object->hid;
			$tbname = $object->tbname;
			$subject = str_replace("\\","",nl2br($subject));
			$descrip = str_replace("\\","",$descrip);
            if($tbname=="house_info"){
 $q_house = mysql_query("SELECT subject FROM rockinus.house_info WHERE hid='$id'");
 if(!$q_house) die(mysql_error());
 $object_house = mysql_fetch_object($q_house);
 $subject = $object_house->subject;
?>
<div style='margin-bottom:20; width:740; height:20; font-size:13px; padding:5 10 5 10; background: #F5F5F5; border-top:1px solid #DDDDDD; border-bottom:1px solid #DDDDDD;' align="left">
<font color='#000000' style='font-size:13px; font-weight:bold'>house_info</font>
</div>
<?php
}else if($tbname=="article_info"){
?>
<div style='margin-bottom:20; width:740; height:20; font-size:13px; padding:5 10 5 10; background: #F5F5F5; border-top:1px solid #DDDDDD; border-bottom:1px solid #DDDDDD;' align="left">
<font color='#000000' style='font-size:13px; font-weight:bold'>article_info</font>
</div>
<?php
}else if($tbname=="memo_follow_info"){
	//echo("SELECT * FROM rockinus.memo_info WHERE memoid='$id'");
	$q_memo = mysql_query("SELECT * FROM rockinus.memo_info WHERE memoid='$id'");
	if(!$q_memo) die(mysql_error());
	$memo_no_row = mysql_num_rows($q_memo);
	if($memo_no_row==0){
		//echo("<div style='color:#999999; font-size:13px; padding-top:10; padding-bottom:10; font-weight:bold' align='center'><img src=img/notfoundIcon.jpg width=10 />&nbsp;&nbsp;Nothing posted</div>");
	}
	$object = mysql_fetch_object($q_memo);
	$memoid = $object->memoid;
	$descrip = $object->descrip;
	$descrip = str_replace("\\","",nl2br($descrip));
	$pdate = $object->pdate;
	$ptime = $object->ptime;
	$sender_= $object->sender;
	if($descrip==NULL)
		echo("<div style='width:550; background:#F5F5F5; padding:5 5 5 7; margin-top:10; margin-bottom:5; line-height:150%; font-size:13px; border:1px solid #EEEEEE; font-family:Georgia, \"Times New Roman\", Times, serif' align='left'><em><font style='font-size:16px; color:#000000; font-weight:normal'>Hi, what's going on?</font></em><br><font color=#666666 style='font-size:11px'> $sender_ (".getDateName($pdate)." | ".substr($ptime,0,5).")</font></div>"); 
	else{ 
		echo("<div class='statusDiv$memoid' class='statusDiv$memoid' style='width:550; background:#F5F5F5; padding:5 5 5 7; margin-top:10; line-height:135%; font-size:16px; border:1px solid #EEEEEE; margin-bottom:5; font-family:Georgia, \"Times New Roman\", Times, serif'><em>".addHyperLink($descrip)."</em><br><font color=#666666 style='font-size:11px'> $sender_ (".getDateName($pdate)." | ".substr($ptime,0,5).")</font></div>"); 
	}

	$t = mysql_query("SELECT count(*) AS cnt FROM rockinus.memo_follow_info WHERE memoid='$memoid';");
	$a = mysql_fetch_object($t);
	$memo_follow_cnt = $a->cnt;
	
	$t_u = mysql_query("SELECT count(*) AS cnt FROM rockinus.memo_follow_info WHERE memoid='$memoid' AND recipient='$uname' AND rstatus='N';");
	$a_u = mysql_fetch_object($t_u);
	$memo_follow_unread_cnt = $a_u->cnt;
	
	$q_sel = mysql_query("SELECT * FROM rockinus.memo_follow_info WHERE memoid='$memoid' ORDER BY memofid ASC;");
	if(!$q_sel){
		$output = mysql_error();
		echo($output);
	}
	
	while($object = mysql_fetch_object($q_sel)){
		$memofid = $object->memofid;
		$sender = $object->sender;
		$recipient = $object->recipient;
		$descrip = $object->descrip;
		$descrip = str_replace("\\","",nl2br($descrip));
		$memo_follow_rstatus = $object->rstatus;
		$pdate = $object->pdate;
		$ptime = $object->ptime;
		
		$loopSenderImg = "upload/$sender/$sender"."60.jpg";
		if(file_exists($loopSenderImg))
			$loopSenderImg = "<div style='height:40;overflow-x:hidden;overflow-y:hidden;' align='left'><img src='$loopSenderImg' width='40' style='border:0px solid #DDDDDD'></div>"; 
		else
			$loopSenderImg = "<img src='img/NoUserIcon100.jpg' width=40 style='border:0px solid #DDDDDD'>";
		
		$q_sender = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$sender'");
		if(!$q_sender) die(mysql_error());
		$object_sender = mysql_fetch_object($q_sender);
		$sender_fname = $object_sender->fname;
		$sender_lname = $object_sender->lname;
		
		$q_recipient = mysql_query("SELECT fname,lname FROM rockinus.user_info WHERE uname='$recipient'");
		if(!$q_recipient) die(mysql_error());
		$object_recipient = mysql_fetch_object($q_recipient);
		$recipient_fname = $object_recipient->fname;
		$recipient_lname = $object_recipient->lname;
		?>

	<div id="replyInfoDiv<?php echo($memofid) ?>" class="replyInfoDiv<?php echo($memofid) ?>" style=" padding-top:5; padding-bottom:0; width:550px; border-bottom:1px solid #F5F5F5" onmouseover="document.getElementById('replyStatusBtn<?php echo($memofid)?>').style.display = 'block';" onmouseout="document.getElementById('replyStatusBtn<?php echo($memofid)?>').style.display = 'none';">
<table width="550" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="55" valign="top" style="padding-left:5" align="left"><?php echo($loopSenderImg) ?></td>
    <td width="495" valign="top">
	<table width="490" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:0; border-bottom:0 dashed #DDDDDD">
      <tr>
        <td width="350" height="20" align="left" valign="top" style=" font-weight:normal; padding-left:0; font-size:13px; padding-top:0; padding-bottom:2; line-height:150%; background:"><?php 
	if($memo_follow_rstatus=="N"&&$recipient==$uname){
	 ?>
			<table border='0' cellpadding='0' cellspacing='0' width='480'>
			<tr>
			<td width=430 style="font-size:13px;">
			<font style="color:<?php echo($_SESSION[hcolor])?>"><?php echo($sender_fname) ?>:</font> <strong><?php echo($descrip)?></strong>&nbsp;&nbsp;</td>
			<td align='right'>
			<a class='one'><span class="replyStatusBtn<?php echo($memofid)?>" id="replyStatusBtn<?php echo($memofid)?>" style="color:<?php echo($_SESSION[hcolor])?>; cursor:pointer; width:50px; font-size:13px; display:none;" onclick="setHiddenVal('<?php echo($sender) ?>')">Reply</span>
			</a>
			<input type="hidden" id="hiddenRecipientVal" name="hiddenRecipientVal" />
			</td></tr></table>
		<?php
	}else{
		if($sender_==$recipient)
			echo("<font color=$_SESSION[hcolor]>$sender_fname:</font> $descrip");
		else
			echo("<font color=$_SESSION[hcolor]>$sender_fname:</font> <font color=#000000 style='font-size:13px'>$recipient_fname:</font> $descrip"); 
	}
	?>        </td>
      </tr>
      <tr>
        <td height="20" align="left" valign="top" style=" font-weight:normal; padding-left:0; font-size:12px; color:#CCCCCC; line-height:150%">
		<?php echo(getDateName($pdate).", ".substr($ptime,0,5)) ?> &nbsp;
		<?php 
		if($uname==$sender){ ?>
          <span style=" height:15; padding:; background:; width:50; display:inline; border:0px solid #999999;  font-size:11px; cursor:pointer; color:#CCCCCC" align="center" id="deleteReplyBtn<?php echo($memofid) ?>" class="deleteReplyBtn<?php echo($memofid) ?>">Delete</span>
            <?php } ?>
		</td>
      </tr>
      <tr>
        <td align="left" valign="top" style=" font-weight:normal; padding-left:0; font-size:11px; padding-top:2; color:#999999; line-height:125%; padding-bottom:5px; border-bottom:0px solid #DDDDDD; background:">    
<script>
$(document).ready(function() { 
	$("#flashReply<?php echo($memofid) ?>").hide();
	$("#displayReplyResult<?php echo($memofid) ?>").hide();
	
	$(".replyStatusContent<?php echo($id) ?>").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#replySubmitBtn<?php echo($id) ?>").show();
	});
	
	$('.replyStatusBtn<?php echo($memofid) ?>').click(function(){
	  document.getElementById('replyStatusContent<?php echo($id) ?>').value = '@'+'<?php echo($sender_fname) ?>'+': ';
   	  $('#replyStatusContent<?php echo($id) ?>').text($('#replyStatusContent<?php echo($id) ?>').text()).focus();
	});
});
</script>

<script type="text/javascript" >
$(function() {
	$(".deleteReplyBtn<?php echo($memofid) ?>").click(function() {
		var memofid = <?php echo($memofid) ?>;
		var dataString = 'memofid='+memofid; 

		if(memofid=='')
		{
			alert("not getting memo id!");
		}
		else
		{
			$("#replyInfoDiv<?php echo($memofid) ?>").hide();
			$("#flashdeleteReply<?php echo($memofid) ?>").show();
 			$("#flashdeleteReply<?php echo($memofid) ?>").fadeIn(400).html('');
 
			$.ajax({
 				type: "POST",
				url: "ajax_delete_reply.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#deleteReplyResult<?php echo($memofid) ?>").after(html);
					document.getElementById('replyStatusContent<?php echo($id) ?>').value='';
					document.getElementById('replyStatusContent<?php echo($id) ?>').focus();
					$("#flashdeleteReply<?php echo($memofid) ?>").hide();
					$("#deleteReplyResult<?php echo($memofid) ?>").fadeOut("slow");
				}
			});
		} return false;
 	});
 });
                </script>
                <div class="flashDeleteReply<?php echo($memofid) ?>" id="flashDeleteReply<?php echo($memofid) ?>" style="display:none"></div>
                <div class="deleteReplyResult<?php echo($memofid) ?>" id="deleteReplyResult<?php echo($memofid) ?>" style="display:none"></div>         
				</td>
      </tr>
    </table></td>
  </tr>
</table>
</div>	
    <? 
		// Update rstatus of follow comment, set it already read
		$upd_memo_follow = mysql_query("UPDATE rockinus.memo_follow_info SET rstatus='Y' WHERE rstatus='N' AND memofid='$memofid';");
		if(!$upd_memo_follow) die(mysql_error());
	}	
	?>
	 
	 <script language="javascript"> 
function setHiddenVal(recipientVal) {
	//alert(channelVal);
	document.getElementById('hiddenRecipientVal').value=recipientVal;
}
</script>

<script type="text/javascript" >
$(function() {
	$(".replySubmitBtn<?php echo($id) ?>").click(function() {
		var test = $("#replyStatusContent<?php echo($id) ?>").val();
		var pdate = '<?php echo(date('Y-m-d')) ?>';
		var ptime = '<?php echo(date("H:i:s", time())) ?>';
		var sender = '<?php echo($uname) ?>';
		var recipient = document.getElementById('hiddenRecipientVal').value;
		if(recipient==''||recipient.length==0) recipient='<?php echo($sender_) ?>';
		var memoid = '<?php echo($memoid) ?>';
		var dataString = 'content='+ test+'&sender='+sender+'&recipient='+recipient+'&memoid='+memoid+'&pdate='+pdate+'&ptime='+ptime; 

		if(test==''||test=='Write here...')
		{
			alert("Please Enter Something ok?");
		}
		else
		{
			$("#replyStatusDiv<?php echo($id) ?>").hide();
			$("#flashReply<?php echo($id) ?>").show();
			$("#flashReply<?php echo($id) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle" width=100>');
 
 			$.ajax({
  				type: "POST",
  				url: "ajax_reply_status_recent.php",
  				data: dataString,
  				cache: false,
  				success: function(html){
  					$("#displayReplyResult<?php echo($id) ?>").after(html);
					document.getElementById('replyStatusContent<?php echo($id) ?>').value='';
					$("#flashReply<?php echo($id) ?>").hide();
					$("#replyStatusBtn<?php echo($id) ?>").show();
  				}
 			});
 		} return false;
 	});
});
</script>
	 
	 <div class="flashReply<?php echo($id) ?>" id="flashReply<?php echo($id) ?>" style=" margin-top:10; margin-left:5px; display:none"></div>
     <div class="displayReplyResult<?php echo($id) ?>" id="displayReplyResult<?php echo($id) ?>" style="margin-top:10; margin-left:5px; display:none"></div>   
     <textarea name="replyStatusContent<?php echo($id) ?>" id="replyStatusContent<?php echo($id) ?>" class="replyStatusContent<?php echo($id) ?>" style=" width:550px; border:1px solid #DDDDDD; height:35px; font-size:13px; padding:4; font-weight:normal; font-family: Arial, Helvetica, sans-serif; margin-bottom:5px; margin-left:5px" onclick="this.style.height = '55px'; if(this.value=='Write here...')this.value=''" onFocus="this.style.height = '55px'; document.getElementById('replySubmitBtn<?php echo($id) ?>').style.display = 'block'; " onBlur=" this.style.height = '35px'; this.value=!this.value?'Write here...':this.value;">Write here...</textarea>
        <div class="replySubmitBtn<?php echo($id) ?>" id="replySubmitBtn<?php echo($id) ?>" style=" height:17; padding:2 5 2 5; background: <?php echo($_SESSION['hcolor']) ?>;  margin-top:0; margin-left:5; line-height:150%; width:50px; border:1px solid #333333; border-top:0px solid #DDDDDD; font-size:12px; cursor:pointer; color:#FFFFFF; display:none" align="center">Submit</div><br />
<?php	
}else if($tbname=="headicon_like"){
?>
<div style='margin-bottom:20; width:740; height:20; font-size:13px; padding:5 10 5 10; background: #F5F5F5; border-top:1px solid #DDDDDD; border-bottom:1px solid #DDDDDD;' align="left">
<font color='#000000' style='font-size:13px; font-weight:bold'>headicon_like</font>
</div>
<?php
}else if($tbname=="interview_question"){
?>
<div style='margin-bottom:20; width:740; height:20; font-size:13px; padding:5 10 5 10; background: #F5F5F5; border-top:1px solid #DDDDDD; border-bottom:1px solid #DDDDDD;' align="left">
<font color='#000000' style='font-size:13px; font-weight:bold'>interview_question</font>
</div>
<?php
		}
	}
}
?>
	</td>
  </tr>
</table>
</td>
  </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
