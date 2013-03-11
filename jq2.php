<?php include("Header.php"); ?>
<form action="/" id="setprior" style="margin-top:0px">
<table width="1024" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px">
  <tr>
    <td width="277" valign="top" style="padding-top:10px">	
<div id="tit" style="padding-right:20px; line-height:230%"><strong>I wanna my <span>first</span> Block to be</strong></div>	
<input type="hidden" name="uname" id="uname" value=<?php echo($_SESSION['usrname']) ?>>
</td>
    <td width="747" style="padding-top:20px">
	  <p value="M">
  	  <font size="3"><u>Messages / Requests</u> <font color="#999999">| Message Box, New Messages, Friend Requests, etc.</font></font>	  </p>
      <p value="A">
	  <font size="3"><u>Flea Market</u> <font color="#999999">| Any sales, or requirements like Furniture, Eletronics, Books,Tickets etc.</font></font>	  </p>
      <p value="H">
	   <font size="3"><u>House Rental</u> <font color="#999999">| Any house leases, rentals around my neighborhood, etc.</font></font>	   </p>
      <p value="C">
	   <font size="3"><u>My Courses</u> <font color="#999999">| Comments, e-books, notes, ratings which related to courses/professors you subscribed.</font></font>	   </p>
      <p value="F">
	  <font size="3"><u>Friends / Groups</u> <font color="#999999">| Updates about your friends, or potential friends, group or potential groups etc.</font></font>	  </p>	  </td>
  </tr>
  <tr>
    <td height="33" valign="top" style="padding-top:20px">&nbsp;</td>
    <td>
	<INPUT TYPE="BUTTON" VALUE="Clean and Use the default Priority Mode" ONCLICK="window.location.href='jq2.php'" class="btn"> 
	<input name="submit" type="submit" class="btn" value="Search">
                  
	</td>
  </tr>
</table>
<p id="ph">
<div id="first"></div>
<div id="second"></div>
<div id="third"></div>
<div id="fourth"></div>
<div id="fifth"></div>
<script>  
$("p").click(function () {
//	alert($("#tit span").text());
	var p_val = $(this).attr("value"); 
	var v = $("#tit span").text();	         
	if (v=="first") v = 1;
	var n = parseInt(v, 10);			 
	var a=0;
	var prior = n+p_val;
	a = parseInt(a) + parseInt(n);
	if (n==1){
		$("div#first").html("<img src='img/greenkiss.jpg'> <strong><font size=4 color=#336633>Successful</font><br>&nbsp;&nbsp;&nbsp;&nbsp;"+n+"st Priority - </strong>" + $(this).html()+" <p>");
		$(this).fadeOut("fast", function(){
			$("#tit span").text(n+"nd ");
		});
	}else if (n==2){
		$("div#second").html("<img src='img/greenkiss.jpg'> <strong><font size=4 color=#336633>Successful</font><br>&nbsp;&nbsp;&nbsp;&nbsp;"+n+"nd Priority - </strong>" + $(this).html()+"<p>");
		$(this).fadeOut("fast", function(){
			$("#tit span").text(n+"rd ");			
		});
	}else if(n==3){
		$("div#third").html("<img src='img/greenkiss.jpg'> <strong><font size=4 color=#336633>Successful</font><br>&nbsp;&nbsp;&nbsp;&nbsp;"+n+"rd Priority - </strong>" + $(this).html()+"<p>");
		$(this).fadeOut("fast", function(){
			$("#tit span").text(n+"th ");
		});
	}else if(n==4){
		$("div#fourth").html("<img src='img/greenkiss.jpg'> <strong><font size=4 color=#336633>Successful</font><br>&nbsp;&nbsp;&nbsp;&nbsp;"+n+"th Priority - </strong>" + $(this).html()+"<p>");
		$(this).fadeOut("fast", function(){
			$("#tit span").text(n+"th ");
		});
	}else if(n==5){
		$("div#fifth").html("<img src='img/greenkiss.jpg'> <strong><font size=4 color=#336633>Successful</font><br>&nbsp;&nbsp;&nbsp;&nbsp;"+n+"th Priority - </strong>" + $(this).html()+"<p>");
		$(this).fadeOut("fast", function(){
			$("#tit span").fadeOut("fast");
		});
		$("p#ph").fadeOut("fast");
	}; 
//	alert($("#uname").val());
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

<?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
