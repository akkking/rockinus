<?php 
include 'dbconnect.php';
include("Allfuc.php");
session_start();
$uname = $_SESSION['usrname'];
	
$q = mysql_query("SELECT * FROM rockinus.user_info where uname='$uname'");
if(!$q) die(mysql_error());
$object = mysql_fetch_object($q);
$fname = $object->fname;
$lname = $object->lname;
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;

$wid = ProfileProgress($uname);

include 'mainHeader.php';
?>
<style type="text/css">
<!--
.STYLE7 {color: #CC3300}
.STYLE8 {color: #000000}
.STYLE10 {color: #000000; font-weight: bold; }
-->
</style>
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
-moz-border-radius: 5px; 
border-radius: 5px;
border:12px solid #DDDDDD;
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
	font-size: 14px;
}
</style>
<div align="center">
  <table width="1024" height="399" border="0" cellpadding="0" cellspacing="0" style="padding-top:0; margin-top:0;" bgcolor="#FFFFFF">
    <tr>
      <td width="230" height="399" align="left" valign="top" style=" line-height:150%; font-size:14px; padding-left:15px">
	  <?php include "ProfileMenu.php" ?>	  </td>
      <td width="794" align="right" valign="top">
	  <form enctype="multipart/form-data" action="upload.php"  method="post" onsubmit="return ray.ajax()" >
        <table height="399" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="399" align="left" valign="top" style="padding-top:15px">
			<table width="760" height="241" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="50" colspan="2" align="center" style="border-right:1px dashed #DDDDDD">
				  <?php 
if(isset($_SESSION['rst_msg'])){
	echo $_SESSION['rst_msg'];
	unset($_SESSION['rst_msg']);
	}
?></td>
                  <td width="106" height="50"  align="right" bgcolor="#FFFFFF" style="padding-right:10"><font color="#336633"><?php echo($wid)?>%</font></td>
                  <td width="250" height="50" bgcolor="#FFFFFF"><div align="left" style="width:200; padding-top:0; padding-bottom:0; border:1 #336633 solid; background: #EEEEEE">
                    <table height="17" border="0" cellpadding="0" cellspacing="0" >
                      <tr>
                        <td height="17" width="<?php echo(2*$wid)?>" bgcolor="#336699" align="left">&nbsp;</td>
                      </tr>
                    </table>
                  </div></td>
                </tr>
                <tr>
                  <td width="174" height="45" align="right" style="padding-right:15px;  ">&nbsp;</td>
                  <td width="346"  style=" padding-left:0;border-right:1px dashed #DDDDDD" align="left">&nbsp;
                      <input name="uname" type="hidden" class="box" value="<?php echo($uname); ?>" style=" background-color:#F5F5F5; border:0; font-weight:bold;  " disabled="disabled" size="20" /></td>
                  <td colspan="2" rowspan="2" bgcolor="#FFFFFF"><div style="padding-bottom:20; padding-top:20; padding-left:15; padding-right:15; width:290; margin-bottom:10" align="center">
                      <?php 
					  $target = "upload/".$uname;
					  if(is_dir($target)){
				  		$pic250_Name = $uname.'250.jpg?'.time();
						echo("<img src=upload/$uname/$pic250_Name style=border:0>");
				  	}else 
				  		echo("<img src=img/NoUserIcon250.jpg style=border:0>");
					?>
                    </div>
				  </td>
                </tr>
                <tr>
                  <td height="141" colspan="2"  style="border-right:1px dashed #DDDDDD">
				  <div align="center">
				    <div align="center" style="background-color:; opacity:0.9; filter:alpha(opacity=80); padding-top: 10; padding-bottom: 15; margin-top:10; margin-bottom:50; padding-left: 5; padding-right:5; border-color: #999999; border-style: solid; width:450;; border-width: 0;">
                        <table width="450" height="185" border="0" cellpadding="0" cellspacing="8">
                          <tr>
                            <td width="112" height="39" align="right" style="; font-weight:bold; ">Select Image </td>
                            <td colspan="2"><input name="uploaded" type="file" style="border-style: solid; border-width: 1px;border-color: black;padding-left: 0px; background-color: #FFFFFF" /></td>
                          </tr>
                          <tr>
                            <td height="57">&nbsp;</td>
                            <td width="98"><input type="submit" name="Submit" value="Upload" style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:1px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; " /></td>
                            <td width="148"><font color="#666666"><em>(Smaller than 2MB)</em></font></td>
                          </tr>
                          <tr>
                            <td height="57">&nbsp;</td>
                            <td colspan="2">
							<?php 
				  	if(isset($_SESSION['rst_flag']) && $_SESSION['rst_flag']=="success"){
				  		echo("<div style='height:18px; padding:2px 5px 2px 5px; background: url(img/master.jpg); margin-top:5px; width:100px; border:1px solid #999999; font-size:13px; cursor:pointer; color:#000000; -moz-border-radius: 3px; border-radius: 3px;' align='center'  onmouseover=\"this.style.border='1px #CCCCCC solid'\" onmouseout=\"this.style.border='1px #999999 solid'\"><a href='ThingsRock.php' class='two'>Home Page</a></div><div style='height:18px; padding:2px 5px 2px 5px; background: url(img/master.jpg); margin-top:15px; width:100px; border:1px solid #999999; font-size:13px; cursor:pointer; color:#000000; -moz-border-radius: 3px; border-radius: 3px;' align='center' onmouseover=\"this.style.border='1px #CCCCCC solid'\" onmouseout=\"this.style.border='1px #999999 solid'\"><a href='EditPassword.php' class='two'>Edit Password</a></div>");
					  	unset($_SESSION['rst_flag']);
					  }
					?>
							</td>
                          </tr>
                        </table>
						<div id="load" style="display:none;"><img src="img/lodingHeadIcon.gif" /></div>
                      </div>
                  </div></td>
                </tr>
                <tr>
                  <td height="10" colspan="2" valign="top" style="border-right:0 dotted #CCCCCC">&nbsp;</td>
                  <td colspan="2" align="center">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
		</form>
	  </td>
    </tr>
</table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
