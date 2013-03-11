<?php
function gen_rounded_pic($images_dir,$image_file){
$corner_radius = isset($_GET['radius']) ? $_GET['radius'] : 20; // The default corner radius is set to 20px
$angle = isset($_GET['angle']) ? $_GET['angle'] : 0; // The default angle is set to 0o
$topleft = (isset($_GET['topleft']) and $_GET['topleft'] == "no") ? false : true; // Top-left rounded corner is shown by default
$bottomleft = (isset($_GET['bottomleft']) and $_GET['bottomleft'] == "no") ? false : true; // Bottom-left rounded corner is shown by default
$bottomright = (isset($_GET['bottomright']) and $_GET['bottomright'] == "no") ? false : true; // Bottom-right rounded corner is shown by default
$topright = (isset($_GET['topright']) and $_GET['topright'] == "no") ? false : true; // Top-right rounded corner is shown by default

$corner_source = imagecreatefrompng('img/rounded_corner.png');

$corner_width = imagesx($corner_source);  
$corner_height = imagesy($corner_source);  
$corner_resized = ImageCreateTrueColor($corner_radius, $corner_radius);
ImageCopyResampled($corner_resized, $corner_source, 0, 0, 0, 0, $corner_radius, $corner_radius, $corner_width, $corner_height);

$corner_width = imagesx($corner_resized);  
$corner_height = imagesy($corner_resized);  
$image = imagecreatetruecolor($corner_width, $corner_height);  
$image = imagecreatefromjpeg($images_dir . $image_file); // replace filename with $_GET['src'] 
$size = getimagesize($images_dir . $image_file); // replace filename with $_GET['src'] 
$white = ImageColorAllocate($image,255,255,255);
$black = ImageColorAllocate($image,0,0,0);

// Top-left corner
if ($topleft == true) {
    $dest_x = 0;  
    $dest_y = 0;  
    imagecolortransparent($corner_resized, $black); 
    imagecopymerge($image, $corner_resized, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100);
} 

// Bottom-left corner
if ($bottomleft == true) {
    $dest_x = 0;  
    $dest_y = $size[1] - $corner_height; 
    $rotated = imagerotate($corner_resized, 90, 0);
    imagecolortransparent($rotated, $black); 
    imagecopymerge($image, $rotated, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100);  
}

// Bottom-right corner
if ($bottomright == true) {
    $dest_x = $size[0] - $corner_width;  
    $dest_y = $size[1] - $corner_height;  
    $rotated = imagerotate($corner_resized, 180, 0);
    imagecolortransparent($rotated, $black); 
    imagecopymerge($image, $rotated, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100);  
}

// Top-right corner
if ($topright == true) {
    $dest_x = $size[0] - $corner_width;  
    $dest_y = 0;  
    $rotated = imagerotate($corner_resized, 270, 0);
    imagecolortransparent($rotated, $black); 
    imagecopymerge($image, $rotated, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100);  
}

// Rotate image
$image = imagerotate($image, $angle, $white);

// Output final image
imagejpeg($image);

imagedestroy($image);  
imagedestroy($corner_source);
}

function highlightWords($string, $words)
{
   foreach ( $words as $word )
   {
       $string = str_ireplace($word, '<font color=#B92828><strong>'.$word.'</strong></font>', $string);
   }
   /*** return the highlighted string ***/
   return $string;
}

function contains($substring, $string) {
        $pos = strpos($string, $substring);
 
        if($pos === false) {
                // string needle NOT found in haystack
                return false;
        }
        else {
                // string needle found in haystack
                return true;
        }
}

function getBrowser() { 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
     $platform = 'Unknown';
     $version= "";
 
    //First get the platform?
     if (preg_match('/linux/i', $u_agent)) {
         $platform = 'linux';
     }
     elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
         $platform = 'mac';
     }
     elseif (preg_match('/windows|win32/i', $u_agent)) {
         $platform = 'windows';
     }
     
    // Next get the name of the useragent yes seperately and for good reason
     if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
     $known = array('Version', $ub, 'other');
     $pattern = '#(?<browser>' . join('|', $known) .
     ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
     if (!preg_match_all($pattern, $u_agent, $matches)) {
         // we have no matching number just continue
     }
     
    // see how many we have
     $i = count($matches['browser']);
     if ($i != 1) {
         //we will have two since we are not using 'other' argument yet
         //see if version is before or after the name
         if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
             $version= $matches['version'][0];
         }
         else {
             $version= $matches['version'][1];
         }
     }
     else {
         $version= $matches['version'][0];
     }
     
    // check if we have a number
     if ($version==null || $version=="") {$version="?";}
     
    return array(
         'userAgent' => $u_agent,
         'name'      => $bname,
         'version'   => $version,
         'platform'  => $platform,
         'pattern'    => $pattern
     );
} 

function deleteDir($dirPath) { 
    if (! is_dir($dirPath)) { 
        throw new InvalidArgumentException('$dirPath must be a directory'); 
    } 
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') { 
        $dirPath .= '/'; 
    } 
    $files = glob($dirPath . '*', GLOB_MARK); 
    foreach ($files as $file) { 
        if (is_dir($file)) { 
            self::deleteDir($file); 
        } else { 
            unlink($file); 
        } 
    } 
    rmdir($dirPath); 
} 

function ProfileProgress($uname){
include 'dbconnect.php';
$wid = 0;
$q = mysql_query("SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_edu_info b INNER JOIN rockinus.user_contact_info c INNER JOIN rockinus.user_hobby_info d ON a.uname='$uname' AND a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname");
if(!$q) die(mysql_error());
$object = mysql_fetch_object($q);
if(trim($object->fname)!=NULL)$wid += 5;
if(trim($object->lname)!=NULL)$wid += 5;
if(trim($object->birthdate)!="0000-00-00" && trim($object->birthdate)!= NULL )$wid += 5;
if($object->gender!=NULL)$wid += 5;
if($object->sstatus!=NULL)$wid += 5;
if($object->mstatus!=NULL)$wid += 5;
if(($object->fcountry!=NULL) && ($object->fcountry!="empty" ))$wid += 10;
if($object->cdegree!=NULL)$wid += 5;
if(($object->cschool!=NULL) && ($object->cschool!="empty" ))$wid += 5;
if(($object->cmajor!=NULL) && ($object->cmajor!="empty"))$wid += 10;
if(trim($object->email)!=NULL)$wid += 5;
if(trim($object->phone)!=NULL)$wid += 5;
if(trim($object->address)!=NULL)$wid += 2;
if(trim($object->ccity)!=NULL)$wid += 5;
if(trim($object->hobby)!=NULL){
	$hobbyCnt = count(explode(",",$object->hobby));
	if($hobbyCnt>=8) $wid += 8;
	else $wid += $hobbyCnt;
}
if(trim($object->sterm)!=NULL && trim($object->sterm)!="empty")$wid += 5;
$target = "upload/".$uname;
if(is_dir($target)) $wid += 10;
return $wid;
}

function getDateName($indate){
	if($indate == date("Y-m-d"))
		return "Today";
	else if($indate == date("Y-m-d", strtotime("-1 day")))
		return "Yesterday";
	else
		return $indate;
}

function getNoDateName($indate){
	if($indate == date("Y-m-d"))
		return "Today";
	else if($indate == date("Y-m-d", strtotime("-1 day")))
		return "Yesterday";
	else
		return substr($indate,5,5);
}

function getCountTime($in_date_time){
	$now = new DateTime();
	$future_date = new DateTime($in_date_time);
	//$future_date = new DateTime('2011-05-11 12:00:00');
	$interval = $future_date->diff($now);
	
	if(greaterDate(date("Y-m-d H:i:s"),$in_date_time)==1) 
		return "<font color=#B92828>Expired</font>";
	
	if(substr(date("Y-m-d H:i:s"),0,3)==substr($in_date_time,0,3))
		return $interval->format("%h hrs, %i mins left");
	
	return $interval->format("%d days, %h hrs, %i mins left");
//	return $interval->format("%d days, %h hours, %i minutes, %s seconds");
}

function greaterDate($start_date,$end_date)
{
  $start = strtotime($start_date);
  $end = strtotime($end_date);
  if ($start-$end > 0)
    return 1;
  else
   return 0;
}

function addHyperLink($string)
{
	$patterns = array();
	$replacements = array();
	$matches = array();
	preg_match('/[a-zA-Z]+:\/\/[0-9a-zA-Z;.\/?:@=_\-#&%~,+$]+/', $string, $matches);
	for($i=0;$i<count($matches);$i++){
		$patterns[$i] = str_replace("/", "\/", $matches[$i]);
		$patterns[$i] = str_replace("?", "\?", $patterns[$i]);
  		$patterns[$i] = "/".$patterns[$i]."/";
		$replacements[$i] = "<a href='".$matches[$i]."' class='one' target='_blank' style='color:$_SESSION[hcolor];borber-bottom:0px dashed #999999'>".$matches[$i]."</a>";
	}
	return preg_replace($patterns, $replacements, $string);
}

function addHyperLink_white($string)
{
	$patterns = array();
	$replacements = array();
	$matches = array();
	preg_match('/[a-zA-Z]+:\/\/[0-9a-zA-Z;.\/?:@=_\-#&%~,+$]+/', $string, $matches);
	for($i=0;$i<count($matches);$i++){
		$patterns[$i] = str_replace("/", "\/", $matches[$i]);
		$patterns[$i] = str_replace("?", "\?", $patterns[$i]);
  		$patterns[$i] = "/".$patterns[$i]."/";
		$replacements[$i] = "<a href='".$matches[$i]."' target='_blank' style='color:;borber-bottom:0px dashed #999999'><u>".$matches[$i]."</u></a>";
	}
	return preg_replace($patterns, $replacements, $string);
}

function getUserPoint($uid){
include 'dbconnect.php';
$wid = ProfileProgress($uid);

$total_profile=2;
if($wid<50) $total_profile=2;
else if($wid>=50&&$wid<85) $total_profile=5;
else if($wid>=85) $total_profile=10;

$t_headicon = mysql_query("SELECT count(*) as cnt FROM rockinus.headicon_history where uname='$uid'");
$a_headicon = mysql_fetch_object($t_headicon);
$total_headicon = $a_headicon->cnt;

//$t_headicon_like = mysql_query("SELECT count(*) as cnt FROM rockinus.headicon_like WHERE headicon_id=(SELECT headicon_id FROM rockinus.headicon_history WHERE uname='$uid'");
//$a_headicon_like = mysql_fetch_object($t_headicon_like);
$total_headicon_like = 1;

$t_message = mysql_query("SELECT count(*) as cnt FROM rockinus.message_info where sender='$uid'");
$a_message = mysql_fetch_object($t_message);
$total_message = $a_message->cnt;

$t_friend = mysql_query("SELECT count(*) AS cnt FROM rockinus.rocker_rel_info WHERE sender='$uid' OR recipient='$uid'");
$z_friend = mysql_fetch_object($t_friend);
$total_friend = $z_friend->cnt;

$t_course_subs = mysql_query("SELECT * FROM rockinus.user_course_info WHERE uname='$uid';");
if(!$t_course_subs) die(mysql_error());
$total_course_subs = mysql_num_rows($t_course_subs);

$q_course_file = mysql_query("SELECT a.*, b.course_id, b.pid, c.course_name FROM rockinus.user_file_info a JOIN rockinus.unique_course_info b JOIN rockinus.course_info c ON a.owner='$uid' AND a.course_uid=b.course_uid AND c.course_id=b.course_id GROUP BY a.course_uid");
if(!$q_course_file) die(mysql_error());
$total_course_file = mysql_num_rows($q_course_file);
		
$t_login = mysql_query("SELECT count(*) as cnt FROM rockinus.user_log_info where uname='$uid' AND flag=0");
$a_login = mysql_fetch_object($t_login);
$total_login_times = $a_login->cnt;

$t_course_memo = mysql_query("SELECT count(*) as cnt FROM rockinus.course_memo_info where sender='$uid'");
$a_course_memo = mysql_fetch_object($t_course_memo);
$total_course_memo = $a_course_memo->cnt;

$t_memo = mysql_query("SELECT count(*) as cnt FROM rockinus.memo_info where sender='$uid' AND descrip<>NULL AND descrip<>''");
$a_memo = mysql_fetch_object($t_memo);
$total_memo = $a_memo->cnt;

$t_news = mysql_query("SELECT count(*) as cnt FROM rockinus.news_info where creater='$uid'");
$a_news = mysql_fetch_object($t_news);
$total_news = $a_news->cnt;

$t_house = mysql_query("SELECT count(*) as cnt FROM rockinus.house_info where uname='$uid'");
$a_house = mysql_fetch_object($t_house);
$total_house = $a_house->cnt;

$t_article = mysql_query("SELECT count(*) as cnt FROM rockinus.article_info where uname='$uid'");
$a_article = mysql_fetch_object($t_article);
$total_article = $a_article->cnt;

$t_visit_user = mysql_query("SELECT * FROM rockinus.visit_info WHERE visitor='$uid' ORDER BY vdate DESC, vtime DESC;");
if(!$t_visit_user) die(mysql_error());
$total_visit_user = mysql_num_rows($t_visit_user);
				
$t_visit_times = mysql_query("SELECT * FROM rockinus.visit_history WHERE visitor='$uid' ORDER BY vdate DESC, vtime DESC;");
if(!$t_visit_times) die(mysql_error());
$total_visit_times = mysql_num_rows($t_visit_times);

$t_interview_question = mysql_query("SELECT * FROM rockinus.interview_question WHERE creater='$uid';");
if(!$t_interview_question) die(mysql_error());
$total_interview_question = mysql_num_rows($t_interview_question);

$t_interview_question_follow = mysql_query("SELECT * FROM rockinus.interview_question_follow WHERE uname='$uid';");
if(!$t_interview_question_follow) die(mysql_error());
$total_interview_question_follow = mysql_num_rows($t_interview_question_follow);

$total_point = $total_profile + $total_headicon*15 + $total_headicon_like*5 + $total_visit_user*3 + $total_article*15 + $total_house*15 + $total_message*5 + $total_news*15 + $total_memo*5 + $total_course_file*20 + $total_course_memo*5 + $total_course_subs*5 + $total_login_times*2 + $total_friend*5 + $total_interview_question*25 + $total_interview_question_follow*25;

//echo("$total_profile + $total_visit_user*2 + $total_article*10 + $total_house*10 + $total_message*5 + $total_news*10 + $total_memo*5 + $total_course_file*8 + $total_course_memo*4 + $total_course_subs*5 + $total_login_times*2 + $total_friend*4");
return $total_point;
}

function cnSubstr($str, $start, $len) {  
	$str_tmp = $len - $start;  
   	if (strlen($str) < $str_tmp) {  
    	$tmpstr = $str;  
    }else {  
    	$tmpstr = "";  
    	$strlen = $start + $len;  
    	
		for($i = 0; $i < $strlen; $i++) {  
    		if(ord(substr($str, $i, 1)) > 0xa0) {  
    			$tmpstr .= substr($str, $i, 2);  
    			$i++;  
    		} else {  
    			$tmpstr .= substr($str, $i, 1);  
    		}  
    	}  
    	$tmpstr .= "..";  
	}  
	return $tmpstr;  
}  

function cutStr($str, $len, $tail = "")
{
 $length = strlen($str);
 $lentail = strlen($tail);
 $result = "";
 if ($length > $len)
 {
  $len = $len - $lentail;
  for ($i = 0; $i < $len; $i++)
  {
   if (ord($str[$i]) < 127)
   {
    $result .= $str[$i];
   } else{
    $result .= $str[$i];
    ++$i;
    $result .= $str[$i];
   }
        }
  $result = strlen($result) > $len ? substr($result, 0, -2) . $tail : $result . $tail;
 } else {
  $result = $str;
 }
 return $result;
}

function getMutalFriends($uname_1,$uname_2){
	$sql_stmt = "SELECT * FROM rockinus.user_info a 
			JOIN rockinus.user_check_info b 
			ON a.uname IN (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname_1'
						   UNION
						   SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname_1')
			AND
				a.uname IN (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname_2'
						   UNION
						   SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname_2')
			AND
				a.uname=b.uname
			ORDER BY b.signup_date DESC, b.signup_time DESC";
	$q = mysql_query($sql_stmt);
	if(!$q) die(mysql_error());
	//$no_row = mysql_num_rows($q);
	$array_mutal_friends=array();
	while($object = mysql_fetch_object($q)){
		$loopName = $object->uname;
		array_push($array_mutal_friends,$loopName);
	}
	return $array_mutal_friends;
}

function getMutalFriendsScore($uname_1,$uname_2,$mutual_friend_num){
	$total_score = 0;
	$total_score = $mutual_friend_num*10;
	
	$sql_stmt_country = "SELECT fcountry FROM rockinus.user_info WHERE 
						fcountry<>'empty'
						AND uname='$uname_1'
						AND fcountry=(SELECT fcountry FROM rockinus.user_info WHERE uname='$uname_2')";
	$q_country = mysql_query($sql_stmt_country);
	if(!$q_country) die(mysql_error());
	$no_row_country = mysql_num_rows($q_country);

	if($no_row_country>0){
		$sql_stmt_region = "SELECT * FROM rockinus.user_info WHERE 
					fregion<>'empty'
					AND uname='$uname_1'
					AND fregion=(SELECT fregion FROM rockinus.user_info WHERE uname='$uname_2')";
		$q_region = mysql_query($sql_stmt_region);
		if(!$q_region) die(mysql_error());
		$no_row_region = mysql_num_rows($q_region);
		if($no_row_region>0) $total_score += 30;
		else $total_score += 15;
	}
	
	$sql_stmt_cstate = "SELECT * FROM rockinus.user_contact_info WHERE 
						cstate IS NOT NULL
						AND uname='$uname_1'
						AND cstate=(SELECT cstate FROM rockinus.user_contact_info WHERE uname='$uname_2')";
	$q_cstate = mysql_query($sql_stmt_cstate);
	if(!$q_cstate) die(mysql_error());
	$no_row_cstate = mysql_num_rows($q_cstate);
	if($no_row_cstate>0) {
		$sql_stmt_ccity = "SELECT * FROM rockinus.user_contact_info WHERE 
					ccity IS NOT NULL
					AND uname='$uname_1'
					AND ccity=(SELECT ccity FROM rockinus.user_contact_info WHERE uname='$uname_2')";
		$q_ccity = mysql_query($sql_stmt_ccity);
		if(!$q_ccity) die(mysql_error());
		$no_row_ccity = mysql_num_rows($q_ccity);
		if($no_row_ccity>0) $total_score += 20;
		else $total_score += 10;
	}

	$sql_stmt_cschool = "SELECT * FROM rockinus.user_edu_info WHERE 
						cschool IS NOT NULL
						AND uname='$uname_1'
						AND cschool=(SELECT cschool FROM rockinus.user_edu_info WHERE uname='$uname_2')";
	$q_cschool = mysql_query($sql_stmt_cschool);
	if(!$q_cschool) die(mysql_error());
	$no_row_cschool = mysql_num_rows($q_cschool);
	if($no_row_cschool>0) {
		$sql_stmt_cmajor = "SELECT * FROM rockinus.user_edu_info WHERE 
					cmajor IS NOT NULL
					AND uname='$uname_1'
					AND cmajor=(SELECT cmajor FROM rockinus.user_edu_info WHERE uname='$uname_2')";
		$q_cmajor = mysql_query($sql_stmt_cmajor);
		if(!$q_cmajor) die(mysql_error());
		$no_row_cmajor = mysql_num_rows($q_cmajor);
		if($no_row_cmajor>0) $total_score += 20;
		else $total_score += 10;
	}
	
	return $total_score;
}
?>