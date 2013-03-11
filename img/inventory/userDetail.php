<?php
include("HeaderOut.php");
if(isset($_GET['uname'])){
	$getname = $_GET['uname'];
	include 'dbconnect.php'; 
	$result = mysql_query("SELECT * from inventory.user_check_info a INNER JOIN inventory.user_info b ON a.uname='$getname' AND a.uname=b.uname");
	if (!$result) die('Invalid query: ' . mysql_error());
	$obj = mysql_fetch_object($result);
	$email=$obj->email;
	$address=$obj->address;
	$fname=$obj->fname;
	$lname=$obj->lname;
	$phone=$obj->phone;
	$level=$obj->level;
	$signup_date=$obj->signup_date;
	$signup_time=$obj->signup_time;
?>
<div align="left" style="padding-bottom:10px; padding-top:0px; padding-left:10px; background-color:">
  <table width="1024" height="142" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="233" valign="top">
	  <form action="index.php" method="post">
	    <table width="233" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-right:0px #333333 dotted; padding-right:15px; margin-bottom:25px">
          <tr>
            <td height="25" colspan="3" align="right"><div align="center">
                <?php
	  	if(isset($_SESSION['rst_msg'])){
			echo($_SESSION['rst_msg']);
	  		unset($_SESSION['rst_msg']);
		}
	  ?>
            </div></td>
          </tr>
          <tr>
            <td width="96" height="40" align="right" style="padding-right:10px;"><span class="STYLE12">Username </span></td>
            <td height="40" colspan="2"><input name="uname" type="text" size="15" class="box" /></td>
          </tr>
          <tr>
            <td width="96" height="40" align="right" style="padding-right:10px;"><span class="STYLE12">Password </span></td>
            <td height="40" colspan="2"><input name="passwd" type="password" size="15" class="box" /></td>
          </tr>
          <tr>
            <td width="96" height="45" align="right" style="padding-right:10px;">&nbsp;</td>
            <td width="51" height="45"><input name="submit" type="submit" class="btn" value="Login" /></td>
            <td width="86" height="45">&nbsp;</td>
          </tr>
          <tr>
            <td width="96" height="45" align="right" style="padding-right:10px; padding-bottom:10px; padding-top:12px">&nbsp;</td>
            <td height="45" colspan="2"><div style="padding-top: 5px; padding-bottom: 5px; padding-left:10px;width: 110px; background:#EEEEEE" align="left"> <a href="join.php"><font color="#336633"><strong>+ New User </strong></font></a></div></td>
          </tr>
          <tr>
            <td width="96" height="35" align="left" style="padding:5px; border:0px #333333 solid">&nbsp;</td>
            <td height="35" colspan="2" align="left" style="border:0px #333333 solid"><div style="padding-top: 5px; padding-bottom: 5px; padding-left:10px; width: 110px; background:#EEEEEE" align="left"> <a href="findpwd.php"><strong><font color="#336633">Find Passwd </font></strong></a></div></td>
          </tr>
        </table>
	    <div align="center"><img src="img/GUnitThisis50New_com.png" width="183" height="183" /></div>
	  </form>
	  </td>
      <td width="791" valign="top"><div align="center">
        <table width="700" height="23" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:5px; border-top:1px #000000 solid;">
          <tr>
            <td width="449" height="45" bgcolor="#666666" align="left" style="padding-left:15px">
			<?php echo("<font size=3 color=#CCCCCC>Profile : </font> <font size=4 color=#FFFFFF><strong>$getname</strong></font>") ?></td>
            <td width="251" height="45" bgcolor="#666666" align="right" style="padding-right:15px">
			<a href="index.php" class=one><font size=3 color=#FFFFFF>Go Back</font></a>
			</td>
          </tr>
        </table>
        <table width="700" height="18" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:0px">
          <tr>
            <td width="351" height="15" align="left" style="border-bottom:0px #EEEEEE dotted; padding-left:10px">&nbsp;</td>
            <td width="349" height="15" style="border-bottom:0px #EEEEEE dotted"><div align="right" style="padding-right:10px">
            </div></td>
          </tr>
        </table>
        <table width="700" height="210" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px dotted  #CCCCCC; margin-bottom:5px">
          <tr>
            <td width="155" height="45" style="padding-right:15px" align="right">Full Name </td>
            <td width="361" height="45" >
			<?php echo("<font size=3>$fname $lname </font>") ?>			</td>
            <td width="184" height="45" style="padding-right:10px" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td height="45" style="padding-right:15px" align="right"">Email Address </td>
            <td height="45" align="left">
			<?php echo("<font size=3>$email</font>") ?>			
			</td>
            <td height="45" align="right" style="padding-right:10px; padding-bottom:5px"></td>
          </tr>
          <tr>
            <td height="45"  style="padding-right:15px" align="right">Phone Number </td>
            <td height="45" align="left"><?php echo("<font size=3>$phone</font>") ?></td>
            <td height="45" align="right" style="padding-right:10px; padding-bottom:5px"></td>
          </tr>
          <tr>
            <td height="45" style="padding-right:15px" align="right">User Level</td>
            <td height="45" align="left"><?php echo("<font size=3>$level</font>") ?></td>
            <td height="45" align="right" style="padding-right:10px; padding-bottom:5px"></td>
          </tr>
          <tr>
            <td height="45" style="padding-right:15px" align="right">Address</td>
            <td height="45" align="left"><?php echo("<font size=3>$address</font>") ?></td>
            <td height="45" align="right" style="padding-right:10px; padding-bottom:5px"></td>
          </tr>
          <tr>
            <td height="45" style="padding-right:15px" align="right">Signup Date </td>
            <td height="45" align="left"><?php echo("<font size=3>$signup_date</font>") ?></td>
            <td height="45" align="right" style="padding-right:10px; padding-bottom:5px"></td>
          </tr>
          <tr>
            <td height="45" style="padding-right:15px" align="right">Signup Time </td>
            <td height="45" align="left"><?php echo("<font size=3>$signup_time</font>") ?></td>
            <td height="45" align="right" style="padding-right:10px; padding-bottom:5px">			</td>
          </tr>
        </table>
      </div></td>
    </tr>
  </table>
</div>
<?php
	mysql_close($link); 
}?>
</body>
</html>
