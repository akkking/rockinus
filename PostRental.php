<?php 
include("mainHeader.php");
include("Allfuc.php");
include 'dbconnect.php';
$uname = $_SESSION['usrname'];

$q = mysql_query("SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_contact_info b ON a.uname='$uname' AND a.uname=b.uname;");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$fname = $object->fname;
if(trim($fname)==NULL)$fname="";
$email = $object->email;
if(trim($email)==NULL)$email="";
$phone = $object->phone;
if(trim($phone)==NULL)$phone="";
$ccity = $object->ccity;
$cstate = $object->cstate;
?>
<style type="text/css">
<!--
.STYLE1 {color: #CCCCCC}
-->
</style>
<link rel="stylesheet" href="style.css" />
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
<script>
function getXMLHTTP() { //fuction to return the xml http object
	var xmlhttp=false;	
	try{
		xmlhttp=new XMLHttpRequest();
	}
	catch(e)	{		
		try{			
			xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e1){
				xmlhttp=false;
			}
		}
	}
		 	
	return xmlhttp;
}
	
function getMetro(strURL)
{         
 var req = getXMLHTTP(); // fuction to get xmlhttp object 
 if (req)
 {
  	req.onreadystatechange = function()
 	{
  		if (req.readyState == 4) { //data is retrieved from server
   			if (req.status == 200) { // which reprents ok status                    
     			document.getElementById('metrostopDiv').innerHTML=req.responseText;
  			}
  			else
  			{ 
     			alert("There was a problem while using XMLHTTP:\n");
  			}
  		}            
  	}        
	req.open("GET", strURL, true); //open url using get method
	req.send(null);
 	}
}

function getCity(strURL)
{         
 var req = getXMLHTTP(); // fuction to get xmlhttp object 
 if (req)
 {
  	req.onreadystatechange = function()
 	{
  		if (req.readyState == 4) { //data is retrieved from server
   			if (req.status == 200) { // which reprents ok status                    
     			document.getElementById('cityDiv').innerHTML=req.responseText;
  			}
  			else
  			{ 
     			alert("There was a problem while using XMLHTTP:\n");
  			}
  		}            
  	}        
	req.open("GET", strURL, true); //open url using get method
	req.send(null);
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
</style>
<div align="center">
  <table width="1024" height="394" border="0" cellpadding="0" cellspacing="0" style="margin-top:0px;" bgcolor="#FFFFFF">
    <tr>
      <td width="300" align="left" valign="top" style=" padding-top:10px; padding-left:10px">
	  <?php include("leftHomeHouseMenu.php"); ?>
	  </td>
      <td width="760" align="right" valign="top">
	  <?php 
	  if(isset($_SESSION['rst_msg'])){
	  	echo $_SESSION['rst_msg'];
	  	unset($_SESSION['rst_msg']); }
	  ?>
	  <div id="load" style="display:none;"><img src="img/loading42.gif" /></div>
	  <form action="Lease_process.php" enctype="multipart/form-data" method="post" style="margin-top:0; margin-bottom:0;" onsubmit="return ray.ajax()">
	  <table width="613" height="348" border="0" cellpadding="0" cellspacing="0" style="border:0 #CCCCCC solid; margin-bottom:8">
        <tr>
          <td width="613" height="342" valign="top"><table width="740" height="35" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10; margin-top:10; border:1px #EEEEEE solid; background:">
            <tr>
              <td align='left' valign='top' style="color:#666666; background:#F5F5F5; padding:10; padding-bottom:8; padding-top:8; line-height:150%; font-size:11px; font-family:Arial, Helvetica, sans-serif"><strong>[Reminder]</strong> Suggest to compose in English, so everyone could understand. It's fine to post in a different language, please remember to leave a brief translation for other users convenience. We really need to be considerate, helpful and great.</td>
            </tr>
          </table>
          <table width="740" height="704" border="0" cellpadding="0" cellspacing="0" style="border:0px #DDDDDD solid; background:#F5F5F5">  
            <tr>
              <td height="50" align="right" style="border-bottom:#CCCCCC solid 0; padding-right:10px">
			  <img src="img/houseMenuIcon.jpg" width="17" />			  </td>
              <td height="50" colspan="3" align="left" style=" font-family: Arial, Helvetica, sans-serif Arial, Helvetica, sans-serif; font-weight:bold; font-size:18px">
			  <font color="<?php echo($_SESSION['hcolor']) ?>">Post Apartment Rent</font>			  </td>
              </tr>
            <tr>
              <td height="5" colspan="4" style="border-top:0px #999999 solid">&nbsp;</td>
              </tr>
            <tr>
              <td height="35" align="right" style="padding-right:10; font-size:14px; font-family: Arial, Helvetica, sans-serif">Title </td>
              <td height="35" colspan="3" style="font-size:14px; font-family: Arial, Helvetica, sans-serif"><input type="text" name="subject" size="80" class="box" style="font-size:14px; font-family: Arial, Helvetica, sans-serif" /></td>
            </tr>
            <tr>
              <td width="146" height="35" align="right" style="padding-right:10; font-size:14px; font-family: Arial, Helvetica, sans-serif">Category</td>
              <td width="174" height="35">
			      <select name="type" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
                  <option value="Single Room">Single Room</option>
                  <option value="Shared Room">Shared Room</option>
                  <option value="Apartment">Apartment</option>
				  <option value="Studio">Studio</option>
				  <option value="House">House</option>
				  <option value="Others">Others</option>
                </select>			  </td>
              <td height="35" align="right" style="padding-right:10; font-size:14px; font-family: Arial, Helvetica, sans-serif">Location </td>
              <td height="35">
			  <select name="state" onchange="getCity('findCity.php?state_name='+this.value)" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
                  <option value="any">Any State</option>
			  <?php 
						$city = mysql_query("SELECT state_name FROM rockinus.city_info GROUP BY state_name ASC;");
						if(!$city) die(mysql_error());
						while($obj_city = mysql_fetch_object($city)){
							$state_name = $obj_city->state_name;
						?><option value="<?php echo($state_name) ?>"><?php echo($state_name) ?></option>
                <? 
						}
						?>
              </select>
			  <div id="cityDiv" class="cityDiv" style="display:inline">
                <select name="city" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
                  <option value="any">Any City</option>
                  </select>
				</div>				</td>
            </tr>

            <tr>
              <td height="35" align="right" style="padding-right:10; font-size:14px; font-family: Arial, Helvetica, sans-serif">I wanna </td>
              <td height="35" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
			  <input type="radio" name="rentlease" value="Lease" checked="yes">
Lease
<input type="radio" name="rentlease" value="Rent">
Rent </td>
              <td height="35" align="right" style="padding-right:10; font-size:14px; font-family: Arial, Helvetica, sans-serif">Email</td>
              <td height="35"><input type="text" name="email" size="25" class="box" value="<?php echo($email); ?>" style="font-size:14px; font-family: Arial, Helvetica, sans-serif" /></td>
            </tr>
            <tr>
              <td height="35" align="right" style="padding-right:10; font-size:14px; font-family: Arial, Helvetica, sans-serif">$ Rate </td>
              <td height="35" colspan="3" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
			  <input type="text" name="rate" size="5" class="box" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
/ Month &nbsp;&nbsp;<font style='font-size:12px'><input type="checkbox" name="extra_fee[]" value="water" checked="checked" />Water&nbsp; <input type="checkbox" name="extra_fee[]" value="electricity" />Elec.&nbsp; <input type="checkbox" name="extra_fee[]" value="gas" />Gas&nbsp;<input type="checkbox" name="extra_fee[]" value="WiFi" />WiFi&nbsp;<input type="checkbox" name="extra_fee[]" value="parking" />Parking&nbsp; </font>			  </td>
              </tr>
            <tr>
              <td height="35" align="right" style="padding-right:10; font-size:14px; font-family: Arial, Helvetica, sans-serif">How long? </td>
              <td height="35"><select name="duration" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
                <option value="0" selected="selected">No Matter</option>
                <option value="7">1 Week</option>
                <option value="30">1 Month</option>
                <option value="91">3 Month</option>
                <option value="182">6 Month</option>
                <option value="365">1 Year</option>
              </select></td>
              <td width="87" height="35" align="right" style="padding-right:10; font-size:14px; font-family: Arial, Helvetica, sans-serif">Phone</td>
              <td width="331" height="35"><input type="text" name="telephone" size="15" class="box" value="<?php echo($phone); ?>" style="font-size:14px; font-family: Arial, Helvetica, sans-serif" /></td>
            </tr>
            <tr>
              <td height="35" align="right" style="padding-right:10; font-size:14px; font-family: Arial, Helvetica, sans-serif">Close to</td>
              <td height="35" colspan="3" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
			  Metro <select name="metroline" onchange="getMetro('findMetro.php?lineNo='+this.value)" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
                <option value="X">Any</option>
                <?php 
						$metro = mysql_query("SELECT lineNo FROM rockinus.metro_info GROUP BY lineNo ASC;");
						if(!$metro) die(mysql_error());
						while($obj_metro = mysql_fetch_object($metro)){
							$lineNo = $obj_metro->lineNo;
						?>
                <option value="<?php echo($lineNo) ?>"><?php echo($lineNo) ?></option>
                <? 
						}
						?>
              </select>
                <div id="metrostopDiv" class="metrostopDiv" style="display:inline">
                      <select name="metrostop" style="padding-right:10px; font-size:14px; font-family: Arial, Helvetica, sans-serif;">
                        <option value="empty">Any</option>
                      </select>
                    </div>                  
					<select name="metromins" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
                      <option value="0">Any Mins</option>
                      <option value="5">0~5 Mins</option>
                      <option value="10">5~10 Mins</option>
                      <option value="15">10~15 Mins</option>
                      <option value="20">15~20 Mins</option>
                      <option value="25">20~25 Mins</option>
                      <option value="30">25~30 Mins</option>
                    </select>              </td>
              </tr>
            <tr>
              <td height="35" align="right" style="padding-right:10; font-size:14px; font-family: Arial, Helvetica, sans-serif">Photos</td>
              <td height="35" colspan="3" style="font-size:14px; font-family: Arial, Helvetica, sans-serif"><input name="uploaded1" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #" /> 
                <font color="#CCCCCC">Make sure smaller than 500KB</font> </td>
              </tr>
            <tr>
              <td height="35">&nbsp;</td>
              <td height="35" colspan="3" style="font-size:14px; font-family: Arial, Helvetica, sans-serif"><input name="uploaded2" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #" />
                <font color="#CCCCCC">Make sure smaller than 500KB</font></td>
            </tr>
            <tr>
              <td height="35">&nbsp;</td>
              <td height="35" colspan="3" style="font-size:14px; font-family: Arial, Helvetica, sans-serif"><input name="uploaded3" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #" />
                <font color="#CCCCCC">Make sure smaller than 500KB</font></td>
            </tr>
            <tr>
              <td height="105" align="right" valign="top" style="padding-right:10; padding-top:15; font-size:14px; font-family: Arial, Helvetica, sans-serif">Description</td>
              <td height="105" colspan="3">
			  <textarea name="description" id="styled" style="margin-top:15; width:520; height:200; font-size:14px; font-family: Arial, Helvetica, sans-serif; line-height:130%; padding:4px;"></textarea></td>
            </tr>
            <tr>
              <td height="10">&nbsp;</td>
              <td height="10" colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td height="23" bgcolor="#F5F5F5" style="border-top:0 #CCCCCC solid">&nbsp;</td>
              <td height="23" colspan="3" align="left" bgcolor="#F5F5F5" style=" font-size:14px; font-family: Arial, Helvetica, sans-serif">
			  * Keep this post for 
                  <select name="expireday" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
                    <option value="3">3 Days</option>
                    <option value="7" selected="selected">7 Days</option>
                    <option value="15">15 Days</option>
                    <option value="30">30 Days</option>
                  </select>                 </td>
            </tr>
            <tr>
              <td height="80" align="center" valign="middle">&nbsp;                </td>
              <td height="80" colspan="3" align="left" valign="top" style=" padding-top:15">
			  <input type="submit" name="rentalSubmit" value=" Submit " style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:0px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif">				</td>
              </tr>
          </table></td>
        </tr>
      </table>
	  </form>
	  </td>
    </tr>
  </table>
<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
