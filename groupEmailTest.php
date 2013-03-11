<?php 
include ("dbconnect.php");
include 'emailfuc.php';
require("class.phpmailer.php");

//$to = 'barmuya@hotmail.com';
//echo(count(explode(";",$to)));
$to  = 'barmuya@hotmail.com' . '; '; // note the comma
$to .= 'ayigai01@students.poly.edu';

$to_name = 'akkking' . '; '; // note the comma
$to_name .= 'harvey';

smtp_mail($to, "admin wants to be your friend in Rockinus.com", "test", "admin@rockinus.com", $to_name, "", ""); 
echo("Sent!");
?>