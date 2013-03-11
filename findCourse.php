<?php
$mid=$_GET['mid'];
include "dbconnect.php";
$query="SELECT course_id, course_name FROM rockinus.course_info WHERE mid='$mid' GROUP BY course_id";
$result=mysql_query($query);?>
<select name="course_id" style="padding-right:10px; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
<option value="all">Any course</option>
<? while($row=mysql_fetch_array($result)) { ?>
   <option value='<?=$row['course_id']?>'><?=$row['course_name']?></option>
<? } ?>
</select>