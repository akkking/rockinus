<? 
include ("dbconnect.php");
include 'emailfuc.php';
require("Allfuc.php");
require("class.phpmailer.php");
session_start();
$uname = $_SESSION['usrname'];

if(isset($_POST['turnTag'])){
	$turnTag=$_POST['turnTag'];
	$channelVal=$_POST['channelVal'];
	// Update user's channel status
	$upd_channel = mysql_query("UPDATE rockinus.user_custom_setting SET $channelVal='$turnTag' WHERE uname='$uname';");
	if(!$upd_channel) die(mysql_error());
	echo("<img src='img/addsuccessIcon_F5.jpg' width=18>&nbsp; Sucess! Redirecting...");
}
?>