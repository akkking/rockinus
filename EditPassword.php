<?php 
include 'dbconnect.php';
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
	 
$wid = ProfileProgress($uname);

include 'mainHeader.php';
?><style type="text/css">
<!--
body,td,th {
	font-size: 13px;
}
-->
</style>
<div align="center">
  <table width="1024" height="396" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="padding-top:0; margin-top:0;">
    <tr>
      <td width="300" height="396" align="left" valign="top" style=" padding-left:15px; line-height:150%; font-size:14px">
	  <?php include "ProfileMenu.php" ?>
	  </td>
      <td width="760" align="right" valign="top" style="padding-top:15px">
	  <form action="ChangePasswd.php" method="post" name="profile" style="border:0px solid #999999; background:">
        <table width="740" height="353" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top"><div align="left">
              <table width="740" border="0" cellspacing="0" cellpadding="0" style="border:#DDDDDD solid 0px; border-top:0; border-bottom:0; background:">
                <tr>
                  <td width="440" height="60" style="border-left:0 #CCCCCC dotted" align="center">                    </td>
                  <td width="70" height="60" align="right" style="padding-right:10; border-left:0 #CCCCCC dotted"><font color="#336633"><?php echo($wid)?>%</font></td>
                  <td width="230" height="60" style="border-right:0 #CCCCCC dotted"><div align="left" style="width:200; padding-top:0; padding-bottom:0; border:1 #336633 solid; background: #EEEEEE">
                    <table height="17" border="0" cellpadding="0" cellspacing="0" >
                      <tr>
                        <td height="17" width="<?php echo(2*$wid)?>" bgcolor="#336699" align="left">&nbsp;</td>
                      </tr>
                    </table>
                  </div></td>
                </tr>
              </table>
              <table width="740" height="278" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><table width="740" height="273" border="0" cellpadding="0" cellspacing="0" style="border:#DDDDDD solid 0px; border-top:0; background:; margin-top:20">
                    <tr>
                      <td width="211" height="40" align="right" valign="top" style="padding-right:5; font-family:Arial, Helvetica, sans-serif; font-size:16px; padding-top:15px"><strong>User name: </strong></td>
                      <td width="230" height="40" valign="top" style="padding-top:0px; padding-left:10px" align="left">&nbsp;
                          <input name="uname" type="text" style="border:0; background:#FFFFFF; font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold" size="25" value="<?php echo($uname); ?>" disabled="disabled" /></td>
                      <td width="299" height="40">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="30" align="right" style="padding-right:5; font-family:Arial, Helvetica, sans-serif; font-size:13px"><strong>Current Password: </strong></td>
                      <td height="30">&nbsp;
                          <input name="oldpasswd" type="password" class="box" id="oldpasswd" size="30" /></td>
                      <td height="30" style="padding-left:10">
					  <?php if(isset($_SESSION['rst_msg'])){
				  			echo($_SESSION['rst_msg']);
							unset($_SESSION['rst_msg']);
				  }?>				  </td>
                    </tr>
                    <tr>
                      <td height="30" align="right" style="padding-right:5; font-family:Arial, Helvetica, sans-serif; font-size:13px"><strong>New Password :</strong></td>
                      <td height="30" colspan="2">&nbsp;
                          <input name="passwd" type="password" class="box" id="passwd" size="30" />
                          <span class="STYLE12">
                          <div id="calendar"></div>
                          </span></td>
                    </tr>
                    <tr>
                      <td height="30" align="right" style="padding-right:5; font-family:Arial, Helvetica, sans-serif; font-size:13px"><strong>Confirm New Password  :</strong></td>
                      <td height="30" colspan="2">&nbsp;
                          <input name="cpasswd" type="password" class="box" id="cpasswd"  size="30" maxlength="30" />
                          <span class="STYLE12">
                          <div id="calendar"></div>
                          </span></td>
                    </tr>
                    <tr>
                      <td height="60">&nbsp;</td>
                      <td height="60" valign="top" style=" padding-top:20">&nbsp;
                        <input name="Submit" type="submit" style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:1px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif" value=" SAVE " /></td>
                      <td height="60" align="right" style="padding-top:40; padding-bottom:50">&nbsp;					  </td>
                      </tr>
                  </table></td>
                  </tr>
              </table>
            </div></td>
          </tr>
        </table>
		</form>
	  </td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
