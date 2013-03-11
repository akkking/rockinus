<?php 
include 'mainHeader.php';
include 'dbconnect.php';
include("Allfuc.php");
?>
<div align="center" style="width:100%">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td align="left" valign="top" style="border-right:1px #DDDDDD dashed">
	  <table border="0" cellspacing="0" cellpadding="0" width="1001">
	    <tr>
	      <td width="1001" align="center" valign="top" style="margin-right:10px; margin-left:0px; padding-top:0px">
	        <br />
	        <br />
			<br />
	        <div style="padding-top:30px; padding-bottom:30px; padding-left:10; padding-right:10; width:800px; border:#DDDDDD solid 16px; background-color:#F5F5F5; -moz-border-radius: 5px; border-radius: 5px;">
	          <?php 
		if(isset($_SESSION['rst_msg'])){
			echo $_SESSION['rst_msg']; 
			unset($_SESSION['rst_msg']); 
		}?>
	        </div>
          <br />
		  <br />
		  <br />
		  </td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
