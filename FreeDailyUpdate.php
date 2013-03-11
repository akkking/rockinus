<table width="650" height="85" border="0" cellpadding="0" cellspacing="0" style="border:0px solid #DDDDDD">
          <tr>
            <td width="663" height="85" valign="top" ><?php
			include 'dbconnect.php';
			include 'Allfuc.php';
			
//header("Content-Type: text/html; charset=gb2312");

			$sel_count = "
SELECT sum(total) as cnt FROM (
	SELECT count(*) as total FROM rockinus.house_info 
	UNION 
	SELECT count(*) as total FROM rockinus.article_info 
	UNION 
	SELECT count(*) as total FROM rockinus.course_memo_info 
	UNION 
	SELECT count(*) as total FROM rockinus.news_info  
	UNION 
	SELECT count(*) as total FROM rockinus.room_mate_info 
) as cnt";

$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

	$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 20;
	$page= (isset($_GET["page"]))? $_GET["page"] : 1;
	if((!$limit) || (is_numeric($limit) == false)|| ($limit < 20) || ($limit > 50)) 
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
		$sql_stmt = "SELECT hid,uname,subject,rentlease,pdate,ptime,tbname, type, city, rate, NULL as col_1, NULL as col_2, descrip, rstatus
					FROM rockinus.house_info c 
					UNION 
					SELECT aid,uname,subject,buysale,pdate,ptime,tbname,aname,city,rate,delivery,type, descrip, rstatus 
					FROM rockinus.article_info d  
					UNION 
					SELECT course_uid, sender, descrip, rating, pdate, ptime, tbname, NULL, NULL, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.course_memo_info e 
					UNION 
					SELECT news_id, creater, subject, descrip, pdate, ptime, 'news_info', NULL, category, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.news_info f  
					UNION 
					SELECT rmate_id, uname, has_room, descrip, pdate, ptime, 'room_mate_info', NULL, mate_type, NULL, NULL, NULL, NULL, NULL 
					FROM rockinus.room_mate_info g 
					ORDER BY pdate DESC, ptime DESC LIMIT $set_limit, $limit";
					//echo($sql_stmt);;
		mysql_query("SET NAMES UTF8");
//		mysql_query("SET NAMES GBK");
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($no_row == 0) echo("");
		while($object = mysql_fetch_object($q)){
			$loopname = $object->uname;		
			$tbname = $object->tbname;			
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			$id = $object->hid;
			$subject = $object->subject;
			$subject = str_replace("\\","",$subject);
			$aname = $object->type;
			$city = $object->city;
			$rate = $object->rate;
			$delivery = $object->col_1;
			$type = $object->col_2;
			$descrip = $object->descrip;
			$rstatus = $object->rstatus;
			$descrip = str_replace("\\","",$descrip);
			$action = $object->rentlease;
			$action = str_replace("\\","",$action);
			if(strlen($subject)>50) $subject = substr(trim($subject), 0, 400)."...";
			if($tbname=="user_check_info_"){
			?>
                <div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:15px; padding-bottom: 20px; border:1px #DDDDDD solid">
                  <table width="650" height="75" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="50" rowspan="5" valign="top" bgcolor="#FFFFFF" style="padding-top:5px; padding-right:5px; padding-bottom:10px; padding-left:10px"><?php
									$loopImg = "upload/$loopname/$loopname"."100.jpg";
							  if(file_exists($loopImg)) echo("<a href=FreeTourUser.php?uid=$loopname class=one><img src=$loopImg width=40px style='border:0px #666666 solid' /></a>");
							  else echo("<a href=FreeTourUser.php?uid=$loopname class=one><img src=img/NoUserIcon100.jpg width=40px /></a>");
							  ?></td>
                      <td height="25" align="left" valign="top" style="padding-left:10px; padding-top:5px; font-size:16px"><?php
							  if($tbname=="user_check_info") 
							  	echo("<a href=FreeTourUser.php?uid=$loopname class=one><font color=#000000><strong>$loopname</strong></font></a>");	
								echo(" has joined the network");
								?> 								
                        &nbsp; </td>
                      <td width="130" height="25" align="right" valign="top" style="padding-right:10px; padding-top:5px; font-size:12px">
                        <?php
							  echo(getDateName($pdate)." | ".substr($ptime,0,5));
							  ?>                      </td>
                    </tr>
                    <tr>
                      <td height="25" valign="top" style="padding-left:10px; padding-top:5px;">
					  <font color="#666666" style="font-size:12px">       
								<?php 
							  	if($tbname=="user_check_info"){
									$pieces = explode('@', $id);
									if(stristr($pieces[1],'poly')==true) echo("From NYU-Poly");
									else {
										$pieces_2 = explode('.', $pieces[1]);
										$len = count($pieces_2[1])-1;
										echo("&nbsp;|&nbsp;&nbsp;From ".strtoupper($pieces_2[$len]));
										//else echo($id);
									}
									
									$qmajor = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid=(SELECT cmajor FROM rockinus.user_edu_info WHERE uname='$loopname');");
									if(!$qmajor) die(mysql_error());
									$o = mysql_fetch_object($qmajor);
									$major_name = $o->major_name;
									if( strlen($major_name)>0 && $major_name!=NULL )
									echo("&nbsp;&nbsp;|&nbsp;&nbsp;$major_name");
									
									$qsstatus = mysql_query("SELECT sstatus FROM rockinus.user_info WHERE uname='$loopname'");
									if(!$qsstatus) die(mysql_error());
									$o = mysql_fetch_object($qsstatus);
									$sstatus = $o->sstatus;
									echo("&nbsp;&nbsp;|&nbsp;&nbsp;$sstatus");
								} 
								?></font></td>
                      <td height="25" style="padding-left:5">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="25" valign="top" style="padding-left:10px; padding-top:5px;">
					  <a href="FreeTourSendMsg.php?recipient=<?php echo($loopname) ?>">
                        <?php
								echo("<div style='background:#EEEEEE; display:inline; border:1px #CCCCCC solid; padding:3 6 3 6; height:15px; color:#000000; font-size:12px' onmouseover=this.style.cursor='hand'>+ Message</div>")
								?>
                      </a></td>
                      <td height="25" style="padding-left:5">&nbsp;</td>
                    </tr>
                  </table>
                </div>
              <?php 
							}else if($tbname=="rocker_rel_info_"){
			?>
              <?php 
							}else if($tbname=="forum_info_"){
							?>
              <?php 
							}else if($tbname=="house_info"){
							?>
<div style="margin-top:5; margin-bottom:5px; padding-left:0; padding-top:5; padding-bottom:15; border-bottom:1px #DDDDDD solid ">
                  <table width="650" height="105" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="60" rowspan="3" align="left" bgcolor="#FFFFFF" style="padding-top:8px; padding-bottom:10px; padding-left:10px" valign="top"><?php 
			$target = "upload/h".$id;
			if(is_dir($target)){
				echo("<a href=main_house.php?hid=$id class=one><img src=upload/h$id/1_100.jpg style='border:0; width:40px'></a>");
			}else 				  		
				echo("<a href=main_house.php?hid=$id class=one><img src=img/NoHouse100_gray.jpg style='border:0; width:40px'></a>");
			?></td>
                      <td width="465" height="30" align="left" style="padding-left:15px; font-size:16px">
					  <?php 
		if(strlen($subject)<70)
			echo("<a href=main_house.php?hid=$id class=one><strong><font color=>$subject</font></strong></a>");
		else
			echo("<a href=main_house.php?hid=$id class=one><strong><font color=>".substr($subject,0,68)."</font> ...</strong></a>");
							  ?>                      
							  </td>
                      <td width="125" align="right" style="padding-left:15px; font-size:16px">
					  <?php if($rstatus=="Y"){?>
					  <div style="width: 90; background-color:#F5F5F5; background-image:; border:1px #EEEEEE solid; color:#333333; padding:4 8 4 8; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif" align="center"><img src='img/addsuccessIcon_F5.jpg' width=12>&nbsp;Available</div> <? }else if($rstatus=="N"){?>
					  <div style="width: 90; background-color:#F5F5F5; background-image:; border:1px #EEEEEE solid; color:#B92828; padding:4 8 4 8; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif" align="center"><img src='img/error_new.jpg' width=12>&nbsp;Expired</div> <? }?>
					  </td>
                    </tr>
                    <tr>
                      <td height="30" colspan="2" align="left" valign="top" style="padding-left:15px; padding-top:10px; font-size:12px; font-weight:"><?php 
				echo("<font color=#000000>$aname | $action | $city</font>");
							  ?>                      </td>
                    </tr>
                    <tr>
                      <td height="30" colspan="2" align="left" valign="top" style="padding-left:15px; font-size:14px; padding-top:10px; padding-right:15; line-height:150%; font-size:14px"><?php
								  if(strlen($descrip)>20) 
									echo(substr(nl2br($descrip),0,500)."...");
								else
							  		echo("<a href=housedetail.php?hid=$id class=one>Click for details >></a>");
?>                      </td>
                    </tr>
                  </table>
              </div>
              <?php 
							}else if($tbname=="article_info"){
							?>
                <div style="margin-top:5; margin-bottom:5px; padding-left:0; padding-top:10; padding-bottom:15px; border-bottom:1px #DDDDDD solid">
                  <table width="650" height="105" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="60" rowspan="3" align="left" bgcolor="#FFFFFF" valign="top" style="padding-left:10px; padding-top:5px"><?php 
			$target = "upload/a".$id;
			if(is_dir($target)){
				echo("<a href=main_market.php?aid=$id class=one><img src=upload/a$id/1_100.jpg style='border:0; width:40px'></a>");
			}else 				  		
				echo("<a href=main_market.php?aid=$id class=one><img src=img/noarticle_gray100.jpg style='border:0; width:40px'></a>");
			?>                      </td>
                      <td width="465" height="30" align="left" style="display:inline; padding-left:15px; border-bottom:0px #BBBBBB dotted; font-size:16px"><?php 
					  if(strlen($subject)<70)
						echo("<a href=main_market.php?aid=$id class=one><strong><font color=>$subject</font></strong></a>");
					  else
					  	echo("<a href=main_market.php?aid=$id class=one><strong><font color=>".substr($subject,0,68)."</font> ...</strong></a>");  
						  ?>
					</td>
                      <td width="125" align="right" style="padding-left:15px; font-size:16px">
					  <?php if($rstatus=="Y"){?>
					  <div style="width: 90; background-color:#F5F5F5; background-image:; border:1px #EEEEEE solid; color:#333333; padding:4 8 4 8; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif" align="center"><img src='img/addsuccessIcon_F5.jpg' width=12>&nbsp;Available</div> <? }else if($rstatus=="N"){?>
					  <div style="width: 90; background-color:#F5F5F5; background-image:; border:1px #EEEEEE solid; color:#B92828; padding:4 8 4 8; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif" align="center"><img src='img/error_new.jpg' width=12>&nbsp;Expired</div> <? }?>
					  </td></tr>
                    <tr>
                      <td height="30" colspan="2" align="left" valign="top" style="padding-left:15px; padding-top:10px; font-size:12px; font-weight:"><?php
							  	echo("<font color=#000000>$aname | $action | $city</strong></font>");	
								?>                      </td>
                    </tr>
                    <tr>
                      <td height="30" colspan="2" align="left" valign="top" style="padding-left:15px; font-size:14px; padding-top:10px; padding-right:15; line-height:150%; font-size:14px"><?php
								  if(strlen($descrip)>20) 
									echo(substr(nl2br($descrip),0,500)."...");
								else
							  		echo("<a href=ArticleDetail.php?aid=$id class=one>Click for details >></a>");
?>                      </td>
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
              <div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:10; padding-bottom:15; border-bottom:1px #DDDDDD solid">
                <table width="650" height="105" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="60" rowspan="2" align="left" style="padding-left:10px; padding-top:10px" valign="top"><img src="img/book100.jpg" width="40" /></strong></font></td>
                    <td height="35" style="padding-left:15px; font-size:14px"><?php
							  	echo("<strong>$course_name</strong>");
							  ?> </td>
                    <td style="font-size:14px" align="right">
					<?php 
						if(strlen($action)>0){
							for($i=0;$i<$action;$i++)
								echo(" <img src=img/yellowstar.jpg />"); 
						}	
						?></td>
                  </tr>
                  <tr>
                    <td height="30" colspan="2" valign="top" style="padding-left:15px; font-size:12px; color:#000000"><?php
							  	echo("<font color=#666666 style='font-size:12px'>(".$major_name." Department)</font>");
							  ?>                    </td>
                  </tr>
                  <tr>
                    <td width="50" height="30" style="padding-left:5px">&nbsp;</td>
                    <td height="30" colspan="2" valign="top" style="padding-left:15px; padding-right:15; line-height:150%; font-size:14px; padding-top:0px"><?php 
					echo(nl2br($subject));
					  ?>                    </td>
                  </tr>
                </table>
              </div>
              <?php }else if($tbname=="news_info"){  ?>
                <div style="padding-left:0; padding-top:10; padding-bottom:10px; border-bottom:1px #DDDDDD solid">
                  <table width="650" height="66" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="60" rowspan="3" valign="top" bgcolor="#FFFFFF" style="padding-left:10px; padding-top:5px">
					  <?php 
				echo("<img src=img/calendar100.jpg style=border:0 width=40px>");
				?>				</td>
                      <td width="476" height="30" style="padding-left:15px; font-size:16px; font-weight:bold"><?php echo("$subject") ?> </td>
                      <td width="121" height="30" align="right" style="padding-right:0px; font-size:12px">
					  <?php echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?>					  </td>
                    </tr>
                    <tr>
                      <td height="30" colspan="2" valign="top" style="padding:5px; padding-left:15; padding-right:15; line-height:150%; font-size:14px">
					  <?php 
					  if(strlen($action)<500)
					  	echo(nl2br($action));
                      else	
					  	echo(nl2br(substr($action,0,500))." ...") ?></td>
                    </tr>
                  </table>
                </div>
              <?php }else if($tbname=="room_mate_info"){  
			  				$has_room_title = "";
							if($subject=="Y") $has_room_title = "<font color=#666666 style='font-size:14px; font-weight:normal'>(has Apt.)</font>";
							if($city=="all") $mate_type = "";
							else $mate_type = "<font color=#666666 style='font-size:14px; font-weight:normal'>(expect $city roommate)</font>";
			  ?>
                <div style="padding-left:0; padding-top:10; padding-bottom:10px; border-bottom:1px #DDDDDD solid">
                  <table width="650" height="66" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="60" rowspan="3" valign="top" bgcolor="#FFFFFF" style="padding-left:10px; padding-top:5px">
					  <?php 
				echo("<img src=img/headIcon.jpg style=border:0 width=40px>");
				?>				</td>
                      <td width="476" height="30" style="padding-left:15px; font-size:16px; font-weight:bold">
					  <?php echo("Looking for roomate $has_room_title $mate_type") ?>
					  </td>
                      <td width="121" height="30" align="right" style="padding-right:0px; font-size:12px">
					  <?php echo(getDateName($pdate)." | ".substr($ptime,0,5)) ?>					  </td>
                    </tr>
                    <tr>
                      <td height="30" colspan="2" valign="top" style="padding:5px; padding-left:15; padding-right:15; line-height:150%; font-size:14px">
					  <?php 
					  if(strlen($action)<500)
					  	echo($action);
                      else	
					  	echo(substr($action,0,500)." ...") ?></td>
                    </tr>
                  </table>
                </div>
              <?php } }?>
            </td>
          </tr>
        </table>