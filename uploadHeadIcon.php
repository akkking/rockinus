
<script type="text/javascript">
var ray={
ajax:function(st){
	 this.show('load');
},

show:function(el){
	 this.getID(el).style.display='';
},

getID:function(el){
	 return document.getElementById(el);
}
}
</script>

<style type="text/css">
#load{
position:absolute;
z-index:1;
border:4px solid #DDDDDD;
background: #F5F5F5;
color:#FFFFFF;
width:250px;
padding-top:15px;
padding-bottom:15px;
margin-top:-150px;
margin-left:-150px;
top:50%;
left:50%;
text-align:center;
line-height:500px;
font-family:"Trebuchet MS", verdana, arial,tahoma;
font-size:14pt;
}
body,td,th {
	font-size: 13px;
}
</style>
	  <form enctype="multipart/form-data" action="upload.php"  method="post" onsubmit="return ray.ajax()" >
<table width="740" height="241" border="0" cellpadding="0" cellspacing="0" style="border:#DDDDDD solid 0px; background:; margin-top:60px;">
  <tr>
    <td height="60" colspan="2" align="center" style="border-right:1px dashed #DDDDDD"><?php 
if(isset($_SESSION['rst_msg'])){
	echo $_SESSION['rst_msg'];
	unset($_SESSION['rst_msg']);
	}else echo("<img src='img/blackSmileIcon.png' width='15'>&nbsp;&nbsp; <font style='font-size:18px;'>Great! Now let's upload a head icon~</font>");
?></td>
    <td width="106"  align="right" bgcolor="#FFFFFF" style="padding-right:10; font-size:13px">
	<font color="#336633"><?php echo($wid)?>% Profile</font></td>
    <td width="250" bgcolor="#FFFFFF"><div align="left" style="width:200; padding-top:0; padding-bottom:0; border:1 #336633 solid; background: #EEEEEE">
      <table height="17" border="0" cellpadding="0" cellspacing="0" >
        <tr>
          <td height="17" width="<?php echo(2*$wid)?>" bgcolor="#336699" align="left">&nbsp;</td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td width="174" height="45" align="right" style="padding-right:15px; font-size:13px; font-family:Arial, Helvetica, sans-serif">&nbsp;</td>
    <td width="346"  style=" padding-left:0;border-right:1px dashed #DDDDDD" align="left"><input name="uname" type="hidden" class="box" value="<?php echo($uname); ?>" style=" background-color:#F5F5F5; border:0; font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif" disabled="disabled" size="20" /></td>
    <td colspan="2" rowspan="2" bgcolor="#FFFFFF"><div style="padding-bottom:20; padding-top:20; padding-left:15; padding-right:15; width:290; margin-bottom:10" align="center">
      <?php 
					  $target = "upload/".$uname;
					  if(is_dir($target)){
				  		$pic250_Name = $uname.'250.jpg?'.time();
						echo("<img src=upload/$uname/$pic250_Name style=border:0>");
				  	}else 
				  		echo("<img src=img/NoUserIcon250.jpg style=border:0>");
					?>
    </div></td>
  </tr>
  <tr>
    <td height="141" colspan="2"  style="border-right:1px dashed #DDDDDD"><div align="center">
      <div align="center" style="background-color:; opacity:0.9; filter:alpha(opacity=80); padding-top: 10; padding-bottom: 15; margin-top:10; margin-bottom:50; padding-left: 0; padding-right:5; border-color: #999999; border-style: solid; width:400;; border-width: 0;">
        <table width="415" height="185" border="0" cellpadding="0" cellspacing="8">
          <tr>
            <td width="107" height="39" align="right" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:13px; padding-right:10">Select Image </td>
            <td colspan="2"><input name="uploaded" type="file" style="border-style: solid; border-width: 1px;border-color: black;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #FFFFFF" /></td>
          </tr>
          <tr>
            <td height="57">&nbsp;</td>
            <td width="84"><input type="submit" name="Submit" value="Upload" style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:1px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif" /></td>
            <td width="167"><font color="#666666"><em>Smaller than 1MB</em></font></td>
          </tr>
          <tr>
            <td height="57">&nbsp;</td>
            <td colspan="2"><?php 
				  	if(isset($_SESSION['rst_flag']) && $_SESSION['rst_flag']=="success"){
				  		echo("<div style='padding-left:0; margin-bottom:10'><input type='button' class='profile_btn' style='background:$_SESSION[hcolor]' value=' Finish, Go home ' ONCLICK=window.location.href='ThingsRock.php' /></div><div style='padding-left:0; margin-bottom:10'><input type='button' class='profile_btn' style='background:$_SESSION[hcolor]' value=' Set a New Password ' ONCLICK=window.location.href='EditPassword.php' /></div>");
					  	unset($_SESSION['rst_flag']);
					  }
					?>
            </td>
          </tr>
        </table>
        <div id="load" style="display:none;"><img src="img/loading42.gif" /></div>
      </div>
    </div></td>
  </tr>
  <tr>
    <td height="10" colspan="2" valign="top" style="border-right:0 dotted #CCCCCC">&nbsp;</td>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
</table>
</form>