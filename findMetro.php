<?php
$lineNo=$_GET['lineNo'];
include "dbconnect.php";
$query="SELECT stopName FROM rockinus.metro_info WHERE lineNo='$lineNo'";
$result=mysql_query($query);?>
<select name="metrostop" style="padding-right:10px; font-size:13px; font-family: Arial, Helvetica, sans-serif">
<option value="empty">Any</option>
<? while($row=mysql_fetch_array($result)) { ?>
   <option value='<?=$row['stopName']?>'><?=$row['stopName']?></option>
<? } ?>
</select>