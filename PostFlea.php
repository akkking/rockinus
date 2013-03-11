<?php 
include 'mainHeader.php';
include("Allfuc.php");
include 'dbconnect.php';
$uname = $_SESSION['usrname'];
$ua=getBrowser();

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
?>
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
<link rel="stylesheet" href="style.css" />
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
      <td width="300" align="left" valign="top" style="padding:15px">
	  <?php include("leftHomeMarketMenu.php"); ?>      </td>
      <td width="860" align="left" valign="top" style="padding:15px 15px 15px 0">
        <?php
	  if(isset($_SESSION['rst_msg'])){
	  	echo $_SESSION['rst_msg'];
	  	unset($_SESSION['rst_msg']); }
	  ?>
	  <div id="load" style="display:none;"><img src="img/loading42.gif" /></div>
	 <form action="Sell_process.php" enctype="multipart/form-data" method="post" style="margin-top:0; margin-bottom:0;" onsubmit="return ray.ajax()">
	  <table width="615" height="431" border="0" cellpadding="0" cellspacing="0" style="border:0 #CCCCCC dotted; margin-bottom:10; margin-top:0">
        <tr>
          <td width="615" height="425" valign="top"><table width="740" height="35" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10; border:1px #EEEEEE solid;">
            <tr>
              <td align='left' valign='top' style="color:#666666; background:#F5F5F5; padding:10; padding-bottom:8; padding-top:8; line-height:150%; font-size:11px; font-family:Arial, Helvetica, sans-serif"><strong>[Reminder]</strong> Suggest to compose in English, so everyone could understand. It's fine to post in a different language, please remember to leave a brief translation for other users convenience. We really need to be considerate, helpful and great.</td>
            </tr>
          </table>
          <table width="740" height="678" border="0" cellpadding="0" cellspacing="0" style=" background:#F5F5F5; border:0px solid #DDDDDD">
            <tr>
              <td height="50" align="right" style="border-bottom:#CCCCCC solid 0; padding-right:10">
			  <img src="img/colorBuyIcon.jpg" width="20" /></td>
              <td height="50" colspan="3" align="left" style=" font-size: 18px; font-family: Arial, Helvetica, sans-serif; ">
			  <font color="<?php echo($_SESSION['hcolor']) ?>"><strong> Publish Something For Sale or Buy </strong></font></td>
              </tr>
            <tr>
              <td height="5" colspan="4" style="border-top:0px solid #999999">&nbsp;</td>
              </tr>
            <tr>
              <td height="30" align="right" style="padding-right:10; font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif">Your title </td>
              <td height="30" colspan="3" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
			  <input type="text" name="subject" size="80" class="box" style="font-size:14px; font-family: Arial, Helvetica, sans-serif"></td>
              </tr>
            <tr>
              <td width="131" height="30" align="right" style="padding-right:10px; font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif">Category</td>
              <td width="234" height="30"><select name="type" id="type" onchange="articleChange(this);" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
                <option value="empty">Select Type</option>
                <option value="Electronics">Electronics</option>
                <option value="Books">Books</option>
                <option value="Furniture">Furniture</option>
                <option value="Costume">Costume</option>
                <option value="Transports">Transports</option>
                <option value="Cosmetics">Cosmetics</option>
                <option value="Instruments">Instruments</option>
                <option value="CardTickets">CardTickets</option>
                </select>
                <select name="aname" id="aname" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
                  <option value="empty">Select Name</option>
                </select></td>
              <td width="85" height="30" align="right" style="padding-right:10; font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif">I wanna</td>
              <td width="288" height="30" style="font-size:14px; font-family: Arial, Helvetica, sans-serif"><input type="radio" name="buysale" value="Sale" checked="checked" />
                Sell
                <input type="radio" name="buysale" value="Buy" />
                Buy </td>
            </tr>
            <tr>
              <td height="30" align="right" style="padding-right:10px; font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif">
			  	Number</td>
              <td height="30"><input type="text" name="num" size="3" value='1' style="font-size:14px; font-family: Arial, Helvetica, sans-serif"> Piece(s)</td>
              <td height="30" align="right" style="padding-right:10; font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif">
			  Condition</td>
              <td height="30" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
			  <select name="quality" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
                <option value="Brand New">Brand New</option>
              	<option value="Like New" selected="selected">Like New</option>
              	<option value="Good">Good</option>
              	<option value="Acceptable">Acceptable</option>
			  	<option value="Broken">Broken</option>
              </select></td>
            </tr>

            <tr>
              <td height="30" align="right" style="padding-right:10; font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif">$ Rate</td>
              <td height="30" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
			  <input type="text" name="rate" size="5" class="box" style="font-size:14px; font-family: Arial, Helvetica, sans-serif"> 
                /Piece </td>
              <td height="30" align="right" style="padding-right:10; font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif">Contact</td>
              <td height="30"><input type="text" name="contact" size="15" class="box" value="<?php echo($fname); ?>" style="font-size:14px; font-family: Arial, Helvetica, sans-serif"></td>
            </tr>
            <tr>
              <td height="30" align="right" style="padding-right:10; font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif">Delivery?</td>
              <td width="234" height="30" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
			  <input type="radio" name="delivery" value="Y" >
                Yes
                <input type="radio" name="delivery" value="N" checked="yes">
                No </td>
              <td height="30" align="right" style="padding-right:10; font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif">Email</td>
              <td height="30"><input type="text" name="email" size="25" class="box" value="<?php echo($email); ?>" style="font-size:14px; font-family: Arial, Helvetica, sans-serif"></td>
            </tr>
            <tr>
              <td height="30" align="right" style="padding-right:10px; font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif">Location</td>
              <td height="30"><select name="state" onchange="getCity('findCity.php?state_name='+this.value)" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
                  <option value="any">Any State</option>
                  <?php 
						$city = mysql_query("SELECT state_name FROM rockinus.city_info GROUP BY state_name ASC;");
						if(!$city) die(mysql_error());
						while($obj_city = mysql_fetch_object($city)){
							$state_name = $obj_city->state_name;
						?>
                  <option value="<?php echo($state_name) ?>"><?php echo($state_name) ?></option>
                  <? 
						}
						?>
                </select>
                  <div id="cityDiv" class="cityDiv" style="display:inline">
                    <select name="city" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
                      <option value="any">Any City</option>
                    </select>
                  </div>              </td>
              <td height="30" align="right" style="padding-right:10; font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif">Phone</td>
              <td height="30"><input type="text" name="telephone" size="15" class="box" value="<?php echo($phone); ?>" style="font-size:14px; font-family: Arial, Helvetica, sans-serif"></td>
            </tr>
            <tr>
              <td height="15" align="right" style="padding-right:10px; font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif">&nbsp;</td>
              <td height="15">&nbsp;</td>
              <td height="15" align="right" style="padding-right:10; font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif">&nbsp;</td>
              <td height="15">&nbsp;</td>
            </tr>
            <tr>
              <td height="30" align="right" style="padding-right:10; font-size:14px; font-weight:normal; font-family: Arial, Helvetica, sans-serif">Photos</td>
              <td height="30" colspan="3" style="font-size:14px; font-family: Arial, Helvetica, sans-serif">
			  <input name="uploaded1" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #" />&nbsp;
                  <font color="#CCCCCC">Make sure smaller than 1MB</font></td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td height="30" colspan="3" style="font-size:14px; font-family: Arial, Helvetica, sans-serif"><input name="uploaded2" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #" />
              <font color="#CCCCCC">&nbsp;Make sure smaller than 1MB</font></td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td height="30" colspan="3" style="font-size:14px; font-family: Arial, Helvetica, sans-serif"><input name="uploaded3" type="file" style="border-style: solid; border-width: 1px;border-color: #CCCCCC;font-family: helvetica, arial, sans serif;padding-left: 0px; background-color: #" />
              <font color="#CCCCCC">&nbsp;Make sure smaller than 1MB</font></td>
            </tr>
            
            <tr>
              <td height="227" align="right" valign="top" style="padding-right:10; padding-top:15; font-size:14px; font-family: Arial, Helvetica, sans-serif">
			  Description</td>
              <td height="227" colspan="3" style="padding-bottom:10; padding-top:15; font-size:14px; font-family: Arial, Helvetica, sans-serif" valign="top">
			  <textarea name="description" id="styled" style="width:530; height:200; font-size:14px; font-family: Arial, Helvetica, sans-serif;line-height:130%; padding:4px;"></textarea></td>
            </tr>
            <tr>
              <td height="23" bgcolor="#F5F5F5" style="border-top:0 #CCCCCC solid">&nbsp;</td>
              <td height="23" colspan="3" bgcolor="#F5F5F5" style=" font-size:14px; font-family: Arial, Helvetica, sans-serif;" align="left">
			   We will keep the post for
                      <select name="expireday">
                        <option value="3">3 Days</option>
                        <option value="7" selected="selected">7 Days</option>
                        <option value="15">15 Days</option>
                        <option value="30">30 Days</option>
                  </select>              </td>
            </tr>
            
            <tr>
              <td height="80" align="center" style="padding-top:25px; padding-bottom:25px">&nbsp;			  </td>
              <td height="80" align="left" style="padding-top:15;" valign="top">
			  <input type="submit" name="Submit" value=" Submit " style="height:22; padding:2 7 2 7; background: url(img/black_cell_bg.jpg); cursor:pointer; border:0px solid #333333; font-size:12px; color:#FFFFFF; line-height:120%; display:inline; font-family:Arial, Helvetica, sans-serif">
			  </td>
              <td height="80" align="center" style="padding-top:25px; padding-bottom:25px">&nbsp;</td>
              <td height="80" align="center" style="padding-top:25px; padding-bottom:25px">&nbsp;</td>
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
