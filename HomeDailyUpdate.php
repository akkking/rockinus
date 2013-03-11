<table width="670" height="85" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="663" height="85" valign="top" ><?php
			include 'dbconnect.php';
			include 'Allfuc.php';
			
			$sel_count = "
SELECT sum(total) as cnt FROM (
	SELECT count(*) as total FROM rockinus.user_check_info  
	UNION 
	SELECT count(*) as total FROM rockinus.house_info 
	UNION 
	SELECT count(*) as total FROM rockinus.article_info 
	UNION 
	SELECT count(*) as total FROM rockinus.course_memo_info 
	UNION 
	SELECT count(*) as total FROM rockinus.event_info
	UNION 
	SELECT count(*) as total FROM rockinus.memo_info 
	UNION 
	SELECT count(*) as total FROM rockinus.rocker_rel_info 
) as cnt";

$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

	$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 40;
	$page= (isset($_GET["page"]))? $_GET["page"] : 1;
	if((!$limit) || (is_numeric($limit) == false)|| ($limit < 40) || ($limit > 50)) 
		$limit = 1; //default
	
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
		$page = 1; //default 

	$next_page = $page + 1;
	$div_id = "myDiv".$page;
	$total_pages = ceil($total_items / $limit);
	$set_limit = ($page * $limit) - $limit;
						
	//				echo("set_limit=".$set_limit);
	//				echo("limit=".$limit);
	//				echo("page=".$page);
		$sql_stmt = "SELECT email,uname, NULL as col_1,status, signup_date,signup_time,tbname, NULL as col_2, NULL as col_3, NULL as col_4, NULL as col_5, NULL as col_6, NULL as col_7 
					FROM rockinus.user_check_info a WHERE a.status='A'
					UNION 
					SELECT foid,creater,subject,NULL,pdate,ptime,'forum_info', category, NULL, NULL, NULL, NULL, descrip 
					FROM rockinus.forum_info b 
					UNION 
					SELECT hid,uname,subject,rentlease,pdate,ptime,tbname, type, city, rate, NULL, NULL, descrip 
					FROM rockinus.house_info c 
					UNION 
					SELECT aid,uname,subject,buysale,pdate,ptime,tbname,aname,city,rate,delivery,type, descrip 
					FROM rockinus.article_info d  
					UNION 
					SELECT course_uid, sender, descrip, rating, pdate, ptime, tbname, NULL, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.course_memo_info e 
					UNION 
					SELECT eid, creater, eventTitle, descrip, pdate, ptime, tbname, eventSpot, eventType,NULL, NULL, NULL, NULL 
					FROM rockinus.event_info f 
					UNION 
					SELECT NULL, sender, recipient, NULL, pdate, ptime, 'rocker_rel_info', NULL, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.rocker_rel_info g 
					ORDER BY signup_date DESC, signup_time DESC LIMIT $set_limit, $limit";
					//echo($sql_stmt);
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($no_row == 0) echo("");
		while($object = mysql_fetch_object($q)){
			$loopname = $object->uname;		
			$tbname = $object->tbname;			
			$pdate = $object->signup_date;
			$ptime = $object->signup_time;
			$id = $object->email;
			$subject = $object->col_1;
			$subject = str_replace("\\","",nl2br($subject));
			$aname = $object->col_2;
			$city = $object->col_3;
			$rate = $object->col_4;
			$delivery = $object->col_5;
			$type = $object->col_6;
			$descrip = $object->col_7;
			$descrip = str_replace("\\","",nl2br($descrip));
			$action = $object->status;
			if(strlen($subject)>50) $subject = substr(trim($subject), 0, 400)."...";
			if($tbname=="user_check_info"){
			?>
                <div style="margin-top:0px; margin-bottom:0px; padding-left:0; padding-top:5px; padding-bottom: 5px; border-bottom:0px #DDDDDD solid">
                  <table width="670" height="25" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="630" height="25" align="left" valign="top" style="padding-left:5px; padding-top:5px; font-size:14px"><?php
							  if($tbname=="user_check_info") 
							  	echo("<strong>[New Student]</strong>&nbsp;&nbsp;<a href=NewFreeUser.php?uid=$loopname class=one><font color=#000000>$loopname</font></a>");	
								?>
								<font color="#666666" style="font-size:12px">       
								<?php 
							  	if($tbname=="user_check_info"){
									$pieces = explode('@', $id);
									
									$qmajor = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid=(SELECT cmajor FROM rockinus.user_edu_info WHERE uname='$loopname');");
									if(!$qmajor) die(mysql_error());
									$o = mysql_fetch_object($qmajor);
									$major_name = $o->major_name;
									if( strlen($major_name)>0 && $major_name!=NULL )
									echo("(".trim($major_name).")");
									
									} 
								?></font>
								<?php
								echo(" joined the network");
								?>
                        &nbsp; </td>
                      <td width="130" height="25" align="right" valign="top" style="padding-right:10px; padding-top:5px; font-size:12px">
                        <?php
							  echo(getDateName($pdate)." | ".substr($ptime,0,5));
							  ?>                      </td>
                    </tr>
                  </table>
                </div>
              <?php 
							}else if($tbname=="rocker_rel_info"){
			?>
                <div style="margin-top:0px; margin-bottom:0px; padding-left:0; padding-top:5px; padding-bottom: 5px; border-bottom:0px #DDDDDD solid">
                  <table width="670" height="30" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="630" height="18" align="left" style="padding-left:5px;"><?php
							  echo("<strong>[Friendship]</strong>&nbsp;&nbsp;<a href=NewFreeUser.php?uid=$loopname class=one>$loopname</a> and <a href=NewFreeUser.php?uid=$subject class=one>$subject</a> are now friend");
							  ?></td>
                      <td width="130" height="18" align="right" valign="middle" style="padding-right:10px; font-size:12px">
                    <?php
						  echo(getDateName($pdate)." | ".substr($ptime,0,5));
					?>                      </td>
                    </tr>
                  </table>
                </div>
              <?php 
							}else if($tbname=="forum_info"){
							?>
<div style="margin-top:0px; margin-bottom:0px; padding-left:0; padding-top:5; padding-bottom:5; border-bottom:0px #DDDDDD solid ">
                  <table width="670" height="29" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="630" height="29" align="left" style="padding-left:5px; padding-top:5px; font-size:14px" valign="top"><?php 
										  echo("<strong>[Open Forum]</strong> <a href=NewFreeUser.php?uid=$loopname class=one><font color=#000000>$loopname</font></a> posted an open topic <font color=#666666 style='font-size:12px'>($aname)</font>");
							  ?>                      </td>
                      <td width="130" height="29" align="right" style="padding-right:10px; padding-top:5px; font-size:12px" valign="top">
					    <?php 
							echo(getDateName($pdate)." | ".substr($ptime,0,5));
						?>                      </td>
                    </tr>
        </table>
              </div>
              <?php 
							}else if($tbname=="house_info"){
							?>
                <div style="margin-top:0px; margin-bottom:0px; padding-left:0; padding-top:5; padding-bottom:5; border-bottom:0px #DDDDDD solid ">
                  <table width="670" height="26" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="630" height="30" align="left" style="padding-left:5px; font-size:14px">
					  <?php 
				echo("<strong>[$aname | $action]</strong>&nbsp;&nbsp;");
		echo("<a href=NewFreeHouse.php?hid=$id class=one>".substr($subject,0,50)." ...</a>");
							  ?>                      </td>
                      <td width="130" height="30" align="right" style="padding-right:10px; font-size:12px">
                        <?php 
										  echo(getDateName($pdate)." | ".substr($ptime,0,5));
							  ?>                      </td>
                    </tr>
                  </table>
                </div>
              <?php 
							}else if($tbname=="article_info"){
							?>
                <div style="margin-top:0px; margin-bottom:0px; padding-left:0; padding-top:5; padding-bottom:5px; border-bottom:0px #DDDDDD solid">
                  <table width="670" height="30" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="630" height="30" align="left" style="display:inline; padding-left:5px; border-bottom:0px #BBBBBB dotted; font-size:14px">
					  <?php 
							 echo("<strong><font color=#000000>[$aname | $action]</strong></font>&nbsp;&nbsp;<a href=NewFreeMarket.php?aid=$id class=one>".substr($subject,0,70)." ...</a>");
							  ?>                      </td>
                      <td width="130" height="30" align="right" valign="middle" style="display:inline; padding-right:10px; border-bottom:0px #BBBBBB dotted; font-size:12px">
					  <?php echo(getDateName($pdate)." | ".substr($ptime,0,5))?>					  </td>
                    </tr>
                  </table>
                </div>
              <?php }else if($tbname=="course_memo_info"){ 
						  		$memo_q = mysql_query("SELECT * FROM rockinus.course_info a JOIN rockinus.major_info b ON a.course_id=(SELECT course_id FROM rockinus.unique_course_info WHERE course_uid ='$id') AND a.mid=b.mid;");
								if(!$memo_q) die(mysql_error());
								$obj = mysql_fetch_object($memo_q); 
								$course_id = $obj->course_id;
								$course_name = $obj->course_name;
								$major_name = $obj->major_name;
						  ?>
                <div style="margin-top:0px; margin-bottom:0px; padding-left:0; padding-top:5; padding-bottom:5; border-bottom:0px #DDDDDD solid">
                  <table width="670" height="30" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="630" height="30" style="padding-left:5px; font-size:14px" align="left">
					  <?php
							  	echo("<strong>[Course comment]</strong> $course_id - $course_name");
							  ?></td>
                      <td width="130" height="30" align="right" style="padding-right:10px; font-size:12px">
					  <?php echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?>					  </td>
                    </tr>
                  </table>
                </div>
              <?php }else if($tbname=="event_info"){  ?>
                <div style="margin-top:0px; margin-bottom:0px; padding-left:0; padding-top:5; padding-bottom:5px; border-bottom:0px #DDDDDD solid">
                  <table width="670" height="30" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="630" height="30" style="padding-left:5px; font-size:14px" align="left"><?php echo("<strong>[Event]</strong>&nbsp;&nbsp;<a href='FreeTourEvent.php?eid=$id' class='one'>$subject</a> (posted by <a href=NewFreeUser.php?uid=$loopname class=one>$loopname</a>)") ?> </td>
                      <td width="130" height="30" align="right" style="padding-right:10px; font-size:12px">
					  <?php echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?>					  </td>
                    </tr>
                  </table>
                </div>
              <?php } }?>
            </td>
          </tr>
        </table>