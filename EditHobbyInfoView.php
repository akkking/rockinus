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
	$_SESSION['rst_msg'] = "<img src=img/addsuccessIcon.jpg width=20px>&nbsp;&nbsp;&nbsp;<strong><font color=#336633 size=3>Successful</font></strong>";
	$_SESSION['rst_flag'] = "success";
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
?><style type="text/css">
<!--
body,td,th {
	font-size: 13px;
}
-->
</style>
<div align="center">
  <table width="1024" height="487" border="0" cellpadding="0" cellspacing="0" style="padding-top:0; margin-top:0;" bgcolor="#FFFFFF">
    <tr>
      <td width="300" height="487" align="left" valign="top" style=" border-right:1px dashed #DDDDDD">
	  <?php include("leftHomeMenu.php"); ?>
	  </td>
      <td width="760" align="right" valign="top" style="">
	  <?php include("HeaderEN.php"); ?>
	  <form action="EditHobbyInfo.php" method="post" name="profile">
        <table width="760" height="394" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top" align="right"><table width="740" height="28" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="140" height="35" background="img/master.png" style="border: #CCCCCC solid 0; border-bottom:1px #999999 solid;"><div align="center"><a href="EditUserInfo.php" class="one">Profile</a></div></td>
                <td width="140" background="img/master.png" style="border: #CCCCCC solid 0; border-bottom:1px #999999 solid;"><div align="center"><a href="EditEduInfo.php" class="one">Education</a></div></td>
                <td width="140" background="img/master.png" style="border: #CCCCCC solid 0; border-bottom:1px #999999 solid;"><div align="center"><a href="EditContactInfo.php" class="one">Contact</a></div></td>
                <td width="140" style="border: #999999 solid 1px; border-bottom:0;"><div align="center"><strong>Interests</strong></div></td>
                <td width="140" background="img/master.png" style="border: #CCCCCC solid 0; border-bottom:1px #999999 solid;"><div align="center"><a href="EditHeadIcon.php" class="one">Head Icon</a> </div></td>
                <td width="140" background="img/master.png" style="border: #CCCCCC solid 0; border-bottom:1px #999999 solid;"><div align="center"><a href="EditPassword.php" class="one">Password</a> </div></td>
              </tr>
            </table>
            <table width="740" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="634" height="60" align="right" style="padding-right:10;"><font color="#336633"><?php echo($wid)?>%</font></td>
                  <td width="246"><div align="left" style="width:200; padding-top:0; padding-bottom:0; border:1 #336633 solid; background: #EEEEEE">
                    <table height="17" border="0" cellpadding="0" cellspacing="0" >
                      <tr>
                        <td height="17" width="<?php echo(2*$wid)?>" bgcolor="#336699" align="left">&nbsp;</td>
                      </tr>
                    </table>
                  </div></td>
                </tr>
              </table>
              <table width="740" height="160" border="0" cellpadding="0" cellspacing="0">
                
                <tr>
                  <td width="135" height="40" align="right" style="padding-right:5; font-size:13px; font-family:Arial, Helvetica, sans-serif">
				  <strong>User name: </strong></td>
                  <td width="208" style="padding-left:10">
				  <input name="uname" type="text" class="box" size="15" style=" background-color:#FFFFFF; border:0; font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif" value="<?php echo($uname); ?>" disabled="disabled" /></td>
                  <td width="397" style="padding-left:10">
                    <?php if(isset($_SESSION['rst_msg'])){
				  			echo($_SESSION['rst_msg']);
							unset($_SESSION['rst_msg']);
				  }?>
                  </td>
                </tr>
                <tr>
                  <td height="30">&nbsp;</td>
                  <td colspan="2" style="padding-top:20; padding-left:10" align="left" valign="top"><table width="550" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD; font-family:Arial, Helvetica, sans-serif">
					  <input type="checkbox" name="hobby[]" value="food" <?php if(contains("food",$hobbyStr))echo("checked"); ?> /></td>
                      <td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif"> Eating </td>
                      <td width="80" height="30" style="padding-left:10; font-size:13px; font-family:Arial, Helvetica, sans-serif">&nbsp;</td>
                      <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif">
					  <input type="checkbox" name="hobby[]" value="job" <?php if(contains("job",$hobbyStr))echo("checked"); ?> />
					  <td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif"> Jobs </td>
                    </tr>
                  </table>
                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD; font-family:Arial, Helvetica, sans-serif">
						<input type="checkbox" name="hobby[]" value="clothes" <?php if(contains("clothes",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif"> Clothes </td>
                        <td width="80" height="30" style="padding-left:10; font-size:13px; font-family:Arial, Helvetica, sans-serif">&nbsp;</td>
                        <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif">
						<input type="checkbox" name="hobby[]" value="travel" <?php if(contains("travel",$hobbyStr))echo("checked"); ?> />
						<td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif"> Travel </td>
                      </tr>
                    </table>
                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD; font-family:Arial, Helvetica, sans-serif">
						<input type="checkbox" name="hobby[]" value="shopping" <?php if(contains("shopping",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif"> Shopping </td>
                        <td width="80" height="30" style="padding-left:10; font-size:13px; font-family:Arial, Helvetica, sans-serif">&nbsp;</td>
                        <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif">
						<input type="checkbox" name="hobby[]" value="film" <?php if(contains("film",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif"> Watching Movie </td>
                      </tr>
                    </table>
                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD; font-family:Arial, Helvetica, sans-serif">
						<input type="checkbox" name="hobby[]" value="car" <?php if(contains("car",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif"> Car </td>
                        <td width="80" height="30" style="padding-left:10; font-size:13px; font-family:Arial, Helvetica, sans-serif">&nbsp;</td>
                        <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif">
						<input type="checkbox" name="hobby[]" value="music" <?php if(contains("music",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif"> Music </td>
                      </tr>
                    </table>
                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD; font-family:Arial, Helvetica, sans-serif">
						<input type="checkbox" name="hobby[]" value="book" <?php if(contains("book",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif">Reading</td>
                        <td width="80" height="30" style="padding-left:10; font-size:13px; font-family:Arial, Helvetica, sans-serif">&nbsp;</td>
                        <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif">
						<input type="checkbox" name="hobby[]" value="dance" <?php if(contains("dance",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif">Dance</td>
                      </tr>
                    </table>
                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD; font-family:Arial, Helvetica, sans-serif">
						<input type="checkbox" name="hobby[]" value="major" <?php if(contains("major",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif"> My major </td>
                        <td width="80" height="30" style="padding-left:10; font-size:13px; font-family:Arial, Helvetica, sans-serif">&nbsp;</td>
                        <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif">
						<input type="checkbox" name="hobby[]" value="cricket" <?php if(contains("cricket",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif"> Cricket</td>
                      </tr>
                    </table>
                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD; font-family:Arial, Helvetica, sans-serif">
						<input type="checkbox" name="hobby[]" value="soccer" <?php if(contains("soccer",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif">Soccer</td>
                        <td width="80" height="30" style="padding-left:10; font-size:13px; font-family:Arial, Helvetica, sans-serif">&nbsp;</td>
                        <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif">
						<input type="checkbox" name="hobby[]" value="basketball" <?php if(contains("basketball",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif">Basketball</td>
                      </tr>
                    </table>
                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD; font-family:Arial, Helvetica, sans-serif">
						<input type="checkbox" name="hobby[]" value="cycling" <?php if(contains("cycling",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif"> Cycling </td>
                        <td width="80" height="30" style="padding-left:10; font-size:13px; font-family:Arial, Helvetica, sans-serif">&nbsp;</td>
                        <td width="50" height="30" style="padding-left:0; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif">
						<input type="checkbox" name="hobby[]" value="swimming" <?php if(contains("swimming",$hobbyStr))echo("checked"); ?> /></td>
                        <td width="185" height="30" align="right" style="padding-right:5; font-size:13px; border-bottom:1px solid #DDDDDD;  font-family:Arial, Helvetica, sans-serif"> Swimming </td>
                      </tr>
                    </table>                  </td>
                </tr>
                

                <tr>
                  <td height="50">&nbsp;</td>
                  <td height="50" align="left" style="padding-top:30; padding-left:10; padding-bottom:50; font-size:12px; font-family: Arial, Helvetica, sans-serif">
				  [<a href="EditHobbyInfo.php" class="one">+Edit</a>]
                 </td>
                  <td height="50" align="right" style="padding-top:45; padding-right:60; padding-bottom:60">
				  				   <?php 
				  	if(isset($_SESSION['rst_flag']) && $_SESSION['rst_flag']=="success"){
				  		echo("<div style='padding-left:10; display:inline'><input type='button' class='profile_btn' style='background:$_SESSION[hcolor]' value=' NEXT ' ONCLICK=window.location.href='EditHeadIcon.php' /></div>");
					  	unset($_SESSION['rst_flag']);
					  }
					?>
				  </td>
                </tr>
				<tr>
                  <td height="40" colspan="3">
				  <div style=" margin-bottom:50px; margin-top:2px" align="center">
			<?php 
			if(isset($_SESSION['rst_friend_flag']) && $_SESSION['rst_friend_flag']=="success"){
				for($k=0;$k<count($hobby);$k++){
					$q = mysql_query("SELECT * FROM rockinus.user_hobby_info WHERE hobby LIKE '%$hobby[$k]%' AND uname<>'$uname';");
					if(!$q) die(mysql_error());
					$no_row = mysql_num_rows($q);
					if($no_row>0){
						echo "<div align='left' style='width:700; padding-left:5; padding-top:10; padding-bottom:10; margin-bottom:15; background:#F5F5F5; border-top:1px #CCCCCC solid; height:20'><font style='font-size:13px; font-weight:normal; font-family: Arial, Helvetica, sans-serif;'>&nbsp;<img src=img/grayStar_66CCFF.jpg width=13 />&nbsp;&nbsp;&nbsp;Following student(s) also like $hobby[$k] :</div>";
						while($object = mysql_fetch_object($q)){					
							$loopname = $object->uname;
							$loopfname = $object->fname;
							$looplname = $object->lname;
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
						
							$loop_uname = $loopname.'100.jpg';
							$target_loop_uname = "upload/".$loopname;
							echo("<table width='700' style='margin-bottom:10px'><tr>");
				
						if(is_dir($target_loop_uname)){
							echo("<td align='left' style='border:0px solid #EEEEEE; ' width='60' height='60' background='upload/$loopname/$loop_uname?".time()."'></td>");
						}else 
							echo("<td align='left' style='border:0px solid #EEEEEE; ' width='60px'><a href='RockerDetail.php?uid=$loopname' class=one title='$loopname'><img src='img/NoUserIcon_fixed.jpg' width=60 height=60 style='margin-right:0px;'></a></td>");
						
						echo("<td style='padding-left:15px; padding-top:5; line-height:150%; font-family: Arial, Helvetica, sans-serif;' valign='top'><a href='RockerDetail.php?uid=$loopname' target='_blank' class=one><strong>$loopfname $looplname</strong></a><br><br>");
						if($rel_rstatus=="S")echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='EditUserInfo.php' class=one>+ Edit</a></div>&nbsp;");
						else if($rel_rstatus=="P")echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'>Requested</div>");
						else if($rel_rstatus=="A")echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='FriendConfirm.php?uid=$loopname&&pageName=EditUserInfo' class=one>Defriend</a></div>");
						else if($rel_rstatus=="X"){
							echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='AcceptFriend.php?sender=$loopname' class=one>Accept</a></div>&nbsp;&nbsp;");
							echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='DenyFriend.php?sender=$loopname&&pageName=EditUserInfo' class=one>Decline</a></div>");
							}else if($rel_rstatus=="N")echo("<div id='addFriendHobbyDiv$loopname' class='addFriendHobbyDiv$loopname' style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'>+ Friend</div>");
						?>
	<span id="flashAddFriendHobby<?php echo($loopname) ?>" class="flashAddFriendHobby<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span>
 	 <span id="addFriendHobbyResult<?php echo($loopname) ?>" class="addFriendHobbyResult<?php echo($loopname) ?>" style='font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:none' align='center'></span>&nbsp;
	 					<?php
	 					if($rel_rstatus!="S"){?><div style="height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline" align="center"><a href="SendMessage.php?recipient=<?php echo($loopname) ?>" class='one'>Message</a>
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
