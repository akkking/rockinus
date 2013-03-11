<?php
include("HeaderOut.php");
require("class.phpmailer.php");
include("func.php");
include 'dbconnect.php';

if(isset($_POST['uname'])){
	$uname = trim($_POST['uname']);
	$fname = trim($_POST['fname']);
	$lname = trim($_POST['lname']);
	$passwd = trim($_POST['passwd']);
	$cpasswd = trim($_POST['cpasswd']);
	$level = $_POST['level'];
	$email = trim($_POST['email']);
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$_SESSION['address_val'] = $address;
	$tag=1;
	
	if($uname==NULL){
		$tag = 0;
		$_SESSION['uname_rst_msg']="<font color=red><strong>User Name is required</strong></font>";
	}else $_SESSION['uname_val'] = $uname;
		
	if($passwd==NULL && $tag==1){
		$tag = 0;
		$_SESSION['passwd_rst_msg']="<font color=red><strong>Passwords cannot be blank</strong></font>";
	}
	
	if($passwd!=$cpasswd && $tag==1){
		$tag = 0;
		$_SESSION['passwd_rst_msg']="<font color=red><strong>Passwords are not same</strong></font>";
	}
	
	if($fname==NULL && $lname==NULL && $tag==1){
		$tag = 0;
		$_SESSION['name_rst_msg']="<font color=red><strong>Input at least a Name</strong></font>";
	}else{
		$_SESSION['fname_val'] = $fname;
		$_SESSION['lname_val'] = $lname;
	}
	
	if($email==NULL && $tag==1){
		$tag = 0;
		$_SESSION['email_rst_msg']="<font color=red><strong>Email address is required</strong></font>";
	}else $_SESSION['email_val'] = $email;

	if(!(is_email($email)) && $tag==1){
		$tag = 0;
		$_SESSION['email_rst_msg']="<font color=red><strong>Email address is invalid</strong></font>";
	}else $_SESSION['email_val'] = $email;
	
	/*if($phone==NULL && $tag==1){
		$tag = 0;
		$_SESSION['phone_rst_msg']="<font color=red><strong>Phone number is required.</strong></font>";
	}else $_SESSION['phone_val'] = $phone;
	*/
	
	if( $tag==1 ){
		include 'dbconnect.php';
		$qresult = mysql_query("SELECT * FROM inventory.user_check_info");
		while($row = mysql_fetch_array($qresult)){
			if ( $uname == $row['uname'] ){
				$_SESSION['uname_rst_msg'] = "<font color=red><strong>The User name $uname already exists</strong></font>";
				$tag = 0;
				break;
			}

			if ( $email == $row['email'] ){
				$_SESSION['email_rst_msg'] = "<font color=red><strong>$email is already registered</strong></font>";
				$tag = 0;
				break;
			}	
		}
		
		if($tag==1){
			$sql = "INSERT INTO inventory.user_info(uname,fname,lname,level,phone,address,tbname)VALUES('$uname','$fname','$lname',
			'$level','$phone','$address','user_info')";
			$result = mysql_query($sql);
			if (!$result) die('Invalid query: ' . mysql_error());
			//echo($sql."<br>");
			$passwd = md5($passwd);
			$sql = "INSERT INTO inventory.user_check_info(uname,email,passwd,tag,signup_date,signup_time,tbname)VALUES('$uname','$email','$passwd','P',CURDATE(), NOW(),'user_check_info')";
			$result = mysql_query($sql);
			$fullname=$fname." ".$lname;
			//echo($sql);
			if (!$result) die('Invalid query: ' . mysql_error());
			//email to the administrator
			smtp_mail("gunit.inventory@gmail.com", "New User regitered", NULL, "bjorn@bjorncg.com", "admin", $fullname, "regist");
			$_SESSION['rst_msg']="<font color=#336633 size=4><strong>Your request has been sent to Administrator.</strong></font>";
		}
	}
}
?>
<style type="text/css">
<!--
.STYLE1 {color: #000000}
-->
</style>

<div align="left" style="padding-bottom:10px; padding-top:0px; padding-left:10px;">
  <table width="1024" height="142" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" colspan="2" valign="top" align="center">
	  <?php
	  	if(isset($_SESSION['rst_msg'])){
			echo($_SESSION['rst_msg']);
	  		unset($_SESSION['rst_msg']);
		}
	  ?>
	  </td>
    </tr>
    <tr>
      <td width="764" valign="top">
	  <form action="join.php" method="post" style="margin:0px">
	  <table width="743" height="390" border="0" cellpadding="0" cellspacing="0">

        <tr>
          <td width="171" height="40" ><div align="right" style="padding-right:15px; color:#000000">User Name </div></td>
          <td width="258" height="40"><input name="uname" type="text" size="15" class="box" value=
		  <?php if(isset($_SESSION['uname_val'])) echo($_SESSION['uname_val']);?> 
		  > 
            <font color=red>*</font>  </td>
          <td width="314" height="40"><?php
	  	if(isset($_SESSION['uname_rst_msg'])){
			echo($_SESSION['uname_rst_msg']);
	  		unset($_SESSION['uname_rst_msg']);
		}
	  ?></td>
        </tr>
        <tr>
          <td height="40"><div align="right" style="padding-right:15px; color:#000000">Password</div></td>
          <td height="40"><input name="passwd" type="password" size="15" class="box" /> 
		  <font color=red>*</font></td>
          <td height="40"><?php
	  	if(isset($_SESSION['passwd_rst_msg'])){
			echo($_SESSION['passwd_rst_msg']);
	  		unset($_SESSION['passwd_rst_msg']);
		}
	  ?></td>
        </tr>
        <tr>
          <td height="40"><div align="right" style="padding-right:15px; color:#000000">Confirm Password </div></td>
          <td height="40"><input name="cpasswd" type="password" size="15" class="box" /> 
		  <font color=red>*</font></td>
          <td height="40"><?php
	  	if(isset($_SESSION['passwd_rst_msg'])){
			echo($_SESSION['passwd_rst_msg']);
	  		unset($_SESSION['passwd_rst_msg']);
		}
	  ?></td>
        </tr>
        <tr>
          <td height="40" style="padding-right:15px; color:#CCCCCC" align="right"><span class="STYLE1">First / Last Name </span></td>
          <td height="40"><input name="fname" type="text" size="15" class="box" value=
		  <?php if(isset($_SESSION['fname_val'])) echo($_SESSION['fname_val']);?> > 
		  <input name="lname" type="text" size="15" class="box"  value=
		  <?php if(isset($_SESSION['lname_val'])) echo($_SESSION['lname_val']);?> > 
		  <font color=red>*</font></td>
          <td height="40"><?php
	  	if(isset($_SESSION['name_rst_msg'])){
			echo($_SESSION['name_rst_msg']);
	  		unset($_SESSION['name_rst_msg']);
		}
	  ?></td>
        </tr>
        <tr>
          <td height="40"><div align="right" style="padding-right:15px; color:#000000">Level </div></td>
          <td height="40" colspan="2">
		  <select name="level" class="box" />
              <option value="Regular">Regular User</option>
              <option value="Admin">Administrator</option>
              <option value="Manager">Manager</option>
          </select>		  </td>
        </tr>
        <tr>
          <td height="40"><div align="right" style="padding-right:15px; color:#000000">Email Address </div></td>
          <td height="40"><input name="email" type="text" size="30" class="box"  value=
		  <?php if(isset($_SESSION['email_val'])) echo($_SESSION['email_val']);?>
		  > 
		  <font color=red>*</font></td>
          <td height="40"><?php
	  	if(isset($_SESSION['email_rst_msg'])){
			echo($_SESSION['email_rst_msg']);
	  		unset($_SESSION['email_rst_msg']);
		}
	  ?></td>
        </tr>
        <tr>
          <td height="40"><div align="right" style="padding-right:15px; color:#000000">Phone Number </div></td>
          <td height="40"><input name="phone" type="text" size="20" class="box"  value=
		  <?php if(isset($_SESSION['phone_val'])) echo($_SESSION['phone_val']);?> ></td>
          <td height="40">&nbsp;</td>
        </tr>
        <tr>
          <td height="40"><div align="right" style="padding-right:15px; color:#000000">Address</div></td>
          <td height="40" colspan="2"><input name="address" type="text" size="70" class="box"  value=
		  <?php if(isset($_SESSION['address_val'])) echo($_SESSION['address_val']);?>
		  ></td>
        </tr>
        <tr>
          <td height="70"><span class="STYLE1"></span></td>
          <td height="70" colspan="2"><input name="submit" type="submit" class="btn" value="Submit" /></td>
        </tr>
      </table>
	  </form>	  </td>
      <td width="260" valign="top"><img src="img/50-cent-2.jpg"/>
	  </td>
    </tr>
  </table>
</div>
</body>
</html>
