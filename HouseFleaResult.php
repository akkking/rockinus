<?php include("Header.php"); ?>
<div align="center">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" style="padding-top:-5; margin-top:5;">
    <tr>
      <td width="128" align="left" valign="top" style="border-right: 1px solid #EEEEEE; padding-right:0; width:10">
	  <?php include("leftMenuHouseRental".$_SESSION['lan'].".php"); ?>
      </td>
      <td width="860" align="center" valign="top" style=" border:#CCCCCC solid 0" sty>&nbsp;<p>
      <div style="padding-top:25; padding-bottom:25; padding-left:7; padding-right:7; width:700; border:#CCCCCC solid 2; background-color:#EEEEEE; margin-top:20;">
	  <?php 
	  if(isset($_SESSION['rst_msg'])){
	  echo $_SESSION['rst_msg'];
	  unset($_SESSION['rst_msg']); }else echo "no";
	  ?> 
	  </div>
	  <p></td>
    </tr>
  </table>
  <p style="border-bottom: 1px dotted #336633; margin-top:-10; margin-left:12; margin-bottom:10; width: 1010"></p>
  </font>
  <div style="font-size:12px">
  <a class="one" href="rockinus_intro.php">About us</a>&nbsp;|&nbsp; Jobs &nbsp;|&nbsp; Advertising&nbsp; |&nbsp; <span class="STYLE7">Give us a feedback.</span></div>
  <div style="margin-bottom:4; margin-top:4; font-size:12px">Copyright &copy; 2011 Rockinus Inc. </div>
</div>
</body>
</html>
