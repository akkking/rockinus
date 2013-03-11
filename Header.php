<?php include("ValidCheck.php"); 
include("Allfuc.php");
$uname = $_SESSION['usrname'];

if(!isset($_SESSION['hcolor']) || !isset($_SESSION['lan']) || !isset($_SESSION['topi'])){
	include 'dbconnect.php';

	$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
	if(!$q1) die(mysql_error());
	$object = mysql_fetch_object($q1);
	$_SESSION['hcolor'] = $object->hcolor;
	$_SESSION['lan'] = $object->lan;
	$_SESSION['topi'] = $object->topi;
}

$hcolor = $_SESSION['hcolor'];
$lan = $_SESSION['lan'];
$topi = $_SESSION['topi'];

if(isset($_POST['lan'])){
	$lan = htmlspecialchars(trim($_POST['lan']));
	$_SESSION['lan'] = $lan;
	include("dbconnect.php");
	$setLan = "UPDATE rockinus.user_setting SET lan='$lan' WHERE uname='$uname'";
    mysql_query($setLan) or die(mysql_error());
	header("location:ThingsRock.php");
}

if(isset($_GET["topi"])){
	include 'dbconnect.php';
	if(isset($_SESSION['topi']))unset($_SESSION['topi']);
	$_SESSION['topi'] = $_GET['topi'];
	$topi = htmlspecialchars(trim( $_GET['topi']));

    $setTopic  = "UPDATE rockinus.user_setting SET topi='$topi' WHERE uname='$uname'";
    mysql_query($setTopic) or die(mysql_error());
	header("location:ThingsRock.php");
}
include("Header".$lan.".php");
?>