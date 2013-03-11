<?php
$state_name=$_GET['state_name'];
include "dbconnect.php";
$query="SELECT city_name FROM rockinus.city_info WHERE state_name='$state_name'";
$result=mysql_query($query);?>
<select name="city" style="padding-right:10px; font-size:13px; font-family: Arial, Helvetica, sans-serif">
<option value="any">Any</option>
<? while($row=mysql_fetch_array($result)) { ?>
   <option value='<?=$row['city_name']?>'><?=$row['city_name']?></option>
<? } ?>
</select>