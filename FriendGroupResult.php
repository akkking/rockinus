<?php 
include 'mainHeader.php';
include 'dbconnect.php';
include("Allfuc.php");
$uname = $_SESSION['usrname'];
?>
<div align="center" style="width:100%">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="padding-top:-5; margin-top:-1;">
    <tr>
      <td align="left" valign="top" style="border-right: 1px dashed #DDDDDD;">
	    <table width="980" height="500" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top" align="center">
              <div style="padding-top:10; padding-bottom:10; width:730; border:#DDDDDD solid 16px; background-color:#F5F5F5; margin-top:50px;  -moz-border-radius: 5px; border-radius: 5px;">
			  <?php
			  if(isset($_SESSION['rst_msg'])){ 
				  echo $_SESSION['rst_msg']; 
				  unset($_SESSION['rst_msg']); 
			  }
			  ?>
              </div></td>
          </tr>
      </table></td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
