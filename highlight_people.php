<script>
$(document).ready(function() { 
	$("#showActiveCourse_2").hide();
    $("#activeCourseDiv_2").hide();
	$("#showActivePeople_2").hide();
    $("#activePeopleDiv_2").hide();
	$("#showActivePeople_1").show(); 
	$("#activePeopleDiv_1").show();
	$("#showActiveCourse_1").show(); 
	$("#activeCourseDiv_1").show();
	
	$("div .showActiveCourse_1").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#showActiveCourse_1").hide();
	  $("#activeCourseDiv_1").hide();
      $("#showActiveCourse_2").show(); 
	  $("#activeCourseDiv_2").show();
	 });

	$("div .showActiveCourse_2").click(function () {
	  $("#showActiveCourse_2").hide();
	  $("#activeCourseDiv_2").hide();
      $("#showActiveCourse_1").show(); 
	  $("#activeCourseDiv_1").show();
	});
	
	$("div .showActivePeople_1").click(function () {
      //$("#activeCourseDiv_2").show("slide", { direction: "up" }, 1000);
	  $("#showActivePeople_1").hide();
	  $("#activePeopleDiv_1").hide();
      $("#showActivePeople_2").show(); 
	  $("#activePeopleDiv_2").show();
	 });

	$("div .showActivePeople_2").click(function () {
	  $("#showActivePeople_2").hide();
	  $("#activePeopleDiv_2").hide();
      $("#showActivePeople_1").show(); 
	  $("#activePeopleDiv_1").show();
	});
});
</script>
<table width="180" height="85" border="0" cellpadding="0" cellspacing="0" style=" margin-top:15px; border-top:1px solid #DDDDDD">
  <tr>
    <td width="180" height="85" valign="top"><table width="180" height="25" border="0" cellpadding="0" cellspacing="0" style="background: #EEEEEE; ">
      <tr>
        <td width="120" height="25" align="left" style="font-size:12px; font-weight:bold; font-family: Georgia, 'Times New Roman', Times, serif; padding-left:7px; padding-top:; color: #666666"><em>Highlights</em></td>
        <td width="59" height="25" align="right" style="font-size:11px; font-weight:bold; padding-right:10; color:#666666"><div class="showActivePeople_1" id="showActivePeople_1" style="font-size:11px; cursor:pointer"> <img src="img/arrow_right.png" width="10" />  Next 5</div>
          <div class="showActivePeople_2" id="showActivePeople_2" style="font-size:11px; cursor:pointer; display:none"> <img src="img/arrow_right.png" width="10" /> Top 5</div></td>
      </tr>
    </table>
        <div class="activePeopleDiv_1" id="activePeopleDiv_1">
          <?php
		$sql_stmt = "SELECT a.email, a.uname, a.status, a.signup_date, a.signup_time, c.fname, c.lname, b.points, MAX(b.points) as points
					FROM rockinus.user_check_info a JOIN rockinus.user_points b JOIN rockinus.user_info c 
					ON a.status='A' AND a.uname=b.uname 
					AND a.uname=c.uname	AND a.uname<>'harvey'
					GROUP BY b.uname 
					ORDER BY points DESC LIMIT 1, 5";
					//echo($sql_stmt);
		mysql_query("SET NAMES GBK");
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($no_row == 0) echo("");
		$j=0;
		while($object = mysql_fetch_object($q)){
			$j++;
			$loopname = $object->uname;	
			$popular_fname = $object->fname;	
			$popular_lname = $object->lname;			
			$pdate = $object->signup_date;
			$ptime = $object->signup_time;
			$id = $object->email;
			$action = $object->status;
			$points = $object->points;
			
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
			
			$loopImg = "upload/$loopname/$loopname"."60.jpg";
			if(file_exists($loopImg)){
			?>
          <script type="text/javascript">
$(function() {
	$(".addFriendDiv<?php echo($loopname) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($loopname) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#addFriendDiv<?php echo($loopname) ?>").hide();
		$("#flashAddFriend<?php echo($loopname) ?>").show();
		$("#flashAddFriend<?php echo($loopname) ?>").fadeIn(400).html('<img src="img/loading42.gif" width="90" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_frequest.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashAddFriend<?php echo($loopname) ?>").hide();
				$("#addFriendResult<?php echo($loopname) ?>").html(html);
				$("#addFriendResult<?php echo($loopname) ?>").show();
			}
 		});
 		return false;
 	});
 });
      </script>
          <div style=" background-image: ; background-color:; margin-top:0; margin-bottom:<?php if($j==5)echo("0"); else echo("0")?>; border-left:0px solid #DDDDDD; border-right:0px solid #DDDDDD; padding-top:0; padding-bottom: 0; border-bottom:<?php if($j==5)echo("0"); else echo("1")?>px dashed #DDDDDD" >
            <table width="180" height="70" border="0" cellpadding="0" cellspacing="0" style="margin-top:0">
              <tr>
                <td width="55" height="70" rowspan="3" align="left" valign="top" style=" padding-left:3"><div style="background: url(<?php echo($loopImg); ?>); background-repeat:no-repeat; margin:5 10 5 0; width:55; height:55">&nbsp;</div>
				</td>
                <td width="275" align="left" valign="top" style="padding-left:0px; padding-top:5px; padding-bottom:3; line-height:150%; font-size:13px"><?php
							  	echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]><strong>$popular_fname $popular_lname</strong></font></a>");	
								//echo(" has joined the network");
								?>
								<br>
								<font style="font-size:12px; font-weight:bold"; color="#B92828"><?php echo("<em>No.".$j."</em>") ?></font>
								<?php	
									$pieces = explode('@', $id);
									if(stristr($pieces[1],'poly')==true) 
										//echo("<font color=#666666 style='font-size:11px'> (NYU-Poly) ($points points)</font>");
										echo("<font color=#666666 style='font-size:11px'> ($points points)</font>");
									else {
										$pieces_2 = explode('.', $pieces[1]);
										$len = count($pieces_2[1])-1;
										echo("&nbsp;<font color=#666666 style='font-size:11px'>(".strtoupper($pieces_2[$len]).") ($points points)</font>");
										//else echo($id);
									}
								?>
                    <br />
                    <font color="#666666" style="font-size:11px">
                    <?php 
								$qmajor = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid=(SELECT cmajor FROM rockinus.user_edu_info WHERE uname='$loopname');");
									if(!$qmajor) die(mysql_error());
									$o = mysql_fetch_object($qmajor);
									$major_name = $o->major_name;
									if( strlen($major_name)>0 && $major_name!=NULL )
										//echo("$major_name");
									;
									//else 
										//echo("Joined@".getDateName($pdate));
								?>
                    </font><a href="SendMessage.php?recipient=<?php echo($loopname) ?>">
                    <?php
								echo("<div style='background-image:url(img/master.png); display:inline; border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; border-left:1px solid #DDDDDD; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px; cursor:pointer'>+ Message</div>")
								?>
                    </a>
                    <?php
					if($rel_rstatus=="N")echo("&nbsp;<div style='background-image:url(img/master.png); display:inline; border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; border-left:1px solid #DDDDDD; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px; cursor:pointer' class='addFriendDiv$loopname' id='addFriendDiv$loopname' align='center'>+ Friend</div>");
					if($rel_rstatus=="S")echo("&nbsp;<a href='EditEduInfo.php'><div style='background-image:url(img/master.jpg); display:inline; border:1px solid #999999; border-top:1px solid #CCCCCC; border-left:1px solid #CCCCCC; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px; cursor:pointer'>+ Edit</div></a>&nbsp;");
					else if($rel_rstatus=="P")echo("&nbsp;<div style='background-image:url(img/master.png); display:inline; border:1px #DDDDDD solid; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px'>Requested</div>");
					else if($rel_rstatus=="A"){
						echo(" <font color=#999999 style='font-size:11px'>(Friend)</font>");
					}?>
                    <span id="flashAddFriend<?php echo($loopname) ?>" class="flashAddFriend<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span> <span id="addFriendResult<?php echo($loopname) ?>" class="addFriendResult<?php echo($loopname) ?>" style=' display:none; background: #EEEEEE; border:1px #DDDDDD solid; padding:2 6 2 6; height:15px; color:#000000; font-size:11px' align='center'></span> 
				</td>
              </tr>
            </table>
          </div>
          <?php 
		}else{
		?>
          <div style=" background-image: ; background-color:; margin-top:0; margin-bottom:<?php if($j==5)echo("0"); else echo("0")?>; border-left:0px solid #DDDDDD; border-right:0px solid #DDDDDD; padding-top:0; padding-bottom: 0; border-bottom:<?php if($j==5)echo("0"); else echo("1")?>px dashed #DDDDDD" onMouseOver="this.style.backgroundColor='#EEEEEE';" onMouseOut=" this.style.backgroundColor='#FFFFFF';">
            <table width="180" height="70" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="55" rowspan="5" valign="top" style="padding:5 10 5 3"><?php
									 echo("<img src=img/NoUserIcon100.jpg width=55px />");
							  ?></td>
                <td width="275" height="25" align="left" valign="top" style="padding-left:5; padding-top:5px; font-size:13px"><?php
							  	echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]><strong>$popular_fname $popular_lname</strong></font></a>");	
								//echo(" has joined the network");
									$pieces = explode('@', $id);
									if(stristr($pieces[1],'poly')==true) echo("<font color=#666666 style='font-size:11px'> (NYU-Poly) ($points points)</font>");
									else {
										$pieces_2 = explode('.', $pieces[1]);
										$len = count($pieces_2[1])-1;
										echo("&nbsp;<font color=#666666 style='font-size:11px'>(".strtoupper($pieces_2[$len]).") ($points points)</font>");
										//else echo($id);
									}
								?>
                  &nbsp; </td>
              </tr>
              <tr>
                <td height="25" valign="top" style="padding-left:5; padding-top:5px;"><font color="#666666" style="font-size:11px; font-family:Arial, Helvetica, sans-serif">
                  <?php 
								$qmajor = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid=(SELECT cmajor FROM rockinus.user_edu_info WHERE uname='$loopname');");
									if(!$qmajor) die(mysql_error());
									$o = mysql_fetch_object($qmajor);
									$major_name = $o->major_name;
									if( strlen($major_name)>0 && $major_name!=NULL )
										echo("$major_name");
									else 
										echo("Joined@".getDateName($pdate));
								?>
                </font></td>
              </tr>
              <tr>
                <td height="25" valign="top" style=" padding-left:5; padding-top:3px;"><a href="main_sendMsg.php?recipient=<?php echo($loopname) ?>">
                  <?php
								echo("<div style='background-image:url(img/master.png); display:inline; border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; border-left:1px solid #DDDDDD; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px; cursor:pointer'>+ Message</div>")
								?>
                </a></td>
              </tr>
            </table>
          </div>
          <?php 
		}
		}
		?>
        </div>
      <div class="activePeopleDiv_2" id="activePeopleDiv_2">
          <?php
		$sql_stmt = "SELECT a.email, a.uname, a.status, a.signup_date, a.signup_time, c.fname, c.lname, b.points, MAX(b.points) as points_2
					FROM rockinus.user_check_info a JOIN rockinus.user_points b JOIN rockinus.user_info c 
					ON a.status='A' AND a.uname=b.uname 
					AND a.uname=c.uname	AND a.uname<>'harvey'
					GROUP BY b.uname 
					ORDER BY points_2 DESC LIMIT 6, 5";
					//echo($sql_stmt);
		mysql_query("SET NAMES GBK");
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($no_row == 0) echo("");
		$j=5;
		$k=5;
		while($object = mysql_fetch_object($q)){
			$j++;
			$k++;
			$loopname = $object->uname;	
			$popular_fname = $object->fname;	
			$popular_lname = $object->lname;			
			$pdate = $object->signup_date;
			$ptime = $object->signup_time;
			$id = $object->email;
			$action = $object->status;
			$points_2 = $object->points_2;
			
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
			
			$loopImg = "upload/$loopname/$loopname"."60.jpg";
			if(file_exists($loopImg)){
			?>
          <script type="text/javascript">
$(function() {
	$(".addFriendDiv<?php echo($loopname) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var recipient = '<?php echo($loopname) ?>';
		var dataString = 'sender='+sender+'&&recipient='+recipient; 
		//alert("dataString");
		
		$("#addFriendDiv<?php echo($loopname) ?>").hide();
		$("#flashAddFriend<?php echo($loopname) ?>").show();
		$("#flashAddFriend<?php echo($loopname) ?>").fadeIn(400).html('<img src="img/loading42.gif" width="90" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_frequest.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashAddFriend<?php echo($loopname) ?>").hide();
				$("#addFriendResult<?php echo($loopname) ?>").html(html);
				$("#addFriendResult<?php echo($loopname) ?>").show();
			}
 		});
 		return false;
 	});
 });
      </script>
          <div style=" background-image: ; background-color:; margin-top:0; margin-bottom:<?php if($j==5)echo("0"); else echo("0")?>; border-left:0px solid #DDDDDD; border-right:0px solid #DDDDDD; padding-top:0; padding-bottom: 0; border-bottom:<?php if($j==5)echo("0"); else echo("1")?>px dashed #DDDDDD" >
            <table width="180" height="70" border="0" cellpadding="0" cellspacing="0" style="margin-top:0">
              <tr>
                <td width="55" height="70" rowspan="3" align="left" valign="top" style=" padding-left:3"><div style="background: url(<?php echo($loopImg); ?>); background-repeat:no-repeat; margin:5 10 5 0; width:55; height:55">&nbsp;</div></td>
                <td width="275" align="left" valign="top" style="padding-left:0px; padding-top:5px; padding-bottom:3; line-height:150%; font-size:13px"><?php
							  	echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]><strong>$popular_fname $popular_lname</strong></font></a>");	
								//echo(" has joined the network");
								?>
                    <br>
                    <font style="font-size:12px; font-weight:bold"; color="#B92828"><?php echo("<em>No.".$j."</em>") ?></font>
                    <?php	
									$pieces = explode('@', $id);
									if(stristr($pieces[1],'poly')==true) 
										//echo("<font color=#666666 style='font-size:11px'> (NYU-Poly) ($points points)</font>");
										echo("<font color=#666666 style='font-size:11px'> ($points points)</font>");
									else {
										$pieces_2 = explode('.', $pieces[1]);
										$len = count($pieces_2[1])-1;
										echo("&nbsp;<font color=#666666 style='font-size:11px'>(".strtoupper($pieces_2[$len]).") ($points points)</font>");
										//else echo($id);
									}
								?>
                    <br />
                    <font color="#666666" style="font-size:11px">
                    <?php 
								$qmajor = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid=(SELECT cmajor FROM rockinus.user_edu_info WHERE uname='$loopname');");
									if(!$qmajor) die(mysql_error());
									$o = mysql_fetch_object($qmajor);
									$major_name = $o->major_name;
									if( strlen($major_name)>0 && $major_name!=NULL )
										//echo("$major_name");
									;
									//else 
										//echo("Joined@".getDateName($pdate));
								?>
                    </font><a href="SendMessage.php?recipient=<?php echo($loopname) ?>">
                    <?php
								echo("<div style='background-image:url(img/master.png); display:inline; border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; border-left:1px solid #DDDDDD; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px; cursor:pointer'>+ Message</div>")
								?>
                    </a>
                    <?php
					if($rel_rstatus=="N")echo("&nbsp;<div style='background-image:url(img/master.png); display:inline; border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; border-left:1px solid #DDDDDD; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px; cursor:pointer' class='addFriendDiv$loopname' id='addFriendDiv$loopname' align='center'>+ Friend</div>");
					if($rel_rstatus=="S")echo("&nbsp;<a href='EditEduInfo.php'><div style='background-image:url(img/master.jpg); display:inline; border:1px solid #999999; border-top:1px solid #CCCCCC; border-left:1px solid #CCCCCC; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px; cursor:pointer'>+ Edit</div></a>&nbsp;");
					else if($rel_rstatus=="P")echo("&nbsp;<div style='background-image:url(img/master.png); display:inline; border:1px #DDDDDD solid; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px'>Requested</div>");
					else if($rel_rstatus=="A"){
						echo(" <font color=#999999 style='font-size:11px'>(Friend)</font>");
					}?>
                    <span id="flashAddFriend<?php echo($loopname) ?>" class="flashAddFriend<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span> <span id="addFriendResult<?php echo($loopname) ?>" class="addFriendResult<?php echo($loopname) ?>" style=' display:none; background: #EEEEEE; border:1px #DDDDDD solid; padding:2 6 2 6; height:15px; color:#000000; font-size:11px' align='center'></span> </td>
              </tr>
            </table>
          </div>
        <?php 
		}else{
		?>
        <div style=" background-image: ; background-color:; margin-top:0; margin-bottom:<?php if($j==5)echo("0"); else echo("0")?>; border-left:0px solid #DDDDDD; border-right:0px solid #DDDDDD; padding-top:0; padding-bottom: 0; border-bottom:<?php if($j==5)echo("0"); else echo("1")?>px dashed #DDDDDD" onMouseOver="this.style.backgroundColor='#EEEEEE';" onMouseOut=" this.style.backgroundColor='#FFFFFF';">
          <table width="180" height="70" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="55" rowspan="5" valign="top" style="padding:5 10 5 3"><?php
									 echo("<img src=img/NoUserIcon100.jpg width=55px />");
							  ?></td>
              <td width="275" height="25" align="left" valign="top" style="padding-left:5; padding-top:5px; font-size:13px"><?php
							  	echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]><strong>$popular_fname $popular_lname</strong></font></a>");	
								//echo(" has joined the network");
									$pieces = explode('@', $id);
									if(stristr($pieces[1],'poly')==true) echo("<font color=#666666 style='font-size:11px'> (NYU-Poly) ($points points)</font>");
									else {
										$pieces_2 = explode('.', $pieces[1]);
										$len = count($pieces_2[1])-1;
										echo("&nbsp;<font color=#666666 style='font-size:11px'>(".strtoupper($pieces_2[$len]).") ($points points)</font>");
										//else echo($id);
									}
								?>
                &nbsp; </td>
            </tr>
            <tr>
              <td height="25" valign="top" style="padding-left:5; padding-top:5px;"><font color="#666666" style="font-size:11px; font-family:Arial, Helvetica, sans-serif">
                <?php 
								$qmajor = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid=(SELECT cmajor FROM rockinus.user_edu_info WHERE uname='$loopname');");
									if(!$qmajor) die(mysql_error());
									$o = mysql_fetch_object($qmajor);
									$major_name = $o->major_name;
									if( strlen($major_name)>0 && $major_name!=NULL )
										echo("$major_name");
									else 
										echo("Joined@".getDateName($pdate));
								?>
              </font></td>
            </tr>
            <tr>
              <td height="25" valign="top" style=" padding-left:5; padding-top:3px;"><a href="main_sendMsg.php?recipient=<?php echo($loopname) ?>">
                <?php
								echo("<div style='background-image:url(img/master.png); display:inline; border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; border-left:1px solid #DDDDDD; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px; cursor:pointer'>+ Message</div>")
								?>
              </a></td>
            </tr>
          </table>
        </div>
        <?php 
		}
		}
		?>
      </div></td>
  </tr>
</table>