<div style="width:100%; background: #336633; height:130;" align="center">
  <table width="1024" height="70" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:5px">
    <tr>
      <td width="682" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size:28px; line-height:100%; color:#FFFFFF; padding-top:15;" valign="top">
	   <a href="main.php" class="">NYU-Poly's Social Network </a><table height="47" border="0" cellpadding="0" cellspacing="0">
	     <tr><td style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size:28px; line-height:110%; color:#FFFFFF; padding-top:10;" valign="top">Simple, Local & free.&nbsp;</td><td style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size:24px; line-height:110%; color:#FFFFFF; padding-top:10;" height="47" valign="top">
		 </td></tr></table>
	  <font style="color:#CCCCCC; font-size:13px; font-family: Georgia, 'Times New Roman', Times, serif; font-weight:normal" >
	   Campus notices. Course board. Apartment rental. Things On-sale. Friends in school, etc.	</font>  </td>
      <td width="342" colspan="2" align="left">
	  <form action="login_process.php" method="post" style="margin-top:0px;">
        <table width="340" height="80" border="0" cellpadding="0" cellspacing="0" style="">
          <tr>
            <td height="15" colspan="2" align="left" style="padding-left:15px; color:#333333">&nbsp;</td>
          </tr>
          <tr>
            <td width="126" height="30" align="right" style="padding-right:15; color: #EEEEEE; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>Username</strong></td>
            <td width="204" height="30" align="left" style=" color:; font-size:12px"><input type="text" style="height:25px; padding:2px; font-size:14px; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif;" name="usrname" size="25" onMouseOver="this.className='over'" onMouseOut="this.className='out'" class="box_login" value="<?php if(isset($_COOKIE["user"])) echo($_COOKIE["user"]); ?>" /></td>
          </tr>
          <tr>
            <td height="30" align="right" style="padding-right:15; color: #EEEEEE; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif"><strong>Password</strong></td>
            <td height="30" align="left" style="padding-left:0; color:; font-size:12px"><input type="password" style="height:25px;font-size:14px; padding:2; font-weight:normal; font-family: Verdana, Arial, Helvetica, sans-serif;" name="passwd" onMouseOver="this.className='over'" onMouseOut="this.className='out'" class="box_login" size="25" /></td>
          </tr>
          <tr>
            <td height="35" align="left" style="padding-left:15px; font-size:12px; color:#F5F5F5"><div style="padding-left:0px">
              <?php 
		  	if(isset($_SESSION['logoff_tag_1'])){
		  		echo $_SESSION['logoff_tag_1'];
				unset($_SESSION['logoff_tag_1']);
			}
		  ?>
            </div></td>
            <td height="35" align="left" style="padding-left:; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif"><input type="submit" name="Submit" value="Sign In" style="font-size:11px; background: url(img/black_cell_bg.jpg); color:#FFFFFF; height:23; padding:2 4 2 4; border:1px solid #999999; font-family:Verdana, Arial, Helvetica, sans-serif" />
			&nbsp;&nbsp;<a href="main_findPass.php" class="one" style="color: #EEEEEE">Forget Password?</a></td>
          </tr>
          </table>
      </form>	  </td>
	  </tr>
  </table>
  </div>
