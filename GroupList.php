<?php include("Header.php"); ?>
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="padding-top:-5; margin-top:-1;">
    <tr>
      <td width="136" align="left" valign="top" style="border-right: 1px solid #EEEEEE; padding-left:15px">
	 <?php include("leftMenuFriendGroup".$_SESSION['lan'].".php"); ?><br /><br />
	  </td>
      <td width="882" align="left" valign="top" style=" border:#CCCCCC solid 0; padding-left:3;">
	  <table width="875" height="500" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="685" valign="top" align="center" style="border-top:2px #EEEEEE solid; padding-top:10px">
            <?php
			include 'dbconnect.php';
			if (isset($_GET['delete']))
			{
				$gid=$_GET['gid'];
				$sql="delete from rockinus.group_info WHERE gid='$gid'";
				$result = mysql_query($sql);
				if (!$result) 
				{
					die('Invalid query: ' . mysql_error());
				}
				unset($_GET['gid']);
			}
			if (isset($_GET['apply']))
			{
				$gid=$_GET['gid'];
				$sql="SELECT * from rockinus.group_info WHERE gid='$gid'";
				$result = mysql_query($sql);
				if (!$result) 
				{
					die('Invalid query: ' . mysql_error());
				}
				$arr = mysql_fetch_array($result);
				$applylist=$arr['applylist'];
				if($applylist==null)
					$applylist=$_SESSION['usrname'];
				else
					$applylist=$arr['applylist'].','.$_SESSION['usrname'];
				$sql="update rockinus.group_info set applylist='$applylist' WHERE gid='$gid'";
				$result = mysql_query($sql);
				if (!$result) 
				{
					die('Invalid query: ' . mysql_error());
				}
				unset($_GET['apply']);
			}
			if (isset($_GET['gid']))
			{
				$gid=$_GET['gid'];
				$sql="SELECT * from rockinus.group_info WHERE gid='$gid' ORDER BY pdate DESC";
				$result = mysql_query($sql);
				if (!$result) 
				{
					die('Invalid query: ' . mysql_error());
				}
				//$count = mysql_num_rows($result);
				//$i=0;
				$arr = mysql_fetch_array($result);
				?>
            <table width="650" border="0" cellpadding="0" cellspacing="0" bgcolor="#F9F8FE" style="border-bottom:1px #EEEEEE solid">
              <tr>
                <td width="123" height="35" align="right" style="padding-right: 15px"><strong>Group Name</strong></td>
                <td width="430" height="35" align="left" style="border-bottom:1px #EEEEEE dotted"><strong><a class='one' href="GroupList.php?gid=<?php echo $arr['gid'] ?>"><font color="#336633"><?php echo $arr['gname'] ?></font></a></strong> | <font color="#CCCCCC"><?php echo $arr['builder'] ?></font></td>
                <td width="97" align="right" style="border-bottom:1px #EEEEEE dotted; padding-right:15px">
				<?php 
				if ($arr['builder']==$_SESSION['usrname']){
					$a = $arr['gid'];
					//循环显示加入人名称
					$sql="SELECT * from rockinus.group_info WHERE gid='$gid' ORDER BY pdate DESC";
					$result = mysql_query($sql);
					if (!$result) die('Invalid query: ' . mysql_error());
					$arr = mysql_fetch_array($result);
					echo("<a class='one' href='GroupList.php?delete=$a&gid=$a'>Delete</a></br>");
					$applylist = $arr['unamelist'];
					$pieces = explode(",", $applylist);
				}else if($arr['unamelist']!=null ){
					//if this group have no applylist, there will be no "accept" link, otherwise loop : represent the "accept"link
					$a = $arr['gid'];
					echo("<a class='one' href='GroupRequestList.php?gid=$a'>GroupRequest</a><br>");
				}
				?>
				</td>
              </tr>
              <tr>
                <td height="35" align="right" style="padding-right: 15px"><strong>Category</strong></td>
                <td height="35" colspan="2" align="left" style="border-bottom:1px #EEEEEE dotted"><?php echo $arr['category'] ?></td>
              </tr>
              <tr>
                <td height="35" align="right" style="padding-right: 15px"><strong>Member list</strong></td>
                <td height="35" colspan="2" align="left" style="border-bottom:0px #EEEEEE dotted"><?php echo $arr['unamelist'] ?></td>
              </tr>
            </table>
            <span style="border-bottom:1px #EEEEEE dotted; padding-right:15px">
            <?php
				if ($arr['builder']==$_SESSION['usrname'])
				{
				}else{
					//check if the current user is in the applylist or memberlist
					$applylist=$arr['applylist'];
					$pieces = explode(",", $applylist);
					$length=count($pieces);
					$flag=0;
					for($i=0;$i<$length;$i++){
						if($pieces[$i]==$_SESSION['usrname'])
						{
							$flag=1;
							break;
						}
					}
					$memberlist=$arr['unamelist'];
					$pieces = explode(",", $memberlist);
					$length=count($pieces);
					for($i=0;$i<$length;$i++)
					{
						if($pieces[$i]==$_SESSION['usrname'])
						{
							$flag=1;
							break;
						}
					}
					if($flag==0)
					{
						//if the current user already joined the group, there will be no "apply" link in this page; otherwise, it will have
						$a = $arr['gid'];
						echo("<a class='one' href='GroupList.php?apply=$a&gid=$a'>apply</a>");
					}
				}
			}
			else if (isset($_GET['type']))
			{
				$type=$_GET['type'];
				$sql="SELECT * from rockinus.group_info WHERE category='$type' ORDER BY pdate DESC";
				$result = mysql_query($sql);
					if (!$result) 
					{
						die('Invalid query: ' . mysql_error());
					}
				//$count = mysql_num_rows($result);
				//$i=0;
				while($arr = mysql_fetch_array($result))
				{
					?>
            </span></br>
            <table width="650" border="0" cellpadding="0" cellspacing="0" bgcolor="#F9F8FE" style="border-bottom:1px #EEEEEE solid">
                  <tr>
                    <td width="122" height="35" align="right" style="padding-right: 15px"><strong>Group Name</strong></td>
                    <td width="526" height="35" align="left" style="border-bottom:1px #EEEEEE dotted"><strong><a class='one' href="GroupList.php?gid=<?php echo $arr['gid'] ?>"><font color="#336633"><?php echo $arr['gname'] ?></font></a></strong> | <font color="#CCCCCC"><?php echo $arr['builder'] ?></font></td>
                  </tr>
                  <tr>
                    <td height="35" align="right" style="padding-right: 15px"><strong>Category</strong></td>
                    <td height="35" align="left" style="border-bottom:1px #EEEEEE dotted"><?php echo $arr['category'] ?></td>
                  </tr>
                  <tr>
                    <td height="35" align="right" style="padding-right: 15px"><strong>Member list</strong></td>
                    <td height="35" align="left" style="border-bottom:0px #EEEEEE dotted"><?php echo $arr['unamelist'] ?></td>
                  </tr>
              </table>
				</br>
					<?php
				}
			}else{
				$sql="SELECT * from rockinus.group_info ORDER BY pdate DESC";
				$result = mysql_query($sql);
					if (!$result) 
					{
						die('Invalid query: ' . mysql_error());
					}
				//$count = mysql_num_rows($result);
				//$i=0;
				while($arr = mysql_fetch_array($result))
				{
					?>
					<table width="650" border="0" cellpadding="0" cellspacing="0" bgcolor="#F9F8FE" style="border-bottom:1px #EEEEEE solid">
					<tr><td width="141" height="130" rowspan="3" align="right" style="padding-right: 15px">
					<?php if($arr['category']=="soccer")echo "<img src=img/soccer_icon.jpg>";
					else if($arr['category']=="fashion")echo "<img src=img/fashion_icon.jpg>";
					else if($arr['category']=="career")echo "<img src=img/career_icon.jpg>";
					?>
					&nbsp;</td>
					<td height="35" colspan="2" align="left" style="border-bottom:1px #EEEEEE dotted">
					<strong><a class='one' href="GroupList.php?gid=<?php echo $arr['gid'] ?>"><font color="#336633"><?php echo $arr['gname'] ?></font></a></strong> <font color=#CCCCCC>| <?php echo $arr['builder'] ?></font></td>
					</tr>
					<tr>
					<td width="415" height="35" align="left" style="border-bottom:1px #EEEEEE dotted"><?php echo $arr['category'] ?></td>
					<td width="94" align="left" style="border-bottom:1px #EEEEEE dotted"><font color="#CCCCCC"><?php echo $arr['pdate'] ?></font></td>
					</tr>
					<tr>
					<td height="35" colspan="2" align="left" style="border-bottom:0px #EEEEEE dotted"><?php echo $arr['unamelist'] ?></td>
					</tr>
			  </table>
					</br>
					<?php
				}
			}
			?>
			</td>
            <td width="200" rowspan="2" bgcolor="#F5F5F5" style="border-left: 1px solid #CCCCCC; margin-left:5">&nbsp;			</td>
          </tr>
      </table>
      </td>
    </tr>
  </table>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>