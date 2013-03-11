<?php 
include 'dbconnect.php';
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];

$hobbyStr=NULL;
if(isset($_POST['hobbySubmit'])){
	$hobby = $_POST['hobby'];
	if($hobby[0]==NULL) $hobbyStr = NULL;
	else{
		for($i=0;$i<count($hobby);$i++){
			$hobbyStr .= $hobby[$i];
			if($i!= (count($hobby)-1))$hobbyStr .= ",";
//		$_SESSION['rst_msg'] = "<strong><font color=#336633>$hobby[0], $cnt_hobby</font></strong>";
		}
		$_SESSION['rst_friend_flag'] = "success";
	}
	$_SESSION['rst_msg'] = "<strong><font color=#336633>$hobbyStr</font></strong>";
	$upd = mysql_query("UPDATE rockinus.user_hobby_info SET hobby='$hobbyStr' WHERE uname='$uname'");
	if(!$upd) die(mysql_error());
	$_SESSION['rst_msg'] = "<img src=img/addsuccessIcon.jpg width=15>&nbsp;&nbsp;&nbsp;<strong><font color=#336633 style=''>Successful</font></strong>";
	$_SESSION['rst_flag'] = "success";
	header("location:EditHobbyInfoView.php");
	mysql_close($link);
}else{
	$q = mysql_query("SELECT * FROM rockinus.user_hobby_info where uname='$uname'");
	if(!$q) die(mysql_error());
	$no_row = mysql_num_rows($q);
	if($no_row == 0) die("No matches met your criteria.");
	$object = mysql_fetch_object($q);
	$hobbyStr = $object->hobby;
}
	
$wid = ProfileProgress($uname);

include 'mainHeader.php';
?><style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
<div align="center">
  <table width="1024" height="487" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="padding-top:0; margin-top:0;">
    <tr>
      <td width="300" height="487" align="left" valign="top" style=" line-height:150%; font-size:14px; padding-left:15px">
	  <?php include "ProfileMenu.php" ?>
	  </td>
      <td width="760" align="right" valign="top" style=" padding-top:25px; padding-bottom:15px">
	  <form action="EditHobbyInfo.php" method="post" name="profile">
        <table width="760" height="394" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top" align="right"><table width="740" height="564" border="0" cellpadding="0" cellspacing="0">
                
                <tr>
                  <td height="50" colspan="3" align="left"><table width="740" height="50" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="634" height="50" align="right" style="padding-right:10;"><font color="#336633"><?php echo($wid)?>%</font></td>
                      <td width="246" height="50"><div align="left" style="width:200; padding-top:0; padding-bottom:0; border:1 #336633 solid; background: #EEEEEE">
                          <table height="17" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td height="17" width="<?php echo(2*$wid)?>" bgcolor="#336699" align="left">&nbsp;</td>
                            </tr>
                          </table>
                      </div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td width="105" height="70" align="right" style="padding-right:10;  ; font-weight:bold; color:#666666"><img src="img/foot_steps_feet.png" width="22" /></td>
                  <td height="70" colspan="2" style="padding-left:10; font-size:20px">
				  <input name="uname" type="hidden" class="box" size="15" style=" background-color:#FFFFFF; border:0; font-weight:bold; font-size:16px; " value="<?php echo($uname); ?>" disabled="disabled" />What are you interested in?</td>
                </tr>
                <tr>
                  <td height="30">&nbsp;</td>
                  <td colspan="2" style="padding-top:10; padding-left:10" align="left" valign="top"><table width="550" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD; ">
					  <input type="checkbox" name="hobby[]" value="food" <?php if(contains("food",$hobbyStr))echo("checked"); ?> /></td>
                      <td width="160" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  "> Eating </td>
                      <td width="120" height="30" style="padding-left:10;  ">&nbsp;</td>
                      <td width="35" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD;  ">
					  <input type="checkbox" name="hobby[]" value="job" <?php if(contains("job",$hobbyStr))echo("checked"); ?> />
					  <td width="185" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  "> Jobs </td>
                    </tr>
                  </table>
                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="50" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD; ">
						<input type="checkbox" name="hobby[]" value="clothes" <?php if(contains("clothes",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="160" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  "> Clothes </td>
                        <td width="120" height="30" style="padding-left:10;  ">&nbsp;</td>
                        <td width="35" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD;  ">
						<input type="checkbox" name="hobby[]" value="travel" <?php if(contains("travel",$hobbyStr))echo("checked"); ?> />
						<td width="185" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  "> Travel </td>
                      </tr>
                    </table>
                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="50" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD; ">
						<input type="checkbox" name="hobby[]" value="shopping" <?php if(contains("shopping",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="160" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  "> Shopping </td>
                        <td width="120" height="30" style="padding-left:10;  ">&nbsp;</td>
                        <td width="35" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD;  ">
						<input type="checkbox" name="hobby[]" value="film" <?php if(contains("film",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  "> Watching Movie </td>
                      </tr>
                    </table>
                    <table width="550" height="30" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="50" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD; ">
						<input type="checkbox" name="hobby[]" value="car" <?php if(contains("car",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="160" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  "> Car </td>
                        <td width="120" height="30" style="padding-left:10;  ">&nbsp;</td>
                        <td width="35" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD;  ">
						<input type="checkbox" name="hobby[]" value="music" <?php if(contains("music",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  "> Music </td>
                      </tr>
                    </table>
                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="50" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD; ">
						<input type="checkbox" name="hobby[]" value="book" <?php if(contains("book",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="160" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  ">Reading</td>
                        <td width="120" height="30" style="padding-left:10;  ">&nbsp;</td>
                        <td width="35" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD;  ">
						<input type="checkbox" name="hobby[]" value="dance" <?php if(contains("dance",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  ">Dance</td>
                      </tr>
                    </table>
                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="50" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD; ">
						<input type="checkbox" name="hobby[]" value="major" <?php if(contains("major",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="160" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  "> My major </td>
                        <td width="120" height="30" style="padding-left:10;  ">&nbsp;</td>
                        <td width="35" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD;  ">
						<input type="checkbox" name="hobby[]" value="cricket" <?php if(contains("cricket",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  "> Cricket</td>
                      </tr>
                    </table>
                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="50" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD; ">
						<input type="checkbox" name="hobby[]" value="soccer" <?php if(contains("soccer",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="160" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  ">Soccer</td>
                        <td width="120" height="30" style="padding-left:10;  ">&nbsp;</td>
                        <td width="35" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD;  ">
						<input type="checkbox" name="hobby[]" value="basketball" <?php if(contains("basketball",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  ">Basketball</td>
                      </tr>
                    </table>
                    <table width="550" height="30" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="50" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD; ">
						<input type="checkbox" name="hobby[]" value="cycling" <?php if(contains("cycling",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="160" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  "> Cycling </td>
                        <td width="120" height="30" style="padding-left:10;  ">&nbsp;</td>
                        <td width="35" height="30" style="padding-left:0;  border-bottom:1px solid #DDDDDD;  ">
						<input type="checkbox" name="hobby[]" value="swimming" <?php if(contains("swimming",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5;  border-bottom:1px solid #DDDDDD;  "> Swimming </td>
                      </tr>
                    </table>                  </td>
                </tr>
                

                <tr>
                  <td height="30">&nbsp;</td>
                  <td width="170" height="30" align="left" style="padding-top:25; padding-left:10; padding-bottom:60">
				  <input name="hobbySubmit" type="submit" style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:1px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; " value=" Save " /></td>
                  <td width="465" height="30" align="left" style="padding-top:45; padding-left:10; padding-bottom:60">&nbsp;</td>
                </tr>
				<tr>
                  <td height="20" colspan="3">
				  <div style=" margin-bottom:50px; margin-top:2px" align="center">
			<?php 
			if(isset($_SESSION['rst_friend_flag']) && $_SESSION['rst_friend_flag']=="success"){
				for($k=0;$k<count($hobby);$k++){
					$q = mysql_query("SELECT * FROM rockinus.user_hobby_info WHERE hobby LIKE '%$hobby[$k]%' AND uname<>'$uname';");
					if(!$q) die(mysql_error());
					$no_row = mysql_num_rows($q);
					if($no_row>0){
						echo "<div align='left' style='width:700; margin-top:15; margin-bottom:15'><font style='font-size:16px; font-weight:normal; '>&nbsp;<img src=img/grayStar.jpg width=15 />&nbsp;&nbsp;Following student(s) also like $hobby[$k] :</div>";
						while($object = mysql_fetch_object($q)){					
							$loopname = $object->uname;
				?>
								  <script type="text/javascript">
$(function() {
	$(".addFriendHobbyDiv<?php echo($loopname) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($loopname) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#addFriendHobbyDiv<?php echo($loopname) ?>").hide();
		$("#flashAddFriendHobby<?php echo($loopname) ?>").show();
		$("#flashAddFriendHobby<?php echo($loopname) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_frequest.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashAddFriendHobby<?php echo($loopname) ?>").hide();
				$("#addFriendHobbyResult<?php echo($loopname) ?>").html(html);
				$("#addFriendHobbyResult<?php echo($loopname) ?>").show();
			}
 		});
 		return false;
 	});
 });
</script>
				<?php
						$rel_rstatus = "N";
						if($loopname==$uname)$rel_rstatus ="S";
						else{
							$q11 = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE (sender='$loopname' AND recipient='$uname') OR (recipient='$loopname' AND sender='$uname')");
							if(!$q11) die(mysql_error());
							$no_row_A = mysql_num_rows($q11);
							if($no_row_A>0)$rel_rstatus='A';
	
							$q21 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$loopname' AND recipient='$uname' AND rstatus='P'");
							if(!$q21) die(mysql_error());
							$no_row_P = mysql_num_rows($q21);
							if($no_row_P>0)$rel_rstatus='X';
	
							$q22 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uname' AND recipient='$loopname' AND rstatus='P'");
							if(!$q22) die(mysql_error());
							$no_row_X = mysql_num_rows($q22);
							if($no_row_X>0)$rel_rstatus='P';	
						}
						
							$loop_uname = $loopname.'_fixed70.jpg';
							$target_loop_uname = "upload/".$loopname;
							echo("<table width='700' style='margin-bottom:10px'><tr>");
				
							if(is_dir($target_loop_uname)){
							echo("<td align='left' style='border:1px solid #EEEEEE; padding:5px' width='50px'><a href='RockerDetail.php?uid=$loopname' target='_blank' class=one title='$loopname'><img src=upload/$loopname/$loop_uname?".time()." style='margin-right:0px;'></a></td>");
						}else 
							echo("<td align='left' style='border:1px solid #EEEEEE; padding:5px' width='50px'><a href='RockerDetail.php?uid=$loopname' target='_blank' class=one title='$loopname'><img src='img/NoUserIcon_fixed.jpg' width=70 height=70 style='margin-right:0px;'></a></td>");
						
						echo("<td style='padding-left:15px; padding-top:5; line-height:150%; font-family: Arial, Helvetica, sans-serif;' valign='top'><a href='RockerDetail.php?uid=$loopname' target='_blank' class=one><strong>$loopname</strong></a><br><br>");
						if($rel_rstatus=="S")echo("<div style=' ; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='EditUserInfo.php' class=one>+ Edit</a></div>&nbsp;");
						else if($rel_rstatus=="P")echo("<div style=' ; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'>Requested</div>");
						else if($rel_rstatus=="A")echo("<div style=' ; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='FriendConfirm.php?uid=$loopname&&pageName=EditUserInfo' class=one>Defriend</a></div>");
						else if($rel_rstatus=="X"){
							echo("<div style=' ; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='AcceptFriend.php?sender=$loopname' class=one>Accept</a></div>&nbsp;&nbsp;");
							echo("<div style=' ; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='DenyFriend.php?sender=$loopname&&pageName=EditUserInfo' class=one>Decline</a></div>");
							}else if($rel_rstatus=="N")echo("<div id='addFriendHobbyDiv$loopname' class='addFriendHobbyDiv$loopname' style=' ; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' onMouseOver=this.style.cursor='hand' align='center'>+ Friend</div>");
						?>
	<span id="flashAddFriendHobby<?php echo($loopname) ?>" class="flashAddFriendHobby<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span>
 	 <span id="addFriendHobbyResult<?php echo($loopname) ?>" class="addFriendHobbyResult<?php echo($loopname) ?>" style=' ; font-weight:normal; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:none' align='center'></span>&nbsp;
	 					<?php
	 					if($rel_rstatus!="S"){?><div style=" ; font-weight:normal; width:90; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333; padding-top:5; padding:3 5 3 5; display:inline" align="center"><a href="SendMessage.php?recipient=<?php echo($loopname) ?>" class='one'>Message</a>
	</div>
	<?php } 
	
						echo("</td></tr></table>");
						}
					}
				}		
				unset($_SESSION['rst_friend_flag']);
			}
			?>	
			</div>				  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
		</form>
	  </td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
