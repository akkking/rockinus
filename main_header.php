<?php 
session_start(); 
echo("<LINK REL='SHORTCUT ICON' HREF='img/rockinTag.png'>");
?>
<script type="text/javascript">
function off(elem){
	elem.className='overborder';
}
function on(elem){
	elem.className='outborder';
}

function showHideDiv(element){
	
	if(document.getElementById(element).style.display == 'none')
    {
    	document.getElementById('jobDiv').style.display = 'none';
		document.getElementById('courseDiv').style.display = 'none';
		document.getElementById('saleDiv').style.display = 'none';
		document.getElementById('alumniDiv').style.display = 'none';
	
		document.getElementById(element).style.display = 'block';    	
		document.getElementById('HomePageDiv').style.display = 'none';
		document.getElementById('SignUpDiv').style.display = 'none';
    }
    else if(document.getElementById(element).style.display == 'block')
    {
		document.getElementById(element).style.display = 'none';    	
		document.getElementById('HomePageDiv').style.display = 'block';
	}
}
</script>
<style type="text/css">
.outborder {
	border-bottom: 2px solid #DDDDDD;
}
.overborder {
	border-bottom: 2px solid #FF9966;
}
</style>
<style type="text/css">
<!--
body {
	background-color: #EEEEEE;
	margin-top: 0px;
	font-family:Arial, Helvetica, sans-serif
}
-->
</style><head>
<title>New York Community Network</title>
<meta name="google-translate-customization" content="3a5bfcb18fe6fadd-11bc63df57f4781e-g645d9e823cb1bbde-1f"></meta>
</head>
<div style="width:100%; background:; border-bottom:0px dashed #CCCCCC; margin-bottom:20" align="center">
  <table width="1024" height="115" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:0px">
    <tr>
      <td width="235" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-size:13px; line-height:100%; color:#000000; padding-top:0; padding-left:0">
          <table height="47" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:">
            <tr>
              <td width="234" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:28px; line-height:110%; color: #000000; padding-top:0;"><a href="index.php" class="one"><img src="img/rockinus_home_green.jpg" /></a></td>
              <td width="10" height="47" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-size:24px; line-height:110%; color:; padding-top:10;"></td>
            </tr>
          </table></td>
      <td width="789" align="right" valign="top" style="">
	  <table width="600" border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #DDDDDD">
        <tr>
          <td width="150" style="border-right:1px dashed #DDDDDD; border-left:1px solid #DDDDDD" class="outborder" onmouseover="off(this)" onmouseout="on(this)" onclick="showHideDiv('jobDiv')">
		  <img src="img/home_menu_job.jpg" width="150" height="65" style="cursor:pointer" />
		  </td>
          <td width="155" style="border-right:1px dashed #DDDDDD" class="outborder" onmouseover="off(this)" onmouseout="on(this)" onclick="showHideDiv('courseDiv')">
		  <img src="img/home_menu_course.jpg" width="150" height="65" style="cursor:pointer" /></td>
          <td width="146" style="border-right:1px dashed #DDDDDD; " class="outborder" onmouseover="off(this)" onmouseout="on(this)"  onclick="showHideDiv('saleDiv')">
		  <img src="img/home_menu_salerent.jpg" width="150" height="65" style="cursor:pointer" /></td>
          <td width="149" style="border-right:1px solid #DDDDDD" class="outborder" onmouseover="off(this)" onmouseout="on(this)" onclick="showHideDiv('alumniDiv')">
		  <img src="img/home_menu_connectalumni.jpg" width="150" height="65" style="cursor:pointer" /></td>
        </tr>
      </table>
	  </td>
    </tr>
  </table>
</div>