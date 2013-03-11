<?php include("Header.php"); ?>
  <table width="1018" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="130" align="left" valign="top" style="border-right: 1px solid #EEEEEE; padding-left:15px; padding-bottom:20px">
        <?php include("leftMenuFriendGroup".$_SESSION['lan'].".php"); ?>
		</td>
      <td width="888" align="left" valign="top" style=" border:#CCCCCC solid 0; padding-left:3;">
	  <table width="870" height="500" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="864" valign="top" align="center"><table width="870" height="500" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="677" valign="top" align="center"><?php
			if ((isset($_POST['groupname']))&&(isset($_POST['grouptype']))&&(isset($_POST['groupdesc'])))
			{
				include 'dbconnect.php'; 
				//session_start();
				$username=$_SESSION['usrname'];
				$groupname = $_POST['groupname']; 
				$grouptype=$_POST['grouptype'];
				$groupdesc=$_POST['groupdesc'];
				$sql = "SELECT * from rockinus.group_info WHERE gname='$groupname'";
				$result = mysql_query($sql);
				if (!$result) {
					die('Invalid query: ' . mysql_error());
				}
				$count = mysql_num_rows($result);
				if($count==1)
				{
					?>
                    <font size="4" color="#FF0000"> This Group Name Has Been Used. </font>
                    <?php
				}
				else
				{
					$sql="INSERT INTO rockinus.group_info (builder, category,gname,unamelist,pdate,ptime) VALUES('$username','$grouptype','$groupname','$username', CURDATE(), NOW())";
					$result = mysql_query($sql);
					if (!$result) {
						die('Invalid query: ' . mysql_error());
					}
					else
					{
						?>
                    <font size="4" color="#FF0000"> Congraduations, your New Group Has Been Created!</br>
                    <a href="GroupList.php" size="4">go back</a> </font>
                    <?php
					}
				}
			}
			else
			{ 
			?>
                    <form action="GroupCreate.php" method="post">
                      <table width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8FCFA" style="border:1 #EEEEEE solid">
                        <tr>
                          <td height="40" colspan="2" align="left" background="img/master.png" bgcolor="#EEEEEE" style="padding-left:15; border-bottom:1 #CCCCCC dashed"><font size="3" color="#000000">Create a New Group</font> </td>
                        </tr>
                        <tr>
                          <td height="24" align="right" style="padding-right:15">&nbsp;</td>
                          <td >&nbsp;</td>
                        </tr>
                        <tr>
                          <td width="132" height="40" align="right" style="padding-right:15">Group Name </td>
                          <td width="466" ><input type="text" name="groupname" size="60" class="box" /></td>
                        </tr>
                        <tr>
                          <td height="40" align="right" style="padding-right:15">Category </td>
                          <td><select name="grouptype">
                              <option value="empty">Select a Type</option>
                              <option value="soccer">Soccer</option>
                              <option value="fashion">Fashion</option>
                              <option value="swimming">swimming</option>
                              <option value="food">Food</option>
                              <option value="tennis">Tennis</option>
                              <option value="career">Career</option>
                              <option value="car">Car</option>
                          </select></td>
                        </tr>
                        <tr>
                          <td height="35" align="right" style="padding-right:15">Description</td>
                          <td rowspan="2"><textarea name="groupdesc" rows="5" cols="50" style="border:1 #EEEEEE solid"></textarea></td>
                        </tr>
                        <tr>
                          <td height="54" align="right" style="padding-right:10">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="80"><div align="right"></div></td>
                          <td height="80" valign="middle" style="padding-bottom:5px; padding-left:0px"><input name="submit" type="submit" value="submit" class="btn" /></td>
                        </tr>
                      </table>
                    </form>
                <?php
			}
			?></td>
                <td width="193" rowspan="2" bgcolor="#F5F5F5" style="border-left: 1px solid #EEEEEE; margin-left:5">&nbsp;</td>
              </tr>
            </table></td>
            <td width="10" rowspan="2" bgcolor="#EEEEEE" style="border-left: 0px solid #CCCCCC; margin-left:5">&nbsp;			</td>
          </tr>
      </table>
      </td>
    </tr>
  </table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>