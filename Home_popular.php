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
<table width="760" height="157" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:15;">
  <tr>
    <td width="285" valign="top"><table width="287" height="85" border="0" cellpadding="0" cellspacing="0" style="border-left:0px solid #DDDDDD; border-right:0px solid #DDDDDD; border-bottom:1px solid #DDDDDD">
      <tr>
        <td width="287" height="85" valign="top">
		<table width="287" height="27" border="0" cellpadding="0" cellspacing="0" style=" border-bottom:1px solid #666666; border-top:1px solid #DDDDDD; border-right:1px solid #DDDDDD; background: ; ">
            <tr>
              <td width="183" height="27" align="left" background="img/master.jpg" style="font-size:14px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; padding-left:5; padding-top:; color: #000000">Highlight People </td>
              <td width="103" height="27" align="right" background="img/master.jpg" style="font-size:11px; font-weight:bold; padding-right:10; padding-top:; color:"><div class="showActivePeople_1" id="showActivePeople_1" style="font-size:11px; cursor:pointer"> <img src="img/arrow_right.png" width="10" /> Show Next 5</div>
                <div class="showActivePeople_2" id="showActivePeople_2" style="font-size:11px; cursor:pointer; display:none"> <img src="img/arrow_right.png" width="10" /> Show Top 5</div></td>
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
              <div style=" background-image: ; background-color:#F5F5F5; margin-top:0; margin-bottom:<?php if($j==5)echo("0"); else echo("0")?>; border-left:0px solid #DDDDDD; border-right:0px solid #DDDDDD; padding-top:0; padding-bottom: 0; border-bottom:<?php if($j==5)echo("0"); else echo("1")?>px dashed #DDDDDD" >
                <table width="285" height="70" border="0" cellpadding="0" cellspacing="0" style="margin-top:0">
                  <tr>
                    <td width="55" height="70" rowspan="3" align="left" valign="top" style=" padding-left:5"><div style="background: url(<?php echo($loopImg); ?>); background-repeat:no-repeat; margin:10; margin-left:0; width:55; height:55">&nbsp;</div></td>
                    <td width="275" align="left" valign="top" style="padding-left:0px; padding-top:8px; padding-bottom:10; line-height:150%; font-size:12px"><?php
							  	echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor]><strong>$popular_fname $popular_lname</strong></font></a>");	
								//echo(" has joined the network");
									$pieces = explode('@', $id);
									if(stristr($pieces[1],'poly')==true) echo("<font color=#666666 style='font-size:11px'> (NYU-Poly) ($points score)</font>");
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
										echo("$major_name");
									else 
										echo("Joined@".getDateName($pdate)." | ".substr($ptime,0,5));
								?>
                        </font><a href="SendMessage.php?recipient=<?php echo($loopname) ?>"><br />
                        <?php
								echo("<div style='background-image:url(img/master.png); display:inline; border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; border-left:1px solid #DDDDDD; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px; cursor:pointer'>+ Message</div>")
								?>
                        </a>
                        <?php
					if($rel_rstatus=="N")echo("&nbsp;<div style='background-image:url(img/master.png); display:inline; border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; border-left:1px solid #DDDDDD; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px; cursor:pointer' class='addFriendDiv$loopname' id='addFriendDiv$loopname' align='center'>+ Friend</div>");
					if($rel_rstatus=="S")echo("&nbsp;<a href='EditEduInfo.php'><div style='background-image:url(img/master.jpg); display:inline; border:1px solid #999999; border-top:1px solid #CCCCCC; border-left:1px solid #CCCCCC; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px; cursor:pointer'>+ Edit</div></a>&nbsp;");
					else if($rel_rstatus=="P")echo("&nbsp;<div style='background-image:url(img/master.png); display:inline; border:1px #DDDDDD solid; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px'>Requested</div>");
					else if($rel_rstatus=="A"){
						echo("&nbsp; <font color=#999999 style='font-size:12px'>(Your friend)</font>");
					}?>
                        <span id="flashAddFriend<?php echo($loopname) ?>" class="flashAddFriend<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span> <span id="addFriendResult<?php echo($loopname) ?>" class="addFriendResult<?php echo($loopname) ?>" style=' display:none; background: #EEEEEE; border:1px #DDDDDD solid; padding:2 6 2 6; height:15px; color:#000000; font-size:11px' align='center'></span> <font style="font-size:12px; font-weight:bold"; color="<?php echo($_SESSION['hcolor']) ?>"><?php echo("<em>&nbsp;&nbsp;No.".$j."</em>") ?></font></td>
                  </tr>
                </table>
              </div>
              <?php 
		}else{
		?>
              <div style=" background-image: ; background-color:#F5F5F5; margin-top:0; margin-bottom:<?php if($j==5)echo("0"); else echo("0")?>; border-left:0px solid #DDDDDD; border-right:0px solid #DDDDDD; padding-top:0; padding-bottom: 0; border-bottom:<?php if($j==5)echo("0"); else echo("1")?>px dashed #DDDDDD" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
                <table width="285" height="70" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="55" rowspan="5" valign="top" style="padding:5 5 10 5">
					<?php
									 echo("<img src=img/NoUserIcon100.jpg width=55px />");
							  ?></td>
                    <td width="275" height="25" align="left" valign="top" style="padding-left:5; padding-top:5px; font-size:14px"><?php
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
										echo("Joined@".getDateName($pdate)." | ".substr($ptime,0,5));
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
		$j=0;
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
              <div style=" background-image: ; background-color:#FFFFFF; margin-top:0; margin-bottom:<?php if($j==5)echo("0"); else echo("0")?>; padding-left:0; padding-top:0; padding-bottom: ; border:0px #EEEEEE solid; border-bottom:<?php if($j==5)echo("0"); else echo("1")?>px solid #DDDDDD" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
                <table width="285" height="70" border="0" cellpadding="0" cellspacing="0" style="margin-top:0">
                  <tr>
                    <td width="55" height="70" rowspan="3" align="left" valign="top" style=" padding-left:5"><div style="background: url(<?php echo($loopImg); ?>); background-repeat: no-repeat; margin:10; margin-left:0; width:55; height:55">&nbsp;</div></td>
                    <td width="275" align="left" valign="top" style="padding-left:5; padding-top:8px; padding-bottom:10; line-height:150%; font-size:12px"><?php
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
                        <br />
                        <font color="#666666" style="font-size:11px">
                        <?php 
								$qmajor = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid=(SELECT cmajor FROM rockinus.user_edu_info WHERE uname='$loopname');");
									if(!$qmajor) die(mysql_error());
									$o = mysql_fetch_object($qmajor);
									$major_name = $o->major_name;
									if( strlen($major_name)>0 && $major_name!=NULL )
										echo("$major_name");
									else 
										echo("Joined@".getDateName($pdate)." | ".substr($ptime,0,5));
								?>
                        </font><a href="SendMessage.php?recipient=<?php echo($loopname) ?>"><br />
                        <?php
								echo("<div style='background-image:url(img/master.png); display:inline; border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; border-left:1px solid #DDDDDD; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px; cursor:pointer'>+ Message</div>")
								?>
                        </a>
                        <?php
					if($rel_rstatus=="N")echo("&nbsp;<div style='background-image:url(img/master.png); display:inline; border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; border-left:1px solid #DDDDDD; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px; cursor:pointer' class='addFriendDiv$loopname' id='addFriendDiv$loopname' align='center'>+ Friend</div>");
					if($rel_rstatus=="S")echo("&nbsp;<a href='EditEduInfo.php'><div style='background-image:url(img/master.jpg); display:inline; border:1px solid #999999; border-top:1px solid #CCCCCC; border-left:1px solid #CCCCCC; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px; cursor:pointer'>+ Edit</div></a>&nbsp;");
					else if($rel_rstatus=="P")echo("&nbsp;<div style='background-image:url(img/master.png); display:inline; border:1px #DDDDDD solid; padding:2 6 2 6; margin-top:5px; height:18px; line-height:120%; color:#333333; font-size:11px'>Requested</div>");
					else if($rel_rstatus=="A"){
						echo("&nbsp; <font color=#999999 style='font-size:12px'>(Your friend)</font>");
					}?>
                        <span id="flashAddFriend<?php echo($loopname) ?>" class="flashAddFriend<?php echo($loopname) ?>" style=" display:none; width:100; padding-right:5"></span> <span id="addFriendResult<?php echo($loopname) ?>" class="addFriendResult<?php echo($loopname) ?>" style=' display:none; background: #EEEEEE; border:1px #DDDDDD solid; padding:2 6 2 6; height:15px; color:#000000; font-size:11px' align='center'></span> <font style="font-size:12px; font-weight:bold"; color="<?php echo($_SESSION['hcolor']) ?>"><?php echo("<em>&nbsp;&nbsp;No.".$k."</em>") ?></font></td>
                  </tr>
                </table>
              </div>
            <?php 
		}else{
		?>
              <div style=" background-image: ; background-color:#F5F5F5; margin-top:0; margin-bottom:<?php if($j==5)echo("0"); else echo("0")?>; padding-left:0; padding-top:0; padding-bottom: 0; border:0px #EEEEEE solid; border-bottom:<?php if($j==5)echo("0"); else echo("1")?>px solid #DDDDDD" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
                <table width="285" height="70" border="0" cellpadding="0" cellspacing="0" style="margin-top:5">
                  <tr>
                    <td width="55" rowspan="5" valign="top" style="padding: 5 5 10 5"><?php
									 echo("<img src=img/NoUserIcon100.jpg width=55 />");
							  ?></td>
                    <td width="275" height="25" align="left" valign="top" style="padding-left:5; padding-top:5; font-size:12px"><?php
							  	echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=#000000><strong>$popular_fname $popular_lname</strong></font></a>");	
								//echo(" has joined the network");
									$pieces = explode('@', $id);
									if(stristr($pieces[1],'poly')==true) echo("<font color=#666666 style='font-size:12px'> (NYU-Poly) ($points_2 score)</font>");
									else {
										$pieces_2 = explode('.', $pieces[1]);
										$len = count($pieces_2[1])-1;
										echo("&nbsp;<font color=#666666 style='font-size:12px'>(".strtoupper($pieces_2[$len]).") ($points_2 points)</font>");
									}
								?>
                      &nbsp; </td>
                  </tr>
                  <tr>
                    <td height="25" valign="top" style="padding-left:5; padding-top:5px;"><font color="#666666" style="font-size:11px">
                      <?php 
								$qmajor = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid=(SELECT cmajor FROM rockinus.user_edu_info WHERE uname='$loopname');");
									if(!$qmajor) die(mysql_error());
									$o = mysql_fetch_object($qmajor);
									$major_name = $o->major_name;
									if( strlen($major_name)>0 && $major_name!=NULL )
										echo("$major_name");
									else 
										echo("Joined@".getDateName($pdate)." | ".substr($ptime,0,5));
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
    </table>    </td>
    <td width="14" valign="top" style="background-color:">&nbsp;</td>
    <td width="285" valign="top"><table width="285" height="149" border="0" cellpadding="0" cellspacing="0" style="border-left:0px solid #DDDDDD; border-top:1px solid #DDDDDD; border-bottom:1px #DDDDDD solid">
      <tr>
        <td width="177" height="27" align="left" background="img/master.jpg" style="font-size:14px; font-weight:bold; padding-left:10; padding-top:; font-family:Arial, Helvetica, sans-serif; background: ; color:#000000"> Most Active Courses</td>
        <td width="93" height="27" align="right" background="img/master.jpg" style="font-size:14px; font-weight:bold; padding-right:10px; padding-top:; background: ; color:"><div class="showActiveCourse_1" id="showActiveCourse_1" style="font-size:11px; cursor:pointer; font-weight:bold"><img src="img/arrow_right.png" width="10" /> Show Next 5</div>
          <div class="showActiveCourse_2" id="showActiveCourse_2" style="font-size:11px; cursor:pointer; display:none"><img src="img/arrow_right.png" width="10" /> Show Top 5</div></td>
      </tr>
      <tr>
        <td height="97" colspan="2" valign="top" style="border-top:1px solid #666666">
		<div class="activeCourseDiv_1" id="activeCourseDiv_1">
            <?php
		include 'dbconnect.php';
			
		$q = mysql_query("SELECT c.clicks, a.course_id, a.course_name, b.course_uid, a.mid, a.sid, b.pid, c.clicks AS sum_rst FROM rockinus.course_info a JOIN rockinus.unique_course_info b JOIN rockinus.course_clicks c JOIN rockinus.course_memo_info d ON a.course_id=b.course_id AND c.course_uid=b.course_uid AND b.course_uid=d.course_uid AND c.course_uid=d.course_uid GROUP BY b.course_uid ORDER BY sum_rst DESC LIMIT 0,5");
//echo($sql);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("No ranking now available");
$i=0;
while($object = mysql_fetch_object($q)){
	$i++;
	$pid = $object->pid;
	$mid = $object->mid;
	$sid = $object->sid;
	$clicks = $object->clicks;
	$course_id = $object->course_id;
	$course_uid = $object->course_uid;
	$course_name = $object->course_name;
	if(strlen($course_name)>40) $course_name = substr($course_name,0,36)."...";
	
	$q_m = mysql_query("SELECT major_name FROM rockinus.major_info where mid='$mid'");
	if(!$q_m) die(mysql_error());
	$no_row = mysql_num_rows($q_m);
	if($no_row == 0) $major_name = "Major Unsure";
	else{
		$object = mysql_fetch_object($q_m);
		$major_name = $object->major_name;
	}

	$q_course_comment = mysql_query("SELECT * FROM rockinus.course_memo_info where course_uid='$course_uid'");
	if(!$q_course_comment) die(mysql_error());
	$comment_num = mysql_num_rows($q_course_comment);
	
	$q_course_files = mysql_query("SELECT * FROM rockinus.user_file_info where course_uid='$course_uid'");
	if(!$q_course_files) die(mysql_error());
	$file_num = mysql_num_rows($q_course_files);
?>
            <div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:1; padding-bottom:; border-right:0px solid #CCCCCC; border-left:0px solid #CCCCCC; border-bottom:<?php if($i==5)echo("0"); else echo("1")?>px dashed #CCCCCC; background:#F5F5F5">
              <table width="285" height="70" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="285" rowspan="2" valign="top" style="padding:15px; padding:10 0 10 10; font-size:12px; line-height:150%"><script type="text/javascript">
$(function() {
	$(".subscribeDiv<?php echo($course_uid) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var course_uid = '<?php echo($course_uid) ?>';
		var dataString = 'sender='+sender+'&&course_uid='+course_uid; 
		//alert("dataString");
		
		$("#subscribeDiv<?php echo($course_uid) ?>").hide();
		$("#flashSubscribe<?php echo($course_uid) ?>").show();
		$("#flashSubscribe<?php echo($course_uid) ?>").fadeIn(400).html('<img src="img/loading42.gif" width="80" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_subsc_course.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashSubscribe<?php echo($course_uid) ?>").hide();
				$("#subscribeResult<?php echo($course_uid) ?>").html(html);
				$("#subscribeResult<?php echo($course_uid) ?>").show();
			}
 		});
 		return false;
 	});
 });
    </script>
                      <?php
							  	echo("<strong><em>$i</em>.&nbsp; <a href='CourseDetail.php?course_uid=$course_uid' class=one><font color=$_SESSION[hcolor] style='font-size:12px'>$course_name.$course_id</font></a></strong><br>");
							  ?>
                      <?php
							  	echo("<font color=#666666 style='font-size:11px'>$pid - <a href='MajorDetail.php?sid=$sid&&mtype=Master&&mid=$mid' class=one>$major_name</a></font><br>");
							  ?>
                      <?php 
					echo("<font color=$_SESSION[hcolor] style='font-size:11px'>$clicks</font> <em>clicks</em>, <font color=$_SESSION[hcolor]  style='font-size:11px'>$comment_num</font> comments, <font color=$_SESSION[hcolor] style='font-size:11px'>$file_num</font> files");
					$q_uid = mysql_query("SELECT * FROM rockinus.user_course_info WHERE uname='$uname' AND course_uid='$course_uid'");
					if(!$q_uid) die(mysql_error());
					$no_row_uid = mysql_num_rows($q_uid);
					if($no_row_uid == 0){
						echo("&nbsp; <span class='subscribeDiv$course_uid' id='subscribeDiv$course_uid' style='height:14; padding:2 6 2 6; background: url(img/master.png); border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; border-left:1px solid #DDDDDD; line-height:120%; font-size:11px; cursor:pointer; color:#000000; display:inline' align='center'>+ Subscribe</span>");
					}else{
						echo("&nbsp; <span style='height:14; padding:2 6 2 6; background: ; border:0px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:11px; color:$_SESSION[hcolor]; line-height:120%; display:inline;font-weight:bold' align='center'>(Subscribed)</span>");
					} ?>
                      <span id="flashSubscribe<?php echo($course_uid) ?>" class="flashSubscribe<?php echo($course_uid) ?>" style=" display:none; width:100; padding-right:5"></span> <span id="subscribeResult<?php echo($course_uid) ?>" class="subscribeResult<?php echo($course_uid) ?>" style='display:none'></span> </td>
                </tr>
              </table>
            </div>
          <?php } ?>
          </div>
            <div class="activeCourseDiv_2" id="activeCourseDiv_2">
              <?php
		include 'dbconnect.php';
			
		$q = mysql_query("SELECT c.clicks, a.course_name, b.course_uid, a.mid, a.sid, b.pid, c.clicks AS sum_rst FROM rockinus.course_info a JOIN rockinus.unique_course_info b JOIN rockinus.course_clicks c JOIN rockinus.course_memo_info d ON a.course_id=b.course_id AND c.course_uid=b.course_uid AND b.course_uid=d.course_uid AND c.course_uid=d.course_uid GROUP BY b.course_uid ORDER BY sum_rst DESC LIMIT 5,5");
//echo($sql);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("No ranking now available");
$i=5;
while($object = mysql_fetch_object($q)){
	$i++;
	$pid = $object->pid;
	$mid = $object->mid;
	$sid = $object->sid;
	$clicks = $object->clicks;
	$course_uid = $object->course_uid;
	$course_name = $object->course_name;
	if(strlen($course_name)>40) $course_name = substr($course_name,0,36)."...";
	
	$q_m = mysql_query("SELECT major_name FROM rockinus.major_info where mid='$mid'");
	if(!$q_m) die(mysql_error());
	$no_row = mysql_num_rows($q_m);
	if($no_row == 0) $major_name = "Major Unsure";
	else{
		$object = mysql_fetch_object($q_m);
		$major_name = $object->major_name;
	}

	$q_course_comment = mysql_query("SELECT * FROM rockinus.course_memo_info where course_uid='$course_uid'");
	if(!$q_course_comment) die(mysql_error());
	$comment_num = mysql_num_rows($q_course_comment);
	
	$q_course_files = mysql_query("SELECT * FROM rockinus.user_file_info where course_uid='$course_uid'");
	if(!$q_course_files) die(mysql_error());
	$file_num = mysql_num_rows($q_course_files);
?>
              <div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:0; padding-bottom:1; border-right:0px solid #CCCCCC; border-left:0px solid #CCCCCC; border-bottom:<?php if($i==5)echo("0"); else echo("1")?>px #CCCCCC dashed; background:#F5F5F5">
                <table width="285" height="70" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="345" rowspan="2" valign="top" style="padding:15px; padding:10 0 10 10; font-size:12px; line-height:150%">
					<script type="text/javascript">
$(function() {
	$(".subscribeDiv<?php echo($course_uid) ?>").click(function() {
		var sender = '<?php echo($uname) ?>';
		var course_uid = '<?php echo($course_uid) ?>';
		var dataString = 'sender='+sender+'&&course_uid='+course_uid; 
		//alert("dataString");
		
		$("#subscribeDiv<?php echo($course_uid) ?>").hide();
		$("#flashSubscribe<?php echo($course_uid) ?>").show();
		$("#flashSubscribe<?php echo($course_uid) ?>").fadeIn(400).html('<img src="img/loading42.gif" width="80" align="absmiddle">');
 
		$.ajax({
			type: "POST",
			url: "ajax_subsc_course.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#flashSubscribe<?php echo($course_uid) ?>").hide();
				$("#subscribeResult<?php echo($course_uid) ?>").html(html);
				$("#subscribeResult<?php echo($course_uid) ?>").show();
			}
 		});
 		return false;
 	});
 });
                </script>
                        <?php
							  	echo("<strong><em>$i</em>.&nbsp; <a href='CourseDetail.php?course_uid=$course_uid' class=one><font color=$_SESSION[hcolor] style='font-size:12px'>$course_name.$course_id</font></a></strong><br>");
							  ?>
                        <?php
							  	echo("<font color=#666666 style='font-size:11px'>$pid - <a href='MajorDetail.php?sid=$sid&&mtype=Master&&mid=$mid' class=one>$major_name</a></font><br>");
							  ?>
                        <?php 
					echo("<font color=$_SESSION[hcolor] style='font-size:11px'>$clicks</font> <em>clicks</em>, <font color=$_SESSION[hcolor]  style='font-size:11px'>$comment_num</font> comments, <font color=$_SESSION[hcolor] style='font-size:11px'>$file_num</font> files");
					$q_uid = mysql_query("SELECT * FROM rockinus.user_course_info WHERE uname='$uname' AND course_uid='$course_uid'");
					if(!$q_uid) die(mysql_error());
					$no_row_uid = mysql_num_rows($q_uid);
					if($no_row_uid == 0){
						echo("&nbsp; <span class='subscribeDiv$course_uid' id='subscribeDiv$course_uid' style='height:14; padding:2 6 2 6; background: url(img/master.png); border:1px solid #CCCCCC; border-top:0px solid #DDDDDD; border-left:1px solid #DDDDDD; line-height:120%; font-size:11px; cursor:pointer; color:#000000; display:inline' align='center'>+ Subscribe</span>");
					}else{
						echo("&nbsp; <span style='height:14; padding:2 4 2 4; background: ; border:0px solid #DDDDDD; border-top:0px solid #DDDDDD; font-size:11px; color:$_SESSION[hcolor]; line-height:120%; display:inline; font-weight:bold' align='center'>(Subscribed)</span>");
					} ?>
                        <span id="flashSubscribe<?php echo($course_uid) ?>" class="flashSubscribe<?php echo($course_uid) ?>" style=" display:none; width:100; padding-right:5"></span> <span id="subscribeResult<?php echo($course_uid) ?>" class="subscribeResult<?php echo($course_uid) ?>" style='display:none'></span> </td>
                  </tr>
                </table>
              </div>
              <?php } ?>
          </div></td>
      </tr>
    </table></td>
    <td width="14" valign="top">&nbsp;</td>
    <td width="162" valign="top" align="left">
	<div style="height:413;overflow-x:hidden;overflow-y:hidden;" align="left">
				<?php include "HomeUserUpdate.php"; ?>
	  </div>
	</td>
  </tr>
</table>
