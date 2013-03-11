<?php
include 'dbconnect.php';
include 'Allfuc.php';
 
if(isset($_POST['content']))
{
 $content=$_POST['content'];
 $sender=$_POST['sender'];
 $pdate=$_POST['pdate'];
 $ptime=$_POST['ptime'];
 mysql_query("INSERT INTO rockinus.memo_info(descrip,sender,pdate,ptime,level) VALUES ('$content','$sender','$pdate', '$ptime','A');");
 $sql_in= mysql_query("SELECT descrip,memoid,pdate,ptime FROM rockinus.memo_info ORDER BY memoid DESC");
 $object = mysql_fetch_object($sql_in);
 $memoid = $object->memoid; 
 $descrip = $object->descrip; 
 $memo_pdate = $object->pdate; 
 $memo_ptime = $object->ptime; 
 echo($descrip."&nbsp;<font color=#999999>(Updated at ".getDateName($memo_pdate)." | ".substr($memo_ptime,0,5).")</font>");
 }
?>