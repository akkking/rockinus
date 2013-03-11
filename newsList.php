<?php 
include 'mainHeader.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];
$sel_cond = "";

if(isset($_POST['newsType'])){
	$_SESSION['newsType'] = trim($_POST['newsType']);
 	if($_POST['newsType']!="blank")
		$sel_cond = " AND category='".trim($_POST['newsType'])."'";
}
?>
<script src="js/ajax.jquery.min.js"></script>
<div align="center" style="width:100%; padding-top:0px">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="659" align="left" valign="top" style=" padding:10px">
	  <div style="border:0px solid #DDDDDD">
	  <?php include("smallMenu.php") ?>
	    <table width="620" height="60" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:5;">
	      <tr>
	        <td width="121" height="30" align="right" style="padding-right:10; color:#000000; font-size:14px; font-weight:">
	          Select Category </td>
            <td width="210" height="30" align="left" style="padding-left:0px">
              <form name="categoryForm" id="categoryForm" method="post">
                <select name="newsType" onChange="document.categoryForm.submit()" style="font-size:12px; font-family:Arial, Helvetica, sans-serif">
                  <option value="blank">All kinds</option>
                  <option value="clubrecruit" <?php if(isset($_SESSION['newsType'])&&$_SESSION['newsType']=="clubrecruit")echo(" selected")?>>Club/Group Recruitment</option>
                  <option value="event" <?php if(isset($_SESSION['newsType'])&&$_SESSION['newsType']=="event")echo(" selected")?>>Event/Activity</option>
                  <option value="lostfound" <?php if(isset($_SESSION['newsType'])&&$_SESSION['newsType']=="lostfound")echo(" selected")?>>Lost+Found</option>
                  <option value="question" <?php if(isset($_SESSION['newsType'])&&$_SESSION['newsType']=="question")echo(" selected")?>>Open question/Topic</option>
                  <option value="work" <?php if(isset($_SESSION['newsType'])&&$_SESSION['newsType']=="work")echo(" selected")?>>Part Time/Volunteer</option>
                  <option value="seminar" <?php if(isset($_SESSION['newsType'])&&$_SESSION['newsType']=="seminar")echo(" selected")?>>Seminar/Lecture</option>
                  <option value="others" <?php if(isset($_SESSION['newsType'])&&$_SESSION['newsType']=="others")echo(" selected")?>>Others</option>
                  </select>
              </form>		  </td>
            <td width="184" height="30" align="right" style="padding-right:15px; color:#FFFFFF; font-size:12px">
              <?php
$page_name = "newsList.php";
include 'dbconnect.php';

// Make sure to display events by listing none expired at top, and list expired afterwards
// Put expired and unexpired events into different array
$q = mysql_query("SELECT * FROM rockinus.news_info WHERE 1=1 $sel_cond ORDER BY pdate DESC,ptime DESC");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
$array_non_expired = array();
$array_expired = array();
while($object = mysql_fetch_object($q)){
	$news_id = $object->news_id;
	$category = $object->category;
	$eventdate = $object->eventdate;
	$eventtime = $object->eventtime;
	
	if(($category=='event' || $category=='seminar') && getCountTime($eventdate." ".$eventtime)=="<font color=#B92828>Expired</font>")
		$array_show_expired[] = $news_id;
	else
		$array_show_non_expired[] = $news_id;
}

// Then merge both arrays
$final_array = array_merge($array_show_non_expired,$array_show_expired);
$total_items = count($final_array);

$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 50;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
if((!$limit) || (is_numeric($limit) == false)|| ($limit < 50) || ($limit > 60)) {
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
	echo("<a href=$page_name?limit=$limit&page=$prev_page class=><<</a> ");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo(" <strong><u>$a</u></strong> "); //no link
}else{ 
	echo(" <a href=$page_name?limit=$limit&page=$a class=>$a</a> ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo(" <a href=$page_name?limit=$limit&page=$next_page class=>>></a>");
}
if ($total_items != 0 )echo "";
?></td>
            <td width="105" height="30" align="right" valign="middle" style=" padding-top:2; padding-right:10">
              <a href="createNews.php">
                <div align="center" style="border:1px solid #999999; background: url(img/master.jpg); padding-bottom:3; padding-top:3; width:80; font-size:14px; font-weight:bold; color:<?php echo($_SESSION['hcolor'])?>">+ Post</div></a>              </td>
          </tr>
	      </table>
	    <div style="width:620; border:0px solid #DDDDDD; border-top:0" align="right">
	      <?php
if ($total_items == 0 )echo("<br><br><br><div align=center><font color=$_SESSION[hcolor] style='font-size:24px'><strong>There is no notice found ...</strong></font></div><br><br><br><br><br>");
else{
	$k = 0;
	for($index=$set_limit; $index<($set_limit+$limit); ++$index){
		if($index>count($final_array)-1)break;
		$id_val = $final_array[$index];
		$q = mysql_query("SELECT * FROM rockinus.news_info WHERE news_id='$id_val'");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		$k++;
		$object = mysql_fetch_object($q);
		$news_id = $object->news_id;
		$creater = $object->creater;
		$subject = $object->subject;
		$subject = str_replace("\\","",$subject);
		$category = $object->category;
		$descrip = $object->descrip;
		$pdate = $object->pdate;
		$ptime = $object->ptime;
		$eventdate = $object->eventdate;
		$eventtime = $object->eventtime;
		$descrip = str_replace("\\","",nl2br($descrip));
		$today = strtotime(date("Y-m-d"));
			?>
	      <script>
$(document).ready(function() {  
	$("div .divNewsTitle_<?php echo($news_id) ?>").click(function () {
	  $("#News_out_<?php echo($k) ?>").hide();
	  $("#divNewsTitle2_<?php echo($news_id) ?>").show();
	  $("#divNews_<?php echo($news_id) ?>").show();
	  
	  var e = "News_out_"+<?php echo($k) ?>;
	  var e_obj = document.getElementById("News_out_"+<?php echo($k) ?>);
		
	  for(var i=1;i<=<?php echo($limit) ?>;i++){
	  	var d_obj = document.getElementById("News_out_"+i);
		var d = "News_out_"+i;
		
		var title_obj = document.getElementById("title_out_"+i);
		var title = "title_out_"+i;
		
		var title2_obj = document.getElementById("title2_out_"+i);
		var title2 = "title2_out_"+i;
		
		if(d!=e){	
			d_obj.style.display = 'none';
			title2_obj.style.display = 'none';
			title_obj.style.display = '';
	  	}else{
			d_obj.style.display = '';
			title_obj.style.display = 'none';
			title2_obj.style.display = '';
	  	}
	  }
	  //$('table.tb_<?php echo($news_id) ?>').attr('border', '0'); 
	 });
	 
	 $("div .divNewsTitle2_<?php echo($news_id) ?>").click(function () {
      $("#divNewsTitle2_<?php echo($news_id) ?>").hide();
	  $("#divNewsTitle_<?php echo($news_id) ?>").show();
	  $("#divNews_<?php echo($news_id) ?>").hide();
	  //$("#tb_<?php echo($news_id) ?>").css('background-color', '');
	  
	  var e = "News_out_"+<?php echo($k) ?>;
	  var e_obj = document.getElementById("News_out_"+<?php echo($k) ?>);
		
	  for(var i=1;i<=<?php echo($limit) ?>;i++){
	  	var d_obj = document.getElementById("News_out_"+i);
		var d = "News_out_"+i;
		
		var title_obj = document.getElementById("title_out_"+i);
		var title = "title_out_"+i;
		
		var title2_obj = document.getElementById("title2_out_"+i);
		var title2 = "title2_out_"+i;
		
		if(d!=e){	
			d_obj.style.display = 'none';
			title2_obj.style.display = 'none';
			title_obj.style.display = '';
	  	}else{
			d_obj.style.display = '';
			title_obj.style.display = '';
			title2_obj.style.display = 'none';
	  	}
	  }
	 });
});
</script> 
	      <table width="620" height="32" border="0" cellpadding="0" cellspacing="0" onmouseover="document.getElementById('dn<?php echo($news_id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; document.getElementById('mn<?php echo($news_id)?>').style.backgroundColor='<?php echo($_SESSION['hcolor']) ?>'; " onmouseout="document.getElementById('dn<?php echo($news_id)?>').style.backgroundColor='#FFFFFF';document.getElementById('mn<?php echo($news_id)?>').style.backgroundColor='#FFFFFF'; " class="tb_<?php echo($news_id) ?>" id="tb_<?php echo($news_id) ?>" style="border-bottom:0px #DDDDDD dashed; border-top:0; margin-bottom:0; <?php if($k%2==0)echo("background:#F5F5F5") ?>">
	        <tr>
	          <td width="525" height="30" valign="middle" style="line-height:150%; font-size:14px; font-family:Arial, Helvetica, sans-serif; padding:10; padding-right:0; padding-top:5; padding-bottom:5; font-weight:normal">
	            <div class="title_out_<?php echo($k) ?>" id="title_out_<?php echo($k) ?>">
	              <div style="cursor:pointer; font-weight:normal; padding-left:0px" id="divNewsTitle_<?php echo($news_id) ?>" class="divNewsTitle_<?php echo($news_id) ?>">
	                <img src="img/newsMenuIcon.jpg"  width="12" />&nbsp;&nbsp;&nbsp; 
	                <?php 
		  if($category!='event' && $category!='seminar'){
		  	  echo("<font color=#333333>$subject</font><font color=#999999 style='font-size:11px; font-weight:normal'> (".ucfirst($category)." | ".getDateName($pdate).")</font>");
		  }else{
			  if(getCountTime($eventdate." ".$eventtime)!="<font color=#B92828>Expired</font>"){
			  	echo("<font color=#333333>$subject</font><font color=#999999 style='font-size:11px; font-weight:normal'> (".getDateName($pdate).")</font>");
			  }else{
			  	echo("<font color=#333333 style='text-decoration: line-through'>$subject</font> <font color=#999999 style='font-size:11px; font-weight:bold; color:$_SESSION[hcolor]'>[".getCountTime($eventdate." ".$eventtime)."]</font>");
			  }
		}
		  ?>		  
	                </div>
		    </div>
		    
		  <div class="title2_out_<?php echo($k) ?>" id="title2_out_<?php echo($k) ?>">
		    <div id="divNewsTitle2_<?php echo($news_id) ?>" class="divNewsTitle2_<?php echo($news_id) ?>" style="display:none; cursor:pointer; font-size:14px; font-weight:normal; padding-left:0px">
		      <img src="img/newsMenuIcon.jpg"  width="12" />&nbsp;&nbsp;&nbsp; 
		      <?php 
		  if($category!='event' && $category!='seminar')
			  echo("<font color=$_SESSION[hcolor]>$subject</font><font color=#999999 style='font-size:11px; font-weight:normal'> (".getDateName($pdate)." | ".substr($ptime,0,5)." )</font>");
		  else
			  echo("<font color=$_SESSION[hcolor]>$subject</font> <font color=#999999 style='font-size:11px; font-weight:bold; color:#333333'>[".getCountTime($eventdate." ".$eventtime)."]</font>");
		  ?>
		      </div>
		    </div>		    </td>
            <td width="95" height="30" valign="middle" align="right" style="line-height:120%; font-size:11px; padding: 5 10 5 10; font-weight:normal; background:#FFFFFF">
              
  <script type="text/javascript">
$(function() {
	$(".attendDiv<?php echo($news_id) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var news_id = '<?php echo($news_id) ?>';
		var dataString = 'sender='+sender+'&&news_id='+news_id; 
		//alert("dataString");
		
		$("#attendDiv<?php echo($news_id) ?>").hide();
		$("#flashAttend<?php echo($news_id) ?>").show();
		$("#flashAttend<?php echo($news_id) ?>").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_attendEvent.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashAttend<?php echo($news_id) ?>").hide();
				$("#attendResult<?php echo($news_id) ?>").html(html);
				$("#attendResult<?php echo($news_id) ?>").show();
			}
 		});
 		return false;
 	});
 });
    </script>
              <?php 
					  if($uname==$creater)echo("<span id='dn$news_id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=NewsConfirm.php?news_id=$news_id&&pageName=newsList><font size=1>Delete</font></a></span> <span id='mn$news_id' style='background-color:#FFFFFF; padding-left:5px; padding-right:5px'><a href=EditNews.php?news_id=$news_id><font size=1>+ Edit</font></a></span>");
					  else if($category=="event"||$category=='seminar'){
					  	$q_uid = mysql_query("SELECT * FROM rockinus.event_attendance WHERE uname='$uname' AND news_id='$news_id' AND rstatus='Y'");
						if(!$q_uid) die(mysql_error());
						$no_row_uid = mysql_num_rows($q_uid);
						if(getCountTime($eventdate." ".$eventtime)!="<font color=#B92828>Expired</font>"){
							if($no_row_uid == 0){
						  		echo("<span id='attendDiv$news_id' class='attendDiv$news_id' style='background: url(img/".substr($_SESSION['hcolor'],1,6)."_ajax_button.jpg); border:1px solid #999999; height:14; padding:2 8 2 8; font-size:11px; display:inline; cursor:pointer; color:#000000'>Click to RSVP</span>");
					  		}else{
								echo("<span style='background: #EEEEEE; border:1px solid #DDDDDD; height:14; padding:2 5 2 5; font-size:11px; display:inline; width:105'><img src='img/addsuccessIcon_F5.jpg' width=8 />&nbsp;I'm attending</span>");
					  		}
						}else{
							echo("RSVP expired");
						}
					}
					  ?>
              <span id="flashAttend<?php echo($news_id) ?>" class="flashAttend<?php echo($news_id) ?>" style="display:none; width:100; padding-right:5"></span> <span id="attendResult<?php echo($news_id) ?>" class="attendResult<?php echo($news_id) ?>" style='display:none'></span>			  </td>
          </tr>
	        </table>
		  <div id="News_out_<?php echo($k) ?>" class="News_out_<?php echo($k) ?>" style="width:620">
		    <div style=" display:none; width:620" id="divNews_<?php echo($news_id) ?>" class="divNews_<?php echo($news_id) ?>">
		      <table width="620" border="0" cellpadding="0" cellspacing="0" style=" border-bottom:0px solid #DDDDDD; margin-bottom:5">
		        <tr>
		          <td width="655" height="35" valign="middle" style="line-height:150%; font-size:14px; padding:10 10 10 37">
		            <script type="text/javascript">
$(function() {
	$(".cancelDiv<?php echo($news_id) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var news_id = '<?php echo($news_id) ?>';
		var dataString = 'sender='+sender+'&&news_id='+news_id; 
		//alert("dataString");
		
		$("#cancelDiv<?php echo($news_id) ?>").hide();
		$("#flashCancel<?php echo($news_id) ?>").show();
		$("#flashCancel<?php echo($news_id) ?>").fadeIn(400).html('...');
 
		$.ajax({
			type: "POST",
			url: "ajax_cancelEvent.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashCancel<?php echo($news_id) ?>").hide();
				$("#cancelResult<?php echo($news_id) ?>").html(html);
				$("#cancelResult<?php echo($news_id) ?>").show();
			}
 		});
 		return false;
 	});
 });
    </script>
		            
		            <?php 
		  	echo(addHyperLink($descrip)."<br>");
			
			$sql_stmt = "SELECT a.email, a.uname, a.status, a.signup_date, a.signup_time, c.fname, c.lname 
					FROM rockinus.user_check_info a JOIN rockinus.event_attendance b JOIN rockinus.user_info c ON a.status='A' AND a.uname=b.uname 
					AND a.uname=c.uname	AND b.news_id='$news_id' AND b.rstatus='Y'
					GROUP BY a.uname 
					ORDER BY b.pdate ASC, b.ptime ASC";
					//echo($sql_stmt);
					
			$q_event = mysql_query($sql_stmt);
			if(!$q_event) die(mysql_error());
			$no_row_event = mysql_num_rows($q_event);
			if($no_row_event == 0) echo("");
			else echo("<strong>RSVP list: </strong>&nbsp;");
			$j=0;
			while($object_event = mysql_fetch_object($q_event)){
				$j++;
				if($j%10==0)echo("<br>");
				$loopname = $object_event->uname;	
				$loop_fname = $object_event->fname;	
				$loop_lname = $object_event->lname;			
				$pdate = $object_event->signup_date;
				$ptime = $object_event->signup_time;
				$id = $object_event->email;
				$action = $object_event->status;
			
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
		
				echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]>$loop_fname $loop_lname</font></a>");
				
				if($rel_rstatus=="S")
						echo(" <font color=#999999 style='font-size:11px'>(<span class='cancelDiv$news_id' id='cancelDiv$news_id' style='cursor:pointer'>Click to Cancel RSVP</span><span id='flashCancel$news_id' class='flashCancel$news_id' style='display:none; width:100; padding-right:5'></span><span id='cancelResult$news_id' class='cancelResult$news_id' style='display:none'></span>)</font>&nbsp;");		
				else
					echo("<font color=#999999 style='font-size:12px'>(<a href='SendMessage.php?recipient=$loopname' class=one><font color=#999999>+ Message</font></a>)</font>&nbsp;");		
			}
		?>
	              <td width="105" height="35" valign="middle" style="line-height:150%; font-size:12px; padding:10 10 10 40">	                </tr>
		        </table>
	    </div>
	    </div>
        <?php } } ?>
	      </div>
      </div></td>
      <td width="365" align="left" valign="top" style="padding:10px 0px 15px 0px">
	  <!--
	Status Post Div Starts
	-->
	  <div id='publishStatusTable' class='publishStatusTable'>
        <table width="360" height="50" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px; background: #FFFFFF;">
          <tr>
            <td width="285" height="32" align="left" valign="top" style="padding-left:0px; padding-top:0px"><textarea name="textarea" class="newStatusContent" id="newStatusContent" style="width:278px; height:40px; border:0; border:1px solid #EEEEEE; font-size:14px; background-color:#F5F5F5; font-family:Georgia, 'Times New Roman', Times, serif; padding:3; position:absolute; color:#888888; margin-top:3px" onfocus="this.style.height = '80px'; this.select(); inputFocus(this)" onblur="this.style.height = '40px'; this.value=!this.value?' Share something with alumnus...':this.value; inputBlur(this)" onclick="this.style.height = '80px'; if(this.value==' Share something with alumnus...')this.value=''"> Share something with alumnus...</textarea>
            </td>
            <td width="75" valign="top" style=" padding-top:15px; padding-left:5px" align="left"><script type="text/javascript" >
	$(function() {
	$(".publishStatusBtn").click(function() {
		var test = $("#newStatusContent").val();
		var pdate = '<?php echo(date('Y-m-d')) ?>';
		var ptime = '<?php echo(date("H:i:s", time())) ?>';
		var sender = '<?php echo($uname) ?>';
		var dataString = 'content='+ test+'&sender='+sender+'&pdate='+pdate+'&ptime='+ptime; 
		
		if(test==''||test==' Share something with alumnus...')
		{
			alert("<?php echo($fname) ?>, please enter something ok?");
		}
		else
		{
			$("#flashStatusMemo").show();
			$("#flashStatusMemo").fadeIn(400).html('');
 
 			$.ajax({
  				type: "POST",
  				url: "ajax_insert_home_status.php",
  				data: dataString,
  				cache: false,
  				success: function(html){
  					$("#displayStatusMemo").after(html);
  					document.getElementById('contentforown').value='';
  					document.getElementById('contentforown').focus();
  					$("#flashStatusMemo").hide();
					$("#publishStatusTable").hide();
  				}
 			});
 		} return false;
 	});
});
      </script>
                <div class="publishStatusBtn" id="publishStatusBtn" style=" height:20px; padding:10 10 10 10; background: #CC6600; display: inline; width:60px; border:1px solid #000000; font-size:14px; cursor:pointer; font: Georgia, 'Times New Roman', Times, serif; color:#FFFFFF;   -moz-border-radius: 3px; border-radius: 3px;" align="center" onmouseover="this.style.background='#C35617'" onmouseout="this.style.background='#CC6600'">Publish</div>
            </td>
          </tr>
        </table>
	    <div style=" width:420px; display:none; height:25px; " align="center" id="postStatusHeader">
          <div style=" width:420px; height:25px; background:#EEEEEE; border-top:1px solid #CCCCCC; border-bottom:1px solid #CCCCCC;"></div>
	      </div>
	    </div>
	  <div id="flashStatusMemo" class="flashStatusMemo" style="margin-top:15; margin-bottom:15; display:none"></div>
<div id="displayStatusMemo" class="displayStatusMemo" style="width:760; margin-bottom:0; display:none"></div>
<!--
	Status Post Ends
	-->
	
	  <?php include("PeopleList.php") ?>	  </td>
    </tr>
</table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
