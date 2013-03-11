<?php 
include 'ValidCheck.php';
include("Allfuc.php");
include 'dbconnect.php';
$uname = $_SESSION['usrname'];
	
$q = mysql_query("SELECT * FROM rockinus.user_info where uname='$uname'");
if(!$q) die(mysql_error());
$object = mysql_fetch_object($q);
$fname = $object->fname;
$lname = $object->lname;
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;
$birthdate = $object->birthdate;
if($birthdate=="0000-00-00")$birthdate=NULL;
$fcountry = $object->fcountry;
	//if($fcountry =="empty")$fcountry="Select a country";
$fregion = $object->fregion;
if($fregion =="empty")$fregion="Hometown Unknown";                   

$gender_options = array("", ""); 
if($gender == "Male"){
	$gender_options[0] = " checked='checked'";
}else if($gender == "Female"){
	$gender_options[1] = " checked='checked'";
}

$sstatus_options = array("", ""); 
if($sstatus == "Student"){
	$sstatus_options[0] = " checked='checked'";
}else if($sstatus == "Employee"){
	$sstatus_options[1] = " checked='checked'";
}

$mstatus_options = array("", "", ""); 
if($mstatus == "Single" ){
	$mstatus_options[0] = "checked='checked'";
}else if($mstatus == "Married"){
	$mstatus_options[1] = "checked='checked'";
}else if($mstatus == "In a relationship"){
	$mstatus_options[2] = "checked='checked'";
}

$wid = ProfileProgress($uname);

include "mainHeader.php";
?>
<style type="text/css">
<!--
body,td,th {
	font-size: 13px;
}
-->
</style>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/ajax.jquery.min.js"></script>
<script>
function getXMLHTTP() { //fuction to return the xml http object
	var xmlhttp=false;	
	try{
		xmlhttp=new XMLHttpRequest();
	}
	catch(e)	{		
		try{			
			xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e1){
				xmlhttp=false;
			}
		}
	}
		 	
	return xmlhttp;
}
	
function getRegion(strURL)
{         
 var req = getXMLHTTP(); // fuction to get xmlhttp object 
 if (req)
 {
  	req.onreadystatechange = function()
 	{
  		if (req.readyState == 4) { //data is retrieved from server
   			if (req.status == 200) { // which reprents ok status                    
     			document.getElementById('regionDiv').innerHTML=req.responseText;
  			}
  			else
  			{ 
     			alert("There was a problem while using XMLHTTP:\n");
  			}
  		}            
  	}        
	req.open("GET", strURL, true); //open url using get method
	req.send(null);
 	}
}
</script>
<div align="center">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" style="padding-top:0; margin-top:0;" bgcolor="#FFFFFF">
    <tr>
      <td width="300" align="left" valign="top" style=" padding-left:15px">
	  <?php include "ProfileMenu.php" ?>
	  </td>
      <td width="760" align="right" valign="top" style="padding-top:50px">
		<table width="760" height="394" border="0" cellpadding="0" cellspacing="0" align="right">
          <tr>
            <td valign="top" align="right"><table width="740" height="550" border="0" cellpadding="0" cellspacing="0" style="border-left:#CCCCCC dotted 0;border-right:#CCCCCC dotted 0;border-bottom:#CCCCCC dotted 0;">
                <tr>
                  <td height="60" colspan="2" align="center" style="padding-right:10; padding-top:5px">&nbsp;</td>
                  <td width="62" height="40"><div align="right" style="padding-right:10"><font color="#336633"><?php echo($wid)?>%</font></div></td>
                  <td width="217" height="40"><div align="left" style="width:200; padding-top:0; padding-bottom:0; border:1 #336633 solid; background: #EEEEEE">
                    <table height="17" border="0" cellpadding="0" cellspacing="0" >
                      <tr>
                        <td height="17" width="<?php echo(2*$wid)?>" bgcolor="#336699" align="left">&nbsp;</td>
                      </tr>
                    </table>
                  </div></td>
                </tr>
                <tr>
                  <td width="178" height="30" align="right" style="padding-right:15px; font-family:Arial, Helvetica, sans-serif"><strong>User name </strong></td>
                  <td width="283" height="30">&nbsp;
                  <input name="uname" type="text" class="box" size="15" style=" background-color:#FFFFFF; border:0; font-weight:bold; " value="<?php echo($uname); ?>" disabled="disabled" /></td>
                  <td height="30" colspan="2">
				  <?php if(isset($_SESSION['rst_msg'])){
				  			echo($_SESSION['rst_msg']);
							unset($_SESSION['rst_msg']);
				  }?></td>
                </tr>
                <tr>
                  <td height="30" align="right" style="padding-right:15px; font-family:Arial, Helvetica, sans-serif"><strong>Full Name </strong></td>
                  <td height="30" style=" font-family:Arial, Helvetica, sans-serif">&nbsp;
                      <?php echo($fname); ?>.<?php echo($lname); ?>					  </td>
                  <td height="30" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" align="right" style="padding-right:15px; font-family:Arial, Helvetica, sans-serif">&nbsp;</td>
                  <td height="20" valign="top">&nbsp;
				  <font color="#999999" style="font-size:12px; font-family:Arial, Helvetica, sans-serif">(First Name . Last Name)</font></td>
                  <td height="20" colspan="2">&nbsp;</td>
                </tr>
				<tr>
                  <td height="30" align="right" style="padding-right:15px; font-family:Arial, Helvetica, sans-serif"><strong>Birthdate</strong></td>
                  <td height="30">&nbsp;
                      <?php echo(substr($birthdate,0,4)); ?>/<?php echo(substr($birthdate,5,2)); ?>/<?php echo(substr($birthdate,8,2)); ?>
					  &nbsp;<font color="#999999">(Year/Month/Day)</font>					  </td>
                  <td height="30" colspan="2"></td>
                </tr>
                <tr>
                  <td height="20" align="right" style="padding-right:15px; font-family:Arial, Helvetica, sans-serif">&nbsp;</td>
                  <td height="20" valign="top">&nbsp;
				  <font color="#999999" style="font-size:12px; font-family:Arial, Helvetica, sans-serif">(Birth year will not be shown to others)</font></td>
                  <td height="20" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td height="30" align="right" style="padding-right:15px; font-family:Arial, Helvetica, sans-serif"><strong>Gender </strong></td>
                  <td height="30" colspan="3" style="font-family:Arial, Helvetica, sans-serif; ">&nbsp;
                      <?php echo $gender; ?> </td>
                </tr>
                <tr>
                  <td height="30" align="right" style="padding-right:15px; font-family:Arial, Helvetica, sans-serif"><strong>Current Status  </strong></td>
                  <td height="30" colspan="3" style="font-family:Arial, Helvetica, sans-serif; ">&nbsp;
                      <?php echo $sstatus; ?> </td>
                </tr>
                <tr>
                  <td height="30" align="right" style="padding-right:15px; font-family:Arial, Helvetica, sans-serif"><strong>Maritial Status </strong></td>
                  <td height="30" colspan="3" style="font-family:Arial, Helvetica, sans-serif; ">&nbsp;
                      <?php echo $mstatus; ?></td>
                </tr>
                <tr>
                  <td height="30" align="right" style="padding-right:15px; font-family:Arial, Helvetica, sans-serif"><strong>  From </strong></td>
                  <td height="30" colspan="3" style="font-family:Arial, Helvetica, sans-serif; ">&nbsp;
           			<?php echo $fregion; ?>, 
					<?php echo $fcountry; ?>					</td>
                </tr>
                <tr>
                  <td height="15">&nbsp;</td>
                  <td height="15" colspan="3" valign="top" style=" padding-left:0">&nbsp;</td>
                </tr>
                <tr>
                  <td height="47">&nbsp;</td>
                  <td style="font-size:12px; font-family:Arial, Helvetica, sans-serif">&nbsp; <a href="EditUserInfo.php" class="one">[+ Edit]</a></td>
                  <td align="right">
                  <?php 
				  	//session_start();
				  	if(isset($_SESSION['rst_flag']) && $_SESSION['rst_flag']=="success"){
				  		echo("<div style='padding-left:10'><input type='button' class='profile_btn' style='background:$_SESSION[hcolor]' value=' NEXT ' ONCLICK=window.location.href='EditEduInfo.php' /></div>");
					  	unset($_SESSION['rst_flag']);
					  }
					?>				  </td>
                  <td>&nbsp;				  </td>
                </tr>
                <tr>
                  <td height="39" colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td height="40" colspan="4">
				  <div style=" margin-bottom:30px; margin-top:2px; width:740" align="center">
			<?php 
			if(isset($_SESSION['rst_friend_flag']) && $_SESSION['rst_friend_flag']=="successs"){
				$q = mysql_query("SELECT * FROM rockinus.user_info WHERE fcountry = '$fcountry' AND fregion = '$fregion' AND uname<>'$uname';");
				if(!$q) die(mysql_error());
				$no_row = mysql_num_rows($q);
				if($no_row>0){
					echo "<div align='left' style='width:700; padding-left:5; padding-top:10; padding-bottom:10; margin-bottom:15; background:#F5F5F5; border-top:1px #CCCCCC solid; height:20'><font style=' font-weight:normal; font-family: Arial, Helvetica, sans-serif;'>&nbsp;<img src=img/grayStar_66CCFF.jpg width=13 />&nbsp;&nbsp;&nbsp;Following student(s) from the same hometown as you :</div>";
					while($object = mysql_fetch_object($q)){					
						$loopname = $object->uname;
						$loopfname = $object->fname;
						$looplname = $object->lname;
				?>
								  <script type="text/javascript">
$(function() {
	$(".addFriendHometownDiv<?php echo($loopname) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($loopname) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#addFriendHometownDiv<?php echo($loopname) ?>").hide();
		$("#flashAddFriendHometown<?php echo($loopname) ?>").show();
		$("#flashAddFriendHometown<?php echo($loopname) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_frequest.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashAddFriendHometown<?php echo($loopname) ?>").hide();
				$("#addFriendHometownResult<?php echo($loopname) ?>").html(html);
				$("#addFriendHometownResult<?php echo($loopname) ?>").show();
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
						if($rel_rstatus=="S")echo("<div style=' font-family:Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='EditUserInfo.php' class=one>+ Edit</a></div>&nbsp;");
						else if($rel_rstatus=="P")echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; color:#000000; display:inline' align='center'>Requested</div>");
						else if($rel_rstatus=="A")echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='FriendConfirm.php?uid=$loopname&&pageName=EditUserInfo' class=one>Defriend</a></div>");
						else if($rel_rstatus=="X"){
							echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' class=one>Accept</a></div>&nbsp;&nbsp;");
							echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='DenyFriend.php?sender=$loopname&&pageName=EditUserInfo' class=one>Decline</a></div>");
							}else if($rel_rstatus=="N")echo("<div id='addFriendHometownDiv$loopname' class='addFriendHometownDiv$loopname' style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' onMouseOver=this.style.cursor='hand' align='center'>+ Friend</div>");
						?>
	<span id="flashAddFriendHometown<?php echo($loopname) ?>" class="flashAddFriendHometown<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span>
 	 <span id="addFriendHometownResult<?php echo($loopname) ?>" class="addFriendHometownResult<?php echo($loopname) ?>" style=' font-family:Arial, Helvetica, sans-serif; font-weight:normal; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:none' align='center'></span>&nbsp;
	 					<?php
	 					if($rel_rstatus!="S"){?><div style="height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline" align="center"><a href="SendMessage.php?recipient=<?php echo($loopname) ?>" class='one'>Message</a>
	</div>
	<?php } 
	
						echo("</td></tr></table>");
					}
				}		
				unset($_SESSION['rst_friend_flag']);
		}
	?>	
	</div>
			
			<div style=" margin-bottom:50px; margin-top:0px; width:740" align="center">
			<?php 
			if(isset($_SESSION['rst_emotionGender_flag']) && $_SESSION['rst_emotionGender_flag']=="successs"){
				if($gender=='F') $gender_here = 'Male'; else $gender_here = 'Female';
				
				$q = mysql_query("SELECT * FROM rockinus.user_info WHERE gender = '$gender_here' AND mstatus = '$mstatus' AND uname<>'$uname';");
				if(!$q) die(mysql_error());
				$no_row = mysql_num_rows($q);
				if($no_row>0){
					echo "<div align='left' style='width:700; padding-left:5; padding-top:10; padding-bottom:10; margin-bottom:15; background:#F5F5F5; border-top:1px #CCCCCC solid; height:20'><font style=' font-weight:normal; font-family: Arial, Helvetica, sans-serif;'>&nbsp;<img src=img/grayStar_66CCFF.jpg width=13 />&nbsp;&nbsp;&nbsp;Following student(s) are also $mstatus :</div>";
					while($object = mysql_fetch_object($q)){					
						$loopname = $object->uname;
						$loopfname = $object->fname;
						$looplname = $object->lname;
				?>
				<script type="text/javascript">
$(function() {
	$(".addFriendRelDiv<?php echo($loopname) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($loopname) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#addFriendRelDiv<?php echo($loopname) ?>").hide();
		$("#flashAddFriendRel<?php echo($loopname) ?>").show();
		$("#flashAddFriendRel<?php echo($loopname) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_frequest.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashAddFriendRel<?php echo($loopname) ?>").hide();
				$("#addFriendRelResult<?php echo($loopname) ?>").html(html);
				$("#addFriendRelResult<?php echo($loopname) ?>").show();
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
						if($rel_rstatus=="S")echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='EditUserInfo.php' class=one>+ Edit</a></div>&nbsp;"); 
						else if($rel_rstatus=="P")echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'>Requested</div>");
						else if($rel_rstatus=="A")echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='FriendConfirm.php?uid=$loopname&&pageName=EditUserInfo' class=one>Defriend</a></div>");
						else if($rel_rstatus=="X"){
							echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='AcceptFriend.php?sender=$loopname'>Accept</a></div>&nbsp;&nbsp;");
							echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='DenyFriend.php?sender=$loopname&&pageName=EditUserInfo'>Decline</a></div>");
							}else if($rel_rstatus=="N")echo("<div id='addFriendRelDiv$loopname' class='addFriendRelDiv$loopname' style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'>+ Friend</div>");
						?>
	<span id="flashAddFriendRel<?php echo($loopname) ?>" class="flashAddFriendHometown<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span>
 	 <span id="addFriendRelResult<?php echo($loopname) ?>" class="addFriendHometownResult<?php echo($loopname) ?>" style=' font-family:Arial, Helvetica, sans-serif; font-weight:normal; width:90; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:none' align='center'></span>&nbsp;
	 					<?php
	 					if($rel_rstatus!="S"){?><div style="height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline" align="center"><a href="SendMessage.php?recipient=<?php echo($loopname) ?>" class='one'>Message</a>
					</div>
					<?php } 
						echo("</td></tr></table>");
					}
				}		
				unset($_SESSION['rst_emotionGender_flag']);
			}
			?>	
			</div>				  </td>
                </tr>
              </table>
			
			</td>
          </tr>
        </table>

	  </td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
