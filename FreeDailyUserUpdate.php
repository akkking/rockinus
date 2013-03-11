<table width="330" height="85" border="0" cellpadding="0" cellspacing="0" style="border:0px solid #DDDDDD">
          <tr>
            <td width="663" height="85" valign="top" ><?php
			include 'dbconnect.php';
			include 'Allfuc.php';
			//include 'Allfuc.php';
			
			$sel_count = "SELECT count(*) as cnt FROM rockinus.user_check_info WHERE status='A'";

$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

	$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 25;
	$page= (isset($_GET["page"]))? $_GET["page"] : 1;
	if((!$limit) || (is_numeric($limit) == false)|| ($limit < 25) || ($limit > 50)) 
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
					
					ORDER BY signup_date DESC, signup_time DESC LIMIT $set_limit, $limit";
					//echo($sql_stmt);
		mysql_query("SET NAMES GBK");
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
			$aname = $object->col_2;
			$city = $object->col_3;
			$rate = $object->col_4;
			$delivery = $object->col_5;
			$type = $object->col_6;
			$descrip = $object->col_7;
			$action = $object->status;
			if(strlen($subject)>50) $subject = substr(trim($subject), 0, 400)."...";
			if($tbname=="user_check_info"){
			?>
                <div style=" background-image: ; background-color:#F5F5F5; margin-top:0; margin-bottom:10px; padding-left:0; padding-top:10px; padding-bottom: 15px; border:1px #EEEEEE solid; border-bottom:1px solid #CCCCCC">
                  <table width="330" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="55" rowspan="5" valign="top" bgcolor="" style="padding-top:5px; padding-right:5px; padding-bottom:10px; padding-left:15px"><?php
									$loopImg = "upload/$loopname/$loopname"."100.jpg";
							  if(file_exists($loopImg)) echo("<a href=main_user.php?uid=$loopname class=one><img src=$loopImg width=60px style='border:0px #666666 solid' /></a>");
							  else echo("<a href=main_user.php?uid=$loopname class=one><img src=img/NoUserIcon100.jpg width=60px /></a>");
							  ?></td>
                      <td width="275" height="25" align="left" valign="top" style="padding-left:10px; padding-top:5px; font-size:14px"><?php
							  if($tbname=="user_check_info") 
							  	echo("<a href=main_user.php?uid=$loopname class=one><font color=#000000>$loopname</font></a>");	
								//echo(" has joined the network");
																	$pieces = explode('@', $id);
									if(stristr($pieces[1],'poly')==true) echo("<font color=#666666 style='font-size:12px'> (from NYU-Poly)</font>");
									else {
										$pieces_2 = explode('.', $pieces[1]);
										$len = count($pieces_2[1])-1;
										echo("&nbsp;|&nbsp;&nbsp;<font color=#666666 style='font-size:12px'>(".strtoupper($pieces_2[$len]).")</font>");
										//else echo($id);
									}
								?> 								
                        &nbsp; </td>
                    </tr>
                    <tr>
                      <td height="25" valign="top" style="padding-left:10px; padding-top:5px;">
					  <font color="#666666" style="font-size:12px">       
								<?php 
							  	if($tbname=="user_check_info"){
									
									$qmajor = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid=(SELECT cmajor FROM rockinus.user_edu_info WHERE uname='$loopname');");
									if(!$qmajor) die(mysql_error());
									$o = mysql_fetch_object($qmajor);
									$major_name = $o->major_name;
									if( strlen($major_name)>0 && $major_name!=NULL )
										echo("$major_name");
									else 
										echo("Joined@".getDateName($pdate)." | ".substr($ptime,0,5));
									
									//$qsstatus = mysql_query("SELECT sstatus FROM rockinus.user_info WHERE uname='$loopname'");
									//if(!$qsstatus) die(mysql_error());
									//$o = mysql_fetch_object($qsstatus);
									//$sstatus = $o->sstatus;
									//echo("&nbsp;&nbsp;|&nbsp;&nbsp;$sstatus");
								} 
								?></font></td>
                    </tr>
                    <tr>
                      <td height="25" valign="top" style=" padding-left:10px; padding-top:5px;">
					  <a href="main_sendMsg.php?recipient=<?php echo($loopname) ?>">
                        <?php
								echo("<div style='background-image:url(img/black_cell_bg.jpg); background:#FFFFFF; display:inline; border-bottom:1px #DDDDDD solid; border-right:1px #DDDDDD solid; padding:3 6 3 6; height:15px; color:#333333; font-size:12px' onmouseover=this.style.cursor='hand'>+ Message</div>")
								?>
                      </a></td>
                    </tr>
                  </table>
                </div>
              <?php 
							}else if($tbname=="rocker_rel_info_"){
			?>
                <div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:10px; padding-bottom: 10px; border-bottom:0px #DDDDDD solid">
                  <table width="330" height="30" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="50" height="18" align="left" valign="middle" style="padding-left:10px;">
					  <img src="img/grayStar.jpg" width="25"/></td>
                      <td height="18" align="left" valign="middle" style="padding-left:15px; font-size:14px"><?php
							  echo("<a href=main_user.php?uid=$loopname class=one><font color=#336633><strong>$loopname</strong></font></a> and <a href=main_user.php?uid=$subject class=one><font color=#336699><strong>$subject</strong></font></a> are friend");
							  ?></td>
                    </tr>
                  </table>
                </div>
              <?php 
							}else if($tbname=="forum_info_"){
							?>
              <?php 
							}else if($tbname=="house_info_"){
							?>
              <?php 
							}else if($tbname=="article_info_"){
							?>
              <?php }else if($tbname=="course_memo_info"){ 
						  		$memo_q = mysql_query("SELECT * FROM rockinus.course_info a JOIN rockinus.major_info b ON a.course_id=(SELECT course_id FROM rockinus.unique_course_info WHERE course_uid ='$id') AND a.mid=b.mid;");
								if(!$memo_q) die(mysql_error());
								$obj = mysql_fetch_object($memo_q); 
								$course_id = $obj->course_id;
								$course_name = $obj->course_name;
								$major_name = $obj->major_name;
						  ?>
              <?php }else if($tbname=="event_info"){  ?>
              <?php } }?>
            </td>
          </tr>
        </table>