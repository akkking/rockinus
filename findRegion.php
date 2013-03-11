<?php
$country_name=$_GET['fcountry'];
include "dbconnect.php";
$q = mysql_query("SELECT region_name FROM rockinus.region_info WHERE country_name='$country_name'");
if(!$q) die(mysql_error());
?>
<select name="fregion" id="fregion" style="padding-right:10px; font-size:13px; font-family: Arial, Helvetica, sans-serif">
<?php
while($object = mysql_fetch_object($q)){
	$region_name = $object->region_name;
?>
<option value='<? echo($region_name) ?>'><? echo($region_name) ?></option>
<? } ?>
</select>