<?php
include 'dbconnect.php';
include 'Allfuc.php';
session_start();
 
if(isset($_POST['memoid']))
{
 	$memoid=$_POST['memoid'];
 	$q_delete = mysql_query("DELETE FROM rockinus.memo_info WHERE memoid='$memoid';");
	if(!$q_delete){
		$output = mysql_error();
 		echo($output);
	}else{
	 	$sql_in = mysql_query("SELECT descrip,memoid,pdate,ptime FROM rockinus.memo_info ORDER BY memoid DESC");
 		$object = mysql_fetch_object($sql_in);
 		$memoid = $object->memoid; 
 		$descrip = $object->descrip;  		
		$pdate = $object->pdate; 
 		$ptime = $object->ptime; 
		
		if($descrip==NULL) echo("<font color=#666666>Nothing posted ...</font>");
		else if(strlen($descrip)>0) echo($descrip."&nbsp;<font color=#999999>(Updated at ".getDateName($pdate)." | ".substr($ptime,0,5).")</font>");
		else echo("Nothing...");
	}
}
?>
              