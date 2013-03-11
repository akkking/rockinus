<?php
include 'dbconnect.php';
require("class.phpmailer.php");
include("func.php");

$sql="select * from inventory.item_history ORDER BY trdate, trtime DESC";
$result = mysql_query($sql);
if (!$result) die('Invalid query: ' . mysql_error());
$str=NULL;
while($arr = mysql_fetch_array($result))
{
	$iid=$arr['iid'];
	$uname=$arr['uname'];
	$sql1="select * from inventory.item_info where iid='$iid'";
	$result1=mysql_query($sql1);
	if(!$result1) die('Invalid query: ' . mysql_error());
	$row1=mysql_fetch_array($result1);
	if(($arr['takereturn']=="out")&&$row1['tag']=='N')
	{
		$sql2="select * from inventory.user_info where uname='$uname' ";
		$result2=mysql_query($sql2);
		if(!$result2) die('Invalid query: ' . mysql_error());
		$row2=mysql_fetch_array($result2);
		$fullname=$row2['fname']." ".$row2['lname'];
		$trtime=$arr['trtime'];
		$trdate=$arr['trdate'];
		$duration=$arr['duration'];
		date_default_timezone_set('America/New_York');
		$date = date( "Y-m-d   H:i:s ");
		//echo $date."</br>";
		$date1= $trdate." ".$trtime; 
		//echo $date1;
		$d1=strtotime($date1); 
		$d2=strtotime($date);
		$hour=round(($d2-$d1)/3600);
		$hour=$duration*24-$hour;
		if($hour<=0)
		{
			$hour=abs($hour);
			$str.="The Item ".$row1['brand']." ".$row1['type']." ".$row1['model']." Overdues ".$hour." h(s) by ";
			$str.=$fullname.".</br>";
		}
	}
}

if($str!=NULL) smtp_mail("gunit.inventory@gmail.com", "Overdue List", NULL, "bjorn@bjorncg.com", null, $str, "overdue");
?>
