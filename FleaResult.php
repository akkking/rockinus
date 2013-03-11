<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];
?>
<div align="center" style="width:100%">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="margin-top:0;">
    <tr>
      <td width="300" align="left" valign="top" style=" border-right:1 dashed #DDDDDD">
        <?php include("leftHomeMarketMenu.php"); ?>
		<br /><br />
      </td>
      <td width="760" align="right" valign="top">
      <?php include("HeaderEN.php"); ?>
	  <div style="padding-top:20; padding-bottom:20; padding-left:7; padding-right:7; width:720; border:#CCCCCC solid 6; background-color:#F5F5F5;">
	  <?php 
	  if(isset($_SESSION['rst_msg'])){
	  echo $_SESSION['rst_msg'];
	  unset($_SESSION['rst_msg']); }
	  ?> 
	  </div>
	  </td>
    </tr>
  </table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>