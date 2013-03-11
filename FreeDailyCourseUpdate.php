<table width="330" height="85" border="0" cellpadding="0" cellspacing="0" style="border:0px solid #DDDDDD">
          <tr>
            <td width="663" height="85" valign="top" ><?php
			include 'dbconnect.php';
			//include 'Allfuc.php';
			
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
			$subject = str_replace("\\","",$subject);
			$aname = $object->col_2;
			$city = $object->col_3;
			$rate = $object->col_4;
			$delivery = $object->col_5;
			$type = $object->col_6;
			$descrip = $object->col_7;
			$descrip = str_replace("\\","",$descrip);
			$action = $object->status;
			if(strlen($subject)>50) $subject = substr(trim($subject), 0, 400)."...";
			if($tbname=="user_check_info_"){
			?>
              <?php 
							}else if($tbname=="rocker_rel_info_"){
			?><?php 
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
<div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:10; padding-bottom:15; border-bottom:1px #DDDDDD solid">
                  <table width="330" height="105" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="50" rowspan="2" align="left" style="padding-left:10px; padding-top:10px" valign="top">
					  <img src="img/book100.jpg" width="40" height="35" /></strong></font></td>
                      <td height="35" style="padding-left:15px; font-size:14px">
					  <?php
							  	echo("<strong>$course_name</strong>");
							  ?></td>
                    </tr>
                    <tr>
                      <td height="30" valign="top" style="padding-left:15px; font-size:12px; color:#000000"><?php
							  	echo("<font color=#666666 style='font-size:12px'>(".$major_name." Department)</font>");
							  ?>					  </td>
                    </tr>
                    <tr>
                      <td width="50" height="30" style="padding-left:5px">&nbsp;</td>
                      <td height="30" valign="top" style="padding-left:15px; padding-right:15; line-height:150%; font-size:14px; padding-top:5px"><?php 
					echo(nl2br($subject));
					  ?><?php 
						if(strlen($action)>0){
							for($i=0;$i<$action;$i++)
								echo(" <img src=img/yellowstar.jpg />"); 
						}	
						?>
						</td>
                    </tr>
                  </table>
              </div>
              <?php }else if($tbname=="event_info"){  ?>
              <?php } }?>
            </td>
          </tr>
        </table>