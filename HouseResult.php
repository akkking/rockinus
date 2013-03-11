<?php 
include 'ValidCheck.php';
include("Allfuc.php");
include 'dbconnect.php';
$uname = $_SESSION['usrname'];
?>
<div align="center" style="width:100%">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" style="padding-top:-5; margin-top:5;">
    <tr>
      <td width="300" align="left" valign="top" style="border-right: 1px dashed #DDDDDD;">
        <?php include("leftHomeHouseMenu.php"); ?>
      </td>
      <td width="760" align="right" valign="top" style=" border:#CCCCCC solid 0" sty>&nbsp;<p>
      <?php include("HeaderEN.php"); ?>
	  <div style="padding-top:10; padding-bottom:10; padding-left:7; padding-right:7; width:700; border:#DDDDDD solid 8; background-color:#F5F5F5; margin-top:10;">
	  <?php 
	  if(isset($_SESSION['rst_msg'])){
	  echo $_SESSION['rst_msg'];
	  unset($_SESSION['rst_msg']); }
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
