<?php include("Header.php"); ?>
<div align="center">
<?php
	include 'dbconnect.php';
//	$uid = $_GET["sender"];
		
	$q = mysql_query("SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_edu_info b INNER JOIN rockinus.user_contact_info c ON a.uname='$uname' AND a.uname=b.uname");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;
$birthdate = $object->birthdate;
$fcity = $object->fregion;
$fcountry = $object->fcountry;
$email = $object->email;
$cmajor = $object->cmajor;
$cschool = $object->cschool;
$cdegree = $object->cdegree;

if($gender=='M')$gender='Gentle Man';
else if($gender=='F')$gender='Female';

if($sstatus=='S')$sstatus='Student';
else if($sstatus=='E')$sstatus='Empolyee(r)';

if($cdegree=='G')$cdegree='Master Student';
else if($cdegree=='P')$cdegree='P.H.D.';
else if($cdegree=='U')$cdegree='Undergraduate';
else $cdegree='Certificate Student';

if($mstatus=='S')$mstatus='Single';
else if($mstatus=='M')$mstatus='Married';
else if($mstatus=='I')$mstatus='In a relationship';

$q1 = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
if(!$q1) die(mysql_error());
$obj1 = mysql_fetch_object($q1);
$cschool = $obj1->school_name;
	
$q2 = mysql_query("SELECT * FROM rockinus.major_info where mid='$cmajor'");
if(!$q2) die(mysql_error());
$obj2 = mysql_fetch_object($q2);
$cmajor = $obj2->major_name;
?>
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="padding-top:-5; margin-top:-1;">
    <tr>
      <td width="136" align="left" valign="top" style="border-right: 1px solid #EEEEEE; padding-right:0; width:10; padding-left:15px"><span style="padding-left:15px">
        <?php include("leftMenuFriendGroup".$_SESSION['lan'].".php"); ?>
      </span></td>
      <td width="878" align="left" valign="top" style=" border:#CCCCCC solid 0; padding-left:3;">
	    <table width="885" height="500" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top"><div align="center">
              <div style="padding-top:25; padding-bottom:25; padding-left:7; padding-right:7; width:700; border:#CCCCCC solid 2; background-color:#EEEEEE; margin-top:50;">
			  <?php echo $_SESSION['rst_msg']; unset($_SESSION['rst_msg']); ?>
              </div>
			  <br>
            </div></td>
          </tr>
        </table>
      </td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
