<?php include("Header.php"); ?>
<div align="center">
  <table width="1018" height="394" border="0" cellpadding="0" cellspacing="0" style="padding-top:0; margin-top:0;">
    <tr>
      <td width="136" align="left" valign="top" style="border-right: 1px solid #CCCCCC; padding-right:0; padding-left:0; width:10">
	  <form action="login_process.php" method="post">
        <div style="margin-top: 0; margin-bottom: 0; margin-left:7; margin-right: 0" align="center">
          <table width="100" height="91" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="34"><span class="STYLE8">
                <div style="border-bottom: 1px dotted #999999; padding-right:0; width:55; padding-bottom:4"><a href="MessageList.php" class="one">Message</a></div>
              </span></td>
            </tr>
            <tr>
              <td height="29" style="padding-top:5"><a href="SendMessage.php?recipient=1" class="one">Draft</a></td>
            </tr>
            <tr>
              <td height="20" style="padding-top:0">History </td>
            </tr>
          </table>
        </div>
        <div style="margin-top: 25; margin-bottom: 0; margin-left:7; margin-right: 0" align="center">
          <table width="100" height="66" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="22"><span class="STYLE8">
                <div style="border-bottom: 1px dotted #999999; padding-right:0; width:40; padding-bottom:4"> <a href="RockerProfile.php" class="one">Profile</a> </div>
              </span></td>
            </tr>
            <tr>
              <td height="26" style="padding-top:5"><a href="RockerEdit.php" class="one">Edit</a></td>
            </tr>
          </table>
        </div>
      </form></td>
      <td width="882" align="left" valign="top" style=" border:#CCCCCC solid 0; padding-left:3;">
	  <div align="center">
	  <form action="ChangePasswd.php" method="post" name="profile" onSubmit="return validateForm()" >
        <table width="888" height="394" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top"><div align="center">
                <table width="880" height="28" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="140" height="26" background="img/master.png" style="border: #CCCCCC solid 1; border-bottom:0;"><div align="center"><a href="RockerProfile.php" class="one">Profile</a></div></td>
                    <td width="140" style="border: #CCCCCC solid 1; border-bottom:0 #CCCCCC dotted;"><div align="center"><a href="PasswdEdit.php" class="one">Password </a></div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 1; border-bottom:1 #CCCCCC dotted;"><div align="center"><a href="ChangeHeadIcon.php" class="one">Head Icon </a></div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 1; border-bottom:1 #CCCCCC dotted;"><div align="center"><a href="RockerEdit.php" class="one">Memo </a></div></td>
                    <td style="border: #CCCCCC solid 0; border-bottom:1 #CCCCCC dotted;">&nbsp;</td>
                    </tr>
                </table>
              <table width="880" height="196" border="0" cellpadding="0" cellspacing="0" style="border:#CCCCCC dotted 1; border-top:0">
                  <tr>
                    <td height="16" colspan="4">&nbsp;</td>
                    </tr>
                  <tr>
                    <td width="173" height="40"><div align="right" style="padding-right:5"><strong>Rock ID: </strong></div></td>
                    <td>&nbsp;
                        <input name="uname" type="text" class="box" value=<?php echo($uname); ?> disabled="disabled">
                        <span class="STYLE12">*</span></td>
                    <td width="237">&nbsp;</td>
                    <td width="228">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Old Password: </strong></div></td>
                    <td colspan="3">&nbsp;
                        <input name="oldpasswd" type="password" class="box" id="oldpasswd" size="20"></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>New Password :</strong></div></td>
                    <td colspan="3">&nbsp;
                        <input name="passwd" type="password" class="box" id="passwd" size="20">
                        <span class="STYLE12">*
                          <div id="calendar"></div>
                        </span></td>
                  </tr>
                  <tr>
                    <td height="35"><div align="right" style="padding-right:5"><strong>Confirm Password  :</strong></div></td>
                    <td colspan="3">&nbsp;
                        <input name="cpasswd" type="password" class="box" id="cpasswd"  size="20" maxlength="10">
                        <span class="STYLE12">*
                          <div id="calendar"></div>
                        </span></td>
                  </tr>
                  <tr>
                    <td height="35">&nbsp;</td>
                    <td width="241">
                      <div align="right" style="margin-bottom:30; margin-top:10"><br><br>
                        <input name="Submit" type="submit" class="btn" value="Submit"><p><p>
                      </div></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
            </div></td>
          </tr>
        </table>
		</form>
      </div>
	  </td>
    </tr>
  </table>
  <p style="border-bottom: 1px dotted #336633; margin-top:-10; margin-left:12; margin-bottom:10; width: 1010"></p>
  </font>
  <div style="font-size:12px">
  <a class="one" href="rockinus_intro.php">About us</a>&nbsp;|&nbsp; Jobs &nbsp;|&nbsp; Advertising&nbsp; |&nbsp; <span class="STYLE7">Give us a feedback.</span></div>
  <div style="margin-bottom:4; margin-top:4; font-size:12px">Copyright &copy; 2011 Rockinus Inc. </div>
</div><br>
</body>
</html>
