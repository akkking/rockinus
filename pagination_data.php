<?php
include('dbconnect.php');
 $per_page = 9; 
if($_GET)
 {
 $page=$_GET['page'];
 }
 
$start = ($page-1)*$per_page;
 $sql = "select * from rockinus.user_info order by msg_id limit $start,$per_page";
 $result = mysql_query($sql);
?>
<table width="800px">
 
<?php
while($row = mysql_fetch_array($result)){
 $uname=$row['uname'];
 $gender=$row['gender'];
?>
<tr>
 <td><?php echo $uname; ?></td>
 <td><?php echo $gender; ?></td>
 </tr>
<?php
}
?>
</table>