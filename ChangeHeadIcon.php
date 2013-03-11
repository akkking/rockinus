<?php include("Header.php"); ?>
<div align="center">
<?php $rst_msg = $_SESSION['rst_msg']; ?>
  <table width="1018" height="327" border="0" cellpadding="0" cellspacing="0" style="padding-top:0; margin-top:0;">
    <tr>
      <td width="136" height="327" align="left" valign="top" style="border-right: 1px solid #CCCCCC; padding-right:0; padding-left:0; width:10">
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
              <td height="20" style="padding-top:0"><a href="MessageSentList.php" class="one">History</a> </td>
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
		<form enctype="multipart/form-data" action="upload.php"  method="post">
        <table width="888" height="327" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top"><div align="center">
                <table width="880" height="28" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="140" height="26" background="img/master.png" style="border: #CCCCCC solid 1; border-bottom:0;"><div align="center"><a href="RockerProfile.php" class="one">Profile</a></div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 1; border-bottom:0 #CCCCCC dotted;"><div align="center"><a href="PasswdEdit.php" class="one">Password </a></div></td>
                    <td width="140" style="border: #CCCCCC solid 1; border-bottom:0;"><div align="center"><a href="ChangeHeadIcon.php" class="one">Head Icon</a> </div></td>
                    <td width="140" background="img/master.png" style="border: #CCCCCC solid 1; border-bottom:1 #CCCCCC dotted;"><div align="center"><a href="RockerEdit.php" class="one">Memo </a></div></td>
                    <td style="border: #CCCCCC solid 0; border-bottom:1 #CCCCCC dotted;">&nbsp;</td>
                    </tr>
                </table>
              <table width="880" height="251" border="0" cellpadding="0" cellspacing="0" style="border:#CCCCCC dotted 1; border-top:0">
                  <tr>
                    <td height="16">&nbsp;</td>
                    <td height="16" >&nbsp;</td>
                    <td height="16">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="173" height="34"><div align="right" style="padding-right:5"><strong>Rock ID: </strong></div></td>
                    <td width="350"  style="border-right:1 dotted #CCCCCC">&nbsp;
                        <input name="uname" type="text" class="box" value=<?php echo($uname); ?> disabled="disabled" size=15></td>
                    <td width="355" rowspan="3" align="center">&nbsp;
					<div style="padding-bottom:20; padding-top:20; padding-left:10; padding-right:10; width:300; margin-bottom:10" align="center"><?php $pic250_Name = $uname.'250.jpg';echo("<img src=upload/$pic250_Name style=border:0>")?>
</div></td>
                    </tr>
                  <tr>
                    <td height="141" colspan="2"  style="border-right:1 dotted #CCCCCC"><div align="center">
					<?php 
echo $rst_msg;
$_SESSION['rst_msg'] = "";
?>
                      <div align="center" style="background-color:; opacity:0.9; filter:alpha(opacity=60); padding-top: 15; padding-bottom: 15; margin-top:30; margin-bottom:0; padding-left: 5; padding-right:5; border-color: #999999; border-style: solid; width:450;; border-width: 2;">
                        <table width="450" height="89" border="0" cellpadding="0" cellspacing="8">
                          <tr>
                            <td width="185" height="39" align="right" class="STYLE10">Upload the new head icon: &nbsp;</td>
                            <td colspan="2">
							<input name="uploaded" type="file" style="border-style: solid; border-width: 1px;border-color: black;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #FFFFFF" /></td>
                          </tr>
                          <tr>
                            <td height="24">&nbsp;</td>
                            <td width="53"><input type="submit" name="Submit" value="Upload" class="btn"></td>
                            <td width="166">&nbsp;</td>
                          </tr>
                        </table>
                      </div>
                    </div></td>
                    </tr>
                  <tr>
                    <td height="35" colspan="2" valign="top" style="border-right:1 dotted #CCCCCC">&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="10" colspan="2" valign="top" style="border-right:0 dotted #CCCCCC">&nbsp;</td>
                    <td align="center">&nbsp;</td>
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
