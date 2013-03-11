<?php 
include "mainHeader.php";

include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
$ua=getBrowser();
  
$pic210_Name = $uname.'210.jpg';
$ProPercent = 70;

//Global Variable: 
$page_name = "MessageList.php";

include 'dbconnect.php';
$sender = $_SESSION['usrname'];
							
// Check if delete button active, start this 
if ( isset($_POST['delete']) && ! empty($_POST['delete'])) { 
	foreach ($_POST['need_delete'] as $msgid => $value) { 
		$sql = 'DELETE FROM rockinus.message_info WHERE msgid='.(int)$msgid; 
		mysql_query($sql); 
    
		$sql_hist = 'DELETE FROM rockinus.message_history WHERE msgid='.(int)$msgid; 
		mysql_query($sql_hist); 
	} 
} 
?> 
<div align="center" style="width:100%">
  <table width="1024" align="center" height="394" border="0" cellpadding="0" cellspacing="0" style="padding-top:0; margin-top:0;" bgcolor="#FFFFFF">
    <tr>
      <td width="255" align="left" valign="top" style=" padding:15px">
	  <?php include "MessageMenu.php" ?>
	  </td>
      <td width="769" align="left" valign="top">
	  <table width="740" height="394" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:20px; border-left:0px #DDDDDD solid; border-right:0px #DDDDDD solid">
          <tr>
            <td valign="top" align="left" style="padding-top:25px">
			<form action="" method="post" style="margin:0; border:0px solid #999999; background:#FFFFFF; padding-bottom:10" name="msgForm" id="msgForm">
            <table width="740" height="35" border="0" cellpadding="0" cellspacing="0" bgcolor="<?php echo($_SESSION['hcolor']) ?>" style="margin-bottom:0; background:url(img/444444_MenuBar.jpg)">
              <tr>
                <td width="45" height="30" style="border-left: #CCCCCC solid 0;" align="center">&nbsp; </td>
                <td width="125" height="30" align="left" style="padding-left:15px; font-size:12px; font-weight:normal; color:#FFFFFF">Sender</td>
                <td width="455" height="3" align="left" style="padding-right:15px; font-size:12px; font-weight:normal; color:#FFFFFF">Subject</td>
                <td width="115" height="30" align="right" style="padding-right:15px; font-size:12px; font-weight:normal; color:#FFFFFF">Sent Date</td>
              </tr>
            </table>
            <table width="740" height="30" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:15px; background:#EEEEEE">
              <tr>
                <td width="75" height="25" style="border-bottom: #DDDDDD dashed 0px; padding-left:5px" align="left">
				<input name="delete" type="submit" id="delete" value="Delete" style="height:20; padding:2 5 5 5; background: url(img/master.png); border:1px solid #CCCCCC; cursor:pointer; border-top:1px solid #DDDDDD; font-size:12px; color:#000000; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif" /></td>
                <td width="187" height="25" style="border-bottom:0px #DDDDDD dashed; padding-left:15px; font-size:14px">
				<script type="text/javascript">
					function selectAll(x) {
						for(var i=0,l=x.form.length; i<l; i++)
						if(x.form[i].type == 'checkbox' && x.form[i].name != 'sAll')
						x.form[i].checked=x.form[i].checked?false:true
					}
				</script>
				<input type="checkbox" name="sAll" onclick="selectAll(this)" /> 
				&nbsp;Select all<br />
				</td>
                <td width="320" style="border-bottom:0px #DDDDDD dashed">&nbsp;</td>
                <td width="164" height="25" align="right" style="padding-right:5px; font-size:14px; font-family:Arial, Helvetica, sans-serif">
				<?php

$q = "SELECT count(*) as cnt FROM rockinus.message_info where recipient='$sender'";

$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 25;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
if((!$limit) || (is_numeric($limit) == false)|| ($limit < 25) || ($limit > 50)) {
	$limit = 1; //default
}
 
if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items)) { 
	$page = 1; //default 
}
 
//calculate total pages
$total_pages = ceil($total_items / $limit);
$set_limit = ($page * $limit) - $limit;
//echo "Total Pages: $total_pages <br/>";
if ($total_items != 0 )echo "Page ";
//prev. page
$prev_page = $page - 1;
if($prev_page >= 1) { 
	echo("<a class='one' href=$page_name?limit=$limit&page=$prev_page>Previous</a>");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo(" <strong>$a</strong>  "); //no link
}else{ 
	echo("<a class='one' href=$page_name?limit=$limit&page=$a> <strong>$a</strong> </a>   ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo(" <a class='one' href=$page_name?limit=$limit&page=$next_page>Next</a>");
}
if ($total_items != 0 )echo "";
?>                </td>
              </tr>
            </table>
            <?php
//mysql_query("SET NAMES UTF8");	
//mysql_query('set names utf8') 
$q = mysql_query("
	(SELECT 'rockinus.message_info' AS tablename, msgid,sender,recipient,subject,iostatus,rstatus,pdate,ptime 
	FROM rockinus.message_info WHERE recipient='$uname' AND msgid NOT IN (SELECT msgid FROM rockinus.message_history WHERE recipient='$uname')) 
	UNION ALL
	(SELECT 'rockinus.message_history' AS tablename, msgid,sender,recipient,NULL as subject,NULL,rstatus,pdate,ptime 
	FROM rockinus.message_history WHERE recipient='$uname' AND msgid GROUP BY msgid) 
	ORDER BY msgid DESC LIMIT $set_limit, $limit");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("<br><br><div style='width:720' align='center'><img src=img/addsuccessIcon.jpg width=20/>&nbsp;&nbsp; <font color=$_SESSION[hcolor] size=4>You have no message.</font></div><br><br>");
else{
	while($object = mysql_fetch_object($q)){
		$msgid = $object->msgid;
		$sender = $object->sender;
		$recipient = $object->recipient;
		$iostatus = $object->iostatus;
		$rstatus = $object->rstatus;
		$subject = $object->subject;
		$pdate = $object->pdate;	
		$ptime = $object->ptime;	
		$tablename = $object->tablename;
		
		$r_sender = mysql_query("SELECT * FROM rockinus.user_info WHERE uname='$sender'");
		if(!$r_sender) die(mysql_error());
		$object_sender = mysql_fetch_object($r_sender);
		$s_fname = $object_sender->fname;
		$s_lname = $object_sender->lname;
		
		if($tablename=="rockinus.message_history"){
			$x = mysql_query("SELECT * FROM rockinus.message_info WHERE msgid='$msgid'");
			if(!$x) die(mysql_error());
			$ob = mysql_fetch_object($x);
			$subject = $ob->subject;
			
			$y = mysql_query("SELECT * FROM rockinus.message_history WHERE msgid='$msgid' AND recipient='$uname' AND rstatus='N'");
			if(!$y) die(mysql_error());
			if(mysql_num_rows($y)>0)$rstatus='N';
			
		}
		
		if($tablename=="rockinus.message_history" && $sender!=$uname)
			$subject = "[RE] ".$subject;
?>            
				    <table width="740" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px #EEEEEE solid">
                      <tr>
                        <td width="35" height="30" align="left" style=" padding-left:5px">
				
						<input name="need_delete[<?php echo($msgid) ?>]" type="checkbox" id="checkbox[<?php echo($msgid) ?>]" value="<?php echo($msgid) ?>" onclick="changeColor(this);">						</td>
                        <td width="125" height="30" align="left" style="font-size:14px; padding-left:5">
						<?php 
						if($iostatus=='I'){
							if($rstatus=='N')
								echo("<a href=rockerDetail.php?uid=$sender class=one><strong><font size=3>$s_fname</font></strong></a>");
							else{
								if($sender=="admin")
									echo("admin");
								else
									echo("<a href=RockerDetail.php?uid=$sender class=one>$s_fname</a>"); 	
							}
						}else
							echo($s_fname);
						?>						</td>
                        <td width="461" height="30" align="left" style="font-size:14px">
						<?php 
						if($rstatus=='N')
						echo("<a href='MessageDetail.php?msgid=$msgid' class='one' style='font-size:14px; font-family:Arial, Helvetica, sans-serif'><strong>$subject</strong></a>");
						else
						echo("<a href='MessageDetail.php?msgid=$msgid' class='one'>$subject</a>");
						?></td>
                        <td width="124" height="30" align="right" style="padding-right:5px; font-size:12px">
						<?php 
						if($rstatus=='N')
						echo("<font style='font-size:14px; font-family:Arial, Helvetica, sans-serif'><strong>$pdate</strong></font>");
						else
						echo($pdate) 
						?>						</td>
                      </tr>
              </table>
			<?php } }?></form>
			</td>
          </tr>
        </table>
      </td>
    </tr>
</table>
</div>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
