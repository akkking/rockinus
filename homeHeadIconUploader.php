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
 <div id="load" style="display:none;"><img src="img/lodingHeadIcon.gif" /></div>
 <div style="height:75px; margin-bottom:10px">
 <form enctype="multipart/form-data" action="upload_home.php"  method="post" onsubmit="return ray.ajax()" >
<table width="360" height="60" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="60" rowspan="2" align="left" style="font-weight:bold;" valign="top">
							<?php echo($unameImg) ?>							</td>
                            <td height="35" colspan="2" align="left" style="padding-left:15px" valign="top">
							<input name="uploaded" size="28" type="file" style="border: 1px solid #DDDDDD; background-color: #FFFFFF" />							</td>
                          </tr>
                          <tr>
                            <td width="90" height="30" align="left" style="padding-left:15px" valign="top">
							 <input name="uname" type="hidden" class="box" value="<?php echo($uname); ?>" style=" background-color:#F5F5F5; border:0; font-weight:bold;  " disabled="disabled" size="20" />
							<input type="submit" name="Submit" value="Upload" style="height:25; padding:2 10 2 10; background: url(img/master.jpg); cursor:pointer; border:1px solid #999999; font-size:12px; color:#000000; line-height:100%; -moz-border-radius: 3px; border-radius: 3px; " />							</td>
                            <td width="210" height="30" valign="top" style=" color:#999999; font-size:12px; padding-top:5px; font-weight:normal">
							<?php 
if(isset($_SESSION['rst_flag'])&&$_SESSION['rst_flag']=="success"){
	echo $_SESSION['headicon_rst_msg'];
	unset($_SESSION['rst_flag']);
	unset($_SESSION['headicon_rst_msg']);
}else if(isset($_SESSION['rst_flag'])&&$_SESSION['rst_flag']=="error"){
	echo $_SESSION['headicon_rst_msg'];
	unset($_SESSION['rst_flag']);
	unset($_SESSION['headicon_rst_msg']);
}else{	
	echo("($uname_fname, set a new icon)");
}
?>
							</td>
                          </tr>
  </table>
</form>
</div>