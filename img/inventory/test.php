<table>
<?php 
include 'dbconnect.php';
$sql="select * from inventory.item_history ORDER BY trdate, trtime DESC";
$result = mysql_query($sql);
if (!$result) die('Invalid query: ' . mysql_error());
//set up a array to identify whether this item is latest
$sql2="SELECT MAX(iid) AS iid FROM inventory.item_history";
$result2=mysql_query($sql2);
if (!$result2) die('Invalid query: ' . mysql_error());
$row2=mysql_fetch_array($result2);
$max_iid=$row2['iid'];
$flag = array();
for($i=0;$i<=$max_iid;$i++)
{
	$flag[$i]=0;
	//echo "flag[".$i."] is: ".$flag[$i]."</br>";
}
while($arr = mysql_fetch_array($result))
{
	$iid=$arr['iid'];
	?>
	<tr>
	<td>
	<?php
	$sql1="select * from inventory.item_info where iid='$iid'";
	$result1=mysql_query($sql1);
	if(!$result1) die('Invalid query: ' . mysql_error());
	$row1=mysql_fetch_array($result1);
	echo $row1['type']."|".$row1['brand']." ".$row1['model']; 
	?>
	</td>
	<td>
	<?php
		if($arr['takereturn']=='in')
		{
			echo "returned";
		}
		else if(($arr['takereturn']=='out')&&($flag[$iid]==0))
		{
			if($row1['tag']=='R')
			{
				echo "Request for Approval";
				$flag[$iid]=1;
			}
			if($row1['tag']=='N')
			{
				echo "Borrowed";
			}
		}
		else 
		{
			echo "Borrowed";
		}
	?>
	</td>
	<td>
	<?php
	echo "On ".$arr['trdate'];
	?>
	</td>
	</tr>
	<tr>
	<td>
	<?php
	echo "It's now ".$arr['cond'];
	?>
	</td>
	<td>
	<?php
	$uname = $arr['uname'];
	$sql3="select * from inventory.user_info where uname='$uname' ";
	$result3=mysql_query($sql3);
	if(!$result3) die('Invalid query: ' . mysql_error());
	$row3=mysql_fetch_array($result3);
	$level=$row3['level'];
	echo ("By <strong><a href=userDetail.php?uname=$uname><font color=black>$uname</font></strong></a> <font color=#CCCCCC>(User)</font>") ;
	?>
	</td>
	<td>
	<?php
	if(($arr['takereturn']=="out")&&$row1['tag']=='N')
	{
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
			echo "<font color='red'><strong>Overdue </strong></font>".$hour." h(s)";
		}
		else if($hour>=24)
		{
			$days=intval($hour/24);
			$hour=$hour-$days*24;
			echo $days." day(s) and ".$hour." hr(s) left";
		}
		else echo $hour."hr(s) left";
		
	}
	else if($arr['takereturn']=="in")echo($arr['trtime']); 
	?>
	</td>
	</tr>
	<?php
}
?>
</table>