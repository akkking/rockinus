<?php 
include("ValidCheck.php"); 
include("Allfuc.php");
include 'dbconnect.php';
$uname = $_SESSION['usrname'];
$proName = trim($_GET['proName']);
$sql_stmt = NULL;
$fcountry = NULL;
$fregion = NULL;
$cmajor = NULL;
$no_row = NULL;
$add_div_name = NULL;
$flash_div_name = NULL;
$result_div_name = NULL;

if($proName=="hometown"){
	$fcountry = $_GET['fcountry'];
	$fregion = $_GET['fregion']; 
	$add_div_name = "addFriendHometownDiv";
	$flash_div_name = "flashAddFriendHometown";
	$result_div_name = "addFriendHometownResult";
	
	$q = mysql_query("SELECT * FROM rockinus.user_info WHERE fcountry = '$fcountry' AND fregion = '$fregion' AND uname<>'$uname';");
	if(!$q) die(mysql_error());
	$no_row = mysql_num_rows($q);
	
	$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 2;
	$page= (isset($_GET["page"]))? $_GET["page"] : 1;
	if((!$limit) || (is_numeric($limit) == false)|| ($limit < 2) || ($limit > 25)) 
	$limit = 1; //default
	
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $no_row))
	$page = 1; //default 
	$last_div_id = $page-1;
			
	$next_page = $page + 1;
	$div_id = "hometownDiv".$page;
	$total_pages = ceil($no_row / $limit);
	$set_limit = ($page * $limit) - $limit;

	$sql_stmt = "SELECT * FROM rockinus.user_info WHERE fcountry = '$fcountry' AND fregion = '$fregion' AND uname<>'$uname' LIMIT $set_limit, $limit;";
}else if($proName=="emotion"){
	$mstatus = $_GET['mstatus'];
	$gender = $_GET['gender'];
	$add_div_name = "addFriendHometownDiv";
	$flash_div_name = "flashAddFriendHometown";
	$result_div_name = "addFriendHometownResult";
	
	$q = mysql_query("SELECT * FROM rockinus.user_info WHERE gender = '$gender_here' AND mstatus = '$mstatus' AND uname<>'$uname';");
	if(!$q) die(mysql_error());
	$no_row = mysql_num_rows($q);
	
	$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 2;
	$page= (isset($_GET["page"]))? $_GET["page"] : 1;
	if((!$limit) || (is_numeric($limit) == false)|| ($limit < 2) || ($limit > 25)) 
	$limit = 1; //default
	
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $no_row))
	$page = 1; //default 
	$last_div_id = $page-1;
			
	$next_page = $page + 1;
	$div_id = "emotionDiv".$page;
	$total_pages = ceil($no_row / $limit);
	$set_limit = ($page * $limit) - $limit;

	$sql_stmt = "SELECT * FROM rockinus.user_info WHERE gender = '$gender_here' AND mstatus = '$mstatus' AND uname<>'$uname' LIMIT $set_limit, $limit;";
}else if($proName=="education"){
	$cmajor = $_GET['cmajor'];
	$add_div_name = "addFriendMajorDiv";
	$flash_div_name = "flashAddFriendMajor";
	$result_div_name = "addFriendMajorResult";
	
	$q = mysql_query("SELECT * FROM rockinus.user_edu_info WHERE cmajor = '$cmajor' AND uname<>'$uname';");
	if(!$q) die(mysql_error());
	$no_row = mysql_num_rows($q);
	
	$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 2;
	$page= (isset($_GET["page"]))? $_GET["page"] : 1;
	if((!$limit) || (is_numeric($limit) == false)|| ($limit < 2) || ($limit > 25)) 
	$limit = 1; //default
	
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $no_row))
	$page = 1; //default 
	$last_div_id = $page-1;
			
	$next_page = $page + 1;
	$div_id = "eduDiv".$page;
	$total_pages = ceil($no_row / $limit);
	$set_limit = ($page * $limit) - $limit;

	$sql_stmt = "SELECT * FROM rockinus.user_edu_info WHERE cmajor = '$cmajor' AND uname<>'$uname' LIMIT $set_limit, $limit;";
}

?>
<div style="margin-bottom:0px; margin-top:-15px; width:740" align="center">
<?php 
				$q = mysql_query($sql_stmt);
				if(!$q) die(mysql_error());
				$no_row = mysql_num_rows($q);
				
				while($object = mysql_fetch_object($q)){					
					$loopname = $object->uname;
				?>
				<script type="text/javascript">
$(function() {
	$(".<?php echo($add_div_name.$loopname) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($loopname) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#<?php echo($add_div_name.$loopname) ?>").hide();
		$("#<?php echo($flash_div_name.$loopname) ?>").show();
		$("#<?php echo($flash_div_name.$loopname) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_frequest.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#<?php echo($flash_div_name.$loopname) ?>").hide();
				$("#<?php echo($result_div_name.$loopname) ?>").html(html);
				$("#<?php echo($result_div_name.$loopname) ?>").show();
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
						//date('Y-m-d, H:i');
						$target_loop_uname = "upload/".$loopname;
						echo("<table width='700' style='margin-bottom:10px'><tr>");
				
						if(is_dir($target_loop_uname)){
							echo("<td align='left' style='border:1px solid #EEEEEE; padding:5px' width='50px'><a href='RockerDetail.php?uid=$loopname' class=one title='$loopname'><img src=upload/$loopname/$loop_uname?".time()." style='margin-right:0px;'></a></td>");
						}else 
							echo("<td align='left' style='border:1px solid #EEEEEE; padding:5px' width='50px'><a href='RockerDetail.php?uid=$loopname' class=one title='$loopname'><img src='img/NoUserIcon_fixed.jpg' width=70 height=70 style='margin-right:0px;'></a></td>");
						
						echo("<td style='padding-left:15px; padding-top:5; line-height:150%; font-family: Verdana, Arial, Helvetica, sans-serif;' valign='top'><a href='RockerDetail.php?uid=$loopname' class=one><font color=$_SESSION[hcolor]>$loopname</font></a><br><br>");
						if($rel_rstatus=="S")echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='EditUserInfo.php' class=one>+ Edit</a></div>&nbsp;");
						else if($rel_rstatus=="P")echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'>Requested</div>");
						else if($rel_rstatus=="A")echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='FriendConfirm.php?uid=$loopname&&pageName=EditUserInfo' class=one>Defriend</a></div>");
						else if($rel_rstatus=="X"){
							echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='AcceptFriend.php?sender=$loopname' class=one>Accept</a></div>&nbsp;&nbsp;");
							echo("<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' align='center'><a href='DenyFriend.php?sender=$loopname&&pageName=EditUserInfo' class=one>Decline</a></div>");
							}else if($rel_rstatus=="N")echo("<div id='addFriendHometownDiv$loopname' class='addFriendHometownDiv$loopname' style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:85px; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:inline' onMouseOver=this.style.cursor='hand' align='center'>+ Friend</div>");
						?>
	<span id="<?php echo($flash_div_name.$loopname) ?>" class="<?php echo($flash_div_name.$loopname) ?>" style=" display:none; width:100; padding-right:5"></span>
 	 <span id="<?php echo($result_div_name.$loopname) ?>" class="<?php echo($result_div_name.$loopname) ?>" style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333;  padding:3 5 3 5; display:none' align='center'></span>&nbsp;
	 		<?php
	 		if($rel_rstatus!="S"){?><div style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:normal; width:90; height:20; border:1px #DDDDDD solid; background: url(img/master.png); color:#333333; padding-top:5; padding:3 5 3 5; display:inline" align="center"><a href="SendMessage.php?recipient=<?php echo($loopname) ?>" class='one'>Message</a>
	</div>
	<?php } 
	
		echo("</td></tr></table>");
	}
	?>	
	</div>
<script type="text/javascript">
function loadFriend(pageNum,div_id)
{
//alert(pageNum);
alert(div_id);
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
    }
  }

xmlhttp.open("GET","loadFriend.php?page="+pageNum+"&proName=education&cmajor="+'<?php echo($cmajor) ?>'+"&limit=2",true);
xmlhttp.setRequestHeader("Content-Type","text/html;charset=gb2312");
xmlhttp.send();
}
</script>
<?php
if($next_page <= $total_pages){ 
?>
<button type="button" onClick="loadFriend('<?php echo($next_page) ?>','<?php echo($div_id) ?>')" style="color:black; background-image:url(img/viewMore.png); font-size:14px; background-color: #F5F5F5; border:0px; margin-left:20; margin-bottom:20; height:29; width:130; font-weight:bold" onMouseOver="this.style.cursor='hand'"> 
</button>
<?php 
} 
?>
<div id=<?php echo($div_id) ?>></div>
<br>