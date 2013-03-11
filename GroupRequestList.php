<?php include("Header.php"); ?>
<div align="center">
  <table width="1018" height="394" border="0" cellpadding="0" cellspacing="0" style="padding-top:-5; margin-top:-1;">
    <tr>
      <td width="136" align="left" valign="top" style="border-right: 1px solid #CCCCCC; padding-right:0; width:10">
          <div style="margin-top: 0; margin-bottom: -20; margin-left:0; margin-right: -5; padding-left:10; border-left: 0px solid #CCCCCC; background-color:; height:500px" align="center">
            <table width="130" height="64" border="0" cellpadding="0" cellspacing="0" style="margin-top:5">
              <tr>
                <td height="24">
				<div style="border-bottom: 0px dotted #999999; padding-right:0; width:90; padding-bottom:4">
				<a href="FriendGroup.php" class="one"><span class="STYLE14">Rockers</span></a></div>
				</td>
              </tr>
              <tr>
                <td height="20" style="padding-top:5"><img src="img/RightArrow.jpg" width="12" height="12"> <a href="RequestList.php" class="one">Requests</a> </td>
              </tr>
              <tr>
                <td height="20" style="padding-top:5"><img src="img/RightArrow.jpg" width="12" height="12"> <a href="FriendList.php" class="one">My friends</a> </td>
              </tr>
            </table>
            <br>
            <table width="130" height="124" border="0" cellpadding="0" cellspacing="0" style="margin-top:5">
              <tr>
                <td height="24"><div style="border-bottom: 0px dotted #999999; padding-right:0; width:90; padding-bottom:4"><span class="STYLE14">Potentials</span></div></td>
              </tr>
              <tr>
                <td height="20" style="padding-top:5"><img src="img/RightArrow.jpg" width="12" height="12">Hometown</td>
              </tr>
              <tr>
                <td height="20" style="padding-top:5"><img src="img/RightArrow.jpg" width="12" height="12">Course</td>
              </tr>
              <tr>
                <td height="20" style="padding-top:5"><img src="img/RightArrow.jpg" width="12" height="12">Major</td>
              </tr>
              <tr>
                <td height="20" style="padding-top:5"><img src="img/RightArrow.jpg" width="12" height="12">School</td>
              </tr>
              <tr>
                <td height="20" style="padding-top:5"><img src="img/RightArrow.jpg" width="12" height="12">Specials</td>
              </tr>
            </table>
            <br>
            <hr width="125" color="#CCCCCC">
            <table width="115" height="28" border="0" cellpadding="0" cellspacing="0" style="margin-top:10">
              <tr>
                <td height="28">
                    <div style="border-bottom: 0px dotted #999999; padding-right:0; width:125; padding-bottom:4">
					<a href="GroupList.php" class="one STYLE8"><span class="STYLE14"><a href="GroupList.php" class="one">Group</a></span>		                     &nbsp;&nbsp;&nbsp;<font color="#006699" size="3">
					<div style="background: #CC3300; width:60; padding-bottom:10; padding-top:10; border-right:#000000 solid 2; border-bottom:#000000 solid 2" align="center"><a href="GroupCreate.php">Create</a></div>
					</font></a>
					</div>
				</td>
              </tr>
            </table>
            <table width="130" height="145" border="0" cellpadding="0" cellspacing="0" style="margin-top:5">
              <tr>
                <td height="25">
                    <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; width:100; padding-bottom:4">
					<span class="STYLE14">Potentials</span>
					</div>
				</td>
              </tr>
              <tr>
                <td height="20" style="padding-top:5"> <img src="img/RightArrow.jpg" width="12" height="12"><a class='one' href="Grouplist.php?type=hometown"> Hometown</a></td>
              </tr>
              <tr>
                <td height="20" style="padding-top:5"><img src="img/RightArrow.jpg" width="12" height="12"><a class='one' href="Grouplist.php?type=interests"> Interests </a></td>
              </tr>
              <tr>
                <td height="20" style="padding-top:5"><img src="img/RightArrow.jpg" width="12" height="12"><a class='one' href="Grouplist.php?type=expertise"> Expertise </a></td>
              </tr>
              <tr>
                <td height="20" style="padding-top:5"><img src="img/RightArrow.jpg" width="12" height="12"><a class='one' href="Grouplist.php?type=school"> Schools</a> </td>
              </tr>
              <tr>
                <td height="20" style="padding-top:5"><img src="img/RightArrow.jpg" width="12" height="12"><a class='one' href="Grouplist.php?type=career"> Career</a>  </td>
              </tr>
              <tr>
                <td height="20" style="padding-top:5"><img src="img/RightArrow.jpg" width="12" height="12"><a class='one' href="Grouplist.php?type=specials"> Specials</a></td>
              </tr>
            </table>
          </div>
	  </td>
      <td width="882" align="left" valign="top" style=" border:#CCCCCC solid 0; padding-left:3;">
	  <table width="885" height="500" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="685" valign="top"><div align='center'>
			<?php
			include 'dbconnect.php';
			$gid=$_GET['gid'];
			if(isset($_GET['accept']))
			{
				//remove from the applylist and add to memberlist
				$applier=$_GET['accept'];
				$sql="SELECT applylist from rockinus.group_info WHERE gid='$gid' ORDER BY pdate DESC";
				$result = mysql_query($sql);
				if (!$result) 
				{
					die('Invalid query: ' . mysql_error());
				}
				$arr = mysql_fetch_array($result);
				$applylist=$arr['applylist'];
				$pieces = explode(",", $applylist);
				$length=count($pieces);
				for($i=0;$i<$length;$i++)
				{
					if($pieces[$i]==$applier)
					{
						$pieces[$i]=null;
						break;
					}
				}
				$applylist=implode(",",$pieces);
				$applylist=str_replace(",,",",",$applylist);
				$applylist=implode(",",$pieces);
				$applylist=str_replace(",,",",",$applylist);
				$sql="update rockinus.group_info set applylist='$applylist' where gid='$gid'";
				$result = mysql_query($sql);
				if (!$result) 
				{
					die('Invalid query: ' . mysql_error());
				}
				$sql="SELECT unamelist from rockinus.group_info WHERE gid='$gid' ORDER BY pdate DESC";
				$result = mysql_query($sql);
				if (!$result) 
				{
					die('Invalid query: ' . mysql_error());
				}
				$arr = mysql_fetch_array($result);
				$memberlist=$arr['unamelist'].','.$applier;
				$sql="update rockinus.group_info set unamelist='$memberlist' where gid='$gid'";
				$result = mysql_query($sql);
				if (!$result) 
				{
					die('Invalid query: ' . mysql_error());
				}
				
				
				unset($_GET['accept']);
			}
			if(isset($_GET['ignore']))
			{
				//remove from the applylist
				$applier=$_GET['ignore'];
				$sql="SELECT applylist from rockinus.group_info WHERE gid='$gid' ORDER BY pdate DESC";
				$result = mysql_query($sql);
				if (!$result) 
				{
					die('Invalid query: ' . mysql_error());
				}
				$arr = mysql_fetch_array($result);
				$applylist=$arr['applylist'];
				$pieces = explode(",", $applylist);
				$length=count($pieces);
				for($i=0;$i<$length;$i++)
				{
					if($pieces[$i]==$applier)
					{
						$pieces[$i]=null;
						break;
					}
				}
				$applylist=implode(",",$pieces);
				$applylist=str_replace(",,",",",$applylist);
				$applylist=implode(",",$pieces);
				$applylist=str_replace(",,",",",$applylist);
				$sql="update rockinus.group_info set applylist='$applylist' where gid='$gid'";
				$result = mysql_query($sql);
				if (!$result) 
				{
					die('Invalid query: ' . mysql_error());
				}
			}
			
			$sql="SELECT applylist from rockinus.group_info WHERE gid='$gid' ORDER BY pdate DESC";
			$result = mysql_query($sql);
			if (!$result) 
			{
				die('Invalid query: ' . mysql_error());
			}
			$arr = mysql_fetch_array($result);
			if ($arr['applylist']==null)
			{
				?>
				Fuck you don't have applier there.
				<?php
			}
			else
			{
				$applylist=$arr['applylist'];
				$pieces = explode(",", $applylist);
				$length=count($pieces);
				while(($length--)>0)
				{
					?>
					Applier name: 
					<?php echo $pieces[$length];?>
					<a class='one' href="GroupRequestList.php?accept=<?php echo $pieces[$length]; ?>&gid=<?php echo $gid ?>">accept</a>&nbsp;&nbsp;
					<a class='one' href="GroupRequestList.php?ignore=<?php echo $pieces[$length]; ?>&gid=<?php echo $gid ?>">ignore</a>
					<?php
				}
			}
			?>
			</td>
            <td width="200" rowspan="2" background="img/Emma_Watson_British_actress.jpg" bgcolor="#EEEEEE" style="border-left: 1px solid #CCCCCC; margin-left:5">&nbsp;</td>
          </tr>
        </table>
      </td>
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