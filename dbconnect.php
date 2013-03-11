<?php 
$link = mysql_connect('68.178.137.14', 'rockinus', 'abc999@SAP');
//$link = mysql_connect('205.178.146.111', 'rockinus', 'harvey9I');
//$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_set_charset('utf8',$link);
//mysql_query("set names gb2312");
?>