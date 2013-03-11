<?php
$_SESSION['rid'] = "";
$_SESSION['uname_tag'] = "";

include 'dbconnect.php'; 
$uname = $_POST['uname']; 

session_start(); 
$sql = "SELECT * from rockinus.user_info WHERE uname='$uname'";
$result = mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$count = mysql_num_rows($result);

if(strlen(trim($uname))<3){
	$_SESSION['uname_tag'] = "<div style='background-color:#EEEEEE; width:320; padding-bottom:5; padding-top:5; border:1 #333333 solid'><font color=#B92828><strong>&nbsp;&nbsp;User name has to be longer than 2 letters</strong></font></div>";
}else if(is_numeric(substr($uname,0,1))){
	$_SESSION['uname_tag'] = "<div style='background-color:#EEEEEE; width:320; padding-bottom:5; padding-top:5; border:1 #333333 solid'><font color=#B92828><strong>&nbsp;&nbsp;User name cannot start with a number!</strong></font></div>";
}else if($count==1){
	$_SESSION['uname_tag']="<font color=red><strong>&nbsp;&nbsp;<img src=img\stop.jpg>&nbsp;&nbsp;Sorry: $uname has been taken!</strong></font>";
}else{
 	$_SESSION['rid']=$uname; 
	$_SESSION['uname_tag']="<font color=#336633>&nbsp;&nbsp;<img src=img\greencoricon.jpg height=23 width=23>&nbsp;&nbsp;&nbsp;<strong>".$_SESSION['rid']."</strong> is availbale!</font>"; 
}
header("location:joinUs.php");
mysql_close($link);
?>