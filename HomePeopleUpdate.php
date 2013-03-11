<?php
include 'dbconnect.php';
include("Allfuc.php");

$sql_stmt = "SELECT * FROM rockinus.user_info a 
			JOIN rockinus.user_check_info b 
			ON b.status='A' AND a.uname<>'harvey' AND a.uname<>'akkking' AND a.uname=b.uname 
			ORDER BY b.signup_date DESC,b.signup_time DESC";
//echo($sql_stmt);
$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("New People are coming soon!");
$i = 1;
$user_array = array();
while($object = mysql_fetch_object($q)){
	$loopName = $object->uname;
	$target = "upload/".$loopName;
	if(is_dir($target)){
		array_push($user_array, $loopName);
		$i++;
	}
	
	if($i==5)break;
}
?>

<?php
$loopName = $user_array[0];
$sql_stmt = "SELECT * FROM rockinus.user_info a 
			JOIN rockinus.user_check_info b  
			JOIN rockinus.user_edu_info c  
			JOIN rockinus.user_contact_info d 
			ON a.uname='$loopName' AND a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname 
			ORDER BY b.signup_date,b.signup_time DESC";
$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
$object = mysql_fetch_object($q);
$fname = $object->fname;
$lname = $object->lname;
$pic100_Name = $loopName.'60.jpg';		
$cstate = $object->cstate;
$ccity = $object->ccity;
$fcountry = $object->fcountry;
$fregion = $object->fregion;
$pdate = $object->signup_date;
//$ptime = $object->signup_time;
$points = $object->points;
if($ccity=="Select a City" || strlen($ccity)==0)$ccity="Somewhere";
if($cstate=="em" || strlen($cstate)==0)$cstate="USA";
$target = "upload/".$loopName;
?>
<table width="450" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="237" style="padding-left:20" align="left">
	<table width="210" height="35" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:3; border-bottom:0px solid #DDDDDD" onmouseover="this.style.backgroundColor='#F5F5F5';" onmouseout=" this.style.backgroundColor='#EEEEEE';">
      <tr>
        <td width="60" align='left' valign='top' style="color:#000000; font-size:14px"><?php
		//echo("<img src=upload/$loopName/$pic100_Name?".time()." width=50 style='border:0px solid #EEEEEE'>");
		echo("<div style='background: url(upload/$loopName/$pic100_Name?".time()."); margin-right:; width:50; height:50'>");
	?>        </td>
        <td width="150" align='left' valign='top' style="color:#006699; font-size:11px;padding-left:10px; font-weight:bold; line-height:160%; padding-top:0"><?php echo("$fname $lname") ?> <br />
            <font style="font-weight:normal; color:#000000"><?php echo("$ccity, $cstate") ?></font> <br />
            <div style="margin-top:0; font-weight:normal; color:#000000">
              <?php
	$qmajor = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid=(SELECT cmajor FROM rockinus.user_edu_info WHERE uname='$loopName');");
									if(!$qmajor) die(mysql_error());
									$o = mysql_fetch_object($qmajor);
									$major_name = $o->major_name;
									if( strlen($major_name)>0 && $major_name!=NULL ){
										$x = array();
										$x = explode(" ",$major_name);
										$major_name = $x[0]." ".$x[1];
										echo("$major_name");
									}else 
										echo("Joined@".getDateName($pdate));
	?>
          </div></td>
      </tr>
    </table></td>
    <td width="213">
	<?php
$loopName = $user_array[1];
$sql_stmt = "SELECT * FROM rockinus.user_info a 
			JOIN rockinus.user_check_info b  
			JOIN rockinus.user_edu_info c  
			JOIN rockinus.user_contact_info d 
			ON a.uname='$loopName' AND a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname 
			ORDER BY b.signup_date,b.signup_time DESC";
$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
$object = mysql_fetch_object($q);
$fname = $object->fname;
$lname = $object->lname;
$pic100_Name = $loopName.'60.jpg';		
$cstate = $object->cstate;
$ccity = $object->ccity;
$fcountry = $object->fcountry;
$fregion = $object->fregion;
$pdate = $object->signup_date;
//$ptime = $object->signup_time;
$points = $object->points;
if($ccity=="Select a City" || strlen($ccity)==0)$ccity="Somewhere";
if($cstate=="em" || strlen($cstate)==0)$cstate="USA";
$target = "upload/".$loopName;
?>

	<table width="210" height="35" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:3; border-bottom:0px solid #DDDDDD" onmouseover="this.style.backgroundColor='#F5F5F5';" onmouseout=" this.style.backgroundColor='#EEEEEE'">
      <tr>
        <td width="60" align='left' valign='top' style="color:#000000; font-size:14px"><?php
		//echo("<img src=upload/$loopName/$pic100_Name?".time()." width=50 style='border:0px solid #EEEEEE'>");
		echo("<div style='background: url(upload/$loopName/$pic100_Name?".time()."); margin-right:; width:50; height:50'>");
	?>        </td>
        <td width="210" align='left' valign='top' style="color:#006699; font-size:11px;padding-left:10px; font-weight:bold; line-height:160%; padding-top:0"><?php echo("$fname $lname") ?> <br />
            <font style="font-weight:normal; color:#000000"><?php echo("$ccity, $cstate") ?></font> <br />
            <div style="margin-top:0; font-weight:normal; color:#000000">
              <?php
	$qmajor = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid=(SELECT cmajor FROM rockinus.user_edu_info WHERE uname='$loopName');");
									if(!$qmajor) die(mysql_error());
									$o = mysql_fetch_object($qmajor);
									$major_name = $o->major_name;
									if( strlen($major_name)>0 && $major_name!=NULL ){
										$x = array();
										$x = explode(" ",$major_name);
										$major_name = $x[0]." ".$x[1];
										echo("$major_name");
									}else 
										echo("Joined@".getDateName($pdate));
	?>
          </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="padding-top:15px; padding-left:20px" align="left" valign="top">
	<?php
$loopName = $user_array[2];
$sql_stmt = "SELECT * FROM rockinus.user_info a 
			JOIN rockinus.user_check_info b  
			JOIN rockinus.user_edu_info c  
			JOIN rockinus.user_contact_info d 
			ON a.uname='$loopName' AND a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname 
			ORDER BY b.signup_date,b.signup_time DESC";
$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
$object = mysql_fetch_object($q);
$fname = $object->fname;
$lname = $object->lname;
$pic100_Name = $loopName.'60.jpg';		
$cstate = $object->cstate;
$ccity = $object->ccity;
$fcountry = $object->fcountry;
$fregion = $object->fregion;
$pdate = $object->signup_date;
//$ptime = $object->signup_time;
$points = $object->points;
if($ccity=="Select a City" || strlen($ccity)==0)$ccity="Somewhere";
if($cstate=="em" || strlen($cstate)==0)$cstate="USA";
$target = "upload/".$loopName;
?>
      <table width="210" height="35" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:3; border-bottom:0px solid #DDDDDD" onmouseover="this.style.backgroundColor='#F5F5F5';" onmouseout=" this.style.backgroundColor='#EEEEEE'">
        <tr>
          <td width="60" align='left' valign='top' style="color:#000000; font-size:14px"><?php
		//echo("<img src=upload/$loopName/$pic100_Name?".time()." width=50 style='border:0px solid #EEEEEE'>");
		echo("<div style='background: url(upload/$loopName/$pic100_Name?".time()."); margin-right:; width:50; height:50'>");
	?>          </td>
          <td width="150" align='left' valign='top' style="color:#006699; font-size:11px;padding-left:10px; font-weight:bold; line-height:160%; padding-top:0"><?php echo("$fname $lname") ?> <br />
              <font style="font-weight:normal; color:#000000"><?php echo("$ccity, $cstate") ?></font> <br />
              <div style="margin-top:0; font-weight:normal; color:#000000">
                <?php
	$qmajor = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid=(SELECT cmajor FROM rockinus.user_edu_info WHERE uname='$loopName');");
									if(!$qmajor) die(mysql_error());
									$o = mysql_fetch_object($qmajor);
									$major_name = $o->major_name;
									if( strlen($major_name)>0 && $major_name!=NULL ){
										$x = array();
										$x = explode(" ",$major_name);
										$major_name = $x[0]." ".$x[1];
										echo("$major_name");
									}else 
										echo("Joined@".getDateName($pdate));
	?>
          </div></td>
        </tr>
      </table></td>
    <td style="padding-top:15" align="top"><?php
$loopName = $user_array[3];
//echo($loopName."----");
$sql_stmt = "SELECT * FROM rockinus.user_info a 
			JOIN rockinus.user_check_info b  
			JOIN rockinus.user_edu_info c  
			JOIN rockinus.user_contact_info d 
			ON a.uname='$loopName' AND a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname 
			ORDER BY b.signup_date,b.signup_time DESC";
$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
$object = mysql_fetch_object($q);
$fname = $object->fname;
$lname = $object->lname;
$pic100_Name = $loopName.'60.jpg';		
$cstate = $object->cstate;
$ccity = $object->ccity;
$fcountry = $object->fcountry;
$fregion = $object->fregion;
$pdate = $object->signup_date;
//$ptime = $object->signup_time;
$points = $object->points;
if($ccity=="Select a City" || $ccity=="empty" || strlen($ccity)==0)$ccity="Somewhere";
if($cstate=="em" || strlen($cstate)==0)$cstate="USA";
$target = "upload/".$loopName;
?>
      <table width="210" height="35" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:3; border-bottom:0px solid #DDDDDD" onmouseover="this.style.backgroundColor='#F5F5F5';" onmouseout=" this.style.backgroundColor='#EEEEEE'">
        <tr>
          <td width="60" align='left' valign='top' style="color:#000000; font-size:14px"><?php
		//echo("<img src=upload/$loopName/$pic100_Name?".time()." width=50 style='border:0px solid #EEEEEE'>");
		echo("<div style='background: url(upload/$loopName/$pic100_Name?".time()."); margin-right:; width:50; height:50'>");
	?>          </td>
          <td width="210" align='left' valign='top' style="color:#006699; font-size:11px;padding-left:10px; font-weight:bold; line-height:160%; padding-top:0"><?php echo("$fname $lname") ?> <br />
              <font style="font-weight:normal; color:#000000"><?php echo("$ccity, $cstate") ?></font> <br />
              <div style="margin-top:0; font-weight:normal; color:#000000">
                <?php
	$qmajor = mysql_query("SELECT major_name FROM rockinus.major_info WHERE mid=(SELECT cmajor FROM rockinus.user_edu_info WHERE uname='$loopName');");
									if(!$qmajor) die(mysql_error());
									$o = mysql_fetch_object($qmajor);
									$major_name = $o->major_name;
									if( strlen($major_name)>0 && $major_name!=NULL ){
										$x = array();
										$x = explode(" ",$major_name);
										$major_name = $x[0]." ".$x[1];
										echo("$major_name");
									}else 
										echo("Joined@".getDateName($pdate));
	?>
            </div></td>
        </tr>
      </table></td>
  </tr>
</table>
