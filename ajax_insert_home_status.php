<?php
include 'dbconnect.php';
include 'Allfuc.php';
session_start();
$uname = $_SESSION['usrname'];
 
if(isset($_POST['content'])){
	$descrip=addslashes($_POST['content']);
	$content=str_replace("\\", "", $_POST['content']);
	$sender=$_POST['sender'];
	$pdate=$_POST['pdate'];
	$ptime=$_POST['ptime'];

	$del = mysql_query("INSERT INTO rockinus.memo_info(descrip,sender,pdate,ptime,level) VALUES ('$descrip','$uname',CURDATE(), NOW(),'Y');"); 
	?>
	
	<table width="350" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;  background:#F5F5F5; border-top:0px solid #EEEEEE">
  <tr>
    <td width="20" height="20" align="right" valign="top" style="padding:5 10 5 5">
	<img src="img/addsuccessIcon_F5.jpg" width="15" /></td>
    <td width="400" align="left" valign="top" style=" padding:5 10 5 0; font-size:13px; font-family: Arial, Helvetica, sans-serif; line-height:100%; color:#000000">
	<?php echo("Great, status has been posted successully. &nbsp;") ?>	</td>
    </tr>
</table>
	
<?php	
}?>