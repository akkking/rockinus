<?php 
include 'dbconnect.php';
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];

$cdegree_options = array("", "", "", "",""); 

$q = mysql_query("SELECT * FROM rockinus.user_edu_info where uname='$uname'");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$sid = $object->cschool;
$cdegree = $object->cdegree;
$cmajor = $object->cmajor;
$sterm = $object->sterm;
$eterm = $object->eterm;
if($sterm!="empty")$sterm = substr($sterm, 0, 4)." ".substr($sterm,4,strlen($sterm)-4);
if($eterm!="empty")$eterm = substr($eterm, 0, 4)." ".substr($eterm,4,strlen($eterm)-4);

$q_school = mysql_query("SELECT * FROM rockinus.school_info WHERE sid='$sid'");
if(!$q_school) die(mysql_error());
$obj_school = mysql_fetch_object($q_school);
$cschool = trim($obj_school->school_name);

$q_major = mysql_query("SELECT * FROM rockinus.major_info WHERE mid='$cmajor'");
if(!$q_major) die(mysql_error());
$obj_major = mysql_fetch_object($q_major);
$major_name = trim($obj_major->major_name);
						                      
if($cdegree == "Undegraduate"){
	$cdegree_options[0] = "checked='checked'";
}else if($cdegree == "Graduate" ){
	$cdegree_options[1] = "checked='checked'";
}else if($cdegree == "PHD"){
	$cdegree_options[2] = "checked='checked'";
}else if($cdegree == "Certificate"){
	$cdegree_options[3] = "checked='checked'";
}

$wid = ProfileProgress($uname);

include "mainHeader.php";
?><style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style>
<div align="center">
  <table width="1018" height="479" border="0" cellpadding="0" cellspacing="0" style="padding-top:0; margin-top:0;" bgcolor="#FFFFFF">
    <tr>
      <td width="300" height="479" align="left" valign="top" style=" padding-left:15px">
	  <?php include "ProfileMenu.php" ?>
	  </td>
      <td width="760" align="left" valign="top" style="padding-top:50px">
	    <table width="760" height="394" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top" align="right"><table width="740" height="410" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="60" colspan="2" align="right" style="padding-right:10"><font color="#336633"><?php echo($wid)?>%</font></td>
                  <td height="60" colspan="2"><div align="left" style="width:200; padding-top:0; padding-bottom:0; border:1 #336633 solid; background: #EEEEEE">
                    <table height="17" border="0" cellpadding="0" cellspacing="0" >
                      <tr>
                        <td height="17" width="<?php echo(2*$wid)?>" bgcolor="#336699" align="left">&nbsp;</td>
                      </tr>
                    </table>
                  </div><div align="center"></div></td>
                </tr>
                <tr>
                  <td height="15" align="right" style="padding-right:15px; ">&nbsp;</td>
                  <td height="15" style="padding-left:10">&nbsp;</td>
                  <td height="15" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td width="193" height="30" align="right" style="padding-right:15px; "><strong>User name: </strong></td>
                  <td width="290" height="30" style="padding-left:10"><input name="uname" type="text" class="box" style=" background-color:#FFFFFF; border:0; font-weight:bold; " value="<?php echo($uname); ?>" size="15" disabled="disabled" /></td>
                  <td height="30" colspan="2">
				   <?php if(isset($_SESSION['rst_msg'])){
				  			echo($_SESSION['rst_msg']);
							unset($_SESSION['rst_msg']);
				  }?></td>
                </tr>
                <tr>
                  <td height="30" align="right" style="padding-right:15px; "><strong>Education level </strong></td>
                  <td height="30" style="">&nbsp; <?php echo $cdegree ?>				    
				  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td height="30" colspan="2" style="">				 </td>
                </tr>
                
                <tr>
                  <td height="30" align="right" style="padding-right:15px; "><strong>Most recent  school: </strong></td>
                  <td height="30" colspan="3" style="">&nbsp; <?php echo($cschool); ?>                      </td>
                </tr>
                <tr>
                  <td height="30" align="right" style="padding-right:15px; "><strong>Major/Program </strong></td>
                  <td height="30" colspan="3" style="">&nbsp; <?php echo($major_name); ?>                      </td>
                </tr>
                <tr>
                  <td height="30" align="right" style="padding-right:15px; "><strong>Enrolled semester </strong></td>
                  <td height="30" colspan="3" style="">&nbsp;
                      <?php echo($sterm); ?></td>
                </tr>
<tr>
                  <td height="30" align="right" style="padding-right:15px; "><strong>Graduate(d) semester </strong></td>
                  <td height="30" colspan="3" style="">&nbsp;
                      <?php echo($eterm); ?></td>
              </tr>
                <tr>
                  <td height="100" align="center">&nbsp;</td>
                  <td height="100" align="left" style="font-size:12px; ">
				  &nbsp; <a href="EditEduInfo.php" class="one">[+ Edit]</a></td>
                  <td width="68" height="100" align="right" valign="middle">
				  <?php 
				  	if(isset($_SESSION['rst_flag']) && $_SESSION['rst_flag']=="success"){
				  		echo("<div style='padding-left:10'><input type='button' class='profile_btn' style='background:$_SESSION[hcolor]' value=' Next ' ONCLICK=window.location.href='EditContactInfo.php' /></div>");
					  	}
					?>					</td>
                  <td width="189" height="100" valign="middle">				  </td>
                </tr>
				<tr>
                  <td height="40" colspan="4">
				  <div style=" margin-bottom:10px; margin-top:2px" align="center">
			<?php 
			if(isset($_SESSION['rst_flag']) && $_SESSION['rst_flag']=="successss"){
				$q = mysql_query("SELECT * FROM rockinus.user_edu_info WHERE cmajor = '$cmajor' AND uname<>'$uname';");
				if(!$q) die(mysql_error());
				$edu_no_row = mysql_num_rows($q);
				$edu_limit= (isset($_GET["limit"])) ? $_GET["limit"] : 5;
				$edu_page= (isset($_GET["page"]))? $_GET["page"] : 1;
				if((!$edu_limit) || (is_numeric($edu_limit) == false)|| ($edu_limit < 5) || ($edu_limit > 25)) 
				$edu_limit = 1; //default
	
				if((!$edu_page) || (is_numeric($edu_page) == false) || ($edu_page < 0) || ($edu_page > $edu_no_row))
				$edu_page = 1; //default 
				
				$edu_next_page = $edu_page + 1;
				$edu_div_id = "eduDiv".$edu_page;
				$edu_total_pages = ceil($edu_no_row / $edu_limit);
				$edu_set_limit = ($edu_page * $edu_limit) - $edu_limit;
				
				if($edu_no_row>0){
					echo "<div align='left' style='width:700; padding-left:5; padding-top:10; padding-bottom:10; margin-bottom:15; background:#F5F5F5; border-top:1px #CCCCCC solid; height:20'><font style='font-size:13px; font-weight:normal; font-family: Arial, Helvetica, sans-serif;'>&nbsp;<img src=img/grayStar_66CCFF.jpg width=13 />&nbsp;&nbsp;&nbsp;Following student(s) study $major_name :</div>";
					$q_edu = mysql_query("SELECT * FROM rockinus.user_edu_info a JOIN rockinus.user_info b WHERE a.cmajor = '$cmajor' AND a.uname<>'$uname' AND a.uname=b.uname LIMIT $edu_set_limit, $edu_limit;");
					if(!$q_edu) die(mysql_error());
					while($object = mysql_fetch_object($q_edu)){					
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
						
						echo("<td style='padding-left:15px; padding-top:5; line-height:150%; font-family: Arial, Helvetica, sans-serif;' valign='top'><a href='RockerDetail.php?uid=$loopname' target='_blank' class=one><strong>$loopfname $looplname</strong></a><br><br>");
						if($rel_rstatus=="S")echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='EditEduInfo.php' class=one>+ Edit</a></div>&nbsp;");
						else if($rel_rstatus=="P")echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'>Requested</div>");
						else if($rel_rstatus=="A")echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='FriendConfirm.php?uid=$loopname&&pageName=EditEduInfo' class=one>Defriend</a></div>");
						else if($rel_rstatus=="X"){
							echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='AcceptFriend.php?sender=$loopname' class=one>Accept</a></div>&nbsp;&nbsp;");
							echo("<div style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'><a href='DenyFriend.php?sender=$loopname&&pageName=EditEduInfo' class=one>Decline</a></div>");
							}else if($rel_rstatus=="N")echo("<div id='addFriendMajorDiv$loopname' class='addFriendMajorDiv$loopname' style='height:16; padding:3 8 3 8; background: url(img/master.png); border:1px solid #DDDDDD; border-top:0px solid #DDDDDD; line-height:120%; font-size:12px; cursor:pointer; color:#000000; display:inline' align='center'>+ Friend</div>");
						?>
	<span id="flashAddFriendMajor<?php echo($loopname) ?>" class="flashAddFriendMajor<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span>
 	 <span id="addFriendMajorResult<?php echo($loopname) ?>" class="addFriendMajorResult<?php echo($loopname) ?>" style='; font-weight:normal; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:none' align='center'></span>&nbsp;
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
<script type="text/javascript">
function loadEduFriend(pageNum,div_id)
{
//alert(pageNum);
//alert(div_id);
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById(div_id).innerHTML=xmlhttp.responseText;
    $("#edu_btn_<?php echo($edu_div_id) ?>").hide();
	}
  }

xmlhttp.open("GET","loadFriend.php?page="+pageNum+"&proName=education&cmajor="+'<?php echo($cmajor) ?>'+"&limit=5",true);
xmlhttp.setRequestHeader("Content-Type","text/html;charset=gb2312");
xmlhttp.send();
}
</script>
<?php
if($edu_next_page <= $edu_total_pages && isset($_SESSION['rst_flag']) ){ 
?>
<button type="button" id='edu_btn_<?php echo($edu_div_id) ?>' onClick="loadEduFriend('<?php echo($edu_next_page) ?>','<?php echo($edu_div_id) ?>')" style="color:black; background-image:url(img/viewMore.png); font-size:13px; background-color: #F5F5F5; border:0px; margin-left:20; margin-bottom:20; height:29; width:130; font-weight:bold; display:none" onMouseOver="this.style.cursor='hand'"> 
&nbsp;</button>
<?php 
} 
?>
<br>
<div id=<?php echo($edu_div_id) ?>></div>
<br>				  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
		</form>
	  </td>
    </tr>
  </table>
<?php 
if(isset($_SESSION['rst_flag'])) unset($_SESSION['rst_flag']);
include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
