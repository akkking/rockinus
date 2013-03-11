<?php 
include("Header.php"); 
$ua=getBrowser();
?>
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="10" align="left" valign="top" style="padding-left:<?php if(contains("Chrome",$ua['name']))echo("5px"); else echo("5"); ?>; border-right:0px #DDDDDD dashed">
	  <?php include("leftMenu".$_SESSION['lan'].".php"); ?>	  </td>
      <td width="900" align="left" valign="top" style="padding-left:0px">
	  <table border="0" cellspacing="0" cellpadding="0" width="874">
        <tr>
          <td valign="top" style="margin-right:10px; margin-left:0px; padding-top:0px" align="center">
		  <br />
		<div style="padding-top:25; padding-bottom:25; padding-left:10; padding-right:10; width:700; border:#CCCCCC solid 6; background-color:#F5F5F5; margin-top:0;">
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
