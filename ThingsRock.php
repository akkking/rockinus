<?php 
include "mainHeader.php";

$q_custom = mysql_query("SELECT * FROM rockinus.user_custom_setting WHERE uname='$uname';");
if(!$q_custom) die(mysql_error());
$object_custom = mysql_fetch_object($q_custom);
$custom_features = $object_custom->features;
$custom_ccomment = $object_custom->ccomment;
$custom_eventnews = $object_custom->eventnews;
$custom_house = $object_custom->house;
$custom_article = $object_custom->article;
$custom_examQuestion = $object_custom->examQuestion;
$custom_jobReferral = $object_custom->jobReferral;
$custom_interviewQuestion = $object_custom->interviewQuestion;
?>

<script type="text/javascript" >
$(function() {
	$(".submitChannelBtn").click(function() {
		var channelVal = document.getElementById('hiddenChannelVal').value;
		var turnTag = document.getElementById('hiddenTurnTag').value;
		var dataString = 'channelVal='+ channelVal +'&turnTag='+ turnTag; 
		
		if(dataString=='')
		{
			alert("Not working now...");
		}
		else
		{
			//$("#flashChannelSubmit").show();
			//$("#flashChannelSubmit").fadeIn(400).html('');
 
 			$.ajax({
  				type: "POST",
  				url: "ajax_submit_channel.php",
  				data: dataString,
  				cache: false,
  				success: function(html){
  					$("#displayChannelRst").after(html);
  					$("#submitChannelBtn").hide();
					$("#cancelChannel").hide();
					setTimeout(function () {
						window.location.href = "ThingsRock.php"; //will redirect to your blog page (an ex: blog.html)
					}, 2000); //will call the function after 2 secs.
  				}
 			});
 		} return false;
 	});
});
</script>


<!--
Center Channel Div
-->
<div id="headerChannelDiv" style="width:500px; height:35px; color:#FFFFFF; background:<?php echo($_SESSION['hcolor']) ?>; position: fixed; z-index:100; top:50%;left:50%; padding-bottom:0; border:18px solid #DDDDDD; border-bottom:0; font-family:Arial, Helvetica, sans-serif; margin-top: -157px; margin-left:-250px; border-top-left-radius: 8px 8px; border-top-right-radius: 8px 8px; display:none" align="right">
     <div style="border:0px solid #999999; width:500px; height:35px; padding-top:8px; padding-right:5px" align="right">
	 <a id="displayText" href="javascript:toggle_off();" style="color:#FFFFFF; font-size:12px; "><img src="img/Close.png" width="20" /></a>&nbsp;&nbsp;
	 </div>
</div>
<div id="centerChannelContent" style="width:500px; height:200px; color:#333333; position: fixed; z-index:100; top:50%; left:50%; padding-bottom:0; background:#F5F5F5; border:18px solid #DDDDDD; border-top:0; font-family:Arial, Helvetica, sans-serif; margin-top: -105px; margin-left:-250px; border-bottom-left-radius: 8px 8px; border-bottom-right-radius: 8px 8px; display:none">
<div style="width:480px; height:200px; padding:25px 20px 10px 25px; font-size:24px; font-family:Arial, Helvetica, sans-serif;" align="left">
<div style="margin-bottom:10"><img src="img/examPaper.png" width="20" />&nbsp; Channel <input type="text" id="hiddenOnOffVal" name="hiddenOnOffVal" style="border:0; font-size:24px; color:#333333; font-family:Arial, Helvetica, sans-serif; width:30px; background:#F5F5F5" /> <input type="text" id="hiddenChannelTitle" name="hiddenChannelTitle" style="border:0; font-size:24px; color:#333333; font-family:Arial, Helvetica, sans-serif; width:230px; background:#F5F5F5" /></div>
<div style="margin-bottom:15; border:0px solid #DDDDDD; padding:0px; font-size:12px; color:#666666; font-family:Arial, Helvetica, sans-serif; width:450px; line-height:125%">
<span id="channelDescrip"></span>
</div>
<span id="submitChannelBtn" class="submitChannelBtn" style="width:100px; padding:3 7 3 7; border:1px solid #666666; font-family:Arial, Helvetica, sans-serif; background:url(img/master.jpg); font-size:13px; text-align:center; cursor:pointer" onmouseover="this.style.background='url(img/GrayGradbgDown120.jpg)'" onmouseout="this.style.background='url(img/master.jpg)'">
Submit</span><div id="displayChannelRst" class="displayChannelRst" style='width:150px; margin-top:20; font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:14px; text-align:left; color:#333333; display:none' ></div>

<input type="hidden" id="hiddenChannelVal" name="hiddenChannelVal" />
<input type="hidden" id="hiddenTurnTag" name="hiddenTurnTag" />

<span style="width:80px; padding:3 7 3 7; border:1px solid #666666; font-family:Arial, Helvetica, sans-serif; background:url(img/master.jpg); font-size:13px; text-align:center; cursor:pointer" onclick="toggle_off()" id="cancelChannel">Maybe later</span>
</div>
</div>

<!--
Center Div End
-->

<script language="javascript"> 
function showHideChannelDiv(){
	if(document.getElementById('channelDiv').style.display == 'none')
    {
    	document.getElementById('channelDiv').style.display = 'block';
    }
    else if(document.getElementById('channelDiv').style.display == 'block')
    {
		document.getElementById('channelDiv').style.display = 'none';    
	}
}

function toggle_on(channelVal, turnTag, onoff, channelTitle) {
	//alert(channelVal);
	document.getElementById('hiddenChannelVal').value=channelVal;
	document.getElementById('hiddenTurnTag').value=turnTag;
	document.getElementById('hiddenOnOffVal').value=onoff;
	document.getElementById('hiddenChannelTitle').value="\""+channelTitle+"\"?";
	if(channelVal=="eventnews")
		document.getElementById('channelDescrip').innerHTML = "\"Campus Notice\" channel enables you to receive daily annoncements by students or faculties, for example: part-time job, lost+found, social activity, seminar, e.g.. Usually what we used to do is checking campus notices in library or cafeteria entrance, now it saves you much of time.";
	else if(channelVal=="interviewQuestion")
		document.getElementById('channelDescrip').innerHTML = "\"Intervew Question\" channel enables you to receive daily interview questions posted by students. All questions are new, updated and are always useful once you look for hiring";
	else if(channelVal=="jobReferral")
		document.getElementById('channelDescrip').innerHTML = "\"Job Referral\" channel enables you to receive most recent job opportunities through other almuni or by Rockinus site. We are proud of having people who graduated from same schools and share valuable info together.";
	else if(channelVal=="examQuestion")
		document.getElementById('channelDescrip').innerHTML = "\"Exam Question\" channel enables you to receive memorized previous exam questions by other students. It's recommended by us to subscribe some courses you take in school, because in this way you would be easier to get updated and improved.";
	else if(channelVal=="ccomment")
		document.getElementById('channelDescrip').innerHTML = "\"Course Comment\" channel enables you to receive daily comments update by other students or faculties, including rating on a specific course as well.";	
	else if(channelVal=="House")
		document.getElementById('channelDescrip').innerHTML = "\"House\" channel enables you to receive daily apartment rental or roommates info.";
	else if(channelVal=="article")
		document.getElementById('channelDescrip').innerHTML = "\"Sales & Bargin\" channel enables you to receive daily sales info.";
	else if(channelVal=="features")
		document.getElementById('channelDescrip').innerHTML = "\"Site Features\" channel enables you to receive newest feature updates in Rockinus.com. This helps you follow up with us, enjoy better service.";
			
	var centerContent = document.getElementById("centerChannelContent");
	var headerDiv = document.getElementById("headerChannelDiv");
	
	//if(headerDiv.style.display == "block") {
    headerDiv.style.display = "block";
	centerContent.style.display = "block";
}

function toggle_off() {
	//alert("111");
	var centerContent = document.getElementById("centerChannelContent");
	var headerDiv = document.getElementById("headerChannelDiv");
	
	//if(headerDiv.style.display == "block") {
    headerDiv.style.display = "none";
	centerContent.style.display = "none";
} 
</script>

<script type="text/javascript">
$(function () {
    var $element1 = $('#updateFlash_1');
    var $element2 = $('#updateFlash_2');
    function fadeInOut () {
        $element1.fadeIn("fast",function () {
            $element1.delay(6000).fadeOut(400, function () {
                $element2.fadeIn(50, function () {
	                $element2.delay(6000).fadeOut(400, function () {
    	                setTimeout(fadeInOut, 10);
                	});
				});
            });
        });
    }

    fadeInOut();
});
</script>

<script>
$(document).ready(function(){
	var $elementt1 = $('#updateFlash_1');
	var $elementt2 = $('#updateFlash_2');
	$elementt1.hover(function() {
		$(this).show();
		$elementt2.hide();
	});
	$elementt2.hover(function() {
		$(this).show();
		$elementt1.hide();
	});
});
</script>
<style>
#updateFlash_1, #updateFlash_2 {
position:absolute;
display: none;
}
</style>
<table width="1032" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="590" valign="top" style="background:#FFFFFF; padding:10px 10px 10px 10px;">
	  <?php 
	include("ThingList.php") 
	?>	</td>
    <td width="442" valign="top" style="padding:15px 0px 15px 10px;">
	<!--
	Channel Div Start
	-->
	<div class="channelDiv" id="channelDiv" style="padding:5px 15px 10px 20px; margin-bottom:15px;  -moz-border-radius: 8px; border-radius: 8px; border:1px solid #999999; background:#FFFFFF; display:none; width:315px">
	<table width="315" border="0" cellspacing="0" cellpadding="0">
  <tr>
    	<td height="35" colspan="2" style="font-size:13px; font-weight:bold">
			Click to turn on/off your channels:		</td>
    </tr>
  <tr>
    <td width="190" height="35">
	<?php if($custom_eventnews=='Y'){?>
                    <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer; color:<?php echo($_SESSION['hcolor']) ?>" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('eventnews','N', 'off', 'Campus Notice')"><img src="img/nailIcon.png" width="15" />&nbsp;&nbsp;&nbsp; Campus Notice </div>
                  <?php }else{ ?>
                    <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer; color:#666666" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('eventnews','Y', 'on', 'Campus Notice')"><img src="img/on-off.png" width="13" />&nbsp;&nbsp;&nbsp; Campus Notice </div>
                  <?php } ?>	</td>
    <td width="180" height="35">
	<?php if($custom_features=='Y'){?>
                    <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer; color:<?php echo($_SESSION['hcolor']) ?>" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('features', 'N', 'off', 'Site New Feauture')"><img src="img/new.png" width="15" />&nbsp;&nbsp;&nbsp; Site New Feature</div>
                <?php }else{ ?>
                <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer; color:#666666" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('features', 'Y', 'on', 'Site New Feauture')"><img src="img/on-off.png" width="15" />&nbsp;&nbsp;&nbsp; Site New Feature</div>
                <?php } ?>	</td>
  </tr>
  <tr>
    <td height="35">
	<?php if($custom_interviewQuestion=='Y'){?>
                    <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer; color:<?php echo($_SESSION['hcolor']) ?>" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('interviewQuestion','N', 'off', 'Interview Question')"><img src="img/question.gif" width="15" />&nbsp;&nbsp;&nbsp; Interview Question </div>
                  <?php }else{ ?>
                    <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer; color:#666666" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('interviewQuestion','Y', 'on', 'Interview Question')"><img src="img/on-off.png" width="13" />&nbsp;&nbsp;&nbsp; Interview Question </div>
                  <?php } ?>	</td>
    <td height="35">
	 <?php if($custom_jobReferral=='Y'){?>
                    <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer; color:<?php echo($_SESSION['hcolor']) ?>" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('jobReferral', 'N', 'off', 'Job Referral')"><img src="img/reference.png" width="15" />&nbsp;&nbsp;&nbsp; Job Referral </div>
                  <?php }else{ ?>
                    <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer; color:#666666" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('jobReferral','Y', 'on', 'Job Referral')"><img src="img/on-off.png" width="13" />&nbsp;&nbsp;&nbsp; Job Referral </div>
                  <?php } ?>	</td>
  </tr>
  <tr>
    <td height="35">
	<?php if($custom_examQuestion=='Y'){?>
                    <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer; color:<?php echo($_SESSION['hcolor']) ?>" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('examQuestion', 'N', 'off', 'Exam Question')"><img src="img/tests.png" width="15" />&nbsp;&nbsp;&nbsp; Exam Question</div>
                  <?php }else{ ?>
                    <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer; color:#666666" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('examQuestion', 'Y', 'on', 'Exam Question')"><img src="img/on-off.png" width="13" />&nbsp;&nbsp;&nbsp; Exam Question</div>
                  <?php } ?>            </td>
    <td height="35">
	<?php if($custom_ccomment=='Y'){?>
                    <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer; color:<?php echo($_SESSION['hcolor']) ?>" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('ccomment', 'N', 'off', 'Course Comment')"><img src="img/comment_write.png" width="15" />&nbsp;&nbsp;&nbsp; Course Comment </div>
                  <?php }else{ ?>
                    <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer; color:#666666" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('ccomment', 'Y', 'on', 'Course Comment')"><img src="img/on-off.png" width="13" />&nbsp;&nbsp;&nbsp; Course Comment </div>
                  <?php } ?>	</td>
  </tr>
  <tr>
    <td height="35">
	<?php if($custom_house=='Y'){?>
                    <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer; color:<?php echo($_SESSION['hcolor']) ?>" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('house', 'N', 'off', 'House Rentals')"><img src="img/homeIcon.png" width="15" />&nbsp;&nbsp;&nbsp; House Rentals </div>
                  <?php }else{ ?>
                    <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer; color:#666666" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('house', 'Y', 'on', 'House Rentals')"><img src="img/on-off.png" width="13" />&nbsp;&nbsp;&nbsp; House Rentals </div>
                  <?php } ?>            </td>
    <td height="35">
	<?php if($custom_article=='Y'){?>
                    <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; color:<?php echo($_SESSION['hcolor']) ?>; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('article', 'N', 'off', 'Sales & Bargin')"><img src="img/cart_add.png" width="15" />&nbsp;&nbsp;&nbsp; Sales &amp; Bargin </div>
                  <?php }else{ ?>
                    <div style=" background:; width:165px; height:15px; margin-bottom:0; font-size:14px; padding:5 5 5 0; font-family: Geneva, Arial, Helvetica, sans-serif; border:0px dashed #999999; border-top:0px; border-right:0px; border-left:0px; margin-top:0; opacity:0.9; filter:alpha(opacity=85); cursor:pointer; color:#666666" onmouseover="this.style.backgroundColor='#EEEEEE';" onmouseout=" this.style.backgroundColor='';" onclick="toggle_on('article', 'Y', 'on', 'Sales/Bargin')"><img src="img/on-off.png" width="13" />&nbsp;&nbsp;&nbsp; Sales &amp; Bargin </div>
                  <?php } ?>            </td>
  </tr>
</table>
	</div>
	<!--
	Channel Div Ends
	-->
	
	  
	  <!--
	Status Post Div Starts
	-->
	<div id='publishStatusTable' class='publishStatusTable'>
			<table width="360" height="50" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px; background: #FFFFFF;">
  <tr>
    <td width="285" height="32" align="left" valign="top" style="padding-left:0px; padding-top:0px">
	  <textarea id="newStatusContent" class="newStatusContent" style="width:278px; height:40px; border:0; border:1px solid #EEEEEE; font-size:14px; background-color:#F5F5F5; font-family:Georgia, 'Times New Roman', Times, serif; padding:3; position:absolute; color:#888888; margin-top:3px" onclick="this.style.height = '80px'; if(this.value==' Share something with alumnus...')this.value=''" onFocus="this.style.height = '80px'; this.select(); inputFocus(this)" onBlur="this.style.height = '40px'; this.value=!this.value?' Share something with alumnus...':this.value; inputBlur(this)"> Share something with alumnus...</textarea>	</td>
    <td width="75" valign="top" style=" padding-top:15px; padding-left:5px" align="left">
	<script type="text/javascript" >
	$(function() {
	$(".publishStatusBtn").click(function() {
		var test = $("#newStatusContent").val();
		var pdate = '<?php echo(date('Y-m-d')) ?>';
		var ptime = '<?php echo(date("H:i:s", time())) ?>';
		var sender = '<?php echo($uname) ?>';
		var dataString = 'content='+ test+'&sender='+sender+'&pdate='+pdate+'&ptime='+ptime; 
		
		if(test==''||test==' Share something with alumnus...')
		{
			alert("<?php echo($fname) ?>, please enter something ok?");
		}
		else
		{
			$("#flashStatusMemo").show();
			$("#flashStatusMemo").fadeIn(400).html('');
 
 			$.ajax({
  				type: "POST",
  				url: "ajax_insert_home_status.php",
  				data: dataString,
  				cache: false,
  				success: function(html){
  					$("#displayStatusMemo").after(html);
  					document.getElementById('contentforown').value='';
  					document.getElementById('contentforown').focus();
  					$("#flashStatusMemo").hide();
					$("#publishStatusTable").hide();
  				}
 			});
 		} return false;
 	});
});
</script>
	<div class="publishStatusBtn" id="publishStatusBtn" style=" height:20px; padding:10 10 10 10; background: #CC6600; display: inline; width:60px; border:1px solid #000000; font-size:14px; cursor:pointer; font: Georgia, 'Times New Roman', Times, serif; color:#FFFFFF;   -moz-border-radius: 3px; border-radius: 3px;" align="center" onmouseover="this.style.background='#C35617'" onmouseout="this.style.background='#CC6600'">Publish</div>	</td>
  </tr>
</table>
<div style=" width:420px; display:none; height:25px; " align="center" id="postStatusHeader">
<div style=" width:420px; height:25px; background:#EEEEEE; border-top:1px solid #CCCCCC; border-bottom:1px solid #CCCCCC;"></div>
</div>
</div>

<div id="flashStatusMemo" class="flashStatusMemo" style="margin-top:15; margin-bottom:15; display:none"></div>
<div id="displayStatusMemo" class="displayStatusMemo" style="width:760; margin-bottom:15; display:none"></div>
<!--
	Status Post Ends
	-->
	
<!--
	Headicon Uploader Starts
	-->
<?php 
include "homeHeadIconUploader.php";
?>
<!--
	Headicon Uploader Ends
	-->	
	
	<?php 
	include("PeopleList.php") 
	?>	</td>
  </tr>
</table>
 <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>

</div>

</body>
</html>
