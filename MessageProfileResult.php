<?php 
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
include 'dbconnect.php';
?>
<div align="center">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="padding-top:0; margin-top:0;">
    <tr>
      <td width="300" align="left" valign="top" style="border-right:1 dashed #DDDDDD">
        <?php include("leftHomeMenu.php"); ?>
      </td>
      <td width="760" align="right" valign="top">
       <?php include("HeaderEN.php"); ?>
		<div align="center" style="padding-top:15; padding-bottom:15; padding-left:10; padding-right:10; width:740; border:#DDDDDD solid 1; background-color:#F5F5F5; margin-top:20;"><?php echo $_SESSION['rst_msg']; unset($_SESSION['rst_msg']); ?> </div>
        <br />
      </td>
    </tr>
  </table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
