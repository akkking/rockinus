<?php 
include 'mainHeader.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];
if(isset($_POST['pressed_button'])){
	$searchfield = $_POST['searchfield'];
}
?>
<div style="width:100%" align="center">
<table width="1024" height="450" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="center">
    <tr>
      <td align="center" valign="top" style="padding-bottom:20px; line-height:180%;">
	  <div style="width:1024px; margin-top:25px; background:#FFFFFF; border:0px solid #999999" align="left">
	    <table width="1024" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px solid #999999; border-top:0px solid #CCCCCC; margin-bottom:10; ">
	      <tr>
	        <td height="50" style="font-size:24px; color:; background: #F5F5F5; border-bottom:1px solid #DDDDDD; font-weight:normal; padding-left:15px">
	          Search Result of "<font style="color:<?php echo($_SESSION['hcolor']) ?>"><?php echo($searchfield) ?></font>"	          </td>
	    </tr>
	      <tr>
	        <td style="font-size:14px; height:30; padding:15px">
			<div style="width:975px; padding-right:20px"> 
			<?php
$total_rst_num = 0;
if(isset($_POST['pressed_button'])){
	$searchfield = $_POST['searchfield'];
	include 'dbconnect.php';

	$mysql_db = mysql_select_db( 'rockinus', $link ); 
    if(! $mysql_db ) { 
        die( 'Can\'t select database: ' . mysql_error() ); 
    } 

    // Traverse all tables 
    $tables_result = mysql_query("SHOW TABLES"); 
    while( $tables_rows = mysql_fetch_row( $tables_result ) ) { 
        foreach( $tables_rows as $table ) { 
			$array_char = array();	
			// Traverse all columns 
            $columns_result = mysql_query("SHOW COLUMNS FROM " . $table); 
            while( $columns_row = mysql_fetch_assoc( $columns_result ) ) { 
                $column = $columns_row['Field']; 
                $type = $columns_row['Type'];  
				//echo($column."<br>".$type."<p>");
            
				// Process only text-based columns 
                if( strpos( $type, 'char' ) !== false || strpos( $type, 'text' ) !== false ) 
					array_push($array_char,$column);
			}
			
			$sql_char = NULL;
			$array_char_cnt = 0;
			$array_char_cnt = count($array_char);
			for($j=0;$j<$array_char_cnt;$j++){ 
				$char_column = $array_char[$j];
				if($j==($array_char_cnt-1)) $sql_char .= " $char_column LIKE '%$searchfield%'";
				else $sql_char .= " $char_column LIKE '%$searchfield%' OR ";
			}	
			//echo $sql_char;
			
//			echo $table;
			
			if($table=="article_info"){
				$q = mysql_query("SELECT aid, uname, subject, descrip FROM $table WHERE $sql_char");
				if(!$q) die(mysql_error());
				$rst_num = mysql_num_rows($q);
				if($rst_num>0){
					$total_rst_num += $rst_num;
					while($object = mysql_fetch_object($q)){
						$aid = $object->aid;
						$uname = $object->uname;
						$subject = $object->subject;
						$descrip = $object->descrip;
						$rst_line = $subject." | ".$descrip." [".$uname."]";
						$words = array($searchfield);
						/*** highlight the words ***/
						$rst_line = highlightWords($rst_line, $words);
						echo("<div style='padding: 5px; border-bottom:1px #EEEEEE solid; font-size:13px'><a href=ArticleDetail.php?aid=$aid class=one>$rst_line</a></div>");
					}
				}	
			}else if($table=="article_comment"){
				$q = mysql_query("SELECT aid, cid, sender, recipient, descrip FROM $table WHERE $sql_char");
				if(!$q) die(mysql_error());
				$rst_num = mysql_num_rows($q);
				if($rst_num>0){
					$total_rst_num += $rst_num;
					while($object = mysql_fetch_object($q)){
						$aid = $object->aid;
						$cid = $object->cid;
						$sender = $object->sender;
						$recipient = $object->recipient;
						$descrip = $object->descrip;
						$rst_line = $descrip." | ".$descrip." [".$sender."]";
						$words = array($searchfield);
						/*** highlight the words ***/
						$rst_line = highlightWords($rst_line, $words);
						echo("<div style='padding: 5px; border-bottom:1px #EEEEEE solid; font-size:13px'><a href=ArticleDetail.php?aid=$aid class=one target=_blank>$rst_line</a></div>");
					}
				}
			}else if($table=="house_info"){
				$q = mysql_query("SELECT hid, uname, subject, descrip FROM $table WHERE $sql_char");
				if(!$q) die(mysql_error());
				$rst_num = mysql_num_rows($q);
				if($rst_num>0){
					$total_rst_num += $rst_num;
					while($object = mysql_fetch_object($q)){
						$hid = $object->hid;
						$uname = $object->uname;
						$subject = $object->subject;
						$descrip = $object->descrip;
						$rst_line = $subject." | ".$descrip." [".$uname."]";
						$words = array($searchfield);
						/*** highlight the words ***/
						$rst_line = highlightWords($rst_line, $words);
						echo("<div style='padding: 5px; border-bottom:1px #EEEEEE solid; font-size:13px'><a href=HouseDetail.php?hid=$hid class=one target=_blank>$rst_line</a></div>");
					}
				}
			}else if($table=="house_comment"){
				$q = mysql_query("SELECT hid, sender, recipient, descrip FROM $table WHERE $sql_char");
				if(!$q) die(mysql_error());
				$rst_num = mysql_num_rows($q);
				if($rst_num>0){
					$total_rst_num += $rst_num;
					while($object = mysql_fetch_object($q)){
						$hid = $object->hid;
						$sender = $object->sender;
						$recipient = $object->recipient;
						$descrip = $object->descrip;
						$rst_line = $subject." | ".$descrip." [".$uname."]";
						$words = array($searchfield);
						/*** highlight the words ***/
						$rst_line = highlightWords($rst_line, $words);
						echo("<div style='padding: 5px; border-bottom:1px #EEEEEE solid; font-size:13px'><a href=HouseDetail.php?hid=$hid class=one target=_blank>$rst_line</a></div>");
					}
				}
			}else if($table=="user_info"){
				$q = mysql_query("SELECT uname,fname,lname FROM $table WHERE ( $sql_char )");					
				if(!$q) die(mysql_error());
				$rst_num = mysql_num_rows($q);
				if($rst_num>0){
					$total_rst_num += $rst_num;
					while($object = mysql_fetch_object($q)){
						$loopname = $object->uname;
						$fname = $object->fname;
						$lname = $object->lname;
						$rst_line = "<strong>User name</strong> : $fname $lname";
						$words = array($searchfield);
						/*** highlight the words ***/
						$rst_line = highlightWords($rst_line, $words);
						echo("<div style='padding: 5px; border-bottom:1px #EEEEEE solid; font-size:13px'><a href='RockerDetail.php?uid=$loopname' class=one target=_blank>$rst_line</a><br><font color=#999999>[$loopname as User ID]</font></div>");
					}
				}
			}else if($table=="news_info"){
				$q = mysql_query("SELECT news_id,creater,subject,descrip FROM $table WHERE $sql_char");					
				if(!$q) die(mysql_error());
				$rst_num = mysql_num_rows($q);
				if($rst_num>0){
					$total_rst_num += $rst_num;
					while($object = mysql_fetch_object($q)){
						$subject = $object->subject;
						$descrip = $object->descrip;
						$creater = $object->creater;
						$news_id = $object->news_id;
						$rst_line = "<strong>$subject</strong> [Notice by $creater]<br>$descrip";
						$words = array($searchfield);
						/*** highlight the words ***/
						$rst_line = highlightWords($rst_line, $words);
						echo("<div style='padding: 5px; border-bottom:1px #EEEEEE solid; font-size:13px'>$rst_line</div>");
					}
				}
			}else if($table=="room_mate_info"){
				$q = mysql_query("SELECT rmate_id,mate_type,descrip FROM $table WHERE $sql_char");					
				if(!$q) die(mysql_error());
				$rst_num = mysql_num_rows($q);
				if($rst_num>0){
					$total_rst_num += $rst_num;
					while($object = mysql_fetch_object($q)){
						$descrip = $object->descrip;
						$mate_type = $object->mate_type;
						$rmate_id = $object->rmate_id;
						$rst_line = $descrip." [<strong>Room mate info</strong>]";
						$words = array($searchfield);
						/*** highlight the words ***/
						$rst_line = highlightWords($rst_line, $words);
						echo("<div style='padding: 5px; border-bottom:1px #EEEEEE solid; font-size:13px'>$rst_line</div>");
					}
				}
			}else if($table=="book_info"){
				$q = mysql_query("SELECT book_id,uname,descrip FROM $table WHERE $sql_char");					
				if(!$q) die(mysql_error());
				$rst_num = mysql_num_rows($q);
				if($rst_num>0){
					$total_rst_num += $rst_num;
					while($object = mysql_fetch_object($q)){
						$descrip = $object->descrip;
						$creater = $object->uname;
						$book_id = $object->book_id;
						$rst_line = $descrip." [<strong>Book info from ".$creater."</strong>]";
						$words = array($searchfield);
						/*** highlight the words ***/
						$rst_line = highlightWords($rst_line, $words);
						echo("<div style='padding: 5px; border-bottom:1px #EEEEEE solid; font-size:13px'>$rst_line</div>");
					}
				}
			}else if($table=="memo_info"){
				$q = mysql_query("SELECT memoid,sender,descrip FROM $table WHERE $sql_char");					
				if(!$q) die(mysql_error());
				$rst_num = mysql_num_rows($q);
				if($rst_num>0){
					$total_rst_num += $rst_num;
					while($object = mysql_fetch_object($q)){
						$descrip = $object->descrip;
						$creater = $object->sender;
						$memoid = $object->memoid;
						$rst_line = "<a href='RockerDetail.php?uid=$creater' class='one' target='_blank'>$descrip</a> [<strong>Status post by $creater</strong>]";
						$words = array($searchfield);
						/*** highlight the words ***/
						$rst_line = highlightWords($rst_line, $words);
						echo("<div style='padding: 5px; border-bottom:1px #EEEEEE solid; font-size:13px'>$rst_line</div>");
					}
				}
			}else if($table=="course_memo_info"){
				$q = mysql_query("SELECT rstatus,course_uid,sender,descrip FROM $table WHERE $sql_char");					
				if(!$q) die(mysql_error());
				$rst_num = mysql_num_rows($q);
				if($rst_num>0){
					$total_rst_num += $rst_num;
					while($object = mysql_fetch_object($q)){
						$descrip = $object->descrip;
						$descrip = str_replace("\\","", $descrip);
						$sender = $object->sender;
						$rstatus = $object->rstatus;
						$course_uid = $object->course_uid;
						$rst_line = $descrip." [<strong>Course comment</strong>]";
						if($rstatus=='Y') continue;						
						$words = array($searchfield);
						/*** highlight the words ***/
						$rst_line = highlightWords($rst_line, $words);
						echo("<div style='padding: 5px; border-bottom:1px #EEEEEE solid; font-size:13px'><a href='CourseDetail.php?course_uid=$course_uid' class=one target=_blank>$rst_line</a></div>");
					}
				}
			}  
    	} 
	}	

	if($total_rst_num>0)
 		echo("<p style='padding-top:15px'><div style='background-color:; padding:0px; border:0px #EEEEEE solid; font-size:16px'>Totally <font color=#B92828><strong>$total_rst_num</strong></font> items found</div>");
   	else
		echo("<div style='line-height:130%; padding:5 10 5 10; font-size:13px'>Unfortunately, there is no results matched <font color='#B92828'> <strong>$searchfield</strong></font></div><div style='line-height:130%; padding:5 10 5 10; font-size:13px; display: inline;'>We suggestion you try other key words!</div><div style='height:18; padding:5 10 5 10; line-height:130%; font-size:13px;'><img src='img/rightTriangleIcon.jpg' width=9 />&nbsp;&nbsp;<a href='reportIssue.php' class=one>Or report us if you think it's an issue</a></div>");
		
	mysql_free_result( $columns_result ); 
    mysql_free_result( $tables_result ); 
    mysql_close( $link ); 
}
?>
</div>
</td>
	        </tr>
	      </table>
                   </div></td>
    </tr>
</table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>