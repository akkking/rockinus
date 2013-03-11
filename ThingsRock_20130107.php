<?php 
header("Content-Type: text/html; charset=utf-8");
include 'ValidCheck.php';
include("Allfuc.php");
include 'dbconnect.php';
$uname = $_SESSION['usrname'];

$q_global = mysql_query("SELECT * FROM rockinus.global_info");
if(!$q_global) die(mysql_error());
$object_global = mysql_fetch_object($q_global);
$cur_term = $object_global->cur_term;
$cur_term_year=substr($cur_term,0,4);

$q_job = mysql_query("SELECT * FROM rockinus.user_job_info WHERE uname='$uname';");
if(!$q_job) die(mysql_error());
$object_job = mysql_fetch_object($q_job);
$ccompany = $object_job->company_name;
$cjobtitle = $object_job->job_title;

$v_today = date("Y-m-d");
$v_yesterday = date("Y-m-d", strtotime("-1 day"));
$t_visit = mysql_query("SELECT count(*) as cnt FROM rockinus.visit_info WHERE host='$uname' AND (vdate='$v_today' OR vdate='$v_yesterday');");
$a_visit = mysql_fetch_object($t_visit);
$total_visit = $a_visit->cnt;

$v1_lasttime = mysql_query("SELECT * FROM rockinus.user_points WHERE uname='$uname' ORDER BY id DESC LIMIT 1,1");
if(!$v1_lasttime) die(mysql_error());
$o1_lasttime = mysql_fetch_object($v1_lasttime);
$this_points = $o1_lasttime->points;

$v2_lasttime = mysql_query("SELECT * FROM rockinus.user_points WHERE uname='$uname' ORDER BY id DESC LIMIT 2,1");
if(!$v2_lasttime) die(mysql_error());
$o2_lasttime = mysql_fetch_object($v2_lasttime);
$last_points = $o2_lasttime->points;
$points = $this_points - $last_points;
//echo("$this_points - $last_points");

$t_book = mysql_query("SELECT count(*) as cnt FROM rockinus.book_info;");
$a_book = mysql_fetch_object($t_book);
$total_book = $a_book->cnt;

$t_roomMate = mysql_query("SELECT count(*) as cnt FROM rockinus.room_mate_info;");
$a_roomMate = mysql_fetch_object($t_roomMate);
$total_roomMate = $a_roomMate->cnt;

$t_question = mysql_query("SELECT count(*) as cnt FROM rockinus.news_info WHERE category='question';");
$a_question = mysql_fetch_object($t_question);
$total_question = $a_question->cnt;

$people = mysql_query("SELECT count(*) as cnt FROM rockinus.user_check_info WHERE status='A'");
if(!$people)	die("Error quering the Database: " . mysql_error());
$people_f = mysql_fetch_object($people);
$people_cnt = $people_f->cnt;

$friend = mysql_query("SELECT count(*) as cnt FROM rockinus.rocker_rel_info WHERE sender='$uname' OR recipient='$uname'");
if(!$friend)	die("Error quering the Database: " . mysql_error());
$friend_f = mysql_fetch_object($friend);
$friend_cnt = $friend_f->cnt;
$total_unfriend = $people_cnt-$friend_cnt;

$memo = mysql_query("SELECT count(*) as cnt FROM rockinus.memo_info 
						WHERE sender in (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname'
						UNION
						SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname') 
						AND sender <> '$uname' AND descrip<>'NULL' ORDER BY memoid DESC");
if(!$memo)	die("Error quering the Database: " . mysql_error());
$memo_f = mysql_fetch_object($memo);
$memo_f_cnt = $memo_f->cnt;

$pic210_Name = $uname.'210.jpg';
$ProPercent = 70;

$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$hcolor = $object->hcolor;

$cschool_tag = 1;
$cmajor_tag = 1;
$cdegree_tag = 1;
$sterm_tag = 1;
$eterm_tag = 1;
$cstate_tag = 1;
$ccity_tag = 1;
$fcountry_tag = 1;
$fregion_tag = 1;
$ccompany_tag = 1;
$cjobtitle_tag = 1;

$edu_tag = 1;
$work_tag = 1;

$q = mysql_query("SELECT *,user_check_info.email AS uname_email FROM rockinus.user_info INNER JOIN rockinus.user_check_info INNER JOIN rockinus.user_edu_info INNER JOIN rockinus.user_contact_info ON user_info.uname='$uname' AND user_info.uname=user_check_info.uname AND user_info.uname=user_edu_info.uname AND user_info.uname=user_contact_info.uname");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;
$fname = $object->fname;
$lname = $object->lname;
$birthdate = $object->birthdate;
$email = $object->email;
$uname_email = $object->uname_email;

$fcountry = $object->fcountry;
if($fcountry==NULL||strlen(trim($fcountry))==0||$fcountry=='empty'){
	$fcountry_tag = 0;
	$fcountry=NULL;
}

$fregion = $object->fregion;
if($fregion==NULL||strlen(trim($fregion))==0||$fregion=='empty'){
	$fregion_tag = 0;
	$fregion=NULL;
}

$cschool = $object->cschool;
if($cschool==NULL||strlen(trim($cschool))==0||$cschool=='empty'){
	$cschool_tag = 0;
	$cschool=NULL;
}

$cmajor = $object->cmajor;
if($cmajor==NULL||strlen(trim($cmajor))==0||$cmajor=='empty'){
	$cmajor_tag = 0;
	$cmajor=NULL;
}

$cdegree = $object->cdegree;
if($cdegree==NULL||strlen(trim($cdegree))==0||$cdegree=='empty'){
	$cdegree_tag = 0;
	$cdegree=NULL;
}

$sterm = $object->sterm;
if($sterm==NULL||strlen(trim($sterm))==0||$sterm=='empty'){
	$sterm_tag = 0;
	$sterm=NULL;
}

$eterm = $object->eterm;
if($eterm==NULL||strlen(trim($eterm))==0||$eterm=='empty'){
	$eterm_tag = 0;
	$eterm=NULL;
}

$cstate = $object->cstate;
if($cstate==NULL||strlen(trim($cstate))==0||$cstate=='empty'){
	$cstate_tag = 0;
	$cstate=NULL;
}

$ccity = $object->ccity;
if($ccity==NULL||strlen(trim($ccity))==0||$ccity=='empty'){
	$ccity_tag = 0;
	$ccity=NULL;
}

if($ccompany==NULL||strlen(trim($ccompany))==0||$ccompany=='empty'){
	$ccompany_tag = 0;
	$ccompany=NULL;
}

if($cjobtitle==NULL||strlen(trim($cjobtitle))==0||$cjobtitle=='empty'){
	$cjobtitle_tag = 0;
	$cjobtitle=NULL;
}

// Get user posted status
$memo_tag = 0;
$memo_follow_cnt = 0;
$q_memo = mysql_query("SELECT * FROM rockinus.memo_info WHERE sender='$uname' ORDER BY memoid DESC;");
if(!$q_memo) die(mysql_error());
$memo_no_row = mysql_num_rows($q_memo);
if($memo_no_row==0) 
	$status_post = "Nothing...!"; 
else{
	$object = mysql_fetch_object($q_memo);
	$memoid = $object->memoid;
	$descrip = $object->descrip;
	$descrip = str_replace("\\","",nl2br($descrip));
	$status_pdate = $object->pdate;
	$status_ptime = $object->ptime;

	$t = mysql_query("SELECT count(*) AS cnt FROM rockinus.memo_follow_info WHERE memoid='$memoid';");
	$a = mysql_fetch_object($t);
	$memo_follow_cnt = $a->cnt;

	if($descrip==NULL&&$memo_no_row==1){ 
		$status_post = "$fname, Happy New Year! Do you have something to say? Write it down and share with us on the top! Enjoy a better 2013!"; 
		$memo_tag = 1;
	}else
		$status_post = addHyperLink_white($descrip);
}

if(isset($_POST['eduSubmit'])){
  	$upd_edu_stmt = "";
	$upd_contact_stmt = "";
		
	if(isset($_POST['cdegree'])) {
		$tmp_cdegree = $_POST['cdegree'];
		$upd_edu_stmt .= " cdegree='$tmp_cdegree', ";
	} else $tmp_cdegree = $cdegree;
		  	
	if(isset($_POST['cschool'])) {
		$tmp_cschool = $_POST['cschool']; 
		$upd_edu_stmt .= " cschool='$tmp_cschool', ";
	} else $tmp_cschool = $cschool;
				
  	if(isset($_POST['cmajor'])) {
		$tmp_cmajor = $_POST['cmajor']; 
		$upd_edu_stmt .= " cmajor='$tmp_cmajor', ";
	} else $tmp_cmajor = $cmajor;
					
  	if(isset($_POST['sterm'])) {
		$tmp_sterm = $_POST['sterm']; 
		$upd_edu_stmt .= " sterm='$tmp_sterm', ";
	} else $tmp_sterm = $sterm;
		  	
	if(isset($_POST['eterm'])) {
		$tmp_eterm = $_POST['eterm']; 
		$upd_edu_stmt .= " eterm='$tmp_eterm', ";
	} else $tmp_eterm = $eterm;
				  	
	if(isset($_POST['cstate'])) {
		$tmp_cstate = $_POST['cstate']; 
		$upd_contact_stmt .= " cstate='$tmp_cstate', ";
	} else $tmp_cstate = $cstate;
				
	if(isset($_POST['ccity'])) {
		$tmp_ccity = $_POST['ccity']; 
		$upd_contact_stmt .= " ccity='$tmp_ccity', ";
	} else $tmp_ccity = $ccity;
					
	if(isset($_POST['fcountry'])) {
		$tmp_fcountry = $_POST['fcountry']; 
		$upd_basic_stmt .= " fcountry='$tmp_fcountry', ";
	} else $tmp_fcountry = $fcountry;
				
	if(isset($_POST['fregion'])) {
		$tmp_fregion = $_POST['fregion']; 
		$upd_basic_stmt .= " fregion='$tmp_fregion', ";
	} else $tmp_fregion = $fregion;
					
	$upd_basic_stmt = substr(trim($upd_basic_stmt),0,strlen($upd_basic_stmt)-3);
	$upd_edu_stmt = substr(trim($upd_edu_stmt),0,strlen($upd_edu_stmt)-3);
	$upd_contact_stmt = substr(trim($upd_contact_stmt),0,strlen($upd_contact_stmt)-3);
	
	$term_expire = 0;
	$term_num=4;
	
	if($cur_term_year<substr($tmp_sterm,0,4)){
		$term_expire = 1;	
	}
	
	if($tmp_sterm!="empty"&&$tmp_eterm!="empty"){
		if(strlen($tmp_sterm)==8 && strlen($tmp_eterm)==10)
			$term_num = (substr($tmp_eterm,0,4)-substr($tmp_sterm,0,4))*2 - 1;
		else if(strlen($tmp_sterm)==10 && strlen($tmp_eterm)==8)
			$term_num = (substr($tmp_eterm,0,4)-substr($tmp_sterm,0,4))*2 + 1;
		else
			$term_num = (substr($tmp_eterm,0,4)-substr($tmp_sterm,0,4))*2;
	}
	
	if($term_expire==1){
		$_SESSION['profile_err_rst_msg'] = "<strong><font color=#B92828>Please enter correct Enrolled, or Graduate(d) term</font></strong>";
		mysql_close($link);
	}else if(($term_num<2||$term_num>4) && $tmp_cdegree=='Graduate'){
		$_SESSION['profile_err_rst_msg'] = "<strong><font color=#B92828>Graduate duration cannot be shorter than 2 semester and longer than 4 term</font></strong>";
		mysql_close($link);
	}else if($tmp_cschool==NULL||strlen(trim($tmp_cschool))==0||$tmp_cschool=="empty"){
		$_SESSION['profile_err_rst_msg'] = "<strong><font color=#B92828>School is not chosen</font></strong>";
		mysql_close($link);
	}else if($tmp_cdegree==NULL||strlen(trim($tmp_cdegree))==0||$tmp_cdegree=="empty"){
		$_SESSION['profile_err_rst_msg'] = "<strong><font color=#B92828>Degree is not chosen</font></strong>";
		mysql_close($link);
	}else if($tmp_cmajor==NULL||strlen(trim($tmp_cmajor))==0||$tmp_cmajor=="empty"){
		$_SESSION['profile_err_rst_msg'] = "<strong><font color=#B92828>Major is not chosen</font></strong>";
		mysql_close($link);
	}else{
		//include 'dbconnect.php';
		if(strlen($upd_edu_stmt)>0){
			$upd_edu = mysql_query("UPDATE rockinus.user_edu_info SET ".$upd_edu_stmt." WHERE uname='$uname'");
			if(!$upd_edu) die(mysql_error().".........!");
		}
		$cschool = $tmp_cschool;
		$cschool_tag = 1;
		$cmajor = $tmp_cmajor;
		$cmajor_tag = 1;
		$cdegree = $tmp_cdegree;
		$cdegree_tag = 1;
		$sterm=$tmp_sterm;
		$sterm_tag = 1;
		$eterm=$tmp_eterm;
		$eterm_tag = 1;
				
		if(strlen($upd_contact_stmt)>0){
			$upd_contact = mysql_query("UPDATE rockinus.user_contact_info SET ".$upd_contact_stmt.", ccountry='US' WHERE uname='$uname'");
			if(!$upd_contact) die(mysql_error());
		}	
		$cstate = $tmp_state;
		$cstate_tag = 1;
		$ccity = $tmp_ccity;
		$ccity_tag = 1;
						
		if(strlen($upd_basic_stmt)>0){
			$upd_basic = mysql_query("UPDATE rockinus.user_info SET ".$upd_basic_stmt." WHERE uname='$uname'");
			if(!$upd_basic) die(mysql_error());
		}	
		$fcountry = $tmp_fcountry;
		$fcountry_tag = 1;
		$fregion = $tmp_fregion;
		$fregion_tag = 1;
	}
}
				
if(isset($_POST['workSubmit'])){
  	if(isset($_POST['companyname'])) $tmp_companyname = $_POST['companyname']; else $tmp_companyname = $companyname;
  	if(isset($_POST['jobtitle'])) $tmp_jobtitle = $_POST['jobtitle']; else $tmp_jobtitle = $jobtitle;
	if($tmp_companyname=="seekjob") $tmp_jobtitle = $tmp_companyname;
		
	if(isset($_POST['newjobtitle'])&&strlen(trim($_POST['newjobtitle']))>1) 
		$tmp_jobtitle=$_POST['newjobtitle']; 
						
  	if(isset($_POST['newcompanyname'])&&strlen(trim($_POST['newcompanyname']))>1)
		$tmp_companyname=$_POST['newcompanyname']; 
					
  	if($tmp_companyname==NULL||strlen(trim($tmp_companyname))==0||$tmp_companyname=="empty"){
		$_SESSION['profile_err_rst_msg'] = "<strong><font color=#B92828>Company name is not chosen or not entered</font></strong>";
		mysql_close($link);
	}else if($tmp_jobtitle==NULL||strlen(trim($tmp_jobtitle))==0||$tmp_jobtitle=="empty"){
		$_SESSION['profile_err_rst_msg'] = "<strong><font color=#B92828>Job title is not chosen or not entered</font></strong>";
		mysql_close($link);
	}else{
		$_SESSION['profile_err_rst_msg'] = $tmp_companyname;
		if(isset($_POST['newjobtitle'])&&strlen(trim($tmp_newjobtitle))>1){
			$tmp_newjobtitle = $_POST['newjobtitle']; 
			$sql = "INSERT INTO rockinus.job_info (job_title) VALUES($tmp_newjobtitle)";
			$result = mysql_query($sql);
			if (!$result) die('Invalid query: ' . mysql_error());
			$tmp_jobtitle = $tmp_newjobtitle;
		}
							
		if(isset($_POST['newcompanyname'])&&strlen(trim($tmp_newcompanyname))>1){
			$tmp_newcompanyname = $_POST['newcompanyname']; 
			$sql = "INSERT INTO rockinus.company_info (company_name) VALUES($tmp_newcompanyname)";
			$result = mysql_query($sql);
			if (!$result) die('Invalid query: ' . mysql_error());
			$tmp_companyname = $tmp_newcompanyname;
		}
						
		$sql = "INSERT INTO rockinus.user_job_info (uname,job_title,company_name, pdate,ptime) VALUES('$uname','$tmp_jobtitle','$tmp_companyname',CURDATE(), NOW())";
		$result = mysql_query($sql);
		if (!$result) die('Invalid query: ' . mysql_error());
						
		$ccompany = $tmp_companyname;
		$ccompany_tag = 1;
		$cjobtitle = $tmp_jobtitle;
		$cjobtitle_tag = 1;
	}
}

//include 'dbconnect.php';
if($cschool!=NULL){
	$q = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
	if(!$q) die(mysql_error());
	$obj = mysql_fetch_object($q);
	$cschool_id = $cschool;
}else $cschool = NULL;

if($cmajor!=NULL){	
	$q = mysql_query("SELECT * FROM rockinus.major_info where mid='$cmajor'");
	if(!$q) die(mysql_error());
	$obj = mysql_fetch_object($q);
}else $cmajor = NULL;

if($mstatus==NULL) $mstatus = "Unknown Status";

if($cschool_tag==0||$cmajor_tag==0||$cdegree_tag==0||$sterm_tag==0||$eterm_tag==0||$cstate_tag==0||$fcountry_tag==0||$fregion_tag==0) $edu_tag=0;
if($ccompany_tag==0||$cjobtitle_tag==0) $work_tag=0;

$expire_tag = 0;
if(substr($cur_term,0,4)-substr($eterm,0,4)>0) $expire_tag = 1;
else if(substr($cur_term,0,4)==substr($eterm,0,4) && strlen($cur_term)<10 && strlen($eterm)>=10) $expire_tag = 1;

$q = "SELECT count(*) as cnt FROM rockinus.message_info where recipient='$uname'";
$t = mysql_query($q);
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

//$q = mysql_query("SELECT descrip FROM rockinus.memo_info WHERE sender='$uname' ORDER BY memoid DESC");
//$object = mysql_fetch_object($q);
//$default_textarea = $object->descrip;
//if($default_textarea==NULL)$default_textarea = "What you think? Write it down here, share with others.";

//Message Number
$qu = "SELECT count(*) as cnt FROM rockinus.message_info where recipient='$uname' and rstatus='N'";
$tu = mysql_query($qu);
$au = mysql_fetch_object($tu);
$total_unread_items = $au->cnt;

//Friend Number
$friendq = "SELECT count(*) as cnt FROM rockinus.rocker_rel_info where recipient='$uname' OR sender='$uname'";
$friendt = mysql_query($friendq);
$friendu = mysql_fetch_object($friendt);
$total_friend_items = $friendu->cnt;

$wid = ProfileProgress($uname);
?>
<link rel="stylesheet" href="js/demos.css" />
<link rel="stylesheet" href="js/jquery.ui.all.css" title="ui-theme" />
<link href="tab.css" rel="stylesheet">
<script src="js/ajax.jquery.min.js"></script>
<script src="js/jquery.animate-colors-min.js"></script>
<script src="js/jquery.ui.core.js"></script>
<script src="js/jquery.ui.widget.js"></script>
<script src="js/jquery.ui.position.js"></script>
<script src="js/jquery.ui.button.js"></script>
<script src="js/jquery.ui.popup.js"></script>
<script>
function getXMLHTTP() { //fuction to return the xml http object
	var xmlhttp=false;	
	try{
		xmlhttp=new XMLHttpRequest();
	}
	catch(e)	{		
		try{			
			xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e1){
				xmlhttp=false;
			}
		}
	}
		 	
	return xmlhttp;
}
	
function getRegion(strURL)
{         
 var req = getXMLHTTP(); // fuction to get xmlhttp object 
 if (req)
 {
  	req.onreadystatechange = function()
 	{
  		if (req.readyState == 4) { //data is retrieved from server
   			if (req.status == 200) { // which reprents ok status                    
     			document.getElementById('regionDiv').innerHTML=req.responseText;
  			}
  			else
  			{ 
     			alert("There was a problem while using XMLHTTP:\n");
  			}
  		}            
  	}        
	req.open("GET", strURL, true); //open url using get method
	req.send(null);
 	}
}
</script>
<script>
function inputFocus(i){
    if(i.value==i.defaultValue){ i.value=""; i.style.color="#000"; }
}
function inputBlur(i){
    if(i.value==""||i.value==" Write something, share with alumni, maybe new year, study, job, mood... Let\'s go!"){ i.value=i.defaultValue; i.style.color="#888"; }
}
</script>

<script type="text/javascript">
$(function () {
    var $element1 = $('#updateFlash_1');
    var $element2 = $('#updateFlash_2');
    function fadeInOut () {
        $element1.fadeIn("fast",function () {
            $element1.delay(6000).fadeOut(400, function () {
                $element2.fadeIn(50, function () {
	                $element2.delay(6000).fadeOut(400, function () {
    	                setTimeout(fadeInOut, 10);
                	});
				});
            });
        });
    }

    fadeInOut();
});
</script>

<script>
$(document).ready(function(){
	var $elementt1 = $('#updateFlash_1');
	var $elementt2 = $('#updateFlash_2');
	$elementt1.hover(function() {
		$(this).show();
		$elementt2.hide();
	});
	$elementt2.hover(function() {
		$(this).show();
		$elementt1.hide();
	});
});
</script>
<style>
#updateFlash_1, #updateFlash_2 {
position:absolute;
display: none;
}
</style>
<style>
#NewUserDiv {
	margin-top: 0px;
	margin-bottom:5px;
    color: #000000;
    width: 650px;
    padding-top: 2px;
    text-align: left;
	background-color:#FFFFFF;
	background-image:;
	border: 0px solid #DDDDDD;
}

#NewsLetterDiv {
	margin-bottom: 10px;
    width: 650px;
    text-align: left;
	padding-bottom:5px;
	background-color:;
	background-image:;
    border-top: 0px solid #DDDDDD;
	border-bottom: 0px solid #DDDDDD;
	<?php if(isset($_SESSION['NewsLetter']))echo("display:none"); ?>;
	display:none;
}

#postingHistory {
	height: 23px;
    border-top: 1px solid #000000;
	border-bottom: 0px solid #000000;
	border-right: 0px solid #000000;
	padding-left:10px;  
	padding-right:10px; 
	color:#FFFFFF; 
	width: 150px;
	font-size: 14px;
	padding-top:4px;
	font-family:Arial, Helvetica, sans-serif
}

#myNews {
	height: 23px;
    border-top: 1px solid #000000;
	border-bottom: 0px solid #000000;
	border-right: 0px solid #000000;
	padding-top:4px;
	padding-left:10px;  
	padding-right:10px; 
	color:#FFFFFF; 
	width: 175px;
	font-size:14px;
	font-family:Arial, Helvetica, sans-serif
}

#polyNews {
	height: 23px;
    border-top: 1px solid #000000;
	border-bottom: 0px solid #000000;
	border-right: 0px solid #000000;
	padding-left:10px;  
	padding-right:10px; 
	color:#FFFFFF; 
	width: 150px;
	font-size: 14px;
	padding-top:4px;
	font-family:Arial, Helvetica, sans-serif
}

body,td,th {
	font-size: 14%;
}
body {
	background-image: ;
}
</style>
<script type="text/javascript">
	function scrollToBottom() {
		$('html, body').animate({scrollTop:$(document).height()}, 'slow');
	}
	function scrollToTop() {
		$('html, body').animate({scrollTop:0}, 'slow');
	}
</script>
<script type="text/javascript"> 
 function enter(elem){ 
     elem.style.backgroundColor = '#FF0000'; 
 } 
 
 function leave(elem){ 
     elem.style.backgroundColor = '#FFFFFF'; 
 } 
</script> 
<script type="text/javascript" src="js/jquery.min.js"></script>
<script>
$(document).ready(function() {
	$("#SandyLink").click(function () {
	  $("#SandyDiv").hide();
	});
});
</script>
<script>
$(document).ready(function() {  
	$("#EditInfoDiv").hide();  
	$("#NewUserDiv").fadeIn(1000);
	//$("#dailyUpdate").show();

	//$("#HomeDynamicUpdate").slideUp(300).delay(10).fadeIn(400);
	//$("#HomeDynamicUpdate").fadeOut(100);
    $("#HomeDynamicUpdate").fadeIn(500);
    //$("#HomeDynamicUpdate").fadeOut(400);
    //$("#HomeDynamicUpdate2").fadeIn(400);

//	$("#HomeDynamicUpdate").slideDown("slow");
	//fadeOut(400).show("slide", { direction: "down" }, 500).fadeOut(400).show("slide", { direction: "up" }, 500).fadeOut(400).show("slide", { direction: "down" }, 500).fadeOut(400).fadeIn(400);

	$("#profileBarDiv").hover(function () {
	  $("#profileBarDiv").hide();
	  $("#EditInfoDiv").show();
	  //$("#joinUsDiv").show("slide", { direction: "up" }, 500);
	});

	$("#EditInfoDiv").mouseleave(function () {
	  $("#EditInfoDiv").hide();
	  $("#profileBarDiv").show();
	  //$("#joinUsDiv").show("slide", { direction: "up" }, 500);
	});
});
</script> 
<div align="center" style="width:100%">
 <div align="center" style="width:1024px; background-color:#FFFFFF; border-left:0px solid #DDDDDD; border-right:0px solid #DDDDDD"> 
  <div style="right:1%; position: fixed; z-index:1; bottom:10%; padding-bottom:0; background:; display:inline; padding:5 10 5 10; opacity:0.7; filter:alpha(opacity=70);" align="right">
  <a href="javascript:scrollToTop()" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold"><img src="img/goupIcon.jpg" width="70"/></a>
  </div>
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="300" align="left" valign="top" style=" border-right:0px dashed #DDDDDD;">
	  <?php include("leftHomeMenu.php"); ?>
	  </td>
	  <td width="760"><table border="0" cellspacing="0" cellpadding="0" width="760">
        <tr>
          <td width="660" valign="top" align="right" style="border-right:0px #DDDDDD solid">
		  <?php include("HeaderEN_home.php") ?>
		  </td>
        </tr>
        <tr>
          <td valign="top" align="right" style="border-right:0px #DDDDDD solid">
		  <table border="0" cellpadding="0" cellspacing="0" style=" display:none; margin-bottom:15; border:12px solid #EEEEEE; width:760" class="SandyDiv" id="SandyDiv">
		  <tr>
		  <td style="background:#FFFFFF; color:#FF0000; font-size:16px; padding:15; line-height:100%; font-family:Arial, Helvetica, sans-serif; border:1px solid #CCCCCC;" align="left">
		  <strong>Emergent Announcement,</strong>&nbsp;&nbsp;&nbsp;
		  <div class="SandyLink" id="SandyLink" style=" color:#000000; font-size:13px; color:#999999; cursor:pointer; display:inline">
		  <u>(Got it)</u></div>
		  <br /><br />
		  <font style="font-size:14px; color:#000000">
		  Hurricane Sandy has visited Northeastern America, many areas experienced different levels of damages.<br />
		  NYU-Poly has been closed due to this, and will be opened from next Monday(11.05.2012).<br />
		  We look forward to see you soon. If you need any help please <a href="reportIssue.php" class="one">report us</a>. Stay good.<br />
		  <br />
		  Rockinus Team<br />
		  10.29.2012
		  </font>
		  </td></tr></table>
		  
            <div class="NewsLetterDiv" id="NewsLetterDiv" style="width:760px">
              <table width="760" height="35" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid; margin-bottom:0px; margin-top:0px;">
                <tr>
                  <td width="618" height="30" valign="top" align="left" style="border-bottom:0px #DDDDDD solid; padding-top:0px; padding-bottom:0px" bgcolor="#FFFFFF"><table width="72" height="30" border="0" cellpadding="0" cellspacing="0" id="notice" style="margin-left:0px; width:600; border-bottom:0px #DDDDDD solid">
                      <tr>
                        <td width="35" align="left" style="padding-left:5px"><img src="img/letterIcon.jpg" height="18" /> </td>
                        <td width="565" align="left" style="padding-left:10"><?php if($_SESSION['lan']=='CN')
				  echo("<font size=2 color=white><strong>来自开发团队的问候</strong></font>");
				  else if($_SESSION['lan']=='EN')
				  echo("<font size=3 color=#333333><strong><span id=n1>A Greeting Letter to Everyone [From Rockinus team]</span></strong></font>&nbsp;&nbsp;");
				  echo("&nbsp;&nbsp;&nbsp;<span id=n2 style='border-bottom:0px #999999 dashed'><a href=#><font size=2 color=$_SESSION[hcolor]></font></a></span>&nbsp;&nbsp;");
				  ?>
                        </td>
                      </tr>
                  </table></td>
                  <td width="30" height="25" align="right" valign="middle" style="padding-right:0px; color:#FFFFFF; border-bottom:0px solid #DDDDDD; font-size:18px" bgcolor="#FFFFFF"><script type="text/javascript">
 	$(document).ready(function(){
		$(".NewsLetterDiv .deleteNewsDiv").click(function(){
 		$(this).parents(".NewsLetterDiv").animate({ opacity: 'hide' }, "slow");
		<?php 
		$_SESSION['NewsLetter'] = "Y";
		?>
 	});
 });
            </script>
                      <script>  
	$("div#notice span#n1").click(function () {
		var ctnt = $("div#firstcontent").html();
			$("div#firstcontent").html("<font size=2>The website has just been published, there may be more or less imperfection with it. We appreciate your understanding and support. Please let us know any suggestions you have thru the using experience. A combination of thanks to everyone, we will make it a better place for you. <a href=forumDetail.php?foid=1 class=one><strong><font color=$_SESSION[hcolor]>Comment us >></font></strong></a></font>");
	});
              </script>
                      <script>  
	$("div#notice span#n2").click(function () {
		$("div#firstcontent").html("<img src=img/greenstartopi.jpg style='margin-top:5px;line-height:100%' />&nbsp;&nbsp;<font size=2>Setup for block display order. &nbsp;&nbsp;&nbsp;&nbsp;<a href=UserSetting.php class=one><strong><font color=#B92828>Check details >>></font></strong></a></font>");
	});
              </script>
                      <div style="display:inline; background-color:#; padding-left:0px; padding-right:5px" align="left" id="left1"> <a href="#"> <img src="img/deleteDiv.jpg" alt="delete" class="deleteNewsDiv" style='border:1px solid #666666' height="18px" width="18px"/></a></div></td>
                </tr>
                <tr>
                  <td height="14" colspan="2" valign="bottom" style="padding:5px; padding-left:2; padding-top:5; line-height:150%; font-size:14px" bgcolor=""><div id="firstcontent">
                      <?php if($_SESSION['lan']=='CN')
				  echo("<font size=2>网站刚刚发布上线，一定会有许多不足之处，希望大家多多关照，提些宝贵建议。如发现使用中有各类问题，请马上告知我们。非常感谢每位同学的关注，我们会加油再加油，把小站做的更加完善. <a href=forumDetail.php?foid=1 class=one><strong><font color=$_SESSION[hcolor]>现在留言>></font></strong></a></font></font>");
				  else if($_SESSION['lan']=='EN')
				  echo("<font color=#000000>The website has recently been released, we would like to say \"great thanks!\" for everyone's join. <br>Due to the limited workforce and hours, there may be still some bugs with the site that we need to correct.<br> For this sake, please <a href='reportIssue.php'><strong><u><font color=black>Report us</font></u></strong></a> for any issues or suggestions found through your using experience.<br> Apologize for any inconvenience, while we keep improving and will dedicate it a better place for you. </font>") ?>
                  </div></td>
                </tr>
              </table>
            </div>
			
			<?php 
	$status_sel = mysql_query("SELECT * FROM rockinus.memo_info WHERE sender='$uname' ORDER BY memoid DESC");
	if(!$status_sel){
		$output = mysql_error();
		echo($output);
	}	
	
	$status_object = mysql_fetch_object($status_sel);
	$memoid = $status_object->memoid;
	$status_pdate = $status_object->pdate;
	$status_ptime = $status_object->ptime;
	
	$status_follow_sel = mysql_query("SELECT * FROM rockinus.memo_follow_info WHERE memoid='$memoid' ORDER BY memoid DESC");
	if(!$status_follow_sel){
		$output = mysql_error();
		echo($output);
	}
	$status_follow_num = mysql_num_rows($status_follow_sel);

	$status_descrip = $status_object->descrip;
	if(strlen($status_descrip)>85)
		$status_descrip = substr(addHyperLink($status_descrip),0,100)."...";
	else
		$status_descrip = addHyperLink($status_descrip);	
	?>
			<div id='publishStatusTable' class='publishStatusTable'>
			<table width="760" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:20px;  background: url(img/GrayGradbgDown.jpg); padding-top:10; padding-bottom:10; border:0px solid #DDDDDD; border-left:0">
  <tr>
    <td width="55" valign="top" align="left" style="padding-left:10px">
	<img src="img/Scale-pencil.png" width="35" /></td>
    <td width="603" valign="top" style=" padding-left:0" align="left">
	<textarea id="newStatusContent" class="newStatusContent" style="width:600px; height:35px; border:0; border:3px solid #CCCCCC; font-size:14px; font-family:Georgia, 'Times New Roman', Times, serif; padding:3; position:absolute; color:#888888" onclick="this.style.height = '85px'; if(this.value==' Write something, share with alumni, maybe new year, study, job, mood... Let\'s go!')this.value=''" onFocus="this.style.height = '85px'; this.select(); inputFocus(this)" onBlur="this.style.height = '35px'; this.value=!this.value?' Write something, share with alumni, maybe new year, study, job, mood... Let\'s go!':this.value; inputBlur(this)"> Write something, share with alumni, maybe new year, study, job, mood... Let's go!</textarea>
	</td>
    <td width="80" valign="top" style=" padding-top:8px; padding-left:10px" align="left">
	<script type="text/javascript" >
	$(function() {
	$(".publishStatusBtn").click(function() {
		var test = $("#newStatusContent").val();
		var pdate = '<?php echo(date('Y-m-d')) ?>';
		var ptime = '<?php echo(date("H:i:s", time())) ?>';
		var sender = '<?php echo($uname) ?>';
		var dataString = 'content='+ test+'&sender='+sender+'&pdate='+pdate+'&ptime='+ptime; 
		
		if(test==''||test==' Write something, share with alumni, maybe new year, study, job, mood... Let\'s go!')
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
	<div class="publishStatusBtn" id="publishStatusBtn" style=" height:15px; padding:7 10 7 10; background: #CC6600; display: inline; width:60px; border:1px solid #000000; font-size:14px; cursor:pointer; font: Georgia, 'Times New Roman', Times, serif; color:#FFFFFF" align="center" onmouseover="this.style.background='#C35617'" onmouseout="this.style.background='#CC6600'">Publish</div>
	</td>
  </tr>
</table>
<div style=" width:760px; display:none; height:25px; " align="center" id="postStatusHeader">
<div style=" width:600px; height:25px; background:#EEEEEE; border-top:1px solid #CCCCCC; border-bottom:1px solid #CCCCCC;">
fadsfdfdsafa
</div>
</div>
</div>

<div id="flashStatusMemo" class="flashStatusMemo" style="margin-top:15; margin-bottom:15;"></div>
<div id="displayStatusMemo" class="displayStatusMemo" style="width:760; margin-bottom:15;"></div>

            <table width="760" height="265" border="0" cellpadding="0" cellspacing="0" bgcolor="" style="margin-bottom:20px; border-top:0px solid #CCCCCC; border-bottom:0px solid #CCCCCC">
			<tr>
			<td width="350" height="265" valign="top">
			<table width="350" height="234" border="0" cellpadding="0" cellspacing="0" background="img/HomeCoverRect_
			<?php echo(substr($_SESSION['hcolor'],1,6));
			//echo("387A36");
			 ?>.jpg" bgcolor="#FFFFFF" style="background-repeat: no-repeat; border-bottom:1px solid #DDDDDD">
			<tr><td height="55" valign="top" style="height:40; line-height:150%; width:340px; font-size:24px; font-weight:bold; background: #F5F5F5; color:<?php echo($_SESSION['hcolor']); ?>; border-bottom:1px #CCCCCC solid; border-top:0px #CCCCCC solid; padding:5; padding-left:0; padding-top:7; font-family:Georgia, 'Times New Roman', Times, serif">
			&nbsp;<?php echo($fname) ?>, Happy New Year!
			</td>
			</tr>
			<tr>
			  <td height="127" valign="top" align="left" style="padding-left:10px; padding-bottom:">
			  <?php if($replied_cnt>0){ ?>
			  <div style=" background:#FFCC66; width:105px; height:15px; margin-bottom:0; font-size:12px; padding:5 0 5 7; font-family: Geneva, Arial, Helvetica, sans-serif; border:1px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:10; opacity:0.9; filter:alpha(opacity=85);">
			  <a href="recentUpdates.php" class="one">
			  <strong>Recent (<?php echo($replied_cnt) ?>)</strong></a>			  
			  </div>
			  <?php }else{ ?>
			  <div style=" background:#F5F5F5; width:105px; height:15px; margin-bottom:0; font-size:12px; padding:5 0 5 7; font-family: Geneva, Arial, Helvetica, sans-serif; border:1px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:10; opacity:0.9; filter:alpha(opacity=85);">
			  <a href="recentUpdates.php" class="one">
			  Recent (<?php echo($replied_cnt) ?>)</a>			  
			  </div>
			  <?php } ?>
			  
			  <?php if($cnt_unread_msg>0){ ?>
			  <div style=" background: #FFCC66; width:105px; height:15px; margin-bottom:0; font-size:12px; padding:5 0 5 7; font-family:Geneva, Arial, Helvetica, sans-serif; border:1px dashed #999999; border-top:0px; border-right:0px; border-left:0px;  margin-top:0;">
			  <a href="MessageList.php" class="one"><strong>Message (<?php echo($cnt_unread_msg."/".$cnt_msg) ?>)</strong></a>
			  </div>
			  <?php }else{ ?>
			  <div style=" background:#F5F5F5; width:105px; height:15px; margin-bottom:0; font-size:12px; padding:5 0 5 7; font-family:Geneva, Arial, Helvetica, sans-serif; border:1px dashed #999999; border-top:0px; border-right:0px; border-left:0px;  margin-top:0; opacity:0.9; filter:alpha(opacity=85);">
			  <a href="MessageList.php" class="one">Message (<?php echo($cnt_unread_msg."/".$cnt_msg) ?>)</a>
			  </div>
			  <?php } ?>
			  
			  <?php if($cnt_friend_rqst>0){ ?>
			  <div style=" background: #FFCC66; width:105px; height:15px; margin-bottom:0; font-size:12px; padding:5 0 5 7; font-family:Geneva, Arial, Helvetica, sans-serif; border:1px dashed #999999; border-top:0px; border-right:0px; border-left:0px;  margin-top:0;">
			  <a href="FriendGroup.php?friendreq=1" class="one"><strong>Request (<?php echo($cnt_friend_rqst."/".$friend_cnt) ?>)</strong></a>
			  </div>
			  <?php }else{ ?>
			  <div style=" background:#F5F5F5; width:105px; height:15px; margin-bottom:0; font-size:12px; padding:5 0 5 7; font-family:Geneva, Arial, Helvetica, sans-serif; border:1px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0;opacity:0.9; filter:alpha(opacity=85);">
			  <a href="FriendGroup.php?friendreq=1" class="one">Request (<?php echo($cnt_friend_rqst."/".$friend_cnt) ?>)</a>
			  </div>
			  <?php } ?>
			  
			  <div style=" background:#F5F5F5; width:105px; height:15px; margin-bottom:5; font-size:12px; padding:5 0 5 7; font-family:Geneva, Arial, Helvetica, sans-serif; border:0px dashed #CCCCCC; border-top:0px; border-right:0px; border-left:0px; margin-top:0;opacity:0.9; filter:alpha(opacity=85);">
			  <a href="ManageCourse.php" class="one">My Courses (<?php echo($total_course_subs) ?>)</a></div>
			  </td>
			  </tr>
			<tr>
			  <td height="32" valign="top" align="left" style="padding-left:10px; padding-bottom:10px"><div style=" background:#666666; width:320px; padding:5; font-size:14px; font-family: Georgia, 'Times New Roman', Times, serif;  border-top:1px solid #333333;  border-bottom:1px solid #333333; margin-top:10px; line-height:100%; color:#FFFFFF; opacity:0.9; filter:alpha(opacity=85);">
                <?php 
				if($memo_tag==1){
					echo("<font style='font-size:16px; line-height:120%'>$status_post</font>");
				}else{
					if(strlen($status_post)<30) 
						echo("<a href='UpdateWall.php'><font style='font-size:24px; line-height:135%'>$status_post</font></a> &nbsp;<font style='font-size:16px; color:#DDDDDD'>(".getDateName($status_pdate)." | ".substr($status_ptime,0,5).")</font><div style='width:300px; margin-top:5px; margin-bottom:5px' align='right'>-- $fname | $memo_follow_cnt Comments</div>");
					else if(strlen($status_post)<50) 
						echo("<a href='UpdateWall.php'><font style='font-size:16px; line-height:135%'>$status_post</font></a> &nbsp;<font style='font-size:14px; color:#DDDDDD'>(".getDateName($status_pdate)." | ".substr($status_ptime,0,5).")</font><div style='width:300px; margin-top:5px' align='right'>-- $fname | $memo_follow_cnt Comments</div>");
					else if(strlen($status_post)<80)
						echo("<a href='UpdateWall.php'><font style='font-size:14px; line-height:135%'>".substr($status_post,0,80)."...</font></a> &nbsp;<font style='font-size:11px; color:#DDDDDD'>(".getDateName($status_pdate)." | ".substr($status_ptime,0,5).")</font><div style='width:300px; margin-top:5px' align='right'>-- $fname | $memo_follow_cnt Comments</div>");
					else if(strlen($status_post)<100)
						echo("<a href='UpdateWall.php'><font style='font-size:13px;line-height:140%'>".substr($status_post,0,100)."...</font></a> &nbsp;<font style='font-size:11px; color:#DDDDDD'>(".getDateName($status_pdate)." | ".substr($status_ptime,0,5).")</font><div style='width:300px; margin-top:5px; margin-bottom:5px' align='right'>-- $fname | $memo_follow_cnt Comments</div>");
					else
						echo("<a href='UpdateWall.php'><font style='font-size:11px'>".substr($status_post,0, 120)."...</font></a> &nbsp;<font style='font-size:11px; color:#DDDDDD'>(".getDateName($status_pdate)." | ".substr($status_ptime,0,5).")</font><div style='width:300px; margin-top:5px' align='right'>-- $fname | $memo_follow_cnt Comments</div>");	 
				}?>
              </div></td>
			  </tr>
			</table>
			
			<div  id="updateFlash_1" class="updateFlash_1" style="display: block">
			<table width="350" height="80" border="0" cellpadding="0" cellspacing="0" background="img/GrayGradbgDown.jpg" style="margin-top:10px; background:; border-bottom:1px solid #DDDDDD; border-top:1px solid #DDDDDD">
              <tr>
                <td style="padding:5 0 5 0">
				<div style="font-size:11px; font-family:Arial, Helvetica, sans-serif; padding:0 0 4 0; height:15px">
				<img src="img/littleMail.png" width="11" /> &nbsp;&nbsp;<a href="MessageDetail.php?msgid=1" class="one">Welcome to Rockinus Community Network</a>
				(Yesterday)</div>
				<div style="font-size:11px; font-family:Arial, Helvetica, sans-serif; padding:0 0 4 0; height:15px">
				<img src="img/littleMail.png" width="11" /> &nbsp;&nbsp;<a href="EditProfile.php" class="one">Your Current profile completeness <strong><?php echo($wid)?>%</strong> - Edit</a>
				(Reminder)				</div>
				<div style="font-size:11px; font-family:Arial, Helvetica, sans-serif; padding:0 0 4 0; height:15px">
				<img src="img/littleMail.png" width="11" /> &nbsp;&nbsp;<a href="MajorDetail.php?sid=NYPOLY&&mtype=Master&&mid=ECS" class="one">Computer Science course board
				now has <strong>2</strong> memory questions</a>
				</div>
				<div style="font-size:11px; font-family:Arial, Helvetica, sans-serif; padding:0 0 0 0; height:15px">
				<img src="img/littleMail.png" width="11" /> &nbsp;&nbsp;Rockinus.com Welcome your join
				  <span style="font-size:11px; font-family:Arial, Helvetica, sans-serif; padding:0 0 4 0; height:15px"> (Yesterday, 20:00)</span></div>
				</td>
                </tr>
            </table>
			</div>
			
			<div id="updateFlash_2" class="updateFlash_2">
			<table width="350" height="80" border="0" cellpadding="0" cellspacing="0" background="img/GrayGradbgDown.jpg" style="margin-top:10px; background:; border-bottom:1px solid #DDDDDD; border-top:1px solid #DDDDDD;">
              <tr>
                <td style="padding:5 0 5 0">
				<?php
		mysql_query("SET NAMES GBK");
		$interview_q = mysql_query("SELECT * FROM rockinus.interview_question ORDER BY q_id DESC LIMIT 0,4");
		if(!$interview_q) die(mysql_error());
		$interview_no_row = mysql_num_rows($interview_q);
		
		if ($interview_no_row == 0)echo("<div style='background-color:#FFFFFF; border: 1 dashed #DDDDDD; width:300px; padding-top:10px; padding-bottom:10px' align='center'><font color=black size=3><strong>No interview question found with your search<p> <a href='postInterviewQuestion.php' class='one'>>> <font color=#B92828>Post a New Question</font></a> </strong></font></div>");
		
		while($object = mysql_fetch_object($interview_q)){
			$q_id = $object->q_id;
			$companyname = $object->company;
			$jobtitle = $object->position;
			$positionCategory = $object->positionCategory;
			$category = $object->category;
			$loopname = $object->creater;
			$descrip = $object->descrip;
			$descrip = nl2br($descrip);
			$descrip = str_replace("\\","",$descrip);
			$descrip = substr($descrip,0,120)."...";
			$qdate = $object->qdate;
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			?>
					<div style="font-size:11px; font-family:Arial, Helvetica, sans-serif; padding:0 0 4 0; height:15px"> <img src="img/comment_user.png" width="11" /> 
					&nbsp;&nbsp;<a href="interviewQuestionDetail.php?q_id=<?php echo($q_id) ?>" class="one"><?php echo("<font style='color:$_SESSION[hcolor]; font-weight:bold'>$companyname</font> | $category | $jobtitle | ".getDateName($pdate)) ?>
					</div>
			<?php
			}
			?>
				  </td>
              </tr>
            </table>
			</div>
			
			</td>
			<td width="410" colspan="2" valign="top" style="padding-top:0; padding-right:5; color: <?php echo($_SESSION['hcolor']); ?>; font-weight:bold; font-size:14px; background:; line-height:150%;" align="right"><table width="390" height="78" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style=" border:0px dashed #CCCCCC; border-top:1px solid #DDDDDD; background-repeat: repeat-x;">
              <tr>
                <td width="305" height="30" valign="top" background="" style="padding-top:7; padding-left:8; border:0px solid #EEEEEE; border-bottom:0px solid #DDDDDD; font-size:14px; font-weight:bold; color:#000000; background:url(img/<?php echo(substr($_SESSION['hcolor'],1,6)."_MenuBar.jpg") ?>)">
				&nbsp;<a href="newsList.php" class="" style=" color:">What's going on?</a></td>
                <td width="85" height="30" align="right" valign="top" background="img/<?php echo(substr($_SESSION['hcolor'],1,6)."_MenuBar.jpg") ?>" style="padding-top:7; padding-right:10; border:0px solid #EEEEEE; border-bottom:0px solid #DDDDDD; font-size:13px; font-weight:bold; color:#EEEEEE">
				<a href="createNews.php" class=""><font color="">+ Publish</font></a>				</td>
              </tr>
              <tr>
                <td height="43" colspan="2" valign="top" style="padding-top:7; padding-bottom:0; border:0px solid #EEEEEE; border-bottom:0px solid #DDDDDD; border-top:1px #999999 solid; background:; background-repeat:repeat-x;"><div id="HomeDynamicUpdate" class="HomeDynamicUpdate" style="border:0px solid #DDDDDD; height:320">
                  <?php include "HomeDynamicUpdate.php"; ?>
                </div></td>
              </tr>
            </table></td>
			</tr>
			</table>
			<?php include "Home_popular.php"; ?>
			<table width="760" height="670" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:15px">
              <tr>
                <td width="380" align="left" valign="top" style="border-left:0px solid #DDDDDD">
				<div id="HomeLatestUpdate" class="HomeLatestUpdate" style=" width:360">
				<?php include "HomeRoomUpdate.php"; ?>
				</div>				</td>
                <td width="380" align="left" valign="top" style="padding-left:0px">
				<div id="HomeLatestUpdate" class="HomeLatestUpdate" style="display:inline">
				<?php include "HomeSaleUpdate.php"; ?>
				</div>				
				</td>
                </tr>
            </table>
            <script type="text/javascript">
function changeColor(id, color) {
element = document.getElementById(id);
event.cancelBubble = true;
oldColor = element.currentStyle.background;
element.style.background = color;
}
            </script>
            <?php 
		  	$q = mysql_query("SELECT priority FROM rockinus.user_setting WHERE uname='$uname'");
			$object = mysql_fetch_object($q);
			$priority = $object->priority;
			if($priority=="D"){
		?>
<table width="760" height="30" border="0" cellpadding="0" cellspacing="0" background="" style="margin-top:<?php 
				  if( ProfileProgress($uname) < $ProPercent )echo("5px"); else echo("0px");
				  ?>; margin-right:0px; margin-bottom:0px; border-bottom:0px #DDDDDD solid;">
              <tr>
                <td width="170" height="30" align="left" valign="middle"><div id="myNews" class="News" onClick="enter(this);" align="center"> <a href="myDefaultAjax2">Friends' Latest Updates</a> </div></td>
                <td width="169" height="30" align="left" style="padding-left:1px" valign="middle"><div id="polyNews" class="News" onMouseOver="this.style.cursor='hand'" align="center"> <a href="DefaultAjax2">Every People Rock</a> </div></td>
                <td width="223" height="30" align="left" style="padding-left:1px" valign="middle"><div id="postingHistory" onMouseOver="this.style.cursor='hand'" align="center"> <a href="postingHistory">My Posting History</a> </div></td>
                <td width="178" align="right" style="padding-right:5px; border-bottom:0px #DDDDDD solid"><?php 
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
	SELECT count(*) as total FROM rockinus.rocker_rel_info
) as cnt";

$t = mysql_query($sel_count);
if(!$t) die("Error quering the Database: " . mysql_error());
 
$a = mysql_fetch_object($t);
$t_cnt = $a->cnt;
if($_SESSION['lan']=="CN") echo("<font size=2 color=$_SESSION[hcolor]><strong><span style='background-color: #EEEEEE'>最近有".$t_cnt."件事儿</span></strong></font>");
else 
//echo("<font size=2 color=$_SESSION[hcolor]><strong><span style='background-color: ; padding:2px'>About ".$t_cnt." Updates</span></strong></font>");
; ?></td>
              </tr>
            </table>
            <div id="content" align="right"></div>
            <div id="flashContent" class="flashContent" align="center"></div>
            <script type="text/javascript">
				$(document).ready(function(){
					//initial
					$("#myNews").css('background-color',"<?php echo($_SESSION['hcolor']) ?>");
					$("#polyNews").css('background-color',"#999999");
					$("#postingHistory").css('background-color',"#999999");
					$('#content').load('myDefaultAjax2.php');
					
					//handle menu click
					$("#myNews a").click(function(){
						//$("#content").hide();
						$("#flashContent").show();
						$("#flashContent").fadeIn(400).html('<img src="img/loading42.gif" align="absmiddle">');
						
						var page=$(this).attr('href');
						$('#content').load(page+'.php');
						
						$("#flashContent").hide();
						$("#content").show();
						$("#myNews").css('background-color',"<?php echo($_SESSION['hcolor']) ?>");
						$("#polyNews").css('background-color',"#999999");
						$("#postingHistory").css('background-color',"#999999");
//						this.style.backgroundColor = '#F5F5F5';
						return false;
					});
					
					$('#polyNews a').click(function(){
						var page=$(this).attr('href');
						//$('#nav li span').css('background-color',"<?php echo($_SESSION['hcolor']) ?>");
						$('#content').load(page+'.php');
						$("#myNews").css('background-color',"#999999");
						$("#polyNews").css('background-color',"<?php echo($_SESSION['hcolor']) ?>");
						$("#postingHistory").css('background-color',"#999999");
						return false;
					});
					
					$('#postingHistory a').click(function(){
						var page=$(this).attr('href');
						//$('#nav li span').css('background-color',"<?php echo($_SESSION['hcolor']) ?>");
						$('#content').load(page+'.php');
						$("#myNews").css('background-color',"#999999");
						$("#polyNews").css('background-color',"#999999");
						$("#postingHistory").css('background-color',"<?php echo($_SESSION['hcolor']) ?>");
						return false;
					});
				});
			</script>
            <?php
				   }else if( strlen($priority) >1 ){
						
					 }
					 
					 ?></td>
        </tr>
      </table>
      </td>
    </tr>
  </table>
  </div>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
