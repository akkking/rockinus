<?php 
include 'dbconnect.php';
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
	
$q = mysql_query("SELECT * FROM rockinus.user_contact_info where uname='$uname'");
if(!$q) die(mysql_error());
$object = mysql_fetch_object($q);
$ccity = $object->ccity;
$cstate = $object->cstate;
$email = $object->email;
$phone = $object->phone;
$address = $object->address;
$address1 = NULL;
$address2 = NULL;
if($cstate=='ZZ'){
	$ccity='Other City';
	$cstate='Other State';
}

if(strlen(trim($phone))==0) $phone = "<font color='#333333'>Blank</font>";
//$q_major = mysql_query("SELECT * FROM rockinus.major_info WHERE mid='$cmajor'");
//if(!$q_major) die(mysql_error());
//$obj_major = mysql_fetch_object($q_major);
//$cmajor = trim($obj_major->major_name);

if ( strlen(trim($address)) > 0 && strlen(trim($address)) <40 ){
	$address1 = $address;
	$address2 = NULL;
}else if( strlen($address) > 40 ){
	$address1 = substr( $address, 0, 40 );
	$address2 = substr( $address, 40, strlen($address)-40 );
}else
$address1 = "<font color='#333333'>Blank</font>";
                      
$cs_options = array("", "", "", ""); 
if($cstate == "empty"){
	$cs_options[0] = "selected='selected'";
}elseif($cstate == "NY"){
	$cs_options[1] = "selected='selected'";
}

$wid = ProfileProgress($uname);
include "mainHeader.php";
?>
<style type="text/css">
<!--
.STYLE7 {color: #CC3300}
body,td,th {
	font-size: 14px;
}
-->
</style>

<div align="center">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" style="padding-top:0; margin-top:0;" bgcolor="#FFFFFF">
    <tr>
      <td width="300" align="left" valign="top" style="padding-left:15px">
	  <?php include "ProfileMenu.php" ?>
	  </td>
      <td width="760" align="left" valign="top" style="padding-top:50px">
	  <form action="EditContactInfo.php" method="post" name="profile">
	    <table width="760" height="394" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="760" valign="top" align="right"><table width="740" height="380" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="60" colspan="2" align="center" style="padding-right:10; padding-top:5px">&nbsp;</td>
                      <td height="45" align="right" style="padding-right:10"><font color="#336633"><?php echo($wid)?>%</font></td>
                      <td height="45"><div align="left" style="width:200; padding-top:0; padding-bottom:0; border:1 #336633 solid; background: #EEEEEE">
                        <table height="17" border="0" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td height="17" width="<?php echo(2*$wid)?>" bgcolor="#336699" align="left">&nbsp;</td>
                          </tr>
                        </table>
                      </div></td>
                    </tr>
                    <tr>
                      <td height="15" align="right" style="padding-right:15px; ">&nbsp;</td>
                      <td height="15">&nbsp;</td>
                      <td height="15" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="199" height="30" align="right" style="padding-right:15px; "><strong>User name: </strong></td>
                      <td width="240" height="30">&nbsp;
                      <input name="uname" type="text" class="box" size="15" value="<?php echo($uname); ?>" style=" background-color:#FFFFFF; border:0; font-weight:bold;  " disabled="disabled" /></td>
                      <td height="30" colspan="2"><?php if(isset($_SESSION['rst_msg'])){
				  			echo($_SESSION['rst_msg']);
							unset($_SESSION['rst_msg']);
				  }?> </td>
                    </tr>
                    <tr>
                      <td height="30" align="right" style="padding-right:15px; "><strong>Current Location </strong></td>
                      <td height="30" style=" ">&nbsp; <?php echo($ccity)?>, <?php echo($cstate)?></td>
                      <td height="30" colspan="2">                                             </td>
                    </tr>
                    <tr>
                      <td height="30" align="right" style="padding-right:15px; "><strong>Email Address</strong></td>
                      <td height="30" colspan="3" style=" ">&nbsp;
                      <?php echo($email); ?></td>
                    </tr>
                    <tr>
                      <td height="30" align="right" style="padding-right:15px; "><strong>Phone | Mobile</strong></td>
                      <td height="30" colspan="3">&nbsp;
                      <?php echo($phone); ?></td>
                    </tr>
                    <tr>
                      <td height="30" align="right" style="padding-right:15px; "><strong>Residential Address</strong></td>
                      <td height="30" colspan="3" style=" ">&nbsp; <?php echo("$address1<br>$address2") ?></td>
                    </tr>
                    <tr>
                      <td height="50">&nbsp;</td>
                      <td height="50" style="padding-top:30; font-size:12px; ">
					  &nbsp; <a href="EditContactInfo.php" class="one">[+ Edit]</a></td>
                      <td width="60" height="50" align="right" style="padding-top:40;">
                          <?php 
				  	if(isset($_SESSION['rst_flag']) && $_SESSION['rst_flag']=="success"){
				  		echo("<div style='padding-left:10'><input type='button' class='profile_btn' style='background:$_SESSION[hcolor]' value=' Next ' ONCLICK=window.location.href='EditHobbyInfo.php' /></div>");
					  	unset($_SESSION['rst_flag']);
					  }
					?>                      </td>
                      <td width="241" height="50" style="padding-top:40;"></td>
                    </tr>
                    <tr>
                      <td height="50">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
              </table>
            </td>
          </tr>
        </table>
	  </form>
<table width="740" border="0" cellspacing="0" cellpadding="0" align="right">
  <tr>
    <td align="right"><div style=" margin-bottom:50px; margin-top:2px" align="center">
      <?php 
			if(isset($_SESSION['rst_friend_flag']) && $_SESSION['rst_friend_flag']=="successss"){
				$q = mysql_query("SELECT * FROM rockinus.user_contact_info a JOIN rockinus.user_info b ON a.cstate = '$cstate' AND a.ccity = '$ccity' AND a.uname<>'$uname' AND a.uname=b.uname;");
//echo($sql);
				if(!$q) die(mysql_error());
				$no_row = mysql_num_rows($q);
				if($no_row>0){
					echo "<div align='left' style='width:700; padding-left:5; padding-top:10; padding-bottom:10; margin-bottom:15; background:#F5F5F5; border-top:1px #CCCCCC solid; height:20'><font style=' font-weight:normal; font-family: Arial, Helvetica, sans-serif;'>&nbsp;<img src=img/grayStar_66CCFF.jpg width=13 />&nbsp;&nbsp;&nbsp;Following student(s) also live in $ccity :</div>";
					while($object = mysql_fetch_object($q)){					
						$loopname = $object->uname;
						$loopfname = $object->fname;
						$looplname = $object->lname;
						?>
      <script type="text/javascript">
$(function() {
	$(".addFriendMajorDiv<?php echo($loopname) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($loopname) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#addFriendMajorDiv<?php echo($loopname) ?>").hide();
		$("#flashAddFriendMajor<?php echo($loopname) ?>").show();
		$("#flashAddFriendMajor<?php echo($loopname) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_frequest.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashAddFriendMajor<?php echo($loopname) ?>").hide();
				$("#addFriendMajorResult<?php echo($loopname) ?>").html(html);
				$("#addFriendMajorResult<?php echo($loopname) ?>").show();
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
						//date('Y-m-d, H:i');
						$target_loop_uname = "upload/".$loopname;
						echo("<table width='700' style='margin-bottom:10px'><tr>");
						
						if(is_dir($target_loop_uname)){
							echo("<td align='left' style='border:0px solid #EEEEEE; ' width='60' height='60' background='upload/$loopname/$loop_uname?".time()."'></td>");
						}else 
							echo("<td align='left' style='border:0px solid #EEEEEE; ' width='60px'><a href='RockerDetail.php?uid=$loopname' class=one title='$loopname'><img src='img/NoUserIcon_fixed.jpg' width=60 height=60 style='margin-right:0px;'></a></td>");
						
						echo("<td style='padding-left:15px; padding-top:5; line-height:150%; font-family: Arial, Helvetica, sans-serif;' valign='top'><a href='RockerDetail.php?uid=$loopname' class=one><strong>$loopfname $looplname</strong></a><br><br>");
						if($rel_rstatus=="S")echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='EditEduInfo.php' class=one>+ Edit</a></div>&nbsp;");
						else if($rel_rstatus=="P")echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'>Requested</div>");
						else if($rel_rstatus=="A")echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='FriendConfirm.php?uid=$loopname&&pageName=EditEduInfo' class=one>Defriend</a></div>");
						else if($rel_rstatus=="X"){
							echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='AcceptFriend.php?sender=$loopname' class=one>Accept</a></div>&nbsp;&nbsp;");
							echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='DenyFriend.php?sender=$loopname&&pageName=EditEduInfo' class=one>Decline</a></div>");
							}else if($rel_rstatus=="N")echo("<div id='addFriendMajorDiv$loopname' class='addFriendMajorDiv$loopname' style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'>+ Friend</div>");
						?>
      <span id="flashAddFriendMajor<?php echo($loopname) ?>" class="flashAddFriendMajor<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span> <span id="addFriendMajorResult<?php echo($loopname) ?>" class="addFriendMajorResult<?php echo($loopname) ?>" style=' ; font-weight:normal; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:none' align='center'></span>&nbsp;
      <?php
	 					if($rel_rstatus!="S"){?>
      <div style="height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline" align="center"><a href="SendMessage.php?recipient=<?php echo($loopname) ?>" class='one'>Message</a> </div>
      <?php } 
	
						echo("</td></tr></table>");
					}
				}		
				unset($_SESSION['rst_friend_flag']);
			}
			?>
    </div></td>
    </tr>
</table>

	  </td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
