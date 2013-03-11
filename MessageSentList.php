<?php 
include "mainHeader.php";
//header("Content-Type: text/html; charset=gb2312");
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];
  
$pic210_Name = $uname.'210.jpg';
$ProPercent = 70;

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
<style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
<div align="center">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="257" align="left" valign="top" style=" padding:15px">
	  	  <?php include "MessageMenu.php" ?>
      </td>
      <td width="767" align="left" valign="top" style="padding-top:25">
	  <table width="740" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:0px solid #999999">
          <tr>
            <td valign="top" align="left" style="padding-top:0">
			<form action="" method="post" style="margin:0">
			<table width="740" height="35" border="0" cellpadding="0" cellspacing="0" style="background:url(img/444444_MenuBar.jpg)">
              <tr>
                <td width="40" height="35" style="border-left: #CCCCCC solid 0; color:#FFFFFF" align="center">&nbsp;</td>
                <td width="124" height="35" align="left" style="padding-left:15px; color:#FFFFFF; font-size:12px">Recipient</td>
                <td width="469" height="35" align="left" style="padding-right:15px; color:#FFFFFF; font-size:12px">Subject</td>
                <td width="107" height="35" align="right" style="font-size:12px; color:#FFFFFF; padding-right:15px">Sent Date</td>
              </tr>
            </table>
              <table width="740" height="30" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10; background:#EEEEEE">
              <tr>
                <td width="70" height="25" align="left" style="border-bottom: #DDDDDD dashed 0; padding-left:5px">
				<a href="DeleteMessage.php" class="one"></a> <input name="delete" type="submit" id="delete" value="Delete" style="height:20; padding:2 5 5 5; background: url(img/master.png); border:1px solid #CCCCCC; cursor:pointer; font-size:12px; color:#000000; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif" /></td>
                <td width="496" align="left" style=" padding-left:20; font-size:14px">
				<script type="text/javascript">
					function selectAll(x) {
						for(var i=0,l=x.form.length; i<l; i++)
						if(x.form[i].type == 'checkbox' && x.form[i].name != 'sAll')
						x.form[i].checked=x.form[i].checked?false:true
					}
				</script>
				<input type="checkbox" name="sAll" onclick="selectAll(this)" /> &nbsp;Select all<br />
				</td>
                <td width="176" height="25" align="right" style="padding-right:5px; font-size:14px; font-family:Arial, Helvetica, sans-serif">
				<?php
//Global Variable: 
$page_name = "MessageList.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
$sender = $_SESSION['usrname'];
$q = "SELECT count(*) as cnt FROM rockinus.message_info where sender='$sender'";
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
if ($total_items == 0 )echo("<font color=#B92828 style='font-size:13px'>Sent box is empty</font>&nbsp;");
//echo "Total Number: $total_items &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//echo "<br/>";
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

$q = mysql_query("SELECT * FROM rockinus.message_info where sender='$sender' ORDER BY pdate DESC LIMIT $set_limit, $limit");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
?></td>
              </tr>
            </table>
            <?php
			
if ($total_items == 0 )echo("<div style='width:700px; line-height:150%' align='center'><a href='SendMessage.php' class='two'><div style='margin-top:80; -moz-border-radius: 5px; border-radius: 5px; width:200px; height:22px; padding:5 0 5 0; background:#666666; border:1px solid #000000; color:#FFFFFF; font-weight:bold; cursor:pointer' align='center'>+ Write a new Message</div></a></div>");

while($object = mysql_fetch_object($q)){
	$msgid = $object->msgid;
	$subject = $object->subject;
	$recipient = $object->recipient;
	$pdate = $object->pdate;	
	$ptime = $object->ptime;
	
	$r_recipient = mysql_query("SELECT * FROM rockinus.user_info WHERE uname='$recipient'");
	if(!$r_recipient) die(mysql_error());
	$object_recipient = mysql_fetch_object($r_recipient);
	$r_fname = $object_recipient->fname;
	$r_lname = $object_recipient->lname;
?>
              
				<div style="margin-top:0; margin-bottom:0; padding-left:0; padding-top:0; padding-bottom:0; ">
                    <table width="740" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:#EEEEEE solid 1px">
                      <tr>
                        <td width="30" height="25" align="left" style=" padding-left:5px">
						<input name="need_delete[<?php echo($msgid) ?>]" type="checkbox" id="checkbox[<?php echo($msgid) ?>]" value="<?php echo($msgid) ?>"></td>
                        <td width="120" height="25" style="padding-left:5; font-size:14px" align="left"><?php echo("<a href=RockerDetail.php?uid=$recipient class=one>$r_fname</a>") ?></td>
                        <td width="476" height="25" align="left" style="font-size:14px"><?php echo("<a href='MessageDetail.php?msgid=$msgid' class='one'>$subject</a>") ?></td>
                        <td width="114" height="25" align="right" style="font-size:12px; padding-right:5px">
						<?php echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?></td>
                      </tr>
                  </table>
                </div>
			<?php } ?>	
			</form>
			</td>
          </tr>
        </table>
      </td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
