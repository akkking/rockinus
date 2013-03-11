<?php
//include 'ValidCheck.php';
include 'dbconnect.php';
//include("Allfuc.php");
//$uname = $_SESSION['usrname'];
?>
<table width="150" height="30" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; padding-left:10; padding-top:; margin-bottom:10; border-top:1px solid #DDDDDD; border-bottom:1px solid #999999; background: url(img/master.jpg); color:#FFFFFF">
  <tr>
    <td align="left" style="padding-left:0; font-size:13px; color:<?php echo($_SESSION['hcolor']) ?>; font-family: Arial, Helvetica, sans-serif; font-weight:bold; ">Popular Friends</td>
  </tr>
</table>
<?php				
$sql_stmt = "SELECT *, d.points, MAX(d.points) as points 
			FROM rockinus.user_info a 
			JOIN rockinus.user_check_info b 
			JOIN rockinus.user_contact_info c 
			JOIN rockinus.user_points d 
			ON a.uname in (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname'
						   UNION
						   SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname')
			AND b.status='A' AND a.uname<>'harvey' AND a.uname<>'akkking' AND a.uname=b.uname AND a.uname=c.uname AND a.uname=d.uname 
			GROUP BY d.uname ORDER BY points DESC";
$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("<br><font style='font-size:12px;'><img src=img/GroupMeIcon.jpg width=13 />&nbsp;&nbsp;Currently no friends&nbsp;&nbsp;<br>&nbsp; <a href='FriendGroup.php'><div align='center' style=' height:15; padding:2 8 2 8; background: url(img/blueBtnBg.jpg); display:; margin-top:0;  margin-bottom:10; width:130; border:1px solid #999999; border-left:0; border-top:0; color:#000000; font-size:11px; cursor:pointer'><strong>&middot;</strong>&nbsp; Click here to find some</div></a></font>");
$i = 1;
while($object = mysql_fetch_object($q)){
	$loopName = $object->uname;
	$fname = $object->fname;
	$lname = $object->lname;
	$pic100_Name = $loopName.'100.jpg';		
	$cstate = $object->cstate;
	$ccity = $object->ccity;
	$ptime = $object->ptime;
	$ptime = $object->ptime;
	$points = $object->points;
	if($ccity=="Select a City" || strlen($ccity)==0)$ccity="Somewhere";
	if($cstate=="em" || strlen($cstate)==0)$cstate="USA";
	
	if($i<=10){
		$target = "upload/".$loopName;
		if(is_dir($target)){
?>
<table width="150" height="35" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:3; border-bottom:0px solid #DDDDDD" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='#FFFFFF';">
  <tr>
    <td width="61" align='left' valign='top' style="color:#000000; font-size:14px">
	<?php
		//echo("<img src=upload/$loopName/$pic100_Name?".time()." width=50 style='border:0px solid #EEEEEE'>");
		echo("<div style='background: url(upload/$loopName/$pic100_Name?".time()."); margin-right:; width:50; height:50'>");
	?>    
	</td>
    <td width="89" align='left' valign='top' style="color:#000000; font-size:11px; font-weight:bold; line-height:140%; padding-top:2">
	<?php echo("<a href='RockerDetail.php?uid=$loopName' class='one' title='$fname $lname' style='color:$_SESSION[hcolor]'>$fname</a>") ?>
	<br />
	<font style="font-weight:normal"><?php echo("$ccity, $cstate") ?></font>
	<br />
	<div style="margin-top:2">
	<?php
$total_point = getUserPoint($loopName);

$token_full = 0;
$token_half = 0;
$token_empty = 0;

$token="star";
$cal_unit=100;

if($total_point>=500&&$total_point<2500){
	$cal_unit=500;
	$token = "diamond";
}else if($total_point>=2500){
	$cal_unit=1000;
	$token = "gold";
}

if(($token=="star"&&$total_point<100) || ($token=="diamond"&&$total_point<1000) || ($token=="gold"&&$total_point<2500)) $token_full=0;
else $token_full = floor($total_point/$cal_unit);
//echo("$token<br>$token_full<br>$total_point<br>");

if($total_point%$cal_unit>0) {
	$token_half=1;
	$token_empty=5-$token_half-$token_full;
}else{
	$token_half=0;
	$token_empty=5-$token_full;
}

for($i=0; $i<$token_full; $i++)
	echo("<img src='img/ratingStar_full.jpg' width=11>");
for($j=0; $j<$token_half; $j++)
	echo("<img src='img/ratingStar_half.jpg' width=11>");
for($k=0; $k<$token_empty; $k++)
	echo("<img src='img/ratingStar_empty.jpg' width=11>");
?>
</div>
	</td>
  </tr>
</table>
<?php
			  $i ++;
			}
		}else break;
	}
?>