<?php 
include 'ValidCheck.php';
include 'dbconnect.php';
include("Allfuc.php");
?>
<div align="center" style="width:100%">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="300" align="left" valign="top" style="border-right:1px #DDDDDD dashed">
	  <?php include("leftHomeMenu.php"); ?>
	  </td>
      <td width="760" align="right" valign="top">
	  <?php include("HeaderEN.php"); ?>
	  <table border="0" cellspacing="0" cellpadding="0" width="740">
        <tr>
          <td valign="top" align="right">
		  <br />
		<div align="center" style="padding-top:15; padding-bottom:15; padding-left:10; padding-right:10; width:700; border:#CCCCCC solid 6; background-color:#F5F5F5; margin-top:0;">
		<?php 
		if(isset($_SESSION['rst_msg'])){
			echo $_SESSION['rst_msg']; 
			unset($_SESSION['rst_msg']); 
		}?> 
		</div>
        <br />
		  </td>
        </tr>
      </table>
	  </td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
