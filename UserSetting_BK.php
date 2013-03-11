<?php 
include("Header.php"); 
?>
<style type="text/css">
<!--
.STYLE8 {color: #000000}
.STYLE9 {color: #999999}
-->
</style>
<div align="center">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="127" align="left" valign="top" style="padding-left:5px">
	  <?php include("leftMenu".$_SESSION['lan'].".php"); ?>	  </td>
      <td width="878" align="left" valign="top">
	  <table width="878" height="295" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="878" height="295" align="left" valign="top" style="margin-bottom:5px">
			  <table width="878" height="202" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="35" colspan="2" valign="middle" style="padding-left:10px;" bgcolor="<?php echo($_SESSION['hcolor']) ?>">
				  <font size="4" color="white"><strong>Display Setting</strong></font></td>
			    </tr>
                <tr>
                  <td height="60" colspan="2" valign="middle" style="padding-left:10px; border-bottom:0px #CCCCCC solid">
				  <font size="3"><strong>Your Most Recent Display Order: </strong></font></td>
                </tr>
                <tr>
                  <td height="45" colspan="2" valign="top" style="padding-left:10px; padding-top:5px">
				  <img src="img/rightTriangleIcon.jpg" width="12" height="12" />&nbsp;<font color=<?php echo($_SESSION['hcolor']) ?> size=3>
				  <?php 
					include 'dbconnect.php';
				 	$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
					if(!$q1) die(mysql_error());
					$obj1 = mysql_fetch_object($q1);
					$priority = htmlspecialchars(trim($obj1->priority));
					echo("<div style='background-color=#; display:inline; padding-left:7px; padding-right:5px; padding-top:5px; padding-bottom:5px'><strong>");
					if($priority=="D")echo("Default Setting ");
					else{
						for( $i = 0; $i<=strlen($priority); $i += 2 ){
							$k = $i/2+1;
							if(substr($priority, $i+1,1)=="F")echo($k.". Friends/Groups &nbsp;&nbsp;");
							else if(substr($priority, $i+1,1)=="M")echo($k.". Events/Updates &nbsp;&nbsp;");
							else if(substr($priority, $i+1,1)=="A")echo($k.". Flea Markets &nbsp;&nbsp;");
							else if(substr($priority, $i+1,1)=="H")echo($k.". House Rentals &nbsp;&nbsp;");
							else if(substr($priority, $i+1,1)=="C")echo($k.". My Courses &nbsp;&nbsp;");
						}
					}
					echo("</strong></div>");
				?></font>				  </td>
                </tr>
                <tr>
                  <td height="66" colspan="2" valign="top" bgcolor="#F5F5F5" style="padding-left:15px; line-height:180%; padding-top:10px">Setting the priority of updates display order, which makes reviewing updates more convenient with regard to your wishes. <br /> 
                  Try, and you can now have a favorite order of what to be displayed in your home page after logged in. </td>
                </tr>
                <tr>
                  <td colspan="2" bgcolor="#F5F5F5" style="padding-left:15px; line-height:180%; padding-bottom:10px">
				  <div style=" background-color:#; padding-bottom:3px; padding-top:3px; display: inline;">
				  If you'd love to keep the default display, just click &quot;use the default&quot; button below, it will display by date and time then.				  </div>
				  <br />
				  <div id='startclick' style=" background-color:#; padding-bottom:3px; padding-top:3px; display: inline; padding-bottom:3px; color:<?php echo($_SESSION['hcolor']) ?>">
				  Start to make your display order by click on items below!  				  </div>				  </td>
                </tr>
		      </table>
			  <div id="tab1" class="tab_content">
				
				  <table width="878" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px">
                    <tr>
                      <td width="231" valign="top" style="padding-top:10px"><font size="3">
					  <div id="tit" style="padding-right:10px; line-height:230%; padding-left:15px; padding-right:25px" align="right"><strong>Set my <span style="text-decoration:underline">first</span> Block to be</strong></div>
                      </font>
                      <input type="hidden" name="uname" id="uname" value="<?php echo($_SESSION['usrname']) ?>" /></td>
                      <td width="659" style="padding-top:10px; padding-bottom:10px">
					  <p value="M"> <font size="2"><u>Forum, Events Updates</u> <font color="#999999">| Forum, and Events update which related to you, or you may interested.</font></font> </p>
                          <p value="A"> <font size="2"><u>Market Updates</u> <font color="#999999">| Any sales like Furniture, Eletronics, Books,Tickets etc.</font></font> </p>
                        <p value="H"> <font size="2"><u>House Updates</u> <font color="#999999">| Any house leases, rentals informations.</font></font> </p>
                        <p value="C"> <font size="2"><u>Courses Updates</u> <font color="#999999">| Comments, ratings regarding to courses under professors that you cared.</font></font> </p>
                      <p value="F"> <font size="2"><u>Friends Update</u> <font color="#999999">| Updates about friends' recent activity.</font></font> </p></td>
                    </tr>
                    <tr>
                      <td height="47" valign="top" style="padding-top:10px">&nbsp;</td>
                      <td style="padding-top:10px; padding-bottom:15px">
					  <div style="background-color:<?php echo($_SESSION['hcolor']) ?>; padding-left:10px; padding-right:10px; padding-top:5px; padding-bottom:5px; border-bottom:1px #000000 solid; border-right:1px #000000 solid; display: inline"><a href="setDefaultPrior.php">Use the default display order</a></div>&nbsp;&nbsp;&nbsp;&nbsp;<div id="setagain" style="background-color:<?php echo($_SESSION['hcolor']) ?>; padding-left:10px; padding-right:10px; padding-top:5px; padding-bottom:5px; border-bottom:1px #000000 solid; border-right:1px #000000 solid; display: inline"></div></td>
                    </tr>
                    <tr>
                      <td height="15" colspan="2" valign="top" style="padding-top:10px; padding-left:15px"><p id="ph"> </p>
                        <div id="zero"></div>
                        <div id="first"></div>
                        <div id="second"></div>
                        <div id="third"></div>
                        <div id="fourth"></div>
                      <div id="fifth"></div></td>
                    </tr>
                </table>
				  <table width="876" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="10" colspan="2" style="padding-left:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="35" colspan="2" bgcolor="<?php echo($_SESSION['hcolor']) ?>" style="padding-left:10px; border-top:0px #CCCCCC solid">
					  <font size="4" color="white"><strong>Privacy Setting</strong></font></td>
                    </tr>
                    <tr>
                      <td width="794" height="50" style="padding-left:10px; border-top:1px #CCCCCC solid">Who can view my personal page? &nbsp;
                        <input type="radio" name="radiobutton" value="radiobutton" checked="checked"/> Everyone <input type="radio" name="radiobutton" value="radiobutton" /> Only friends
					  <input type="radio" name="radiobutton" value="radiobutton" /> No one</td>
                      <td width="82" height="50" style="padding-left:10px; border-top:1px #CCCCCC solid">
					  <input type="submit" value="I'm done" class="btn2" />					  </td>
                    </tr>
                    <tr>
                      <td height="50" style="padding-left:10px; border-top:1px #EEEEEE solid">Receive new feature notification thru : &nbsp;
                      <input type="checkbox" name="radiobutton" value="radiobutton" checked="checked"/> Email <input type="checkbox" name="radiobutton" value="radiobutton" />                        Message</td>
                      <td height="50" style="padding-left:10px; border-top:1px #EEEEEE solid">
                      <input name="submit" type="submit" class="btn2" value="I'm done" />                      </td>
                    </tr>
                    <tr>
                      <td height="50" style="padding-left:10px; border-top:1px #EEEEEE solid">Keep telephone info to be visible to others?&nbsp; 
					  <input type="radio" name="radiobutton" value="radiobutton" checked="checked"/> 
					  Yes 
					  <input type="radio" name="radiobutton" value="radiobutton" /> 
					  No					  </td>
                      <td height="50" style="padding-left:10px; border-top:1px #EEEEEE solid"><input name="submit2" type="submit" class="btn2" value="I'm done" /></td>
                    </tr>
                    <tr>
                      <td height="50" style="padding-left:10px; border-top:1px #EEEEEE solid">Forward new message to my email address automatically?&nbsp;
                          <input type="radio" name="radiobutton" value="radiobutton" checked="checked"/>
                        Yes
                        <input type="radio" name="radiobutton" value="radiobutton" />
                      No </td>
                      <td height="50" style="padding-left:10px; border-top:1px #EEEEEE solid"><input name="submit2" type="submit" class="btn2" value="I'm done" /></td>
                    </tr>
                    <tr>
                      <td height="50" style="padding-left:10px; border-top:1px #EEEEEE solid">&nbsp;</td>
                      <td height="50" style="padding-left:10px; border-top:1px #EEEEEE solid">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                </table>
				  <script>  
$("p").click(function () {
//	alert($("#tit span").text());
	var p_val = $(this).attr("value"); 
	var v = $("#tit span").text();	         
	if (v=="first") v = 1;
	var n = parseInt(v, 10);			 
	var a=0;
	a = parseInt(a) + parseInt(n);
	if (n==1){
		$("div#first").html("<div id='s1'><img src='img/greenstartopi.jpg'> <strong><font size=4 color=#336633>Added</font></div><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=3>Your "+n+"st Block - </font></strong>" + $(this).html()+" <p>");
		$(this).fadeOut("fast", function(){
			$("#tit span").text(n+"nd ");
			$("div#setagain").html("<a href='main.php' onClick='window.location.reload();return false;'>I am done</a>");
		});
	}else if (n==2){
		$("div#second").html("<div id='s2'><img src='img/greenstartopi.jpg'> <strong><font size=4 color=#336633>Added</font></div><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=3>Your "+n+"nd Block - </font></strong>" + $(this).html()+" <p>");
		$(this).fadeOut("fast", function(){
			$("#tit span").text(n+"rd ");
			$("div#setagain").html("<a href='#' onClick='window.location.reload();return false;'>I am done</a>");			
		});
	}else if(n==3){
		$("div#third").html("<div id='s3'><img src='img/greenstartopi.jpg'> <strong><font size=4 color=#336633>Added</font></div><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=3>Your "+n+"rd Block - </font></strong>" + $(this).html()+"<p>");
		$(this).fadeOut("fast", function(){
			$("#tit span").text(n+"th ");
			$("div#setagain").html("<a href='#' onClick='window.location.reload();return false;'>I am done</a>");
		});
	}else if(n==4){
		$("div#fourth").html("<div id='s4'><img src='img/greenstartopi.jpg'> <strong><font size=4 color=#336633>Added</font></div><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=3>Your "+n+"th Block - </font></strong>" + $(this).html()+"<p>");
		$(this).fadeOut("fast", function(){
			$("#tit span").text(n+"th ");
			$("div#setagain").html("<a href='#' onClick='window.location.reload();return false;'>I am done</a>");
		});
	}else if(n==5){
		$("div#fifth").html("<div id='s5'><img src='img/greenstartopi.jpg'> <strong><font size=4 color=#336633>Added</font></div><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=3>Your "+n+"th Block - </font></strong>" + $(this).html()+"<p>");
		$(this).fadeOut("fast", function(){
			$("div#tit").fadeOut("fast");
			$("div#s1").fadeOut("fast");
			$("div#s2").fadeOut("fast");
			$("div#s3").fadeOut("fast");
			$("div#s4").fadeOut("fast");
			$("div#s5").fadeOut("fast");
			$("div#startclick").fadeOut("fast");
			$("div#setagain").html("<a href='#' onClick='window.location.reload();return false;'>Set the display order again</a>");
			$("div#zero").html("<br><img src='img/greenstartopi.jpg'> <strong><font size=4 color=#336633> Good Job, following display order has been set</font></strong><p style=padding-bottom:10px>");
		});
//		$("p#ph").fadeOut("fast");
	}; 
	
	var prior = n + p_val;
	$.post(
		'ajax_prior.php',
		{
			uname:$("#uname").val(),
			prior:prior
		}
	)
	
	n = n + 1;	
});  
</script>
</form>
			  </div>
		    </td>
          </tr>
      </table>      </td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
