<?php 
include 'mainHeader.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];
?>
<link rel="stylesheet" href="style.css" />
<div align="center">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td align="left" valign="top" style=" padding:15px">
	  <table width="990" height="50" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-top:solid 0px #DDDDDD; border-bottom:solid 0px #999999">
        <tr>
          <td height="30" style=" font-weight:bold; color:<?php echo($_SESSION['hcolor']) ?>; font-size:18px; line-height:150%" align="center">
            <?php
if(isset($_GET['aid']))
	$aid = $_GET['aid'];
else if(isset($_POST['aid']))
	$aid = $_POST['aid'];
mysql_query("SET NAMES GBK");
$q = mysql_query("SELECT * FROM rockinus.article_info where aid=$aid");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$aid = $object->aid;
$subject = $object->subject;
$subject = str_replace("\\","",nl2br($subject));
$type = $object->type;
$condition = $object->quality;
$delivery = $object->delivery;
if($delivery=='N')$delivery='No';else '$delivery=Yes';
$state = $object->state;
$city = $object->city;
$email = $object->email;
$rate = $object->rate;
$telephone = $object->telephone;
$num = $object->num;
$aname = $object->aname;
$postuname = $object->uname;
$rstatus = $object->rstatus;
$description = $object->descrip;
$description = str_replace("\\","",nl2br($description));
$pdate = $object->pdate;
$ptime = $object->ptime;

if($uname==$postuname){
	$t2 = mysql_query("SELECT * FROM rockinus.article_comment WHERE rstatus='N' AND aid=$aid");
	if(!$t2) die(mysql_error());
	$no_row_hist = mysql_num_rows($t2);
	
	if($no_row_hist>0){	
		$upd = mysql_query("UPDATE rockinus.article_comment SET rstatus='Y' WHERE aid='$aid' AND rstatus='N'");
		if(!$upd) die(mysql_error());
	}
}

$unameImg = "upload/$uname/$uname"."60.jpg";
if(file_exists($unameImg))
	$unameImg = "<div style='height:50;overflow-x:hidden;overflow-y:hidden;' align='left'><img src='$unameImg' width='40' style='border:0px solid #DDDDDD'></div>"; 
	else
	$unameImg = "<img src='img/NoUserIcon100.jpg' width=50 style='border:0px solid #DDDDDD'>";
?>
          <?php echo($subject) ?></font>	</td>
     </tr>
          </table>      <table width="990" border="0" cellpadding="0" cellspacing="0" bgcolor="" style="border:#DDDDDD solid 0; font-size:14px; font-family:Arial, Helvetica, sans-serif; margin-bottom:20px">
        <tr>
          <td height="50" style="padding-right:15px; font-size:11px; color:#CCCCCC" align="right">
          Timestamp: </td>
      <td height="50" style="padding-left:0px; font-size:11px; color:#CCCCCC"><?php echo(getDateName($pdate)) ?> | <?php echo(substr($ptime,0,5)) ?></td>
      <td height="50" style="padding-left:50px; font-size:12px; color:#CCCCCC">	</td>
      <td height="50" colspan="2" align="right" style="line-height:150%; padding-right:20px; font-size:14px; font-weight:bold; font-family:Arial, Helvetica, sans-serif"><a href="PostFlea.php" class="one">+ Publish </a></td>
    </tr>
        <tr>
          <td width="123" height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Name</td>
      <td width="182" height="25" style="font-size:14px; font-family:Arial, Helvetica, sans-serif"> <?php echo($aname) ?></td>
      <td width="100" height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Available?</td>
      <td width="153" height="25" align="left" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
        
        <?php 
	if(trim($rstatus)=='Y'){
		echo("<font color=#336633>Yes</font>");
	}else 
		echo("<font color=#B92828>No</font>");
	?>		</td>
      <td width="180" height="25" align="right" style="padding-right:20px">
        <?php 
	if(trim($postuname)==trim($uname)) echo("<a href=EditArticle.php?aid=$aid><div align=center style='height:15; padding:2 5 2 5; background: url(img/master.jpg); display:; margin-top:5; margin-bottom:0; width:50; color:#000000; border:1px solid #999999; font-size:11px; cursor:pointer'>+ Edit</div></a>"); ?></td>
    </tr>
        <tr>
          <td height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Cost</td>
      <td height="25" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">$<?php echo($rate) ?> </td>
      <td height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Number</td>
      <td height="25" style="font-size:14px; font-family:Arial, Helvetica, sans-serif"><?php echo($num) ?>&nbsp;Piece(s)	</td>
      <td height="25" align="right" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; padding-right:20">
        <?php   echo("<a href=SendMessage.php?recipient=$postuname><div style='height:15; padding:2 5 2 5; background: url(img/master.jpg); display:; margin-top:5; margin-bottom:0; width:50; color:#000000; border:1px solid #999999;  font-size:11px; cursor:pointer' align='center'>Message</div></a>");
				  ?>      </td>
    </tr>
        <tr>
          <td height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Condition</td>
      <td height="25" style="font-size:14px; font-family:Arial, Helvetica, sans-serif"> <?php echo($condition) ?>&nbsp;</td>
      <td height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Contact</td>
      <td height="25" colspan="2" style="font-size:14px; font-family:Arial, Helvetica, sans-serif">
        <?php echo($postuname) ?>	 </td>
      </tr>
        <tr>
          <td height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Delivery</td>
      <td height="25" style="font-size:14px; font-family:Arial, Helvetica, sans-serif"> 
        <?php 
	if($delivery=='Y')
	echo("Yes"); else echo("No"); ?>	</td>
      <td height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Email</td>
      <td height="25" colspan="2" style="font-size:14px; font-family:Arial, Helvetica, sans-serif"><?php echo($email) ?></td>
    </tr>
        <tr style="border-bottom:solid 1px #CCCCCC;">
          <td height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Location</td>
      <td height="25" style="font-size:14px; font-family:Arial, Helvetica, sans-serif"><?php echo($city) ?>&nbsp;,&nbsp;<?php echo($state) ?></td>
      <td height="25" align="right" style="padding-right:15px; font-size:14px; font-family:Arial, Helvetica, sans-serif">Phone</td>
      <td height="25" colspan="2" style="font-size:14px; font-family:Arial, Helvetica, sans-serif"><?php echo($telephone) ?></td>
    </tr>
        <tr>
          <td align="right" valign="top" style="padding-right:15; border-top:#EEEEEE dotted 0; padding-top:10px;font-size:14px; font-family:Arial, Helvetica, sans-serif">&nbsp;</td>
      <td colspan="4" align="left" valign="top" bgcolor="" style="border-bottom:0 #EEEEEE dotted; padding:15 100 0 0; line-height:150%; font-size:14px; font-family:Arial, Helvetica, sans-serif;">
        <?php
	  echo($description);
	  ?>		  
        <?php 
					$target = "upload/a".$aid;
					if(is_dir($target)){
						echo("<div style='margin-top:20; margin-bottom:20'>");
						if(file_exists($target."/1_600.jpg")) echo("<img src=upload/a$aid/1_600.jpg width=450 style=border:0><br><br>");
				  		if(file_exists($target."/2_600.jpg")) echo("<img src=upload/a$aid/2_600.jpg width=450 style=border:0><br><br>");
						if(file_exists($target."/3_600.jpg")) echo("<img src=upload/a$aid/3_600.jpg width=450 style=border:0>");
						echo("</div>");
					}
	?>    </td>
      </tr>
        
        <tr>
          <td height="30" align="right" style="padding-right:10; border-top:#EEEEEE dotted 0; padding-top:30px" valign="top">&nbsp;</td>
      <td height="30"colspan="4" valign="top" style="border-top:#EEEEEE dotted 0; padding-top:10px"><table border="0" cellpadding="0" cellspacing="0" style="margin-top:10px">
        <tr>
          <td width="710" height="41" colspan="3">
            <?php 
		if(isset($_SESSION['$f_rst_msg'])){
			echo($_SESSION['$f_rst_msg']);
			unset($_SESSION['$f_rst_msg']);
		}
		?>
            <?php
$q1 = mysql_query("SELECT * FROM rockinus.article_comment WHERE aid='$aid' ORDER BY pdate DESC, ptime DESC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("");}
if($no_row > 0){ 
while($object = mysql_fetch_object($q1)){
	$cid = $object->cid;
	$aid = $object->aid;
	$sender = $object->sender;
	$recipient = $object->recipient;
	$descrip = $object->descrip;
	$ptime = $object->ptime;
	$pdate = $object->pdate; 
?>
            <div id="flashDeleteMemo<?php echo($cid) ?>" class="flashDeleteMemo<?php echo($cid) ?>" style="padding-left:0px"></div>
			  <div id="deleteMemoResult<?php echo($cid) ?>" class="deleteMemoResult<?php echo($cid) ?>" style="padding-left:0px"></div>
			  <div style="line-height:180%; margin-bottom:5; width: 550; border:0 #EEEEEE solid" id="articleMemo<?php echo($cid) ?>" class="articleMemo<?php echo($cid) ?>">
			    <table width="580" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style=" margin-top:0px; margin-bottom:0px; border:0 #EEEEEE solid">
			      <tr>
			        <td width="70" style="padding:5;" valign="top">
			          <script type="text/javascript" >
$(function() {
	$(".deleteComment_button<?php echo($cid) ?>").click(function() {
		var cid = <?php echo($cid) ?>;
		var dataString = 'cid='+cid; 

		if(cid=='')
		{
			alert("not getting memo id!");
		}
		else
		{
			$("#flashDeleteMemo<?php echo($cid) ?>").show();
 			$("#flashDeleteMemo<?php echo($cid) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle"> <span class="loading">Removing comment...</span>');
 
			$.ajax({
 				type: "POST",
				url: "memo_delete_article.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#flashDeleteMemo<?php echo($cid) ?>").hide();
					$("#articleMemo<?php echo($cid) ?>").hide();
					$("#deleteMemoResult<?php echo($cid) ?>").after(html);
					$("#deleteMemoResult<?php echo($cid) ?>").fadeIn("slow");
					document.getElementById('replycontent').value='';
					document.getElementById('replycontent').focus();
				}
			});
		} return false;
 	});
 });
</script>
			          <?php 
			$memo_uname = $sender.'60.jpg';
			//date('Y-m-d, H:i');
			$target_memo_uname = "upload/".$sender;
			echo("<table><tr>");
			if(is_dir($target_memo_uname)){
				echo("<td align='center' style='border:0px solid #EEEEEE; padding:0px' width='50px'><a href='RockerDetail.php?uid=$sender' class=one title='$sender'><img src=upload/$sender/$memo_uname?".time()." style='margin-right:0px;'></a></td>");
			}else 
				echo("<td align='center' style='border:0px solid #EEEEEE; padding:0px' width='50px'><a href='RockerDetail.php?uid=$sender' class=one title='$sender'><img src='img/NoUserIcon_fixed.jpg' width=70 height=70 style='margin-right:0px;'></a></td>");
			echo("</tr></table>");
			 ?>                  </td>
                    <td width="480" height="36" colspan="0" valign="top" style="padding-top:5px; line-height:150%; border-top:0px #EEEEEE solid; padding-left:5px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><?php
			echo(nl2br($descrip));
			echo("<br><font color=#CCCCCC style='font-size:11px'>".getDateName($pdate)." | ".$ptime." | </font>");
			if($sender==$uname)echo("<font color=#CCCCCC style='font-size:11px'>From </font><a href='RockerDetail.php?uid=$sender' class=one><font color=#999999 style='font-size:11px'>$sender</font></a> &nbsp;<span id='deleteComment_button$cid' class='deleteComment_button$cid' style='height:13;display:inline; padding:0 7 0 7; background-color:#F5F5F5; border:1px #EEEEEE solid; font-size:11px' onMouseOver=this.style.cursor='hand';><font color=$_SESSION[hcolor]>Delete </font></span>");else
			echo("<font color=#CCCCCC style='font-size:11px'>Click <a href='RockerDetail.php?uid=$sender' class=one><font color=#CCCCCC style='font-size:11px'>$sender</font></a> to reply</font>");
	?>                  </td>
                  </tr>
			      </table>
              </div>
            <?php }}?></td>
        </tr>
        </table>            
	  <div id="flashArticleMemo" class="flashArticleMemo" style="padding-left:0px"></div>
      <div id="displayArticleMemo" style="padding-left:0px"></div>
         <table width="800" border="0" cellpadding="0" cellspacing="0" style="border-top:#EEEEEE solid 1px; margin-bottom:20">
           <tr>
             <td width="46" height="86" align="left" valign="top" bgcolor="#F5F5F5" style="padding:10px; border-top:0px solid #999999"><?php echo($unameImg) ?></td>
              <td width="460" height="86" colspan="2" align="left" bgcolor="#F5F5F5" style="padding:10 10 10 0; border-top:0px solid #999999"><textarea name="replycontent" class="replycontent" id="replycontent" rows="6" style="width:700px; font-size:14px; font-family:Arial, Helvetica, sans-serif; border:1px #DDDDDD solid"></textarea></td>
              </tr>
           <tr>
             <td height="38" align="left" bgcolor="#F5F5F5" style="padding:10px; border-top:0px solid #999999">&nbsp;</td>
              <td height="38" colspan="2" align="left" bgcolor="#F5F5F5" style="padding:0 10 10 0; border-top:0px solid #999999">
                <input type="hidden" name="recipient" id="recipient" value="<?php echo($postuname) ?>" />            
                <input name="submit2" type="submit" class="commentArticle_button" value=" Submit " style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:0px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif" />
                <input type="hidden" name="aid" value="<?php echo($aid) ?>" />
                <input type="hidden" name="sender" value="<?php echo($uname) ?>" />
                <div id="show_recipient_name"></div>			  </td>
            </tr>
           </table>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript">
 $(function() {
 $(".commentArticle_button").click(function() {
var test = $("#replycontent").val();
var aid = <?php echo($aid) ?>;
var pdate = '<?php echo(date('Y-m-d')) ?>';
var ptime = '<?php echo(date("H:i:s", time())) ?>';
var sender = '<?php echo($uname) ?>';
var recipient = $("#recipient").val();
var dataString = 'content='+ test+'&aid='+aid+'&sender='+sender+'&recipient='+recipient+'&pdate='+pdate+'&ptime='+ptime; 
//alert(dataString);

if(test=='')
{
 alert("Please Enter Something ok?");
}
else
{
 $("#flashArticleMemo").show();
 $("#flashArticleMemo").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle"> <span class="loading">Posting Comment...</span>');
 
 $.ajax({
  type: "POST",
  url: "memo_article.php",
  data: dataString,
  cache: false,
  success: function(html){
  $("#displayArticleMemo").after(html);
  document.getElementById('replycontent').value='';
  document.getElementById('replycontent').focus();
  $("#flashArticleMemo").hide();
  }
 });
 } 
return false;
 });
 });
</script></td>
    </tr>
      </table></td>
    </tr>
  </table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
