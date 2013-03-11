<?php
//include 'ValidCheck.php';
include 'dbconnect.php';
//include("Allfuc.php");
//$uname = $_SESSION['usrname'];
?>
<table width="200" height="35" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:8px; border-top:1px solid #DDDDDD; border-bottom:0px solid #666666; background:#EEEEEE">
  <tr>
    <td align="left" width="200" style=" padding-left:7px; font-size:18px; color:#666666; font-family: Georgia, 'Times New Roman', Times, serif; font-weight:bold;"><em>Recommends</em>  &nbsp;&nbsp;&nbsp; <img src="img/br_down.png" width="15" /></td>
  </tr>
</table>
<?php
$sql_stmt = "SELECT * FROM rockinus.user_info a 
			JOIN rockinus.user_check_info b 
			ON a.uname NOT IN (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname'
						   UNION
						   SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname')
			AND
				a.uname=b.uname
			AND 
				a.uname<>'$uname'
			ORDER BY b.signup_date DESC, b.signup_time DESC";
$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());

// Save mutual friend number
$hash_mutal_friends = array();

// Store mutual scores
$hash_mutal_friends_score = array();

while($object = mysql_fetch_object($q)){
	$loopName = $object->uname;
	if(strlen(trim($loopName))>0)
	$hash_mutal_friends[$loopName] = count(getMutalFriends($uname,$loopName));
	$hash_mutal_friends_score[$loopName] = getMutalFriendsScore($uname,$loopName,$hash_mutal_friends[$loopName]);
	//echo($loopName." = ".$hash_mutal_friends[$loopName]."==".$hash_mutal_friends_score[$loopName]."<br>");
}
//echo("number: ".count($hash_mutal_friends));
arsort($hash_mutal_friends);
arsort($hash_mutal_friends_score);
$i = 1;
foreach($hash_mutal_friends_score as $key=>$value){
	if($i==11)break;
	$sql_stmt = "SELECT * FROM rockinus.user_info a 
				JOIN rockinus.user_check_info b 
				ON a.uname='$key' AND a.uname=b.uname AND a.uname<>'$uname'
				ORDER BY b.signup_date DESC, b.signup_time DESC";
	$q = mysql_query($sql_stmt);
	if(!$q) die(mysql_error());
	$object = mysql_fetch_object($q);
	$loopName = $object->uname;
	$fname = $object->fname;
	$lname = $object->lname;
	$pic60_Name = $loopName.'60.jpg';		
	$pdate = $object->pdate;
	$ptime = $object->ptime;
	
	$rel_rstatus = "N";
		
	$target = "upload/".$loopName;
	if(is_dir($target)){
		if($loopName==$uname)$rel_rstatus ="S";
		else{
			$q11 = mysql_query("SELECT * FROM rockinus.rocker_rel_info WHERE (sender='$loopName' AND recipient='$uname') OR (recipient='$loopName' AND sender='$uname')");
			if(!$q11) die(mysql_error());
			$no_row_A = mysql_num_rows($q11);
			if($no_row_A>0)$rel_rstatus='A';
	
			$q21 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$loopName' AND recipient='$uname' AND rstatus='P'");
			if(!$q21) die(mysql_error());
			$no_row_P = mysql_num_rows($q21);
			if($no_row_P>0)$rel_rstatus='X';
	
			$q22 = mysql_query("SELECT * FROM rockinus.rocker_rel_history WHERE sender='$uname' AND recipient='$loopName' AND rstatus='P'");
			if(!$q22) die(mysql_error());
			$no_row_X = mysql_num_rows($q22);
			if($no_row_X>0)$rel_rstatus='P';	
		}
?>
<table width="200" height="36" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:4; background:">
  <tr>
    <td width="55" align='left' valign='top' style="color:#000000; font-size:14px; padding-left:3">
	<?php
		//echo("<img src=upload/$loopName/$pic60_Name?".time()." width=50 style='border:0px solid #EEEEEE'>");
		echo("<div style='background: url(upload/$loopName/$pic60_Name?".time()."); background-repeat: no-repeat; margin-right:; width:50; height:50'>");
	?>	</td>
    <td width="125" align='left' valign='top' style="color:#000000; font-size:11px; font-weight:normal; padding-top:2; padding-left:7; line-height:120%">
	<?php echo("<a href='RockerDetail.php?uid=$loopName' class='one' title='$fname $lname' style='font-weight:bold; color:$_SESSION[hcolor]; font-size:13px'>$fname</a>") ?>
	<br />
	<div style=" margin-bottom:2; margin-top:2">
	<font style="font-weight:normal">
	<?php echo($hash_mutal_friends[$key]) ?> mutual friends</font>
	</div>
              <script type="text/javascript">
$(function() {
	$(".addFriendDiv<?php echo($loopName) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($loopName) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#addFriendDiv<?php echo($loopName) ?>").hide();
		$("#flashAddFriend<?php echo($loopName) ?>").show();
		$("#flashAddFriend<?php echo($loopName) ?>").fadeIn(400).html('<img src="img/loading42.gif" width="65" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_frequest.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashAddFriend<?php echo($loopName) ?>").hide();
				$("#addFriendResult<?php echo($loopName) ?>").html(html);
				$("#addFriendResult<?php echo($loopName) ?>").show();
			}
 		});
 		return false;
 	});
 });
      </script>
	<?php
					if($rel_rstatus=="N")echo("<div style='background: ; display:inline;  border-left:0px #DDDDDD solid; border-bottom:0px #CCCCCC solid; border-right:0px #CCCCCC solid; padding:1; margin-top:5px; height:12; line-height:120%; color:#333333; font-size:11px; cursor:pointer; font-weight:bold' class='addFriendDiv$loopName' id='addFriendDiv$loopName' onmouseover='this.style.backgroundColor=#EEEEEE;' onmouseout='this.style.backgroundColor=#F5F5F5;' align='center'>+ Friend</div>");
					if($rel_rstatus=="S")echo("<a href='EditEduInfo.php'><div style='background-image:url(img/master.png); display:inline; border:1px #DDDDDD solid; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px; cursor:pointer'>+ Edit</div></a>&nbsp;");
					else if($rel_rstatus=="P")echo("<div style='background-image:; display:inline; border:0px #DDDDDD solid; padding:2 0 2 0; margin-top:5px; height:18px; line-height:120%; color:$_SESSION[hcolor]; font-size:11px'>Request sent!</div>");
					else if($rel_rstatus=="A"){
						echo("");
					}?>
                        <span id="flashAddFriend<?php echo($loopName) ?>" class="flashAddFriend<?php echo($loopName) ?>" style=" display:none; width:100; padding-right:5"></span> <span id="addFriendResult<?php echo($loopName) ?>" class="addFriendResult<?php echo($loopName) ?>" style=' display:none; background: #EEEEEE; border:1px #DDDDDD solid; padding:2 6 2 6; height:15px; color:#000000; font-size:11px' align='center'></span>
	</td>
  </tr>
</table>
<?php	
		$i ++;
	}
}
	//echo($i);
?>